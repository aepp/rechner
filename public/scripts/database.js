$(document).ready(function() {
    $(".editTableLink").unbind('click').click(function(event){
    	$('.jumbotron').remove();
    	$('#navSelectTable').find('li.active').removeClass();
    	$(this).parent().addClass('active');
        var heading = $(this).text();
        var tableName = $(this).attr("id");
		var tableFields = [];
		var defaultSorting = '';
		var logoUploaded = '';
		var formCreatedFunction = function (event, data) {
			data.form.validationEngine();
        };
		switch (tableName) {
		    case "aktion":
		    	tableFields = getFields_aktion();
		    	defaultSorting = 'aktionId ASC';
		    	formCreatedFunction = function (event, data){
		    		data.form.validationEngine();
					$('#Edit-banken').val(data.record.banken[0].bankId);
		    	};		    	
		        break;
		    case "bank":
		    	tableFields = getFields_bank();
		    	defaultSorting = 'bankId ASC';
		    	formCreatedFunction = function (event, data){
		    		data.form.validationEngine();
//					$('#Edit-banken').val(data.record.banken[0].bankId);
		            $("#logoUpload").uploadify({
		                height: 35,
		                width: 183,
		                swf: 'scripts/uploadify/uploadify.swf',
		                uploader: 'scripts/uploadify/uploadify.php',
		                folder: 'uploads/bank-logo',
		                cancelImg: 'scripts/uploadify/img/uploadify-cancel.png',
		                removeCompleted: false,
		                multi: false,
		                onInit : function(instance) {
		                    $('#logoUpload-button').remove();
		                	var uploadButton = $('<button/>');
		                	uploadButton.attr('type', 'button')
            							.attr('id', 'logoUpload-button')	
            							.addClass('btn btn-primary')
            							.css('width', '183px')
            							.text('Datei auswählen')
            							.appendTo($('#logoUpload'));
		                	$('#logoUpload').css('width', '183px');
		                    $('.swfupload').attr('width', '183px');
		                    $('param[name="flashvars"]').val().replace('120','buttonWidth=183');
		                }, 
		                onUploadComplete : function(file) {
//		                    alert('The file ' + file.name + ' finished processing.');
		                }, 
		                onUploadSuccess: function (file, data, response) {
		                	logoUploaded = file.name;
		                	$('#bankLogo').val(logoUploaded);
//		                	alert(data);
//		                	alert($('input[name="bankLogo"]').val());
		                	$('#logoPreview').attr('src', 'uploads/bank-logo/'+logoUploaded);

		                },		
		                onUploadError : function(file, errorCode, errorMsg, errorString) {
//		                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
		                }, 
		                width: 120
		            });
		    	};
		        break;
		    case "bewertung":
//		    	tableFields = getFields_bewertung();
//		    	defaultSorting = 'bewertungId ASC';
//		        break;
		    	return;
		    case "einlagensicherungLand":
		    	tableFields = getFields_einlagensicherungLand();
		    	defaultSorting = 'einlagensicherungLandId ASC';
		        break;
		    case "kategorie":
		    	tableFields = getFields_kategorie();
		    	defaultSorting = 'kategorieId ASC';
		        break;
		    case "kontozugriff":
		    	tableFields = getFields_kontozugriff();
		    	defaultSorting = 'kontozugriffId ASC';
		        break;
		    case "legitimation":
		    	tableFields = getFields_legitimation();
		    	defaultSorting = 'legitimationId ASC';
		        break;
		    case "produktart":
		    	tableFields = getFields_produktart();
		    	defaultSorting = 'produktartId ASC';
		        break;
		    case "testbericht":
//		    	tableFields = getFields_testbericht();
//		    	defaultSorting = 'testberichtId ASC';
//		        break;
		    	return;
			case "user":
		    	tableFields = getFields_user();
		    	defaultSorting = 'userId ASC';
		        break;
		    case "zeitabschnitt":
		    	tableFields = getFields_zeitabschnitt();
		    	defaultSorting = 'zeitabschnittId ASC';
		        break;
		    case "zinssatz":
		    	tableFields = getFields_zinssatz();
		    	defaultSorting = 'zinssatzId ASC';
		        break;
		}
		if($("#tableContent").find(".jtable-main-container").length > 0){
			$('#tableContent').jtable('destroy');
		} 
        $('#tableContent').jtable({
        	title: heading,
        	jqueryuiTheme: true,
            paging: true,
            pageSize: 10,
            sorting: true,
            defaultSorting: defaultSorting,
            selecting: true,
            multiselect: true,
            selectingCheckboxes: true,
            selectOnRowClick: true,
            loadingAnimationDelay: 20,
            ajaxSettings: {
                type: 'POST',
                dataType: 'json'
            },
            toolbar: {
                hoverAnimation: true, //Enable/disable small animation on mouse hover to a toolbar item.
                hoverAnimationDuration: 60, //Duration of the hover animation.
                hoverAnimationEasing: undefined, //Easing of the hover animation. Uses jQuery's default animation ('swing') if set to undefined.
                items: [{
                    text: 'Aktualisieren',
                    icon: '../img/refresh-icon.png',
                    cssClass: 'refreshButton',
                    click: function () {
                    	$('#tableContent').jtable('reload');
                    }
                }]
            },
            actions: {
                listAction: 'database/'+tableName+'/list',
                createAction: 'database/'+tableName+'/create',
                updateAction: 'database/'+tableName+'/update',
                deleteAction: 'database/'+tableName+'/delete'
            },
            fields: tableFields,
            formCreated: formCreatedFunction,
            formSubmitting: function (event, data) {
                return data.form.validationEngine('validate');
    		},
            formClosed: function (event, data) {
                data.form.validationEngine('hide');
                data.form.validationEngine('detach');
            },
            selectionChanged: function () {
//            	$('#tableContent').append('<a class="btn btn-alert" id="deleteSelectedButton" href="#">Ausgewählte Einträge löschen</button>');
            	$('#tableContent').jtable('selectedRows');
            },
        });
        
        $('#tableContent').jtable('load');

        $('#deleteSelectedButton').click(function () {
            var $selectedRows = $('#tableContent').jtable('selectedRows');
            $('#tableContent').jtable('deleteRows', $selectedRows);
        });
    });  	
    function getFields_aktion(){
    	fields = {
	        aktionId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        aktionName: {
	            title: 'Aktion',
	            type: 'text',
	            inputClass: 'validate[required]',
	        },
	        aktionBeschreibung: {
	            title: 'Beschreibung',
	            type: 'textarea',
	        },	
	        banken: {
	            title: 'Bank',
	            options: 'database/bank/options',
	            display: function (data) {
	                var preview =
	                	'<div>';
	                if(data.record.banken[0].bankLogo){
	                	preview +=
	                		'<img id="logoPreview" src="uploads/bank-logo/'+data.record.banken[0].bankLogo+'" class="bank-logo-preview"/>'+
	            			'<br/>';
	            	}
                	preview +=
                			data.record.banken[0].bankName +
	                	'</div>';
	                return preview;	            	
	            }
	        },
	        aktionStartOn: {
	            title: 'Aktionsstart',
	            type: 'date',
	            displayFormat: "d. MM yy",
	            inputClass: 'validate[required] text-input datepicker"',
	        },	
	        aktionEndeOn: {
	            title: 'Aktionssende',
	            type: 'date',
	            displayFormat: "d. MM yy",
	            inputClass: 'validate[required] text-input datepicker"',
	        },	
	        aktionIsZuende: {
	            title: 'Aktion beendet?',
                type: 'radiobutton',
                options: { '1': 'Ja',
                           '0': 'Nein'
            	},
                inputClass: 'validate[required]',
	        },	
    	};
    	return fields;
    }  
    function getFields_bank(){
    	fields = {
	        bankId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        bankName: {
	            title: 'Bankname',
	            width: '45%',
	            inputClass: 'validate[required]',
	        },	
	        bankLogo: {
	            title: 'Logo',
	            width: '45%',
	            display: function (data) {
	                var preview =
	                	'<div>';
	                if(data.record.bankLogo){
	                	preview +=
		                		'<img src="uploads/bank-logo/'+data.record.bankLogo+'" class="bank-logo-preview"/>';

	            	} else {
	                	preview +=
		                		'Kein Logo';
	            	}
	                preview += 
	                	'</div>';
	                return preview;
//	                return '<img src="uploads/bank-logo/'+data.record.bankLogo+'" class="bank-logo-preview"/>';
	            },
	            input: function (data) {
	                var preview =
	                	'<div>';
	                if(data.record.bankLogo){
	                	preview +=
		                		'<img id="logoPreview" src="uploads/bank-logo/'+data.record.bankLogo+'" class="bank-logo-preview"/>'+
	                			'<br/>'+
//	                			'<input type="text" id="bankLogo" name="bankLogo" value="'+data.record.bankLogo+'"  class="validate[required]"/>';
	                			'<input type="text" id="bankLogo" name="bankLogo" value="'+data.record.bankLogo+'"/>';

	            	} else {
	                	preview +=
		                		'<img id="logoPreview" class="bank-logo-preview"/>'+
	                			'<br/>'+
//	                			'<input type="text" id="bankLogo" name="bankLogo" class="validate[required]"/>';
	                			'<input type="text" id="bankLogo" name="bankLogo"/>';
	            	}
	                preview += 
	                	'</div>';
	                return preview;
	            },
	        },	
	        logoUpload: {
                list: false,
                create: true,
                edit: true,
                input: function (data) {
                    return '<div id="logoUpload" name="logoUpload"></div>';

                }
            },
    	};
    	return fields;
    }
    function getFields_einlagensicherungLand(){
    	fields = {
			einlagensicherungLandId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        einlagensicherungLandName: {
	            title: 'Land',
	            type: 'text',
	            inputClass: 'validate[required]',
	        },
    	};
    	return fields;
    }  
    function getFields_kontozugriff(){
    	fields = {
			kontozugriffId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        kontozugriffName: {
	            title: 'Kontozugriffsart',
	            type: 'text',
	            inputClass: 'validate[required]',
	        },
    	};
    	return fields;
    }  
    function getFields_legitimation(){
    	fields = {
			legitimationId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        legitimationName: {
	            title: 'Legitimationsform',
	            type: 'text',
	            inputClass: 'validate[required]',
	        },
    	};
    	return fields;
    } 
    function getFields_produktart(){
    	fields = {
    			produktartId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        produktartName: {
	            title: 'Produktart',
	            type: 'text',
	            inputClass: 'validate[required]',
	        },
    	};
    	return fields;
    }  
    function getFields_user(){
    	fields = {
	        userId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        userVorname: {
	            title: 'Vorname',
	            inputClass: 'validate[required]',
	        },	
	        userName: {
	            title: 'Name',
	            inputClass: 'validate[required]',
	        },	
	        userEmail: {
	            title: 'Email',
	            inputClass: 'validate[required, custom[email]]',
	        },	
	        userPassword: {
	            title: 'Password',
                type: 'password',
	            list: false,
	            inputClass: 'validate[required]',
	        },	
    	};
    	return fields;
    }
    function getFields_kategorie(){
    	fields = {
	        kategorieId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        kategorieName: {
	            title: 'Kategorie',
	            width: '45%',
	            inputClass: 'validate[required]',
	        },	
    	};
    	return fields;
    }   
    function getFields_zeitabschnitt(){
    	fields = {
			zeitabschnittId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        zeitabschnittName: {
	            title: 'Zeitabschnitt',
	            type: 'text',
	            inputClass: 'validate[required]',
	        },
    	};
    	return fields;
    }  
    function getFields_zinssatz(){
    	fields = {
			zinssatzId: {
	            key: true,
	            edit: false,
	            list: true,
	            title: 'ID',
	            width: '5%',
	        },
	        zinssatzName: {
	            title: 'Zinssatz',
	            type: 'text',
	            inputClass: 'validate[required]',
	        },
    	};
    	return fields;
    }   
});