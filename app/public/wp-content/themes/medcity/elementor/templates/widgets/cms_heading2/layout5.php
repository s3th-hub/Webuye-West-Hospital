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
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','secondary'),
		'lh-1375',
		'mt-n10 pb-35'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','secondary')
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-22 empty-none',
		'text-'.$widget->get_setting('description_color','body'),
	])
]);

// Buttons
$widget->add_render_attribute('buttons',[
	'class' => [
		'cms-heading-buttons d-flex gap mt-32',
		'justify-content-'.$widget->get_setting('align',$default_align),
		'align-items-center'
	]
]);
// Feature
$features = $widget->get_setting('cms_feature', []);
$widget->add_render_attribute('features-wrap', [
	'class' => [
		'cms-heading-features',
		'pt-60'
	]
]);
$widget->add_render_attribute('features-item',[
	'class' => [
		'cms-list',
		'hover-icon-bounce',
		'd-flex flex-nowrap gap-20'
	]
]);

?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('buttons')); ?>><?php
		medcity_elementor_link_button_render($widget, $settings, [
			'name'       => 'btn1', 
			'type'       => 'button', 
			'class'      => 'cms-btn-lg',
			'icon_class' => 'order-first',
			'icon_size'  => 20
		]);
		medcity_elementor_link_button_render($widget, $settings, [
			'name'                 => 'btn2', 
			'type'                 => 'button', 
			'class'                => 'cms-btn-lg cms-btn-xlg',
			'btn_text_color'       => 'secondary',
			'btn_text_hover_color' => 'white',
			'btn_prefix'           => 'cms-btn-outline-',
			'btn_color'						 => 'secondary',
			'btn_hover_color'			 => 'secondary' 
		]);
	?></div>
	<?php if($settings['show_feature'] == 'yes'): ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('features-wrap')); ?>>
		<?php 
		foreach ( $features as $key => $cms_feature ):
			$title_key = $widget->get_repeater_setting_key( 'title', 'cms_list', $key );
			$widget->add_render_attribute($title_key, [
				'class' => [
					'feature-title flex-basic',
					'text-15 font-700',
					'text-'.$widget->get_setting('feature_title_color','body')
				]
			]);
			$widget->add_inline_editing_attributes( $title_key, 'none' );
		?>
	        <div <?php etc_print_html($widget->get_render_attribute_string('features-item')); ?>>
	            <?php 
	            	medcity_elementor_icon_render($cms_feature['icon'], ['library' => 'awesome', 'value' => 'fas fa-check'], [ 
									'aria-hidden' => 'true', 
									'class'       => 'cms-icon flex-auto pt-5',
									'icon_size'   => 14,
									'icon_color'  => $widget->get_setting('feature_icon_color','secondary')
	            	]);
	            ?>
            	<div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $cms_feature['title'] ) ?></div>
	        </div>
		<?php endforeach;?>
	</div>
	<?php endif; ?>
</div>