<?php
if(!class_exists('WPCF7') || empty($widget->get_setting('ctf7_id',''))) return;
$widget->add_render_attribute('wrap', [
    'id'    => 'cms-cf7-'.$settings['element_id'],
    'class' => [
        'cms-contact-form',
        'form-style-2'
    ]
]);
$widget->add_render_attribute('wrap-inner', [
    'class' => [
        'cms-contact-form-inner'
    ]
]);
// form title
$widget->add_render_attribute('form-title', [
    'class' => [
        'cms-heading',
        'form-title',
        'text-24',
        'mt-n8 pb-20',
        'empty-none'
    ]
]);
//form desc
$widget->add_render_attribute('form-desc',[
    'class' => [
        'form-desc',
        'text-14',
        'pb-35'
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div <?php etc_print_html($widget->get_render_attribute_string('wrap-inner')); ?>>
        <h3 <?php etc_print_html($widget->get_render_attribute_string('form-title')); ?>><?php 
            echo nl2br($settings['ctf7_title']);
        ?></h3>
        <div <?php etc_print_html($widget->get_render_attribute_string('form-desc')); ?>><?php 
            echo wpautop($settings['ctf7_description']);
        ?></div>
        <?php echo do_shortcode('[contact-form-7 id="'.esc_attr( $widget->get_setting('ctf7_id','')).'"]'); ?>
    </div>
</div>
