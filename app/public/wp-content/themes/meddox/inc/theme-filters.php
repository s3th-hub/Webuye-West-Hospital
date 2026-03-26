<?php
/**
 * Filters hook for the theme
 *
 * @package Bravis-Themes
 */

/* Custom Classs - Body */
function meddox_body_gallery( $gallery ) {   

    if (class_exists('ReduxFramework')) {
        $gallery[] = ' pxl-redux-page';
    }

    $footer_fixed = meddox()->get_theme_opt('footer_fixed');
    if(isset($footer_fixed) && $footer_fixed) {
        $gallery[] = ' pxl-footer-fixed';
    }

    $theme_default = meddox()->get_theme_opt('theme_default');
    if(isset($theme_default['font-family']) && $theme_default['font-family'] == false) {
        $gallery[] = ' pxl-font-default';
    }

    return $gallery;
}
add_filter( 'body_class', 'meddox_body_gallery' );


add_filter( 'pxl_server_info', 'meddox_add_server_info');
function meddox_add_server_info($infos){
	$infos = [
		'api_url' => 'https://api.bravisthemes.com/',
		'docs_url' => 'https://doc.bravisthemes.com/meddox/',
		'plugin_url' => 'https://api.bravisthemes.com/plugins/',
		'demo_url' => 'https://demo.bravisthemes.com/meddox/',
		'support_url' => 'https://bravisthemes.desky.support/',
		'help_url' => 'https://doc.bravisthemes.com/',
		'email_support' => '',
		'video_url' => '#'
	];
  
	return $infos;
}


/* Post Type Support Elementor*/
add_filter( 'pxl_add_cpt_support', 'meddox_add_cpt_support' );
function meddox_add_cpt_support($cpt_support) { 
	$cpt_support[] = 'service';
    return $cpt_support;
}

add_filter( 'pxl_support_default_cpt', 'meddox_support_default_cpt' );
function meddox_support_default_cpt($postypes){
	return $postypes; // pxl-template
}

add_filter( 'pxl_extra_post_types', 'meddox_add_posttype' );
function meddox_add_posttype( $postypes ) {
	$postypes['department'] = array(
		'status' => true,
		'item_name'  => 'Department',
		'items_name' => 'Department',
		'args'       => array(
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'rewrite'             => array(
                'slug'       => 'department',
 		 	),
		),
	);
	$postypes['gallery'] = array(
		'status' => true,
		'item_name'  => 'Gallery',
		'items_name' => 'Gallery',
		'args'       => array(
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'rewrite'             => array(
                'slug'       => 'gallery',
 		 	),
		),
	);
	$postypes['careers'] = array(
		'status' => true,
		'item_name'  => 'Careers',
		'items_name' => 'Careers',
		'args'       => array(
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'rewrite'             => array(
                'slug'       => 'careers',
 		 	),
		),
	);
	return $postypes;
}

add_filter( 'pxl_extra_taxonomies', 'meddox_add_tax' );
function meddox_add_tax( $taxonomies ) {

	$taxonomies['department-category'] = array(
		'status'     => true,
		'post_type'  => array( 'department' ),
		'taxonomy'   => 'Categories',
		'taxonomies' => 'Categories',
		'args'       => array(
			'rewrite'             => array(
                'slug'       => 'department-category'
 		 	),
		),
		'labels'     => array()
	);

	$taxonomies['department-tag'] = array(
		'status'     => true,
		'post_type'  => array( 'department' ),
		'taxonomy'   => 'Tags',
		'taxonomies' => 'Tags',
		'args'       => array(
			'rewrite'             => array(
                'slug'       => 'department-tag'
 		 	),
		),
		'labels'     => array()
	);

	$taxonomies['gallery-category'] = array(
		'status'     => true,
		'post_type'  => array( 'gallery' ),
		'taxonomy'   => 'Categories',
		'taxonomies' => 'Categories',
		'args'       => array(
			'rewrite'             => array(
                'slug'       => 'gallery-category'
 		 	),
		),
		'labels'     => array()
	);

	$taxonomies['gallery-tag'] = array(
		'status'     => true,
		'post_type'  => array( 'gallery' ),
		'taxonomy'   => 'Tags',
		'taxonomies' => 'Tags',
		'args'       => array(
			'rewrite'             => array(
                'slug'       => 'gallery-tag'
 		 	),
		),
		'labels'     => array()
	);
	$taxonomies['careers-category'] = array(
		'status'     => true,
		'post_type'  => array( 'careers' ),
		'taxonomy'   => 'Categories',
		'taxonomies' => 'Categories',
		'args'       => array(
			'rewrite'             => array(
                'slug'       => 'careers-category'
 		 	),
		),
		'labels'     => array()
	);
	$taxonomies['careers-tag'] = array(
		'status'     => true,
		'post_type'  => array( 'careers' ),
		'taxonomy'   => 'Tags',
		'taxonomies' => 'Tags',
		'args'       => array(
			'rewrite'             => array(
                'slug'       => 'careers-tag'
 		 	),
		),
		'labels'     => array()
	);
	return $taxonomies;
}


add_filter( 'pxl_theme_builder_post_types', 'meddox_theme_builder_post_type' );
function meddox_theme_builder_post_type($postypes){
	//default are header, footer, mega-menu
	return $postypes;
}

add_filter( 'pxl_theme_builder_layout_ids', 'meddox_theme_builder_layout_id' );
function meddox_theme_builder_layout_id($layout_ids){
	//default [], 
	$header_layout        = (int)meddox()->get_opt('header_layout');
	$header_sticky_layout = (int)meddox()->get_opt('header_sticky_layout');
	$footer_layout        = (int)meddox()->get_opt('footer_layout');
	$ptitle_layout        = (int)meddox()->get_opt('ptitle_layout');
	if( $header_layout > 0) 
		$layout_ids[] = $header_layout;
	if( $header_sticky_layout > 0) 
		$layout_ids[] = $header_sticky_layout;
	if( $footer_layout > 0) 
		$layout_ids[] = $footer_layout;
	if( $ptitle_layout > 0) 
		$layout_ids[] = $ptitle_layout;
	
	return $layout_ids;
}

add_filter( 'pxl_wg_get_source_id_builder', 'meddox_wg_get_source_builder' );
function meddox_wg_get_source_builder($wg_datas){
  $wg_datas['tabs'] = ['control_name' => 'tabs', 'source_name' => 'content_template'];
  return $wg_datas;
}

/* Update primary color in Editor Builder */
add_action( 'elementor/preview/enqueue_styles', 'meddox_add_editor_preview_style' );
function meddox_add_editor_preview_style(){
    wp_add_inline_style( 'editor-preview', meddox_editor_preview_inline_styles() );
}
function meddox_editor_preview_inline_styles(){
    $theme_colors = meddox_configs('theme_colors');
    ob_start();
        echo '.elementor-edit-area-active{';
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color: %2$s;', str_replace('#', '',$color),  $value['value']);
            }
        echo '}';
    return ob_get_clean();
}
 
add_filter( 'get_the_archive_title', 'meddox_archive_title_remove_label' );
function meddox_archive_title_remove_label( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_home() ) {
		$title = single_post_title( '', false );
	}

	return $title;
}

add_filter( 'comment_reply_link', 'meddox_comment_reply_text' );
function meddox_comment_reply_text( $link ) {
	$link = str_replace( 'Reply', ''.esc_attr__('Reply', 'meddox').'', $link );
	return $link;
}

add_filter( 'pxl_enable_megamenu', 'meddox_enable_megamenu' );
function meddox_enable_megamenu() {
	return true;
}
add_filter( 'pxl_enable_onepage', 'meddox_enable_onepage' );
function meddox_enable_onepage() {
	return true;
}

add_filter( 'pxl_support_awesome_pro', 'meddox_support_awesome_pro' );
function meddox_support_awesome_pro() {
	return true;
}
 
add_filter( 'redux_pxl_iconpicker_field/get_icons', 'meddox_add_icons_to_pxl_iconpicker_field' );
function meddox_add_icons_to_pxl_iconpicker_field($icons){
	$custom_icons = []; //'Flaticon' => array(array('flaticon-marker' => 'flaticon-marker')),
	$icons = array_merge($custom_icons, $icons);
	return $icons;
}


add_filter("pxl_mega_menu/get_icons", "meddox_add_icons_to_megamenu");
function meddox_add_icons_to_megamenu($icons){
	$custom_icons = []; //'Flaticon' => array(array('flaticon-marker' => 'flaticon-marker')),
	$icons = array_merge($custom_icons, $icons);
	return $icons;
}
 

/**
 * Move comment field to bottom
 */
add_filter( 'comment_form_fields', 'meddox_comment_field_to_bottom' );
function meddox_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}


/* ------Disable Lazy loading---- */
add_filter( 'wp_lazy_loading_enabled', '__return_false' );
