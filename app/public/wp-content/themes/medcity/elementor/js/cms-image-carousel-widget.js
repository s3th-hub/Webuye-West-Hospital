( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */

    var WidgetCMSImageCarouselHandler = function( $scope, $ ) {
        var breakpoints = elementorFrontend.config.breakpoints;
        var carousel = $scope.find(".cms-slick-carousel");
        var sliderCounter = $scope.find('.slider-counter');
        var data = carousel.data();
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
        // Nav Count
        if (carousel.length && sliderCounter.length) {
            var currentSlide;
            var slidesCount;
            var updateSliderCounter = function(slick, currentIndex) {
                currentSlide = slick.slickCurrentSlide() + 1;
                slidesCount = slick.slideCount;
                $(sliderCounter).text(currentSlide + ' / ' +slidesCount)
            };

            carousel.on('init', function(event, slick) {
                updateSliderCounter(slick);
            });

            carousel.on('afterChange', function(event, slick, currentSlide) {
                updateSliderCounter(slick, currentSlide);
            });
        }
        // Slick run
        carousel.slick(slickOptions);

    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_image_carousel.default', WidgetCMSImageCarouselHandler );
    } );
} )( jQuery );