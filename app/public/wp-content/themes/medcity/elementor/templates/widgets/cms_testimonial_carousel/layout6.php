<?php
$slides_to_show = $widget->get_setting('slides_to_show', '');
$slides_to_show_tablet = $widget->get_setting('slides_to_show_tablet', '');
$slides_to_show_mobile = $widget->get_setting('slides_to_show_mobile', '');
$slides_to_scroll = $widget->get_setting('slides_to_scroll', '');
$slides_to_scroll_tablet = $widget->get_setting('slides_to_scroll_tablet', '');
$slides_to_scroll_mobile = $widget->get_setting('slides_to_scroll_mobile', '');

$slidesToShow = !empty($slides_to_show)?$slides_to_show:1;
$isSingleSlide = 1 === $slidesToShow;
$defaultLGDevicesSlidesCount = $isSingleSlide ? 1 : 1;
$slidesToShowTablet = !empty($slides_to_show_tablet)?$slides_to_show_tablet:$defaultLGDevicesSlidesCount;
$slidesToShowMobile = !empty($slides_to_show_mobile)?$slides_to_show_mobile:1;
if($isSingleSlide){
    $slidesToScroll = 1;
}
else{
    $slidesToScroll = !empty($slides_to_scroll)?$slides_to_scroll:$defaultLGDevicesSlidesCount;
}
$slidesToScrollTablet = !empty($slides_to_scroll_tablet)?$slides_to_scroll_tablet:$defaultLGDevicesSlidesCount;
$slidesToScrollMobile = !empty($slides_to_scroll_mobile)?$slides_to_scroll_mobile:1;

$arrows = $widget->get_setting('arrows');
$dots = $widget->get_setting('dots');
$pause_on_hover = $widget->get_setting('pause_on_hover');
$autoplay = $widget->get_setting('autoplay', '');
$autoplay_speed = $widget->get_setting('autoplay_speed', '8000');
$infinite = $widget->get_setting('infinite');
$speed = $widget->get_setting('speed', '800');
$widget->add_render_attribute( 'carousel', [
    'class'                     => 'cms-slick-carousel',
    'data-dir'                  => is_rtl() ? 'true' : 'false',
    'data-arrows'               => $arrows,
    'data-dots'                 => $dots,
    'data-pauseOnHover'         => $pause_on_hover,
    'data-autoplay'             => true,
    'data-autoplaySpeed'        => $autoplay_speed,
    'data-infinite'             => '0',
    'data-speed'                => $speed,
    'data-slidesToShow'         => '1',
    'data-slidesToShowTablet'   => '1',
    'data-slidesToShowMobile'   => '1',
    'data-slidesToScroll'       => '1',
    'data-slidesToScrollTablet' => '1',
    'data-slidesToScrollMobile' => '1',
] );
?>
<?php if(isset($settings['clients']) && !empty($settings['clients']) && count($settings['clients'])): ?>
    <div class="cms-testimonial-carousel layout6 cms-slick-slider text-center">
        <div class="testimonial-inner">
            <div class="testimonial-carousel-inner">
                <div class="cms-slick-nav-wrap">
                    <div class="cms-slick-nav" data-nav="<?php echo esc_attr($settings['nav']); ?>" data-centermode="true" data-centerpadding="0" data-variablewidth="true" data-draggable="false" data-infinite="true">
                        <?php foreach ($settings['clients'] as $key => $value_nav):
                            medcity_elementor_image_render($settings['clients'][$key], [
                                'name'        => 'client_image',
                                'size'        => 'custom',
                                'custom_size' => ['width' => 60, 'height' => 60],
                                'img_class'   => 'ttmn-avatar circle cms-transition name-color text-accent',
                                'before'      => '<div class="testimonial-holder"><div class="testimonial--holder">',
                                'after'       => '</div></div>'
                            ]);
                        endforeach; ?>
                    </div>
                </div>
                <div class="cms-slick-primary pt-20 cms-slick-dots-currenColor">
                    <div <?php etc_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                        <?php foreach ($settings['clients'] as $key => $value): ?>
                            <div class="client-content">
                                <div class="heading text-23 lh-1826 font-700 font-italic">
                                    <?php echo esc_attr($value['client_content']); ?>
                                </div>
                                <div class="client-meta pt-20">
                                    <span class="name-text name-color text-16 font-700"><?php echo esc_attr($value['client_name']); ?></span>
                                    <span class="client-job text-14"> - <?php echo esc_attr($value['client_job']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>