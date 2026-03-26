<?php
?>
<div class="cms-video-player layout2">
    <div class="content-inner">
        <div class="inner">
            <?php
            if (!empty($settings['video_link'])){
                ?>
                <a class="video-play-button" href="<?php echo esc_url($settings['video_link']);?>">
                    <i class="zmdi zmdi-play"></i>
                </a>
                <?php
            }
            if (!empty($settings['description'])){
                ?>
                <h3 class="description font-smooth"><?php etc_print_html(nl2br($settings['description'])); ?></h3>
                <?php
            }
            ?>
        </div>
    </div>
</div>