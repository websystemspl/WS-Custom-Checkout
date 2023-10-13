<?php
defined( 'ABSPATH' ) || exit;
class Web_Systems_Custom_Woocommerce_Checkout_Checkout_Manager {
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
        /*foreach ( [ 'shipping', 'sections' ] as $script_name ) {
        $script_name = 'sections';                
            wp_register_script( "web_systems_custom_woocommerce_checkout-js-checkout-{$script_name}", WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . "checkout/js/{$script_name}.js", [ 'jquery'], false, true );//in_footer
            wp_enqueue_script( "web_systems_custom_woocommerce_checkout-js-checkout-{$script_name}" );
        }*/

        /*$sections_js_dependencies = [ 'jquery' ];
        if( wp_is_mobile() ) {  
            wp_register_script( 'jquery-mobile', 'http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js', $sections_js_dependencies, false, true );//in_footer
            wp_enqueue_script( 'jquery-mobile' );
            
            $sections_js_dependencies = [ 'jquery-mobile' ];
        }
        wp_register_script( 'web_systems_custom_woocommerce_checkout-js-checkout-sections', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/js/sections.js', $sections_js_dependencies, false, true );//in_footer
        wp_enqueue_script( 'web_systems_custom_woocommerce_checkout-js-checkout-sections' );*/

        //wp_enqueue_script( 'jquery-ui-core' );
 
        //wp_register_script( 'jquery-mobile', 'http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js', [ 'jquery' ], false, true );//in_footer
            //wp_enqueue_script( 'jquery-mobile' );


        wp_register_script( 'web_systems_custom_woocommerce_checkout-js-checkout-swipe', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/js/swipe.js', [ 'jquery'  ], false, true );//in_footer
        wp_enqueue_script( 'web_systems_custom_woocommerce_checkout-js-checkout-swipe' );


        wp_register_script( 'web_systems_custom_woocommerce_checkout-js-checkout-sections', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/js/sections.js', [ 'jquery', 'web_systems_custom_woocommerce_checkout-js-checkout-swipe'  ], false, true );//in_footer
        wp_enqueue_script( 'web_systems_custom_woocommerce_checkout-js-checkout-sections' );
  
        if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) {
            $script_name = 'shipping';           
            wp_register_script( 'web_systems_custom_woocommerce_checkout-js-checkout-shipping', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/js/shipping.js', [ 'web_systems_custom_woocommerce_checkout-js-checkout-sections' ], false, true );//in_footer
            wp_enqueue_script( 'web_systems_custom_woocommerce_checkout-js-checkout-shipping' );
        }
    }
    private function enqueue_checkout_styles() {   
        wp_register_style( 'web_systems_custom_woocommerce_checkout-css-checkout-sections', WS_CUSTOM_CHECKOUT_PLUGIN_DIR_URL . 'checkout/css/sections.css' );
        wp_enqueue_style( 'web_systems_custom_woocommerce_checkout-css-checkout-sections' );
    }
}