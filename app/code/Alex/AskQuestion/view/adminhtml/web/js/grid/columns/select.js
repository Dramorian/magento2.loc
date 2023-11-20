define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            additionalCustomClass: '',
            customClasses: {
                pending: 'red',
                answered: 'green'
            },
            bodyTmpl: 'Alex_AskQuestion/grid/cells/text'
        },

        getCustomClass: function (row) {
            var customClass = this.customClasses[row.status] || '';
            return customClass + ' ' + this.additionalCustomClass;
        }
    });
});
