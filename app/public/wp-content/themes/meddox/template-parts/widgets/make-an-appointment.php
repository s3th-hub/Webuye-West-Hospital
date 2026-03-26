<?php
defined( 'ABSPATH' ) or exit( -1 );

/**
 * contact Information widgets
 *
 */

if(!function_exists('pxl_register_wp_widget')) return;
add_action( 'widgets_init', function(){
    pxl_register_wp_widget( 'PXL_Contact_Info_Widget' );
});
class PXL_contact_Info_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'pxl_contact_info_widget',
            esc_html__('* Pxl Appointment', 'meddox'),
            array('description' => esc_html__('Show contact Information', 'meddox'),)
        );
    }

    function widget($args, $instance)
    {
        if(!is_singular('post')){
            return;
        }
        extract($args);
        $contact_image_id = isset($instance['contact_image']) ? (!empty($instance['contact_image']) ? $instance['contact_image'] : '') : '';
        $contact_image_url = wp_get_attachment_image_url($contact_image_id, '');
        $contact_heading = isset($instance['contact_heading']) ? (!empty($instance['contact_heading']) ? $instance['contact_heading'] : '') : '';
        $contact_sub = isset($instance['contact_sub']) ? (!empty($instance['contact_sub']) ? $instance['contact_sub'] : '') : '';
        $description = isset($instance['description']) ? (!empty($instance['description']) ? $instance['description'] : '') : '';
        $button_text = isset($instance['button_text']) ? (!empty($instance['button_text']) ? $instance['button_text'] : '') : '';
        $button_link = isset($instance['button_link']) ? (!empty($instance['button_link']) ? $instance['button_link'] : '') : '';
        ?>
        <div class="pxl-contact-info widget" >
            <div class="content-inner" style="background-image: url(<?php echo esc_url($contact_image_url)?>);">
                <div class="background-overlay-2"></div>
                <div class="contact-image" >
                    <div class="image-wrap" >
                    <?php
                    if (!empty($contact_heading) || !empty($contact_sub)){
                        ?>
                        <div class="heading-sub">
                            <?php if (!empty($contact_sub)): ?>  
                                <div class="contact-sub">
                                    <?php echo esc_html($contact_sub);?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($contact_heading)): ?>
                                <h4 class="contact-heading"><?php echo esc_html($contact_heading);?></h4>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php if (!empty($description)): ?>
                    <div class="contact-desc">
                        <?php
                        if (function_exists('lcb_print_html')){
                            lcb_print_html(nl2br($description));
                        }else{
                            echo wp_kses_post($description);
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($button_text)): ?>
                    <div class="button-text pxl-button-wrapper">
                        <a href="<?php echo esc_html($button_link);?>" class="btn btn-white"><span><?php echo esc_html($button_text);?></span></a>
                    </div>
                <?php endif; ?>
                    </div>
                    
                </div>

            </div>
        </div>
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['contact_image'] = strip_tags($new_instance['contact_image']);
        $instance['contact_sub'] = strip_tags($new_instance['contact_sub']);
        $instance['contact_heading'] = strip_tags($new_instance['contact_heading']);
        $instance['description'] = strip_tags($new_instance['description']);
        $instance['button_text'] = strip_tags($new_instance['button_text']);
        $instance['button_link'] = strip_tags($new_instance['button_link']);
        return $instance;
    }

    function form($instance)
    {
        $contact_image = isset($instance['contact_image']) ? esc_attr($instance['contact_image']) : '';
        $contact_heading = isset($instance['contact_heading']) ? esc_html($instance['contact_heading']) : '';
        $contact_sub = isset($instance['contact_sub']) ? esc_html($instance['contact_sub']) : '';
        $description = isset($instance['description']) ? esc_html($instance['description']) : '';
        $button_text = isset($instance['button_text']) ? esc_html($instance['button_text']) : '';
        $button_link = isset($instance['button_link']) ? esc_html($instance['button_link']) : '';
        ?>
        <div class="meddox-image-wrap">
            <label for="<?php echo esc_url($this->get_field_id('contact_image')); ?>"><?php esc_html_e('Appointment Image', 'meddox'); ?></label>
            <input type="hidden" class="widefat hide-image-url"
                   id="<?php echo esc_attr($this->get_field_id('contact_image')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('contact_image')); ?>"
                   value="<?php echo esc_attr($contact_image) ?>"/>
            <div class="pxl-show-image">
                <?php
                if ($contact_image != "") {
                    ?>
                    <img src="<?php echo wp_get_attachment_image_url($contact_image) ?>">
                    <?php
                }
                ?>
            </div>
            <?php
            if ($contact_image != "") {
                ?>
                <a href="#" class="pxl-select-image" style="display: none;"><?php esc_html_e('Select Image', 'meddox'); ?></a>
                <a href="#" class="pxl-remove-image"><?php esc_html_e('Remove Image', 'meddox'); ?></a>
                <?php
            } else {
                ?>
                <a href="#" class="pxl-select-image"><?php esc_html_e('Select Image', 'meddox'); ?></a>
                <a href="#" class="pxl-remove-image" style="display: none;"><?php esc_html_e('Remove Image', 'meddox'); ?></a>
                <?php
            }
            ?>
        </div>
        <p>
            <label for="<?php echo esc_url($this->get_field_id('contact_sub')); ?>"><?php esc_html_e( 'contact sub', 'meddox' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('contact_sub') ); ?>" name="<?php echo esc_attr( $this->get_field_name('contact_sub') ); ?>" type="text" value="<?php echo esc_attr( $contact_sub ); ?>" />
        </p>
        
        <p>
            <label for="<?php echo esc_url($this->get_field_id('contact_heading')); ?>"><?php esc_html_e( 'contact heading', 'meddox' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('contact_heading') ); ?>" name="<?php echo esc_attr( $this->get_field_name('contact_heading') ); ?>" type="text" value="<?php echo esc_attr( $contact_heading ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_url($this->get_field_id('description')); ?>"><?php esc_html_e('Description', 'meddox'); ?></label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo wp_kses_post($description); ?></textarea>
        </p>

        <p>
            <label for="<?php echo esc_url($this->get_field_id('button_text')); ?>"><?php esc_html_e('Button Text', 'meddox'); ?></label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr($this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>"><?php echo wp_kses_post($button_text); ?></textarea>
        </p>

        <p>
            <label for="<?php echo esc_url($this->get_field_id('button_link')); ?>"><?php esc_html_e('Button Link', 'meddox'); ?></label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr($this->get_field_id('button_link')); ?>" name="<?php echo esc_attr($this->get_field_name('button_link')); ?>"><?php echo wp_kses_post($button_link); ?></textarea>
        </p>
        <?php
    }

}