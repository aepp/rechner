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
			6 : {
				sorter : false,
				filter : false
			},
		},
	    textExtraction: {
	        1 : function(node, table, cellIndex){ return $(node).find('span').text(); },
	        4 : function(node, table, cellIndex){ return $(node).find('span').find('span').attr('class'); },
	        5 : function(node, table, cellIndex){ return $(node).find('span').find('span').attr('class'); },
	    },
	    ignoreCase : false
	});	
//	.tablesorterPager({
//		container: $(".ts-pager"),
//		cssGoto  : ".pagenum",
//		removeRows: false,
//		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
//	});
	
	$('.delete-produkt-button').unbind('click').click(function(event){
		$('#delete-confirm-modal').modal('toggle');
		var id = $(this).parent().find('.produktId').val();
		$('#delete-produkt-id').val(id);
		$('#delete-produkt-name').html($('#produkt-name-'+id).text());
		$('#delete-produkt-bank').html($('#produkt-bank-name-'+id).text());
		$('#delete-produkt-kategorie').html($('#produkt-kategorie-'+id).text());
	});
	
	$('#delete-confirm').unbind('click').click(function(event){
		var id = $('#delete-produkt-id').val();
		var tableRow = $('#produkt-table-row-'+id);
		
    	$.ajax({ 
    		type : 'POST',
		    url : 'produkt/delete/'+id,
		    data : {produktId : id},
		    success : function (response){
		    	tableRow.remove();
		    	$("#produkte-table").trigger("update");
		    	$('#delete-confirm-modal').modal('toggle');
		    	$('#alert')
		    			.css('display', 'block')
		    			.removeClass()
		    			.addClass('alert alert-success')
		    			.find("#alert-message").text("Produkt erfolgreich gelöscht!");
		    },
		    error : function (response){
		    	$('#alert')
	    			.css('display', 'block')
	    			.removeClass()
	    			.addClass('alert alert-warning')
	    			.find("#alert-message").text("Es ist ein Fehler afgetretten!");
		    },
		    complete : function (){
		        $('html, body').animate({
//		            scrollTop: $("#alert").offset().top
		        	scrollTop: 0
		        }, 600);		    	
		    }
    	});		
	});
});  	
