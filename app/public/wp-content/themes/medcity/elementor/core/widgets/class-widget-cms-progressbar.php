<?php

class ETC_CmsProgressbar_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_progressbar';
    protected $title = 'Progress Bar';
    protected $icon = 'eicon-skill-bar';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"source_section","label":"Source Settings","tab":"content","controls":[{"name":"progressbar_list","label":"Progress Bar Lists","type":"repeater","controls":[{"name":"title","label":"Title","type":"text","placeholder":"Enter your title","default":"My Skill","label_block":true},{"name":"percent","label":"Percentage","type":"slider","default":{"size":50,"unit":"%"},"label_block":true}]}]}]}';
    protected $styles = array(  );
    protected $scripts = array( 'cms-progressbar-widget-js' );
}