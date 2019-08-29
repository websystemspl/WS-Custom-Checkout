<?php
/*
 * Plugin Name:       Web Systems Custom Woocommerce Checkout Page
 * Author: Web Systems
 * Author URI: https://www.web-systems.pl/
 * Description:       Tab-based checkout page layout.
 * Version:           1.0
 */
 
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! defined( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH' ) ) {
    define( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_URL' ) ) {
    define( 'WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

function run_web_systems_custom_woocommerce_checkout_plugin_manager() {
    require_once WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH . 'includes/class-plugin-manager.php';
    $plugin_manager = new Web_Systems_Custom_Woocommerce_Checkout_Plugin_Manager();
    $plugin_manager->run();	 
}

run_web_systems_custom_woocommerce_checkout_plugin_manager();