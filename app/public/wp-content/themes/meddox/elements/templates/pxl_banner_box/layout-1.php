<div class="pxl-banner pxl-banner1 <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
	<div class="pxl-banner-inner">
		<?php if(!empty($settings['banner_image']['id'])) : 
			$img = pxl_get_image_by_size( array(
				'attach_id'  => $settings['banner_image']['id'],
				'thumb_size' => 'full',
			));
			$thumbnail = $img['thumbnail'];
			?>
			<div class="pxl-item--meta">
			<?php if(!empty($settings['banner_title'])) : ?>
				<div class="pxl-item--title pxl--circle-type">
					<?php echo pxl_print_html($settings['banner_title']); ?>
				</div>
			<?php endif; ?>
		</div>
			<div class="pxl-item--image">
				<?php echo pxl_print_html($thumbnail); ?>
			</div>
		<?php endif; ?>
		
	</div>
</div>