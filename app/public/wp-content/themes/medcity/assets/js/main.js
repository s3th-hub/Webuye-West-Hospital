;(function ($) {

    "use strict";

    /* ===================
     Page reload
     ===================== */
    var scroll_top;
    var window_height;
    var window_width;
    var scroll_status = '';
    var lastScrollTop = 0;
    $(window).on('load', function () {
        $(".cms-loader").fadeOut("slow");
        window_width = $(window).width();
        theme_col_offset();
        medcity_header_sticky();
        medcity_scroll_to_top();
    });
    $(window).on('resize', function () {
        window_width = $(window).width();
        theme_col_offset();
    });

    $(window).on('scroll', function () {
        scroll_top = $(window).scrollTop();
        window_height = $(window).height();
        window_width = $(window).width();
        if (scroll_top < lastScrollTop) {
            scroll_status = 'up';
        } else {
            scroll_status = 'down';
        }
        lastScrollTop = scroll_top;
        medcity_header_sticky();
        medcity_scroll_to_top();
    });

    $.sep_grid_refresh = function (){
        $('.cms-grid-masonry').each(function () {
            var iso = new Isotope(this, {
                itemSelector: '.grid-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.grid-sizer',
                },
                containerStyle: null,
                stagger: 30,
                sortBy : 'name',
            });

            var filtersElem = $(this).parent().find('.grid-filter-wrap');
            filtersElem.on('click', function (event) {
                var filterValue = event.target.getAttribute('data-filter');
                iso.arrange({filter: filterValue});
            });

            var filterItem = $(this).parent().find('.filter-item');
            filterItem.on('click', function (e) {
                filterItem.removeClass('active');
                $(this).addClass('active');
            });

            var filtersSelect = $(this).parent().find('.select-filter-wrap');
            filtersSelect.change(function() {
                var filters = $(this).val();
                iso.arrange({filter: filters});
            });

            var orderSelect = $(this).parent().find('.select-order-wrap');
            orderSelect.change(function() {
                var e_order = $(this).val();
                if(e_order == 'asc') {
                    iso.arrange({sortAscending: false});
                }
                if(e_order == 'des') {
                    iso.arrange({sortAscending: true});
                }
            });

        });
    }

    $(document).on('click', '.h-btn-search', function () {
        $('.cms-modal-search').addClass('open');
        setTimeout(function(){
            $('.cms-modal-search input[name="s"]').focus();
        },1000);
    });

    // load more
    $('.cms-grid').each(function () {
        var _this_wrap = $(this);
        var html_id = _this_wrap.attr('id');

        $(document).on('click', '.cms-load-more', function(){
            var loadmore = $(this).data('loadmore');
            var _this = $(this).parents(".cms-grid");
            var layout_type = _this.data('layout');
            loadmore.paged = parseInt(_this.data('start-page')) +1;
            var _this_click = $(this);
            _this_click.find('i').attr('class', 'fa fa-refresh fa-spin');
            $.ajax({
                url: main_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'medcity_load_more_post_grid',
                    settings: loadmore
                }
            })
            .done(function (res) {
                if(res.status == true) {
                    var html = $("<div></div>").html(res.data.html);
                    html.find(".grid-item").addClass("cms-animated");
                    html = html.html();
                    _this.find('.cms-grid-inner').append(html);
                    _this.data('start-page', res.data.paged);
                    if(layout_type == 'masonry'){
                        _this.imagesLoaded(function() {
                            $.sep_grid_refresh();
                        });
                    }
                    if(res.data.paged >= res.data.max){
                        _this_click.hide();
                    }
                }
            })
            .fail(function (res) {
                return false;
            })
            .always(function () {
                _this_click.find('i').attr('class', 'i-hidden');
                return false;
            });
        });

        // pagination
        $(document).on('click', '.cms-grid-pagination .ajax a.page-numbers', function(){
            var _this = $(this).parents(".cms-grid");
            var loadmore = _this.find(".cms-grid-pagination").data('loadmore');
            var query_vars = _this.find(".cms-grid-pagination").data('query');
            var layout_type = _this.data('layout');
            var paged = $(this).attr('href');
            paged = paged.replace('#', '');
            loadmore.paged = parseInt(paged);
            query_vars.paged = parseInt(paged);
            $('html,body').animate({ scrollTop: _this.offset().top - 100 }, 750);
            // reload pagination
            $.ajax({
                url: main_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'medcity_get_pagination_html',
                    query_vars: query_vars
                }
            }).done(function (res) {
                if(res.status == true){
                    _this.find(".cms-grid-pagination").html(res.data.html);
                }
            }).fail(function (res) {
                return false;
            }).always(function () {
                return false;
            });
            // load post
            $.ajax({
                url: main_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'medcity_load_more_post_grid',
                    settings: loadmore
                }
            }).done(function (res) {
                if(res.status == true){
                    _this.find('.cms-grid-inner .grid-item').remove();
                    _this.find('.cms-grid-inner').append(res.data.html);
                    _this.data('start-page', res.data.paged);
                    if(layout_type == 'masonry'){
                        _this.imagesLoaded(function() {
                            $.sep_grid_refresh();
                        });
                    }
                }
            }).fail(function (res) {
                return false;
            }).always(function () {
                return false;
            });
            return false;
        });
        
    });

    // Svg support
    $('.grid-item-inner .item-icon img').each((i, e) => {
        const $img = $(e);
        const imgID = $img.attr('id');
        const imgClass = $img.attr('class');
        const imgURL = $img.attr('src');
        $.get(imgURL, (data) => {
            // Get the SVG tag, ignore the rest
            let $svg = $(data).find('svg');
            // Add replaced image's ID to the new SVG
            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', `${imgClass}replaced-svg`);
            }
            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');
            // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
            if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr(`viewBox 0 0  ${$svg.attr('height')} ${$svg.attr('width')}`);
            }
            // Replace image with new SVG
            $img.replaceWith($svg);
        }, 'xml');
    });

    $(document).ready(function () {

        /* =================
         Menu Dropdown
         =================== */
        var $menu = $('.main-navigation');
        $menu.find('.primary-menu li').each(function () {
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

        $('.sub-menu .current-menu-item').parents('.menu-item-has-children').addClass('current-menu-ancestor');
        $('.mega-auto-width').parents('.megamenu').addClass('remove-pos');
        /* =================
         Menu Mobile
         =================== */
        $("#main-menu-mobile .open-menu").on('click', function () {
            $(this).toggleClass('opened');
            $('.site-navigation').toggleClass('navigation-open');
        });

        /* ===================
         Search Toggle
         ===================== */
        $('.h-btn-form').click(function (e) {
            e.preventDefault();
            $('.cms-modal-contact-form').removeClass('remove').toggleClass('open');
        });
        $('.cms-close').click(function (e) {
            e.preventDefault();
            $(this).parent().addClass('remove').removeClass('open');
            $(this).parents('.cms-modal').addClass('remove').removeClass('open');
            $(this).parents('#page').find('.site-overlay').removeClass('open');
        });

        /* Video 16:9 */
        $('.entry-video iframe').each(function () {
            var v_width = $(this).width();

            v_width = v_width / (16 / 9);
            $(this).attr('height', v_width + 35);
        });
        /* Images Light Box - Gallery:True */
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

        /* Video Light Box */
        $('.cms-video-button, .video-play-button,  .btn-video, .cms-video-link a').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
        
        /* ====================
         Scroll To Top
         ====================== */
        $('.scroll-top').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

        /* =================
        Add Class
        =================== */
        $('.wpcf7-select').parent().addClass('wpcf7-menu');

        $('.animation-time').each(function () {
            var vctime = 100;
            var vc_inner = $(this).children().length;
            var _vci = vc_inner - 1;
            $(this).find('> .grid-item > .wpb_animate_when_almost_visible').each(function (index, obj) {
                $(this).css('animation-delay', vctime + 'ms');
                if (_vci === index) {
                    vctime = 100;
                    _vci = _vci + vc_inner;
                } else {
                    vctime = vctime + 40;
                }
            });
        });

        /* =================
         The clicked item should be in center in owl carousel
         =================== */
        var $owl_item = $('.owl-active-click');
        $owl_item.children().each(function (index) {
            $(this).attr('data-position', index);
        });
        $(document).on('click', '.owl-active-click .owl-item > div', function () {
            $owl_item.trigger('to.owl.carousel', $(this).data('position'));
        });

        /* Select */
        $('select').each(function () {
            $(this).niceSelect();
        });

        /* Newsletter */
        var email_text = $('.tnp-field-email label').text();
        $('.tnp-field-email label').remove();
        $('.tnp-field-email').find(".tnp-email").each(function (ev) {
            if (!$(this).val()) {
                $(this).attr("placeholder", email_text);
            }
        });
        var firstname_text = $('.tnp-field-firstname label').text();
        $('.tnp-field-firstname label').remove();
        $('.tnp-field-firstname').find(".tnp-firstname").each(function (ev) {
            if (!$(this).val()) {
                $(this).attr("placeholder", firstname_text);
            }
        });
        var lastname_text = $('.tnp-field-lastname label').text();
        $('.tnp-field-lastname label').remove();
        $('.tnp-field-lastname').find(".tnp-lastname").each(function (ev) {
            if (!$(this).val()) {
                $(this).attr("placeholder", lastname_text);
            }
        });

        $('.tnp-privacy-field label').each(function (ev) {
            if (!$(this).val()) {
                $(this).append("<span class='custom'></span>");
            }
        });

        /* Highlight Menu */
        $('.highlight-menu-wrap .menu-icon-wrap').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('highlight-active');
        });

        /* Mobile Menu */
        $('.main-navigation li.menu-item-has-children').append('<span class="main-menu-toggle"></span>');
        $('.main-menu-toggle').on('click', function () {
            $(this).parent().find('> .sub-menu').toggleClass('submenu-open');
            $(this).parent().find('> .sub-menu').slideToggle();
        });

        $(".h-btn-sidebar").on('click', function (e) {
            e.preventDefault();
            $('.cms-hidden-sidebar').toggleClass('open');
        });
        $(".cms-hidden-close").on('click', function (e) {
            e.preventDefault();
            $(this).parent().removeClass('open');
        });
        $(document).on('click', function (e) {
            if (e.target.className == 'cms-modal-close'){
                $(e.target).parents(".cms-modal-search").removeClass('open');
            }
            if (e.target.className == 'cms-hidden-sidebar open')
                $('.cms-hidden-sidebar').removeClass('open');
        });

        // Cms Toggle
        $(".cms-toggle-open").on('click', function () {
            $(this).parent().find(".cms-toggle-target").slideToggle(300);
        });
        $(".cms-toggle-close").on('click', function () {
            $(this).parents(".cms-toggle-target").slideToggle(300);
            setCookie('header_top_visible', 'no', 30);

        });
        // Active Class
        $(".cms-toggle-active").on('click', function () {
            $(this).parent().find(".cms-target-active").toggleClass("active");
        });

        /* =================
         Move Divider, Angled & Overlay for Row VC
         =================== */
        $('.entry-content > .vc_row').each(function () {
            var _el_overlay = $(this).find(".cms-row-overlay"),
                _row_overlay = _el_overlay.parents(".wpb_column");
            _row_overlay.before(_el_overlay.clone());
            _el_overlay.remove();
            $(this).find(".cms-row-overlay").parent().addClass('vc-row-overlay');

            var _el_divider = $(this).find(".row-divider"),
                _row_divider = _el_divider.parents(".wpb_column");
            _row_divider.before(_el_divider.clone());
            _el_divider.remove();
        });
        /**
         * @since 1.1.1
         * @author duongmanhchinh@gmail.com
         * 
         * **/
        medcity_wpcf7();
    });

    /* =================
     Column Absolute
     =================== */
    function theme_col_offset() {
        var w_vc_row_lg = ($('#content').width() - 1200) / 2;
        if (window_width > 1200) {
            $('body:not(.rtl) .col-offset-left > .elementor-widget-wrap').css('padding-left', w_vc_row_lg + 'px');
            $('body:not(.rtl) .col-offset-right > .elementor-widget-wrap').css('padding-right', w_vc_row_lg + 'px');

            $('.rtl .col-offset-left > .elementor-widget-wrap').css('padding-right', w_vc_row_lg + 'px');
            $('.rtl .col-offset-right > .elementor-widget-wrap').css('padding-left', w_vc_row_lg + 'px');

            /*

                $('body:not(.rtl) .col-offset-left > .elementor-column-wrap > .elementor-widget-wrap').css('padding-left', w_vc_row_lg + 'px');
                $('body:not(.rtl) .col-offset-right > .elementor-column-wrap > .elementor-widget-wrap').css('padding-right', w_vc_row_lg + 'px');

                $('.rtl .col-offset-left > .elementor-column-wrap > .elementor-widget-wrap').css('padding-right', w_vc_row_lg + 'px');
                $('.rtl .col-offset-right > .elementor-column-wrap > .elementor-widget-wrap').css('padding-left', w_vc_row_lg + 'px');

            */
        }
    }

    function medcity_header_sticky() {
        var offsetTop = $('#site-header-wrap').outerHeight();
        var h_header = $('.fixed-height').outerHeight();
        var offsetTopAnimation = offsetTop + 200;
        if($('#site-header-wrap').hasClass('is-sticky')) {
            if (scroll_top > offsetTopAnimation) {
                $('#site-header').addClass('h-fixed');
            } else {
                $('#site-header').removeClass('h-fixed');   
            }
        }
        if (window_width > 992) {
            $('.fixed-height').css({
                'height': h_header
            });
        }

        $('.cms-navigation-menu.sticky-menu').each(function () {
            var adminbar_height = $('#wpadminbar').outerHeight();
            var secondary_menu_offset = $(this).parent().offset().top - adminbar_height;
            var h_secondary_menu = $(this).outerHeight();
            if (scroll_top > secondary_menu_offset) {
                $(this).addClass('is-sticky');
            } else {
                $(this).removeClass('is-sticky');
            }
            $(this).parents('body').addClass('secondary-is-sticky');
        });
    }

    /* ====================
     Scroll To Top
     ====================== */
    function medcity_scroll_to_top() {
        if (scroll_top < window_height) {
            $('.scroll-top').addClass('off').removeClass('on');
        }
        if (scroll_top > window_height) {
            $('.scroll-top').addClass('on').removeClass('off');
        }
    }
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return false;
    }

    /**
     * Contact form 7
     * @since 1.1.1
     * @author duongmanhchinh@gmail.com
     * 
     * */
    function medcity_wpcf7() {
        'use strict';
        // add radio class active for default item
        $('.wpcf7-radio').each(function() {
            $('input[checked="checked"]').parents('.wpcf7-list-item').addClass('active');
        });
        // add radio class active on click
        $('.wpcf7-radio .wpcf7-list-item').on('click', function() {
            $(this).parent().find('.wpcf7-list-item').removeClass('active');
            $(this).toggleClass('active');
        });
        // add checkbox class active for default item
        $('.wpcf7-checkbox').each(function() {
            //$('input[checked="checked"]').parents('.wpcf7-list-item').addClass('active');
        });
        // add checkbox class active on click
        $('.wpcf7-checkbox .wpcf7-list-item').on('click', function() {
            $(this).toggleClass('active');
        });
        // date time
        $('.wpcf7-form-control-wrap.cms-date-time').on('click', function() {
            $(this).addClass('active');
        });
    }

})(jQuery);
