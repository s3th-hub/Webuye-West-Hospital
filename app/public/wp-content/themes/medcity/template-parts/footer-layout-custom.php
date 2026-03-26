<?php
$footer_layout_custom = medcity_get_opt('footer_layout_custom');
$custom_footer = medcity_get_page_opt('custom_footer', 'false');
$footer_layout_page = medcity_get_page_opt('footer_layout');
$footer_layout_custom_page = medcity_get_page_opt('footer_layout_custom');
if( $custom_footer && $footer_layout_page == 'custom' && !empty($footer_layout_custom_page) ) {
    $footer_layout_custom = $footer_layout_custom_page;
}
if(!empty($footer_layout_custom)){
    ?>
    <footer id="colophon" class="site-footer-custom">
        <?php /*?>
        <div class="footer-custom-inner">
            <div class="container">
                <div class="row">
                    <div class="col-12"> 
        <?php */?>
                        <?php
                        $cms_post = get_post($footer_layout_custom);
                        if (!is_wp_error($cms_post) && $cms_post->ID == $footer_layout_custom && class_exists('Elementor_Theme_Core') && function_exists('etc_print_html')){
                            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $footer_layout_custom );
                            etc_print_html($content);
                        }
                        ?>
                    <?php /* ?></div>
                </div>
            </div>
        </div> 
        <?php */?>
    </footer>
    <?php
}else{
    ?>
    <footer id="colophon" class="site-footer-default">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="default-copyright">
                        <?php
                        echo esc_html('Copyright &copy;'.' '.esc_html(date("Y"))).esc_html('&nbsp;').'<a target="_blank" href="https://themeforest.net/user/7oroof/portfolio">7oroof</a>'.esc_html('&nbsp;All Rights Reserved');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php
}
?>