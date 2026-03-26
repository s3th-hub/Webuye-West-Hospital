<?php
$widget->add_inline_editing_attributes( 'title' );
$widget->add_inline_editing_attributes( 'text' );
$widget->add_inline_editing_attributes( 'link_text' );
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-cta',
		'cms-cta-'.$settings['layout'],
		'text-14 font-700',
		medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align', 'default' => $default_align]),
		'empty-none',
		'p-tb-15 p-lr-25 cms-shadow-1 cms-radius-10 bg-white',
		'd-flex flex-nowrap'
	])
]);
// Text
$widget->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'text-'.$widget->get_setting('text_color','body'),
		'empty-none'
	]
]);
// Link
$page_link = $widget->get_setting('page_link','');
switch ($settings['link_type']) {
	case 'page':
		$url  = !empty($page_link) ? get_permalink($page_link) : '#';
		break;
	
	default:
		$url = $widget->get_setting('custom_link', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'link_text', [
	'class' => [
		'text-'.$widget->get_setting('link_color','secondary'),
		'text-hover-'.$widget->get_setting('link_color_hover','primary'),
		'font-700',
		'd-inline-flex align-items-center gap-10'
	],
	'href'	=> $url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php medcity_elementor_icon_image_render($widget, $settings, [
		'size'         => 16,
		'class'				 => 'pr-10',
		'icon_tag'     => 'span',
		'icon_default' => [
			'library' => 'awesome',
			'value'	  => 'fas fa-star'
		]
	]); ?>
	<div>
		<span <?php etc_print_html($widget->get_render_attribute_string('text')) ?>><?php 
			printf('%s&nbsp;', nl2br($settings['text']));
		?></span>
		<?php if(!empty($settings['link_text'])): ?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>>
				<?php 
					// text
					echo esc_html( $settings['link_text'] );
					// icon
					medcity_elementor_button_icon_render();
				?>
			</a>
		<?php endif; ?>
	</div>
</div>