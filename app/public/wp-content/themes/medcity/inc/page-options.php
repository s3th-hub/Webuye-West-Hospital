<?php
/**
 * Register metabox for posts based on Redux Framework. Supported methods:
 *     isset_args( $post_type )
 *     set_args( $post_type, $redux_args, $metabox_args )
 *     add_section( $post_type, $sections )
 * Each post type can contains only one metabox. Pease note that each field id
 * leads by an underscore sign ( _ ) in order to not show that into Custom Field
 * Metabox from WordPress core feature.
 *
 * @param  CMS_Post_Metabox $metabox
 */

add_action( 'cms_post_metabox_register', 'medcity_page_options_register' );

function medcity_page_options_register( $metabox ) {

	if ( ! $metabox->isset_args( 'post' ) ) {
		$metabox->set_args( 'post', array(
			'opt_name'            => 'post_option',
			'display_name'        => esc_html__( 'Post Settings', 'medcity' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'product' ) ) {
		$metabox->set_args( 'product', array(
			'opt_name'            => 'product_option',
			'display_name'        => esc_html__( 'Product Settings', 'medcity' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'page' ) ) {
		$metabox->set_args( 'page', array(
			'opt_name'            => medcity_get_page_opt_name(),
			'display_name'        => esc_html__( 'Page Settings', 'medcity' ),
			'show_options_object' => false,
            'disable_google_fonts_link' => '',
            'font_display' => 'swap',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'cms_pf_audio' ) ) {
		$metabox->set_args( 'cms_pf_audio', array(
			'opt_name'     => 'post_format_audio',
			'display_name' => esc_html__( 'Audio', 'medcity' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'cms_pf_link' ) ) {
		$metabox->set_args( 'cms_pf_link', array(
			'opt_name'     => 'post_format_link',
			'display_name' => esc_html__( 'Link', 'medcity' )
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'cms_pf_quote' ) ) {
		$metabox->set_args( 'cms_pf_quote', array(
			'opt_name'     => 'post_format_quote',
			'display_name' => esc_html__( 'Quote', 'medcity' )
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'cms_pf_video' ) ) {
		$metabox->set_args( 'cms_pf_video', array(
			'opt_name'     => 'post_format_video',
			'display_name' => esc_html__( 'Video', 'medcity' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'cms_pf_gallery' ) ) {
		$metabox->set_args( 'cms_pf_gallery', array(
			'opt_name'     => 'post_format_gallery',
			'display_name' => esc_html__( 'Gallery', 'medcity' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	/* Extra Post Type */

	if ( ! $metabox->isset_args( 'doctor' ) ) {
		$metabox->set_args( 'doctor', array(
			'opt_name'            => 'doctor_option',
			'display_name'        => esc_html__( 'Doctors Settings', 'medcity' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'service' ) ) {
		$metabox->set_args( 'service', array(
			'opt_name'            => 'service_option',
			'display_name'        => esc_html__( 'Service Settings', 'medcity' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

    if ( ! $metabox->isset_args( 'department' ) ) {
        $metabox->set_args( 'department', array(
            'opt_name'            => 'department_option',
            'display_name'        => esc_html__( 'Department Settings', 'medcity' ),
            'show_options_object' => false,
        ), array(
            'context'  => 'advanced',
            'priority' => 'default'
        ) );
    }

	/**
	 * Config post meta options
	 *
	 */
	$metabox->add_section( 'post', array(
		'title'  => esc_html__( 'Post Settings', 'medcity' ),
		'icon'   => 'el el-refresh',
		'fields' => array(
			array(
				'id'             => 'post_content_padding',
				'type'           => 'spacing',
				'output'         => array( '.single-post #content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'medcity' ),
				'subtitle'     => esc_html__( 'Content site paddings.', 'medcity' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'medcity' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
			array(
				'id'      => 'show_sidebar_post',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Sidebar', 'medcity' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'sidebar_post_pos',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Sidebar Position', 'medcity' ),
				'options'      => array(
					'left'  => esc_html__('Left', 'medcity'),
	                'right' => esc_html__('Right', 'medcity'),
	                'none'  => esc_html__('Disabled', 'medcity')
				),
				'default'      => 'right',
				'required'     => array( 0 => 'show_sidebar_post', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
		)
	) );

	/**
	 * Config page meta options
	 *
	 */
	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Header', 'medcity' ),
		'desc'   => esc_html__( 'Header settings for the page.', 'medcity' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
				'id'      => 'custom_header',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Header', 'medcity' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'header_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'medcity' ),
				'subtitle'     => esc_html__( 'Select a layout for header.', 'medcity' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/header-layout/h0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
					'2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
					'3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
                    '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
                    '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
                    '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
                    '7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
				),
				'default'      => medcity_get_option_of_theme_options( 'header_layout' ),
				'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
			),
            array(
                'id'       => 'page_custom_logo',
                'type'     => 'media',
                'title'    => esc_html__('Custom Logo', 'medcity'),
                'default' => '',
                'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
                'force_output' => true
            ),
            array(
                'id'      => 'custom_main_menu',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom Main Menu', 'medcity' ),
                'default' => false,
                'indent'  => true
            ),
            array(
                'id'    => 'main_menu_select',
                'type'  => 'select',
                'title' => esc_html__( 'Select Menu', 'medcity' ),
                'data'  => 'menus',
                'args'  => array(
                    'hide_empty' => false,
                    'orderby'    => 'name',
                ),
                'required'     => array( 0 => 'custom_main_menu', 1 => 'equals', 2 => '1' ),
            ),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Page Title', 'medcity' ),
		'icon'   => 'el el-indent-left',
		'fields' => array(
            array(
                'id'           => 'custom_pagetitle',
                'type'         => 'button_set',
                'title'        => esc_html__( 'Page Title', 'medcity' ),
                'options'      => array(
                    'themeoption'  => esc_html__( 'Theme Option', 'medcity' ),
                    'hide'  => esc_html__( 'Elementor Content', 'medcity' ),
                ),
                'default'      => 'themeoption',
                'desc'           => esc_html__( 'Inherit from Theme Option or build-in Elementor Content', 'medcity' ),
            ),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Content', 'medcity' ),
		'desc'   => esc_html__( 'Settings for content area.', 'medcity' ),
		'icon'   => 'el-icon-pencil',
		'fields' => array(
			array(
				'id'       => 'content_bg_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'medcity' ),
				'subtitle' => esc_html__( 'Content background color.', 'medcity' ),
				'output'   => array( 'background-color' => 'body' )
			),
			array(
				'id'             => 'content_padding',
				'type'           => 'spacing',
				'output'         => array( '#content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'medcity' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'medcity' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
            array(
				'id'          => 'font_heading',
				'type'        => 'typography',
				'title'       => esc_html__('Heading Font', 'medcity'),
				'subtitle'    => esc_html__( 'Content heading from h1 to h6.', 'medcity' ),
				'google'      => true,
				'font-backup' => false,
				'subsets'     => false,
				'font-style'  => false,
				'font-weight' => false, // true
				'text-align'  => false,
				'font-size'   => false,
				'line-height' => false,
				'color'       => false,
				'output'      => array('.site-content h1, .site-content h2, .site-content h3, .site-content h4, .site-content h5, .site-content h6', 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading'),
                'units'       => 'px',
            ),
			array(
				'id'      => 'show_sidebar_page',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Sidebar', 'medcity' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'sidebar_page_pos',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Sidebar Position', 'medcity' ),
				'options'      => array(
					'left'  => esc_html__( 'Left', 'medcity' ),
					'right' => esc_html__( 'Right', 'medcity' ),
				),
				'default'      => 'right',
				'required'     => array( 0 => 'show_sidebar_page', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
		)
	) );

    $metabox->add_section('page', array(
        'title' => esc_html__('Footer', 'medcity'),
        'desc' => esc_html__('Settings for page footer.', 'medcity'),
        'icon' => 'el el-website',
        'fields' => array(
            array(
                'id'      => 'custom_footer',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom Footer', 'medcity' ),
                'default' => false,
                'indent'  => true
            ),
            array(
                'id'       => 'footer_layout',
                'type'     => 'button_set',
                'title'    => esc_html__('Layout', 'medcity'),
                'subtitle' => esc_html__('Select a layout for upper footer area.', 'medcity'),
                'options'  => array(
                    '1'  => esc_html__('Default', 'medcity'),
                    'custom'  => esc_html__('Custom', 'medcity'),
                    '0'  => esc_html__('No footer', 'medcity'),

                ),
                'default'  => '1',
                'required' => array( 0 => 'custom_footer', 1 => 'equals', 2 => '1' ),
                'force_output' => true
            ),
            array(
                'id'          => 'footer_layout_custom',
                'type'        => 'select',
                'title'       => esc_html__('Custom Layout', 'medcity'),
                'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','medcity'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=footer' ) ) . '">','</a>'),
                'options'     => medcity_list_post('footer'),
                'default'     => '',
                'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => 'custom' ),
                'force_output' => true
            ),
        )
    ));
    
    $metabox->add_section( 'page', array(
        'title'  => esc_html__( 'Color', 'medcity' ),
        'desc'   => esc_html__( 'Replace color settings in Theme Options for this page', 'medcity' ),
        'icon'   => 'el el-brush',
        'fields' => array(
            array(
                'id'      => 'custom_color',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom Global Color', 'medcity' ),
                'default' => false,
                'indent'  => true
            ),
            array(
                'id'          => 'primary_color',
                'type'        => 'color',
                'title'       => esc_html__('Primary Color', 'medcity'),
                'transparent' => false,
                'default'     => '',
                'required'     => array( 0 => 'custom_color', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id' => 'secondary_color',
                'type' => 'color',
                'title' => esc_html__('Secondary Color', 'medcity'),
                'transparent' => false,
                'default' => '',
                'required'     => array( 0 => 'custom_color', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id' => 'tertiary_color',
                'type' => 'color',
                'title' => esc_html__('Tertiary Color', 'medcity'),
                'transparent' => false,
                'default' => '',
                'required'     => array( 0 => 'custom_color', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id' => 'note_color',
                'type' => 'color',
                'title' => esc_html__('Header Note Highlight', 'medcity'),
                'transparent' => false,
                'default' => '',
                'output'   => array('#masthead #site-header-wrap .site-header-top .header-note-text'),
            ),
            array(
                'id' => 'h_icon_color',
                'type' => 'color',
                'title' => esc_html__('Header Top Contact Icon', 'medcity'),
                'transparent' => false,
                'default' => '',
                'output'   => array('#masthead #site-header-wrap .header-top-item i'),
            ),
        )
    ) );

	$metabox->add_section( 'product', array(
		'title'  => esc_html__( 'Header', 'medcity' ),
		'desc'   => esc_html__( 'Header settings for the page.', 'medcity' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
				'id'      => 'custom_header',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Header', 'medcity' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'header_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'medcity' ),
				'subtitle'     => esc_html__( 'Select a layout for header.', 'medcity' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/header-layout/h0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
					'2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
					'3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
                    '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
                    '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
                    '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
                    '7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
				),
				'default'      => medcity_get_option_of_theme_options( 'header_layout' ),
				'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
			),
		)
	) );


	/**
	 * Config post format meta options
	 *
	 */

	$metabox->add_section( 'cms_pf_video', array(
		'title'  => esc_html__( 'Video', 'medcity' ),
		'fields' => array(
			array(
				'id'    => 'post-video-url',
				'type'  => 'text',
				'title' => esc_html__( 'Video URL', 'medcity' ),
				'desc'  => esc_html__( 'YouTube or Vimeo video URL', 'medcity' )
			),

			array(
				'id'    => 'post-video-file',
				'type'  => 'editor',
				'title' => esc_html__( 'Video Upload', 'medcity' ),
				'desc'  => esc_html__( 'Upload video file', 'medcity' )
			),

			array(
				'id'    => 'post-video-html',
				'type'  => 'textarea',
				'title' => esc_html__( 'Embadded video', 'medcity' ),
				'desc'  => esc_html__( 'Use this option when the video does not come from YouTube or Vimeo', 'medcity' )
			)
		)
	) );

	$metabox->add_section( 'cms_pf_gallery', array(
		'title'  => esc_html__( 'Gallery', 'medcity' ),
		'fields' => array(
			array(
				'id'       => 'post-gallery-lightbox',
				'type'     => 'switch',
				'title'    => esc_html__( 'Lightbox?', 'medcity' ),
				'subtitle' => esc_html__( 'Enable lightbox for gallery images.', 'medcity' ),
				'default'  => true
			),
			array(
				'id'       => 'post-gallery-images',
				'type'     => 'gallery',
				'title'    => esc_html__( 'Gallery Images ', 'medcity' ),
				'subtitle' => esc_html__( 'Upload images or add from media library.', 'medcity' )
			)
		)
	) );

	$metabox->add_section( 'cms_pf_audio', array(
		'title'  => esc_html__( 'Audio', 'medcity' ),
		'fields' => array(
			array(
				'id'          => 'post-audio-url',
				'type'        => 'text',
				'title'       => esc_html__( 'Audio URL', 'medcity' ),
				'description' => esc_html__( 'Audio file URL in format: mp3, ogg, wav.', 'medcity' ),
				'validate'    => 'url',
				'msg'         => 'Url error!'
			)
		)
	) );

	$metabox->add_section( 'cms_pf_link', array(
		'title'  => esc_html__( 'Link', 'medcity' ),
		'fields' => array(
			array(
				'id'       => 'post-link-url',
				'type'     => 'text',
				'title'    => esc_html__( 'URL', 'medcity' ),
				'validate' => 'url',
				'msg'      => 'Url error!'
			)
		)
	) );

	$metabox->add_section( 'cms_pf_quote', array(
		'title'  => esc_html__( 'Quote', 'medcity' ),
		'fields' => array(
			array(
				'id'    => 'post-quote-cite',
				'type'  => 'text',
				'title' => esc_html__( 'Cite', 'medcity' )
			)
		)
	) );

	/**
	 * Config Doctors meta options
	 *
	 */
	$metabox->add_section( 'doctor', array(
		'title'  => esc_html__( 'General', 'medcity' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
				'id'             => 'doctor_content_padding',
				'type'           => 'spacing',
				'output'         => array( '.single-doctor #content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'medcity' ),
				'subtitle'     => esc_html__( 'Content site paddings.', 'medcity' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'medcity' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
		)
	) );
	$metabox->add_section( 'doctor', array(
		'title'  => esc_html__( 'Header', 'medcity' ),
		'desc'   => esc_html__( 'Header settings for the page.', 'medcity' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
				'id'      => 'custom_header',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Header', 'medcity' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'header_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'medcity' ),
				'subtitle'     => esc_html__( 'Select a layout for header.', 'medcity' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/header-layout/h0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
					'2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
                    '3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
                    '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
                    '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
                    '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
                    '7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
				),
				'default'      => medcity_get_option_of_theme_options( 'header_layout' ),
				'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
			),
		)
	) );
	$metabox->add_section( 'doctor', array(
		'title'  => esc_html__( 'Page Title', 'medcity' ),
		'icon'   => 'el el-indent-left',
		'fields' => array(
            array(
                'id'           => 'custom_pagetitle',
                'type'         => 'button_set',
                'title'        => esc_html__( 'Page Title', 'medcity' ),
                'options'      => array(
                    'themeoption'  => esc_html__( 'Theme Option', 'medcity' ),
                    'hide'  => esc_html__( 'Elementor Content', 'medcity' ),
                ),
                'default'      => 'themeoption',
                'desc'           => esc_html__( 'Inherit from Theme Option or build-in Elementor Content', 'medcity' ),
            ),
		)
	) );
    $metabox->add_section( 'doctor', array(
        'title'  => esc_html__( 'Doctor Information', 'medcity' ),
        'icon'   => 'el el-info-circle',
        'fields' => array(
            array(
                'id'      => 'doctor_facebook_url',
                'type'    => 'text',
                'title'   => esc_html__('Facebook URL', 'medcity'),
                'default' => '#',
            ),
            array(
                'id'      => 'doctor_instagram_url',
                'type'    => 'text',
                'title'   => esc_html__('Instagram URL', 'medcity'),
                'default' => '#',
            ),
            array(
                'id'      => 'doctor_twitter_url',
                'type'    => 'text',
                'title'   => esc_html__('Twitter URL', 'medcity'),
                'default' => '#',
            ),
            array(
                'id'           => 'doctor_email',
                'type'         => 'text',
                'title'        => esc_html__( 'Email', 'medcity' ),
                'force_output' => true
            ),
            array(
                'id'           => 'doctor_phone',
                'type'         => 'text',
                'title'        => esc_html__( 'Phone', 'medcity' ),
                'force_output' => true
            ),
        )
    ) );

	/**
	 * Config service meta options
	 *
	 */
	$metabox->add_section( 'service', array(
		'title'  => esc_html__( 'General', 'medcity' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
	            'id'       => 'service_icon',
	            'type'     => 'media',
	            'title'    => esc_html__('Icon Image', 'medcity'),
	            'default' => ''
	        ),
            array(
                'id'       => 'service_feature',
                'type'     => 'multi_text',
                'title'    => esc_html__('Feature', 'medcity'),
                'validate' => 'html',
            ),
			array(
				'id'             => 'service_content_padding',
				'type'           => 'spacing',
				'output'         => array( '.single-service #content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'medcity' ),
				'subtitle'     => esc_html__( 'Content site paddings.', 'medcity' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'medcity' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
		)
	) );
	$metabox->add_section( 'service', array(
		'title'  => esc_html__( 'Header', 'medcity' ),
		'desc'   => esc_html__( 'Header settings for the page.', 'medcity' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
				'id'      => 'custom_header',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Header', 'medcity' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'header_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'medcity' ),
				'subtitle'     => esc_html__( 'Select a layout for header.', 'medcity' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/header-layout/h0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
					'2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
                    '3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
                    '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
                    '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
                    '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
                    '7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
				),
				'default'      => medcity_get_option_of_theme_options( 'header_layout' ),
				'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
			),
            array(
                'id'       => 'page_custom_logo',
                'type'     => 'media',
                'title'    => esc_html__('Custom Logo', 'medcity'),
                'default' => '',
                'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
                'force_output' => true
            ),
		)
	) );
	$metabox->add_section( 'service', array(
		'title'  => esc_html__( 'Page Title', 'medcity' ),
		'icon'   => 'el el-indent-left',
		'fields' => array(
			array(
				'id'           => 'custom_pagetitle',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Page Title', 'medcity' ),
				'options'      => array(
					'themeoption'  => esc_html__( 'Theme Option', 'medcity' ),
					'hide'  => esc_html__( 'Elementor Content', 'medcity' ),
				),
				'default'      => 'themeoption',
                'desc'           => esc_html__( 'Inherit from Theme Option or build-in Elementor Content', 'medcity' ),
			),
		)
	) );
    $metabox->add_section('service', array(
        'title' => esc_html__('Footer', 'medcity'),
        'desc' => esc_html__('Settings for page footer.', 'medcity'),
        'icon' => 'el el-website',
        'fields' => array(
            array(
                'id'      => 'custom_footer',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom Footer', 'medcity' ),
                'default' => false,
                'indent'  => true
            ),
            array(
                'id'       => 'footer_layout',
                'type'     => 'button_set',
                'title'    => esc_html__('Layout', 'medcity'),
                'subtitle' => esc_html__('Select a layout for upper footer area.', 'medcity'),
                'options'  => array(
                    '1'  => esc_html__('Default', 'medcity'),
                    'custom'  => esc_html__('Custom', 'medcity'),
                    '0'  => esc_html__('No footer', 'medcity'),

                ),
                'default'  => '1',
                'required' => array( 0 => 'custom_footer', 1 => 'equals', 2 => '1' ),
                'force_output' => true
            ),
            array(
                'id'          => 'footer_layout_custom',
                'type'        => 'select',
                'title'       => esc_html__('Custom Layout', 'medcity'),
                'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','medcity'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=footer' ) ) . '">','</a>'),
                'options'     => medcity_list_post('footer'),
                'default'     => '',
                'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => 'custom' ),
                'force_output' => true
            ),
        )
    ));
    $metabox->add_section( 'service', array(
        'title'  => esc_html__( 'Color', 'medcity' ),
        'desc'   => esc_html__( 'Replace color settings in Theme Options for this page', 'medcity' ),
        'icon'   => 'el el-brush',
        'fields' => array(
            array(
                'id'      => 'custom_color',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom Global Color', 'medcity' ),
                'default' => false,
                'indent'  => true
            ),
            array(
                'id'          => 'primary_color',
                'type'        => 'color',
                'title'       => esc_html__('Primary Color', 'medcity'),
                'transparent' => false,
                'default'     => '',
                'required'     => array( 0 => 'custom_color', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id' => 'secondary_color',
                'type' => 'color',
                'title' => esc_html__('Secondary Color', 'medcity'),
                'transparent' => false,
                'default' => '',
                'required'     => array( 0 => 'custom_color', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id' => 'tertiary_color',
                'type' => 'color',
                'title' => esc_html__('Tertiary Color', 'medcity'),
                'transparent' => false,
                'default' => '',
                'required'     => array( 0 => 'custom_color', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id' => 'note_color',
                'type' => 'color',
                'title' => esc_html__('Header Note Highlight', 'medcity'),
                'transparent' => false,
                'default' => '',
                'output'   => array('#masthead #site-header-wrap .site-header-top .header-note-text'),
            ),
            array(
                'id' => 'h_icon_color',
                'type' => 'color',
                'title' => esc_html__('Header Top Contact Icon', 'medcity'),
                'transparent' => false,
                'default' => '',
                'output'   => array('#masthead #site-header-wrap .header-top-item i'),
            ),
        )
    ) );

    /**
     * Config department meta options
     *
     */
    $metabox->add_section( 'department', array(
        'title'  => esc_html__( 'General', 'medcity' ),
        'icon'   => 'el-icon-website',
        'fields' => array(
            array(
                'id' => 'department_icon',
                'type' => 'media',
                'title' => esc_html__('Department Icon Image', 'medcity'),
            ),
            array(
                'id'             => 'department_content_padding',
                'type'           => 'spacing',
                'output'         => array( '.single-department #content' ),
                'right'          => false,
                'left'           => false,
                'mode'           => 'padding',
                'units'          => array( 'px' ),
                'units_extended' => 'false',
                'title'          => esc_html__( 'Content Padding', 'medcity' ),
                'subtitle'     => esc_html__( 'Content site paddings.', 'medcity' ),
                'desc'           => esc_html__( 'Default: Theme Option.', 'medcity' ),
                'default'        => array(
                    'padding-top'    => '',
                    'padding-bottom' => '',
                    'units'          => 'px',
                )
            ),
            array(
                'id' => 'description_list',
                'type' => 'multi_text',
                'title' => esc_html__('Features List', 'medcity'),
                'subtitle'     => esc_html__( 'Show in Department Grid', 'medcity' ),
            ),
        )
    ) );
    $metabox->add_section( 'department', array(
        'title'  => esc_html__( 'Header', 'medcity' ),
        'desc'   => esc_html__( 'Header settings for the page.', 'medcity' ),
        'icon'   => 'el-icon-website',
        'fields' => array(
            array(
                'id'      => 'custom_header',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom Header', 'medcity' ),
                'default' => false,
                'indent'  => true
            ),
            array(
                'id'           => 'header_layout',
                'type'         => 'image_select',
                'title'        => esc_html__( 'Layout', 'medcity' ),
                'subtitle'     => esc_html__( 'Select a layout for header.', 'medcity' ),
                'options'      => array(
                    '0' => get_template_directory_uri() . '/assets/images/header-layout/h0.jpg',
                    '1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
                    '2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
                    '3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
                    '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
                    '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
                    '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
                    '7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
                ),
                'default'      => medcity_get_option_of_theme_options( 'header_layout' ),
                'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
                'force_output' => true
            ),
        )
    ) );
    $metabox->add_section( 'department', array(
        'title'  => esc_html__( 'Page Title', 'medcity' ),
        'icon'   => 'el el-indent-left',
        'fields' => array(
            array(
                'id'           => 'custom_pagetitle',
                'type'         => 'button_set',
                'title'        => esc_html__( 'Page Title', 'medcity' ),
                'options'      => array(
                    'themeoption'  => esc_html__( 'Theme Option', 'medcity' ),
                    'hide'  => esc_html__( 'Elementor Content', 'medcity' ),
                ),
                'default'      => 'themeoption',
                'desc'           => esc_html__( 'Inherit from Theme Option or build-in Elementor Content', 'medcity' ),
            ),
        )
    ) );

}

function medcity_get_option_of_theme_options( $key, $default = '' ) {
	if ( empty( $key ) ) {
		return '';
	}
	$options = get_option( medcity_get_opt_name(), array() );
	$value   = isset( $options[ $key ] ) ? $options[ $key ] : $default;

	return $value;
}