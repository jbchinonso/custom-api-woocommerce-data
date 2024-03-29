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
namespace App;

if ( !defined( 'ABSPATH' ) ): exit();
endif;

define('SAUCAL_PATH', trailingslashit(plugin_dir_path(__FILE__)));

require_once SAUCAL_PATH . 'functions.php';

use includes\SaucalWidget;
use includes\CreateAdminMenu;



class App {


    public function __construct(){

        $this->loadClasses();
        CreateAdminMenu::getInstance();
       add_action('wp_enqueue_scripts', [$this, 'enqueue_plugin_assets']);
       add_action('widgets_init', [$this, 'register_widgets']);

    }

    public function loadClasses(){
        spl_autoload_register(function ($class) {
            $baseDir = plugin_dir_path(__FILE__);
            $class_path = $baseDir . str_replace('\\', '/', $class) . '.php';

            if (file_exists($class_path)) {
                require_once $class_path;
            }

        });

    }

    public function enqueue_plugin_assets(){
            wp_register_style(
                'saucal_api_style',
                plugins_url('assets/saucal-main.css', __FILE__),
                [],
                filemtime(SAUCAL_PATH . 'assets/saucal-main.css')
            );

            wp_enqueue_style('saucal_api_style');

     }

    public function register_widgets(){
           
        return register_widget('includes\SaucalWidget');
    }


}

new App();



