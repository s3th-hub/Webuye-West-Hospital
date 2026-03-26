<?php
/**
 * @package Bravis-Themes
 */
$archive_readmore_text = meddox()->get_theme_opt( 'archive_readmore_text', esc_html__('Read more', 'meddox') );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('pxl-item--post pxl-item--archive'); ?>>
    
    <?php if (has_post_thumbnail()) {
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
        echo '<div class="entry-featured pxl-item--image">'; ?>
            <a href="<?php echo esc_url( get_permalink()); ?>"><?php the_post_thumbnail('pxl-large'); ?></a>
        <?php echo '</div>';
    } ?>
    <div class="entry-body pxl-item--holder">
        <?php meddox()->blog->get_archive_meta();?>
        <h2 class="entry-title pxl-item--title">
            <a href="<?php echo esc_url( get_permalink()); ?>" title="<?php the_title_attribute(); ?>">
                <?php if(is_sticky()) { ?>
                    <i class="caseicon-tick"></i>
                <?php } ?>
                <?php the_title(); ?>
            </a>
        </h2>
        <div class="entry-excerpt pxl-item--excerpt">
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
            <a class="btn-readmore pxl-btn-effect4" href="<?php echo esc_url( get_permalink()); ?>">
                <?php echo meddox_html($archive_readmore_text); ?>
            </a>
        </div>
    </div>
</article><!-- #post -->