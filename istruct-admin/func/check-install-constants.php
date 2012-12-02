<?php

// Create an empty array to hold any flags that may come up
$flags = array(
	'constants' => array(),
	'dbcon' => array()
);

// What are we checking
$currently_checking = $_GET['check'];

// include globals so we can see if they are defined
include( '../../config/settings.php' );

switch( $currently_checking ) {

	case 'constants':

		// Is the database host defined
		if( !defined( 'STRUCT_DBHOST' ) || STRUCT_DBHOST == '' ) {
			array_push( $flags['constants'], array( 'line' => '12', 'constant' => 'STRUCT_DBHOST' ) );
		}

		// Is the database name defined
		if( !defined( 'STRUCT_DBNAME' ) || STRUCT_DBNAME == '' ) {
			array_push( $flags['constants'], array( 'line' => '13', 'constant' => 'STRUCT_DBNAME' ) );
		}

		// Is the database username defined
		if( !defined( 'STRUCT_DBUSER' ) || STRUCT_DBUSER == '' ) {
			array_push( $flags['constants'], array( 'line' => '14', 'constant' => 'STRUCT_DBUSER' ) );
		}

		// Is the database username defined
		if( !defined( 'STRUCT_DBPASS' ) || STRUCT_DBPASS == '' ) {
			array_push( $flags['constants'], array( 'line' => '14', 'constant' => 'STRUCT_DBPASS' ) );
		}

		if( count( $flags['constants'] ) >= 1 ) {
			$return = array(
				'checking' => 'constants',
				'status' => false,
				'flags' => $flags['constants']
			);
		} else {
			$return = array( 'checking' => 'constants', 'status' => true );
		}

	break;

	case 'dbcon':

		try {
			$dns = STRUCT_DBENGINE . ':dbname=' . STRUCT_DBNAME . ";host=" . STRUCT_DBHOST;
			$dbh = new PDO( $dns, STRUCT_DBUSER, STRUCT_DBPASS );
			$return = array( 'checking' => 'dbcon', 'status' => true );
		} catch( PDOException $e ) {
			$return = array(
				'checking' => 'dbcon',
				'status' => false,
				'flags' => $flags['dbcon']
			);
		}

	break;

}

echo json_encode( $return );

?>