<?php
$widget->add_render_attribute( 'wrapper', 'class', 'cms-button-readmore' );

if ( ! empty( $settings['link']['url'] ) ) {
    $widget->add_render_attribute( 'button', 'href', $settings['link']['url'] );

    if ( $settings['link']['is_external'] ) {
        $widget->add_render_attribute( 'button', 'target', '_blank' );
    }

    if ( $settings['link']['nofollow'] ) {
        $widget->add_render_attribute( 'button', 'rel', 'nofollow' );
    }
}

$widget->add_render_attribute( 'button', 'class', 'btn-read-more '.$settings['style'] );

if ( ! empty( $settings['button_css_id'] ) ) {
    $widget->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
}

$is_new = \Elementor\Icons_Manager::is_migration_allowed();

?>
<div <?php etc_print_html($widget->get_render_attribute_string( 'wrapper' )); ?>>
    <a <?php etc_print_html($widget->get_render_attribute_string( 'button' )); ?>>
        <?php
        switch ($settings['style']){
            case 'more-invert':
                ?>
                <span <?php etc_print_html($widget->get_render_attribute_string( 'text' )); ?>>
                    <i class="fac fac-arrow-right"></i>
                    <?php echo esc_html($settings['text']); ?>
                </span>
                <?php
                break;
            default:
                ?>
                <span <?php etc_print_html($widget->get_render_attribute_string( 'text' )); ?>>
                    <?php echo esc_html($settings['text']); ?>
                    <i class="fac fac-arrow-right"></i>
                </span>
                <?php
                break;
        }
        ?>
    </a>
</div>