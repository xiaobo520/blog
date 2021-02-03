<?
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
//--------------搜索条件生成
include_once("jingyan_post_all.php"); 
//--------------搜索条件生成
$action=$url_info['action'];
$time=$url_info['time'];

//修改用户-开始

if ($action=="add"){

	$title=quotes_gpc_pd($_POST['title'],1);
	$fenzu=$_POST['fenzu'];
	$message=quotes_gpc_pd($_POST['message1'],0);
	$indate=quotes_gpc_pd($_POST['indate'],1);
	$pass=quotes_gpc_pd($_POST['pass'],1);
	$px=quotes_gpc_pd($_POST['px'],1);
	

	if ($title=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('代码标题必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if ($fenzu==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('代码分类，必须填写（如无符合标签，请新添加）！','alert_back','','error','');</script>";
		exit;
	}
	
	if ($px==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('排序，必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	
	
	if ($indate==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('发布日期，必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	$title_code = quweima($title);//将标题转为数字区位索引
	
	$sql="insert into lei_daima (title,message,indate,fenzu,pass,px) values ('".$title."','".$message."','".$indate."','".$fenzu."','".$pass."','".$px."') ";
	$mysqli->query($sql);

	$result_zidian=$mysqli->query("select last_insert_id()");//mysql_insert_id($mysqli);//获取自动增键
	if($mysqllast=$result_zidian->fetch_assoc()){
		$aid=$mysqllast["last_insert_id()"];//关联ID
	}
	
	$back_url=encrypt_url("&page=".$page."&aid=".$aid."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//输出alert所需文件
	echo "<script>alert_go('代码添加成功！','alert_go','','ok','daima_list.php?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//结束

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
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	

	<div class="h_a">功能说明</div>
	<div class="prompt_text">
		<ol>
			<li>代码状态分为“未发布”和“发布”，“未发布”状态下的代码前台不显示。</li>
		</ol>
	</div>

	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&".$pageurl."&action=add&time=".time(),$key_url_md_5)?>"><!--//加密链变量 -->
	<div class="h_a">添加代码库信息</div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
			<tr>
			  <th>代码标题</th>
			  <td>
			  <input name="title" type="text" id="title" value="" class="input length_5" /></td>
		  </tr>
			
			<tr>
			  <th>代码分组</th>
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
			  <th>排序编号</th>
			  <td>
			  <input name="px" type="text" id="px" value="10000" class="input length_5" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
		  </tr>
			<tr>
			  <th>发布状态</th>
			  <td><select name="pass" class="select_5" id="pass">
						<option value="0" selected >未发布</option>
						<option value="1" >发布</option>
					</select></td>
		  </tr>
			<tr>
			  <th>发布日期</th>
			  <td>
			  <input name="indate" type="text" id="indate" value="<?=date("Y-m-d H:i:s")?>" onFocus="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="true" class="input length_5" /></td>
		  </tr>
			

			<tr>
			  <th>代码内容</th>
			  <td><script id="editor1" name="message1" type="text/plain" style="width:99%;height:150px;"></script></td>
		  </tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('确认保存代码？','submit','formsa','wen','')" >保存代码</button>
			&nbsp;
			<?
			$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
			?>
			<button class="btn btn_big loading_it" type="button" onClick="document.location.href='daima_list.php?<?=$back_url?>';" > 返回列表 </button>
			
			
		</div>
	</div>

	</form>
</div>

<script type="text/javascript">
    var ue1 = UE.getEditor('editor1');
</script>
</body>
</html>
