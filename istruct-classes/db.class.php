<?php

class Query {

	private $dbh; 				// The initial DB handle
	public $query;
	public  $status; 			// The status of the current query instance
	public  $errorInfo;			// The error info if any
	public  $affectedRows = 0;	// The number of rows the called method affected

	public function __construct() { self::dbcon(); }
	public function __destruct() { $this->dbh = false; }

	/**
	 * Description: Connect to the database
	 *
	 * @param  none
	 * @return none
	 */
	private function dbcon() {

		try {
			$con = new PDO( ISTRUCT_DNS, ISTRUCT_DBUSER, ISTRUCT_DBPASS );
	    	$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	    	$this->dbh = $con;
	    	$this->status = 'success';
	    	return true;
	    } catch( PDOException $e ) {
	    	$this->status = 'fail';
			$this->errorInfo = $e;
	    	return false;
	    }

	}

	/**
	 * Description: Adds a new record to a db table
	 *
	 * @param   str   $tbl      The name of the db table
	 * @param   arr   $params   An associative array of columns/values
	 * @return  bool
	 */
	public function add( $tbl, $params ) {

		// Build the bind parts
		$bind = array();

		foreach( $params as $col => $value ) {
			$bkey = ':'.$col;
			$bind[$bkey] = $val;
			$params[$col] = $bkey;
		}

		// Build the query
		$query  = "INSERT INTO $tbl (" . implode( ',', array_keys( $params ) ) . ")";
		$query .= " VALUES(" . implode( ',', array_values( $params ) ) . ")";

		try {
			$sth = $this->dbh->prepare( $query );
			$sth->execute( $bind );
	    	$this->status = 'success';
	    	$this->affectedRows = $sth->rowCount();
	    	return true;
	    } catch( PDOException $e ) {
	    	$this->status = 'fail';
			$this->errorInfo = $e;
			return false;
		}

	}

	/**
	 * Description: Returns a record(s) from a db table
	 *
	 * @param   str   $tbl         The name of the db table
	 * @param   arr   $fields      A numeric array of columns to return
	 * @param   str   $condition   The "WHERE" clause
	 * @param   str   $orderby     The column name to sort by
	 * @param   str   $order       The order to return the rows (ASC or DESC)
	 * @param   str   $groupby     The column name to group the rows by
	 * @param   str   $having      The "HAVING" clause
	 * @param   str   $limit       The Limit to set for the query
	 * @return  bool
	 */
	public function get( $tbl, array $fields, $condition = null, $orderby = null, $order = 'ASC', $groupby = null, $having = null, $limit = null ) {

		// Build the query
		$get_fields = ( count( $fields ) === 0 ) ? '*' : implode( ',', $fields );
		$query  = "SELECT $get_fields FROM $tbl";
		$bind = array();

		if( !empty( $condition ) ) { $query .= ' WHERE '. $this->serialize_where( $bind, $condition ); }
		if( !empty( $orderby ) ) { $query .= " ORDER BY $orderby $order"; }
		if( !empty( $groupby ) ) { $query .= " GROUP BY $groupby"; }
		if( !empty( $having ) ) { $query .= " HAVING $having"; }
		if( !empty( $limit ) ) { $query .= " LIMIT $limit"; }

		try {
			$sth = $this->dbh->prepare( $query );

			if( count( $bind ) >= 1 ) {
				$sth->execute( $bind );
			} else {
				$sth->execute();
			}

	    	$this->status = 'success';
	    	$this->affectedRows = $sth->rowCount();
	    	$result = ( $this->affectedRows > 1 ) ? $sth->fetchAll( PDO::FETCH_OBJ ) : $sth->fetch( PDO::FETCH_OBJ );
			return $result;
	    } catch( PDOException $e ) {
	    	$this->status = 'fail';
			$this->errorInfo = $e;
			return false;
		}

	}

	/**
	 * Description: Edits a record in a db table
	 *
	 * @param   str   $tbl         The name of the db table
	 * @param   arr   $params      An associative array of columns/values
	 * @param   str   $condition   The "WHERE" Clause
	 * @return  bool
	 */
	public function update( $tbl, array $params, $condition = false ) {

		if( !$condition )
			return;

		// Build the bind parts
		$bind = array();
		$set = array();

		foreach( $params as $col => $value ) {
			$bkey = ':'.$col;
			$set_str = $col . '=' . $bkey;
			$bind[$bkey] = $value;
			$set[] = $set_str;
		}

		// Build the query
		$query = "UPDATE $tbl SET " . implode( ',', $set ) . ' WHERE ' . $this->serialize_where( $bind, $condition );

		try {
			$sth = $this->dbh->prepare( $query );
			$sth->execute( $bind );
	    	$this->status = 'success';
	    	$this->affectedRows = $sth->rowCount();
	    	return true;
	    } catch( PDOException $e ) {
	    	$this->status = 'fail';
			$this->errorInfo = $e;
			$this->query = $query;
			return false;
		}

	}

	/**
	 * Description: Edits a record in a db table
	 *
	 * @param   str   $tbl         The name of the db table
	 * @param   str   $condition   The "WHERE" Clause
	 * @return  bool
	 */
	public function delete( $tbl, $condition ) {

		// Build the query
		$bind = array();
		$query = "DELETE FROM $tbl WHERE " . $this->serialize_where( $bind, $condition );

		try {
			$sth = $this->dbh->prepare( $query );
			$sth->execute( $bind );
	    	$this->status = 'success';
	    	$this->affectedRows = $sth->rowCount();
	    	return true;
	    } catch( PDOException $e ) {
	    	$this->status = 'fail';
			$this->errorInfo = $e;
			return false;
		}

	}
	
	/**
	 * Description: Creates a table in the connected database
	 *
	 * @param   str   $tbl     The name to give the table
	 * @param   arr   $fields      The columns and attributes to give the table
	 * @param   arr   $primary     The column to designate as the primary key
	 * @param   arr   $unique      The column(s) to designate for unique indexing
	 * @return  bool
	 */
	public function create_table( $tbl, $fields, $primary ) {

		$crit = array(); // Will hold the inner criteria to build the table
		foreach( $fields as $col => $atts ) { $crit[] = $col . ' ' . $atts; }
		$crit[] = "PRIMARY KEY ($primary)";

		// Build the query
		$query = "CREATE TABLE $tbl (" . implode( ',', $crit ) . ")";

		try {
			$sth = $this->dbh->prepare( $query );
			$sth->execute();
	    	$this->status = 'success';
	    	$this->affectedRows = $sth->rowCount();
	    	return true;
	    } catch( PDOException $e ) {
	    	$this->status = 'fail';
	    	$this->query = $query;
			$this->errorInfo = $e;
			return false;
		}

	}

	/**
	 * Description: Creates a table in the connected database
	 *
	 * @param   str   $tbl     The name of the table
	 * @return  bool
	 */
	public function drop_table( $tbl ) {

		try {
			$sth = $this->dbh->prepare( "DROP TABLE $tbl" );
			$sth->execute();
	    	$this->status = 'success';
	    	$this->affectedRows = $sth->rowCount();
	    	return true;
	    } catch( PDOException $e ) {
	    	$this->status = 'fail';
	    	$this->query = $query;
			$this->errorInfo = $e;
			return false;
		}

	}

	/**
	 * Description: Serializes the WHERE clause and adds the bind values to the referenced bind array
	 *
	 * @param   arr   $bind     The array of "binded" values
	 * @param   str   $clause   The "WHERE" Clause
	 * @return  str 			The serialized WHERE clause
	 */
	private function serialize_where( &$bind, $clause ) {

		try {
			// Break apart at conditionals
			$bac = preg_split( '/(AND|OR)/', $clause );

			for( $i = 0; $i < count( $bac ); $i++ ) {
				$bao = preg_split( '/(>=|<=|<>|>|<|=|BETWEEN|LIKE|IN)/', $bac[$i] );
				$bkey = ':WHERE_'.trim( $bao[0] );
				$bind[$bkey] = trim( $bao[1] );
				$clause = str_replace( trim( $bao[1] ), ' '.$bkey.' ', $clause );
			}

			return $clause;
		} catch( Exception $e ) {
	    	$this->status = 'fail';
			$this->errorInfo = $e;
			return false;
		}

	}

}

?>