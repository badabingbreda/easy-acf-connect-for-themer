<?php
/**
 Plugin Name: Easy ACF Connect for Themer
 Plugin URI: https://www.badabing.nl
 Description: Easy ACF Connect for Beaver Themer. Just select the fieldname to connect.
 Version: 1.1.5
 Author: Didou Schol
 Text Domain: easy-acf-connect
 Domain Path: /languages
 Author URI: https://www.badabing.nl
 */

define( 'EASYACFCONNECT_VERSION' 	, '1.1.5' );
define( 'EASYACFCONNECT_DIR'			, plugin_dir_path( __FILE__ ) );
define( 'EASYACFCONNECT_FILE'		, __FILE__ );
define( 'EASYACFCONNECT_URL' 		, plugins_url( '/', __FILE__ ) );

// include the Conditional Logic rules
include_once( 'easy-bb-logic.php' );

// include the easy-acf class
include_once( 'classes/class-easy-acf.php' );

add_action( 'init' , 'easy_acf_connect::init', 99, 1 );

add_action( 'plugins_loaded', 'easy_acf_setup_textdomain' );

/**
 * Function to load the textdomain
 * @return void
 * @since  1.1
 */
function easy_acf_setup_textdomain(){
	//textdomain
	load_plugin_textdomain( 'easy-acf-connect', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
