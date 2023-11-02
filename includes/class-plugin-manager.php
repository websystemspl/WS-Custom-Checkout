<?php
defined('ABSPATH') || exit;
class WSCCP_Plugin_Manager
{
    private $_sections = ['checkout'];

    private function initialise_templates_for_replacement_from_scandir()
    {
        $templates_for_replacement = [];
        foreach ($this->_sections as $section) {
            $templates_for_replacement[$section] = [];
            foreach (scandir(WSCCP_DIR_PATH . "{$section}/templates/for_replacement") as $file_name) {
                if (!in_array($file_name, ['.', '..'])) {
                    $templates_for_replacement[$section][] = $file_name;
                }
            }
        }
        return $templates_for_replacement;
    }

    public function run()
    {
        $this->register_template_replacement_filter();
        $this->register_hooks();
        $this->checkoutPageSetting();
    }


    private function register_template_replacement_filter()
    {
        require_once(WSCCP_DIR_PATH . 'includes/class-template-replacement-manager.php');

        $templates_for_replacement = $this->initialise_templates_for_replacement_from_scandir();

        $template_replacement_manager = new WSCCP_Checkout_Template_Replacement_Manager($templates_for_replacement);

        add_filter('woocommerce_locate_template', [$template_replacement_manager, 'replace_template'], 20, 2);
    }

    private function register_hooks()
    {
        require_once(WSCCP_DIR_PATH . 'includes/class-hook-manager.php');

        $hook_manager = new WSCCP_Checkout_Hook_Manager();

        $hook_manager->run();
    }

    private function checkoutPageSetting()
    {
        require_once(WSCCP_DIR_PATH . 'includes/class-checkout-page-settings.php');
        $checkout_page_settings = new WSCCP_Page_Settings();
        $checkout_page_settings->run();
    }
}
