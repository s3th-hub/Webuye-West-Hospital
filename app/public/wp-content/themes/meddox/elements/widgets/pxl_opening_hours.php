<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_opening_hours',
        'title' => esc_html__('Pxl Opening Hours', 'meddox'),
        'icon' => 'eicon-editor-link',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_layout',
                    'label' => esc_html__('Layout', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Templates', 'meddox' ),
                            'type' => 'layoutcontrol',
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__('Layout 1', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_opening_hours/layout-image/layout1.jpg'
                                ],
                                '2' => [
                                    'label' => esc_html__('Layout 2', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_opening_hours/layout-image/layout2.jpg'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'meddox'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                     array(
                        'name' => 'icon_type',
                        'label' => esc_html__('Type', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            'icon' => 'Icon',
                            'image' => 'Image',
                        ],
                        'default' => 'icon',
                    ),
                     array(
                        'name' => 'icon_image',
                        'label' => esc_html__( 'Image', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'condition' => [
                            'icon_type' => 'image',
                        ],
                    ),
                     array(
                        'name' => 'pxl_icon',
                        'label' => esc_html__('Icon', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::ICONS,
                        'fa4compatibility' => 'icon',
                        'condition' => [
                            'icon_type' => 'icon',
                        ],
                    ),
                     array(
                        'name' => 'title',
                        'label' => esc_html__('Title', 'meddox' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                    ),
                     array(
                        'name' => 'content',
                        'label' => esc_html__('Link', 'meddox'),
                        'type' => \Elementor\Controls_Manager::REPEATER,
                        'controls' => array(
                            array(
                                'name' => 'day_of_week',
                                'label' => esc_html__('The day of week', 'meddox'),
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'default' => 'Monday',
                            ),
                            array(
                                'name' => 'opening',
                                'label' => esc_html__('Inputs opening time', 'meddox'),
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'default' => '6.00',
                            ),
                            array(
                                'name' => 'closing',
                                'label' => esc_html__('Inputs closing time', 'meddox'),
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'default' => '18.00',
                            ),

                        ),
                        'title_field' => '{{{ day_of_week }}}',
                    ),
                 ),
                ),
                array(
                    'name' => 'section_style_link',
                    'label' => esc_html__('Link', 'meddox'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(


                    ),
                ),

                meddox_widget_animation_settings(),
            ),
),
),
meddox_get_class_widget_path()
);