/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'sample_gateway',
                component: 'Alex_SamplePaymentGateway/js/view/payment/method-renderer/sample_gateway'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
