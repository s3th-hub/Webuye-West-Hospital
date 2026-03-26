<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
get_template_part( 'inc/admin/libs/tgmpa/class-tgm-plugin-activation' );

add_action( 'tgmpa_register', 'meddox_register_required_plugins' );
function meddox_register_required_plugins() {
    include( locate_template( 'inc/admin/demo-data/demo-config.php' ) );
    $pxl_server_info = apply_filters( 'pxl_server_info', ['plugin_url' => 'https://api.bravisthemes.com/plugins/'] ) ; 
    $default_path = $pxl_server_info['plugin_url'];  
    $images = get_template_directory_uri() . '/inc/admin/assets/img/plugins';
    $plugins = array(

        array(
            'name'               => esc_html__('Redux Framework', 'meddox'),
            'slug'               => 'redux-framework',
            'required'           => true,
            'logo'        => $images . '/redux.png',
            'description' => esc_html__( 'Build theme options and post, page options for WordPress Theme.', 'meddox' ),
        ),

        array(
            'name'               => esc_html__('Elementor', 'meddox'),
            'slug'               => 'elementor',
            'required'           => true,
            'logo'        => $images . '/elementor.png',
            'description' => esc_html__( 'Introducing a WordPress website builder, with no limits of design. A website builder that delivers high-end page designs and advanced capabilities', 'meddox' ),
        ),

        array(
            'name'               => esc_html__('Bravis Addons', 'meddox'),
            'slug'               => 'bravis-addons',
            'source'             => 'bravis-addons.zip',
            'required'           => true,
            'logo'        => $images . '/bravis-logo.png',
            'description' => esc_html__( 'Main process and Powerful Elements Plugin, exclusively for Meddox WordPress Theme.', 'meddox' ),
        ),

        array(
            'name'               => esc_html__('Revolution Slider', 'meddox'),
            'slug'               => 'revslider',
            'source'             => 'revslider.zip',
            'required'           => false,
            'logo'        => $images . '/rev-slider.png',
            'description' => esc_html__( 'Revolution Slider helps beginner-and mid-level designers WOW their clients with pro-level visuals.', 'meddox' )
        ),
  
        array(
            'name'               => esc_html__('Contact Form 7', 'meddox'),
            'slug'               => 'contact-form-7',
            'required'           => true,
            'logo'        => $images . '/contact-f7.png',
            'description' => esc_html__( 'Contact Form 7 can manage multiple contact forms, you can customize the form and the mail contents flexibly with simple markup', 'meddox' ),
        ), 

        array(
            'name'               => esc_html__('Mailchimp', 'meddox'),
            'slug'               => "mailchimp-for-wp",
            'required'           => true,
            'logo'        => $images . '/mailchimp.png',
            'description' => esc_html__( 'Allowing your visitors to subscribe to your newsletter should be easy. With this plugin, it finally is.', 'meddox' ),
        ),
        array(
            'name'               => esc_html__('WooCommerce', 'meddox'),
            'slug'               => "woocommerce",
            'required'           => true,
            'logo'        => $images . '/woo.png',
            'description' => esc_html__( 'WooCommerce is the world’s most popular open-source eCommerce solution.', 'meddox' ),
        ),

        array(
            'name'               => esc_html__('Quick View', 'meddox'),
            'slug'               => "woo-smart-quick-view",
            'required'           => false, 
            'logo'        => $images . '/woo-smart-quickview.png',
            'description' => esc_html__( 'WPC Smart Quick View allows users to get a quick look of products without opening the product page.', 'meddox' ),
        ),
        array(
            'name'               => esc_html__('Wishlist', 'meddox'),
            'slug'               => "woo-smart-wishlist",
            'required'           => false,
            'logo'        => $images . '/woo-smart-wishlist.png',
            'description' => esc_html__( 'WPC Smart Wishlist is a simple but powerful tool that can help your customer save products for buying later.', 'meddox' ),
        ),
    );
 

    $config = array(
        'default_path' => $default_path,           // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'is_automatic' => true,
    );

    tgmpa( $plugins, $config );

}