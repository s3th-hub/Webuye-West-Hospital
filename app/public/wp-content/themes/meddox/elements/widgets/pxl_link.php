<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_link',
        'title' => esc_html__('Pxl Links', 'meddox'),
        'icon' => 'eicon-editor-link',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'meddox'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'style_list',
                            'label' => esc_html__('Style', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'vertical' => 'Vertical',
                                'horizontal' => 'Horizontal',
                            ],
                            'default' => 'vertical',
                        ),
                        array(
                            'name' => 'right_spacer',
                            'label' => esc_html__('Right Spacer', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 300,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-link li' => 'margin-right: {{SIZE}}{{UNIT}};',
                            ],
                            'condition' => [
                                'style_list' => ['horizontal'],
                            ],
                        ),
                        array(
                            'name' => 'height',
                            'label' => esc_html__('Line Height', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 300,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-link' => 'line-height: {{SIZE}}{{UNIT}};',
                            ],
                            'condition' => [
                                'style_list' => ['horizontal'],
                            ],
                        ),
                        array(
                            'name' => 'bottom_spacer',
                            'label' => esc_html__('Bottom Spacer', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 300,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-link li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                            ],
                            'condition' => [
                                'style_list' => ['vertical'],
                            ],
                        ),
                        array(
                            'name' => 'link',
                            'label' => esc_html__('Link', 'meddox'),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(

                                array(
                                    'name' => 'text',
                                    'label' => esc_html__('Text', 'meddox'),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'link',
                                    'label' => esc_html__('Link', 'meddox'),
                                    'type' => \Elementor\Controls_Manager::URL,
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'pxl_icon',
                                    'label' => esc_html__('Icon', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::ICONS,
                                    'fa4compatibility' => 'icon',
                                ),
                                array(
                                    'name' => 'bg_icon_link_color',
                                    'label' => esc_html__('Background Icon Color', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::COLOR,
                                    'selectors' => [
                                        '{{WRAPPER}} {{CURRENT_ITEM}}  i' => 'background-color: {{VALUE}};',
                                    ],
                                ),
                                array(
                                    'name' => 'pxl_link_active',
                                    'label' => esc_html__('Active', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'options' => [
                                        'default' => [
                                            'title' => esc_html__( 'Default','meddox'),
                                        ],
                                        'true' => [
                                            'title' => esc_html__( 'Active','meddox'),
                                        ],

                                    ],
                                    'default' => 'default',
                                ),
                                array(
                                    'name' => 'pxl_link_active_color',
                                    'label' => esc_html__('Active Color', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::COLOR,
                                    'selectors' => [
                                        '{{WRAPPER}} {{CURRENT_ITEM}}  a' => 'color: {{VALUE}};',
                                    ],
                                    'condition' => [
                                        'pxl_link_active' => ['true'],
                                    ],
                                ),
                                array(
                                    'name' => 'item_right_spacer',
                                    'label' => esc_html__('Left Spacer', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SLIDER,
                                    'control_type' => 'responsive',
                                    'size_units' => [ 'px' ],
                                    'range' => [
                                        'px' => [
                                            'min' => 0,
                                            'max' => 300,
                                        ],
                                    ],
                                    'selectors' => [
                                        '{{WRAPPER}} .pxl-link {{CURRENT_ITEM}}' => 'margin-left: {{SIZE}}{{UNIT}};',
                                    ],
                                ),

                            ),
'title_field' => '{{{ text }}}',
),
),
),
array(
    'name' => 'section_style_link',
    'label' => esc_html__('Link', 'meddox'),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'style',
            'label' => esc_html__('Style Content', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'style1' => 'Style 1 (Categories Department)',
                'style2' => 'Style 2 (Benfits)',
                'style3' => 'Style 3 (Footer)',
                'style4' => 'Style 4 (Footer Link CopyRight)',
                'style5' => 'Style 5 (Contact info)',
                'style6' => 'Style 6 (Blog)',
            ],
            'default' => 'style1',
        ),
        array(
          'name' => 'align',
          'label' => esc_html__( 'Alignment', 'meddox' ),
          'type' => \Elementor\Controls_Manager::CHOOSE,
          'control_type' => 'responsive',
          'options' => [
            'left' => [
                'title' => esc_html__( 'Left', 'meddox' ),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'meddox' ),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => esc_html__( 'Right', 'meddox' ),
                'icon' => 'eicon-text-align-right',
            ],
            'justify' => [
                'title' => esc_html__( 'Justified', 'meddox' ),
                'icon' => 'eicon-text-align-justify',
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .pxl-link' => 'text-align: {{VALUE}};',
        ],
    ),
        array(
            'name' => 'link_color',
            'label' => esc_html__('Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-link a' => 'color: {{VALUE}};',
            ],
        ),
        array(
            'name' => 'link_color_hover',
            'label' => esc_html__('Color Hover', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-link li:hover a, {{WRAPPER}} .pxl-link a:hover i' => 'color: {{VALUE}} !important;',
            ],
        ),
        array(
            'name' => 'link_typography',
            'label' => esc_html__('Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-link a',

        ),
        array(
            'name' => 'link_custom_font_family',
            'label' => esc_html__('Custom Font Family', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => 'Inherit',
                'ft-walsheim' => 'GT Walsheim Pro',
            ],
            'default' => '',
        ),

        array(
            'name' => 'divider_color',
            'label' => esc_html__('Divider Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-link a:before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .pxl-link li' => 'border-color: {{VALUE}};',
            ],

        ),
    ),
),
array(
    'name' => 'section_style_icon',
    'label' => esc_html__('Icon', 'meddox'),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(

        array(
            'name' => 'icon_color',
            'label' => esc_html__('Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-link a i' => 'color: {{VALUE}};',
            ],
        ),
        array(
            'name' => 'icon_color_hover',
            'label' => esc_html__('Color Hover', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-link a:hover i' => 'color: {{VALUE}} !important;',
            ],
        ),
        array(
            'name' => 'icon_typography',
            'label' => esc_html__('Icon Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-link a i',

        ),
        array(
            'name' => 'background_icon_color',
            'label' => esc_html__('Background Icon Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-link a i' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'style' => ['style2'],
            ],
        ),
        array(
            'name' => 'icon_space_top',
            'label' => esc_html__('Top Spacer', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-link a i' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ),
        array(
            'name' => 'icon_font_size',
            'label' => esc_html__('Font Size', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-link a i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ),
        array(
            'name' => 'icon_width',
            'label' => esc_html__('Min Width', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-link a i' => 'min-width: {{SIZE}}{{UNIT}};',
            ],
        ),
    ),
),
meddox_widget_animation_settings(),
),
),
),
meddox_get_class_widget_path()
);