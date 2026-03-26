<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets.
 *
 * @package Bravis-Themes
 * @since meddox 1.0
 */

if(!defined('THEME_DEV_MODE_ELEMENTS') && is_user_logged_in()){
    define('THEME_DEV_MODE_ELEMENTS', true);
}

if(!defined('DEV_MODE')){define('DEV_MODE', true);}
 
require_once get_template_directory() . '/inc/classes/class-main.php';

if ( is_admin() ){ 
	require_once get_template_directory() . '/inc/admin/admin-init.php'; 
}

/**
 * Theme Require
*/
meddox()->require_folder('inc');
meddox()->require_folder('inc/classes');
meddox()->require_folder('inc/theme-options');
meddox()->require_folder('template-parts/widgets');
if(class_exists('Woocommerce')){
    meddox()->require_folder('woocommerce');
}

