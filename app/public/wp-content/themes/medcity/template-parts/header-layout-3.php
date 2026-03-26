<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = medcity_get_opt( 'sticky_on', false );
$search_on = medcity_get_opt( 'search_on', false );
$h_btn_on = medcity_get_opt( 'h_btn_on', 'hide' );

$h_btn_text = medcity_get_opt( 'h_btn_text' );
$h_btn_link_type = medcity_get_opt( 'h_btn_link_type', 'page' );
$h_btn_link = medcity_get_opt( 'h_btn_link' );
$h_btn_link_custom = medcity_get_opt( 'h_btn_link_custom' );
$h_btn_target = medcity_get_opt( 'h_btn_target', '_self' );
if($h_btn_link_type == 'page') {
    $h_btn_url = get_permalink($h_btn_link);
} else {
    $h_btn_url = $h_btn_link_custom;
}

$note_text_close = medcity_get_opt( 'note_text_close' );
$header_top_cookie = medcity_get_cookie('header_top_visible');

?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout3 fixed-height <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
        <?php
        if ($header_top_cookie != 'no'){
            ?>
            <div class="site-header-top cms-toggle-target">
                <div class="container">
                    <div class="row">
                        <div class="header-top-inner">
                            <?php if(!empty($note_text_close)) : ?>
                                <?php echo wp_kses_post($note_text_close); ?>
                            <?php endif; ?>
                        </div>
                        <span class="cms-toggle-close"><i class="material zmdi zmdi-close"></i></span>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div id="site-header" class="site-header-main">
            <div class="container">
                <div class="row">
                    <div class="site-branding">
                        <?php get_template_part( 'template-parts/header-branding' ); ?>
                    </div>
                    <div class="site-navigation">
                        <nav class="main-navigation">
                            <?php get_template_part( 'template-parts/header-menu' ); ?>
                        </nav>
                        <?php
                        if (($h_btn_on == 'show') || $search_on ){
                            ?>
                            <div class="site-tool">
                                <?php if($search_on) : ?>
                                    <div class="site-header-item site-header-search">
                                        <span class="h-btn-search"><i class="fa fa-search"></i></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($h_btn_on == 'show') : ?>
                                    <div class="site-header-item site-header-button">
                                        <a class="btn" href="<?php echo esc_url($h_btn_url); ?>" target="<?php echo esc_attr($h_btn_target); ?>" data-title="<?php echo esc_attr($h_btn_text); ?>">
                                            <?php echo wp_kses_post($h_btn_text); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="main-menu-mobile">
                <span class="btn-nav-mobile open-menu">
                    <span></span>
                </span>
            </div>
        </div>
    </div>
</header>