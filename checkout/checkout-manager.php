<?php
defined( 'ABSPATH' ) || exit;
class WSCCP_Checkout_Checkout_Manager {
    public function dispatch_hook_actions() {        
        add_action( 'woocommerce_checkout_order_review', [ $this, 'deregister_woocommerce_checkout_payment' ], 10 );

        add_action( 'woocommerce_before_checkout_form', [ $this, 'deregister_woocommerce_checkout_coupon_form' ], 5 );
        
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles_and_scripts' ], 1 );
    }
    public function deregister_woocommerce_checkout_payment() {
        //payment method and buy-button moved to template:form-checkout.php
        remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    }
    public function deregister_woocommerce_checkout_coupon_form() {
        //payment method and buy-button moved to template:form-checkout.php
        remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    }
    public function enqueue_styles_and_scripts() {
        if( is_checkout() ) {
            $this->enqueue_checkout_scripts();
            $this->enqueue_checkout_styles();
        }
    }
    private function enqueue_checkout_scripts() {
        wp_register_script( 'wsccp_checkout-js-checkout-swipe', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/js/swipe.js', [ 'jquery'  ], false, true );//in_footer
        wp_enqueue_script( 'wsccp_checkout-js-checkout-swipe' );


        wp_register_script( 'wsccp_checkout-js-checkout-sections', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/js/sections.js', [ 'jquery', 'wsccp_checkout-js-checkout-swipe'  ], false, true );//in_footer
        wp_enqueue_script( 'wsccp_checkout-js-checkout-sections' );
  
        if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) {
            $script_name = 'shipping';           
            wp_register_script( 'wsccp_checkout-js-checkout-shipping', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/js/shipping.js', [ 'wsccp_checkout-js-checkout-sections' ], false, true );//in_footer
            wp_enqueue_script( 'wsccp_checkout-js-checkout-shipping' );
        }
    }
    private function enqueue_checkout_styles() {   
        wp_register_style( 'wsccp_checkout-css-checkout-sections', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/css/sections.css' );
        wp_enqueue_style( 'wsccp_checkout-css-checkout-sections' );
    }
}