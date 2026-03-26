<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Medcity
 */

/**
 * Setup default image sizes after the theme has been activated
 */
function medcity_after_setup_theme()
{

}
add_action( 'after_setup_theme', 'medcity_after_setup_theme' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function medcity_body_classes( $classes )
{   
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    if (medcity_get_opt( 'site_boxed', false )) {
        $classes[] = 'site-boxed';
    }

    if ( class_exists('WPBakeryVisualComposerAbstract') ) {
        $classes[] = 'visual-composer';
    }

    if (class_exists('ReduxFramework')) {
        $classes[] = 'redux-page';
    }

    $body_default_font = medcity_get_opt( 'body_default_font', 'Default' );
    $heading_default_font = medcity_get_opt( 'heading_default_font', 'Default' );
    $heading_custom_font = medcity_get_page_opt( 'font_heading', ['font-family'=>''] );
    if($heading_custom_font == ''){
        $heading_custom_font = ['font-family' => ''];
    }
    if($body_default_font == 'Default') {
        $classes[] = 'body-default-font';
    }

    if($heading_default_font == 'Default' && $heading_custom_font['font-family'] == '') {
        $classes[] = 'heading-default-font';
    }

    if (medcity_get_opt( 'sticky_on', false )) {
        $classes[] = 'header-sticky';
    }

    return $classes;
}
add_filter( 'body_class', 'medcity_body_classes' );


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function medcity_pingback_header()
{
    if ( is_singular() && pings_open() )
    {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'medcity_pingback_header' );

/**
 * Contact Form 7
 * @since 1.1.1
 * @author Chinh Duong Manh
 * 
 * */
if(class_exists('WPCF7')){
    /**
     * removing default select tag
     */
    remove_action('wpcf7_init', 'wpcf7_add_form_tag_select');
    /**
    ** A base module for [select] and [select*]
    **/

    /* form_tag handler */

    add_action( 'wpcf7_init', 'medcity_wpcf7_add_form_tag_select', 10, 0 );
    function medcity_wpcf7_add_form_tag_select() {
        wpcf7_add_form_tag( array( 'select', 'select*' ),
            'medcity_wpcf7_select_form_tag_handler',
            array(
                'name-attr'         => true,
                'selectable-values' => true,
            )
        );
    }

    function medcity_wpcf7_select_form_tag_handler( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type );

        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }

        $atts = array();

        $atts['class']        = $tag->get_class_option( $class );
        $atts['id']           = $tag->get_id_option();
        $atts['tabindex']     = $tag->get_option( 'tabindex', 'signed_int', true );
        $atts['autocomplete'] = $tag->get_option(
            'autocomplete', '[-0-9a-zA-Z]+', true
        );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        if ( $validation_error ) {
            $atts['aria-invalid'] = 'true';
            $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
                $tag->name
            );
        } else {
            $atts['aria-invalid'] = 'false';
        }

        $multiple       = $tag->has_option( 'multiple' );
        $include_blank  = $tag->has_option( 'include_blank' );
        $first_as_label = $tag->has_option( 'first_as_label' );

        if ( $tag->has_option( 'size' ) ) {
            $size = $tag->get_option( 'size', 'int', true );

            if ( $size ) {
                $atts['size'] = $size;
            } elseif ( $multiple ) {
                $atts['size'] = 4;
            } else {
                $atts['size'] = 1;
            }
        }

        if ( $data = (array) $tag->get_data_option() ) {
            $tag->values = array_merge( $tag->values, array_values( $data ) );
            $tag->labels = array_merge( $tag->labels, array_values( $data ) );
        }

        $values = $tag->values;
        $labels = $tag->labels;

        $default_choice = $tag->get_default_option( null, array(
            'multiple' => $multiple,
        ) );

        if ( $include_blank
        or empty( $values ) ) {
            array_unshift(
                $labels,
                __( '&#8212;Please choose an option&#8212;', 'medcity' )
            );
            array_unshift( $values, '' );
        } elseif ( $first_as_label ) {
            $values[0] = '';
        }

        $html = '';
        $hangover = wpcf7_get_hangover( $tag->name );

        foreach ( $values as $key => $value ) {
            if ( $hangover ) {
                $selected = in_array( $value, (array) $hangover, true );
            } else {
                $selected = in_array( $value, (array) $default_choice, true );
            }

            $item_atts = array(
                'value' => $value,
                'selected' => $selected,
            );

            $label = isset( $labels[$key] ) ? $labels[$key] : $value;

            $html .= sprintf(
                '<option %1$s>%2$s</option>',
                wpcf7_format_atts( $item_atts ),
                esc_html( $label )
            );
        }

        $atts['multiple'] = (bool) $multiple;
        $atts['name'] = $tag->name . ( $multiple ? '[]' : '' );

        /**
         * Custom CF7 Select field
         * add icon option
         * @since 1.1.1
         * @author Chinh Duong Manh
         * 
         * **/
        // icon type
        $atts['icon_type'] = medcity_cf7_get_icon_type($tag->options);
        // icon
        $atts['icon'] = medcity_cf7_get_icon($tag->options);
        $atts['icon_class'] = medcity_cf7_get_icon_class($tag->options);
        $icon = '';
        $icon_position = $tag->get_option( 'icon_position', '[-0-9a-zA-Z]+', true);
        if(isset($atts['icon']) && $atts['icon'] != ''){
            switch($atts['icon_type']){
                case 'svg':
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'">'.medcity_svgs_icon_render([
                        'icon'  => $atts['icon'],
                        'echo'  => false
                    ]).'</span>';
                    break;
                default:
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'"></span>';
                    break;
            }
        }
        // icon position
        $atts['icon_position'] = medcity_cf7_get_icon_position($tag->options);
        $icon_before = $icon_after = '';
        if(isset($atts['icon_position']) && $atts['icon_position'] === 'before'){
            $icon_before = $icon;
        } else{
            $icon_after = $icon;
        }
        // icon select
        $icon_select = '';
        $atts['icon_select'] = medcity_cf7_get_icon_select($tag->options);
        if($tag->has_option( 'icon_select' )){
            $icon_select = '<span class="wpcf7-form-control-icon after select">'.medcity_svgs_icon_render([
                'icon'  => $atts['icon_select'],
                'echo'  => false
            ]).'</span>';
        }
        unset($atts['icon_type']);
        unset($atts['icon']);
        unset($atts['icon_position']);
        unset($atts['icon_class']);
        unset($atts['icon_select']);
        // html
        $html = sprintf(
            '<span class="wpcf7-form-control-wrap cms-wpcf7-form-control-wrap" data-name="%1$s">%5$s<select %2$s>%3$s</select>%4$s%6$s%7$s</span>',
            esc_attr( $tag->name ),
            wpcf7_format_atts( $atts ),
            $html,
            $validation_error,
            $icon_before,
            $icon_after,
            $icon_select
        );

        return $html;
    }
    // Text
    remove_action( 'wpcf7_init', 'wpcf7_add_form_tag_text', 10, 0 );
    add_action( 'wpcf7_init', 'medcity_wpcf7_add_form_tag_text', 10, 0 );

    function medcity_wpcf7_add_form_tag_text() {
        wpcf7_add_form_tag(
            array( 'text', 'text*', 'email', 'email*', 'url', 'url*', 'tel', 'tel*' ),
            'medcity_wpcf7_text_form_tag_handler',
            array(
                'name-attr' => true,
            )
        );
    }

    function medcity_wpcf7_text_form_tag_handler( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

        if ( in_array( $tag->basetype, array( 'email', 'url', 'tel' ) ) ) {
            $class .= ' wpcf7-validates-as-' . $tag->basetype;
        }

        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }

        $atts = array();

        $atts['size'] = $tag->get_size_option( '40' );
        $atts['maxlength'] = $tag->get_maxlength_option();
        $atts['minlength'] = $tag->get_minlength_option();

        if ( $atts['maxlength'] and $atts['minlength']
        and $atts['maxlength'] < $atts['minlength'] ) {
            unset( $atts['maxlength'], $atts['minlength'] );
        }

        $atts['class'] = $tag->get_class_option( $class );
        $atts['id'] = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
        $atts['readonly'] = $tag->has_option( 'readonly' );

        $atts['autocomplete'] = $tag->get_option(
            'autocomplete', '[-0-9a-zA-Z]+', true
        );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        if ( $validation_error ) {
            $atts['aria-invalid'] = 'true';
            $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
                $tag->name
            );
        } else {
            $atts['aria-invalid'] = 'false';
        }

        $value = (string) reset( $tag->values );

        if ( $tag->has_option( 'placeholder' )
        or $tag->has_option( 'watermark' ) ) {
            $atts['placeholder'] = $value;
            $value = '';
        }
        $value = $tag->get_default_option( $value );
        $value = wpcf7_get_hangover( $tag->name, $value );

        /**
         * Custom CF7 Select field
         * add icon option
         * @since 1.1.1
         * @author Chinh Duong Manh
         * 
         * **/
        // icon type
        $atts['icon_type'] = medcity_cf7_get_icon_type($tag->options);
        // icon
        $atts['icon'] = medcity_cf7_get_icon($tag->options);
        $atts['icon_class'] = medcity_cf7_get_icon_class($tag->options);
        $icon = '';
        $icon_position = $tag->get_option( 'icon_position', '[-0-9a-zA-Z]+', true);
        if(isset($atts['icon']) && $atts['icon'] != ''){
            switch($atts['icon_type']){
                case 'svg':
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'">'.medcity_svgs_icon_render([
                        'icon'  => $atts['icon'],
                        'echo'  => false
                    ]).'</span>';
                    break;
                default:
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'"></span>';
                    break;
            }
        }

        $atts['value'] = $value;
        $atts['type'] = $tag->basetype;
        $atts['name'] = $tag->name;

        unset($atts['icon_type']);
        unset($atts['icon']);
        unset($atts['icon_position']);
        unset($atts['icon_class']);

        $html = sprintf(
            '<span class="wpcf7-form-control-wrap" data-name="%1$s"><input %2$s />%3$s%4$s</span>',
            esc_attr( $tag->name ),
            wpcf7_format_atts( $atts ),
            $validation_error,
            $icon
        );

        return $html;
    }

    // Add time tag
    add_action( 'wpcf7_init', 'medcity_add_form_tag_time' );
    function medcity_add_form_tag_time() {
        wpcf7_add_form_tag( ['time','time*'], 'medcity_time_form_tag_handler', array( 'name-attr' => true ) ); // "time" is the type of the form-tag
    }
    function medcity_time_form_tag_handler( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

        if ( in_array( $tag->basetype, array( 'time', 'time*' ) ) ) {
            $class .= ' wpcf7-validates-as-' . $tag->basetype;
        }
        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }
        $atts = array();
        $atts['class']    = $tag->get_class_option( $class );
        $atts['id']       = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        if ( $validation_error ) {
            $atts['aria-invalid'] = 'true';
            $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
                $tag->name
            );
        } else {
            $atts['aria-invalid'] = 'false';
        }
        // icon type
        $atts['icon_type'] = $tag->get_option('icon_type', '[-0-9a-zA-Z]+', true);
        // icon
        $atts['icon']          = medcity_cf7_get_icon($tag->options);
        $atts['icon_class']    = $tag->get_option('icon_class', '[-0-9a-zA-Z]+', true);
        $atts['icon_position'] = medcity_cf7_get_icon_position($tag->options);
        $icon = '';
        $icon_position = $tag->get_option('icon_position', '[-0-9a-zA-Z]+', true);
        if(isset($atts['icon']) && $atts['icon'] != ''){
            switch($atts['icon_type']){
                case 'svg':
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'">'.medcity_svgs_icon_render([
                        'icon'  => $atts['icon'],
                        'echo'  => false
                    ]).'</span>';
                    break;
                default:
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'"></span>';
                    break;
            }
        }
        // placeholder
        $value = (string) reset( $tag->values );
        $placeholder = '';
        if ( $tag->has_option( 'placeholder' )
        or $tag->has_option( 'watermark' ) ) {
            $atts['placeholder'] = $value;
            $placeholder = '<span class="cms-time-placeholder cms-placeholder">'.$value.'</span>';
            $value = '';
        }
        
        $value = $tag->get_default_option( $value );
        $value = wpcf7_get_hangover( $tag->name, $value );
        $atts['value'] = $value;
        if ( wpcf7_support_html5() ) {
            $atts['type'] = $tag->basetype;
        } else {
            $atts['type']        = 'text';
            $atts['onfocus']     = '(this.type="time")';
            $atts['onmouseover'] = '(this.type="time")';
            $atts['onblur']      = '(this.type="time")';
        }

        $atts['name'] = $tag->name;
        unset($atts['icon']);
        unset($atts['icon_position']);
        unset($atts['placeholder']);
        // Generate attributes
        $atts = wpcf7_format_atts( $atts ); 
        $html = sprintf(
            '<span class="wpcf7-form-control-wrap cms-date-time cms-time %1$s">%2$s<input %3$s />%4$s%5$s</span>',
            sanitize_html_class( $tag->name ), 
            $placeholder, 
            $atts, 
            $validation_error,
            $icon
        );

        return $html;
    }
    /* Time Tag generator */
    add_action( 'wpcf7_admin_init', 'wpcf7_add_tag_generator_cms_time', 10 );
    function wpcf7_add_tag_generator_cms_time() {
        $tag_generator = WPCF7_TagGenerator::get_instance();
        $tag_generator->add( 'time', __( 'CMS Time', 'medcity' ),
            'wpcf7_tag_generator_cms_time' );
    }
    function wpcf7_tag_generator_cms_time( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );

        $description = __( "Generate a form-tag for a CMS Time. For more details, see %s.", 'medcity' );

        $desc_link = wpcf7_link( __( 'https://7oroof.com/knowledge-base/', 'medcity' ), __( 'CMS Time', 'medcity' ) );

    ?>
    <div class="control-box">
    <fieldset>
    <legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

    <table class="form-table">
    <tbody>
        <tr>
        <th scope="row"><?php echo esc_html( __( 'Field type', 'medcity' ) ); ?></th>
        <td>
            <fieldset>
            <legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'medcity' ) ); ?></legend>
            <label><input type="checkbox" name="required" /> <?php echo esc_html( __( 'Required field', 'medcity' ) ); ?></label>
            </fieldset>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'medcity' ) ); ?></label></th>
        <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
        </tr>

        <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-values' ); ?>"><?php echo esc_html( __( 'Default value', 'medcity' ) ); ?></label></th>
        <td><input type="text" name="values" class="oneline" id="<?php echo esc_attr( $args['content'] . '-values' ); ?>" /><br />
        <label><input type="checkbox" name="placeholder" class="option" /> <?php echo esc_html( __( 'Use this text as the placeholder of the field', 'medcity' ) ); ?></label></td>
        </tr>


        <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'medcity' ) ); ?></label></th>
        <td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
        </tr>

        <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'medcity' ) ); ?></label></th>
        <td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
        </tr>

    </tbody>
    </table>
    </fieldset>
    </div>

    <div class="insert-box">
        <input type="text" name="time" class="tag code" readonly="readonly" onfocus="this.select()" />

        <div class="submitbox">
        <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'medcity' ) ); ?>" />
        </div>

        <br class="clear" />

        <p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'medcity' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
    </div>
    <?php
    }

    // Custom date tag
    remove_action('wpcf7_init', 'wpcf7_add_form_tag_date');
    add_action( 'wpcf7_init', 'medcity_add_form_tag_cms_date' );
    function medcity_add_form_tag_cms_date() {
        wpcf7_add_form_tag( ['date','date*'], 'medcity_cms_date_form_tag_handler', array( 'name-attr' => true ) ); // "time" is the type of the form-tag
    }
    function medcity_cms_date_form_tag_handler( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

        if ( in_array( $tag->basetype, array( 'date', 'date*', 'tel' ) ) ) {
            $class .= ' wpcf7-validates-as-' . $tag->basetype;
        }
        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }
        $atts = array();
        $atts['class']    = $tag->get_class_option( $class );
        $atts['id']       = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        if ( $validation_error ) {
            $atts['aria-invalid'] = 'true';
            $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
                $tag->name
            );
        } else {
            $atts['aria-invalid'] = 'false';
        }
        // icon type
        $atts['icon_type'] = $tag->get_option('icon_type', '[-0-9a-zA-Z]+', true);
        // icon
        $atts['icon']          = medcity_cf7_get_icon($tag->options);
        $atts['icon_class']    = $tag->get_option('icon_class', '[-0-9a-zA-Z]+', true);
        $atts['icon_position'] = medcity_cf7_get_icon_position($tag->options);
        $icon = '';
        $icon_position = $tag->get_option('icon_position', '[-0-9a-zA-Z]+', true);
        if(isset($atts['icon']) && $atts['icon'] != ''){
            switch($atts['icon_type']){
                case 'svg':
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'">'.medcity_svgs_icon_render([
                        'icon'  => $atts['icon'],
                        'echo'  => false
                    ]).'</span>';
                    break;
                default:
                    $icon = '<span class="wpcf7-form-control-icon '.$atts['icon'].' '.$icon_position.' '.$atts['icon_class'].'"></span>';
                    break;
            }
        }
        $icon_before = $icon_after = '';
        if ( $tag->has_option( 'icon' ) && $atts['icon'] !== ''){
            if($atts['icon_position'] === 'before'){
                $icon_before = $icon;
            } else {
                $icon_after = $icon;
            }
        }

        // placeholder
        $value = (string) reset( $tag->values );
        $placeholder = '';
        if ( $tag->has_option( 'placeholder' )
        or $tag->has_option( 'watermark' ) ) {
            $atts['placeholder'] = $value;
            $placeholder = '<span class="cms-date-placeholder cms-placeholder">'.$value.'</span>';
            $value = '';
        }

        $value = $tag->get_default_option( $value );
        $value = wpcf7_get_hangover( $tag->name, $value );
        $atts['value'] = $value;
        if ( wpcf7_support_html5() ) {
            $atts['type'] = $tag->basetype;
            $atts['min'] = date('Y-m-d');
        } else {
            $atts['type']        = 'text';
            $atts['onfocus']     = '(this.type="date")';
            $atts['onmouseover'] = '(this.type="date")';
            $atts['onblur']      = '(this.type="date")';
        }
        $atts['name'] = $tag->name;
        
        unset($atts['icon_type']);
        unset($atts['icon']);
        unset($atts['icon_position']);
        unset($atts['placeholder']);
        // Generate attributes
        $atts = wpcf7_format_atts( $atts ); 
        $html = sprintf(
            '<span class="wpcf7-form-control-wrap cms-date-time cms-date %1$s">%2$s<input %3$s />%4$s%5$s</span>',
            sanitize_html_class( $tag->name ), 
            $placeholder, 
            $atts, 
            $validation_error,
            $icon
        );

        return $html;
    }
    /**
     * removing default submit tag
     */
    remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
    /**
     * adding action with function which handles our button markup
     */
    add_action('wpcf7_init', 'medcity_cf7_submit_button');
    /**
     * adding out submit button tag
     */
    if (!function_exists('medcity_cf7_submit_button')) {
        function medcity_cf7_submit_button() {
            wpcf7_add_form_tag('submit', 'medcity_cf7_submit_button_handler');
        }
    }
    /**
     * out button markup inside handler
     */
    if (!function_exists('medcity_cf7_submit_button_handler')) {
        function medcity_cf7_submit_button_handler($tag) {
            $tag              = new WPCF7_FormTag($tag);
            $class            = wpcf7_form_controls_class($tag->type);
            $atts             = array();
            $atts['class']    = $tag->get_class_option($class);
            $atts['id']       = $tag->get_id_option();
            $atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
            $value            = isset($tag->values[0]) ? $tag->values[0] : '';
            if (empty($value)) {
                $value = esc_html__('Send', 'medcity');
            }
            $atts['type'] = 'submit';
            // icon type
            $atts['icon_type'] = medcity_cf7_get_icon_type($tag->options);
            // icon
            $atts['icon'] = medcity_cf7_get_icon($tag->options);
            $atts['icon_class'] = medcity_cf7_get_icon_class($tag->options);
            $icon = '';
            if(isset($atts['icon']) && $atts['icon'] != ''){
                switch($atts['icon_type']){
                    case 'svg':
                        $icon = '<span class="wpcf7-submit-icon rtl-flip '.$atts['icon'].' '.$atts['icon_class'].'">'.medcity_elementor_svg_hover_icon_render([
                            'icon'  => $atts['icon'],
                            'echo'  => false
                        ]).'</span>';
                        break;
                    default:
                        $icon = '<span class="wpcf7-submit-icon rtl-flip '.$atts['icon'].' '.$atts['icon_class'].'"></span>';
                        break;
                }
            }
            // icon position
            $atts['icon_position'] = medcity_cf7_get_icon_position($tag->options);
            $icon_before = $icon_after = '';
            if(isset($atts['icon_position']) && $atts['icon_position'] === 'before'){
                $icon_before = $icon;
            } else{
                $icon_after = $icon;
            }
            unset($atts['icon_type']);
            unset($atts['icon']);
            unset($atts['icon_position']);
            unset($atts['icon_class']);
            $atts = wpcf7_format_atts($atts);   
            
            $html = sprintf('<button %1$s>%2$s%3$s%4$s</button>', $atts, $icon_before, $value, $icon_after);
            return $html;
        }
    }
    //
    if(!function_exists('medcity_cf7_get_icon_type')){
        function medcity_cf7_get_icon_type($data, $default=''){
            if ( is_string( $default ) ) {
                $default = explode( ' ', $default );
            }
            $options = array_merge(
                (array) $default,
                (array) medcity_cf7_get_atts( $data, 'icon_type', 'icon_type' ) 
            );

            $options = array_filter( array_unique( $options ) );

            return implode( ' ', $options );
        }
    }

    if(!function_exists('medcity_cf7_get_icon')){
        function medcity_cf7_get_icon($data, $default=''){
            if ( is_string( $default ) ) {
                $default = explode( ' ', $default );
            }
            $options = array_merge(
                (array) $default,
                (array) medcity_cf7_get_atts( $data, 'icon', 'icon' )
            );

            $options = array_filter( array_unique( $options ) );

            return implode( ' ', $options );
        }
    }
    if(!function_exists('medcity_cf7_get_icon_class')){
        function medcity_cf7_get_icon_class($data, $default=''){
            if ( is_string( $default ) ) {
                $default = explode( ' ', $default );
            }
            $options = array_merge(
                (array) $default,
                (array) medcity_cf7_get_atts( $data, 'icon_class', 'icon_class' )
            );

            $options = array_filter( array_unique( $options ) );

            return implode( ' ', $options );
        }
    }

    if(!function_exists('medcity_cf7_get_icon_position')){
        function medcity_cf7_get_icon_position($data, $default=''){
            if ( is_string( $default ) ) {
                $default = explode( ' ', $default );
            }
            $options = array_merge(
                (array) $default,
                (array) medcity_cf7_get_atts( $data, 'icon_position', 'icon_position' )
            );

            $options = array_filter( array_unique( $options ) );

            return implode( ' ', $options );
        }
    }

    if(!function_exists('medcity_cf7_get_icon_select')){
        function medcity_cf7_get_icon_select($data, $default=''){
            if ( is_string( $default ) ) {
                $default = explode( ' ', $default );
            }
            $options = array_merge(
                (array) $default,
                (array) medcity_cf7_get_atts( $data, 'icon_select', 'icon_select' )
            );

            $options = array_filter( array_unique( $options ) );

            return implode( ' ', $options );
        }
    }

    function medcity_cf7_get_atts( $data, $opt, $pattern = '', $single = false ) {
        $preset_patterns = array(
            'date'          => '([0-9]{4}-[0-9]{2}-[0-9]{2}|today(.*))',
            'int'           => '[0-9]+',
            'signed_int'    => '-?[0-9]+',
            'class'         => '[-0-9a-zA-Z_]+',
            'icon_type'     => '[-0-9a-zA-Z_]+',
            'icon'          => '[-0-9a-zA-Z_]+',
            'icon_position' => '[-0-9a-zA-Z_]+',
            'icon_class'    => '[-0-9a-zA-Z_]+',
            'icon_select'   => '[-0-9a-zA-Z_]+',
            'id'            => '[-0-9a-zA-Z_]+',
        );

        if ( isset( $preset_patterns[$pattern] ) ) {
            $pattern = $preset_patterns[$pattern];
        }

        if ( '' == $pattern ) {
            $pattern = '.+';
        }

        $pattern = sprintf( '/^%s:%s$/i', preg_quote( $opt, '/' ), $pattern );

        if ( $single ) {
            $matches = medcity_cf7_get_first_match_option( $data, $pattern );

            if ( ! $matches ) {
                return false;
            }

            return substr( $matches[0], strlen( $opt ) + 1 );
        } else {
            $matches_a = medcity_cf7_get_all_match_options( $data, $pattern );

            if ( ! $matches_a ) {
                return false;
            }

            $results = array();

            foreach ( $matches_a as $matches ) {
                $results[] = substr( $matches[0], strlen( $opt ) + 1 );
            }

            return $results;
        }
    }
    function medcity_cf7_get_first_match_option( $options, $pattern ) {
        foreach( (array) $options as $option ) {
            if ( preg_match( $pattern, $option, $matches ) ) {
                return $matches;
            }
        }

        return false;
    }
    function medcity_cf7_get_all_match_options( $options, $pattern ) {
        $result = array();

        foreach( (array) $options as $option ) {
            if ( preg_match( $pattern, $option, $matches ) ) {
                $result[] = $matches;
            }
        }

        return $result;
    }
}