<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

//--------------搜索条件生成
$action_pd=$url_info['action_pd'];

$cid_search=quotes_gpc_pd($_POST['cid_search'],1);
$nicheng_search=quotes_gpc_pd($_POST['nicheng_search'],1);
$bk_search=quotes_gpc_pd($_POST['bk_search'],1);
$user_search=quotes_gpc_pd($_POST['user_search'],1);
$date1_search=quotes_gpc_pd($_POST['date1_search'],1);
$date2_search=quotes_gpc_pd($_POST['date2_search'],1);
$px_search=quotes_gpc_pd($_POST['px_search'],1);
$pagenums_search=quotes_gpc_pd($_POST['pagenums_search'],1);
$zhuangtai_search=quotes_gpc_pd($_POST['zhuangtai_search'],1);

if ($cid_search=='' ) $cid_search=$url_info['cid_search'];
if ($nicheng_search=='' ) $nicheng_search=$url_info['nicheng_search'];
if ($bk_search=='' ) $bk_search=$url_info['bk_search'];
if ($user_search=='' ) $user_search=$url_info['user_search'];
if ($date1_search=='' ) $date1_search=$url_info['date1_search'];
if ($date2_search=='' ) $date2_search=$url_info['date2_search'];
if ($px_search=='' ) $px_search=$url_info['px_search'];
if ($pagenums_search=='' ) $pagenums_search=$url_info['pagenums_search'];
if ($zhuangtai_search=='' ) $zhuangtai_search=$url_info['zhuangtai_search'];

$page=$url_info['page'];//跳转页码

if ($pagenums_search>100){
	echo "<script language=javascript>alert('每页行数最大为100！');javascript:history.back(-1);</script>";
	exit;
}

$user_search=keyword_replace($user_search);//替换keyword
//========================================

$pageurl="&action_pd=".$action_pd."&user_search=".$user_search."&zhuangtai_search=".$zhuangtai_search."&date1_search=".$date1_search."&date2_search=".$date2_search."&px_search=".$px_search."&cid_search=".$cid_search."&nicheng_search=".$nicheng_search."&bk_search=".$bk_search."&pagenums_search=".$pagenums_search;
//--------------搜索条件生成
//print_r($url_info);
$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];
$aid=$url_info['aid'];
$table=$url_info['table'];



if ($action=="del"){

	if ( (time()-$time)>$var_outhours*3600 ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('网页过期，禁止操作！','alert_back','','error','');</script>";
		exit;
	}

	if ($id=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('ID不存在！','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select id from ".$table." where id='".$id."' and pass='0' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		$sql="delete from ".$table." where id='".$id."' and pass='0' limit 1";
		$mysqli->query($sql);

		$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
		
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('评论删除成功！','alert_go','','ok','?".$back_url."');</script>";
		exit;

	}else{
		echo "<script language=javascript>alert('ID不存在！');javascript:history.back(-1);</script>";
		exit;
	}
	$mysqli->close();

}

if ($action=="shangbao" ){//提交

	if ( (time()-$time)>$var_outhours*3600 ){
		echo "<script language=javascript>alert('网页过期，禁止操作！');javascript:history.back(-1);</script>";
		exit;
	}
	
	$sql="select id,pass from ".$table." where id='".$id."' limit 1 ";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$pass=$rs["pass"];
	}
	
	if ($pass=='1' ){//状态转换
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
	
	alert_ini();//输出alert所需文件
	echo "<script>alert_go('状态转换成功！','alert_go','','ok','?".$back_url."');</script>";
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
<script language="javascript" type="text/javascript" src="js/checkpinzhong.js"></script>
<script>
function show_hide_m(id,table){
	
	//$("#"+a).fadeToggle(400);

	$('#my_to_alert').modal('show');
	$('#hide_read').val(id);
	$('#hide_table').val(table);
	
	ribao_read(id,table);

}
</script>
<script language="javascript" type="text/javascript" src="js/fayan_base.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	

	<div class="h_a">信息检索</div>
	<div class="search_type cc mb10">
		<form action="?" method="post" id="formsa" name="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<li>
					<label>主题ID：</label><input name="cid_search" type="text" class="input length_3" id="cid_search" value="<?=$cid_search?>">
				</li>
				
				<li>
					<label>用户名：</label><input name="user_search" type="text" class="input length_3" id="user_search" value="<?=$user_search?>">
				</li>
				
				<li>
					<label>昵称：</label><input name="nicheng_search" type="text" class="input length_3" id="nicheng_search" value="<?=$nicheng_search?>" onFocus="check_pinzhong()" onKeyUp="check_pinzhong()" autocomplete="off"  placeholder="昵称或拼音首字母">
					<div style="position:relative;">
						<div id="showdanwei"></div>
					</div>
				</li>
				
				
				<li>
					<label>发帖日期：</label><input name="date1_search" type="text" id="date1_search" value="<?=$date1_search?>" size="10"  onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true" class="input length_7" /> - <input name="date2_search" type="text" id="date2_search" value="<?=$date2_search?>" size="10" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true"  class="input length_7" />
				</li>
				
				<li>
					<label>帖子状态：</label><select name="zhuangtai_search" id="zhuangtai_search" class="select_3" >
             			<option value="" <? if ($zhuangtai_search==''){?>selected="selected"<? }?> >全部</option>
						<option value="1" <? if ($zhuangtai_search=='1'){?>selected="selected"<? }?> >正常</option>
                        <option value="0" <? if ($zhuangtai_search=='0'){?>selected="selected"<? }?> >未审核</option>
          </select>
				</li>
				

				<li>
					<label>版块分类：</label><select name="bk_search" id="bk_search" class="select_3" >
             			<option value="1" <? if ($bk_search=='1' || $bk_search==''){?>selected="selected"<? }?> >PHP经验分享</option>
                        <option value="2" <? if ($bk_search=='2'){?>selected="selected"<? }?> >随手记</option>
                        <option value="3" <? if ($bk_search=='3'){?>selected="selected"<? }?> >关于博主</option>
          </select>
				</li>
				
				<li>
					<label>排序：</label><select name="px_search" id="px_search" class="select_3" >
            <option value="" <? if ($px_search==''){?>selected="selected"<? }?>>--默认--</option>
			<option value="1" <? if ($px_search=='1'){?>selected="selected"<? }?>>--发帖时间（正序）--</option>
			<option value="2" <? if ($px_search=='2'){?>selected="selected"<? }?>>--发帖时间（倒序）--</option>
          </select>
				</li>
				
				
				<li>
					<label>每页行数：</label><input name="pagenums_search" type="text" class="input length_3" id="pagenums_search" value="<?=$pagenums_search?>" maxlength="3" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>
			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit loading_it" type="submit">快速搜索</button>
		</div>
		</form>
	</div>
	
	
	
	<div class="table_list">
	<table width="100%"  id="mytable">
		
		<colgroup>
				<col width="5%">
				<col width="20%">
				<col width="19%">
				<col >
				<col width="14%">
				<col width="8%">
				<col width="14%">
		</colgroup>
		
		<thead>
			<tr>
			  	<td >序号</td>
				<td >主题</td>
				<td >用户名/昵称</td>
				<td >回复内容</td>
				<td >回复时间/IP</td>
				<td >帖子状态</td>
				<td >操作</td>
			</tr>
		</thead>
<?php

	$search_count_num=0;

	if($cid_search==''){
		$cid_str='';
	}else{
		$cid_str=" and ( cid = '".$cid_search."' ) "; // in ".$."
		$search_count_num++;
	}
	
	if($user_search==''){
		$user_str='';
	}else{
		$user_str=" and ( username like '".$user_search."%' ) "; // in ".$."
		$search_count_num++;
	}
	
	if($nicheng_search==''){
		$nicheng_str='';
	}else{
		$nicheng_str=" and ( nicheng like '%".$nicheng_search."%' ) "; // in ".$."
		$search_count_num++;
	}

	if($date1_search=='' || $date2_search==''){//操作日期
		//$nowdate=date("Y-m-d",strtotime("-7 day"));//默认显示最近7天的
		//$nowdate=date("Y-m-d",strtotime("last Friday"));//next last
		//$date1_search=$nowdate;
		//$date2_search=date("Y-m-d");
		
		//$indate_str=" and indate >= '".$date1_search." 00:00:00' and indate <= '".$date2_search." 23:59:59'  ";
		$indate_str='';
	}else{
		$indate_str=" and indate >= '".$date1_search." 00:00:00' and indate <= '".$date2_search." 23:59:59'  ";
		$search_count_num++;
	}
	
	
	
	if($zhuangtai_search==''){
		$zhuangtai_str=" ";
	}else{
		$zhuangtai_str=" and pass = '".$zhuangtai_search."' ";
		$search_count_num++;
	}
	
	if ($bk_search=='1'){ //更新主题表及回复表判定
		$answtalbe="lei_jingyan";
		$answtalbe_an="lei_jingyan_hf";
		$answtalbe_mulu="/jingyan/";
	}elseif ($bk_search=='2'){
		$answtalbe="lei_news";
		$answtalbe_an="lei_news_hf";
		$answtalbe_mulu="/news/";
	}elseif ($bk_search=='3'){
		$answtalbe="lei_message";
		$answtalbe_an="lei_message_hf";
		$answtalbe_mulu="/lilei-";
	}else{
		$answtalbe="lei_jingyan";
		$answtalbe_an="lei_jingyan_hf";
		$answtalbe_mulu="/jingyan/";
	}
	
	if($px_search==''){
		$px_str=' order by id desc';
	}else{
		if ($px_search=='1'){	//注册时间（正序）
			$px_str=" order by id asc";
			
		}elseif($px_search=='2'){//注册时间（倒序）
			$px_str=" order by id desc";
			
		}
	}
	
	$searchstr=" 1=1 ".$cid_str." ".$user_str." ".$nicheng_str." ".$username_str." ".$indate_str." ".$zhuangtai_str." ";
	
	$sql_page="select count(*) from ".$answtalbe_an." where ".$searchstr."";
	$result_page=$mysqli->query($sql_page);
	$rs_page=$result_page->fetch_array();
	if ($pagenums_search!=''){
		$pagenum=$pagenums_search;   //自定义每页显示条数
		if ($pagenum==0) $pagenum=15;
	}else{
		$pagenum=15;   //每页显示条数
	}
	$pageidcount=$rs_page[0];
	$allnum=ceil($rs_page[0]/$pagenum);//总页数
	
	if($page=="") $page=1;
	if($page<=1) $page=1;
	if($page>=$allnum)$page=$allnum;//因为page是从0开始的，所以要-1
	$pagestart=($page-1)*$pagenum;
	if($pagestart<=0) $pagestart=0; 
	
	$sql_search="select * from ".$answtalbe_an." where ".$searchstr." ".$px_str." limit ".$pagestart.",".$pagenum." ";
	
	$i=$pagestart;
	$result=$mysqli->query($sql_search);
	while ($rs=$result->fetch_assoc()){
	$i++;
		if ($rs["pass"]=='0'){
			$leixing_str='<span style=color:red>审核中</span>';
		}elseif ($rs["pass"]=='1'){
			$leixing_str='<span style=color:green>正常</span>';
		}else{
			$leixing_str='--';
		}
		
		$sql1="select * from ".$answtalbe." where id='".$rs["cid"]."' limit 1 ";
		$result1=$mysqli->query($sql1);
		if($rs1=$result1->fetch_assoc()){
			$title=$rs1["title"];
		}else{
			$title='未知';
		} 
		
?>
			<tr>
			  <td><?=$i?><? if ($aid==$rs["id"]){?> <i class="icon-eye-open"></i><? }?></td>
				<td><a href="<?=$answtalbe_mulu?><?=$rs["cid"]?>.html" target="_blank" style="color:#333333" title="<?=clear_all($title)?>" ><?=mysubstr(clear_all($title),0,30, 'gbk');?></a><br /></td>
				<td><?=$rs["username"]?></br><?=$rs["nicheng"]?></td>
				<td><span id="key_<?=$rs["id"]?>" style="cursor:pointer;" onclick="show_hide_m('<?=$rs["id"]?>','<?=$answtalbe_an?>')" ><?=mysubstr(clear_all($rs["content"]),0,200, 'gbk')?></span></td>
				<td><?=$rs["indate"]?><br /><?=$rs["ip"]?></td>
				<td><?=$leixing_str?></td>
			    <td>
				<?
					   if ( $rs["pass"]=='0'){?>
					  <a href="javascript:void(0)" onClick="alert_go('确认将状态转为“通过”？','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&table=".$answtalbe_an."&time=".time(),$key_url_md_5)?>');" ><i class="icon-ok-circle"></i> 通过</a>
					  <? 
					  	}elseif ( $rs["pass"]=='1'){
					  ?>
					  <a href="javascript:void(0)" onClick="alert_go('确认将状态转为“审核”？','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&table=".$answtalbe_an."&time=".time(),$key_url_md_5)?>');" ><i class="icon-remove-circle"></i> 审核</a>
					  <? }?>
					  
					  <?
					   if ( $rs["pass"]=='0'){//未发布可删除?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('确认删除文章？','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=del&table=".$answtalbe_an."&time=".time(),$key_url_md_5)?>');" ><i class="icon-trash"></i> 删除</a>
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


<style>
.modal{
        z-index:500;
}
.modal-backdrop{
        z-index:400;
}
</style>
			
<div id="my_to_alert" class="modal hide fade no_bg" style="color:#111111; display:none;font-family:微软雅黑;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3>编辑评论内容</h3>
  </div>
  <div class="modal-body">
		<!--内容 -->
		
		<div ><!--限高 --><!--style="max-height:150px;overflow-x:hidden; overflow-y:scroll"-->
			<div id="quanxian_1" style="width:100%; clear:both; line-height:25px;display:">
				<div>
					<script id="message1" name="message1" type="text/plain" style="width:100%;height:100px;"></script>
					<script type="text/javascript">var message1 = UE.getEditor('message1');</script>
				</div>
			</div>
		</div>
		<!--内容 -->
  </div>

  <div class="modal-footer">
  	<input name="hide_read" id="hide_read" type="hidden" value="" />
	<input name="hide_table" id="hide_table" type="hidden" value="" />
	
	<span id="readzt" style="margin-right:20px;"></span>
	<button class="btn btn_error" onClick="ribao_save()">保存</button>
	<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
  </div>
</div>
<!--提示层 END -->	


<!--表格排序-->
<link href="css/theme.default.css" rel="stylesheet"><!--表格排序样式 -->
<script language="JavaScript" type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
	$("#mytable").tablesorter({  headers:{  3:{sorter:false}, 6:{sorter:false} }  });
</script>
<!--表格排序END -->

</body>
</html>
