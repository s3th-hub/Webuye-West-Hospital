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
    <div class="cms-testimonial-carousel layout1 cms-slick-slider">
        <div class="testimonial-inner">
            <div class="testimonial-carousel-inner">
                <div class="cms-slick-primary">
                    <div <?php etc_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                        <?php foreach ($settings['clients'] as $value): ?>
                            <div class="client-content">
                                <h3 class="said">
                                    <?php echo esc_attr($value['client_content']); ?>
                                </h3>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="cms-slick-nav-wrap">
                    <div class="cms-slick-nav" data-nav="<?php echo esc_attr($settings['nav']); ?>">
                        <?php foreach ($settings['clients'] as $value_nav):
                            $img = etc_get_image_by_size( array(
                                'attach_id'  => $value_nav['client_image']['id'],
                                'thumb_size' => '60x60',
                                'class'      => '',
                            ));
                            $thumbnail = $img['thumbnail'];
                            ?>
                            <div class="testimonial-holder">
                                <?php if(!empty($value_nav['client_image']['id'])) { ?>
                                    <div class="client-image">
                                        <?php echo wp_kses_post($thumbnail); ?>
                                    </div>
                                <?php } ?>
                                <div class="client-meta">
                                    <h3 class="client-name"><span class="name-text"><?php echo esc_attr($value_nav['client_name']); ?></span></h3>
                                    <span class="client-job"><?php echo esc_attr($value_nav['client_job']); ?></span>
                                </div>
                                <div class="svg-icon">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 95.333 95.332" style="enable-background:new 0 0 95.333 95.332;"
                                         xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M30.512,43.939c-2.348-0.676-4.696-1.019-6.98-1.019c-3.527,0-6.47,0.806-8.752,1.793
                                                    c2.2-8.054,7.485-21.951,18.013-23.516c0.975-0.145,1.774-0.85,2.04-1.799l2.301-8.23c0.194-0.696,0.079-1.441-0.318-2.045
                                                    s-1.035-1.007-1.75-1.105c-0.777-0.106-1.569-0.16-2.354-0.16c-12.637,0-25.152,13.19-30.433,32.076
                                                    c-3.1,11.08-4.009,27.738,3.627,38.223c4.273,5.867,10.507,9,18.529,9.313c0.033,0.001,0.065,0.002,0.098,0.002
                                                    c9.898,0,18.675-6.666,21.345-16.209c1.595-5.705,0.874-11.688-2.032-16.851C40.971,49.307,36.236,45.586,30.512,43.939z"/>
                                                <path d="M92.471,54.413c-2.875-5.106-7.61-8.827-13.334-10.474c-2.348-0.676-4.696-1.019-6.979-1.019
                                                    c-3.527,0-6.471,0.806-8.753,1.793c2.2-8.054,7.485-21.951,18.014-23.516c0.975-0.145,1.773-0.85,2.04-1.799l2.301-8.23
                                                    c0.194-0.696,0.079-1.441-0.318-2.045c-0.396-0.604-1.034-1.007-1.75-1.105c-0.776-0.106-1.568-0.16-2.354-0.16
                                                    c-12.637,0-25.152,13.19-30.434,32.076c-3.099,11.08-4.008,27.738,3.629,38.225c4.272,5.866,10.507,9,18.528,9.312
                                                    c0.033,0.001,0.065,0.002,0.099,0.002c9.897,0,18.675-6.666,21.345-16.209C96.098,65.559,95.376,59.575,92.471,54.413z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
