<?php
if(empty($settings['menu'])) return;
// Wrap
$widget->add_render_attribute('wrap',[
    'cms-emenu',
    'cms-emenu-'.$settings['layout']
]);
// Heading
$widget->add_render_attribute('heading', [
    'class' => [
        'cms-eheading cms-heading heading text-18 lh-1375 mt-n10 pb-25',
        'font-700',
        $settings['widget_title_class']
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php if(!empty($settings['widget_title'])) : ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('heading')); ?>><?php etc_print_html( nl2br($settings['widget_title']) ); ?></div>
    <?php endif; ?>
    <?php wp_nav_menu(array(
            'fallback_cb' => '',
            //'walker'      => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
            'menu'        => $settings['menu'],
            'menu_class'  => 'cms--emenu-'.$settings['layout'],
            'depth'       => 1  
        )
    ); ?>
</div>