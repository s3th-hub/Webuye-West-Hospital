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
$is_new = \Elementor\Icons_Manager::is_migration_allowed();
?>
<?php if(isset($settings['boxs']) && !empty($settings['boxs']) && count($settings['boxs'])): ?>
    <div class="cms-fancy-box-carousel layout2 cms-slick-slider">
        <div <?php etc_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
            <?php
            foreach ($settings['boxs'] as $box){
                ?>
                <div class="carousel-item">
                    <div class="carousel-item-inner">
                        <?php
                        $has_icon = ! empty( $box['selected_icon'] );
                        if ( ! empty( $box['link']['url'] ) ) {
                            $widget->add_render_attribute( 'link', 'href', $box['link']['url'], true );

                            if ( $box['link']['is_external'] ) {
                                $widget->add_render_attribute( 'link', 'target', '_blank', true );
                            }

                            if ( $box['link']['nofollow'] ) {
                                $widget->add_render_attribute( 'link', 'rel', 'nofollow', true );
                            }
                        }
                        $link_attributes = $widget->get_render_attribute_string( 'link' );
                        if ($has_icon){
                            ?>
                            <div class="item-icon">
                                <?php
                                if($is_new):
                                    \Elementor\Icons_Manager::render_icon( $box['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                    ?>
                                <?php else: ?>
                                    <i <?php etc_print_html($widget->get_render_attribute_string( 'i' )); ?>></i>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="item-content">
                            <h3 class="item-title">
                                <?php echo etc_print_html($box['title_text']); ?>
                            </h3>
                            <?php
                            if (!empty($box['description_text'])){
                                ?>
                                <div class="item-description">
                                    <?php echo esc_html($box['description_text']); ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="item-button">
                                <a <?php echo implode( ' ', [ $link_attributes ] ); ?>>
                                    <?php if(!empty($box['button_text'])) : ?>
                                        <span class="f-btn-text"><?php echo esc_attr($box['button_text']); ?></span>
                                    <?php endif; ?>
                                    <span class="f-btn-icon"><i class="fac fac-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php endif; ?>
