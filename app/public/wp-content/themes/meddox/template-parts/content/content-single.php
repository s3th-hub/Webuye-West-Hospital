<?php
/**
 * Template part for displaying posts in loop
 *
 * @package Bravis-Themes
 */
$post_tag = meddox()->get_theme_opt( 'post_tag', true );
$post_navigation = meddox()->get_theme_opt( 'post_navigation', false );
$post_social_share = meddox()->get_theme_opt( 'post_social_share', false );
$post_author_box_info = meddox()->get_theme_opt( 'post_author_box_info', false );
$post_category_on = meddox()->get_theme_opt( 'post_category_on', true );
$author_position = get_post_meta($post->ID, 'author_position', true);
$single_post_title_layout = meddox()->get_theme_opt('single_post_title_layout','0');
$post_custom_title  = meddox()->get_theme_opt('post_custom_title',esc_html__('Blog details', 'meddox'));
?>
<article id="pxl-post-<?php the_ID(); ?>" <?php post_class('pxl-item--post'); ?>>
    <?php if (has_post_thumbnail()) {
        echo '<div class="pxl-item--image">'; ?>
        <?php the_post_thumbnail('meddox-medium'); ?>
        <?php echo '</div>';
    } ?>
    <div class="pxl-item--holder">
        <?php meddox()->blog->get_post_metas(); ?>
        <?php if($single_post_title_layout == '1') : ?>        
            <h3 class="pxl-item--title"><?php echo esc_attr(get_the_title($post->ID)); ?></h3>
        <?php endif; ?>
        <div class="item-author">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 35 ); ?>
            <h3 class="author-name">
                <?php the_author_posts_link(); ?>
            </h3>
        </div>
        <div class="pxl-item--excerpt clearfix">
            <?php
            the_content();
            wp_link_pages( array(
                'before'      => '<div class="page-links">',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) );
            ?>
        </div>

    </div>

    <?php if($post_tag || $post_social_share ) :  ?>
        <div class="pxl--post-footer">
            <?php if($post_tag) { meddox()->blog->get_tagged_in(); } ?>
            <?php if($post_social_share) { meddox()->blog->get_socials_share(); } ?>
        </div>
    <?php endif; ?>
    <?php if($post_author_box_info) : ?>
        <div class="entry-author-info">
            <div class="image-author">
                 <?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
            </div>
            <div class="entry-author-meta">
                <h3 class="author-name">
                    <?php the_author_posts_link(); ?>
                </h3>
                <p class="author-position">Author</p>
                <div class="author-description">
                    <?php the_author_meta( 'description' ); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php  meddox()->blog->meddox_related_post();  ?>
    <?php if($post_navigation) { meddox()->blog->get_post_nav(); } ?>
</article><!-- #post -->