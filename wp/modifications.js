/* Place all your JavaScript modifications below */

$(document).ready(function(){
	
	/* Validation */
    $("#geld-anlegen-form").validationEngine('attach');
    $("#kredit-aufnehmen-form").validationEngine('attach');

	/* Tooltipster */
	$('.tooltip').tooltipster();
    
	/* Range-Slider Tagesgeld Betrag*/
	$("#slider-price").slider({
		range: "min",
		value: 10000,
		min: 1000,
		max: 150000,
		slide: function( event, ui ) {
			$("#price").val(ui.value +  " Euro");
		}
	});

	/* Range-Slider Zeit Tagesgeld*/
	$("#slider-time").slider({
		range: "min",
		value: 3,
		min: 1,
		max: 12,
		slide: function( event, ui ) {
			$("#time").val(ui.value +  " Monate");
		}
	});

	/* Brands-Slider*/
	$.brandsBox.embed("#brandsbox_container", {
		"collection": "collection.xml",
		"cols": 6,
		"rows": 1,
		"scrollingDelay": 2000,
		"startOpacity": 1,
		"hoverOpacity": 1
	});		

	switch($('#anlageziel').val()){
		case '0':
			$('#g1-button-1').attr('href', 'tagesgeld-vergleich');
			break;
		case '1':
			$('#g1-button-1').attr('href', 'festgeld-vergleich');
			break;
		case '2':
			$('#g1-button-1').attr('href', 'laufender-sparplan');
			break;
	};
	
	$('#anlageziel').unbind('change').change(function(event){
		var next_page = $(this).val();
		//alert(page);
    	switch(next_page){
	    	case '0':
	    		$('#g1-button-1').attr('href', 'tagesgeld-vergleich?vari=test');
	    		break;
	    	case '1':
	    		$('#g1-button-1').attr('href', 'festgeld-vergleich?vari=test');
	    		break;
			case '2':
	    		$('#g1-button-1').attr('href', 'laufender-sparplan?vari=test');
	    		break;
    	};
	});
	$('#g1-button-1').unbind('click').click(function(event){
		$('#geld-anlegen-form').submit();
	});
});