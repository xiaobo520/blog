<?php
include_once("co_inc/config_system.php");
include_once("co_inc/config_system_info.php");//必须先调用获取基本参数
include_once("co_inc/checkall.php"); 
include_once("co_inc/conn.php"); 

$action=htmlspecialchars($_REQUEST['action']);
$search_cookie=htmlspecialchars($_REQUEST['pd_value']);

if ($action=='chk'){ //必须用在<html>标签前

	if ($search_cookie=='open'){ //必须用在<html>标签前
		setcookie("search_cookie_pd","open", time()+9999999);
	}else{
		setcookie("search_cookie_pd","close", time()+9999999);
	}
	//setcookie("search_cookie_pd", "", time()+9999999);//清空COOK
}

//输出  $_COOKIE["search_cookie_pd"]
?>