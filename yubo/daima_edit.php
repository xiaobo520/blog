<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
//--------------������������
include_once("daima_post_all.php"); 
//--------------������������
$id=$url_info['id'];
$action=$url_info['action'];
$time=$url_info['time'];

//�޸��û�-��ʼ

if ($action=="baidu"){
	$urls = array(
		'http://'.$var_domain.'/',
		'http://'.$var_domain.'/jingyan/'.$id.'.html',
	);
	
	$api = 'http://data.zz.baidu.com/urls?site=www.mdaima.com&token=jImfT6HgJcLOFRt2';
	$ch = curl_init();
	$options =  array(
		CURLOPT_URL => $api,
		CURLOPT_POST => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POSTFIELDS => implode("\n", $urls),
		CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
	);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	
	$back_url=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('��ٶ����ͳɹ���[".$result."]','alert_go','','ok','?".$back_url."');</script>";
	exit;
}
	
if ($action=="edit"){
	
	$title=quotes_gpc_pd($_POST['title'],1);
	$fenzu=$_POST['fenzu'];
	$message=quotes_gpc_pd($_POST['message1'],0);
	$indate=quotes_gpc_pd($_POST['indate'],1);
	$pass=quotes_gpc_pd($_POST['pass'],1);
	$px=quotes_gpc_pd($_POST['px'],1);
	

	if ($title=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('������������д��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($fenzu==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('������࣬������д�����޷��ϱ�ǩ��������ӣ���','alert_back','','error','');</script>";
		exit;
	}
	
	if ($px==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('���򣬱�����д��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($message=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�������ݱ�����д','alert_back','','error','');</script>";
		exit;
	}
	
	if ($indate==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�������ڣ�������д��','alert_back','','error','');</script>";
		exit;
	}
	
	$title_code = quweima($title);//������תΪ������λ����

	
	$sql="update lei_daima set title='".$title."',indate='".$indate."',px='".$px."',pass='".$pass."',message='".$message."',fenzu='".$fenzu."' where id='".$id."' ";
	$mysqli->query($sql);
	
	$back_url=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('���뱣��ɹ���','alert_go','','ok','?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//����

$sql="select * from lei_daima where id='".$id."' limit 1 ";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$title=$rs["title"];
	$fenzu=$rs["fenzu"];
	$indate=$rs["indate"];
	
	$message=$rs["message"];
	$pass=$rs["pass"];
	$px=$rs["px"];

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
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor_daima.config.js"></script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

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
			<li>����״̬��Ϊ��δ�������͡�����������δ������״̬�µĴ���ǰ̨����ʾ��</li>
		</ol>
	</div>

	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&action=edit&time=".time(),$key_url_md_5)?>"><!--//���������� -->
	<div class="h_a">�޸Ĵ������Ϣ</div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
			<tr>
			  <th>���±���</th>
			  <td>
			  <input name="title" type="text" id="title" value="<?=$title?>" class="input length_5" /></td>
		  </tr>
			
			<tr>
			  <th>���ݱ�ǩ</th>
			  <td>
						<?

						$sql_search2="select * from lei_daima_bk where pass='1' order by px";
						$result2=$mysqli->query($sql_search2);
						$i=0;
						while ($rs2=$result2->fetch_assoc()){
						$i++;

						?>	<div style="float:left; width:180px; height:25px;">
							<input name="fenzu" type="radio" value="<?=$rs2["id"]?>" <? if( $rs2["id"]==$fenzu){?>checked="checked"<? }?>/> <?=$rs2["keyword"]?>
							</div>
						<? 
						}?></td>
		  </tr>
		  
		   <tr>
			  <th>������</th>
			  <td>
			  <input name="px" type="text" id="px" value="<?=$px?>" class="input length_5" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
		  </tr>
			
			<tr>
			  <th>����״̬</th>
			  <td><select name="pass" class="select_5" id="pass">
						<option value="0" <? if ($pass=='0'){?>selected="selected"<? }?> >δ����</option>
						<option value="1" <? if ($pass=='1'){?>selected="selected"<? }?>>����</option>
					</select></td>
		  </tr>
		 
			<tr>
			  <th>��������</th>
			  <td>
			  <input name="indate" type="text" id="indate" value="<?=$indate?>" onFocus="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="true" class="input length_5" /></td>
		  </tr>
			

			<tr>
			  <th>��������</th>
			  <td><script id="editor1" name="message1" type="text/plain" style="width:99%;height:150px;"><?=$message?></script>			  </td>
		  </tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('ȷ�ϱ�����룿','submit','formsa','wen','')" >�������</button>
			&nbsp;
			<?
			$back_url=encrypt_url("&page=".$page."&aid=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
			?>
			<button class="btn btn_big loading_it" type="button" onClick="document.location.href='daima_list.php?<?=$back_url?>';" > �����б� </button>
			
			
		</div>
	</div>

	</form>
</div>

<script type="text/javascript">
    var ue1 = UE.getEditor('editor1');
</script>
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
