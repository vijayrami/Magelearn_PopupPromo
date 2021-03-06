
define([
    'jquery',
    'jquery/jquery.cookie'
], function ($) {
    'use strict';

    $.widget('magelearn.popupPromo', {
        cookieName: 'magelearn_popup_promo',

        cookie: function() {
            var now = new Date().getTime(),
                expiryDate = now + (10 * 60 * 1000);
            $.cookie(this.cookieName, 1, {path: '/', expires: expiryDate});
        },

        _create: function () {
            var options = this.options;

            /** Close popup */
            $(options.close).click(function () {
                $(options.container).fadeOut();
            });

            /** Copy promo code */
            $(options.button).click(function () {
                var $temp = $('<input>');
                $('body').append($temp);
                $temp.val($(options.code).val()).select();
                document.execCommand("copy");
                $temp.remove();
                $(options.button).text($(options.button).data('copied'));
            });

            /** Display */
            var obj = this;
            if ($.cookie(this.cookieName) != 1) {
                if (options.displaySettings == 'after_x_seconds') {
                    setTimeout(function () {
                        $(options.container).fadeIn();
                        obj.cookie();
                    }, parseInt(options.displayDelay) * 1000);
                } else if (options.displaySettings == 'immediately') {
                    $(options.container).fadeIn();
                    obj.cookie();
                }
            }
        }
    });

    return $.magelearn.popupPromo;

});