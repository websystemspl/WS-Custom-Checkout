<?php
defined( 'ABSPATH' ) || exit;
class WSCCP_Checkout_Template_Replacement_Manager {
    private function get_templates_for_replacement_path( string $templates_for_replacement_section, string $template_for_replacement ): string {
        return WSCCP_DIR_PATH . "{$templates_for_replacement_section}/templates/for_replacement/{$template_for_replacement}";
    }

    private $_templates_for_replacement;
    private function get_templates_for_replacement(): array {
        return $this->_templates_for_replacement;
    }
    function __construct( array $templates_for_replacement ) {
        $this->_templates_for_replacement = $templates_for_replacement;
    }
    public function replace_template(string $template_file, string $template_name ) : string {
        $templates_for_replacement = $this->get_templates_for_replacement();
        foreach ( $templates_for_replacement as $templates_for_replacement_section_name => $templates_for_replacement_section ) {
            foreach ( $templates_for_replacement_section as $template_for_replacement ) {
                if( $template_name == "{$templates_for_replacement_section_name}/{$template_for_replacement}" ) {
                    $template_file = $this->get_templates_for_replacement_path( $templates_for_replacement_section_name, $template_for_replacement );
                    return $template_file;
                }
            }
        }

        return $template_file;
    }
}