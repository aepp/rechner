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
	$('label[for="produktTipp"]').parent().find('div.col-sm-8').find('label').removeClass().addClass('btn btn-default');
	$('label[for="produktTipp"]').parent().find('div.col-sm-8').attr('data-toggle', 'buttons');
	$('label[for="produktTipp"]').parent().find('div.col-sm-8').addClass('btn-group');
	
//	$('label[for="produktIsBonitabh"]').parent().css('display', 'none');
	$('label[for="produktIsBonitabh"]').parent().find('div.col-sm-8').find('label').removeClass().addClass('btn btn-default');
	$('label[for="produktIsBonitabh"]').parent().find('div.col-sm-8').attr('data-toggle', 'buttons');
	$('label[for="produktIsBonitabh"]').parent().find('div.col-sm-8').addClass('btn-group');
	
	$('label[for="produktHasOnlineAbschluss"]').parent().find('div.col-sm-8').find('label').removeClass().addClass('btn btn-default');
	$('label[for="produktHasOnlineAbschluss"]').parent().find('div.col-sm-8').attr('id', 'produktHasOnlineAbschluss');
	$('label[for="produktHasOnlineAbschluss"]').parent().find('div.col-sm-8').attr('data-toggle', 'buttons');
	$('label[for="produktHasOnlineAbschluss"]').parent().find('div.col-sm-8').addClass('btn-group');
	
	$('.btn').button();
	$('input:checked').each(function(i, radio){
		$(radio).parent().button('toggle');
	});

	$('body').scrollspy({ 
		target: '.scrollspy-nav',
		offset: 70
	});
	$('.affix').affix({
	    offset: {
	      top: 145,
	      bottom: 77
	    }
	});
	$('#overview-nav li a').click(function(event) {
	    event.preventDefault();
	    $($(this).attr('href'))[0].scrollIntoView();
	    scrollBy(0, -60);
	});
	
	function summernote_initialize(elem){
		elem.summernote({
			height: 150,
			lang: 'de-DE',
			codemirror: { // codemirror options
			    theme: 'spacelab'
			},
			toolbar: [
			          ['style', ['clear', 'bold', 'italic', 'underline', 'style']],
			          ['fontsize', ['fontsize']],
			          ['color', ['color']],
			          ['height', ['height']],
			          ['para', ['ul', 'ol', 'paragraph']],
			          ['table', ['table']],
			          ['insert', ['link', 'picture']],
			          ['view', ['fullscreen', 'codeview']],
		          ]
		});
	}
	summernote_initialize($('#produktInformationen'));
	summernote_initialize($('#produktAnnahmerichtlinie'));
	
	function addCommas(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? ',' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1 + x2;
	}

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
    $('.save-changes').unbind('click').click(function(event){
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
    	var info = $('#produktInformationen').parent().find('div').eq(0).find('.note-editable').code();
    	$('#produktInformationen').val(info);
    	$('#produktInformationen').attr('value', info);

    	var info = $('#produktAnnahmerichtlinie').parent().find('div').eq(0).find('.note-editable').code();
    	$('#produktAnnahmerichtlinie').val(info);
    	$('#produktAnnahmerichtlinie').attr('value', info);
    	
//    	if(false){
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
    $('.konditionen-bearbeiten').unbind('click').click(function(event){
    	$('#konditionen-bearbeiten-modal').modal('toggle');
    	load_konditionen();
    	var erste_schwelle = $('.nav-tabs a:first');
    	if(erste_schwelle.length > 0) erste_schwelle.tab('show');
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
    	 * Setze Bonitätsabh.-Radio im Modal-Dialog
    	 */
    	var bonitabh = $("input:radio[name ='produktIsBonitabh']:checked");
		$('input[name="produktIsBonitabh-helper"]').each(function(i, helper){
			if($(helper).val() == bonitabh.val()) $(this).prop('checked', bonitabh.prop('checked'));
		});
		
		if(!bonitabh.val()){
			$('.progress').hide();
			return;
		}
		
    	var message = "Es ist ein Fehler augetretten!";
//    	if($('#konditionen-table tbody tr').length == 0){
    	if($('#schwelle-tab-0').find('table tbody tr').length == 0){
//		if($('#schwelle-tab-0').find('table').find('tbody').find('tr').length == 0){
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
		    							$.parseJSON(response.sales),
		    							$.parseJSON(response.schwellen)
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
    
    function build_konditionen_table(init, bonitabh, laufzeiten, risikoklassen, zinssaetze, leads, sales, schwellen){
    	var zinssatz = '';
    	var lead = '';
    	var sale = '';
    	var remove_risikoklasse_disabled = "";
    	
    	if(init){
    		laufzeiten = [[12, 18, 24, 36, 48, 60, 72, 84]];
//    		if(bonitabh == 1) risikoklassen = [1, 2, 3, 4, 5, 6];
//    		else risikoklassen = [1];
    		if(bonitabh == 1) {
    			remove_risikoklasse_disabled = "";
    			risikoklassen = [[1, 3, 6]];
    		}
			else {
				remove_risikoklasse_disabled = "disabled";
				risikoklassen = [[1]];
			}
    		schwellen = [0];
    	}
    	
		var table = 
			'<ul class="nav nav-tabs">';
		for(var i = 0; i < schwellen.length; i++){
			table += 
				'<li>'+
					'<a href="#schwelle-tab-'+i+'" data-toggle="tab" id="#schwelle-tab-link-'+i+'">ab '+schwellen[i]+'</a>'+
				'</li>';
		}
		table += 
			'</ul>'+
			'<div class="tab-content">';
		for(var i = 0; i < schwellen.length; i++){	
			table += 
				'<div class="tab-pane schwelle-tab" id="schwelle-tab-'+i+'">'+
//				'<table class="table table-hover table-condensed" id="konditionen-table">'+
				'<table class="table table-hover table-condensed">'+
					'<thead>'+
						'<tr class="active">'+
							'<th>Schwelle</th>'+
							'<th colspan="2"><input class="form-control input-sm schwelle-input" type="text" id="#schwelle-input-'+i+'" value="'+schwellen[i]+'"/></th>'+
							'<th>'+
								'<button type="button" class="btn btn-xs btn-success add-schwelle pull-left">'+
									'<span class="glyphicon glyphicon-plus"></span>'+
								'</button>'+	
								'<button type="button" class="btn btn-xs btn-danger remove-schwelle pull-right">'+
									'<span class="glyphicon glyphicon-remove"></span>'+
								'</button>'+	
							'</th>'+
							'<th colspan="'+ (laufzeiten[schwellen[i]].length-1) +'"></th>'+
						'</tr>'+					
						'<tr class="active">'+
							'<th colspan="3"></th>'+
							'<th colspan="'+ laufzeiten[schwellen[i]].length +'">Laufzeit in Monaten</th>'+
						'</tr>'+
						'<tr class="active">'+
							'<th colspan="3"></th>';
			for(var j = 0; j < laufzeiten[schwellen[i]].length; j++){
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
			
			$.each(laufzeiten[schwellen[i]],function(j, laufzeit){
				table +=
							'<th><input type="text" class="form-control kondition-laufzeit kondition-input input-sm" value="'+laufzeit+'"/></th>';
			});
			table +=
						'</tr>'+
					'</thead>'+
					'<tbody>';
			$.each(risikoklassen[schwellen[i]],function(j, risikoklasse){
				table +=
						'<tr>'+
							'<td class="active">'+
								'<button type="button" class="btn btn-xs btn-success add-risikoklasse">'+
									'<span class="glyphicon glyphicon-plus"></span>'+
								'</button>'+
							'</td>'+
							'<td class="active">'+
								'<button type="button" class="btn btn-xs btn-danger remove-risikoklasse '+remove_risikoklasse_disabled+'">'+
									'<span class="glyphicon glyphicon-remove"></span>'+
								'</button>'+
							'</td>'+									
							'<td class="active"><input type="text" class="form-control kondition-risikoklasse kondition-input input-sm" value="'+risikoklasse+'"/></td>';
				$.each(laufzeiten[schwellen[i]],function(k, laufzeit){
					if(!init) zinssatz = zinssaetze[schwellen[i]][risikoklasse][laufzeit].toString().replace('.', ',');
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
			$.each(laufzeiten[schwellen[i]],function(j, laufzeit){
				if(!init) lead = leads[schwellen[i]][laufzeit].toString().replace('.', ',');
				table +=
							'<th><input type="text" class="form-control kondition-lead kondition-input input-sm" value="'+lead+'"/></th>';
			});
			table +=
						'</tr>'+
						'<tr class="active">'+
							'<th colspan="3">Provision in  % v.d. Kreditsumme (Sales)</th>';
			$.each(laufzeiten[schwellen[i]],function(j, laufzeit){
				if(!init) sale = sales[schwellen[i]][laufzeit].toString().replace('.', ',');
				table +=
							'<th><input type="text" class="form-control kondition-sale kondition-input input-sm" value="'+sale+'"/></th>';
			});
			table +=
						'</tr>'+								
					'</tfoot>'+
				'</table>'+
				'</div>';
		}
		table +=
			'</div>';    
		$('.table-responsive').html(table);
		if(init) $('#schwelle-tab-0').find('button.remove-schwelle').addClass('disabled');
    }
    
    $('.nav-tabs a').click(function(event){
    	event.preventDefault();
    	$(this).tab('show');
	});
    
    /*
     * Ein Flag, das angibt ob sich der Inhalt
     * eines Input-Feldes geändert hat
     */
    var inputChanged = false;
    
    /*
     * Schreibt den Schwellwert in den Link; setzt value
     */    
    $(document).on('keyup', '.schwelle-input', function(event) {
    	$('ul.nav-tabs').find('li.active').find('a').text('ab '+$(this).val());
    	$(this).attr("value", $(this).val());
    	inputChanged = true;
    });
    
    /*
     * Beim Ändern der Bonitätsabhängigkeit die bestehenden 
     * Konditionen zwischenspeichern
     */
    $(document).on('change', 'input[name ="produktIsBonitabh"]', function(event) {
    	/*
    	 * Setze Bonitätsanh.-Radio im Modal-Dialog
    	 */
    	var bonitabh = $("input:radio[name ='produktIsBonitabh']:checked");
		$('input[name="produktIsBonitabh-helper"]').each(function(i, helper){
			if($(helper).val() == bonitabh.val()){
				if(!$(helper).prop('checked')){
					$(helper).prop('checked', bonitabh.prop('checked'));
//					$(helper).parent().button('toggle');
				}
			}
		});
		
    	if($('#schwelle-tab-0').length == 0) load_konditionen();
//		if($('#konditionen-table').length == 0) load_konditionen();
    	var currentValueName = 'Value_'+ ($(this).val() == 0 ? 1 : 0);
    	var newValueName = 'Value_'+ $(this).val();
    	$('.table-responsive').data[currentValueName] = $('.table-responsive').html();

//        	$('.table-responsive').html('Wait...');
    	
    	if($('.table-responsive').data[newValueName]) $('.table-responsive').html($('.table-responsive').data[newValueName]);
    	else {
    		build_konditionen_table(true, $(this).val());
        	var erste_schwelle = $('.nav-tabs a:first');
        	if(erste_schwelle.length > 0) erste_schwelle.tab('show');
    	}
    });
    
    $(document).on('change', 'input[name ="produktIsBonitabh-helper"]', function(event) {
    	/*
    	 * Setze Bonitätsanh.-Radio in Produkt-Form
    	 */
    	var bonitabh = $("input:radio[name ='produktIsBonitabh-helper']:checked");
		$('input[name="produktIsBonitabh"]').each(function(i, core){
			if($(this).val() == bonitabh.val()){
				if(!$(core).prop('checked')){
					$(core).prop('checked', bonitabh.prop('checked'));
//					$(core).parent().button('toggle');
				}
			}
		});
		
		if(!bonitabh.val()){
			$('.progress').hide();
			return;
		}
    	var currentValueName = 'Value_'+ ($(this).val() == 0 ? 1 : 0);
    	var newValueName = 'Value_'+ $(this).val();
    	$('.table-responsive').data[currentValueName] = $('.table-responsive').html();
    	
    	if($('.table-responsive').data[newValueName]) $('.table-responsive').html($('.table-responsive').data[newValueName]);
    	else {
    		build_konditionen_table(true, $(this).val());
        	var erste_schwelle = $('.nav-tabs a:first');
        	if(erste_schwelle.length > 0) erste_schwelle.tab('show');
    	}
    });
    
    /*
     * Speichern der Konditionen in der DB 
     */
    $('#save-konditionen').unbind('click').click(function(event){
    	var konditionen = new Array();
        
    	var n = 0;
//    	$('#konditionen-table tbody tr').each(function(i, row){
//    		$('#konditionen-table thead th input').each(function(j, laufzeit){
//    			var colIndex = parseInt($(laufzeit).parent().index());
//	    		konditionen[n]={
//	    	        "laufzeit" : $(laufzeit).val(), 
//	    	        "risikoklasse" :$(row).find('.kondition-risikoklasse').val(),
//	    	        "zinssatz" : $(row).find('.kondition-zinssatz').eq(colIndex-1).val(),
//	    	        "lead" : $('#konditionen-table').find('.kondition-lead').eq(colIndex-1).val(),
//	    	        "sale" : $('#konditionen-table').find('.kondition-sale').eq(colIndex-1).val()
//	    	    };
//	    		n++;
//    		});
//    	});  

    	$('.schwelle-tab').each(function(i, tab){
	    	$(tab).find('table tbody tr').each(function(i, row){
	    		$(tab).find('table thead th .kondition-laufzeit').each(function(j, laufzeit){
	    			var colIndex = parseInt($(laufzeit).parent().index());
		    		konditionen[n]={
		    	        "laufzeit" : $(laufzeit).val(), 
		    	        "risikoklasse" :$(row).find('.kondition-risikoklasse').val(),
		    	        "zinssatz" : $(row).find('.kondition-zinssatz').eq(colIndex-1).val(),
		    	        "lead" : $(tab).find('table').find('.kondition-lead').eq(colIndex-1).val(),
		    	        "sale" : $(tab).find('table').find('.kondition-sale').eq(colIndex-1).val(),
		    	        "schwelle" : $(tab).find('.schwelle-input').val()
		    	    };
		    		n++;
	    		});
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
    		if(
				!$(input).val() && 
				$(input).attr('type') != 'hidden' &&
				!$(input).hasClass('kondition-lead') &&
				!$(input).hasClass('kondition-sale')) {
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
//    	var schwellenIndex = $(this).parent().parent().parent().parent().parent().attr('id').split('-')[2];
    	var table = $(this).parent().parent().parent().parent();
    	var colIndex = button.parent().index();
    	var schwelleHeading = table.find('thead').find('tr').eq(0).find('th').eq(3);
    	var schwelleColspan = schwelleHeading.attr('colspan');
    	var laufzeitHeading = table.find('thead').find('tr').eq(1).find('th').eq(1);
    	var colspan = laufzeitHeading.attr('colspan');
    	if(colspan == 1){
    		table.find('thead').find('tr').eq(2).find('.remove-laufzeit').removeAttr('disabled');
    	}
    	laufzeitHeading.attr('colspan', parseInt(colspan)+1);
    	if(schwelleHeading.length == 0) table.find('thead').find('tr').eq(0).append('<th colspan="1"></th>');
    	else schwelleHeading.attr('colspan', parseInt(schwelleColspan)+1);
    	
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
    		2: thButtons,
    		3: thLaufzeit
    	});
    	var tfoot = ({
    		0: thLead,
    		1: thSale
    	});
    	table.find('thead').find('tr').each(function(i, tr) {
    		if(i != 0 && i != 1) $(tr).find('th').eq(colIndex).after(thead[i]);
        });
    	table.find('tfoot').find('tr').each(function(i, tr) {
            $(tr).find('th').eq(colIndex).after(tfoot[i]);
        });
    	table.find('tbody').find('tr').each(function(i, tr) {
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
    	var table = $(this).parent().parent().parent().parent();
    	var colIndex = button.parent().index();
    	var laufzeitHeading = table.find('thead').find('tr').eq(1).find('th').eq(1);
    	var schwelleHeading = table.find('thead').find('tr').eq(0).find('th').eq(3);
    	var schwelleColspan = schwelleHeading.attr('colspan');
    	var colspanOld = laufzeitHeading.attr('colspan');
    	if(colspanOld == 1) return;
    	var colspanNew = parseInt(colspanOld)-1;
    	if(colspanNew == 1){
    		table.find('thead').find('tr').eq(2).find('.remove-laufzeit').attr('disabled', 'disabled');
    	}
    	laufzeitHeading.attr('colspan', colspanNew);
    	if(schwelleColspan == 1) schwelleHeading.remove();
    	else schwelleHeading.attr('colspan', parseInt(schwelleColspan)-1);
    	
    	table.find('thead').find('tr').each(function(i, tr) {
    		if($(tr).find('th').eq(colIndex).find('input').val()) inputChanged = true;
    		if(i != 0 && i != 1) $(tr).find('th').eq(colIndex).remove();
        });
    	table.find('tfoot').find('tr').each(function(i, tr) {
        	if($(tr).find('th').eq(colIndex).find('input').val()) inputChanged = true;
            $(tr).find('th').eq(colIndex).remove();
        });
    	table.find('tbody').find('tr').each(function(i, tr) {
        	if($(tr).find('td').eq(colIndex+2).find('input').val()) inputChanged = true;
            $(tr).find('td').eq(colIndex+2).remove();
        }); 
	}); 

    /*
     * Neue Risikoklasse hinzufügen
     */
    $(document).on('click', '.add-risikoklasse', function(e) {
    	var button = $(this); 
    	var table = $(this).parent().parent().parent().parent();
    	var tr = button.parent().parent();
    	var rowIndex = tr.index();
    	
    	var laufzeitHeading = table.find('thead').find('tr').eq(1).find('th').eq(1);
    	var columnsCount = laufzeitHeading.attr('colspan');
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
    	
    	var newRow = table.find('tbody').find('tr').eq(parseInt(rowIndex)+1);
    	for(var i = 0; i < columnsCount; i++){
    		newRow.append(
				'<td>'+
					'<input class="form-control kondition-zinssatz kondition-input input-sm" type="text">'+
				'</td>'
    		);
    	}
    	
    	var remove_risikoklasse_button = table.find('tbody tr').eq(0).find('td').eq(1).find('button');
    	if(table.find('tbody tr').length > 1 && remove_risikoklasse_button.hasClass('disabled')) 
    		remove_risikoklasse_button.removeClass('disabled');
    	/*
    	 * TODO: Anfangswerte der neuen Felder speichern
    	 */
    });
    
    /*
     * Eine Risikoklasse löschen
     */
    $(document).on('click', '.remove-risikoklasse', function(e) {
    	var table = $(this).parent().parent().parent().parent();
    	$($(this).parent().parent().find('td input')).each(function(i, input){
    		if($(input).val()) {
    			inputChanged = true;
    		}
    	});
    	$(this).parent().parent().remove();
    	if(table.find('tbody tr').length == 1) table.find('tbody tr').find('td').eq(1).find('button').addClass('disabled');
    });  
    
    /*
     * Neue Schwelle hinzufügen
     */
    $(document).on('click', '.add-schwelle', function(e) {
//    	var div_tab_content = $(this).parent().parent().parent().parent().parent().parent();
    	var div_tab = $(this).parent().parent().parent().parent().parent();
    	var div_tab_index = div_tab.index();
    	div_tab.after(build_new_schwelle_tab());
    	
		$('.nav-tabs').find('li').eq(div_tab_index).after(
			'<li>'+
				'<a href="#" data-toggle="tab" id="0">ab 0</a>'+
			'</li>'
		);
		
		$('.nav-tabs').find('a').each(function(i, elem) {
			$(this).attr('href', '#schwelle-tab-'+i);
			$(this).attr('id', 'schwelle-tab-link-'+i);
		});
		$('.tab-content').find('div.tab-pane').each(function(i, elem) {
			$(this).attr('id', 'schwelle-tab-'+i);
			$(this).find('.schwelle-input').attr('id', 'schwelle-input-'+i);;
		});
		
		$('.nav-tabs').find('li').eq(parseInt(div_tab_index)+1).find('a').click();
		$('.tab-content').find('div.tab-pane').eq(parseInt(div_tab_index)+1).find('input.schwelle-input').focus();
		
		if($('.nav-tabs').find('li').length > 1 &&
				$('#schwelle-tab-0').find('button.remove-schwelle').hasClass('disabled')) 
			$('#schwelle-tab-0').find('button.remove-schwelle').removeClass('disabled');
    });
    
    
    /*
     * Konditionen-Tabelle für die neue Schwelle aufbauen
     */
    function build_new_schwelle_tab(){

    	var bonitabh = $("input:radio[name ='produktIsBonitabh-helper']:checked").val();
    	var	laufzeiten = [12, 18, 24, 36, 48, 60, 72, 84];
		if(bonitabh == 1) {
			remove_risikoklasse_disabled = "";
			risikoklassen = [1, 3, 6];
		}
		else {
			remove_risikoklasse_disabled = "disabled";
			risikoklassen = [1];
		}

		var	table = 
			'<div class="tab-pane schwelle-tab" id="0">'+
				'<table class="table table-hover table-condensed">'+
					'<thead>'+
						'<tr class="active">'+
							'<th>Schwelle</th>'+
							'<th colspan="2"><input class="form-control input-sm schwelle-input" type="text" id="0"/></th>'+
							'<th>'+
								'<button type="button" class="btn btn-xs btn-success add-schwelle pull-left">'+
									'<span class="glyphicon glyphicon-plus"></span>'+
								'</button>'+	
								'<button type="button" class="btn btn-xs btn-danger remove-schwelle pull-right">'+
									'<span class="glyphicon glyphicon-remove"></span>'+
								'</button>'+	
							'</th>'+
							'<th colspan="'+ (laufzeiten.length - 1) +'"></th>'+
						'</tr>'+					
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
								'<button type="button" class="btn btn-xs btn-danger remove-risikoklasse '+remove_risikoklasse_disabled+'">'+
									'<span class="glyphicon glyphicon-remove"></span>'+
								'</button>'+
							'</td>'+									
							'<td class="active"><input type="text" class="form-control kondition-risikoklasse kondition-input input-sm" value="'+risikoklasse+'"/></td>';
			$.each(laufzeiten,function(j, laufzeit){
				table +=
							'<td><input type="text" class="form-control kondition-zinssatz kondition-input input-sm"/></td>';
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
			table +=
							'<th><input type="text" class="form-control kondition-lead kondition-input input-sm"/></th>';
		});
		table +=
						'</tr>'+
						'<tr class="active">'+
							'<th colspan="3">Provision in  % v.d. Kreditsumme (Sales)</th>';
		$.each(laufzeiten,function(i, laufzeit){
			table +=
							'<th><input type="text" class="form-control kondition-sale kondition-input input-sm"/></th>';
		});
		table +=
						'</tr>'+								
					'</tfoot>'+
				'</table>'+
			'</div>';
		return table;
    }
    
    /*
     * Eine Schwelle löschen
     */
    $(document).on('click', '.remove-schwelle', function(e) {
//    	var div_tab_content = $(this).parent().parent().parent().parent().parent().parent();
    	var div_tab = $(this).parent().parent().parent().parent().parent();
    	var div_tab_index = div_tab.index();
    	
    	div_tab.remove();
    	
		$('.nav-tabs').find('li').eq(div_tab_index).remove();
		
		$('.nav-tabs').find('a').each(function(i, elem) {
			$(this).attr('href', '#schwelle-tab-'+i);
			$(this).attr('id', 'schwelle-tab-link-'+i);
		});
		$('.tab-content').find('div.tab-pane').each(function(i, elem) {
			$(this).attr('id', 'schwelle-tab-'+i);
			$(this).find('.schwelle-input').attr('id', 'schwelle-input-'+i);;
		});
		
		var tab_link = $('.nav-tabs').find('li').eq(div_tab_index);
		if(tab_link.length == 0) tab_link = $('.nav-tabs').find('li').eq(div_tab_index - 1);
		tab_link.find('a').click();
		
		if($('.nav-tabs').find('li').length == 1) $('#schwelle-tab-0').find('button.remove-schwelle').addClass('disabled');
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
    $('.discard-changes').unbind('click').click(function(event){
    	restore();
    });
    
//    $(document).on('click', '#fill', function() {
//    	$('.table-responsive').find('input').each(function(i, elem) {
//    		$(elem).attr("value", i);
//    	});
////    	$('#konditionen-table tfoot').find('input').each(function(i, elem) {
////    		$(elem).attr("value", i);
////    	});
//    	inputChanged = true;
//    });
//    
//    $(document).on('click', '#fill-produkt', function() {
//    	$('#produkt-form').find('input[type="text"]').each(function(i, elem) {
//    		$(elem).attr("value", i);
//    	});
//    	$('#produkt-form').find('textarea').each(function(i, elem) {
//    		$(elem).attr("value", i+1.3);
//    	});    
//    	$('#produkt-form').find('select').each(function(i, elem) {
//    		$(elem).val($(elem).find('option').eq(1).val());
//    	});   
//    	$('#produktGueltigSeit').val('12.12.2013');
//    	$('#kategorie').val(2);
//    	
//    	inputChanged = true;
//    });
});