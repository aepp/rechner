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
    $('#produkt-form').find(':input').each(function(i, elem) {
        var input = $(elem);
//        alert(input.attr('name') + " " + input.prop('checked'));
        var state = input.prop('checked');
//        alert(input.attr('name') + " " + state);
        input.data({
        	'initialValue' : input.val(),
        	'initialState' : state
        });
   });
//    $('#produktGueltigSeit').parent().append('<span class="input-group-addon glyphicon glyphicon-th"></span>');
    if($('#bank').val()){
    	load_aktionen($('#bank').val());
    }
    $('#save-changes').unbind('click').click(function(event){
    	var produktId = $('.produktId').val();
    	var action = "";
    	var modus = $('#modus').val();
    	switch(modus){
	    	case 'edit':
	    		action = '../insert/'+produktId;
	    		break;
	    	case 'create':
	    		action = produktId == 0 ? 'insert' : 'insert/'+produktId; 
	    		break;
    	};
    	var alertClass = 'alert-success';
    	
    	if($('#produkt-form').validationEngine('validate')){
	    	$.ajax({ 
	    		type : 'POST',
			    url : action,
			    data : $("#produkt-form").serialize(),
			    success : function (response){
			    	if(!response.error) window.location = response.redirect;
			    	if(response.error) alertClass = 'alert-danger';
			    	$('#alert')
			    		.css('display', 'block')
			    		.removeClass()
			    		.addClass('alert alert-dismissable')
			    		.addClass(alertClass)
			    		.find("#alert-message").text(response.message);
			    	$('.produktId').val(response.produktId);
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
    	var action = "";
    	var modus = $('#modus').val();
    	switch(modus){
	    	case 'edit':
	    		action = '../loadAktionen/'+produktId;
	    		break;
	    	case 'create':
	    		action = produktId == 0 ? 'loadAktionen' : 'loadAktionen/'+produktId; 
	    		break;
    	};
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
	    				if($('#aktion option[value="' + response.aktion.aktionId + '"]').length > 0) 
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
    	var produktId = $('.produktId').val();
    	$('#konditionen-bearbeiten-modal').modal('toggle');
    	$('#alert-modal').css('display', 'none');
    	$('#konditionen-modal-form .has-error').each(function(i, div){
        	var cnt = $(div).contents();
        	$(div).replaceWith(cnt);
    	});
    	
    	var message = "Es ist ein Fehler augetretten!";
    	if($('#konditionen-table tbody tr').length == 0){
        	var action = "";
        	var modus = $('#modus').val();
        	switch(modus){
    	    	case 'edit':
    	    		action = '../loadKonditionen/'+produktId;
    	    		break;
    	    	case 'create':
    	    		action = produktId == 0 ? null : 'loadKonditionen/'+produktId; 
    	    		break;
        	};
	    	if(action != null){
		    	$.ajax({ 
		    		type : 'POST',
				    url : action,
				    success : function (response){
				    	if(response.error){ 
				    		alertClass = 'alert-danger';
			    		} else {
			    			var row;
			    			$.each(response.konditionen, function(i, kondition) { 
			    	        	$('#konditionen-table').append('<tr>');
			    	        	row = $('#konditionen-table tbody tr:last')
			    	        								.append('<td>')
			    	    							    	.append('<td>')
			    	    							    	.append('<td>')
			    	    							    	.append('<td>')
			    	    							    	.append('<td>');
			    	        	var span = $('<span />', {
			    	        		"class" : 'glyphicon glyphicon-remove'  
			    	        	});  
			    	        	$('<input type="text" />').addClass('form-control kondition-laufzeit kondition-input').val(kondition.konditionLaufzeit).appendTo(row.find('td').eq(0));
			    	        	$('<input type="text" />').addClass('form-control kondition-einlage-von kondition-input').val(kondition.konditionEinlageVon.toString().replace('.', ',')).appendTo(row.find('td').eq(1));    	
			    	        	$('<input type="text" />').addClass('form-control kondition-einlage-bis kondition-input').val(kondition.konditionEinlageBis.toString().replace('.', ',')).appendTo(row.find('td').eq(2));
			    	        	$('<input type="text" />').addClass('form-control kondition-zinssatz kondition-input').val(kondition.konditionZinssatz.toString().replace('.', ',')).appendTo(row.find('td').eq(3));    
			    	        	$('<button type="button" />').addClass('btn btn-danger remove-kondition').append(span).appendTo(row.find('td').eq(4));  		    				
			    			});
			    		}
				    	message = response.message;
				    },
				    error : function (response){
				    	alertClass = 'alert-danger';
				    	$('#alert-modal')
				    		.css('display', 'block')
				    		.removeClass()
				    		.addClass('alert alert-dismissable')
				    		.addClass(alertClass)
				    		.find("#alert-modal-message")
				    		.text(message);
				    }, 
				    complete : function(){
				    	$('.progress').hide();
//				    	if($('#konditionen-table tbody tr').length == 0){
//				    		add_empty_kondition_row();
//				    	}
				    }
		    	});  
	    	} else {
	    		$('.progress').hide();
//    			add_empty_kondition_row();
	    	}
    	}
    });
    
    $('#add-kondition').unbind('click').click(function(event){
    	add_empty_kondition_row();
    });
    $(document).on('click', '.remove-kondition', function(e) {
    	$($(this).parent().parent().find('td input')).each(function(i, input){
    		if($(input).val()) {
    			inputChanged = true;
    		}
    	});
    	$(this).parent().parent().remove();
	});    
    
    var inputChanged = false;
    $('#save-konditionen').unbind('click').click(function(event){
    	var konditionen = new Array();
        
    	$('#konditionen-table tbody tr').each(function(i, tr){
    		konditionen[i]={
    	        "laufzeit" : $(tr).find('.kondition-laufzeit').val(), 
    	        "von" :$(tr).find('.kondition-einlage-von').val(),
    	        "bis" : $(tr).find('.kondition-einlage-bis').val(),
    	        "zinssatz" : $(tr).find('.kondition-zinssatz').val(),
    	    };
    	});  
    	
    	var produktId = $('.produktId').val();
    	var action = "";
    	var modus = $('#modus').val();
    	switch(modus){
	    	case 'edit':
	    		action = produktId == 0 ? 'saveKonditionen' : '../saveKonditionen/'+produktId; 
	    		break;
	    	case 'create':
	    		action = produktId == 0 ? 'saveKonditionen' : 'saveKonditionen/'+produktId; 
	    		break;
    	};
    	var alertClass = 'alert-success';
    	var message = "Es ist ein Fehler augetretten!";
    	var validation = true;
    	
    	$('#konditionen-modal-form input').each(function(i, input){
    		if(!$(input).val() && $(input).attr('type') != 'hidden') {
    			$(input).wrap($('<div>').addClass('has-error'));
    			validation = false;
    		}
    	});
    	if(validation){
    		if(inputChanged){
		    	$.ajax({ 
		    		type : 'POST',
				    url : action,
				    data : {konditionen : JSON.stringify(konditionen)},
				    success : function (response){
				    	if(response.error){ 
				    		alertClass = 'alert-danger';
			    		}
				    	message = response.message;
				    	inputChanged = false;
				    },
				    error : function (response){
				    	alertClass = 'alert-danger';
				    },
				    complete : function (){
				    	$('#alert-modal')
				    		.css('display', 'block')
				    		.removeClass()
				    		.addClass('alert alert-dismissable')
				    		.addClass(alertClass)
				    		.find("#alert-modal-message")
				    		.text(message);
				    }
		    	});   
    		} else {
        		alertClass = 'alert-info';
        		message = 'Es gibt nichts zu speichern.';
    	    	$('#alert-modal')
    	    		.css('display', 'block')
    	    		.removeClass()
    	    		.addClass('alert alert-dismissable')
    	    		.addClass(alertClass)
    	    		.find("#alert-modal-message")
    	    		.text(message);
    		}
    	} else {
    		alertClass = 'alert-danger';
    		message = 'Die markierten Felder müssen gefüllt sein!';
	    	$('#alert-modal')
	    		.css('display', 'block')
	    		.removeClass()
	    		.addClass('alert alert-dismissable')
	    		.addClass(alertClass)
	    		.find("#alert-modal-message")
	    		.text(message);
    	}
    });
    $(document).on('input', '.kondition-input', function(e) {
    	inputChanged = true;
	});  
    function add_empty_kondition_row(){
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
    	$('<input type="text" />').addClass('form-control kondition-laufzeit kondition-input').appendTo(row.find('td').eq(0));
    	$('<input type="text" />').addClass('form-control kondition-einlage-von kondition-input').appendTo(row.find('td').eq(1));    	
    	$('<input type="text" />').addClass('form-control kondition-einlage-bis kondition-input').appendTo(row.find('td').eq(2));
    	$('<input type="text" />').addClass('form-control kondition-zinssatz kondition-input').appendTo(row.find('td').eq(3));    
    	$('<button type="button" />').addClass('btn btn-danger remove-kondition').append(span).appendTo(row.find('td').eq(4));  
    }
    function restore() {
        $('#produkt-form').find(':input').each(function(i, elem) {
             var input = $(elem);
             input.val(input.data('initialValue'));
        	 input.prop("checked", input.data('initialState'));
        });
    }
    $('#discard-changes').unbind('click').click(function(event){
    	restore();
    });
});