<?php
etc_add_custom_widget(
    array(
        'name' => 'cms_company_history',
        'title' => esc_html__('Company History', 'medcity'),
        'icon' => 'eicon-history',
        'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
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
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_company_history/layout-image/layout1.jpg'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_timelines',
                    'label' => esc_html__('Timelines', 'medcity'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'timelines',
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'default' => [
                                [
                                    'timeline_year' => '2001',
                                    'timeline_title' => 'This is the heading',
                                    'timeline_content' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'medcity' ),
                                ],
                            ],
                            'controls' => array(
                                array(
                                    'name' => 'timeline_year',
                                    'label' => esc_html__('Timeline Year', 'medcity'),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                    'default' => esc_html__( '1996', 'medcity' )
                                ),
                                array(
                                    'name' => 'timeline_title',
                                    'label' => esc_html__('Content Title', 'medcity'),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                    'default' => esc_html__( 'This is the heading', 'medcity' )
                                ),
                                array(
                                    'name' => 'timeline_content',
                                    'label' => __( 'Content', 'medcity' ),
                                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                                    'rows' => '10',
                                    'default' => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                                ),
                            ),
                            'title_field' => '{{{ timeline_year }}}',
                        ),
                    ),
                ),
                array(
                    'name' => 'style_section',
                    'label' => esc_html__('Text Style', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'year_bg',
                            'label' => esc_html__('Years Background', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-company-history .timeline-year' => 'background-color: {{VALUE}};',
                                '{{WRAPPER}} .cms-company-history .timeline-year:after' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'year_color',
                            'label' => esc_html__('Years Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-company-history .timeline-year' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'content_color',
                            'label' => esc_html__('Content Color', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .cms-company-history .timeline-text' => 'color: {{VALUE}};',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);