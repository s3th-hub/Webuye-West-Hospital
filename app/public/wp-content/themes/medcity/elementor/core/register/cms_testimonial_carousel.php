<?php
$slides_to_show = range( 1, 5 );
$slides_to_show = array_combine( $slides_to_show, $slides_to_show );

// Register Contact Form 7 Widget
etc_add_custom_widget(
    array(
        'name' => 'cms_testimonial_carousel',
        'title' => esc_html__('Testimonial Carousel', 'medcity'),
        'icon' => 'eicon-testimonial-carousel',
        'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
        'scripts' => array(
            'jquery-slick',
            'cms-post-carousel-widget-js',
        ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'layout_section',
                    'label' => esc_html__( 'Layout', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__( 'Templates', 'medcity' ),
                            'type' => Elementor_Theme_Core::LAYOUT_CONTROL,
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__( 'Layout 1', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonial_carousel/layout-image/layout1.jpg'
                                ],
                                '2' => [
                                    'label' => esc_html__( 'Layout 2', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonial_carousel/layout-image/layout2.jpg'
                                ],
                                '3' => [
                                    'label' => esc_html__( 'Layout 3', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonial_carousel/layout-image/layout3.jpg'
                                ],
                                '4' => [
                                    'label' => esc_html__( 'Layout 4', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonial_carousel/layout-image/layout4.jpg'
                                ],
                                '5' => [
                                    'label' => esc_html__( 'Layout 5', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonial_carousel/layout-image/layout5.jpg'
                                ],
                                /**
                                 * @since 1.1.1
                                 * @author Chinh Duong Manh
                                 * */
                                '6' => [
                                    'label' => esc_html__( 'Layout 6', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonial_carousel/layout-image/6.webp'
                                ]
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_clients',
                    'label' => esc_html__('Clients', 'medcity'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'clients',
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'default' => [
                                [
                                    'client_content' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'medcity' ),
                                    'client_image'   => [],
                                    'client_name'    => esc_html__( 'John Doe', 'medcity' ),
                                    'client_job'     => esc_html__( 'Designer', 'medcity' ),
                                    'client_link'    => esc_html__( 'http://client-link.com', 'medcity' ),
                                ],
                            ],
                            'controls' => array(
                                array(
                                    'name'    => 'client_content',
                                    'label'   => __( 'Content', 'medcity' ),
                                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                                    'rows'    => '10',
                                    'default' => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                                ),
                                array(
                                    'name'        => 'client_image',
                                    'label'       => esc_html__('Avatar Image', 'medcity'),
                                    'type'        => \Elementor\Controls_Manager::MEDIA,
                                    'label_block' => true,
                                    'default'     => [
                                        'url' => get_template_directory_uri().'/assets/images/placeholder-square.png'
                                    ]
                                ),
                                array(
                                    'name' => 'client_name',
                                    'label' => esc_html__('Client Name', 'medcity'),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                    'default' => esc_html__( 'John Doe', 'medcity' )
                                ),
                                array(
                                    'name'  =>  'client_job',
                                    'label' => __( 'Job', 'medcity' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'default' => 'Designer',
                                ),
                                array(
                                    'name' => 'rating',
                                    'label' => esc_html__('Rating', 'medcity' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => 'star5',
                                    'options' => [
                                        'star1' => esc_html__('1 Star', 'medcity' ),
                                        'star2' => esc_html__('2 Star', 'medcity' ),
                                        'star3' => esc_html__('3 Star', 'medcity' ),
                                        'star4' => esc_html__('4 Star', 'medcity' ),
                                        'star5' => esc_html__('5 Star', 'medcity' ),
                                    ],
                                ),
                                array(
                                    'name' => 'client_link',
                                    'label' => esc_html__('Client URL', 'medcity'),
                                    'type' => \Elementor\Controls_Manager::URL,
                                    'label_block' => true,
                                    'placeholder' => esc_html__('http://client-link.com', 'medcity'),
                                ),
                            ),
                            'title_field' => '{{{ client_name }}}',
                        ),
                    ),
                ),
                array(
                    'name' => 'section_styling',
                    'label' => esc_html__('Settings', 'medcity'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'content_typography',
                            'label' => esc_html__('Said Typo', 'medcity'),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .cms-testimonial-carousel .client-content .said',
                        ),
                        array(
                            'name' => 'client_content_color',
                            'label' => esc_html__('Said Color', 'medcity'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-testimonial-carousel .client-content p' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .cms-testimonial-carousel .client-content .said' => 'color: {{VALUE}};',
                                '{{WRAPPER}}' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'name_typography',
                            'label' => esc_html__('Name Typo', 'medcity'),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .cms-testimonial-carousel .client-name .name-text',
                        ),
                        array(
                            'name' => 'client_name_color',
                            'label' => esc_html__('Name Color', 'medcity'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-testimonial-carousel .client-name .name-text' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .name-color' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'client_job_color',
                            'label' => esc_html__('Job Color', 'medcity'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-testimonial-carousel .client-job' => 'color: {{VALUE}};',
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_carousel_settings',
                    'label' => esc_html__('Carousel Settings', 'medcity'),
                    'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
                    'controls' => array(
                        array(
                            'name' => 'slides_to_show',
                            'label' => esc_html__('Slides to Show', 'medcity'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'control_type' => 'responsive',
                            'options' => [
                                    '' => esc_html__( 'Default', 'medcity' ),
                                ] + $slides_to_show,
                        ),
                        array(
                            'name' => 'slides_to_scroll',
                            'label' => esc_html__('Slides to Scroll', 'medcity'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'control_type' => 'responsive',
                            'options' => [
                                    '' => esc_html__( 'Default', 'medcity' ),
                                ] + $slides_to_show,
                            'condition' => [
                                'slides_to_show!' => '1',
                            ],
                        ),
                        array(
                            'name' => 'slides_gutter',
                            'label' => esc_html__('Gutter', 'medcity'),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'control_type' => 'responsive',
                            'default' => 10,
                            'condition' => [
                                'slides_to_show!' => '1',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .cms-slick-carousel .slick-list .slick-slide' => 'padding: {{VALUE}}px;',
                                '{{WRAPPER}} .cms-slick-carousel .slick-list' => 'margin: 0 -{{VALUE}}px;',
                            ],
                        ),
                        array(
                            'name' => 'arrows',
                            'label' => esc_html__('Show Arrows', 'medcity'),
                            'type' => \Elementor\Controls_Manager::SWITCHER,
                        ),
                        array(
                            'name' => 'dots',
                            'label' => esc_html__('Show Dots', 'medcity'),
                            'type' => \Elementor\Controls_Manager::SWITCHER,
                        ),
                        array(
                            'name' => 'pause_on_hover',
                            'label' => esc_html__('Pause on Hover', 'medcity'),
                            'type' => \Elementor\Controls_Manager::SWITCHER,
                        ),
                        array(
                            'name' => 'autoplay',
                            'label' => esc_html__('Autoplay', 'medcity'),
                            'type' => \Elementor\Controls_Manager::SWITCHER,
                        ),
                        array(
                            'name' => 'autoplay_speed',
                            'label' => esc_html__('Autoplay Speed', 'medcity'),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => 5000,
                            'condition' => [
                                'autoplay' => 'true'
                            ]
                        ),
                        array(
                            'name' => 'infinite',
                            'label' => esc_html__('Infinite Loop', 'medcity'),
                            'type' => \Elementor\Controls_Manager::SWITCHER,
                        ),
                        array(
                            'name' => 'speed',
                            'label' => esc_html__('Animation Speed', 'medcity'),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => 500,
                        ),
                        array(
                            'name' => 'nav',
                            'label' => esc_html__('Nav Slides To Show', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                                '6' => '6',
                                'auto' => 'auto',
                            ],
                            'default' => '3',
                            'condition' => [
                                'layout' => ['1','2','6'],
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);