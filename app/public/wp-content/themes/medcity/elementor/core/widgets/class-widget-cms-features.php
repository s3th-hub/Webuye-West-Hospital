<?php

class ETC_CmsFeatures_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_features';
    protected $title = 'Feature';
    protected $icon = 'eicon-icon-box';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_features\/layout-image\/layout1.jpg"},"2":{"label":"Layout 1","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_features\/layout-image\/layout2.jpg"}}}]},{"name":"features_section","label":"Feature Content","tab":"content","controls":[{"name":"title_text","label":"Title","type":"text","placeholder":"Enter your title","label_block":true},{"name":"description_text","label":"Description","type":"textarea","placeholder":"Enter your description","rows":10,"show_label":false},{"name":"btn_text","label":"Button Text","type":"text","condition":{"layout":"2"}},{"name":"btn_link","label":"Button Link","type":"url","condition":{"layout":"2"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}