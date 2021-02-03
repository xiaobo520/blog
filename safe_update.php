<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");


$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$p=$url_info['p'];
$u=$url_info['u'];
$times=$url_info['time'];

if ($p!='safe' || $p=='' || $u=='' || $times==''){//回贴总开关

	echo "<span style='color:red'>参数错误！</span>";
	exit;

}

$date2 = time(); //取当前时间的时间戳
$days=($date2-$times);

if ($days>1800){  //1800秒失效
	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 链接已失效！</span>";
	exit;
}

if ($_SESSION['safe_new_pass']==''){//防止刷新变化
	
	$sql="select username from lei_user where username='".$u."' limit 1 ";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$new_pass=randomkeys(8);
		
		$sql="update lei_user set password='".md5(md5($new_pass).md5('@lei_user7d'))."' where username='".$u."' limit 1";
		$mysqli->query($sql);
	}else{
		echo "<span style='color:red'>参数错误！</span>";
		exit;
	}
}else{
	$new_pass=$_SESSION['safe_new_pass'];
}
$_SESSION['safe_new_pass']=$new_pass;
?><style type="text/css">
<!--
body,td,th,div{
	font-size: 12px;font-family:微软雅黑
}
a:link {
	color: #333333;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: none;
	color: #666666;
}
a:active {
	text-decoration: none;
	color: #666666;
}
-->
</style>

<title>找回密码-码代码-李雷博客</title>

<div style="width:100%;margin:100px auto; text-align:center; color:#999999; font-size:18px;font-family:微软雅黑; line-height:100px;">您的新密码：<span style="color:#FF0000; font-weight:bold; font-size:32px;"><?=$new_pass?></span><a href="/login.html" style="color:#999999; font-size:12px; margin-left:30px" >立即登录</a></div>

<div style="margin:100px auto; clear:both; line-height:80px;text-align:center; width:100%; color:#999999">版权所有：<a href="/" style="color:#999999" target="_blank">码代码-PHP技术经验教程分享-李雷博客！</a>&nbsp;&nbsp;&nbsp;ICP备案号：京ICP备10202169号</div>