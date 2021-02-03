<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$page=$_REQUEST['page'];

$sql="select username,xingming,lasttime,usbkey from lei_admin where username='".$_SESSION['blog_lileiuser']."'";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$username=$rs["username"];
	$xingming=$rs["xingming"];
	$lasttime=$rs["lasttime"];
	$usbkey=$rs["usbkey"];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" />
</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	

	<div class="h_a">功能说明</div>
	<div class="prompt_text">
		<ol>
			<li>通过当前页面，您可以查询您个人的相关信息。</li>
		</ol>
	</div>

	<form action="" method="post">
	<div class="h_a">个人信息</div>
	<div class="table_full">
		<table width="100%">
			<colgroup>
					<col width="170">
					<col >
					<col width="170">
					<col >
			</colgroup>
		
			<tr>
				<th width="15%" >帐号</th>
				<td width="35%" ><?=$username?>				</td>
				<th width="15%" >最近登录时间</th>
				<td width="35%" ><?=$lasttime?></td>
			</tr>
			<tr>
				<th>使用人姓名</th>
				<td width="35%"><?=$xingming?></td>
				<th width="15%">USB-Key</th>
				<td width="35%"><?=$usbkey?></td>
			</tr>
			<tr>
			  <th>magic_quotes_gpc状态</th>
			  <td><?
			  if (!get_magic_quotes_gpc()) {
					echo '<span style=color:red>未开启</span>';    // delete backslash(\)
				}else{
					echo '已开启';
				}
			  ?></td>
			  <th>&nbsp;</th>
			  <td>&nbsp;</td>
		  </tr>
		</table>
	</div>
	
	
	</form>
</div>

</body>
</html>
