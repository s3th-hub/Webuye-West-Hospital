<?php
if ( ! class_exists( 'ReduxFrameworkInstances' ) ) {
	return;
}

class meddox_CSS_Generator {
	/**
     * @access protected
     * @var scssc
     */
    protected $scssc = null;

    /**
     * ReduxFramework class instance
     *
     * @access protected
     * @var ReduxFramework
     */
    protected $redux = null;

    /**
     * Debug mode is turn on or not
     *
     * @access protected
     * @var boolean
     */
    protected $dev_mode = true;

    /**
     * opt_name of ReduxFramework
     *
     * @access protected
     * @var string
     */
    protected $opt_name = '';

	function __construct() {
		$this->opt_name = meddox()->get_option_name();  
		if ( empty( $this->opt_name ) ) {
			return;
		}
		$this->dev_mode = (defined('THEME_DEV_MODE_SCSS') && THEME_DEV_MODE_SCSS);  
 
		add_filter( 'pxl_scssc_on', '__return_true' );
		add_action( 'init', array( $this, 'init' ) );
	}

	function init() {

		if ( ! class_exists( 'scssc' ) ) {
			return;
		}

		$this->redux = ReduxFrameworkInstances::get_instance( $this->opt_name );

		if ( empty( $this->redux ) || ! $this->redux instanceof ReduxFramework ) {
			return;
		}
		add_action( 'wp', array( $this, 'meddox_generate_with_dev_mode' ) );
		add_action( "redux/options/{$this->opt_name}/saved", function () {
			$this->meddox_generate_file_options();
		} );
	}

	function meddox_generate_with_dev_mode() {
		if ( $this->dev_mode === true ) {
            $this->meddox_generate_file_options();
			$this->meddox_generate_file();
		}
	}

    function meddox_generate_file_options() {
        $scss_dir = get_template_directory() . '/assets/scss/';
        $this->scssc = new scssc();
        $this->scssc->setImportPaths( $scss_dir );
        $_options = $scss_dir . '_options.scss';
        $this->scssc->setFormatter( 'scss_formatter' );
        $this->redux->filesystem->execute( 'put_contents', $_options, array(
            'content' => preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->meddox_options_output() )
        ) );
    }

	function meddox_generate_file() {
		$scss_dir = get_template_directory() . '/assets/scss/';
		$css_dir  = get_template_directory() . '/assets/css/';

		$this->scssc = new scssc();
		$this->scssc->setImportPaths( $scss_dir );

		$css_file = $css_dir . 'style.css';

		$this->scssc->setFormatter( 'scss_formatter' );
		$this->redux->filesystem->execute( 'put_contents', $css_file, array(
			'content' => preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->scssc->compile( '@import "style.scss"' ) )
		) );
	}

	protected function print_scss_opt_colors($variable,$param){
        if(is_array($variable)){
            $k = [];
            $v = [];
            foreach ($variable as $key => $value) {
                $k[] = str_replace('-', '_', $key);
                $v[] = 'var(--'.str_replace(['#',' '], [''],$key).'-color)';
            }
            if($param === 'key'){
                return implode(',', $k);
            }else{
                return implode(',', $v);
            }
            
        } else {
            return $variable;
        }
    }

	protected function meddox_options_output() {
		$theme_colors                    = meddox_configs('theme_colors');
        $links                           = meddox_configs('link');
        $gradients                           = meddox_configs('gradient');
		ob_start();

		printf('$meddox_theme_colors_key:(%s);',$this->print_scss_opt_colors($theme_colors,'key'));
        printf('$meddox_theme_colors_val:(%s);',$this->print_scss_opt_colors($theme_colors,'val'));
        // color rgb only
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color_hex: %2$s;', str_replace('-', '_', $key), $value['value']); 
        }
        // color
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color: %2$s;', str_replace('-', '_', $key), 'var(--'.str_replace(['#',' '], [''],$key).'-color)' );
        }

        // color rgb only
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color_hex: %2$s;', str_replace('-', '_', $key), $value['value']); 
        }
        // color
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color: %2$s;', str_replace('-', '_', $key), 'var(--'.str_replace(['#',' '], [''],$key).'-color)' );
        }
         
        // link color
        foreach ($links as $key => $value) {
            printf('$link_%1$s: %2$s;', str_replace('-', '_', $key), 'var(--link-'.$key.')');
        }

        // gradient color
        foreach ($gradients as $key => $value) {
            printf('$gradient_%1$s: %2$s;', str_replace('-', '_', $key), 'var(--gradient-'.$key.')');
        }

        // gradient color hex
        /* Gradient Color Main */
        $gradient_color_hex = meddox()->get_opt( 'gradient_color' );
        if ( !empty($gradient_color_hex['from']) && isset($gradient_color_hex['from']) ) {
            printf( '$gradient_from_hex: %s;', esc_attr( $gradient_color_hex['from'] ) );
        } else {
            echo '$gradient_from_hex: #8d4cfa;';
        }
        if ( !empty($gradient_color_hex['to']) && isset($gradient_color_hex['to']) ) {
            printf( '$gradient_to_hex: %s;', esc_attr( $gradient_color_hex['to'] ) );
        } else {
            echo '$gradient_to_hex: #5f6ffb;';
        }

        /* Font */
        $theme_default = meddox()->get_theme_opt('theme_default');
        if($theme_default['font-family'] == false) {
            echo '
                $ft_theme_default: "Rajdhani";
            ';
        } else {
            echo '
                $ft_theme_google: '.$theme_default["font-family"].';
            ';
        }
  
		return ob_get_clean();
	}

}

new meddox_CSS_Generator();