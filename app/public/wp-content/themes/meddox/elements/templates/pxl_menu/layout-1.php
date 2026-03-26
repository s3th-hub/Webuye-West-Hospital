<?php
$p_menu = meddox()->get_page_opt('p_menu');
if(!empty($p_menu)) {
    $menu = $p_menu;
}
else {
    $menu = $settings['menu'];
}
if(!empty($menu)) { ?>
    <div class="pxl-nav-menu pxl-nav-menu1 <?php echo esc_attr($settings['hover_active_style'].' '.$settings['divider_position'].' '.$settings['style']); ?> sub-<?php echo esc_attr($settings['hover_active_style_sub']); ?>">
        <?php wp_nav_menu(array(
            'menu_class' => 'pxl-menu-primary clearfix',
            'walker'     => class_exists( 'PXL_Mega_Menu_Walker' ) ? new PXL_Mega_Menu_Walker : '',
            'link_before'     => '',
            'link_after'      => '<i class="flaticon_meddox2 flaticon_meddox2-plus pxl-hide"></i>',
            'menu'        => wp_get_nav_menu_object($menu))
        ); ?>
    </div>
<?php } elseif( has_nav_menu( 'primary' ) ) { ?>
    <div class="pxl-nav-menu pxl-nav-menu1 <?php echo esc_attr($settings['hover_active_style']); ?>">
        <?php $attr_menu = array(
            'theme_location' => 'primary',
            'menu_class' => 'pxl-menu-primary clearfix',
            'link_before'     => '',
            'link_after'      => '<i class="caseicon-angle-arrow-down  pxl-hide"></i>',
            'walker'         => class_exists( 'PXL_Mega_Menu_Walker' ) ? new PXL_Mega_Menu_Walker : '',
        );
        wp_nav_menu( $attr_menu ); ?>
    </div>
<?php } ?>