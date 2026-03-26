<?php
use Elementor\Controls_Manager;

if (!function_exists('medcity_widget_cms_zocdoc_register_controls')) {
    add_action('etc_widget_cms_zocdoc_register_controls', 'medcity_widget_cms_zocdoc_register_controls', 10, 1);
    function medcity_widget_cms_zocdoc_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_zocdoc/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'medcity' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_zocdoc/layout/2.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Zocdoc Settings
        medcity_elementor_zocdoc_settings($widget);
        // Buttons
        medcity_elementor_link_button_settings($widget, [
            'name' => 'btn1',
            'condition' => [
                'layout' => ['2']
            ]
        ]);
    }
}