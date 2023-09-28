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
        },

        submitForm: function () {
            if (!this.validateForm()) {
                validationAlert();
                return;
            }

            console.log('Form was submitted');
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
            })
                .done(function (response) {
                    alert({
                        title: $.mage.__(response.status),
                        content: $.mage.__(response.message)
                    });
                })
                .fail(function (error) {
                    console.log(JSON.stringify(error));
                    alert({
                        title: 'Error',
                        content: 'Your request can not be submitted. Please, contact us directly via email or prone to get your Sample.'
                    });
                });
        },

        validateForm: function () {
            return $(this.element).validation().valid();
        }
    });

    return $.alex.requestSample;
});
