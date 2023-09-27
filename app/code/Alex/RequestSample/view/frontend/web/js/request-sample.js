define([
    'jquery',
    'jquery/ui'
], function ($) {

    $.widget('alex.requestSample', {
        options: {
            action: ''
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
        },

        submitForm: function () {
            if (!this.validateForm()) {
                return;
            }

            alert('Form was submitted');
        },
        /**
         *
         * @returns {boolean}
         */
        validateForm: function () {
            return true;
        }
    });

    return $.alex.requestSample;
});
