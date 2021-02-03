<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

//--------------搜索条件生成
include_once("daima_post_all.php"); 
//--------------搜索条件生成
//print_r($url_info);
$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];
$aid=$url_info['aid'];

if ($action=="del"){

	if ( (time()-$time)>$var_outhours*3600 ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('网页过期，禁止操作！','alert_back','','error','');</script>";
		exit;
	}

	if ($id==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('ID不存在！','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select id from lei_daima where id='".$id."' and pass<>'1' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		$sql="delete from lei_daima where id='".$id."' and pass<>'1' limit 1";
		$mysqli->query($sql);

		$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
		
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('代码删除成功！','alert_go','','ok','?".$back_url."');</script>";
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
	
	$sql="select id,pass from lei_daima where id='".$id."' limit 1 ";
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
	
	$sql="update lei_daima set pass='".$zhuangtai_value."' where id='".$id."'";
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
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor_1.config.js"></script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	

	<div class="h_a">信息检索</div>
		<div class="search_type cc mb10">
		<form action="?" method="post" id="formsa" name="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<? include_once("daima_form_all.php");?>
			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit loading_it" type="submit">搜索</button>
			&nbsp;&nbsp;
			<button class="btn btn_error loading_it" type="button" onclick="document.location.href='daima_add.php?<?=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5)?>'">添加</button>
		</div>
		</form>
	</div>
	
	<div class="table_list">
	<table width="100%"  id="mytable">
		
		<colgroup>
				<col width="5%">
				<col width="14%">
				<col >
				<col width="18%">
				<col width="10%">
				<col width="19%">
		</colgroup>
		
		<thead>
			<tr>
			  <td >序号</td>
				<td >发布日期</td>
				<td >代码标题</td>
				<td >代码分组</td>
				<td >状态</td>
				<td >操作</td>
			</tr>
		</thead>
<?php

	include_once("daima_sql_all.php"); 
	
	$sql_page="select count(*) from lei_daima where ".$searchstr."";
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
	
	$sql_search="select id,title,message,indate,pass,fenzu".$search_score." from lei_daima where ".$searchstr." ".$px_str." limit ".$pagestart.",".$pagenum." ";
	
	$i=$pagestart;
	$result=$mysqli->query($sql_search);
	while ($rs=$result->fetch_assoc()){
	$i++;
		
?>
			<tr>
			  <td><?=$i?><? if ($aid==$rs["id"]){?> <i class="icon-eye-open"></i><? }?></td>
				<td><?=date("Y年m月d日",strtotime($rs["indate"]))?><br /><?=get_week($rs["indate"])?></td>
				<td><?=clear_all($rs["title"])?></td>
				<td><?
				$sql2="select * from lei_daima_bk where id='".$rs["fenzu"]."'";
				$result2=$mysqli->query($sql2);
				if($rs2=$result2->fetch_assoc()){
					$keyword=$rs2["keyword"];
				}
				echo $keyword;

				?></td>
				<td><?
				if ($rs["pass"]!='1'){ echo "<span style='color:red'>未发布</span>";}else{ echo "<span style='color:green'>发布</span>";}
				?></td>
			    <td>
					  <a class="loading_it" href="daima_edit.php?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5)?>"><i class="icon-edit"></i> 详细</a>
					  <?
					   if ( $rs["pass"]!='1'){?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('确认发布？','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&time=".time(),$key_url_md_5)?>');" ><i class="icon-upload"></i> 发布</a>
					  <? }?>
					  
					  <?
					   if ( $rs["pass"]=='1'){?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('确认取消发布？','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&time=".time(),$key_url_md_5)?>');" ><i class="icon-download"></i> 撤回</a>
					  <? }?>
					  
					  <?
					   if ( $rs["pass"]!='1'){//未发布可删除?>
					  &nbsp;|&nbsp;
					  <a href="javascript:void(0)" onClick="alert_go('确认删除？','href','','wen','?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=del&time=".time(),$key_url_md_5)?>');" ><i class="icon-trash"></i> 删除</a>
					  <? }?>					  </td>
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

<!--表格排序-->
<link href="css/theme.default.css" rel="stylesheet"><!--表格排序样式 -->
<script language="JavaScript" type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
	$("#mytable").tablesorter({  headers:{  2:{sorter:false}, 6:{sorter:false}  }  });
</script>
<!--表格排序END -->

</body>
</html>
