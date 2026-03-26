<?php

class ETC_CmsButtonAnchor_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_button_anchor';
    protected $title = 'Button Anchor';
    protected $icon = 'eicon-anchor';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost:8888\/medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_button_anchor\/layout\/1.webp"},"2":{"label":"Layout 2","image":"http:\/\/localhost:8888\/medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_button_anchor\/layout\/2.webp"}}}]},{"name":"content_section","label":"CMS Anchor","tab":"content","controls":[{"name":"anchor_id","label":"The ID of Menu Anchor.","type":"text","placeholder":"For Example: About","description":"This ID will be the CSS ID you will have to use in your own page, Without #.","label_block":true},{"name":"anchor_note","type":"raw_html","raw":"Note: The ID link ONLY accepts these chars: `A-Z, a-z, 0-9, _ , -`","content_classes":"elementor-panel-alert elementor-panel-alert-warning"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}