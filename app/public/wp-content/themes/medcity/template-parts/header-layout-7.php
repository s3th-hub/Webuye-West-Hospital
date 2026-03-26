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

$short_link1 = medcity_get_opt( 'short_link1' );
$short_link2 = medcity_get_opt( 'short_link2' );

// Language
$language_switch = medcity_get_opt( 'language_switch', false );
?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout2 header-layout6 header-7 fixed-height <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
        <div class="site-header-top">
            <div class="container">
                <div class="row">
                    <div class="header-top-left">
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
                    <div class="header-top-right">
                        <div class="site-header-social">
                            <?php medcity_social_media(); ?>
                        </div>
                        <div class="header-short-link">
                            <?php if (!empty($short_link1)){
                                ?> <div class="link-item"><?php echo wp_kses_post($short_link1); ?></div><?php
                            }?>
                            <?php if (!empty($short_link2)){
                                ?> <div class="link-item"><?php echo wp_kses_post($short_link2); ?></div><?php
                            }?>
                        </div>
                        <?php if($language_switch) : ?>
                            <?php if(class_exists('SitePress')) { ?>
                                <div class="site-header-item site-header-lang">
                                    <?php do_action('wpml_add_language_selector'); ?>
                                </div>
                            <?php } else {
                                wp_enqueue_style('wpml-style', get_template_directory_uri() . '/assets/css/style-lang.css', array(), '1.0.0');
                                ?>
                                <div class="site-header-item site-header-lang custom">
                                    <div class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown">
                                        <ul>
                                            <li tabindex="0" class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-dropdown">
                                                <a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle"><img class="wpml-ls-flag" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/flag/en.png'); ?>" alt="en" title="English"><span class="wpml-ls-native"><?php echo esc_html__('English', 'medcity'); ?></span></a>
                                                <ul class="wpml-ls-sub-menu">
                                                    <li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-fr">
                                                        <a href="#" class="wpml-ls-link"><img class="wpml-ls-flag" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/flag/fr.png'); ?>" alt="fr" title="France"><span class="wpml-ls-native"><?php echo esc_html__('France', 'medcity'); ?></span></a>
                                                    </li>
                                                    <li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-de wpml-ls-last-item">
                                                        <a href="#" class="wpml-ls-link"><img class="wpml-ls-flag" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/flag/it.png'); ?>" alt="it" title="Italy"><span class="wpml-ls-native"><?php echo esc_html__('Italy', 'medcity'); ?></span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
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
                        <nav class="main-navigation d-flex justify-content-center flex-basic">
                            <?php get_template_part( 'template-parts/header-menu' ); ?>
                        </nav>
                        <?php
                        if (($h_btn_on == 'show') || (!empty($phone_number)) ){
                            ?>
                            <div class="site-tool">
                                <?php if(!empty($phone_number)) : ?>
                                    <div class="site-header-item site-header-phone custom header-7">
                                        <i class="fas fac-phone"></i>
                                        <a href="tel:<?php echo esc_attr($phone_result); ?>" class="text-hover-primary"><?php echo esc_html($phone_number); ?></a>
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