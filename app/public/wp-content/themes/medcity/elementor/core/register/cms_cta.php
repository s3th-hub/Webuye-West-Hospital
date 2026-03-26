<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('medcity_widget_cms_cta_register_controls')) {
    add_action('etc_widget_cms_cta_register_controls', 'medcity_widget_cms_cta_register_controls', 10, 1);
    function medcity_widget_cms_cta_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/2.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content Section Start
        $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );    
            // Icon
            medcity_elementor_icon_image_settings($widget, [
                'group' => false,
                'condition' => [
                    'layout' => ['2']
                ]
            ]);
            // Text  
            $widget->add_control(
                'text',
                [
                    'label'       => esc_html__( 'Description', 'medcity' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Get free advice by speaking to one of our financial advisers over the phone or just submit your details and we’ll be in touch shortly!',
                    'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                    'label_block' => true
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'text_color',
                'label'     => esc_html__( 'Text Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'separator' => 'after',
                'condition'   => [
                    'text!' => ''
                ]
            ]);
            $widget->add_control(
                'link_text',
                [
                    'label'       => esc_html__( 'Link Settings', 'medcity' ),
                    'description' => esc_html__('Link Text', 'medcity'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Click here', 'medcity' ),
                    'placeholder' => esc_html__( 'Click here', 'medcity' ),
                    'label_block' => true,
                ]
            );
            $widget->add_control(
                'link_type',
                [
                    'label'   => esc_html__('Link Type', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'medcity'),
                        'page'   => esc_html__('Page', 'medcity'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'link_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'page_link',
                [
                    'label'   => esc_html__('Select Page', 'medcity'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'return_value' => 'ID',
                    'multiple'  => false,
                    'condition' => [
                        'link_text!' => '',
                        'link_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'custom_link',
                [
                    'label'       => esc_html__( 'Link', 'medcity' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'medcity' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'link_text!' => '',
                        'link_type' => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        
        // Style
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings','medcity'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            $widget->add_responsive_control(
                'align',
                [
                    'label'        => esc_html__( 'Alignment', 'medcity' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'responsive'   => true,
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
            // Link
            medcity_elementor_colors_opts($widget,[
                'name'     => 'link_color',
                'label'     => esc_html__( 'Link Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-link' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'link_color_hover',
                'label'     => esc_html__( 'Link Color Hover', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-link:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
    }
}
