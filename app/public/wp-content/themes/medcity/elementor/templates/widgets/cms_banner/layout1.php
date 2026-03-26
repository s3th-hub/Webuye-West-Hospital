<?php 
//wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$widget->get_setting('layout')
	]
]);
$attachment_id = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
<?php
	medcity_elementor_image_render($settings,[
		'name'      => 'banner',
		'img_class' => 'cms-radius-12',
		'custom_size' => ['width' => 500, 'height' => 558]
	]);
?>
</div>