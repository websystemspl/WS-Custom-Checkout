<?php
defined( 'ABSPATH' ) || exit;
class Web_Systems_Custom_Woocommerce_Checkout_Plugin_Manager {
    private $_sections = ['checkout' ];

    private function initialise_templates_for_replacement_from_scandir() {
        $templates_for_replacement = [];
        foreach ( $this->_sections as $section ) {
            $templates_for_replacement[ $section ] = [];
            foreach ( scandir( WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH . "{$section}/templates/for_replacement" ) as $file_name ) {
                if( ! in_array( $file_name, [ '.', '..' ] ) ) {
                    $templates_for_replacement[ $section ][] = $file_name; 
                }
            }
        }
        return $templates_for_replacement;
    }

    public function run() {
        $this->register_template_replacement_filter();
        $this->register_hooks();
    }


    private function register_template_replacement_filter() {
        require_once(  WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH . 'includes/class-template-replacement-manager.php' );

        $templates_for_replacement = $this->initialise_templates_for_replacement_from_scandir();

        $template_replacement_manager = new Web_Systems_Custom_Woocommerce_Checkout_Template_Replacement_Manager( $templates_for_replacement );

        add_filter( 'woocommerce_locate_template', [ $template_replacement_manager, 'replace_template' ], 20, 2 );
    }

    private function register_hooks() {
        require_once(  WEB_SYSTEMS_CUSTOM_WOOCOMMERCE_CHECKOUT_PLUGIN_DIR_PATH . 'includes/class-hook-manager.php' );

        $hook_manager = new Web_Systems_Custom_Woocommerce_Checkout_Hook_Manager();

        $hook_manager->run();
    }
}