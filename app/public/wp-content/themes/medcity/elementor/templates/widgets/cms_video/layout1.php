<?php
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		'cms-gradient-black-bt',
		//'hover-image-move',
		//'hover-remove-gradient',
		'overflow-hidden'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
<?php 
    // Video Banner
	$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
    medcity_elementor_image_render($settings, [
		'custom_size'   => ['width' => 1480,'height' => 800],
		'img_class'     => 'img-cover cms-radius-20',
		'before'        => '',
		'max_height'	=> true,
		'after'         => '<div class="cms-gradient-render cms-overlay"></div>'
    ]);
    // video button
    medcity_elementor_button_video_render($widget, $settings, [
		'name'       => 'video_link',
		// icon
		'icon'       => $widget->get_setting('video_icon'),
		'icon_size'	 => 15,
		'icon_color' => $widget->get_setting('video_text_color', 'secondary'),
		'icon_class' => 'bg-hover-primary text-hover-white m-lr-auto mb-30',
		// text
		'text'       => $widget->get_setting('video_text', ''),
		'text_class' => 'cms-play-text2 heading font-300 font-italic text-50 text-center d-inline-block lh-11 text-'.$widget->get_setting('video_text_color', 'white'),
		// other
		'layout'        => '1 cms-btn-video-1 size-large',
		'class'         => 'cms-overlay justify-content-center',
		'inner_class'   => 'absolute center',
		'content_class' => '',
		'echo'          => true,
		'default'       => true
    ]);
?>
</div>
