<?php
/**
 * Slider Element
 * @since 1.1.1
 * 
 * */
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('medcity_widget_cms_slider_register_controls')) {
    add_action('etc_widget_cms_slider_register_controls', 'medcity_widget_cms_slider_register_controls', 10, 1);
    function medcity_widget_cms_slider_register_controls($widget)
    {
        // Layout Tab Start
        $widget->start_controls_section('layout_section', [
            'label' => esc_html__('Layout', 'medcity'),
            'tab' => Controls_Manager::TAB_LAYOUT,
        ]);
            $widget->add_control('header_transparent', [
                'label'              => esc_html__('Header Transparent', 'medcity'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => '',
                'prefix_class'       => 'cms-eslider-header-transparent-',
                'description'        => esc_html__('Make arrows alignment middle when have Header Transparent','medcity')   
            ]);
            $widget->add_control('layout', [
                'label'   => esc_html__('Templates', 'medcity'),
                'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                'default' => '1',
                'options' => [
                    '1' => [
                        'label' => esc_html__('Layout 1', 'medcity'),
                        'image' => get_template_directory_uri().'/elementor/templates/widgets/cms_slider/layout/1.webp',
                    ]
                ]
            ]);
        $widget->end_controls_section();

        // Slider List Section Start
        $widget->start_controls_section('slider_list_section', [
            'label' => esc_html__('Slider List', 'medcity'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

            $repeater = new Repeater();
            $repeater->add_control(
                'slide_type',
                [
                    'label'       => esc_html__('Slide Type', 'medcity'),
                    'type'        => Controls_Manager::SELECT,
                    'label_block' => false,
                    'options'     => [
                        ''      => esc_html__('None','medcity'),
                        'img'   => esc_html__('Image','medcity'),
                        'video' => esc_html__('Video','medcity')
                    ],
                    'default'     => 'img',
                ]
            );
            $repeater->add_control(
                'image',
                [
                    'label'       => esc_html__('Slide Image', 'medcity'),
                    'type'        => Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default'     => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'slide_type' => 'img'
                    ]
                ]
            );
            $repeater->add_control(
                'video_url',
                [
                    'label' => esc_html__( 'Video URL', 'medcity' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true
                    ],
                    'placeholder' => esc_html__( 'Enter your YouTube video url', 'medcity' ) . ' (YouTube)',
                    'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                    'label_block' => true,
                    'condition' => [
                        'slide_type' => 'video',
                    ],
                    'ai' => [
                        'active' => false,
                    ]
                ]
            );
            $repeater->add_control(
                'subtitle',
                [
                    'label'       => esc_html__('Small Title', 'medcity'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the subtitle', 'medcity'),
                    'placeholder' => esc_html__('Enter your subtitle', 'medcity'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'medcity'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the title', 'medcity'),
                    'placeholder' => esc_html__('Enter your title', 'medcity'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'description_title',
                [
                    'label'       => esc_html__('Description Title', 'medcity'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your Description Title', 'medcity'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label'       => esc_html__('Description', 'medcity'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the description', 'medcity'),
                    'placeholder' => esc_html__('Enter your description', 'medcity'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'button_primary',
                [
                    'label'       => esc_html__('Button Primary', 'medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__('Button Primary', 'medcity'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'button_primary_type',
                [
                    'label'   => esc_html__('Link Type', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'medcity'),
                        'page'   => esc_html__('Page', 'medcity'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'button_primary!' => ''
                    ]
                ]
            );
            $repeater->add_control(
                'button_primary_page_link',
                [
                    'label'   => esc_html__('Select Page', 'medcity'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'return_value' => 'ID',
                    'multiple'    => false,
                    'label_block' => true,
                    'condition'   => [
                        'button_primary!'     => '',
                        'button_primary_type' => 'page'
                    ]
                ]
            );
            $repeater->add_control(
                'button_primary_link',
                [
                    'label'       => esc_html__( 'Custom Link', 'medcity' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'medcity' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'button_primary!'     => '',
                        'button_primary_type' => 'custom'
                    ]
                ]
            );
            // Button Secondary 
            $repeater->add_control(
                'button_secondary',
                [
                    'label'       => esc_html__('Button Secondary', 'medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__('Button Secondary', 'medcity'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'button_secondary_type',
                [
                    'label'   => esc_html__('Link Type', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'medcity'),
                        'page'   => esc_html__('Page', 'medcity'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'button_secondary!' => ''
                    ]
                ]
            );
            $repeater->add_control(
                'button_secondary_page_link',
                [
                    'label'   => esc_html__('Select Page', 'medcity'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'return_value' => 'ID',
                    'multiple'    => false,
                    'label_block' => true,
                    'condition'   => [
                        'button_secondary!'     => '',
                        'button_secondary_type' => 'page'
                    ]
                ]
            );
            $repeater->add_control(
                'button_secondary_link',
                [
                    'label'       => esc_html__( 'Custom Link', 'medcity' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'medcity' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'button_secondary!'     => '',
                        'button_secondary_type' => 'custom'
                    ]
                ]
            );
            // Video  Button
            $repeater->add_control(
                'video_link',
                [
                    'label'       => esc_html__( 'Button Video', 'medcity' ),
                    'description' => esc_html__('Video url from  YouTube/Vimeo/Dailymotion.','medcity').' EX: https://www.youtube.com/watch?v=iYf3OgEdGmo',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'dynamic'     => [
                        'active' => true
                    ],
                    'label_block' => true
                ]
            );
            $repeater->add_control(
                'video_text',
                [
                    'label'       => '',
                    'description' => esc_html__('Text beside play icon','medcity'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'How it works',
                    'condition'   => [
                        'video_link!' => ''
                    ],
                    'label_block' => true
                ]
            );
            // Start List
            $widget->add_control(
                'cms_slides',
                [
                    'label' => esc_html__('Slides', 'medcity'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'title'       => 'Smart Systems For Safe Future!',
                            'subtitle'    => '',
                            'description' => 'Not only will this reduce the probability of crime happening on your property, it will reduce or eliminate any liability that falls on you if you can show you have solid, well-designed commercial building security systems in place.',
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'title'       => 'Unique & Powerful Security Solutions',
                            'subtitle'    => '',
                            'description' => 'Not only will this reduce the probability of crime happening on your property, it will reduce or eliminate any liability that falls on you if you can show you have solid, well-designed commercial building security systems in place.',
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $widget->end_controls_section();
        // General Style Section Start
        $widget->start_controls_section(
            'general_style_section',
            [
                'label' => esc_html__('General', 'medcity'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control('overlay_style', [
                'label' => esc_html__('Overlay Style', 'medcity'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    ''  => esc_html__('None','medcity'),
                    '1' => 'Style 1'
                ],
                'default' => '1'
            ]);
            $widget->add_responsive_control(
                'content_align',
                [
                    'label'        => esc_html__( 'Content Alignment', 'medcity' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'start'    => [
                            'title' => esc_html__( 'Left', 'medcity' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'  => [
                            'title' => esc_html__( 'Center', 'medcity' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'end'   => [
                            'title' => esc_html__( 'Right', 'medcity' ),
                            'icon'  => 'eicon-text-align-right',
                        ]
                    ]
                ]
            );
            $widget->add_responsive_control(
                'content_width',
                [
                    'label' => esc_html__('Content Width', 'medcity'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min'  => 300, 
                            'max'  => 1280,
                            'step' => 5
                        ]
                    ],
                    'selectors'    => [
                        '{{WRAPPER}} .cms-slider--content' => 'max-width: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );
        $widget->end_controls_section();
        // Subtitle Style Section Start
        $widget->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle', 'medcity'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'subtitle_animation',
                [
                    'label'              => esc_html__('Animation', 'medcity'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'subtitle_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'medcity'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 500,
                    'frontend_available' => true,
                ]
            );
            medcity_add_hidden_device_controls($widget, ['prefix' => 'subtitle_']);
        $widget->end_controls_section();
        // Subtitle Style Section End

        // Title Style Section Start
        $widget->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'medcity'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'title_animation',
                [
                    'label'              => esc_html__('Animation', 'medcity'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'title_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'medcity'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 600,
                    'frontend_available' => true,
                ]
            );
            medcity_add_hidden_device_controls($widget, ['prefix' => 'title_']);
        $widget->end_controls_section();
        // Title Style Section End

        // Description Style Section Start
        $widget->start_controls_section(
            'description_style_section',
            [
                'label' => esc_html__('Description', 'medcity'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_responsive_control(
                'desc_width',
                [
                    'label' => esc_html__('Width', 'medcity'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min'  => 300, 
                            'max'  => 1280,
                            'step' => 5
                        ]
                    ],
                    'selectors'    => [
                        '{{WRAPPER}} .cms-slider-desc' => 'max-width: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );
            $widget->add_control(
                'description_animation',
                [
                    'label'              => esc_html__('Animation', 'medcity'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'description_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'medcity'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 700,
                    'frontend_available' => true,
                ]
            );
            medcity_add_hidden_device_controls($widget, ['prefix' => 'desc_']);
        $widget->end_controls_section();
        // Description Style Section End

        // Button Primary Style Section Start
        $widget->start_controls_section(
            'button_primary_style_section',
            [
                'label' => esc_html__('Button Primary', 'medcity'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'button_primary_animation',
            [
                'label'              => esc_html__('Animation', 'medcity'),
                'type'               => Controls_Manager::ANIMATION,
                'default'            => 'fadeInLeft',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'button_primary_animation_delay',
            [
                'label'              => esc_html__('Animation Delay', 'medcity'),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 50,
                'step'               => 50,
                'default'            => 800,
                'frontend_available' => true,
            ]
        );
        medcity_add_hidden_device_controls($widget, ['prefix' => 'btn1_']);
        $widget->end_controls_section();
        // Button Primary Style Section End

        // Button Secondary Style Section Start
        $widget->start_controls_section(
            'button_secondary_style_section',
            [
                'label' => esc_html__('Button Secondary', 'medcity'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'button_secondary_animation',
            [
                'label'              => esc_html__('Animation', 'medcity'),
                'type'               => Controls_Manager::ANIMATION,
                'default'            => 'fadeInLeft',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'button_secondary_animation_delay',
            [
                'label'              => esc_html__('Animation Delay', 'medcity'),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 50,
                'step'               => 50,
                'default'            => 900,
                'frontend_available' => true,
            ]
        );
        medcity_add_hidden_device_controls($widget, ['prefix' => 'btn2_']);
        $widget->end_controls_section();
        // Button Secondary Style Section End

        // Button Video Style Section Start
        $widget->start_controls_section(
            'button_video_style_section',
            [
                'label' => esc_html__('Button Video', 'medcity'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'button_video_animation',
            [
                'label'              => esc_html__('Animation', 'medcity'),
                'type'               => Controls_Manager::ANIMATION,
                'default'            => 'fadeInLeft',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'button_video_animation_delay',
            [
                'label'              => esc_html__('Animation Delay', 'medcity'),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 50,
                'step'               => 50,
                'default'            => 1000,
                'frontend_available' => true,
            ]
        );
        medcity_add_hidden_device_controls($widget, ['prefix' => 'btn_video_']);
        $widget->end_controls_section();
        // Carousel Settings
        $widget->start_controls_section(
            'carousel_section',
            [
                'label'     => esc_html__('Carousel Settings', 'medcity'),
                'tab'       => Controls_Manager::TAB_SETTINGS
            ]
        );
            $widget->add_responsive_control(
                'slides_height',
                [
                    'label'   => esc_html__( 'Slider Height', 'medcity' ),
                    'type'    => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '780',
                        'unit' => 'px' 
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-eslider' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'size_units' => [ 'px', 'vh'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 2000,
                        ],
                        'vh' => [
                            'min' => 20,
                            'max' => 100,
                        ],
                    ],
                ]
            );
            $slides_to_show = range(1, 3);
            $slides_to_show = array_combine($slides_to_show, $slides_to_show);
            $widget->add_responsive_control(
                'slides_to_show',
                [
                    'label'   => esc_html__('Slides to Show', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                            '' => esc_html__('Default', 'medcity'),
                        ] + $slides_to_show,
                    'default'        => '1',
                    'tablet_default' => '1',
                    'mobile_default' => '1',
                    'frontend_available' => true
                ]
            );

            $widget->add_responsive_control(
                'slides_to_scroll',
                [
                    'label' => esc_html__('Slides to Scroll', 'medcity'),
                    'type' => Controls_Manager::SELECT,
                    'description' => esc_html__('Set how many slides are scrolled per swipe.', 'medcity'),
                    'options' => [
                            '' => esc_html__('Default', 'medcity'),
                        ] + $slides_to_show,
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true
                ]
            );

            $widget->add_responsive_control(
                'space_between',
                [
                    'label' => esc_html__('Space Between', 'medcity'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 30,
                    ],
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'arrows',
                [
                    'label'              => esc_html__('Show Arrows', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'dots',
                [
                    'label'              => esc_html__('Show Dots', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'dots_type',
                [
                    'label'              => esc_html__('Dots Type', 'medcity'),
                    'type'               => Controls_Manager::SELECT,
                    'options'            => [
                        'progressbar'      => esc_html__('Progressbar','medcity'),
                        'bullets'          => esc_html__('Dots','medcity'),
                        'circle'           => esc_html__('Dots Circle','medcity'),
                        'number'           => esc_html__('Number','medcity'),
                        'fraction'         => esc_html__('Fraction (Current/Total)','medcity'),
                        'current-of-total' => esc_html__('Current of Total', 'medcity'),
                        'custom'           => esc_html__('Custom','medcity')
                    ],
                    'default'            => 'bullets',
                    'frontend_available' => true,
                    'condition' => [
                        'dots' => 'yes'
                    ]
                ]
            );
            $widget->add_control(
                'lazyload',
                [
                    'label' => esc_html__('Lazyload', 'medcity'),
                    'type' => Controls_Manager::SWITCHER,
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'autoplay',
                [
                    'label' => esc_html__('Autoplay', 'medcity'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'pause_on_hover',
                [
                    'label' => esc_html__('Pause on Hover', 'medcity'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'pause_on_interaction',
                [
                    'label' => esc_html__('Pause on Interaction', 'medcity'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'autoplay_speed',
                [
                    'label' => esc_html__('Autoplay Speed', 'medcity'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 5000,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'infinite',
                [
                    'label' => esc_html__('Infinite Loop', 'medcity'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'effect',
                [
                    'label' => esc_html__('Effect', 'medcity'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'slide',
                    'options' => [
                        'slide' => esc_html__('Slide', 'medcity'),
                        'fade' => esc_html__('Fade', 'medcity'),
                    ],
                    'condition' => [
                        'slides_to_show' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'speed',
                [
                    'label' => esc_html__('Animation Speed', 'medcity'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 500,
                    'render_type' => 'none',
                    'frontend_available' => true,
                ]
            );

        $widget->end_controls_section();
    }
}
