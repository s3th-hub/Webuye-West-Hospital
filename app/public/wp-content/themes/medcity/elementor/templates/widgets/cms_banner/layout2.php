<?php 
$icons_box = $widget->get_setting('icons_box', []);
//wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$widget->get_setting('layout'),
		'relative',
		'pt-smobile-200 bg-white cms-radius-12 overflow-hidden'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
<?php
	// banner
	medcity_elementor_image_render($settings,[
		'name'        => 'banner',
		'img_class'   => 'cms-radius-trbr-12 absolute top-right mh-100 ratio-152',
		'size'        => 'custom',
		'custom_size' => ['width' => 878, 'height' => 584]
	]);
?>
	<div class="cms-ebanner-icons-box d-flex flex-cols-4 flex-cols-tablet-2 flex-cols-smobile-1 relative z-top"><?php 
		// Icons Boxs
		$count = 0;
		foreach ($icons_box as $key => $icon_box) {
			$count ++;
			if($count == 1){
				$box_class = 'cms-radius-tl-12';
			} elseif($count == 2){
				$box_class = 'cms-radius-bl-12';
			} else {
				$box_class = '';
			}
			// Item key
			$item_key = $widget->get_repeater_setting_key( 'item_key', 'cms_ebanner', $key );
	    $widget->add_render_attribute( $item_key,[
	        'class' => [
	        	'cms-ebanner-icon-box',
	        	'bg-white cms-shadow-1',
	        	'p-40',
	        	$box_class
	        ]
	    ]);
	    // Item title
	    $item_title_key = $widget->get_repeater_setting_key( 'item_title_key', 'cms_ebanner', $key );
	    $widget->add_render_attribute( $item_title_key,[
	        'class' => [
	        	'cms-heading',
	        	'text-20',
	        	'pt-105 mb-n8'
	        ]
	    ]);
	?>
		<div <?php etc_print_html($widget->get_render_attribute_string( $item_key )); ?>>
			<?php 
				medcity_elementor_icon_image_render($widget, $settings, [
					'size' => 48,
					'class' => 'lh-1'
				], $icon_box);
			?>
			<h3 <?php etc_print_html($widget->get_render_attribute_string( $item_title_key )); ?>><?php 
				printf('%s',$icon_box['title']);
			?></h3>
		</div>
	<?php
			if($count == 1){
				echo '<div class="col-separate w-100"></div>';
			}
		}
		// Button
		medcity_elementor_link_button_render($widget, $settings, [
			'name'       => 'link1', 
			'type'       => 'button', 
			'class'      => 'cms-btn-xl w-100',
			'before'		 => '<div class="cms-ebanner-icon-box box-link d-flex align-items-end p-40">',
			'after'			 => '</div>',
			//icon
			'icon_default' => ['library' => 'awesome', 'value' => 'fas fa-arrow-right'],
			'icon_class'   => '',
			'icon_size'    => 12,
		]);
	?>
	</div>
</div>