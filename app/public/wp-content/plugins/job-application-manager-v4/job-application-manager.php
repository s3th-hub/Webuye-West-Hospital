<?php
/**
 * Plugin Name: Job Application Manager
 * Plugin URI:  https://example.com/job-application-manager
 * Description: A complete frontend job application form system with backend management, email notifications, and Elementor compatibility.
 * Version:     1.0.0
 * Author:      Your Name
 * Text Domain: jam
 * License:     GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Constants ────────────────────────────────────────────────────────────────
define( 'JAM_VERSION',     '1.0.0' );
define( 'JAM_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'JAM_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'JAM_PLUGIN_FILE', __FILE__ );

// ── Autoload core files ───────────────────────────────────────────────────────
require_once JAM_PLUGIN_DIR . 'includes/class-jam-post-type.php';
require_once JAM_PLUGIN_DIR . 'includes/class-jam-form-handler.php';
require_once JAM_PLUGIN_DIR . 'includes/class-jam-email.php';
require_once JAM_PLUGIN_DIR . 'includes/class-jam-shortcode.php';
require_once JAM_PLUGIN_DIR . 'includes/class-jam-export.php';
require_once JAM_PLUGIN_DIR . 'admin/class-jam-admin.php';
require_once JAM_PLUGIN_DIR . 'admin/class-jam-settings.php';
require_once JAM_PLUGIN_DIR . 'frontend/class-jam-frontend.php';

// ── Bootstrap ────────────────────────────────────────────────────────────────
function jam_init() {
    JAM_Post_Type::instance();
    JAM_Form_Handler::instance();
    JAM_Shortcode::instance();
    JAM_Export::instance();
    JAM_Admin::instance();
    JAM_Settings::instance();
    JAM_Frontend::instance();
}
add_action( 'plugins_loaded', 'jam_init' );

// ── Activation / Deactivation ────────────────────────────────────────────────
register_activation_hook( __FILE__, 'jam_activate' );
function jam_activate() {
    JAM_Post_Type::register_post_type();
    flush_rewrite_rules();
    // Default settings
    if ( ! get_option( 'jam_settings' ) ) {
        update_option( 'jam_settings', [
            'admin_email'    => get_option( 'admin_email' ),
            'admin_subject'  => 'New Job Application Received',
            'confirm_subject'=> 'Your Application Has Been Received',
        ] );
    }
}

register_deactivation_hook( __FILE__, 'jam_deactivate' );
function jam_deactivate() {
    flush_rewrite_rules();
}
