<?php

session_start();
include( '../../ws-framework/struct/globals.php' );
include( '../../ws-framework/struct/db.php' );
include( 'user.php' );

$user = $iuser->verifyUser( 'josh@deltamediallc.com', 'Josh@Delta36' );

if( $user ) {
	echo "yes";
} else {
	echo "no";
}


?>