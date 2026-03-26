<?php
add_action('after_setup_theme', 'bravisthemes_setup_theme_option', 1);
function bravisthemes_setup_theme_option(){
    if (!class_exists('ReduxFramework')) {
        return;
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
    }

    $opt_name = meddox()->get_option_name();
    $version = meddox()->get_version();

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => '', //$theme->get('Name'),
        // Name that appears at the top of your panel
        'display_version'      => $version,
        // Version that appears at the top of your panel
        'menu_type'            => 'submenu', //class_exists('Pxltheme_Core') ? 'submenu' : '',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__('Theme Options', 'meddox'),
        'page_title'           => esc_html__('Theme Options', 'meddox'),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => true,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
        'show_options_object' => false,
        // OPTIONAL -> Give you extra features
        'page_priority'        => 80,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'pxlart', //class_exists('meddox_Admin_Page') ? 'case' : '',
        // For a full list of options, visit: //codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'pxlart-theme-options',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        ),
    );

    Redux::SetArgs($opt_name, $args);

    /*--------------------------------------------------------------
    # General
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('General', 'meddox'),
        'icon'   => 'el-icon-home',
        'fields' => array(
            array(
                'id'       => 'favicon',
                'type'     => 'media',
                'title'    => esc_html__('Favicon', 'meddox'),
                'default'  => '',
                'url'      => false
            ),
            array(
                'id'       => 'site_loader',
                'type'     => 'switch',
                'title'    => esc_html__('Loader', 'meddox'),
                'default'  => false
            ),
            array(
                'id'    => 'loader_style',
                'type'  => 'select',
                'title' => esc_html__('Loader Style', 'meddox'),
                'options' => [
                    'style-kindergarten'           => esc_html__('Kindergarten', 'meddox'),
                    'style-default'           => esc_html__('Medical', 'meddox'),

                ],
                'default' => 'style-default',
                'indent' => true,
                'required' => array( 0 => 'site_loader', 1 => 'equals', 2 => true ),
            ),
        )
    ));

    /*--------------------------------------------------------------
    # Colors
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Colors', 'meddox'),
        'icon'   => 'el-icon-file-edit',
        'fields' => array(
            array(
                'id'          => 'primary_color',
                'type'        => 'color',
                'title'       => esc_html__('Primary Color', 'meddox'),
                'transparent' => false,
                'default'     => ''
            ),
            array(
                'id'          => 'secondary_color',
                'type'        => 'color',
                'title'       => esc_html__('Secondary Color', 'meddox'),
                'transparent' => false,
                'default'     => ''
            ),
            array(
                'id'          => 'regular_color',
                'type'        => 'color',
                'title'       => esc_html__('Regular Color', 'meddox'),
                'transparent' => false,
                'default'     => ''
            ),
            array(
                'id'          => 'fourth_color',
                'type'        => 'color',
                'title'       => esc_html__('Fourth Color', 'meddox'),
                'transparent' => false,
                'default'     => ''
            ),
            array(
                'id'          => 'fifth_color',
                'type'        => 'color',
                'title'       => esc_html__('Fifrth Color', 'meddox'),
                'transparent' => false,
                'default'     => ''
            ),
        )
    ));

    /*--------------------------------------------------------------
    # Header
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Header', 'meddox'),
        'icon'   => 'el el-indent-left',
        'fields' => array_merge(
            meddox_header_opts(),
            array(
                array(
                    'id'       => 'sticky_scroll',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Sticky Scroll', 'meddox'),
                    'options'  => array(
                        'pxl-sticky-stt' => esc_html__('Scroll To Top', 'meddox'),
                        'pxl-sticky-stb'  => esc_html__('Scroll To Bottom', 'meddox'),
                    ),
                    'default'  => 'pxl-sticky-stb',
                ),
            )
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Mobile', 'meddox'),
        'icon'       => 'el el-picture',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'logo_m',
                'type'     => 'media',
                'title'    => esc_html__('Select Logo', 'meddox'),
                'default' => array(
                    'url'=>get_template_directory_uri().'/assets/img/logo.png'
                ),
                'url'      => false
            ),
            array(
                'id'       => 'logo_height',
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Height', 'meddox'),
                'width'    => false,
                'unit'     => 'px',
                'output'    => array('#pxl-header-default .pxl-header-branding img, .pxl-logo-mobile img'),
            ),
            array(
                'id'       => 'search_mobile',
                'type'     => 'switch',
                'title'    => esc_html__('Search Form', 'meddox'),
                'default'  => true
            )
        )
    ));

    /*--------------------------------------------------------------
    # Page Title area
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Page Title', 'meddox'),
        'icon'   => 'el-icon-map-marker',
        'fields' => array_merge(
            meddox_page_title_opts() 
        )
    ));


    /*--------------------------------------------------------------
    # Footer
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Footer', 'meddox'),
        'icon'   => 'el el-website',
        'fields' => array_merge(
            meddox_footer_opts(),
            array(
                array(
                    'id'       => 'back_totop_on',
                    'type'     => 'switch',
                    'title'    => esc_html__('Button Back to Top', 'meddox'),
                    'default'  => false,
                ),
                array(
                    'id'       => 'footer_fixed',
                    'type'     => 'switch',
                    'title'    => esc_html__('Footer Fixed', 'meddox'),
                    'default'  => false,
                )
            ) 
        )
        
    ));

    /*--------------------------------------------------------------
    # WordPress default content
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title' => esc_html__('Blog Archive', 'meddox'),
        'icon'  => 'el-icon-pencil',
        'fields'     => array_merge(
            meddox_sidebar_pos_opts([ 'prefix' => 'blog_']),
            array(
                array(
                    'id'       => 'archive_date',
                    'title'    => esc_html__('Date', 'meddox'),
                    'subtitle' => esc_html__('Display the Date for each blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true,
                ),
                array(
                    'id'       => 'archive_comments',
                    'title'    => esc_html__('Comment', 'meddox'),
                    'subtitle' => esc_html__('Display the Category for each blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true,
                ),
                array(
                    'id'       => 'archive_author',
                    'title'    => esc_html__('Author', 'meddox'),
                    'subtitle' => esc_html__('Display the Category for each blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true,
                ),
                array(
                    'id'      => 'archive_excerpt_length',
                    'type'    => 'text',
                    'title'   => esc_html__('Excerpt Length', 'meddox'),
                    'default' => '',
                    'subtitle' => esc_html__('Default: 50', 'meddox'),
                ),
                array(
                    'id'      => 'archive_readmore_text',
                    'type'    => 'text',
                    'title'   => esc_html__('Read More Text', 'meddox'),
                    'default' => '',
                    'subtitle' => esc_html__('Default: Read more', 'meddox'),
                )
            )
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Single Post', 'meddox'),
        'icon'       => 'el-icon-file-edit',
        'subsection' => true,
        'fields'     => array_merge(
            meddox_sidebar_pos_opts([ 'prefix' => 'post_']),
            array(
                
                array(
                    'id'       => 'single_post_title_layout',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Post title layout', 'meddox'),
                    'options'  => array(
                        '0' => esc_html__('Default', 'meddox'),
                        '1' => esc_html__('Custom Post Title', 'meddox'),
                    ),
                    'default'  => '1'
                ),
                array(
                    'id'       => 'post_custom_title',
                    'title'    => esc_html__('Custom Post Title', 'meddox'),
                    'subtitle' => esc_html__('Show custom post title instead of post title.', 'meddox'),
                    'type'     => 'text',
                    'default'  => esc_html__('Blog details', 'meddox'),
                    'required'      => [ 'single_post_title_layout', '=', '1']
                ),

                array(
                    'id'       => 'post_date',
                    'title'    => esc_html__('Date', 'meddox'),
                    'subtitle' => esc_html__('Display the Date for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true
                ),
                array(
                    'id'       => 'post_comments',
                    'title'    => esc_html__('comments', 'meddox'),
                    'subtitle' => esc_html__('Display the comments for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true
                ),
                array(
                    'id'       => 'post_author',
                    'title'    => esc_html__('Author', 'meddox'),
                    'subtitle' => esc_html__('Display the Author for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true
                ),
                array(
                    'id'       => 'post_category',
                    'title'    => esc_html__('Categories', 'meddox'),
                    'subtitle' => esc_html__('Display the Category for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true
                ),
                array(
                    'id'       => 'post_tag',
                    'title'    => esc_html__('Tags', 'meddox'),
                    'subtitle' => esc_html__('Display the Tag for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true
                ),
                array(
                    'id'       => 'post_navigation',
                    'title'    => esc_html__('Navigation', 'meddox'),
                    'subtitle' => esc_html__('Display the Navigation for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => false,
                ),
                array(
                    'id'       => 'post_related',
                    'title'    => esc_html__('Related Post', 'meddox'),
                    'subtitle' => esc_html__('Display the Navigation for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => false,
                ),
                array(
                    'id'       => 'post_author_box_info',
                    'title'    => esc_html__('Author', 'meddox'),
                    'subtitle' => esc_html__('Display the Author for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => false,
                ),
                array(
                    'title' => esc_html__('Social', 'meddox'),
                    'type'  => 'section',
                    'id' => 'social_section',
                    'indent' => true,
                ),
                array(
                    'id'       => 'post_social_share',
                    'title'    => esc_html__('Social', 'meddox'),
                    'subtitle' => esc_html__('Display the Social Share for blog post.', 'meddox'),
                    'type'     => 'switch',
                    'default'  => false,
                ),
                array(
                    'id'       => 'social_facebook',
                    'title'    => esc_html__('Facebook', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true,
                    'indent' => true,
                    'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
                ),
                array(
                    'id'       => 'social_twitter',
                    'title'    => esc_html__('Twitter', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true,
                    'indent' => true,
                    'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
                ),
                array(
                    'id'       => 'social_instagram',
                    'title'    => esc_html__('Instagram', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true,
                    'indent' => true,
                    'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
                ),
                array(
                    'id'       => 'social_linkedin',
                    'title'    => esc_html__('Linkedin', 'meddox'),
                    'type'     => 'switch',
                    'default'  => true,
                    'indent' => true,
                    'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
                ),
            )
    )
    ));

    /*--------------------------------------------------------------
    # Woocommerce
    --------------------------------------------------------------*/
    if(class_exists('Woocommerce')) {
        Redux::setSection($opt_name, array(
            'title' => esc_html__('Woocommerce', 'meddox'),
            'icon'  => 'el el-shopping-cart',
            'fields'     => array_merge(
                meddox_sidebar_pos_opts([ 'prefix' => 'shop_']),
                array(
                    array(
                        'id'       => 'shop_display_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Display Type', 'meddox'),
                        'options'  => array(
                            'grid' => esc_html__('Grid', 'meddox'),
                            'list' => esc_html__('List', 'meddox'),
                        ),
                        'default'  => 'grid'
                    ),
                    array(
                        'title'         => esc_html__('Products displayed per row', 'meddox'),
                        'id'            => 'products_columns',
                        'type'          => 'slider',
                        'subtitle'      => esc_html__('Number product to show per row', 'meddox'),
                        'default'       => 3,
                        'min'           => 2,
                        'step'          => 1,
                        'max'           => 6,
                        'display_value' => 'text'
                    ),
                    array(
                        'title'         => esc_html__('Products displayed per page', 'meddox'),
                        'id'            => 'product_per_page',
                        'type'          => 'slider',
                        'subtitle'      => esc_html__('Number product to show', 'meddox'),
                        'default'       => 9,
                        'min'           => 3,
                        'step'          => 1,
                        'max'           => 50,
                        'display_value' => 'text'
                    ),
                )
            )
        ));

        Redux::setSection($opt_name, array(
            'title'      => esc_html__('Single Product', 'meddox'),
            'icon'       => 'el el-shopping-cart',
            'subsection' => true,
            'fields'     => array_merge(
                meddox_sidebar_pos_opts([ 'prefix' => 'product_']),
                array(
                    array(
                        'id'       => 'product_related',
                        'title'    => esc_html__('Product Related', 'meddox'),
                        'subtitle' => esc_html__('Show/Hide related product', 'meddox'),
                        'type'     => 'switch',
                        'default'  => '1',
                    ),    
                )
            )
        ));
    }
    /*--------------------------------------------------------------
    # Typography
    --------------------------------------------------------------*/
    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Typography', 'meddox'),
        'icon'   => 'el-icon-text-width',
        'fields' => array(
            array(
                'id'          => 'font_body',
                'type'        => 'typography',
                'title'       => esc_html__('Body', 'meddox'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'line-height'  => true,
                'font-size'  => true,
                'text-align'  => false,
                'units'       => 'px',
            ),
            array(
                'id'          => 'font_h1',
                'type'        => 'typography',
                'title'       => esc_html__('Heading 1', 'meddox'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'units'       => 'px',
            ),
            array(
                'id'          => 'font_h2',
                'type'        => 'typography',
                'title'       => esc_html__('Heading 2', 'meddox'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'units'       => 'px',
            ),
            array(
                'id'          => 'font_h3',
                'type'        => 'typography',
                'title'       => esc_html__('Heading 3', 'meddox'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'units'       => 'px',
            ),
            array(
                'id'          => 'font_h4',
                'type'        => 'typography',
                'title'       => esc_html__('Heading 4', 'meddox'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'units'       => 'px',
            ),
            array(
                'id'          => 'font_h5',
                'type'        => 'typography',
                'title'       => esc_html__('Heading 5', 'meddox'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'units'       => 'px',
            ),
            array(
                'id'          => 'font_h6',
                'type'        => 'typography',
                'title'       => esc_html__('Heading 6', 'meddox'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'units'       => 'px',
            ),
            array(
                'id'          => 'theme_default',
                'type'        => 'typography',
                'title'       => esc_html__('Theme Default', 'meddox'),
                'google'      => true,
                'font-backup' => false,
                'all_styles'  => false,
                'line-height'  => false,
                'font-size'  => false,
                'color'  => false,
                'font-style'  => false,
                'font-weight'  => false,
                'text-align'  => false,
                'units'       => 'px',
            ),
        )
    ));
}