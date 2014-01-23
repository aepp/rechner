var pageInitialized;
$(document).ready(function() {
	if (pageInitialized) {
		return;
	}
	pageInitialized = true;
	$.extend($.tablesorter.themes.bootstrap, {
		table      : 'table table-bordered',
		caption    : 'caption',
		header     : 'bootstrap-header', // give the header a gradient background
		footerRow  : '',
		footerCells: '',
		icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
		sortNone   : 'bootstrap-icon-unsorted',
		sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up',     // includes classes for Bootstrap v2 & v3
		sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down', // includes classes for Bootstrap v2 & v3
		active     : '', // applied when column is sorted
		hover      : '', // use custom css here - bootstrap class may not override it
		filterRow  : '', // filter row class
		filter_useParsedData : true,
		even       : '', // odd row zebra striping
		odd        : ''  // even row zebra striping
	});
	$("#erfahrungen-table").tablesorter({
		theme : "bootstrap",
		widthFixed: false,
		headerTemplate : '{content} {icon}', 
		widgets : [ "uitheme", "filter", "zebra" ],
		widgetOptions : {
			zebra : ["even", "odd"],
			filter_reset : ".reset",
			filter_useParsedData : true,
		},
		headers    : {
			0 : {
				sorter : true,
				filter : false
			},
			1 : {
				sorter : true,
				filter : false
			},
		},
	    textExtraction: {
	        0 : function(node, table, cellIndex){ return $(node).find('span.verfasst-am').text(); },
	        1 : function(node, table, cellIndex){ return $(node).find('span').text(); }
	    },
	    ignoreCase : false
	});	
	$("#sort-on-status").click(function() {
		$('#erfahrungen-table').find("th:eq(1)").trigger("sort");
		return false;
	});
	$("#sort-on-date").click(function() {
		$('#erfahrungen-table').find("th:eq(0)").trigger("sort");
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
		var erfahrungId = $(this).parent().parent().parent().parent().parent().parent().attr('id').split('-')[1];
		if($(this).hasClass('btn-danger')) {
			status = 1;
			$(this).replaceWith( 
				"<button class='btn btn-success btn-xs status-switch' type='button'>"+
					"<span class='glyphicon glyphicon-ok' title='freigescheltet'></span>"+
				"</button>" 
			); 
		} else {
			status = 0;
			$(this).replaceWith( 
				"<button class='btn btn-danger btn-xs status-switch' type='button'>"+
					"<span class='glyphicon glyphicon-remove' title='freigescheltet'></span>"+
				"</button>" 
			); 		
		}
		
    	$.ajax({ 
    		type : 'POST',
		    url : 'erfahrungsberichte/update/'+erfahrungId,
		    data : {status: status},
		    success : function (response){

		    },
		    error : function (response){

		    },
		    complete : function (){

		    }
    	});	
    	
    	$(document).on('click', '.erfahrung-delete', function(event) {
    		alert("Coming soon!!!");
    	});
	});
});