<?php

if($_SESSION['blog_lileiuser']=="" || !isset($_SESSION['blog_lileiflag'])){
	echo "<script language=javascript>alert('���ѳ�ʱ��δ��¼��');top.location.href='index.php';</script>";
	exit;
}

//include_once("config_limit.php");//������֤ҳ��Ȩ��
?>