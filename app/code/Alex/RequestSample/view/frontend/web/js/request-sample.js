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

        /**
         * Validate request and submit the form, if possible
         */
        submitForm: function () {
            if (!this.validateForm()) {
                validationAlert();

                return;
            }
            this.ajaxSubmit();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
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

                /** @inheritDoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritDoc */
                success: function (response) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__(response.status),
                        content: $.mage.__(response.message)
                    });

                    if (response.status === 'Success') {
                        // Prevent from sending requests too often
                        $.mage.cookies.set(this.options.cookieName, true);
                    }
                },

                /** @inheritDoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your request can not be submitted right now. Please, contact us directly via email or phone to get your Sample.')
                    });
                }
            });

        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         *  Clear 'alex_request_sample_clear_cookie` cookie
         *  when the event `alex_request_sample_clear_cookie` is triggered
         */
        clearCookie: function () {
            $.mage.cookies.clear(this.options.cookieName);
        }
    });

    return $.alex.requestSample;
});
