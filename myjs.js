$(document).ready(function(){

$("#show_custom_login_button").click(function(){
	$( "#login-dropdown" ).hide(1000);	
	$( "#custom_loginid" ).show(1000);
	$( "#show_custom_login_button" ).hide(1000);

});

$("#hide_custom_login_button").click(function(){
	$( "#custom_loginid" ).hide( 1000);
	$( "#custom_login_url" ).val("");
	$( "#login-dropdown" ).show(1000);
	$( "#show_custom_login_button" ).show(1000);//button

});
});
