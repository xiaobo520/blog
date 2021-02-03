<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php");  


$action=$_REQUEST['action'];
if ($action=='quxiao'){//取消提醒 
	$sql="update lei_cs set zt_tixing_reg='0',zt_tixing_huitie='0',zt_tixing_host='0' where id='1' limit 1 ";
	$mysqli->query($sql);
}


$sql="select username,xingming from lei_admin where username='".$_SESSION['blog_lileiuser']."'";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$username=$rs["username"];
	$xingming=$rs["xingming"];
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" />
<script language="JavaScript" type="text/javascript" src="js/css_change.js"></script>
<script>
function GetXmlHttpObject(){
		var xmlHttp=null;
		try{
			// Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
		}
		catch (e){
			// Internet Explorer
			try{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e){
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		return xmlHttp;
		
	}
	
	function check_timer(){
		
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null){
			alert ("抱歉，浏览器不支持")
			return
		} 
		
		var url="online.php"
		url=url+"?action=chk"
		url=url+"&sid="+Math.random()
		
		xmlHttp.onreadystatechange=stateChanged
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		
		function stateChanged(){ 
			if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
			
					var result_str=xmlHttp.responseText.split("|");
					
					if ( result_str[0]==1 ){ //有内容
					
						document.getElementById("tishi").innerHTML='消息：'+result_str[1];
						
					}else{
						document.getElementById("tishi").innerHTML='消息：暂时没有新通知内容！';
					}

			 }
		}
			
	}
	
	check_timer();
	setInterval(function(){check_timer()},30000);
</script>
<style type="text/css">
body { margin:0px; font-size:12px;font-family: 微软雅黑,宋体,Arial, Helvetica, sans-serif; }
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
div { margin:0px; padding:0px; }
.system_logo {float:left; text-align:left;margin-left:18px; margin-top:1px; background:url(images/logo.gif) no-repeat; width:500px;}
/*- Menu Tabs 6--------------------------- */

#tabs {
  float:right;
  width:auto;
  line-height:normal;
  margin-right:20px;
  _margin-right:10px;
  }
#tabs ul {
  margin:0;
  padding:27px 10px 0 0px;
  list-style:none;
  }
  
@-moz-document url-prefix() { #tabs ul{ padding:26px 10px 0 0px;} }
/*仅支持firefox浏览器*/
  
#tabs li {
  display:inline;
  margin-right:0;
  padding:0;
  }
#tabs a {
  float:left;
  background:url("skins/images/tableft6.gif") no-repeat left top;
  margin:0;
  padding:0 0 0 4px;
  text-decoration:none;
  
  }
#tabs a span {
  float:left;
  display:block;
  background:url("skins/images/tabright6.gif") no-repeat right top;
  padding:8px 8px 6px 6px;
  color:#E9F4FF;
  
  }
/* Commented Backslash Hack hides rule from IE5-Mac \*/
#tabs a span {float:none;}
/* End IE5-Mac hack */
#tabs a:hover span {
  color:#fff;
  }
#tabs a:hover {
	position: relative;
  background-position:0% -42px;
  }
#tabs a:hover span {

  background-position:100% -42px;
  color:#222;
  z-index:9999;
  }

/*----点击后样式*/
#tabs .hifocus a {
  background-position:0% -42px;
}
  
#tabs .hifocus a span {
  background-position:100% -42px;
  color:#222;
}
/*----点击后样式*/


.ss {
   color:#000000
  }
.ss1 {
  background-position:0% -42px;
  }
  
  .link_normal{ background:url(images/dh_bg.gif);background-position:-199px 0; width:102px;height:42px; text-align:center; line-height:42px; float:left; margin-right:5px;}
.link_normal:hover{background-position:-97px 0;}
.link_active{width:97px;background-position:0 0;}
.link_active:hover{background-position:0 0;}
.link_normal a{color:#FFFFFF; font-weight:bold; outline:none;}
.link_active a{color: #333333;}

</style>
<SCRIPT>

function shleft(){
	if(window.parent.document.getElementById("left_all").cols == "185,*") {
		window.parent.document.getElementById("left_all").cols ="0,*";
		document.getElementById("ImgArrow").src="images/window_duplicate.png";
    } else {
        window.parent.document.getElementById("left_all").cols="185,*";
        document.getElementById("ImgArrow").src="images/window.png";
    }

}

function active_class(a){

		//removeClass('active_class_1','link_active')
		//removeClass('active_class_2','link_active')
		//removeClass('active_class_3','link_active')
		
		//addClass('active_class_'+a,'link_active')
		document.getElementById("active_class_1").className="link_normal";
		document.getElementById("active_class_2").className="link_normal";
        document.getElementById("active_class_3").className="link_normal";
		document.getElementById("active_class_"+a).className="link_normal link_active";
		
		addClass('active_i_1','icon-white');
		addClass('active_i_2','icon-white');
		addClass('active_i_3','icon-white');
		removeClass("active_i_"+a,'icon-white');
		
}

</SCRIPT>
<!--LOADING 加载开始-->
	<div id="loading" style="position: absolute; width:100%; margin:0 auto; text-align:center; height:100%; display:none">
		<!--<div style="position: absolute; width:100%; margin:0 auto; text-align:center; height:100%; background:#CCCCCC;filter:alpha(opacity=20);-moz-opacity:0.2;opacity:0.2;"></div>--><!--背景层 -->
		<div class="loading">
			<table width="120" border="0">
			  <tr>
				<td width="40" align="right" valign="middle" style="padding-top:4px;"><img src="images/loading.gif" border="0" /></td>
				<td width="80" align="left" valign="middle">&nbsp;&nbsp;加载中...</td>
			  </tr>
		  </table>
		</div>
	</div>
<!--LOADING END-->
<div style="position:absolute; right:20px; top:39px;">
	
	<div id="active_class_1" class="link_normal link_active" >					
		<a href="#" onclick="parent.leftFrame.getfirst();active_class(1)" hidefocus="true"><i id="active_i_1" class="icon-home"></i> 系统首页</a>	   				
	</div>

	
	<div id="active_class_2" class="link_normal" >					
		<a href="#" onclick="parent.leftFrame.getdanwei();active_class(2)" hidefocus="true"><i id="active_i_2" class="icon-list icon-white"></i> 站点管理</a>	   				
	</div>
	
	<div id="active_class_3" class="link_normal" >					
		<a href="/" target="_blank" hidefocus="true"><i id="active_i_3" class="icon-tag icon-white"></i> 网站首页</a>	   				
	</div>
		
	
	<div class="link_normal" >					
		<a href="login_true.php?action=out" hidefocus="true" onClick="return confirm('确认退出系统？')" target="_top"><i class="icon-off icon-white"></i> 退出系统</a>		
	</div>
	
</div>







<div class="menu" style="background:url(images/bg_blue.gif) repeat-x; height:124px;">
	<div class="system_logo">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="408" height="72">
					  <param name="movie" value="images/flash/20.swf" />
					  <param name="quality" value="high" />
					  <param name="wmode" value="transparent" />
					  <embed src="images/flash/20.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="408" height="72" wmode="transparent"></embed>
		  </object>
	</div>
	
	<div style=" position:absolute;top:93px;*top:94px;_top:94px; left:22px;">
		<div style="float:left"><a href="#" onclick="shleft();" hidefocus="true"><img src="images/window.png" id="ImgArrow" title="展开/还原窗口" /></a></div>
		<div style="float:left; margin-left:20px;"><img src="images/comments.png" /></div>
		<div style="float:left; margin-left:5px;" id="tishi">消息：暂时没有新通知内容！</div>
	</div>
	
	<div style=" position:absolute;top:93px;*top:94px;_top:94px; right:22px;">
		<i class="icon-user"></i> 当前用户：<?=$xingming?> [<?=$username?>]
	</div>
	
	
	<div style="clear:both"></div>
</div>

<link href="css/nprogress.css" rel='stylesheet' />
<script src='js/jquery.min.js'></script>
<script src='js/nprogress.js'></script>

</body>
</html>