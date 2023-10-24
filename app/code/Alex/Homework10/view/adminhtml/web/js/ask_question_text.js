define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Alex_Homework10/text_template',
        },

        initialize: function () {
            this._super();
            console.log("I have been loaded!")
        },
    });
});
