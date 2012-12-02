<?php

	if( !isset( $_GET['src'] ) )
		return;

	extract( $_GET );

	if( !file_exists( $src ) )
		return;

	$img_atts = getimagesize( $src );
	$allowed = array( 'image/jpeg','image/gif','image/png' );

	if( !in_array( $img_atts['mime'], $allowed ) )
		return;

	header( 'Content-type: ' . $img_atts['mime'] );

	$canvas = imagecreatetruecolor( $w, $h );

	switch( $img_atts['mime'] ) {
		case 'image/jpeg': $img = imagecreatefromjpeg( $src ); break;
		case 'image/gif': $img = imagecreatefromgif( $src ); break;
		case 'image/png': $img = imagecreatefrompng( $src ); break;
	}

	if( $img_atts['mime'] == "image/gif" || $img_atts['mime'] == "image/png" ) {
		imagecolortransparent( $canvas, imagecolorallocatealpha( $canvas, 0, 0, 0, 127 ) );
	    imagealphablending( $canvas, false );
	    imagesavealpha( $canvas, true );
	}

	imagecopyresampled( $canvas , $img, 0, 0, 0, 0, $w, $h, $img_atts[0], $img_atts[1] );

	switch( $img_atts['mime'] ) {
		case 'image/jpeg': imagejpeg( $canvas ); break;
		case 'image/gif': imagegif( $canvas ); break;
		case 'image/png': imagepng( $canvas ); break;
	}

?>