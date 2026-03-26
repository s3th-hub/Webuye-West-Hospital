<?php
$widget->add_render_attribute( 'selected_icon', 'class' );
$has_icon = ! empty( $settings['selected_icon'] );

if ( ! empty( $settings['link']['url'] ) ) {
    $widget->add_render_attribute( 'link', 'href', $settings['link']['url'] );

    if ( $settings['link']['is_external'] ) {
        $widget->add_render_attribute( 'link', 'target', '_blank' );
    }

    if ( $settings['link']['nofollow'] ) {
        $widget->add_render_attribute( 'link', 'rel', 'nofollow' );
    }
}

if ( $has_icon ) {
    $widget->add_render_attribute( 'i', 'class', $settings['selected_icon'] );
    $widget->add_render_attribute( 'i', 'aria-hidden', 'true' );
}

$icon_attributes = $widget->get_render_attribute_string( 'selected_icon' );
$link_attributes = $widget->get_render_attribute_string( 'link' );

$widget->add_render_attribute( 'description_text', 'class', 'item-description' );

$widget->add_inline_editing_attributes( 'title_text', 'none' );
$widget->add_inline_editing_attributes( 'description_text' );

$is_new = \Elementor\Icons_Manager::is_migration_allowed();
$overlay_class = $wrap_class = "";
if ( empty($settings['selected_image']['url'])){
    $overlay_class = "overlay-icon";
    $wrap_class .= " cms-hover-anim";
}
?>
<div class="cms-fancy-box layout3<?php echo esc_attr($wrap_class);?>">
    <div class="content-inner <?php echo esc_attr($overlay_class);?>">
        <?php if ( $has_icon ) : ?>
            <div class="item-icon cms-hover-anim--icon cms-transition">
                <?php
                if($is_new):
                    \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                    ?>
                <?php else: ?>
                    <i <?php etc_print_html($widget->get_render_attribute_string( 'i' )); ?>></i>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
        if ( !empty($settings['selected_image']['url'])){
            ?>
            <div class="item-image bg-image" style="background-image: url(<?php echo esc_url($settings['selected_image']['url']); ?>);"></div>
            <?php
        }else{
            ?>
            <div class="item-icon-overlay">
                <?php
                if($is_new):
                    \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                    ?>
                <?php else: ?>
                    <i <?php etc_print_html($widget->get_render_attribute_string( 'i' )); ?>></i>
                <?php endif; ?>
            </div>
            <?php
        }
        ?>
        <div class="item-content">
            <h3 class="item-title">
                <?php echo etc_print_html($settings['title_text']); ?>
            </h3>
            <?php if ( !empty($settings['description_text']) ) : ?>
                <div <?php etc_print_html($widget->get_render_attribute_string( 'description_text' )); ?>>
                    <?php echo esc_html($settings['description_text']); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="item-button">
        <a <?php echo implode( ' ', [ $link_attributes ] ); ?>>
            <span class="f-btn-icon"><i class="fac fac-arrow-right"></i></span>
            <?php if(!empty($settings['button_text'])) : ?>
                <span class="f-btn-text"></span>
            <?php endif; ?>
        </a>
    </div>
</div>