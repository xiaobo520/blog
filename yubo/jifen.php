<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

//--------------������������
$action_pd=$url_info['action_pd'];

$user_search=quotes_gpc_pd($_POST['user_search'],1);
$date1_search=quotes_gpc_pd($_POST['date1_search'],1);
$date2_search=quotes_gpc_pd($_POST['date2_search'],1);
$px_search=quotes_gpc_pd($_POST['px_search'],1);
$pagenums_search=quotes_gpc_pd($_POST['pagenums_search'],1);
$zhuangtai_search=quotes_gpc_pd($_POST['zhuangtai_search'],1);
$bz_search=quotes_gpc_pd($_POST['bz_search'],1);


if ($user_search=='' ) $user_search=$url_info['user_search'];
if ($date1_search=='' ) $date1_search=$url_info['date1_search'];
if ($date2_search=='' ) $date2_search=$url_info['date2_search'];
if ($px_search=='' ) $px_search=$url_info['px_search'];
if ($pagenums_search=='' ) $pagenums_search=$url_info['pagenums_search'];
if ($zhuangtai_search=='' ) $zhuangtai_search=$url_info['zhuangtai_search'];
if ($bz_search=='' ) $bz_search=$url_info['bz_search'];

$page=$url_info['page'];//��תҳ��

if ($pagenums_search>100){
	echo "<script language=javascript>alert('ÿҳ�������Ϊ100��');javascript:history.back(-1);</script>";
	exit;
}

$user_search=keyword_replace($user_search);//�滻keyword
//========================================

$pageurl="&action_pd=".$action_pd."&user_search=".$user_search."&zhuangtai_search=".$zhuangtai_search."&date1_search=".$date1_search."&date2_search=".$date2_search."&px_search=".$px_search."&bz_search=".$bz_search."&pagenums_search=".$pagenums_search;
//--------------������������
//print_r($url_info);
$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];
$aid=$url_info['aid'];


if ($action=="add" ){//�ύ

	if ( (time()-$time)>$var_outhours*3600 ){
		echo "<script language=javascript>alert('��ҳ���ڣ���ֹ������');javascript:history.back(-1);</script>";
		exit;
	}
	
	$czfanwei_search=quotes_gpc_pd($_POST['czfanwei_search'],1);
	$czuser_search=quotes_gpc_pd($_POST['czuser_search'],1);
	$czjifen_search=quotes_gpc_pd($_POST['czjifen_search'],1);
	$czbz_search=quotes_gpc_pd($_POST['czbz_search'],1);
	
	if ($czfanwei_search=="one" && $czuser_search=='' ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('ָ����Աʱ����Ա�û�������Ϊ��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($czjifen_search=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('���������Ϊ��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($czbz_search=='' ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('��ע����Ϊ��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($czfanwei_search=='one'){//ָ����Ա
		$sql="select jifen,jifen_all,username from lei_user where username='".$czuser_search."' limit 1 ";
		$result=$mysqli->query($sql);
		if($rs=$result->fetch_assoc()){
			jilu_in($czuser_search,$czjifen_search,'qita',$czbz_search);//ָ����Ա����Ҫ��Ӽ�¼��ȫԱ�˶಻��Ӽ�¼
		}else{
			alert_ini();//���alert�����ļ�
			echo "<script>alert_go('�û�����д����δ�ҵ���Ӧ��Ա��','alert_back','','error','');</script>";
			exit;
		}
	}elseif ($czfanwei_search=='all'){//ȫ����Ա
		$sql="update lei_user set jifen=jifen+".$czjifen_search.",jifen_all=jifen_all+".$czjifen_search." where pass='1' ";//״̬�����Ļ�Ա
		$mysqli->query($sql);
	}
	
	$mysqli->close();
	$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('���ֵ����ɹ���','alert_go','','ok','?');</script>";
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
					<label>�û�����</label><input name="user_search" type="text" class="input length_3" id="user_search" value="<?=$user_search?>">
				</li>
				
				
				<li>
					<label>����ʱ�䣺</label><input name="date1_search" type="text" id="date1_search" value="<?=$date1_search?>" size="10"  onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true" class="input length_7" /> - <input name="date2_search" type="text" id="date2_search" value="<?=$date2_search?>" size="10" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true"  class="input length_7" />
				</li>
				
				<li>
					<label>��ע��Ϣ��</label><input name="bz_search" type="text" class="input length_3" id="bz_search" value="<?=$bz_search?>">
				</li>
				
				<li>
					<label>����</label><select name="px_search" id="px_search" class="select_3" >
            <option value="" <? if ($px_search==''){?>selected="selected"<? }?>>--Ĭ��--</option>
			<option value="1" <? if ($px_search=='1'){?>selected="selected"<? }?>>--����ʱ�䣨����--</option>
			<option value="2" <? if ($px_search=='2'){?>selected="selected"<? }?>>--����ʱ�䣨����--</option>
          </select>
				</li>

				<li>
					<label>���ͣ�</label><select name="zhuangtai_search" id="zhuangtai_search" class="select_3" >
            <option value="" <? if ($zhuangtai_search==''){?>selected="selected"<? }?>>--ȫ��--</option>
			<option value="denglujiangli" <? if ($zhuangtai_search=='denglujiangli'){?>selected="selected"<? }?>>��¼����</option>
			<option value="sharejiangli" <? if ($zhuangtai_search=='sharejiangli'){?>selected="selected"<? }?>>������</option>
			<option value="huitie" <? if ($zhuangtai_search=='huitie'){?>selected="selected"<? }?>>��������</option>
			<option value="pintu" <? if ($zhuangtai_search=='pintu'){?>selected="selected"<? }?>>ƴͼ��Ϸ����</option>
			<option value="qita" <? if ($zhuangtai_search=='qita'){?>selected="selected"<? }?>>����</option>
          </select>
				</li>
				
				
				<li>
					<label>ÿҳ������</label><input name="pagenums_search" type="text" class="input length_3" id="pagenums_search" value="<?=$pagenums_search?>" maxlength="3" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>
			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit loading_it" type="submit">��������</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn_error" type="button" onclick="document.getElementById('jifen_cz').style.display=''">��������</button>
		</div>
		</form>
	</div>
	
	
	
	<div id="jifen_cz" class="search_type cc mb10" style="display: none;">
		<form action="?<?=encrypt_url("action=add&time=".time(),$key_url_md_5)?>" method="post" id="formsa2" name="formsa2">
		<div class="ul_wrap">
			<ul class="cc">
				<li>
					<label>��Ա��Χ��</label><select name="czfanwei_search" id="czfanwei_search" class="select_3" >
					<option value="one" selected="selected">--ָ����Ա���û������--</option>
					<option value="all" >--ȫ����Ա���û������--</option>
				  </select>
				</li>
				
				<li>
					<label>�û�����</label><input name="czuser_search" type="text" class="input length_3" id="czuser_search" value="" placeholder="ָ����Աʱ����">
				</li>
				
				
				<li>
					<label>�������</label><input name="czjifen_search" type="text" class="input length_3" id="czjifen_search" value="" placeholder="���ֿ���Ϊ��ֵ�� -100">
				</li>
				
				<li>
					<label>��ע��Ϣ��</label><input name="czbz_search" type="text" class="input length_3" id="czbz_search" value="�ƹ�">
				</li>
				
				

			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_success" type="button" onClick="alert_go('ȷ�ϵ������֣�','submit','formsa2','wen','')">��������</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn" type="button" onclick="document.getElementById('jifen_cz').style.display='none'">ȡ���ر�</button>
		</div>
		</form>
	</div>
	
	
	
	<div class="table_list">
	<table width="100%"  id="mytable">
		
		<colgroup>
				<col width="5%">
				<col width="16%">
				<col width="10%">
				<col width="12%">
				<col width="17%">
				<col width="13%">
				<col >
		</colgroup>
		
		<thead>
			<tr>
			  	<td >���</td>
				<td >�û���</td>
				<td >���ֱ䶯</td>
				<td >����</td>
				<td >�䶯ʱ��</td>
				<td >����IP</td>
				<td >��ע</td>
			</tr>
		</thead>
<?php

	$search_count_num=0;

	if($user_search==''){
		$username_str='';
	}else{
		$username_str=" and ( username like '".$user_search."%' ) "; // in ".$."
		$search_count_num++;
	}
	
	if($bz_search==''){
		$bz_str='';
	}else{
		$bz_str=" and ( bz like '%".$bz_search."%' ) "; // in ".$."
		$search_count_num++;
	}

	if($date1_search=='' || $date2_search==''){//��������
		//$nowdate=date("Y-m-d",strtotime("-7 day"));//Ĭ����ʾ���7���
		//$nowdate=date("Y-m-d",strtotime("last Friday"));//next last
		//$date1_search=$nowdate;
		//$date2_search=date("Y-m-d");
		
		//$indate_str=" and indate >= '".$date1_search." 00:00:00' and indate <= '".$date2_search." 23:59:59'  ";
		$indate_str='';
	}else{
		$indate_str=" and intime >= '".$date1_search." 00:00:00' and intime <= '".$date2_search." 23:59:59'  ";
		$search_count_num++;
	}
	
	
	
	if($zhuangtai_search==''){
		$zhuangtai_str=" ";
	}else{
		$zhuangtai_str=" and leixing = '".$zhuangtai_search."' ";
		$search_count_num++;
	}
	
	if($px_search==''){
		$px_str=' order by id desc';
	}else{
		if ($px_search=='1'){	//ע��ʱ�䣨����
			$px_str=" order by id asc";
			
		}elseif($px_search=='2'){//ע��ʱ�䣨����
			$px_str=" order by id desc";
			
		}
	}
	
	$searchstr=" 1=1 ".$username_str." ".$indate_str." ".$zhuangtai_str." ".$bz_str." ";
	
	$sql_page="select count(*) from lei_jifen where ".$searchstr."";
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
	
	$sql_search="select * from lei_jifen where ".$searchstr." ".$px_str." limit ".$pagestart.",".$pagenum." ";
	
	$i=$pagestart;
	$result=$mysqli->query($sql_search);
	while ($rs=$result->fetch_assoc()){
	$i++;
		if ($rs["leixing"]=='denglujiangli'){
			$leixing_str='��¼����';
		}elseif ($rs["leixing"]=='sharejiangli'){
			$leixing_str='������';
		}elseif ($rs["leixing"]=='huitie'){
			$leixing_str='��������';
		}elseif ($rs["leixing"]=='pintu'){
			$leixing_str='ƴͼ��Ϸ����';
		}elseif ($rs["leixing"]=='qita'){
			$leixing_str='����';
		}else{
			$leixing_str='--';
		}
		
?>
			<tr>
			  <td height="35"><?=$i?><? if ($aid==$rs["id"]){?> <i class="icon-eye-open"></i><? }?></td>
				<td><?=$rs["username"]?></td>
				<td><?=$rs["jifen"]?> ��</td>
				<td><?=$leixing_str?></td>
				<td><?=$rs["intime"]?></td>
				<td><?=$rs["ip"]?></td>
			    <td><?=$rs["bz"]?></td>
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
	$("#mytable").tablesorter({  headers:{  1:{sorter:true}, 6:{sorter:true}  }  });
</script>
<!--�������END -->

</body>
</html>
