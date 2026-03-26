<?php
// Register Button Widget
use Elementor\Controls_Manager;

etc_add_custom_widget(
    array(
        'name' => 'cms_button_anchor',
        'title' => esc_html__('Button Anchor', 'medcity' ),
        'icon' => 'eicon-anchor',
        'categories' => array( Elementor_Theme_Core::ETC_CATEGORY_NAME ),
        'params' => array(
            'sections' => array(
                //  Layout
                array(
                    'name'     => 'layout_section',
                    'label'    => esc_html__('Layout', 'medcity' ),
                    'tab'      => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name'    => 'layout',
                            'label'   => esc_html__('Templates', 'medcity' ),
                            'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__('Layout 1', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_button_anchor/layout/1.webp'
                                ],
                                '2' => [
                                    'label' => esc_html__('Layout 2', 'medcity' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_button_anchor/layout/2.webp'
                                ]
                            ],
                        ),
                    ),
                ),
                // Content
                array(
                    'name' => 'content_section',
                    'label' => esc_html__('CMS Anchor', 'medcity' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name'        => 'anchor_id',
                            'label'       => esc_html__('The ID of Menu Anchor.', 'medcity' ),
                            'type'        => \Elementor\Controls_Manager::TEXT,
                            'placeholder' => esc_html__('For Example: About', 'medcity' ),
                            'description' => esc_html__( 'This ID will be the CSS ID you will have to use in your own page, Without #.', 'medcity' ),
                            'label_block' => true,
                        ),
                        array(
                            'name'            => 'anchor_note',
                            'type'            => \Elementor\Controls_Manager::RAW_HTML,
                            'raw'             => sprintf( esc_html__( 'Note: The ID link ONLY accepts these chars: %s', 'medcity' ), '`A-Z, a-z, 0-9, _ , -`' ),
                            'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);