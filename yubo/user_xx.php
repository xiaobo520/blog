<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
//--------------������������
include_once("news_post_all.php"); 
//--------------������������
$id=$url_info['id'];
$action=$url_info['action'];
$time=$url_info['time'];

//�޸��û�-��ʼ

if ($action=="edit"){

	$nicheng=quotes_gpc_pd($_POST['nicheng'],1);
	$nicheng_py=quotes_gpc_pd($_POST['nicheng_py'],1);
	$tel=quotes_gpc_pd($_POST['tel'],1);
	$pass=quotes_gpc_pd($_POST['pass'],1);
	$password=quotes_gpc_pd($_POST['password'],1);
	
	if ( $tel!='' ){
		if (check_tel_mail($tel,1)=='result_false'){
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('�ֻ�����Ǳ�׼��ʽ��','alert_back','','error','');</script>";
			exit;
		}else{
			$sql="select tel from lei_user where tel='".$tel."' and id<>'".$id."' limit 1 " ;//������ǰ�û�������û��Ƿ��а�����ֻ������
			$result=$mysqli->query($sql);
			if($rs=$result->fetch_assoc()){
				alert_ini_index();//���alert�����ļ�
				echo "<script>alert_go('�ֻ����벻���ظ��󶨣�','alert_back','','error','');</script>";
				exit;
			}
		}
	}

	if ($password=='1'){
		//md5($password.md5('@lei_user7d'))
		$update_password=",password='".md5(md5('000000').md5('@lei_user7d'))."'";
	}else{
		$update_password='';
	}
	//ƴ�����û��޸�Ĭ����PHP���ɣ���̨�����ֶ����JS�޸�

	$sql="update lei_user set nicheng='".$nicheng."',nicheng_py='".$nicheng_py."',tel='".$tel."',pass='".$pass."'".$update_password." where id='".$id."' limit 1";
	$mysqli->query($sql);
	
	$back_url=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('�û���Ϣ����ɹ���','alert_go','','ok','?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//����

$sql="select * from lei_user where id='".$id."' limit 1 ";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$username=$rs["username"];
	$nicheng=$rs["nicheng"];
	$nicheng_py=$rs["nicheng_py"];
	$tel=$rs["tel"];
	$userimg=$rs["userimg"];
	$jifen=$rs["jifen"];
	$jifen_all=$rs["jifen_all"];
	$pass=$rs["pass"];
	$indate=$rs["indate"];
	$lasttime=$rs["lasttime"];
}else{
	echo "ϵͳ�����ʱ��";
	$mysqli->close();
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">
<script src="js/pinyin.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
<script language="JavaScript" type="text/javascript" src="js/pic.js"></script>
  
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:6;
}
-->
</style>
</head>

<body>
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	

	<div class="h_a">����˵��</div>
	<div class="prompt_text">
		<ol>
			<li>�û�״̬��Ϊ����ˡ������������͡���ɾ������</li>
		</ol>
	</div>

	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&action=edit&time=".time(),$key_url_md_5)?>"><!--//���������� -->
	<div class="h_a">�޸��û���Ϣ</div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
			<tr>
			  <th>�û���</th>
			  <td><?=$username?></td>
		  </tr>
		  <tr>
		      <th>�ǳ�</th>
		      <td><input name="nicheng" type="text" class="input length_5" id="nicheng" value="<?=$nicheng?>" maxlength="30" onBlur="document.getElementById('nicheng_py').value=CC2PY(this.value).toUpperCase();" onKeyUp="document.getElementById('nicheng_py').value=CC2PY(this.value).toUpperCase()"/></td>
	      </tr>
		  
		   <tr>
		      <th>�ǳ�ƴ����</th>
		      <td><input name="nicheng_py" type="text" class="input length_5" id="nicheng_py" value="<?=$nicheng_py?>" maxlength="30" /></td>
	      </tr>
			
		  <tr>
			  <th>���ֻ���</th>
			  <td>
			  <input name="tel" type="text" id="tel" value="<?=$tel?>" class="input length_5" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
		  </tr>
		   <tr>
			  <th>ʣ�����</th>
			  <td><?=$jifen?> ��</td>
		  </tr>
		   <tr>
			  <th>��ʷ����</th>
			  <td><?=$jifen_all?> ��</td>
		  </tr>
			<tr>
			  <th>�û�ͷ��</th>
			  <td><a href="<?=$userimg?>" target="_blank"><img src="<?=$userimg?>" width="50" height="50" /></a></td>
		  </tr>
			<tr>
			  <th>�û�״̬</th>
			  <td><select name="pass" class="select_5" id="pass">
						<option value="0" <? if ($pass=='0'){?>selected="selected"<? }?> >�����</option>
						<option value="1" <? if ($pass=='1'){?>selected="selected"<? }?>>����</option>
						<option value="1" <? if ($pass=='90'){?>selected="selected"<? }?>>��ɾ��</option>
					</select></td>
		  </tr>
		   <tr>
			  <th>ע��ʱ��</th>
			  <td><?=$indate?>
			  </td>
		  </tr>
		  <tr>
			  <th>����Ծ</th>
			  <td><?=$lasttime?></td>
		  </tr>
		  <tr>
			  <th>��ʼ����</th>
			  <td><input name="password" type="checkbox" id="password" value="1" onClick="if (this.checked){return confirm('ȷ��Ҫ��ʼ���û������룿')}"> ȷ�ϳ�ʼ����&nbsp;&nbsp;&nbsp; &nbsp;����ѡ����ʾ�����û��������Ϊ��ʼ 000000 ��</td>
		  </tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('ȷ���޸��û���Ϣ��','submit','formsa','wen','')" >������Ϣ</button>
			&nbsp;
			<?
			$back_url=encrypt_url("&page=".$page."&aid=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
			?>
			<button class="btn btn_big loading_it" type="button" onClick="document.location.href='user.php?<?=$back_url?>';" > �����б� </button>
			
			
		</div>
	</div>

	</form>
</div>

<div id="a1" style=" position:absolute; z-index:9999;"></div>

<? /*
<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" /><!--����JQ -->
<script type="text/javascript" src="js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript">
	//<img id="photo" src="/images/1.jpg" />
	$(document).ready(function () {
		$('#photo').imgAreaSelect({ maxWidth: 217, maxHeight: 156, handles: true,fadeSpeed: 200});
		//{ aspectRatio: '4:3', handles: true }{ x1: 120, y1: 90, x2: 280, y2: 210 , onSelectChange: preview }
	});
</script>
*/
?>
</body>
</html>
