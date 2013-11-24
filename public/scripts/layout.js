$(document).ready(function() {
	$(".nav-link-layout").on('click', function(event){
    	$('#navLayout').find('li.active').removeClass();
    	$(this).parent().addClass('active');
	});
});