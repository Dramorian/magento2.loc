var config = {
    map: {
        '*': {
            alex_askQuestion: 'Alex_AskQuestion/js/ask-question',
            alex_validationAlert: 'Alex_AskQuestion/js/validation-alert',
            // overriding default cookie component
            'jquery/jquery.cookie': 'Alex_AskQuestion/js/jquery/jquery.cookie'
        }
    },
    config: {
        mixins: {
            'mage/validation': {
                'Alex_AskQuestion/js/validation-mixin': true
            }
        }
    }
};
