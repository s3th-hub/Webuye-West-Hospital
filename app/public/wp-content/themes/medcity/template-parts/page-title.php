<?php
$titles = medcity_get_page_titles();
$pagetitle = medcity_get_opt( 'pagetitle', 'show' );
$custom_pagetitle = medcity_get_page_opt( 'custom_pagetitle', 'themeoption');
if($custom_pagetitle != 'themeoption' && $custom_pagetitle != '' && !is_archive() && !is_search() ) {
    $pagetitle = $custom_pagetitle;
}
$breadcrumb = medcity_get_opt( 'breadcrumb_on', false );
$ptitle_content_align = medcity_get_opt( 'ptitle_content_align', 'center' );

if(is_404()) {
    return true;
}
if(class_exists('WooCommerce')) {
    if (is_shop()) {
        $ptitle_content_align = 'center';
    }
}

if($pagetitle == 'show') : ?>
    <div id="pagetitle" class="pagetitle">
        <div class="container">
            <div class="page-title-inner ptt-align-<?php echo esc_attr($ptitle_content_align);?>">
                <h1 class="page-title"><?php echo wp_kses_post( $titles['title'] ); ?></h1>
                <?php if($breadcrumb) : ?>
                    <?php medcity_breadcrumb(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


