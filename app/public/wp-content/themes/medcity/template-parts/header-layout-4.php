<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = medcity_get_opt( 'sticky_on', false );
$search_on = medcity_get_opt( 'search_on', false );
$cart_on = medcity_get_opt( 'cart_on', false );
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
$phone_label = medcity_get_opt( 'phone_label' );
$phone_number = medcity_get_opt( 'phone_number' );
$phone_result = preg_replace('#[ () ]*#', '', $phone_number);
$phone_number_menu = medcity_get_opt( 'phone_number_menu' );
if (!empty($phone_number_menu)){
    $phone_number = $phone_number_menu;
}
$location_label = medcity_get_opt( 'location_label' );
$location_text = medcity_get_opt( 'location_text' );
$location_link = medcity_get_opt( 'location_link' );
$time_label = medcity_get_opt( 'time_label' );
$time = medcity_get_opt( 'time' );

$note_text = medcity_get_opt( 'note_text' );

?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout4 fixed-height <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
        <div class="site-header-top">
            <div class="container">
                <div class="row">
                    <div class="header-top-left">
                        <div class="header-note-text">
                            <?php if(!empty($note_text)) : ?>
                                <?php echo wp_kses_post($note_text); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="header-top-right">
                        <?php if(!empty($phone_number)) : ?>
                            <div class="header-top-item">
                                <i class="fas fac-phone"></i>
                                <div class="header-top-item-inner">
                                    <span><?php echo esc_html($phone_label); ?></span>
                                    <a href="tel:<?php echo esc_attr($phone_result); ?>"><?php echo esc_html($phone_number); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($location_text)) : ?>
                            <div class="header-top-item">
                                <i class="fas fac-map-marker-alt"></i>
                                <div class="header-top-item-inner">
                                    <span><?php echo esc_html($location_label); ?></span>
                                    <a href="<?php echo esc_attr($location_link); ?>" target="_blank"><?php echo esc_html($location_text); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($time)) : ?>
                            <div class="header-top-item">
                                <i class="fas fac-clock"></i>
                                <div class="header-top-item-inner">
                                    <span><?php echo esc_attr($time_label); ?></span>
                                    <span><?php echo esc_attr($time); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
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
                                <?php if($h_btn_on == 'show') : ?>
                                    <div class="site-header-item site-header-button">
                                        <a class="btn" href="<?php echo esc_url($h_btn_url); ?>" target="<?php echo esc_attr($h_btn_target); ?>" data-title="<?php echo esc_attr($h_btn_text); ?>">
                                            <?php echo wp_kses_post($h_btn_text); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if($search_on) : ?>
                                    <div class="site-header-item site-header-search">
                                        <span class="h-btn-search"><i class="far fa-search"></i></span>
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