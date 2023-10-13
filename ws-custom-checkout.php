<?php
/*
 * Plugin Name:       WS Custom Checkout
 * Text Domain:       ws_custom_checkout
 * Description:       Tab-based checkout page layout.
 * Version:           1.0
 * Requires at least: 5.0
 * Author:            Web Systems
 * Author URI:        https://www.web-systems.pl/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 */
 
if ( ! defined( 'WPINC' ) ) {
    die;
}

class CheckoutPlugin{
    function __construct(){
        if ( !defined( 'WS_CUSTOM_CHECKOUT_PLUGIN_DIR_PATH' ) ) {
            define( 'WS_CUSTOM_CHECKOUT_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
        }
        
        if ( !defined( 'WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL' ) ) {
            define( 'WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
        }
        $this->run_ws_custom_checkout_manager();
    }
    function activate(){
    }
    function deactivate(){
    }
    function unistall(){
    }
    function run_ws_custom_checkout_manager() {
        require_once WS_CUSTOM_CHECKOUT_PLUGIN_DIR_PATH . 'includes/class-plugin-manager.php';
        $plugin_manager = new WS_Woo_Checkout_Plugin_Manager();
        $plugin_manager->run();	 
    }
}
if(class_exists('CheckoutPlugin')){
    $checkoutPlugin = new CheckoutPlugin();
    \register_activation_hook(__FILE__ , [ $checkoutPlugin, 'activate']);
    \register_deactivation_hook(__FILE__, [ $checkoutPlugin, 'deactivate']);
}