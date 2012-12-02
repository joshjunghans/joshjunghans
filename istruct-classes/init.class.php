<?php

require 'struct.class.php';
iStructSite::init();

class iStructSite {

	static function init() {

		$struct = new Struct();
		$struct->set_page_properties();

		$page_to_load = null;

		switch( $struct->current_slug ) {

			case 'home':
				$page_to_load = ISTRUCT_TEMPLATE_FILEPATH . 'home.php';
			break;
			case '404':
				$page_to_load = ISTRUCT_TEMPLATE_FILEPATH . '404.php';
			break;
			default:
				$page_to_load = ISTRUCT_TEMPLATE_FILEPATH . 'index.php';

		}

		do_stack( 'init' );

		if( file_exists( $page_to_load ) )
			require_once $page_to_load;

	}

}

?>