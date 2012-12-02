<?php

if( !isset( $_GET['page'] ) )

	echo array( 'status' => false, 'message' => 'No page was assigned.' );

else

	include( '../includes/struct.php' );

	$post = $_POST;
	$curr = $_GET['page'];

	$save = $page->update( $curr, $post );

	echo json_encode( $save );

?>