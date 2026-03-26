<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_quote',
        'title' => esc_html__('Pxl Quote', 'meddox' ),
        'icon' => 'eicon-blockquote',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'text',
                            'label' => esc_html__('Content Quote', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXTAREA,
                        ),
                        array(
                            'name' => 'text_typography',
                            'label' => esc_html__('Typography Content ', 'meddox' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-quote .content-quote',

                        ),
                        array(
                            'name' => 'author',
                            'label' => esc_html__('Author', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),

                        array(
                            'name' => 'author_typography',
                            'label' => esc_html__('Typography Author ', 'meddox' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-quote .content-author',

                        ),

                    ),
                ), 
            ),
        ),
    ),
    meddox_get_class_widget_path()
);