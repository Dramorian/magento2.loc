define([
    'jquery',
    'alex_validationAlert',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui'
], function ($, validationAlert, alert) {
    'use strict';

    $.widget('alex.requestSample', {
        options: {
            cookieName: 'alex_sample_was_requested'
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
            $('body').on('alex_request_sample_clear_cookie', this.clearCookie.bind(this));
        },

        submitForm: function () {
            if (!this.validateForm()) {
                validationAlert();
                return;
            }

            var formData = new FormData($(this.element).get(0));
            formData.append('form_key', $.mage.cookies.get('form_key'));

            $.ajax({
                url: $(this.element).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                success: function (response) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__(response.status),
                        content: $.mage.__(response.message)
                    });

                    if (response.status === 'Success') {
                        // can use this cookie to prevent from sending requests too often
                        $.mage.cookies.set(this.options.cookieName, true);
                    }
                },

                error: function (error) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your request can not be submitted right now. Please, contact us directly via email or phone to get your Sample.')
                    });
                }
            })

        },

        validateForm: function () {
            return $(this.element).validation().valid();
        },

        clearCookie: function () {
            $.mage.cookies.clear(this.options.cookieName);
        }
    });

    return $.alex.requestSample;
});
