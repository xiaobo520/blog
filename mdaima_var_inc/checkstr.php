<?php 

$Url=$_SERVER["HTTP_REFERER"];

function chkss($str){

	if (strstr($str,"'")!=false || strstr($str,'"')!=false){
		echo "ϵͳ��⵽�������ַ���";
		exit;
	}
	
}

chkss($Url);
?>