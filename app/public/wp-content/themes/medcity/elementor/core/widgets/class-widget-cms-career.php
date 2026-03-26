<?php

class ETC_CmsCareer_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_career';
    protected $title = 'Careers';
    protected $icon = 'eicon-menu-bar';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_career\/layout-image\/layout1.jpg"}}}]},{"name":"section_list","label":"Careers","tab":"content","controls":[{"name":"content_list","label":"Content","type":"repeater","default":[],"controls":[{"name":"title","label":"Title","type":"text","label_block":true},{"name":"time","label":"Time","type":"text"},{"name":"address","label":"Address","type":"text"},{"name":"description","label":"Description","type":"textarea"},{"name":"button_text","label":"Button Text","type":"text"},{"name":"button_link","label":"Button Link","type":"url"}],"title_field":"{{{ title }}}"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}