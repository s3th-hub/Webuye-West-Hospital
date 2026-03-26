<?php

class PxlIconCart_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_icon_cart';
    protected $title = 'Shop Cart Pxl';
    protected $icon = 'eicon-cart-medium';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"source_section","label":"Source Settings","tab":"content","controls":[{"name":"pxl_icon","label":"Icon","type":"icons","fa4compatibility":"icon"},{"name":"icon_color","label":"Icon Color","type":"color","selectors":{"{{WRAPPER}} .pxl-cart-sidebar-button":"color: {{VALUE}};"}},{"name":"icon_color_hover","label":"Icon Color Hover","type":"color","selectors":{"{{WRAPPER}} .pxl-cart-sidebar-button:hover":"color: {{VALUE}};"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}