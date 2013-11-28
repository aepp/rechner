$(document).ready(function() {
    $('#save-changes').unbind('click').click(function(event){
    	var produktId = $('.produktId').val();
    	if($('#addProductForm').validationEngine('validate')){
	    	$.ajax({ 
	    		type : 'POST',
			    url : '../insert/'+produktId,
			    data : $("#addProductForm").serialize(),
			    success : function (response){
			    	alert("Änderungen gespeichert!") ;
			    },
			    error : function (response){
		    		alert("Error occcured") ;
			    },
			    always : function (){
			    	
			    }
	    	});
    	}
    });
});