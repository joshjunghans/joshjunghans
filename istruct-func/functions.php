<?php

function add_script( $id, $src ) {
	global $scripts;
	$scripts[] = array('id' => $id, 'src' => $src );
}

function add_meta( $params ) { global $meta; $meta[] = $params; }

function add_stylesheet( $id, $src ) {
	global $styles;
	$styles[] = array('id' => $id, 'src' => $src );
}

function add_to_stack( $stackname, $func, $args = array(), $priority = null ) {

	global $stack;

	if( !isset( $stack[$stackname] ) )
		return;

	$this_stack = $stack[$stackname];

	$stack_this = array(
		'func' => $func,
		'args' => $args,
		'priority' => $priority
	);

	array_push( $stack[$stackname], $stack_this );
	return true;

}

function do_stack( $stackname ) {

	global $stack;
	
	if( !isset( $stack[$stackname] ) || count( $stack[$stackname] ) == 0 )
		return;

	for( $i = 0; $i < count( $stack[$stackname] ); $i++ ) {

		$func = $stack[$stackname][$i];

		if( !function_exists( $func['func'] ) )
			return;

		if( !is_array( $func['args'] ) ) {

			if( $func['args'] == '' ) {
				call_user_func( $func['func'] );
			} else {
				$func['args'] = array( $func['args'] );
				call_user_func_array( $func['func'], $func['args'] );
			}

		} else {
			call_user_func_array( $func['func'], $func['args'] );
		}

	}

}

function is_page( $slug ) {
	global $page;

	if( $slug == $page->Page_Slug ) {
		return true;
	} else {
		return false;
	}
	
}


function template_image( $path, $echo = true, $public = true ) {

	$raw_img = 'images/' . $path;
	$full_path = ( !$public ) ? ISTRUCT_TEMPLATE_FILEPATH . $raw_img : ISTRUCT_TEMPLATE_URL . $raw_img;

	if( !$echo ){
		return $full_path;
	} else {
		echo $full_path;
	}

}

function image_thumb( $src, $w, $h, $dest, $echo = true ) {

	$path = ISTRUCT_THUMB_FUNC . '?src=' . urlencode( $src ) . '&w=' . $w . '&h=' . $h . '&dest=' . $dest;

	if( !$echo ) {
		return $path;
	} else {
		echo $path;
	}

}

?>