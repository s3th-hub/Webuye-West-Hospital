<?php
$files = scandir(get_template_directory() . '/elementor/core/register');
foreach ($files as $file){
    $pos = strrpos($file, ".php");
    if($pos !== false){
        require_once get_template_directory() . '/elementor/core/register/' . $file;
    }
}
if(!function_exists('medcity_register_custom_icon_library')){
    add_filter('elementor/icons_manager/native', 'medcity_register_custom_icon_library');
    function medcity_register_custom_icon_library($tabs){
        $custom_tabs = [
            'extra_icon1' => [
                'name' => 'material',
                'label' => esc_html__( 'Material Design Iconic', 'medcity' ),
                'url' => get_template_directory_uri() . '/assets/css/material-design-iconic-font.min.css',
                'enqueue' => [  ],
                'prefix' => 'zmdi zmdi-',
                'displayPrefix' => 'material',
                'labelIcon' => 'zmdi zmdi-collection-text',
                'ver' => '1.0.0',
                'fetchJson' => get_template_directory_uri() . '/assets/elementor-icon/materialdesign.js',
                'native' => true,
            ],
            'extra_icon2' => [
                'name' => 'flaticon',
                'label' => esc_html__( 'Flaticon', 'medcity' ),
                'url' => get_template_directory_uri() . '/assets/css/flaticon.css',
                'enqueue' => [  ],
                'prefix' => 'flaticon-',
                'displayPrefix' => 'flaticon',
                'labelIcon' => 'flaticon-project',
                'ver' => '1.0.0',
                'fetchJson' => get_template_directory_uri() . '/assets/elementor-icon/flaticon.js',
                'native' => true,
            ],
        ];

        $tabs = array_merge($custom_tabs, $tabs);

        return $tabs;
    }
}
/**
 * New Elementor elements
 * @since 1.1.1
 * @author Chinh Duong Manh
 * duongmanhchinh@gmail.com
 * 
 * **/
if (!function_exists('medcity_elementor_register_widgets')) {
    add_filter('etc_register_widgets', 'medcity_elementor_register_widgets');
    function medcity_elementor_register_widgets($widgets)
    {
        $widgets = [
            [ // Cms Banner
                'name'       => 'cms_banner',
                'title'      => esc_html__('CMS Banner', 'medcity'),
                'icon'       => 'eicon-banner',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords' => [
                    'medcity', 'cms banner', 'banner'
                ]
            ],
            [ // Cms CTA
                'name'       => 'cms_cta',
                'title'      => esc_html__('CMS Call to Action', 'medcity'),
                'icon'       => 'eicon-image-rollover',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords' => [
                    'medcity', 'cms call to acction', 'call to acction'
                ]
            ],
            [ // Cms Copyright
                'name'       => 'cms_copyright',
                'title'      => esc_html__('CMS Copyright', 'medcity'),
                'icon'       => 'eicon-menu-bar',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'medcity', 'cms copyright', 'copyright'
                ]
            ],
            [ // Cms Heading
                'name'       => 'cms_heading2',
                'title'      => esc_html__('CMS Heading', 'medcity'),
                'icon'       => 'eicon-t-letter',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords' => [
                    'medcity', 'cms heading', 'heading'
                ]
            ],
            [ // CMS Quick Contact
                'name'       => 'cms_quickcontact',
                'title'      => esc_html__('CMS Quick Contact', 'medcity'),
                'icon'       => 'eicon-mail',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'medcity', 'cms quick contact', 'quick', 'contact',
                ]
            ],
            [ // Cms Slider
                'name'       => 'cms_slider',
                'title'      => esc_html__('CMS Slider', 'medcity'),
                'icon'       => 'eicon-slides',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-swiper',
                ],
                'keywords' => [
                    'medcity', 'cms slider', 'slider'
                ]
            ],
            [ // Cms Testimonial
                'name'       => 'cms_testimonials',
                'title'      => esc_html__('CMS Testimonials', 'medcity'),
                'icon'       => 'eicon-testimonial',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'cms-swiper',
                ],
                'keywords' => [
                    'cms', 'medcity', 'testimonial', 'testimonials', 'carousel'
                ]
            ],
            [ // Cms Video
                'name'       => 'cms_video',
                'title'      => esc_html__('CMS Video', 'medcity'),
                'icon'       => 'eicon-play',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords' => [
                    'medcity', 'video'
                ]
            ],
            [ // Cms Zocdoc
                'name'       => 'cms_zocdoc',
                'title'      => esc_html__('CMS Zocdoc', 'medcity'),
                'icon'       => 'eicon-rating',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords' => [
                    'medcity', 'zocdoc rating', 'zocdoc', 'rating'
                ]
            ]
        ];
        return $widgets;
    }
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Icons_Manager;
function medcity_nice_class($classes = []){
    $classes = (array) $classes;
    return implode(' ', array_filter($classes));
}
if(!function_exists('medcity_elementor_colors_opts')){
    function medcity_elementor_colors_opts($widget=[],$args = []){
        $args = wp_parse_args($args, [
            'name'      => '',
            'selector'  => [],
            'label'     => esc_html__('Color', 'medcity'),
            'separator' => '',
            'condition' => [],
            'custom'    => true    
        ]);
        $widget->add_control(
            $args['name'],
            [
                'label'     => $args['label'],
                'type'      => Controls_Manager::SELECT,
                'options'   => medcity_theme_colors(['custom' => $args['custom']]),
                'default'   => '',
                'separator' => $args['separator'],
                'condition' => $args['condition']
            ]
        );
        if($args['custom']){
            $widget->add_control(
                $args['name'].'_custom',
                [
                    'label'     => $args['label'].' '.esc_html__( 'Custom', 'medcity' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => $args['selector'],
                    'condition' => array_merge(
                        $args['condition'],
                        [
                            $args['name'] => 'custom'
                        ]
                    )
                ]
            );
        }
    }
}
if(!function_exists('medcity_theme_colors')){
    function medcity_theme_colors($args = []){
        $args = wp_parse_args($args, [
            'custom' => true
        ]);
        $colors = medcity_configs('theme_colors');
        $customs = apply_filters('medcity_elementor_theme_custom_colors', []);

        $opts = [
            ''          => esc_html__('Default','medcity'),
            'primary'   => esc_html__('Primary', 'medcity'),
            'secondary' => esc_html__('Secondary', 'medcity'),
            'tertiary'  => esc_html__('Tertiary', 'medcity'),
            'white'     => esc_html__('White','medcity')
        ];
        if($args['custom']){
            $customs['custom'] = esc_html__('Custom','medcity');
        }
        return array_merge($opts, $customs);
    }
}
if(!function_exists('medcity_add_hidden_device_controls')){
    function medcity_add_hidden_device_controls($widget = [], $args = []) {
        $args = wp_parse_args($args, [
            'prefix'    => 'cms_',
            'condition' => []
        ]);
        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

        foreach ( $active_devices as $breakpoint_key ) {
            $label = 'desktop' === $breakpoint_key ? esc_html__( 'Desktop', 'medcity' ) : $active_breakpoints[ $breakpoint_key ]->get_label();

            $widget->add_control(
                $args['prefix'].'hide_' . $breakpoint_key,
                [
                    /* translators: %s: Device name. */
                    'label'        => sprintf( __( 'Hide On %s', 'medcity' ), $label ),
                    'type'         => Controls_Manager::SWITCHER,
                    'default'      => '',
                    //'prefix_class' => 'elementor-',
                    'label_on'     => esc_html__( 'Hide', 'medcity' ),
                    'label_off'    => esc_html__( 'Show', 'medcity' ),
                    //'return_value' => 'hidden-' . $breakpoint_key,
                    'condition' => $args['condition']
                ]
            );
        }
    }
}
if(!function_exists('medcity_add_hidden_device_controls_render')){
    function medcity_add_hidden_device_controls_render($settings = [], $prefix = ''){
        $active_devices     = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
        $hidden             = [];
        foreach ($active_devices as $device) {
            $hidden[] = ($settings[$prefix.'hide_'.$device] === 'yes') ? 'cms-hidden-'.$device : '';
        }
        return implode(' ',array_filter($hidden));
    }
}
// Display Alignment
if(!function_exists('medcity_elementor_reponsive_flex_alignment')){
    function medcity_elementor_responsive_flex_alignment($widget = [], $args = []){
        $args = wp_parse_args($args, [
            'name'      => 'align',
            'condition' => [],
            'label'     => esc_html__( 'Alignment', 'medcity' )
        ]);
        return $widget->add_responsive_control(
            $args['name'],
            [
                'label'        => $args['label'],
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'start'    => [
                        'title' => esc_html__( 'Left', 'medcity' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Center', 'medcity' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'end'   => [
                        'title' => esc_html__( 'Right', 'medcity' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'between' => [
                        'title' => esc_html__( 'Between', 'medcity' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'condition' => $args['condition']
            ]
        );
    }
}
// Alignment Class
if(!function_exists('medcity_elementor_get_alignment_class')){
    function medcity_elementor_get_alignment_class($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'name'         => '',
            'default'      => '',
            'prefix_class' => 'text-',
            'desktop'      => '',
            'widescreen'   => '', 
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => '',
            'smobile'      => '' 
        ]);
        
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $align_class = [];
        if(!empty($settings[$args['name']]) || !empty($args['default'])){
            $align_class[] = $args['prefix_class'].$widget->get_setting($args['name'], $args['default']);
        }
        // Align Class
        foreach ( $active_devices as $key => $breakpoint_key ) {
            $breakpoint_key_class =  str_replace('_','-',$breakpoint_key);

            $setting_breakpoint_key = $widget->get_setting($args['name'].'_' . $breakpoint_key, $args[$breakpoint_key]);

            if($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key) ){
                //$align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$settings[$args['name'].'_' . $breakpoint_key];
                $align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$setting_breakpoint_key;
            }
        }
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));
        
        // return
        return medcity_nice_class($align_class);
    }
}
// Elementor default Icon
if(!function_exists('medcity_elementor_icon_default')){
    function medcity_elementor_icon_default($icon = ['value' => '', 'library' => ''], $default = ['value' => '', 'library']){
        if(empty($icon['value'])) $icon = $default;
        return $icon;
    }
}
if(!function_exists('medcity_elementor_icon_render')){
    function medcity_elementor_icon_render($icon=[], $default=[], $attrs=[], $tag = 'i', $before = '', $after = ''){
        $attrs = wp_parse_args($attrs, [
            'icon_size'        => '',
            'icon_color'       => '',
            'icon_color_hover' => '',
            'class'            => ''
        ]);
        $icon             = medcity_elementor_icon_default($icon, $default);
        $icon_size        = !empty($attrs['icon_size']) ? 'text-'.$attrs['icon_size'] : '';
        $icon_color       = !empty($attrs['icon_color']) ? 'text-'.$attrs['icon_color']: '';
        $icon_color_hover = !empty($attrs['icon_color_hover']) ? 'text-hover-'.$attrs['icon_color_hover'] : '';

        $attrs['class']   = is_string($attrs['class']) ?  explode(' ', $attrs['class']) : $attrs['class'];
        $attrs['class'][] = $icon_size;
        $attrs['class'][] = $icon_color;
        $attrs['class'][] = $icon_color_hover;
        $attrs['class'][] = 'rtl-flip';
        $attrs['class'] = medcity_nice_class($attrs['class']);
        $style = '';

        unset($attrs['icon_size']);
        unset($attrs['icon_color']);
        unset($attrs['icon_color_hover']);
        // before
        printf('%s', $before);
        if($icon['library'] === 'cms-svg') {
            $attrs['class'] .= ' cms-html-svg lh-0';
            medcity_svgs_icon_render([
                'icon' => $icon['value'],
                'echo' => true,
                'before' => '<'.$tag.' '.\Elementor\Utils::render_html_attributes( $attrs ).'>',
                'after'  => '</'.$tag.'>'
            ]);
        } elseif($icon['library'] === 'svg') {
            $attrs['class'] .= ' cms-eicon-uploaded-svg lh-0';
            $attrs['data-size'] = $icon_size;
        ?>
            <<?php etc_print_html($tag.' '.\Elementor\Utils::render_html_attributes( $attrs ));?> ><?php 
                Icons_Manager::render_icon( $icon, $attrs, $tag );
            ?></<?php etc_print_html($tag) ?>>
        <?php } else {
            Icons_Manager::render_icon( $icon, $attrs, $tag ); 
        }
        printf('%s', $after);
    }
}
// Icon & Image Settings 
if(!function_exists('medcity_elementor_icon_image_settings')){
    function medcity_elementor_icon_image_settings($widget, $args = []){
        $args = wp_parse_args($args, [
            // Group
            'label'     => esc_html__('Icon/Image Settings', 'medcity'),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => [],
            'conditions' => [],
            'group'     => true,
            'skin'      => 'inline',
            //
            'prefix'   => '',
            'name'     => 'icon_img',
            'type'     => 'icon', 
            // icon
            'icon_label'   => __('Choose Icon','medcity'),
            'icon_default' => [
                'library' => 'medcity',
                'value'   => 'medcity-icon-widgets'  
            ],
            // image
            'img_label'        => __('Choose Image','medcity'),
            'img_default'      => [],
            'img_size'         => true, 
            'img_default_size' => 'thumbnail',
        ]);
        if(!empty($args['conditions'])){
            $condition_tag = 'conditions';
            $condition_value = $args['conditions'];
            $condition_relation_icon = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'icon'
                ],
                $args['conditions']
            );
            $condition_relation_img = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'image',
                ],
                $args['conditions']
            );
            $condition_relation_img_size = array_merge(
                [
                    $args['prefix'].$args['name'].'_type'        => 'image',
                    $args['prefix'].$args['name'].'_image[url]!' => '',
                ],
                $args['conditions']
            );
        } else {
            $condition_tag = 'condition';
            $condition_value = $args['condition'];
            $condition_relation_icon = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'icon'
                ],
                $args['condition']
            );
            $condition_relation_img = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'image',
                ],
                $args['condition']
            );
            $condition_relation_img_size = array_merge(
                [
                    $args['prefix'].$args['name'].'_type'        => 'image',
                    $args['prefix'].$args['name'].'_image[url]!' => '',
                ],
                $args['condition']
            );
        }
        if($args['group']){
            $widget->start_controls_section(
                $args['prefix'].'icon_img_section',
                [
                    'label'        => $args['label'],
                    'tab'          => $args['tab'],
                    $condition_tag => $condition_value
                ]
            );
        }
            $widget->add_control(
                $args['prefix'].$args['name'].'_type',
                [
                    'label'   => esc_html__('Icon Type', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'icon'  => esc_html__('Icon','medcity'),
                        'image' => esc_html__('Image','medcity'),
                        ''      => esc_html__('None','medcity'),
                    ],
                    'default' => $args['type'],
                    $condition_tag => $condition_value
                ]
            );
            $widget->add_control(
                $args['prefix'].$args['name'].'_icon',
                [
                    'label'     => $args['icon_label'],
                    'type'      => Controls_Manager::ICONS,
                    $condition_tag => $condition_relation_icon,
                    'default'     => $args['icon_default'],
                    'skin'        => $args['skin'],
                    'label_block' => false
                ]
            );
            $widget->add_control(
                $args['prefix'].$args['name'].'_image',
                [
                    'label'       => $args['img_label'],
                    'type'        => Controls_Manager::MEDIA,
                    $condition_tag => $condition_relation_img,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'skin'        => $args['skin'],
                    'label_block' => false
                ]
            );
            if($args['img_size']){
                $widget->add_group_control(
                    Group_Control_Image_Size::get_type(),
                    [
                        'name'         => $args['prefix'].$args['name'].'_image',
                        'label'        => esc_html__('Image Size','medcity'),
                        'default'      => $args['img_default_size'],
                        $condition_tag => $condition_relation_img_size,
                    ]
                );
            }
        if($args['group']){
            $widget->end_controls_section();
        }
    }
}
// Icon & Image Render
if(!function_exists('medcity_elementor_icon_image_render')){
    function medcity_elementor_icon_image_render($widget = [], $settings = [], $args = [], $data = []){
        $args = wp_parse_args($args,[
            'prefix'      => '',
            'name'        => 'icon_img',
            'size'        => 64,
            'color'       => 'accent',
            'color_hover' => 'accent',
            // icon
            'icon_default' => [],
            'icon_tag'    => 'div',
            // image
            'img_size'   => true,
            // default
            'class'      => '',
            'before'     => '',
            'after'      => '',
            'echo'       => true,
        ]);
        if(!empty($data)){
            $settings = $data;
        }
        $icon_type = $settings[$args['prefix'].$args['name'].'_type'];
        // Render Icon / Image
        switch ($icon_type) {
            case 'image':
                medcity_elementor_image_render( $settings, [
                    'name'           => $args['prefix'].$args['name'].'_image',
                    'image_size_key' => $args['prefix'].$args['name'].'_image',
                    'size'           => $args['img_size'] ? $args['prefix'].$args['name'].'_image' : 'custom',    
                    'img_class'      => $args['class'], 
                    'custom_size'    => ['width' => $args['size'], 'height' => $args['size']],
                    'before'         => $args['before'],
                    'after'          => $args['after'] 
                ]);
                break;
            case 'icon':
                medcity_elementor_icon_render($settings[$args['prefix'].$args['name'].'_icon'], $args['icon_default'], [
                    'aria-hidden'      => 'true', 
                    'class'            => $args['class'], 
                    'icon_size'        => $args['size'], 
                    'icon_color'       => $args['color'], 
                    'icon_color_hover' => $args['color_hover']  
                ], $args['icon_tag'], $args['before'], $args['after']);
                break;
        }
    }
}
// Elementor Image Render
if(!function_exists('medcity_elementor_image_render')){
    function medcity_elementor_image_render( $settings = [], $args = []){
        if(!class_exists('\Elementor\Plugin') && !class_exists('Elementor_Theme_Core')) return;
        $args = wp_parse_args($args, [
            'name'           => 'image',     
            'image_size_key' => '',
            'size'           => 'medium',
            'custom_size'    => ['width' => get_option('medium_size_w'), 'height' => get_option('medium_size_h')],
            'img_class'      => '',
            'max_height'     => false,   
            'before'         => '',
            'after'          => ''
        ]);
        if(empty($args['image_size_key'])) $args['image_size_key'] = $args['name'];
        // add custom args for $settings
        $settings['img_class']   = $args['img_class'];
        $settings['size']        = $args['size'];
        $settings['custom_size'] = $args['custom_size'];
        $settings['max_height']  = $args['max_height'];

        // Default custom image size
        if(!isset($settings[$args['name'].'_custom_dimension'])){
            $settings[$args['name'].'_custom_dimension'] = $args['custom_size'];
        } else {
            $settings[$args['name'].'_custom_dimension']['width'] = !empty($settings[$args['name'].'_custom_dimension']['width']) ? $settings[$args['name'].'_custom_dimension']['width'] : $args['custom_size']['width'];
            
            $settings[$args['name'].'_custom_dimension']['height'] = !empty($settings[$args['name'].'_custom_dimension']['height']) ? $settings[$args['name'].'_custom_dimension']['height'] : $args['custom_size']['height'];
        }
        printf('%s', $args['before']);
        // Print image
        \Elementor\Group_Control_Image_Size::print_attachment_image_html( $settings, $args['image_size_key'], $args['name'] );
        printf('%s', $args['after']);
    }
}
// Custom Elementor Image render
add_filter('elementor/image_size/get_attachment_image_html', 'medcity_elementor_get_attachment_image_html', 10, 4);
function medcity_elementor_get_attachment_image_html( $html, $settings, $image_size_key, $image_key ) {
    // fix for default of elemenor
    $settings['max_height'] = isset($settings['max_height']) ? $settings['max_height'] : false;
    $settings['size'] = isset($settings['size']) ? $settings['size'] : '';
    $settings['custom_size'] = isset($settings['custom_size']) ? $settings['custom_size'] : '';

    
    if ( ! $image_key ) {
        $image_key = $image_size_key;
    }
    
    $image = $settings[ $image_key ];

    // Old version of image settings.
    if ( ! isset($settings[ $image_size_key . '_size' ]) || empty($settings[ $image_size_key . '_size' ]) ) {
        $settings[ $image_size_key . '_size' ] = $settings['size'];
    }
    $size = $settings[ $image_size_key . '_size' ];
    $html = '';
    // If is the new version - with image size.
    $image_sizes = get_intermediate_image_sizes();
    $image_class = isset($settings['img_class']) ? $settings['img_class'] : '';
    $image_class .= ! empty( $settings['hover_animation'] ) ? ' elementor-animation-' . $settings['hover_animation'] : '';
    $image_sizes[] = 'full';

    if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
        $image['id'] = '';
    }

    $is_static_render_mode = \Elementor\Plugin::$instance->frontend->is_static_render_mode();

    // On static mode don't use WP responsive images.
    if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) {
        $image_class .= " attachment-$size size-$size wp-image-{$image['id']}";
        $image_attr = [
            'class' => trim( $image_class )
        ];
        $image_attr['style'] = '';
        // if have max-height style
        if($settings['max_height']){
            $image_attr['style'] = 'max-height:'.$image_attr[2].'px;';
        }

        $html .= wp_get_attachment_image( $image['id'], $size, false, $image_attr );
    } else {
        $custom_dimension = isset($settings[ $image_key . '_custom_dimension' ]) ? $settings[ $image_key . '_custom_dimension' ] : $settings['custom_size'];
        $image_src = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $image['id'], $image_size_key, $settings );

        if ( ! $image_src && isset( $image['url'] ) ) {
            $image_src = $image['url'];
        }

        if ( ! empty( $image_src ) ) {
            $image_class_html = ! empty( $image_class ) ? ' class="' . esc_attr( $image_class ) . '"' : '';
            // if have max-height style
            $image_style = '';
            if($settings['max_height']){
                $image_style = ' style="max-height:'.$custom_dimension['height'].'px;"';
            }

            $html .= sprintf(
                '<img src="%1$s" title="%2$s" alt="%3$s"%4$s%5$s loading="lazy" />',
                esc_url( $image_src ),
                esc_attr( \Elementor\Control_Media::get_image_title( $image ) ),
                esc_attr( \Elementor\Control_Media::get_image_alt( $image ) ),
                $image_class_html,
                $image_style
            );
        }
    }

    /**
     * Get Attachment Image HTML
     *
     * Filters the Attachment Image HTML
     *
     * @since 2.4.0
     * @param string $html the attachment image HTML string
     * @param array  $settings       Control settings.
     * @param string $image_size_key Optional. Settings key for image size.
     *                               Default is `image`.
     * @param string $image_key      Optional. Settings key for image. Default
     *                               is null. If not defined uses image size key
     *                               as the image key.
     */
    return $html;
}
// Elementor Link/Button Settings
function medcity_elementor_link_button_settings($widget, $args = []){
    $args = wp_parse_args($args, [
        'name'      => 'link',
        'group'     => true,
        'type'      => 'button',
        'condition' => []
    ]);
    switch ($args['type']) {
        case 'link':
            $title = esc_html__('Link','medcity');
            break;
        
        case 'button':
            $title = esc_html__('Button','medcity');
            break;
    }
    if($args['group']){
        $widget->start_controls_section($args['name'].'_section',[
            'label'     => $title.' '.esc_html__('Settings', 'medcity'),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => $args['condition']
        ]);
    }
        medcity_elementor_icon_image_settings($widget,[
            // Group
            'label'     => esc_html__('Icon Settings', 'medcity'),
            'condition' => [
                $args['name'].'_text!' => ''
            ],
            'group' => false,
            //
            'name'     => $args['name'].'_icon',
            'type'     => 'icon',
            // icon
            'icon_default' => [],
            // image
            'img_size' => false
        ]);
        $widget->add_control(
            $args['name'].'_text',
            [
                'label'       => $title.' '.esc_html__( 'Text', 'medcity' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Click Here',
                'placeholder' => esc_html__( 'Enter your text', 'medcity' ),
                'separator'   => 'before'
            ]
        );
        $widget->add_control(
            $args['name'].'_type',
            [
                'label'   => $title.' '.esc_html__( ' Type', 'medcity'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'custom' => esc_html__('Custom', 'medcity'),
                    'page'   => esc_html__('Page', 'medcity'),
                ],
                'default' => 'custom',
                'condition' => [
                    $args['name'].'_text!' => ''
                ]
            ]
        );
        $widget->add_control(
            $args['name'].'_page',
            [
                'label'     => esc_html__('Select Page', 'medcity'),
                'type'      => Elementor_Theme_Core::POSTS_CONTROL,
                'post_type' => [
                    'page'
                ],
                'return_value' => 'ID',
                'multiple'     => false,
                'condition'    => [
                    $args['name'].'_text!' => '',
                    $args['name'].'_type' => 'page'
                ]
            ]
        );
        $widget->add_control(
            $args['name'].'_custom',
            [
                'label'       => esc_html__( 'Link Custom', 'medcity' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'medcity' ),
                'default'     => [
                    'url' => '#',
                ],
                'condition' => [
                    $args['name'].'_text!' => '',
                    $args['name'].'_type' => 'custom'
                ]
            ]
        );
        // Color
        medcity_elementor_colors_opts($widget,[
            'name'      => $args['name'].'_color',
            'label'     => $title.' '.esc_html__( ' Color', 'medcity' ),
            'custom'    => false,
            'condition' => [
                $args['name'].'_text!' => ''
            ]
        ]);
        medcity_elementor_colors_opts($widget,[
            'name'   => $args['name'].'_color_hover',
            'label'  => $title.' '.esc_html__( ' Color Hover', 'medcity' ),
            'custom' => false,
            'condition' => [
                $args['name'].'_text!' => ''
            ]
        ]);
        if($args['type'] == 'button'){
            medcity_elementor_colors_opts($widget,[
                'name'      => $args['name'].'_bg_color',
                'label'     => $title.' '.esc_html__( ' Background Color', 'medcity' ),
                'custom'    => false,
                'condition' => [
                    $args['name'].'_text!' => ''
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'      => $args['name'].'_bg_hover_color',
                'label'     => $title.' '.esc_html__( ' Background Hover Color', 'medcity' ),
                'custom'    => false,
                'condition' => [
                    $args['name'].'_text!' => ''
                ]
            ]);
        }
    if($args['group']){
        $widget->end_controls_section();
    }
}
function medcity_elementor_link_button_render($widget, $settings, $args = []){
    $args =  wp_parse_args($args, [
        'name'                 => 'link',
        'type'                 => 'button',
        'class'                => '',
        'btn_text_color'       => 'white',
        'btn_text_hover_color' => 'white', 
        'btn_color'            => 'accent',
        'btn_hover_color'      => 'secondary',
        'btn_prefix'           => 'cms-btn-',
        'btn_hover_prefix'     => 'cms-btn-hover-',
        // link
        'text_color'       => 'accent',
        'text_hover_color' => 'primary',
        //icon
        'icon_default'     => [],
        'icon_size'        => 12, 
        'icon_class'       => '',
        'icon_before'      => '',
        'icon_after'       => '',
        // wrap
        'before'           => '',
        'after'            => ''   
    ]);
    $link_page = $widget->get_setting($args['name'].'_page');
    switch ($settings[$args['name'].'_type']) {
        case 'page':
            $url  = !empty($link_page) ? get_permalink($link_page) : '#';
            break;
        
        default:
            $url = $widget->get_setting($args['name'].'_custom', ['url' => '#'])['url'];
            break;
    }
    $widget->add_inline_editing_attributes( $args['name'].'_text' );
    switch ($args['type']) {
        case 'button':
            $widget->add_render_attribute( $args['name'].'_text', [
                'class' => [
                    'cms-btn',
                    $args['btn_prefix'].$widget->get_setting($args['name'].'_bg_color',$args['btn_color']),
                    'text-'.$widget->get_setting($args['name'].'_color', $args['btn_text_color']),
                    $args['btn_hover_prefix'].$widget->get_setting($args['name'].'_bg_hover_color', $args['btn_hover_color']),
                    'text-hover-'.$widget->get_setting($args['name'].'_color_hover', $args['btn_text_hover_color'])
                ]
            ]);
            break;
        case 'link':
            $widget->add_render_attribute( $args['name'].'_text', [
                'class' => [
                    'cms-link',
                    'text-'.$widget->get_setting($args['name'].'_color', $args['text_color']),
                    'text-hover-'.$widget->get_setting($args['name'].'_color_hover', $args['text_hover_color'])
                ]
            ]);
            break;
    }
    $widget->add_render_attribute( $args['name'].'_text', [
        'class' => [
           $args['class']
        ],
        'href'  => $url
    ]);

    if(empty($settings[$args['name'].'_text'])) return;

    printf('%s', $args['before']);
?>
    <a <?php etc_print_html( $widget->get_render_attribute_string($args['name'].'_text' ) ); ?>><?php 
        echo esc_html( $settings[$args['name'].'_text'] ); 
        medcity_elementor_icon_image_render($widget, $settings, [
            'name'        => $args['name'].'_icon',
            'size'        => $args['icon_size'],
            'color'       => 'inherit',
            'color_hover' => 'inherit',
            // icon
            'icon_default' => $args['icon_default'],
            'icon_tag'    => 'span',
            // image
            'img_size'   => false,
            // default
            'class'      => $args['icon_class'],
            'before'     => $args['icon_before'],
            'after'      => $args['icon_after']
        ]);
    ?></a>
<?php
   printf('%s', $args['after']); 
}
/**
 * Custom Elemento Row Settings
 * 
 * Background image overlay gradient render
 * 
 * */
function medcity_elementor_background_gradient_settings($widget, $args = []){
    $args = wp_parse_args($args, [
        'name'             => 'background_gradient',
        'group'            => true,
        'title'            => esc_html__('Background Gradient', 'medcity'),
        'tab'              => Controls_Manager::TAB_CONTENT,
        'condition'        => []
    ]);
    if($args['group']){
        $widget->start_controls_section($args['name'].'_section',[
            'label'     => $args['title'],
            'tab'       => $args['tab'],
            'condition' => $args['condition']
        ]);
    }
        $widget->add_control(
            $args['name'].'_image',
            [
                'label'       => esc_html__( 'Background Image', 'medcity' ),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src()
                ]
            ]
        );
        $widget->add_control(
            $args['name'].'_style',
            [
                'label'       => esc_html__( 'Gradient Style', 'medcity' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    '' => esc_html__('Default', 'medcity'),
                    '1' => esc_html__('Style 1', 'medcity'),
                    '2' => esc_html__('Style 2', 'medcity'),
                    '3' => esc_html__('Style 3', 'medcity'),
                    '4' => esc_html__('Style 4', 'medcity'),
                    '5' => esc_html__('Style 5', 'medcity'),
                ]
            ]
        );
    if($args['group']){
        $widget->end_controls_section();
    }
}
function medcity_elementor_background_gradient_render($widget, $settings, $args = []){
    $args = wp_parse_args($args, [
        'name'    => 'background_gradient',
        'class'   => '',
        'default' => ''
    ]);
    $classes = [
        'cms-gradient-'.$widget->get_setting($args['name'].'_style', $args['default']),
        $args['class']
    ];
    return medcity_nice_class($classes);
}
function medcity_elementor_background_gradient_inner_render($widget, $settings, $args = []){
    $args =  wp_parse_args($args, [
        'name'  => 'background_gradient',
        'class' => ''
    ]);
    $classes = [
        'cms-gradient-render',
        'cms-overlay',
        'cms-bg-cover',
        $args['class']
    ];
    $widget->add_render_attribute('gradient-inner', [
        'class' => $classes,
        'style' => 'background-image:url('.$settings[$args['name'].'_image']['url'].');'
    ])
?>
    <div <?php etc_print_html($widget->get_render_attribute_string('gradient-inner')); ?>></div>
<?php
}
/**
 * Elementor SVG icon render
 * 
 * */
if(!function_exists('medcity_elementor_svg_hover_icon_render')){
    function medcity_elementor_svg_hover_icon_render($args=[]){
        $args = wp_parse_args($args, [
            'icon'   => 'up-arrow-right',
            'class'  => '',
            'color1' => 'currentColor',
            'color2' => 'currentColor',
            'echo'   => true,
            'before' => '',
            'after'  => ''   
        ]);
        ob_start();
        printf('%s', $args['before']);
        switch ($args['icon']) {
            case 'up-arrow-right':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z" fill="<?php echo esc_attr($args['color1']) ?>"/>
                </g>
                <g class="cms-hover-move-2">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z" fill="<?php echo esc_attr($args['color2']) ?>"/>
                </g>
            </svg>
        <?php
                break;
            case 'alternate':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" xmlns="http://www.w3.org/2000/svg" width="101.7" height="101.7" viewBox="0 0 101.7 101.7"><g fill="none" stroke="currentColor" stroke-width="6">
                <path d="m.7 101 100-100"></path>
                <path d="M.7 1h100" stroke-width="9">
                </path><path d="M100.7 1v100" stroke-width="9"></path>
            </g></svg>
        <?php
                break;
            case 'alternate-move':
        ?>
            <svg class="<?php echo implode(' ', ['alternate-move', $args['class']]); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" xmlns="http://www.w3.org/2000/svg" width="101.7" height="101.7" viewBox="0 0 101.7 101.7">
                <g class="cms-hover-move-1" fill="none" stroke="currentColor" stroke-width="6">
                    <path d="m.7 101 100-100"></path>
                    <path d="M.7 1h100" stroke-width="9"></path>
                    <path d="M100.7 1v100" stroke-width="9"></path>
                </g>
                <g class="cms-hover-move-2" fill="none" stroke="currentColor" stroke-width="6">
                    <path d="m.7 101 100-100"></path>
                    <path d="M.7 1h100" stroke-width="9"></path>
                    <path d="M100.7 1v100" stroke-width="9"></path>
                </g>
            </svg>
        <?php
                break;
            case 'chevron-right':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z" fill="<?php echo esc_attr($args['color1']) ?>"/>
                </g>
                <g class="cms-hover-move-2">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z" fill="<?php echo esc_attr($args['color2']) ?>"/>
                </g>
            </svg>
        <?php
                break;
            case 'arrow-up-hover-right':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z"/>
                </g>
                <g class="cms-hover-move-2">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z"/>
                </g>
            </svg>
        <?php
                break;
            case 'arrow-right-hover-up':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z"/>
                </g>
                <g class="cms-hover-move-3">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z"/>
                </g>
            </svg>
        <?php
                break;
            case 'arrow-right':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 39 32" viewBox="0 0 39 32" width="512" height="420" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                     <path d="M28.893 19.224h-28.893v-6.418h28.893v6.418zM28.893 19.224l-8.924 8.668c-0.933 0.948-0.925 2.475 0.023 3.408 0.143 0.143 0.308 0.263 0.482 0.369 0.248 0.158 0.519 0.286 0.805 0.369h2.332c0.512-0.15 0.971-0.421 1.347-0.79l12.776-13.438c0.188-0.203 0.339-0.436 0.451-0.685 0.241-0.361 0.369-0.775 0.384-1.204-0.053-1.008-0.677-1.896-1.603-2.287l-12.001-12.618c-1.219-1.174-3.085-1.347-4.492-0.414-1.151 0.67-1.542 2.144-0.873 3.288 0.105 0.173 0.226 0.339 0.369 0.482l8.924 8.442z"></path>
                </g>
                <g class="cms-hover-move-3">
                     <path d="M28.893 19.224h-28.893v-6.418h28.893v6.418zM28.893 19.224l-8.924 8.668c-0.933 0.948-0.925 2.475 0.023 3.408 0.143 0.143 0.308 0.263 0.482 0.369 0.248 0.158 0.519 0.286 0.805 0.369h2.332c0.512-0.15 0.971-0.421 1.347-0.79l12.776-13.438c0.188-0.203 0.339-0.436 0.451-0.685 0.241-0.361 0.369-0.775 0.384-1.204-0.053-1.008-0.677-1.896-1.603-2.287l-12.001-12.618c-1.219-1.174-3.085-1.347-4.492-0.414-1.151 0.67-1.542 2.144-0.873 3.288 0.105 0.173 0.226 0.339 0.369 0.482l8.924 8.442z"></path>
                </g>
            </svg>
        <?php
                break;
            default:
                // code...
                break;
        }
        printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
if(!function_exists('medcity_elementor_button_icon_render')){
    function medcity_elementor_button_icon_render($args = []){
        $args = wp_parse_args($args, [
            'icon'   => 'arrow-right',
            'class'  => 'rtl-flip',
            'color1' => 'currentColor',
            'color2' => 'currentColor',
            'before' => '<span class="btn-icon text-12 lh-1">',
            'after'  => '</span>',
            'echo'   => true
        ]);
        medcity_elementor_svg_hover_icon_render($args);
    }
}
// Button Video Lightbox
if(!function_exists('medcity_elementor_button_video_render')){
    function medcity_elementor_button_video_render($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'name'       => 'video_link',
            'layout'     => '1',
            // text
            'text'       => '',
            'text_class' => 'flex-basic',
            //icon
            'icon'       => ['library' => 'awesome', 'value' => 'fa fa-play'],
            'icon_class' => 'flex-auto',
            'icon_size'  => '20',
            'icon_color' => '',
            //class
            'class'         => '',
            'inner_class'   => '',
            'content_class' => 'd-flex gap-10 align-items-center',
            'echo'          => true,
            'attrs'         => [],
            'loop'          => false,
            'loop_key'      => '',
            // stroke 
            'stroke'      => false,
            'stroke_opts' => [
                'width'  => 232,
                'height' => 232
            ],
            // html
            'before'    => '',
            'after'     => ''
        ]);
        if(empty($settings[$args['name']])) return;

        $lightbox_id = 'cms-lightbox-'.$widget->get_setting('element_id');
        $video_url = $settings['video_link'];
        $embed_params = [
            'loop'           => '0',
            'controls'       => '1',
            'autoplay'       => '1',
            'mute'           => '1',
            'rel'            => '0',
            'modestbranding' => '0'
        ];
        $embed_options = [];
        $lightbox_options = [
            'type'         => 'video',
            'videoType'    => 'youtube',
            'url'          => \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options ),
            'modalOptions' => [
                'id'                       => $lightbox_id,
                'entranceAnimation'        => '',
                'entranceAnimation_tablet' => '',
                'entranceAnimation_mobile' => '',
                'videoAspectRatio'         => 169
            ]
        ];

        if(!$args['loop']){
            $video_key = 'video-attrs';
            if($settings['lightbox'] == 'yes'){
                $widget->add_render_attribute($video_key, [
                    'data-elementor-open-lightbox' => 'yes',
                    'data-elementor-lightbox'      => wp_json_encode( $lightbox_options )
                ]);
            }
            $widget->add_render_attribute($video_key, [
                'class' => implode(' ', array_filter([
                    'cms-btn-video', 
                    'layout-'.$args['layout'], 
                    $args['class'], 
                    'cms-transition'
                ])),
            ]);
            $widget->add_render_attribute($video_key, $args['attrs']);
        } else {
            $video_key = $widget->get_repeater_setting_key( 'video_key', 'cms_video', $args['loop_key'] );
            $widget->add_render_attribute($video_key, [
                'class' => medcity_nice_class([
                    'cms-btn-video', 
                    'layout-'.$args['layout'], 
                    $args['class'], 
                    'cms-transition'
                ]),
                'data-elementor-open-lightbox' => 'yes',
                'data-elementor-lightbox'      => wp_json_encode( $lightbox_options )
            ]);
            $widget->add_render_attribute($video_key, $args['attrs']);
        }
        // inner
        $video_inner_key = 'video-inner-key';
        $widget->add_render_attribute($video_inner_key, [
            'class' => medcity_nice_class([
                'cms-btn--video',
                'cms-hover-backdrop-psedure',
                $args['inner_class']
            ])
        ]);
        // content class
        $video_content_classe = ['cms-btn-video-content z-top', $args['content_class']];

        if($args['stroke']){
            $widget->add_render_attribute($video_key, [
                'class' => 'has-stroke'
            ]);
            //
            $widget->add_render_attribute($video_inner_key, [
                'style' => 'width:'.$args['stroke_opts']['width'].'px;height:'.$args['stroke_opts']['height'].'px;'
            ]);
            //
            $video_content_classe[] = 'absolute center';
        }
        ob_start();
            printf('%s', $args['before']);
        ?>
            <div <?php etc_print_html($widget->get_render_attribute_string($video_key)); ?>>
                <div <?php etc_print_html($widget->get_render_attribute_string($video_inner_key)); ?>>
                    <?php 
                        if($args['stroke']){
                            medcity_elementor_button_video_stroke($args['stroke_opts']);
                        }
                    ?>
                    <div class="<?php echo medcity_nice_class($video_content_classe); ?>">
                        <?php medcity_elementor_icon_render($args['icon'], [], [
                            'arial-hidden' => "true", 
                            'class'        => ['cms-play-icon cms-icon', 'cms-transition', $args['icon_class']], 
                            'icon_size'    => $args['icon_size'], 
                            'icon_color'   => $args['icon_color'] 
                        ]); ?>
                        <span class="cms-play-text empty-none <?php echo esc_attr($args['text_class']); ?>"><?php etc_print_html($args['text']) ?></span>
                    </div>
                </div>
            </div>
        <?php
            printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
// Video Render
if(!function_exists('medcity_elementor_video_render')){
    function medcity_elementor_video_render($args = []){
        $args = wp_parse_args($args, [
            'url' => '',
            'overlay' => false
        ]);
        if(empty($args['url'])) return;
        $video_url    = $args['url'];
        $video_ID     = \Elementor\Embed::get_video_properties( $video_url )['video_id'];
        $embed_params = [
            'controls'       => '0',
            'playsinline'    => '1',
            'modestbranding' => '0',
            'rel'            => '0',
            'mute'           => '1',
            'autoplay'       => '1',
            'loop'           => '1',
            'playlist'       => $video_ID
        ];
        $embed_options = [];
        $url = \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options );
        $iframe_class = 'w-100 h-100';
        if($args['overlay']){
            echo '<div class="cms-ifram-video relative" style="width: 100%;height: 100%;">';
            $iframe_class = 'cms-frame-playback';
        }
    ?>
        <iframe src="<?php etc_print_html($url); ?>" frameborder="0" allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" class="<?php echo esc_attr($iframe_class); ?>" ></iframe>
    <?php
        if($args['overlay']){
            echo '<div class="cms-ifram-video-overlay cms-overlay z-top"></div></div>';
        }
    }
}
// Zocdoc rating 
if(!function_exists('medcity_elementor_zocdoc_settings')){
    function medcity_elementor_zocdoc_settings($widget, $args = []){
        $args = wp_parse_args($args, [
            'show_rating'         => 'yes',
            'rating_rated'        => '4.9',
            'rating_text_overall' => 'Zocdoc Overall Rating',
            'rating_text'         => ', based on 7541 reviews.',
            'tabs'                => Controls_Manager::TAB_CONTENT,
            'condition'           => []   
        ]);
        $widget->start_controls_section(
            'zocdoc_section',
            [
                'label'     => esc_html__( 'Zocdoc Options', 'medcity' ),
                'tab'       => $args['tabs'],
                'condition' => $args['condition']
            ]
        );
            $widget->add_control(
                'show_rating',
                [
                    'label'        => esc_html__( 'Show Zocdoc', 'medcity' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => $args['show_rating']
                ],
            );
            $widget->add_control(
                'rating_rated',
                [
                    'label'    => esc_html__( 'Rated', 'medcity' ),
                    'type'     => Controls_Manager::TEXTAREA,
                    'default'  => $args['rating_rated'],
                    'condition'=>[
                        'show_rating' => 'yes'
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'rating_rated_color',
                'label'    => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-zodoc-rated' => 'color: {{VALUE}};',
                ]
            ]);
            $widget->add_control(
                'rating_text_overall',
                [
                    'label'    => esc_html__( 'Overall Text', 'medcity' ),
                    'type'     => Controls_Manager::TEXTAREA,
                    'default'  => $args['rating_text_overall'],
                    'condition'=>[
                        'show_rating' => 'yes'
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'rating_text_overall_color',
                'label'    => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-zodoc-overall' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'rating_text_overall!' => ''
                ]
            ]);
            $widget->add_control(
                'rating_text',
                [
                    'label'    => esc_html__( 'Text', 'medcity' ),
                    'type'     => Controls_Manager::TEXT,
                    'default'  => $args['rating_text'],
                    'condition'=>[
                        'show_rating' => 'yes'
                    ]
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'rating_text_color',
                'label'    => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-zodoc-text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'rating_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
    }
}
if(!function_exists('medcity_zocdoc_rating_render')){
    function medcity_zocdoc_rating_render($widget, $settings, $args = []){
        $args = wp_parse_args($args, [
            'wrap_class'   => '',
            'before'       => '',
            'after'        => ''   
        ]);
        $show_rating               = $widget->get_setting('show_rating', 'yes');
        $rating_rated              = $widget->get_setting('rating_rated', '4.9');
        $rating_rated_color        = $widget->get_setting('rating_rated_color', 'secondary');
        $rating_text_overall       = $widget->get_setting('rating_text_overall');
        $rating_text_overall_color = $widget->get_setting('rating_text_overall_color','secondary');
        $rating_text               = $widget->get_setting('rating_text');
        $rating_text_color         = $widget->get_setting('rating_text_color');
        if($show_rating !== 'yes') return;
        printf('%s', $args['before']);
        ?>
            <div class="<?php echo trim(implode(' ', ['cms-zodoc-rating d-flex gap-25', $args['wrap_class']]));?>">
                <div class="cms-zodoc-rated flex-auto cms-heading text-38 text-<?php echo esc_attr($rating_rated_color);?> lh-1"><?php 
                    echo esc_html($rating_rated);
                ?></div>
                <div class="cms-zodoc-text flex-basic mt-n5">
                    <span class="cms-zocdoc-overall text-14 font-700 text-<?php echo esc_attr($rating_text_overall_color);?> bdr-b2"><?php echo esc_html($rating_text_overall);?>
                    </span>
                    <span class="cms-zocdoc-text text-13 text-<?php echo esc_attr($rating_text_color);?>">
                        <?php echo ' '.esc_html($rating_text);?>
                    </span>
                </div>
            </div>
        <?php
        printf('%s', $args['after']);
    }
}
// Carousel Setting
if(!function_exists('medcity_elementor_carousel_settings')){
    function medcity_elementor_carousel_settings($widget, $args = []){
        $args = wp_parse_args($args, [
            'label'     => esc_html__('Carousel Settings', 'medcity'),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [],
            'hover_icon'=> false,
            'arrows'           => 'yes',
            'dots'             => 'yes',
            'dots_type'        => 'circle',  
            'slides_to_show'   => '',
            'slides_to_scroll' => '',
        ]);
        $widget->start_controls_section(
            'carousel_section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );
            $widget->add_control(
                'item_shadow',
                [
                    'label'     => esc_html__('Item Shadow?', 'medcity'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => [
                        'yes' => esc_html__('Yes', 'medcity'),
                        'no'   => esc_html__('No', 'medcity')
                    ],
                    'default' => 'no',
                    'dynamic' => [
                        'active' => true
                    ],
                    'style_transfer' => true,
                    'prefix_class' => 'cms-carousel-item-shadow-',

                ]
            );
            $widget->add_control(
                'content_width',
                [
                    'label'     => esc_html__('Content Width', 'medcity'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => [
                        ''             => esc_html__('Default', 'medcity'),
                        'start'        => esc_html__('Full to Start', 'medcity'),
                        'end'          => esc_html__('Full to End', 'medcity'),
                        'start-medium' => esc_html__('Full to Start (Medium [usedxxx])', 'medcity'),
                        'end-medium'   => esc_html__('Full to End (Medium [usedxxx])', 'medcity'),
                        'start-large'  => esc_html__('Full to Start (Large)', 'medcity'),
                        'end-large'    => esc_html__('Full to End (Large)', 'medcity'),
                        'start-mlarge' => esc_html__('Full to Start (Medium Large)', 'medcity'),
                        'end-mlarge'   => esc_html__('Full to End (Medium Large)', 'medcity'),
                        'start-xlarge' => esc_html__('Full to Start (Extra Large)', 'medcity'),
                        'end-xlarge'   => esc_html__('Full to End (Extra Large)', 'medcity'),
                        'both'         => esc_html__('Full to Both', 'medcity')
                    ],
                    'prefix_class' => 'cms-swiper-full-',
                    'separator'    => 'after'
                ]
            );
            
            $slides_to_show = range(1, 10);
            $slides_to_show = array_combine($slides_to_show, $slides_to_show);
            $widget->add_responsive_control(
                'slides_to_show',
                [
                    'label'   => esc_html__('Slides to Show', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                            '' => esc_html__('Default', 'medcity'),
                            //'auto' => esc_html__('Auto', 'medcity'),
                        ] + $slides_to_show,
                    'frontend_available' => true,
                    'default' => $args['slides_to_show']
                ]
            );

            $widget->add_responsive_control(
                'slides_to_scroll',
                [
                    'label'       => esc_html__('Slides to Scroll', 'medcity'),
                    'type'        => Controls_Manager::SELECT,
                    'description' => esc_html__('Set how many slides are scrolled per swipe.', 'medcity'),
                    'options'     => [
                            '' => esc_html__('Default', 'medcity'),
                        ] + $slides_to_show,
                    'condition' => [
                        'slides_to_show!' => ['auto','1'],
                    ],
                    'frontend_available' => true,
                    'default' => $args['slides_to_scroll']
                ]
            );
            $widget->add_responsive_control(
                'space_between',
                [
                    'label' => esc_html__('Space Between', 'medcity'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 40,
                    ],
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'drag-cursor',
                [
                    'label'              => esc_html__('Drag Cursor', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'frontend_available' => false,
                    'return_value'       => 'drag-cursor'
                ]
            );
            $widget->add_control(
                'lazyload',
                [
                    'label'              => esc_html__('Lazyload', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'autoplay',
                [
                    'label'              => esc_html__('Autoplay', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'pause_on_hover',
                [
                    'label'              => esc_html__('Pause on Hover', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'pause_on_interaction',
                [
                    'label'              => esc_html__('Pause on Interaction', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'autoplay_speed',
                [
                    'label'     => esc_html__('Autoplay Speed', 'medcity'),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 5000,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'infinite',
                [
                    'label'              => esc_html__('Infinite Loop', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'effect',
                [
                    'label'   => esc_html__('Effect', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'slide',
                    'options' => [
                        'slide' => esc_html__('Slide', 'medcity'),
                        'fade'  => esc_html__('Fade', 'medcity'),
                    ],
                    'condition' => [
                        'slides_to_show' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'speed',
                [
                    'label'              => esc_html__('Animation Speed', 'medcity'),
                    'type'               => Controls_Manager::NUMBER,
                    'default'            => 500,
                    'render_type'        => 'none',
                    'frontend_available' => true
                ]
            );
            $widget->add_control(
                'arrows',
                [
                    'label'              => esc_html__('Show Arrows', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'label_block'        => true,
                    'default'            => $args['arrows']
                ]
            );
            $widget->add_control(
                'arrows_type',
                [
                    'label'   => esc_html__('Arrows Type', 'medcity'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''       => esc_html__('Default','medcity'),
                        'button' => esc_html__('Button','medcity'),
                        'icon'   => esc_html__('Icon','medcity')
                    ],
                    'label_block' => false,
                    'condition'   => [
                        'arrows' => 'yes'
                    ]
                ]
            );
            
            $widget->add_control(
                'arrow_prev_icon',
                [
                    'label'            => esc_html__('Previous Arrow Icon', 'medcity'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'skin'             => 'inline',
                    'label_block'      => false,
                    'skin_settings'    => [
                        'inline' => [
                            'none' => [
                                'label' => 'Default',
                                'icon'  => 'eicon-chevron-left',
                            ],
                            'icon' => [
                                'icon' => 'eicon-chevron-left',
                            ]
                        ]
                    ],
                    'condition' => [
                        'arrows' => 'yes'
                    ],
                ]
            );
            if($args['hover_icon']){
                $widget->add_control(
                    'arrow_prev_icon_hover',
                    [
                        'label'            => esc_html__('Previous Arrow Icon Hover', 'medcity'),
                        'type'             => Controls_Manager::ICONS,
                        'skin'             => 'inline',
                        'label_block'      => false,
                        'skin_settings'    => [
                            'inline' => [
                                'none' => [
                                    'label' => 'Default',
                                    'icon'  => 'eicon-chevron-left',
                                ],
                                'icon' => [
                                    'icon' => 'eicon-chevron-left',
                                ]
                            ]
                        ],
                        'condition' => [
                            'arrows' => 'yes'
                        ]
                    ]
                );
            }
            $widget->add_control(
                'arrow_next_icon',
                [
                    'label'            => esc_html__('Next Arrow Icon', 'medcity'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'skin'             => 'inline',
                    'label_block'      => false,
                    'skin_settings'    => [
                        'inline' => [
                            'none' => [
                                'label' => 'Default',
                                'icon'  => 'eicon-chevron-right',
                            ],
                            'icon' => [
                                'icon' => 'eicon-chevron-right',
                            ],
                        ],
                    ],
                    'condition' => [
                        'arrows' => 'yes'
                    ],
                ]
            );
            if($args['hover_icon']){
                $widget->add_control(
                    'arrow_next_icon_hover',
                    [
                        'label'            => esc_html__('Next Arrow Icon Hover', 'medcity'),
                        'type'             => Controls_Manager::ICONS,
                        'skin'             => 'inline',
                        'label_block'      => false,
                        'skin_settings'    => [
                            'inline' => [
                                'none' => [
                                    'label' => 'Default',
                                    'icon'  => 'eicon-chevron-right',
                                ],
                                'icon' => [
                                    'icon' => 'eicon-chevron-right',
                                ],
                            ],
                        ],
                        'condition' => [
                            'arrows' => 'yes'
                        ]
                    ]
                );
            }

            $widget->add_control(
                'arrows_size',
                [
                    'label' => esc_html__('Arrow Size', 'medcity'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 20,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-carousel-button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'arrows' => 'yes',
                    ],
                ]
            );
            $widget->add_control(
                'arrows_icon_size',
                [
                    'label' => esc_html__('Arrow Icon Size', 'medcity'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 60,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-carousel-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .cms-carousel-button-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'arrows' => 'yes',
                    ],
                ]
            );
            medcity_elementor_colors_opts($widget,[
                'name'     => 'arrows_color',
                'label'     => esc_html__( 'Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-carousel-button,' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-carousel-button svg' => 'fill: {{VALUE}};'
                ],
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]);
            medcity_elementor_colors_opts($widget,[
                'name'     => 'arrows_hover_color',
                'label'     => esc_html__( 'Hover/Active Color', 'medcity' ),
                'selector' => [
                    '{{WRAPPER}} .cms-carousel-button:hover,' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-carousel-button:hover svg' => 'fill: {{VALUE}};'
                ],
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]);
            medcity_add_hidden_device_controls($widget, [
                'prefix'    => 'arrows_',
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]);
            // Dots
            $widget->add_control(
                'dots',
                [
                    'label'              => esc_html__('Show Dots', 'medcity'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'label_block'        => true,
                    'default'            => $args['dots']
                ]
            );
            $widget->add_control(
                'dots_type',
                [
                    'label'              => esc_html__('Dots Type', 'medcity'),
                    'type'               => Controls_Manager::SELECT,
                    'options'            => [
                        'progressbar'      => esc_html__('Progressbar','medcity'),
                        'bullets'          => esc_html__('Bullets','medcity'),
                        'circle'           => esc_html__('Dots Circle','medcity'),
                        'number'           => esc_html__('Number','medcity'),
                        'fraction'         => esc_html__('Fraction (Current/Total)','medcity'),
                        'current-of-total' => esc_html__('Current of Total', 'medcity'),
                        'custom'           => esc_html__('Custom','medcity'),
                    ],
                    'default'            => $args['dots_type'],
                    'frontend_available' => true,
                    'condition' => [
                        'dots' => 'yes'
                    ]
                ]
            );
            $widget->add_control( // This option need for make custom html dots
                'number_of_dots',
                [
                    'label'              => esc_html__('Number of Dots', 'medcity'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 1,
                    'max'                => 6,
                    'default'            => 1,
                    'frontend_available' => true,
                    'condition'          => [
                        'dots' => 'yes',
                        'dots_type' => 'custom'
                    ],
                ]
            );
            $widget->add_control(
                'dots_size',
                [
                    'label' => esc_html__('Size', 'medcity'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 5,
                            'max' => 10,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'dots'       => 'yes',
                        'dots_type!' => 'custom'
                    ],
                ]
            );
            $widget->add_control(
                'dots_inactive_color',
                [
                    'label' => esc_html__('Color', 'medcity'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // The opacity property will override the default inactive dot color which is opacity 0.2.
                        '{{WRAPPER}} .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' => 'background: {{VALUE}}; opacity: 1',
                    ],
                    'condition' => [
                        'dots'       => 'yes',
                        'dots_type!' => 'custom'
                    ],
                ]
            );

            $widget->add_control(
                'dots_color',
                [
                    'label' => esc_html__('Active Color', 'medcity'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
                    ],
                    'condition' => [
                        'dots'       => 'yes',
                        'dots_type!' => 'custom'
                    ],
                ]
            );
            medcity_add_hidden_device_controls($widget, [
                'prefix'    => 'dots_',
                'condition' => [
                    'dots'       => 'yes',
                    'dots_type!' => 'custom'
                ]
            ]);
        $widget->end_controls_section();
    }
}
if(!function_exists('medcity_elementor_swipper_wrapper_classes_render')){
    function medcity_elementor_swipper_wrapper_classes_render($widget, $settings){
        $widget->add_render_attribute('swiper-wrapper', [
            'class' => [
                'swiper-wrapper',
                $settings['drag-cursor']
            ]
        ]);
        etc_print_html($widget->get_render_attribute_string('swiper-wrapper'));
    }
}
// Grid Columns
if(!function_exists('medcity_elementor_grid_columns_settings')){
    function medcity_elementor_grid_columns_settings($widget, $args=[]){
        $args = wp_parse_args($args, [
            'name'      => 'col',
            'label'     => esc_html__('Grid Settings', 'medcity'),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'separator' => 'after',
            'condition' => []
        ]);
        $widget->start_controls_section(
            $args['name'].'_grid_section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );

            $widget->add_responsive_control(
                $args['name'],
                [
                    'label'        => esc_html__('Columns', 'medcity'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => '',
                    'default_args' => [
                        'tablet' => '',
                        'mobile' => ''
                    ],
                    'options' => [
                        ''     => esc_html__('Default', 'medcity'),
                        '1'    => '1',
                        '2'    => '2',
                        '3'    => '3',
                        '4'    => '4',
                        '5'    => '5',
                        '6'    => '6',
                        'auto' => esc_html__('Auto','medcity'),
                    ],
                    'separator' => $args['separator']
                ]
            );
            $widget->add_control(
                'col_separator',
                [
                    'label'        => esc_html__('Add separator?','medcity'),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes'
                ]
            );
        $widget->end_controls_section();
    }
}
if(!function_exists('medcity_elementor_get_grid_columns')){
    function medcity_elementor_get_grid_columns($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'name'         => 'col',
            'prefix_class' => 'flex-col-',
            'default'      => '',
            'widescreen'   => '', 
            'desktop'      => '',
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => '',
            'smobile'      => '1'
        ]); 
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $align_class = [];
        if(!empty($settings[$args['name']]) || !empty($args['default']) ){
            $class = (isset($settings[$args['name']]) && !empty($settings[$args['name']])) ? $settings[$args['name']] : $args['default'];
            $align_class[] = $args['prefix_class'].$class;
        }
        // Align Class
        foreach ( $active_devices as $key => $breakpoint_key ) {
            $breakpoint_key_class =  str_replace('_','-',$breakpoint_key);
            $setting_breakpoint_key = (isset($settings[$args['name'].'_' . $breakpoint_key]) && !empty($settings[$args['name'].'_' . $breakpoint_key])) ? $settings[$args['name'].'_' . $breakpoint_key] : $args[$breakpoint_key];

            if($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key) ){
                $align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$setting_breakpoint_key;
            }
        }
        $align_class[] = 'flex-col-smobile-'.$args['smobile'];
        $align_class[] = 'flex-col-separator-'.$widget->get_setting('col_separator', 'no');
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));
        
        // return
        return medcity_nice_class($align_class);
    }
}