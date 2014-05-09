
$(document).ready(function(){$('#login-button').unbind('click').click(function(event){if(!$('#login-form').validationEngine('validate')){}
else($('#login-form').submit());});});