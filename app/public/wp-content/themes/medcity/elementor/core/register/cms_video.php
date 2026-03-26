<?php
/**
 * @since 1.1.1
 * @author Chinh Duong Manh
 * 
 * **/
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('medcity_widget_cms_video_register_controls')) {
    add_action('etc_widget_cms_video_register_controls', 'medcity_widget_cms_video_register_controls', 10, 1);
    function medcity_widget_cms_video_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video/layout/1.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Video Sections
        $widget->start_controls_section(
            'section_video_player',
            [
                'label' => esc_html__('Video Settings', 'medcity'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $widget->add_control(
            'video_type',
            [
                'label' => esc_html__( 'Source', 'medcity' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__( 'YouTube', 'medcity' ),
                    // 'vimeo' => esc_html__( 'Vimeo', 'medcity' ),
                    // 'dailymotion' => esc_html__( 'Dailymotion', 'medcity' ),
                    // 'videopress' => esc_html__( 'VideoPress', 'medcity' ),
                    // 'hosted' => esc_html__( 'Self Hosted', 'medcity' ),
                ],
                'frontend_available' => true,
            ]
        );
        $widget->add_control(
            'lightbox',
            [
                'label'     => esc_html__( 'Lightbox', 'medcity' ),
                'type'      => Controls_Manager::SWITCHER,
                //'label_off' => esc_html__( 'Hide', 'medcity' ),
                //'label_on'  => esc_html__( 'Show', 'medcity' ),
                'default'   => 'yes',
                'frontend_available' => true,
            ]
        );
        $widget->add_control(
            'controls',
            [
                'label'     => esc_html__( 'Player Controls', 'medcity' ),
                'type'      => Controls_Manager::SWITCHER,
                //'label_off' => esc_html__( 'Hide', 'medcity' ),
                //'label_on'  => esc_html__( 'Show', 'medcity' ),
                'default'   => 'yes',
                'condition' => [
                    'lightbox!' => 'yes'
                ],
                'frontend_available' => true,
            ]
        );
        
        $widget->add_control(
            'video_link',
            [
                'label'    => esc_html__( 'Video URL', 'medcity' ),
                'subtitle' => esc_html__('Video url from  YouTube/Vimeo/Dailymotion','medcity'),
                'type'     => Controls_Manager::TEXTAREA,
                'default'  => 'https://www.youtube.com/watch?v=iYf3OgEdGmo',
                'dynamic' => [
                    'active' => true
                ],
                'label_block' => false,
                'ai' => [
                    'active' => false
                ],
                'frontend_available' => true
            ]
        );
        $widget->add_control(
            'video_icon',
            [
                'label'   => esc_html__( 'Video Icon', 'medcity' ),
                'type'    => Controls_Manager::ICONS,
                'skin'    => 'inline',
                'default' => [
                    'library' => 'awesome',
                    'value'   => 'fas fa-play'
                ],
                'condition' => [
                    'video_link!' => ''
                ],
                'label_block' => false
            ]
        );
        $widget->add_control(
            'video_text_title',
            [
                'label'       => esc_html__( 'Watch Video Title', 'medcity' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => '',
                'label_block' => false,
                'condition'   => [
                    'layout' => ['2']
                ]
            ]
        );
        $widget->add_control(
            'video_text',
            [
                'label'    => esc_html__( 'Watch Video Text', 'medcity' ),
                'type'     => Controls_Manager::TEXTAREA,
                'default'  => '',
                'condition' => [
                    'video_link!' => ''
                ],
                'label_block' => false
            ]
        );
        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'video_text_typo',
                'selector' => '{{WRAPPER}} .cms-play-text',
                'condition' => [
                    'video_link!' => '',
                    'video_text!' => ''
                ]
            ]
        );
        $widget->add_control(
            'image',
            [
                'label'   => esc_html__( 'Video Banner', 'medcity' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'skin'  => 'inline',
                'condition' => [
                    'video_link!' => '',
                    'layout'      => ['1']  
                ]
            ]
        );
        $widget->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'image',
                'label'   => esc_html__('Banner Size','medcity'),
                'default' => 'custom',
                'condition' => [
                    'video_link!' => '',
                    'image[url]!' => '',
                    'layout'      => ['1']
                ],
                'frontend_available' => true,
            ]
        );
        $widget->end_controls_section();
    }
}
