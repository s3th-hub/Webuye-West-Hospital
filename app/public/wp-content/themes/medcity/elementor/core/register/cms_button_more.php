<?php
// Register Button Widget
etc_add_custom_widget(
    array(
        'name' => 'cms_button_more',
        'title' => esc_html__('Button Read More', 'medcity' ),
        'icon' => 'eicon-button',
        'categories' => array( Elementor_Theme_Core::ETC_CATEGORY_NAME ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'content_section',
                    'label' => esc_html__('Content', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'more-default',
                            'options' => [
                                'more-default' => esc_html__('Default', 'medcity' ),
                                'more-invert' => esc_html__('Invert', 'medcity' ),
                                'hover-scale' => esc_html__('Scale Hover', 'medcity' ),
                            ],
                        ),
                        array(
                            'name' => 'text',
                            'label' => esc_html__('Text', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => 'Read More',
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
                            'name' => 'align',
                            'label' => esc_html__('Alignment', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::CHOOSE,
                            'options' => [
                                'left'    => [
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
                            'prefix_class' => 'elementor-align-',
                            'default' => '',
                        ),
                    ),
                ),
                array(
                    'name' => 'style_section',
                    'label' => esc_html__('Text Style', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'button_color',
                            'label' => esc_html__('Button Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-button-readmore .btn-read-more' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .cms-button-readmore .btn-read-more i' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'icon_color',
                            'label' => esc_html__('Icon Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-button-readmore .btn-read-more i' => 'color: {{VALUE}};',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);