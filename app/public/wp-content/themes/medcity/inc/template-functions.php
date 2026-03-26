<?php
/**
 * Helper functions for the theme
 *
 * @package Medcity
 */

/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function medcity_get_opt( $opt_id, $default = false ) {
	$opt_name = medcity_get_opt_name();
	if ( empty( $opt_name ) ) {
		return $default;
	}

	global ${$opt_name};
	if ( ! isset( ${$opt_name} ) || ! isset( ${$opt_name}[ $opt_id ] ) ) {
		$options = get_option( $opt_name );
	} else {
		$options = ${$opt_name};
	}
	if ( ! isset( $options ) || ! isset( $options[ $opt_id ] ) || $options[ $opt_id ] === '' ) {
		return $default;
	}
	if ( is_array( $options[ $opt_id ] ) && is_array( $default ) ) {
		foreach ( $options[ $opt_id ] as $key => $value ) {
			if ( isset( $default[ $key ] ) && $value === '' ) {
				$options[ $opt_id ][ $key ] = $default[ $key ];
			}
		}
	}

	return $options[ $opt_id ];
}

/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function medcity_get_page_opt( $opt_id, $default = false ) {
	$page_opt_name = medcity_get_page_opt_name();
	if ( empty( $page_opt_name ) ) {
		return $default;
	}
	$id = get_the_ID();
	if ( ! is_archive() && is_home() ) {
		if ( ! is_front_page() ) {
			$page_for_posts = get_option( 'page_for_posts' );
			$id             = $page_for_posts;
		}
	}

	// Get page option for Shop Page
    if(class_exists('WooCommerce') && is_shop()){
        $id = get_option( 'woocommerce_shop_page_id' );
    }

	return $options = ! empty($id) ? get_post_meta( intval( $id ), $opt_id, true ) : $default;
}

/**
 *
 * Get post format values.
 *
 * @param $post_format_key
 * @param bool $default
 *
 * @return bool|mixed
 */
function medcity_get_post_format_value( $post_format_key, $default = false ) {
	global $post;

	return $value = ! empty( $post->ID ) ? get_post_meta( $post->ID, $post_format_key, true ) : $default;
}


/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function medcity_get_opt_name() {
	return apply_filters( 'medcity_opt_name', 'cms_theme_options' );
}

/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function medcity_get_page_opt_name() {
	return apply_filters( 'medcity_page_opt_name', 'cms_page_options' );
}

/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function medcity_get_post_opt_name() {
	return apply_filters( 'medcity_post_opt_name', 'medcity_post_options' );
}

/**
 * Get page title and description.
 *
 * @return array Contains 'title'
 */
function medcity_get_page_titles() {
	$title = '';

	// Default titles
	if ( ! is_archive() ) {
		// Posts page view
		if ( is_home() ) {
			// Only available if posts page is set.
			if ( ! is_front_page() && $page_for_posts = get_option( 'page_for_posts' ) ) {
				$title = get_post_meta( $page_for_posts, 'custom_title', true );
				if ( empty( $title ) ) {
					$title = get_the_title( $page_for_posts );
				}
			}
			if ( is_front_page() ) {
				$title = esc_html__( 'Blog', 'medcity' );
			}
		} // Single page view
        elseif ( is_page() ) {
			$title = get_post_meta( get_the_ID(), 'custom_title', true );
			if ( ! $title ) {
				$title = get_the_title();
			}
		} elseif ( is_404() ) {
			$title = esc_html__( '404', 'medcity' );
		} elseif ( is_search() ) {
			$title = esc_html__( 'Search results', 'medcity' );
		} else {
			$title = get_post_meta( get_the_ID(), 'custom_title', true );
			if ( ! $title ) {
				$title = get_the_title();
			}
		}
	} elseif ( is_author() ) {
		$title = esc_html__( 'Author:', 'medcity' ) . ' ' . get_the_author();
	} // Author
	else {
		$title = get_the_archive_title();
		if( (class_exists( 'WooCommerce' ) && is_shop()) ) {
			$title = esc_html__( 'Our Products', 'medcity' );
		}
	}

	return array(
		'title' => $title,
	);
}

/**
 * Generates an excerpt from the post content with custom length.
 * Default length is 55 words, same as default the_excerpt()
 *
 * The excerpt words amount will be 55 words and if the amount is greater than
 * that, then the string '&hellip;' will be appended to the excerpt. If the string
 * is less than 55 words, then the content will be returned as it is.
 *
 * @param int $length Optional. Custom excerpt length, default to 55.
 * @param int|WP_Post $post Optional. You will need to provide post id or post object if used outside loops.
 *
 * @return string           The excerpt with custom length.
 */
function medcity_get_the_excerpt( $length = 55, $post = null ) {
	$post = get_post( $post );

	if ( empty( $post ) || 0 >= $length ) {
		return '';
	}

	if ( post_password_required( $post ) ) {
		return esc_html__( 'Post password required.', 'medcity' );
	}

	$content = apply_filters( 'the_content', strip_shortcodes( $post->post_content ) );
	$content = str_replace( ']]>', ']]&gt;', $content );

	$excerpt_more = apply_filters( 'medcity_excerpt_more', '&hellip;' );
	$excerpt      = wp_trim_words( $content, $length, $excerpt_more );

	return $excerpt;
}


/**
 * Check if provided color string is valid color.
 * Only supports 'transparent', HEX, RGB, RGBA.
 *
 * @param  string $color
 *
 * @return boolean
 */
function medcity_is_valid_color( $color ) {
	$color = preg_replace( "/\s+/m", '', $color );

	if ( $color === 'transparent' ) {
		return true;
	}

	if ( '' == $color ) {
		return false;
	}

	// Hex format
	if ( preg_match( "/(?:^#[a-fA-F0-9]{6}$)|(?:^#[a-fA-F0-9]{3}$)/", $color ) ) {
		return true;
	}

	// rgb or rgba format
	if ( preg_match( "/(?:^rgba\(\d+\,\d+\,\d+\,(?:\d*(?:\.\d+)?)\)$)|(?:^rgb\(\d+\,\d+\,\d+\)$)/", $color ) ) {
		preg_match_all( "/\d+\.*\d*/", $color, $matches );
		if ( empty( $matches ) || empty( $matches[0] ) ) {
			return false;
		}

		$red   = empty( $matches[0][0] ) ? $matches[0][0] : 0;
		$green = empty( $matches[0][1] ) ? $matches[0][1] : 0;
		$blue  = empty( $matches[0][2] ) ? $matches[0][2] : 0;
		$alpha = empty( $matches[0][3] ) ? $matches[0][3] : 1;

		if ( $red < 0 || $red > 255 || $green < 0 || $green > 255 || $blue < 0 || $blue > 255 || $alpha < 0 || $alpha > 1.0 ) {
			return false;
		}
	} else {
		return false;
	}

	return true;
}

/**
 * Minify css
 *
 * @param  string $css
 *
 * @return string
 */
function medcity_css_minifier( $css ) {
	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );
	// Remove spaces before and after comment
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );
	// Remove comment blocks, everything between /* and */, unless
	// preserved with /*! ... */ or /** ... */
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );
	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );
	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );
	// Remove space before , ; { } ( ) >
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );
	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );
	// Shortern 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Header Tracking Code to wp_head hook.
 */
function medcity_header_code() {
	$site_header_code = medcity_get_opt( 'site_header_code' );
	if ( $site_header_code !== '' ) {
		print wp_kses( $site_header_code, wp_kses_allowed_html() );
	}
}

add_action( 'wp_head', 'medcity_header_code' );

/**
 * Footer Tracking Code to wp_footer hook.
 */
function medcity_footer_code() {
	$site_footer_code = medcity_get_opt( 'site_footer_code' );
	if ( $site_footer_code !== '' ) {
		print wp_kses( $site_footer_code, wp_kses_allowed_html() );
	}
}

add_action( 'wp_footer', 'medcity_footer_code' );

/**
 * Custom Comment List
 */
function medcity_comment_list( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
	?>
    <<?php echo ''.$tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		    <div class="comment-inner">
		        <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, 90); ?>
		        <div class="comment-content">
		            <h4 class="comment-title">
		            	<?php printf( '%s', get_comment_author_link() ); ?>
		            </h4>
		            <div class="comment-meta">
		            	<span class="comment-date">
	                        <?php echo get_comment_date().' - '.get_comment_time(); ?>
	                    </span>
		            </div>
		            <div class="comment-text"><?php comment_text(); ?></div>
		            <div class="comment-reply">
						<?php comment_reply_link( array_merge( $args, array(
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth']
						) ) ); ?>
		            </div>
		        </div>
		    </div>
		<?php if ( 'div' != $args['style'] ) : ?>
        </div>
	<?php endif;
}

/**
 * Add field subtitle to post.
 */
function medcity_add_subtitle_field() {
	global $post;

	$screen = get_current_screen();

	if ( in_array( $screen->id, array( 'acm-post' ) ) ) {

		$value = get_post_meta( $post->ID, 'post_subtitle', true );

		echo '<div class="subtitle"><input type="text" name="post_subtitle" value="' . esc_attr( $value ) . '" id="subtitle" placeholder = "' . esc_html__( 'Subtitle', 'medcity' ) . '" style="width: 100%;margin-top: 4px;"></div>';
	}
}

add_action( 'edit_form_after_title', 'medcity_add_subtitle_field' );

/**
 * Save custom theme meta
 */
function medcity_save_meta_boxes( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_subtitle'] ) ) {
		update_post_meta( $post_id, 'post_subtitle', $_POST['post_subtitle'] );
	}
}

add_action( 'save_post', 'medcity_save_meta_boxes' );

// Custom Post type
add_filter( 'cms_extra_post_types', 'medcity_add_posttype' );
function medcity_add_posttype( $postypes ) {
	$postypes['portfolio'] = array(
		'status' => false,
		'args'       => array(
			'rewrite'             => array(
                'slug'       => ''
 		 	),
		),
	);

	$service_slug = medcity_get_opt( 'service_slug', 'solution' );
	$postypes['service'] = array(
		'status'     => true,
		'item_name'  => esc_html__( 'Services', 'medcity' ),
		'items_name' => esc_html__( 'Services', 'medcity' ),
		'args'       => array(
			'menu_icon'          => 'dashicons-hammer',
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
                'excerpt',
			),
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'             => array(
                'slug'       => $service_slug
 		 	),
		),
        'labels'     => array(
            'add_new_item' => esc_html__('Add New Service', 'medcity'),
            'edit_item' => esc_html__('Edit Service', 'medcity'),
            'view_item' => esc_html__('View Service', 'medcity'),
        )
	);

	$doctor_slug = medcity_get_opt( 'doctor_slug', 'doctor' );
	$postypes['doctor'] = array(
		'status'     => true,
		'item_name'  => esc_html__( 'Doctors', 'medcity' ),
		'items_name' => esc_html__( 'Doctors', 'medcity' ),
		'args'       => array(
			'menu_icon'          => 'dashicons-groups',
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
                'excerpt',
			),
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'             => array(
                'slug'       => $doctor_slug
 		 	),
		),
        'labels'     => array(
            'add_new_item' => esc_html__('Add New Doctor', 'medcity'),
            'edit_item' => esc_html__('Edit Doctor', 'medcity'),
            'view_item' => esc_html__('View Doctor', 'medcity'),
        )
	);

    $department_slug = medcity_get_opt( 'department_slug', 'department' );
    $postypes['department'] = array(
        'status'     => true,
        'item_name'  => esc_html__( 'Departments', 'medcity' ),
        'items_name' => esc_html__( 'Departments', 'medcity' ),
        'args'       => array(
            'menu_icon'          => 'dashicons-plus-alt',
            'supports'           => array(
                'title',
                'thumbnail',
                'editor',
                'excerpt',
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'rewrite'             => array(
                'slug'       => $department_slug
            ),
        ),
        'labels'     => array(
            'add_new_item' => esc_html__('Add New Department', 'medcity'),
            'edit_item' => esc_html__('Edit Department', 'medcity'),
            'view_item' => esc_html__('View Department', 'medcity'),
        )
    );
    $postypes['footer'] = array(
        'status'     => true,
        'item_name'  => esc_html__( 'Footers', 'medcity' ),
        'items_name' => esc_html__( 'Footers', 'medcity' ),
        'args'       => array(
            'menu_icon'          => 'dashicons-editor-insertmore',
            'supports'           => array(
                'title',
                'editor',
            ),
            'public'             => true,
            'publicly_queryable' => true,
        ),
        'labels'     => array()
    );
	return $postypes;
}

add_filter( 'cms_extra_taxonomies', 'medcity_add_tax' );
function medcity_add_tax( $taxonomies ) {
	$taxonomies['service-category'] = array(
		'status'     => true,
		'post_type'  => array( 'service' ),
		'taxonomy' => esc_html__( 'Category', 'medcity' ),
		'taxonomies' => esc_html__( 'Categories', 'medcity' ),
		'args'       => array(),
		'labels'     => array()
	);
    $taxonomies['doctor-category'] = array(
        'status'     => true,
        'post_type'  => array( 'doctor' ),
        'taxonomy' => esc_html__( 'Category', 'medcity' ),
        'taxonomies' => esc_html__( 'Categories', 'medcity' ),
        'args'       => array(),
        'labels'     => array()
    );
    $taxonomies['department-category'] = array(
        'status'     => true,
        'post_type'  => array( 'department' ),
        'taxonomy' => esc_html__( 'Category', 'medcity' ),
        'taxonomies' => esc_html__( 'Categories', 'medcity' ),
        'args'       => array(),
        'labels'     => array()
    );
	
	return $taxonomies;
}

function medcity_add_cpt_support() {
    $cpt_support = get_option( 'elementor_cpt_support' );

    if( ! $cpt_support ) {
        $cpt_support = [ 'page', 'post', 'service', 'doctor', 'department', 'footer', 'cms-mega-menu' ];
        update_option( 'elementor_cpt_support', $cpt_support );
    } else if( ! in_array( 'service', $cpt_support ) ) {
        $cpt_support[] = 'service';
        update_option( 'elementor_cpt_support', $cpt_support );
    } else if( ! in_array( 'doctor', $cpt_support ) ) {
        $cpt_support[] = 'doctor';
        update_option( 'elementor_cpt_support', $cpt_support );
    } else if( ! in_array( 'department', $cpt_support ) ) {
        $cpt_support[] = 'department';
        update_option( 'elementor_cpt_support', $cpt_support );
    } else if( ! in_array( 'footer', $cpt_support ) ) {
        $cpt_support[] = 'footer';
        update_option( 'elementor_cpt_support', $cpt_support );
    } else if( ! in_array( 'cms-mega-menu', $cpt_support ) ) {
        $cpt_support[] = 'cms-mega-menu';
        update_option( 'elementor_cpt_support', $cpt_support );
    }
}
add_action( 'after_switch_theme', 'medcity_add_cpt_support');

/**
 * Get Post List
 */
if(!function_exists('medcity_list_post')){
    function medcity_list_post($post_type = 'post', $default = false){
        $post_list = array();
        $posts = get_posts(array('post_type' => $post_type,'posts_per_page' => '-1'));
        foreach($posts as $post){
            $post_list[$post->ID] = $post->post_title;
        }
        return $post_list;
    }
}

add_filter( 'cms_enable_megamenu', 'medcity_enable_megamenu' );
function medcity_enable_megamenu() {
	return false;
}
add_filter( 'cms_enable_onepage', 'medcity_enable_onepage' );
function medcity_enable_onepage() {
	return false;
}

// remove <br> in contact form7
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/* Show/hide CMS Carousel */
add_filter( 'enable_cms_carousel', 'medcity_enable_cms_carousel' );
function medcity_enable_cms_carousel() {
	return false;
}

/* ------Disable Lazy loading---- */
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

/* Create Demo Data */
add_filter('swa_ie_export_mode', 'medcity_enable_export_mode');
function medcity_enable_export_mode()
{
    return defined('DEV_MODE') && DEV_MODE == true;
}
add_filter('swa_post_types', 'function_swa_post_types');
function function_swa_post_types($post_type)
{
    $post_type[] = 'timetable_weekdays';
    $post_type[] = 'events';
    return $post_type;
}
/* Dashboard Theme */
add_filter('cms_documentation_link',function(){
     return 'http://doc.7oroof.com/medcity';
});

add_filter('cms_ticket_link', 'medcity_add_cms_ticket_link');
function medcity_add_cms_ticket_link($url)
{
    $url = array('type' => 'url', 'link' => '#');
    return $url;
}
add_filter('cms_video_tutorial_link',function(){
     return '#';
});

/**
 *  Add custom field to Elementor section
 * @since 1.1.1
 * @author Chinh Duong Manh
*/
if(!function_exists('medcity_custom_section_params')){
    add_filter('etc-custom-section/custom-params', 'medcity_custom_section_params'); 
    function medcity_custom_section_params(){
        return array(
            'sections' => array(
                array(
                    'name'     => 'cms_default_row_overlay',
                    'tab'      => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'label'    => esc_html__( 'Medcity Custom Settings', 'medcity' ),
                    'controls' => array(
                        array(
                            'name' => 'cms_row_gradient',
                            'label' => __('Gradient Overlay','medcity'),
                            'type'       => \Elementor\Controls_Manager::SELECT,
                            'options'   => [
                                ''  => esc_html__('None','medcity'),
                                '1' => esc_html__('Style 1','medcity'), 
                                '2' => esc_html__('Style 2','medcity'), 
                                '3' => esc_html__('Style 3','medcity'), 
                                '4' => esc_html__('Style 4','medcity'), 
                                '5' => esc_html__('Style 5','medcity'), 
                            ],
                            'prefix_class' => 'cms-gradient-'
                        )
                    )
                )
            )
        );
    }
}
// add html to before row settings
if(!function_exists('medcity_before_row_custom_html_setting')){
    add_filter('etc-custom-section/before-elementor-row-settings', 'medcity_before_row_custom_html_setting', 10 , 2);
    function medcity_before_row_custom_html_setting( $html, $settings){
        $html .= '<div class="cms-gradient-render cms-overlay"></div>';
        return $html;
    }
}
// Custom HTML Elementor ROW (Frontend)
if(!function_exists('medcity_before_row_custom_html_render')){
    add_filter('etc-custom-section/before-elementor-row-render', 'medcity_before_row_custom_html_render', 11 , 2);
    function medcity_before_row_custom_html_render( $html, $settings){
        // Overlay Gradient
        if(isset($settings['cms_row_gradient']) && $settings['cms_row_gradient'] != ''){
            $html .= '<div class="cms-gradient-render cms-overlay"></div>';
        }
        // Return
        return $html;
    }
}