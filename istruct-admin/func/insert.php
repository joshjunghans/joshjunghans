<?php

if( isset( $_GET['type'] ) || empty( $_GET['type'] ) ) {

	$ret = array( 'status' => false, 'error' => null );
	$type = $_GET['type'];

	require_once '../../istruct-classes/istruct.config.php';
	require_once ISTRUCT_DB_CLASS;
	global $des_types;

	$q = new DBQuery();
	$tbl = $des_types[$type];
	$new_vals = $_POST;

	switch( $type ) {
		case 'page':
			//unique values for pages here
		break;
	}

	$result = $q->add( $tbl, $new_vals );

	if( !$result ) {
		$ret['error'] = $q->errorMessage;
	} else {
		$ret = array( 'status' => true, 'insert_id' => $q->insert_id );
	}

	if( isset( $_GET['return'] ) && $_GET['return'] == 'json' ) {
		echo json_encode( $ret );
	} else {
		return $ret;
	}

}


?>