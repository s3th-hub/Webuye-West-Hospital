<?php
if ( ! empty( $settings['button_link']['url'] ) ) {
    $widget->add_render_attribute( 'button', 'href', $settings['button_link']['url'] );

    if ( $settings['button_link']['is_external'] ) {
        $widget->add_render_attribute( 'button', 'target', '_blank' );
    }

    if ( $settings['button_link']['nofollow'] ) {
        $widget->add_render_attribute( 'button', 'rel', 'nofollow' );
    }
}
?>
<div class="pxl-pricing pxl-pricing1 <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <?php if(!empty($settings['style_star'])) : ?>
        <div class="item--star <?php echo esc_attr( $style_star ); ?>">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
    <?php endif; ?>
    <h4 class="pxl-item--title"><span><?php echo esc_attr($settings['title']); ?></span></h4>
    <div class="pxl-item--subtitle"><?php echo esc_attr($settings['sub_title']); ?></div>
    <div class="pxl-item--price"><?php echo pxl_print_html($settings['price']); ?></div>
    <?php if(isset($settings['feature']) && !empty($settings['feature']) && count($settings['feature'])): ?>
    <ul class="pxl-item--feature">
        <?php foreach ($settings['feature'] as $key => $value): ?>
            <li class="<?php echo esc_attr($value['active']); ?>"><i class="caseicon-check"></i><?php echo pxl_print_html($value['feature_text'])?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
    
    <?php if(!empty($settings['button_text'])) : ?>
        <div class="pxl-item--readmore">
            <a class="btn-readmore pxl-btn-effect7" <?php pxl_print_html($widget->get_render_attribute_string( 'button' )); ?>><?php echo esc_attr($settings['button_text']); ?><i class="far fa-long-arrow-right"></i></a>
        </div>
    <?php endif; ?>
</div>