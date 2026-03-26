<?php
/**
 * @package Bravis-Themes
 */
get_header();?>
<div class="container">
    <div class="row content-row">
        <div id="pxl-content-area" class="pxl-content-area col-12">
            <main id="pxl-content-main">
                <div class="wrap-content-404">
                    <div class="pxl-error-inner">
                        <h3 class="pxl-error-title">
                            <?php echo esc_html__('404', 'meddox'); ?>
                        </h3>
                        <div class="error-404-desc">
                            <?php echo esc_html__("The page you are looking is not available or has been removed. Try going to Home Page by using the button below.", "meddox"); ?>
                        </div>
                        <a class="btn btn-primary" href="<?php echo esc_url(home_url('/')); ?>">
                            <?php echo esc_html__('Go Back To Homepage', 'meddox'); ?>
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<?php
get_footer();