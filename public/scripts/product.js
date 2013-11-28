$(document).ready(function() {
    $('#save-changes').unbind('click').click(function(event){
    	var produktId = $('.produktId').val();
    	var action = produktId == 0 ? 'insert' : '../insert/'+produktId;
    	if($('#produkt-form').validationEngine('validate')){
	    	$.ajax({ 
	    		type : 'POST',
			    url : action,
			    data : $("#produkt-form").serialize(),
			    success : function (response){
			    	$('#alert')
			    		.css('display', 'block')
			    		.removeClass()
			    		.addClass('alert alert-success alert-dismissable')
			    		.find("#alert-message").text("Änderungen gespeichert!");
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
});