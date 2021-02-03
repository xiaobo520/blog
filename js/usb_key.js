function checkform_login(){
	
	$('#login_u').attr('class','login_u');
	$('#login_p').attr('class','login_p');
	$("#hidereg").val('1');
	
	if (document.form_login.username.value==""){
		document.form_login.username.focus();
		$('#login_u').attr('class','login_u login_u_error');
		return false
		
	}else if (document.form_login.password.value==""){
		document.form_login.password.focus();
		$('#login_p').attr('class','login_p login_p_error');
		return false
		
	}else{
		document.form_login.password.value=hex_md5(document.form_login.password.value);
		document.form_login.submit();
		return true
	}
}

function checkform_reg(){
	
	$('#reg_u').attr('class','reg_u');
	$('#reg_p1').attr('class','reg_p1');
	$('#reg_p2').attr('class','reg_p2');
	$("#hidereg").val('2');
	
	if (document.form_register.zcusername.value==""){
		document.form_register.zcusername.focus();
		$('#reg_u').attr('class','reg_u reg_u_error');
		return false
		
	}else if (document.form_register.password1.value==""){
		document.form_register.password1.focus();
		$('#reg_p1').attr('class','reg_p1 reg_p1_error');
		return false
		
	}else if (document.form_register.password2.value==""){
		document.form_register.password2.focus();
		$('#reg_p2').attr('class','reg_p2 reg_p2_error');
		return false
		
	}else{
		document.form_register.submit();
		return true
	}
}


function checkform_lose(){
	
	$('#lose_u').attr('class','lose_u');
	$("#hidereg").val('3');
	
	if (document.form_lose.loseusername.value==""){
		document.form_lose.loseusername.focus();
		$('#lose_u').attr('class','lose_u lose_u_error');
		return false
		
	}else{
		document.form_lose.submit();
		return true
	}
}