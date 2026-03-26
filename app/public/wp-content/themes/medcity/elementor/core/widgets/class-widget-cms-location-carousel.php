<?php

class ETC_CmsLocationCarousel_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_location_carousel';
    protected $title = 'Location Carousel';
    protected $icon = 'eicon-map-pin';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 4","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_location_carousel\/layout-image\/layout1.jpg"}}}]},{"name":"section_boxs","label":"Box Settings","tab":"content","controls":[{"name":"boxs","label":"","type":"repeater","default":[],"controls":[{"name":"box_text_sub","label":"Location Subtitle","type":"textarea","label_block":true,"default":""},{"name":"box_text_title","label":"Location Title","type":"textarea","label_block":true,"default":""},{"name":"box_text","label":"Location Detail","type":"textarea","label_block":true,"default":""}]}]},{"name":"section_carousel_settings","label":"Carousel Settings","tab":"settings","controls":[{"name":"arrows","label":"Show Arrows","type":"switcher","default":"true"},{"name":"dots","label":"Show Dots","type":"switcher","default":"false"},{"name":"pause_on_hover","label":"Pause on Hover","type":"switcher"},{"name":"autoplay","label":"Autoplay","type":"switcher"},{"name":"autoplay_speed","label":"Autoplay Speed","type":"number","default":5000,"condition":{"autoplay":"true"}},{"name":"infinite","label":"Infinite Loop","type":"switcher"},{"name":"speed","label":"Animation Speed","type":"number","default":500}]}]}';
    protected $styles = array(  );
    protected $scripts = array( 'jquery-slick','cms-clients-list-widget-js' );
}