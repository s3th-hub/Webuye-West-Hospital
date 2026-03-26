<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_calendar',
        'title' => esc_html__('Pxl Calendar', 'meddox'),
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
                                'style1' => 'Style 1',
                                'style2' => 'Style 2',
                            ],
                            'default' => 'style1',
                        ),
                        array(
                            'name' => 'text_date',
                            'label' => esc_html__('Month', 'meddox'),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
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
                            '{{WRAPPER}} .pxl-calendar' => 'text-align: {{VALUE}};',
                        ],
                    ),
                        array(
                            'name' => 'bg_icon_link_color',
                            'label' => esc_html__('Background Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wrap-content-calendar:before' => 'background-color: {{VALUE}};',
                                '{{WRAPPER}} .wrap-content-calendar:after' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'icon_arrow_color',
                            'label' => esc_html__('Arrow Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .icon-after svg' => 'fill: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'month_color',
                            'label' => esc_html__('Date Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .month' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'link_color',
                            'label' => esc_html__('Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-calendar a' => 'color: {{VALUE}};',
                            ],
                        ),
                        
                        array(
                            'name' => 'link_color_hover',
                            'label' => esc_html__('Color Hover', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-calendar a:hover' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'link_typography',
                            'label' => esc_html__('Typography', 'meddox' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-calendar a',
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
                                '{{WRAPPER}} .pxl-calendar li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                            ],
                        ),
                        array(
                            'name' => 'hover_style',
                            'label' => esc_html__('Style', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'hv-style1' => 'Style 1',
                                'hv-style2' => 'Style 2',
                                'hv-style3' => 'Style 3',
                                'hv-style4' => 'Style 4 (Box White)',
                                'hv-style5' => 'Style 5 (Box White)',
                                'hv-style6' => 'Style 6 (Box White)',
                                'hv-style7' => 'Style 7 (Icon Box Gradient)',
                                'hv-style8' => 'Style 8 (Horizontal Divider)',
                            ],
                            'default' => 'hv-style1',
                        ),
                        array(
                            'name' => 'divider_color',
                            'label' => esc_html__('Divider Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-calendar a:before' => 'background-color: {{VALUE}};',
                                '{{WRAPPER}} .pxl-calendar li' => 'border-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'hover_style' => ['hv-style2','hv-style3','hv-style8']
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
                '{{WRAPPER}} .pxl-calendar a i' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .pxl-calendar a i' => 'margin-top: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .pxl-calendar a i' => 'font-size: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .pxl-calendar a i' => 'min-width: {{SIZE}}{{UNIT}};',
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