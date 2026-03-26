<?php 

add_action( 'elementor/element/section/section_structure/after_section_end', 'meddox_add_custom_section_controls' ); 
add_action( 'elementor/element/column/layout/after_section_end', 'meddox_add_custom_columns_controls' ); 
function meddox_add_custom_section_controls( \Elementor\Element_Base $element) {

	$element->start_controls_section(
		'section_pxl',
		[
			'label' => esc_html__( 'Meddox Settings', 'meddox' ),
			'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
		]
	);

	$element->add_control(
		'header_layout_type',
		[
			'label'   => esc_html__( 'Header Layout Type', 'meddox' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => array(
				'none'        => esc_html__( 'None', 'meddox' ),
				'clip'   => esc_html__( 'Clip', 'meddox' ),
			),
			'prefix_class' => 'pxl-type-header-',
			'default'      => 'none',
		]
	);


	$element->add_control(
		'pxl_color_offset',
		[
			'label'   => esc_html__( 'Background - Left Space', 'meddox' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => array(
				'none'        => esc_html__( 'No', 'meddox' ),
				'left'   => esc_html__( 'Yes', 'meddox' ),
			),
			'prefix_class' => 'pxl-bg-color-',
			'default'      => 'none',
		]
	);

	$element->add_control(
		'offset_color',
		[
			'label' => esc_html__('Background Color', 'meddox' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}}.pxl-bg-color-left:before' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'pxl_color_offset' => ['left'],
			],
		]
	);

	$element->add_control(
		'row_divider',
		[
			'label'   => esc_html__( 'Divider', 'meddox' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => array(
				''        => esc_html__( 'None', 'meddox' ),
				'shape-top'   => esc_html__( 'Shape Top', 'meddox' ),
				'shape-bottom'   => esc_html__( 'Shape Bottom', 'meddox' ),
				'shape-top-bottom'   => esc_html__( 'Shape Top Bottom', 'meddox' ),
			),
			'prefix_class' => 'pxl-row-divider-',
			'default'      => '',
		]
	);

	$element->add_control(
		'divider_color',
		[
			'label' => esc_html__('Divider Color', 'meddox' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .pxl-shape-divider .pxl-row-angle' => 'fill: {{VALUE}};',
			],
			'condition' => [
				'row_divider' => ['shape-bottom','shape-top','shape-top-bottom'],
			],
		]
	);
	$element->add_control(
		'divider_color_bottom',
		[
			'label' => esc_html__('Divider Color Bottom', 'meddox' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .pxl-shape-divider .pxl-row-angle-bottom' => 'fill: {{VALUE}} !important;',
			],
			'condition' => [
				'row_divider' => ['shape-bottom','shape-top-bottom'],
			],
		]
	);

	$element->add_control(
		'divider_height',
		[
			'label' => esc_html__('Divider Height', 'meddox' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'control_type' => 'responsive',
			'size_units' => [ 'px' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 3000,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .pxl-shape-divider .pxl-row-angle' => 'height: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'after',
			'condition' => [
				'row_divider' => ['shape-bottom','shape-top','shape-top-bottom'],
			],
		]
	);

	$element->add_control(
		'full_content_with_space',
		[
			'label' => esc_html__( 'Full Content with space from?', 'meddox' ),
			'type'         => \Elementor\Controls_Manager::SELECT,
			'prefix_class' => 'pxl-full-content-with-space-',
			'options'      => array(
				'none'    => esc_html__( 'None', 'meddox' ),
				'start'   => esc_html__( 'Start', 'meddox' ),
				'end'     => esc_html__( 'End', 'meddox' ),
			),
			'default'      => 'none',
			'condition' => [
				'layout' => 'full_width'
			]
		]
	);

	$element->add_control(
		'pxl_container_width',
		[
			'label' => esc_html__('Container Width', 'meddox'),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => 1200,
			'condition' => [
				'layout' => 'full_width',
				'full_content_with_space!' => 'none'
			]           
		]
	);

	$element->add_control(
		'row_scroll_fixed',
		[
			'label'   => esc_html__( 'Row Scroll - Column Fixed', 'meddox' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => array(
				'none'        => esc_html__( 'No', 'meddox' ),
				'fixed'   => esc_html__( 'Yes', 'meddox' ),
			),
			'prefix_class' => 'pxl-row-scroll-',
			'default'      => 'none',      
		]
	);


	$element->end_controls_section();
};

function meddox_add_custom_columns_controls( \Elementor\Element_Base $element) {
	$element->start_controls_section(
		'columns_pxl',
		[
			'label' => esc_html__( 'meddox Settings', 'meddox' ),
			'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
		]
	);
	$element->add_control(
		'col_line',
		[
			'label'   => esc_html__( 'Column Line Style', 'meddox' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => array(
				'none'           => esc_html__( 'None', 'meddox' ),
				'line1'           => esc_html__( 'Line 1', 'meddox' ),
				'line2'           => esc_html__( 'Line 2', 'meddox' ),
			),
			'default' => 'none',
			'prefix_class' => 'pxl-col-'
		]
	);

	$element->add_control(
		'col_line_color',
		[
			'label' => esc_html__('Column Line Color', 'meddox' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}}.pxl-col-line2:before' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'col_line' => ['line2'],
			],
		]
	);

	$element->add_control(
		'col_line_height',
		[
			'label' => esc_html__('Column Line Height', 'meddox' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'control_type' => 'responsive',
			'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 3000,
				],
			],
			'selectors' => [
				'{{WRAPPER}}.pxl-col-line2:before' => 'height: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'after',
			'condition' => [
				'col_line' => ['line2'],
			],
		]
	);

	$element->add_control(
		'col_content_align',
		[
			'label'   => esc_html__( 'Column Content Align', 'meddox' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => array(
				''           => esc_html__( 'Default', 'meddox' ),
				'start'           => esc_html__( 'Start', 'meddox' ),
				'center'           => esc_html__( 'Center', 'meddox' ),
				'end'           => esc_html__( 'End', 'meddox' ),
			),
			'default' => '',
			'prefix_class' => 'pxl-col-align-'
		]
	);
	$element->add_control(
		'col_sticky',
		[
			'label'   => esc_html__( 'Column Sticky', 'meddox' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => array(
				'none'           => esc_html__( 'No', 'meddox' ),
				'sticky' => esc_html__( 'Yes', 'meddox' ),
			),
			'default' => 'none',
			'prefix_class' => 'pxl-column-'
		]
	);
	$element->end_controls_section();
}

add_action( 'elementor/element/after_add_attributes', 'meddox_custom_el_attributes', 10, 1 );
function meddox_custom_el_attributes($el){
	if( 'section' !== $el->get_name() ) {
		return;
	}
	$settings = $el->get_settings();

	$pxl_container_width = !empty($settings['pxl_container_width']) ? (int)$settings['pxl_container_width'] : 1200;

	if( isset( $settings['stretch_section']) && $settings['stretch_section'] == 'section-stretched') 
		$pxl_container_width = $pxl_container_width - 30;

	$pxl_container_width = $pxl_container_width.'px';

	if ( isset( $settings['full_content_with_space'] ) && $settings['full_content_with_space'] === 'start' ) {

		$el->add_render_attribute( '_wrapper', 'style', 'padding-left: calc( (100% - '.$pxl_container_width.')/2);');
	}
	if ( isset( $settings['full_content_with_space'] ) && $settings['full_content_with_space'] === 'end' ) {

		$el->add_render_attribute( '_wrapper >', 'style', 'padding-right: calc( (100% - '.$pxl_container_width.')/2);');
	}
}
add_filter( 'pxl-custom-section/before-render', 'meddox_custom_section_before_render', 10, 3 );
function meddox_custom_section_before_render($custom,$settings,$el){
	if ($settings['row_divider'] == 'shape-bottom') {
		$custom =  '<div class="pxl-shape-divider">
		<svg class="pxl-row-angle pxl-row-angle-bottom" width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 150" >
		<path d="M 0 26.1978 C 275.76 83.8152 430.707 65.0509 716.279 25.6386 C 930.422 -3.86123 1210.32 -3.98357 1439 9.18045 C 2072.34 45.9691 2201.93 62.4429 2560 26.198 V 172.199 L 0 172.199 V 26.1978 Z">
		<animate repeatCount="indefinite" fill="freeze" attributeName="d" dur="10s" values="M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z; M0 86.3149C316 86.315 444 159.155 884 51.1554C1324 -56.8446 1320.29 34.1214 1538 70.4063C1814 116.407 2156 188.408 2560 86.315V232.317L0 232.316V86.3149Z; M0 53.6584C158 11.0001 213 0 363 0C513 0 855.555 115.001 1154 115.001C1440 115.001 1626 -38.0004 2560 53.6585V199.66L0 199.66V53.6584Z; M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z">
		</animate>
		</path>
		</svg>
		</div>';
		return $custom;
	}
	if ($settings['row_divider'] == 'shape-top') {
		$custom =  '<div class="pxl-shape-divider" >
		<svg class="pxl-row-angle pxl-row-angle-top"   width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 150" >
		<path d="M 0 26.1978 C 275.76 83.8152 430.707 65.0509 716.279 25.6386 C 930.422 -3.86123 1210.32 -3.98357 1439 9.18045 C 2072.34 45.9691 2201.93 62.4429 2560 26.198 V 172.199 L 0 172.199 V 26.1978 Z">
		<animate repeatCount="indefinite" fill="freeze" attributeName="d" dur="10s" values="M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z; M0 86.3149C316 86.315 444 159.155 884 51.1554C1324 -56.8446 1320.29 34.1214 1538 70.4063C1814 116.407 2156 188.408 2560 86.315V232.317L0 232.316V86.3149Z; M0 53.6584C158 11.0001 213 0 363 0C513 0 855.555 115.001 1154 115.001C1440 115.001 1626 -38.0004 2560 53.6585V199.66L0 199.66V53.6584Z; M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z">
		</animate>
		</path>
		</svg>
		</div>';
		return $custom;
	}
	if ($settings['row_divider']== 'shape-top-bottom') {
		$custom =  '<div class="pxl-shape-divider" >
		<svg class="pxl-row-angle pxl-row-angle-top"   width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 150" >
		<path d="M 0 26.1978 C 275.76 83.8152 430.707 65.0509 716.279 25.6386 C 930.422 -3.86123 1210.32 -3.98357 1439 9.18045 C 2072.34 45.9691 2201.93 62.4429 2560 26.198 V 172.199 L 0 172.199 V 26.1978 Z">
		<animate repeatCount="indefinite" fill="freeze" attributeName="d" dur="10s" values="M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z; M0 86.3149C316 86.315 444 159.155 884 51.1554C1324 -56.8446 1320.29 34.1214 1538 70.4063C1814 116.407 2156 188.408 2560 86.315V232.317L0 232.316V86.3149Z; M0 53.6584C158 11.0001 213 0 363 0C513 0 855.555 115.001 1154 115.001C1440 115.001 1626 -38.0004 2560 53.6585V199.66L0 199.66V53.6584Z; M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z">
		</animate>
		</path>
		</svg>
		<svg class="pxl-row-angle pxl-row-angle-bottom"   width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 150" >
		<path d="M 0 26.1978 C 275.76 83.8152 430.707 65.0509 716.279 25.6386 C 930.422 -3.86123 1210.32 -3.98357 1439 9.18045 C 2072.34 45.9691 2201.93 62.4429 2560 26.198 V 172.199 L 0 172.199 V 26.1978 Z">
		<animate repeatCount="indefinite" fill="freeze" attributeName="d" dur="10s" values="M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z; M0 86.3149C316 86.315 444 159.155 884 51.1554C1324 -56.8446 1320.29 34.1214 1538 70.4063C1814 116.407 2156 188.408 2560 86.315V232.317L0 232.316V86.3149Z; M0 53.6584C158 11.0001 213 0 363 0C513 0 855.555 115.001 1154 115.001C1440 115.001 1626 -38.0004 2560 53.6585V199.66L0 199.66V53.6584Z; M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z">
		</animate>
		</path>
		</svg>
		</div>';
		return $custom;
	}
}