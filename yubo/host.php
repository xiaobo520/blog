<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

//--------------������������
include_once("./host_post_all.php"); 
//print_r($url_info);
$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];
$aid=$url_info['aid'];
$table=$url_info['table'];



if ($action=="del"){

	if ( (time()-$time)>$var_outhours*3600 ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('��ҳ���ڣ���ֹ������','alert_back','','error','');</script>";
		exit;
	}

	if ($id=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('ID�����ڣ�','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select id from ".$table." where id='".$id."' and pass='0' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		$sql="delete from ".$table." where id='".$id."' and pass='0' limit 1";
		$mysqli->query($sql);

		$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
		
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('����ɾ���ɹ���','alert_go','','ok','?".$back_url."');</script>";
		exit;

	}else{
		echo "<script language=javascript>alert('ID�����ڣ�');javascript:history.back(-1);</script>";
		exit;
	}
	$mysqli->close();

}

if ($action=="shangbao" ){//�ύ

	if ( (time()-$time)>$var_outhours*3600 ){
		echo "<script language=javascript>alert('��ҳ���ڣ���ֹ������');javascript:history.back(-1);</script>";
		exit;
	}
	
	$sql="select id,pass from ".$table." where id='".$id."' limit 1 ";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$pass=$rs["pass"];
	}
	
	if ($pass=='1' ){//״̬ת��
		$zhuangtai_value='0';
	}elseif ($pass=='0'){
		$zhuangtai_value='1';
	}else{
		$zhuangtai_value='0';
	}
	
	$sql="update ".$table." set pass='".$zhuangtai_value."' where id='".$id."'";
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
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor_3.config.js"></script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/lang/zh-cn/zh-cn.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="js/checkhost.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	

	<div class="h_a">��Ϣ����</div>
	<div class="search_type cc mb10">
		<form action="?" method="post" id="formsa" name="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<li>
					<label>�������룺</label><input name="cid_search" type="text" class="input length_3" id="cid_search" value="<?=$cid_search?>">
				</li>
				
				<li>
					<label>�û�����</label><input name="user_search" type="text" class="input length_3" id="user_search" value="<?=$user_search?>">
				</li>
				
				<li>
					<label>�����ͺţ�</label><input name="xinghao_search" type="text" class="input length_3" id="xinghao_search" value="<?=$xinghao_search?>" onFocus="check_pinzhong()" onKeyUp="check_pinzhong()" autocomplete="off" placeholder="����ؼ���">
					<div style="position:relative;">
						<div id="showdanwei" style="width:250px;"></div>
					</div>
				</li>
				
				
				<li>
					<label>�������ڣ�</label><input name="date1_search" type="text" id="date1_search" value="<?=$date1_search?>" size="10"  onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true" class="input length_7" /> - <input name="date2_search" type="text" id="date2_search" value="<?=$date2_search?>" size="10" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true"  class="input length_7" />
				</li>
				
				<li>
					<label>����״̬��</label><select name="zhuangtai_search" id="zhuangtai_search" class="select_3" >
             			<option value="" <? if ($zhuangtai_search==''){?>selected="selected"<? }?> >ȫ��</option>
						<option value="1" <? if ($zhuangtai_search=='1'){?>selected="selected"<? }?> >������</option>
                        <option value="2" <? if ($zhuangtai_search=='2'){?>selected="selected"<? }?> >����ͨ</option>
						<option value="3" <? if ($zhuangtai_search=='3'){?>selected="selected"<? }?> >�ѿ�ͨ</option>
						<option value="90" <? if ($zhuangtai_search=='90'){?>selected="selected"<? }?> >��ȡ��</option>
          </select>
				</li>
				
				<li>
					<label>����</label><select name="px_search" id="px_search" class="select_3" >
            <option value="" <? if ($px_search==''){?>selected="selected"<? }?>>--Ĭ��--</option>
			<option value="1" <? if ($px_search=='1'){?>selected="selected"<? }?>>--����ʱ�䣨����--</option>
			<option value="2" <? if ($px_search=='2'){?>selected="selected"<? }?>>--����ʱ�䣨����--</option>
          </select>
				</li>
				
				
				<li>
					<label>ÿҳ������</label><input name="pagenums_search" type="text" class="input length_3" id="pagenums_search" value="<?=$pagenums_search?>" maxlength="3" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>
			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit loading_it" type="submit">��������</button>
		</div>
		</form>
	</div>
	
	
	
	<div class="table_list">
	<table width="100%"  id="mytable">
		
		<colgroup>
				<col width="5%">
				<col width="15%">
				<col width="13%">
				<col >
				<col width="10%">
				<col width="14%">
				<col width="8%">
				<col width="13%">
		</colgroup>
		
		<thead>
			<tr>
			  	<td >���</td>
				<td >������</td>
				<td >�û���</td>
				<td >�����ͺ�</td>
				<td >����/�ɽ��۸�</td>
				<td >����ʱ��</td>
				<td >��ͨ״̬</td>
				<td >����</td>
			</tr>
		</thead>
<?php
	include_once("./host_sql_all.php"); 
	
	
	$sql_page="select count(*) from lei_host where ".$searchstr."";
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
	
	$sql_search="select * from lei_host where ".$searchstr." ".$px_str." limit ".$pagestart.",".$pagenum." ";
	$gourl="select * from lei_host where ".$searchstr." ".$px_str." ";
	$i=$pagestart;
	$result=$mysqli->query($sql_search);
	$tongjia_jiage=0;
	$tongjia_overjiage=0;
	while ($rs=$result->fetch_assoc()){
	$i++;
		$zt=$rs["zt"];
		if ($zt=='1'){
			$zt_str='<span style="color:red">������</span>';
		}elseif ($zt=='2'){
			$zt_str='<span style="color:yellow">����ͨ</span>';
		}elseif ($zt=='3'){
			$zt_str='<span style="color:green">�ѿ�ͨ</span>';
		}elseif ($zt=='90'){
			$zt_str='<span style="color:blue;">��ȡ��</span>';
		}else{
			$zt_str='--';
		}
		
		$tongjia_jiage=$tongjia_jiage+$rs["jiage"]*$rs["host_nianxian"];
		$tongjia_overjiage=$tongjia_overjiage+$rs["jiage"]*$rs["host_nianxian"]-$rs["host_jifen"];
		
?>
			<tr>
			  <td height="35"><?=$i?><? if ($aid==$rs["id"]){?> <i class="icon-eye-open"></i><? }?></td>
				<td><?=$rs["dh"]?></td>
				<td><?=$rs["username"]?></td>
				<td><?=$rs["xinghao"]?></td>
				<td><span style="color:#3399FF;font-weight:bold;"><?=($rs["jiage"]*$rs["host_nianxian"])?></span> Ԫ / <span style="color: #FF0000; font-weight:bold;"><?=(($rs["jiage"]*$rs["host_nianxian"])-$rs["host_jifen"])?></span> Ԫ</td>
				<td><?=$rs["indate"]?></td>
				<td><?=$zt_str?></td>
			    <td>
					  <a class="loading_it" href="host_xx.php?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5)?>"><i class="icon-edit"></i> ��ϸ</a>
					  
					  <?
					   if ( $zt=='90'){//δ������ɾ��?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('ȷ��ɾ��������','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=del&table=".$answtalbe_an."&time=".time(),$key_url_md_5)?>');" ><i class="icon-trash"></i> ɾ��</a>
					  <? }?>				</td>
		    </tr>
			
			
	<?php 
	
	}
	//sleep(3);
	?>
		<tr>
				  <td height="35" colspan="3">

					<input name="buttondc" class="btn btn_success" type="button" value="��������������" onClick="alert_go('ȷ�ϵ������ݣ�','alert_open','','wen','out_host.php?<?=encrypt_url("&action=excel&sqls=".base64_encode($gourl)."&time=".time(),$key_url_md_5)?>');" >
				</td>
		          <td height="35" colspan="5" align="right"><span style="font-weight:bold">�����۸� <span style="color:#3399FF;font-size:22px; "><?=$tongjia_jiage?></span> Ԫ /  �ɽ��۸� <span style="color:#FF0000;font-size:22px; "><?=$tongjia_overjiage?></span> Ԫ</span></td>
        </tr>
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
	$("#mytable").tablesorter({  headers:{  4:{sorter:false}, 7:{sorter:false} }  });
</script>
<!--�������END -->

</body>
</html>
