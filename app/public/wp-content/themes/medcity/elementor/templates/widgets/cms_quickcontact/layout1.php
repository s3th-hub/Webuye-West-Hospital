<?php
	// Wrap 
	$widget->add_render_attribute('wrap',[
		'class' => [
			'cms-eqc',
			'cms-eqc-'.$settings['layout'],
			medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align']),
			medcity_elementor_background_gradient_render($widget, $settings, ['default' => 3]),
			'cms-radius-12',
			'p-60 p-lr-smobile-20'
		]
	]);
	// Title
	$widget->add_inline_editing_attributes( 'title', 'Quick Contact' );
	$widget->add_render_attribute( 'title', [
		'class' => [
			'cms-title text-30',
			'text-'.$widget->get_setting('title_color','white'),
			'mt-n8'
		]
	]);
	// Description
	$widget->add_inline_editing_attributes( 'desc', 'none' );
	$widget->add_render_attribute( 'desc', [
		'class' => [
			'cms-desc',
			'text-'.$widget->get_setting('desc_color','white'),
			'font-700 text-18',
			'pt-15'
		]
	]);
	$desc = $widget->get_setting('desc','');
	// Email
		$icon_email_color = $widget->get_setting('icon_email_color', 'white');
		$email_color = $widget->get_setting('email_color', 'white');
		$email_color_hover = $widget->get_setting('email_color_hover', 'white');
		$widget->add_render_attribute( 'email-item', [
			'class' => [
				'cms-eqc-item',
				'd-flex align-items-center gap-10',
				medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
				'cms-email',
				'text-'.$email_color,
				'text-hover-'.$email_color_hover
			],
			'href'   => 'mailto:'.$settings['email'],
			'target' => '_blank'
		]);
		// email icon
		$widget->add_render_attribute( 'email-icon', [
			'class' => [
				'cms-icon',
				'cms-icon-color',
				'text-'.$icon_email_color,
				'cmsi-email',
				'text-16'
			]
		]);
		// email title
		$widget->add_inline_editing_attributes( 'email_title' );
		$widget->add_render_attribute( 'email_title', [
			'class' => [
				'cms-email-title',
				'cms-icon-color',
				'text-'.$icon_email_color,
				medcity_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
		// email
		$widget->add_inline_editing_attributes( 'email' );
		$widget->add_render_attribute( 'email', [
			'class' => [
				'cms-email-text',
				//medcity_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
	// Phone
	$icon_phone_color = $widget->get_setting('icon_phone_color', 'white');
	$phone_color = $widget->get_setting('phone_color', 'white');
	$phone_color_hover = $widget->get_setting('phone_color_hover', 'white');
	$phone_link  = str_replace(' ', '', $settings['phone']);
	$widget->add_render_attribute( 'phone-item',[ 
		'class' => [
			'cms-eqc-item',
			'd-flex align-items-center gap-10',
			medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
			'cms-phone',
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
				'text-16'
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
	// Time
		$icon_time_color = $widget->get_setting('icon_time_color', 'white');
		$time_color = $widget->get_setting('time_color', 'white');
		$time_color_hover = $widget->get_setting('time_color_hover', 'white');
		$widget->add_render_attribute( 'time-item', [
			'class' => [
				'cms-eqc-item',
				'd-flex align-items-center gap-10',
				medcity_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
				'cms-time',
				'text-'.$time_color,
				'text-hover-'.$time_color_hover
			]
		]);
		// time icon
		$widget->add_render_attribute( 'time-icon', [
			'class' => [
				'cms-icon',
				'cms-icon-color',
				'text-'.$icon_time_color,
				'cmsi-clock',
				'text-16'
			]
		]);
		// time title
		$widget->add_inline_editing_attributes( 'time_title' );
		$widget->add_render_attribute( 'time_title', [
			'class' => [
				'cms-time-title',
				'cms-icon-color',
				'text-'.$icon_time_color,
				medcity_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
		// time
		$widget->add_inline_editing_attributes( 'time' );
		$widget->add_render_attribute( 'time', [
			'class' => [
				'cms-time-text',
				//medcity_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
	// Adress
		$icon_address_color = $widget->get_setting('icon_address_color', 'white');
		$address_color = $widget->get_setting('address_color', 'white');
		$address_color_hover = $widget->get_setting('address_color_hover', 'white');

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
		// address icon
		$widget->add_render_attribute( 'address-icon', [
			'class' => [
				'cms-icon',
				'cms-icon-color',
				'text-'.$icon_address_color,
				'text-20'
			]
		]);
		// address title
		$widget->add_inline_editing_attributes( 'address_title' );
		$widget->add_render_attribute( 'address_title', [
			'class' => [
				'cms-address-title',
				'cms-icon-color',
				'text-'.$icon_address_color,
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
	<?php medcity_elementor_background_gradient_inner_render($widget, $settings); ?>
	<div class="relative">
		<?php if (!empty($widget->get_setting('title'))) { ?>
			<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php 
				echo etc_print_html( $widget->get_setting('title') ); 
			?></h2>
		<?php } ?>
		<?php if(!empty($desc)) { ?>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'desc' ) ); ?>><?php 
			echo nl2br( $desc ); 
		?></div>
		<div class="pt-55 empty-none font-700 text-14"><?php }
		// Email
		if(!empty($settings['email'])){
		?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'email-item' ) ); ?>>
			<span <?php etc_print_html($widget->get_render_attribute_string('email-icon')); ?>><?php medcity_svgs_icon_render(['icon' => 'mail', 'echo' => true]); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('email_title')); ?>><?php echo esc_html($settings['email_title']); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('email')); ?>><?php echo esc_html($settings['email']); ?></span>
		</a>
		<?php }
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
				<span <?php etc_print_html($widget->get_render_attribute_string('address-icon')); ?>><?php medcity_svgs_icon_render(['icon' => 'map', 'echo' => true]); ?></span>
				<span <?php etc_print_html($widget->get_render_attribute_string('address_title')); ?>><?php echo esc_html($settings['address_title']); ?></span>
				<span <?php etc_print_html($widget->get_render_attribute_string('address')); ?>><?php echo esc_html($settings['address']); ?></span>
			</a>
		<?php } 
		// Time
		if(!empty($settings['time'])){
		?>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'time-item' ) ); ?>>
			<span <?php etc_print_html($widget->get_render_attribute_string('time-icon')); ?>><?php medcity_svgs_icon_render(['icon' => 'clock', 'echo' => true]); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('time_title')); ?>><?php echo esc_html($settings['time_title']); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('time')); ?>><?php echo esc_html($settings['time']); ?></span>
		</div>
		<?php } ?></div>
		<?php
		medcity_elementor_link_button_render($widget, $settings, [
			'name'                 => 'btn', 
			'type'                 => 'button', 
			'class'                => 'mt-25 cms-btn-lg cms-btn-2xlg',
			'btn_text_color'       => 'white',
			'btn_text_hover_color' => 'secondary',
			'btn_prefix'           => 'cms-btn-outline-',
			'btn_color'						 => 'white',
			'btn_hover_color'			 => 'white' 
		]);
		?>
	</div>
</div>