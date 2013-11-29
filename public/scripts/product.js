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
    	alert($(this).val());
    });
});