<?php
$editor_content = $widget->get_settings_for_display( 'text' );
$editor_content = $widget->parse_text_editor( $editor_content );
?>
<div class="pxl-quote">
	<span class="content-quote"><?php echo esc_attr($settings['text']); ?></span>
	<span class="content-author"><?php echo esc_attr($settings['author']); ?></span>
</div>