<?php
$widget->add_render_attribute( 'inner', [
    'class' => 'cms-testimonial-inner',
] );
$slidesToShow = !empty($settings['slides_to_show'])?$settings['slides_to_show']:1;
$isSingleSlide = 1 === $slidesToShow;
$defaultLGDevicesSlidesCount = $isSingleSlide ? 1 : 1;
$slidesToShowTablet = !empty($settings['slides_to_show_tablet'])?$settings['slides_to_show_tablet']:$defaultLGDevicesSlidesCount;
$slidesToShowMobile = !empty($settings['slides_to_show_mobile'])?$settings['slides_to_show_mobile']:1;
if($isSingleSlide){
    $slidesToScroll = 1;
}
else{
    $slidesToScroll = !empty($settings['slides_to_scroll'])?$settings['slides_to_scroll']:$defaultLGDevicesSlidesCount;
}
$slidesToScrollTablet = !empty($settings['slides_to_scroll_tablet'])?$settings['slides_to_scroll_tablet']:$defaultLGDevicesSlidesCount;
$slidesToScrollMobile = !empty($settings['slides_to_scroll_mobile'])?$settings['slides_to_scroll_mobile']:1;
$widget->add_render_attribute( 'carousel', [
    'class'                     => 'cms-slick-carousel',
    'data-dir'                  => is_rtl() ? 'true' : 'false',
    'data-arrows'               => $settings['arrows'],
    'data-dots'                 => $settings['dots'],
    'data-pauseOnHover'         => $settings['pause_on_hover'],
    'data-autoplay'             => $settings['autoplay'],
    'data-autoplaySpeed'        => $settings['autoplay_speed'],
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
<?php if(isset($settings['clients']) && !empty($settings['clients']) && count($settings['clients'])): ?>
    <div class="cms-testimonial-carousel layout4 cms-slick-slider">
        <div <?php etc_print_html($widget->get_render_attribute_string( 'inner' )); ?>>
            <div <?php etc_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                <?php foreach ($settings['clients'] as $client): ?>
                    <div class="content-inner">
                        <?php
                        if(!empty($client['client_content'])){
                            ?>
                            <h4 class="said"><?php echo esc_html($client['client_content']); ?></h4>
                            <?php
                        }
                        ?>
                        <div class="client-name">
                            <?php
                            if (!empty($client['client_link']['id'])){
                                $url = !empty($client['client_link']['id'])?$client['client_link']['id']:'#';
                                $target = !empty($client['client_link']['is_external']);
                                $rel = !empty($client['client_link']['nofollow']);
                                ?>
                                <a class="name-text" href="<?php echo esc_url($url); ?>" <?php etc_print_html($target?'target="_blank"':''); ?> <?php etc_print_html($rel?'rel="nofollow"':''); ?>>
                                    <?php echo esc_html($client['client_name']); ?>
                                </a>
                                <?php
                            }else{
                                ?> <div class="name-text"><?php echo esc_html($client['client_name']);?></div> <?php
                            }
                            ?>
                        </div>
                        <div class="icon">
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
<?php endif; ?>
