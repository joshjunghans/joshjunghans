<?php
session_start();
require_once '../../istruct-classes/istruct.config.php';
require_once ISTRUCT_DB_CLASS;

extract( $_POST );
$ret = array();

if( $User_Email == '' || $User_Pass == '' ) {

	$ret = array(
		'status' => false,
		'error' => 'You must enter your email address and password to login.'
	);

} else {

	$verify = verifyUser( $User_Email, $User_Pass );

	if( !$verify ) {
		$ret = array(
			'status' => false,
			'error' => 'The email or password you entered were incorrect.'
		);
	} else {
		$_SESSION['istruct_user'] = $User_Email;
		$now = date( 'Y-m-d H:i:s', time() );

		$q = new Query;
		$q->update( 'istruct_users', array( 'Last_Logged_In' => $now ), 'User_Email=' . $_SESSION['istruct_user'] );

		$ret = array( 'status' => true );
	}

}

echo json_encode( $ret );

function verifyUser( $email, $pass ) {
/**
 *  Description: Verifies a user for login purposes
 *
 *  @param 	string $email the user's email address
 *  @param 	string $pass the user's password
 *  @return	boolean true/false
 *
 */

	$d = md5( '+_+_+__+^^' . $pass . '^^+__+_+_+' );

	$params = array(
		'tbl' => 'istruct_users',
		'fields' => array(),
		'condition' => 'User_Email=' . $email . ' AND User_Pass=' . $d
	);

	extract( $params );

	$q = new Query;
	$user_record = $q->get( $tbl, $fields, $condition );

	if( !$user_record ) {
		return false;
	} else {
		return true;
	}

}


?>