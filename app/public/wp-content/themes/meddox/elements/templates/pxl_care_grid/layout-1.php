<?php
$col_xs = $widget->get_setting('col_xs', '');
$col_sm = $widget->get_setting('col_sm', '');
$col_md = $widget->get_setting('col_md', '');
$col_lg = $widget->get_setting('col_lg', '');
$col_xl = $widget->get_setting('col_xl', '');

$col_xl = 12 / intval($col_xl);
$col_lg = 12 / intval($col_lg);
$col_md = 12 / intval($col_md);
$col_sm = 12 / intval($col_sm);
$col_xs = 12 / intval($col_xs);

$grid_sizer = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
$item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";

if ( ! empty( $settings['btn_link']['url'] ) ) {
    $widget->add_render_attribute( 'button', 'href', $settings['btn_link']['url'] );

    if ( $settings['btn_link']['is_external'] ) {
        $widget->add_render_attribute( 'button', 'target', '_blank' );
    }

    if ( $settings['btn_link']['nofollow'] ) {
        $widget->add_render_attribute( 'button', 'rel', 'nofollow' );
    }
} ?>
<?php if(isset($settings['care']) && !empty($settings['care']) && count($settings['care'])): ?>
<div class="pxl-grid pxl-care-grid pxl-care-grid1">
    <div class="pxl-grid-inner pxl-grid-masonry row" data-gutter="15">

        <?php foreach ($settings['care'] as $key => $value):
         $title = isset($value['title']) ? $value['title'] : '';
         $time = isset($value['time']) ? $value['time'] : '';
         $position = isset($value['position']) ? $value['position'] : '';
         $description = isset($value['description']) ? $value['description'] : '';
         $btn_text = isset($value['btn_text']) ? $value['btn_text'] : '';
         ?>
         <div class="<?php echo esc_attr($item_class); ?>">
            <div class="pxl-item--inner <?php echo esc_attr($settings['pxl_animate']); ?>">
                <h3 class="pxl-item--title">    
                    <?php echo pxl_print_html($title); ?>
                </h3>
                <ul class="">
                    <li class="pxl-item--time"><?php echo pxl_print_html($time); ?>  </li>
                    <li class="pxl-item--position"><?php echo pxl_print_html($position); ?>  </li>
                </ul>
                <div class="pxl-item--description"><?php echo pxl_print_html($description); ?> </div>


            <?php if ( ! empty( $settings['btn_link']['url'] ) ) {
                $widget->add_render_attribute( 'btn_link', 'href', $settings['btn_link']['url'] );

                if ( $settings['btn_link']['is_external'] ) {
                    $widget->add_render_attribute( 'btn_link', 'target', '_blank' );
                }

                if ( $settings['btn_link']['nofollow'] ) {
                    $widget->add_render_attribute( 'btn_link', 'rel', 'nofollow' );
                } ?>
                <div class="pxl-item--link"><a <?php pxl_print_html($widget->get_render_attribute_string( 'btn_link' )); ?>>
                    <?php if ( !empty($settings['pxl_btn_icon']['value']) ) : ?>
                        <span class="pxl-item-btn-icon">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_btn_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                        </span>
                    <?php endif; ?>
                    <?php pxl_print_html($settings['btn_text']); ?> 
                </a></div>
            <?php } ?>




        </div>
    </div>
<?php endforeach; ?>
<div class="grid-sizer <?php echo esc_attr($grid_sizer); ?>"></div>
</div>
</div>
<?php endif; ?>
