<?
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
//--------------搜索条件生成
include_once("jingyan_post_all.php"); 
//--------------搜索条件生成
$id=$url_info['id'];
$action=$url_info['action'];
$time=$url_info['time'];

//修改用户-开始

if ($action=="baidu"){
	$urls = array(
		'http://'.$var_domain.'/',
		'http://'.$var_domain.'/jingyan/'.$id.'.html',
	);
	
	$api = 'http://data.zz.baidu.com/urls?site=www.mdaima.com&token=jImfT6HgJcLOFRt2';
	$ch = curl_init();
	$options =  array(
		CURLOPT_URL => $api,
		CURLOPT_POST => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POSTFIELDS => implode("\n", $urls),
		CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
	);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	
	$back_url=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	alert_ini();//输出alert所需文件
	echo "<script>alert_go('向百度推送成功！[".$result."]','alert_go','','ok','?".$back_url."');</script>";
	exit;
}
	
if ($action=="edit"){
	
	$title=quotes_gpc_pd($_POST['title'],1);
	$keyword=$_POST['keyword'];
	$laiyuan=quotes_gpc_pd($_POST['laiyuan'],1);
	$message=quotes_gpc_pd($_POST['message1'],0);
	$indate=quotes_gpc_pd($_POST['indate'],1);
	$pass=quotes_gpc_pd($_POST['pass'],1);
	$hits=quotes_gpc_pd($_POST['hits'],1);
	$shipin=quotes_gpc_pd($_POST['shipin'],1);
	$zhiding=quotes_gpc_pd($_POST['zhiding'],1);
	$pinglun=quotes_gpc_pd($_POST['pinglun'],1);
	$guanjianci=quotes_gpc_pd($_POST['guanjianci'],1);
	
	$article_suofang=quotes_gpc_pd($_POST['article_suofang'],1);
	$article_shuiyin=quotes_gpc_pd($_POST['article_shuiyin'],1);

	if ($title=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('文章标题必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if ($keyword==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('内容标签，必须填写（如无符合标签，请新添加）！','alert_back','','error','');</script>";
		exit;
	}
	
	if ($guanjianci==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('关键词，必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if ($message=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('文章内容必须填写','alert_back','','error','');</script>";
		exit;
	}
	
	if ($laiyuan=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('文章来源必须填写','alert_back','','error','');</script>";
		exit;
	}
	
	if ($hits=="" ){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('文章访问次数必须填写','alert_back','','error','');</script>";
		exit;
	}
	
	if ($indate==""){
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('文章日期，必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if ($_FILES["file"]["error"] !=4){
		
		function fileext($filename) 
		{ 
			return substr(strrchr($filename, '.'), 1); 
		}

		$type=array("jpg","gif","png","jpeg");//设置允许上传文件的类型 "jpeg","png"

		if(!in_array(strtolower(fileext($_FILES['file']['name'])),$type)){
			
			alert_ini();//输出alert所需文件
			echo "<script>alert_go('上传文件类型不正确！','alert_back','','error','');</script>";
			exit;
		}
		
		if ($_FILES["file"]["size"] > 500*1024){
			alert_ini();//输出alert所需文件
			echo "<script>alert_go('上传文件大小超过限制[500K]！','alert_back','','error','');</script>";
			exit;
		}
		
		$sql="select simgpaths from lei_jingyan where id='".$id."' limit 1 ";
		$result=$mysqli->query($sql);
		if($rs=$result->fetch_assoc()){
			$filePath=$rs["simgpaths"]; //只是获取路径，上传时用于覆盖，不生成新的图片文件
		}else{
			echo "系统错误或超时！";
			$mysqli->close();
			exit;
		}
		
		if ($_FILES["file"]["error"] > 0){
			echo "上传参数错误: " . $_FILES["file"]["error"] . "<br />";
		}else{
			move_uploaded_file($_FILES["file"]["tmp_name"],$filePath);//上传文件,后台上传用原路径，前台过滤../
		}
		//$newimgname_edit=",simgpaths='".$filePath."'"; 此项已取消
	
	}
	

	//超宽尺寸自动缩放 $var_article_suofang='1';//发布文章是否将内容中的图片自动缩放到指定宽度以内，1是，0否
	if ($article_suofang=='1'){
		if(preg_match("/<img.*>/",$message)){//如果有图片
			
			include_once("../mdaima_var_inc/new_image.class.php");
			$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,stripslashes($message),$match); //count($match)  获取到的图片路径数量
			$countm=count($match[1]); //1路径，0完整含标签<img>
			//print_r($match[1]);
			//exit;
			for ($i=0;$i<=$countm-1;$i++){
				@list($ws,$tt)=@getimagesize("..".$match[1][$i]);//注意路径
				if ($ws>660 || $tt>700){  //宽度超过660或，高度超过700，才按指定的宽高比例缩放
					$image=new image("..".$match[1][$i], 1, "660", "700" ,"..".$match[1][$i]);
					$image->outimage();
				}
			}
			
		}
	}
	

	//水印，图片处理完最后执行 $var_article_shuiyin='1';//发布文章是否将内容中的图片自动添加水印，1是，0否
	if ($article_shuiyin=='1'){
		if(preg_match("/<img.*>/",$message)){//如果有图片
			
			include_once("../mdaima_var_inc/new_image.class.php");
			$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,stripslashes($message),$match); //count($match)  获取到的图片路径数量
			$countm=count($match[1]); //1路径，0完整含标签<img>
			
			for ($i=0;$i<=$countm-1;$i++){
				@list($ws,$tt)=@getimagesize("..".$match[1][$i]);
				if ($ws>300 && $tt>50){  //宽度超过350且，高度超过250，才添加水印
					$image=new image("..".$match[1][$i], 3, "../images/shuiyin.gif", "9","..".$match[1][$i]);
					$image->outimage();
				}
			}
			
		}
	}

	$title_code = quweima($title);//将标题转为数字区位索引

	$keyword = implode(",",$keyword);
	$keyword = '-'.str_replace(",",'-,-',$keyword).'-';//封闭字符串  -1-,-12-,-5-
	
	$sql="update lei_jingyan set title='".$title."',title_code='".$title_code."',keyword='".$keyword."',shipin='".$shipin."',indate='".$indate."',laiyuan='".$laiyuan."',hits='".$hits."',pass='".$pass."',message='".$message."',zhiding='".$zhiding."',pinglun='".$pinglun."',guanjianci='".$guanjianci."' where id='".$id."' ";
	$mysqli->query($sql);
	
	$back_url=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//输出alert所需文件
	echo "<script>alert_go('文章保存成功！','alert_go','','ok','?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//结束

$sql="select * from lei_jingyan where id='".$id."' limit 1 ";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$title=$rs["title"];
	$keyword=$rs["keyword"];
	$indate=$rs["indate"];
	$laiyuan=$rs["laiyuan"];
	$simgpaths=$rs["simgpaths"];
	$hits=$rs["hits"];
	$message=$rs["message"];
	$pass=$rs["pass"];
	$shipin=$rs["shipin"];
	$zhiding=$rs["zhiding"];
	$pinglun=$rs["pinglun"];
	$guanjianci=$rs["guanjianci"];
}else{
	echo "系统错误或超时！";
	$mysqli->close();
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor_1.config.js"></script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>


<script language="JavaScript" type="text/javascript" src="js/pic.js"></script>
  
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:6;
}
-->
</style>
</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	

	<div class="h_a">功能说明</div>
	<div class="prompt_text">
		<ol>
			<li>文章状态分为“未发布”和“发布”，“未发布”状态下的文章前台不显示。</li>
		</ol>
	</div>

	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&action=edit&time=".time(),$key_url_md_5)?>"><!--//加密链变量 -->
	<div class="h_a">修改PHP经验信息</div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
			<tr>
			  <th>文章标题</th>
			  <td>
			  <input name="title" type="text" id="title" value="<?=$title?>" class="input length_5" /></td>
		  </tr>
			
			<tr>
			  <th>内容标签</th>
			  <td>
						<?

						$sql_search2="select * from lei_keyword where pass='1' order by px";
						$result2=$mysqli->query($sql_search2);
						$i=0;
						while ($rs2=$result2->fetch_assoc()){
						$i++;

						?>	<div style="float:left; width:130px; height:25px;">
							<input name="keyword[]" type="checkbox" value="<?=$rs2["id"]?>" <? if(strpos($keyword,"-".$rs2["id"]."-")!==false){?>checked="checked"<? }?> /> <?=$rs2["keyword"]?>
							</div>
						<? 
						}?></td>
		  </tr>
		   <tr>
		      <th>关键词</th>
		      <td><input name="guanjianci" type="text" class="input length_5" id="guanjianci" value="<?=$guanjianci?>" maxlength="30" />
		      &nbsp; 多个关键词，以半角逗号（,）分开（SEO关键词设置）</td>
	      </tr>
		    <tr>
              <th>是否视频</th>
		      <td><input name="shipin" type="text" id="shipin" value="<?=$shipin?>" class="input length_5" />&nbsp;&nbsp;<input name="shipin_button" type="button" value=" 填写时间格式 " onclick="document.getElementById('shipin').value='X小时XX分XX秒'" />
                <input name="shipin_button" type="button" value=" 清空 " onclick="document.getElementById('shipin').value=''" /></td>
	      </tr>
	      <tr>
			  <th>文章来源</th>
			  <td>
			  <input name="laiyuan" type="text" id="laiyuan" value="<?=$laiyuan?>" class="input length_5" />&nbsp;&nbsp;<select id="zhuanye_as" name="zhuanye_as" onChange="document.getElementById('laiyuan').value=this.options[this.selectedIndex].value" >
				<option value="">---选择来源---</option>
				<option value="本站原创">本站原创</option>
				<option value="本站整理">本站整理</option>
				<option value="互联网转载">互联网转载</option>
				<option value="腾讯网">腾讯网</option>
				<option value="虎嗅网">虎嗅网</option>
				<option value="PHP100">PHP100</option>
				<option value="PHPCHINA">PHPCHINA</option>
			</select></td>
		  </tr>
		   <tr>
			  <th>访问次数</th>
			  <td>
			  <input name="hits" type="text" id="hits" value="<?=$hits?>" class="input length_5" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
		  </tr>
			<tr>
			  <th>缩略图片</th>
			  <td><input name="file" type="file" id="file" class="input length_5"/>&nbsp; 180*130 不修改，勿上传 &nbsp;&nbsp;&nbsp;<a href="<?=$simgpaths?>" target="_blank" onMouseMove="show(event,'<?=$simgpaths?>','111')" onmouseout="hide(this)" >图片预览</a>&nbsp;&nbsp;&nbsp;<a href="/jingyan/?&see=true&search_open=ok" target="_blank" >列表预览</a>&nbsp;&nbsp;&nbsp;<a href="/jingyan/<?=$id?>.html?see=true" target="_blank" >文章预览</a>
			  <? if ($var_domain=='www.mdaima.com'){?>
			  &nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="alert_go('确认将本文章推送给百度？','href','','wen','?<?=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&action=baidu&time=".time(),$key_url_md_5)?>');">百度推送</a>
			  <? }?></td>
		  </tr>
			<tr>
			  <th>文章状态</th>
			  <td><select name="pass" class="select_5" id="pass">
						<option value="0" <? if ($pass=='0'){?>selected="selected"<? }?> >未发布</option>
						<option value="1" <? if ($pass=='1'){?>selected="selected"<? }?>>发布</option>
					</select></td>
		  </tr>
		  <tr>
			  <th>是否置顶</th>
			  <td>
			    <input type="radio" name="zhiding" value="0" <? if ($zhiding=='0'){?>checked="checked"<? }?> /> 不置顶&nbsp;&nbsp;
				<input type="radio" name="zhiding" value="1" <? if ($zhiding=='1'){?>checked="checked"<? }?>/> 置顶			  </td>
		  </tr>
		  <tr>
			  <th>是否评论</th>
			  <td>
			    <input type="radio" name="pinglun" value="0" <? if ($pinglun=='0'){?>checked="checked"<? }?>/> 不可以&nbsp;&nbsp;
				<input type="radio" name="pinglun" value="1" <? if ($pinglun=='1'){?>checked="checked"<? }?> /> 可以			  </td>
		  </tr>
			<tr>
			  <th>图片属性</th>
			  <td>
			    <input name="article_suofang" type="checkbox" value="1" />
		      自动缩放文章图片 &nbsp;&nbsp;&nbsp;&nbsp;             
		      <input name="article_shuiyin" type="checkbox" value="1" />
为文章图片添加水印</td>
		  </tr>
			<tr>
			  <th>发布日期</th>
			  <td>
			  <input name="indate" type="text" id="indate" value="<?=$indate?>" onFocus="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="true" class="input length_5" /></td>
		  </tr>
			

			<tr>
			  <th>文章内容</th>
			  <td><script id="editor1" name="message1" type="text/plain" style="width:99%;height:150px;"><?=$message?></script>			  </td>
		  </tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('确认保存文章？','submit','formsa','wen','')" >保存文章</button>
			&nbsp;
			<?
			$back_url=encrypt_url("&page=".$page."&aid=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
			?>
			<button class="btn btn_big loading_it" type="button" onClick="document.location.href='jingyan_list.php?<?=$back_url?>';" > 返回列表 </button>
			
			
		</div>
	</div>

	</form>
</div>

<script type="text/javascript">
    var ue1 = UE.getEditor('editor1');
</script>
<div id="a1" style=" position:absolute; z-index:9999;"></div>

<? /*
<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" /><!--引用JQ -->
<script type="text/javascript" src="js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript">
	//<img id="photo" src="/images/1.jpg" />
	$(document).ready(function () {
		$('#photo').imgAreaSelect({ maxWidth: 217, maxHeight: 156, handles: true,fadeSpeed: 200});
		//{ aspectRatio: '4:3', handles: true }{ x1: 120, y1: 90, x2: 280, y2: 210 , onSelectChange: preview }
	});
</script>
*/
?>
</body>
</html>
