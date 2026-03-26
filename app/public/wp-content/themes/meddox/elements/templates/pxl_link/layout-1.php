<?php
if(isset($settings['link']) && !empty($settings['link']) && count($settings['link'])): ?>
    <ul class="pxl-link pxl-link-l1 <?php echo esc_attr($settings['style_list']) ?> <?php echo esc_attr($settings['pxl_animate'].' '.$settings['style'].' '.$settings['link_custom_font_family']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
        <?php
            foreach ($settings['link'] as $key => $link):
                $icon_key = $widget->get_repeater_setting_key( 'pxl_icon', 'icons', $key );
                $item_cls = [ 'elementor-repeater-item-'.$link['_id'] ];
                $widget->add_render_attribute( $icon_key, [
                    'class' => $link['pxl_icon'],
                    'aria-hidden' => 'true',
                ] );
                $link_key = $widget->get_repeater_setting_key( 'link', 'value', $key );
                if ( ! empty( $link['link']['url'] ) ) {
                    $widget->add_render_attribute( $link_key, 'href', $link['link']['url'] );

                    if ( $link['link']['is_external'] ) {
                        $widget->add_render_attribute( $link_key, 'target', '_blank' );
                    }

                    if ( $link['link']['nofollow'] ) {
                        $widget->add_render_attribute( $link_key, 'rel', 'nofollow' );
                    }
                }
                $link_attributes = $widget->get_render_attribute_string( $link_key );
                ?>
                <li class="<?php echo implode(' ', $item_cls) ?>" >
                    <a id="pxl-not-rtl"<?php echo implode( ' ', [ $link_attributes ] ); ?> >
                        <?php if(!empty($link['pxl_icon'])){
                            \Elementor\Icons_Manager::render_icon( $link['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' );
                        } ?>
                        <span><?php echo pxl_print_html($link['text']); ?></span>
                    </a>
                </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
