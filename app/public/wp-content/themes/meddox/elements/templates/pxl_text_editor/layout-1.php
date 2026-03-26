<?php
$editor_content = $widget->get_settings_for_display( 'text_ed' );
$editor_content = $widget->parse_text_editor( $editor_content );
?>
<div class="pxl-text-editor">
	<div class="pxl-item--inner <?php echo esc_attr($settings['pxl_animate'].' '.$settings['text_custom_font_family']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
		<?php echo wp_kses_post($editor_content); ?>
	</div>
</div>