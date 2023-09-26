define([
        "jquery",
        "Magento_Ui/js/modal/modal"
    ],

    function ($) {
        var RegistrationPopup = {
            initModal: function (config, element) {
                let $target = $(config.target);

                // Modify the modal options to change the button text
                let modalOptions = {
                    type: 'popup',
                    title: 'Registration for dealer',
                    buttons: [{
                        text: $.mage.__('Back'), // Change the button text to 'Back'
                        class: 'action primary',
                        click: function () {
                            this.closeModal();
                        }
                    }]
                };

                $target.modal(modalOptions);

                let $element = $(element);
                $element.click(function () {
                    $target.modal('openModal');
                });
            }
        };

        return {
            'registrationPopup': RegistrationPopup.initModal
        };
    });
