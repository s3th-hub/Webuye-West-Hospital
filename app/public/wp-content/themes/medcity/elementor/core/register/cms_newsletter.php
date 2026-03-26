<?php

// Register Newsletter Form Widget
if(class_exists('Newsletter')) {
    $news_forms = array_filter( (array) get_option( 'newsletter_forms', array() ) );
    $news_forms_list = array(
        'default' => esc_html__( 'Default Form', 'medcity' )
    );
    if ( $news_forms )
    {
        $index = 1;
        foreach ( $news_forms as $key => $form )
        {
            $news_forms_list[$key] = sprintf( esc_html__( 'form_%s', 'medcity' ), $index );
            $index ++;
        }
    }
    etc_add_custom_widget(
        array(
            'name' => 'cms_newsletter',
            'title' => esc_html__('Newsletter Forms', 'medcity'),
            'icon' => 'eicon-form-horizontal',
            'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
            'scripts' => array(
                'cms-newsletter-widget-js',
            ),
            'params' => array(
                'sections' => array(
                    array(
                        'name' => 'source_section',
                        'label' => esc_html__('Content Settings', 'medcity'),
                        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                        'controls' => array(
                            array(
                                'name' => 'newsletter_id',
                                'label' => esc_html__('Select Form', 'medcity'),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'options' => $news_forms_list,
                                'default' => 'default',
                            ),
                            array(
                                'name' => 'form_style',
                                'label' => esc_html__('Form Style', 'medcity'),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'options' => [
                                    'default' => esc_html__('Default', 'medcity' ),
                                ],
                                'default' => 'default',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        get_template_directory() . '/elementor/core/widgets/'
    );
}