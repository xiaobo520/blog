<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

//--------------搜索条件生成
$action_pd=$url_info['action_pd'];

//--------------搜索条件生成
//print_r($url_info);
$action=$url_info['action'];
$id=$url_info['id'];
$time=$url_info['time'];

if ($action=="edit"){

	if ( (time()-$time)>$var_outhours*3600 ){
		echo "<script language=javascript>alert('网页过期，禁止操作！');javascript:history.back(-1);</script>";
		exit;
	}
	
	$name_search=quotes_gpc_pd($_POST['keyword_name'],1);
	$pass_search=quotes_gpc_pd($_POST['zhongdian_pass'],1);
	$px_search=quotes_gpc_pd($_POST['zhongdian_px'],1);
	
	if ($name_search=="" || $pass_search=="" || $px_search=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('各项均必须填写！','alert_back','','error','');</script>";
		exit;
	}

	$sql="select * from lei_keyword where id='".$id."' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		
		$indate=date("Y-m-d H:i:s");
		
		$sql="update lei_keyword set keyword='".$name_search."',pass='".$pass_search."',px='".$px_search."' where id='".$id."' limit 1";
		$mysqli->query($sql);

		$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
		
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('关键词修改成功！','alert_go','','ok','?".$back_url."');</script>";
		exit;
		
	}else{
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('ID不存在！','alert_back','','error','');</script>";
		exit;
	}
	$mysqli->close();

}

if ($action=="add"){

	$name_search=quotes_gpc_pd($_POST['name_search'],1);
	$pass_search=quotes_gpc_pd($_POST['pass_search'],1);
	$px_search=quotes_gpc_pd($_POST['px_search'],1);

	if ($name_search=="" || $pass_search=="" || $px_search=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('各项均必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select * from lei_keyword where keyword='".$name_search."' limit 1";
	$result=$mysqli->query($sql);
	if(!$rs=$result->fetch_assoc()){
		
		$sql="insert into lei_keyword (keyword,pass,px) values ('".$name_search."','".$pass_search."','".$px_search."') ";
		$mysqli->query($sql);

		alert_ini();//输出alert所需文件
		echo "<script>alert_go('关键词添加成功！','alert_go','','ok','?".$back_url."');</script>";
		exit;
	}else{
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('关键词已经存在！','alert_back','','error','');</script>";
		exit;
	}
	$mysqli->close();

}
//结束


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

	
	$sql="select * from lei_keyword where id='".$id."' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		$sql="update lei_keyword set pass='0' where id='".$id."' limit 1";
		$mysqli->query($sql);

		alert_ini();//输出alert所需文件
		echo "<script>alert_go('关键词状态转为无效！','alert_go','','ok','?".$back_url."');</script>";
		exit;
	}else{
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('ID不存在！','alert_back','','error','');</script>";
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
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	


	<div class="h_a">信息检索</div>
		<div class="search_type cc mb10">
		<form action="?<?=encrypt_url("&page=".$page."&".$pageurl."&action=add&time=".time(),$key_url_md_5)?>" method="post" name="formsa" id="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<li>
					<label>标签内容：</label><input name="name_search" type="text" class="input length_2" id="name_search" value="">
				</li>

				<li>
					<label>是否有效：</label><select name="pass_search" class="select_2" id="pass_search">
						<option value="1" selected >有效</option>
						<option value="0" >无效</option>
					</select>
				</li>

				<li>
					<label>标签排序：</label><input name="px_search" type="text" class="input length_2" id="px_search" value="" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>

				

			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit" type="button" onClick="alert_go('确认添加关键词？','submit','formsa','wen','')" >添加关键词</button>
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
			  <td >序号</td>
				<td >标签内容</td>
				<td >有效性设置</td>
				<td >排序</td>
				<td >操作</td>
			</tr>
		</thead>
<?php
	
	$sql_search="select * from lei_keyword where pass<>'90' order by px "; //不显示被删除的
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
						<option value="0" <? if ($rs["pass"]=="0") {?>selected<? }?>>无效</option>
						<option value="1" <? if ($rs["pass"]=="1") {?>selected<? }?> >有效</option>
					</select></td>
			    <td><input name="zhongdian_px" type="text" class="input length_2" id="zhongdian_px" value="<?=$rs["px"]?>" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')"/></td>
			    <td>
				<button class="btn btn_submit" type="button" onClick="alert_go('确认修改？','submit','formlist_<?=$rs["id"]?>','wen','')" ><i class="icon-edit icon-white"></i> 保存设置</button>
				<? if ($rs["pass"]=='1'){?>
				&nbsp;&nbsp;
				<button class="btn btn_error" type="button" onClick="alert_go('确认设置无效？默认只是将关键词转为无效！','href','formlist_<?=$rs["id"]?>','wen','?<?=encrypt_url("&id=".$rs["id"]."&".$pageurl."&action=del&time=".time(),$key_url_md_5)?>')" ><i class="icon-trash icon-white"></i> 设置无效</button>
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
