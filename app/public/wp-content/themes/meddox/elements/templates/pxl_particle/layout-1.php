<?php $html_id = pxl_get_element_id($settings); ?>
<?php if(isset($settings['images']) && !empty($settings['images']) && count($settings['images'])): ?>
	<div class="pxl-particle pxl-particle1 <?php echo esc_attr($settings['image_visible']); ?>">
		<?php foreach ($settings['images'] as $key => $value): 
			$particle  = pxl_get_image_by_size( array(
                'attach_id'  => $value['particle']['id'],
                'thumb_size' => 'full',
                'class'      => $value['pxl_animate']
            ) );
            $particle_thumbnail    = $particle['thumbnail']; ?>
		    <div id="<?php echo esc_attr($html_id.$key); ?>" class="pxl-item--particle elementor-repeater-item-<?php echo esc_attr($value['_id']); ?> <?php echo esc_attr($value['type_position'].' '.$value['particle_effect']); ?>" <?php if($value['particle_effect'] == 'move-parallax') { ?>data-speed="<?php echo esc_attr($value['parallax_speed']); ?>" data-move="<?php echo esc_attr($value['parallax_move']); ?>"<?php } ?>>
		    	<?php echo wp_kses_post($particle_thumbnail); ?>		
		    </div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
