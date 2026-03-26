<?php
$widget->add_render_attribute( 'wrapper', 'class', 'pxl-button' );
if($settings['btn_style'] != 'btn2-primary'){
    $widget->add_render_attribute( 'button', 'class', 'btn '.$settings['btn_custom_font_family'].' '.$settings['btn_hover_effect'].' '.$settings['btn_style'].' '.$settings['pxl_animate'].' pxl-icon--'.$settings['icon_align'].'' );
}
else{
    $widget->add_render_attribute( 'button', 'class', 'btn2 '.$settings['btn_custom_font_family'].' '.$settings['btn_hover_effect'].' '.$settings['btn_style'].' '.$settings['pxl_animate'].' pxl-icon--'.$settings['icon_align'].'' );
}

if ( ! empty( $settings['link']['url'] ) ) {
    $widget->add_render_attribute( 'button', 'href', $settings['link']['url'] );

    if ( $settings['link']['is_external'] ) {
        $widget->add_render_attribute( 'button', 'target', '_blank' );
    }

    if ( $settings['link']['nofollow'] ) {
        $widget->add_render_attribute( 'button', 'rel', 'nofollow' );
    }
} ?>
<div <?php pxl_print_html($widget->get_render_attribute_string( 'wrapper' )); ?>>
    <a <?php pxl_print_html($widget->get_render_attribute_string( 'button' )); ?> data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
        <?php if(!empty($settings['btn_icon'])) {
            \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' );
        } ?>
        <span class="pxl--btn-text" data-text="<?php echo esc_attr($settings['text']); ?>">
            <?php 
            if($settings['btn_hover_effect'] == 'btn-nina') {
                $chars = str_split($settings['text']);
                foreach ($chars as $value) {
                    if($value == ' ') {
                        echo '<span class="spacer">&nbsp;</span>';
                    } else {
                        echo '<span>'.$value.'</span>';
                    }
                }
            } else {
                echo pxl_print_html($settings['text']);
            }
            ?>
        </span>
    </a>
</div>