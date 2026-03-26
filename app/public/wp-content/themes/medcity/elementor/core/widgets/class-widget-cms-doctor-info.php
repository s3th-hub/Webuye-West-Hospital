<?php

class ETC_CmsDoctorInfo_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_doctor_info';
    protected $title = 'Doctor Information';
    protected $icon = 'eicon-preferences';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost:8888\/medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_doctor_info\/layout-image\/layout1.jpg"}}}]},{"name":"content_section","label":"Description","tab":"content","controls":[{"name":"description","label":"Description For Current Doctor","type":"textarea","label_block":true},{"name":"show_facebook","label":"Show Facebook","type":"switcher","default":"true"},{"name":"show_instagram","label":"Show Instagram","type":"switcher","default":"false"},{"name":"show_twitter","label":"Show Twitter","type":"switcher","default":"true"},{"name":"show_email","label":"Show Email","type":"switcher","default":"true"},{"name":"show_phone","label":"Show Phone","type":"switcher","default":"true"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}