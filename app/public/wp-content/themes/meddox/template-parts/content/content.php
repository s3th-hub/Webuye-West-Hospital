<?php
/**
 * Template Name: Blog Classic
 * @package Bravis-Themes
 */
$archive_readmore_text = meddox()->get_theme_opt('archive_readmore_text', esc_html__('Read More', 'meddox'));
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('pxl-item--post pxl-item--archive'); ?>>
    <div class="pxl-item--holder">
        <?php  
        $images_size = !empty($img_size) ? $img_size : 'full';
        $img_id = get_post_thumbnail_id($post->ID);
        $thumbnail = get_the_post_thumbnail($post->ID, $images_size);
        ?>
        <?php meddox()->blog->get_archive_meta(); ?>

        <h2 class="pxl-item--title">
            <a href="<?php echo esc_url( get_permalink()); ?>" title="<?php the_title_attribute(); ?>">
                <?php if(is_sticky()) { ?>
                    <i class="fa fa-thumb-tack"></i>
                <?php } ?>
                <?php the_title(); ?>
            </a>
        </h2>
        <?php meddox()->blog->get_archive_author(); ?>
        
        <div class="pxl-item--excerpt">
            <?php
            meddox()->blog->get_excerpt();
            wp_link_pages( array(
                'before'      => '<div class="page-links">',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) );
            ?>
        </div>
        <div class="pxl-item--readmore ">
            <a class="btn-readmore" href="<?php echo esc_url( get_permalink()); ?>">
                <?php echo meddox_html($archive_readmore_text); ?>
            </a>
        </div>
    </div>

    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
    <div class="pxl-item--image hover-imge-effect2">
        <div class="wrap-feature" <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) { $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?> style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);"<?php } ?>>
            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" ></a>
        </div>
    </div>
<?php endif; ?>
</article>