<?php

class ETC_CmsContactInfo_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_contact_info';
    protected $title = 'Contact Info';
    protected $icon = 'eicon-info-circle-o';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/wp_medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_contact_info\/layout-image\/layout1.jpg"}}}]},{"name":"section_contact_info","label":"Contact Info","tab":"content","controls":[{"name":"label","label":"Label","type":"text"},{"name":"content","label":"Content","type":"textarea","label_block":true},{"name":"cms_icon","label":"Icon","type":"icons","fa4compatibility":"icon","default":{"value":"fas fa-star","library":"fa-solid"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}