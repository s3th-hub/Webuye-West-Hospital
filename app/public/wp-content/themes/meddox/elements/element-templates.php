<?php 

if(!function_exists('meddox_get_post_grid')){
    function meddox_get_post_grid($posts = [], $settings = []){ 
        if (empty($posts) || !is_array($posts) || empty($settings) || !is_array($settings)) {
            return false;
        }
        switch ($settings['layout']) {
            case 'post-1':
            meddox_get_post_grid_layout1($posts, $settings);
            break;
            case 'post-2':
            meddox_get_post_grid_layout2($posts, $settings);
            break;
            case 'department-1':
            meddox_get_department_grid_layout1($posts, $settings);
            break;
            case 'department-2':
            meddox_get_department_grid_layout2($posts, $settings);
            break;
            case 'department-3':
            meddox_get_department_grid_layout3($posts, $settings);
            break;
            case 'pxl_event-1':
            meddox_get_pxl_event_grid_layout1($posts, $settings);
            break;
            break; 
            case 'gallery-1':
            meddox_get_gallery_grid_layout1($posts, $settings);
            break;
            case 'gallery-2':
            meddox_get_gallery_grid_layout2($posts, $settings);
            break;
            case 'careers-1':
            meddox_get_careers_grid_layout1($posts, $settings);
            break;
            default:
            return false;
            break;
        }
    }
}

// Start Post Grid
//--------------------------------------------------
function meddox_get_post_grid_layout1($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '370x250';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && (count($grid_masonry) > 1)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            $post_category_on = meddox()->get_theme_opt( 'post_category_on', true );
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);
            }
            $author = get_user_by('id', $post->post_author); ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                    <div class="pxl-item--image hover-imge-effect2">
                        <div class="wrap-feature">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            <?php if($show_category == 'true') : ?>
                                <div class="pxl-item-category">
                                    <?php the_terms($post->ID, 'category', '', ', '); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endif; ?>
                <div class="pxl-item--holder">
                   <div class="wrap-meta pxl-inline-flex">
                    <?php if($show_date == 'true' ) : ?>
                        <div class="pxl-item--date "><?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?></div>
                    <?php endif; ?>
                    <?php if($show_comment == 'true' ) : ?>
                        <div class="item-comment">
                            <a href="#comments"><?php echo comments_number(esc_html__('No Comments', 'meddox'),esc_html__('Comment (1) ', 'meddox'),esc_html__('Comments (%)', 'meddox'),$post->ID); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if($show_title == 'true') : ?>
                    <h3 class="pxl-item--title">
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                    </h3>
                <?php endif; ?>
                <?php if($show_excerpt == 'true') : ?>
                   <p class="pxl-item-except">
                    <?php echo wp_trim_words( $post->post_excerpt, $num_words, '...'); ?>
                </p>
            <?php endif; ?>


            <?php if($show_button == 'true') : ?>
                <div class="pxl-item--readmore">
                    <a class="btn-readmore" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                        <span>
                            <?php if(!empty($button_text)) {
                                echo esc_attr($button_text);
                            } else {
                                echo esc_html__('Discover More', 'meddox');
                            } ?>
                        </span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
endforeach;
endif;
}

function meddox_get_post_grid_layout2($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '370x250';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && (count($grid_masonry) > 1)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);
            }
            $author = get_user_by('id', $post->post_author); ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                    <div class="pxl-item--image hover-imge-effect2">
                        <div class="wrap-feature">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                        </div>
                        <div class="wrap-meta pxl-inline-flex">
                            <?php if($show_date == 'true' ) : ?>
                                <div class="pxl-item--date "><i class="caseicon-calendar-alt"></i><?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?></div>
                            <?php endif; ?>
                            <?php if($show_comment == 'true' ) : ?>
                                <div class="item-comment">
                                    <i class="caseicon-comment"></i>
                                    <a href="#comments"><?php echo comments_number(esc_html__('No Comments', 'meddox'),esc_html__('Comment (1) ', 'meddox'),esc_html__('Comments (%)', 'meddox'),$post->ID); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="pxl-item--holder">
                    <h3 class="pxl-item--title">
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                    </h3>
                    <?php if($show_button == 'true') : ?>
                        <div class="pxl-item--readmore">
                            <a class="btn-readmore" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                <span>
                                    <?php if(!empty($button_text)) {
                                        echo esc_attr($button_text);
                                    } else {
                                        echo esc_html__('Read More', 'meddox');
                                    } ?>
                                </span>
                                <i class="caseicon-long-arrow-right-two"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}
// End Post Grid
//--------------------------------------------------

// Start department Grid
//--------------------------------------------------
function meddox_get_department_grid_layout1($posts = [], $settings = []){ 
    extract($settings);
    $images_size = !empty($img_size) ? $img_size : '600x470';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
          $department_icon_font = get_post_meta($post->ID, 'department_icon_font', true);
          $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
          if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
            $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
            $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
            $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
            $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
            $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
            $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";

            $img_size_m = $grid_masonry[$key]['img_size_m'];
            if(!empty($img_size_m)) {
                $images_size = $img_size_m;
            }
        } elseif (!empty($img_size)) {
            $images_size = $img_size;
        }

        if(!empty($tax))
            $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
        else 
            $filter_class = '';


        ?>
        <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
            <div class="wrap-content-department">
                <span></span>
                <div class="pxl-item-icon">
                    <i class="<?php echo esc_attr($department_icon_font); ?>"></i>
                </div>
                <div class="item--holder">
                    <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                    <p class="pxl-item-except">
                         <?php echo wp_trim_words( $post->department_excerpt, 13 , '...'); ?>
                    </p>
                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"  class="btn-more">Discover More</a>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}

function meddox_get_department_grid_layout2($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '600x470';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
          $department_icon_font = get_post_meta($post->ID, 'department_icon_font', true);
          $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
          if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
            $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
            $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
            $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
            $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
            $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
            $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";

            $img_size_m = $grid_masonry[$key]['img_size_m'];
            if(!empty($img_size_m)) {
                $images_size = $img_size_m;
            }
        } elseif (!empty($img_size)) {
            $images_size = $img_size;
        }

        if(!empty($tax))
            $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
        else 
            $filter_class = '';


        ?>
        <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
            <div class="wrap-content-department">
                <span></span>
                <div class="pxl-item-icon">
                    <i class="<?php echo esc_attr($department_icon_font); ?>"></i>
                </div>
                <div class="item--holder">
                    <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                    <p class="pxl-item-except">
                        <?php echo wp_trim_words( $post->department_excerpt, 17 , '...'); ?>
                    </p>
                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"  class="btn-more">Discover More</a>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}
function meddox_get_department_grid_layout3($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : 'full';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            $department_excerpt = get_post_meta($post->ID, 'department_excerpt', true);
            $department_type = get_post_meta($post->ID, 'department_type', true);
            $department_class = get_post_meta($post->ID, 'department_class', true);
            $department_price = get_post_meta($post->ID, 'department_price', true);
            $department_time = get_post_meta($post->ID, 'department_time', true);
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";

                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);
            } ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s "<?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) { $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);"<?php } ?>>
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                    <div class="item--featured">
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                    </div>
                <?php endif; ?>
                <div class="content-right">
                    <div class="item--holder">
                        <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                        <div class="content-excerpt">
                            <?php echo pxl_print_html($department_excerpt)  ?>
                        </div>
                    </div>
                    <div class="wrap-type-department">
                        <ul class="type-department type-department-1" >
                            <li class="type-age">
                                <i class="far fa-user-graduate"></i>
                                <?php echo pxl_print_html($department_type) ?>
                            </li>
                            <li class="type-price">
                                <i class="far fa-usd-circle"></i>
                                <?php echo pxl_print_html($department_price) ?>
                            </li>

                        </ul>
                        <ul class="type-department type-department-2" >
                            <li class="type-class">
                                <i class="far fa-book"></i>
                                <?php echo pxl_print_html($department_class) ?>
                            </li>
                            <li class="type-time">
                                <i class="far fa-clock"></i>
                                <?php echo pxl_print_html($department_time) ?>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}

// End department Grid
//--------------------------------------------------

// Start pxl_event Grid
//--------------------------------------------------
function meddox_get_pxl_event_grid_layout1($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : 'full';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);

            } 
            $pxl_event_address = get_post_meta($post->ID, 'pxl_event_address', true);
            $pxl_event_date = get_post_meta($post->ID, 'pxl_event_date', true);
            $pxl_event_time = get_post_meta($post->ID, 'pxl_event_time', true);
            ?>

            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="wrap-content-event">

                    <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                        <div class="item--featured">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="wrap-entry-body">
                    <div class="entry-body">
                        <div class="item--holder">
                            <h3 class="item--title">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?>
                            </a>
                        </h3>
                    </div>
                    <div class="wrap-type-pxl_event">
                        <ul class="type-pxl_event type-pxl_event-1" >
                            <li class="type-address">
                                <i class="far fa-map-marker-alt"></i>
                                <?php echo pxl_print_html($pxl_event_address) ?>
                            </li>
                        </ul>
                        <ul class="type-pxl_event type-pxl_event-2" >
                            <li class="type-date">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo pxl_print_html($pxl_event_date) ?>
                            </li>
                            <li class="type-time">
                                <i class="far fa-clock"></i>
                                <?php echo pxl_print_html($pxl_event_time) ?>
                            </li>

                        </ul>
                    </div>
                </div>
                <?php if($show_button == 'true') : ?>
                    <div class="pxl-item--readmore">
                        <a class="btn-readmore pxl-btn-effect4" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                            Read More <i class="far fa-long-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
endforeach;
endif;
}
function meddox_get_pxl_event_grid_layout2($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : 'full';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);

            } 
            $pxl_event_address = get_post_meta($post->ID, 'pxl_event_address', true);
            $pxl_event_date = get_post_meta($post->ID, 'pxl_event_date', true);
            $pxl_event_time = get_post_meta($post->ID, 'pxl_event_time', true);
            ?>

            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="wrap-content-event">

                    <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s " <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) { $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);"<?php } ?>>
                    </div>
                    <div class="wrap-entry-body">
                        <div class="entry-body">
                            <div class="item--holder">
                                <h3 class="item--title">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?>
                                </a>
                            </h3>
                        </div>
                        <div class="wrap-type-pxl_event">
                            <ul class="type-pxl_event" >
                                <li class="type-address">
                                    <i class="far fa-map-marker-alt"></i>
                                    <?php echo pxl_print_html($pxl_event_address) ?>
                                </li>
                                <li class="type-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo pxl_print_html($pxl_event_date) ?>
                                </li>
                                <li class="type-time">
                                    <i class="far fa-clock"></i>
                                    <?php echo pxl_print_html($pxl_event_time) ?>
                                </li>
                            </ul>
                        </div>
                        <?php if($show_button == 'true') : ?>
                            <div class="pxl-item--readmore">
                                <a class="btn-readmore pxl-btn-effect4" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                    Read More <i class="far fa-long-arrow-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}
function meddox_get_pxl_event_grid_layout3($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '400x400';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);

            } 
            ?>
            <div class="wrap-content-event">
                <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                    <div class="item--featured">
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="wrap-entry-body">
                <div class="item--holder-inner">
                    <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                    <?php if($show_date == 'true' ) : ?>
                        <div class="item--meta">

                            <?php if($show_date == 'true'): ?>
                                <div class="item--date"><i class="caseicon-calendar-alt"></i><?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}

// End pxl_event Grid
//--------------------------------------------------
// Start Careers Grid
//--------------------------------------------------
function meddox_get_careers_grid_layout1($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '370x250';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && (count($grid_masonry) > 1)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            $post_category_on = meddox()->get_theme_opt( 'post_category_on', true );
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);
            }
            $author = get_user_by('id', $post->post_author); 
            $month = substr(get_the_date("F"), 0,3);
            $time = get_post_meta($post->ID, 'careers_time', true);
            $position = get_post_meta($post->ID, 'careers_position', true);
            $careers_excerpt = get_post_meta($post->ID, 'careers_excerpt', true);
            if($time == "fulltime"){
                $time = 'Full Time';
            }
            else{
                $time = 'Part Time';
            }
            ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s"> 
                    <span></span>
                    <?php if($show_title == 'true') : ?>
                        <h3 class="pxl-item--title">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                        </h3>
                    <?php endif; ?>
                    <ul class="">
                        <li class="pxl-item--time"><?php echo pxl_print_html($time); ?>  </li>
                        <li class="pxl-item--position"><?php echo pxl_print_html($position); ?>  </li>
                    </ul>
                    <?php if($show_excerpt == 'true') : ?>
                       <p class="pxl-item-except">
                        <?php echo wp_trim_words( $post->post_excerpt, $num_words, '...'); ?>
                    </p>
                <?php endif; ?>
                <?php if($show_button == 'true') : ?>
                    <div class="pxl-item--readmore">
                        <a class="btn-readmore" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                            <?php if(!empty($button_text)) {
                                echo esc_attr($button_text);
                            } else {
                                echo esc_html__('Read More', 'meddox');
                            } ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    endforeach;
endif;
}
// End Post Grid
//--------------------------------------------------
// Start Gallery Grid
//--------------------------------------------------
function meddox_get_gallery_grid_layout1($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '370x336';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);

            } 
            ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?> <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                <div class="wrap-content-gallery">
                    <div class="pxl-item--inner ">
                        <span></span>
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                        <div class="item--featured">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                        </div>
                        <div class="item-icon">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                <i class="fas fa-link"></i>
                            </a>

                            <a class="light-box" href="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), $size = 'full') ?>">
                                 <i class="fas fa-eye"></i>
                            </a>

                            
                        </div>
                        <div class="item--holder">
                            <h6 class="item-tag"> <?php the_terms($post->ID, 'gallery-tag', '', ', '); ?> </h6>
                            <h3 class="item--title">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}

function meddox_get_gallery_grid_layout2($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '400x400';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            if($img_id) {
                $img = pxl_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
            } else {
                $thumbnail = get_the_post_thumbnail($post->ID, $images_size);

            } 
            $gallery_type = get_post_meta($post->ID, 'gallery_type', true);
            ?>
            <div class="wrap-content-class">
                <div class="pxl-item--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                    <div class="item--featured">
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="wrap-entry-body">
                <div class="item--holder-inner">
                    <div class="type-age">
                        <?php echo pxl_print_html($gallery_type) ?>
                    </div>
                    <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                    <div class="item-author">
                        <?php pxl_print_html('By','meddox').''. the_author_posts_link(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
}

// End Gallery Grid
//--------------------------------------------------

add_action( 'wp_ajax_meddox_get_pagination_html', 'meddox_get_pagination_html' );
add_action( 'wp_ajax_nopriv_meddox_get_pagination_html', 'meddox_get_pagination_html' );
function meddox_get_pagination_html(){
    try{
        if(!isset($_POST['query_vars'])){
            throw new Exception(__('Something went wrong while requesting. Please try again!', 'meddox'));
        }
        $query = new WP_Query($_POST['query_vars']);
        ob_start();
        meddox()->page->get_pagination( $query,  true );
        $html = ob_get_clean();
        wp_send_json(
            array(
                'status' => true,
                'message' => esc_attr__('Load Successfully!', 'meddox'),
                'data' => array(
                    'html' => $html,
                    'query_vars' => $_POST['query_vars'],
                    'post' => $query->have_posts()
                ),
            )
        );
    }
    catch (Exception $e){
        wp_send_json(array('status' => false, 'message' => $e->getMessage()));
    }
    die;
}

add_action( 'wp_ajax_meddox_load_more_post_grid', 'meddox_load_more_post_grid' );
add_action( 'wp_ajax_nopriv_meddox_load_more_post_grid', 'meddox_load_more_post_grid' );
function meddox_load_more_post_grid(){
    try{
        if(!isset($_POST['settings'])){
            throw new Exception(__('Something went wrong while requesting. Please try again!', 'meddox'));
        }
        $settings = $_POST['settings'];
        set_query_var('paged', $settings['paged']);
        extract(pxl_get_posts_of_grid($settings['post_type'], [
            'source' => isset($settings['source'])?$settings['source']:'',
            'orderby' => isset($settings['orderby'])?$settings['orderby']:'date',
            'order' => isset($settings['order'])?$settings['order']:'desc',
            'limit' => isset($settings['limit'])?$settings['limit']:'6',
            'post_ids' => isset($settings['post_ids'])?$settings['post_ids']:[],
        ]));
        ob_start();

        meddox_get_post_grid($posts, $settings);
        $html = ob_get_clean();
        wp_send_json(
            array(
                'status' => true,
                'message' => esc_attr__('Load Successfully!', 'meddox'),
                'data' => array(
                    'html' => $html,
                    'paged' => $settings['paged'],
                    'posts' => $posts,
                    'max' => $max,
                ),
            )
        );
    }
    catch (Exception $e){
        wp_send_json(array('status' => false, 'message' => $e->getMessage()));
    }
    die;
}