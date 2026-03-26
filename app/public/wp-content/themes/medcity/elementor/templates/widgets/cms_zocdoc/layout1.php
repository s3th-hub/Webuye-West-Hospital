<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-ezocdoc',
		'cms-ezocdoc-'.$widget->get_setting('layout')
	])
]);

?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>><?php
	medcity_zocdoc_rating_render($widget, $setting);
?></div>