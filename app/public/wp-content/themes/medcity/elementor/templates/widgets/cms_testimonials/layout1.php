<?php
$default_align = 'start';
$testimonials = $widget->get_setting('testimonials', []);
$layout_mode = $widget->get_setting('layout_mode', 'carousel');

// Arrows
$arrows = $widget->get_setting('arrows');
$arrows_type = $widget->get_setting('arrows_type', 'icon');
$arrows_icon_size = ($arrows_type === 'icon') ? 45 : 10; 
// Dots
$dots = $widget->get_setting('dots');
$dots_type = $widget->get_setting('dots_type', 'bullets');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 46,
    'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 46
];
$widget->add_render_attribute('dots',[
    'class' => [
        'cms-carousel-dots cms-carousel-dots-'.$settings['dots_type'],
        'mt-0'
    ]
]);
if($settings['dots_type'] != 'custom'){
    $widget->add_render_attribute('dots', [
        'class' => 'cms-carousel-dots-secondary cms-carousel-dots-active-primary'
    ]);
}
// Wrap
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-ettmn',
        'cms-ettmn-'.$widget->get_setting('layout_mode', $layout_mode),
        'cms-ettmn-'.$settings['layout'],
        'text-'.$default_align
    ]
]);
if($layout_mode == 'grid'){
    $widget->add_render_attribute('wrap', [
        'class' => [
            'd-flex gutter',
            medcity_elementor_get_grid_columns($widget, $settings)
        ]
    ]);
}
// Description 
$widget->add_render_attribute('description',[
    'class' => [
       'cms-ttmn-desc heading text-23 lh-1826 font-500 font-italic',
       'text-'.$widget->get_setting('desc_color','secondary')
    ]
]);
// Author Name
$widget->add_render_attribute('ttmn-author',[
    'class' => [
        'cms-ttmn--name heading text-16 font-500 empty-none',
        'text-'.$widget->get_setting('author_color', 'secondary')
    ]
]);
// Author Position
$widget->add_render_attribute('ttmn-author-pos',[
    'class' => [
        'cms-ttmn--pos text-13',
        'text-'.$widget->get_setting('author_pos_color', 'body')
    ]
]);
// Items
$widget->add_render_attribute('ttmn-item',[
    'class' => [
        'cms-ttmn-item'
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php switch ($layout_mode) {
        case 'grid':
            $widget->add_render_attribute('ttmn-item', [
                'class' => 'cms-ttmn-grid-item'
            ]);
            break;
        
        default:
            $widget->add_render_attribute('ttmn-item', [
                'class' => 'cms-carousel-item swiper-slide'
            ]);
    ?>
        <div class="cms-carousel swiper">
            <div class="swiper-wrapper">
    <?php
            break;
    } ?>
    
            <?php foreach ($testimonials as $key => $testimonial) {
                $testimonial['image_size'] = $settings['image_size'];
                $testimonial['image_custom_dimension'] = $thumbnail_custom_dimension;
            ?>
                <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-item')); ?>>
                    <div class="cms-ttmn--item  swiper-nav-vert">
                        <div <?php etc_print_html($widget->get_render_attribute_string('description')); ?>><?php 
                            etc_print_html($testimonial['description']); 
                        ?></div>
                        <?php if( $dots!=='yes' || ($dots=='yes' && $dots_type!=='custom') || $settings['layout_mode'] == 'grid'){ ?>
                            <div class="cms-ttmn-info pt-40 d-flex flex-nowrap gap-20 align-items-center">
                                <?php
                                    medcity_elementor_image_render($testimonial,[
                                        'name'           => 'image',
                                        'image_size_key' => 'image',
                                        'img_class'      => 'cms-ttmn--img circle cms-img-stroke',
                                        'custom_size'    => $thumbnail_custom_dimension,
                                        'before'         => '<div class="cms-ttmn-img flex-auto">',
                                        'after'          => '</div>'
                                    ]);
                                ?>
                                <div class="flex-basic">
                                    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
                                    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
    <?php switch ($layout_mode) {
        case 'grid':
            // code...
            break;
        default:
            // code...
    ?>
            </div>
        </div>
        <div class="cms-carousel-nav-dots d-flex flex-nowrap gap align-items-center pt-40">
            <?php // Arrows
            if ($arrows == 'yes') : ?>
                <div class="cms-carousel-buttons flex-auto d-flex justify-content-end gap-30">
                    <div class="cms-carousel-button-hover-circle cms-carousel-button-prev">
                        <?php
                            medcity_elementor_icon_render($settings['arrow_prev_icon'], ['library' => 'cms-svg','value'   => 'arrow-prev'],['aria-hidden' => 'true', 'class' => '', 'icon_size'=>15]);
                        ?>
                    </div>
                    <div class="cms-carousel-button-hover-circle cms-carousel-button-next">
                        <?php
                            medcity_elementor_icon_render($settings['arrow_next_icon'],['library' => 'cms-svg','value'   => 'arrow-next'],['aria-hidden' => 'true', 'class' => '', 'icon_size'=>15]);
                        ?>
                    </div>
                </div>
            <?php endif;
            if ($dots == 'yes') : 
                if($dots_type == '-----custom'){
                ?>
                <div class="flex-basic">
                    <div class="thumbs-slider swiper">
                        <div class="swiper-wrapper cms-carousel-dots-sync-<?php echo esc_attr($settings['element_id']); ?>">
                            <?php foreach ($testimonials as $key => $testimonial) {
                                $testimonial['image_size'] = $settings['image_size'];
                                $testimonial['image_custom_dimension'] = $thumbnail_custom_dimension;
                                ?>
                                <div class="swiper-slide d-flex flex-nowrap gap-30 align-items-center pl-8 p-tb-8">
                                    <?php
                                        medcity_elementor_image_render($testimonial,[
                                            'name'           => 'image',
                                            'image_size_key' => 'image',
                                            'img_class'      => 'cms-ttmn--img circle cms-img-stroke',
                                            'custom_size'    => $thumbnail_custom_dimension,
                                            'before'         => '<div class="cms-ttmn-img flex-auto"><span class="icon-quote text-18 text-accent">'.medcity_svgs_icon_render(['icon' => 'quote']).'</span>',
                                            'after'          => '</div>'
                                        ]);
                                    ?>
                                    <div class="flex-basic">
                                        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
                                        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div <?php etc_print_html($widget->get_render_attribute_string('dots')); ?>>
                    
                    <?php 
                    if($dots_type == 'custom'){
                        foreach ($testimonials as $key => $testimonial) {
                            $testimonial['image_size'] = $settings['image_size'];
                            $testimonial['image_custom_dimension'] = $thumbnail_custom_dimension;
                            ?>
                            <div class="dots-item d-flex flex-nowrap gap-20 align-items-center flex-auto">
                                <?php
                                    medcity_elementor_image_render($testimonial,[
                                        'name'           => 'image',
                                        'image_size_key' => 'image',
                                        'img_class'      => 'cms-ttmn--img circle cms-img-stroke',
                                        'custom_size'    => $thumbnail_custom_dimension,
                                        'before'         => '<div class="cms-ttmn-img flex-auto"><span class="icon-quote text-18 text-accent">'.medcity_svgs_icon_render(['icon' => 'quote']).'</span>',
                                        'after'          => '</div>'
                                    ]);
                                ?>
                                <div class="flex-basic">
                                    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
                                    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
                                </div>
                            </div>
                        <?php } 
                    } ?>

                </div>
            <?php } 
            endif ;?>
        </div>
    <?php
            break;
    } ?>
</div>