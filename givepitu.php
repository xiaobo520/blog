<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php");
include_once("./mdaima_var_inc/sendmail.php");//�����ʼ���


//$content = ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',quotes_gpc_pd($_POST['content'],0));
//$content = iconv("utf-8","gbk",$_POST['content']);
$src_i = $_POST['src_i'];

$indate=date("Y-m-d H:i:s");

if( $_SERVER['HTTP_REFERER'] == "" ){
	//header("Location:".$fromurl); 
	exit;
}

if ($_SESSION['user_lei_username']!=''){
	$cz_user=$_SESSION['user_lei_username'];
	
	$zt_pintu=jilu_in($cz_user,$var_jifen_pintu,'pintu','');//����
	if ($zt_pintu=='��ȡ����OK'){
		echo "��ϲ�����ɹ���ɱ�����Ϸ����׬ȡ��".$var_jifen_pintu."���֣�";	
	}else{
		echo "��ϲ�����ɹ���ɱ�����Ϸ����û�л���ඣ�ÿ��ֻ����ȡһ��ƴͼ���֣������ټ����ɣ���";	
	}

}else{
	echo "��ϲ�����ɹ���ɱ�����Ϸ������¼���׬ȡ����Ŷ����"; //�ǵ�¼�û������жϣ�ֻ�ӹ�ϲ

}
?>