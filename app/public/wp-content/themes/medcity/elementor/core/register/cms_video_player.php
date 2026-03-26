<?php
// Register Video Player Widget
etc_add_custom_widget(
    array(
        'name' => 'cms_video_player',
        'title' => esc_html__('Video Player', 'medcity' ),
        'icon' => 'eicon-play',
        'categories' => array( Elementor_Theme_Core::ETC_CATEGORY_NAME ),
        'scripts' => array(

        ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'layout_section',
                    'label' => esc_html__('Layout', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Templates', 'medcity' ),
                            'type' => Elementor_Theme_Core::LAYOUT_CONTROL,
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__('Layout 1', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout-image/layout1.jpg'
                                ],
                                '2' => [
                                    'label' => esc_html__('Layout 2', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout-image/layout2.jpg'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'icon_section',
                    'label' => esc_html__('Video Player', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'video_style',
                            'label' => esc_html__('Style', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style-image' => 'Image',
                                'style-background' => 'Background',
                            ],
                            'default' => 'style-image',
                            'condition' => [
                                'layout' => '1'
                            ],
                        ),
                        array(
                            'name' => 'video_size',
                            'label' => esc_html__('Style', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'default' => 'Default',
                                'bigger' => 'Bigger',
                            ],
                            'default' => 'default',
                            'condition' => [
                                'layout' => '1'
                            ],
                        ),
                        array(
                            'name' => 'text_align',
                            'label' => esc_html__('Video Alignment', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::CHOOSE,
                            'control_type' => 'responsive',
                            'options' => [
                                'left' => [
                                    'title' => esc_html__('Left', 'medcity' ),
                                    'icon' => 'fa fa-align-left',
                                ],
                                'center' => [
                                    'title' => esc_html__('Center', 'medcity' ),
                                    'icon' => 'fa fa-align-center',
                                ],
                                'right' => [
                                    'title' => esc_html__('Right', 'medcity' ),
                                    'icon' => 'fa fa-align-right',
                                ],
                            ],
                            'condition' => [
                                'video_style' => 'style-background'
                            ],
                            'selectors' => [
                                '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'image',
                            'label' => esc_html__('Choose Image', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::MEDIA,
                            'condition' => [
                                'video_style' => 'style-image',
                                'layout' => '1'
                            ],
                        ),
                        array(
                            'name' => 'video_link',
                            'label' => esc_html__('Link', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => 'https://www.youtube.com/watch?v=SF4aHwxHtZ0'
                        ),
                        array(
                            'name' => 'description',
                            'label' => esc_html__('Description', 'medcity'),
                            'type' => \Elementor\Controls_Manager::TEXTAREA,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'box_background',
                            'label' => esc_html__('Box Background', 'medcity' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'condition' => [
                                'layout' => '2'
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .cms-video-player.layout2 .content-inner .inner' => 'background-color: {{VALUE}};',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);