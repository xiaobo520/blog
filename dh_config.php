<?
include_once("./mdaima_var_inc/checkall_home.php");

$dh_url=$_SERVER["REQUEST_URI"];
if (strpos($dh_url,"home")!==false){
	$home_css="1";
	$daohang='用户信息';
}elseif (strpos($dh_url,"zhuji")!==false){
	$home_css="2";
	$daohang='虚拟主机';
}elseif (strpos($dh_url,"score")!==false){
	$home_css="3";
	$daohang='积分记录';
}elseif (strpos($dh_url,"myfatie")!==false){
	$home_css="4";
	$daohang='我的发言';
}elseif (strpos($dh_url,"password")!==false){
	$home_css="5";
	$daohang='修改密码';
}else{
	$home_css="1";
	$daohang='个人信息';
}

?>