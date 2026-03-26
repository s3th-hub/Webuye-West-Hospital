<?php 
if ( ! empty( $settings['image_link']['url'] ) ) {
    $widget->add_render_attribute( 'image_link', 'href', $settings['image_link']['url'] );

    if ( $settings['image_link']['is_external'] ) {
        $widget->add_render_attribute( 'image_link', 'target', '_blank' );
    }

    if ( $settings['image_link']['nofollow'] ) {
        $widget->add_render_attribute( 'image_link', 'rel', 'nofollow' );
    }
} ?>
<div class="pxl-image-single <?php echo esc_attr($settings['style']); ?> <?php if(!empty($settings['img_effect'])) { echo esc_attr($settings['img_effect']); } ?> <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms" data-maxtilt="<?php echo esc_attr($settings['max_tilt']); ?>" data-speedtilt="<?php echo esc_attr($settings['speed_tilt']); ?>">
    <?php if(!empty(!empty($settings['image']['id']))) : ?>
        <?php if ($settings['image_type'] == 'img') { 
            $image_size = !empty($settings['img_size']) ? $settings['img_size'] : 'full';
            $img  = pxl_get_image_by_size( array(
                'attach_id'  => $settings['image']['id'],
                'thumb_size' => $image_size,
                'class' => 'no-lazyload'
            ) );
            $thumbnail    = $img['thumbnail'];
            ?>
            <div class="pxl-item--inner">
                <?php if ( ! empty( $settings['image_link']['url'] ) ) { ?><a <?php ct_print_html($widget->get_render_attribute_string( 'image_link' )); ?>><?php } ?>
                <?php if ( ! empty( $settings['image']['url'] ) ) { echo wp_kses_post($thumbnail); } ?>
                <?php if ( ! empty( $settings['image_link']['url'] ) ) { ?></a><?php } ?>
            </div>
        <?php } else { ?>
            <div class="pxl-image-bg bg-image <?php echo esc_attr($settings['style_bgr']); ?> <?php if($settings['style_bgr'] == 'style-bgr-1'|| $settings['style_bgr'] == 'style-bgr-2'){echo "elementor-widget-particle";} ?> " <?php if($settings['style_bgr'] == 'style-bgr-1'|| $settings['style_bgr'] == 'style-bgr-default') : ?> style="background-image: url(<?php echo esc_url($settings['image']['url']); ?>);" <?php endif; ?>>
                <div class="pxl-bgr-overlay"></div>
                <?php  if($settings['style_bgr'] == 'style-bgr-2') : ?>
                    <div class="bg-section-2">
                        <div class="bg-section-2-left"></div>
                        <div class="bg-section-2-right" style="background-image: url(<?php echo esc_url($settings['image']['url']); ?>);">
                            <div class="pxl-overlay"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php } ?>
    <?php endif; ?>
</div>