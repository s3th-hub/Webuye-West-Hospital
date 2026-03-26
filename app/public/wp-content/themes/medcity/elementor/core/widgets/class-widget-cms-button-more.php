<?php

class ETC_CmsButtonMore_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_button_more';
    protected $title = 'Button Read More';
    protected $icon = 'eicon-button';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"content_section","label":"Content","tab":"content","controls":[{"name":"style","label":"Style","type":"select","default":"more-default","options":{"more-default":"Default","more-invert":"Invert","hover-scale":"Scale Hover"}},{"name":"text","label":"Text","type":"text","default":"Read More"},{"name":"link","label":"Link","type":"url","placeholder":"https:\/\/your-link.com","default":{"url":"#"}},{"name":"align","label":"Alignment","type":"choose","options":{"left":{"title":"Left","icon":"fa fa-align-left"},"center":{"title":"Center","icon":"fa fa-align-center"},"right":{"title":"Right","icon":"fa fa-align-right"}},"prefix_class":"elementor-align-","default":""}]},{"name":"style_section","label":"Text Style","tab":"style","controls":[{"name":"button_color","label":"Button Color","type":"color","selectors":{"{{WRAPPER}} .cms-button-readmore .btn-read-more":"color: {{VALUE}};","{{WRAPPER}} .cms-button-readmore .btn-read-more i":"background-color: {{VALUE}};"}},{"name":"icon_color","label":"Icon Color","type":"color","selectors":{"{{WRAPPER}} .cms-button-readmore .btn-read-more i":"color: {{VALUE}};"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}