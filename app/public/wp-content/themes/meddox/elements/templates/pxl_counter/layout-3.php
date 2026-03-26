<?php
$widget->add_render_attribute( 'counter', [
    'class' => 'pxl--counter-value',
    'data-duration' => $settings['duration'],
    'data-to-value' => $settings['ending_number'],
    'data-delimiter' => $settings['thousand_separator_char'],
] ); ?>
<div class="pxl-counter pxl-counter3 <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms" >
    <div class="pxl--item-inner">
        <?php if ( !empty($settings['bgr_image']['id']) ) : ?>
            <div class="background-image-counter">
                <?php $bgr_image  = pxl_get_image_by_size( array(
                    'attach_id'  => $settings['bgr_image']['id'],
                    'thumb_size' => 'full',
                ) );
                $thumbnail_icon    = $bgr_image['thumbnail'];
                echo pxl_print_html($thumbnail_icon); ?>
            </div>
        <?php endif; ?>
        <div class="pxl-item-holder">
            <div class="pxl-wrap-icon">
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
            </div>
           <div class="pxl-wrap-content">
                <div class="pxl--counter-number">
                    <?php if(!empty($settings['prefix'])) : ?>
                        <span class="pxl--counter-prefix"><?php echo pxl_print_html($settings['prefix']); ?></span>
                    <?php endif; ?>
                    <span <?php pxl_print_html($widget->get_render_attribute_string( 'counter' )); ?>><?php echo esc_html($settings['starting_number']); ?></span>
                    <?php if(!empty($settings['suffix'])) : ?>
                        <span class="pxl--counter-suffix"><?php echo pxl_print_html($settings['suffix']); ?></span>
                    <?php endif; ?>
                </div>
                <div class="pxl--item-title"><?php echo pxl_print_html($settings['title']); ?></div>
            </div>
        </div>
    </div>
</div>