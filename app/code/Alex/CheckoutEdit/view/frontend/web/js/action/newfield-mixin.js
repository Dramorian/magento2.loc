/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();

            // Check if the shipping address form is visible (not logged in)
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            var attribute = shippingAddress.customAttributes.find(
                function (element) {
                    return element.attribute_code === 'new_field';
                }
            );

            // Check if the 'new_field' attribute is found before accessing its value
            if (attribute) {
                shippingAddress['extension_attributes']['new_field'] = attribute.value;
            }

            // pass execution to the original action ('Magento_Checkout/js/action/set-shipping-information')
            return originalAction();
        });
    };
});
