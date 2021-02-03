<?
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$id=$url_info['id'];
$action=$url_info['action'];
$time=$url_info['time'];


if ($action=="edit"){

	$message=quotes_gpc_pd($_POST['message'],0);
	
	if ($message=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('信息必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	$indate=date("Y-m-d H:i:s");
	
	$sql="update lei_message set message='".$message."' where id='".$id."' ";
	$mysqli->query($sql);
	
	$back_url=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	alert_ini();//输出alert所需文件
	echo "<script>alert_go('保存成功！','alert_go','','ok','message_edit.php?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//结束


$sql="select * from lei_message where id='".$id."' limit 1 ";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$title=$rs["title"];
	$message=$rs["message"];
}else{
	echo "系统错误或超时！";
	$mysqli->close();
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor_1.config.js"></script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	

	<div class="h_a">功能说明</div>
  <div class="prompt_text">
		<ol>
			<li>前台信息编辑。</li>
		</ol>
	</div>

	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&action=edit&time=".time(),$key_url_md_5)?>"><!--//加密链变量 -->
	<div class="h_a">前台信息编辑-<?=$title?></div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
				<col class="th" >
				<col >
			</colgroup>

			<tr>
			  <th>详细内容</th>
			  <td style="line-height:23px;">
			  	<script id="editor1" name="message" type="text/plain" style="width:99%;height:200px;"><?=$message?></script>
				<script>
					var ue1 = UE.getEditor('editor1');
				</script>
			  </td>
		  </tr>
			
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('确认保存信息？','submit','formsa','wen','')">保存信息</button>
		</div>
	</div>

	</form>
</div>


</body>
</html>
