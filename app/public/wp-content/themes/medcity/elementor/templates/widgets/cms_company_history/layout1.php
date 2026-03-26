<?php
if(isset($settings['timelines']) && !empty($settings['timelines']) && count($settings['timelines'])): ?>
    <div class="cms-company-history">
        <div class="history-content-items">
            <?php foreach ($settings['timelines'] as $timeline): ?>
                <?php
                if(!empty($timeline['timeline_year'])){
                    ?>
                    <div class="content-item">
                        <div class="left-content">
                            <span class="dot"></span>
                            <div class="timeline-year"><?php echo esc_html($timeline['timeline_year'])?></div>
                        </div>
                        <div  class="right-content"">
                            <h3 class="timeline-title"><?php echo esc_html($timeline['timeline_title'])?></h3>
                            <p class="timeline-text"><?php echo esc_html($timeline['timeline_content'])?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
