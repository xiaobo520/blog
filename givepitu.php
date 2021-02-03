<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");
include_once("./mdaima_var_inc/sendmail.php");//发送邮件类


//$content = ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',quotes_gpc_pd($_POST['content'],0));
//$content = iconv("utf-8","gbk",$_POST['content']);
$src_i = $_POST['src_i'];

$indate=date("Y-m-d H:i:s");

if( $_SERVER['HTTP_REFERER'] == "" ){
	//header("Location:".$fromurl); 
	exit;
}

if ($_SESSION['user_lei_username']!=''){
	$cz_user=$_SESSION['user_lei_username'];
	
	$zt_pintu=jilu_in($cz_user,$var_jifen_pintu,'pintu','');//积分
	if ($zt_pintu=='获取积分OK'){
		echo "恭喜您，成功完成本次游戏！（赚取了".$var_jifen_pintu."积分）";	
	}else{
		echo "恭喜您，成功完成本次游戏！（没有积分喽，每天只限领取一次拼图积分！明天再继续吧！）";	
	}

}else{
	echo "恭喜您，成功完成本次游戏！（登录后可赚取积分哦！）"; //非登录用户不用判断，只接恭喜

}
?>