<?php

class ETC_CmsGalleryGrid_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_gallery_grid';
    protected $title = 'Gallery Grid';
    protected $icon = 'eicon-image';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"content_section","label":"Content","tab":"content","controls":[{"name":"image","label":"Image","type":"gallery","label_block":true}]},{"name":"grid_section","label":"Grid","tab":"content","controls":[{"name":"size_list","label":"Image Size List","type":"text","description":"Enter image size (Example: \"thumbnail\", \"medium\", \"large\", \"full\" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height). Enter multiple sizes (Example: 100x100,200x200,300x300))."},{"name":"col_xs","label":"Columns XS Devices","type":"select","default":"1","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_sm","label":"Columns SM Devices","type":"select","default":"2","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_md","label":"Columns MD Devices","type":"select","default":"3","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_lg","label":"Columns LG Devices","type":"select","default":"4","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}},{"name":"col_xl","label":"Columns XL Devices","type":"select","default":"4","options":{"1":"1","2":"2","3":"3","4":"4","6":"6"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array( 'imagesloaded','isotope','cms-post-grid-widget-js' );
}