<?php pxl_add_custom_widget(
    array(
        'name' => 'pxl_instagram',
        'title' => esc_html__('Pxl Instagram', 'meddox'),
        'icon' => 'eicon-instagram-gallery',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(        
                array(
                    'name' => 'tab_content',
                    'label' => esc_html__('Content', 'meddox'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'icon_heading',
                            'label' => esc_html__('Icon Heading', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::ICONS,
                            'label_block' => true,
                            'fa4compatibility' => 'icon',
                        ),
                        array(
                            'name' => 'heading',
                            'label' => esc_html__('Heading', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => esc_html__('Click Here', 'meddox'),
                        ),
                        array(
                            'name' => 'images',
                            'label' => esc_html__('Images', 'meddox'),
                            'type' => \Elementor\Controls_Manager::GALLERY,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'img_size',
                            'label' => esc_html__('Image Size', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'description' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height).',
                        ),
                        array(
                            'name' => 'item_active',
                            'label' => esc_html__('Item Active', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                        ),
                        array(
                            'name' => 'ins_link',
                            'label' => esc_html__('Account Link', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::URL,
                        ),
                        array(
                            'name' => 'item_width',
                            'label' => esc_html__('Item Width', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 3000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-instagram1 .pxl--item' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    meddox_get_class_widget_path()
);