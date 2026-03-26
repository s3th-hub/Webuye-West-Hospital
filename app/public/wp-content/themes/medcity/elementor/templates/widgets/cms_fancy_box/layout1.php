<?php
$widget->add_render_attribute( 'selected_icon', 'class' );
$has_icon = ! empty( $settings['selected_icon'] );
$hover_animation = $widget->get_setting('hover_animation', '');

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
// Add Attributes
$widget->add_render_attribute( 'item_icon', 'class', [ 'item-icon', 'elementor-animation-' . $settings['hover_animation'] ] );
$widget->add_inline_editing_attributes( 'title_text', 'none' );
$widget->add_render_attribute( 'description_text', 'class', 'item-description' );
$widget->add_inline_editing_attributes( 'description_text' );
$link_attributes = $widget->get_render_attribute_string( 'link' );

$is_new = \Elementor\Icons_Manager::is_migration_allowed();
?>
<div class="cms-fancy-box layout1">
    <?php if ( $has_icon ) : ?>
        <div <?php etc_print_html($widget->get_render_attribute_string( 'item_icon' )); ?>>
            <?php
            if($is_new):
                \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                ?>
            <?php else: ?>
                <i <?php etc_print_html($widget->get_render_attribute_string( 'i' )); ?>></i>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="item-content">
        <h3 class="item-title">
            <?php echo etc_print_html($settings['title_text']); ?>
        </h3>
        <?php
        if (!empty($settings['description_text'])){
            ?>
            <div <?php etc_print_html($widget->get_render_attribute_string( 'description_text' )); ?>>
                <?php echo esc_html($settings['description_text']); ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>