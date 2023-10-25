define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            console.log("I have been loaded!")
        },
    });
});
