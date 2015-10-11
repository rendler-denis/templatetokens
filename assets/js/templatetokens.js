+function ($) {
    "use strict";

    var TemplateTokens = function () {

        this.updateToken = function (recordId) {
            var newPopup = $('<a />');

            newPopup.popup({
                handler: 'onUpdateToken',
                extraData: {
                    'record_id': recordId
                }
            });
        };

        this.createToken = function () {
            var newPopup = $('<a />');
            newPopup.popup({ handler: 'onCreateToken' });
        };

    }

    $.templateTokens = new TemplateTokens();

}(window.jQuery);