define([
    'jquery',
    'mage/validation',
    'mage/translate'
], function ($) {
    'use strict';

    return function (validator) {
        $.validator.addMethod(
            'mobileUA',
            function (phoneNumber, element) {
                return this.optional(element) || phoneNumber.length > 9 &&
                    // Regular expression to match Ukrainian phone numbers
                    phoneNumber.match(/^\+380\d{9}$/);
            },
            $.mage.__('Please enter a valid Ukrainian phone number.')
        );
        return validator;
    }
});
