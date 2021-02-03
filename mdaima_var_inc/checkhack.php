<?php
function chkss($str){//µÇÂ¼Óë×¢²áÑéÖ¤
	if (strstr($str,"'")!==false || strstr($str,"=")!==false || strstr($str,"<")!==false || strstr($str,">")!==false || strstr($str,"&")!==false || strstr($str,'"')!==false){
		echo "<script language=javascript>alert('ÇëÎğ°üº¬ÌØÊâ×Ö·û£¡');javascript:history.back(-1);</script>";
		exit;
	}
}
?>