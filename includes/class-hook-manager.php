<?php
defined( 'ABSPATH' ) || exit;
class Web_Systems_Custom_Woocommerce_Checkout_Hook_Manager {   
    public function run() {
        //is_checkout and is_cart function are noit defined yet

        require_once(  WS_CUSTOM_CHECKOUT_PLUGIN_DIR_PATH . 'checkout/checkout-manager.php' );
        $checkout_manager = new Web_Systems_Custom_Woocommerce_Checkout_Checkout_Manager();
        $checkout_manager->dispatch_hook_actions();  
    
    }
}