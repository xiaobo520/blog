<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php");

//$content = ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',quotes_gpc_pd($_POST['content'],0));
//$content = iconv("utf-8","gbk",$_POST['content']);

$action=$_REQUEST['action'];//�ͺ�
$max_fen = $_POST['max_fen'];//������߻���
$jiage=$_POST['jiage'];//��������۸�
$host_jifen=$_POST['host_jifen'];//ʹ�û���
$host_nianxian=$_POST['host_nianxian'];//����
$xinghao=$_POST['xinghao'];//�ͺ�
$indate=date("Y-m-d H:i:s");

if ($host_jifen==''){
	$host_jifen=0;
}

if ($_SESSION['user_lei_username']!='' && $action=='2'){//д�붩���ɹ����ٶ��λص��˺�������ֹͬ��ʱ���ػ���,JQ�첽����
	if ($sms_host_open=='1'){
		$overjiage=(($jiage*$host_nianxian)-$host_jifen);//��������۸�*����-ʹ�û���
		
		require_once('./mdaima_var_inc/lib/Ucpaas.class.php');
		$options['accountsid']=$sms_accountsid;
		$options['token']=$sms_token;
		$ucpass = new Ucpaas($options);
		$appId = $sms_appId;
		$to = "15901121235";
		$templateId = "14583";//ģ��ID
		$param=iconv("gbk","utf-8",$_SESSION['user_lei_username'].",".$overjiage."Ԫ");//�滻{1{2}}ģ���е����ݣ�����԰�Ƕ��ŷֿ�
		$ucpass->templateSMS($appId,$to,$templateId,$param);//echo �����״̬��Ϣ
	}
}

if ($_SESSION['user_lei_username']!='' && $action=='1'){

	$sql="select jifen from lei_user where username='".$_SESSION['user_lei_username']."' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$jifen_all=$rs["jifen"];
	}else{
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> ���󣬡�0090����</span>";
		exit;
	}

	if ($host_jifen>$jifen_all){
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> ���ֲ��㣬��ֻ�� '".$jifen_all."' ���֣�</span>";
		exit;
	}
	
	if ($host_jifen>($max_fen*$host_nianxian)){
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> ����ʹ�� '".$max_fen*$host_nianxian."' ���֣�</span>";
		exit;
	}
	
	$dh=give_dh_18();
	
	$sql="insert into lei_host (dh,username,jiage,host_jifen,host_nianxian,xinghao,indate,zt) values ('".$dh."','".$_SESSION['user_lei_username']."','".$jiage."','".$host_jifen."','".$host_nianxian."','".iconv("utf-8","gbk",$xinghao)."','".$indate."','1') ";
	$mysqli->query($sql);
	
	
	$koujifen='-'.$host_jifen;
	jilu_in($_SESSION['user_lei_username'],$koujifen,'qita',iconv("utf-8","gbk",'���ֶһ�������'.$xinghao.'��'));//�ۼ�����
	
	$sql="update lei_cs set zt_tixing_host=zt_tixing_host+1 where id='1' limit 1 ";//��̨���Ѹ���״̬������
	$mysqli->query($sql);

	echo "<span style='color:green'><i class='icon-info-sign'></i> �һ��ɹ���<a href='/zhuji.html' style='color:red;font-weight:bold'>�鿴��ϸ</a></span>";
	exit;


}else{
	echo "<span style='color:red'><i class='icon-remove-sign' ></i> ���¼��һ���</span>";
	exit;
}
?>