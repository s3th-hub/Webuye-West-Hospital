<?php

class ETC_CmsBlockquote_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_blockquote';
    protected $title = 'Blockquote';
    protected $icon = 'eicon-blockquote';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"content_section","label":"Content","tab":"content","controls":[{"name":"title_text","label":"Title","type":"text","label_block":true},{"name":"description_text","label":"Description","type":"textarea","rows":10,"show_label":false}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}