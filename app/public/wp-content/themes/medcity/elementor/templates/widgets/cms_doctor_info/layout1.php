<?php
if (!is_singular('doctor')){
    ?> <h4> <?php echo esc_html__('This Widget Just Use For Single Doctor Only!', 'medcity'); ?></h4><?php
    return true;
}
$post_ID = get_the_ID();
$html_id = etc_get_element_id($settings);
// Social Info
$doctor_facebook = get_post_meta($post_ID, 'doctor_facebook_url', true);
$doctor_instagram = get_post_meta($post_ID, 'doctor_instagram_url', true);
$doctor_twitter = get_post_meta($post_ID, 'doctor_twitter_url', true);
$doctor_email = get_post_meta($post_ID, 'doctor_email', true);
$doctor_phone = get_post_meta($post_ID, 'doctor_phone', true);
$doctor_phone_escape = preg_replace('#[ () ]*#', '', $doctor_phone);

?>
<div id="<?php echo esc_attr($html_id); ?>" class="cms-doctor-info">
        <div class="info-inner">
            <div class="top-content">
                <div class="doctor-image scale-hover">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full');
                    }
                    ?>
                </div>
            </div>
            <div class="bottom-content">
                <div class="content-text">
                    <h3 class="doctor-title"><?php the_title(); ?></h3>
                    <?php if(get_the_terms($post_ID,'doctor-category')){?>
                        <div class="doctor-category">
                            <?php the_terms( $post_ID, 'doctor-category', '', ', ' ); ?>
                        </div>
                    <?php } ?>
                    <?php
                    if (!empty($settings['description'])){
                        ?><p class="description"><?php echo wp_kses_post($settings['description']) ;?></p><?php
                    }
                    ?>
                    <div class="content-social">
                        <ul class="doctor-social">
                            <?php if(!empty($doctor_facebook) && $settings['show_facebook']) : ?>
                                <li>
                                    <a class="doctor-f" href="<?php echo esc_url($doctor_facebook); ?>" target="_self">
                                        <i class="zmdi zmdi-facebook"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(!empty($doctor_twitter) && $settings['show_twitter']) : ?>
                                <li>
                                    <a class="doctor-t" href="<?php echo esc_url($doctor_twitter); ?>" target="_self">
                                        <i class="zmdi zmdi-twitter"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(!empty($doctor_instagram) && $settings['show_instagram']) : ?>
                                <li>
                                    <a class="doctor-i" href="<?php echo esc_attr($doctor_instagram); ?>" target="_self">
                                        <i class="zmdi zmdi-instagram"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(!empty($doctor_email) && $settings['show_email']) : ?>
                                <li>
                                    <a class="doctor-e" href="mailto:<?php echo esc_html($doctor_email); ?>" target="_self">
                                        <i class="zmdi zmdi-email"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(!empty($doctor_phone) && $settings['show_phone']) : ?>
                                <li>
                                    <a class="doctor-p" href="tel:<?php echo esc_attr($doctor_phone_escape); ?>">
                                        <i class="zmdi zmdi-phone"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

