<?php

class ETC_CmsTextEditor_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_text_editor';
    protected $title = 'Text Editor';
    protected $icon = 'eicon-text';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"editor_section","label":"Text Editor","tab":"content","controls":[{"name":"text_editor","label":"","type":"wysiwyg","default":"Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."}]},{"name":"section_style_content","label":"Content Alignment","tab":"style","controls":[{"name":"align","label":"Alignment","type":"choose","control_type":"responsive","options":{"left":{"title":"Left","icon":"eicon-text-align-left"},"center":{"title":"Center","icon":"eicon-text-align-center"},"right":{"title":"Right","icon":"eicon-text-align-right"},"justify":{"title":"Justified","icon":"eicon-text-align-justify"}},"selectors":{"{{WRAPPER}} .elementor-text-editor":"text-align: {{VALUE}};"}},{"name":"text_color","label":"Text Color","type":"color","default":"","selectors":{"{{WRAPPER}}":"color: {{VALUE}};"}},{"name":"typography","type":"typography","control_type":"group"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}