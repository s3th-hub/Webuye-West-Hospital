<div class="gallery-image">
    <div class="wrap-title">
        <?php if(!empty($settings['icon_heading'])) {
            \Elementor\Icons_Manager::render_icon( $settings['icon_heading'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' );
        } ?>
        <div class="title">
            <span><?php echo pxl_print_html($settings['heading']); ?></span>
        </div>
    </div>
    <?php 
    $images_size = !empty($settings['img_size']) ? $settings['img_size'] : '300x300'; 
    if ( ! empty( $settings['ins_link']['url'] ) ) {
        $widget->add_render_attribute( 'link', 'href', $settings['ins_link']['url'] );

        if ( $settings['ins_link']['is_external'] ) {
            $widget->add_render_attribute( 'link', 'target', '_blank' );
        }

        if ( $settings['ins_link']['nofollow'] ) {
            $widget->add_render_attribute( 'link', 'rel', 'nofollow' );
        }
    }
    ?>
    <?php if(isset($settings['images']) && !empty($settings['images']) && count($settings['images'])): ?>
    <div class="pxl-instagram pxl-gallery row">
        <?php foreach ($settings['images'] as $key => $value): 
            $img = pxl_get_image_by_size( array(
                'attach_id'  => $value['id'],
                'thumb_size' => $images_size,
            ));
            $thumbnail = $img['thumbnail']; ?>
            <div class="pxl--item pxl-item-image grid-item col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 <?php if($settings['item_active'] == $key + 1) { echo 'active'; } ?>">
                <div class="wrap-light-box">
                    <a class="light-box"  href="<?php echo wp_get_attachment_image_url( $value['id'], $size = 'full') ?>" ></a>
                <?php echo wp_kses_post($thumbnail); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</div>