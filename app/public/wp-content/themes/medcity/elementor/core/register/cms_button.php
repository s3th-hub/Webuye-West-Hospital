<?php
// Register Button Widget
etc_add_custom_widget(
    array(
        'name' => 'cms_button',
        'title' => esc_html__('Button', 'medcity' ),
        'icon' => 'eicon-button',
        'categories' => array( Elementor_Theme_Core::ETC_CATEGORY_NAME ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'source_section',
                    'label' => esc_html__('Source Settings', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'btn-default',
                            'options' => [
                                'btn-default' => esc_html__('Default', 'medcity' ),
                                'btn-fullwidth' => esc_html__('Full Width', 'medcity' ),
                                'white-hover' => esc_html__('White Hover', 'medcity' ),
                                'btn-secondary' => esc_html__('Secondary', 'medcity' ),
                                'btn-white' => esc_html__('White', 'medcity' ),
                                'btn-white-secondary' => esc_html__('White Secondary', 'medcity' ),
                                'btn-outline' => esc_html__('Outline', 'medcity' ),
                                'btn-outline-secondary' => esc_html__('Outline Secondary', 'medcity' ),
                                'btn-outline-white' => esc_html__('Outline White', 'medcity' ),
                            ],
                        ),
                        array(
                            'name' => 'text',
                            'label' => esc_html__('Text', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => esc_html__('Click here', 'medcity'),
                            'placeholder' => esc_html__('Click here', 'medcity'),
                        ),
                        array(
                            'name' => 'link',
                            'label' => esc_html__('Link', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::URL,
                            'placeholder' => esc_html__('https://your-link.com', 'medcity' ),
                            'default' => [
                                'url' => '#',
                            ],
                        ),
                        array(
                            'name' => 'text_align',
                            'label' => esc_html__('Alignment', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::CHOOSE,
                            'control_type' => 'responsive',
                            'options' => [
                                'left' => [
                                    'title' => esc_html__('Left', 'medcity' ),
                                    'icon' => 'fa fa-align-left',
                                ],
                                'center' => [
                                    'title' => esc_html__('Center', 'medcity' ),
                                    'icon' => 'fa fa-align-center',
                                ],
                                'right' => [
                                    'title' => esc_html__('Right', 'medcity' ),
                                    'icon' => 'fa fa-align-right',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .cms-button' => 'text-align: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'btn_icon',
                            'label' => esc_html__('Icon', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::ICONS,
                            'label_block' => true,
                            'fa4compatibility' => 'icon',
                        ),
                        array(
                            'name' => 'icon_align',
                            'label' => esc_html__('Icon Position', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'right',
                            'options' => [
                                'right' => esc_html__('After', 'medcity' ),
                                'left' => esc_html__('Before', 'medcity' ),
                            ],
                            'condition' => [
                                'btn_icon!' => '',
                            ],
                        ),
                        array(
                            'name' => 'icon_indent',
                            'label' => esc_html__('Icon Spacing', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'range' => [
                                'px' => [
                                    'min' => 5,
                                    'max' => 50,
                                ],
                            ],
                            'condition' => [
                                'btn_icon!' => '',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .cms-button .cms-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .cms-button .cms-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_style_button',
                    'label' => esc_html__('Button Style', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'background_color',
                            'label' => esc_html__('Background Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-button .btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'button_color',
                            'label' => esc_html__('Button Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-button .btn' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'hover_background',
                            'label' => esc_html__('Hover Background', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-button .btn:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'hover_color',
                            'label' => esc_html__('Hover Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-button .btn:hover' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name'  => 'button_border_radius',
                            'label' => __( 'Border Radius', 'medcity' ),
                            'type' =>\Elementor\Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .cms-button .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ),
                        array(
                            'name' => 'button_padding',
                            'label' => esc_html__('Padding', 'medcity'),
                            'type' => \Elementor\Controls_Manager::DIMENSIONS,
                            'control_type' => 'responsive',
                            'size_units'    => ['px', 'em', '%'],
                            'separator' => 'before',
                            'selectors'     => [
                                '{{WRAPPER}} .cms-button .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                            ]
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);