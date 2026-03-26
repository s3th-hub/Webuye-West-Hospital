<?php
if (!class_exists('ReduxFramework')) {
	return;
}
if (class_exists('ReduxFrameworkPlugin')) {
	remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
}

if (class_exists('Newsletter')) {
	$forms = array_filter((array) get_option('newsletter_forms', array()));

	$newsletter_forms = array(
		'default' => esc_html__('Default Form', 'medcity'),
	);

	if ($forms) {
		$index = 1;
		foreach ($forms as $key => $form) {
			$newsletter_forms[$key] = sprintf(esc_html__('Form %s', 'medcity'), $index);
			$index++;
		}
	}
} else {
	$newsletter_forms = '';
}

$opt_name = medcity_get_opt_name();
$theme = wp_get_theme();

$args = array(
	// TYPICAL -> Change these values as you need/desire
	'opt_name' => $opt_name,
	'font-display' => 'swap',
	// This is where your data is stored in the database and also becomes your global variable name.
	'display_name' => $theme->get('Name'),
	// Name that appears at the top of your panel
	'display_version' => $theme->get('Version'),
	// Version that appears at the top of your panel
	'menu_type' => class_exists('Elementor_Theme_Core') ? 'submenu' : '',
	//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu' => true,
	// Show the sections below the admin menu item or not
	'menu_title' => esc_html__('Theme Options', 'medcity'),
	'page_title' => esc_html__('Theme Options', 'medcity'),
	// You will need to generate a Google API key to use this feature.
	// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
	'google_api_key' => '',
	// Set it you want google fonts to update weekly. A google_api_key value is required.
	'google_update_weekly' => false,
	// Must be defined to add google fonts to the typography module
	'async_typography' => false,
	// Use a asynchronous font on the front end or font string
	//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
	'admin_bar' => true,
	// Show the panel pages on the admin bar
	'admin_bar_icon' => 'dashicons-admin-generic',
	// Choose an icon for the admin bar menu
	'admin_bar_priority' => 50,
	// Choose an priority for the admin bar menu
	'global_variable' => '',
	// Set a different name for your global variable other than the opt_name
	'dev_mode' => true,
	// Show the time the page took to load, etc
	'update_notice' => true,
	// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	'customizer' => true,
	// Enable basic customizer support
	//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
	//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
	'show_options_object' => false,
	// OPTIONAL -> Give you extra features
	'page_priority' => null,
	// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_parent' => class_exists('Elementor_Theme_Core') ? $theme->get('TextDomain') : '',
	// For a full list of options, visit: //codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	'page_permissions' => 'manage_options',
	// Permissions needed to access the options panel.
	'menu_icon' => '',
	// Specify a custom URL to an icon
	'last_tab' => '',
	// Force your panel to always open to a specific tab (by id)
	'page_icon' => 'icon-themes',
	// Icon displayed in the admin panel next to your menu_title
	'page_slug' => 'theme-options',
	// Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
	'save_defaults' => true,
	// On load save the defaults to DB before user clicks save or not
	'default_show' => false,
	// If true, shows the default value next to each field that is not the default value.
	'default_mark' => '',
	// What to print by the field's title if the value shown is default. Suggested: *
	'show_import_export' => true,
	// Shows the Import/Export panel when not used as a field.

	// CAREFUL -> These options are for advanced use only
	'transient_time' => 60 * MINUTE_IN_SECONDS,
	'output' => true,
	// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	'output_tag' => true,
	// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	'database' => '',
	// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	'use_cdn' => true,
	// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

	// HINTS
	'hints' => array(
		'icon' => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color' => 'lightgray',
		'icon_size' => 'normal',
		'tip_style' => array(
			'color' => 'red',
			'shadow' => true,
			'rounded' => false,
			'style' => '',
		),
		'tip_position' => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect' => array(
			'show' => array(
				'effect' => 'slide',
				'duration' => '500',
				'event' => 'mouseover',
			),
			'hide' => array(
				'effect' => 'slide',
				'duration' => '500',
				'event' => 'click mouseleave',
			),
		),
	),
	'templates_path' => get_template_directory() . '/inc/templates/redux/',
);

Redux::SetArgs($opt_name, $args);

/*--------------------------------------------------------------
# General
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
	'title' => esc_html__('General', 'medcity'),
	'icon' => 'el-icon-home',
	'fields' => array(
		array(
			'id' => 'favicon',
			'type' => 'media',
			'title' => esc_html__('Favicon', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'show_page_loading',
			'type' => 'switch',
			'title' => esc_html__('Enable Page Loading', 'medcity'),
			'subtitle' => esc_html__('Enable page loading effect when you load site.', 'medcity'),
			'default' => false,
		),
		array(
			'id' => 'dev_mode',
			'type' => 'switch',
			'title' => esc_html__('Dev Mode (not recommended)', 'medcity'),
			'description' => 'no minimize , generate css over time...',
			'default' => false,
		),
	),
));

/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
	'title' => esc_html__('Header', 'medcity'),
	'icon' => 'el-icon-website',
	'fields' => array(
		array(
			'id' => 'header_layout',
			'type' => 'image_select',
			'title' => esc_html__('Layout', 'medcity'),
			'subtitle' => esc_html__('Select a layout for header.', 'medcity'),
			'options' => array(
				'1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
				'2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
				'3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
				'4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
				'5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
				'6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
				'7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
			),
			'default' => '1',
		),
		array(
			'id' => 'sticky_on',
			'type' => 'switch',
			'title' => esc_html__('Sticky Header', 'medcity'),
			'subtitle' => esc_html__('Header will be sticked when applicable.', 'medcity'),
			'default' => false,
		),
		array(
			'id' => 'menu_highlight_on',
			'type' => 'switch',
			'title' => esc_html__('Highlight Menu ( Layout1 only )', 'medcity'),
			'subtitle' => esc_html__('Header menu will be clickable with bar icon.', 'medcity'),
			'default' => false,
		),
		array(
			'id' => 'hl_menu_select',
			'type' => 'select',
			'title' => esc_html__('Select Menu', 'medcity'),
			'data' => 'menus',
			'args' => array(
				'hide_empty' => false,
				'orderby' => 'name',
			),
			'required' => array(0 => 'menu_highlight_on', 1 => 'equals', 2 => true),
		),
		array(
			'id' => 'menu_name_url',
			'type' => 'text',
			'title' => esc_html__('Menu Name Url', 'medcity'),
			'default' => '',
			'required' => array(0 => 'menu_highlight_on', 1 => 'equals', 2 => true),
		),
		array(
			'id' => 'search_on',
			'type' => 'switch',
			'title' => esc_html__('Search Icon', 'medcity'),
			'default' => false,
		),
		array(
			'id' => 'cart_on',
			'type' => 'switch',
			'title' => esc_html__('Cart Icon', 'medcity'),
			'subtitle' => esc_html__('Cart icon will be show when turn on.', 'medcity'),
			'default' => false,
		),
		array(
			'id' => 'language_switch',
			'type' => 'switch',
			'title' => esc_html__('Language Switch', 'medcity'),
			'default' => false,
		),
		array(
			'id' => 'emergency_on',
			'type' => 'switch',
			'title' => esc_html__('Emergency Menu', 'medcity'),
			'subtitle' => esc_html__('Show on Header Top Bar', 'medcity'),
			'default' => false,
		),
		array(
			'id' => 'emergency_text',
			'type' => 'text',
			'title' => esc_html__('Emergency Text', 'medcity'),
			'default' => '',
			'required' => array(0 => 'emergency_on', 1 => 'equals', 2 => 'true'),
			'force_output' => true,
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Top Bar', 'medcity'),
	'icon' => 'el el-website',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'top_bar_bg_color',
			'type' => 'color',
			'transparent' => false,
			'title' => esc_html__('Background Color', 'medcity'),
			'output' => array('background-color' => '#masthead #site-header-wrap .site-header-top'),
		),
		array(
			'id' => 'note_text',
			'type' => 'textarea',
			'title' => esc_html__('Note Text', 'medcity'),
			'rows' => 3,
			'default' => '',
			'force_output' => true,
		),
		array(
			'id' => 'note_text_close',
			'type' => 'textarea',
			'title' => esc_html__('Note Text Close', 'medcity'),
			'rows' => 3,
			'default' => '',
			'force_output' => true,
		),
		array(
			'id' => 'phone_label',
			'type' => 'text',
			'title' => esc_html__('Phone Label', 'medcity'),
			'default' => '',
			'force_output' => true,
		),
		array(
			'id' => 'phone_number',
			'type' => 'text',
			'title' => esc_html__('Phone Number', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'phone_number_menu',
			'type' => 'text',
			'title' => esc_html__('Phone Number In Menu', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'location_label',
			'type' => 'text',
			'title' => esc_html__('Location Label', 'medcity'),
			'default' => '',
			'force_output' => true,
		),
		array(
			'id' => 'location_text',
			'type' => 'text',
			'title' => esc_html__('Location Text', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'location_link',
			'type' => 'text',
			'title' => esc_html__('Location Link', 'medcity'),
			'default' => '',
			'force_output' => true,
		),
		array(
			'id' => 'time_label',
			'type' => 'text',
			'title' => esc_html__('Time Label', 'medcity'),
			'default' => '',
			'force_output' => true,
		),
		array(
			'id' => 'time',
			'type' => 'text',
			'title' => esc_html__('Time', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'short_link1',
			'type' => 'textarea',
			'title' => esc_html__('Short Link 1', 'medcity'),
			'validate' => 'html_custom',
			'rows' => 3,
			'default' => '',
		),
		array(
			'id' => 'short_link2',
			'type' => 'textarea',
			'title' => esc_html__('Short Link 2', 'medcity'),
			'validate' => 'html_custom',
			'rows' => 3,
			'default' => '',
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Logo', 'medcity'),
	'icon' => 'el el-picture',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'logo',
			'type' => 'media',
			'title' => esc_html__('Logo Dark', 'medcity'),
			'default' => array(
				'url' => get_template_directory_uri() . '/assets/images/logo-dark.png',
			),
		),
		array(
			'id' => 'logo_light',
			'type' => 'media',
			'title' => esc_html__('Logo Light', 'medcity'),
			'default' => array(
				'url' => get_template_directory_uri() . '/assets/images/logo-light.png',
			),
		),
		array(
			'id' => 'logo_mobile',
			'type' => 'media',
			'title' => esc_html__('Logo Tablet & Mobile', 'medcity'),
			'default' => array(
				'url' => get_template_directory_uri() . '/assets/images/logo-dark.png',
			),
		),
		array(
			'id' => 'logo_maxh',
			'type' => 'dimensions',
			'title' => esc_html__('Logo Max height', 'medcity'),
			'subtitle' => esc_html__('Enter number.', 'medcity'),
			'width' => false,
			'unit' => 'px',
		),
		array(
			'id' => 'logo_maxh_sm',
			'type' => 'dimensions',
			'title' => esc_html__('Logo Max height Tablet & Mobile', 'medcity'),
			'subtitle' => esc_html__('Enter number.', 'medcity'),
			'width' => false,
			'unit' => 'px',
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Navigation', 'medcity'),
	'icon' => 'el el-lines',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'font_menu',
			'type' => 'typography',
			'title' => esc_html__('Custom Google Font', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'font-style' => false,
			'font-weight' => true,
			'text-align' => false,
			'font-size' => false,
			'line-height' => false,
			'color' => false,
			'output' => array('.primary-menu > li > a, body .primary-menu .sub-menu li a'),
			'units' => 'px',
		),
		array(
			'id' => 'menu_font_size',
			'type' => 'text',
			'title' => esc_html__('Font Size', 'medcity'),
			'validate' => 'numeric',
			'desc' => 'Enter number',
			'msg' => 'Please enter number',
			'default' => '',
		),
		array(
			'id' => 'menu_text_transform',
			'type' => 'select',
			'title' => esc_html__('Text Transform', 'medcity'),
			'options' => array(
				'' => esc_html__('Default', 'medcity'),
				'uppercase' => esc_html__('Uppercase', 'medcity'),
				'capitalize' => esc_html__('Capitalize', 'medcity'),
				'lowercase' => esc_html__('Lowercase', 'medcity'),
				'initial' => esc_html__('Initial', 'medcity'),
				'inherit' => esc_html__('Inherit', 'medcity'),
				'none' => esc_html__('None', 'medcity'),
			),
			'default' => '',
		),
		array(
			'title' => esc_html__('Main Menu', 'medcity'),
			'type' => 'section',
			'id' => 'main_menu',
			'indent' => true,
		),
		array(
			'id' => 'main_menu_color',
			'type' => 'link_color',
			'title' => esc_html__('Color', 'medcity'),
			'default' => array(
				'regular' => '',
				'hover' => '',
				'active' => '',
			),
		),
		array(
			'title' => esc_html__('Sticky Menu', 'medcity'),
			'type' => 'section',
			'id' => 'sticky_menu',
			'indent' => true,
		),
		array(
			'id' => 'sticky_menu_color',
			'type' => 'link_color',
			'title' => esc_html__('Color', 'medcity'),
			'default' => array(
				'regular' => '',
				'hover' => '',
				'active' => '',
			),
		),

		array(
			'title' => esc_html__('Button Navigation', 'medcity'),
			'type' => 'section',
			'id' => 'button_navigation',
			'indent' => true,
		),
		array(
			'id' => 'h_btn_on',
			'type' => 'button_set',
			'title' => esc_html__('Show/Hide Button', 'medcity'),
			'options' => array(
				'show' => esc_html__('Show', 'medcity'),
				'hide' => esc_html__('Hide', 'medcity'),
			),
			'default' => 'hide',
		),
		array(
			'id' => 'h_btn_text',
			'type' => 'text',
			'title' => esc_html__('Button Text', 'medcity'),
			'default' => '',
			'required' => array(0 => 'h_btn_on', 1 => 'equals', 2 => 'show'),
			'force_output' => true,
		),
		array(
			'id' => 'h_btn_link_type',
			'type' => 'button_set',
			'title' => esc_html__('Button Link Type', 'medcity'),
			'options' => array(
				'page' => esc_html__('Page', 'medcity'),
				'custom' => esc_html__('Custom', 'medcity'),
			),
			'default' => 'page',
			'required' => array(0 => 'h_btn_on', 1 => 'equals', 2 => 'show'),
			'force_output' => true,
		),
		array(
			'id' => 'h_btn_link',
			'type' => 'select',
			'title' => esc_html__('Page Link', 'medcity'),
			'data' => 'page',
			'args' => array(
				'post_type' => 'page',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
			),
			'required' => array(0 => 'h_btn_link_type', 1 => 'equals', 2 => 'page'),
			'force_output' => true,
		),
		array(
			'id' => 'h_btn_link_custom',
			'type' => 'text',
			'title' => esc_html__('Custom Link', 'medcity'),
			'default' => '',
			'required' => array(0 => 'h_btn_link_type', 1 => 'equals', 2 => 'custom'),
			'force_output' => true,
		),
		array(
			'id' => 'h_btn_target',
			'type' => 'button_set',
			'title' => esc_html__('Button Target', 'medcity'),
			'options' => array(
				'_self' => esc_html__('Self', 'medcity'),
				'_blank' => esc_html__('Blank', 'medcity'),
			),
			'default' => '_self',
			'required' => array(0 => 'h_btn_on', 1 => 'equals', 2 => 'show'),
			'force_output' => true,
		),
	),
));

/*--------------------------------------------------------------
# Page Title area
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
	'title' => esc_html__('Page Title', 'medcity'),
	'icon' => 'el-icon-map-marker',
	'fields' => array(

		array(
			'id' => 'pagetitle',
			'type' => 'button_set',
			'title' => esc_html__('Page Title', 'medcity'),
			'options' => array(
				'show' => esc_html__('Show', 'medcity'),
				'hide' => esc_html__('Hide', 'medcity'),
			),
			'default' => 'show',
		),

		array(
			'id' => 'ptitle_bg',
			'type' => 'background',
			'title' => esc_html__('Background', 'medcity'),
			'subtitle' => esc_html__('Page title background.', 'medcity'),
			'output' => array('body #pagetitle'),
			'required' => array(0 => 'pagetitle', 1 => 'equals', 2 => 'show'),
			'force_output' => true,
			'transparent' => false,
		),
		array(
			'id' => 'ptitle_color',
			'type' => 'color',
			'title' => esc_html__('Text Color', 'medcity'),
			'subtitle' => esc_html__('Text color.', 'medcity'),
			'output' => array('body #pagetitle h1.page-title', 'body #pagetitle .page-title-inner .cms-breadcrumb'),
			'default' => '',
			'transparent' => false,
			'required' => array(0 => 'pagetitle', 1 => 'equals', 2 => 'show'),
			'force_output' => true,
		),
		array(
			'id' => 'ptitle_paddings',
			'type' => 'spacing',
			'title' => esc_html__('Content Paddings', 'medcity'),
			'subtitle' => esc_html__('Content page title paddings.', 'medcity'),
			'mode' => 'padding',
			'units' => array('em', 'px', '%'),
			'top' => true,
			'right' => false,
			'bottom' => true,
			'left' => false,
			'output' => array('#pagetitle.pagetitle'),
			'default' => array(
				'top' => '',
				'right' => '',
				'bottom' => '',
				'left' => '',
				'units' => 'px',
			),
		),
		array(
			'id' => 'ptitle_content_align',
			'type' => 'button_set',
			'title' => esc_html__('Content Align', 'medcity'),
			'options' => array(
				'left' => esc_html__('Left', 'medcity'),
				'center' => esc_html__('Center', 'medcity'),
				'right' => esc_html__('Right', 'medcity'),
			),
			'default' => 'left',
		),
		array(
			'title' => esc_html__('Breadcrumb', 'medcity'),
			'type' => 'section',
			'id' => 'pt_breadcrumb',
			'indent' => true,
		),
		array(
			'id' => 'breadcrumb_on',
			'type' => 'switch',
			'title' => esc_html__('Breadcrumb', 'medcity'),
			'default' => false,
		),
	),
));

/*--------------------------------------------------------------
# WordPress default content
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
	'title' => esc_html__('Content', 'medcity'),
	'icon' => 'el-icon-pencil',
	'fields' => array(
		array(
			'id' => 'content_bg_color',
			'type' => 'color_rgba',
			'title' => esc_html__('Background Color', 'medcity'),
			'subtitle' => esc_html__('Content background color.', 'medcity'),
			'output' => array('background-color' => 'body'),
		),
		array(
			'id' => 'content_padding',
			'type' => 'spacing',
			'output' => array('.single #content'),
			'right' => false,
			'left' => false,
			'mode' => 'padding',
			'units' => array('px'),
			'units_extended' => 'false',
			'title' => esc_html__('Content Padding', 'medcity'),
			'subtitle' => esc_html__('Single Post Content Padding.', 'medcity'),
			'desc' => esc_html__('Default: Top-110px, Bottom-110px', 'medcity'),
			'default' => array(
				'padding-top' => '',
				'padding-bottom' => '',
				'units' => 'px',
			),
		),
		array(
			'id' => 'search_field_placeholder',
			'type' => 'text',
			'title' => esc_html__('Search Form - Text Placeholder', 'medcity'),
			'default' => '',
			'desc' => esc_html__('Default: Search Keywords...', 'medcity'),
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Archive', 'medcity'),
	'icon' => 'el-icon-list',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'archive_sidebar_pos',
			'type' => 'button_set',
			'title' => esc_html__('Sidebar Position', 'medcity'),
			'subtitle' => esc_html__('Select a sidebar position for blog home, archive, search...', 'medcity'),
			'options' => array(
				'left' => esc_html__('Left', 'medcity'),
				'right' => esc_html__('Right', 'medcity'),
				'none' => esc_html__('Disabled', 'medcity'),
			),
			'default' => 'right',
		),
		array(
			'id' => 'archive_author_on',
			'title' => esc_html__('Author', 'medcity'),
			'subtitle' => esc_html__('Show author name on each post.', 'medcity'),
			'type' => 'switch',
			'default' => false,
		),
		array(
			'id' => 'archive_date_on',
			'title' => esc_html__('Date', 'medcity'),
			'subtitle' => esc_html__('Show date posted on each post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
		array(
			'id' => 'archive_categories_on',
			'title' => esc_html__('Categories', 'medcity'),
			'subtitle' => esc_html__('Show category names on each post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
		array(
			'id' => 'archive_comments_on',
			'title' => esc_html__('Comments', 'medcity'),
			'subtitle' => esc_html__('Show comments count on each post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Single Post', 'medcity'),
	'icon' => 'el-icon-file-edit',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'post_bg_color',
			'type' => 'color',
			'title' => esc_html__('Content Background Color', 'medcity'),
			'transparent' => false,
			'default' => '',
			'required' => array(0 => 'single_post_layout', 1 => 'equals', 2 => 'real-estate'),
			'force_output' => true,
		),
		array(
			'id' => 'post_sidebar_pos',
			'type' => 'button_set',
			'title' => esc_html__('Sidebar Position', 'medcity'),
			'subtitle' => esc_html__('Select a sidebar position', 'medcity'),
			'options' => array(
				'left' => esc_html__('Left', 'medcity'),
				'right' => esc_html__('Right', 'medcity'),
				'none' => esc_html__('Disabled', 'medcity'),
			),
			'default' => 'right',
		),
		array(
			'id' => 'post_title_on',
			'title' => esc_html__('Title', 'medcity'),
			'subtitle' => esc_html__('Show title on single post.', 'medcity'),
			'type' => 'switch',
			'default' => false,
		),
		array(
			'id' => 'post_author_on',
			'title' => esc_html__('Author', 'medcity'),
			'subtitle' => esc_html__('Show author name on single post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
		array(
			'id' => 'post_author_info_on',
			'title' => esc_html__('Author Info', 'medcity'),
			'subtitle' => esc_html__('Show author info name on single post.', 'medcity'),
			'type' => 'switch',
			'default' => false,
		),
		array(
			'id' => 'post_date_on',
			'title' => esc_html__('Date', 'medcity'),
			'subtitle' => esc_html__('Show date on single post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
		array(
			'id' => 'post_categories_on',
			'title' => esc_html__('Categories', 'medcity'),
			'subtitle' => esc_html__('Show category names on single post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
		array(
			'id' => 'post_tags_on',
			'title' => esc_html__('Tags', 'medcity'),
			'subtitle' => esc_html__('Show tag names on single post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
		array(
			'id' => 'post_comments_on',
			'title' => esc_html__('Comments', 'medcity'),
			'subtitle' => esc_html__('Show comments count on single post.', 'medcity'),
			'type' => 'switch',
			'default' => false,
		),
		array(
			'id' => 'post_social_share_on',
			'title' => esc_html__('Social Share', 'medcity'),
			'subtitle' => esc_html__('Show social share on single post.', 'medcity'),
			'type' => 'switch',
			'default' => false,
		),
		array(
			'id' => 'post_navigation_on',
			'title' => esc_html__('Navigation', 'medcity'),
			'subtitle' => esc_html__('Show navigation on single post.', 'medcity'),
			'type' => 'switch',
			'default' => false,
		),
		array(
			'id' => 'post_comments_form_on',
			'title' => esc_html__('Comments Form', 'medcity'),
			'subtitle' => esc_html__('Show comments form on single post.', 'medcity'),
			'type' => 'switch',
			'default' => true,
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Post Type Slug', 'medcity'),
	'icon' => 'el-icon-file-edit',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'service_slug',
			'type' => 'text',
			'title' => esc_html__('Service Slug', 'medcity'),
			'default' => '',
			'subtitle' => esc_html__('The slug name cannot be the same as a page name. Make sure to regenertate permalinks, after making changes.', 'medcity'),
		),
		array(
			'id' => 'doctor_slug',
			'type' => 'text',
			'title' => esc_html__('Doctor Slug', 'medcity'),
			'default' => '',
			'subtitle' => esc_html__('The slug name cannot be the same as a page name. Make sure to regenertate permalinks, after making changes.', 'medcity'),
		),
		array(
			'id' => 'department_slug',
			'type' => 'text',
			'title' => esc_html__('Department Slug', 'medcity'),
			'default' => '',
			'subtitle' => esc_html__('The slug name cannot be the same as a page name. Make sure to regenertate permalinks, after making changes.', 'medcity'),
		),
		array(
			'id' => 'single_archive_url',
			'type' => 'text',
			'title' => esc_html__('Single Doctor Archive Url', 'medcity'),
			'default' => '',
		),
	),
));

/*--------------------------------------------------------------
# Shop
--------------------------------------------------------------*/
if (class_exists('Woocommerce')) {
	Redux::setSection($opt_name, array(
		'title' => esc_html__('Shop', 'medcity'),
		'icon' => 'el el-shopping-cart',
		'fields' => array(
			array(
				'id' => 'sidebar_shop',
				'type' => 'button_set',
				'title' => esc_html__('Sidebar Position', 'medcity'),
				'subtitle' => esc_html__('Select a sidebar position for archive shop.', 'medcity'),
				'options' => array(
					'left' => esc_html__('Left', 'medcity'),
					'right' => esc_html__('Right', 'medcity'),
					'none' => esc_html__('Disabled', 'medcity'),
				),
				'default' => 'right',
			),
			array(
				'title' => esc_html__('Products displayed per page', 'medcity'),
				'id' => 'product_per_page',
				'type' => 'slider',
				'subtitle' => esc_html__('Number product to show', 'medcity'),
				'default' => 9,
				'min' => 4,
				'step' => 1,
				'max' => 50,
				'display_value' => 'text',
			),
			array(
				'id' => 'product_per_row',
				'type' => 'button_set',
				'title' => esc_html__('Product per row', 'medcity'),
				'options' => array(
					'3' => esc_html__('3 Column', 'medcity'),
					'4' => esc_html__('4 Column', 'medcity'),
					'5' => esc_html__('5 Column', 'medcity'),
				),
				'default' => '4',
				'force_output' => true,
			),
			array(
				'id' => 'shop_ptitle_bg',
				'type' => 'background',
				'title' => esc_html__('Page Title Background', 'medcity'),
				'subtitle' => esc_html__('Shop Products Page title background.', 'medcity'),
				'output' => array('body.woocommerce.archive #pagetitle'),
				'required' => array(0 => 'pagetitle', 1 => 'equals', 2 => 'show'),
				'force_output' => true,
				'transparent' => false,
			),
			array(
				'id' => 'content_paddings',
				'type' => 'spacing',
				'title' => esc_html__('Content Paddings', 'medcity'),
				'subtitle' => esc_html__('Content shop paddings.', 'medcity'),
				'mode' => 'padding',
				'units' => array('em', 'px', '%'),
				'top' => true,
				'right' => false,
				'bottom' => true,
				'left' => false,
				'output' => array('body.woocommerce #content'),
				'default' => array(
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => '',
					'units' => 'px',
				),
			),
		),
	));
}

/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
	'title' => esc_html__('Footer', 'medcity'),
	'icon' => 'el el-website',
	'fields' => array(
		array(
			'id' => 'footer_layout',
			'type' => 'button_set',
			'title' => esc_html__('Layout', 'medcity'),
			'subtitle' => esc_html__('Select a layout for upper footer area.', 'medcity'),
			'options' => array(
				'custom' => esc_html__('Custom', 'medcity'),
				'0' => esc_html__('No Footer', 'medcity'),
			),
			'default' => 'custom',
		),
		array(
			'id' => 'footer_layout_custom',
			'type' => 'select',
			'title' => esc_html__('Custom Layout', 'medcity'),
			'desc' => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.', 'medcity'), '<a href="' . esc_url(admin_url('edit.php?post_type=footer')) . '">', '</a>'),
			'options' => medcity_list_post('footer'),
			'default' => '',
			'required' => array(0 => 'footer_layout', 1 => 'equals', 2 => 'custom'),
			'force_output' => true,
		),
		array(
			'id' => 'back_totop_on',
			'type' => 'switch',
			'title' => esc_html__('Back to Top Button', 'medcity'),
			'subtitle' => esc_html__('Show back to top button when scrolled down.', 'medcity'),
			'default' => true,
		),
	),
));

/*--------------------------------------------------------------
# Colors
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
	'title' => esc_html__('Colors', 'medcity'),
	'icon' => 'el-icon-file-edit',
	'fields' => array(
		array(
			'id' => 'primary_color',
			'type' => 'color',
			'title' => esc_html__('Primary Color', 'medcity'),
			'transparent' => false,
			'default' => '#21cdc0',
		),
		array(
			'id' => 'secondary_color',
			'type' => 'color',
			'title' => esc_html__('Secondary Color', 'medcity'),
			'subtitle' => esc_html__('For Title, Heading', 'medcity'),
			'transparent' => false,
			'default' => '#0e204d',
		),
		array(
			'id' => 'tertiary_color',
			'type' => 'color',
			'title' => esc_html__('Tertiary Color', 'medcity'),
			'subtitle' => esc_html__('For Subtitle, Category...', 'medcity'),
			'transparent' => false,
			'default' => '#435ba1',
		),
		array(
			'id' => 'dark_light_color',
			'type' => 'color',
			'title' => esc_html__('Dark Light Color', 'medcity'),
			'subtitle' => esc_html__('For Single Header, Grid Title...', 'medcity'),
			'transparent' => false,
			'default' => '#26365e',
		),
		array(
			'id' => 'button_secondary_color',
			'type' => 'color',
			'title' => esc_html__('Button Secondary Color', 'medcity'),
			'subtitle' => esc_html__('For Secondary Button background color', 'medcity'),
			'transparent' => false,
			'default' => '#213360',
		),
		array(
			'id' => 'link_color',
			'type' => 'link_color',
			'title' => esc_html__('Link Colors', 'medcity'),
			'default' => array(
				'regular' => 'inherit',
				'hover' => '#21cdc0',
				'active' => '#21cdc0',
			),
			'output' => array('a'),
		),
	),
));

/*--------------------------------------------------------------
# Typography
--------------------------------------------------------------*/
$custom_font_selectors_1 = medcity_get_opt('custom_font_selectors_1');
$custom_font_selectors_1 = !empty($custom_font_selectors_1) ? explode(',', $custom_font_selectors_1) : array();
Redux::setSection($opt_name, array(
	'title' => esc_html__('Typography', 'medcity'),
	'icon' => 'el-icon-text-width',
	'fields' => array(
		array(
			'id' => 'body_default_font',
			'type' => 'select',
			'title' => esc_html__('Body Default Font', 'medcity'),
			'options' => array(
				'Default' => esc_html__('Default', 'medcity'),
				'Google-Font' => esc_html__('Google Font', 'medcity'),
			),
			'default' => 'Default',
		),
		array(
			'id' => 'font_main',
			'type' => 'typography',
			'title' => esc_html__('Body Google Font', 'medcity'),
			'subtitle' => esc_html__('This will be the default font of your website.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'line-height' => true,
			'font-size' => true,
			'text-align' => false,
			'output' => array('body'),
			'units' => 'px',
			'required' => array(0 => 'body_default_font', 1 => 'equals', 2 => 'Google-Font'),
			'force_output' => true,
		),
		array(
			'id' => 'heading_default_font',
			'type' => 'select',
			'title' => esc_html__('Heading Default Font', 'medcity'),
			'options' => array(
				'Default' => esc_html__('Default', 'medcity'),
				'Google-Font' => esc_html__('Google Font', 'medcity'),
			),
			'default' => 'Default',
		),
		array(
			'id' => 'font_h1',
			'type' => 'typography',
			'title' => esc_html__('H1', 'medcity'),
			'subtitle' => esc_html__('This will be the default font for all H1 tags of your website.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'text-align' => false,
			'output' => array('h1', '.h1', '.text-heading'),
			'units' => 'px',
			'required' => array(0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font'),
			'force_output' => true,
		),
		array(
			'id' => 'font_h2',
			'type' => 'typography',
			'title' => esc_html__('H2', 'medcity'),
			'subtitle' => esc_html__('This will be the default font for all H2 tags of your website.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'text-align' => false,
			'output' => array('h2', '.h2'),
			'units' => 'px',
			'required' => array(0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font'),
			'force_output' => true,
		),
		array(
			'id' => 'font_h3',
			'type' => 'typography',
			'title' => esc_html__('H3', 'medcity'),
			'subtitle' => esc_html__('This will be the default font for all H3 tags of your website.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'text-align' => false,
			'output' => array('h3', '.h3'),
			'units' => 'px',
			'required' => array(0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font'),
			'force_output' => true,
		),
		array(
			'id' => 'font_h4',
			'type' => 'typography',
			'title' => esc_html__('H4', 'medcity'),
			'subtitle' => esc_html__('This will be the default font for all H4 tags of your website.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'text-align' => false,
			'output' => array('h4', '.h4'),
			'units' => 'px',
			'required' => array(0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font'),
			'force_output' => true,
		),
		array(
			'id' => 'font_h5',
			'type' => 'typography',
			'title' => esc_html__('H5', 'medcity'),
			'subtitle' => esc_html__('This will be the default font for all H5 tags of your website.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'text-align' => false,
			'output' => array('h5', '.h5'),
			'units' => 'px',
			'required' => array(0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font'),
			'force_output' => true,
		),
		array(
			'id' => 'font_h6',
			'type' => 'typography',
			'title' => esc_html__('H6', 'medcity'),
			'subtitle' => esc_html__('This will be the default font for all H6 tags of your website.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'text-align' => false,
			'output' => array('h6', '.h6'),
			'units' => 'px',
			'required' => array(0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font'),
			'force_output' => true,
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Fonts Selectors', 'medcity'),
	'icon' => 'el el-fontsize',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'custom_font_1',
			'type' => 'typography',
			'title' => esc_html__('Custom Font', 'medcity'),
			'subtitle' => esc_html__('This will be the font that applies to the class selector.', 'medcity'),
			'google' => true,
			'font-backup' => true,
			'all_styles' => true,
			'text-align' => false,
			'output' => $custom_font_selectors_1,
			'units' => 'px',

		),
		array(
			'id' => 'custom_font_selectors_1',
			'type' => 'textarea',
			'title' => esc_html__('CSS Selectors', 'medcity'),
			'subtitle' => esc_html__('Add class selectors to apply above font.', 'medcity'),
			'validate' => 'no_html',
		),
	),
));

/* 404 Page /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
	'title' => esc_html__('404 Page', 'medcity'),
	'icon' => 'el-cog-alt el',
	'fields' => array(
		array(
			'id' => 'heading_404_page',
			'type' => 'text',
			'title' => esc_html__('Heading Text', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'content_404_page',
			'type' => 'textarea',
			'title' => esc_html__('Content', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'btn_text_404_page',
			'type' => 'text',
			'title' => esc_html__('Button Text', 'medcity'),
			'default' => '',
			'desc' => esc_html__('Default: Take me go back home', 'medcity'),
		),
		array(
			'id' => 'bg_404_page',
			'type' => 'background',
			'title' => esc_html__('Background', 'medcity'),
			'output' => array('body.error404 .error-404'),
			'background-color' => false,
		),
	),
));

/* Social Media */
Redux::setSection($opt_name, array(
	'title' => esc_html__('Social Media', 'medcity'),
	'icon' => 'el el-twitter',
	'subsection' => false,
	'fields' => array(
		array(
			'id' => 'social_media',
			'type' => 'sorter',
			'title' => 'Enable and Sort',
			'desc' => 'Choose which social networks are displayed and edit where they link to.',
			'options' => array(
				'enabled' => array(),
				'disabled' => array(
					'facebook' => 'Facebook',
					'twitter' => 'Twitter',
					'instagram' => 'Instagram',
					'behance' => 'Behance',
					'dribbble' => 'Dribbble',
					'google' => 'Google',
					'youtube' => 'Youtube',
					'vimeo' => 'Vimeo',
					'tumblr' => 'Tumblr',
					'pinterest' => 'Pinterest',
					'yelp' => 'Yelp',
					'skype' => 'Skype',
					'linkedin' => 'Linkedin',
					'rss' => 'Rss',
				),
			),
		),
		array(
			'id' => 'social_facebook_url',
			'type' => 'text',
			'title' => esc_html__('Facebook URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_twitter_url',
			'type' => 'text',
			'title' => esc_html__('Twitter URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_instagram_url',
			'type' => 'text',
			'title' => esc_html__('Instagram URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_behance_url',
			'type' => 'text',
			'title' => esc_html__('Behance URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_dribbble_url',
			'type' => 'text',
			'title' => esc_html__('Dribbble URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_inkedin_url',
			'type' => 'text',
			'title' => esc_html__('Inkedin URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_rss_url',
			'type' => 'text',
			'title' => esc_html__('Rss URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_google_url',
			'type' => 'text',
			'title' => esc_html__('Google URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_skype_url',
			'type' => 'text',
			'title' => esc_html__('Skype URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_pinterest_url',
			'type' => 'text',
			'title' => esc_html__('Pinterest URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_vimeo_url',
			'type' => 'text',
			'title' => esc_html__('Vimeo URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_youtube_url',
			'type' => 'text',
			'title' => esc_html__('Youtube URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_yelp_url',
			'type' => 'text',
			'title' => esc_html__('Yelp URL', 'medcity'),
			'default' => '',
		),
		array(
			'id' => 'social_tumblr_url',
			'type' => 'text',
			'title' => esc_html__('Tumblr URL', 'medcity'),
			'default' => '',
		),
	),
));

/* Custom Code /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
	'title' => esc_html__('Custom Code', 'medcity'),
	'icon' => 'el-icon-edit',
	'fields' => array(

		array(
			'id' => 'site_header_code',
			'type' => 'textarea',
			'theme' => 'chrome',
			'title' => esc_html__('Header Custom Codes', 'medcity'),
			'subtitle' => esc_html__('It will insert the code to wp_head hook.', 'medcity'),
		),
		array(
			'id' => 'site_footer_code',
			'type' => 'textarea',
			'theme' => 'chrome',
			'title' => esc_html__('Footer Custom Codes', 'medcity'),
			'subtitle' => esc_html__('It will insert the code to wp_footer hook.', 'medcity'),
		),

	),
));

/* Custom CSS /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
	'title' => esc_html__('Custom CSS', 'medcity'),
	'icon' => 'el-icon-adjust-alt',
	'fields' => array(

		array(
			'id' => 'customcss',
			'type' => 'info',
			'desc' => esc_html__('Custom CSS', 'medcity'),
		),

		array(
			'id' => 'site_css',
			'type' => 'ace_editor',
			'title' => esc_html__('CSS Code', 'medcity'),
			'subtitle' => esc_html__('Advanced CSS Options. You can paste your custom CSS Code here.', 'medcity'),
			'mode' => 'css',
			'validate' => 'css',
			'theme' => 'chrome',
			'default' => "",
		),

	),
));