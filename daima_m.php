<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>大胆哥博客 常用代码片断分享 www.ubug.icu</title>
<link rel="stylesheet" id="daima_style" title="Default" href="/css/gaoliang/agate.css"><!--样式style -->
<link rel="stylesheet" href="/css/zTreeStyle/zTreeStyle.css" type="text/css">
<style>
	body{
	background: #333;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

	ul,li{ list-style:none;}
	
	pre { margin:0}
	
	ul.ztree {overflow:hidden}/*设置树形样式*/
	.rolinList{ height:auto;margin-left:-35px;*margin-left:5px;_margin-left:4px;}
	
	#left{padding:0; text-align:left; width:240px;}
	#left_box{background:#FFFFFF;border:20px solid #FFFFFF; border-left:0; border-right:0; -moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;overflow-x:hidden;overflow-y:auto; 
	}

	#right{ padding:0 20px; text-align:left;}
	#right_box{ position:relative;border:20px solid #FFFFFF;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; background:#fff;overflow-x:hidden;overflow-y:auto; }
	
	#left_box::-webkit-scrollbar,#right_box::-webkit-scrollbar {
		/*滚动条整体样式*/
		width : 8px;  /*高宽分别对应横竖滚动条的尺寸*/
		height: 1px;
	}
	#left_box::-webkit-scrollbar-thumb,#right_box::-webkit-scrollbar-thumb {
		/*滚动条里面小方块*/
		border-radius: 8px;
		box-shadow   : inset 0 0 5px rgba(0, 0, 0, 0.2);
		background   : #ccc
	}
	#left_box::-webkit-scrollbar-track,#right_box::-webkit-scrollbar-track {
		/*滚动条里面轨道*/
		box-shadow   : inset 0 0 5px rgba(0, 0, 0, 0.2);
		border-radius: 8px;
		background   : #ededed;
	}
	
	#alerts{ position: absolute;color:#111111; -moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;background:#FFFFFF; width:200px; height:100px; font-size:12px; text-align:center; display:none; z-index:3}
	
	#alerts_bg{ position: absolute; display:none; background:#666;filter: alpha(opacity=90);-moz-opacity: 0.8;opacity: 0.8; z-index:1;}
	
	code.has-numbering {
		margin-left: 45px;
	}
	
	.pre-numbering {
		position: absolute;
		top:9px;
		left:0;
		width: 45px;
		padding: 0 0 0 0;
		line-height:15px;
		border-right:2px solid #FF6600;
		text-align: center;
		color: #AAA;
		font-family: italic;
		font-size:12px;
	}
	
	
	
	
</style>
<script type="text/javascript" src="/js/highlight.pack.js"></script>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="/js/jquery.ztree.exhide-3.5.min.js"></script>
<script type="text/javascript">
<!--
var setting = {
	view: {
		dblClickExpand: true,
		showLine: true,
		fontCss: getFont,
		nameIsHTML: true
	},
	data: {
		simpleData: {
			enable: true
		}
	},
	callback: {
		onClick: zTreeOnClick
	}
	
};

function zTreeOnClick(event, treeId, treeNode) {
    //alert(treeNode.tId + ", "+treeNode.id + ", " + treeNode.name+","+treeNode.pId);
	if (treeNode.pId!=null && treeNode.name!='返回博客首页' ){
		show_daima(treeNode.id);
	}
};

/*
function onClick(e,treeId, treeNode) {
	//$.fn.zTree.getZTreeObj("treeDemo").expandNode(treeNode);
	//$.fn.zTree.getZTreeObj("treeDemo2").expandNode(treeNode);
	//alert(treeId+","+treeNode.id + ", " + treeNode.name+","+treeNode.pId);
	if (treeNode.name!='网站首页' && treeNode.name!='退出系统'  && treeNode.name!='系统首页'  && treeNode.name!='站点管理'  && treeNode.name!='前台管理'  && treeNode.name!='业务管理' ){
		show_loading();//激活loading
	}
	alert('1')

}
*/

var zNodes =[
<?
	$sql_search="select * from lei_daima_bk where pass='1' order by px ";
	$i=0;
	$result=$mysqli->query($sql_search);
	while ($rs=$result->fetch_assoc()){	
		$i++;
		$sql_page="select count(*) from lei_daima where pass='1' and fenzu='".$rs["id"]."'";
		$result_page=$mysqli->query($sql_page);
		$rs_page=$result_page->fetch_array();
		$pageidcount=$rs_page[0];
?>
		{ id:<?="0009999".$rs["id"]?>, pId:0, name:"<?=$rs["keyword"]?>（<?=$pageidcount?>）",open:true},
			<?
				$sql_1="select id,title,pass from lei_daima where pass='1' and fenzu='".$rs["id"]."' order by px ";
				$result1=$mysqli->query($sql_1);
				while ($rs1=$result1->fetch_assoc()){
				
				//page_white_code_red   page_white_code
				
				if ($i % 2 ==0){
					$imgs="page_white_code_red";
				}else{
					$imgs="page_white_code";
				}
			?>
			{ id:<?=$rs1["id"]?>, pId:<?="0009999".$rs["id"]?>, name:"<?=$rs1["title"]?>",open:true,url:"", target:"frmright", icon:"/css/zTreeStyle/img/diy/<?=$imgs?>.png"},
			<? }?>
	<? }?>
	
	//{ id:11999999, pId:0, name:"返回博客首页",open:false,url:"/", target:"frmright", icon:"/css/zTreeStyle/img/diy/1_open.png"}


];



function getFont(treeId, node) {
	return node.font ? node.font : {};
}

$(document).ready(function(){
	$.fn.zTree.init($("#treeDemo"), setting, zNodes);

});
//-->
</script>
</head>

<body id="body">
<div style="clear:both; height:60px; line-height:60px; padding:0 0 0 40px; ">
	<a href="/" style="font-size:22px; font-family:微软雅黑; color: #BFBFBF; text-decoration:none;">大胆哥博客 个人常用代码库备忘手册 www.ubug.icu</a>
</div>

<table id="bigbox" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:0 20px 0 40px;">
	<tr>
		<td id="left" valign="top" align="left">
		<div style="position:relative">
			<div id="left_box">
				<ul class="rolinList" id="rolin" >
					<li> 
						<ul id="treeDemo" class="ztree" style="margin-top:-6px;" ></ul>
					</li>
				</ul>
			</div>
		</div>
		</td>
		
		<td id="right" valign="top" align="left">
		<div id="right_box">
			<div id="alerts_bg"><!--背景层 --></div>
			<div id="alerts"><img src="/images/load_4.gif" border="0"  width="146" height="95"/><!--提示层 --></div>
		
		<div id="get_code" class="content_art" style=" padding:20px;font-family:微软雅黑;">
			<div id="default_div" style=" color:#111; margin:auto auto; text-align:center; font-size:24px; font-family:微软雅黑; ">大胆哥博客 个人常用代码库备忘手册 www.ubug.icu </div>
		</div>
</div>
		</td>
	</tr>
</table>


<div style="clear:both; height:50px; line-height:50px; font-size:12px; font-family:微软雅黑; color: #999999; text-align:center">
	Copyright &copy; 2018-<?=date("Y")?> www.ubug.icu All Rights Reserved. <a href="/" style="color:#999999; text-decoration:none">大胆哥博客</a> 个人常用代码库备忘手册
				<!--&nbsp;&nbsp;&nbsp;&nbsp;代码风格：
				<select onchange="changeStyle(this.value)" id="codestyle">
					 <option value="agate" selected>agate</option>
					 <option value="atelier-dune-dark">dune</option>
					 <option value="default">default</option> 
					 <option value="atelier-lakeside-light">lakeside</option>
				</select>-->
</div>
  
<script src="/js/light.js"></script>


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

	document.getElementById('default_div').style.marginTop=parseInt((document.documentElement.clientHeight)/2-110)+"px";
	
});
</script>
	
<?php /*?><script src="/js/jquery.cookie.js" type="text/javascript"></script>
<?
if ($_COOKIE["daima_style"]!=''){
?>
	<script>changeStyle("<?=$_COOKIE["daima_style"]?>");$("#codestyle").val("<?=$_COOKIE["daima_style"]?>");</script>
<?
}
?><?php */?>
</body>
</html>
