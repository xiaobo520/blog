<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/conn.php"); 

$action=$_GET['action'];
$password=quotes_gpc_pd($_POST['password'],1);  //ת��
$username=quotes_gpc_pd($_POST['username'],1);

if ($action=="go"){

	if ($password=="" || $username==""){
		echo "<script language=javascript>alert('�û��������������д��');location.href='index.php';</script>";
		exit;
	}
	
	$sql="select username,password,pass,flag from lei_admin where username='".$username."'";
	$result=$mysqli->query($sql);

	//echo $sql;
	//exit;
	if($rs=$result->fetch_assoc()){
		if($rs["pass"]=="0" || $rs["pass"]=="del" ){
			$mysqli->close();
			echo "<script>alert('�����ʺŴ�������(���)״̬���޷���¼!');javascript:history.back(-1);</script>";
			exit;
		}
	
		$post_pass=md5($password.md5('@xxhc_cn_lei_1'));//����

		if($post_pass==$rs["password"]){
			
			$_SESSION['blog_lileiuser']=$username;
			$_SESSION['blog_lileiflag']=$rs["flag"];
			
			$lasttime=date("Y-m-d H:i:s");
			$sql="update lei_admin set lasttime='".$lasttime."' where username='".$username."'";//���������¼ʱ��
			$mysqli->query($sql);
			
			$mysqli->close();
			echo "<script>top.location.href='./';</script>";
			exit;
		} 
		else{
			$mysqli->close();
			echo "<script>alert('�û��������벻��ȷ[001]!');javascript:history.back(-1);</script>";
			exit;
		}
	}else{
		$mysqli->close();
		echo "<script language=javascript>alert('�û��������벻��ȷ[002]��');javascript:history.back(-1);</script>";
		exit;
	}
	

}
?>