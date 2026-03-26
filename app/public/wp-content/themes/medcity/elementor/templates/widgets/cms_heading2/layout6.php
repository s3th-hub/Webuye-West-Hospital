<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align)
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc mt-n5 empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);

// Buttons
$widget->add_render_attribute('buttons',[
	'class' => [
		'cms-heading-buttons d-flex gap pt-20',
		'justify-content-'.$widget->get_setting('align',$default_align),
		'align-items-center'
	]
]);
// Signature
$widget->add_render_attribute('signature-wrap',[
	'class' => [
		'cms-signature d-flex gap-10 align-items-center'
	]
]);
$savatar_class = medcity_nice_class(['savatar', 'circle']);
//
$widget->add_inline_editing_attributes( 'sname' );
$widget->add_render_attribute('sname', [
	'class' => [
		'sname',
		'cms-heading text-17 font-700',
		'text-nowrap'
	]
]);
//
$widget->add_inline_editing_attributes( 'sposition' );
$widget->add_render_attribute('sposition', [
	'class' => [
		'sposition',
		'text-14 text-accent',
		'text-nowrap'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('buttons')); ?>><?php 
			// Button
			medcity_elementor_link_button_render($widget, $settings, [
			'name'       => 'btn1', 
			'type'       => 'button', 
			'class'      => 'cms-btn2 cms-btn-xlg',
			'icon_default' => ['library' => 'awesome', 'value' => 'fas fa-arrow-right'],
			'icon_class' => '',
			'icon_size'  => 12
		]); ?>
		<div <?php etc_print_html($widget->get_render_attribute_string('signature-wrap')); ?>>
			<?php medcity_elementor_image_render($settings, [
				'name'        => 'savatar',
				'size'		    => 'custom',
				'custom_size' => ['width' => 86, 'height' => 86],
				'img_class'   => $savatar_class,
				'before'      => '<div class="savatars">',
				'after'       => '</div>'
			]); ?>
			<div class="stext flex-auto relative">
				<?php 
					medcity_elementor_image_render($settings, [
						'name'        => 'simage',
						'size'        => 'custom',
						'custom_size' => ['width' => 170, 'height'=> 86],
						'img_class'		=> 'cms-simg'
					]);
				?>
				<div class="cms--signature absolute center-left">
					<div <?php etc_print_html($widget->get_render_attribute_string('sname')); ?>><?php echo nl2br($settings['sname']); ?></div>
					<div <?php etc_print_html($widget->get_render_attribute_string('sposition')); ?>><?php echo nl2br($settings['sposition']); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>