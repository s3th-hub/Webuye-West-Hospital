<?php
use Elementor\Controls_Manager;
use Elementor\Base_Data_Control;

if(!function_exists('medcity_widget_cms_copyright_register_controls')){
	add_action('etc_widget_cms_copyright_register_controls', 'medcity_widget_cms_copyright_register_controls', 10, 1);
	function medcity_widget_cms_copyright_register_controls($widget){
		// Layout Settings
		$widget->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__( 'Copyright', 'medcity' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
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
		                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_copyright/layout/1.webp'
		                ]
		            ]
		        ]
			);
		$widget->end_controls_section();
		// Content Settings
		$widget->start_controls_section(
			'setting_section',
            [
            	'label'    => esc_html__('Settings', 'medcity'),
            	'tab'      => \Elementor\Controls_Manager::TAB_CONTENT
            ]
		);
		$widget->add_control(
			'copyright_text',
			[
				'label'       => esc_html__('Copyright Text', 'medcity'),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'description' => esc_html__('Use [[year]] variable to insert current year, [[name]] variable to insert site name.', 'medcity'),
				'label_block' => true,
				'default' => '&copy;[[year]] [[name]], All Rights Reserved. With Love by <a href="https://7oroof.com/" target="_blank" rel="nofollow">7oroof.com</a>',
			]
		);
        
		$widget->end_controls_section();
		// Style
        $widget->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Style', 'medcity'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'text_color',
                'label'     => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'link_color',
                'label'     => esc_html__( 'Link Color', 'medcity' ),
                'selectors' => [
	                    '{{WRAPPER}} a' => 'color: {{VALUE}};',
	                ],
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'link_color_hover',
                'label'     => esc_html__( 'Link Color Hover', 'medcity' ),
                'selectors' => [
	                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
	                ],
            ]);
        $widget->end_controls_section();
	}
}
?>