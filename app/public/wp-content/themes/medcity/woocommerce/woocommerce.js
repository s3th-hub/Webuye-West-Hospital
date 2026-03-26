;(function ($) {

    "use strict";

    $(document).ready(function () {

        $('.widget_product_search .search-field').find("input[type='text']").each(function (ev) {
            if (!$(this).val()) {
                $(this).attr("placeholder", "Search and Press Enter");
            }
        });

        $('.product-layout-list').parents('ul.products').addClass('products-list');
        $('.single_variation_wrap').addClass('clearfix');
        $('.woocommerce-variation-add-to-cart').addClass('clearfix');

        $('.cart-total-wrap').on('click', function () {
            $('.widget-cart-sidebar').toggleClass('open');
            $(this).toggleClass('cart-open');
            $('.site-overlay').toggleClass('open');
        });

        $('.site-overlay').on('click', function () {
            $(this).removeClass('open');
            $(this).parents('#page').find('.widget-cart-sidebar').removeClass('open');
        });

        $('.woocommerce-tab-heading').on('click', function () {
            $(this).toggleClass('open');
            $(this).parent().find('.woocommerce-tab-content').slideToggle('');
        });

        $('.site-menu-right .h-btn-cart, .mobile-menu-cart .h-btn-cart').on('click', function (e) {
            e.preventDefault();
            $(this).parents('#site-header-wrap').find('.widget_shopping_cart').toggleClass('open');
            $('.cms-hidden-sidebar').removeClass('open');
            $('.cms-search-popup').removeClass('open');
        });

        /* ===================
         Cart Toggle
         ===================== */
        $('.open-cart').on('click',function(e){
            e.preventDefault();
            $('.widget_shopping_cart_content').toggleClass('active');
        });

        /* ===================
         WooComerce Quantity
         ===================== */

        $('#content .quantity').append('<span class="quantity-icon"><i class="quantity-up fac fac-plus"></i><i class="quantity-down fac fac-minus"></i></span>');
        $('.quantity-up').on('click', function () {
            var qtyInput = $(this).parents('.quantity').find('input[type="number"]');
            qtyInput.get(0).stepUp();
            qtyInput.trigger('change');
        });
        $('.quantity-down').on('click', function () {
            var qtyInput = $(this).parents('.quantity').find('input[type="number"]');
            qtyInput.get(0).stepDown();
            qtyInput.trigger('change');
        });
        $('.woocommerce-cart-form .actions .button').removeAttr('disabled');

    });

})(jQuery);
