<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
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
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('网页过期，禁止操作！','alert_back','','error','');</script>";
		exit;
	}

	if ($id==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('ID不存在！','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="delete from lei_link where id='".$id."'";
	$mysqli->query($sql);
	
	alert_ini();//输出alert所需文件
	echo "<script>alert_go('删除成功！','alert_go','','ok','?".$back_url."');</script>";//不需要返回参数
	exit;
		
	$mysqli->close();

}

if ($action=="edit"){

	
	if ($linkname=="" || $url=="" || $px==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('信息不能为空！','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select * from lei_link where id='".$id."'";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$sql="update lei_link set linkname='".$linkname."',url='".$url."',px='".$px."',pass='".$pass."' where id='".$id."'";
		$mysqli->query($sql);
		
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('修改成功！','alert_go','','ok','?".$back_url."');</script>";
		exit;
	}else{
		$mysqli->close();
		echo "<script language=javascript>alert('系统错误或系统超时！');javascript:history.back(-1);</script>";
		exit;
	}
}

if ($action=="add"){

	if ($linkname=="" || $url=="" || $px==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('信息不能为空！','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="insert into lei_link (linkname,url,px,indate,pass) values ('".$linkname."','".$url."','".$px."','".$indate."','".$pass."') ";  //写入主题信息
	$mysqli->query($sql);
	
	alert_ini();//输出alert所需文件
	echo "<script>alert_go('添加成功！','alert_go','','ok','?".$back_url."');</script>";
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
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	


	<div class="h_a">友情链接-添加</div>
		<div class="search_type cc mb10">
		<form action="?<?=encrypt_url("&page=".$page."&".$pageurl."&action=add&time=".time(),$key_url_md_5)?>" method="post" name="formsa" id="formsa">
		<div class="ul_wrap">
			<ul class="cc">
				<li>
					<label>网站名称：</label><input name="linkname" type="text" class="input length_3" id="linkname" value="">
				</li>
				
				<li>
					<label>网址：</label><input name="url" type="text" class="input length_3" id="url" value="http://">
				</li>
				
				<li>
					<label>状态：</label><select name="pass" class="select_2" id="pass">
						<option value="通过" selected >通过</option>
						<option value="暂停" >暂停</option>
					</select>
				</li>

				<li>
					<label>排序：</label><input name="px" type="text" class="input length_3" id="px" value="" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>

				

			</ul>
		</div>
		<div class="btn_side">
			<button class="btn btn_submit" type="button" onClick="alert_go('确认添加友情链接？','submit','formsa','wen','')" >添加友情链接</button>
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
			  <td >序号</td>
				<td >链接名称</td>
				<td >链接地址</td>
				<td >排序</td>
				<td >状态</td>
				<td >操作</td>
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
						<option value="暂停" <? if ($rs["pass"]=="暂停") {?>selected<? }?>>暂停</option>
						<option value="通过" <? if ($rs["pass"]=="通过") {?>selected<? }?> >通过</option>
					</select></td>
			    <td>
				<button class="btn btn_submit" type="button" onClick="alert_go('确认修改？','submit','formlist_<?=$rs["id"]?>','wen','')" ><i class="icon-edit icon-white"></i> 保存</button>
				&nbsp;&nbsp;
				<button class="btn btn_error" type="button" onClick="alert_go('确认删除？','href','formlist_<?=$rs["id"]?>','wen','?<?=encrypt_url("&id=".$rs["id"]."&".$pageurl."&action=del&time=".time(),$key_url_md_5)?>')" ><i class="icon-trash icon-white"></i> 删除</button>
				</td>
			</tr>
		</form>
	<?php }?>
	</table>
	</div>
	
	
</div>


</body>
</html>
