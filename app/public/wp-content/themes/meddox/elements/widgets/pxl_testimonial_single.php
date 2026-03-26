<?php
// Register Image Box Widget
pxl_add_custom_widget(
    array(
        'name' => 'pxl_testimonial_single',
        'title' => esc_html__('Pxl Testimonial', 'meddox' ),
        'icon' => 'eicon-testimonial',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_layout',
                    'label' => esc_html__('Layout', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Templates', 'meddox' ),
                            'type' => 'layoutcontrol',
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__('Layout 1', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_testimonial_single/layout-image/layout1.jpg'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                     array(
                        'name' => 'pxl_icon',
                        'label' => esc_html__('Icon', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::ICONS,
                        'fa4compatibility' => 'icon',
                    ),
                     array(
                        'name' => 'title',
                        'label' => esc_html__('Title', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                    ),
                     array(
                        'name' => 'position',
                        'label' => esc_html__('Position', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                    ),
                     array(
                        'name' => 'desc',
                        'label' => esc_html__('Description', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'rows' => 10,
                        'show_label' => false,
                    ),
                 ),
                ),
                array(
                    'name' => 'section_style',
                    'label' => esc_html__('Style', 'meddox'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style-default' => 'Default',
                                'style-img-top' => 'Image Top',
                                'style-img-larger' => 'Image Larger',
                            ],
                            'default' => 'style-default',
                            'condition' => [
                                'layout' => ['1'],
                            ],
                        ),
                        array(
                            'name' => 'title_color',
                            'label' => esc_html__('Title Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-image-box .pxl-item--title' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .pxl-item-meta .pxl-item--title' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'title_typography',
                            'label' => esc_html__('Title Typography', 'meddox' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-image-box .pxl-item--title',
                            'selector' => '{{WRAPPER}} .pxl-item-meta .pxl-item--title',
                        ),
                        array(
                            'name' => 'pos_color',
                            'label' => esc_html__('Position Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-image-box .pxl-item--position' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .pxl-item-meta .pxl-item--position' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'pos_typography',
                            'label' => esc_html__('Position Typography', 'meddox' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-image-box .pxl-item--position',
                            'selector' => '{{WRAPPER}} .pxl-item-meta .pxl-item--position',
                        ),
                        array(
                            'name' => 'desc_color',
                            'label' => esc_html__('Description Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-image-box .pxl-item--description' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .pxl-item--inner .pxl-item--description' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'desc_typography',
                            'label' => esc_html__('Description Typography', 'meddox' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-image-box .pxl-item--description',
                            'selector' => '{{WRAPPER}} .pxl-item--inner .pxl-item--description',
                        ),
                    ),
                ),
meddox_widget_animation_settings(),
),
),
),
meddox_get_class_widget_path()
);