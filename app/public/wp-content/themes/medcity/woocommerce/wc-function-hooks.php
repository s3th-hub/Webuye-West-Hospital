<?php

/* Remove result count & product ordering & item product category..... */
function medcity_cwoocommerce_remove_function() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10, 0 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5, 0 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10, 0 );
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10, 0 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10, 0 );
    remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

    remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_sharing', 50 );
}
add_action( 'init', 'medcity_cwoocommerce_remove_function' );

/* Product Category */
add_action( 'woocommerce_before_shop_loop', 'medcity_woocommerce_nav_top', 2 );
function medcity_woocommerce_nav_top() { ?>
    <div class="woocommerce-topbar">
        <div class="woocommerce-result-count">
            <?php woocommerce_result_count(); ?>
        </div>
        <div class="woocommerce-topbar-ordering">
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>
<?php }

add_filter( 'woocommerce_after_shop_loop_item', 'medcity_woocommerce_product' );
function medcity_woocommerce_product() {
    global $product;
    ?>
    <div class="woocommerce-product-inner">
        <div class="woocommerce-product-header">
            <a class="woocommerce-product-details" href="<?php the_permalink(); ?>">
                <?php woocommerce_template_loop_product_thumbnail(); ?>
            </a>
            <div class="woocommerce-product-meta">
                <?php if ( ! $product->managing_stock() && ! $product->is_in_stock() ) { ?>
                    <div class="woocommerce-out-of-stock">
                        <a class="btn" href="<?php the_permalink(); ?>"><?php echo esc_html__('Out Of Stock', 'medcity'); ?></a>
                    </div>
                <?php } else { ?>
                    <div class="woocommerce-add-to-cart">
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="woocommerce-product-holder">
            <h3 class="woocommerce-product-title">
                <a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
            </h3>
            <?php woocommerce_template_loop_price(); ?>
        </div>
    </div>
<?php }

/* Add the custom Tabs Specification */
function medcity_custom_product_tab_specification( $tabs ) {
    $product_specification = medcity_get_page_opt( 'product_specification' );
    if(!empty($product_specification)) {
        $tabs['tab-product-feature'] = array(
            'title'    => esc_html__( 'Product Specification', 'medcity' ),
            'callback' => 'medcity_custom_tab_content_specification',
            'priority' => 10,
        );
        return $tabs;
    } else {
        return $tabs;
    }
}
add_filter( 'woocommerce_product_tabs', 'medcity_custom_product_tab_specification' );

/* Function that displays output for the Tab Specification. */
function medcity_custom_tab_content_specification( $slug, $tab ) {
    $product_specification = medcity_get_page_opt( 'product_specification' );
    $result = count($product_specification); ?>
    <div class="tab-content-wrap">
        <?php if (!empty($product_specification)) : ?>
            <div class="tab-product-feature-list">
                <?php for($i=0; $i<$result; $i+=2) { ?>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <?php echo isset($product_specification[$i])?esc_html( $product_specification[$i] ):''; ?>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-12">
                            <?php echo isset($product_specification[$i+1])?esc_html( $product_specification[$i+1] ):''; ?>
                        </div>
                    </div>
                    <div class="line-gap"></div>
                <?php } ?>
            </div>
        <?php endif; ?>
    </div>
<?php }

/* Removes the "shop" title on the main shop page */
function medcity_hide_page_title()
{
    return false;
}
add_filter('woocommerce_show_page_title', 'medcity_hide_page_title');

/* Replace text Onsale */
add_filter( 'woocommerce_sale_flash', 'medcity_replace_sale_text' );
function medcity_replace_sale_text( $html ) {

    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
    $sale_price = get_post_meta( get_the_ID(), '_sale_price', true);

    $product_sale = '';
    if(!empty($sale_price)) {
        $product_sale = intval( ( (intval($regular_price) - intval($sale_price)) / intval($regular_price) ) * 100);
        return str_replace( 'Sale!', '<span class="onsale-inner"><span>' .$product_sale. '%</span></span>', $html );
    }
}

/* Show product per page */
function medcity_loop_shop_per_page(){
    $product_per_page = medcity_get_opt( 'product_per_page', '9' );
    return $product_per_page;
}
add_filter( 'loop_shop_per_page', 'medcity_loop_shop_per_page' );

/* Product Single: Summary */
add_action( 'woocommerce_before_single_product_summary', 'medcity_woocommerce_single_summer_start', 0 );
function medcity_woocommerce_single_summer_start() { ?>
    <?php echo '<div class="woocommerce-summary-wrap row">'; ?>
<?php }
add_action( 'woocommerce_after_single_product_summary', 'medcity_woocommerce_single_summer_end', 5 );
function medcity_woocommerce_single_summer_end() { ?>
    <?php echo '</div></div>'; ?>
<?php }

add_action( 'woocommerce_single_product_summary', 'medcity_woocommerce_sg_product_price', 10 );
function medcity_woocommerce_sg_product_price() { ?>
    <div class="woocommerce-sg-product-holder">
        <div class="woocommerce-sg-product-title">
            <?php woocommerce_template_single_title(); ?>
        </div>
        <div class="woocommerce-sg-product-rating">
            <?php woocommerce_template_single_rating(); ?>
        </div>
        <div class="woocommerce-sg-product-price">
            <?php woocommerce_template_single_price(); ?>
        </div>
    </div>
<?php }

add_action( 'woocommerce_single_product_summary', 'medcity_woocommerce_sg_product_excerpt', 20 );
function medcity_woocommerce_sg_product_excerpt() { ?>
    <div class="woocommerce-sg-product-excerpt">
        <?php woocommerce_template_single_excerpt(); ?>
    </div>
<?php }

add_action( 'woocommerce_single_product_summary', 'medcity_woocommerce_sg_product_social_share', 31 );
function medcity_woocommerce_sg_product_social_share() { global $product; $product_sku = $product->get_sku(); ?>
    <div class="woocommerce-product-summary-meta">
        <?php if(!empty($product_sku)) : ?>
            <div class="woocommerce-product-suk">
                <label><?php echo esc_html__('SUK:', 'medcity'); ?></label>
                <span><?php echo esc_attr($product_sku); ?></span>
            </div>
        <?php endif; ?>
        <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="woocommerce-product-category"><label>'.esc_html('Categories:', 'medcity').'</label>', '</div>' ); ?>
        <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="woocommerce-product-tag"><label>'.esc_html('Tags:', 'medcity').'</label>', '</div>' ); ?>
    </div>
    <div class="woocommerce-sg-product-social-share">
        <div class="el-social">
            <?php medcity_social_share_product(); ?>
        </div>
    </div>
<?php }

/* Product Single: Gallery */
add_action( 'woocommerce_before_single_product_summary', 'medcity_woocommerce_single_gallery_start', 0 );
function medcity_woocommerce_single_gallery_start() { ?>
    <?php echo '<div class="woocommerce-gallery col-lg-6 col-md-6 col-sm-12 col-xs-12">'; ?>
<?php }
add_action( 'woocommerce_before_single_product_summary', 'medcity_woocommerce_single_gallery_end', 30 );
function medcity_woocommerce_single_gallery_end() { ?>
    <?php echo '</div><div class="woocommerce-product-summary col-lg-6 col-md-6 col-sm-12 col-xs-12">'; ?>
<?php }

/* Rating */
function medcity_rating($rating_html, $rating) {
    global $product;
    $rating_count = $product->get_rating_count();
    if($rating_count == 0) {
        $rating_count = esc_html__( 'No', 'medcity' );
    }
    $rating_html = '<div class="star-rating-wrap">';
    $rating_html .= '<div class="star-rating">';
    $rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"></span>';
    $rating_html .= '</div>';
    $rating_html .= '<div class="count-rating">'.$rating_count.' '.esc_html__('reviews', 'medcity').'</div>';
    $rating_html .= '</div>';
    return $rating_html;
}
add_filter( 'woocommerce_product_get_rating_html', 'medcity_rating', 10, 2);

/* Ajax update cart item */
add_filter('woocommerce_add_to_cart_fragments', 'medcity_woo_mini_cart_item_fragment');
function medcity_woo_mini_cart_item_fragment( $fragments ) {
    global $woocommerce;
    $product_subtitle = medcity_get_page_opt( 'product_subtitle' );
    ob_start();
    ?>
    <div class="widget_shopping_cart">
        <div class="widget_shopping_title">
            <?php echo esc_html__( 'Shopping Cart', 'medcity' ); ?> <span class="widget_cart_counter">(<?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count, 'medcity' ), WC()->cart->cart_contents_count ); ?>)</span>
        </div>
        <div class="widget_shopping_cart_content">
            <?php
            $cart_is_empty = sizeof( $woocommerce->cart->get_cart() ) <= 0;
            ?>
            <ul class="cart_list product_list_widget">

                <?php if ( ! WC()->cart->is_empty() ) : ?>

                    <?php
                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                            $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                            $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                            $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                            ?>
                            <li>
                                <?php if(!empty($thumbnail)) : ?>
                                    <div class="cart-product-image">
                                        <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                            <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="cart-product-meta">
                                    <h3><a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>"><?php echo esc_html($product_name); ?></a></h3>
                                    <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                                    <?php
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="zmdi zmdi-close-circle-o"></i></a>',
                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                        esc_attr__( 'Remove this item', 'medcity' ),
                                        esc_attr( $product_id ),
                                        esc_attr( $cart_item_key ),
                                        esc_attr( $_product->get_sku() )
                                    ), $cart_item_key );
                                    ?>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>

                <?php else : ?>

                    <li class="empty">
                        <span><?php esc_html_e( 'Your cart is empty', 'medcity' ); ?></span>
                        <a class="btn" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php echo esc_html__('Browse Shop', 'medcity'); ?></a>
                    </li>

                <?php endif; ?>

            </ul><!-- end product list -->
        </div>
        <?php if ( ! WC()->cart->is_empty() ) : ?>
            <div class="widget_shopping_cart_footer">
                <p class="total"><strong><?php esc_html_e( 'Subtotal', 'medcity' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

                <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

                <p class="buttons">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn wc-forward"><?php esc_html_e( 'View Cart', 'medcity' ); ?></a>
                    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn checkout wc-forward"><?php esc_html_e( 'Checkout', 'medcity' ); ?></a>
                </p>
            </div>
        <?php endif; ?>
    </div>
    <?php
    $fragments['div.widget_shopping_cart'] = ob_get_clean();
    return $fragments;
}

/* Ajax update cart total number */
add_filter( 'woocommerce_add_to_cart_fragments', 'medcity_woocommerce_header_cart_count_number' );
function medcity_woocommerce_header_cart_count_number( $fragments ) {
    ob_start();
    ?>
    <span class="cart-couter-items">(<?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count, 'medcity' ), WC()->cart->cart_contents_count ); ?>)</span>
    <?php

    $fragments['span.cart-couter-items'] = ob_get_clean();

    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'medcity_woocommerce_sidebar_cart_count_number_header' );
function medcity_woocommerce_sidebar_cart_count_number_header( $fragments ) {
    ob_start();
    ?>
    <span class="widget_cart_counter_header"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count, 'medcity' ), WC()->cart->cart_contents_count ); ?></span>
    <?php

    $fragments['span.widget_cart_counter_header'] = ob_get_clean();

    return $fragments;
}

/**
 * Change number of related products output
 */
add_filter( 'woocommerce_output_related_products_args', 'medcity_related_products_args', 20 );
function medcity_related_products_args( $args ) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}

add_filter('loop_shop_columns', 'medcity_loop_columns', 999);
if (!function_exists('medcity_loop_columns')) {
    function medcity_loop_columns() {
        return medcity_get_opt('product_per_row',4);
    }
}
