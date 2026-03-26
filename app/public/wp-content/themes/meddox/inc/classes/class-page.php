<?php

if (!class_exists('meddox_Page')) {

    class meddox_Page
    {
        public function get_site_loader(){

            $site_loader = meddox()->get_theme_opt( 'site_loader', false );
            $loader_style = meddox()->get_theme_opt( 'loader_style', 'style-digital' );

            if($site_loader) { ?>
                <div id="pxl-loadding" class="pxl-loader <?php echo esc_attr($loader_style); ?>">
                    <div class="pxl-loader-effect">
                        <?php switch ($loader_style) {
                            case 'style-business': ?>
                            <?php break;

                            case 'style-software': ?>
                            <div class = "pxl-bounce-1"></div>
                            <div class = "pxl-bounce-2"></div>
                            <?php break;
                            case 'style-kindergarten': ?>
                            <div id="animationWindow">
                                
                            </div>
                            <?php break;

                            case 'style-default': ?>
                            <div class="loading-default" style="background-image: url(<?php echo esc_url(get_template_directory_uri().'/assets/img/loading.gif'); ?>)">
                                
                            </div>
                            <?php break;
                            
                            default: ?>
                            <div class = "pxl-circle-1"></div>
                            <div class = "pxl-circle-2"></div>
                            <?php break;
                        } ?>
                    </div>
                    
                </div>
                <script>
                    var animData = {
                        wrapper: document.querySelector('#animationWindow'),
                        animType: 'svg',
                        loop: true,
                        prerender: true,
                        autoplay: true,
                        path: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/LEGO_loader.json'
                    };
                </script>
            <?php }
        }
        public function get_link_pages() {
            wp_link_pages( array(
                'before'      => '<div class="page-links">',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) ); 
        }

        public function get_page_title(){
            $pt_mode = meddox()->get_opt('pt_mode');
            if( $pt_mode == 'none' ) return;
            $ptitle_layout = (int)meddox()->get_opt('ptitle_layout');
            $titles = $this->get_title();
            if ($pt_mode == 'bd' && $ptitle_layout > 0 && class_exists('Pxltheme_Core') && is_callable( 'Elementor\Plugin::instance' )) {
                ?>
                <div id="pxl-page-title-elementor">
                    <?php echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $ptitle_layout);?>
                </div>
                <?php 
            } else {
                $ptitle_breadcrumb_on = meddox()->get_opt( 'ptitle_breadcrumb_on', '1' ); 
                wp_enqueue_script('stellar-parallax'); ?>
                <div id="pxl-page-title-default" class="pxl--parallax" data-stellar-background-ratio="0.5" style="background-image: url('<?php echo esc_url(get_template_directory_uri().'/assets/img/page-title.jpg');?> ')">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="pxl-page-title"><?php echo meddox_html($titles['title']) ?></h1>
                                <?php if($ptitle_breadcrumb_on == '1') : ?>
                                    <?php $this->get_breadcrumb(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } 
        } 

      public function get_title() {
            $title = '';
            $single_post_title_layout = meddox()->get_theme_opt('single_post_title_layout','0');
            $post_custom_title  = meddox()->get_theme_opt('post_custom_title',esc_html__('Blog details', 'meddox'));
            // Default titles
            if ( ! is_archive() ) {
                // Posts page view
                if ( is_home() ) {
                    // Only available if posts page is set.
                    if ( ! is_front_page() && $page_for_posts = get_option( 'page_for_posts' ) ) {
                        $title = get_post_meta( $page_for_posts, 'custom_title', true );
                        if ( empty( $title ) ) {
                            $title = get_the_title( $page_for_posts );
                        }
                    }
                    if ( is_front_page() ) {
                        $title = esc_html__( 'Blog', 'meddox' );
                    }
                } // Single page view
                elseif ( is_page() ) {
                    $title = get_post_meta( get_the_ID(), 'custom_title', true );
                    if ( ! $title ) {
                        $title = get_the_title();
                    }
                } elseif ( is_404() ) {
                    $title = esc_html__( '404', 'meddox' );
                } elseif ( is_search() ) {
                    $title = esc_html__( 'Search results', 'meddox' );
                } else {
                    $title = get_post_meta( get_the_ID(), 'custom_title', true );
                    if( is_singular('post') && $single_post_title_layout == '1'){
                        $title = $post_custom_title; 
                    } elseif ( ! $title ) {
                        $title = get_the_title();
                    } else {
                        $title = $title; //get_the_title();
                    }
                }
            } elseif ( is_author() ) {  
                $title     = get_the_author();
            } else {
                $custom_title = meddox()->get_opt('custom_title');
                $_title = get_the_archive_title();
                if( class_exists( 'WooCommerce' ) && is_shop() ) {
                    $_title = get_post_meta( wc_get_page_id('shop'), 'custom_title', true );
                    if(!$_title) {
                        $_title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
                    }
                }
                $title = !empty($custom_title) ? $custom_title : $_title;
            }
            //* Custom main and sub title
            $main_title = meddox()->get_page_opt('custom_main_title');
            if (!empty($main_title)){
                $title = $main_title;
            }
            $sub_title = meddox()->get_opt('custom_sub_title');
            $page_sub_title = meddox()->get_page_opt('custom_sub_title');
            if (!empty($page_sub_title)){
                $sub_title = $page_sub_title;
            }
            return array(
                'title' => $title,
                'sub_title' => $sub_title
            );
        }

        public function get_breadcrumb(){

            if ( ! class_exists( 'CASE_Breadcrumb' ) )
            {
                return;
            }

            $breadcrumb = new CASE_Breadcrumb();
            $entries = $breadcrumb->get_entries();

            if ( empty( $entries ) )
            {
                return;
            }

            ob_start();

            foreach ( $entries as $entry )
            {
                $entry = wp_parse_args( $entry, array(
                    'label' => '',
                    'url'   => ''
                ) );

                if ( empty( $entry['label'] ) )
                {
                    continue;
                }

                echo '<li>';

                if ( ! empty( $entry['url'] ) )
                {
                    printf(
                        '<a class="breadcrumb-entry" href="%1$s">%2$s</a>',
                        esc_url( $entry['url'] ),
                        esc_attr( $entry['label'] )
                    );
                }
                else
                {
                    printf( '<span class="breadcrumb-entry" >%s</span>', esc_html( $entry['label'] ) );
                }

                echo '</li>';
            }

            $output = ob_get_clean();

            if ( $output )
            {
                printf( '<ul class="pxl-breadcrumb">%s</ul>', wp_kses_post($output));
            }
        }

        public function get_pagination( $query = null, $ajax = false ){

            if($ajax){
                add_filter('paginate_links', 'meddox_ajax_paginate_links');
            }

            $gallery = array();

            if ( empty( $query ) )
            {
                $query = $GLOBALS['wp_query'];
            }

            if ( empty( $query->max_num_pages ) || ! is_numeric( $query->max_num_pages ) || $query->max_num_pages < 2 )
            {
                return;
            }

            $paged = $query->get( 'paged', '' );

            if ( ! $paged && is_front_page() && ! is_home() )
            {
                $paged = $query->get( 'page', '' );
            }

            $paged = $paged ? intval( $paged ) : 1;

            $pagenum_link = html_entity_decode( get_pagenum_link() );
            $query_args   = array();
            $url_parts    = explode( '?', $pagenum_link );

            if ( isset( $url_parts[1] ) )
            {
                wp_parse_str( $url_parts[1], $query_args );
            }

            $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
            $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
            $paginate_links_args = array(
                'base'     => $pagenum_link,
                'total'    => $query->max_num_pages,
                'current'  => $paged,
                'mid_size' => 1,
                'add_args' => array_map( 'urlencode', $query_args ),
                'prev_text' => '',
                'next_text' => '',
            );
            if($ajax){
                $paginate_links_args['format'] = '?page=%#%';
            }
            $links = paginate_links( $paginate_links_args );
            if ( $links ):
                ?>
                <nav class="pxl-pagination-wrap <?php echo esc_attr($ajax?'ajax':''); ?>">
                    <div class="pxl-pagination-links">
                        <?php
                        printf($links);
                        ?>
                    </div>
                </nav>
                <?php
            endif;
        }
    }
}

