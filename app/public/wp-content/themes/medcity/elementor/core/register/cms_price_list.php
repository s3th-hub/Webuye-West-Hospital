<?php
etc_add_custom_widget(
    array(
        'name' => 'cms_price_list',
        'title' => esc_html__('Price List', 'medcity'),
        'icon' => 'eicon-price-list',
        'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
        'scripts' => array(
        ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'layout_section',
                    'label' => esc_html__('Layout', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Templates', 'medcity' ),
                            'type' => Elementor_Theme_Core::LAYOUT_CONTROL,
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__('Layout 1', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_price_list/layout-image/layout1.jpg'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'content_list',
                    'label' => esc_html__('Content', 'medcity'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'list_title',
                            'label' => esc_html__('List Title', 'medcity'),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'price',
                            'label' => esc_html__('Add Item', 'medcity'),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(
                                array(
                                    'name' => 'item_text',
                                    'label' => esc_html__('Item Text', 'medcity'),
                                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'item_price',
                                    'label' => esc_html__('Item Price', 'medcity'),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                ),
                            ),
                            'title_field' => '{{{ item_text }}}',
                        ),
                    ),
                ),
                array(
                    'name' => 'section_style_settings',
                    'label' => esc_html__('Box Style', 'medcity'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'box_background',
                            'label' => esc_html__('Box Background', 'medcity'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-price-list' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'heading_color',
                            'label' => esc_html__('Heading Color', 'medcity'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-price-list h3.list-title' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'list_text_color',
                            'label' => esc_html__('Text List Color', 'medcity'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-price-list .item-text' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'list_price_bg',
                            'label' => esc_html__('List Price Background', 'medcity'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-price-list .price-item .item-inner .item-price' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'box_padding',
                            'label' => esc_html__('Box Padding', 'medcity'),
                            'type' => \Elementor\Controls_Manager::DIMENSIONS,
                            'control_type' => 'responsive',
                            'size_units'    => ['px', 'em', '%'],
                            'separator' => 'before',
                            'selectors'     => [
                                '{{WRAPPER}} .cms-price-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                            ]
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);