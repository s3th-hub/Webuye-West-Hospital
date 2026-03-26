<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('medcity_widget_cms_testimonials_register_controls')) {
    add_action('etc_widget_cms_testimonials_register_controls', 'medcity_widget_cms_testimonials_register_controls', 10, 1);
    function medcity_widget_cms_testimonials_register_controls($widget)
    {
        // Layout Tab Start
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'medcity'),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $widget->add_control(
            'layout_mode',
            [
                'label'   => esc_html__( 'Layout Mode', 'medcity' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'grid'     => esc_html__('Grid','medcity'),
                    'carousel' => esc_html__('Carousel', 'medcity')
                ],
                'default' => 'carousel'
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/1.webp'
                    ]
                ]
            ]
        );
        $widget->end_controls_section();
        // Testimonials
        $widget->start_controls_section(
            'list_section',
            [
                'label' => esc_html__('Testimonials', 'medcity'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new Repeater();

            $repeater->add_control(
                'image',
                [
                    'label' => esc_html__('Avatar', 'medcity'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $repeater->add_control(
                'name',
                [
                    'label' => esc_html__('Name', 'medcity'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Testimonial Name', 'medcity'),
                ]
            );

            $repeater->add_control(
                'position',
                [
                    'label' => esc_html__('Position', 'medcity'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Testimonial Position', 'medcity'),
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label' => esc_html__('Description', 'medcity'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Testimonial Description', 'medcity'),
                ]
            );

            $widget->add_control(
                'testimonials',
                [
                    'label' => esc_html__('Testimonials', 'medcity'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => 'Name',
                            'position'    => 'Position',
                            'description' => '#1 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => 'Name #2',
                            'position'    => 'Position #2',
                            'description' => '#2 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => 'Name #3',
                            'position'    => 'Position #3',
                            'description' => '#3 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                        ],
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
            $widget->add_control(
                'avatar_size_setting',
                [
                    'name'      => 'avatar_size_heading',
                    'label'     => esc_html__('Avatar Settings','medcity'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'      => 'image',
                    'default'   => 'custom'
                ]
            );
        $widget->end_controls_section();
        // Carousel Settings
        medcity_elementor_carousel_settings($widget, [
            'arrows'           => 'no',
            'dots'             => 'yes',
            'dots_type'        => 'custom',  
            'slides_to_show'   => 1,
            'slides_to_scroll' => 1,
            'condition'        => ['layout_mode' => 'carousel']
        ]);
        // Grid Settings
        medcity_elementor_grid_columns_settings($widget, ['condition' => ['layout_mode' => 'grid']]);
        // Style
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings','medcity'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'desc_color',
                'label'    => esc_html__( 'Description Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-ttmn--text' => 'color: {{VALUE}};'
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'author_color',
                'label'    => esc_html__( 'Author Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-ttmn--name' => 'color: {{VALUE}};'
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'author_pos_color',
                'label'    => esc_html__( 'Position Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-ttmn--pos' => 'color: {{VALUE}};'
                ]
            ]);
        $widget->end_controls_section();
    }
}
