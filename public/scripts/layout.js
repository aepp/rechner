$(document).ready(function() {
	$(".nav-link-layout").on('click', function(event){
    	$('#navLayout').find('li.active').removeClass();
    	$(this).parent().addClass('active');
	});
	
    $('li.dropdown-submenu').on('click', function(event) {
        // Avoid following the href location when clicking
        //event.preventDefault(); 
        // Avoid having the menu to close when clicking
        event.stopPropagation(); 
        // If a menu is already open we close it
        $('li.dropdown-submenu').parent().parent().removeClass('open');
        // opening the one you clicked on
        $(this).parent().parent().addClass('open');
    });
});