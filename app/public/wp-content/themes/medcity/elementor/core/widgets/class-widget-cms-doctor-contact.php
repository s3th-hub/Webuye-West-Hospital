<?php

class ETC_CmsDoctorContact_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_doctor_contact';
    protected $title = 'Doctor Contact';
    protected $icon = 'eicon-user-circle-o';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost:8888\/medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_doctor_contact\/layout-image\/layout1.jpg"}}}]},{"name":"content_list","label":"Content","tab":"content","controls":[{"name":"image","label":"Doctor Image","type":"media"},{"name":"name","label":"Doctor Name","type":"text","label_block":true},{"name":"position","label":"Position","type":"text"},{"name":"information","label":"Add Item","type":"repeater","controls":[{"name":"label","label":"Label","type":"text","label_block":true},{"name":"text","label":"Info Text","type":"textarea","label_block":true}],"title_field":"{{{ label }}}"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}