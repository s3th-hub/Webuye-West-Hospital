/**
 * Custom Card Carousel Pro — carousel.js
 * Reads all settings from data-* attributes on .ccc-swiper.
 */
(function () {
  'use strict';

  function boot() {
    if (typeof Swiper === 'undefined') { setTimeout(boot, 80); return; }

    document.querySelectorAll('.ccc-swiper').forEach(function (el) {
      var wrap   = el.closest('.ccc-wrap');
      var uid    = el.id;
      var prevEl = wrap && wrap.querySelector('.ccc-prev');
      var nextEl = wrap && wrap.querySelector('.ccc-next');
      var pagEl  = wrap && wrap.querySelector('.ccc-dots');

      var d = el.dataset;
      var autoplay  = d.autoplay  !== 'false';
      var delay     = parseInt(d.delay,  10) || 4000;
      var loop      = d.loop      !== 'false';
      var speed     = parseInt(d.speed,  10) || 550;

      /* Cards per view — Elementor passes desktop/tablet/mobile separately */
      var desktopCards = parseFloat(d.desktopCards)  || 3;
      var tabletCards  = parseFloat(d.tabletCards)   || 2;
      var mobileCards  = parseFloat(d.mobileCards)   || 1;

      new Swiper('#' + uid, {
        slidesPerView: mobileCards,
        spaceBetween:  16,
        loop:          loop,
        speed:         speed,
        grabCursor:    true,
        watchSlidesProgress: true,

        breakpoints: {
          640:  { slidesPerView: tabletCards,  spaceBetween: 20 },
          1025: { slidesPerView: desktopCards, spaceBetween: 24 },
        },

        navigation: { nextEl: nextEl, prevEl: prevEl },

        pagination: pagEl ? { el: pagEl, clickable: true, dynamicBullets: true } : false,

        autoplay: autoplay ? { delay: delay, disableOnInteraction: false, pauseOnMouseEnter: true } : false,

        a11y: { prevSlideMessage: 'Previous slide', nextSlideMessage: 'Next slide' },
      });
    });
  }

  document.readyState === 'loading'
    ? document.addEventListener('DOMContentLoaded', boot)
    : boot();
})();
