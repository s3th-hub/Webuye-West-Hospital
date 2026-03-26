<?php

class PxlQuote_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_quote';
    protected $title = 'Pxl Quote';
    protected $icon = 'eicon-blockquote';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"text","label":"Content Quote","type":"textarea"},{"name":"text_typography","label":"Typography Content ","type":"typography","control_type":"group","selector":"{{WRAPPER}} .pxl-quote .content-quote"},{"name":"author","label":"Author","type":"text"},{"name":"author_typography","label":"Typography Author ","type":"typography","control_type":"group","selector":"{{WRAPPER}} .pxl-quote .content-author"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}