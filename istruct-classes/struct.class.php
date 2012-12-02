<?php

class Struct {

	public $current_slug;
	public $page = null;

	public function __construct() {
		session_start();
		error_reporting( E_ALL );

		require_once 'istruct.config.php';
		require_once ISTRUCT_DB_CLASS;
		require_once ISTRUCT_FUNC;
		$this->set_current_page();
		$this->load_template();

	}

	private function load_template() {

		global $scripts; global $styles; global $meta;

		$system_template = ISTRUCT_SERVER . 'istruct-templates/' . ISTRUCT_TEMPLATE . '/'; // Server-side path
		$public_template = ISTRUCT_DOMAIN . 'istruct-templates/' . ISTRUCT_TEMPLATE . '/'; // Client-side path

		$template_func_file    = $system_template . 'functions.php';
		$template_scripts_file = $system_template . 'js/scripts.js';
		$template_scripts_url  = $public_template . 'js/scripts.js';
		$template_styles_file  = $system_template . 'styles/styles.css';
		$template_styles_url   = $public_template . 'styles/styles.css';

		if( file_exists( $template_func_file ) ) { require_once $template_func_file; }
		if( file_exists( $template_scripts_file ) ) { add_script( 'template-scripts', $template_scripts_url ); }
		if( file_exists( $template_styles_file ) ) { add_stylesheet( 'template-styles', $template_styles_url ); }

		// Add the site language and charset (as defined in istruct.config.php) to the meta stack
		add_meta( array('http-equiv' => 'content-type', 'content' => ISTRUCT_CHARSET ) );
		add_meta( array('http-equiv' => 'content-language', 'content' => ISTRUCT_LANGUAGE ) );

	}

	public function set_current_page() {

		if( !isset( $_GET['showpage'] ) ) {
			$this->current_slug = 'home';
		} else {

			$slugs = new Query;
			$slug_list = $slugs->get( 'istruct_pages', array('Page_Slug'), 'Page_Slug=' . $_GET['showpage'] );
			$this->current_slug = ( !$slug_list ) ? '404' : $_GET['showpage'];

		}

	}

	public function set_page_properties() {
		global $page;
		$pq = new Query;
		$page = $pq->get( 'istruct_pages', array(), 'Page_Slug=' . $this->current_slug, '', '', '', '', 1 );
	}

	public function doctype( $type = 'xtransitional' ) {

		$doctypes = array(
			'html5' 		=> '<!DOCTYPE html>',
			'strict' 		=> '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'."\n",
			'transitional' 	=> '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'."\n",
			'frameset' 		=> '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">'."\n",
			'xstrict' 		=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n",
			'xtransitional' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n",
			'xframeset' 	=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">'."\n",
			'xhtml' 		=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'."\n"
		);

		return $doctypes[$type];

	}

	public function page_title() { global $page; echo $page->Page_Title; }

	private function meta_block() {

		global $meta;
		$out = '';

		if( count( $meta ) == 0 ) return;

		for( $i = 0; $i < count( $meta ); $i++ ) {

			if( count( $meta[$i] ) == 0 ) return;

			$atts = array();

			foreach( $meta[$i] as $att => $value ) { $atts[] = $att . '="' . $value . '"'; }

			$out .= '<meta ' . implode( ' ', $atts ) . ' />'."\n";

		}

		return $out;

	}

	private function script_block() {

		global $scripts;
		$out = '';

		if( count( $scripts ) == 0 )
			return;

		for( $i = 0; $i < count( $scripts ); $i++ ) {
			$out .= '<script type="text/javascript" id="' . $scripts[$i]['id'] . '" src="' . $scripts[$i]['src'] . '"></script>'."\n";
		}

		return $out;

	}

	private function stylesheet_block() {

		global $styles;
		$out = '';

		if( count( $styles ) == 0 )
			return;

		for( $i = 0; $i < count( $styles ); $i++ ) {
			$out .= '<link rel="stylesheet" type="text/css" id="' . $styles[$i]['id'] . '" href="' . $styles[$i]['src'] . '" />'."\n";
		}

		return $out;

	}

	public function head() {
		global $page;
		?>
<?php echo $this->doctype(); ?>
<head>
<?php do_stack( 'before_title' ); ?>
<title><?php echo $page->Page_Title; ?></title>
<?php do_stack( 'after_title' ); ?>
<?php do_stack( 'before_meta' ); ?>
<?php echo $this->meta_block(); ?>
<?php do_stack( 'after_meta' ); ?>
<?php do_stack( 'before_styles' ); ?>
<?php echo $this->stylesheet_block(); ?>
<?php do_stack( 'after_styles' ); ?>
<?php do_stack( 'before_scripts' ); ?>
<?php echo $this->script_block(); ?>
<?php do_stack( 'after_scripts' ); ?>
</head>
<body class="<?php echo $page->Page_Slug; ?>">
		<?php do_stack( 'before_header' ); ?>
		<?php $this->page_header(); ?>
		<?php do_stack( 'after_header' ); ?>
		<?php
	}

	private function page_header() { require_once ISTRUCT_TEMPLATE_HEADER; }

	public function page_content() { global $page; echo $page->Page_Content; }

	private function page_footer() { require_once ISTRUCT_TEMPLATE_FOOTER; }

	public function foot() { ?>
		<?php do_stack( 'before_footer' ); ?>
		<?php $this->page_footer(); ?>
		<?php do_stack( 'after_footer' ); ?>
		</body>
		</html>
	<?php
	}

}

$stack = array(
	'init' 				  => array(),
	'before_title'		  => array(),
	'after_title' 		  => array(),
	'before_meta' 		  => array(),
	'after_meta' 		  => array(),
	'before_styles' 	  => array(),
	'after_styles' 		  => array(),
	'before_scripts' 	  => array(),
	'after_scripts' 	  => array(),
	'before_header'		  => array(),
	'after_header' 		  => array(),
	'before_page_content' => array(),
	'before_content' 	  => array(),
	'after_content'		  => array(),
	'after_page_content'  => array(),
	'before_footer' 	  => array(),
	'after_footer' 		  => array()
);

$meta 	 = array();
$scripts = array();
$styles  = array();
$page 	 = null;

?>