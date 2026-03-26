<?php

class ETC_CmsBannerBox_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_banner_box';
    protected $title = 'Banner Box';
    protected $icon = 'eicon-info-box';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_banner_box\/layout-image\/layout1.jpg"},"2":{"label":"Layout 2","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_banner_box\/layout-image\/layout2.jpg"},"3":{"label":"Layout 3","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_banner_box\/layout-image\/layout3.jpg"}}}]},{"name":"icon_section","label":"Banner Box","tab":"content","controls":[{"name":"image","label":"Choose Image","type":"media"},{"name":"thumbnail","label":"Image Size","type":"image-size","control_type":"group","default":"full"},{"name":"selected_icon","label":"Choose Icon","type":"icons","fa4compatibility":"icon","default":{"value":"","library":""}},{"name":"title_text","label":"Title","type":"text","default":"","placeholder":"Enter your title","label_block":true},{"name":"link","label":"Link","type":"url","condition":{"layout":"1"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}