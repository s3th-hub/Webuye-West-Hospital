( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSPostCarouselHandler = function( $scope, $ ) {
        var breakpoints = elementorFrontend.config.breakpoints;
        var carousel = $scope.find(".cms-slick-carousel");
        var data = carousel.data();
        var slider_nav = $scope.find('.cms-slick-nav');
        if (slider_nav.length === 0) {
            slider_nav = false;
        }
        var slickOptions = {
            slidesToShow: data.slidestoshow,
            slidesToScroll: data.slidestoscroll,
            autoplay: true === data.autoplay,
            autoplaySpeed: data.autoplayspeed,
            infinite: true === data.infinite,
            pauseOnHover: true === data.pauseonhover,
            speed: data.speed,
            centerPadding: data.centerpadding,
            arrows: true === data.arrows,
            dots: true === data.dots,
            rtl: true === data.dir,
            nextArrow: '<span class="slick-next fac fac-arrow-right"></span>',
            prevArrow: '<span class="slick-prev fac fac-arrow-left"></span>',
            asNavFor: slider_nav,
            responsive: [{
                breakpoint: breakpoints.lg,
                settings: {
                    slidesToShow: data.slidestoshowtablet,
                    slidesToScroll: data.slidestoscrolltablet,
                }
            }, {
                breakpoint: breakpoints.md,
                settings: {
                    slidesToShow: data.slidestoshowmobile,
                    slidesToScroll: data.slidestoscrollmobile,
                    centerPadding: '0px',
                }
            }]
        };
        // Slick run
        carousel.slick(slickOptions);
        if(typeof carousel.attr('data-centerMode') !== 'undefined') {
            slickOptions.centerMode = carousel.attr('data-centerMode') == 'true' ? true : false;
        }
        var nav_for = $scope.find(".cms-slick-nav");
        if(nav_for.length > 0){
            slickOptions.asNavFor = nav_for;
        }

        $('.cms-slick-nav-arrow').parents('.elementor-element').addClass('hide-nav');

        $('.cms-slick-nav-left').on('click', function () {
            $(this).parents('.elementor-element').find('.cms-slick-slider .slick-prev').trigger('click');
        });
        $('.cms-slick-nav-right').on('click', function () {
            $(this).parents('.elementor-element').find('.cms-slick-slider .slick-next').trigger('click');
        });

    };

    $('.cms-slick-slider').each(function () {
        var slider_main = $(this).find('.cms-slick-carousel');
        var slider_nav = $(this).find('.cms-slick-nav'),
            centerMode = slider_nav.data('centermode'),
            centerPadding = slider_nav.data('centerpadding'),
            variableWidth = slider_nav.data('variablewidth'),
            draggable = slider_nav.data('draggable'),
            infinite = slider_nav.data('infinite');
        var slider_nav_opts = {
                slidesToShow: parseInt(slider_nav.attr('data-nav')),
                slidesToScroll: 1,
                asNavFor: slider_main,
                dots: false,
                focusOnSelect: true,
                //infinite: false,
                nextArrow: '<span class="slick-next fac fac-arrow-right"></span>',
                prevArrow: '<span class="slick-prev fac fac-arrow-left"></span>',
                arrows:false,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            };
        if(typeof centerMode != 'undefined'){
            slider_nav_opts.centerMode = centerMode;
        }
        if(typeof centerPadding != 'undefined'){
            slider_nav_opts.centerPadding = centerPadding;
        }
        if(typeof variableWidth != 'undefined'){
            slider_nav_opts.variableWidth = variableWidth;
        }
        if(typeof draggable != 'undefined'){
            slider_nav_opts.draggable = draggable;
        }
        if(typeof infinite != 'undefined'){
            slider_nav_opts.infinite = infinite;
        } else {
            slider_nav_opts.infinite = false;
        }
        $(slider_nav).slick(slider_nav_opts);
    });
    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_post_carousel.default', WidgetCMSPostCarouselHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_doctor_carousel.default', WidgetCMSPostCarouselHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_service_carousel.default', WidgetCMSPostCarouselHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_department_carousel.default', WidgetCMSPostCarouselHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_career_carousel.default', WidgetCMSPostCarouselHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_testimonial_carousel.default', WidgetCMSPostCarouselHandler );
    } );
} )( jQuery );