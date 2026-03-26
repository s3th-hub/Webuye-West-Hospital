<?php

class CMS_Contact_Box_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'cms_contact_box_widget',
            esc_html__('* Contact Box', 'medcity'),
            array('description' => esc_html__('Contact Box Widget', 'medcity'),)
        );
    }

    function widget($args, $instance)
    {
        extract($args);
        $widget_icon = get_template_directory_uri() . '/assets/images/widget-call-icon.png';
        $title = isset($instance['title']) ? (!empty($instance['title']) ? $instance['title'] : '') : '';
        $description = isset($instance['description']) ? (!empty($instance['description']) ? $instance['description'] : '') : '';
        $button_text = isset($instance['button_text']) ? $instance['button_text'] : '';
        $button_link = isset($instance['button_link']) ? $instance['button_link'] : '';
        $background_img_id = isset($instance['background_img']) ? (!empty($instance['background_img']) ? $instance['background_img'] : '') : '';
        $background_img_url = wp_get_attachment_image_url($background_img_id, '');
        ?>
        <div class="cms-contact-box widget" style="background-image: url('<?php echo esc_url($background_img_url)?>');">
            <div class="widget-icon">
                <img src="<?php echo esc_url($widget_icon); ?>" alt="<?php echo esc_attr__('widget icon', 'medcity')?>">
            </div>
            <?php if (!empty($title)) : ?>
                <h3 class="box-title">
                    <?php
                    if (function_exists('etc_print_html')){
                        etc_print_html(nl2br($title));
                    }else{
                        echo wp_kses_post($title);
                    }
                    ?>
                </h3>
            <?php endif; ?>
            <?php if (!empty($description)): ?>
                <div class="cms-contact-text">
                    <p><?php echo wp_kses_post($description); ?></p>
                </div>
            <?php endif; ?>
            <?php if (!empty($button_link)) : ?>
                <div class="cms-contact-button">
                    <a href="<?php echo esc_url($button_link);?>" target="_blank"><i aria-hidden="true" class="fas fa-phone-alt"></i><?php echo esc_html($button_text);?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['description'] = strip_tags($new_instance['description']);
        $instance['button_text'] = strip_tags($new_instance['button_text']);
        $instance['button_link'] = strip_tags($new_instance['button_link']);
        $instance['background_img'] = strip_tags($new_instance['background_img']);
        return $instance;
    }

    function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $description = isset($instance['description']) ? esc_attr($instance['description']) : '';
        $button_text = isset($instance['button_text']) ? esc_attr($instance['button_text']) : '';
        $button_link = isset($instance['button_link']) ? esc_attr($instance['button_link']) : '';
        $background_img = isset($instance['background_img']) ? esc_attr($instance['background_img']) : '';
        ?>
        <p>
            <label for="<?php echo esc_url($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'medcity'); ?></label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php echo wp_kses_post($title); ?></textarea>
        </p>

        <div class="medcity-image-wrap">
            <label for="<?php echo esc_url($this->get_field_id('background_img')); ?>"><?php esc_html_e('Background Image', 'medcity'); ?></label>
            <input type="hidden" class="widefat hide-image-url"
                   id="<?php echo esc_attr($this->get_field_id('background_img')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('background_img')); ?>"
                   value="<?php echo esc_attr($background_img) ?>"/>
            <div class="medcity-show-image">
                <?php
                if ($background_img != "") {
                    ?>
                    <img src="<?php echo wp_get_attachment_image_url($background_img) ?>">
                    <?php
                }
                ?>
            </div>
            <?php
            if ($background_img != "") {
                ?>
                <a href="#" class="medcity-select-image" style="display: none;"><?php esc_html_e('Select Image', 'medcity'); ?></a>
                <a href="#" class="medcity-remove-image"><?php esc_html_e('Remove Image', 'medcity'); ?></a>
                <?php
            } else {
                ?>
                <a href="#" class="medcity-select-image"><?php esc_html_e('Select Image', 'medcity'); ?></a>
                <a href="#" class="medcity-remove-image" style="display: none;"><?php esc_html_e('Remove Image', 'medcity'); ?></a>
                <?php
            }
            ?>
        </div>

        <p>
            <label for="<?php echo esc_url($this->get_field_id('description')); ?>"><?php esc_html_e('Description', 'medcity'); ?></label>
            <textarea class="widefat" rows="8" cols="20" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo wp_kses_post($description); ?></textarea>
        </p>

        <p><label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>"><?php esc_html_e( 'Button Text', 'medcity' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('button_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('button_text') ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('button_link')); ?>"><?php esc_html_e( 'Button Link', 'medcity' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('button_link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('button_link') ); ?>" type="text" value="<?php echo esc_attr( $button_link ); ?>" /></p>
        <?php
    }

}

function register_contact_box_widget()
{
    global $wp_widget_factory;
    $wp_widget_factory->register( 'CMS_Contact_Box_Widget' );
}

add_action('widgets_init', 'register_contact_box_widget'); ?>