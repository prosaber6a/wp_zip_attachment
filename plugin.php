<?php
/*
Plugin Name: Pro Product Zip Generator
Plugin URI: http://procoder.us/
Description: 
Author: Saber Hossen Rabbani
Version: 1.0.0
Author URI: http://saberhr.me/
Text Domain: pro-zip
*/

require_once dirname(__FILE__).'/tgmpa/tgmpa_plugin_register.php';
require_once dirname(__FILE__).'/post-type.php';
require_once dirname(__FILE__).'/metafield.php';
require_once dirname(__FILE__).'/shortcode.php';

function prozip_plugin_init() {
    load_plugin_textdomain( 'pro-zip', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'prozip_plugin_init' );


function prozip_scripts() {
    wp_enqueue_style('prozip_front-css', plugin_dir_url(__FILE__).'/css/front.css', null, time());
    wp_enqueue_style('font_awesome-css', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
    wp_enqueue_script('prozip_front_script', plugin_dir_url(__FILE__).'/js/scripts.js', ['jquery'], false, true);
    wp_localize_script( 'prozip_front_script', 'my_ajax_object', ['ajax_url' => admin_url( 'admin-ajax.php' ) ] );

}

add_action('wp_enqueue_scripts', 'prozip_scripts');


