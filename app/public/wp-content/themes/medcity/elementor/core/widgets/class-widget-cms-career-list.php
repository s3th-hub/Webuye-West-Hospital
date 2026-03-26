<?php

class ETC_CmsCareerList_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_career_list';
    protected $title = 'Career List';
    protected $icon = 'eicon-parallax';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_career_list\/layout-image\/layout1.jpg"}}}]},{"name":"content_list","label":"Content","tab":"content","controls":[{"name":"career","label":"Add Item","type":"repeater","controls":[{"name":"title","label":"Title","type":"text","label_block":true},{"name":"description","label":"Description","type":"textarea","label_block":true},{"name":"time","label":"Time","type":"text","label_block":true},{"name":"address","label":"Address","type":"text","label_block":true},{"name":"button_text","label":"Button Text","type":"text","separator":"after"},{"name":"button_link","label":"Button Link","type":"url"}],"title_field":"{{{ title }}}"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}