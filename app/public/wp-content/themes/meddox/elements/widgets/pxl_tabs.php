<?php
$templates = meddox_get_templates_option('tab', []) ;
pxl_add_custom_widget(
    array(
        'name' => 'pxl_tabs',
        'title' => esc_html__( 'Pxl Tabs', 'meddox' ),
        'icon' => 'eicon-tabs',
        'categories' => array('pxltheme-core'),
        'scripts' => array(
            'meddox-tabs'
        ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'tab_content',
                    'label' => esc_html__( 'Tabs', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'tab_active',
                            'label' => esc_html__( 'Active Tab', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => 1,
                            'separator' => 'after',
                        ),
                        array(
                            'name' => 'tabs',
                            'label' => esc_html__( 'Content', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(
                                array(
                                    'name' => 'title',
                                    'label' => esc_html__( 'Title', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                ),
                               array(
                                    'name' => 'pxl_icon',
                                    'label' => esc_html__('Icon', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::ICONS,
                                    'fa4compatibility' => 'icon',
                                ),
                                array(
                                    'name' => 'content_type',
                                    'label' => esc_html__('Content Type', 'meddox'),
                                    'type' => 'select',
                                    'options' => [
                                        'df' => esc_html__( 'Default', 'meddox' ),
                                        'template' => esc_html__( 'From Template Builder', 'meddox' )
                                    ],
                                    'default' => 'df' 
                                ),
                                array(
                                    'name' => 'desc',
                                    'label' => esc_html__( 'Content', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                                    'condition' => ['content_type' => 'df'] 
                                ),
                                array(
                                    'name' => 'content_template',
                                    'label' => esc_html__('Select Templates', 'meddox'),
                                    'type' => 'select',
                                    'options' => $templates,
                                    'default' => 'df',
                                    'description' => 'Add new tab template: "<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '" target="_blank">Click Here</a>"',
                                    'condition' => ['content_type' => 'template'] 
                                ),
                            ),
                            'title_field' => '{{{ title }}}',
                        ),
                    ),
),
array(
    'name' => 'tab_style',
    'label' => esc_html__( 'Style', 'meddox' ),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'style',
            'label' => esc_html__('Style', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'style-round-box' => 'Round Box',
                'style-button-set' => 'Button No Background',
            ],
            'default' => 'style-round-box',
        ),
        array(
            'name' => 'tab_effect',
            'label' => esc_html__('Effect', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'tab-effect-slide' => 'Slide',
                'tab-effect-fade' => 'Fade',
            ],
            'default' => 'tab-effect-slide',
        ),
        array(
            'name' => 'title_color',
            'label' => esc_html__('Title Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-tabs .pxl-item--title' => 'color: {{VALUE}};',
            ],
        ),
        array(
            'name' => 'title_active_color',
            'label' => esc_html__('Title Active Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-tabs .pxl-item--title' => 'color: {{VALUE}};',
            ],
        ),
        array(
            'name' => 'title_typography',
            'label' => esc_html__('Title Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-tabs .pxl-item--title',
            'separator' => 'after',
        ),
        array(
            'name' => 'content_color',
            'label' => esc_html__('Content Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-tabs .pxl-item--content' => 'color: {{VALUE}};',
            ],
        ),
        array(
            'name' => 'content_typography',
            'label' => esc_html__('Content Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-tabs .pxl-item--content',
        ),
    ),
),
meddox_widget_animation_settings(),
),
),
),
meddox_get_class_widget_path()
);