<?php
include_once("../mdaima_var_inc/config_system.php");
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数

if($_SESSION['blog_lileiuser']=="" || !isset($_SESSION['blog_lileiflag'])){
	echo "<script>location.href='login.php';</script>";
	exit;
}

include_once("../mdaima_var_inc/conn.php"); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>码代码-大胆哥博客后台管理信息系统</title>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
</head>

<frameset rows="124,*,1,35" cols="*" id="topfirst" frameborder="no" border="0" framespacing="0" >
	  <frame src="top.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" />
	  <frameset cols="185,*" frameborder="no" border="0" framespacing="0" id="left_all">
		<frame src="left.php" name="leftFrame" scrolling="no" style="border:0;border-right:1px solid #CCCCCC" noresize="noresize" id="leftframe" />
		<frame src="index_main.php" name="frmright" id="frmright" noresize="noresize" />
	  </frameset>
	  <frame src="kong.html" name="bottomKong" scrolling="No" noresize="noresize" id="bottomKong"  />
	  <frame src="bottom.php" name="bottomFrame" scrolling="No" noresize="noresize" id="bottomFrame"  />
	</frameset>
<noframes><body>
</body>
</noframes></html>