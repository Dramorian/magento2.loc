define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            customer_name: ko.observable('No name')
        },

        initialize: function () {
            this._super();

            this.myFirstJavaScript();

            return this;
        },

        myFirstJavaScript: function () {
            this.customer_name('IVAN. (or other name that came from ajax)');
        }
    });
});
