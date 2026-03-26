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
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-700 empty-none mt-n5',
		'text-'.$widget->get_setting('description_bold_color','body')
	])
]);
// Feature
$features = $widget->get_setting('cms_feature', []);
$features2 = $widget->get_setting('cms_feature2', []);
$widget->add_render_attribute('features-wrap', [
	'class' => [
		'cms-heading-features2 d-flex flex-cols-2 flex-cols-smobile-1',
		'pt-40'
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
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
	<?php if($settings['show_feature'] == 'yes'): ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('features-wrap')); ?>>
		<div><?php 
			// Feature 1
			foreach ( $features as $key => $cms_feature ):
				$title_key = $widget->get_repeater_setting_key( 'title', 'cms_list', $key );
				$widget->add_render_attribute($title_key, [
					'class' => [
						'feature-title flex-auto',
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
										'class'       => 'cms-icon flex-auto',
										'icon_size'   => 22,
										'icon_color'  => $widget->get_setting('feature_icon_color','primary')
		            	]);
		            ?>
	            	<div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $cms_feature['title'] ) ?></div>
		        </div>
			<?php endforeach; ?>
		</div>
		<div>
			<?php
			// Feature 2
			foreach ( $features2 as $key => $cms_feature ):
				$title_key = $widget->get_repeater_setting_key( 'title', 'cms_list', $key );
				$widget->add_render_attribute($title_key, [
					'class' => [
						'feature-title flex-auto',
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
										'class'       => 'cms-icon flex-auto',
										'icon_size'   => 22,
										'icon_color'  => $widget->get_setting('feature_icon_color','primary')
		            	]);
		            ?>
	            	<div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $cms_feature['title'] ) ?></div>
		        </div>
			<?php endforeach;?>
		</div>
	</div>
	<?php endif; ?>
</div>