<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

//--------------������������
include_once("user_post_all.php"); 
//--------------������������
//print_r($url_info);
$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];
$aid=$url_info['aid'];


if ($action=="shangbao" ){//�ύ

	if ( (time()-$time)>$var_outhours*3600 ){
		echo "<script language=javascript>alert('��ҳ���ڣ���ֹ������');javascript:history.back(-1);</script>";
		exit;
	}
	
	$pass=$url_info['pass'];
	
	$sql="update lei_user set pass='".$pass."' where id='".$id."'";
	$mysqli->query($sql);
	
	$mysqli->close();
	$back_url=encrypt_url("&page=".$page."&aid=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('״̬ת���ɹ���','alert_go','','ok','?".$back_url."');</script>";
	exit;
	
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="js/checkpinzhong.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	

	<div class="h_a">��Ϣ����</div>
		<div class="search_type cc mb10">
		<form action="?" method="post" id="formsa" name="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<? include_once("user_form_all.php");?>
			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit loading_it" type="submit">����</button>
		</div>
		</form>
	</div>
	
	<div class="table_list">
	<table width="100%"  id="mytable">
		
		<colgroup>
				<col width="5%">
				<col >
				<col width="12%">
				<col width="12%">
				<col width="15%">
				<col width="15%">
				<col width="8%">
				<col width="17%">
		</colgroup>
		
		<thead>
			<tr>
			  	<td >���</td>
				<td >�û���/�ǳ�</td>
				<td >���ֻ���</td>
				<td >����/��ʷ����</td>
				<td >ע��ʱ��</td>
				<td >�����Ծ</td>
				<td >״̬</td>
				<td >����</td>
			</tr>
		</thead>
<?php

	include_once("user_sql_all.php"); 
	
	$sql_page="select count(*) from lei_user where ".$searchstr."";
	$result_page=$mysqli->query($sql_page);
	$rs_page=$result_page->fetch_array();
	if ($pagenums_search!=''){
		$pagenum=$pagenums_search;   //�Զ���ÿҳ��ʾ����
		if ($pagenum==0) $pagenum=15;
	}else{
		$pagenum=15;   //ÿҳ��ʾ����
	}
	$pageidcount=$rs_page[0];
	$allnum=ceil($rs_page[0]/$pagenum);//��ҳ��
	
	if($page=="") $page=1;
	if($page<=1) $page=1;
	if($page>=$allnum)$page=$allnum;//��Ϊpage�Ǵ�0��ʼ�ģ�����Ҫ-1
	$pagestart=($page-1)*$pagenum;
	if($pagestart<=0) $pagestart=0; 
	
	$sql_search="select * from lei_user where ".$searchstr." ".$px_str." limit ".$pagestart.",".$pagenum." ";
	
	$i=$pagestart;
	$result=$mysqli->query($sql_search);
	while ($rs=$result->fetch_assoc()){
	$i++;
		
?>
			<tr>
			  <td><?=$i?><? if ($aid==$rs["id"]){?> <i class="icon-eye-open"></i><? }?></td>
				<td><?=$rs["username"]?><br /><?=$rs["nicheng"]?></td>
				<td><? if ($rs["tel"]!=''){echo $rs["tel"];}else{echo '---';}?></td>
				<td><?=$rs["jifen"]?> / <?=$rs["jifen_all"]?></td>
				<td><?=$rs["indate"]?></td>
				<td><?=$rs["lasttime"]?></td>
			    <td><?
				if ($rs["pass"]=='0'){ echo "<span style='color:red'>�����</span>";}elseif ($rs["pass"]=='1'){ echo "<span style='color:green'>����</span>";}elseif ($rs["pass"]=='90'){ echo "<span style='color:red;text-decoration:line-through'>��ɾ��</span>";}
				?></td>
			    <td>
					  <a class="loading_it" href="user_xx.php?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5)?>"><i class="icon-edit"></i> ��ϸ</a>
					  <?
					   if ( $rs["pass"]=='0'){?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('ȷ��״̬תΪ��ͨ������','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&pass=1&time=".time(),$key_url_md_5)?>');" ><i class="icon-upload"></i> ͨ��</a>
					  <? }?>
					  
					  <?
					   if ( $rs["pass"]=='1'){?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('ȷ��״̬תΪ����ˡ���','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&pass=0&time=".time(),$key_url_md_5)?>');" ><i class="icon-download"></i> ���</a>
					  <? }?>
					  
					  <?
					   if ( $rs["pass"]=='0'){//δ������ɾ��?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('ȷ��ɾ���û���ɾ�����û����������վ������ʵ��ɾ����','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&pass=90&time=".time(),$key_url_md_5)?>');" ><i class="icon-trash"></i> ɾ��</a>
					  <? }?>
					  
					  <?
					   if ( $rs["pass"]=='90'){//δ������ɾ��?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('ȷ�ϻָ��û����ָ���״̬Ϊ����ˡ���','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&pass=0&time=".time(),$key_url_md_5)?>');" ><i class="icon-share"></i> �ָ�</a>
					  <? }?>
					  
					  </td>
			</tr>
			
	<?php 
	}
	//sleep(3);
	?>
	</table>
	</div>
	
	<div>
		<? include_once("v_i_page.php")?>
	</div>
	
	
</div>

<!--�������-->
<link href="css/theme.default.css" rel="stylesheet"><!--���������ʽ -->
<script language="JavaScript" type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
	$("#mytable").tablesorter({  headers:{  1:{sorter:false}, 4:{sorter:true}, 7:{sorter:true}  }  });
</script>
<!--�������END -->

</body>
</html>
