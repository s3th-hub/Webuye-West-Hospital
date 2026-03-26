<?php
$col_xs = $widget->get_setting('col_xs', '');
$col_sm = $widget->get_setting('col_sm', '');
$col_md = $widget->get_setting('col_md', '');
$col_lg = $widget->get_setting('col_lg', '');
$col_xl = $widget->get_setting('col_xl', '');
$col_xxl = $widget->get_setting('col_xxl', '');
if($col_xxl == 'inherit') {
    $col_xxl = $col_xl;
}
$slides_to_scroll = $widget->get_setting('slides_to_scroll', '');
$arrows = $widget->get_setting('arrows','false');  
$pagination = $widget->get_setting('pagination','false');
$pagination_type = $widget->get_setting('pagination_type','bullets');
$pause_on_hover = $widget->get_setting('pause_on_hover');
$autoplay = $widget->get_setting('autoplay', '');
$autoplay_speed = $widget->get_setting('autoplay_speed', '5000');
$infinite = $widget->get_setting('infinite','false');  
$speed = $widget->get_setting('speed', '500');
$opts = [
    'slide_direction'               => 'horizontal',
    'slide_percolumn'               => '1', 
    'slide_mode'                    => 'slide', 
    'slides_to_show'                => $col_xl, 
    'slides_to_show_xxl'             => $col_xxl, 
    'slides_to_show_lg'             => $col_lg, 
    'slides_to_show_md'             => $col_md, 
    'slides_to_show_sm'             => $col_sm, 
    'slides_to_show_xs'             => $col_xs, 
    'slides_to_scroll'              => $slides_to_scroll,
    'arrow'                         => $arrows,
    'pagination'                    => $pagination,
    'pagination_type'               => $pagination_type,
    'autoplay'                      => $autoplay,
    'pause_on_hover'                => $pause_on_hover,
    'pause_on_interaction'          => 'true',
    'delay'                         => $autoplay_speed,
    'loop'                          => $infinite,
    'speed'                         => $speed
];
$widget->add_render_attribute( 'carousel', [
    'class'         => 'pxl-swiper-container',
    'dir'           => is_rtl() ? 'rtl' : 'ltr',
    'data-settings' => wp_json_encode($opts)
]);
if(isset($settings['testimonial']) && !empty($settings['testimonial']) && count($settings['testimonial'])): ?>
    <div class="pxl-swiper-sliders pxl-testimonial-carousel pxl-testimonial-carousel4 pxl-swiper-boxshadow pxl-swiper-arrow-show" data-view-auto="<?php echo esc_attr($col_xl); ?>">
        <div class="pxl-carousel-inner">
            <div <?php pxl_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                <div class="pxl-swiper-wrapper">
                    <?php foreach ($settings['testimonial'] as $key => $value):
                        $title = isset($value['title']) ? $value['title'] : '';
                        $position = isset($value['position']) ? $value['position'] : '';
                        $trusted = isset($value['trusted']) ? $value['trusted'] : '';
                        $desc = isset($value['desc']) ? $value['desc'] : '';
                        $image = isset($value['image']) ? $value['image'] : '';
                        $img_author = isset($value['img_author']) ? $value['img_author'] : '';
                        $logo = isset($value['logo']) ? $value['logo'] : '';
                        $pxl_icon = isset($value['pxl_icon']) ? $value['pxl_icon'] : ''; 
                        ?>
                        <div class="pxl-swiper-slide">
                            <div class="wrap-content">
                               <?php if(!empty($image['id'])) { 
                                $img = pxl_get_image_by_size( array(
                                    'attach_id'  => $image['id'],
                                    'thumb_size' => '730x450',
                                    'class' => 'no-lazyload',
                                ));
                                $thumbnail = $img['thumbnail'];?>
                                <div class="pxl-item--image ">
                                    <?php echo wp_kses_post($thumbnail); ?>
                                </div>
                            <?php } ?>
                            <div class="pxl-item--holder">
                                <div class="pxl-item--meta">
                                    <div class="image-author">
                                        <?php if(!empty($img_author['id'])) { 
                                            $img1 = pxl_get_image_by_size( array(
                                                'attach_id'  => $img_author['id'],
                                                'thumb_size' => '80x80',
                                                'class' => 'no-lazyload',
                                            ));
                                            $thumbnail1 = $img1['thumbnail'];
                                        ?>
                                        <?php echo wp_kses_post($thumbnail1); ?>
                                    </div>
                                    <?php } ?>
                                    <div class="author-info">
                                        <h4 class="pxl-item--title"><?php echo pxl_print_html($title); ?></h4>
                                        <div class="pxl-item--position"><?php echo pxl_print_html($position); ?></div>
                                    </div>
                                </div>
                                <div class="pxl-item--desc"><?php echo pxl_print_html($desc); ?></div>
                                    <div class="wrap-rating">
                                        <div class="pxl-item-client-trusted"><?php echo pxl_print_html($trusted); ?></div>
                                        <ul class="rating-star" >
                                            <li><img src="<?php echo esc_url(get_template_directory_uri().'/assets/img/star.png'); ?>" alt="start_of_week"></li>
                                            <li><img src="<?php echo esc_url(get_template_directory_uri().'/assets/img/star.png'); ?>" alt="start_of_week"></li>
                                            <li><img src="<?php echo esc_url(get_template_directory_uri().'/assets/img/star.png'); ?>" alt="start_of_week"></li>
                                            <li><img src="<?php echo esc_url(get_template_directory_uri().'/assets/img/star.png'); ?>" alt="start_of_week"></li>
                                            <li><img src="<?php echo esc_url(get_template_directory_uri().'/assets/img/star.png'); ?>" alt="start_of_week"></li>
                                        </ul>
                                        <div class="pxl-item--icon">
                                            <?php \Elementor\Icons_Manager::render_icon( $value['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if($arrows !== 'false'): ?>
                <div class="pxl-swiper-arrow pxl-swiper-arrow-next"><i class="caseicon-angle-arrow-right rtl-icon"></i></div>
                <div class="pxl-swiper-arrow pxl-swiper-arrow-prev"><i class="caseicon-angle-arrow-left rtl-icon"></i></div>
            <?php endif; ?>
            <?php if($pagination !== 'false'): ?>
                <div class="pxl-swiper-dots"></div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
