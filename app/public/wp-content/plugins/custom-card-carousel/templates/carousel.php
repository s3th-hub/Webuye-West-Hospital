<?php
/**
 * Front-end carousel template.
 * $slides  — array of slide data
 * $atts    — shortcode / widget settings
 */
if ( ! defined( 'ABSPATH' ) ) exit;

static $inst = 0; $inst++;
$uid = 'ccc-swiper-' . $inst;

$autoplay       = $atts['autoplay']       ?? 'true';
$delay          = $atts['delay']          ?? 4000;
$loop           = $atts['loop']           ?? 'true';
$speed          = $atts['speed']          ?? 550;
$desktop_cards  = $atts['desktop_cards']  ?? 3;
$tablet_cards   = $atts['tablet_cards']   ?? 2;
$mobile_cards   = $atts['mobile_cards']   ?? 1;

/* Inline CSS variables — only output properties that were explicitly set */
$css_vars = $atts['css_vars'] ?? [];
$inline_style = '';
if ( ! empty( $css_vars ) ) {
    $inline_style = ' style="' . esc_attr( implode( '; ', $css_vars ) ) . '"';
}

$arr_r = '<svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M9 5l7 7-7 7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arr_l = '<svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M15 19l-7-7 7-7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arrow = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>
<div class="ccc-wrap"<?php echo $inline_style; ?>>
  <div class="ccc-slider-outer">

    <div class="ccc-prev" aria-label="Previous" role="button" tabindex="0"><?php echo $arr_l; ?></div>
    <div class="ccc-next" aria-label="Next"     role="button" tabindex="0"><?php echo $arr_r; ?></div>

    <div class="swiper ccc-swiper" id="<?php echo esc_attr( $uid ); ?>"
         data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
         data-delay="<?php echo esc_attr( $delay ); ?>"
         data-loop="<?php echo esc_attr( $loop ); ?>"
         data-speed="<?php echo esc_attr( $speed ); ?>"
         data-desktop-cards="<?php echo esc_attr( $desktop_cards ); ?>"
         data-tablet-cards="<?php echo esc_attr( $tablet_cards ); ?>"
         data-mobile-cards="<?php echo esc_attr( $mobile_cards ); ?>">

      <div class="swiper-wrapper">
        <?php foreach ( $slides as $s ) :
          if ( ! is_array( $s ) ) continue;
          $img   = esc_url(  $s['image'] ?? '' );
          $badge = esc_html( $s['badge'] ?? '' );
          $title = esc_html( $s['title'] ?? '' );
          $desc  = esc_html( $s['desc']  ?? ( $s['description'] ?? '' ) );
          $btn   = esc_html( $s['btn']   ?? ( $s['btn_text']    ?? 'Read More' ) );
          $url   = esc_url(  $s['url']   ?? ( $s['btn_url']     ?? '#' ) );
          if ( empty( $title ) && empty( $img ) ) continue; // skip blank slides
        ?>
        <div class="swiper-slide">
          <div class="ccc-card">
            <div class="ccc-img-wrap">
              <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" loading="lazy" />
              <?php if ( $badge ) : ?><span class="ccc-badge"><?php echo $badge; ?></span><?php endif; ?>
            </div>
            <div class="ccc-card-body">
              <h3 class="ccc-title"><?php echo $title; ?></h3>
              <p class="ccc-desc"><?php echo $desc; ?></p>
              <a class="ccc-btn" href="<?php echo $url; ?>">
                <?php echo $btn; ?>
                <?php echo $arrow; ?>
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="swiper-pagination ccc-dots"></div>
    </div>
  </div>
</div>
