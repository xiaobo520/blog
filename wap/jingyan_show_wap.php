<?
if ($wap_mobile!='true') exit;

include_once("mdaima_var_inc/config_system.php");
include_once("mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("mdaima_var_inc/conn.php"); 
include_once("wap/c_inc/c_inc.php"); 

$cid=$_REQUEST["id"];

if ($_SESSION['blog_lileiuser']!="" && $_REQUEST['see']=='true'){//Ϊ��̨Ԥ��Ч��׼��
	$pass_str="";
}else{
	$pass_str=" and pass='1' ";
}

$sql="select * from lei_jingyan where id='".$cid."' ".$pass_str." limit 1 ";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$title=$rs["title"];
	$indate=$rs["indate"];
	$laiyuan=$rs["laiyuan"];
	$guanjianci=$rs["guanjianci"];
	$simgpaths=$rs["simgpaths"];
	$hits=$rs["hits"]+1;
	$message=$rs["message"];
	$pass=$rs["pass"];
	$shipin=$rs["shipin"];
	$pinglun=$rs["pinglun"];
}else{
	echo "���²����ڣ�";
	$mysqli->close();
	exit;
} 

$sql="update lei_jingyan set hits='".$hits."' where id='".$cid."' limit 1";//���·�������
$mysqli->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
<title><?=$title?>-�����-���ײ���</title>
<meta name="Keywords" content="<?=$guanjianci?>">
<meta name="description" content="<?=mysubstr(clear_all($message),0,120, 'gbk')?>" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta http-equiv="cache-control" content="no-cache" />
<meta name="applicable-device" content="mobile">
<meta http-equiv="pragram" content="no-cache">
<meta meta name="format-detection" content="telephone=no,email=no,adress=no" />
<link href="/wap/style.css?v=2020031000017" rel="stylesheet" media="screen">
<script type="text/javascript" src="/wap/js/jquery-1.7.1.min.js"></script>
</head>
<body>

<? include_once("wap/top.php"); ?>

	
<!--�ⲿ�� -->
<div class="box">
	
	<div class="artbox">
		<h1 class="content_title"><?=$title?></h1>
		<div class="content_right">���£�<?=$indate?>&nbsp;&nbsp;&nbsp;������<?=$hits?>&nbsp;&nbsp;&nbsp;��Դ��<?=$laiyuan?></div>
		<div class="i_lb_r_hr"></div>
		
		<div class="content_art"><?=$message?></div>
		
		<div class="i_lb_r_hr"></div>
	</div>
	
	<? include_once("wap/foot.php"); ?>
	
	
</div>
<!--�ⲿ��end -->

<script type="text/javascript" src="/js/tooledit/ueditor_baidu/ueditor.parse.min.js"></script>
<script type="text/javascript" src="/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js"></script>
<link href="/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	uParse('.content_art',{
		'highlightJsUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js',
		'highlightCssUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css'
	});
	
	SyntaxHighlighter.all();
	
});
</script>


</body>
</html>
