<?php
if(isset($settings['content']) && !empty($settings['content']) && count($settings['content'])): ?>
    <ul class="pxl-opening-hours pxl-opening-hours-l1">
        <?php
            foreach ($settings['content'] as $key => $content):
                ?>
                <li>                        
                    <span><?php echo pxl_print_html($content['day_of_week']); ?></span>
                    <span class="wrap-time">
                        <span><?php echo pxl_print_html($content['opening']); ?> - </span>
                        <span> <?php echo pxl_print_html($content['closing']); ?></span>
                    </span>
                </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
