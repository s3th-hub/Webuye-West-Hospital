<?php

class ETC_CmsPointer_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_pointer';
    protected $title = 'Pointer';
    protected $icon = 'eicon-cursor-move';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"content_section","label":"Content","tab":"content","controls":[{"name":"number","label":"Number","type":"text"},{"name":"title","label":"Title","type":"text","label_block":true},{"name":"active","label":"Actvie","type":"select","options":{"":"No","open":"Yes"},"default":""},{"name":"position_top","label":"Position Top","type":"dimensions","size_units":["px","em","%"],"selectors":{"{{WRAPPER}} .cms-pointer1":"top: {{TOP}}{{UNIT}};"},"allowed_dimensions":["top"]},{"name":"position_right","label":"Position Right","type":"dimensions","size_units":["px","em","%"],"selectors":{"{{WRAPPER}} .cms-pointer1":"right: {{RIGHT}}{{UNIT}};"},"allowed_dimensions":["right"]},{"name":"position_bottom","label":"Position Bottom","type":"dimensions","size_units":["px","em","%"],"selectors":{"{{WRAPPER}} .cms-pointer1":"bottom: {{BOTTOM}}{{UNIT}};"},"allowed_dimensions":["bottom"]},{"name":"position_left","label":"Position Left","type":"dimensions","size_units":["px","em","%"],"selectors":{"{{WRAPPER}} .cms-pointer1":"left: {{LEFT}}{{UNIT}};"},"allowed_dimensions":["left"]}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}