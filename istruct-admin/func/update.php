<?php

if( isset( $_GET['type'] ) || empty( $_GET['type'] ) ) {

	$ret = array( 'status' => false, 'error' => null );
	$type = $_GET['type'];

	require_once '../../istruct-classes/istruct.config.php';
	require_once ISTRUCT_DB_CLASS;

	global $des_types;

	$q = new Query();
	$tbl = $des_types[$type];
	$new_vals = $_POST;
	$where = null;

	switch( $type ) {
		case 'page':
			if( !isset( $_GET['p_id'] ) || empty( $_GET['p_id'] ) ) {
				$ret['error'] = 'No page was designated to update';
			} else {
				$where = 'Page_ID=' . $_GET['p_id'];
			}
		break;
		case 'user':
			if( !isset( $_GET['user_id'] ) || empty( $_GET['user_id'] ) ) {
				$ret['error'] = 'No User was designated to update';
			} else {
				$where = 'User_ID=' . $_GET['user_id'];
			}
		break;
	}

	if( !empty( $where ) ) {

		$result = $q->update( $tbl, $new_vals, $where );

		if( !$result ) {
			$ret['error'] = $q->errorInfo->getMessage();
			$ret['query'] = $q->query;
		} else {
			$ret = array( 'status' => true );
		}

	}

	if( isset( $_GET['return'] ) && $_GET['return'] == 'json' ) {
		echo json_encode( $ret );
	} else {
		return $ret;
	}
	
}


?>