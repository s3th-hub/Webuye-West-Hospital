<?php
/**
 * Functions and definitions
 *
 * @package Medcity
 */

if ( ! function_exists( 'medcity_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function medcity_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'medcity', get_template_directory() . '/languages' );

		// Custom Header
		add_theme_support( "custom-header" );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'medcity' ),
			'footer-bottom' => esc_html__( 'Footer Bottom', 'medcity' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'medcity_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core custom logo.
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		add_theme_support( 'post-formats', array(
			'gallery',
			'video',
		) );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails');

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
        /* Add theme image size */
        add_image_size( 'medcity-medium', 768, 768, true );
        // For WP 5.8
        remove_theme_support('widgets-block-editor');
	}
endif;
add_action( 'after_setup_theme', 'medcity_setup' );

add_action( 'cms_locations', function ( $cms_locations ) {
	return $cms_locations;
} );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 */
function medcity_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'medcity_content_width', 640 );
}

add_action( 'after_setup_theme', 'medcity_content_width', 0 );

/**
 * Register widget area.
 */
function medcity_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'medcity' ),
		'id'            => 'sidebar-blog',
		'description'   => esc_html__( 'Add widgets here.', 'medcity' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	if (class_exists('ReduxFramework')) {
		register_sidebar( array(
			'name'          => esc_html__( 'Page Sidebar', 'medcity' ),
			'id'            => 'sidebar-page',
			'description'   => esc_html__( 'Add widgets here.', 'medcity' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

	if ( class_exists( 'Woocommerce' ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Shop Sidebar', 'medcity' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Add widgets here.', 'medcity' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

    if (class_exists('ReduxFramework')) {
        register_sidebar( array(
            'name'          => esc_html__( 'Emergency Sidebar', 'medcity' ),
            'id'            => 'sidebar-emergency',
            'description'   => esc_html__( 'Add widgets here to show in header.', 'medcity' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-content">',
            'after_widget'  => '</div></section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }
}

add_action( 'widgets_init', 'medcity_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function medcity_scripts() {
	$theme = wp_get_theme( get_template() );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.0.0' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style('font-awesome5', get_template_directory_uri() . '/assets/css/font-awesome5.min.css', array(), '5.8.0' );
    wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/assets/css/flaticon.css', array(), $theme->get( 'Version' )  );
	wp_enqueue_style( 'material-design-iconic-font', get_template_directory_uri() . '/assets/css/material-design-iconic-font.min.css', array(), '2.2.0' );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '1.0.0' );
	wp_enqueue_style( 'medcity-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), $theme->get( 'Version' ) );
    wp_add_inline_style( 'medcity-theme', medcity_inline_styles() );
	wp_enqueue_style( 'medcity-google-fonts', medcity_fonts_url() );

	/* Lib JS */
    wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/assets/js/jquery.cookie.js', array( 'jquery' ), '1.4.1', true);
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '4.0.0', true );
    wp_enqueue_script( 'nice-select', get_template_directory_uri() . '/assets/js/nice-select.min.js', array( 'jquery' ), 'all', true );
    wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/magnific-popup.min.js', array( 'jquery' ), '1.0.0', true );

    /* Theme JS */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'medcity-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), $theme->get( 'Version' ), true );
    wp_register_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '2.2.1', true);
	wp_register_script( 'medcity-carousel', get_template_directory_uri() . '/assets/js/cms-carousel-owl.js', array( 'jquery' ), $theme->get( 'Version' ), true );
	wp_enqueue_script( 'medcity-woocommerce', get_template_directory_uri() . '/woocommerce/woocommerce.js', array( 'jquery' ), $theme->get( 'Version' ), true );
	wp_localize_script( 'medcity-main', 'main_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

    /*
     * Elementor Widget JS
     */
    // Counter Widget
    wp_register_script( 'cms-counter-widget-js', get_template_directory_uri() . '/elementor/js/cms-counter-widget.js', [ 'jquery' ], $theme->get( 'Version' ) );
    // Progress Bar Widget
    wp_register_script( 'cms-progressbar-widget-js', get_template_directory_uri() . '/elementor/js/cms-progressbar-widget.js', [ 'jquery' ], $theme->get( 'Version' ) );
    // Clients List Widget
    wp_register_script( 'cms-clients-list-widget-js', get_template_directory_uri() . '/elementor/js/cms-clients-list-widget.js', [ 'jquery' ], $theme->get( 'Version' ) );
    // CMS Post Carousel Widget
    wp_register_script( 'cms-post-carousel-widget-js', get_template_directory_uri() . '/elementor/js/cms-post-carousel-widget.js', [ 'jquery' ], $theme->get( 'Version' ) );
    // CMS Image Carousel Widget
    wp_register_script( 'cms-image-carousel-widget-js', get_template_directory_uri() . '/elementor/js/cms-image-carousel-widget.js', [ 'jquery' ], $theme->get( 'Version' ) );
    wp_register_script('cms-post-grid-widget-js', get_template_directory_uri() . '/elementor/js/cms-post-grid-widget.js', [ 'isotope', 'jquery' ], $theme->get( 'Version' ), true);
    wp_register_script('cms-toggle-widget-js', get_template_directory_uri() . '/elementor/js/cms-toggle-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true);
    wp_register_script('cms-accordion-widget-js', get_template_directory_uri() . '/elementor/js/cms-accordion-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true);
    wp_register_script('cms-tabs-widget-js', get_template_directory_uri() . '/elementor/js/cms-tabs-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true);
    /**
	 * @since 1.1.1
    **/
    wp_enqueue_style( 'medcity-icon', get_template_directory_uri() . '/assets/fonts/medcity/style.css', array(), '1.1.1' );
    wp_register_script('cms-swiper', get_template_directory_uri() . '/elementor/js/cms-swiper.js', [ 'jquery' ], $theme->get( 'Version' ), true);
}

add_action( 'wp_enqueue_scripts', 'medcity_scripts' );

/* add editor styles */
function medcity_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}

add_action( 'admin_init', 'medcity_add_editor_styles' );

/* add admin styles */
function medcity_admin_style() {
	$theme = wp_get_theme( get_template() );
	wp_enqueue_style( 'medcity-admin-style', get_template_directory_uri() . '/assets/css/admin.css' );
	wp_enqueue_style( 'font-material-icon', get_template_directory_uri() . '/assets/css/material-design-iconic-font.min.css', array(), '2.2.0' );
    wp_enqueue_script('medcity-main-admin', get_template_directory_uri() . '/assets/js/main-admin.js', array( 'jquery' ), $theme->get('Version'), true);
}

add_action( 'admin_enqueue_scripts', 'medcity_admin_style' );

/**
 * Helper functions for this theme.
 */
require_once get_template_directory() . '/inc/theme-configs/theme-configs.php';

/**
 * Helper functions for this theme.
 */
require_once get_template_directory() . '/inc/template-functions.php';

/**
 * Theme options
 */
require_once get_template_directory() . '/inc/theme-options.php';

/**
 * Page options
 */
require_once get_template_directory() . '/inc/page-options.php';

/**
 * CSS Generator.
 */
if ( ! class_exists( 'CSS_Generator' ) ) {
	require_once get_template_directory() . '/inc/classes/class-css-generator.php';
}

/**
 * Breadcrumb.
 */
require_once get_template_directory() . '/inc/classes/class-breadcrumb.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/* Load list require plugins */
require_once( get_template_directory() . '/inc/require-plugins.php' );

/* Load lib Font */
require_once get_template_directory() . '/inc/libs/fontawesome.php';
require_once get_template_directory() . '/inc/libs/materialdesign.php';


/**
 * Additional widgets for the theme
 */
require_once get_template_directory() . '/widgets/widget-recent-posts.php';
require_once get_template_directory() . '/widgets/widget-social.php';
require_once get_template_directory() . '/widgets/widget-contact-box.php';
require_once get_template_directory() . '/widgets/class.widget-extends.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/extends.php';


if ( ! function_exists( 'medcity_fonts_url' ) ) :
	/**
	 * Register Google fonts.
	 *
	 * Create your own medcity_fonts_url() function to override in a child theme.
	 *
	 * @since league 1.1
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function medcity_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		if ( 'off' !== _x( 'on', 'Quicksand font: on or off', 'medcity' ) ) {
            $fonts[] = 'Quicksand:300,400,500,600,700';
		}
		
		if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'medcity' ) ) {
			$fonts[] = 'Roboto:300,400,400i,500,500i,600,600i,700,700i';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;

/* Favicon */
function medcity_site_favicon(){
    
    $favicon = medcity_get_opt( 'favicon' );
    
    if(!empty($favicon['url']))
        echo '<link rel="icon" type="image/png" href="'.esc_url($favicon['url']).'"/>';
}
add_action('wp_head', 'medcity_site_favicon');

/**
 * Add Template Woocommerce
 */
if(class_exists('Woocommerce')){
    require_once( get_template_directory() . '/woocommerce/wc-function-hooks.php' );
}

/**
 * Get Started
 * @since 1.1.1
 * @author Chinh Duong Manh
 */
require_once get_template_directory() . '/inc/get-started.php';
/**
 * Add admin styles 
 * @since 1.1.1
 * @author Chinh Duong Manh
 * */
function medcity_live_update() {
	$theme = wp_get_theme( get_template() );
	// import demo
	wp_enqueue_style( 'medcity-get-started-css', get_template_directory_uri() . '/assets/admin/get-started.css' );
	wp_enqueue_script( 'medcity-get-started-js', get_template_directory_uri() . '/assets/admin/get-started.js', [ 'jquery' ], $theme->get( 'Version' ), true );
	wp_localize_script( 'medcity-get-started-js', 'main_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'admin_enqueue_scripts', 'medcity_live_update' );

/**
 * Extra Elementor Icons
 */
require_once get_template_directory() . '/assets/fonts/medcity/font-medcity.php';
/**
 * Custom Elementor Editor
 * @since 1.1.1
 * @author Chinh Duong Manh
 * */
add_action( 'elementor/editor/before_enqueue_scripts', function() {
    wp_enqueue_style( 'medcity-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-panel.css', array(), '1.0.0' );
});
add_action('elementor/preview/enqueue_styles',  function() {
	wp_enqueue_style( 'medcity-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-panel.css', array(), '1.0.0' );
    wp_enqueue_style( 'medcity-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-preview.css', array(), '1.0.0' );
});
/**
 * Custom Font
 * get custom heading font for page only
 * @since 1.1.1
 * @author Chinh Duong Manh
 * **/
add_action('wp_footer','medcity_custom_font');
function medcity_custom_font(){
    $heading_custom_font = medcity_get_page_opt( 'font_heading', ['font-family'=>''] );
    if($heading_custom_font == ''){
        $heading_custom_font = ['font-family' => ''];
    }
	if($heading_custom_font['font-family'] !== '') {
        $heading_font = str_replace(' ', '+', $heading_custom_font['font-family']);
?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php /* ?><link href="https://fonts.googleapis.com/css2?family=<?php echo esc_attr($heading_font);?>:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet"><?php */?>
	<link href="https://fonts.googleapis.com/css2?family=<?php echo esc_attr($heading_font);?>:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<?php
	}
}
/**
 * ================================================
 * All function for Demo Data
 * 
 * @package CMS Theme
 * @subpackage Medcity
 * @since 1.1.1
 * @author Chinh Duong Manh
 * ================================================
 * 
*/
/**
 * Get option based on its id.
 * get option of theme and page
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 * @return mixed
 */
function medcity_get_opts($opt_id, $default = false, $dependency = ''){
    $theme_opt = medcity_get_opt($opt_id, $default);
    $_dependency = medcity_get_page_opt($dependency);
    if($dependency === 'on' || $_dependency === 'on'){
        $page_opt = medcity_get_page_opt($opt_id, $theme_opt);
        if ($page_opt !== null && $page_opt !== '' && $page_opt !== '-1' && $page_opt !== '0') {
            if (is_array($page_opt) && is_array($theme_opt)) {
                foreach ($page_opt as $key => $value) {
                    foreach ($theme_opt as $key => $value) {
                        if (empty($page_opt[$key]) || $page_opt[$key] === 'px') {
                            $page_opt[$key] = $theme_opt[$key];
                        }
                    }
                }
            }
            $theme_opt = $page_opt;
        }
    }
    return $theme_opt;
}

/* Create Demo Data */
if(!function_exists('medcity_enable_export_mode')){
    function medcity_enable_export_mode() {
        return defined('DEV_MODE') && DEV_MODE == true ? true : false;
    }
}
add_filter('swa_ie_export_mode', 'medcity_enable_export_mode');
if (!function_exists('medcity_cpt_dev_mode')) {
    function medcity_cpt_dev_mode()
    {
        return defined('DEV_MODE') && DEV_MODE == true ? true : false;
    }
}
add_filter('cpt_dev_mode', 'medcity_cpt_dev_mode');
/**
 * Update custom post type edit with Elementor
 * @since 1.1.1
 * @author Chinh Duong Manh
 * **/
add_action('theme_core_ie_after_import', 'medcity_elementor_cpts');
add_action('after_switch_theme', 'medcity_elementor_cpts');
if (!function_exists('medcity_elementor_cpts')) {
    function medcity_elementor_cpts(){
        $default = (array)get_option('elementor_cpt_support');
        $cpt_support = array_merge(
            $default, 
            [
                //core
                'post',
                'page',
                'footer',
                // theme
                'service',
                'doctor',
                'department'
            ]
        );
        update_option( 'elementor_cpt_support', $cpt_support );
    }
}
/**
 * Update Option TranslatePress
 * @since 1.1.1
 * @author Chinh Duong Manh
 * */
add_action('plugins_loaded', 'medcity_translatepress_configs');
add_action('activate_translatepress-multilingual/index.php', 'medcity_translatepress_configs');
add_action('theme_core_ie_after_import', 'medcity_translatepress_configs');
if(!function_exists('medcity_translatepress_configs')){
    function medcity_translatepress_configs(){
        $trp_settings = (array)get_option('trp_settings');
        $trp_settings['trp-ls-floater'] = 'no'; // Hide Floating language selection
        $trp_settings['trp-ls-show-poweredby'] = 'no'; // Hide "Powered by TranslatePress"
        update_option( 'trp_settings', $trp_settings );
    }
}
/**
 * Dashboard Configurations
 * @since 1.1.1
 * @author Chinh Duong Manh
 */
if (!function_exists('medcity_cms_cpt_dashboard_config')) {
    function medcity_cms_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://cmssuperheroes.gitbook.io/medcity-wordpress-theme/',
            'ticket_link'         => 'https://cmssuperheroes.ticksy.com/',
            'video_tutorial_link' => 'https://www.youtube.com/c/CMSSuperheroes',
            'demo_link'           => 'http://demo.cmssuperheroes.com/themeforest/medcity/',
        ];
    }
}
if (!function_exists('medcity_7oroof_cpt_dashboard_config')) {
    function medcity_7oroof_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://7oroof-themes.gitbook.io/medcity-wordpress-theme/',
            'ticket_link'         => 'https://7oroof.com/support/',
            'video_tutorial_link' => 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg',
            'demo_link'           => 'https://7oroof.com/tfdemos/medcity/',
        ];
    }
}
if (!function_exists('medcity_farost_cpt_dashboard_config')) {
    function medcity_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://farost.gitbook.io/medcity-wordpress-theme',
            'ticket_link'         => 'mailto:farost.agency@gmail.com',
            'video_tutorial_link' => 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg',
            'demo_link'           => 'http://demo.farost.net/medcity',
        ];
    }
}
add_filter('cpt_dashboard_config', 'medcity_7oroof_cpt_dashboard_config');
add_filter('cms_documentation_link', function(){ return 'https://doc.7oroof.com/medcity/index.html';});
add_filter('cms_ticket_link', function(){ return ['type' => 'url', 'link' => 'https://7oroof.com/support/'];});
add_filter('cms_video_tutorial_link', function(){ return 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg';});
/**
 * =========================
 * End Demo Data
 * =========================
 * */

/**
 * Check if is build with Elementor
 * @since 1.1.3
 * **/
if(!function_exists('medcity_is_built_with_elementor')){
    function medcity_is_built_with_elementor(){
        if ( class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get( get_the_ID() )->is_built_with_elementor() ) {
            return true;
        } else {
            return false;
        }
    }
}