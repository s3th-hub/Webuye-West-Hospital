<?php
if(!function_exists('medcity_icons')){
	add_filter('tco_icon_picker_options', 'medcity_icons');  // add icon use in Theme Options
	add_filter('etc_icons_control_use_fontawesome', '__return_false'); // remove default font awesome use in Elementor Icon_Controls
	add_filter('etc_icons_control_custom_icons', 'medcity_icons'); // add icon use in Elementor Icon_Controls
	add_filter('cms_mega_menu/get_icons', 'medcity_icons'); // add icon use in Megamenu
	function medcity_icons($icons){
		$icons['Medcity Icons'] = [
			["medcity-icon-calendar"             => "calendar"],
			["medcity-icon-clock"                => "clock"],
			["medcity-icon-heart"                => "heart"],
			["medcity-icon-label"                => "label"],
			["medcity-icon-mail"                 => "mail"],
			["medcity-icon-user"                 => "user"],
			["medcity-icon-widgets"              => "widgets"],
			["medcity-icon-facebook"             => "facebook"],
			["medcity-icon-twitter"              => "twitter"],
			["medcity-icon-youtube"              => "youtube"],
			["medcity-icon-phone"                => "phone"],
			["medcity-icon-map"                  => "map"],
			["medcity-icon-check"                => "check"],
			["medcity-icon-arrow-up"             => "arrow-up"],
			["medcity-icon-arrow-right"          => "arrow-right"],
			["medcity-icon-circle-chevron-right" => "circle-chevron-right"],
			["medcity-icon-circle-chevron-down"  => "circle-chevron-down"]
		];
		return array_merge($icons);
	}
}

if (!function_exists('medcity_register_custom_icon_library_new')) {
  add_filter('elementor/icons_manager/native', 'medcity_register_custom_icon_library_new');
  function medcity_register_custom_icon_library_new($tabs)
  {
    $tabs['cmsi_medcity'] = [
      'name'          => 'cmsi-medcity',
      'label'         => esc_html__('CMS Medcity', 'medcity'),
      'url'           => get_template_directory_uri() . '/assets/fonts/medcity/style.css',
      'enqueue'       => [],
      'prefix'        => '',
      'displayPrefix' => '',
      'labelIcon'     => 'medcity-icon-widgets',
      'ver'           => '1.0.0',
      'fetchJson'     => get_template_directory_uri() . '/assets/fonts/medcity/font-medcity.js',
      'native'        => true
    ];
    return $tabs;
  }
}