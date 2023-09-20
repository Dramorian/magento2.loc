define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, modal, url) {
    'use strict';

    // Initialize the modal
    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Registration',
        modalClass: 'registration-popup',
        buttons: [{
            text: $.mage.__('Close'),
            class: '',
            click: function () {
                this.closeModal();
            }
        }]
    };

    function openPopup()
    {
        var registrationPopup = $('#registration-popup');
        modal(options, registrationPopup);
        registrationPopup.modal('openModal');
    }

    return {
        openPopup: openPopup
    };
});
