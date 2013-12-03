var pageInitialized;
$(document).ready(function() {
	if (pageInitialized) {
		return;
	}
	pageInitialized = true;
	$('label[for="ktozugriffe"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('checkbox-inline');
	$('label[for="produktHasAltersbeschraenkung"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('radio-inline');
	$('label[for="produktHasOnlineBanking"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('radio-inline');
	$('label[for="produktTipp"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('radio-inline');
	$('label[for="produktHasGesetzlEinlagvers"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('radio-inline');
	$('label[for="produktHasOnlineAbschluss"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('radio-inline');
	$('#produktInformationen').maxlength({
		alwaysShow: true,
		threshold: 10,
		warningClass: "label label-success",
		limitReachedClass: "label label-important",
		separator: ' von ',
		preText: '',
		postText: '',
		validate: true
	});
    $('#produktGueltigSeit')
//	    .wrap('<div class="input-group" id="datetimepicker" data-date-format="dd.m.yyyy"></div>')
	    .wrap('<div class="" id="datetimepicker" data-date-format="dd.m.yyyy"></div>')
	    .datetimepicker({
	    	language: 'de',
	    	format: 'dd.m.yyyy',
	    	autoclose: 'true',
	    	minView: '2'
    });
//    $('#produktGueltigSeit').parent().append('<span class="input-group-addon glyphicon glyphicon-th"></span>');
    if($('#bank').val()){
    	load_aktionen($('#bank').val());
    }
    $('#save-changes').unbind('click').click(function(event){
    	var produktId = $('.produktId').val();
    	var action = produktId == 0 ? 'insert' : '../insert/'+produktId;
    	var alertClass = 'alert-success';
    	
    	if($('#produkt-form').validationEngine('validate')){
	    	$.ajax({ 
	    		type : 'POST',
			    url : action,
			    data : $("#produkt-form").serialize(),
			    success : function (response){
			    	if(response.error) alertClass = 'alert-danger';
			    	$('#alert')
			    		.css('display', 'block')
			    		.removeClass()
			    		.addClass('alert alert-dismissable')
			    		.addClass(alertClass)
			    		.find("#alert-message").text(response.message);
			    },
			    error : function (response){
			    	$('#alert')
			    		.css('display', 'block')
			    		.removeClass()
			    		.addClass('alert alert-danger alert-dismissable')
			    		.find("#alert-message").text("Es ist ein Fehler augetretten!");
			    },
			    complete : function (){
			        $('html, body').animate({
//			            scrollTop: $("#alert").offset().top
			        	scrollTop: 0
			        }, 600);
			    }
	    	});
    	}
    });
    $('#bank').change(function(event){
    	load_aktionen($(this).val());
    });
    function load_aktionen(bankId){
    	var produktId = $('.produktId').val();
    	var action = produktId == 0 ? 'loadAktionen' : '../loadAktionen/'+produktId;
    	var alertClass = 'alert-success';
    	$.ajax({ 
    		type : 'POST',
		    url : action,
		    data : {bankId : bankId},
		    success : function (response){
		    	if(response.error){ 
		    		alertClass = 'alert-danger';
			    	$('#alert')
			    		.css('display', 'block')
			    		.removeClass()
			    		.addClass('alert alert-dismissable')
			    		.addClass(alertClass)
			    		.find("#alert-message")
			    		.text(response.message);
	    		} else {
	    			$('#aktion option').each(function() {
    			        $(this).remove();
	    			});
	    			$('#aktion')
	    				.append($('<option>', { value : '' })
						.text('--- Bitte wählen ---')); 
	    			$.each(response.aktionen, function(i, aktion) {   
	    			     $('#aktion')
	    			     	.append($('<option>', { value : aktion.aktionId })
		     				.text(aktion.aktionName)); 
	    			});
	    			if(response.aktion){
	    				$('#aktion').val(response.aktion.aktionId);
	    			} 
	    		}
		    },
		    error : function (response){
//		    	$('#alert')
//		    		.css('display', 'block')
//		    		.removeClass()
//		    		.addClass('alert alert-danger alert-dismissable')
//		    		.find("#alert-message")
//		    		.text("Es ist ein Fehler augetretten!");
		    },
		    complete : function (){}
    	});    	
    };
    
    $('#konditionen-bearbeiten').unbind('click').click(function(event){
    	$('#konditionen-bearbeiten-modal').modal('toggle');
    });
    
    $('#add-kondition').unbind('click').click(function(event){
    	$('#konditionen-table').append('<tr>');
    	var row = $('#konditionen-table tbody tr:last')
    								.append('<td>')
							    	.append('<td>')
							    	.append('<td>')
							    	.append('<td>')
							    	.append('<td>');
    	var span = $('<span />', {
    		"class" : 'glyphicon glyphicon-remove'  
    	});  
    	$('<input type="text" />').addClass('form-control kondition-laufzeit').appendTo(row.find('td').eq(0));
    	$('<input type="text" />').addClass('form-control kondition-einlage-von').appendTo(row.find('td').eq(1));    	
    	$('<input type="text" />').addClass('form-control kondition-einlage-bis').appendTo(row.find('td').eq(2));
    	$('<input type="text" />').addClass('form-control kondition-zinssatz').appendTo(row.find('td').eq(3));    
    	$('<button type="button" />').addClass('btn btn-danger remove-kondition').append(span).appendTo(row.find('td').eq(4));  
    });
    $(document).on('click', '.remove-kondition', function(e) {
    	$(this).parent().parent().remove();
	});    
});