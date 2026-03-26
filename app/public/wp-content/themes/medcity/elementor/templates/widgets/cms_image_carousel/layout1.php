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
$image_count = count($settings['images']);
?>
<?php if(isset($settings['images']) && !empty($settings['images']) && count($settings['images'])): ?>
    <div class="cms-image-carousel layout1 cms-slick-slider">
        <div class="image-inner">
            <div class="cms-image-carousel-inner">
                <?php if($settings['arrows'] == true) : ?>
                    <div class="cms-slick-nav-wrap">
                        <div class="nav-arrows">
                            <div class="cms-slick-nav-arrow cms-slick-nav-left"><i class="fac fac-arrow-left"></i></div>
                            <div class="cms-slick-nav-arrow cms-slick-nav-right"><i class="fac fac-arrow-right"></i></div>
                        </div>
                        <div class="slider-counter"><?php echo '1 / '.esc_html($image_count);?></div>
                    </div>
                <?php endif; ?>
                <div class="cms-slick-primary">
                    <div <?php etc_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                        <?php foreach ($settings['images'] as $image):
                            $image_id =  $image['item_image']['id'];
                            $img          = etc_get_image_by_size( array(
                                'attach_id'  => $image_id,
                                'thumb_size' => 'full',
                                'class'      => '',
                            ) );
                            $thumbnail    = $img['thumbnail'];
                            if(!empty($image['item_image']['id'])){ ?>
                                <div class="item-image">
                                    <?php echo wp_kses_post($thumbnail); ?>
                                    <div class="up-icon">
                                        <a href="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>">
                                            <i class="zmdi zmdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php endif; ?>
