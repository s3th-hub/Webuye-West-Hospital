<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">
  <h1>🎠 Card Carousel — Manage Slides</h1>
  <p style="color:#666;margin-bottom:20px;">Add, edit or remove slides. All styling is done inside the <strong>Elementor Style panel</strong> when you place the Card Carousel widget on a page.</p>

  <form method="post">
    <?php wp_nonce_field('ccc_save','ccc_nonce'); ?>
    <div id="ccc-slides">
      <?php foreach($slides as $i=>$s):
        if(!is_array($s)) continue;
        $f_image = esc_url(  $s['image'] ?? '' );
        $f_badge = esc_attr( $s['badge'] ?? '' );
        $f_title = esc_attr( $s['title'] ?? '' );
        $f_desc  = esc_textarea( $s['desc'] ?? ( $s['description'] ?? '' ) );
        $f_btn   = esc_attr( $s['btn']   ?? ( $s['btn_text']    ?? 'Read More' ) );
        $f_url   = esc_url(  $s['url']   ?? ( $s['btn_url']     ?? '#' ) );
      ?>
      <div class="ccc-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:6px;padding:18px 20px;margin-bottom:14px;position:relative;">
        <strong style="font-size:14px;">Slide <?php echo $i+1; ?></strong>
        <button type="button" class="ccc-del button button-small" style="position:absolute;top:14px;right:14px;">✕ Remove</button>
        <table class="form-table" style="margin:8px 0 0;">
          <tr><th style="width:130px;">Image URL</th><td><input type="url" name="ccc_slide_image[]" value="<?php echo $f_image; ?>" style="width:100%;max-width:500px;" /></td></tr>
          <tr><th>Badge</th><td><input type="text" name="ccc_slide_badge[]" value="<?php echo $f_badge; ?>" style="width:180px;" placeholder="e.g. Pharmacy" /></td></tr>
          <tr><th>Title</th><td><input type="text" name="ccc_slide_title[]" value="<?php echo $f_title; ?>" style="width:100%;max-width:500px;" /></td></tr>
          <tr><th>Description</th><td><textarea name="ccc_slide_desc[]" rows="3" style="width:100%;max-width:500px;"><?php echo $f_desc; ?></textarea></td></tr>
          <tr><th>Button Text</th><td><input type="text" name="ccc_slide_btn[]" value="<?php echo $f_btn; ?>" style="width:180px;" /></td></tr>
          <tr><th>Button URL</th><td><input type="url" name="ccc_slide_url[]" value="<?php echo $f_url; ?>" style="width:100%;max-width:500px;" /></td></tr>
        </table>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="button" id="ccc-add" class="button button-secondary" style="margin-bottom:20px;">+ Add Slide</button><br>
    <?php submit_button('Save Slides'); ?>
  </form>
</div>
<template id="ccc-tpl">
  <div class="ccc-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:6px;padding:18px 20px;margin-bottom:14px;position:relative;">
    <strong style="font-size:14px;">New Slide</strong>
    <button type="button" class="ccc-del button button-small" style="position:absolute;top:14px;right:14px;">✕ Remove</button>
    <table class="form-table" style="margin:8px 0 0;">
      <tr><th style="width:130px;">Image URL</th><td><input type="url" name="ccc_slide_image[]" style="width:100%;max-width:500px;" /></td></tr>
      <tr><th>Badge</th><td><input type="text" name="ccc_slide_badge[]" style="width:180px;" /></td></tr>
      <tr><th>Title</th><td><input type="text" name="ccc_slide_title[]" style="width:100%;max-width:500px;" /></td></tr>
      <tr><th>Description</th><td><textarea name="ccc_slide_desc[]" rows="3" style="width:100%;max-width:500px;"></textarea></td></tr>
      <tr><th>Button Text</th><td><input type="text" name="ccc_slide_btn[]" value="Read More" style="width:180px;" /></td></tr>
      <tr><th>Button URL</th><td><input type="url" name="ccc_slide_url[]" style="width:100%;max-width:500px;" /></td></tr>
    </table>
  </div>
</template>
<script>
document.getElementById('ccc-add').onclick = function(){
  document.getElementById('ccc-slides').appendChild(document.getElementById('ccc-tpl').content.cloneNode(true));
};
document.getElementById('ccc-slides').addEventListener('click',function(e){
  if(e.target.classList.contains('ccc-del')) e.target.closest('.ccc-row').remove();
});
</script>
