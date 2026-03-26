<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('medcity_widget_cms_heading2_register_controls')) {
    add_action('etc_widget_cms_heading2_register_controls', 'medcity_widget_cms_heading2_register_controls', 10, 1);
    function medcity_widget_cms_heading2_register_controls($widget)
    {
        // Layout
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'medcity'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading2/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading2/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading2/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading2/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading2/layout/5.webp'
                        ],
                        '6' => [
                            'label' => esc_html__( 'Layout 6', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading2/layout/6.webp'
                        ],
                        '7' => [
                            'label' => esc_html__( 'Layout 7', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading2/layout/7.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content Tab Start

        // Heading Section Start
        $widget->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading Content', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            // Small Heading
            $widget->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'medcity' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is small heading',
                    'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout'  => ['2', '3']  
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'smallheading_color',
                'label'     => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-smallheading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout'             => ['2','3'],
                    'smallheading_text!' => ''
                ]
            ]);
            // Heading
            $widget->add_control(
                'heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'medcity' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout!'       => ['7']
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'heading_color',
                'label'    => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-heading, {{WRAPPER}} .cms-heading a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => '',
                    'layout!'       => ['7']
                ]
            ]);
            // Description Bold
            $widget->add_control(
                'description_bold_text',
                [
                    'label'       => esc_html__( 'Description (Bold)', 'medcity' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since', 
                    'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                    'rows'        => 10,
                    'show_label'  => true,
                    'condition' => [
                        'layout' => ['3','5','7']
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'description_bold_color',
                'label'     => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc-bold' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout'                 => ['3','5'],
                    'description_bold_text!' => ''
                ]
            ]);
            // Description
            $widget->add_control(
                'description_text',
                [
                    'label'       => esc_html__( 'Description', 'medcity' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour', 
                    'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                    'rows'        => 10,
                    'show_label'  => true,
                    'condition' => [
                        'layout' => ['3','5','6']
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'description_color',
                'label'     => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout'            => ['3','5','6'],
                    'description_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Link 1
        $widget->start_controls_section('link1_section',[
            'label' => esc_html__('Link #1', 'medcity'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout' => ['3']
            ]
        ]);
            $widget->add_control(
                'link1_text',
                [
                    'label'       => esc_html__( 'Link #1 Text', 'medcity' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Click Here',
                    'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                    'separator' => 'before'
                ]
            );
            $widget->add_control(
                'link1_type',
                [
                    'label'   => esc_html__('Link #1 Type', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'medcity'),
                        'page'   => esc_html__('Page', 'medcity'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'link1_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'link1_page',
                [
                    'label'     => esc_html__('Select Page', 'medcity'),
                    'type'      => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'return_value' => 'ID',
                    'multiple'     => false,
                    'condition'    => [
                        'link1_text!' => '',
                        'link1_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'link1_custom',
                [
                    'label'       => esc_html__( 'Link Custom', 'medcity' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'medcity' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'link1_text!' => '',
                        'link1_type' => 'custom'
                    ]
                ]
            );
            // Link #1
            medcity_elementor_colors_opts($widget,[
                'name'      => 'link1_color',
                'label'     => esc_html__( 'Link #1 Color', 'medcity' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'      => 'link1_bg_color',
                'label'     => esc_html__( 'Link #1 Background Color', 'medcity' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'   => 'link1_color_hover',
                'label'  => esc_html__( 'Link #1 Color Hover', 'medcity' ),
                'custom' => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'      => 'link1_bg_hover_color',
                'label'     => esc_html__( 'Link #1 Background Hover Color', 'medcity' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Buttons
        medcity_elementor_link_button_settings($widget, [
            'name' => 'btn1',
            'condition' => [
                'layout' => ['5','6']
            ]
        ]);
        medcity_elementor_link_button_settings($widget, [
            'name' => 'btn2',
            'condition' => [
                'layout' => ['5']
            ]
        ]);
        // Features
        $widget->start_controls_section('features_section',[
            'label' => esc_html__('Features Settings', 'medcity'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout'  => ['5', '7']
            ]
        ]);
            $repeater = new Repeater();
            $repeater->add_control(
                'icon',
                [
                    'label'       => esc_html__( 'Icon', 'medcity' ),
                    'default'     => [],
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'label_block' => false,
                ]
            );
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'medcity' ),
                    'default'     => 'Your feature title',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );
            $repeater2 = new Repeater();
            $repeater2->add_control(
                'icon',
                [
                    'label'       => esc_html__( 'Icon', 'medcity' ),
                    'default'     => [],
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'label_block' => false,
                ]
            );
            $repeater2->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'medcity' ),
                    'default'     => 'Your feature title',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );
            //
            $widget->add_control(
                'show_feature',
                [
                    'label'   => esc_html__('Show Feature', 'medcity'),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );
            $widget->add_control(
                'cms_feature',
                [
                    'label'   => esc_html__('Features List', 'medcity'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon'        => [],
                            'title'       => 'Your feature title #1'
                        ],
                        [
                            'icon'        => [],
                            'title'       => 'Your feature title #1'
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                    'condition' => [
                        'show_feature' => 'yes'
                    ]
                ]
            );
            $widget->add_control(
                'cms_feature2',
                [
                    'label'   => esc_html__('Features List #2', 'medcity'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon'        => [],
                            'title'       => 'Your feature title #1'
                        ],
                        [
                            'icon'        => [],
                            'title'       => 'Your feature title #1'
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                    'condition' => [
                        'show_feature' => 'yes',
                        'layout'       => ['7']
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'feature_icon_color',
                'label'    => esc_html__( 'Icon Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .feature-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_feature' => 'yes'
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'feature_title_color',
                'label'    => esc_html__( 'Title Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .feature-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_feature' => 'yes'
                ]
            ]);
        $widget->end_controls_section();
        // Signature
        $widget->start_controls_section('signature_section',[
            'label' => esc_html__('Signature', 'medcity'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout' => ['3','6']
            ]
        ]);
            $widget->add_control(
                'savatar',
                [
                    'label'   => esc_html__( 'Avatar', 'medcity' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [],
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'simage',
                [
                    'label'   => esc_html__( 'Signature Image', 'medcity' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'sname',
                [
                    'label'       => esc_html__( 'Name', 'medcity' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Michael Brian',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'sposition',
                [
                    'label'       => esc_html__( 'Position', 'medcity' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'The Founder',
                    'label_block' => false
                ]
            );
        $widget->end_controls_section();
        // Style Content Alignment Start
        $widget->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content Alignment', 'medcity'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
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
                            'icon' => 'eicon-text-align-justify',
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
    }
}