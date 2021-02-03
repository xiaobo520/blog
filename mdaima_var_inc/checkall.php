<?php

if($_SESSION['blog_lileiuser']=="" || !isset($_SESSION['blog_lileiflag'])){
	echo "<script language=javascript>alert('您已超时或未登录！');top.location.href='index.php';</script>";
	exit;
}

//include_once("config_limit.php");//调用验证页面权限
?>