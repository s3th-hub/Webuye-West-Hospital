<div class="pxl-image-box pxl-image-box1 <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <div class="pxl-item--inner">
        <?php if (!empty($settings['pxl_icon']['value']) ) : ?>
            <div class="wrap-icon-box">
                <div class="pxl-item--icon">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                </div>
                <p class="pxl-item-feature">
                   <?php echo pxl_print_html($settings['feature']); ?>
               </p>
           </div>

       <?php endif; ?>

       <div class="pxl-item-image-1">
        <?php 
        $img_icon1  = pxl_get_image_by_size( array(
            'attach_id'  => $settings['icon_image_1']['id'],
            'thumb_size' => 'full',
        ) );
        $thumbnail_icon1    = $img_icon1['thumbnail'];
        echo pxl_print_html($thumbnail_icon1); ?>
    </div>
    <div class="pxl-item-image-2">
        <?php 
        $img_icon2  = pxl_get_image_by_size( array(
            'attach_id'  => $settings['icon_image_2']['id'],
            'thumb_size' => 'full',
        ) );
        $thumbnail_icon2    = $img_icon2['thumbnail'];
        echo pxl_print_html($thumbnail_icon2); ?>
    </div>
    <div class="pxl-item-image-3">
        <?php 
        $img_icon3  = pxl_get_image_by_size( array(
            'attach_id'  => $settings['icon_image_3']['id'],
            'thumb_size' => 'full',
        ) );
        $thumbnail_icon3   = $img_icon3['thumbnail'];
        echo pxl_print_html($thumbnail_icon3); ?>
    </div>
</div>
</div>