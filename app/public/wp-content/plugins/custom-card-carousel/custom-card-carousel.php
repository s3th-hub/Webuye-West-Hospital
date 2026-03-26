<?php
/**
 * Plugin Name:       Custom Card Carousel Pro
 * Description:       Fully style-controlled card carousel for Elementor. Fonts, colours, spacing, buttons — all from the Elementor panel.
 * Version:           2.0.0
 * Author:            Seth
 * License:           GPL-2.0+
 * Text Domain:       custom-card-carousel
 * Requires at least: 5.8
 * Requires PHP:      7.4
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CCC_VERSION',    '2.0.0' );
define( 'CCC_DIR',        plugin_dir_path( __FILE__ ) );
define( 'CCC_URL',        plugin_dir_url( __FILE__ ) );

/* ── 1. Enqueue front-end assets ── */
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(  'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11' );
    wp_enqueue_script( 'swiper-js',  'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',  [], '11', true );
    wp_enqueue_style(  'ccc-style',  CCC_URL . 'assets/carousel.css', ['swiper-css'], CCC_VERSION );
    wp_enqueue_script( 'ccc-script', CCC_URL . 'assets/carousel.js',  ['swiper-js'],  CCC_VERSION, true );
} );

/* ── 2. Shortcode [card_carousel] ── */
add_shortcode( 'card_carousel', function ( $atts ) {
    $atts   = shortcode_atts( [ 'autoplay'=>'true','delay'=>'4000','loop'=>'true','speed'=>'550' ], $atts );
    $slides = ccc_get_slides();
    ob_start();
    include CCC_DIR . 'templates/carousel.php';
    return ob_get_clean();
} );

/* ── 3. Admin slides page ── */
add_action( 'admin_menu', function () {
    add_submenu_page( 'themes.php', 'Card Carousel', 'Card Carousel', 'manage_options', 'card-carousel-settings', 'ccc_settings_page' );
} );

function ccc_settings_page() {
    // Suppress any stray PHP notices/warnings from OTHER plugins polluting our page output
    $prev_error_reporting = error_reporting( E_ERROR | E_PARSE );

    if ( isset( $_POST['ccc_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ccc_nonce'] ) ), 'ccc_save' ) ) {
        $slides = [];
        $count  = isset( $_POST['ccc_slide_title'] ) ? count( $_POST['ccc_slide_title'] ) : 0;
        for ( $i = 0; $i < $count; $i++ ) {
            $slides[] = [
                'image'  => esc_url_raw( wp_unslash( $_POST['ccc_slide_image'][$i] ?? '' ) ),
                'badge'  => sanitize_text_field( wp_unslash( $_POST['ccc_slide_badge'][$i] ?? '' ) ),
                'title'  => sanitize_text_field( wp_unslash( $_POST['ccc_slide_title'][$i] ?? '' ) ),
                'desc'   => sanitize_textarea_field( wp_unslash( $_POST['ccc_slide_desc'][$i] ?? '' ) ),
                'btn'    => sanitize_text_field( wp_unslash( $_POST['ccc_slide_btn'][$i] ?? 'Read More' ) ),
                'url'    => esc_url_raw( wp_unslash( $_POST['ccc_slide_url'][$i] ?? '#' ) ),
            ];
        }
        update_option( 'ccc_slides', $slides );
        echo '<div class="notice notice-success is-dismissible"><p><strong>✅ Slides saved successfully!</strong></p></div>';
    }

    $slides = ccc_get_slides();

    // Restore original error reporting after our page finishes
    error_reporting( $prev_error_reporting );

    include CCC_DIR . 'templates/admin.php';
}

/* ── 4. Slides helper ── */
function ccc_get_slides() {
    $saved = get_option( 'ccc_slides', [] );

    if ( ! empty( $saved ) && is_array( $saved ) ) {
        // Normalise every slide so ALL keys always exist regardless of which
        // plugin version saved the data (v1 used 'description', v2 uses 'desc', etc.)
        return array_map( 'ccc_normalise_slide', $saved );
    }

    return [
        [ 'image'=>'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&q=80', 'badge'=>'Pharmacy',   'title'=>'Pharmacy Services',      'desc'=>'Safe, high-quality and affordable pharmaceutical services to support your treatment and recovery journey.',            'btn'=>'Read More',  'url'=>'#' ],
        [ 'image'=>'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=600&q=80', 'badge'=>'Lab',        'title'=>'Laboratory Services',    'desc'=>'Reliable, timely and accurate diagnostic testing to support clinical decision-making and disease detection.',          'btn'=>'Read More',  'url'=>'#' ],
        [ 'image'=>'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=600&q=80', 'badge'=>'Emergency',  'title'=>'Emergency Care',         'desc'=>'Round-the-clock emergency medical services with rapid response teams ready to handle any critical situation.',         'btn'=>'Learn More', 'url'=>'#' ],
        [ 'image'=>'https://images.unsplash.com/photo-1559757175-5700dde675bc?w=600&q=80',    'badge'=>'Outpatient', 'title'=>'Outpatient Clinic',      'desc'=>'Comprehensive outpatient consultations across multiple specialties with experienced medical professionals.',           'btn'=>'Learn More', 'url'=>'#' ],
        [ 'image'=>'https://images.unsplash.com/photo-1581595219315-a187dd40c322?w=600&q=80', 'badge'=>'Surgery',    'title'=>'Surgical Services',      'desc'=>'State-of-the-art surgical facilities and highly skilled surgeons for both elective and emergency procedures.',         'btn'=>'Learn More', 'url'=>'#' ],
    ];
}

/**
 * Normalise a single slide array so every expected key is always present.
 * Handles legacy keys from v1 of the plugin.
 */
function ccc_normalise_slide( $s ) {
    if ( ! is_array( $s ) ) return ccc_empty_slide();

    return [
        // 'image' was always 'image'
        'image' => isset( $s['image'] ) ? esc_url_raw( $s['image'] ) : '',

        // 'badge' was always 'badge'
        'badge' => isset( $s['badge'] ) ? sanitize_text_field( $s['badge'] ) : '',

        // 'title' was always 'title'
        'title' => isset( $s['title'] ) ? sanitize_text_field( $s['title'] ) : '',

        // v1 used 'description', v2 uses 'desc' — support both
        'desc'  => isset( $s['desc'] )
                    ? sanitize_textarea_field( $s['desc'] )
                    : ( isset( $s['description'] ) ? sanitize_textarea_field( $s['description'] ) : '' ),

        // v1 used 'btn_text', v2 uses 'btn' — support both
        'btn'   => isset( $s['btn'] )
                    ? sanitize_text_field( $s['btn'] )
                    : ( isset( $s['btn_text'] ) ? sanitize_text_field( $s['btn_text'] ) : 'Read More' ),

        // v1 used 'btn_url', v2 uses 'url' — support both
        'url'   => isset( $s['url'] )
                    ? esc_url_raw( $s['url'] )
                    : ( isset( $s['btn_url'] ) ? esc_url_raw( $s['btn_url'] ) : '#' ),
    ];
}

function ccc_empty_slide() {
    return [ 'image'=>'', 'badge'=>'', 'title'=>'', 'desc'=>'', 'btn'=>'Read More', 'url'=>'#' ];
}

/* ── 5. Register Elementor widget ── */
add_action( 'elementor/widgets/register', function ( $manager ) {
    if ( ! did_action( 'elementor/loaded' ) ) return;
    require_once CCC_DIR . 'elementor/widget.php';
    $manager->register( new \CCC_Elementor_Widget() );
} );

/* ── 6. Activation + migration ── */
register_activation_hook( __FILE__, function () {
    ccc_migrate_legacy_data();
    flush_rewrite_rules();
} );

/* Migrate on every admin load in case plugin was updated without reactivating */
add_action( 'admin_init', 'ccc_migrate_legacy_data' );

function ccc_migrate_legacy_data() {
    if ( get_option( 'ccc_data_version' ) === CCC_VERSION ) return;
    $saved = get_option( 'ccc_slides', [] );
    if ( ! empty( $saved ) && is_array( $saved ) ) {
        update_option( 'ccc_slides', array_map( 'ccc_normalise_slide', $saved ) );
    }
    update_option( 'ccc_data_version', CCC_VERSION );
}
