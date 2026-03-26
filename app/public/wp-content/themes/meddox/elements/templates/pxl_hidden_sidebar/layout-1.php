<?php 
$template = (int)$widget->get_setting('template','0');
if($template > 0 ){
	 
	if ( !has_action( 'pxl_anchor_target_hidden_panel_'.$template) ){
		add_action( 'pxl_anchor_target_hidden_panel_'.$template, 'meddox_hook_anchor_hidden_panel' );
	} 
	
}else{
	return;
}
?>
<div class="pxl-hidden-button <?php echo esc_attr($settings['style']); ?>">
	<?php if(!empty($settings['pxl_icon']['value'])) {
            \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' );
    } else { ?>
    	<i class="flaticon-bars"></i>
    <?php } ?>
</div>
