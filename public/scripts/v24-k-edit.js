function v24KEditWrapper($) {
    var v24KEdit = {
        pathname: window.location.pathname.replace('/', ''),
        /**
         * Main entry point
         */
        init: function() {
            v24KEdit.prepareRadioOrCheckbox('produktTipp');
            v24KEdit.prepareRadioOrCheckbox('produktIsBonitabh');
            v24KEdit.prepareRadioOrCheckbox('produktHasOnlineAbschluss');
            v24KEdit.prepareRadioOrCheckbox('zinssatz');
            v24KEdit.prepareRadioOrCheckbox('rkvAbschluss');
            v24KEdit.prepareRadioOrCheckbox('legitimation');
            v24KEdit.prepareRadioOrCheckbox('ktozugriffe');
            v24KEdit.prettifyRadioOrCheckbox();

            v24KEdit.registerEventHandlers();
        },
        prepareRadioOrCheckbox: function(fieldName) {
            var parent = $('label[for="' + fieldName + '"]').parent().find('div.col-sm-8'),
                    elements = parent.find('label'),
                    colWidth = 12 / elements.length;
            elements.removeClass();
            elements.addClass('btn btn-default');
            elements.addClass('col-lg-' + colWidth);
            elements.addClass('col-md-' + colWidth);
            elements.addClass('col-sm-' + colWidth);
            elements.addClass('col-xs-' + colWidth);
            parent.attr('data-toggle', 'buttons');
            parent.addClass('btn-group');
        },
        prettifyRadioOrCheckbox: function() {
            $('.btn').button();
            $('input:checked').each(function(i, radio) {
                $(radio).parent().button('toggle');
            });
        },
        /**
         * Registers event handlers
         */
        registerEventHandlers: function() {
        }
    };
    $(document).ready(v24KEdit.init);
}

v24KEditWrapper(jQuery);