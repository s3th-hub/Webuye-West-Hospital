<div class="wrap-info-postype info-postype">
    <?php
    if(isset($settings['info']) && !empty($settings['info']) && count($settings['info'])): ?>
        <div class="wrap-title">
            <?php if(!empty($settings['icon_heading'])) {
                \Elementor\Icons_Manager::render_icon( $settings['icon_heading'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' );
            } ?>
            <div class="title">
                <span><?php echo pxl_print_html($settings['heading']); ?></span>
            </div>
        </div>
        <ul class="pxl-info pxl-info-l1 <?php echo esc_attr($settings['style_list']) ?> <?php echo esc_attr($settings['pxl_animate'].' '.$settings['hover_style'].' '.$settings['info_custom_font_family']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">

            <?php
            foreach ($settings['info'] as $key => $info):
                $icon_key = $widget->get_repeater_setting_key( 'pxl_icon', 'icons', $key );
                $item_cls = [ 'elementor-repeater-item-'.$info['_id'] ];
                $widget->add_render_attribute( $icon_key, [
                    'class' => $info['pxl_icon'],
                    'aria-hidden' => 'true',
                ] );
                $info_key = $widget->get_repeater_setting_key( 'info', 'value', $key );
                if ( ! empty( $info['info']['url'] ) ) {
                    $widget->add_render_attribute( $info_key, 'href', $info['info']['url'] );

                    if ( $info['info']['is_external'] ) {
                        $widget->add_render_attribute( $info_key, 'target', '_blank' );
                    }

                    if ( $info['info']['nofollow'] ) {
                        $widget->add_render_attribute( $info_key, 'rel', 'nofollow' );
                    }
                }
                $info_attributes = $widget->get_render_attribute_string( $info_key );
                ?>
                <li class="<?php echo implode(' ', $item_cls) ?>">

                    <span class="wrap-title-icon">
                        <?php if(!empty($info['pxl_icon'])){
                            \Elementor\Icons_Manager::render_icon( $info['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' );
                        } ?>
                        <span><?php echo pxl_print_html($info['text']); ?></span>
                    </span>
                    <span class="info-desc"><?php echo pxl_print_html($info['info_desc']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if ( ! empty( $settings['btn_link']['url'] ) ) {
        $widget->add_render_attribute( 'btn_link', 'href', $settings['btn_link']['url'] );

        if ( $settings['btn_link']['is_external'] ) {
            $widget->add_render_attribute( 'btn_link', 'target', '_blank' );
        }
        if ( $settings['btn_link']['nofollow'] ) {
            $widget->add_render_attribute( 'btn_link', 'rel', 'nofollow' );
        }
    } ?>
    <?php if(!empty($settings['btn_text'])) : ?>
        <div class="pxl-item--button"><a class="btn-readmore pxl-btn-effect4" <?php pxl_print_html($widget->get_render_attribute_string( 'btn_link' )); ?>><span><?php echo esc_attr($settings['btn_text']); ?></span><i class="caseicon-long-arrow-right-two"></i></a></div>
    <?php endif; ?>

</div>