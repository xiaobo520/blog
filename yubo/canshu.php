<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$action=$_GET['action'];
$page=$_REQUEST['page'];

$csurl="../mdaima_var_inc/config_system_info.php";

if ($action=="edit"){
	
	$content=stripslashes($_POST['content']); //  ��ΪGPC �ǿ��ģ�Ҫ���˵������\
	
	if ($content=='' ){
		echo "<script language=javascript>alert('��������Ϊ�գ�');javascript:history.back(-1);</script>";
		exit;
	}
	
	$content="<?php ".$content." ?>";
	
	file_put_contents($csurl,$content);//�����ļ�
	
	
	$back_url=encrypt_url("&time=".time(),$key_url_md_5);
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('�޸ĳɹ���','alert_go','','ok','?".$back_url."');</script>";
	exit;
}

$content=file_get_contents($csurl);//��ȡԴ��
$content=str_replace("<?php","",$content);
$content=str_replace("?>","",$content);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	

	<form name="form1" id="form1" method="POST" action="?action=edit">
	<div class="h_a">��������</div>
	<div class="table_full">
		<table width="100%" style="margin-bottom:45px;">
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
			<tr>
				<th>��������</span></th>
				<td><textarea name="content" id="content" style=" width:90%;height:300px; padding:10px; line-height:30px; background:url(images/hld.jpg) repeat;" disabled="disabled"><?=$content?></textarea></td>
			</tr>
		</table>
	</div>
	
	<div class="btn_wrap">
		<div class="btn_wrap_pd">
			<button class="btn btn_error btn_big" type="button" onClick="document.getElementById('content').disabled='';document.getElementById('editbut').disabled='';document.getElementById('editbut').className='btn btn_submit btn_big';" > �����༭ </button>
			&nbsp;
			<button class="btn btn_big btn_submit disabled" type="button" id="editbut" disabled="disabled" onClick="alert_go('�޸�ǰ����ϸ�˶Ա�����Ϣ��ȱ�������ַ����������ϵͳ���д���ȷ���޸ģ�','submit','form1','wen','')" >�޸�����</button>
			
		</div>
	</div>

	</form>
</div>
</body>
</html>
