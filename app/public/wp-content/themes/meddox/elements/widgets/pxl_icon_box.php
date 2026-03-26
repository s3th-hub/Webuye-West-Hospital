<?php
// Register Icon Box Widget
pxl_add_custom_widget(
    array(
        'name' => 'pxl_icon_box',
        'title' => esc_html__('Pxl Icon Box', 'meddox' ),
        'icon' => 'eicon-icon-box',
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
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout1.jpg'
                                ],
                                '2' => [
                                    'label' => esc_html__('Layout 2', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout2.jpg'
                                ],
                                '3' => [
                                    'label' => esc_html__('Layout 3', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout3.jpg'
                                ],
                                '4' => [
                                    'label' => esc_html__('Layout 4', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout4.jpg'
                                ],
                                '5' => [
                                    'label' => esc_html__('Layout 5', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout5.jpg'
                                ],
                                '6' => [
                                    'label' => esc_html__('Layout 6', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout6.jpg'
                                ],
                                '7' => [
                                    'label' => esc_html__('Layout 7', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout7.jpg'
                                ],
                                '8' => [
                                    'label' => esc_html__('Layout 8', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout8.jpg'
                                ],
                                '9' => [
                                    'label' => esc_html__('Layout 9', 'meddox' ),
                                    'image' => get_template_directory_uri() . '/elements/templates/pxl_icon_box/layout-image/layout9.jpg'
                                ],
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Title', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'condition' => [
                                'layout' => ['1','2','3','4','9'],
                            ],
                        ),
                        array(
                            'name' => 'desc',
                            'label' => esc_html__('Description', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXTAREA,
                            'rows' => 10,
                            'show_label' => false,
                            'condition' => [
                                'layout' => ['1','2','3','4','9'],
                            ],
                        ),
                        array(
                            'name' => 'btn_text',
                            'label' => esc_html__('Button Text', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'condition' => [
                                'layout' => ['1','2'],
                            ],
                        ),
                        array(
                            'name' => 'pxl_btn_icon',
                            'label' => esc_html__('Icon Button', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::ICONS,
                            'condition' => [
                                'layout' => ['1'],
                            ],
                        ),
                        array(
                            'name' => 'btn_link',
                            'label' => esc_html__('Button Link', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::URL,
                            'condition' => [
                                'layout' => ['1','2'],
                            ],
                        ),
                        array(
                            'name' => 'icon_type',
                            'label' => esc_html__('Icon Type', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'icon' => 'Icon',
                                'image' => 'Image',
                            ],
                            'default' => 'icon',
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
                            'name' => 'icon_image',
                            'label' => esc_html__( 'Icon Image', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::MEDIA,
                            'condition' => [
                                'icon_type' => 'image',
                            ],
                        ),
                        array(
                            'name' => 'item_active',
                            'label' => esc_html__('Item Active', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'pxl--item-deactive' => 'No',
                                'pxl--item-active' => 'Yes',
                            ],
                            'default' => 'pxl--item-deactive',
                            'condition' => [
                                'layout' => ['1','2','3','4','9'],
                            ],
                        ),
                        array(
                            'name' => 'bg_item_color',
                            'label' => esc_html__('Background Color', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'condition' => [
                                'layout' => ['1','2'],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-item--inner' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        
                        array(
                            'name' => 'wg_max_width',
                            'label' => esc_html__('Widget Max Width', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 3000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-icon-box' => 'max-width: {{SIZE}}{{UNIT}};',
                            ],
                            'condition' => [
                                'layout' => ['1','2','3','4','9'],
                            ],
                        ),

                        array(
                            'name' => 'item_link_1',
                            'label' => esc_html__('Text 1', 'meddox'),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'condition' => [
                                'layout' => ['5','6','7','8'],
                            ],

                        ),
                        array(
                            'name' => 'link_1',
                            'label' => esc_html__('Text 1 Link', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::URL,
                            'condition' => [
                                'layout' => ['5','6','8'],
                            ], 
                        ),
                        array(
                            'name' => 'item_link_2',
                            'label' => esc_html__('Text 2', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'rows' => 10,
                            'show_label' => false, 
                            'condition' => [
                                'layout' => ['5','6','7'],
                            ],
                        ),
                        array(
                            'name' => 'link_2',
                            'label' => esc_html__('Text 2 Link', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::URL,
                            'condition' => [
                                'layout' => ['5','6','7'],
                            ],
                        ),
                        array(
                            'name' => 'link_doctor',
                            'label' => esc_html__('Link Doctor', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::URL,
                            'condition' => [
                                'layout' => ['3'],
                            ],
                        ),
                        array(
                            'name' => 'padding_fomr',
                            'label' => esc_html__('Padding Form', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px' ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-icon-box .pxl-item--inner ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'control_type' => 'responsive',
                            'condition' => [
                                'layout' => ['8'],
                            ],
                        ),
                    ),
),
array(
    'name' => 'section_style_title',
    'label' => esc_html__('Title', 'meddox'),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'title_tag',
            'label' => esc_html__('HTML Tag', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
            'default' => 'h3',
        ),
        array(
            'name' => 'title_color',
            'label' => esc_html__('Title Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--title' => 'color: {{VALUE}};',
                '{{WRAPPER}} .pxl-icon-box .pxl-item--title span' => 'color: {{VALUE}};text-fill-color: {{VALUE}};-webkit-text-fill-color: {{VALUE}};background-image: none;',
            ],
        ),
        array(
            'name' => 'title_typography',
            'label' => esc_html__('Title Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-icon-box .pxl-item--title',
        ),
        array(
            'name' => 'title_top_spacer',
            'label' => esc_html__('Title Top Spacer', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 3000,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--title' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
            ],
        ),
        array(
            'name' => 'title_bottom_spacer',
            'label' => esc_html__('Title Bottom Spacer', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--title' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
            ],
        ),
    ),
),
array(
    'name' => 'section_style_desc',
    'label' => esc_html__('Description', 'meddox'),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'desc_color',
            'label' => esc_html__('Description Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--description' => 'color: {{VALUE}};',
                '{{WRAPPER}} .pxl-icon-box .pxl-item--description a' => 'color: {{VALUE}};',
            ],
        ),
        array(
            'name' => 'desc_color_hover',
            'label' => esc_html__('Description Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--description a:hover' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'layout' => ['2'],
            ],
        ),
        array(
            'name' => 'desc_typography',
            'label' => esc_html__('Description Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-icon-box .pxl-item--description',
            'selector' => '{{WRAPPER}} .pxl-icon-box .pxl-item--description a',
        ),
    ),
),
array(
    'name' => 'section_style_icon',
    'label' => esc_html__('Icon', 'meddox'),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'icon_color',
            'label' => esc_html__('Icon Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--icon i' => 'color: {{VALUE}};text-fill-color: {{VALUE}};-webkit-text-fill-color: {{VALUE}};background-image: none;',
            ],
            'condition' => [
                'icon_type' => 'icon',
            ],
        ),
        array(
            'name' => 'bg_icon_color',
            'label' => esc_html__('Background Icon Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--icon ' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'icon_type' => 'icon',
                'icon_type' => 'image',
            ],
        ),
        array(
            'name' => 'icon_font_size',
            'label' => esc_html__('Icon Font Size', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--icon i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'icon_type' => 'icon',
            ],
        ),
        array(
            'name' => 'icon_img_max_height',
            'label' => esc_html__('Icon Image Max Height', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--icon img' => 'max-height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'icon_type' => 'image',
            ],
        ),
        array(
            'name'         => 'icon_bg_gradient',
            'label' => esc_html__( 'Box Background', 'meddox' ),
            'type'         => \Elementor\Group_Control_Background::get_type(),
            'control_type' => 'group',
            'types' => [ 'gradient' ],
            'selector'     => '{{WRAPPER}} .pxl-icon-box5 .pxl-item--icon',
            'condition' => [
                'layout' => ['5','6'],
            ],
        ),
        array(
            'name'         => 'icon_box_hover_shadow',
            'label' => esc_html__( 'Hover Box Shadow', 'meddox' ),
            'type'         => \Elementor\Group_Control_Box_Shadow::get_type(),
            'control_type' => 'group',
            'selector'     => '{{WRAPPER}} .pxl-icon-box5 .pxl-item--inner:hover .pxl-item--icon',
            'condition' => [
                'layout' => ['5','6'],
            ],
        ),
    ),
),
array(
    'name' => 'section_style_button',
    'label' => esc_html__('Button', 'meddox'),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'condition' => [
        'layout' => ['1','2'],
    ],
    'controls' => array(
        array(
            'name' => 'button_color',
            'label' => esc_html__('Button Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-item--link a' => 'color: {{VALUE}};text-fill-color: {{VALUE}};-webkit-text-fill-color: {{VALUE}};background-image: none;',
            ],
            'condition' => [
                'layout' => ['1','2'],
            ],
        ),
        array(
            'name' => 'button_typography',
            'label' => esc_html__('Button Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-icon-box .pxl-item--link a',
        ),
        array(
            'name' => 'button_background_color',
            'label' => esc_html__('Button Background Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-item--link a' => 'background-color: {{VALUE}} !important;',
            ],
            'condition' => [
                'layout' => ['1','2'],
            ],
        ),
        array(
            'name' => 'border_button_color',
            'label' => esc_html__('Border Button Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-item--link a' => 'border-color: {{VALUE}};',
            ],
            'condition' => [
                'layout' => ['1','2'],
            ],
        ),

        array(
            'name' => 'icon_btn_color',
            'label' => esc_html__('Icon Button Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-item--link .pxl-item-btn-icon i' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'layout' => ['1'],
            ],
        ),
        array(
            'name' => 'button_color_hover',
            'label' => esc_html__('Button Color Hover', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-item--link a:hover' => 'color: {{VALUE}} !important;',
                '{{WRAPPER}} .pxl-item--link a:hover i' => 'color: {{VALUE}} !important;;',
            ],
            'condition' => [
                'layout' => ['1','2','3'],
            ],
        ),

        array(
            'name' => 'button_background_color_hv',
            'label' => esc_html__('Button Background Color Hover', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-item--link a:hover' => 'background-color: {{VALUE}} !important;',
            ],
            'condition' => [
                'layout' => ['1','2'],
            ],
        ),
        array(
            'name' => 'border_button_color_hover',
            'label' => esc_html__('Border Button Color Hover', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-item--link a:hover' => 'border-color: {{VALUE}} !important;;',
            ],
            'condition' => [
                'layout' => ['2'],
            ],
        ),
        array(
            'name' => 'icon_btn_font_size',
            'label' => esc_html__('Icon Font Size', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--link .pxl-item-btn-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout' => ['1'],
            ],
        ),

        array(
            'name' => 'border_icon_button_width',
            'label' => esc_html__('Border Icon Button Width', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--link .pxl-item-btn-icon i' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout' => ['1'],
            ],
        ),

        array(
            'name' => 'border_icon_button_height',
            'label' => esc_html__('Border Icon Button Height', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'control_type' => 'responsive',
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .pxl-icon-box .pxl-item--link .pxl-item-btn-icon i' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout' => ['1'],
            ],
        ),




    ),
),
meddox_widget_animation_settings(),
),
),
),
meddox_get_class_widget_path()
);