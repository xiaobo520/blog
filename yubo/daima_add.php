<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
//--------------������������
include_once("jingyan_post_all.php"); 
//--------------������������
$action=$url_info['action'];
$time=$url_info['time'];

//�޸��û�-��ʼ

if ($action=="add"){

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
	
	
	
	if ($indate==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�������ڣ�������д��','alert_back','','error','');</script>";
		exit;
	}
	
	$title_code = quweima($title);//������תΪ������λ����
	
	$sql="insert into lei_daima (title,message,indate,fenzu,pass,px) values ('".$title."','".$message."','".$indate."','".$fenzu."','".$pass."','".$px."') ";
	$mysqli->query($sql);

	$result_zidian=$mysqli->query("select last_insert_id()");//mysql_insert_id($mysqli);//��ȡ�Զ�����
	if($mysqllast=$result_zidian->fetch_assoc()){
		$aid=$mysqllast["last_insert_id()"];//����ID
	}
	
	$back_url=encrypt_url("&page=".$page."&aid=".$aid."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('������ӳɹ���','alert_go','','ok','daima_list.php?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//����

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

	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&".$pageurl."&action=add&time=".time(),$key_url_md_5)?>"><!--//���������� -->
	<div class="h_a">��Ӵ������Ϣ</div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
			<tr>
			  <th>�������</th>
			  <td>
			  <input name="title" type="text" id="title" value="" class="input length_5" /></td>
		  </tr>
			
			<tr>
			  <th>�������</th>
			  <td>
						<?
						$sql_search2="select * from lei_daima_bk where pass='1' order by px";
						$result2=$mysqli->query($sql_search2);
						$i=0;
						while ($rs2=$result2->fetch_assoc()){
						$i++;

						?>	<div style="float:left; width:180px; height:25px;">
							<input name="fenzu" type="radio" value="<?=$rs2["id"]?>" /> <?=$rs2["keyword"]?>
							</div>
						<? 
						}?></td>
		  </tr>
		   <tr>
			  <th>������</th>
			  <td>
			  <input name="px" type="text" id="px" value="10000" class="input length_5" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
		  </tr>
			<tr>
			  <th>����״̬</th>
			  <td><select name="pass" class="select_5" id="pass">
						<option value="0" selected >δ����</option>
						<option value="1" >����</option>
					</select></td>
		  </tr>
			<tr>
			  <th>��������</th>
			  <td>
			  <input name="indate" type="text" id="indate" value="<?=date("Y-m-d H:i:s")?>" onFocus="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="true" class="input length_5" /></td>
		  </tr>
			

			<tr>
			  <th>��������</th>
			  <td><script id="editor1" name="message1" type="text/plain" style="width:99%;height:150px;"></script></td>
		  </tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('ȷ�ϱ�����룿','submit','formsa','wen','')" >�������</button>
			&nbsp;
			<?
			$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
			?>
			<button class="btn btn_big loading_it" type="button" onClick="document.location.href='daima_list.php?<?=$back_url?>';" > �����б� </button>
			
			
		</div>
	</div>

	</form>
</div>

<script type="text/javascript">
    var ue1 = UE.getEditor('editor1');
</script>
</body>
</html>
