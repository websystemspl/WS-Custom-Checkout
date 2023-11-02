<?php
defined( 'ABSPATH' ) || exit;
class WSCCP_Checkout_Hook_Manager {   
    public function run() {
        //is_checkout and is_cart function are noit defined yet

        require_once(  WSCCP_DIR_PATH . 'checkout/checkout-manager.php' );
        $checkout_manager = new WSCCP_Checkout_Checkout_Manager();
        $checkout_manager->dispatch_hook_actions();  
    
    }
}