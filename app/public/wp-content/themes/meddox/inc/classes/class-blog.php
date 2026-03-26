<?php
if (!class_exists('meddox_Blog')) {

    class meddox_Blog
    {

        public function get_archive_meta() {
            $archive_comments = meddox()->get_theme_opt( 'archive_comments', true );
            $archive_date = meddox()->get_theme_opt( 'archive_date', true );
            if($archive_comments || $archive_category || $archive_date) : ?>
                <ul class="pxl-item--meta">
                    <?php if($archive_date) : ?>
                        <li class="pxl-item--date"><?php echo get_the_date(); ?></li>
                    <?php endif; ?>
                </ul>
            <?php endif; 
        }
        public function get_archive_author() {
            $archive_author = meddox()->get_theme_opt( 'archive_author', true );  
            if($archive_author) : ?>
                <?php if($archive_author): ?>
                    <div class="pxl-item--author">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 35 ); ?>
                        <?php the_author_posts_link(); ?>
                    </div>
                <?php endif; ?>
            <?php endif; 
        }

        public function get_excerpt(){
            $archive_excerpt_length = meddox()->get_theme_opt('archive_excerpt_length', '50');
            $meddox_the_excerpt = get_the_excerpt();
            if(!empty($meddox_the_excerpt)) {
                echo wp_trim_words( $meddox_the_excerpt, 20, $more = null );
            } else {
                echo wp_kses_post($this->get_excerpt_more( $archive_excerpt_length ));
            }
        }

        public function get_excerpt_more( $post = null ) {
            $archive_excerpt_length = meddox()->get_theme_opt('archive_excerpt_length', '50');
            $post = get_post( $post );

            if ( empty( $post ) || 0 >= $archive_excerpt_length ) {
                return '';
            }

            if ( post_password_required( $post ) ) {
                return esc_html__( 'Post password required.', 'meddox' );
            }

            $content = apply_filters( 'the_content', strip_shortcodes( $post->post_content ) );
            $content = str_replace( ']]>', ']]&gt;', $content );

            $excerpt_more = apply_filters( 'meddox_excerpt_more', '&hellip;' );
            $excerpt      = wp_trim_words( $content, $archive_excerpt_length, $excerpt_more );

            return $excerpt;
        }

        public function get_post_metas(){
            $post_category_on = meddox()->get_theme_opt( 'post_category_on', true );
            $post_author = meddox()->get_theme_opt( 'post_author', true );
            $post_comments = meddox()->get_theme_opt( 'post_comments', true );
            $post_date = meddox()->get_theme_opt( 'post_date', true );
            if($post_author || $post_date || $post_category_on) : ?>
                <div class="pxl-item--meta">
                    <?php if($post_date) : ?>
                        <span class="pxl-item--date">
                            <?php echo get_the_date(); ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; 
        }

        public function meddox_set_post_views( $postID ) {
            $countKey = 'post_views_count';
            $count    = get_post_meta( $postID, $countKey, true );
            if ( $count == '' ) {
                $count = 0;
                delete_post_meta( $postID, $countKey );
                add_post_meta( $postID, $countKey, '0' );
            } else {
                $count ++;
                update_post_meta( $postID, $countKey, $count );
            }
        }

        public function get_tagged_in(){
            $tags_list = get_the_tag_list( '<label class="label">'.esc_attr__('Popular Tags:', 'meddox'). '</label>', ' ' );
            if ( $tags_list )
            {
                echo '<div class="pxl--tags">';
                printf('%2$s', '', $tags_list);
                echo '</div>';
            }
        }

        public function get_socials_share() { 
            $img_url = '';
            if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), false)) {
                $img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), false);
            }
            $social_facebook = meddox()->get_theme_opt( 'social_facebook', true );
            $social_twitter = meddox()->get_theme_opt( 'social_twitter', true );
            $social_instagram = meddox()->get_theme_opt( 'social_instagram', true );
            $social_dribbble = meddox()->get_theme_opt( 'social_dribbble', true );  
            $social_behance = meddox()->get_theme_opt( 'social_behance', true );
            $social_linkedin = meddox()->get_theme_opt( 'social_linkedin', true );
            ?>
            <div class="pxl--social">
                <label><?php echo esc_html__('Share News', 'meddox'); ?></label>
                <div class="wrap-social">
                    <?php if($social_facebook) : ?>
                        <a class="fb-social" title="<?php echo esc_attr__('Facebook', 'meddox'); ?>" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="caseicon-facebook"></i></a>
                    <?php endif; ?>
                    <?php if($social_twitter) : ?>
                        <a class="tw-social" title="<?php echo esc_attr__('Twitter', 'meddox'); ?>" target="_blank" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>"><i class="caseicon-twitter"></i></a>
                    <?php endif; ?>
                    <?php if($social_instagram) : ?>
                        <a class="in-social" title="<?php echo esc_attr__('Instagram', 'meddox'); ?>" target="_blank" href="http://www.instagram.com/?url=<?php the_permalink(); ?>"><i class="caseicon-instagram"></i></a>
                    <?php endif; ?>
                    <?php if($social_linkedin) : ?>
                        <a class="be-social" title="<?php echo esc_attr__('Link', 'meddox'); ?>" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>"><i class="caseicon-linkedin"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
        function meddox_get_user_social() {

            $user_facebook = get_user_meta(get_the_author_meta( 'ID' ), 'user_facebook', true);
            $user_twitter = get_user_meta(get_the_author_meta( 'ID' ), 'user_twitter', true);
            $user_linkedin = get_user_meta(get_the_author_meta( 'ID' ), 'user_linkedin', true);
            $user_skype = get_user_meta(get_the_author_meta( 'ID' ), 'user_skype', true);
            $user_youtube = get_user_meta(get_the_author_meta( 'ID' ), 'user_youtube', true);
            $user_vimeo = get_user_meta(get_the_author_meta( 'ID' ), 'user_vimeo', true);
            $user_tumblr = get_user_meta(get_the_author_meta( 'ID' ), 'user_tumblr', true);
            $user_pinterest = get_user_meta(get_the_author_meta( 'ID' ), 'user_pinterest', true);
            $user_instagram = get_user_meta(get_the_author_meta( 'ID' ), 'user_instagram', true);
            $user_yelp = get_user_meta(get_the_author_meta( 'ID' ), 'user_yelp', true);

            ?>
            <ul class="user-social">
                <?php if(!empty($user_facebook)) { ?>
                    <li><a href="<?php echo esc_url($user_facebook); ?>"><i class="Caseicon-facebook"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_twitter)) { ?>
                    <li><a href="<?php echo esc_url($user_twitter); ?>"><i class="Caseicon-twitter"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_linkedin)) { ?>
                    <li><a href="<?php echo esc_url($user_linkedin); ?>"><i class="Caseicon-linkedin"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_instagram)) { ?>
                    <li><a href="<?php echo esc_url($user_instagram); ?>"><i class="Caseicon-instagram"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_skype)) { ?>
                    <li><a href="<?php echo esc_url($user_skype); ?>"><i class="Caseicon-skype"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_pinterest)) { ?>
                    <li><a href="<?php echo esc_url($user_pinterest); ?>"><i class="Caseicon-pinterest"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_vimeo)) { ?>
                    <li><a href="<?php echo esc_url($user_vimeo); ?>"><i class="Caseicon-vimeo"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_youtube)) { ?>
                    <li><a href="<?php echo esc_url($user_youtube); ?>"><i class="Caseicon-youtube"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_yelp)) { ?>
                    <li><a href="<?php echo esc_url($user_yelp); ?>"><i class="Caseicon-yelp"></i></a></li>
                <?php } ?>
                <?php if(!empty($user_tumblr)) { ?>
                    <li><a href="<?php echo esc_url($user_tumblr); ?>"><i class="Caseicon-tumblr"></i></a></li>
                <?php } ?>

                </ul> <?php
            }
            public function get_socials_share_portfolio() { 
                $img_url = '';
                if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), false)) {
                    $img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), false);
                }
                ?>
                <div class="pxl--social">
                    <a class="fb-social" title="<?php echo esc_attr__('Facebook', 'meddox'); ?>" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="caseicon-facebook"></i></a>
                    <a class="tw-social" title="<?php echo esc_attr__('Twitter', 'meddox'); ?>" target="_blank" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>%20"><i class="caseicon-twitter"></i></a>
                    <a class="pin-social" title="<?php echo esc_attr__('Pinterest', 'meddox'); ?>" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_url($img_url[0]); ?>&description=<?php the_title(); ?>%20"><i class="caseicon-pinterest"></i></a>
                    <a class="lin-social" title="<?php echo esc_attr__('LinkedIn', 'meddox'); ?>" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>%20"><i class="caseicon-linkedin"></i></a>
                </div>
                <?php
            }

            public function get_post_nav() {
                global $post;
                $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
                $next     = get_adjacent_post( false, '', false );

                if ( ! $next && ! $previous )
                    return;
                ?>
                <?php
                $next_post = get_next_post();
                $previous_post = get_previous_post();

                if( !empty($next_post) || !empty($previous_post) ) { 
                    ?>
                    <div class="pxl-post--navigation">
                        <h2 class="title-nav-post">Related Post</h2>
                        <div class="pxl--items">
                            <div class="pxl--item pxl--item-prev">
                                <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') { 
                                    $prev_img_id = get_post_thumbnail_id($previous_post->ID);
                                    $prev_img_url = wp_get_attachment_image_src($prev_img_id, 'meddox-thumb-post');
                                    ?>
                                    <div class="pxl--holder">
                                        <?php if(!empty($prev_img_id)) : ?>
                                            <div class="pxl--img">
                                                <a  href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><img src="<?php echo wp_kses_post($prev_img_url[0]); ?>" /></a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="pxl--meta">

                                            <ul class="pxl-item--meta">
                                                <li class="pxl-item--date"><i class="caseicon-calendar-alt"></i><?php echo get_the_date(); ?></li>
                                                <li class="item-comment">
                                                    <i class="caseicon-comment"></i>
                                                    <a href="#comments"><?php echo comments_number(esc_html__('No Comments', 'meddox'),esc_html__('Comment (1) ', 'meddox'),esc_html__('Comments (%)', 'meddox'), $previous_post->ID); ?></a>
                                                </li>
                                            </ul>
                                            <div class="title-post-nav"><a  href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo get_the_title( $previous_post->ID ); ?></a></div>
                                            <a class="pxl--readmore-nav" href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo esc_html__('READ MORE', 'meddox'); ?><i class="caseicon-long-arrow-right-two"></i></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="pxl--item pxl--item-next">
                                <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') {
                                    $next_img_id = get_post_thumbnail_id($next_post->ID);
                                    $next_img_url = wp_get_attachment_image_src($next_img_id, 'meddox-thumb-post');
                                    ?>

                                    <div class="pxl--holder">
                                        <?php if(!empty($next_img_id)) : ?>
                                            <div class="pxl--img">
                                                <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><img src="<?php echo wp_kses_post($next_img_url[0]); ?>" /></a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="pxl--meta">

                                            <ul class="pxl-item--meta">
                                                <li class="pxl-item--date"><i class="caseicon-calendar-alt"></i><?php echo get_the_date(); ?></li>
                                                <li class="item-comment">
                                                    <i class="caseicon-comment"></i>
                                                    <a href="#comments"><?php echo comments_number(esc_html__('No Comments', 'meddox'),esc_html__('Comment (1) ', 'meddox'),esc_html__('Comments (%)', 'meddox'), $next_post->ID); ?></a>
                                                </li>
                                            </ul>
                                            <div class="title-post-nav">
                                                <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo get_the_title( $next_post->ID ); ?></a>
                                            </div>

                                            <a class="pxl--readmore-nav" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo esc_html__('READ MORE', 'meddox'); ?><i class="caseicon-long-arrow-right-two"></i></a>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>
                        </div><!-- .nav-links -->
                    </div>
                <?php }
            }
            function meddox_related_post() {
                $post_related = meddox()->get_theme_opt( 'post_related', false );
                if($post_related) {
                    global $post; 
                    $current_id = $post->ID;
                    $posttags = get_the_category($post->ID);
                    if (empty($posttags)) return;

                    $tags = array();

                    foreach ($posttags as $tag) {

                        $tags[] = $tag->term_id;
                    }
                    $post_number = '2';
                    $query_similar = new WP_Query(array('posts_per_page' => $post_number, 'post_type' => 'post', 'post_status' => 'publish', 'category__in' => $tags));
                    if (count($query_similar->posts) > 1) {
                        ?>
                        <div class="pxl-related-post">
                            <h4 class="widget-title"><?php echo esc_html__('Related Posts', 'meddox'); ?></h4>
                            <div class="pxl-related-post-inner row" data-start-page="1" data-max-pages="2" data-total="2" data-perpage="2">
                                <?php foreach ($query_similar->posts as $post):
                                    $author = get_user_by('id', $post->post_author);
                                    $thumbnail_url = '';
                                    if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) :
                                        $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'meddox-related-post', false);
                                endif;
                                if ($post->ID !== $current_id) : ?>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="grid-item-inner pxl--holder">
                                            <?php if (has_post_thumbnail()) { ?>
                                                <div class="item-featured">
                                                    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($thumbnail_url[0]); ?>" alt="post-image" /></a>
                                                </div>
                                            <?php } ?>
                                            <div class="item-holder pxl--meta">
                                                <ul class="entry-meta pxl-item--meta">
                                                    <li class="pxl-item--date"><i class="caseicon-calendar-alt"></i><?php echo get_the_date(); ?></li>
                                                    <li class="item-comment">
                                                        <i class="caseicon-comment"></i>
                                                        <a href="#comments"><?php echo comments_number(esc_html__('No Comments', 'meddox'),esc_html__('Comment (1) ', 'meddox'),esc_html__('Comments (%)', 'meddox'), $post->ID); ?></a>
                                                    </li>
                                                </ul>
                                                <h3 class="item-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h3>
                                                <a class="pxl--readmore-related" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_html__('Read More', 'meddox'); ?><i class="caseicon-long-arrow-right-three"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                <?php }
            }

            wp_reset_postdata();
        }

    }
}
