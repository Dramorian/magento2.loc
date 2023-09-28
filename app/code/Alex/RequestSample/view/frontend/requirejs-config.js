var config = {
    map: {
        '*': {
            alex_requestSample: 'Alex_RequestSample/js/request-sample',
            alex_validationAlert: 'Alex_RequestSample/js/validation-alert',
            // overriding default cookie component
            'jquery/jquery.cookie': 'Alex_RequestSample/js/jquery/jquery.cookie'
        }
    },
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Alex_RequestSample/js/product/catalog-add-to-cart-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Alex_RequestSample/js/checkout/place-order-mixin': true
            }
        }
    }
};
