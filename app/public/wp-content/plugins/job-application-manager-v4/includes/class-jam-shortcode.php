<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class JAM_Shortcode {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode( 'job_application_form', [ $this, 'render_form' ] );
    }

    public function render_form( $atts ) {
        $atts = shortcode_atts( [
            'title' => __( 'Job Application Form', 'jam' ),
        ], $atts, 'job_application_form' );

        // Variables passed into the template
        $regulatory_bodies  = JAM_Post_Type::get_regulatory_bodies();
        $positions          = JAM_Settings::get_positions();
        $departments        = JAM_Settings::get_departments();
        $recaptcha_active   = JAM_Settings::recaptcha_is_active();
        $recaptcha_site_key = JAM_Settings::get_recaptcha_site_key();
        $nonce              = wp_create_nonce( 'jam_form_nonce' );

        ob_start();
        include JAM_PLUGIN_DIR . 'frontend/views/form.php';
        return ob_get_clean();
    }
}
