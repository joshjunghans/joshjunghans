<?php

/*
	Verifies if a user is logged in or not.  if they are not, then port them to the login page.
 */

if( !isset( $_SESSION ) || !array_key_exists( 'istruct_user', $_SESSION ) || $_SESSION['istruct_user'] == '' )
	header("Location:login.php");


?>