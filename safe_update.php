<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php");


$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$p=$url_info['p'];
$u=$url_info['u'];
$times=$url_info['time'];

if ($p!='safe' || $p=='' || $u=='' || $times==''){//�����ܿ���

	echo "<span style='color:red'>��������</span>";
	exit;

}

$date2 = time(); //ȡ��ǰʱ���ʱ���
$days=($date2-$times);

if ($days>1800){  //1800��ʧЧ
	echo "<span style='color:red'><i class='icon-remove-sign' ></i> ������ʧЧ��</span>";
	exit;
}

if ($_SESSION['safe_new_pass']==''){//��ֹˢ�±仯
	
	$sql="select username from lei_user where username='".$u."' limit 1 ";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$new_pass=randomkeys(8);
		
		$sql="update lei_user set password='".md5(md5($new_pass).md5('@lei_user7d'))."' where username='".$u."' limit 1";
		$mysqli->query($sql);
	}else{
		echo "<span style='color:red'>��������</span>";
		exit;
	}
}else{
	$new_pass=$_SESSION['safe_new_pass'];
}
$_SESSION['safe_new_pass']=$new_pass;
?><style type="text/css">
<!--
body,td,th,div{
	font-size: 12px;font-family:΢���ź�
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

<title>�һ�����-�����-���ײ���</title>

<div style="width:100%;margin:100px auto; text-align:center; color:#999999; font-size:18px;font-family:΢���ź�; line-height:100px;">���������룺<span style="color:#FF0000; font-weight:bold; font-size:32px;"><?=$new_pass?></span><a href="/login.html" style="color:#999999; font-size:12px; margin-left:30px" >������¼</a></div>

<div style="margin:100px auto; clear:both; line-height:80px;text-align:center; width:100%; color:#999999">��Ȩ���У�<a href="/" style="color:#999999" target="_blank">�����-PHP��������̷̳���-���ײ��ͣ�</a>&nbsp;&nbsp;&nbsp;ICP�����ţ���ICP��10202169��</div>