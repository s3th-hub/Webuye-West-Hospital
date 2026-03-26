<?php

class ETC_CmsImagePointers_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_image_pointers';
    protected $title = 'Image with Pointers';
    protected $icon = 'eicon-info-box';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost:8888\/medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_image_pointers\/layout-image\/layout1.jpg"}}}]},{"name":"icon_section","label":"Banner Box","tab":"content","controls":[{"name":"box_style","label":"Box Style","type":"select","options":{"style1":"Default","style2":"Invert White"},"default":"style1"},{"name":"image_bg","label":"Backround Image","type":"media"},{"name":"content_list","label":"Pointers List","type":"repeater","default":[],"controls":[{"name":"content","label":"Content","type":"textarea","label_block":true},{"name":"content_hover","label":"Holder Style","type":"select","options":{"holder-right":"Holder Right","holder-left":"Holder Left"},"default":"holder-right"},{"name":"item_postion","label":"Item Postion","type":"dimensions","control_type":"responsive","allowed_dimensions":["top","left"],"size_units":["px","%"],"range":{"%":{"min":0,"max":100}},"selectors":{"{{WRAPPER}} {{CURRENT_ITEM}}.item-pointer":"top: {{TOP}}{{UNIT}};left: {{LEFT}}{{UNIT}}"}}],"title_field":"{{{ content }}}"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}