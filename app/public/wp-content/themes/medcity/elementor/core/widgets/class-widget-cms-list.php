<?php

class ETC_CmsList_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_list';
    protected $title = 'Lists';
    protected $icon = 'eicon-editor-list-ul';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"section_list","label":"List Items","tab":"content","controls":[{"name":"list","label":"Info Lists","type":"repeater","default":[],"controls":[{"name":"content","label":"Content","type":"text","label_block":true}],"title_field":"{{{ content }}}"},{"name":"content_color","label":"Content Color","type":"color","selectors":{"{{WRAPPER}} .cms-list":"color: {{VALUE}};"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}