<?php
$info = $widget->get_setting('information', '');
$image = isset($settings['image']) ? $settings['image'] : '';
$img = etc_get_image_by_size( array(
    'attach_id'  => $image['id'],
    'thumb_size' => '160x216',
    'class'      => '',
));
$thumbnail = $img['thumbnail'];
?>
<div class="cms-doctor-contact">
    <div class="top-info">
        <div class="doctor-avatar">
            <?php echo wp_kses_post($thumbnail); ?>
        </div>
        <div class="doctor-name">
            <h4><?php echo esc_html($settings['name']); ?></h4>
            <span class="doctor-position"><?php echo esc_html($settings['position']); ?></span>
        </div>
    </div>
    <?php if(isset($info) && !empty($info) && count($info)): ?>
        <div class="bottom-info">
            <?php foreach ($info as $key => $value):
                ?>
                <div class="info-item">
                    <span class="info-label"><?php echo esc_attr($value['label']); ?></span>
                    <span class="info-text"><?php echo esc_attr($value['text']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
