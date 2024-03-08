define([
    'jquery',
    'alex_validationAlert',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui'
], function ($, validationAlert, alert) {
    'use strict';

    $.widget('alex.askQuestion', {
        options: {
            cookieName: 'alex_question_was_requested'

        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
            $('body').on('alex_ask_question_clear_cookie', this.clearCookie.bind(this));
        },


        /**
         * Validate request and submit the form, if possible
         */
        submitForm: function () {
            // Check if 2 minutes have passed since the last request
            var lastRequestTime = $.mage.cookies.get(this.options.cookieName);
            var currentTime = Math.floor(Date.now() / 1000);  // UNIX timestamp in seconds

            if (lastRequestTime && (currentTime - lastRequestTime < 5)) {
                // Less than 2 minutes have passed, show a message to the user
                alert({
                    title: $.mage.__('Request Limit'),
                    content: $.mage.__('You can make another request in ' + (5 - (currentTime - lastRequestTime)) + ' seconds.')
                });
                return;
            }

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
            formData.append('isAjax', 1);

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
                        var currentTime = Math.floor(Date.now() / 1000);  // UNIX timestamp in seconds
                        $.mage.cookies.set(this.options.cookieName, currentTime);
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
         *  Clear 'alex_ask_question_clear_cookie` cookie
         *  when the event `alex_ask_question_clear_cookie` is triggered
         */
        clearCookie: function () {
            $.mage.cookies.clear(this.options.cookieName);
        }
    });

    return $.alex.askQuestion;
});
