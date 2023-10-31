<?php
/*
 * Plugin Name:       WS Custom Checkout
 * Text Domain:       ws-custom-checkout
 * Description:       Tab-based checkout page layout.
 * Version:           1.0
 * Requires at least: 5.0
 * Author:            Web Systems
 * Author URI:        https://www.k4.pl/
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('WPINC')) {
    die;
}

if (!defined('WS_CUSTOM_CHECKOUT_PLUGIN_DIR_PATH')) {
    define('WS_CUSTOM_CHECKOUT_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
}

if (!defined('WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL')) {
    define('WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
}

if (!class_exists('WSCCP_Plugin_Manager')) {
    require_once WS_CUSTOM_CHECKOUT_PLUGIN_DIR_PATH . 'includes/class-plugin-manager.php';
    $plugin_manager = new WSCCP_Plugin_Manager();
    $plugin_manager->run();
}
