<div class="pxl-icon-box pxl-icon-box8 <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <div class="pxl-item--inner">
       <?php {
        $widget->add_render_attribute( 'link_1', 'href', $settings['link_1']['url'] );

        if ( $settings['link_1']['is_external'] ) {
            $widget->add_render_attribute( 'link_1', 'target', '_blank' );
        }

        if ( $settings['link_1']['nofollow'] ) {
            $widget->add_render_attribute( 'link_1', 'rel', 'nofollow' );
        } ?>
        <a <?php pxl_print_html($widget->get_render_attribute_string( 'link_1' )); ?>> </a>
        <?php if ( $settings['icon_type'] == 'icon' && !empty($settings['pxl_icon']['value']) ) : ?>
            <div class="pxl-item--icon">
                <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
            </div>
        <?php endif; ?>
        <?php if ( $settings['icon_type'] == 'image' && !empty($settings['icon_image']['id']) ) : ?>
            <div class="pxl-item--icon">
                <?php $img_icon  = pxl_get_image_by_size( array(
                    'attach_id'  => $settings['icon_image']['id'],
                    'thumb_size' => 'full',
                ) );
                $thumbnail_icon    = $img_icon['thumbnail'];
                echo pxl_print_html($thumbnail_icon); ?>
            </div>
        <?php endif; ?>
        

        <?php 
        if(!empty($settings['link_1'])) { ?>
            <div class="pxl-item--link1">
                <a <?php pxl_print_html($widget->get_render_attribute_string( 'link_1' )); ?>>
                    <?php pxl_print_html($settings['item_link_1']); ?> 
                </a>
            </div>
        <?php } else { ?>
            <div class="pxl-item--link1">
                <?php pxl_print_html($settings['item_link_1']); ?> 
            </div>
        <?php } ?>
    <?php } ?>
</div>
</div>