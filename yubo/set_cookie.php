<?php
include_once("co_inc/config_system.php");
include_once("co_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("co_inc/checkall.php"); 
include_once("co_inc/conn.php"); 

$action=htmlspecialchars($_REQUEST['action']);
$search_cookie=htmlspecialchars($_REQUEST['pd_value']);

if ($action=='chk'){ //��������<html>��ǩǰ

	if ($search_cookie=='open'){ //��������<html>��ǩǰ
		setcookie("search_cookie_pd","open", time()+9999999);
	}else{
		setcookie("search_cookie_pd","close", time()+9999999);
	}
	//setcookie("search_cookie_pd", "", time()+9999999);//���COOK
}

//���  $_COOKIE["search_cookie_pd"]
?>