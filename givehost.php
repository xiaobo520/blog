<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");

//$content = ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',quotes_gpc_pd($_POST['content'],0));
//$content = iconv("utf-8","gbk",$_POST['content']);

$action=$_REQUEST['action'];//型号
$max_fen = $_POST['max_fen'];//单年最高积分
$jiage=$_POST['jiage'];//单年基础价格
$host_jifen=$_POST['host_jifen'];//使用积分
$host_nianxian=$_POST['host_nianxian'];//年限
$xinghao=$_POST['xinghao'];//型号
$indate=date("Y-m-d H:i:s");

if ($host_jifen==''){
	$host_jifen=0;
}

if ($_SESSION['user_lei_username']!='' && $action=='2'){//写入订单成功后再二次回调此函数，防止同步时加载缓慢,JQ异步加载
	if ($sms_host_open=='1'){
		$overjiage=(($jiage*$host_nianxian)-$host_jifen);//单年基本价格*年限-使用积分
		
		require_once('./mdaima_var_inc/lib/Ucpaas.class.php');
		$options['accountsid']=$sms_accountsid;
		$options['token']=$sms_token;
		$ucpass = new Ucpaas($options);
		$appId = $sms_appId;
		$to = "15901121235";
		$templateId = "14583";//模板ID
		$param=iconv("gbk","utf-8",$_SESSION['user_lei_username'].",".$overjiage."元");//替换{1{2}}模板中的内容，多个以半角逗号分开
		$ucpass->templateSMS($appId,$to,$templateId,$param);//echo 可输出状态信息
	}
}

if ($_SESSION['user_lei_username']!='' && $action=='1'){

	$sql="select jifen from lei_user where username='".$_SESSION['user_lei_username']."' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$jifen_all=$rs["jifen"];
	}else{
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> 错误，【0090】！</span>";
		exit;
	}

	if ($host_jifen>$jifen_all){
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> 积分不足，您只有 '".$jifen_all."' 积分！</span>";
		exit;
	}
	
	if ($host_jifen>($max_fen*$host_nianxian)){
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> 最多可使用 '".$max_fen*$host_nianxian."' 积分！</span>";
		exit;
	}
	
	$dh=give_dh_18();
	
	$sql="insert into lei_host (dh,username,jiage,host_jifen,host_nianxian,xinghao,indate,zt) values ('".$dh."','".$_SESSION['user_lei_username']."','".$jiage."','".$host_jifen."','".$host_nianxian."','".iconv("utf-8","gbk",$xinghao)."','".$indate."','1') ";
	$mysqli->query($sql);
	
	
	$koujifen='-'.$host_jifen;
	jilu_in($_SESSION['user_lei_username'],$koujifen,'qita',iconv("utf-8","gbk",'积分兑换主机（'.$xinghao.'）'));//扣减积分
	
	$sql="update lei_cs set zt_tixing_host=zt_tixing_host+1 where id='1' limit 1 ";//后台提醒更新状态，回帖
	$mysqli->query($sql);

	echo "<span style='color:green'><i class='icon-info-sign'></i> 兑换成功，<a href='/zhuji.html' style='color:red;font-weight:bold'>查看详细</a></span>";
	exit;


}else{
	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 请登录后兑换！</span>";
	exit;
}
?>