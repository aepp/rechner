$(document).ready(function() {
    $('#produktInsert').unbind('click').click(function(event){
//    	if($('#addProductForm').validationEngine('validate')){
	    	$.ajax({ type : 'POST',
			    url : 'insert',
			    processData : { mod : '' } ,
			    success : function ( json ){
			    	alert(json.result);
			    },
			    error : function (){
		    		alert("error<br />") ;
			    },
	//		    always : function (){
	//		    	
	//		    }
	    	});
//    	}
    });
});