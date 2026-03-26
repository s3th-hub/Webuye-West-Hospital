;(function ($) {

    "use strict";
    
    var pxl_scroll_top;
    var pxl_window_height;
    var pxl_window_width;
    var pxl_scroll_status = '';
    var pxl_last_scroll_top = 0;
    $(window).on('load', function () {
        $(".pxl-loader").fadeOut("slow");
        pxl_window_width = $(window).width();
        meddox_header_sticky();
        meddox_scroll_to_top();
        meddox_footer_fixed();
        meddox_quantity_icon();
    });
    $( document ).ready( function() {
        /* For Shop */
        meddox_shop_view_layout();
    });
    $(window).on('scroll', function () {
        pxl_scroll_top = $(window).scrollTop();
        pxl_window_height = $(window).height();
        pxl_window_width = $(window).width();
        if (pxl_scroll_top < pxl_last_scroll_top) {
            pxl_scroll_status = 'up';
        } else {
            pxl_scroll_status = 'down';
        }
        pxl_last_scroll_top = pxl_scroll_top;
        meddox_header_sticky();
        meddox_scroll_to_top();
        meddox_footer_fixed();
    });
    setTimeout(function(){
        $('.md-align-center').parents('.rs-parallax-wrap').addClass('pxl-group-center');
    }, 300);

    $(document).ready(function () {
        /* Menu Responsive Dropdown */
        var $meddox_menu = $('.pxl-header-elementor-main');
        $meddox_menu.find('.pxl-menu-primary li').each(function () {
            var $meddox_submenu = $(this).find('> ul.sub-menu');
            if ($meddox_submenu.length == 1) {
                $(this).hover(function () {
                    if ($meddox_submenu.offset().left + $meddox_submenu.width() > $(window).width()) {
                        $meddox_submenu.addClass('pxl-sub-reverse');
                    } else if ($meddox_submenu.offset().left < 0) {
                        $meddox_submenu.addClass('pxl-sub-reverse');
                    }
                }, function () {
                    $meddox_submenu.removeClass('pxl-sub-reverse');
                });
            }
        });

        /* Start Menu Mobile */
        $('.pxl-header-menu li.menu-item-has-children').append('<span class="pxl-menu-toggle"></span>');
        $('.pxl-menu-toggle').on('click', function () {
            if( $(this).hasClass('active')){
                $(this).closest('ul').find('.pxl-menu-toggle.active').toggleClass('active');
                $(this).closest('ul').find('.sub-menu.active').toggleClass('active').slideToggle();    
            }else{
                $(this).closest('ul').find('.pxl-menu-toggle.active').toggleClass('active');
                $(this).closest('ul').find('.sub-menu.active').toggleClass('active').slideToggle();
                $(this).toggleClass('active');
                $(this).parent().find('> .sub-menu').toggleClass('active');
                $(this).parent().find('> .sub-menu').slideToggle();
            }      
        });
        
        $("#pxl-nav-mobile").on('click', function () {
            $(this).toggleClass('active');
            $('.pxl-header-menu').toggleClass('active');
        });

        $(".pxl-menu-close, .pxl-header-menu-backdrop").on('click', function () {
            $(this).parents('.pxl-header-main').find('.pxl-header-menu').removeClass('active');
            $('#pxl-nav-mobile').removeClass('active');
        });
        /* End Menu Mobile */

        /* Elementor Header */
        $('.pxl-type-header-clip > .elementor-container').append('<div class="pxl-header-shape"><span></span></div>');

        /* Scroll To Top */
        $('.pxl-scroll-top').on('click', function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

        /* Animate Time Delay */
        $('.pxl-grid-masonry').each(function () {
            var eltime = 100;
            var elt_inner = $(this).children().length;
            var _elt = elt_inner - 1;
            $(this).find('> .pxl-grid-item > .wow').each(function (index, obj) {
                $(this).css('animation-delay', eltime + 'ms');
                if (_elt === index) {
                    eltime = 100;
                    _elt = _elt + elt_inner;
                } else {
                    eltime = eltime + 60;
                }
            });
        });

        $('.pxl-item--text').each(function () {
            var pxl_time = 0;
            var pxl_item_inner = $(this).children().length;
            var _elt = pxl_item_inner - 1;
            $(this).find('> .pxl-text--slide > .wow').each(function (index, obj) {
                $(this).css('transition-delay', pxl_time + 'ms');
                if (_elt === index) {
                    pxl_time = 0;
                    _elt = _elt + pxl_item_inner;
                } else {
                    pxl_time = pxl_time + 80;
                }
            });
        });

        /* Lightbox Popup */
        $('.btn-video, .pxl-video-popup').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });

        $('.images-light-box').each(function () {
            $(this).magnificPopup({
                delegate: 'a.light-box',
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade',
            });
        });
        /* Comment Reply */


        /* Parallax */
        if($('#pxl-page-title-default').hasClass('pxl--parallax')) {
            $(this).stellar();
        }

        /* Animate Time */
        $('.btn-nina').each(function () {
            var eltime = 0.045;
            var elt_inner = $(this).children().length;
            var _elt = elt_inner - 1;
            $(this).find('> .pxl--btn-text > span').each(function (index, obj) {
                $(this).css('transition-delay', eltime + 's');
                eltime = eltime + 0.045;
            });
        });

        /* Search Popup */
        $(".pxl-search-popup-button").on('click', function () {
            $('body').addClass('body-overflow');
            $('#pxl-search-popup').addClass('active');
            $('#pxl-search-popup .search-field').focus();
        });
        $("#pxl-search-popup .pxl-item--overlay, #pxl-search-popup .pxl-item--close").on('click', function () {
            $('body').removeClass('body-overflow');
            $('#pxl-search-popup').removeClass('active');
        });
        /* Hidden Sidebar */
        $(".pxl-hidden-button").on('click', function () {
            $('body').addClass('body-overflow');
            $('pxl-close').css("display","block");
            $('#pxl-hidden-sidebar').addClass('active');
        });
        $("#pxl-hidden-sidebar .pxl-item--overlay, #pxl-hidden-sidebar .pxl-item--close").on('click', function () {
            $('body').removeClass('body-overflow');
            $('pxl-close').css("display","none");
            $('#pxl-hidden-sidebar').removeClass('active');
        });
        /* Hidden Icon Cart */
        $(".pxl-cart-sidebar-button").on('click', function () {
            $('#pxl-side-cart').addClass('open');
        });
        $(".pxl-close").on('click', function () {
            $('#pxl-side-cart').removeClass('open');
        });

        /* Hover Active Item */
        $('.pxl--widget-hover').each(function () {
            $(this).hover(function () {
                $(this).parents('.elementor-row').find('.pxl--widget-hover').removeClass('pxl--item-active');
                $(this).parents('.elementor-container').find('.pxl--widget-hover').removeClass('pxl--item-active');
                $(this).addClass('pxl--item-active');
            });
        });

        /* Hover Button */
        $('.btn-plus-text').hover(function () {
            $(this).find('span').toggle(300);
        });

        /* Nav Logo */
        $(".pxl-nav-button").on('click', function () {
            $(this).toggleClass('active');
            $(this).parent().find('.pxl-nav-wrap').toggle(400);
        });

        /* Button Mask */
        $('.pxl-btn-effect4').append('<span class="pxl-btn-mask"></span>');

        /* Start Icon Bounce */
        var boxEls = $('.el-bounce, .pxl-image-effect1');
        $.each(boxEls, function(boxIndex, boxEl) {
            loopToggleClass(boxEl, 'bounce-active');
        });

        function loopToggleClass(el, toggleClass) {
            el = $(el);
            let counter = 0;
            if (el.hasClass(toggleClass)) {
                waitFor(function () {
                    counter++;
                    return counter == 2;
                }, function () {
                    counter = 0;
                    el.removeClass(toggleClass);
                    loopToggleClass(el, toggleClass);
                }, 'Deactivate', 1000);
            } else {
                waitFor(function () {
                    counter++;
                    return counter == 3;
                }, function () {
                    counter = 0;
                    el.addClass(toggleClass);
                    loopToggleClass(el, toggleClass);
                }, 'Activate', 1000);
            }
        }

        function meddox_panel_anchor_toggle(){
            'use strict';
            $(document).on('click','.pxl-anchor.side-panel',function(e){
                e.preventDefault();
                e.stopPropagation();
                var target = $(this).attr('data-target');
                $(this).toggleClass('cliked');
                $(target).toggleClass('open');
                $('body').toggleClass('side-panel-open');
                setTimeout(function(){
                    $(document).find('.pxl-search-form input[name="s"]').focus();
                    $(document).find('.search-form input[name="s"]').focus();
                },1000);

            });

        //* Menu Dropdown
            $('.pxl-menu-primary li').each(function () {
                var $submenu = $(this).find('> ul.sub-menu');
                if ($submenu.length == 1) {
                    $(this).hover(function () {
                        if ($submenu.offset().left + $submenu.width() > $(window).width()) {
                            $submenu.addClass('back');
                        } else if ($submenu.offset().left < 0) {
                            $submenu.addClass('back');
                        }
                    }, function () {
                        $submenu.removeClass('back');
                    });
                }
            });
        }

        function meddox_document_click(){
            $(document).on('click',function (e) {
                var target = $(e.target);
                var check = '.btn-nav-mobile';

                if (!(target.is(check)) && target.closest('.pxl-hidden-template').length <= 0 && $('body').hasClass('side-panel-open')) { 
                    $('.btn-nav-mobile').removeClass('cliked');

                    $('.pxl-hidden-template').removeClass('open');
                    $('body').removeClass('side-panel-open');
                }
            });
            $(document).on('click','.pxl-close',function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).closest('.pxl-hidden-template').toggleClass('open');
                $('.btn-nav-mobile').removeClass('cliked');

                $('body').toggleClass('side-panel-open');
            });


        }

        function waitFor(condition, callback, message, time) {
            if (message == null || message == '' || typeof message == 'undefined') {
                message = 'Timeout';
            }
            if (time == null || time == '' || typeof time == 'undefined') {
                time = 100;
            }
            var cond = condition();
            if (cond) {
                callback();
            } else {
                setTimeout(function() {
                    console.log(message);
                    waitFor(condition, callback, message, time);
                }, time);
            }
        }
    /* End Icon Bounce */
    /* Slider - Group align center */
        setTimeout(function(){
            $('.md-align-center').parents('.rs-parallax-wrap').addClass('pxl-group-center');
        }, 300);

    /* Image Effect */
        if($('.pxl-image-tilt').length){
            $('.pxl-image-tilt').each(function () {
                var pxl_maxtilt = $(this).data('maxtilt'),
                pxl_speedtilt = $(this).data('speedtilt');
                $(this).tilt({
                    maxTilt: pxl_maxtilt,
                    speed: pxl_speedtilt,
                });
            });
        }

    /* Team */
        $('.pxl-item--button').on('click', function () {
            $(this).toggleClass('active');
            $(this).parent().toggleClass('active');
        });

    /* Image Box */
        $( ".pxl-image-box2 .pxl-item--inner" ).hover(
          function() {
            $( this ).find('.pxl-item--description').slideToggle(220);
        }, function() {
            $( this ).find('.pxl-item--description').slideToggle(220);
        }
        );

    /* Select Theme Style */
        $('.wpcf7-select').each(function(){
            var $this = $(this), numberOfOptions = $(this).children('option').length;

            $this.addClass('pxl-select-hidden'); 
            $this.wrap('<div class="pxl-select"></div>');
            $this.after('<div class="pxl-select-higthlight"></div>');

            var $styledSelect = $this.next('div.pxl-select-higthlight');
            $styledSelect.text($this.children('option').eq(0).text());

            var $list = $('<ul />', {
                'class': 'pxl-select-options'
            }).insertAfter($styledSelect);

            for (var i = 0; i < numberOfOptions; i++) {
                $('<li />', {
                    text: $this.children('option').eq(i).text(),
                    rel: $this.children('option').eq(i).val()
                }).appendTo($list);
            }

            var $listItems = $list.children('li');

            $styledSelect.on('click', function(e) {
                e.stopPropagation();
                $('div.pxl-select-higthlight.active').not(this).each(function(){
                    $(this).removeClass('active').next('ul.pxl-select-options').addClass('pxl-select-lists-hide');
                });
                $(this).toggleClass('active');
            });

            $listItems.on('click', function(e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));
            });

            $(document).on('click', function() {
                $styledSelect.removeClass('active');
            });

        });

    });
    //shop display
function meddox_shop_view_layout(){

    $(document).on('click','.pxl-view-layout .view-icon a', function(e){
        e.preventDefault();
        if(!$(this).parent('li').hasClass('active')){
            $('.pxl-view-layout .view-icon').removeClass('active');
            $(this).parent('li').addClass('active');
            $(this).parents('.pxl-content-area').find('ul.products').removeAttr('class').addClass($(this).attr('data-cls'));
        }
    });
}


setTimeout(function(){
    $('.pxl-close, .pxl-close .pxl-icon-close').on('click', function (e) {
        e.preventDefault();
        $(this).parents('.pxl-widget-cart-wrap').removeClass('open');
        $(this).parents('.pxl-modal').addClass('remove').removeClass('open');
        $(this).parents('#page').find('.site-overlay').removeClass('open');
        $(this).parents('body').removeClass('ov-hidden');
    });
}, 300);

    /* Header Sticky */
function meddox_header_sticky() {
    if($('#pxl-header-elementor').hasClass('is-sticky')) {
        if (pxl_scroll_top > 100) {
            $('.pxl-header-elementor-sticky.pxl-sticky-stb').addClass('pxl-header-fixed');
        } else {
            $('.pxl-header-elementor-sticky.pxl-sticky-stb').removeClass('pxl-header-fixed');   
        }

        if (pxl_scroll_status == 'up' && pxl_scroll_top > 100) {
            $('.pxl-header-elementor-sticky.pxl-sticky-stt').addClass('pxl-header-fixed');
        } else {
            $('.pxl-header-elementor-sticky.pxl-sticky-stt').removeClass('pxl-header-fixed');
        }
    }

    $('.pxl-header-elementor-sticky').parents('body').addClass('pxl-header-sticky');
}

    /* Scroll To Top */
function meddox_scroll_to_top() {
    if (pxl_scroll_top < pxl_window_height) {
        $('.pxl-scroll-top').addClass('pxl-off').removeClass('pxl-on');
    }
    if (pxl_scroll_top > pxl_window_height) {
        $('.pxl-scroll-top').addClass('pxl-on').removeClass('pxl-off');
    }
}

    /* Footer Fixed */
function meddox_footer_fixed() {
    setTimeout(function(){
        var h_footer = $('.pxl-footer-fixed #pxl-footer-elementor').outerHeight() - 1;
        $('.pxl-footer-fixed #pxl-main').css('margin-bottom', h_footer + 'px');
    }, 600);
}

    /* ====================
     WooComerce Quantity
     ====================== */
function meddox_quantity_icon() {
    $('#pxl-main .quantity').append('<span class="quantity-icon"><i class="quantity-down fas fa-sort-down"></i><i class="quantity-up fas fa-sort-up"></i></span>');
    $('.quantity-up').on('click', function () {
        $(this).parents('.quantity').find('input[type="number"]').get(0).stepUp();
    });
    $('.quantity-down').on('click', function () {
        $(this).parents('.quantity').find('input[type="number"]').get(0).stepDown();
    });
    $('.woocommerce-cart-form .actions .button').removeAttr('disabled');
}

jQuery( document ).on( 'updated_wc_div', function() {
    meddox_quantity_icon();

} );
    /*$( document ).ajaxComplete(function() {
       meddox_quantity_icon();
   }); */

})(jQuery);

(function ($) {
  function getDirection(ev, obj) {
    var w = $(obj).width(),
    h = $(obj).height(),
    x = (ev.pageX - $(obj).offset().left - (w / 2)) * (w > h ? (h / w) : 1),
    y = (ev.pageY - $(obj).offset().top - (h / 2)) * (h > w ? (w / h) : 1),
    d = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4;
    return d;
}
function addClass( ev, obj, state ) {
    var direction = getDirection( ev, obj ),
    class_suffix = null;
    $(obj).removeAttr('class');
    switch ( direction ) {
    case 0 : class_suffix = '-top';    break;
    case 1 : class_suffix = '-right';  break;
    case 2 : class_suffix = '-bottom'; break;
    case 3 : class_suffix = '-left';   break;
    }
    $(obj).addClass( state + class_suffix );
}
$.fn.ctDeriction = function () {
    this.each(function () {
      $(this).on('mouseenter',function(ev){
        addClass( ev, this, 'in' );
    });
      $(this).on('mouseleave',function(ev){
        addClass( ev, this, 'out' );
    });
  });
}
$('.pxl-grid-direction .item-direction').ctDeriction();

$('select[name=monster-widget-just-testing] option').each(function() {
  var optionText = this.text;
  var newOption = optionText.substring(0, 40);
  $(this).text(newOption + '...');
});

$('.comment-respond .form-submit').append( '<button name="submit" type="submit" id="submit" class="submit btn2 btn2-secondary" value="Post Comment">Leave a Comment</button>' );
$('.comment-respond .form-submit button').append( '<i class="flaticon_meddox2 flaticon_meddox2-plus"></i>' );
$('.attachment-full').attr('alt', 'image');
})(jQuery);
(function ($) {
    $(document).ready(function () {
        $('.pxl-department-grid .wrap-content-department, .pxl-department-carousel1 .pxl-item--image, .pxl-gallery-grid-layout1 .pxl-item--inner, .pxl-careers-grid .pxl-item--inner , .pxl-gallery-carousel1 .pxl-item--inner, .woocommerce-product-header .woocommerce-product-details').on('mouseenter', function (e) {
            x = e.pageX - $(this).offset().left,
            y = e.pageY - $(this).offset().top;
            $(this).find('span').css({
                top: y,
                left: x
            });
        });
    });
   
})(jQuery);

