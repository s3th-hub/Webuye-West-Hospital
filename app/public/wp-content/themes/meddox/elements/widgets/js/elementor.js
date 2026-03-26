( function( $ ) {
    var pxl_widget_elementor_handler = function( $scope, $ ) {

    };
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', pxl_widget_elementor_handler );
    } );
} )( jQuery );