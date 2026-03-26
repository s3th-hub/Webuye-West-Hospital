<?php
if(isset($settings['content']) && !empty($settings['content']) && count($settings['content'])): ?>
    <div class="pxl-opening-hours pxl-opening-hours-l2">
        <div class="pxl-icon">
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
        <div class="pxl-title">
            <?php echo pxl_print_html($settings['title']); ?>
        </div>
        <ul class="pxl-wrap-time">
            <?php foreach ($settings['content'] as $key => $content) : ?>
                <li>                        
                    <span><?php echo pxl_print_html($content['day_of_week']); ?></span>
                    <span class="wrap-time">
                        <span><?php echo pxl_print_html($content['opening']); ?> - </span>
                        <span> <?php echo pxl_print_html($content['closing']); ?></span>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
