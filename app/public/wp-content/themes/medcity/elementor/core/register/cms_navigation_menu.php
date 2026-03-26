<?php
$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
if ( is_array( $menus ) && ! empty( $menus ) ) {
    foreach ( $menus as $single_menu ) {
        if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->term_id ) ) {
            $custom_menus[ $single_menu->slug ] = $single_menu->name;
        }
    }
} else {
    $custom_menus = '';
}
etc_add_custom_widget(
    array(
        'name' => 'cms_navigation_menu',
        'title' => esc_html__('Navigation Menu', 'medcity'),
        'icon' => 'eicon-menu-bar',
        'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
        'scripts' => array(),
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
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/1.webp'
                                ],
                                '2' => [
                                    'label' => esc_html__('Layout 2', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/2.webp'
                                ],
                                '3' => [
                                    'label' => esc_html__('Layout 3', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/3.webp'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'source_section',
                    'label' => esc_html__('Source Settings', 'medcity'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name'        => 'widget_title',
                            'label'       => esc_html__('Widget Title', 'medcity'),
                            'type'        => \Elementor\Controls_Manager::TEXTAREA,
                            'label_block' => true,
                        ),
                        array(
                            'name'        => 'widget_title_class',
                            'label'       => esc_html__('Widget Title CSS Class', 'medcity'),
                            'type'        => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'condition'   => [
                                'widget_title!' => ''
                            ]
                        ),
                        array(
                            'name'      => 'menu',
                            'label'     => esc_html__('Select Menu', 'medcity'),
                            'type'      => \Elementor\Controls_Manager::SELECT,
                            'options'   => $custom_menus,
                            'separator' => 'before'
                        ),
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'default' => 'Default',
                                'inline' => 'Inline',
                                'e-sidebar-widget' => 'Sidebar Menu'
                            ],
                            'default' => 'default',
                            'condition' => [
                                'layout' => ['1']
                            ]
                        ),
                        array(
                            'name' => 'link_color',
                            'label' => esc_html__('Link Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-navigation-menu ul.menu li a' => 'color: {{VALUE}} !important;',
                            ],
                        ),
                        array(
                            'name' => 'link_color_hover',
                            'label' => esc_html__('Link Color Hover & Active', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-navigation-menu ul.menu li a:hover, {{WRAPPER}} .cms-navigation-menu ul.menu li.current_page_item > a' => 'color: {{VALUE}} !important;',
                            ],
                        ),
                        array(
                            'name' => 'border_color_hover',
                            'label' => esc_html__('Border Color Hover & Active', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'condition' => [
                                'style' => array('inline', 'one-page'),
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .cms-navigation-menu.inline ul.menu > li > a:after' => 'background-color: {{VALUE}} !important;',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);