<?php
function chkss($str){//��¼��ע����֤
	if (strstr($str,"'")!==false || strstr($str,"=")!==false || strstr($str,"<")!==false || strstr($str,">")!==false || strstr($str,"&")!==false || strstr($str,'"')!==false){
		echo "<script language=javascript>alert('������������ַ���');javascript:history.back(-1);</script>";
		exit;
	}
}
?>