<?php
$is_new = \Elementor\Icons_Manager::is_migration_allowed();
if(isset($settings['icons']) && !empty($settings['icons']) && count($settings['icons'])): ?>
    <div class="pxl-icon1 <?php echo esc_attr($settings['hv_style'].' '.$settings['style'].' '.$settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
        <?php foreach ($settings['icons'] as $key => $value):
            $icon_type = isset($value['icon_type']) ? $value['icon_type'] : '';
            $icon_image = isset($value['icon_image']) ? $value['icon_image'] : '';
            $icon_key = $widget->get_repeater_setting_key( 'pxl_icon', 'icons', $key );
            $widget->add_render_attribute( $icon_key, [
                'class' => $value['pxl_icon'],
                'aria-hidden' => 'true',
            ] );
            $link_key = $widget->get_repeater_setting_key( 'icon_link', 'value', $key );
            if ( ! empty( $value['icon_link']['url'] ) ) {
                $widget->add_render_attribute( $link_key, 'href', $value['icon_link']['url'] );

                if ( $value['icon_link']['is_external'] ) {
                    $widget->add_render_attribute( $link_key, 'target', '_blank' );
                }

                if ( $value['icon_link']['nofollow'] ) {
                    $widget->add_render_attribute( $link_key, 'rel', 'nofollow' );
                }
            }
            $link_attributes = $widget->get_render_attribute_string( $link_key ); ?>
            <?php if ( $icon_type == 'icon' && ! empty( $value['pxl_icon'] ) ) : ?>
                <a class="elementor-repeater-item-<?php echo esc_attr($value['_id']); ?>" <?php echo implode( ' ', [ $link_attributes ] ); ?>>
                    <?php if ( $is_new ):
                        \Elementor\Icons_Manager::render_icon( $value['pxl_icon'], [ 'aria-hidden' => 'true' ] );
                    elseif(!empty($value['pxl_icon'])): ?>
                        <i class="<?php echo esc_attr( $value['pxl_icon'] ); ?>" aria-hidden="true"></i>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <?php if ( $icon_type == 'image' && !empty($icon_image['id']) ) : 
                $img_icon  = pxl_get_image_by_size( array(
                    'attach_id'  => $icon_image['id'],
                    'thumb_size' => 'full',
                ) );
                $thumbnail_icon    = $img_icon['thumbnail']; ?>
                <a <?php echo implode( ' ', [ $link_attributes ] ); ?>>
                    <?php echo pxl_print_html($thumbnail_icon); ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>