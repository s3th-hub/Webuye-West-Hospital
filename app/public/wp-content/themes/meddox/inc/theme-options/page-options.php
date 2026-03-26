<?php

add_action( 'pxl_post_metabox_register', 'meddox_page_options_register' );
function meddox_page_options_register( $metabox ) {

	$panels = [
		'post' => [
			'opt_name'            => 'post_option',
			'display_name'        => esc_html__( 'Post Options', 'meddox' ),
			'show_options_object' => false,
			'context'  => 'advanced',
			'priority' => 'default',
			'sections'  => [
				'post_settings' => [
					'title'  => esc_html__( 'Post Options', 'meddox' ),
					'icon'   => 'el el-refresh',
					'fields' => array_merge(
						meddox_sidebar_pos_opts(['prefix' => 'post_', 'default' => true, 'default_value' => '-1']) 
					)
				]
			]
		],
		'page' => [
			'opt_name'            => 'pxl_page_options',
			'display_name'        => esc_html__( 'Page Options', 'meddox' ),
			'show_options_object' => false,
			'context'  => 'advanced',
			'priority' => 'default',
			'sections'  => [
				'header' => [
					'title'  => esc_html__( 'Header', 'meddox' ),
					'icon'   => 'el-icon-website',
					'fields' => array_merge(
						meddox_header_opts([
							'default'         => true,
							'default_value'   => '-1'
						]),
						array(
							array(
								'id'       => 'p_menu',
								'type'     => 'select',
								'title'    => esc_html__( 'Menu', 'meddox' ),
								'options'  => meddox_get_nav_menu_slug(),
								'default' => '',
							),
						)
					)

				],
				'page_title' => [
					'title'  => esc_html__( 'Page Title', 'meddox' ),
					'icon'   => 'el el-indent-left',
					'fields' => array_merge(
						meddox_page_title_opts([
							'default'         => true,
							'default_value'   => '-1'
						])
					)
				],
				'content' => [
					'title'  => esc_html__( 'Content', 'meddox' ),
					'icon'   => 'el-icon-pencil',
					'fields' => array_merge(
						meddox_sidebar_pos_opts(['prefix' => 'page_', 'default' => false, 'default_value' => '0']),
						array(
							array(
								'id'             => 'content_spacing',
								'type'           => 'spacing',
								'output'         => array( '#pxl-wapper #pxl-main' ),
								'right'          => false,
								'left'           => false,
								'mode'           => 'padding',
								'units'          => array( 'px' ),
								'units_extended' => 'false',
								'title'          => esc_html__( 'Spacing Top/Bottom', 'meddox' ),
								'default'        => array(
									'padding-top'    => '',
									'padding-bottom' => '',
									'units'          => 'px',
								)
							), 
							array(
								'id'       => 'content_bg_color',
								'type'     => 'color_rgba',
								'title'    => esc_html__('Background Color', 'meddox'),
								'subtitle' => esc_html__('Content background color.', 'meddox'),
								'output'   => array('background-color' => 'footer','background-color' => '#pxl-main','fill' => '#pxl-page-title-elementor .pxl-shape-divider svg')
							),
						)
					)
				],
				'footer' => [
					'title'  => esc_html__( 'Footer', 'meddox' ),
					'icon'   => 'el el-website',
					'fields' => array_merge(
						meddox_footer_opts([
							'default'         => true,
							'default_value'   => '-1'
						])
					)
				],
				'colors' => [
					'title'  => esc_html__( 'Colors', 'meddox' ),
					'icon'   => 'el el-website',
					'fields' => array_merge(
						array(
							array(
								'id'          => 'primary_color',
								'type'        => 'color',
								'title'       => esc_html__('Primary Color', 'meddox'),
								'transparent' => false,
								'default'     => ''
							),
							array(
								'id'          => 'secondary_color',
								'type'        => 'color',
								'title'       => esc_html__('Secondary Color', 'meddox'),
								'transparent' => false,
								'default'     => ''
							),
							array(
								'id'          => 'regular_color',
								'type'        => 'color',
								'title'       => esc_html__('Regular Color', 'meddox'),
								'transparent' => false,
								'default'     => ''
							),
							array(
								'id'          => 'fourth_color',
								'type'        => 'color',
								'title'       => esc_html__('Fourth Color', 'meddox'),
								'transparent' => false,
								'default'     => ''
							),
							array(
								'id'          => 'fifth_color',
								'type'        => 'color',
								'title'       => esc_html__('Fifth Color', 'meddox'),
								'transparent' => false,
								'default'     => ''
							),
						)
					)
				]
			]
		],
		'product' => [ //post_type
		'opt_name'            => 'pxl_product_options',
		'display_name'        => esc_html__( 'Product Settings', 'meddox' ),
		'show_options_object' => false,
		'context'  => 'advanced',
		'priority' => 'default',
		'sections'  => [
			'general' => [
				'title'  => esc_html__( 'General', 'meddox' ),
				'icon'   => 'el-icon-website',
				'fields' => array_merge(
					array(
						array(
							'id'=> 'product_feature_text',
							'type' => 'text',
							'title' => esc_html__('Featured Text', 'meddox'),
							'default' => '',
						),
					)
				)
			],
		]
	],
	'department' => [
		'opt_name'            => 'pxl_department_options',
		'display_name'        => esc_html__( 'Department Options', 'meddox' ),
		'show_options_object' => false,
		'context'  => 'advanced',
		'priority' => 'default',
		'sections'  => [
			'header' => [
				'title'  => esc_html__( 'General', 'meddox' ),
				'icon'   => 'el-icon-website',
				'fields' => array_merge(
					array(
						
						array(
							'id'=> 'department_excerpt',
							'type' => 'textarea',
							'title' => esc_html__('Excerpt', 'meddox'),
							'validate' => 'html_custom',
							'default' => 'Lorem Ipsum is simply text of the printing and typesetting industry. consectetur adipiscing elit.',
						),

						array(
							'id'       => 'department_icon_font',
							'type'     => 'pxl_iconpicker',
							'title'    => esc_html__('Icon Font', 'meddox'),
						),

						array(
							'id'             => 'content_spacing',
							'type'           => 'spacing',
							'output'         => array( '#pxl-wapper #pxl-main' ),
							'right'          => false,
							'left'           => false,
							'mode'           => 'padding',
							'units'          => array( 'px' ),
							'units_extended' => 'false',
							'title'          => esc_html__( 'Content Spacing Top/Bottom', 'meddox' ),
							'default'        => array(
								'padding-top'    => '',
								'padding-bottom' => '',
								'units'          => 'px',
							)
						),
					)
				)
			],
		]
	],
	'gallery' => [
		'opt_name'            => 'pxl_gallery_options',
		'display_name'        => esc_html__( 'Gallery Options', 'meddox' ),
		'show_options_object' => false,
		'context'  => 'advanced',
		'priority' => 'default',
		'sections'  => [
			'header' => [
				'title'  => esc_html__( 'General', 'meddox' ),
				'icon'   => 'el-icon-website',
				'fields' => array_merge(
					array(
						array(
							'id'=> 'gallery_type',
							'type' => 'text',
							'title' => esc_html__('School(Age)', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'=> 'gallery_class',
							'type' => 'text',
							'title' => esc_html__('Class', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'=> 'gallery_price',
							'type' => 'text',
							'title' => esc_html__('Price', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'=> 'gallery_time',
							'type' => 'text',
							'title' => esc_html__('Time', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'       => 'content_bg_color_gallery',
							'type'     => 'color_rgba',
							'title'    => esc_html__('Background Color', 'meddox'),
							'subtitle' => esc_html__('Content background color.', 'meddox'),
							'output'   => array('background-color' => '#pxl-main','fill' => '#pxl-page-title-elementor .pxl-shape-divider svg')
						),
						array(
							'id'       => 'content_bg_color_gallery_footer',
							'type'     => 'color_rgba',
							'title'    => esc_html__('Background Color Footer', 'meddox'),
							'output'   => array('background-color' => '#pxl-footer-elementor')
						),
						array(
							'id'=> 'gallery_excerpt',
							'type' => 'textarea',
							'title' => esc_html__('Excerpt', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),

						array(
							'id'       => 'gallery_icon_font',
							'type'     => 'pxl_iconpicker',
							'title'    => esc_html__('Icon Font', 'meddox'),
						),

						array(
							'id'             => 'content_spacing',
							'type'           => 'spacing',
							'output'         => array( '#pxl-wapper #pxl-main' ),
							'right'          => false,
							'left'           => false,
							'mode'           => 'padding',
							'units'          => array( 'px' ),
							'units_extended' => 'false',
							'title'          => esc_html__( 'Content Spacing Top/Bottom', 'meddox' ),
							'default'        => array(
								'padding-top'    => '',
								'padding-bottom' => '',
								'units'          => 'px',
							)
						),
					)
				)
			],
		]
	],
	'pxl_event' => [
		'opt_name'            => 'pxl_pxl_event_options',
		'display_name'        => esc_html__( 'pxl_event Options', 'meddox' ),
		'show_options_object' => false,
		'context'  => 'advanced',
		'priority' => 'default',
		'sections'  => [
			'header' => [
				'title'  => esc_html__( 'General', 'meddox' ),
				'icon'   => 'el-icon-website',
				'fields' => array_merge(
					array(
						array(
							'id'=> 'pxl_event_address',
							'type' => 'text',
							'title' => esc_html__('Address', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'=> 'pxl_event_date',
							'type' => 'text',
							'title' => esc_html__('Date', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'=> 'pxl_event_time',
							'type' => 'text',
							'title' => esc_html__('Time', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'       => 'content_bg_color_pxl_event',
							'type'     => 'color_rgba',
							'title'    => esc_html__('Background Color', 'meddox'),
							'subtitle' => esc_html__('Content background color.', 'meddox'),
							'output'   => array('background-color' => '#pxl-main','fill' => '#pxl-page-title-elementor .pxl-shape-divider svg')
						),
						array(
							'id'       => 'content_bg_color_pxl_event_footer',
							'type'     => 'color_rgba',
							'title'    => esc_html__('Background Color Footer', 'meddox'),
							'output'   => array('background-color' => '#pxl-footer-elementor')
						),
						array(
							'id'=> 'pxl_event_excerpt',
							'type' => 'textarea',
							'title' => esc_html__('Excerpt', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),

						array(
							'id'       => 'pxl_event_icon_font',
							'type'     => 'pxl_iconpicker',
							'title'    => esc_html__('Icon Font', 'meddox'),
						),

						array(
							'id'             => 'content_spacing',
							'type'           => 'spacing',
							'output'         => array( '#pxl-wapper #pxl-main' ),
							'right'          => false,
							'left'           => false,
							'mode'           => 'padding',
							'units'          => array( 'px' ),
							'units_extended' => 'false',
							'title'          => esc_html__( 'Content Spacing Top/Bottom', 'meddox' ),
							'default'        => array(
								'padding-top'    => '',
								'padding-bottom' => '',
								'units'          => 'px',
							)
						),
					)
				)
			],
		]
	],
	'careers' => [
		'opt_name'            => 'pxl_careers_options',
		'display_name'        => esc_html__( 'Careers Options', 'meddox' ),
		'show_options_object' => false,
		'context'  => 'advanced',
		'priority' => 'default',
		'sections'  => [
			'header' => [
				'title'  => esc_html__( 'General', 'meddox' ),
				'icon'   => 'el-icon-website',
				'fields' => array_merge(
					array(
						array(
							'id'    => 'careers_time',
							'type'  => 'select',
							'title' => esc_html__('Select Time', 'meddox'),
							'options' => [
								'fulltime'       	   => esc_html__('Full time', 'meddox'), 
								'parttime'       => esc_html__('Part time', 'meddox'), 
							],
							'default' => 'fulltime',
						),
						array(
							'id'    => 'careers_position',
							'type'  => 'text',
							'title' => esc_html__('Input Position', 'meddox'),
							'default' => 'New York',
						),
						array(
							'id'             => 'content_spacing',
							'type'           => 'spacing',
							'output'         => array( '#pxl-wapper #pxl-main' ),
							'right'          => false,
							'left'           => false,
							'mode'           => 'padding',
							'units'          => array( 'px' ),
							'units_extended' => 'false',
							'title'          => esc_html__( 'Content Spacing Top/Bottom', 'meddox' ),
							'default'        => array(
								'padding-top'    => '',
								'padding-bottom' => '',
								'units'          => 'px',
							)
						),

					)
				)
			],
		]
	],
	'service' => [
		'opt_name'            => 'pxl_service_options',
		'display_name'        => esc_html__( 'Service Options', 'meddox' ),
		'show_options_object' => false,
		'context'  => 'advanced',
		'priority' => 'default',
		'sections'  => [
			'header' => [
				'title'  => esc_html__( 'General', 'meddox' ),
				'icon'   => 'el-icon-website',
				'fields' => array_merge(
					array(
						array(
							'id'=> 'service_external_link',
							'type' => 'text',
							'title' => esc_html__('External Link', 'meddox'),
							'validate' => 'url',
							'default' => '',
						),
						array(
							'id'=> 'service_excerpt',
							'type' => 'textarea',
							'title' => esc_html__('Excerpt', 'meddox'),
							'validate' => 'html_custom',
							'default' => '',
						),
						array(
							'id'       => 'service_icon_type',
							'type'     => 'button_set',
							'title'    => esc_html__('Icon Type', 'meddox'),
							'options'  => array(
								'icon'  => esc_html__('Icon', 'meddox'),
								'image'  => esc_html__('Image', 'meddox'),
							),
							'default'  => 'icon'
						),
						array(
							'id'       => 'service_icon_font',
							'type'     => 'pxl_iconpicker',
							'title'    => esc_html__('Icon', 'meddox'),
							'required' => array( 0 => 'service_icon_type', 1 => 'equals', 2 => 'icon' ),
							'force_output' => true
						),
						array(
							'id'       => 'service_icon_img',
							'type'     => 'media',
							'title'    => esc_html__('Icon Image', 'meddox'),
							'default' => '',
							'required' => array( 0 => 'service_icon_type', 1 => 'equals', 2 => 'image' ),
							'force_output' => true
						),
						array(
							'id'             => 'content_spacing',
							'type'           => 'spacing',
							'output'         => array( '#pxl-wapper #pxl-main' ),
							'right'          => false,
							'left'           => false,
							'mode'           => 'padding',
							'units'          => array( 'px' ),
							'units_extended' => 'false',
							'title'          => esc_html__( 'Content Spacing Top/Bottom', 'meddox' ),
							'default'        => array(
								'padding-top'    => '',
								'padding-bottom' => '',
								'units'          => 'px',
							)
						),
					)
				)
			],
		]
	],
		'pxl-template' => [ //post_type
		'opt_name'            => 'pxl_hidden_template_options',
		'display_name'        => esc_html__( 'Template Options', 'meddox' ),
		'show_options_object' => false,
		'context'  => 'advanced',
		'priority' => 'default',
		'sections'  => [
			'header' => [
				'title'  => esc_html__( 'General', 'meddox' ),
				'icon'   => 'el-icon-website',
				'fields' => array(
					array(
						'id'    => 'template_type',
						'type'  => 'select',
						'title' => esc_html__('Type', 'meddox'),
						'options' => [
							'df'       	   => esc_html__('Select Type', 'meddox'), 
							'header'       => esc_html__('Header', 'meddox'), 
							'footer'       => esc_html__('Footer', 'meddox'), 
							'mega-menu'    => esc_html__('Mega Menu', 'meddox'), 
							'page-title'   => esc_html__('Page Title', 'meddox'), 
							'tab' => esc_html__('Tab', 'meddox'),
							'hidden-panel' => esc_html__('Hidden Panel', 'meddox'),
						],
						'default' => 'df',
					),
					array(
						'id'    => 'header_type',
						'type'  => 'button_set',
						'title' => esc_html__('Header Type', 'meddox'),
						'options' => [
							'px-header--default'       	   => esc_html__('Default', 'meddox'), 
							'px-header--transparent'       => esc_html__('Transparent', 'meddox'),
						],
						'default' => 'px-header--default',
						'indent' => true,
						'required' => array( 0 => 'template_type', 1 => 'equals', 2 => 'header' ),
					),
				),

			],
		]
	],
];

$metabox->add_meta_data( $panels );
}
