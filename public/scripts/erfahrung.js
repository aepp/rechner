var pageInitialized;
$(document).ready(function() {
    if (pageInitialized) {
        return;
    }
    pageInitialized = true;
    $.extend($.tablesorter.themes.bootstrap, {
        table: 'table table-bordered',
        caption: 'caption',
        header: 'bootstrap-header', // give the header a gradient background
        footerRow: '',
        footerCells: '',
        icons: '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
        sortNone: 'bootstrap-icon-unsorted',
        sortAsc: 'icon-chevron-up glyphicon glyphicon-chevron-up', // includes classes for Bootstrap v2 & v3
        sortDesc: 'icon-chevron-down glyphicon glyphicon-chevron-down', // includes classes for Bootstrap v2 & v3
        active: '', // applied when column is sorted
        hover: '', // use custom css here - bootstrap class may not override it
        filterRow: '', // filter row class
        filter_useParsedData: true,
    });
    $("#erfahrungen-table").tablesorter({
        theme: "bootstrap",
//		debug: true,
        widthFixed: false,
        headerTemplate: '{content} {icon}',
        widgets: ["uitheme", "filter"],
        widgetOptions: {
            filter_columnFilters: true,
            filter_reset: ".reset",
            filter_useParsedData: true,
//			filter_anyMatch : true,
        },
        headers: {
            0: {
                sorter: true,
                filter: true
            },
            1: {
                sorter: true,
                filter: true
            },
            2: {
                sorter: true,
                filter: true
            },
            3: {
                sorter: true,
                filter: true
            },
            4: {
                sorter: true,
                filter: true
            }
        },
        textExtraction: {
            0: function(node, table, cellIndex) {
                return $(node).find('span').text();
            },
            1: function(node, table, cellIndex) {
                return $(node).find('span.verfasst-am').text();
            },
            2: function(node, table, cellIndex) {
                return $(node).find('span').text();
            },
            3: function(node, table, cellIndex) {
                return $(node).find('span').text();
            },
            4: function(node, table, cellIndex) {
                return $(node).html();
            }
        },
        filter_functions: {
            0: true,
            1: true,
            2: true,
            3: true,
//
////	    	1 : function(e, n, f, i, $r) {
////	    		new Date(value) Date.compare ( Date date1, Date date2 )
////	    		return e === f;
////	    	},
            4: {
                "0": function(e, n, f, i, $r) {
                    console.log("filtering started");
                    var d = e.split('.');
                    var year = d[2];
                    var month = d[1];
                    var day = d[0];
                    return Date.compare(new Date(), new Date(year, month, day)) == 0 ? true : false;
                },
                "1": function(e, n, f, i, $r) {
                    return /^[E-H]/.test(e);
                },
                "2": function(e, n, f, i, $r) {
                    return /^[I-L]/.test(e);
                },
                "3": function(e, n, f, i, $r) {
                    return /^[M-P]/.test(e);
                }
            },
        },
        ignoreCase: true
    });

    $('#bank-filter').unbind('change').change(function(event) {
        var columns = [];
        columns[0] = $(this).val();
        $('#erfahrungen-table').trigger('search', [columns]);
    });
    $('#status-filter').unbind('change').change(function(event) {
        var columns = [];
        columns[3] = $(this).val();
        $('#erfahrungen-table').trigger('search', [columns]);
    });
    $('#note-filter').unbind('change').change(function(event) {
        var columns = [];
        columns[2] = $(this).val();
        $('#erfahrungen-table').trigger('search', [columns]);
    });
    $('#datum-filter').unbind('change').change(function(event) {
        var columns = [];
        columns[4] = $(this).val();
        $('#erfahrungen-table').trigger('search', [columns]);
    });
    $("#sort-on-status").click(function() {
        $('#erfahrungen-table').find("th:eq(3)").trigger("sort");
        return false;
    });
    $("#sort-on-date").click(function() {
        $('#erfahrungen-table').find("th:eq(1)").trigger("sort");
        return false;
    });
    $('#erfahrungen-table').find('.bewertung').each(function(i, elem) {
        var div = $(elem);
        div.raty({
            score: div.attr('id').split('-')[1],
            path: 'scripts/raty/images',
            size: 36,
            hints: ['absolut unmöglich', 'schlecht', 'in Ordnung', 'gut', 'super'],
            readOnly: true
        });
    });

    $(document).on('click', '.status-switch', function(event) {
        var status = null;

        var parent_tr = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
        var erfahrungId = parent_tr.attr('id').split('-')[3];
        var span_status = parent_tr.find('td').eq(3).find('span');

        var replace_with = null;
        var current_status = $(this);

        if (current_status.hasClass('btn-danger')) {
            status = 1;
            replace_with =
                    "<button class='btn btn-success btn-xs status-switch' type='button'>" +
                    "<span class='glyphicon glyphicon-ok' title='freigescheltet'></span>" +
                    "</button>"
                    ;
        } else {
            status = 0;
            replace_with =
                    "<button class='btn btn-danger btn-xs status-switch' type='button'>" +
                    "<span class='glyphicon glyphicon-remove' title='freigescheltet'></span>" +
                    "</button>"
                    ;
        }

        $.ajax({
            type: 'POST',
            url: 'erfahrungsberichte/update/' + erfahrungId,
            data: {status: status},
            success: function(response) {
                current_status.replaceWith(replace_with);
                span_status.html(' ' + status + ' ');
                $("#erfahrungen-table").trigger("updateCell", [parent_tr.find('td').eq(3), false]);
            },
            error: function(response) {

            },
            complete: function() {

            }
        });
    });

    $(document).on('click', '.erfahrung-delete', function(event) {
        event.preventDefault();
        $('#delete-confirm-modal').modal('toggle');

        var erfahrungId = $(this).parent().parent().parent().parent().parent().parent().parent().parent().attr('id').split('-')[1];
        var autor = $(this).parent().parent().parent().parent().find('div').eq(1).html();
        $('#delete-erfahrung-id').val(erfahrungId);
        $('#delete-erfahrung-autor').html(autor);
    });

    $('#delete-confirm').unbind('click').click(function(event) {
        var erfahrungId = $('#delete-erfahrung-id').val();
        $.ajax({
            type: 'POST',
            url: 'erfahrungsberichte/delete/' + erfahrungId,
            success: function(response) {
                $('#erfahrungen-table-row-' + erfahrungId).remove();
                $('#delete-confirm-modal').modal('toggle');
            },
            error: function(response) {

            },
            complete: function() {

            }
        });
    });
});