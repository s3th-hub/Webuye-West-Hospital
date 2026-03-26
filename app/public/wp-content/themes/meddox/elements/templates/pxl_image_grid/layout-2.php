<?php

$col_xl = $widget->get_setting('col_xl', '');
$col_lg = 12 / intval($widget->get_setting('col_lg', 4));
$col_md = 12 / intval($widget->get_setting('col_md', 3));
$col_sm = 12 / intval($widget->get_setting('col_sm', 2));
$col_xs = 12 / intval($widget->get_setting('col_xs', 1));


$grid_sizer = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
$item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
$grid_custom_columns = $widget->get_setting('grid_masonry', []);
$msclass = is_admin() ? 'pxl-grid-masonry-adm' : 'pxl-grid-masonry22';
if( !empty($grid_custom_columns) ){
    $col_xl_s = 12 / intval($grid_custom_columns[0]['col_xl_m']);
    $col_lg_s = 12 / intval($grid_custom_columns[0]['col_lg_m']);
    $col_md_s = 12 / intval($grid_custom_columns[0]['col_md_m']);
    $col_sm_s = 12 / intval($grid_custom_columns[0]['col_sm_m']);
    $col_xs_s = 12 / intval($grid_custom_columns[0]['col_xs_m']);
    $grid_sizer = "col-xl-{$col_xl_s} col-lg-{$col_lg_s} col-md-{$col_md_s} col-sm-{$col_sm_s} col-{$col_xs_s}";
}
?>
<?php if(isset($settings['image_list']) && !empty($settings['image_list']) && count($settings['image_list'])): ?>
<div class="pxl-grid pxl-image-grid pxl-image-grid2">
    <div class="pxl-grid-inner <?php echo esc_attr($msclass) ?> row" data-gutter="15">

        <?php foreach ($settings['image_list'] as $key => $value):
            $title = isset($value['title']) ? $value['title'] : '';
            $desc = isset($value['desc']) ? $value['desc'] : '';
            $image = isset($value['image']) ? $value['image'] : '';
            $img_size = isset($value['img_size']) ? $value['img_size'] : '';
            $image_size = !empty($img_size) ? $img_size : 'full';

            $item_class = $item_class;
            if( !empty($grid_custom_columns[$key]) ){
                $col_xl = 12 / intval($grid_custom_columns[$key]['col_xl_m']);
                $col_lg = 12 / intval($grid_custom_columns[$key]['col_lg_m']);
                $col_md = 12 / intval($grid_custom_columns[$key]['col_md_m']);
                $col_sm = 12 / intval($grid_custom_columns[$key]['col_sm_m']);
                $col_xs = 12 / intval($grid_custom_columns[$key]['col_xs_m']);
                $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";

                if(!empty($grid_custom_columns[$key]['img_size_m']))
                    $image_size = $grid_custom_columns[$key]['img_size_m'];
            }
            ?>
            <div class="<?php echo esc_attr($item_class); ?>">
                <div class="pxl-image-inner pxl-grid-direction <?php echo esc_attr($settings['pxl_animate']); ?>">
                    <?php if(!empty($image['id'])) { 
                        $img = pxl_get_image_by_size( array(
                            'attach_id'  => $image['id'],
                            'thumb_size' => $image_size,
                            'class' => 'no-lazyload',
                        ));
                        $thumbnail = $img['thumbnail'];
                        ?>
                        <div class="pxl-item-image item-direction">
                            <div class="wrap-item">
                                <?php echo wp_kses_post($thumbnail); ?>
                                <a class="light-box" href="<?php echo wp_get_attachment_image_url( $image['id'], $size = 'full') ?>"></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="grid-sizer pxl-grid-item <?php echo esc_attr($grid_sizer); ?>"></div>
    </div>
</div>
<?php endif; ?>
