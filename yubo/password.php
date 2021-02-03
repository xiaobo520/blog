<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$action=$_GET['action'];
$password0=quotes_gpc_pd($_POST['password0'],1);  //转义
$password1=quotes_gpc_pd($_POST['password1'],1);  //转义
$password2=quotes_gpc_pd($_POST['password2'],1);  //转义

if ($action=="edit"){

	if ($password0=="" || $password1=="" || $password2=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('原密码和新密码必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if ($password1 !== $password2){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('新密码两次输入不致！','alert_back','','error','');</script>";
		exit;
	}
	
	if (strlen ($password1)<6){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('密码至少6位以上！','alert_back','','error','');</script>";
		exit;
	}
	
	
	$sql="select username,password from lei_admin where username='".$_SESSION['blog_lileiuser']."'";
	$result=$mysqli->query($sql);
	
	if($rs=$result->fetch_assoc()){
		
		$post_pass=md5(md5($password0).md5('@xxhc_cn_lei_1'));//加密

		if($post_pass==$rs["password"]){
		
			$post_pass1=md5(md5($password1).md5('@xxhc_cn_lei_1'));//加密
		
			$sql="update lei_admin set password='".$post_pass1."' where username='".$_SESSION['blog_lileiuser']."'";
			$mysqli->query($sql);
			
			$mysqli->close();

			
			$back_url="&page=".$page."&".$pageurl."&time=".time();
			alert_ini();//输出alert所需文件
			echo "<script>alert_go('密码修改成功！','alert_go','','ok','?".$back_url."');</script>";
			exit;
		} 
		else{
			$mysqli->close();
			alert_ini();//输出alert所需文件
			echo "<script>alert_go('旧密码不正确！','alert_back','','error','');</script>";
			exit;
		}
	}else{
		$mysqli->close();
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('系统错误或系统超时！','alert_back','','error','');</script>";
		exit;
	}
	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />

<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">
<script src="js/jquery.min.js" type="text/javascript" charset="gbk" ></script>
<script src="js/bootstrap.min.js"></script>

</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	

	<div class="h_a">功能说明</div>
	<div class="prompt_text">
		<ol>
			<li>修改个人登录密码。</li>
			</ol>
	</div>

	<form name="form1" id="form1" method="POST" action="?action=edit">
	<div class="h_a">修改密码</div>
	<div class="table_full">
		<table width="100%" ><colgroup>
					<col class="th" >
					<col width="550">
					<col >
			</colgroup>
			<tr>
				<th>旧密码</span></th>
				<td><input name="password0" type="password" id="password0" class="input length_5"/></td>
				<td><div class="fun_tips">请输入旧密码</div></td>
			</tr>
			<tr>
				<th>新密码</th>
				<td><input name="password1" type="password" class="input length_5" id="password1" /></td>
				<td><div class="fun_tips">请输入新密码</div></td>
			</tr>
			<tr>
				<th>确认新密码</th>
				<td><input name="password2" type="password" class="input length_5" id="password2" /></td>
				<td><div class="fun_tips">请重复输入一次新密码</div></td>
			</tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('确认修改密码？','submit','form1','wen','')">修改密码</button>
		</div>
	</div>

	</form>
</div>
</body>
</html>
