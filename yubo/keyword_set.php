<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

//--------------������������
$action_pd=$url_info['action_pd'];

//--------------������������
//print_r($url_info);
$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];

if ($action=="edit"){

	if ( (time()-$time)>$var_outhours*3600 ){
		echo "<script language=javascript>alert('��ҳ���ڣ���ֹ������');javascript:history.back(-1);</script>";
		exit;
	}
	
	$name_search=quotes_gpc_pd($_POST['keyword_name'],1);
	$pass_search=quotes_gpc_pd($_POST['zhongdian_pass'],1);
	$px_search=quotes_gpc_pd($_POST['zhongdian_px'],1);
	
	if ($name_search=="" || $pass_search=="" || $px_search=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�����������д��','alert_back','','error','');</script>";
		exit;
	}

	$sql="select * from lei_keyword where id='".$id."' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		
		$indate=date("Y-m-d H:i:s");
		
		$sql="update lei_keyword set keyword='".$name_search."',pass='".$pass_search."',px='".$px_search."' where id='".$id."' limit 1";
		$mysqli->query($sql);

		$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
		
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�ؼ����޸ĳɹ���','alert_go','','ok','?".$back_url."');</script>";
		exit;
		
	}else{
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('ID�����ڣ�','alert_back','','error','');</script>";
		exit;
	}
	$mysqli->close();

}

if ($action=="add"){

	$name_search=quotes_gpc_pd($_POST['name_search'],1);
	$pass_search=quotes_gpc_pd($_POST['pass_search'],1);
	$px_search=quotes_gpc_pd($_POST['px_search'],1);

	if ($name_search=="" || $pass_search=="" || $px_search=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�����������д��','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select * from lei_keyword where keyword='".$name_search."' limit 1";
	$result=$mysqli->query($sql);
	if(!$rs=$result->fetch_assoc()){
		
		$sql="insert into lei_keyword (keyword,pass,px) values ('".$name_search."','".$pass_search."','".$px_search."') ";
		$mysqli->query($sql);

		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�ؼ�����ӳɹ���','alert_go','','ok','?".$back_url."');</script>";
		exit;
	}else{
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�ؼ����Ѿ����ڣ�','alert_back','','error','');</script>";
		exit;
	}
	$mysqli->close();

}
//����


if ($action=="del"){

	if ( (time()-$time)>$var_outhours*3600 ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('��ҳ���ڣ���ֹ������','alert_back','','error','');</script>";
		exit;
	}

	if ($id==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('ID�����ڣ�','alert_back','','error','');</script>";
		exit;
	}

	
	$sql="select * from lei_keyword where id='".$id."' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		$sql="update lei_keyword set pass='0' where id='".$id."' limit 1";
		$mysqli->query($sql);

		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�ؼ���״̬תΪ��Ч��','alert_go','','ok','?".$back_url."');</script>";
		exit;
	}else{
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('ID�����ڣ�','alert_back','','error','');</script>";
		exit;
	}
	$mysqli->close();

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" />
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	


	<div class="h_a">��Ϣ����</div>
		<div class="search_type cc mb10">
		<form action="?<?=encrypt_url("&page=".$page."&".$pageurl."&action=add&time=".time(),$key_url_md_5)?>" method="post" name="formsa" id="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<li>
					<label>��ǩ���ݣ�</label><input name="name_search" type="text" class="input length_2" id="name_search" value="">
				</li>

				<li>
					<label>�Ƿ���Ч��</label><select name="pass_search" class="select_2" id="pass_search">
						<option value="1" selected >��Ч</option>
						<option value="0" >��Ч</option>
					</select>
				</li>

				<li>
					<label>��ǩ����</label><input name="px_search" type="text" class="input length_2" id="px_search" value="" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>

				

			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit" type="button" onClick="alert_go('ȷ����ӹؼ��ʣ�','submit','formsa','wen','')" >��ӹؼ���</button>
		</div>
		</form>
	</div>
	
	<div class="table_list">
	<table width="100%">
		
		<colgroup>
				<col width="5%">
				<col>
				<col width="20%">
				<col width="20%">
				<col width="23%">
		</colgroup>
		
		<thead>
			<tr>
			  <td >���</td>
				<td >��ǩ����</td>
				<td >��Ч������</td>
				<td >����</td>
				<td >����</td>
			</tr>
		</thead>
<?php
	
	$sql_search="select * from lei_keyword where pass<>'90' order by px "; //����ʾ��ɾ����
	$i=0;
	$result=$mysqli->query($sql_search);
	while ($rs=$result->fetch_assoc()){
	$i++;
?>
		<form action="?<?=encrypt_url("action=edit&id=".$rs["id"]."&".$pageurl."&time=".time(),$key_url_md_5)?>" method="post" id="formlist_<?=$rs["id"]?>" name="formlist_<?=$rs["id"]?>">
			<tr>
			  <td><?=$i?></td>
				<td><input name="keyword_name" type="text" class="input length_4" id="keyword_name" value="<?=$rs["keyword"]?>"></td>
				<td><select name="zhongdian_pass" class="select_2" id="zhongdian_pass">
						<option value="0" <? if ($rs["pass"]=="0") {?>selected<? }?>>��Ч</option>
						<option value="1" <? if ($rs["pass"]=="1") {?>selected<? }?> >��Ч</option>
					</select></td>
			    <td><input name="zhongdian_px" type="text" class="input length_2" id="zhongdian_px" value="<?=$rs["px"]?>" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')"/></td>
			    <td>
				<button class="btn btn_submit" type="button" onClick="alert_go('ȷ���޸ģ�','submit','formlist_<?=$rs["id"]?>','wen','')" ><i class="icon-edit icon-white"></i> ��������</button>
				<? if ($rs["pass"]=='1'){?>
				&nbsp;&nbsp;
				<button class="btn btn_error" type="button" onClick="alert_go('ȷ��������Ч��Ĭ��ֻ�ǽ��ؼ���תΪ��Ч��','href','formlist_<?=$rs["id"]?>','wen','?<?=encrypt_url("&id=".$rs["id"]."&".$pageurl."&action=del&time=".time(),$key_url_md_5)?>')" ><i class="icon-trash icon-white"></i> ������Ч</button>
				<? }?>
							</td>
			</tr>
		</form>
	<?php }?>
	</table>
	</div>
	
	
</div>


</body>
</html>
