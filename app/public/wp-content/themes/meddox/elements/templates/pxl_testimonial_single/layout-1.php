<div class="pxl-testimonial-single pxl-testimonial-single1 <?php echo esc_attr($settings['style'].' '.$settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <div class="pxl-item--inner">

        <div class="pxl-item--description"><?php echo pxl_print_html($settings['desc']); ?>
        
        <div class="pxl-item--icon">
            <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
        </div>
    </div>
    <div class="pxl-item--holder">


        <h4 class="pxl-item--title"><?php echo pxl_print_html($settings['title']); ?></h4>
        <div class="pxl-item--position"><?php echo pxl_print_html($settings['position']); ?></div>
    </div>
</div>
</div>