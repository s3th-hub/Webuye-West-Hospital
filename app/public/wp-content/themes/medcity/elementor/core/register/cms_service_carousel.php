<?php
// Post term options
$post_term_options = etc_get_grid_term_options('service');
$slides_to_show = range( 1, 3 );
$slides_to_show = array_combine( $slides_to_show, $slides_to_show );
// Register Post Carousel Widget
etc_add_custom_widget(
    array(
        'name'       => 'cms_service_carousel',
        'title'      => esc_html__('Service Carousel', 'medcity' ),
        'icon'       => 'eicon-posts-carousel',
        'categories' => array( Elementor_Theme_Core::ETC_CATEGORY_NAME ),
        'scripts'    => array(
            'jquery-slick',
            'cms-post-carousel-widget-js',
        ),
        'params' => array(
            'sections' => array(
                array(
                    'name'     => 'layout_section',
                    'label'    => esc_html__('Layout', 'medcity' ),
                    'tab'      => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Templates', 'medcity' ),
                            'type' => Elementor_Theme_Core::LAYOUT_CONTROL,
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__('Layout 1', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_service_carousel/layout-image/layout1.jpg'
                                ],
                                '2' => [
                                    'label' => esc_html__('Layout 2', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_service_carousel/layout-image/layout2.jpg'
                                ],
                                '3' => [
                                    'label' => esc_html__('Layout 3', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_service_carousel/layout-image/layout3.jpg'
                                ],
                                /**
                                 * @since 1.1.1
                                 * @author Chinh Duong Manh
                                 * */
                                '4' => [
                                    'label' => esc_html__('Layout 4', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_service_carousel/layout-image/4.webp'
                                ],
                                '5' => [
                                    'label' => esc_html__('Layout 5', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_service_carousel/layout-image/5.webp'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name'     => 'source_section',
                    'label'    => esc_html__('Source', 'medcity' ),
                    'tab'      => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name'         => 'thumbnail',
                            'type'         => \Elementor\Group_Control_Image_Size::get_type(),
                            'control_type' => 'group',
                            'default'      => 'full',
                        ),
                        array(
                            'name'     => 'source',
                            'label'    => esc_html__('Select Categories', 'medcity' ),
                            'type'     => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'options'  => $post_term_options,
                        ),
                        array(
                            'name'    => 'orderby',
                            'label'   => esc_html__('Order By', 'medcity' ),
                            'type'    => \Elementor\Controls_Manager::SELECT,
                            'default' => 'date',
                            'options' => [
                                'date' => esc_html__('Date', 'medcity' ),
                                'ID' => esc_html__('ID', 'medcity' ),
                                'author' => esc_html__('Author', 'medcity' ),
                                'title' => esc_html__('Title', 'medcity' ),
                                'rand' => esc_html__('Random', 'medcity' ),
                            ],
                        ),
                        array(
                            'name'    => 'order',
                            'label'   => esc_html__('Sort Order', 'medcity' ),
                            'type'    => \Elementor\Controls_Manager::SELECT,
                            'default' => 'desc',
                            'options' => [
                                'desc' => esc_html__('Descending', 'medcity' ),
                                'asc' => esc_html__('Ascending', 'medcity' ),
                            ],
                        ),
                        array(
                            'name'    => 'limit',
                            'label'   => esc_html__('Total items', 'medcity' ),
                            'type'    => \Elementor\Controls_Manager::NUMBER,
                            'default' => '6',
                        ),
                        array(
                            'name'      => 'num_words',
                            'label'     => esc_html__('Number of Words', 'medcity' ),
                            'type'      => \Elementor\Controls_Manager::NUMBER,
                            'default'   => 35,
                            'condition' => [
                                'layout!' => '1',
                            ],
                        ),
                        array(
                            'name'         => 'heading_typography',
                            'label'        => esc_html__('Title Typography', 'medcity' ),
                            'type'         => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector'     => '{{WRAPPER}} .grid-item-inner .entry-title',
                        )
                    ),
                ),
                array(
                    'name'     => 'section_carousel_settings',
                    'label'    => esc_html__('Carousel', 'medcity'),
                    'tab'      => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name'         => 'slides_to_show',
                            'label'        => esc_html__('Slides to Show', 'medcity'),
                            'type'         => \Elementor\Controls_Manager::SELECT,
                            'control_type' => 'responsive',
                            'options'      => [
                                    '' => esc_html__('Default', 'medcity' ),
                                ] + $slides_to_show,
                        ),
                        array(
                            'name'         => 'slides_to_scroll',
                            'label'        => esc_html__('Slides to Scroll', 'medcity'),
                            'type'         => \Elementor\Controls_Manager::SELECT,
                            'control_type' => 'responsive',
                            'options'      => [
                                    '' => esc_html__('Default', 'medcity' ),
                                ] + $slides_to_show,
                            'condition' => [
                                'slides_to_show!' => '1',
                            ],
                        ),
                        array(
                            'name'         => 'slides_gutter',
                            'label'        => esc_html__('Gutter', 'medcity'),
                            'type'         => \Elementor\Controls_Manager::NUMBER,
                            'control_type' => 'responsive',
                            'default'      => 15,
                            'condition'    => [
                                'slides_to_show!' => '1',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .cms-slick-carousel .slick-list .slick-slide' => 'padding: 0 {{VALUE}}px;',
                                '{{WRAPPER}} .cms-slick-carousel .slick-list' => 'margin: 0 -{{VALUE}}px;',
                            ],
                        ),
                        array(
                            'name'    => 'arrows',
                            'label'   => esc_html__('Show Arrows', 'medcity'),
                            'type'    => \Elementor\Controls_Manager::SWITCHER,
                            'default' => 'false',
                        ),
                        array(
                            'name'    => 'dots',
                            'label'   => esc_html__('Show Dots', 'medcity'),
                            'type'    => \Elementor\Controls_Manager::SWITCHER,
                            'default' => 'true',
                        ),
                        array(
                            'name'    => 'infinite',
                            'label'   => esc_html__('Infinite Loop', 'medcity'),
                            'type'    => \Elementor\Controls_Manager::SWITCHER,
                            'default' => 'true',
                        ),
                        array(
                            'name'    => 'speed',
                            'label'   => esc_html__('Animation Speed', 'medcity'),
                            'type'    => \Elementor\Controls_Manager::NUMBER,
                            'default' => 500,
                        ),
                    ),
                ),
                array(
                    'name'     => 'section_style_content',
                    'label'    => esc_html__('Style', 'medcity' ),
                    'tab'      => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name'      => 'dots_color',
                            'label'     => esc_html__('Dots Color', 'medcity' ),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .slick-dots li button' => 'background-color: {{VALUE}} !important;',
                            ],
                        ),
                        array(
                            'name'      => 'dots_color_active',
                            'label'     => esc_html__('Dots Color Active', 'medcity' ),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}} !important;',
                            ],
                        ),
                        array(
                            'name'         => 'dots_align',
                            'label'        => esc_html__('Dots Alignment', 'medcity' ),
                            'type'         => \Elementor\Controls_Manager::CHOOSE,
                            'control_type' => 'responsive',
                            'options'      => [
                                'flex-start' => [
                                    'title' => esc_html__('Left', 'medcity' ),
                                    'icon' => 'fa fa-align-left',
                                ],
                                'center' => [
                                    'title' => esc_html__('Center', 'medcity' ),
                                    'icon' => 'fa fa-align-center',
                                ],
                                'flex-end' => [
                                    'title' => esc_html__('Right', 'medcity' ),
                                    'icon' => 'fa fa-align-right',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .slick-dots' => 'justify-content: {{VALUE}} !important;',
                            ],
                        ),
                        array(
                            'name'       => 'box_border_radius',
                            'label'      => __( 'Border Radius', 'medcity' ),
                            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .grid-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                '{{WRAPPER}} .grid-item-inner .entry-featured' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                '{{WRAPPER}} .grid-item-inner .entry-featured img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);