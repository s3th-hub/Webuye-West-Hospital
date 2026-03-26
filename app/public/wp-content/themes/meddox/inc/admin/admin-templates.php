<?php

if( !defined( 'ABSPATH' ) )
	exit; 

class Meddox_Admin_Templates extends Meddox_Base{

	public function __construct() {
		$this->add_action( 'admin_menu', 'register_page', 20 );
	}
 
	public function register_page() {
		add_submenu_page(
			'pxlart',
		    esc_html__( 'Templates', 'meddox' ),
		    esc_html__( 'Templates', 'meddox' ),
		    'manage_options',
		    'edit.php?post_type=pxl-template',
		    false
		);
	}
}
new Meddox_Admin_Templates;
