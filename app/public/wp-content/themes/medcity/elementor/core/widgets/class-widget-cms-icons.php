<?php

class ETC_CmsIcons_Widget extends Elementor_Theme_Core_Widget_Base{
    protected $name = 'cms_icons';
    protected $title = 'Icons';
    protected $icon = 'eicon-icon-box';
    protected $categories = array( 'elementor-theme-core' );
    protected $params = '{"sections":[{"name":"icon_section","label":"Icon Box","tab":"content","controls":[{"name":"icons","label":"Icon","type":"cms_icons"},{"name":"emoji","label":"Emoji","type":"emojionearea"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}