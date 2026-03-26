<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Medcity
 */
$heading_404_page = medcity_get_opt( 'heading_404_page' );
$content_404_page = medcity_get_opt( 'content_404_page' );
$btn_text_404_page = medcity_get_opt( 'btn_text_404_page' );
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="row">
                <div class="col-12">
                    <section class="error-404 bg-overlay bg-image">
                        <div class="error-404-inner">
                            <header>
                                <h1>404</h1>
                            </header><!-- .page-title -->
                            <h2 class="page-heading">
                                <?php if(!empty($heading_404_page)) {
                                    echo wp_kses_post($heading_404_page);
                                } else {
                                    echo esc_html__("Oops! That page can’t be found.", 'medcity');
                                } ?>
                            </h2>
                            <div class="page-content">
                                <?php if(!empty($content_404_page)) {
                                    echo wp_kses_post($content_404_page);
                                } else {
                                    echo esc_html__("The page requested couldn't be found. This could be a spelling error in the URL or a removed page.", 'medcity');
                                } ?>
                            </div><!-- .page-content -->
                            <a class="btn btn-default" href="<?php echo esc_url(home_url('/')); ?>">
                                <?php if(!empty($btn_text_404_page)) {
                                    echo wp_kses_post($btn_text_404_page);
                                } else {
                                    echo esc_html__('Back To Home', 'medcity');
                                } ?>
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </section><!-- .error-404 -->
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
