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
         * Set cookie expiration time. If no cookie — allow requestc
         * @returns {boolean}
         */
        isSubmitAllowed: function () {
            var cookieValue = $.mage.cookies.get(this.options.cookieName);

            if (cookieValue) {
                // Get the cookie expiration time.
                var cookieExpirationTime = parseInt(cookieValue, 10);

                // If the cookie has expired, allow the user to submit a request.
                if (cookieExpirationTime < new Date().getTime()) {
                    $.mage.cookies.clear(this.options.cookieName);  // Clear the expired cookie
                    return true;
                }
            } else {
                // If the cookie does not exist, allow the user to submit a request.
                return true;
            }

            // Otherwise, prevent the user from submitting a request.
            return false;
        },

        /**
         * Validate request and submit the form, if possible
         */
        submitForm: function () {
            if (!this.validateForm()) {
                validationAlert();

                return;
            }

            if (!this.isSubmitAllowed()) {
                alert({
                    title: $.mage.__('Error'),
                    content: $.mage.__('You are not allowed to submit a request right now. Please wait for 2 minutes before submitting another request.')
                });

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
            $.mage.cookies.set(this.options.cookieName, String(new Date().getTime() + 5000), 1);
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


