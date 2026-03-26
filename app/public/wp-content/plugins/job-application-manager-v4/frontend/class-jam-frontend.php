<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class JAM_Frontend {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    public function enqueue_assets() {
        // Google Fonts
        wp_enqueue_style(
            'jam-fonts',
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@600;700;800&display=swap',
            [],
            null
        );

        wp_enqueue_style(
            'jam-frontend',
            JAM_PLUGIN_URL . 'assets/css/frontend.css',
            [ 'jam-fonts' ],
            JAM_VERSION
        );

        // Google reCAPTCHA v2
        if ( JAM_Settings::recaptcha_is_active() ) {
            wp_enqueue_script(
                'google-recaptcha',
                'https://www.google.com/recaptcha/api.js',
                [],
                null,
                true
            );
        }

        wp_enqueue_script(
            'jam-frontend',
            JAM_PLUGIN_URL . 'assets/js/frontend.js',
            [ 'jquery' ],
            JAM_VERSION,
            true
        );

        wp_localize_script( 'jam-frontend', 'JAM', [
            'ajaxurl'                    => admin_url( 'admin-ajax.php' ),
            'recaptcha_active'           => JAM_Settings::recaptcha_is_active() ? '1' : '0',
            'non_regulatory_positions'   => JAM_Settings::get_non_regulatory_positions(),
            'i18n'                       => [
                // Buttons
                'submitting'           => __( 'Submitting…', 'jam' ),
                'submit'               => __( 'Submit Application', 'jam' ),
                'error_generic'        => __( 'An error occurred. Please try again.', 'jam' ),
                // File upload
                'file_too_large'       => __( 'File exceeds the 10MB limit.', 'jam' ),
                'file_wrong_type'      => __( 'Only PDF files are allowed.', 'jam' ),
                'max_certs'            => __( 'You may upload a maximum of 5 certificates.', 'jam' ),
                // Consent & reCAPTCHA
                'consent_required'     => __( 'You must agree to the privacy & consent statement to submit your application.', 'jam' ),
                'recaptcha_required'   => __( 'Please complete the reCAPTCHA verification.', 'jam' ),
                // Form type labels (badge + title updates)
                'standard_form_label'  => __( 'Job Application Form', 'jam' ),
                'intern_form_label'    => __( 'Internship / Attachment Application Form', 'jam' ),
                'standard_subtitle'    => __( 'Please fill in all required fields and upload your documents as PDF files (max 10MB each).', 'jam' ),
                'intern_subtitle'      => __( 'Please complete all fields below for your internship or attachment application. Upload your documents as PDF files (max 10MB each).', 'jam' ),
            ],
        ] );
    }
}
