/*
 * Ein Flag der das doppelte Laden der FUnktionen verhindert
 */
var pageInitialized;
/*
 * Speichert die DB-Werte der Konditionen
 */
var konditionen_backup;

$(document).ready(function() {
	if (pageInitialized) {
		return;
	}
	pageInitialized = true;
	$('label[for="produktTipp"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('radio-inline');
	
	$('label[for="produktIsBonitabh"]').parent().find('div.col-sm-3').find('label').removeClass().addClass('radio-inline');
	
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
	
	/*
	 * Das Input-Feld in ein Datepicker umwandeln
	 */
    $('#produktGueltigSeit')
	    .wrap('<div class="input-group date"></div>');
    $('#produktGueltigSeit').parent().append(
    	    '<span class="input-group-btn">'+
    	    	'<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-calendar"></i></button>'+
        	'</span>'
	);
    $('.input-group.date')
//	    .wrap('<div class="" id="datetimepicker" data-date-format="dd.m.yyyy"></div>')
	    .datetimepicker({
	    	language: 'de',
	    	pickTime: false,
    });
    
    /*
     * Anfangswerte der Input-Felder sichern
     */
    $('#produkt-form').find(':input').each(function(i, elem) {
        var input = $(elem);
        var state = input.prop('checked');
        input.data({
        	'initialValue' : input.val(),
        	'initialState' : state
        });
   });
    
    /*
     * Wenn ein Bank vorausgewählt ist (z. B. beim Beiarbeiten eines
     * existierenden Produkts), die Aktionen für diese Bank laden
     */
    if($('#bank').val()){
    	load_aktionen($('#bank').val());
    }
    
    /*
     * Produkt in der DB speichern
     */
    $('#save-changes').unbind('click').click(function(event){
    	/*
    	 * TODO: Speichern nur wenn sich etwas geändert hat, sonst Meldung ausgeben
    	 */
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
			    	if(!response.error) window.location = response.redirect;	/* Redirect zur Übersicht bei Erfolg */
			    	else alertClass = 'alert-danger';
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
			        	scrollTop: 0
			        }, 600);
			    }
	    	});
    	}
    });
    
    /*
     * Aktionen laden, wenn ein neuer Bank ausgewählt wurde
     */
    $('#bank').change(function(event){
    	load_aktionen($(this).val());
    });
    
    /*
     * Aktionen für die ausgewählte Bank laden
     */
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
		    }
    	});    	
    };
    
    /*
     * Modal-Dialog zum Bearbeiten der Konditionen öffnen
     */
    $('#konditionen-bearbeiten').unbind('click').click(function(event){
    	$('#konditionen-bearbeiten-modal').modal('toggle');
    	load_konditionen();
    });
    
    /*
     * Konditionanen aus der DB laden
     */
    function load_konditionen(){
    	var produktId = $('.produktId').val();
    	
    	$('#alert-modal').css('display', 'none');
    	$('#konditionen-modal-form .has-error').each(function(i, div){
        	var cnt = $(div).contents();
        	$(div).replaceWith(cnt);
    	});
    	
    	/*
    	 * Setze Bonitätsanh.-Radio im Modal-Dialog
    	 */
    	var bonitabh = $("input:radio[name ='produktIsBonitabh']:checked");
		$('input[name="produktIsBonitabh-helper"]').each(function(){
			if($(this).val() == bonitabh.val()) $(this).prop('checked', bonitabh.prop('checked'));
		});
		
		if(!bonitabh.val()){
			$('.progress').hide();
			return;
		}
		
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
				    async : false,
				    success : function (response){
				    	if(response.error){ 
				    		alertClass = 'alert-danger';
			    		} else {
			    			if(response.empty) build_konditionen_table(true, bonitabh.val());
			    			else {
			    				build_konditionen_table(
				    					false, 
				    					bonitabh.val(),
				    					$.parseJSON(response.laufzeiten), 
				    					$.parseJSON(response.risikoklassen), 
				    					$.parseJSON(response.zinssaetze),
		    							$.parseJSON(response.leads),
		    							$.parseJSON(response.sales)
								);
			    			}
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
				    }
		    	});  
	    	} else {
	    		build_konditionen_table(true, bonitabh.val());
	    		$('.progress').hide();
	    	}
    	} else {
    		$('.progress').hide();
    	}   	
    }
    
    function build_konditionen_table(init, bonitabh, laufzeiten, risikoklassen, zinssaetze, leads, sales){
    	var zinssatz = '';
    	var lead = '';
    	var sale = '';
    	
    	if(init){
    		laufzeiten = [12, 18, 24, 36, 48, 60, 72, 84];
    		if(bonitabh == 1) risikoklassen = [1, 2, 3, 4, 5, 6];
    		else risikoklassen = [1];
    	}
    	
		var table = 
			'<table class="table table-hover table-condensed" id="konditionen-table">'+
				'<thead>'+
					'<tr class="active">'+
						'<th colspan="3"></th>'+
						'<th colspan="'+ laufzeiten.length +'">Laufzeit in Monaten</th>'+
					'</tr>'+
					'<tr class="active">'+
						'<th colspan="3"></th>';
		for(var i = 0; i < laufzeiten.length; i++){
			table +=
						'<th>'+
							'<button type="button" class="btn btn-xs btn-success add-laufzeit pull-left">'+
								'<span class="glyphicon glyphicon-plus"></span>'+
							'</button>'+	
							'<button type="button" class="btn btn-xs btn-danger remove-laufzeit pull-right">'+
								'<span class="glyphicon glyphicon-remove"></span>'+
							'</button>'+								
						'</th>';
		}
		table +=
					'</tr>'+		
					'<tr class="active">'+
						'<th colspan="3">Risikoklasse</th>';
		
		$.each(laufzeiten,function(i, laufzeit){
			table +=
						'<th><input type="text" class="form-control kondition-laufzeit kondition-input input-sm" value="'+laufzeit+'"/></th>';
		});
		table +=
					'</tr>'+
				'</thead>'+
				'<tbody>';
		$.each(risikoklassen,function(i, risikoklasse){
			table +=
					'<tr>'+
						'<td class="active">'+
							'<button type="button" class="btn btn-xs btn-success add-risikoklasse">'+
								'<span class="glyphicon glyphicon-plus"></span>'+
							'</button>'+
						'</td>'+
						'<td class="active">'+
							'<button type="button" class="btn btn-xs btn-danger remove-risikoklasse">'+
								'<span class="glyphicon glyphicon-remove"></span>'+
							'</button>'+
						'</td>'+									
						'<td class="active"><input type="text" class="form-control kondition-risikoklasse kondition-input input-sm" value="'+risikoklasse+'"/></td>';
			$.each(laufzeiten,function(j, laufzeit){
				if(!init) zinssatz = zinssaetze[risikoklasse][laufzeit].toString().replace('.', ',');
				table +=
						'<td><input type="text" class="form-control kondition-zinssatz kondition-input input-sm" value="'+zinssatz+'"/></td>';
			});
			table +=
					'</tr>';								
		});
		table +=
				'</tbody>'+
				'<tfoot>'+
					'<tr class="active">'+
						'<th colspan="3">Provision in  € (Lead)</th>';
		$.each(laufzeiten,function(i, laufzeit){
			if(!init) lead = leads[laufzeit];
			table +=
						'<th><input type="text" class="form-control kondition-lead kondition-input input-sm" value="'+lead+'"/></th>';
		});
		table +=
					'</tr>'+
					'<tr class="active">'+
						'<th colspan="3">Provision in  % v.d. Kreditsumme (Sales)</th>';
		$.each(laufzeiten,function(i, laufzeit){
			if(!init) sale = sales[laufzeit];
			table +=
						'<th><input type="text" class="form-control kondition-sale kondition-input input-sm" value="'+sale+'"/></th>';
		});
		table +=
					'</tr>'+								
				'</tfoot>'+
			'</table>';    
		$('.table-responsive').html(table);
    }
    
    /*
     * Beim Ändern der Bonitätsabhängigkeit die bestehenden 
     * Konditionen zwischenspeichern
     */
    $(document).on('change', 'input[name ="produktIsBonitabh"]', function(event) {
    	
    	/*
    	 * Setze Bonitätsanh.-Radio im Modal-Dialog
    	 */
    	var bonitabh = $("input:radio[name ='produktIsBonitabh']:checked");
		$('input[name="produktIsBonitabh-helper"]').each(function(){
			if($(this).val() == bonitabh.val()) $(this).prop('checked', bonitabh.prop('checked'));
		});
		
    	if($('#konditionen-table').length == 0) load_konditionen();
    	var currentValueName = 'Value_'+ ($(this).val() == 0 ? 1 : 0);
    	var newValueName = 'Value_'+ $(this).val();
    	$('.table-responsive').data[currentValueName] = $('.table-responsive').html();

//        	$('.table-responsive').html('Wait...');
    	
    	if($('.table-responsive').data[newValueName]) $('.table-responsive').html($('.table-responsive').data[newValueName]);
    	else build_konditionen_table(true, $(this).val());
    });
    
    $(document).on('change', 'input[name ="produktIsBonitabh-helper"]', function(event) {
    	/*
    	 * Setze Bonitätsanh.-Radio in Produkt-Form
    	 */
    	var bonitabh = $("input:radio[name ='produktIsBonitabh-helper']:checked");
		$('input[name="produktIsBonitabh"]').each(function(){
			if($(this).val() == bonitabh.val()) $(this).prop('checked', bonitabh.prop('checked'));
		});
		
		if(!bonitabh.val()){
			$('.progress').hide();
			return;
		}
    	var currentValueName = 'Value_'+ ($(this).val() == 0 ? 1 : 0);
    	var newValueName = 'Value_'+ $(this).val();
    	$('.table-responsive').data[currentValueName] = $('.table-responsive').html();
    	
    	if($('.table-responsive').data[newValueName]) $('.table-responsive').html($('.table-responsive').data[newValueName]);
    	else build_konditionen_table(true, $(this).val());
    });
    
    /*
     * Ein Flag, das angibt ob sich der Inhalt
     * eines Input-Feldes geändert hat
     */
    var inputChanged = false;
    
    /*
     * Speichern der Konditionen in der DB 
     */
    $('#save-konditionen').unbind('click').click(function(event){
    	var konditionen = new Array();
        
    	var n = 0;
    	$('#konditionen-table tbody tr').each(function(i, row){
    		$('#konditionen-table thead th input').each(function(j, laufzeit){
    			var colIndex = parseInt($(laufzeit).parent().index());
	    		konditionen[n]={
	    	        "laufzeit" : $(laufzeit).val(), 
	    	        "risikoklasse" :$(row).find('.kondition-risikoklasse').val(),
	    	        "zinssatz" : $(row).find('.kondition-zinssatz').eq(colIndex-1).val(),
	    	        "lead" : $('#konditionen-table').find('.kondition-lead').eq(colIndex-1).val(),
	    	        "sale" : $('#konditionen-table').find('.kondition-sale').eq(colIndex-1).val()
	    	    };
	    		n++;
    		});
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
				    data : {
				    	konditionen : JSON.stringify(konditionen), 
				    	produktIsBonitabh : $("input:radio[name ='produktIsBonitabh-helper']:checked").val()
			    	},
				    success : function (response){
				    	if(response.error){ 
				    		alertClass = 'alert-danger';
			    		}
				    	message = response.message;
				    	inputChanged = false;
				    	/*
				    	 * Setze Bonitätsabh.-Radio in Produkt-Form
				    	 */
				    	var bonitabh = $("input:radio[name ='produktIsBonitabh-helper']:checked");
						$('input[name="produktIsBonitabh"]').each(function(){
							if($(this).val() == bonitabh.val()) $(this).prop('checked', bonitabh.prop('checked'));
						});
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
    
    /*
     * Setzt ein Flag auf true, wenn sich 
     * der Wert eines Input-Felds geändert hat
     */
    $(document).on('input', '.kondition-input', function(e) {
    	$(this).attr("value", $(this).val());
    	inputChanged = true;
    	/*
    	 * TODO: Anfangswerte der neuen Felder speichern
    	 */
//    	if($(this).get(0).defaultValue.trim()) 
//    	alert($(this).data('initialValue'));
	});  
    
    /*
     * Neue Laufzeit hinzufügen
     */
    $(document).on('click', '.add-laufzeit', function() {
    	var button = $(this); 
    	var colIndex = button.parent().index();
    	var laufzeitHeading = $('#konditionen-table thead').find('tr').eq(0).find('th').eq(1);
    	var colspan = laufzeitHeading.attr('colspan');
    	if(colspan == 1){
    		$('#konditionen-table thead').find('tr').eq(1).find('.remove-laufzeit').removeAttr('disabled');
    	}
    	laufzeitHeading.attr('colspan', parseInt(colspan)+1);
    	
    	var thButtons = 
			'<th>'+
				'<button type="button" class="btn btn-xs btn-success add-laufzeit pull-left">'+
					'<span class="glyphicon glyphicon-plus"></span>'+
				'</button>'+
				'<button type="button" class="btn btn-xs btn-danger remove-laufzeit pull-right">'+
					'<span class="glyphicon glyphicon-remove"></span>'+
				'</button>'+								
			'</th>';
    	var thLaufzeit = 
    		'<th>'+
    			'<input type="text" class="form-control kondition-laufzeit kondition-input input-sm"/>'+  
			'</th>';    	
    	var tdZinssatz = 
    		'<td>'+
    			'<input type="text" class="form-control kondition-zinssatz kondition-input input-sm"/>'+  
			'</td>';
    	var thLead = 
    		'<th>'+
    			'<input type="text" class="form-control kondition-lead kondition-input input-sm"/>'+  
			'</th>';  
    	var thSale = 
    		'<th>'+
    			'<input type="text" class="form-control kondition-sale kondition-input input-sm"/>'+  
			'</th>';    	
    	var thead = ({
    		1: thButtons,
    		2: thLaufzeit
    	});
    	var tfoot = ({
    		0: thLead,
    		1: thSale
    	});
    	$('#konditionen-table thead').find('tr').each(function(i, tr) {
    		if(i != 0) $(tr).find('th').eq(colIndex).after(thead[i]);
        });
        $('#konditionen-table tfoot').find('tr').each(function(i, tr) {
            $(tr).find('th').eq(colIndex).after(tfoot[i]);
        });
        $('#konditionen-table tbody').find('tr').each(function(i, tr) {
            $(tr).find('td').eq(colIndex+2).after(tdZinssatz);
        });
    	/*
    	 * TODO: Anfangswerte der neuen Felder speichern
    	 */
    });
    
    /*
     * Eine Laufzeit löschen
     */
    $(document).on('click', '.remove-laufzeit', function(e) {
    	var button = $(this); 
    	var colIndex = button.parent().index();
    	var laufzeitHeading = $('#konditionen-table thead').find('tr').eq(0).find('th').eq(1);
    	var colspanOld = laufzeitHeading.attr('colspan');
    	if(colspanOld == 1) return;
    	var colspanNew = parseInt(colspanOld)-1;
    	if(colspanNew == 1){
    		$('#konditionen-table thead').find('tr').eq(1).find('.remove-laufzeit').attr('disabled', 'disabled');
    	}
    	laufzeitHeading.attr('colspan', colspanNew);
    	
    	$('#konditionen-table thead').find('tr').each(function(i, tr) {
    		if($(tr).find('th').eq(colIndex).find('input').val()) inputChanged = true;
    		if(i != 0) $(tr).find('th').eq(colIndex).remove();
        });
        $('#konditionen-table tfoot').find('tr').each(function(i, tr) {
        	if($(tr).find('th').eq(colIndex).find('input').val()) inputChanged = true;
            $(tr).find('th').eq(colIndex).remove();
        });
        $('#konditionen-table tbody').find('tr').each(function(i, tr) {
        	if($(tr).find('td').eq(colIndex+2).find('input').val()) inputChanged = true;
            $(tr).find('td').eq(colIndex+2).remove();
        }); 
	}); 

    /*
     * Neue Risikoklasse hinzufügen
     */
    $(document).on('click', '.add-risikoklasse', function(e) {
    	var button = $(this); 
    	var tr = button.parent().parent();
    	var rowIndex = tr.index();
    	
    	var laufzeitHeading = $('#konditionen-table thead').find('tr').eq(0).find('th').eq(1);
    	var columnsCount = laufzeitHeading.attr('colspan');
    	alert(columnsCount);
    	tr.after(
			'<tr>'+
				'<td class="active">'+
					'<button class="btn btn-xs btn-success add-risikoklasse" type="button">'+
						'<span class="glyphicon glyphicon-plus"></span>'+
					'</button>'+		
				'</td>'+
				'<td class="active">'+
					'<button class="btn btn-xs btn-danger remove-risikoklasse" type="button">'+
						'<span class="glyphicon glyphicon-remove"></span>'+
					'</button>'+		
				'</td>'+	
				'<td class="active">'+
					'<input class="form-control kondition-risikoklasse kondition-input input-sm" type="text">'+
				'</td>'+					
			'</tr>'
		);
    	
    	var newRow = $('#konditionen-table tbody').find('tr').eq(parseInt(rowIndex)+1);
    	for(var i = 0; i < columnsCount; i++){
    		newRow.append(
				'<td>'+
					'<input class="form-control kondition-zinssatz kondition-input input-sm" type="text">'+
				'</td>'
    		);
    	}
    	/*
    	 * TODO: Anfangswerte der neuen Felder speichern
    	 */
    });
    
    /*
     * Eine Risikoklasse löschen
     */
    $(document).on('click', '.remove-risikoklasse', function(e) {
    	$($(this).parent().parent().find('td input')).each(function(i, input){
    		if($(input).val()) {
    			inputChanged = true;
    		}
    	});
    	$(this).parent().parent().remove();
    });  
    
    /*
     * Setzt die Input-Felder auf ihre Anfangswerte zurück
     */
    function restore() {
        $('#produkt-form').find(':input').each(function(i, elem) {
             var input = $(elem);
             input.val(input.data('initialValue'));
        	 input.prop("checked", input.data('initialState'));
        });
    }
    
    /*
     * Input-Felder zurücksetzen
     */
    $('#discard-changes').unbind('click').click(function(event){
    	restore();
    });
    
    $(document).on('click', '#fill', function() {
    	$('#konditionen-table').find('input.kondition-zinssatz').each(function(i, elem) {
    		$(elem).attr("value", i+1.3);
    	});
    	$('#konditionen-table tfoot').find('input').each(function(i, elem) {
    		$(elem).attr("value", i);
    	});
    	inputChanged = true;
    });
    
    $(document).on('click', '#fill-produkt', function() {
    	$('#produkt-form').find('input[type="text"]').each(function(i, elem) {
    		$(elem).attr("value", i);
    	});
    	$('#produkt-form').find('textarea').each(function(i, elem) {
    		$(elem).attr("value", i+1.3);
    	});    
    	$('#produkt-form').find('select').each(function(i, elem) {
    		$(elem).val($(elem).find('option').eq(1).val());
    	});   
    	$('#produktGueltigSeit').val('12.12.2013');
    	$('#kategorie').val(2);
    	
    	inputChanged = true;
    });
});