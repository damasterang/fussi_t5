$(document).ready(function(){

	// $('.errorLogin').hide();

	$('.sideMenuAct').animate({left: '0'}, 2000);

});

function errorLogin(){
	$('.errorLogin').show();
	$('.errorLogin').delay(3000).fadeOut();
}