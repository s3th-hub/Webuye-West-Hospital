<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-ezocdoc',
		'cms-ezocdoc-'.$widget->get_setting('layout'),
		'd-flex gap-20'
	])
]);

?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>><?php
	medcity_zocdoc_rating_render($widget, $settings, [
		'wrap_class' => 'flex-basic'
	]);
	medcity_elementor_link_button_render($widget, $settings, [
		'name'       => 'btn1', 
		'type'       => 'button', 
		'class'      => 'flex-auto flex-smobile-100',
		'icon_default' => [
			'library' => 'awesome',
			'value'   => 'fas fa-arrow-right'
		],
		'icon_class' => '',
		'icon_size'  => 12
	]);
?></div>