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
    'data-arrows'               => $settings['arrows'],
    'data-dots'                 => $settings['dots'],
    'data-infinite'             => $settings['infinite'],
    'data-speed'                => $settings['speed'],
    'data-slidesToShow'         => $slidesToShow,
    'data-slidesToShowTablet'   => $slidesToShowTablet,
    'data-slidesToShowMobile'   => $slidesToShowMobile,
    'data-slidesToScroll'       => $slidesToScroll,
    'data-slidesToScrollTablet' => $slidesToScrollTablet,
    'data-slidesToScrollMobile' => $slidesToScrollMobile,
] );
?>
<?php if(isset($settings['images']) && !empty($settings['images']) && count($settings['images'])): ?>
    <div class="cms-image-carousel layout2 cms-slick-slider">
        <div <?php etc_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                <?php foreach ($settings['images'] as $image):
                    if ( ! empty( $image['item_image']['url'] ) ) {
                    ?>
                    <div class="item-image images-light-box">
                        <a data-elementor-lightbox-slideshow="<?php echo esc_attr($settings['element_id']);?>" data-elementor-open-lightbox="yes" href="<?php echo esc_url($image['item_image']['url']); ?>">
                            <?php
                                medcity_elementor_image_render($image,[
                                    'name'      => 'item_image',
                                    'size'      => 'custom',
                                    'custom_size' => ['width' => 640, 'height' => 481]
                                ]);
                            ?>
                        </a>
                    </div>
                    <?php }
                endforeach;?>
            </div>
    </div>
<?php endif; ?>
