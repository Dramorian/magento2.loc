define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    // Class to represent a row in the seat reservations grid
    function SeatReservation(name, initialMeal) {
        var self = this;
        self.name = name;
        self.meal = ko.observable(initialMeal);

        self.formattedPrice = ko.computed(function () {
            var price = self.meal().price;
            return price ? "$" + price.toFixed(2) : "None";
        });
    }

    return Component.extend({
        defaults: {
            template: 'Overdose_Cache/seat-reservation'
        },
        initialize: function () {
            this._super();

            this.availableMeals = [
                {
                    mealName: "Classic Breakfast",
                    price: 8.99
                },
                {
                    mealName: "Vegetarian Delight",
                    price: 12.50
                },
                {
                    mealName: "Mediterranean Feast",
                    price: 18.75
                },
                {
                    mealName: "Tex-Mex Special",
                    price: 15.99
                },
                {
                    mealName: "Sushi Extravaganza",
                    price: 24.99
                },
                {
                    mealName: "Healthy Salad Bowl",
                    price: 10.49
                },
                {
                    mealName: "BBQ Bonanza",
                    price: 22.75
                },
                {
                    mealName: "Seafood Delight",
                    price: 29.99
                },
                {
                    mealName: "Vegan Bliss",
                    price: 14.99
                },
                {
                    mealName: "Gourmet Pizza",
                    price: 20.50
                }
            ];

            this.seats = ko.observableArray([
                new SeatReservation("Steve", this.availableMeals[0]),
                new SeatReservation("Bert", this.availableMeals[0])
            ]);

            // Operations
            this.addSeat = function () {
                this.seats.push(new SeatReservation("", this.availableMeals[0]));
            };
            this.removeSeat = function (seat) {
                this.seats.remove(seat);
            };
            this.removeAllSeats = function () {
                this.seats.removeAll();
            };
            this.numberOfSeats = ko.observable();
            this.validationMessage = ko.observable("");

            this.totalMealPrice = ko.computed(function () {
                var total = 0;
                for (var i = 0; i < this.seats().length; i++) {
                    var meal = this.seats()[i].meal();
                    if (meal) {
                        total += meal.price;
                    }
                }
                return "$" + total.toFixed(2);
            }, this);

            this.addMultipleSeats = function () {
                var numSeats = parseInt(this.numberOfSeats(), 10);

                if (numSeats >= 4) {
                    for (var i = 0; i < numSeats; i++) {
                        this.seats.push(new SeatReservation("", this.availableMeals[0]));
                    }
                    this.validationMessage(""); // Clear the validation message
                } else {
                    this.validationMessage("Reserving multiple seats requires a minimum of 4 seats.");
                }
            };
        }
    });
});
