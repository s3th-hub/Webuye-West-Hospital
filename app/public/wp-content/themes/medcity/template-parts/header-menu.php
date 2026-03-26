<?php
/**
 * Template part for displaying the primary menu of the site
 */

$menu_icon = '';
$menu_highlight = medcity_get_opt( 'menu_highlight_on', false );
if ( $menu_highlight  ){
    $menu_icon = '<span class="menu-icon"></span>';
}
$custom_main_menu = medcity_get_page_opt( 'custom_main_menu', false );
$main_menu_select = medcity_get_page_opt( 'main_menu_select' );

if ( has_nav_menu( 'primary' ) )
{

    if ($custom_main_menu && !empty($main_menu_select) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu' => $main_menu_select,
            'menu_id' => 'mastmenu',
            'container'  => '',
            'menu_class' => 'primary-menu clearfix',
            'before'               => "",
            'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
        ) );
    }else{
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'  => '',
            'menu_id'    => 'mastmenu',
            'menu_class' => 'primary-menu clearfix',
            'before'               => "",
            'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
        ) );
    }
}
else
{
    printf(
        '<ul class="primary-menu-not-set"><li><a href="%1$s">%2$s</a></li></ul>',
        esc_url( admin_url( 'nav-menus.php' ) ),
        esc_html__( 'Create New Menu', 'medcity' )
    );
}