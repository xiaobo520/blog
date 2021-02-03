<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 
?>

<style>
body,table,div,tr,td,input {
	font-family: 微软雅黑,宋体,Arial, Helvetica, sans-serif;
	font-size:12px;
	background:#16283a;
	margin:0;
	padding:0;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr height="35">
	<td align="right" style="padding-right:30px; font-size:12px; color:#FFFFFF; background:url(images/bottom_bg.gif) repeat-x;">Copyright &copy; <?=date("Y")?> 码代码-大胆哥博客  All rights reserved.</td>
  </tr>
</table>
<iframe frameborder="0" id="hiddenre" name="hiddenre" src="sessionkeeper.php" style="height:0;visibility: visible;width:0;"></iframe>
