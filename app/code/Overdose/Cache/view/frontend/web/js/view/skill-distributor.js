define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Overdose_Cache/skill-distributor'
        },

        initialize: function () {
            this._super();

            // Set default skill points
            this.totalSkillPoints = ko.observable(10); // Change this to your desired initial skill points
            this.attackPoints = ko.observable(0);
            this.defensePoints = ko.observable(0);
            this.speedPoints = ko.observable(0);

            // Add an observable to track if all skill points are spent
            this.allPointsSpent = ko.pureComputed(function () {
                return this.totalSkillPoints() === 0;
            }, this);

            // Disable plus buttons when all skill points are spent
            this.disablePlusButtons = ko.pureComputed(function () {
                return this.totalSkillPoints() === 0;
            }, this);
        },

        updateTotalPoints: function () {
            // Update total skill points based on the values of individual points
            this.totalSkillPoints(10 - this.attackPoints() - this.defensePoints() - this.speedPoints());
        }
    });
});
