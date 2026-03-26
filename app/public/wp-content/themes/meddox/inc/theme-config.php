<?php
// make some configs
if(!function_exists('meddox_configs')){
    function meddox_configs($value){
         
        $configs = [
            'theme_colors' => [
                'primary'   => [
                    'title' => esc_html__('Primary', 'meddox').' ('.meddox()->get_opt('primary_color', '#28B6F6').')', 
                    'value' => meddox()->get_opt('primary_color', '#28B6F6')
                ],
                'secondary'   => [
                    'title' => esc_html__('Secondary', 'meddox').' ('.meddox()->get_opt('secondary_color', '#053485').')', 
                    'value' => meddox()->get_opt('secondary_color', '#053485')
                ],
                'regular'   => [
                    'title' => esc_html__('Regular', 'meddox').' ('.meddox()->get_opt('regular_color', '#647589').')', 
                    'value' => meddox()->get_opt('regular_color', '#647589')
                ],
                'fourth'   => [
                    'title' => esc_html__('Fourth', 'meddox').' ('.meddox()->get_opt('fourth_color', '#0857DE').')', 
                    'value' => meddox()->get_opt('fourth_color', '#0857DE')
                ],
                'fifth'   => [
                    'title' => esc_html__('Fifth', 'meddox').' ('.meddox()->get_opt('fifth_color', '#DDD').')', 
                    'value' => meddox()->get_opt('fifth_color', '#DDD')
                ],
                
            ],
            'link' => [
                'color' => meddox()->get_opt('link_color', ['regular' => '#28B6F6'])['regular'],
                'color-hover'   => meddox()->get_opt('link_color', ['hover' => '#053485'])['hover'],
                'color-active'  => meddox()->get_opt('link_color', ['active' => '#053485'])['active'],
            ],
            'gradient' => [
                'color-from' => meddox()->get_page_opt('gradient_color', ['from' => '#8d4cfa'])['from'],
                'color-to' => meddox()->get_page_opt('gradient_color', ['to' => '#5f6ffb'])['to'],
            ],
               
        ];
        return $configs[$value];
    }
}
if(!function_exists('meddox_inline_styles')) {
    function meddox_inline_styles() {  
        
        $theme_colors      = meddox_configs('theme_colors');
        $link_color        = meddox_configs('link');
        $gradient_color        = meddox_configs('gradient');
         
        ob_start();
        echo ':root{';
            
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color: %2$s;', str_replace('#', '',$color),  $value['value']);
            }
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color-rgb: %2$s;', str_replace('#', '',$color),  meddox_hex_rgb($value['value']));
            }
            foreach ($link_color as $color => $value) {
                printf('--link-%1$s: %2$s;', $color, $value);
            } 
            foreach ($gradient_color as $color => $value) {
                printf('--gradient-%1$s: %2$s;', $color, $value);
            } 
        echo '}';

        return ob_get_clean();
         
    }
}
 