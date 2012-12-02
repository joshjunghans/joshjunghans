<?php

/**
 *
 *  File: User Class
 *  Description:  Handles the functionality of the iStruct users
 * 
 */


Class iStructUser {

	public $con;
	public $ID;
	public $first_name;
	public $last_name;
	public $full_name;
	public $email;
	public $role;
	public $active;
	public $active_date;
	public $last_login;
	public $errors = array();

	public function __construct( ) {
		$this->dbcon();

		if(array_key_exists( 'istruct_user', $_SESSION ) ) {
			$u = $this->user( $_SESSION['istruct_user'] );

			$this->email = $_SESSION['istruct_user'];
			$this->ID = $u['User_ID'];
			$this->first_name = $u['User_First'];
			$this->last_name = $u['User_Last'];
			$this->full_name = $this->first_name . ' ' . $this->last_name;
			$this->role = $u['User_Role'];
			$this->active = $u['User_Active'];
			$this->active_date = $u['User_Active_Date'];
			$this->last_login = $u['Last_Logged_In'];
		}

	}

    public function dbcon(){
	/**
	 *  Description: Runs the initial database connection.
	 *
	 *  @param 	none
	 *  @return	Success: Added the connection handle to $this->con
	 *  @return Failed: The error is stacked onto $this->errors
	 *
	 */    	

        $dns = ISTRUCT_DBENGINE . ':dbname=' . ISTRUCT_DBNAME . ";host=" . ISTRUCT_DBHOST;

        // Try PDO connection
        try{
	        $this->con = new PDO( $dns, ISTRUCT_DBUSER, ISTRUCT_DBPASS );
	        return $this->con;
	    } catch ( PDOException $e ) {
	    	$this->stack_error( 'Connection Failed:' . $e->getMessage() );
	    }

    }

	public function stack_error( $err ) {
	/**
	 *  Description: Stacks and error to the class' error array
	 *
	 *  @param 	 string $err
	 *  @return none
	 *
	 */

		array_push( $this->errors, $err );

	}

	public function verifyUser( $email, $pass ) {
	/**
	 *  Description: Verifies a user for login purposes
	 *
	 *  @param 	string $email the user's email address
	 *  @param 	string $pass the user's password
	 *  @return	boolean true/false
	 *
	 */
	
		$d = md5( '+_+_+__+^^' . $pass . '^^+__+_+_+' );

		$sql = 'SELECT * FROM iStruct_Users WHERE User_Email = :email AND User_Pass = :pass LIMIT 1';
		$binded = array( ':email' => $email, ':pass' => $d );

		try {
			$dbh = $this->con;
			$sth = $dbh->prepare( $sql );
			$sth->execute( $binded );

			if( $sth->rowCount() == 0 ) {
				return false;
			} else {
				return true;
			}
		} catch( PDOException $e ) {
			$this->stack_error( $e->getMessage() );
			return false;
		}

	}

	public function user( $email ) {
	/**
	 *  Description: Gather's the user's stored information into an array
	 *
	 *  @param 	string $email The user's email address
	 *  @return	array|boolean (An associative array of info for the user|false if no user found
	 *
	 */
	
		$sql = 'SELECT * FROM iStruct_Users WHERE User_Email = :email LIMIT 1';
		$binded = array( ':email' => $email );

		try {
			$dbh = $this->con;
			$sth = $dbh->prepare( $sql );
			$sth->execute( $binded );

			if( $sth->rowCount() == 0 ) {
				return false;
			} else {
				$fetched = $sth->fetchAll( PDO::FETCH_ASSOC );
				$the_user = $fetched[0];
				unset( $the_user['User_Pass'] );
				return $the_user;
			}
		} catch( PDOException $e ) {
			$this->stack_error( $e->getMessage() );
			return false;
		}
	

	}

	public function updateUser( $email, $fields ) {
	/**
	 *  Description: Update's a user in the database
	 *
	 *  @param 	string $email The user's email address
	 *  @param 	string|array $fields (a serialized sting of values|an associative array of values)
	 *  @return	boolean true/false
	 *
	 */
	
		$flag = 0;
		$bind = array( ':User_Email' => $email );
		$set_str = array();
		$filters = array( 'User_Email','User_Pass','User_Active','User_Active_Date');

		if( $email == '' ) {
			$this->stack_error( 'User email is required.' );
			return false;
		}

		if( is_array( $fields ) ) {
			if( count( $fields ) == 0 ) {
				$this->stack_error( 'Fields must be passed in order to update.' );
				return false;
			} else {

				foreach( $fields as $field => $val ) {

					if( in_array( $field, $filters ) ) {
						$flag++;
					} else {
						$bind[':' . $field] = $val;
						$str = $field . ' = :' . $field;
						array_push( $set_str, $str );
					}

				}

			}

		} elseif( $fields == '' ) {
			$this->stack_error( 'Fields must be passed in order to update.' );
			return false;
		} else {
			// parse the string into an array
			parse_str( $fields, $q );

			foreach( $q as $field => $val ) {

				if( in_array( $field, $filters ) ) {
					$flag++;
				} else {
					$bind[':' . $field] = $val;
					$str = $field . ' = :' . $field;
					array_push( $set_str, $str );
				}

			}

		}

		if( $flag > 0 ) {
			$this->stack_error( 'You are trying to update a prohibited field.' );
			return false;
		} else {

			$sql = 'UPDATE iStruct_Users SET ' . implode( ',' , $set_str ) . ' WHERE User_Email = :User_Email';

			try {
				$dbh = $this->con;
				$sth = $dbh->prepare( $sql );
				$sth->execute( $bind );
				return true;
			} catch( PDOException $e ) {
				$this->stack_error( $e->getMessage() );
				return false;
			}

		}

	}

	public function logout() {
		session_destroy();
	}


}

$user = new iStructUser();


?>