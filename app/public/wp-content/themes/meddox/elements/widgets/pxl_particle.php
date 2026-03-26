<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_particle',
        'title' => esc_html__('Pxl Particle', 'meddox' ),
        'icon' => 'eicon-barcode',
        'categories' => array('pxltheme-core'),
        'scripts' => [
            'meddox-particle',
            'meddox-parallax',
        ],
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'tab_content',
                    'label' => esc_html__('Content', 'meddox'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'images',
                            'label' => esc_html__('Images', 'meddox'),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'default' => [],
                            'controls' => array(
                                array(
                                    'name' => 'particle',
                                    'label' => esc_html__( 'Particle', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::MEDIA,
                                ),
                                array(
                                    'name' => 'type_position',
                                    'label' => esc_html__('Position', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'options' => [
                                        'top-left' => 'Top Left',
                                        'top-right' => 'Top Right',
                                        'bottom-left' => 'Bottom Left',
                                        'bottom-right' => 'Bottom Right',
                                    ],
                                    'default' => 'top-left',
                                ),
                                array(
                                    'name' => 'top_positioon',
                                    'label' => esc_html__('Top Position', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SLIDER,
                                    'size_units' => [ 'px', '%' ],
                                    'control_type' => 'responsive',
                                    'default' => [
                                        'size' => 0,
                                        'unit' => '%',
                                    ],
                                    'range' => [
                                        '%' => [
                                            'min' => -100,
                                            'max' => 100,
                                        ],
                                    ],
                                    'selectors' => [
                                        'body:not(.elementor-editor-active) {{WRAPPER}} .pxl-particle {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
                                    ],
                                    'condition' => [
                                        'type_position' => ['top-left', 'top-right'],
                                    ],
                                ),
                                array(
                                    'name' => 'left_positioon',
                                    'label' => esc_html__('Left Position', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SLIDER,
                                    'size_units' => [ 'px', '%' ],
                                    'control_type' => 'responsive',
                                    'default' => [
                                        'size' => 0,
                                        'unit' => '%',
                                    ],
                                    'range' => [
                                        '%' => [
                                            'min' => -1000,
                                            'max' => 1000,
                                        ],
                                    ],
                                    'selectors' => [
                                        'body:not(.elementor-editor-active) {{WRAPPER}} .pxl-particle {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
                                    ],
                                    'condition' => [
                                        'type_position' => ['top-left','bottom-left'],
                                    ],
                                ),
                                array(
                                    'name' => 'bottom_positioon',
                                    'label' => esc_html__('Bottom Position', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SLIDER,
                                    'size_units' => [ 'px', '%' ],
                                    'control_type' => 'responsive',
                                    'default' => [
                                        'size' => 0,
                                        'unit' => '%',
                                    ],
                                    'range' => [
                                        '%' => [
                                            'min' => 0,
                                            'max' => 100,
                                        ],
                                    ],
                                    'selectors' => [
                                        'body:not(.elementor-editor-active) {{WRAPPER}} .pxl-particle {{CURRENT_ITEM}}' => 'bottom: {{SIZE}}{{UNIT}};',
                                    ],
                                    'condition' => [
                                        'type_position' => ['bottom-right','bottom-left'],
                                    ],
                                ),
                                array(
                                    'name' => 'right_positioon',
                                    'label' => esc_html__('Right Position', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SLIDER,
                                    'size_units' => [ 'px', '%' ],
                                    'control_type' => 'responsive',
                                    'default' => [
                                        'size' => 0,
                                        'unit' => '%',
                                    ],
                                    'range' => [
                                        '%' => [
                                            'min' => 0,
                                            'max' => 100,
                                        ],
                                    ],
                                    'selectors' => [
                                        'body:not(.elementor-editor-active) {{WRAPPER}} .pxl-particle {{CURRENT_ITEM}}' => 'right: {{SIZE}}{{UNIT}};',
                                    ],
                                    'condition' => [
                                        'type_position' => ['top-right', 'bottom-right'],
                                    ],
                                ),
                                array(
                                    'name' => 'particle_effect',
                                    'label' => esc_html__('Effect', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '',
                                    'options' => [
                                        '' => 'None',
                                        'move-parallax' => 'Parallax',
                                        'slide-bottom-to-top' => 'Slide Bottom To Top',
                                        'slide-top-to-bottom' => 'Slide Top To Bottom',
                                        'slide-left-to-right' => 'Slide Left To Right',
                                        'slide-right-to-left' => 'Slide Right To Left',
                                        'slide-effect1' => 'Effect 1',
                                        'slide-effect2' => 'Effect 2',
                                    ],
                                ),
                                array(
                                    'name' => 'parallax_speed',
                                    'label' => esc_html__('Parallax Speed', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'condition' => [
                                        'particle_effect' => 'move-parallax',
                                    ],
                                    'default' => '6',
                                ),
                                array(
                                    'name' => 'parallax_move',
                                    'label' => esc_html__('Parallax Move', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'condition' => [
                                        'particle_effect' => 'move-parallax',
                                    ],
                                    'default' => '60',
                                ),
                                array(
                                    'name' => 'pxl_animate',
                                    'label' => esc_html__('Animate', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'options' => meddox_widget_animate(),
                                    'default' => '',
                                ),
                                array(
                                    'name' => 'pxl_animate_delay',
                                    'label' => esc_html__('Animate Delay', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'default' => '0',
                                    'description' => 'Enter number. Default 0ms',
                                ),
                            ),
                        ),
                        array(
                            'name' => 'image_visible',
                            'label' => esc_html__('Image Visible', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'img-below-content' => 'Below Content',
                                'img-above-content' => 'Above Content',
                            ],
                            'default' => 'img-below-content',
                        ),
                        /*array(
                            'name' => 'image_section',
                            'label' => esc_html__('Image Show Section', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'parents' => 'Main',
                                'inner' => 'Inner',
                            ],
                            'default' => 'parents',
                        ),*/
                    ),
                ),
            ),
        ),
    ),
    meddox_get_class_widget_path()
);