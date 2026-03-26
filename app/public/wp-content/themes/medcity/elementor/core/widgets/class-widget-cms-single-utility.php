<?php

class ETC_CmsSingleUtility_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_single_utility';
    protected $title = 'Single Utilities';
    protected $icon = 'eicon-share';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_single_utility\/layout-image\/layout1.jpg"}}}]},{"name":"display_section","label":"Display Options","tab":"content","controls":[{"name":"show_tag_share","label":"Show Tag &amp; Share","type":"switcher","default":"true"},{"name":"show_post_nav","label":"Show Prev &amp; Next Post","type":"switcher","default":"true"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}