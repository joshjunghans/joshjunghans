<?php

if( ( !isset( $_GET['type'] ) || empty( $_GET['type'] ) ) || !isset( $_GET['action'] ) || empty( $_GET['action'] ) )
	return;

$type = $_GET['type'];
$action = $_GET['action'];

require_once '../../istruct-classes/istruct.config.php';
require_once ISTRUCT_DB_CLASS;
global $des_types;
$tbl = $des_types[$type];
$result = null;

$q = new Query;

switch( $action ) {

	case 'add':

		$result = $q->add( $tbl, $_POST );

	break;
	case 'update':

		if( !isset( $_GET['id'] ) || empty( $_GET['id'] ) )
			return;

		$condition = ucfirst( $type ) . '_ID=' . $_GET['id'];

		$result = $q->update( $tbl, $_POST, $condition );

	break;
	case 'delete':

		if( !isset( $_GET['id'] ) || empty( $_GET['id'] ) )
			return;

		$condition = ucfirst( $type ) . '_ID=' . $_GET['id'];

		$result = $q->delete( $tbl, $condition );

	break;

}

if( !$result ) {
	$ret = array(
		'status' => false,
		'error' => $q->errorInfo->getMessage()
	);
} else {
	$ret = array( 'status' => true );
}

if( isset( $_GET['return'] ) && $_GET['return'] == 'json' ) {
	echo json_encode( $ret );
} else {
	return $ret;
}

?>