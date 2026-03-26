<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!function_exists('medcity_widget_cms_quickcontact_register_controls')) {
    add_action('etc_widget_cms_quickcontact_register_controls', 'medcity_widget_cms_quickcontact_register_controls', 10, 1);
    function medcity_widget_cms_quickcontact_register_controls($widget)
    {
        // Layout Settings
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'medcity' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $widget->add_responsive_control(
                'align',
                [
                    'label'        => esc_html__( 'Alignment', 'medcity' ),
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
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'medcity' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ]
                ]
            );
            $widget->add_control(
                'layout',
                [
                    'label'   => esc_html__( 'Templates', 'medcity' ),
                    'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'label' => esc_html__( 'Layout 1', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/3.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();

        // Title Section Start
        $widget->start_controls_section(
            'title_section',
            [
                'label'     => esc_html__('Title', 'medcity'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','2','3']
                ]
            ]
        );
            $widget->add_control(
                'title',
                [
    				'label'       => '',
    				'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Quick Contact',  
    				'placeholder' => esc_html__('Enter your title', 'medcity')
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'     => esc_html__( 'Title Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Desc Section Start
        $widget->start_controls_section(
            'desc_section',
            [
                'label' => esc_html__('Description', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','2','3']
                ]
            ]
        );
            $widget->add_control(
                'desc',
                [
                    'label'       => '',
                    'default'     => 'If you have any questions or need help, feel free to contact with our team.',
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__('Enter your text', 'medcity')
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'desc_color',
                'label'     => esc_html__( 'Description Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        
        // Email Section Start
        $widget->start_controls_section(
            'email_section',
            [
                'label' => esc_html__('Email', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1']
                ]
            ]
        );
            $widget->add_control(
                'email_title',
                [
                    'label'       => esc_html__('Email Title','medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Email:'  
                ]
            );
            $widget->add_control(
                'email',
                [
    				'label'       => '',
    				'type'        => Controls_Manager::TEXTAREA,
    				'default'     => 'medcity@7oroof.com',
                    'placeholder' => 'medcity@7oroof.com'
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'icon_email_color',
                'label'     => esc_html__( 'Icon Email Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-email .cms-icon-color' => 'color: {{VALUE}};',
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'email_color',
                'label'     => esc_html__( 'Email Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-email' => 'color: {{VALUE}};',
                ]
            ]);
             medcity_elementor_colors_opts($widget,[
                'name'     => 'email_color_hover',
                'label'     => esc_html__( 'Email Hover Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-email:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Phone Section Start
        $widget->start_controls_section(
            'phone_section',
            [
                'label' => esc_html__('Phone Settings', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout'  => ['1','2','3']
                ]
            ]
        );
            $widget->add_control(
                'phone_title',
                [
                    'label'       => esc_html__('Phone Title','medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Phone:',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'phone',
                [
    				'label'       => esc_html__('Phone Number','medcity'),
    				'type'        => Controls_Manager::TEXT,
    				'default'     => '02 01061245741',
                    'placeholder' => '02 01061245741'
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'icon_phone_color',
                'label' => esc_html__('Icon Phone Color', 'medcity'),
                'selector' => [
                    '{{WRAPPER}} .cms-phone .cms-icon-color' => 'color: {{VALUE}};'
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'phone_color',
                'label' => esc_html__('Phone Color', 'medcity'),
                'selector' => [
                    '{{WRAPPER}} .cms-phone' => 'color: {{VALUE}};'
                ],
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'phone_color_hover',
                'label' => esc_html__('Phone Hover Color', 'medcity'),
                'selector' => [
                    '{{WRAPPER}} .cms-phone:hover' => 'color: {{VALUE}};'
                ],
            ]);
        $widget->end_controls_section();
        // Time Section Start
        $widget->start_controls_section(
            'time_section',
            [
                'label' => esc_html__('Time Settings', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'=> [
                    'layout' => ['1']
                ]
            ]
        );
            $widget->add_control(
                'time_title',
                [
                    'label'       => esc_html__('Time Title','medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Mon - Fri:',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'time',
                [
                    'label'       => esc_html__('Time','medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '8AM - 5PM',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'exclude_time',
                [
                    'label'       => esc_html__('Exclude Time','medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '*Excludes Holidays',
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['x']
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'icon_time_color',
                'label' => esc_html__('Icon Time Color', 'medcity'),
                'selector' => [
                    '{{WRAPPER}} .cms-time .cms-icon-color' => 'color: {{VALUE}};',
                ],
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'time_color',
                'label' => esc_html__('Time Color', 'medcity'),
                'selector' => [
                    '{{WRAPPER}} .cms-time' => 'color: {{VALUE}};',
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'time_color_hover',
                'label' => esc_html__('Time Hover Color', 'medcity'),
                'selector' => [
                    '{{WRAPPER}} .cms-time:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Address Section Start
        $widget->start_controls_section(
            'address_section',
            [
                'label' => esc_html__('Address', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','2','3']
                ]
            ]
        );
            $widget->add_control(
                'address_title',
                [
                    'label'       => esc_html__('Address Title','medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Location',
                    'label_block' => false  
                ]
            );
            $widget->add_control(
                'address',
                [
                    'label'       => '',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '2307 Beverley Rd Brooklyn, New York 11226 United States.',
                    'placeholder' => esc_html__('Enter your address', 'medcity')
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'icon_address_color',
                'label'     => esc_html__( 'Icon Address Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-address .cms-icon-color' => 'color: {{VALUE}};',
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'address_color',
                'label'     => esc_html__( 'Address Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-address' => 'color: {{VALUE}};',
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'address_color_hover',
                'label'     => esc_html__( 'Address Hover Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-address:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Buttons
        medcity_elementor_link_button_settings($widget, ['name' => 'btn','condition'=>['layout' => ['1'] ] ]);
        // Socials
        $widget->start_controls_section(
            'section_icon',
            [
                'label' => esc_html__('Socials Settings', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2','3']
                ]
            ]
        );
            $socials = new Repeater();
            $socials->add_control(
                'icon',
                [
                    'label'   => esc_html__( 'Icon', 'medcity' ),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'fas fa-star',
                        'library' => 'font-awesome',
                    ]
                ]
            );

            $socials->add_control(
                'title',
                [
                    'label'   => esc_html__( 'Title', 'medcity' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Icon Title',
                ]
            );

            $socials->add_control(
                'link',
                [
                    'label'   => esc_html__( 'Link', 'medcity' ),
                    'type'    => Controls_Manager::URL,
                    'default' => [
                        'is_external' => 'true',
                        'url'         => '#'  
                    ],
                    'placeholder' => esc_html__( 'https://your-link.com', 'medcity' ),
                ]
            );
            medcity_elementor_colors_opts($socials,[
                'name'     => 'color',
                'label'    => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}'     => 'color: {{VALUE}};',
                    //'{{WRAPPER}} {{CURRENT_ITEM}} .cms-icon svg' => 'fill: {{VALUE}};',
                ]
            ]);
            medcity_elementor_colors_opts($socials,[
                'name'     => 'color_hover',
                'label'    => esc_html__( 'Hover Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}:hover'     => 'color: {{VALUE}};',
                    //'{{WRAPPER}} {{CURRENT_ITEM}} .cms-icon:hover svg' => 'fill: {{VALUE}};',
                ]
            ]);
            $widget->add_control(
                'icons',
                [
                    'label' => esc_html__('Icons', 'medcity'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $socials->get_controls(),
                    'default' => [
                        [
                            'icon' => [
                                'value'   => 'fab fa-facebook-square',
                                'library' => 'awesome',
                            ],
                            'title' => 'Facebook',
                            'link'  => [
                                'is_external' => true,
                                'url'         => 'https://facebook.com'
                            ]
                        ],
                        [
                            'icon' => [
                                'value'   => 'fab fa-twitter-square',
                                'library' => 'awesome',
                            ],
                            'title' => 'Twitter',
                            'link'  => [
                                'is_external' => true,
                                'url' => 'https://twitter.com'
                            ]
                        ],
                        [
                            'icon' => [
                                'value'   => 'fab fa-linkedin',
                                'library' => 'awesome',
                            ],
                            'title' => 'LinkedIn',
                            'link'  => [
                                'is_external' => true,
                                'url'         => 'https://linkedin.com'
                            ]
                        ],
                    ],
                    'title_field' => '{{{ "<i class=\"" + icon.value + "\"></i>" + " " + title }}}',
                ]
            );
        $widget->end_controls_section();
        // Background Gradient
        medcity_elementor_background_gradient_settings($widget,[
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        // Background Icon
        medcity_elementor_icon_image_settings($widget,[
            'name'      => 'icon_background',
            'label'     => esc_html__('Background Settings', 'medcity'),
            'condition' => [
                'layout' => ['2','3']
            ]
        ]);
        // Style Section
        $widget->start_controls_section(
            'show_hide_title_section',
            [
                'label' => esc_html__('Title Settings', 'medcity'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
	        medcity_add_hidden_device_controls($widget, [
                'prefix' => 'title_',
            ]);
        $widget->end_controls_section(); 
    }
}
