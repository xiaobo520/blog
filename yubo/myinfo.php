<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
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
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	

	<div class="h_a">����˵��</div>
	<div class="prompt_text">
		<ol>
			<li>ͨ����ǰҳ�棬�����Բ�ѯ�����˵������Ϣ��</li>
		</ol>
	</div>

	<form action="" method="post">
	<div class="h_a">������Ϣ</div>
	<div class="table_full">
		<table width="100%">
			<colgroup>
					<col width="170">
					<col >
					<col width="170">
					<col >
			</colgroup>
		
			<tr>
				<th width="15%" >�ʺ�</th>
				<td width="35%" ><?=$username?>				</td>
				<th width="15%" >�����¼ʱ��</th>
				<td width="35%" ><?=$lasttime?></td>
			</tr>
			<tr>
				<th>ʹ��������</th>
				<td width="35%"><?=$xingming?></td>
				<th width="15%">USB-Key</th>
				<td width="35%"><?=$usbkey?></td>
			</tr>
			<tr>
			  <th>magic_quotes_gpc״̬</th>
			  <td><?
			  if (!get_magic_quotes_gpc()) {
					echo '<span style=color:red>δ����</span>';    // delete backslash(\)
				}else{
					echo '�ѿ���';
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
