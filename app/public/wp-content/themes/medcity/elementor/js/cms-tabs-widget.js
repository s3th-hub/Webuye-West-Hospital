( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSTabsHandler = function( $scope, $ ) {
        $scope.find(".cms-tabs .cms-tabs-title .cms-tab-title").on("click", function(e){
            e.preventDefault();
            var target = $(this).data("target");
            var parent = $(this).parents(".cms-tabs");
            parent.find(".cms-tabs-content .cms-tab-content").hide();
            parent.find(".cms-tabs-title .cms-tab-title").removeClass('active');
            $(this).addClass("active");
            $(target).show();
        });
    };
    var WidgetWorkProcessHandler = function( $scope, $ ) {
        // $scope.find(".cms-work-process .process-action .action-item").on("mouseover", function(e){
        //     e.preventDefault();
        //     var target = $(this).data("target");
        //     var parent = $(this).parents(".cms-work-process");
        //     parent.find(".process-content .content-item").hide();
        //     parent.find(".process-action .action-item").removeClass('active');
        //     $(this).addClass("active");
        //     $(target).show();
        // });
        $scope.find(".cms-work-process .process-action .action-item").on({
            mouseenter: function (e) {
                e.preventDefault();
                var target = $(this).data("target");
                var parent = $(this).parents(".cms-work-process");
                parent.find(".process-content .content-item").hide();
                parent.find(".process-action .action-item").removeClass('active');
                $(this).addClass("active");
                $(target).show();
            },
            mouseleave: function (e) {
                //stuff to do on mouse leave
            }
        });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_tabs.default', WidgetCMSTabsHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_work_process.default', WidgetWorkProcessHandler );
    } );
} )( jQuery );