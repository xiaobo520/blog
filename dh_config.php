<?
include_once("./mdaima_var_inc/checkall_home.php");

$dh_url=$_SERVER["REQUEST_URI"];
if (strpos($dh_url,"home")!==false){
	$home_css="1";
	$daohang='�û���Ϣ';
}elseif (strpos($dh_url,"zhuji")!==false){
	$home_css="2";
	$daohang='��������';
}elseif (strpos($dh_url,"score")!==false){
	$home_css="3";
	$daohang='���ּ�¼';
}elseif (strpos($dh_url,"myfatie")!==false){
	$home_css="4";
	$daohang='�ҵķ���';
}elseif (strpos($dh_url,"password")!==false){
	$home_css="5";
	$daohang='�޸�����';
}else{
	$home_css="1";
	$daohang='������Ϣ';
}

?>