<?php

// Bring in the globals and db API
include( '../../config/settings.php' );

$posted = $_POST;
$errs = array();
$dberrs = 0;

// Validate the input
foreach( $posted['db'] as $field => $val ) {

	switch( $field ) {

		case 'Site_Name':
			if( $val == '' ) {
				$errarr = array(
					'field' => $field,
					'error' => 'You must name your website.'
				);
				array_push( $errs, $errarr );
			}
		break;
		case 'Site_Domain':
			if( $val != 'localhost' ) {
				$patt = '/^(http|https):\/\/(www\.)(([a-z0-9]([-a-z0-9]*[a-z0-9]+)?){1,63}\.)+[a-z]{2,6}/';

				if( $val == '' ) {
					$errarr = array(
						'field' => $field,
						'error' => 'You must enter your website\'s domain name.'
					);
					array_push( $errs, $errarr );
				} elseif( !preg_match( $patt, $val ) ) {
					$errarr = array(
						'field' => $field,
						'error' => 'The domain name you entered is not valid.'
					);
					array_push( $errs, $errarr );
				}
			}
		break;
		case 'Site-Charset':
			if( $val == '' ) {
				$errarr = array(
					'field' => $field,
					'error' => 'Please choose a character set.'
				);
				array_push( $errs, $errarr );
			}
		break;
		case 'Site_Language':
			if( $val == '' ) {
				$errarr = array(
					'field' => $field,
					'error' => 'Please choose a language.'
				);
				array_push( $errs, $errarr );
			}
		break;

	}

}

// Validate the user account information
$user = $posted['user'];
if( $user['User_Email'] == '' ) {
	$errarr = array(
		'field' => 'User_Email',
		'error' => 'You must enter your email address.'
	);
	array_push( $errs, $errarr );
} elseif( !filter_var( $user['User_Email'], FILTER_VALIDATE_EMAIL ) ) {
	$errarr = array(
		'field' => 'User_Email',
		'error' => 'You must enter a valid email address.'
	);
	array_push( $errs, $errarr );
}

if( $user['User_Pass'] == '' ) {
	$errarr = array(
		'field' => 'User_Pass',
		'error' => 'You must enter a password.'
	);
	array_push( $errs, $errarr );
} else {
	if( $user['User_Repass'] == '' ) {
		$errarr = array(
			'field' => 'User_Repass',
			'error' => 'You must re-enter your password.'
		);
		array_push( $errs, $errarr );
	} elseif( $user['User_Pass'] != $user['User_Repass'] ) {
		$errarr = array(
			'field' => 'User_Pass',
			'error' => 'Your passwords don\'t match.'
		);
		array_push( $errs, $errarr );
	}
}

// Build the arrays for database table definitions
$tbl_site = array(
	'fields' => array(
		'Site_ID' => array( 'INT', 'AUTO_INCREMENT' ),
		'Site_Name' => array( 'VARCHAR(75)' ),
		'Site_Domain' => array( 'VARCHAR(50)' ),
		'Site_Charset' => array( 'VARCHAR(50)', "DEFAULT 'UTF-8'" ),
		'Site_Language' => array( 'VARCHAR(50)', "DEFAULT 'en'" )
	),
	'primary' => 'Site_ID'
);

$tbl_users = array(
	'fields' => array(
		'User_ID' => array( 'INT', 'NOT NULL', 'AUTO_INCREMENT' ),
		'User_Email' => array( 'VARCHAR(100)' ),
		'User_First' => array( 'VARCHAR(30)' ),
		'User_Last' => array( 'VARCHAR(50)' ),
		'User_Pass' => array( 'VARCHAR(255)' ),
		'User_Role' => array( 'VARCHAR(30)', "DEFAULT 'author'"),
		'User_Active' => array( 'INT', "DEFAULT 0" ),
		'User_Active_Date' => array( 'TIMESTAMP', 'DEFAULT CURRENT_TIMESTAMP' ),
		'Last_Logged_In' => array( 'TIMESTAMP', "DEFAULT '0000-00-00 00:00:00'" )
	),
	'primary' => 'User_ID'
);

$tbl_pages = array(
	'fields' => array(
		'Page_ID' => array( 'INT', 'AUTO_INCREMENT' ),
		'Page_Slug' => array( 'VARCHAR(255)' ),
		'Page_Type' =>array( 'VARCHAR(75)', "DEFAULT 'page'" ),
		'Page_Category' => array( 'INT' ),
		'Page_Title' => array( 'VARCHAR(255)' ),
		'Page_Author' => array( 'VARCHAR(255)' ),
		'Page_Date' => array( 'TIMESTAMP', 'DEFAULT CURRENT_TIMESTAMP' ),
		'Page_Content' => array( 'TEXT' ),
		'Page_Template' => array( 'VARCHAR(255)' ),
		'Page_Tags' => array( 'TEXT' )
	),
	'primary' => 'Page_ID',
	'unique'  => 'Page_Slug'
);

$tbl_page_options = array(
	'fields' =>array(
		'Page_Option_ID' => array( 'INT', 'AUTO_INCREMENT' ),
		'Page_ID' => array( 'INT' ),
		'Comments' => array( 'TINYINT', 'DEFAULT 0' )
	)
	'primary' => 'Page_Option_ID',
	'unique' => 'Page_ID'
);

$tbl_comments = array(
	'fields' => array(
		'Comment_ID' => array( 'INT', 'NOT NULL', 'AUTO_INCREMENT' ),
		'Comment_Page' => array( 'INT', 'NOT NULL' ),
		'Comment_Parent' => array( 'INT' ),
		'Comment_User' => array( 'INT' ),
		'Comment_Date' => array( 'TIMESTAMP', "DEFAULT CURRENT_TIMESTAMP" ),
		'Comment_Content' => array( 'TEXT', 'NOT NULL' )
	),
	'primary' => 'Comment_ID'
);

$master_tbl_arr = array(
	'iStruct_Site' => $tbl_site,
	'iStruct_Users' => $tbl_users,
	'iStruct_Pages' => $tbl_pages,
	'iStruct_Page_Options' => $tbl_page_options,
	'iStruct_Comments' => $tbl_comments
);

// Loop through the master table array and create the tables
foreach( $master_tbl_arr as $tbl => $fields ) {

	try {
		createTable( $tbl, $fields );
	} catch( Exception $e ) {
		$dberrs++;
	}
	
}

if( count( $errs ) >= 1 ) {
	$ret = array(
		'status' => false,
		'errors' => $errs
	);
} elseif( $dberrs >= 1 ) {
	$ret = array(
		'status' => false
	);
} else {

	$user_info = array(
		'User_Email' => $user['User_Email'],
		'User_Pass' =>  md5( '+_+_+__+^^' . $user['User_Pass'] . '^^+__+_+_+' ),
		'User_Role' => $user['User_Role'],
		'User_Active' => 1,
		'Last_Logged_In' => date( 'Y-m-d H:i:s', time() )
	);

	try {
		insert( 'iStruct_Site', $posted['db'] );
		insert( 'iStruct_Users', $user_info );

		$ret = array( 'status' => true );

	} catch( Exception $e ) {
		$ret = array(
			'status' => false,
			'details' => $e->getMessage()
		);
	}

}

echo json_encode( $ret );

function createTable( $table, $atts ) {
/**
 *  Description: Creates a table in the database
 *
 *  @param     $table             str      The name to give the table
 *  @param     $atts['fields']     array    An array of fields and associated attributes
 *  @param     $atts['primary']   array    The Field to use as the Primary Key
 *  @return    boolen true/false (if false adds the error to the stack)
 *
 */

	// $table must be passed and not have a null value
	if( !$table || $table == '' ) {
		throw new Exception( 'Could not create table: A table name must be given' );
		return false;
	}

	// Set defaults
	$defaults = array(
		'fields' => array(),
		'primary' => null,
		'unique' => null
	);

	// Overwrite the defaults and add the values to the variable stack
	extract( merge_atts( $defaults, $atts ) );
	
	// $fields must be an array
	if( !is_array( $fields ) ) {
		throw new Exception( 'Could not create table "' . $table . '": Fields must be passed in the form of an array.' );
		return false;
	}

	// If no fields are specified, stop processing
	if( count( $fields ) == 0 ) {
		throw new Exception( 'Could not create table "' . $table . '": Fields must be passed.' );
		return false;
	}
	
	// Build the array that holds the inner field elements and parameters
	$crit = array();
	foreach( $fields as $field => $params ) {

		if( !is_array( $params ) ) {
			throw new Exception( 'Parameters for field ' . $field . ' must be given in the form of an array.' );
		}

		$field_sql = $field . ' ' . implode( ' ', $params );
		array_push( $crit, $field_sql );

	}

	//  If a primary field is given, add it to $crit
	if( $primary != null ) {
		array_push( $crit, 'PRIMARY KEY (' . $primary . ')');
	}

	//  If a unique field is given, add it to $crit
	if( $unique != null ) {
		array_push( $crit, 'UNIQUE (' . $unique . ')');
	}

	// Build the SQL statement
	$sql  = 'CREATE TABLE IF NOT EXISTS ' . $table . '(';
	$sql .= implode( ',', $crit );
	$sql .= ')';

	// Execute the SQL statement
	try {
		$dns = STRUCT_DBENGINE . ':dbname=' . STRUCT_DBNAME . ";host=" . STRUCT_DBHOST;
		$dbh = new PDO( $dns, STRUCT_DBUSER, STRUCT_DBPASS );
	    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $dbh->exec( $sql );
	    return true;
	} catch (PDOException $e) {
	    throw new Exception( 'Execution failed: ' . $e->getMessage() );
	    return false;
	}
	
}

function merge_atts( $defaults, $new_atts ) {
/**
 *  Description: Overrides default parameters with new values
 *
 *  @param 	$default    array    The default parameters
 *  @param 	$new_atts   array    The attributes that should override the defaults
 *  @return	            array    The merged array
 *
 */

	return array_merge( $defaults, $new_atts );
}

function insert( $table, $fields ) {
/**
 *  Description: Inserts a row into a table
 *
 *  @param     $table    string    The name of the table to insert the row
 *  @param     $params   array     An associative array of field names/values
 *  @return    			 boolean   true on success | false on failure
 *
 */

	// $table must be passed and not have a null value
	if( !$table || $table == '' ) {
		throw new Exception( 'Could not create table: A table name must be given.' );
		return false;
	}

	// $fields must be passed
	if( !$fields ) {
		throw new Exception( 'Could not create table "' . $table . '": Fields must be provided.' );
		return false;
	}
	
	// $fields must be an array
	if( !is_array( $fields ) ) {
		throw new Exception( 'Could not create table "' . $table . '": Fields must be passed in the form of an array.' );
		return false;
	}

	// Build the field and value strings
	$fields_arr = array();
	$values_arr = array();

	foreach( $fields as $field => $value ) {
		array_push( $fields_arr, $field );
		array_push( $values_arr, ':'.$field );
	}

	// Build the SQL statement
	$sql = 'INSERT INTO ' . $table . ' (' . implode( ',', $fields_arr ) . ') VALUES(' . implode( ',', $values_arr ) .')';

	// Execute the SQL statement
	try {
		$dns = STRUCT_DBENGINE . ':dbname=' . STRUCT_DBNAME . ";host=" . STRUCT_DBHOST;
		$dbh = new PDO( $dns, STRUCT_DBUSER, STRUCT_DBPASS );
	    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sth = $dbh->prepare( $sql );
	    $sth->execute( $fields );
	    return true;
	} catch (PDOException $e) {
	    throw new Exception( 'Execution failed: ' . $e->getMessage() );
	    return false;
	}

}

?>