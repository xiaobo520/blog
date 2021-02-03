<?
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php");  

$action=$_REQUEST['action'];

if ($action=='chk'){
	$tishi_str='';
	$sql="select zt_tixing_reg,zt_tixing_huitie,zt_tixing_host from lei_cs where id='1' limit 1 ";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$zt_tixing_reg=$rs["zt_tixing_reg"];
		$zt_tixing_huitie=$rs["zt_tixing_huitie"];
		$zt_tixing_host=$rs["zt_tixing_host"];
	}
	
	$close_open='false';
	
	if ($zt_tixing_reg>0){
		$tishi_str=$tishi_str."有 <span style='color:red;font-weight:bold;'>".$zt_tixing_reg."</span> 位新会员注册！";
		$close_open='true';
	}
	
	if ($zt_tixing_huitie>0){
		$tishi_str=$tishi_str."有 <span style='color:red;font-weight:bold;'>".$zt_tixing_huitie."</span> 条新回复！";
		$close_open='true';
	}
	
	if ($zt_tixing_host>0){
		$tishi_str=$tishi_str."有 <span style='color:red;font-weight:bold;'>".$zt_tixing_host."</span> 笔主机订单！";
		$close_open='true';
	}
	
	if ($close_open=='true'){
		echo "1|".$tishi_str." <a href='javascript:void(0)' onclick=document.location.href='?action=quxiao';document.getElementById('newtishi').style.display='none' target='frmright' style='text-decoration:none; color:#0066FF'>取消提醒</a>";
	}else{
		echo "0|0";
	}
}else{
	echo "0|0"; //终止
}

?>