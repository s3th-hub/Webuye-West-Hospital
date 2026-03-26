<?php
/**
 * Custom template tags for this theme.
 *
 * @package Medcity
 */

/**
 * Header layout
 **/
function medcity_page_loading()
{
    $page_loading = medcity_get_opt( 'show_page_loading', false );

    if($page_loading) { ?>
        <div id="cms-loadding" class="cms-loader">
            <div class="loading-center-absolute">
                <div class="lds-dual-ring"></div>
            </div>
        </div>
    <?php }
}

/**
 * Header layout
 **/
function medcity_header_layout()
{
    $header_layout = medcity_get_opt( 'header_layout', '1' );
    $custom_header = medcity_get_page_opt( 'custom_header', '0' );

    if ( $custom_header == '1' && is_page() || $custom_header == '1' && is_singular('doctor') || $custom_header == '1' && is_singular('service') || $custom_header == '1' && is_singular('department') )
    {
        $page_header_layout = medcity_get_page_opt('header_layout');
        $header_layout = $page_header_layout;
        if($header_layout == '0') {
            return;
        }
    }
    if (is_404()){
        $header_layout = '2';
    }
    get_template_part( 'template-parts/header-layout', $header_layout );
}

/**
 * Page title layout
 **/
function medcity_page_title_layout()
{
    get_template_part( 'template-parts/page-title', '' );
}

/**
 * Page title layout
 **/
function medcity_footer()
{
    if (is_404()) {
        return true;
    }
    $footer_layout = medcity_get_opt('footer_layout', 'custom');

    if (is_page()) {
        $page_footer_layout = medcity_get_page_opt('footer_layout');
        $footer_layout = $page_footer_layout;
    }
    if ($footer_layout == '0') {
        return true;
    }
    get_template_part('template-parts/footer-layout-custom');
}

/**
 * Set primary content class based on sidebar position
 *
 * @param  string $sidebar_pos
 * @param  string $extra_class
 */
function medcity_primary_class( $sidebar_pos, $extra_class = '' )
{
    if ( class_exists( 'WooCommerce' ) && (is_product_category()) || class_exists( 'WooCommerce' ) && (is_shop()) ) :
        $sidebar_load = 'sidebar-shop';
    elseif (is_page()) :
        $sidebar_load = 'sidebar-page';
    else :
        $sidebar_load = 'sidebar-blog';
    endif;

    if ( is_active_sidebar( $sidebar_load ) ) {
        $class = array( trim( $extra_class ) );
        switch ( $sidebar_pos )
        {
            case 'left':
                $class[] = 'content-has-sidebar float-right col-xl-8 col-lg-8 col-md-12';
                break;

            case 'right':
                $class[] = 'content-has-sidebar float-left col-xl-8 col-lg-8 col-md-12';
                break;

            default:
                $class[] = 'content-full-width col-12';
                break;
        }

        $class = implode( ' ', array_filter( $class ) );

        if ( $class )
        {
            echo ' class="' . esc_html($class) . '"';
        }
    } else {
        echo ' class="content-area col-12"';
    }
}

/**
 * Set secondary content class based on sidebar position
 *
 * @param  string $sidebar_pos
 * @param  string $extra_class
 */
function medcity_secondary_class( $sidebar_pos, $extra_class = '' )
{
    if ( class_exists( 'WooCommerce' ) && (is_product_category()) ) :
        $sidebar_load = 'sidebar-shop';
    elseif (is_page()) :
        $sidebar_load = 'sidebar-page';
    else :
        $sidebar_load = 'sidebar-blog';
    endif;

    if ( is_active_sidebar( $sidebar_load ) ) {
        $class = array(trim($extra_class));
        switch ($sidebar_pos) {
            case 'left':
                $class[] = 'widget-has-sidebar sidebar-fixed col-xl-4 col-lg-4 col-md-12';
                break;

            case 'right':
                $class[] = 'widget-has-sidebar sidebar-fixed col-xl-4 col-lg-4 col-md-12';
                break;

            default:
                break;
        }

        $class = implode(' ', array_filter($class));

        if ($class) {
            echo ' class="' . esc_html($class) . '"';
        }
    }
}


/**
 * Prints HTML for breadcrumbs.
 */
function medcity_breadcrumb()
{
    if ( ! class_exists( 'CMS_Breadcrumb' ) )
    {
        return;
    }

    if(class_exists('Woocommerce') && is_product()){
        woocommerce_breadcrumb(array(
            'delimiter'   => '',
            'wrap_before' => '<ul class="cms-breadcrumb">',
            'wrap_after'  => '</ul>',
            'before'      => '<li>',
            'after'       => '</li>',
            'home'        => esc_html__( 'Home', 'medcity' ),
        ));

        return;
    }

    $breadcrumb = new CMS_Breadcrumb();
    $entries = $breadcrumb->get_entries();

    if ( empty( $entries ) )
    {
        return;
    }

    ob_start();

    foreach ( $entries as $entry )
    {
        $entry = wp_parse_args( $entry, array(
            'label' => '',
            'url'   => ''
        ) );

        if ( empty( $entry['label'] ) )
        {
            continue;
        }

        echo '<li>';

        if ( ! empty( $entry['url'] ) )
        {
            printf(
                '<a class="breadcrumb-entry" href="%1$s">%2$s</a>',
                esc_url( $entry['url'] ),
                esc_attr( $entry['label'] )
            );
        }
        else
        {
            printf( '<span class="breadcrumb-entry" >%s</span>', esc_html( $entry['label'] ) );
        }

        echo '</li>';
    }

    $output = ob_get_clean();

    if ( $output )
    {
        printf( '<ul class="cms-breadcrumb">%s</ul>', wp_kses_post($output));
    }
}


function medcity_entry_link_pages()
{
    wp_link_pages( array(
        'before'      => '<div class="page-links">',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
    ) );
}


if ( ! function_exists( 'medcity_entry_excerpt' ) ) :
    /**
     * Print post excerpt based on length.
     *
     * @param  integer $length
     */
    function medcity_entry_excerpt( $length = 55 )
    {
        $cms_the_excerpt = get_the_excerpt();
        if(!empty($cms_the_excerpt)) {
            echo esc_html($cms_the_excerpt);
        } else {
            echo wp_kses_post(medcity_get_the_excerpt( $length ));
        }
    }
endif;

/**
 * Prints post edit link when applicable
 */
function medcity_entry_edit_link()
{
    edit_post_link(
        sprintf(
            wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
                esc_html__( 'Edit', 'medcity' ),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ),
        '<div class="entry-edit-link"><i class="fa fa-edit"></i>',
        '</div>'
    );
}

if(!function_exists('medcity_ajax_paginate_links')){
    function medcity_ajax_paginate_links($link){
        $parts = parse_url($link);
        parse_str($parts['query'], $query);
        if(isset($query['page']) && !empty($query['page'])){
            return '#' . $query['page'];
        }
        else{
            return '#1';
        }
    }
}

add_action( 'wp_ajax_medcity_get_pagination_html', 'medcity_get_pagination_html' );
add_action( 'wp_ajax_nopriv_medcity_get_pagination_html', 'medcity_get_pagination_html' );
if(!function_exists('medcity_get_pagination_html')){
    function medcity_get_pagination_html(){
        try{
            if(!isset($_POST['query_vars'])){
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'medcity'));
            }
            $query = new WP_Query($_POST['query_vars']);
            ob_start();
            medcity_posts_pagination( $query,  true );
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_html__('Load Successfully!', 'medcity'),
                    'data' => array(
                        'html' => $html,
                        'query_vars' => $_POST['query_vars'],
                        'post' => $query->have_posts()
                    ),
                )
            );
        }
        catch (Exception $e){
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}

/**
 * Prints posts pagination based on query
 *
 * @param  WP_Query $query     Custom query, if left blank, this will use global query ( current query )
 * @return void
 */
function medcity_posts_pagination( $query = null, $ajax = false )
{
    if($ajax){
        add_filter('paginate_links', 'medcity_ajax_paginate_links');
    }

    $classes = array();

    if ( empty( $query ) )
    {
        $query = $GLOBALS['wp_query'];
    }

    if ( empty( $query->max_num_pages ) || ! is_numeric( $query->max_num_pages ) || $query->max_num_pages < 2 )
    {
        return;
    }

    $paged = $query->get( 'paged', '' );

    if ( ! $paged && is_front_page() && ! is_home() )
    {
        $paged = $query->get( 'page', '' );
    }

    $paged = $paged ? intval( $paged ) : 1;

    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) )
    {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $html_prev = '<i class="fac fac-arrow-left"></i>';
    $html_next = '<i class="fac fac-arrow-right"></i>';
    $paginate_links_args = array(
        'base'     => $pagenum_link,
        'total'    => $query->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => $html_prev,
        'next_text' => $html_next,
    );
    if($ajax){
        $paginate_links_args['format'] = '?page=%#%';
    }
    $links = paginate_links( $paginate_links_args );
    if ( $links ):
    ?>
    <nav class="navigation posts-pagination <?php echo esc_attr($ajax?'ajax':''); ?>">
        <div class="posts-page-links">
            <?php
                printf($links);
            ?>
        </div>
    </nav>
    <?php
    endif;
}

/**
 * Prints archive meta on blog
 */
if ( ! function_exists( 'medcity_archive_meta' ) ) :
    function medcity_archive_meta() {
        $archive_author_on = medcity_get_opt( 'archive_author_on', false );
        $archive_categories_on = medcity_get_opt( 'archive_categories_on', true );
        $archive_comments_on = medcity_get_opt( 'archive_comments_on', true );
        $archive_date_on = medcity_get_opt( 'archive_date_on', true );
        if($archive_author_on || $archive_comments_on || $archive_categories_on || $archive_date_on) : ?>
            <ul class="entry-meta">
                <?php if($archive_categories_on && !empty(get_the_terms(get_the_ID(),'category'))) : ?>
                    <li class="item-category"><?php the_terms( get_the_ID(), 'category', '', ', ' ); ?></li>
                <?php endif; ?>
                <?php if($archive_author_on) : ?>
                    <li class="item-author">
                        <span><?php echo esc_html__('By', 'medcity'); ?></span>
                        <?php the_author_posts_link(); ?>
                    </li>
                <?php endif; ?>
                <?php if($archive_date_on) : ?>
                    <li><?php echo get_the_date(); ?></li>
                <?php endif; ?>
                <?php if($archive_comments_on) : ?>
                    <li class="item-comment"><a href="<?php the_permalink(); ?>"><?php echo comments_number(esc_html__('No Comments', 'medcity'),esc_html__('Comment: 1', 'medcity'),esc_html__('Comments: %', 'medcity')); ?></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; }
endif;

if ( ! function_exists( 'medcity_post_meta' ) ) :
    function medcity_post_meta() {
        $post_author_on = medcity_get_opt( 'post_author_on', true );
        $post_categories_on = medcity_get_opt( 'post_categories_on', true );
        $post_date_on = medcity_get_opt( 'post_date_on', true );
        $post_comments_on = medcity_get_opt( 'post_comments_on', false );
        if($post_author_on || $post_comments_on || $post_categories_on || $post_date_on) : ?>
            <ul class="entry-meta">
                <?php if($post_date_on) : ?>
                    <li class="item-date"><?php echo get_the_date(); ?></li>
                <?php endif; ?>
                <?php if($post_categories_on && !has_post_thumbnail()) : ?>
                    <li class="item-category"><?php the_terms( get_the_ID(), 'category', '', ', ' ); ?></li>
                <?php endif; ?>
                <?php if($post_author_on) : ?>
                    <li class="item-author">
                        <span><?php echo esc_html__('By:', 'medcity'); ?></span>
                        <?php the_author_posts_link(); ?>
                    </li>
                <?php endif; ?>
                <?php if($post_comments_on) : ?>
                    <li class="item-comment"><a href="<?php the_permalink(); ?>"><?php echo comments_number(esc_html__('No Comments', 'medcity'),esc_html__('Comment: 1', 'medcity'),esc_html__('Comments: %', 'medcity')); ?></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; }
endif;

/**
 * Set Customer Cookie
 */
if ( ! function_exists( 'medcity_set_cookie' ) ) :
    function medcity_set_cookie($cname, $cvalue, $exdays)
    {
        $extimes = $exdays*24*60*60;
        setcookie($cname, $cvalue, time() + $extimes);
    }
endif;
/**
 * Get Customer Cookie
 */
if ( ! function_exists( 'medcity_get_cookie' ) ) :
    function medcity_get_cookie($cname)
    {
        if (!empty($_COOKIE[$cname])){
            return $_COOKIE[$cname];
        }else{
            return false;
        }
    }
endif;

/**
 * Prints tag list
 */
if ( ! function_exists( 'medcity_entry_tagged_in' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function medcity_entry_tagged_in()
    {
        ob_start();
        $before_tags = ob_get_clean();
        $tags_list = get_the_tag_list( $before_tags, '' );
        if ( $tags_list )
        {
            echo '<div class="clearfix">';
            echo '<div class="entry-tags">';
            printf('%2$s', '', $tags_list);
            echo '</div>';
            echo '</div>';
        }
    }
endif;

/**
 * List socials share for post.
 */
function medcity_socials_share_default() { ?>
    <div class="entry-social-wrap">
        <label><?php echo esc_html__('Share', 'medcity');?></label>
        <ul>
            <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php urlencode(the_permalink()); ?>"><i class="fab fac-facebook-f"></i></a></li>
            <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="fab fac-twitter"></i></a></li>
            <li><a class="pin-social" title="Pinterest" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_post_thumbnail_url('full'); ?>&media=&description=<?php echo urlencode(the_title_attribute('echo=0')); ?>"><i class="fab fac-pinterest-p"></i></a></li>
        </ul>
    </div>
    <?php
}

/**
 * Search Popup
 */
function medcity_search_popup()
{
    $search_on = medcity_get_opt( 'search_on', false );
    if($search_on) { ?>
        <div class="cms-modal cms-modal-search">
            <div class="cms-modal-close"><i class="zmdi zmdi-close"></i></div>
            <div class="cms-modal-content">
                <form role="search" method="get" class="search-form-popup" action="<?php echo esc_url(home_url( '/' )); ?>">
                    <div class="searchform-wrap">
                        <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                        <input type="text" placeholder="<?php echo esc_attr__('Type Words Then Enter', 'medcity'); ?>" id="search" name="s" class="search-field" />
                    </div>
                </form>
            </div>
        </div>
    <?php }
}
/**
 * Sidebar Hidden
 */
function medcity_sidebar_hidden()
{
    $hidden_sidebar_on = medcity_get_opt( 'hidden_sidebar_on', false );
    if($hidden_sidebar_on && is_active_sidebar('sidebar-hidden')) { ?>
        <div class="cms-hidden-sidebar">
            <div class="cms-hidden-close fa fa-close"></div>
            <div class="cms-hidden-sidebar-inner">
                <?php dynamic_sidebar( 'sidebar-hidden' ); ?>
            </div>
        </div>
    <?php }
}
/**
 * User custom fields.
 */
add_action( 'show_user_profile', 'medcity_user_fields' );
add_action( 'edit_user_profile', 'medcity_user_fields' );
function medcity_user_fields($user){

    $user_facebook = get_user_meta($user->ID, 'user_facebook', true);
    $user_twitter = get_user_meta($user->ID, 'user_twitter', true);
    $user_linkedin = get_user_meta($user->ID, 'user_linkedin', true);
    $user_skype = get_user_meta($user->ID, 'user_skype', true);
    $user_google = get_user_meta($user->ID, 'user_google', true);
    $user_youtube = get_user_meta($user->ID, 'user_youtube', true);
    $user_vimeo = get_user_meta($user->ID, 'user_vimeo', true);
    $user_tumblr = get_user_meta($user->ID, 'user_tumblr', true);
    $user_rss = get_user_meta($user->ID, 'user_rss', true);
    $user_pinterest = get_user_meta($user->ID, 'user_pinterest', true);
    $user_instagram = get_user_meta($user->ID, 'user_instagram', true);
    $user_yelp = get_user_meta($user->ID, 'user_yelp', true);

    ?>
    <h3><?php esc_html_e('Social', 'medcity'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="user_facebook"><?php esc_html_e('Facebook', 'medcity'); ?></label></th>
            <td>
                <input id="user_facebook" name="user_facebook" type="text" value="<?php echo esc_attr(isset($user_facebook) ? $user_facebook : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_twitter"><?php esc_html_e('Twitter', 'medcity'); ?></label></th>
            <td>
                <input id="user_twitter" name="user_twitter" type="text" value="<?php echo esc_attr(isset($user_twitter) ? $user_twitter : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_linkedin"><?php esc_html_e('Linkedin', 'medcity'); ?></label></th>
            <td>
                <input id="user_linkedin" name="user_linkedin" type="text" value="<?php echo esc_attr(isset($user_linkedin) ? $user_linkedin : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_skype"><?php esc_html_e('Skype', 'medcity'); ?></label></th>
            <td>
                <input id="user_skype" name="user_skype" type="text" value="<?php echo esc_attr(isset($user_skype) ? $user_skype : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_google"><?php esc_html_e('Google', 'medcity'); ?></label></th>
            <td>
                <input id="user_google" name="user_google" type="text" value="<?php echo esc_attr(isset($user_google) ? $user_google : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_youtube"><?php esc_html_e('Youtube', 'medcity'); ?></label></th>
            <td>
                <input id="user_youtube" name="user_youtube" type="text" value="<?php echo esc_attr(isset($user_youtube) ? $user_youtube : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_vimeo"><?php esc_html_e('Vimeo', 'medcity'); ?></label></th>
            <td>
                <input id="user_vimeo" name="user_vimeo" type="text" value="<?php echo esc_attr(isset($user_vimeo) ? $user_vimeo : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_tumblr"><?php esc_html_e('Tumblr', 'medcity'); ?></label></th>
            <td>
                <input id="user_tumblr" name="user_tumblr" type="text" value="<?php echo esc_attr(isset($user_tumblr) ? $user_tumblr : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_rss"><?php esc_html_e('Rss', 'medcity'); ?></label></th>
            <td>
                <input id="user_rss" name="user_rss" type="text" value="<?php echo esc_attr(isset($user_rss) ? $user_rss : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_pinterest"><?php esc_html_e('Pinterest', 'medcity'); ?></label></th>
            <td>
                <input id="user_pinterest" name="user_pinterest" type="text" value="<?php echo esc_attr(isset($user_pinterest) ? $user_pinterest : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_instagram"><?php esc_html_e('Instagram', 'medcity'); ?></label></th>
            <td>
                <input id="user_instagram" name="user_instagram" type="text" value="<?php echo esc_attr(isset($user_instagram) ? $user_instagram : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_yelp"><?php esc_html_e('Yelp', 'medcity'); ?></label></th>
            <td>
                <input id="user_yelp" name="user_yelp" type="text" value="<?php echo esc_attr(isset($user_yelp) ? $user_yelp : ''); ?>" />
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save user custom fields.
 */
add_action( 'personal_options_update', 'medcity_save_user_custom_fields' );
add_action( 'edit_user_profile_update', 'medcity_save_user_custom_fields' );
function medcity_save_user_custom_fields( $user_id )
{
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    if(isset($_POST['user_facebook']))
        update_user_meta( $user_id, 'user_facebook', $_POST['user_facebook'] );
    if(isset($_POST['user_twitter']))
        update_user_meta( $user_id, 'user_twitter', $_POST['user_twitter'] );
    if(isset($_POST['user_linkedin']))
        update_user_meta( $user_id, 'user_linkedin', $_POST['user_linkedin'] );
    if(isset($_POST['user_skype']))
        update_user_meta( $user_id, 'user_skype', $_POST['user_skype'] );
    if(isset($_POST['user_google']))
        update_user_meta( $user_id, 'user_google', $_POST['user_google'] );
    if(isset($_POST['user_youtube']))
        update_user_meta( $user_id, 'user_youtube', $_POST['user_youtube'] );
    if(isset($_POST['user_vimeo']))
        update_user_meta( $user_id, 'user_vimeo', $_POST['user_vimeo'] );
    if(isset($_POST['user_tumblr']))
        update_user_meta( $user_id, 'user_tumblr', $_POST['user_tumblr'] );
    if(isset($_POST['user_rss']))
        update_user_meta( $user_id, 'user_rss', $_POST['user_rss'] );
    if(isset($_POST['user_pinterest']))
        update_user_meta( $user_id, 'user_pinterest', $_POST['user_pinterest'] );
    if(isset($_POST['user_instagram']))
        update_user_meta( $user_id, 'user_instagram', $_POST['user_instagram'] );
    if(isset($_POST['user_yelp']))
        update_user_meta( $user_id, 'user_yelp', $_POST['user_yelp'] );
}
/* Author Social */
function medcity_get_user_social() {

    $user_facebook = get_user_meta(get_the_author_meta( 'ID' ), 'user_facebook', true);
    $user_twitter = get_user_meta(get_the_author_meta( 'ID' ), 'user_twitter', true);
    $user_linkedin = get_user_meta(get_the_author_meta( 'ID' ), 'user_linkedin', true);
    $user_skype = get_user_meta(get_the_author_meta( 'ID' ), 'user_skype', true);
    $user_google = get_user_meta(get_the_author_meta( 'ID' ), 'user_google', true);
    $user_youtube = get_user_meta(get_the_author_meta( 'ID' ), 'user_youtube', true);
    $user_vimeo = get_user_meta(get_the_author_meta( 'ID' ), 'user_vimeo', true);
    $user_tumblr = get_user_meta(get_the_author_meta( 'ID' ), 'user_tumblr', true);
    $user_rss = get_user_meta(get_the_author_meta( 'ID' ), 'user_rss', true);
    $user_pinterest = get_user_meta(get_the_author_meta( 'ID' ), 'user_pinterest', true);
    $user_instagram = get_user_meta(get_the_author_meta( 'ID' ), 'user_instagram', true);
    $user_yelp = get_user_meta(get_the_author_meta( 'ID' ), 'user_yelp', true);

    ?>
    <ul class="user-social">
        <?php if(!empty($user_facebook)) { ?>
            <li><a href="<?php echo esc_url($user_facebook); ?>"><i class="fa fa-facebook"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_twitter)) { ?>
            <li><a href="<?php echo esc_url($user_twitter); ?>"><i class="fa fa-twitter"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_rss)) { ?>
            <li><a href="<?php echo esc_url($user_rss); ?>"><i class="fa fa-rss"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_google)) { ?>
            <li><a href="<?php echo esc_url($user_google); ?>"><i class="fa fa-google-plus"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_skype)) { ?>
            <li><a href="<?php echo esc_url($user_skype); ?>"><i class="fa fa-skype"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_pinterest)) { ?>
            <li><a href="<?php echo esc_url($user_pinterest); ?>"><i class="fa fa-pinterest"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_vimeo)) { ?>
            <li><a href="<?php echo esc_url($user_vimeo); ?>"><i class="fa fa-vimeo-square"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_instagram)) { ?>
            <li><a href="<?php echo esc_url($user_instagram); ?>"><i class="fa fa-instagram"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_linkedin)) { ?>
            <li><a href="<?php echo esc_url($user_linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_youtube)) { ?>
            <li><a href="<?php echo esc_url($user_youtube); ?>"><i class="fa fa-youtube"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_yelp)) { ?>
            <li><a href="<?php echo esc_url($user_yelp); ?>"><i class="fa fa-yelp"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_tumblr)) { ?>
            <li><a href="<?php echo esc_url($user_tumblr); ?>"><i class="fa fa-tumblr"></i></a></li>
        <?php } ?>

    </ul> <?php
}

function medcity_social_share_product() { ?>
    <a class="fb-social hover-effect" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i></a>
    <a class="tw-social hover-effect" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i></a>
    <a class="pin-social hover-effect" title="Pinterest" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(the_post_thumbnail_url( 'full' )); ?>&media=&description=<?php the_title(); ?>"><i class="zmdi zmdi-pinterest"></i></a>
    <?php
}

function medcity_product_nav() {
    global $post;
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    if( !empty($next_post) || !empty($previous_post) ) { ?>
        <div class="product-previous-next">
            <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') { ?>
                <a class="nav-link-prev" href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><i class="fa fa-long-arrow-left"></i></a>
            <?php } ?>
            <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') { ?>
                <a class="nav-link-next" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><i class="fa fa-long-arrow-right"></i></a>
            <?php } ?>
        </div>
    <?php }
}

/**
 * Social Media
 */
function medcity_social_media()
{
    $social_media = medcity_get_opt('social_media');
    $social = array();
    if (!empty($social_media['enabled'])){
        $social = $social_media['enabled'];
    }
    if ($social) : foreach ($social as $key => $value) { ?>
        <?php switch ($key) {

            case 'facebook':
                echo '<a title="Facebook" href="' . esc_url(medcity_get_opt('social_facebook_url')) . '"><i class="fab fac-facebook-f"></i></a>';
                break;

            case 'twitter':
                echo '<a title="Twitter" href="' . esc_url(medcity_get_opt('social_twitter_url')) . '"><i class="fab fac-twitter"></i></a>';
                break;

            case 'instagram':
                echo '<a title="Instagram" href="' . esc_url(medcity_get_opt('social_instagram_url')) . '"><i class="fab fac-instagram"></i></a>';
                break;

            case 'behance':
                echo '<a title="Behance" href="' . esc_url(medcity_get_opt('social_behance_url')) . '"><i class="fab fac-behance"></i></a>';
                break;

            case 'dribbble':
                echo '<a title="Dribbble" href="' . esc_url(medcity_get_opt('social_dribbble_url')) . '"><i class="fab fac-dribbble"></i></a>';
                break;

            case 'linkedin':
                echo '<a title="Linkedin" href="' . esc_url(medcity_get_opt('social_inkedin_url')) . '"><i class="fab fac-linkedin-in"></i></a>';
                break;

            case 'rss':
                echo '<a title="Rss" href="' . esc_url(medcity_get_opt('social_rss_url')) . '"><i class="fas fac-rss"></i></a>';
                break;

            case 'google':
                echo '<a title="Google+" href="' . esc_url(medcity_get_opt('social_google_url')) . '"><i class="fab fac-google-plus-g"></i></a>';
                break;

            case 'skype':
                echo '<a title="Skype" href="' . esc_url(medcity_get_opt('social_skype_url')) . '"><i class="fab fac-skype"></i></a>';
                break;

            case 'pinterest':
                echo '<a title="Pinterest" href="' . esc_url(medcity_get_opt('social_pinterest_url')) . '"><i class="fab fac-pinterest"></i></a>';
                break;

            case 'vimeo':
                echo '<a title="Vimeo" href="' . esc_url(medcity_get_opt('social_vimeo_url')) . '"><i class="fab fac-vimeo-v"></i></a>';
                break;

            case 'youtube':
                echo '<a title="Youtube" href="' . esc_url(medcity_get_opt('social_youtube_url')) . '"><i class="fab fac-youtube"></i></a>';
                break;

            case 'yelp':
                echo '<a title="Yelp" href="' . esc_url(medcity_get_opt('social_yelp_url')) . '"><i class="fab fac-yelp"></i></a>';
                break;

            case 'tumblr':
                echo '<a title="Tumblr" href="' . esc_url(medcity_get_opt('social_tumblr_url')) . '"><i class="fab fac-tumblr"></i></a>';
                break;

        }
    }
    endif;
}

function medcity_social_footer() {
    $f_social_facebook_url = medcity_get_opt( 'f_social_facebook_url' );
    $f_social_twitter_url = medcity_get_opt( 'f_social_twitter_url' );
    $f_social_inkedin_url = medcity_get_opt( 'f_social_inkedin_url' );
    $f_social_instagram_url = medcity_get_opt( 'f_social_instagram_url' );
    $f_social_google_url = medcity_get_opt( 'f_social_google_url' );
    $f_social_skype_url = medcity_get_opt( 'f_social_skype_url' );
    $f_social_pinterest_url = medcity_get_opt( 'f_social_pinterest_url' );
    $f_social_vimeo_url = medcity_get_opt( 'f_social_vimeo_url' );
    $f_social_youtube_url = medcity_get_opt( 'f_social_youtube_url' );
    $f_social_yelp_url = medcity_get_opt( 'f_social_yelp_url' );
    $f_social_tumblr_url = medcity_get_opt( 'f_social_tumblr_url' );
    $f_social_tripadvisor_url = medcity_get_opt( 'f_social_tripadvisor_url' );

    if(!empty($f_social_tripadvisor_url)) :
        echo '<a href="'.esc_url($f_social_tripadvisor_url).'" target="_blank"><i class="fa fa-tripadvisor"></i></a>';
    endif;
    if(!empty($f_social_facebook_url)) :
        echo '<a href="'.esc_url($f_social_facebook_url).'" target="_blank"><i class="fa fa-facebook"></i></a>';
    endif;
    if(!empty($f_social_twitter_url)) :
        echo '<a href="'.esc_url($f_social_twitter_url).'" target="_blank"><i class="fa fa-twitter"></i></a>';
    endif;
    if(!empty($f_social_inkedin_url)) :
        echo '<a href="'.esc_url($f_social_inkedin_url).'" target="_blank"><i class="fa fa-linkedin"></i></a>';
    endif;
    if(!empty($f_social_instagram_url)) :
        echo '<a href="'.esc_url($f_social_instagram_url).'" target="_blank"><i class="fa fa-instagram"></i></a>';
    endif;
    if(!empty($f_social_google_url)) :
        echo '<a href="'.esc_url($f_social_google_url).'" target="_blank"><i class="fa fa-google-plus"></i></a>';
    endif;
    if(!empty($f_social_skype_url)) :
        echo '<a href="'.esc_url($f_social_skype_url).'" target="_blank"><i class="fa fa-skype"></i></a>';
    endif;
    if(!empty($f_social_pinterest_url)) :
        echo '<a href="'.esc_url($f_social_pinterest_url).'" target="_blank"><i class="fa fa-pinterest"></i></a>';
    endif;
    if(!empty($f_social_vimeo_url)) :
        echo '<a href="'.esc_url($f_social_vimeo_url).'" target="_blank"><i class="fa fa-vimeo-square"></i></a>';
    endif;
    if(!empty($f_social_youtube_url)) :
        echo '<a href="'.esc_url($f_social_youtube_url).'" target="_blank"><i class="fa fa-youtube"></i></a>';
    endif;
    if(!empty($f_social_yelp_url)) :
        echo '<a href="'.esc_url($f_social_yelp_url).'" target="_blank"><i class="fa fa-yelp"></i></a>';
    endif;
    if(!empty($f_social_tumblr_url)) :
        echo '<a href="'.esc_url($f_social_tumblr_url).'" target="_blank"><i class="fa fa-tumblr"></i></a>';
    endif;
}

if(!function_exists('medcity_get_post_grid_layout1')){
    function medcity_get_post_grid_layout1($posts = [], $settings = []){
        extract($settings);
        if($thumbnail_size != 'custom' && $thumbnail_size != 'full'){
            $img_size = $thumbnail_size;
        }
        elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
            $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
        }
        else{
            $img_size = '768x568';
        }
        if (is_array($posts)):
            foreach ($posts as $post):
                $img_id = get_post_thumbnail_id($post->ID);
                $img = etc_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $img_size,
                    'class'      => '',
                ));
                $thumbnail = $img['thumbnail'];
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));
                $author = get_user_by('id', $post->post_author);
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false) && $show_thumbnail == 'true'): ?>
                            <div class="entry-featured">
                                <div class="post-image">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                </div>
                                <?php if($show_categories == 'true'): ?>
                                    <div class="post-category"><?php the_terms( $post->ID, 'category', '', ', ' ); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="entry-body">
                            <ul class="entry-meta">
                                <?php if($show_post_date == 'true'): ?>
                                    <li class="post-date"><?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?></li>
                                <?php endif; ?>
                                <?php if($show_author == 'true'): ?>
                                    <li class="author">
                                        <a href="<?php echo esc_url(get_author_posts_url($post->post_author, $author->user_nicename)); ?>"><?php echo esc_html($author->display_name); ?></a></li>
                                <?php endif; ?>
                            </ul>
                            <?php if($show_title == 'true'): ?>
                                <<?php etc_print_html($title_tag);?> class="entry-title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></<?php etc_print_html($title_tag);?>>
                            <?php endif; ?>
                            <?php if($show_excerpt == 'true'): ?>
                                <div class="entry-content">
                                    <?php
                                        if(!empty($post->post_excerpt)){
                                            echo wp_trim_words( $post->post_excerpt, $num_words, $more = null );
                                        }
                                        else{
                                            $content = strip_shortcodes( $post->post_content );
                                            $content = apply_filters( 'the_content', $content );
                                            $content = str_replace(']]>', ']]&gt;', $content);
                                            $content = wp_trim_words( $content, $num_words, '&hellip;' );
                                            echo wp_kses_post($content);
                                        }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php if($show_button == 'true'): ?>
                                <div class="entry-readmore">
                                    <a class="btn-more" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                        <span><?php echo esc_attr($button_text); ?></span>
                                        <i class="far fa-arrow-right"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('medcity_get_doctor_grid_layout1')){
    function medcity_get_doctor_grid_layout1($posts = [], $settings = []){
        extract($settings);
        if($thumbnail_size != 'custom'){
            $img_size = $thumbnail_size;
        }
        elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
            $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
        }
        else{
            $img_size = 'full';
        }
        if (is_array($posts)):
            foreach ($posts as $post):
                $img_id = get_post_thumbnail_id($post->ID);
                $img = etc_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $img_size,
                    'class'      => '',
                ));
                $thumbnail = $img['thumbnail'];
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));

                // Social Info
                $doctor_facebook = get_post_meta($post->ID, 'doctor_facebook_url', true);
                $doctor_instagram = get_post_meta($post->ID, 'doctor_instagram_url', true);
                $doctor_twitter = get_post_meta($post->ID, 'doctor_twitter_url', true);
                $doctor_email = get_post_meta($post->ID, 'doctor_email', true);
                $doctor_phone = get_post_meta($post->ID, 'doctor_phone', true);
                $doctor_phone_escape = preg_replace('#[ () ]*#', '', $doctor_phone);
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                            <div class="entry-featured">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                <div class="content-social">
                                    <ul class="doctor-social">
                                        <?php if(!empty($doctor_facebook) && $show_facebook == 'true') : ?>
                                            <li>
                                                <a class="doctor-f" href="<?php echo esc_url($doctor_facebook); ?>" target="_self">
                                                    <i class="zmdi zmdi-facebook"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_twitter) && $show_twitter == 'true') : ?>
                                            <li>
                                                <a class="doctor-t" href="<?php echo esc_url($doctor_twitter); ?>" target="_self">
                                                    <i class="zmdi zmdi-twitter"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_instagram) && $show_instagram == 'true') : ?>
                                            <li>
                                                <a class="doctor-i" href="<?php echo esc_attr($doctor_instagram); ?>" target="_self">
                                                    <i class="zmdi zmdi-instagram"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_email) && $show_email == 'true') : ?>
                                            <li>
                                                <a class="doctor-e" href="mailto:<?php echo esc_html($doctor_email); ?>" target="_self">
                                                    <i class="zmdi zmdi-email"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_phone) && $show_phone == 'true') : ?>
                                            <li>
                                                <a class="doctor-p" href="tel:<?php echo esc_attr($doctor_phone_escape); ?>">
                                                    <i class="zmdi zmdi-phone"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="entry-body">
                            <h3 class="entry-title">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                            <?php if($show_categories == 'true'): ?>
                                <div class="item-category"><?php the_terms( $post->ID, 'doctor-category', '', ', ' ); ?></div>
                            <?php endif; ?>
                            <?php if($show_excerpt == 'true'): ?>
                                <div class="entry-content">
                                    <?php
                                    if (!empty($post->post_excerpt)) {
                                        echo wp_trim_words($post->post_excerpt, $num_words, '.');
                                    } else {
                                        $content = strip_shortcodes($post->post_content);
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = wp_trim_words($content, $num_words, '&hellip;');
                                        echo wp_kses_post($content);
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('medcity_get_doctor_grid_layout2')){
    function medcity_get_doctor_grid_layout2($posts = [], $settings = []){
        extract($settings);
        if($thumbnail_size != 'custom'){
            $img_size = $thumbnail_size;
        }
        elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
            $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
        }
        else{
            $img_size = 'full';
        }
        if (is_array($posts)):
            foreach ($posts as $post):
                $img_id = get_post_thumbnail_id($post->ID);
                $img = etc_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $img_size,
                    'class'      => '',
                ));
                $thumbnail = $img['thumbnail'];
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));
                // Social Info
                $doctor_facebook = get_post_meta($post->ID, 'doctor_facebook_url', true);
                $doctor_instagram = get_post_meta($post->ID, 'doctor_instagram_url', true);
                $doctor_twitter = get_post_meta($post->ID, 'doctor_twitter_url', true);
                $doctor_email = get_post_meta($post->ID, 'doctor_email', true);
                $doctor_phone = get_post_meta($post->ID, 'doctor_phone', true);
                $doctor_phone_escape = preg_replace('#[ () ]*#', '', $doctor_phone);
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                            <div class="entry-featured">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-body">
                            <h3 class="entry-title">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                            <?php if($show_categories == 'true'): ?>
                                <div class="item-category">
                                    <?php the_terms( $post->ID, 'doctor-category', '', ', ' ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if($show_excerpt == 'true'): ?>
                                <div class="entry-content">
                                    <?php
                                    if (!empty($post->post_excerpt)) {
                                        echo wp_trim_words($post->post_excerpt, $num_words, '.');
                                    } else {
                                        $content = strip_shortcodes($post->post_content);
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = wp_trim_words($content, $num_words, '&hellip;');
                                        echo wp_kses_post($content);
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="bottom-content">
                                <?php if($show_button == 'true'): ?>
                                    <div class="entry-readmore">
                                        <a class="btn" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                            <span><?php echo esc_attr($button_text); ?></span>
                                            <i class="far fa-arrow-right"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="content-social">
                                    <ul class="doctor-social">
                                        <?php if(!empty($doctor_facebook) && $show_facebook == 'true') : ?>
                                            <li>
                                                <a class="doctor-f" href="<?php echo esc_url($doctor_facebook); ?>" target="_self">
                                                    <i class="zmdi zmdi-facebook"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_twitter) && $show_twitter == 'true') : ?>
                                            <li>
                                                <a class="doctor-t" href="<?php echo esc_url($doctor_twitter); ?>" target="_self">
                                                    <i class="zmdi zmdi-twitter"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_instagram) && $show_instagram == 'true') : ?>
                                            <li>
                                                <a class="doctor-i" href="<?php echo esc_attr($doctor_instagram); ?>" target="_self">
                                                    <i class="zmdi zmdi-instagram"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_email) && $show_email == 'true') : ?>
                                            <li>
                                                <a class="doctor-e" href="mailto:<?php echo esc_html($doctor_email); ?>" target="_self">
                                                    <i class="zmdi zmdi-email"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!empty($doctor_phone) && $show_phone == 'true') : ?>
                                            <li>
                                                <a class="doctor-p" href="tel:<?php echo esc_attr($doctor_phone_escape); ?>">
                                                    <i class="zmdi zmdi-phone"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('medcity_get_doctor_grid_layout3')){
    function medcity_get_doctor_grid_layout3($posts = [], $settings = []){
        extract($settings);
        if($thumbnail_size != 'custom'){
            $img_size = $thumbnail_size;
        }
        elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
            $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
        }
        else{
            $img_size = 'full';
        }
        if (is_array($posts)):
            foreach ($posts as $post):
                $img_id = get_post_thumbnail_id($post->ID);
                $img = etc_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $img_size,
                    'class'      => '',
                ));
                $thumbnail = $img['thumbnail'];
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                            <div class="entry-featured">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-body">
                            <h3 class="entry-title">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                            <?php if($show_categories == 'true'): ?>
                                <div class="item-category">
                                    <?php the_terms( $post->ID, 'doctor-category', '', ', ' ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if($show_excerpt == 'true'): ?>
                                <div class="entry-content">
                                    <?php
                                    if (!empty($post->post_excerpt)) {
                                        echo wp_trim_words($post->post_excerpt, $num_words, '.');
                                    } else {
                                        $content = strip_shortcodes($post->post_content);
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = wp_trim_words($content, $num_words, '&hellip;');
                                        echo wp_kses_post($content);
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php if($show_button == 'true'): ?>
                                <div class="entry-readmore">
                                    <a class="btn" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                        <span><?php echo esc_attr($button_text); ?></span>
                                        <i class="far fa-arrow-right"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('medcity_get_service_grid_layout1')){
    function medcity_get_service_grid_layout1($posts = [], $settings = []){
        extract($settings);
        if($thumbnail_size != 'custom' && $thumbnail_size != 'full'){
            $img_size = $thumbnail_size;
        }
        elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
            $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
        }
        else{
            $img_size = '320x240';
        }
        if (is_array($posts)):
            foreach ($posts as $post):
                $img_id = get_post_thumbnail_id($post->ID);
                $img = etc_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $img_size,
                    'class'      => '',
                ));
                $thumbnail = $img['thumbnail'];
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));
                $service_icon = get_post_meta($post->ID, 'service_icon', true);
                $service_feature = get_post_meta($post->ID, 'service_feature', true);
                $result_feature = count($service_feature);
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner">
                        <?php if(!empty($service_icon)) : ?>
                            <div class="item-icon">
                                <img src="<?php echo esc_url($service_icon['url']); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>" />
                            </div>
                            <div class="icon-overlay">
                                <img src="<?php echo esc_url($service_icon['url']); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>" />
                            </div>
                        <?php endif; ?>
                        <div class="entry-body">
                            <h3 class="entry-title">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                            <?php if($show_excerpt == 'true'): ?>
                                <div class="entry-content">
                                    <?php
                                    if (!empty($post->post_excerpt)) {
                                        echo wp_trim_words($post->post_excerpt, $num_words, '.');
                                    } else {
                                        $content = strip_shortcodes($post->post_content);
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = wp_trim_words($content, $num_words, '&hellip;');
                                        echo wp_kses_post($content);
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($service_feature)) : ?>
                                <ul class="item-feature">
                                    <?php for($i=0; $i<$result_feature; $i++) { ?>
                                        <li><i class="fac fac-check"></i><?php echo isset($service_feature[$i])?esc_html( $service_feature[$i] ):''; ?></li>
                                    <?php } ?>
                                </ul>
                            <?php endif; ?>
                            <?php if($show_button == 'true'): ?>
                                <div class="entry-readmore">
                                    <a class="service-readmore btn" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr($button_text); ?> <i class="fac fac-arrow-right"></i></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}
if(!function_exists('medcity_get_service_grid_layout4')){
    /**
     * @since 1.1.1
     * @author Chinh Duong Manh
     * */
    function medcity_get_service_grid_layout4($posts = [], $settings = []){
        extract($settings);
        if($thumbnail_size != 'custom' && $thumbnail_size != 'full'){
            $img_size = $thumbnail_size;
        }
        elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
            $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
        }
        else{
            $img_size = '570x416';
        }
        if (is_array($posts)):
            foreach ($posts as $post):
                $img_id = get_post_thumbnail_id($post->ID);
                $img = etc_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $img_size,
                    'class'      => 'cms-radius-12',
                ));
                $thumbnail = $img['thumbnail'];
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));
                $service_icon = get_post_meta($post->ID, 'service_icon', true);
                $service_feature = get_post_meta($post->ID, 'service_feature', true);
                $result_feature = count($service_feature);
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="inner-wrap bg-white cms-radius-12 cms-shadow-1 cms-transition cms-hover-change cms-divider-bottom-hover-accent cms-hover-zoom-img overflow-hidden">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="d-block cms-radius-12 overflow-hidden"><?php 
                                echo wp_kses_post($thumbnail); 
                            ?></a>
                        <?php endif; ?>
                        <div class="entry-body p-40">
                            <h3 class="entry-title text-on-hover-primary text-23 mt-n8 pb-15">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                            <?php if($show_excerpt == 'true'): ?>
                                <div class="entry-content text-15">
                                    <?php
                                    if (!empty($post->post_excerpt)) {
                                        echo wp_trim_words($post->post_excerpt, $num_words, '.');
                                    } else {
                                        $content = strip_shortcodes($post->post_content);
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = wp_trim_words($content, $num_words, '&hellip;');
                                        echo wp_kses_post($content);
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php if($show_button == 'true'): ?>
                                <div class="entry-readmore mt-32">
                                    <a class="service-readmore cms-btn cms-btn-outline-btn2 text-btn cms-btn-hover-secondary text-hover-white cms-btn-on-hover-primary text-on-hover-white" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                        <?php echo esc_html__("Read More", 'medcity'); ?><i class="fac fac-arrow-right text-12"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}
if(!function_exists('medcity_get_department_grid_layout1')){
    function medcity_get_department_grid_layout1($posts = [], $settings = []){
        extract($settings);
        if($thumbnail_size != 'custom' && $thumbnail_size != 'full'){
            $img_size = $thumbnail_size;
        }
        elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
            $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
        }
        else{
            $img_size = '370x275';
        }
        if (is_array($posts)):
            foreach ($posts as $post):
                $img_id = get_post_thumbnail_id($post->ID);
                $img = etc_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $img_size,
                    'class'      => '',
                ));
                $thumbnail = $img['thumbnail'];
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));
                $depart_icon = get_post_meta($post->ID, 'department_icon', true);
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false) ): ?>
                            <div class="entry-featured">
                                <a class="item-feauted" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="entry-body">
                            <h3 class="entry-title">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                            <?php if($show_excerpt == 'true'): ?>
                                <div class="entry-content">
                                    <?php
                                    if (!empty($post->post_excerpt)) {
                                        echo wp_trim_words($post->post_excerpt, $num_words, '.');
                                    } else {
                                        $content = strip_shortcodes($post->post_content);
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = wp_trim_words($content, $num_words, '&hellip;');
                                        echo wp_kses_post($content);
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php if($show_button == 'true'): ?>
                                <div class="entry-readmore">
                                    <a class="btn btn-outline-secondary" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr($button_text); ?> <i class="fac fac-arrow-right"></i></a>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}
function medcity_get_product_grid_layout1($posts = [], $settings = [])
{
    extract($settings);
    if($thumbnail_size != 'custom'){
        $img_size = $thumbnail_size;
    }
    elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
        $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
    }
    else{
        $img_size = 'full';
    }
    if (is_array($posts)):
        foreach ($posts as $post):
            $img_id = get_post_thumbnail_id($post->ID);
            $img = etc_get_image_by_size( array(
                'attach_id'  => $img_id,
                'thumb_size' => $img_size,
                'class'      => '',
            ));
            $thumbnail = $img['thumbnail'];
            $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            $filter_class = etc_get_term_of_post_to_class($post->ID, array_unique($tax));
            $product = wc_get_product( $post->ID );
            $regular_price = get_post_meta( $post->ID, '_regular_price', true);
            $sale_price = get_post_meta( $post->ID, '_sale_price', true);
            $product_sale = '';
            ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="grid-item-inner woocommerce-product-inner">
                    <?php
                    if(!empty($sale_price) && $product->is_on_sale()) {
                        $product_sale = intval( ( (intval($regular_price) - intval($sale_price)) / intval($regular_price) ) * 100);
                        echo '<span class="onsale">'.$product_sale.'%</span>';
                    }
                    ?>
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                        <div class="item-featured woocommerce-product-header">
                            <a class="woocommerce-product-details" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                <?php echo wp_kses_post($thumbnail); ?>
                            </a>
                            <div class="woocommerce-product-meta">
                                <div class="woocommerce-add-to-cart">
                                    <?php
                                    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button ajax_add_to_cart %s product_type_%s">%s</a>',
                                            esc_url( $product->add_to_cart_url() ),
                                            esc_attr( $product->get_id() ),
                                            esc_attr( $product->get_sku() ),
                                            $product->is_purchasable() ? 'add_to_cart_button' : '',
                                            esc_attr( $product->get_type() ),
                                            esc_html( $product->add_to_cart_text() )
                                        ),
                                        $product );
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="woocommerce-product-holder">
                        <h3 class="woocommerce-product-title">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                        </h3>
                        <span class="price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
    endif;
}

if(!function_exists('medcity_get_post_grid')){
    function medcity_get_post_grid($posts = [], $settings = []){
        if (empty($posts) || !is_array($posts) || empty($settings) || !is_array($settings)) {
            return false;
        }
        switch ($settings['template_type']) {
            case 'post_grid_layout1':
                medcity_get_post_grid_layout1($posts, $settings);
                break;

            case 'doctor_grid_layout1':
                medcity_get_doctor_grid_layout1($posts, $settings);
                break;

            case 'doctor_grid_layout2':
                medcity_get_doctor_grid_layout2($posts, $settings);
                break;

            case 'doctor_grid_layout3':
                medcity_get_doctor_grid_layout3($posts, $settings);
                break;

            case 'service_grid_layout1':
                medcity_get_service_grid_layout1($posts, $settings);
                break;
            case 'service_grid_layout4':
                /** 
                 * @since 1.1.1
                 * @author Chinh Duong Manh
                **/
                medcity_get_service_grid_layout4($posts, $settings);
                break;
            case 'department_grid_layout1':
                medcity_get_department_grid_layout1($posts, $settings);
                break;
            case 'product_grid_layout1':
                medcity_get_product_grid_layout1($posts, $settings);
            default:
                return false;
                break;
        }
    }
}

add_action( 'wp_ajax_medcity_load_more_post_grid', 'medcity_load_more_post_grid' );
add_action( 'wp_ajax_nopriv_medcity_load_more_post_grid', 'medcity_load_more_post_grid' );
if(!function_exists('medcity_load_more_post_grid')){
    function medcity_load_more_post_grid(){
        try{
            if(!isset($_POST['settings'])){
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'medcity'));
            }
            $settings = $_POST['settings'];
            set_query_var('paged', $settings['paged']);
            extract(etc_get_posts_of_grid($settings['posttype'], [
                'source' => isset($settings['source'])?$settings['source']:'',
                'orderby' => isset($settings['orderby'])?$settings['orderby']:'date',
                'order' => isset($settings['order'])?$settings['order']:'desc',
                'limit' => isset($settings['limit'])?$settings['limit']:'6',
                'post_ids' => '',
            ]));
            if(!isset($settings['tax']) || empty($settings['tax'])){
                $settings['tax'] = [];
            }
            ob_start();
            medcity_get_post_grid($posts, $settings);
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_html__('Load Successfully!', 'medcity'),
                    'data' => array(
                        'html' => $html,
                        'paged' => $settings['paged'],
                        'posts' => $posts,
                        'max' => $max,
                    ),
                )
            );
        }
        catch (Exception $e){
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}

/**
* Display navigation to next/previous post when applicable.
*/
function medcity_post_nav_default() {
    global $post;
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    $archive_url = medcity_get_opt( 'single_archive_url', '' );
    if (empty($archive_url)){
        $archive_url = get_post_type_archive_link('doctor');
    }

    if( !empty($next_post) || !empty($previous_post) ) { ?>
        <div class="nav-links">
            <div class="nav-item nav-post-prev <?php if(empty($previous_post)) { echo esc_attr('invisible'); } ?>">
                <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') {
                    $prev_img_id = get_post_thumbnail_id($previous_post->ID);
                    $prev_img_url = wp_get_attachment_image_src($prev_img_id);
                    if(!empty($prev_img_id)) : ?>
                        <div class="nav-post-img">
                            <a  href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>">
                                <span class="bg-image" style="background-image: url('<?php echo esc_url($prev_img_url[0]); ?>');"></span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="nav-post-meta">
                        <label><?php echo esc_html__('Previous Post', 'medcity'); ?></label>
                        <a  href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>">
                            <?php echo get_the_title( $previous_post->ID ); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="nav-item nav-post-next <?php if(empty($next_post)) { echo esc_attr('invisible'); } ?>">
                <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') {
                    $next_img_id = get_post_thumbnail_id($next_post->ID);
                    $next_img_url = wp_get_attachment_image_src($next_img_id);
                    if(!empty($next_img_id)) : ?>
                        <div class="nav-post-img">
                            <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>">
                                <span class="bg-image" style="background-image: url('<?php echo esc_url($next_img_url[0]); ?>');"></span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="nav-post-meta">
                        <label><?php echo esc_html__('Next Post', 'medcity'); ?></label>
                        <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo get_the_title( $next_post->ID ); ?></a>
                    </div>
                <?php } ?>
            </div>
        </div><!-- .nav-links -->
    <?php }
}
/**
 * Custom Widget Archive Counts
 */
add_filter('wp_list_categories', 'medcity_cat_count_span');
function medcity_cat_count_span($output) {
    $dir = is_rtl() ? 'left' : 'right';
    $output = str_replace("\t", '', $output);
    $output = str_replace("\n</li>", '</li>', $output);
    $output = str_replace('</a> (', '<span class="count '.$dir.'">(', $output);
    $output = str_replace(")</li>", ')</span></a></li>', $output);
    $output = str_replace("(", '', $output);
    $output = str_replace(")", '', $output);
    return $output;
}
// For shop with other structure
add_filter('wp_list_categories', 'medcity_wc_cat_count_span');
function medcity_wc_cat_count_span($links) {
    $dir = is_rtl() ? 'left' : 'right';
    $links = str_replace('</a> <span class="count">', ' <span class="count '.$dir.'">', $links);
    $links = str_replace('</span>', '</span></a>', $links);
    return $links;
}

/**
 * Change Footer layout
 * 
 * @since 1.1.1
 * @author Chinh Duong Manh
 * **/
function medcity_elementor_footer()
{
    $footer_layout_custom = medcity_get_opt('footer_layout_custom');
    $custom_footer = medcity_get_page_opt('custom_footer', 'false');
    $footer_layout_page = medcity_get_page_opt('footer_layout');
    $footer_layout_custom_page = medcity_get_page_opt('footer_layout_custom');
    if( $custom_footer && $footer_layout_page == 'custom' && !empty($footer_layout_custom_page) ) {
        $footer_layout_custom = $footer_layout_custom_page;
    }
    if(!empty($footer_layout_custom)){
        ?>
        <footer id="site-footer-elementor" class="site-footer-elementor">
            <?php
            $cms_post = get_post($footer_layout_custom);
            if (!is_wp_error($cms_post) && $cms_post->ID == $footer_layout_custom && class_exists('Elementor_Theme_Core') && function_exists('etc_print_html')){
                $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $footer_layout_custom );
                etc_print_html($content);
            }
            ?>
        </footer>
        <?php
    } else {
    ?>
        <footer id="colophon" class="site-footer-default">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="default-copyright">
                            <?php
                            echo esc_html('Copyright &copy;'.' '.esc_html(date("Y"))).esc_html('&nbsp;').'<a target="_blank" href="https://themeforest.net/user/7oroof/portfolio">7oroof</a>'.esc_html('&nbsp;All Rights Reserved');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php
    }
}


/**
 * SVgs Icon
 * @since 1.1.1
 * @author Chinh Duong Manh
 * **/
function medcity_svgs_icon_render( $args = []){
    $args = wp_parse_args($args, [
        'icon' => 'widgets',
        'echo' => false,
        'before' => '',
        'after'  => ''
    ]);
    $defaults = [
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 18 20" width="512" height="568"><path fill-rule="evenodd" d="M4.000,8.997 L8.999,8.997 L8.999,13.997 L4.000,13.997 L4.000,8.997 ZM16.000,17.996 L2.000,17.996 L2.000,6.998 L16.000,6.998 L16.000,17.996 ZM16.000,1.997 L14.999,1.997 L14.999,-0.003 L12.999,-0.003 L12.999,1.997 L5.000,1.997 L5.000,-0.003 L3.000,-0.003 L3.000,1.997 L2.000,1.997 C0.890,1.997 0.010,2.897 0.010,3.997 L-0.000,17.996 C-0.000,19.097 0.890,19.997 2.000,19.997 L16.000,19.997 C17.100,19.997 18.000,19.097 18.000,17.996 L18.000,3.997 C18.000,2.897 17.100,1.997 16.000,1.997 Z"/></svg>',
        'clock' => '<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16" width="512" height="512"><path fill-rule="evenodd" d="M11.359,11.354 L7.200,8.795 L7.200,3.995 L8.399,3.995 L8.399,8.155 L12.000,10.314 L11.359,11.354 ZM7.999,-0.006 C3.599,-0.006 0.000,3.595 0.000,7.994 C0.000,12.395 3.599,15.994 7.999,15.994 C12.400,15.994 16.000,12.395 16.000,7.994 C16.000,3.595 12.400,-0.006 7.999,-0.006 Z"/></svg>',
        'label' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 20" width="512" height="640"><path fill-rule="evenodd" d="M2.000,1.998 L7.000,1.998 L7.000,9.999 L4.499,8.499 L2.000,9.999 L2.000,1.998 ZM13.999,-0.001 L2.000,-0.001 C0.900,-0.001 0.000,0.899 0.000,1.998 L0.000,17.999 C0.000,19.099 0.900,19.999 2.000,19.999 L13.999,19.999 C15.100,19.999 16.000,19.099 16.000,17.999 L16.000,1.998 C16.000,0.899 15.100,-0.001 13.999,-0.001 Z"/></svg>',
        'mail' => '<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 16" width="640" height="512"><path fill-rule="evenodd" d="M18.000,3.999 L10.000,8.999 L2.000,3.999 L2.000,1.999 L10.000,6.999 L18.000,1.999 L18.000,3.999 ZM18.000,-0.002 L2.000,-0.002 C0.900,-0.002 0.010,0.899 0.010,1.999 L0.000,13.999 C0.000,15.099 0.900,15.999 2.000,15.999 L18.000,15.999 C19.100,15.999 20.000,15.099 20.000,13.999 L20.000,1.999 C20.000,0.899 19.100,-0.002 18.000,-0.002 Z"/></svg>',
        'phone' => '<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 17 16" width="512" height="482"><path fill-rule="evenodd" d="M5.155,10.491 C7.669,13.595 13.793,16.569 15.271,15.900 C16.366,15.420 17.054,14.315 17.002,13.121 C16.939,12.453 13.581,10.406 12.737,10.017 C11.891,9.628 10.921,10.879 10.456,11.418 C9.970,11.934 8.112,10.362 7.309,9.564 C7.309,9.564 5.197,7.150 5.683,6.633 C6.168,6.116 7.372,5.083 6.950,4.241 C6.527,3.398 4.394,0.041 3.719,-0.006 C2.531,-0.001 1.474,0.749 1.078,1.869 C0.487,3.400 3.317,9.241 6.464,11.677 "/></svg>',
        'user'  => '<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16" width="512" height="512"><path fill-rule="evenodd" d="M8.000,9.999 C5.330,9.999 -0.000,11.339 -0.000,13.999 L-0.000,15.999 L16.000,15.999 L16.000,13.999 C16.000,11.339 10.670,9.999 8.000,9.999 ZM8.000,7.999 C10.210,7.999 12.000,6.208 12.000,3.999 C12.000,1.789 10.210,-0.001 8.000,-0.001 C5.789,-0.001 4.000,1.789 4.000,3.999 C4.000,6.208 5.789,7.999 8.000,7.999 Z"/></svg>',
        'widgets' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 21 21" width="512" height="512"><path fill-rule="evenodd" d="M18.500,9.999 L17.000,9.999 L17.000,5.999 C17.000,4.899 16.100,3.998 14.999,3.998 L11.000,3.998 L11.000,2.500 C11.000,1.119 9.880,-0.002 8.500,-0.002 C7.120,-0.002 6.000,1.119 6.000,2.500 L6.000,3.998 L2.000,3.998 C0.900,3.998 0.010,4.899 0.010,5.999 L0.010,9.798 L1.500,9.798 C2.990,9.798 4.200,11.009 4.200,12.498 C4.200,13.989 2.990,15.198 1.500,15.198 L0.000,15.198 L0.000,18.998 C0.000,20.099 0.900,20.999 2.000,20.999 L5.800,20.999 L5.800,19.499 C5.800,18.009 7.010,16.799 8.500,16.799 C9.990,16.799 11.199,18.009 11.199,19.499 L11.199,20.999 L14.999,20.999 C16.100,20.999 17.000,20.099 17.000,18.998 L17.000,14.999 L18.500,14.999 C19.880,14.999 21.000,13.878 21.000,12.498 C21.000,11.119 19.880,9.999 18.500,9.999 Z"/></svg>',
        'circle-chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM135 241c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l87 87 87-87c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L273 345c-9.4 9.4-24.6 9.4-33.9 0L135 241z"/></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 10" width="600" height="500"><path fill-rule="evenodd" d="M11.892,5.337 C11.857,5.412 11.815,5.484 11.753,5.550 L7.773,9.735 C7.660,9.856 7.512,9.931 7.354,9.983 L6.626,9.983 C6.539,9.954 6.453,9.919 6.375,9.868 C5.946,9.578 5.876,9.051 6.220,8.691 L8.999,5.991 L8.999,3.989 L8.999,3.989 L8.999,5.988 L-0.001,5.989 L-0.001,3.988 L8.998,3.988 L6.220,1.364 C5.876,1.003 5.946,0.476 6.375,0.188 C6.803,-0.101 7.430,-0.043 7.773,0.318 L11.509,4.248 C11.804,4.393 12.011,4.652 12.011,4.960 C12.011,5.098 11.962,5.222 11.892,5.337 Z"/></svg>',
        'arrow-up' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 13"><path d="M9.882,5.640 C9.593,6.068 9.065,6.138 8.705,5.795 L6.004,3.016 L6.003,3.016 L6.003,12.016 L4.003,12.016 L4.003,3.019 L1.379,5.795 C1.018,6.138 0.490,6.068 0.202,5.640 C-0.086,5.212 -0.028,4.585 0.332,4.241 L4.262,0.505 C4.408,0.211 4.667,0.003 4.975,0.003 C5.113,0.003 5.237,0.052 5.351,0.122 C5.426,0.158 5.499,0.200 5.564,0.262 L9.750,4.241 C9.870,4.355 9.946,4.503 9.997,4.661 L9.997,5.389 C9.967,5.476 9.934,5.562 9.882,5.640 Z"/></svg>',
        'arrow-next' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 45"><path fill-rule="evenodd" d="M20.986,22.234 L20.338,22.565 L20.473,22.635 L1.910,44.986 L1.209,44.626 L0.910,44.986 L0.014,44.525 L18.577,22.174 L18.718,22.246 L0.526,0.457 L1.422,-0.002 L1.722,0.357 L2.422,-0.002 L20.986,22.234 Z"/></svg>',
        'arrow-prev' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 45"><path fill-rule="evenodd" d="M2.423,22.174 L20.986,44.525 L20.090,44.986 L19.791,44.626 L19.090,44.986 L0.526,22.635 L0.662,22.565 L0.014,22.234 L18.577,-0.002 L19.278,0.357 L19.577,-0.002 L20.473,0.457 L2.281,22.246 L2.423,22.174 Z"/></svg>',
        'map' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 20"><path fill-rule="evenodd" d="M6.999,9.496 C5.620,9.496 4.501,8.375 4.501,6.997 C4.501,5.616 5.620,4.496 6.999,4.496 C8.380,4.496 9.500,5.616 9.500,6.997 C9.500,8.375 8.380,9.496 6.999,9.496 ZM6.999,-0.004 C3.130,-0.004 -0.002,3.126 -0.002,6.997 C-0.002,12.246 6.999,19.996 6.999,19.996 C6.999,19.996 13.999,12.246 13.999,6.997 C13.999,3.126 10.869,-0.004 6.999,-0.004 Z"/></svg>',
        'page' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 20" width="512px" height="640px"><path fill-rule="evenodd" d="M9.000,6.999 L9.000,1.498 L14.500,6.999 L9.000,6.999 ZM12.000,11.999 L4.000,11.999 L4.000,9.999 L12.000,9.999 L12.000,11.999 ZM12.000,15.999 L4.000,15.999 L4.000,14.000 L12.000,14.000 L12.000,15.999 ZM10.000,-0.001 L2.000,-0.001 C0.900,-0.001 0.011,0.899 0.011,2.000 L0.000,17.999 C0.000,19.099 0.890,19.999 1.990,19.999 L14.000,19.999 C15.101,19.999 15.999,19.099 15.999,17.999 L15.999,5.999 L10.000,-0.001 Z"/></svg>',
        'quote' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 13"><path fill-rule="evenodd" d="M18.046,8.794 C18.046,11.017 16.296,12.830 14.112,12.830 C11.985,12.830 10.319,11.144 10.152,8.820 C9.869,4.862 11.830,1.631 13.594,0.068 C13.647,0.022 13.712,-0.002 13.777,-0.002 C13.845,-0.002 13.912,0.022 13.965,0.070 C14.122,0.217 14.230,0.329 14.466,0.573 C14.645,0.759 14.901,1.024 15.313,1.444 C15.409,1.541 15.422,1.693 15.346,1.806 C14.333,3.304 14.306,4.379 14.342,4.774 C16.419,4.896 18.047,6.649 18.046,8.794 ZM3.987,12.830 C1.860,12.830 0.194,11.144 0.028,8.820 C-0.256,4.862 1.705,1.631 3.469,0.068 C3.522,0.022 3.587,-0.002 3.653,-0.002 C3.720,-0.002 3.787,0.022 3.840,0.070 C3.998,0.217 4.105,0.329 4.341,0.573 C4.520,0.759 4.776,1.024 5.188,1.444 C5.284,1.541 5.297,1.693 5.221,1.806 C4.208,3.304 4.181,4.379 4.217,4.774 C6.294,4.896 7.922,6.649 7.921,8.794 C7.921,11.017 6.171,12.830 3.987,12.830 Z"/></svg>'
    ];
    $icons = apply_filters('medcity_svgs_icon_render', $defaults);
    // html
    if($args['echo']){
        printf('%1$s%2$s%3$s', $args['before'], $icons[$args['icon']], $args['after']);
    } else {
        return $args['before'].$icons[$args['icon']].$args['after'];
    }
}