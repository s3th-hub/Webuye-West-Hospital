<?php

class ETC_CmsTestimonials_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_testimonials';
    protected $title = 'Testimonials';
    protected $icon = 'eicon-testimonial';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"layout_section","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","prefix_class":"cms-testimonials-layout","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/medcity\/wp-content\/themes\/medcity\/elementor\/templates\/widgets\/cms_testimonials\/layout-image\/layout1.jpg"}}}]},{"name":"image_section","label":"Image Box","tab":"content","controls":[{"name":"testimonials_text","label":"Content","type":"textarea","default":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.","placeholder":"Enter your description","rows":10,"show_label":false},{"name":"image","label":"Choose Image","type":"media"},{"name":"name_text","label":"Title","type":"text","default":"John Doe","label_block":true},{"name":"job_text","label":"Position","type":"text","default":"Designer","label_block":true},{"name":"wg_title","label":"Widget Title","type":"text","default":"Client\u2019s Testimonials","label_block":true}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}