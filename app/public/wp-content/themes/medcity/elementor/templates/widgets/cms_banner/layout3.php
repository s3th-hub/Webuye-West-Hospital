<?php 
$icons_box = $widget->get_setting('icons_box', []);
//wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$widget->get_setting('layout'),
		'relative'
	]
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-25 empty-none',
		'text-14 lh-1786',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php
		// banner
		medcity_elementor_image_render($settings,[
			'name'        => 'banner',
			'img_class'   => '',
			'size'        => 'custom',
			'custom_size' => ['width' => 185, 'height' => 50]
		]);
	?>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<?php
		medcity_elementor_link_button_render($widget, $settings, [
			'name'       => 'link3', 
			'type'       => 'link', 
			'class'      => 'pt-15',
			// icon
			'icon_default' => ['library' => 'awesome', 'value' => 'fas fa-arrow-right'],
			//'icon_class' => '',
			//'icon_size'  => 12
		]);
	?>
</div>