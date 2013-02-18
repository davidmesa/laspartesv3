 $(document).ready(function() {
   show_login();
 });
 
 //funcion que despliega la forma de login
 function show_login(){
	 $('#home-div-header-top-sesion span').click(function(){
		var show= $('#home-div-header-login-box').hasClass('hide');
		if(show){
			$('#home-div-header-login-box').css('display','block');
			$('#home-div-header-login-box').removeClass('hide');
			$('#home-div-header-login-box').addClass('show');
		}else{
			$('#home-div-header-login-box').hide();
			$('#home-div-header-login-box').removeClass('show');
			$('#home-div-header-login-box').addClass('hide');
		}
	 	return false;
	 });
	 
 }