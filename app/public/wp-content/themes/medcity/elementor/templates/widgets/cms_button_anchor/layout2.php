<?php 
$widget->add_render_attribute('anchor',[
    'class' => [
        'cms-anchor-up',
        'circle',
        'd-flex align-items-center justify-content-center',
        'bg-primary bg-hover-tertiary',
        'text-white text-hover-white text-12'
    ],
    'href'  => '#'.$settings['anchor_id'],
    'target' => '_self'
]);
?>
<a <?php etc_print_html($widget->get_render_attribute_string('anchor')); ?>><?php 
    medcity_svgs_icon_render([
        'icon' => 'arrow-up',
        'echo' => true
    ]);
?></a>
