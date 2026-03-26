<?php
$wg_sub_title = $widget->get_setting('wg_subtitle', '');
$wg_title = $widget->get_setting('wg_title', '');
$tabs = $widget->get_setting('tabs', '');
$tabs_title = [];
$tabs_description = [];
$tabs_content = [];
foreach ($tabs as $key => $tab){
    $title_key = $widget->get_repeater_setting_key( 'tab_title', 'tabs', $key );
    $content_key = $widget->get_repeater_setting_key( 'tab_content', 'tabs', $key );

    $tabs_title[$title_key] = $tab['tab_title'];
    $tabs_description[$title_key] = $tab['tab_description'];
    $tabs_content[$content_key] = '';
    if($tab['content_type'] == 'template'){
        if(!empty($tab['tab_content_template'])){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $tab['tab_content_template'] );
            $tabs_content[$content_key] = $content;
        }
    }
    elseif($tab['content_type'] == 'text_editor'){
        $tabs_content[$content_key] = $tab['tab_content'];
    }

    $widget->add_render_attribute( $title_key, [
        'class' => [ 'action-item' ],
        'data-target' => '#' . $tab['_id'],
    ] );

    $widget->add_inline_editing_attributes( $title_key, 'basic' );
    $widget->add_render_attribute( $content_key, [
        'class' => [ 'content-item' ],
        'id' => $tab['_id'],
    ] );
    if($tab['content_type'] == 'text_editor'){
        $widget->add_inline_editing_attributes( $content_key, 'advanced' );
    }

    if($key == 0){
        $widget->add_render_attribute( $content_key, 'style', 'display:block;');
        $widget->add_render_attribute( $title_key, 'class', 'active');
    }
}

?>
<div class="cms-work-process">
    <div class="process-content">
        <?php foreach ($tabs_content as $content_key => $tab_content): ?>
            <div <?php etc_print_html($widget->get_render_attribute_string( $content_key )); ?>><?php etc_print_html($tab_content); ?></div>
        <?php endforeach; ?>
    </div>
    <div class="process-action">
        <?php
        if (!empty($wg_sub_title) || empty($wg_title)){
            ?>
            <div class="widget-title-wrap">
                <?php
                if (!empty($wg_sub_title)){
                    ?>
                    <div class="wg-subtitle"><?php echo esc_html($wg_sub_title);?></div>
                    <?php
                }
                if (!empty($wg_title)){
                    ?>
                    <h2 class="wg-title"><?php etc_print_html($wg_title); ?></h2>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="action-item-wrap">
            <?php foreach ($tabs_title as $title_key => $tab_title): ?>
                <div <?php etc_print_html($widget->get_render_attribute_string( $title_key )); ?>>
                    <h3 class="item-title">
                        <?php echo etc_print_html($tab_title); ?>
                    </h3>
                    <div class="item-description">
                        <?php echo etc_print_html($tabs_description[$title_key]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>