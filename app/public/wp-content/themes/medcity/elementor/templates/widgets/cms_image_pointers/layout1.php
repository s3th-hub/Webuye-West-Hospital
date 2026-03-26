<?php
$default_settings = [
    'box_style' => 'style1',
    'content_list' => '',
    'thumbnail_size' => '',
    'thumbnail_custom_dimension' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings);
$html_id = etc_get_element_id($settings);

if ( ! empty( $settings['image_bg']['url'] ) ) {
    $widget->add_render_attribute( 'image_bg', 'src', $settings['image_bg']['url'] );
    $widget->add_render_attribute( 'image_bg', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image_bg'] ) );
    $widget->add_render_attribute( 'image_bg', 'title', \Elementor\Control_Media::get_image_title( $settings['image_bg'] ) );
}

$image_html_bg = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image_bg' );

if($thumbnail_size != 'custom'){
    $img_size = $thumbnail_size;
}
elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
    $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
}
else{
    $img_size = 'full';
}

?>
<div class="cms-image-pointers <?php echo esc_attr($settings['box_style']);?>">
    <div class="inner-content">
        <?php if ( $image_html_bg ) : ?>
            <div class="img-bg">
                <?php echo wp_kses_post($image_html_bg); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($content_list) && !empty($content_list) && count($content_list)): ?>
            <div class="cms-imagepointers-list">
                <?php foreach ($content_list as $key => $value):
                    $content = isset($value['content']) ? $value['content'] : '';
                    $content_hover = isset($value['content_hover']) ? $value['content_hover'] : '';
                    ?>
                    <div id="<?php echo esc_attr( $value['_id'] ); ?>" class="item-pointer <?php echo esc_attr( $content_hover ); ?> elementor-repeater-item-<?php echo esc_attr( $value['_id'] ); ?>">
                        <div class="item-inner">
                            <span class="plus-icon">+</span>
                            <?php if(!empty($content)) { ?>
                                <div class="item-holder">
                                    <div class="inner-holder">
                                        <div class="item--excerpt">
                                            <?php echo esc_attr($content); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                       </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>