
window.onload = function(){//��ȡ����
	var oInput = document.getElementById("username");
	oInput.focus();
}

function checklogin(){
	if (document.login.username.value==""){
		alert("�������û�����")
		document.login.username.focus();
		//$('#show_username').tooltip('show')
		return false
	}else if (document.login.password.value==""){
		//$('#show_password').tooltip('show')
		alert("���������룿");
		document.login.password.focus();
		return false
	}else{
		document.login.password.value=hex_md5(document.login.password.value);
		document.login.submit();
		return true
	}
}

function loginfy(){
	if (document.login.username.value!=""){
		$('#show_username').tooltip('hide');
	}	
	
	if (document.login.password.value!=""){
		$('#show_password').tooltip('hide');
	}
}