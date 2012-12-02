<?php

// Paths
$domain 	   = 'http://localhost/testing-grounds/'; 				// The URL to the iStruct Installation
$server 	   = $_SERVER['DOCUMENT_ROOT'] . 'testing-grounds/';	// The system path to the iStruct Installation
$template 	   = 'jdizzle';  									    // The main template to use for the website
$site_language = 'en-US';
$site_charset  = 'text/html; charset=UTF-8';

// Database Credentials
$dbengine = 'mysql';			// The database engine
$dbhost   = 'localhost';		// The database host
$dbname   = 'jdz';				// The main database
$dbuser   = 'joshjunghans';		// The database username
$dbpass   = 'Josh@Delta36';		// The database password;

//////////////////////////////////////
/////   DO NOT EDIT BELOW THIS   /////
//////////////////////////////////////
define( 'ISTRUCT_DOMAIN', $domain );
define( 'ISTRUCT_LANGUAGE', $site_language );
define( 'ISTRUCT_CHARSET', $site_charset );
define( 'ISTRUCT_SERVER', $server );
define( 'ISTRUCT_TEMPLATE', $template );
define( 'ISTRUCT_TEMPLATE_FILEPATH', ISTRUCT_SERVER . 'istruct-templates/' . ISTRUCT_TEMPLATE . '/' );
define( 'ISTRUCT_TEMPLATE_URL', ISTRUCT_DOMAIN . 'istruct-templates/' . ISTRUCT_TEMPLATE . '/' );
define( 'ISTRUCT_TEMPLATE_IMAGES', ISTRUCT_TEMPLATE_URL . 'images/' );
define( 'ISTRUCT_TEMPLATE_HEADER', ISTRUCT_TEMPLATE_FILEPATH . 'header.php' );
define( 'ISTRUCT_TEMPLATE_FOOTER', ISTRUCT_TEMPLATE_FILEPATH . 'footer.php' );
define( 'ISTRUCT_DBENGINE', $dbengine );
define( 'ISTRUCT_DBHOST', $dbhost );
define( 'ISTRUCT_DBNAME', $dbname );
define( 'ISTRUCT_DBUSER', $dbuser );
define( 'ISTRUCT_DBPASS', $dbpass );
define( 'ISTRUCT_DNS', ISTRUCT_DBENGINE . ':dbname=' . ISTRUCT_DBNAME . ';host=' . ISTRUCT_DBHOST );
define( 'ISTRUCT_THUMB_FUNC', ISTRUCT_DOMAIN . 'istruct-func/thumbnail.php' );
define( 'ISTRUCT_FUNC', ISTRUCT_SERVER . 'istruct-func/functions.php' );
define( 'ISTRUCT_DB_CLASS', ISTRUCT_SERVER . 'istruct-classes/db.class.php' );
define( 'ISTRUCT_ADMIN_CLASS', ISTRUCT_SERVER . 'istruct-admin/admin.class.php' );
define( 'ISTRUCT_JQUERY', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js' );

$des_types = array(
	'user' => 'iStruct_Users',
	'page' => 'iStruct_Pages',
);


?>