<?php
$list_title = $widget->get_setting('list_title', '');
$price = $widget->get_setting('price', '');
?>
<?php if(isset($price) && !empty($price) && count($price)): ?>
    <div class="cms-price-list">
        <?php
        if (!empty($list_title)){
            ?><h3 class="list-title"><?php echo esc_html($list_title);?></h3><?php
        }
        ?>
        <?php foreach ($price as $key => $value):
            ?>
            <div class="price-item">
                <div class="item-inner">
                    <span class="item-text">
                        <?php echo esc_html($value['item_text']); ?>
                    </span>
                    <span class="item-price">
                        <?php echo esc_html($value['item_price']); ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
