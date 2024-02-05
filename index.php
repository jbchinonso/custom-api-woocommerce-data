<?php
/**
* Custom API woocommerce Data
*
* Plugin Name: Custom API woocommerce Data
* Plugin URI:  https://github.com/jbchinonso/custom-api-woocommerce-data
* Description: Enable Custom API in woocommerce my-account page and as a widget
* Version:     1.0
* Author:      johnbosco
* Author URI:  https://github.com/jbchinonso
* License:     MIT
* Text Domain: Saucal
* Requires PHP at least: 7.0
*
*/
if ( !defined( 'ABSPATH' ) ): exit();
endif;

define( 'SAUCAL_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

require_once SAUCAL_PATH . 'includes/constants.php';
require_once SAUCAL_PATH . 'functions.php';


//Register Styles
function saucal_enqueue_plugin_assets()
{
    wp_register_style(
        'saucal_api_style',
        plugins_url('assets/saucal-main.css', __FILE__),
        [],
        filemtime(SAUCAL_PATH . 'assets/saucal-main.css')
    );

    wp_enqueue_style('saucal_api_style');

}


add_action('wp_enqueue_scripts', 'saucal_enqueue_plugin_assets');

