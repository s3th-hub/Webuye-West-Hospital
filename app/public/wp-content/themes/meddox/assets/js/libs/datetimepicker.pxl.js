;(function ($) {

    "use strict";

    $(document).ready(function () {
        $('.pxl-date input').datetimepicker({
            timepicker: false,
            format:'F j, Y'
        });  
    });
    $(document).ready(function () {
        $('.pxl-time input').datetimepicker({
            datepicker:false,
            format:'H:i'
        });  
    });
    $('.pxl-date i').appendTo('.pxl-date .wpcf7-form-control-wrap');
    $('.pxl-time i').appendTo('.pxl-time .wpcf7-form-control-wrap');

})(jQuery);