<?php

class ETC_CmsFeatureGrid_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_feature_grid';
    protected $title = 'Feature Grid';
    protected $icon = 'eicon-flash';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"section_list","label":"Content","tab":"content","controls":[{"name":"content_list","label":"Team List","type":"repeater","default":[],"controls":[{"name":"title","label":"Title","type":"text","label_block":true},{"name":"description","label":"Description","type":"textarea"},{"name":"btn_text","label":"Button Text","type":"text"},{"name":"link","label":"Button Link","type":"url"}],"title_field":"{{{ title }}}"}]},{"name":"grid_section","label":"Grid","tab":"content","controls":[{"name":"col_xs","label":"Columns XS Devices","type":"select","default":"1","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_sm","label":"Columns SM Devices","type":"select","default":"2","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_md","label":"Columns MD Devices","type":"select","default":"3","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_lg","label":"Columns LG Devices","type":"select","default":"4","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_xl","label":"Columns XL Devices","type":"select","default":"4","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array( 'imagesloaded','isotope','cms-post-grid-widget-js' );
}