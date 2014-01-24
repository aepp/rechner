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
	});
	$("#erfahrungen-table").tablesorter({
		theme : "bootstrap",
		widthFixed: false,
		headerTemplate : '{content} {icon}', 
		widgets : [ "uitheme", "filter" ],
		widgetOptions : {
			filter_columnFilters: false,
			filter_reset : ".reset",
			filter_useParsedData : true,
			filter_startsWith : true,
		},
		headers    : {
			0 : {
				sorter : true,
				filter : true
			},
			1 : {
				sorter : true,
				filter : true
			},
			2 : {
				sorter : true,
				filter : true
			},
			3 : {
				sorter : true,
				filter : true
			},
		},
	    textExtraction: {
	    	0 : function(node, table, cellIndex){ return $(node).find('span').text(); },
	        1 : function(node, table, cellIndex){ return $(node).find('span.verfasst-am').text(); },
	        2 : function(node, table, cellIndex){ return $(node).find('span').text(); },
	        3 : function(node, table, cellIndex){ return $(node).find('span').text(); }
	    },
	    ignoreCase : false
	});	

	$('#bank-filter').unbind('change').change(function(event){
	    var columns = [];
	    columns[0] = $(this).val();
	    $('#erfahrungen-table').trigger('search', [ columns ]);		
	});
	$('#status-filter').unbind('change').change(function(event){
	    var columns = [];
	    columns[3] = $(this).val();
	    $('#erfahrungen-table').trigger('search', [ columns ]);		
	});	
	$('#note-filter').unbind('change').change(function(event){
	    var columns = [];
	    columns[2] = $(this).val();
	    $('#erfahrungen-table').trigger('search', [ columns ]);		
	});	
	$('#datum-filter').unbind('change').change(function(event){
	    var columns = [];
	    columns[1] = $(this).val();
	    $('#erfahrungen-table').trigger('search', [ columns ]);		
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
		var erfahrungId = $(this).parent().parent().parent().parent().parent().parent().parent().parent().attr('id').split('-')[1];
		var replace_with = null;
		var current_status = $(this);
		
		if(current_status.hasClass('btn-danger')) {
			status = 1;
			replace_with = 
				"<button class='btn btn-success btn-xs status-switch' type='button'>"+
					"<span class='glyphicon glyphicon-ok' title='freigescheltet'></span>"+
				"</button>" 
			; 
		} else {
			status = 0;
			replace_with =  
				"<button class='btn btn-danger btn-xs status-switch' type='button'>"+
					"<span class='glyphicon glyphicon-remove' title='freigescheltet'></span>"+
				"</button>" 
			; 		
		}
		
    	$.ajax({ 
    		type : 'POST',
		    url : 'erfahrungsberichte/update/'+erfahrungId,
		    data : {status: status},
		    success : function (response){
		    	current_status.replaceWith(replace_with); 
		    },
		    error : function (response){

		    },
		    complete : function (){

		    }
    	});	
    	
    	$('.erfahrung-delete').unbind('click').click(function(event){
    		alert("Coming soon!!!");
    	});
	});
});