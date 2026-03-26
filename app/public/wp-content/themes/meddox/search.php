<?php
/**
 *
 * @package Bravis-Themes
 */
get_header();
$meddox_sidebar_pos = meddox()->get_theme_opt( 'blog_sidebar_pos', 'right' );
$meddox_sidebar = meddox()->get_sidebar_args(['type' => 'blog', 'content_col'=> '8']); // type: blog, post, page, shop, product
?>
<div class="container">

    <div class="row <?php echo esc_attr($meddox_sidebar['wrap_class']) ?>">
        <section id="pxl-content-area" class="<?php echo esc_attr($meddox_sidebar['content_class']) ?>">
            <main id="pxl-content-main">
                <?php if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();
                        get_template_part( 'template-parts/content/content-search' );
                    }
                    meddox()->page->get_pagination();
                } else {
                    get_template_part( 'template-parts/content/content', 'none' );
                } ?>
            </main>
        </section>
        <?php if ($meddox_sidebar['sidebar_class']) : ?>
            <div id="pxl-sidebar-area" class="<?php echo esc_attr($meddox_sidebar['sidebar_class']) ?>">
                <div class="pxl-sidebar-sticky">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php get_footer();
