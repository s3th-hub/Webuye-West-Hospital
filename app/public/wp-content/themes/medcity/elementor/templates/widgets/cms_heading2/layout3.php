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
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'pb-17',
		'text-16 font-700 mt-n8',
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'lh-1375',
		'mt-n10'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold pt-37 font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading')
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-22 empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);

// Buttons
$widget->add_render_attribute('buttons',[
	'class' => [
		'cms-heading-buttons d-flex gap pt-40 mt-32',
		'justify-content-'.$widget->get_setting('align',$default_align),
		'align-items-center',
		'bdr-t-2'
	]
]);

// Link 1
$link1_page = $widget->get_setting('link1_page');
switch ($settings['link1_type']) {
	case 'page':
		$url  = !empty($link1_page) ? get_permalink($link1_page) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link1_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_inline_editing_attributes( 'link1_text' );
$widget->add_render_attribute( 'link1_text', [
	'class' => [
		'cms-btn cms-btn-lg',
		'cms-btn-'.$widget->get_setting('link1_bg_color','accent'),
		'text-'.$widget->get_setting('link1_color','white'),
		'cms-btn-hover-'.$widget->get_setting('link1_bg_hover_color', 'secondary'),
		'text-hover-'.$widget->get_setting('link1_color_hover', 'white')
	],
	'href'	=> $url
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
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
	<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('buttons')); ?>>
		<?php if(!empty($settings['link1_text'])) { ?>
			<div>
				<a <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>>
					<?php echo esc_html( $settings['link1_text'] ); ?>
				</a>
			</div>
		<?php } ?>
		<div <?php etc_print_html($widget->get_render_attribute_string('signature-wrap')); ?>>
			<?php medcity_elementor_image_render($settings, [
				'name'        => 'savatar',
				'size'		    => 'custom',
				'custom_size' => ['width' => 56, 'height' => 56],
				'img_class'   => $savatar_class,
				'before'      => '<div class="savatars">',
				'after'       => '</div>'
			]); ?>
			<div class="stext flex-auto relative">
				<?php 
					medcity_elementor_image_render($settings, [
						'name'        => 'simage',
						'size'        => 'custom',
						'custom_size' => ['width' => 120, 'height'=> 61],
						'img_class'		=> 'cms-simg'
					]);
				?>
				<div class="cms--signature absolute bottom-left pl-40">
					<div <?php etc_print_html($widget->get_render_attribute_string('sname')); ?>><?php echo nl2br($settings['sname']); ?></div>
					<div <?php etc_print_html($widget->get_render_attribute_string('sposition')); ?>><?php echo nl2br($settings['sposition']); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>