<?php

class PxlInstagram_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_instagram';
    protected $title = 'Pxl Instagram';
    protected $icon = 'eicon-instagram-gallery';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"tab_content","label":"Content","tab":"content","controls":[{"name":"icon_heading","label":"Icon Heading","type":"icons","label_block":true,"fa4compatibility":"icon"},{"name":"heading","label":"Heading","type":"text","default":"Click Here"},{"name":"images","label":"Images","type":"gallery","label_block":true},{"name":"img_size","label":"Image Size","type":"text","description":"Enter image size (Example: \"thumbnail\", \"medium\", \"large\", \"full\" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)."},{"name":"item_active","label":"Item Active","type":"number"},{"name":"ins_link","label":"Account Link","type":"url"},{"name":"item_width","label":"Item Width","type":"slider","control_type":"responsive","size_units":["px","%"],"range":{"px":{"min":0,"max":3000}},"selectors":{"{{WRAPPER}} .pxl-instagram1 .pxl--item":"width: {{SIZE}}{{UNIT}};"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}