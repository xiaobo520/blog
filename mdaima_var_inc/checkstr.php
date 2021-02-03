<?php 

$Url=$_SERVER["HTTP_REFERER"];

function chkss($str){

	if (strstr($str,"'")!=false || strstr($str,'"')!=false){
		echo "系统检测到，特殊字符！";
		exit;
	}
	
}

chkss($Url);
?>