<?
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php"); 

if ($_SESSION['user_lei_username']!=''){//登录用户才记录积分
	$webid=quotes_gpc_pd($_POST['webid'],1);
	$url=quotes_gpc_pd($_POST['url'],1);
	jilu_in($_SESSION['user_lei_username'],$var_jifen_bdshare,'sharejiangli',$webid."#".$url);//积分
	
}

?>