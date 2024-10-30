<?php
/*
Plugin Name: Bible Reading Plan
Plugin URI: http://fullthrottledevelopment.com/bible_reading_plan/
Description: This widget places a daily Bible verse in your sidebar based on Dr. Nathan Finn's Bible Reading plan found at <a href='http://betweenthetimes.com/bible-reading-plan'>http://betweenthetimes.com</a>
Version: 0.2
Author: FullThrottle Development
Author URI: http://fullthrottledevelopment.com/
*/

//Primary Developer : Glenn Ansley (http://glennansley.com)

/*Copyright 2009 Glenn Ansley

/* Release History
 0.1 - Initial Release
 0.2 - Fixed Widget Header CSS and added ability to link verse.
*/

include_once('widget.php');

define( 'FT_BRP_Version' , '0.2' );

// Define plugin path
if ( !defined('WP_CONTENT_DIR') ) {
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content');
}
define('FT_BRP_PATH' , WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)) );

// Define plugin URL
if ( !defined('WP_CONTENT_URL') ) {
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content' );
}
define( 'FT_BRP_URL' , WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)) );


// Setup form security
if ( !function_exists('wp_nonce_field') ) {
    function ft_brp_nonce_field($action = -1) { return; }
    $ft_brp_nonce = -1;
} else {
	if( !function_exists( 'ft_brp_nonce_field' ) ) {
	function ft_brp_nonce_field($action = -1,$name = 'ft_brp-update-checkers') { return wp_nonce_field($action,$name); }
	define('FT_BRP_NONCE' , 'ft_brp-update-checkers');
	}
}

//This function sets up my tables
if ( !function_exists('ft_brp_plugin_activation') ){
	function ft_brp_plugin_activation() {
		global $wpdb;
		include_once('db_setup.php');
		$db = new FT_BRP_Table_Setup();
	}
}

register_activation_hook( __FILE__, 'ft_brp_plugin_activation' );