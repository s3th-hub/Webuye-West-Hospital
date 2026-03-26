<?php
class CSS_Generator {
	/**
     * scssc class instance
     *
     * @access protected
     * @var scssc
     */
    protected $scssc = null;
    protected $child_scssc = null;

    /**
     * Debug mode is turn on or not
     *
     * @access protected
     * @var boolean
     */
    protected $dev_mode = false;

    /**
     * opt_name of ReduxFramework
     *
     * @access protected
     * @var string
     */
    protected $opt_name = '';

	/**
	 * Constructor
	 */
	function __construct() {
		$this->opt_name = medcity_get_opt_name();

		if ( empty( $this->opt_name ) ) {
			return;
		}
		$this->dev_mode = medcity_get_opt( 'dev_mode', '0' ) === '1' ? true : false;
		add_filter( 'cms_scssc_on', function(){ return $this->dev_mode;} );
		add_filter( 'cms_scssc_lib', function(){ return 'new'; });
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 20 );
	}

	/**
	 * init hook - 10
	 */
	function init() {
		if ( !class_exists( '\ScssPhp\ScssPhp\Compiler' ) )
        {
            return;
        }

		add_action( 'wp', array( $this, 'generate_with_dev_mode' ) );
		add_action( "redux/options/{$this->opt_name}/saved", function () {
			$this->generate_file();
		} );
	}

	function generate_with_dev_mode() {
		if ( $this->dev_mode === true ) {
			$this->generate_file();
		}
	}

	/**
	 * Generate options and css files
	 */
	function generate_file() {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            $creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }

		$scss_dir = get_template_directory() . '/assets/scss/';
		$css_dir  = get_template_directory() . '/assets/css/';

		// Build CSS
		$this->scssc = new \ScssPhp\ScssPhp\Compiler();
		$this->scssc->setImportPaths( $scss_dir );
		// Optimize CSS
		$this->scssc->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);

		$_options = $scss_dir . 'variables.scss';

		$wp_filesystem->put_contents(
            $_options,
            preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->options_output() ),
           FS_CHMOD_FILE
        );

		$css_file = $css_dir . 'theme.css';
		$result = $this->scssc->compileString('@import "theme.scss";');
		$wp_filesystem->put_contents(
            $css_file,
            preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $result->getCss() ),
           FS_CHMOD_FILE
        );
	}

	/**
	 * Output options to _variables.scss
	 *
	 * @access protected
	 * @return string
	 */
	protected function options_output() {
		ob_start();
		$theme_colors = medcity_configs('theme_colors');
		foreach ($theme_colors as $key => $value) {
			printf('$%1$s_color: %2$s;', $key, 'var(--color-'.$key.')' );
		}
		$dark_light_color = medcity_get_opt( 'dark_light_color', '#26365e' );
		if ( ! medcity_is_valid_color( $dark_light_color ) ) {
			$dark_light_color = '#26365e';
		}
		printf( '$dark_light_color: %s;', esc_attr( $dark_light_color ) );

		$button_secondary_color = medcity_get_opt( 'button_secondary_color', '#213360' );
		if ( ! medcity_is_valid_color( $button_secondary_color ) ) {
			$button_secondary_color = '#213360';
		}
		printf( '$button_secondary_color: %s;', esc_attr( $button_secondary_color ) );

		/* Font */
		$body_default_font = medcity_get_opt( 'body_default_font', 'Default');
		printf ('$body_default_font:%1$s;', $body_default_font );
		// heading
		$heading_default_font = medcity_get_opt( 'heading_default_font', 'Quicksand' );
		printf ('$heading_default_font:%1$s;', $heading_default_font);
		
		/**
		 * Active Elementor device
		 * @since 1.1.1
		*/
		$medcity_active_devices = $this->medcity_active_devices();
		foreach ($medcity_active_devices as $key => $value) {
			echo '$max-'.$key.'-size:'.$value.'px;';
		}
		printf('%s', $this->medcity_enable_devices());

		return ob_get_clean();
	}

	/**
	 * Hooked wp_enqueue_scripts - 20
	 * Make sure that the handle is enqueued from earlier wp_enqueue_scripts hook.
	 */
	function enqueue() {
		$css = $this->inline_css();
		if ( ! empty( $css ) ) {
			wp_add_inline_style( 'medcity-theme', $this->dev_mode ? $css : medcity_css_minifier( $css ) );
		}
	}
	/**
	 * Get Elementor Active device
	 * @since 1.1.1
	 * @author Chinh Duong Manh
	 * 
	 * */
	protected function medcity_active_devices(){
        $medcity_active_devices = [];
        if(class_exists('\Elementor\Plugin')){
            $breakpoints = \Elementor\Plugin::$instance->breakpoints->get_breakpoints_config( [ 'reverse' => false ]);
            $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => false ] );
        } else {
            $breakpoints = [
                'mobile'       => ['value' => '767', 'is_enabled' => true],
                'tablet'       => ['value' => '1024', 'is_enabled' => true],
            ];
            $active_devices = ['mobile','tablet','desktop'];
        }
        foreach ($breakpoints as $key => $value) {
            if($value['is_enabled']){
                $key = str_replace('_', '-', $key);
                $medcity_active_devices[$key] = $value['value'];
            }
        }
        return $medcity_active_devices;
    }
    protected function medcity_enable_devices(){
        $medcity_enable_devices = [];
        if(class_exists('\Elementor\Plugin')){
            $breakpoints = \Elementor\Plugin::$instance->breakpoints->get_breakpoints_config( [ 'reverse' => false ]);
        } else {
            $breakpoints = [
				'mobile'       => ['value' => '767', 'is_enabled' => true],
				'mobile_extra' => ['value' => '880', 'is_enabled' => false],
				'tablet'       => ['value' => '1024', 'is_enabled' => true],
				'tablet_extra' => ['value' => '1200', 'is_enabled' => false],
				'laptop'       => ['value' => '1366', 'is_enabled' => false],
				'widescreen'   => ['value' => '2400', 'is_enabled' => false]
            ];
        }
        foreach ($breakpoints as $key => $value) {
            $key = str_replace('_', '-', $key);
            $is_enabled = $value['is_enabled'] ? 'true' : 'false';
            $medcity_enable_devices[] = '$enable-'.$key.':'.$is_enabled;
        }
        return implode(';',$medcity_enable_devices);
    }
	/**
	 * Generate inline css based on theme options
	 */
	protected function inline_css() {
		ob_start();
		/* Logo */
		$logo_maxh = medcity_get_opt( 'logo_maxh' );

		if ( ! empty( $logo_maxh['height'] ) && $logo_maxh['height'] != 'px' ) {
			printf( '#site-header-wrap .site-branding a img { max-height: %s; }', esc_attr( $logo_maxh['height'] ) );
		} ?>
		<?php $logo_maxh_sm = medcity_get_opt( 'logo_maxh_sm' );
		if ( ! empty( $logo_maxh_sm['height'] ) && $logo_maxh_sm['height'] != 'px' ) {
			printf( '#site-header-wrap .site-branding a.logo-mobile img { max-height: %s !important; }', esc_attr( $logo_maxh_sm['height'] ) );
		} ?>
		<?php /* Menu */
		$menu_text_transform = medcity_get_opt( 'menu_text_transform' );
		if ( ! empty( $menu_text_transform ) ) {
			printf( '.primary-menu > li > a { text-transform: %s !important; }', esc_attr( $menu_text_transform ) );
		}
		$menu_font_size = medcity_get_opt( 'menu_font_size' );
		if ( ! empty( $menu_font_size ) ) {
			printf( '.primary-menu > li > a { font-size: %s' . 'px !important; }', esc_attr( $menu_font_size ) );
		}
		$main_menu_color = medcity_get_opt( 'main_menu_color' );
		if ( ! empty( $main_menu_color['regular'] ) ) {
			printf( '.primary-menu > li > a { color: %s !important; }', esc_attr( $main_menu_color['regular'] ) );
		}
		if ( ! empty( $main_menu_color['hover'] ) ) {
			printf( '.primary-menu > li > a:hover { color: %s !important; }', esc_attr( $main_menu_color['hover'] ) );
		}
		if ( ! empty( $main_menu_color['active'] ) ) {
			printf( '.primary-menu > li.current_page_item > a, .primary-menu > li.current-menu-item > a, .primary-menu > li.current_page_ancestor > a, .primary-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr( $main_menu_color['active'] ) );
		}
		$sticky_menu_color = medcity_get_opt( 'sticky_menu_color' );
		if ( ! empty( $sticky_menu_color['regular'] ) ) {
			printf( '#site-header.h-fixed .primary-menu > li > a { color: %s !important; }', esc_attr( $sticky_menu_color['regular'] ) );
		}
		if ( ! empty( $sticky_menu_color['hover'] ) ) {
			printf( '#site-header.h-fixed .primary-menu > li > a:hover { color: %s !important; }', esc_attr( $sticky_menu_color['hover'] ) );
		}
		if ( ! empty( $sticky_menu_color['active'] ) ) {
			printf( '#site-header.h-fixed .primary-menu > li.current_page_item > a, #site-header.h-fixed .primary-menu > li.current-menu-item > a, #site-header.h-fixed .primary-menu > li.current_page_ancestor > a, #site-header.h-fixed .primary-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr( $sticky_menu_color['active'] ) );
		}

		/* Page Title */
		$ptitle_bg = medcity_get_page_opt( 'ptitle_bg' );
		$title_font_size = medcity_get_page_opt( 'title_font_size' );
		if ( ! empty( $ptitle_bg['background-image'] ) ) {
			echo 'body #pagetitle.page-title {
                background-image: url(' . esc_attr( $ptitle_bg['background-image'] ) . ');
            }';
		}

		if ( ! empty( $title_font_size ) ) {
			echo 'body #pagetitle .page-title, body #pagetitle.page-title-layout2 .page-title {
                font-size: ' . esc_attr( $title_font_size ) . 'px;
            }';
		}

		/* Content */
		$content_bg_color = medcity_get_page_opt( 'content_bg_color' );
		if ( ! empty( $content_bg_color['color'] ) ) {
			echo '#pagetitle svg path {
                fill: ' . esc_attr( $content_bg_color['color'] ) . ';
            }';
		}

		/* Footer */
		$footer_bg_color_top      = medcity_get_opt( 'footer_bg_color_top' );
		$footer_top_heading_color = medcity_get_opt( 'footer_top_heading_color' );
		$footer_top_heading_fs    = medcity_get_opt( 'footer_top_heading_fs' );
		$footer_top_heading_tt    = medcity_get_opt( 'footer_top_heading_tt' );
		if ( ! empty( $footer_bg_color_top ) ) {
			echo '.site-footer:before {
                background-color: ' . esc_attr( $footer_bg_color_top['rgba'] ) . ' !important;
            }';
		}
		if ( ! empty( $footer_top_heading_color ) ) {
			echo '.top-footer .footer-widget-title {
                color: ' . esc_attr( $footer_top_heading_color ) . ' !important;
            }';
		}
		if ( ! empty( $footer_top_heading_fs ) ) {
			echo '.top-footer .footer-widget-title {
                font-size: ' . esc_attr( $footer_top_heading_fs ) . 'px !important;
            }';
		}
		if ( ! empty( $footer_top_heading_tt ) ) {
			echo '.top-footer .footer-widget-title {
                text-transform: ' . esc_attr( $footer_top_heading_tt ) . ' !important;
            }';
		}
		/* Custom Css */
		$custom_css = medcity_get_opt( 'site_css' );
		if ( ! empty( $custom_css ) ) {
			echo esc_attr( $custom_css );
		}

		return ob_get_clean();
	}
}

new CSS_Generator();