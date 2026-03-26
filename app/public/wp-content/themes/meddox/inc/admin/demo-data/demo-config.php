<?php

$uri = get_template_directory_uri() . '/inc/admin/demo-data/demo-imgs/';
$pxl_server_info = apply_filters( 'pxl_server_info', ['demo_url' => 'https://demo.bravisthemes.com/meddox/'] ) ; 
// Demos
$demos = array(
	// Elementor Demos
	'meddox' => array(
		'title'       => 'Meddox',	
		'description' => '',
		'screenshot'  => $uri . 'meddox.jpg',
		'preview'     => $pxl_server_info['demo_url'],
	),	 
);