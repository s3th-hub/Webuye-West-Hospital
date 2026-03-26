<?php

if(isset($settings['progressbar_list']) && !empty($settings['progressbar_list'])):
    foreach ($settings['progressbar_list'] as $key => $progressbar):
        $wrapper_key = $widget->get_repeater_setting_key( 'wrapper', 'progressbar_list', $key );
        $progress_bar_key = $widget->get_repeater_setting_key( 'progress_bar', 'progressbar_list', $key );
        $widget->add_render_attribute( $wrapper_key, [
            'class' => 'elementor-progress-wrapper',
            'role' => 'progressbar',
            'aria-valuemin' => '0',
            'aria-valuemax' => '100',
            'aria-valuenow' => $progressbar['percent']['size'],
        ] );

        if ( ! empty( $progressbar['progress_type'] ) ) {
            $widget->add_render_attribute( $wrapper_key, 'class', 'progress-' . $progressbar['progress_type'] );
        }

        $widget->add_render_attribute( $progress_bar_key, [
            'class' => 'elementor-progress-bar',
            'data-max' => $progressbar['percent']['size'],
        ] );

        if ( ! empty( $progressbar['title'] ) ) { ?>
            <div class="cms-progress-wrapper">
                <h5 class="elementor-title"><?php echo esc_html($progressbar['title']); ?></h5>
        <?php } ?>
        
        <div <?php etc_print_html($widget->get_render_attribute_string( $wrapper_key )); ?>>
            <div <?php etc_print_html($widget->get_render_attribute_string( $progress_bar_key )); ?>>
                <span class="elementor-progress-percentage"><?php echo esc_html($progressbar['percent']['size']); ?>%</span>
            </div>
        </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>