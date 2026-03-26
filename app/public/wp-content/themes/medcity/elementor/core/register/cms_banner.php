<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

if (!function_exists('medcity_widget_cms_banner_register_controls')) {
    add_action('etc_widget_cms_banner_register_controls', 'medcity_widget_cms_banner_register_controls', 10, 1);
    function medcity_widget_cms_banner_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/3.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Banner
        $widget->start_controls_section(
            'section_single_image',
            [
                'label' => esc_html__('Banner Image', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Banner', 'medcity' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'banner',
                    'label'   => esc_html__('Image Size','medcity'),
                    'default' => 'custom',
                ]
            );
        $widget->end_controls_section();
        // Banner Icon Box
        $widget->start_controls_section(
            'section_icons_box',
            [
                'label' => esc_html__('Banner Icons Box', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            $icon_box = new Repeater();
                medcity_elementor_icon_image_settings($icon_box, ['group' => false]);
                $icon_box ->add_control(
                    'title',
                    [ 
                        'label'   => esc_html__('Title','medcity'),
                        'type'    => Controls_Manager::TEXT,
                        'default' => 'Your Title'
                    ]
                );
                $icon_box ->add_control(
                    'url',
                    [ 
                        'label'   => esc_html__('Link','medcity'),
                        'type'    => Controls_Manager::URL,
                        'default' => [
                            'url' => '#'
                        ]
                    ]
                );
            // Icons Box
            $widget->add_control(
                'icons_box',
                [
                    'label'       => esc_html__('Icon Box', 'medcity'),
                    'type'        => \Elementor\Controls_Manager::REPEATER,
                    'fields'      => $icon_box->get_controls(),
                    'title_field' => '{{title}}',
                    'separator'   => 'after',
                    'default'     => [
                        [
                            'icon' => [
                            'library' => 'flaticon',
                            'value'   => 'flaticon-cms'
                            ],
                            'title' => 'Your Title #1'
                        ],
                        [
                            'icon' => [
                            'library' => 'flaticon',
                            'value'   => 'flaticon-cms'
                            ],
                            'title' => 'Your Title #2'
                        ],
                        [
                            'icon' => [
                            'library' => 'flaticon',
                            'value'   => 'flaticon-cms'
                            ],
                            'title' => 'Your Title #3'
                        ],
                        [
                            'icon' => [
                            'library' => 'flaticon',
                            'value'   => 'flaticon-cms'
                            ],
                            'title' => 'Your Title #4'
                        ]
                    ]
                ]
            );
            // Link
            medcity_elementor_link_button_settings($widget, [
                'name' => 'link1',
                'group' => false
            ]);
        $widget->end_controls_section();
        // Banner Content
        $widget->start_controls_section(
            'banner_content',
            [
                'label' => esc_html__('Banner Content', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['3']
                ]
            ]
        );
            // Description
            $widget->add_control(
                'description_text',
                [
                    'label'       => esc_html__( 'Description', 'medcity' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour', 
                    'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                    'rows'        => 10,
                    'show_label'  => true
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'description_color',
                'label'     => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'description_text!' => ''
                ]
            ]);
            // Button
            medcity_elementor_link_button_settings($widget, [
                'name'  => 'link3',
                'type'  => 'link',
                'group' => false
            ]);
        $widget->end_controls_section();
    }
}
