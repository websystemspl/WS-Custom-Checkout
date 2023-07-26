<?php
/*
 * Plugin Name:       Web Systems Custom Woocommerce Checkout Page
 * Text Domain:       web_systems_custom_woocommerce_checkout_plugin
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
        if ( !defined( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH' ) ) {
            define( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
        }
        
        if ( !defined( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_URL' ) ) {
            define( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
        }
        $this->run_web_systems_custom_woocommerce_checkout_plugin_manager();
    }
    function activate(){
        \flush_rewrite_rules();
    }
    function deactivate(){
        \flush_rewrite_rules();
    }
    function unistall(){

    }

    function run_web_systems_custom_woocommerce_checkout_plugin_manager() {
        require_once WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH . 'includes/class-plugin-manager.php';
        $plugin_manager = new Web_Systems_Custom_Woocommerce_Checkout_Plugin_Manager();
        $plugin_manager->run();	 
    }
}
if(class_exists('CheckoutPlugin')){
    $checkoutPlugin = new CheckoutPlugin();
    \register_activation_hook(__FILE__ , [ $checkoutPlugin, 'activate']);
    \register_deactivation_hook(__FILE__, [ $checkoutPlugin, 'deactivate']);
}
