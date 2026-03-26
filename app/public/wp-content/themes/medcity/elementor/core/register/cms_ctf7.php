<?php
// Register Contact Form 7 Widget
if(class_exists('WPCF7')) {
    $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');

    $contact_forms = array();
    if ($cf7) {
        foreach ($cf7 as $cform) {
            $contact_forms[$cform->ID] = $cform->post_title;
        }
    } else {
        $contact_forms[esc_html__('No contact forms found', 'medcity')] = 0;
    }


    etc_add_custom_widget(
        array(
            'name'       => 'cms_ctf7',
            'title'      => esc_html__('Contact Form 7', 'medcity'),
            'icon'       => 'eicon-form-horizontal',
            'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
            'scripts'    => array(),
            'params'     => array(
                'sections' => array(
                    array(
                        'name'     => 'layout_section',
                        'label'    => esc_html__('Source Settings', 'medcity'),
                        'tab'      => \Elementor\Controls_Manager::TAB_LAYOUT,
                        'controls' => array(
                            array(
                                'name'  => 'layout',
                                'label' => esc_html__('Layout', 'medcity' ),
                                'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                                'options' => [
                                    '1' => [
                                        'label' => esc_html__( 'Layout 1', 'medcity' ),
                                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_ctf7/layout/1.webp'
                                    ],
                                    '2' => [
                                        'label' => esc_html__( 'Layout 2', 'medcity' ),
                                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_ctf7/layout/2.webp'
                                    ],
                                ],
                                'default' => '1',
                            )
                        )
                    ),
                    array(
                        'name' => 'source_section',
                        'label' => esc_html__('Source Settings', 'medcity'),
                        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                        'controls' => array(
                            array(
                                'name'        => 'ctf7_title',
                                'label'       => esc_html__('Title', 'medcity' ),
                                'type'        => \Elementor\Controls_Manager::TEXT,
                                'label_block' => true,
                                'condition'   => [
                                    'layout' => ['2'],
                                ],
                            ),
                            array(
                                'name'        => 'ctf7_description',
                                'label'       => esc_html__('Description', 'medcity' ),
                                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                                'label_block' => true,
                                'rows'        => 6,
                                'condition'   => [
                                    'layout' => ['2'],
                                ],
                            ),
                            array(
                                'name'        => 'ctf7_id',
                                'label'       => esc_html__('Select Form', 'medcity'),
                                'type'        => \Elementor\Controls_Manager::SELECT,
                                'options'     => $contact_forms,
                                'label_block' => true
                            ),
                        ),
                    ),
                    array(
                        'name' => 'textarea_size',
                        'label' => esc_html__('Input Style', 'medcity'),
                        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                        'controls' => array(
                            array(
                                'name'  =>  'message_height',
                                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                                'label' => esc_html__('Textarea Height', 'medcity'),
                                'size_units' => ['px'],
                                'range' => [
                                    'px' => [
                                        'min' => 120,
                                        'max' => 350,
                                    ],
                                ],
                                'default'   => [
                                    'unit' => 'px',
                                    'size' => '',
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .wpcf7-form textarea.wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}};',
                                ],
                            ),
                            array(
                                'name'  => 'input_border_radius',
                                'label' => __( 'Input Border Radius', 'medcity' ),
                                'type' =>\Elementor\Controls_Manager::DIMENSIONS,
                                'size_units' => [ 'px', '%' ],
                                'selectors' => [
                                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                                    '{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important ;',
                                ],
                                'condition' => [
                                    'layout' => ['1']
                                ]
                            ),
                        ),
                    ),
                ),
            ),
        ),
        get_template_directory() . '/elementor/core/widgets/'
    );
}