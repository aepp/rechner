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
	$("#produkte-table").tablesorter({
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
				sorter : false,
				filter : false
			},
			4 : {
				sorter : false,
				filter : false
			},
			5 : {
				sorter : false,
				filter : false
			} 
		},
	    textExtraction: {
	        1 : function(node, table, cellIndex){ return $(node).find("span").html(); },
	    }
	})	
	.tablesorterPager({
		container: $(".ts-pager"),
		cssGoto  : ".pagenum",
		removeRows: false,
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
	});
	
	$('.delete-produkt-button').unbind('click').click(function(event){
		var produktId = $(this).parent().find('.produktId').val();
    	$.ajax({ 
    		type : 'POST',
		    url : 'delete',
		    data : {produktId : produktId},
		    success : function (response){
		    	
		    },
		    error : function (response){
	    		alert("Error occcured") ;
		    },
		    always : function (){
		    	
		    }
    	});
	});
});  	
