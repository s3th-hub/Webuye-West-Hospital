<?php
// make some configs
if(!function_exists('medcity_configs')){
    function medcity_configs($value){
        $configs = [
            // color
            'theme_colors' => [
                'primary'   => [
                    'opt_name' => 'primary_color',
                    'value' => medcity_get_opt('primary_color', '#21cdc0')
                ],
                'secondary' => [
                    'opt_name' => 'secondary_color',
                    'value' => medcity_get_opt('secondary_color', '#0e204d')
                ],
                'tertiary' => [
                    'opt_name' => 'tertiary_color',
                    'value' => medcity_get_opt('tertiary_color', '#435ba1')
                ],
            ],
        ];
        return $configs[$value];
    }
}

if(!function_exists('medcity_hex2rgb')){
    function medcity_hex2rgb($colour) {
        if ( $colour[0] == '#' ) {
            $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
            return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        $rgb_string = $r.','.$g.','.$b;
        return $rgb_string;
    }
}

if(!function_exists('medcity_inline_styles')){
    function medcity_inline_styles() {
        ob_start();
        // CSS Variable
        $theme_colors       = medcity_configs('theme_colors');
        $page_custom_colors = medcity_get_page_opt('custom_color', '0');
        $page_heading = medcity_get_page_opt('font_heading');

        if ($page_custom_colors == '1' ){
            foreach ($theme_colors as $color => $value) {
                if ( !empty(medcity_get_page_opt($value['opt_name'])) ){
                    $theme_colors[$color]['value'] = medcity_get_page_opt($value['opt_name']);
                }
            }
        }
        echo ':root{';
            foreach ($theme_colors as $color => $value) {
                printf('--color-%1$s: %2$s;', $color, $value['value']);
            }
            foreach ($theme_colors as $color => $value) {
                printf('--rgb-color-%1$s: %2$s;', $color, medcity_hex2rgb($value['value']));
            }
            if(isset($page_heading['font-family']) && $page_heading['font-family'] != ''){
                printf('--cms-heading-font:%1$s;', $page_heading['font-family'] );
            }
        echo '}';
        return ob_get_clean();
    }
}