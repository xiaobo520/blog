<?
include_once("../mdaima_var_inc/config_system.php");
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/conn.php"); 

$action=$_GET['action'];
if ($action=="out"){
	$_SESSION['blog_lileiuser']='';
	$_SESSION['blog_lileiflag']='';
}

if ($_SESSION['blog_lileiuser']!='' && $_SESSION['blog_lileiflag']!=''){
	echo "<script>top.location.href='admin_index.php';</script>";
	exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
<title>大胆哥博客后台管理信息系统</title>
<style type="text/css">
<!--
body {
	font-size:12px;
	/*background-image: url(images/login_bground.gif);*/
	font-family:微软雅黑,"宋体";
	min-height:1600px;
	overflow-y:hidden;
	
	FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#b8c4cb,endColorStr=#f6f6f8); /*IE 6 7 8*/ 

	background: -ms-linear-gradient(top, #b8c4cb,  #f6f6f8);        /* IE 10 */
	
	background:-moz-linear-gradient(top,#b8c4cb,#f6f6f8);/*火狐*/ 
	
	background:-webkit-gradient(linear, 0% 0%, 0% 100%,from(#b8c4cb), to(#f6f6f8));/*谷歌*/ 
	
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#b8c4cb), to(#f6f6f8));      /* Safari 4-5, Chrome 1-9*/
	
	background: -webkit-linear-gradient(top, #b8c4cb, #f6f6f8);   /*Safari5.1 Chrome 10+*/
	
	background: -o-linear-gradient(top, #b8c4cb, #f6f6f8);  /*Opera 11.10+*/

}

.input1{
	line-height:28px;
	height:28px;
	width:229px;
	padding:2px 4px;
	border:1px solid #DDD;
	border-top:1px solid #AAA;
	font-size:12px;
	font-family: 微软雅黑,Tahoma,Arial, Helvetica, sans-serif;
}
-->
</style>
<script language="javascript" src="js/usb_key.js"></script>
<script language="javascript" src="js/js_md5.js"></script>
<script language="javascript"> 
	if(top==self)top.location="index.php" ;
</script>
</head>

<body id="body" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">

<!--<noscript><iframe src="*.htm"></iframe></noscript>-->


	
<form id="login" name="login" action="checklogin.php?action=go" method="post" class="form-search" onsubmit="return checklogin()">
<table border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:120px;">
  <tr>
    <td width="679" height="315" valign="top" background="images/login_bg.gif" >
	
	
	  <table width="584" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td width="0" height="99" align="right">&nbsp;</td>
          <td width="0">&nbsp;</td>
          <td width="0">&nbsp;</td>
        </tr>
        <tr>
          <td width="0" height="40" align="right" style="color:#577086">用户名：</td>
          <td width="0" height="40"><input name="username" type="text" class="input1" id="username" maxlength="20" /></td>
          <td width="0">&nbsp;</td>
        </tr>
        <tr>
          <td width="0" height="40" align="right" style="color:#577086">密码：</td>
          <td width="0" height="40"><input name="password" type="password" class="input1" id="password" maxlength="20" autocomplete="off"/></td>
          <td width="0">&nbsp;</td>
        </tr>
        
        <tr>
          <td width="0" height="69" align="right">&nbsp;</td>
          <td width="0">

		  <input type="image" name="imageField" src="images/bt1.gif" style="width:110px; height:34px;outline:none;"/>

		  <img src="images/bt2.gif" width="110" height="34" style="border:0; cursor:pointer; outline:none; margin-left:14px;" onclick="document.login.username.value='';document.login.password.value='';"/>          </td>
          <td width="0">&nbsp;</td>
        </tr>
      </table>
	
    </td>
  </tr>
</table>
</form>
<table width="802" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="55" align="center" style="font-size:12px; color:#111111">Copyright &copy; <?=date("Y")?> 大胆哥博客  All rights reserved.</td>
  </tr>
</table>
</body>
</html>
