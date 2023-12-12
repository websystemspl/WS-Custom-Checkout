<?php
/*
 * Plugin Name:       WS Custom Checkout
 * Text Domain:       WS-Custom-Checkout
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

if (!defined('WSCCP_DIR_PATH')) {
    define('WSCCP_DIR_PATH', plugin_dir_path(__FILE__));
}

if (!defined('WSCCP_DIR_URL')) {
    define('WSCCP_DIR_URL', plugin_dir_url(__FILE__));
}

if (!class_exists('WSCCP_Plugin_Manager')) {
    require_once WSCCP_DIR_PATH . 'includes/class-plugin-manager.php';
    $plugin_manager = new WSCCP_Plugin_Manager();
    $plugin_manager->run();
}
