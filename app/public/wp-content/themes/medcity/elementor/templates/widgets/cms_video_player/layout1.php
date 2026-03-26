<?php
$image_html = "";
if ( ! empty( $settings['image']['url'] ) ) {
    $widget->add_render_attribute( 'image', 'src', $settings['image']['url'] );
    $widget->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );
    $widget->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['image'] ) );
    $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
}
?>
<div class="cms-video-player layout1 <?php echo esc_attr($settings['video_style']);?>">
    <?php if ( ! empty( $settings['image']['url'] ) ) { echo wp_kses_post($image_html); } ?>
    <?php if(!empty($settings['video_link'])) : ?>
        <a class="cms-video-button <?php echo esc_attr($settings['video_size']); ?>" href="<?php echo esc_url($settings['video_link']); ?>">
            <i class="fac fac-play"></i>
            <?php
            if (!empty($settings['description'])){
                ?><span class="video-text"><?php echo wp_kses_post($settings['description']) ;?></span><?php
            }
            ?>
        </a>
    <?php endif; ?>
</div>