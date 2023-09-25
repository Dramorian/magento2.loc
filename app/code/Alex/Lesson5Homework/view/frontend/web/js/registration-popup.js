define([
        "jquery",
        "Magento_Ui/js/modal/modal"
    ],

    function ($) {
        var RegistrationPopup = {
            initModal: function (config, element) {
                let $target = $(config.target);
                $target.modal();
                let $element = $(element);
                $element.click(function () {
                    $target.modal('openModal');
                });
            }
        };

        return {
            'registrationPopup': RegistrationPopup.initModal
        };
    }
);
