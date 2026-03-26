;
(function($) {
    "use strict";

    $(document).on('click', '#btn-cms-get-started', function() {
        var _this = $(this);
        var alert = $('#cms-alert');
        if (!_this.hasClass('loading')) {
            if (_this.hasClass('btn-activate')) {
                $.ajax({
                    url: main_data.ajax_url,
                    type: "POST",
                    beforeSend: function() {
                        _this.addClass('loading');
                        _this.text('Activating');
                    },
                    data: {
                        action: 'get_started',
                        activate: 1
                    },
                }).done(function(res) {
                    if (res.stt) {
                        window.location.href = res.data.redirect_url;
                    } else {
                        _this.text('Activate');
                        alert.text(res.msg);
                        alert.show();
                    }
                }).fail(function(res) {
                    _this.text('Activate');
                    alert.text('Fail to Activate! Please try again!');
                    alert.show();
                }).always(function() {
                    _this.removeClass('loading');
                });
            } else {
                $.ajax({
                    url: 'https://core.7oroof.com/wp-json/api-bearer-auth/v1/get-started',
                    type: "POST",
                    beforeSend: function() {
                        _this.addClass('loading');
                        _this.text('Installing');
                    },
                    data: {
                        action: 'get_started',
                    },
                }).done(function(res) {
                    if (res.download_link) {
                        $.ajax({
                            url: main_data.ajax_url,
                            type: "POST",
                            beforeSend: function() {
                                _this.addClass('loading');
                                _this.text('Installing');
                            },
                            data: {
                                action: 'get_started',
                                download_link: res.download_link
                            },
                        }).done(function(res) {
                            if (res.stt) {
                                window.location.href = res.data.redirect_url;
                            } else {
                                _this.text('Install');
                                alert.text(res.msg);
                                alert.show();
                            }
                        }).fail(function(res) {
                            _this.text('Install');
                            alert.text('Fail to Install! Please try again!');
                            alert.show();
                        }).always(function() {
                            _this.removeClass('loading');
                        });
                    } else {
                        _this.text('Install');
                        alert.text('Fail to Install! Please try again!');
                        alert.show();
                    }
                }).fail(function(res) {
                    _this.text('Install');
                    if (typeof res.message != 'undefined') {
                        alert.text(res.message);
                        alert.show();
                    }
                    _this.removeClass('loading');
                }).always(function() {

                });
            }
        }
    });
})(jQuery);