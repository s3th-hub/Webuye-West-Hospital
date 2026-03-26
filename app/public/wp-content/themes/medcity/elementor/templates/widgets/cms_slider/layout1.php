<?php
$default_align  = $widget->get_setting('content_align', 'center');
$cms_slides     = $widget->get_setting('cms_slides', []);
$arrows         = $widget->get_setting('arrows','');
$dots           = $widget->get_setting('dots','');
$autoplay_speed = $widget->get_setting('autoplay_speed',5000);
$divider_speed  = $widget->get_setting('autoplay_speed',5000)-300;
// Dots
$widget->add_render_attribute('dots', [
    'class' => [
        'cms-carousel-dots',
        'cms-carousel-dots-'.$settings['dots_type'],
        'cms-carousel-dots-in',
        'justify-content-center',
        'text-white',
        'cms-carousel-dots-white',
        'cms-carousel-dots-active-white'
    ]
]);
// Wrapper
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-eslider',
        'cms-eslider-'.$settings['layout'],
        'cms-carousel', 'swiper'
    ]
]);
// Container
$widget->add_render_attribute('container', [
    'class' => [
        'container',
        'd-flex',
        'justify-content-'.$default_align,
        'text-'.$default_align,
        'relative z-top'
    ]
]);
// Description
$cms_slider_desc_classes = [
    'cms-slider-desc pt-20 empty-none',
    medcity_add_hidden_device_controls_render($settings, 'desc_')
];
if($default_align === 'center'){
    $cms_slider_desc_classes[] = 'm-lr-auto';
}
// Buttons
$widget->add_render_attribute('buttons', [
    'class' => [
        'cms-slider-buttons d-flex align-items-center gap-30',
        'justify-content-'.$default_align,
        'pt-30',
        'empty-none'
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')) ?>>
    <div class="swiper-wrapper">
        <?php foreach ($cms_slides as $key => $cms_slide) { ?>
            <div class="cms-slider-item swiper-slide relative cms-gradient-<?php echo esc_attr($settings['overlay_style']);?>">
                <?php 
                    $cms_slide['lazy']       = false;
                    $cms_slide['image_size'] = 'full';
                    // image/video
                    switch($cms_slide['slide_type']){
                        case 'video':
                            // video
                            medcity_elementor_video_render(['url' => $cms_slide['video_url'], 'overlay' => true]);
                            break;
                        case 'img':
                            // image
                            medcity_elementor_image_render($cms_slide, [
                                'name'           => 'image',
                                'image_size_key' => 'image',
                                'img_class'      => 'cms-slider-img img-cover absolute center cms-frame-playback',
                                'before'         => '<div class="w-100 h-100 relative">',
                                'after'          => '</div>'
                            ]);
                            break;
                    }
                    // Sub Title
                    $sub_title_key = $widget->get_repeater_setting_key('sub-title-key', 'cms_slider', $key);
                    $widget->add_render_attribute($sub_title_key, [
                        'class' => [
                            'cms-slider-subtitle text-white empty-none',
                            'text-16 font-700 pb-20 mt-n8',
                            medcity_add_hidden_device_controls_render($settings, 'subtitle_')
                        ],
                        'data-cms-animation'       => 'subtitle_animation',
                        'data-cms-animation-delay' => 'subtitle_animation_delay'
                    ]);
                    // Title
                    $title_key = $widget->get_repeater_setting_key('title-key', 'cms_slider', $key);
                    $widget->add_render_attribute($title_key, [
                        'class' => [
                            'cms-slider-title heading text-white mt-n10 empty-none text-75 text-mobile-50 font-700 lh-11',
                            'empty-none',
                            medcity_add_hidden_device_controls_render($settings, 'title_')
                        ],
                        'data-cms-animation'       => 'title_animation',
                        'data-cms-animation-delay' => 'title_animation_delay'
                    ]);
                    
                    // Description
                    $desc_key = $widget->get_repeater_setting_key('desc-key', 'cms_slider', $key);
                    $widget->add_render_attribute($desc_key, [
                        'class' => $cms_slider_desc_classes,
                        //'data-cms-animation'       => 'description_animation',
                        //'data-cms-animation-delay' => 'description_animation_delay'
                    ]);
                    // description_title
                    $desc_key_title = $widget->get_repeater_setting_key('desc-title-key', 'cms_slider', $key);
                    $widget->add_render_attribute($desc_key_title, [
                        'class' => [
                            'cms-slider-desc-title text-20 font-700',
                            'text-white',
                            'empty-none',
                            'relative',
                            'pb-20'
                        ],
                        'data-cms-animation'       => 'description_animation',
                        'data-cms-animation-delay' => 'description_animation_delay'
                    ]);
                    // description text
                    $desc_key_text = $widget->get_repeater_setting_key('desc-key-text', 'cms_slider', $key);
                    $widget->add_render_attribute($desc_key_text, [
                        'class'                    => 'text-white font-700 text-17',
                        'data-cms-animation'       => 'description_animation',
                        'data-cms-animation-delay' => 'description_animation_delay'
                    ]);
                    // Primary Button
                    switch ($cms_slide['button_primary_type']) {
                        case 'page':
                            $button_primary_url  = !empty($cms_slide['button_primary_page_link']) ? get_permalink($cms_slide['button_primary_page_link']) : '#';
                            break;
                        default:
                            $button_primary_url = $cms_slide['button_primary_link']['url'];
                            break;
                    }
                    $primary_btn_key = $widget->get_repeater_setting_key('primary-btn', 'cms_slider', $key);
                    $widget->add_render_attribute($primary_btn_key, [
                        'class' => [
                            'cms-slider-btn',
                            'cms-btn cms-btn-lg cms-btn-accent text-white cms-btn-hover-secondary text-hover-white',
                            medcity_add_hidden_device_controls_render($settings, 'btn1_'),
                        ],
                        'href'                     => $button_primary_url,
                        'data-title'               => $cms_slide['button_primary'],
                        'data-cms-animation'       => 'button_primary_animation',
                        'data-cms-animation-delay' => 'button_primary_animation_delay'
                    ]);
                    // Secondary Button
                    switch ($cms_slide['button_secondary_type']) {
                        case 'page':
                            $button_secondary_url  = !empty($cms_slide['button_secondary_page_link']) ? get_permalink($cms_slide['button_secondary_page_link']) : '#';
                            break;
                        default:
                            $button_secondary_url = $cms_slide['button_secondary_link']['url'];
                            break;
                    }
                    $secondary_btn_key = $widget->get_repeater_setting_key('secondary-btn', 'cms_slider', $key);
                    $widget->add_render_attribute($secondary_btn_key, [
                        'class' => [
                            'cms-slider-btn',
                            'cms-btn cms-btn-lg cms-btn-white text-btn cms-btn-hover-accent text-hover-white',
                            medcity_add_hidden_device_controls_render($settings, 'btn2_')
                        ],
                        'href'                     => $button_secondary_url,
                        'data-cms-animation'       => 'button_secondary_animation',
                        'data-cms-animation-delay' => 'button_secondary_animation_delay'
                    ]);
                ?>
                <div class="cms-slider-content cms-overlay cms-gradient-render d-flex align-items-center">
                    <div <?php etc_print_html($widget->get_render_attribute_string('container')); ?>>
                        <div class="cms-slider--content">
                            <div <?php etc_print_html($widget->get_render_attribute_string($sub_title_key)); ?>><?php etc_print_html($cms_slide['subtitle']); 
                            ?></div>
                            <h2 <?php etc_print_html($widget->get_render_attribute_string($title_key)); ?>><?php 
                                echo nl2br($cms_slide['title']); 
                            ?></h2>
                            <div <?php etc_print_html($widget->get_render_attribute_string($desc_key)); ?>>
                                <div <?php etc_print_html($widget->get_render_attribute_string($desc_key_title)); ?>><?php 
                                    etc_print_html($cms_slide['description_title']);
                                ?></div>
                                <div <?php etc_print_html($widget->get_render_attribute_string($desc_key_text)); ?>><?php etc_print_html($cms_slide['description']); 
                                ?></div>
                            </div>
                            <div <?php etc_print_html($widget->get_render_attribute_string('buttons')); ?>><?php
                            // Primary Button
                            if ( ! empty( $cms_slide['button_primary'] ) ) :   
                            ?>
                                
                                <a <?php etc_print_html($widget->get_render_attribute_string($primary_btn_key)); ?>>
                                    <?php 
                                    // text 
                                    etc_print_html( $cms_slide['button_primary'] ); 
                                    // icon
                                    medcity_elementor_button_icon_render();
                                    ?>
                                </a>
                            <?php endif;
                            // Secondary Button
                                if ( ! empty( $cms_slide['button_secondary'] ) ) :
                            ?>
                                <a <?php etc_print_html($widget->get_render_attribute_string($secondary_btn_key)); ?>>
                                    <?php 
                                    // text 
                                    etc_print_html( $cms_slide['button_secondary'] ); 
                                    // icon
                                    medcity_elementor_button_icon_render();
                                    ?>
                                </a>
                            <?php endif; 
                                // Video button
                                medcity_elementor_button_video_render($widget, $cms_slide, [
                                    'name'       => 'video_link',
                                    'icon_class' => 'cms-transition mr-20',
                                    'text'       => $cms_slide['video_text'],
                                    'layout'     => '1 cms-btn-video-1',
                                    'class'      => medcity_add_hidden_device_controls_render($settings, 'btn_video_'),
                                    'echo'       => true,
                                    'loop'       => true,
                                    'loop_key'   => $key, 
                                    'attrs'      => [
                                        'data-cms-animation'       => 'button_video_animation',
                                        'data-cms-animation-delay' => 'button_video_animation_delay'
                                    ]
                                ]);
                            ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php if ($arrows == 'yes') : ?>
        <div class="cms-carousel-button-prev cms-carousel-vertical absolute center-left ml-50 text-22 lh-0 text-white text-hover-secondary"><?php
            medcity_svgs_icon_render([
                'icon' => 'arrow-prev',
                'echo' => true
            ]);
        ?></div>
        <div class="cms-carousel-button-next cms-carousel-vertical absolute center-right mr-50 text-22 lh-0 text-white text-hover-secondary"><?php
             medcity_svgs_icon_render([
                'icon' => 'arrow-next',
                'echo' => true
            ]);
        ?></div>
    <?php endif ?> 
    <?php if ($dots == 'yes') : ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('dots')); ?>></div>
    <?php endif ?>
</div>