<?php 
/**
 * Plugin Name: Landing Pages
 * Description: A plugin to create dynamic landing pages
 * Version: 2.0
 * Author: Alexander Steadman
 * Author URI: github.com/VeryOddlySpecific
 * License: GPL2
 */

// if this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
    die;
}

// define plugin constants
define( 'VOS_LP_PATH', plugin_dir_path( __FILE__ ) );
define( 'VOS_LP_URL', plugin_dir_url( __FILE__ ) );
define( 'VOS_LP_VERSION', '2.0' );

// include main plugin class
require_once VOS_LP_PATH . 'includes/class-landing-pages.php';

// run the plugin
$plugin = new Landing_Pages();
$plugin->run();