<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];
$indate=date("Y-m-d H:i:s");

$linkname=quotes_gpc_pd($_POST['linkname'],1);
$url=quotes_gpc_pd($_POST['url'],1);
$pass=quotes_gpc_pd($_POST['pass'],1);
$px=quotes_gpc_pd($_POST['px'],1);

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
	
	$sql="delete from lei_link where id='".$id."'";
	$mysqli->query($sql);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('ɾ���ɹ���','alert_go','','ok','?".$back_url."');</script>";//����Ҫ���ز���
	exit;
		
	$mysqli->close();

}

if ($action=="edit"){

	
	if ($linkname=="" || $url=="" || $px==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('��Ϣ����Ϊ�գ�','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select * from lei_link where id='".$id."'";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$sql="update lei_link set linkname='".$linkname."',url='".$url."',px='".$px."',pass='".$pass."' where id='".$id."'";
		$mysqli->query($sql);
		
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�޸ĳɹ���','alert_go','','ok','?".$back_url."');</script>";
		exit;
	}else{
		$mysqli->close();
		echo "<script language=javascript>alert('ϵͳ�����ϵͳ��ʱ��');javascript:history.back(-1);</script>";
		exit;
	}
}

if ($action=="add"){

	if ($linkname=="" || $url=="" || $px==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('��Ϣ����Ϊ�գ�','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="insert into lei_link (linkname,url,px,indate,pass) values ('".$linkname."','".$url."','".$px."','".$indate."','".$pass."') ";  //д��������Ϣ
	$mysqli->query($sql);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('��ӳɹ���','alert_go','','ok','?".$back_url."');</script>";
	exit;
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


	<div class="h_a">��������-���</div>
		<div class="search_type cc mb10">
		<form action="?<?=encrypt_url("&page=".$page."&".$pageurl."&action=add&time=".time(),$key_url_md_5)?>" method="post" name="formsa" id="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<li>
					<label>��վ���ƣ�</label><input name="linkname" type="text" class="input length_3" id="linkname" value="">
				</li>
				
				<li>
					<label>��ַ��</label><input name="url" type="text" class="input length_3" id="url" value="http://">
				</li>
				
				<li>
					<label>״̬��</label><select name="pass" class="select_2" id="pass">
						<option value="ͨ��" selected >ͨ��</option>
						<option value="��ͣ" >��ͣ</option>
					</select>
				</li>

				<li>
					<label>����</label><input name="px" type="text" class="input length_3" id="px" value="" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>

				

			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit" type="button" onClick="alert_go('ȷ������������ӣ�','submit','formsa','wen','')" >�����������</button>
		</div>
		</form>
	</div>
	
	<div class="table_list">
	<table width="100%">
		
		<colgroup>
				<col width="5%">
				<col width="20%">
				<col width="20%">
				<col width="12%">
				<col width="15%">
				<col >
		</colgroup>
		
		<thead>
			<tr>
			  <td >���</td>
				<td >��������</td>
				<td >���ӵ�ַ</td>
				<td >����</td>
				<td >״̬</td>
				<td >����</td>
			</tr>
		</thead>
<?php
	
	$sql_search="select * from lei_link order by px ";
	$i=0;
	$result=$mysqli->query($sql_search);
	while ($rs=$result->fetch_assoc()){
	$i++;
?>
		<form action="?<?=encrypt_url("action=edit&id=".$rs["id"]."&".$pageurl."&time=".time(),$key_url_md_5)?>" method="post" id="formlist_<?=$rs["id"]?>" name="formlist_<?=$rs["id"]?>">
			<tr>
			  <td><?=$i?></td>
				<td><input name="linkname" type="text" class="input length_4" id="linkname" value="<?=$rs["linkname"]?>"></td>
				<td><input name="url" type="text" class="input length_4" id="url" value="<?=$rs["url"]?>"></td>
				<td><input name="px" type="text" class="input length_2" id="px" value="<?=$rs["px"]?>" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')"></td>
				<td><select name="pass" class="select_2" id="pass">
						<option value="��ͣ" <? if ($rs["pass"]=="��ͣ") {?>selected<? }?>>��ͣ</option>
						<option value="ͨ��" <? if ($rs["pass"]=="ͨ��") {?>selected<? }?> >ͨ��</option>
					</select></td>
			    <td>
				<button class="btn btn_submit" type="button" onClick="alert_go('ȷ���޸ģ�','submit','formlist_<?=$rs["id"]?>','wen','')" ><i class="icon-edit icon-white"></i> ����</button>
				&nbsp;&nbsp;
				<button class="btn btn_error" type="button" onClick="alert_go('ȷ��ɾ����','href','formlist_<?=$rs["id"]?>','wen','?<?=encrypt_url("&id=".$rs["id"]."&".$pageurl."&action=del&time=".time(),$key_url_md_5)?>')" ><i class="icon-trash icon-white"></i> ɾ��</button>
				</td>
			</tr>
		</form>
	<?php }?>
	</table>
	</div>
	
	
</div>


</body>
</html>
