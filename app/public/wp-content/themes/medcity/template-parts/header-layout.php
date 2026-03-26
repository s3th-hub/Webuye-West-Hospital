<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = medcity_get_opt( 'sticky_on', false );
$search_on = medcity_get_opt( 'search_on', false );
$cart_on = medcity_get_opt( 'cart_on', false );
$h_btn_on = medcity_get_opt( 'h_btn_on', 'hide' );
// Emergency Sidebar
$emergency_on = medcity_get_opt( 'emergency_on', false );
$emergency_text = medcity_get_opt( 'emergency_text', '' );

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
$location_label = medcity_get_opt( 'location_label' );
$location_text = medcity_get_opt( 'location_text' );
$location_link = medcity_get_opt( 'location_link' );
$time_label = medcity_get_opt( 'time_label' );
$time = medcity_get_opt( 'time' );
// Highlight menu
$menu_highlight = medcity_get_opt( 'menu_highlight_on', false );
$menu_highlight_select = "";
if ( $menu_highlight  ){
    $menu_highlight_select = medcity_get_opt( 'hl_menu_select' );
    $menu_object = wp_get_nav_menu_object( $menu_highlight_select );
    $menu_name = "";
    if (!empty($menu_object->name)){
        $menu_name = $menu_object->name;
    }
}
$menu_name_url = medcity_get_opt( 'menu_name_url' );
if (empty($menu_name_url)){
    $menu_name_url = "#";
}
?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout1 fixed-height <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
        <div class="site-header-top">
            <div class="container">
                <div class="row">
                    <div class="header-top-left">
                        <?php if(!empty($emergency_on)) : ?>
                            <div class="emergency-wrap">
                                <?php
                                if(is_active_sidebar('sidebar-emergency')) {
                                    ?>
                                    <span class="h-emergency cms-toggle-active"><?php echo esc_html($emergency_text);?></span>
                                    <div class="emergency-content cms-target-active">
                                        <div class="sidebar-widget">
                                            <?php dynamic_sidebar( 'sidebar-emergency' ); ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php endif; ?>
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
                        <?php
                        if ($search_on){
                            ?>
                            <div class="site-header-search">
                                <?php get_search_form(); ?>
                            </div>
                            <?php
                        }
                        ?>
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
                        <div class="site-main">
                            <nav class="main-navigation">
                                <?php get_template_part( 'template-parts/header-menu' ); ?>
                            </nav>
                        </div>
                        <?php if(class_exists('Woocommerce')){
                            if($cart_on){ ?>
                                <div class="cart-icon-wrap">
                                    <div class="cart-desktop icon-wrap">
                                        <a href="#" class="open-cart">
                                            <span class="cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
                                            <i class="fas fac-cart-plus"></i>
                                        </a>
                                        <div class="widget_shopping_cart_content">
                                            <?php woocommerce_mini_cart(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if(!empty($menu_highlight_select)) : ?>
                            <nav class="main-navigation">
                                <ul class="primary-menu clearfix">
                                    <li class="highlight-menu-wrap menu-item-has-children">
                                        <div class="menu-icon-wrap"><span class="menu-icon"></span></div>
                                        <a href="<?php echo esc_url($menu_name_url);?>" target="_self" class="menu-name"><?php echo esc_html($menu_name);?></a>
                                        <?php
                                        wp_nav_menu( array(
                                            'menu' => $menu_highlight_select,
                                            'container'  => '',
                                            'menu_class' => 'sub-menu clearfix',
                                            'before'               => "",
                                            'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                        ) );
                                        ?>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                        <?php
                        if (($h_btn_on == 'show')){
                            ?>
                            <div class="site-tool">
                                <?php if($h_btn_on == 'show') : ?>
                                    <div class="site-header-item site-header-button">
                                        <a class="btn" href="<?php echo esc_url($h_btn_url); ?>" target="<?php echo esc_attr($h_btn_target); ?>">
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
