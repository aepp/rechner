$(document).ready(function() {
    $('#produktInsert').unbind('click').click(function(event){
    	if($('#addProductForm').validationEngine('validate')){
	    	$.ajax({ 
	    		type : 'POST',
			    url : 'insert',
			    data : $("#addProductForm").serialize(),
			    success : function (response){
			    	
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