<?php
if (!class_exists('Woocommerce')){
    ?> <h4> <?php echo esc_html__('Please Install Woocommerce!', 'medcity'); ?></h4><?php
    return true;
}
$html_id = etc_get_element_id($settings);
$tax = array();
$source = $widget->get_setting('source', '');
$orderby = $widget->get_setting('orderby', 'date');
$order = $widget->get_setting('order', 'desc');
$limit = $widget->get_setting('limit', 6);
$post_ids = $widget->get_setting('post_ids', '');
extract(etc_get_posts_of_grid('product', [
    'source' => $source,
    'orderby' => $orderby,
    'order' => $order,
    'limit' => $limit,
    'post_ids' => $post_ids,
],array('product_cat')));
$filter_default_title = $widget->get_setting('filter_default_title', 'All');
$col_xl = 12 / intval($widget->get_setting('col_xl', 3));
$col_lg = 12 / intval($widget->get_setting('col_lg', 3));
$col_md = 12 / intval($widget->get_setting('col_md', 2));
$col_sm = 12 / intval($widget->get_setting('col_sm', 1));
$col_xs = 12 / intval($widget->get_setting('col_xs', 1));
$grid_sizer = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
$gap_item = intval($widget->get_setting('gap', 15));
$grid_class = 'cms-grid-inner cms-grid-masonry row';
$layout_type = $widget->get_setting('layout_type', 'masonry');

if ($layout_type == 'masonry') {
    $grid_class = 'cms-grid-inner cms-grid-masonry row';
} else {
    $grid_class = 'cms-grid-inner row';
}
$filter = $widget->get_setting('filter', 'false');
$filter_alignment = $widget->get_setting('filter_alignment', 'center');

$thumbnail_size = $widget->get_setting('thumbnail_size', '');
$thumbnail_custom_dimension = $widget->get_setting('thumbnail_custom_dimension', '');
$title_tag = $widget->get_setting('title_tag', 'h3');
$pagination_type = $widget->get_setting('pagination_type', 'pagination');
$cms_animate = $widget->get_setting('cms_animate');

$load_more = array(
    'posttype' => 'product',
    'startPage' => $paged,
    'maxPages'  => $max,
    'total'     => $total,
    'perpage'   => $limit,
    'nextLink'  => $next_link,
    'source' => $source,
    'orderby' => $orderby,
    'order' => $order,
    'limit' => $limit,
    'post_ids' => $post_ids,
    'col_xl'    => $col_xl,
    'col_lg'    => $col_lg,
    'col_md'    => $col_md,
    'col_sm'    => $col_sm,
    'col_xs'    => $col_xs,
    'thumbnail_size'  => $thumbnail_size,
    'thumbnail_custom_dimension'  => $thumbnail_custom_dimension,
    'pagination_type' => $pagination_type,
    'template_type' => 'product_grid_layout1',
);
?>
<div id="<?php echo esc_attr($html_id) ?>" class="cms-grid cms-product-grid woocommerce" data-layout="masonry" data-start-page="<?php echo esc_attr($paged); ?>" data-max-pages="<?php echo esc_attr($max); ?>" data-total="<?php echo esc_attr($total); ?>" data-perpage="<?php echo esc_attr($limit); ?>" data-next-link="<?php echo esc_attr($next_link); ?>">
    <?php if ($filter == "true"): ?>
        <div class="grid-filter-wrap align-<?php echo esc_attr($filter_alignment); ?>">
            <span class="filter-item active" data-filter="*"><?php echo esc_html($filter_default_title); ?></span>
            <?php foreach ($categories as $category): ?>
                <?php $category_arr = explode('|', $category); ?>
                <?php $tax[] = $category_arr[1]; ?>
                <?php $term = get_term_by('slug',$category_arr[0], $category_arr[1]); ?>

                <span class="filter-item" data-filter="<?php echo esc_attr('.' . $term->slug); ?>">
                    <?php echo esc_html($term->name); ?>
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="<?php echo esc_attr($grid_class); ?> animate-time" data-gutter="<?php echo esc_attr($gap_item); ?>">
        <?php if ($layout_type == 'masonry') : ?>
            <div class="grid-sizer <?php echo esc_attr($grid_sizer); ?>"></div>
        <?php endif; ?>
        <?php
        $load_more['tax'] = $tax;
        medcity_get_post_grid($posts, $load_more);
        ?>
    </div>
    <?php if ($pagination_type == 'pagination') { ?>
        <div class="cms-grid-pagination" data-loadmore="<?php echo esc_attr(json_encode($load_more)); ?>" data-query="<?php echo esc_attr(json_encode($args)); ?>">
            <?php medcity_posts_pagination($query, true); ?>
        </div>
    <?php } ?>
    <?php if (!empty($next_link) && $pagination_type == 'loadmore') { ?>
        <div class="cms-load-more text-center" data-loadmore="<?php echo esc_attr(json_encode($load_more)); ?>">
            <span class="btn btn-secondary">
                <?php echo esc_html__('Load More', 'medcity') ?>
            </span>
        </div>
    <?php } ?>
</div>