<?php
	// Wrap 
	$widget->add_render_attribute('wrap',[
		'class' => [
			'cms-eqc',
			'cms-eqc-'.$settings['layout'],
			medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align']),
			'bg-white cms-radius-12 divider-l-accent',
			'relative p-40 p-lr-smobile-20'
		]
	]);
	// Title
	$widget->add_inline_editing_attributes( 'title', 'Quick Contact' );
	$widget->add_render_attribute( 'title', [
		'class' => [
			'cms-title text-18',
			'text-'.$widget->get_setting('title_color','heading'),
			'mt-n8'
		]
	]);
	// Description
	$widget->add_inline_editing_attributes( 'desc', 'none' );
	$widget->add_render_attribute( 'desc', [
		'class' => [
			'cms-desc',
			'text-'.$widget->get_setting('desc_color','body'),
			'text-14',
			'pt-25'
		]
	]);
	$desc = $widget->get_setting('desc','');
	// Phone
	$icon_phone_color = $widget->get_setting('icon_phone_color', 'tertiary');
	$phone_color = $widget->get_setting('phone_color', 'tertiary');
	$phone_color_hover = $widget->get_setting('phone_color_hover', 'tertiary');
	$phone_link  = str_replace(' ', '', $settings['phone']);
	$widget->add_render_attribute( 'phone-item',[ 
		'class' => [
			'cms-eqc-item',
			'd-flex align-items-center gap-10',
			medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
			'cms-phone text-22 font-700 heading',
			'text-'.$phone_color,
			'text-hover-'.$phone_color_hover
		],
		'href' => 'tel:'.$phone_link
	]);
		// phone icon
		$widget->add_render_attribute( 'phone-icon', [
			'class' => [
				'cms-icon',
				'cms-icon-color',
				'text-'.$icon_phone_color,
				'text-18 lh-0'
			]
		]);
		// phone title
		$widget->add_inline_editing_attributes('phone_title');
		$widget->add_render_attribute( 'phone_title',[ 
			'class' => [
				'cms-phone-title',
				'cms-icon-color',
				'text-'.$icon_phone_color,
				medcity_add_hidden_device_controls_render($settings, 'title_'),
				'empty-none'
			]
		]);
		// phone number
		$widget->add_inline_editing_attributes('phone');
		$widget->add_render_attribute( 'phone',[ 
			'class' => [
				'cms-phone-text',
				//medcity_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
	// Adress
		$icon_address_color = $widget->get_setting('icon_address_color', 'primary');
		$address_color = $widget->get_setting('address_color', 'body');
		$address_color_hover = $widget->get_setting('address_color_hover', 'secondary');

		$address     = $settings['address'];
		$map_zoom    = 14;
		$map_api_key = medcity_get_opt('gm_api_key');
		$map_params  = [
		    rawurlencode( $address ),
		    absint( $map_zoom )
		];
		$map_url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;iwloc=near';
		
		$widget->add_render_attribute( 'address-item', [
			'class' => [
				'cms-eqc-item',
				'd-flex align-items-center gap-10',
				medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
				'cms-address',
				'text-'.$address_color,
				'text-hover-'.$address_color_hover
			],
			'href'   => vsprintf( $map_url, $map_params ),
			'target' => '_blank'
		]);
		$widget->add_render_attribute( 'address-item-link', [
			'class' => [
				'cms-eqc-item-address',
				'd-flex align-items-center gap-10',
				medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
				'cms-address',
				'text-'.$icon_address_color,
				'text-hover-'.$address_color_hover,
				'font-700 text-15'
			],
			'href'   => vsprintf( $map_url, $map_params ),
			'target' => '_blank'
		]);
		// address icon
		$widget->add_render_attribute( 'address-icon', [
			'class' => [
				'cms-icon',
				'cms-icon-color',
				//'text-'.$icon_address_color,
				//'text-hover-'.$address_color_hover,
				'text-12 lh-0'
			]
		]);
		// address title
		$widget->add_inline_editing_attributes( 'address_title' );
		$widget->add_render_attribute( 'address_title', [
			'class' => [
				'cms-address-title',
				'cms-icon-color',
				'text-'.$icon_address_color,
				'text-hover-'.$address_color_hover,
				medcity_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
		// address
		$widget->add_inline_editing_attributes( 'address' );
		$widget->add_render_attribute( 'address', [
			'class' => [
				'cms-address-text',
				//medcity_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php 
	// Icon/Image Background
	medcity_elementor_icon_image_render($widget,$settings, [
		'name'        => 'icon_background',
		'color'       => 'secondary',
		'color_hover' => 'secondary',
		'size'        => 168,
		'class'       => 'cms-qc-bg-icon absolute bottom-right'
	]);
	?>
	<div class="relative">
		<?php
		// Title
		if (!empty($widget->get_setting('title'))) { ?>
			<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php 
				echo etc_print_html( $widget->get_setting('title') ); 
			?></h2>
		<?php 
		} if(!empty($desc)) { ?>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'desc' ) ); ?>><?php 
			echo nl2br( $desc ); 
		?></div>
		<div class="pt-15 empty-none text-14"><?php }
		// Phone
		if(!empty($settings['phone'])) { ?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'phone-item' ) ); ?>>
				<span <?php etc_print_html($widget->get_render_attribute_string('phone-icon')); ?>><?php medcity_svgs_icon_render(['icon' => 'phone', 'echo' => true]); ?></span>
				<span <?php etc_print_html($widget->get_render_attribute_string('phone_title')); ?>><?php echo esc_html($settings['phone_title']); ?></span>
				<span <?php etc_print_html($widget->get_render_attribute_string('phone')); ?>><?php echo esc_html($settings['phone']); ?></span>
			</a>
		<?php }  
		// Address
		if(!empty($address)) { ?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'address-item' ) ); ?>>
				<span <?php etc_print_html($widget->get_render_attribute_string('address')); ?>><?php echo nl2br($settings['address']); ?></span>
			</a>
		<?php } 
		?></div>
		<div class="pt-20 d-flex gap-30">
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'address-item-link' ) ); ?>>
				<span <?php etc_print_html($widget->get_render_attribute_string('address-icon')); ?>><?php 
					medcity_svgs_icon_render(['icon' => 'arrow-right', 'echo' => true]); 
				?></span>
				<span><?php echo esc_html($settings['address_title']); ?></span>
			</a>
			<div class="cms-qc-socials empty-none d-flex gap-10"><?php
				// Socials
				$icons = $widget->get_setting('icons', []);
				foreach ( $icons as $key => $value ) {
					$_id = isset( $value['_id'] ) ? $value['_id'] : '';
					$link_key = $widget->get_repeater_setting_key( 'link', 'icons', $key );
					$color = !empty($value['color']) ? $value['color'] : 'secondary';
					$color_hover = !empty($value['color_hover']) ? $value['color_hover'] : 'primary';
					$widget->add_render_attribute( $link_key, 'class', [
							'cms-social-item',
							'elementor-repeater-item-' . $_id,
							'text-'.$color,
							'text-hover-'.$color_hover,
							'lh-1'
						] );
					$widget->add_link_attributes( $link_key, $value['link'] );
			?>
			<a <?php etc_print_html($widget->get_render_attribute_string( $link_key )); ?>><?php 
				medcity_elementor_icon_render( $value['icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon text-20' ] ); 
			?></a>
			<?php } ?></div>
		</div>
	</div>
</div>