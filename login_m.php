<?
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php"); 

$comeurl=$_SERVER["HTTP_REFERER"];
$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$action=$url_info['action'];
$url=$url_info['url'];

if ($action=="out"){
	$_SESSION['user_lei_username']="";
	//setcookie("7d_cokie_u",'',time()-100);
	//setcookie("7d_cokie_p",'',time()+100);
	echo "<script>location.href='/';</script>";
	exit;
}

if ($_SESSION['user_lei_username']!=''){
	echo "<script>location.href='/home.html';</script>";
	exit;
}

if ($action=="go"){
	
	$urlresult=base64_decode($url);
	if ($urlresult=='' || strpos($urlresult,"login.html")!==false || strpos($urlresult,"register.html")!==false || strpos($urlresult,"losepass.html")!==false || strpos($urlresult,"losepass_2.html")!==false  || strpos($urlresult,"back_safe.html")!==false ){
			$comeurl="home.html";
	}else{
		$comeurl=$urlresult;
	}

	$password=quotes_gpc_pd($_POST['password'],1);  //转义
	$username=quotes_gpc_pd($_POST['username'],1);
	
	
	if (check_null($password)=='0' || check_null($username)=='0' ){
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('用户名和密码必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_str_teshu($username)=='result_false' || check_str_teshu($password)=='result_false' || substr($username,0,7)=='mdaima#'){//mdaima_为游客发贴标记邮箱前缀

		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('特殊字符检测失败！','alert_back','','error','');</script>";
		exit;
	
	}

	$sql="select username,password,pass from lei_user where username='".$username."' limit 1 " ;
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		if($rs["pass"]!='1'){
			$result->free();
			$mysqli->close();
			alert_ini_index();//输出alert所需文件
			echo "<script>alert_go('您处于锁定(审核)状态，无法登录！','alert_back','','error','');</script>";
			exit;

		}

		//substr(md5("1"),8,16); // 16位MD5加密
		
		//提交前已经JS经MD5加过密了，与修改密码相比，少了一道
		if(md5($password.md5('@lei_user7d'))==$rs["password"] ){ //  *******************或为兼容  || substr(md5($password),8,16)==$rs->password

			$_SESSION['user_lei_username']=$rs["username"];
			setcookie("7d_cokie_u",$rs["username"],time()+9999999); // $_COOKIE["7d_cokie_u"]
			//setcookie("7d_cokie_p",$password,time()+9999999); // $_COOKIE["7d_cokie_u"]
			
			
			jilu_in($username,$var_jifen_denglu,'denglujiangli','');//积分

			$result->free();
			$mysqli->close();
			
			echo "<script>location.href='".$comeurl."';</script>";
			exit;
		} 
		else{

			$result->free();
			$mysqli->close();
			alert_ini_index();//输出alert所需文件
			echo "<script>alert_go('用户名或密码不正确！','alert_back','','error','');</script>";
			exit;
		}

	}else{
		$result->free();
		$mysqli->close();
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('用户名或密码不正确！','alert_back','','error','');</script>";
		exit;

	}

}


if ($action=="reg"){

	$password1=quotes_gpc_pd($_POST['password1'],1);  //转义
	$password2=quotes_gpc_pd($_POST['password2'],1);  //转义
	$username=quotes_gpc_pd(str_replace(' ','',$_POST['zcusername']),1);
	
	if (check_null($password1)=='0' || check_null($username)=='0' ){
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('用户名和密码必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_tel_mail($username,2)=='result_false' ){
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('您的用户名（邮箱）格式不正确！','alert_back','','error','');</script>";
		exit;
	
	}
	
	if ($password1!=$password2){
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('两次密码输入不一致！','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_str_teshu($username)=='result_false' || check_str_teshu($password)=='result_false' || substr($username,0,7)=='mdaima#'){//mdaima_为游客发贴标记邮箱前缀

		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('特殊字符检测失败！','alert_back','','error','');</script>";
		exit;
	
	}
	
	$sql="select username from lei_user where username='".$username."' limit 1 " ;
	$result=$mysqli->query($sql);
	if(!$rs=$result->fetch_assoc()){
	
		$indate=date("Y-m-d H:i:s");
		
		$touxiang_first='';
		for ($ti=1;$ti<26;$ti++){
			$touxiang_first=$touxiang_first.",".$ti;
		}
		$touxiang_first=substr($touxiang_first,1);
		$touxiang_rand=explode(',',$touxiang_first);
		shuffle($touxiang_rand);//打乱数组
		$xuan_img="/images/touxiang/".$touxiang_rand[0].".jpg";

		$sql="insert into lei_user (username,userimg,password,nicheng,nicheng_py,pass,jifen,jifen_all,indate,lasttime) values ('".$username."','".$xuan_img."','".md5(md5($password1).md5('@lei_user7d'))."','码代码网友','mdmwy','".$var_register_pass."','0','0','".$indate."','".$indate."') ";
		$mysqli->query($sql);
		
		$sql="update lei_cs set zt_tixing_reg=zt_tixing_reg+1 where id='1' limit 1 ";//后台提醒更新状态，注册
		$mysqli->query($sql);
		
		//substr(md5("1"),8,16); // 16位MD5加密*******************或为兼容  || substr(md5($password),8,16)==$rs->password

		if($var_register_pass=='1'){ //  默认注册就开通才可以登录

			$_SESSION['user_lei_username']=$username;
			setcookie("7d_cokie_u",$username,time()+9999999); // $_COOKIE["7d_cokie_u"]
			//setcookie("7d_cokie_p",$password,time()+9999999); // $_COOKIE["7d_cokie_u"]
			
			jilu_in($username,$var_jifen_reg,'qita','注册奖励');//其它
			jilu_in($username,$var_jifen_denglu,'denglujiangli','');//积分

			$result->free();
			$mysqli->close();
			
			echo "<script>location.href='home.html';</script>";
			exit;
		}else{
			$result->free();
			$mysqli->close();
			alert_ini_index();//输出alert所需文件
			echo "<script>alert_go('注册成功，请等待博主审核（审核通过有邮件通知）！','alert_go','','ok','http://".$var_domain."');</script>";
			exit;
	
		}

	}else{
		$result->free();
		$mysqli->close();
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('用户名（邮箱）已经被注册了，请重新选择！','alert_back','','error','');</script>";
		exit;

	}

}


if ($action=="lose"){
	
	$username=quotes_gpc_pd($_POST['loseusername'],1);
	
	
	
	if (check_null($username)=='0' ){
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('注册时的邮箱必须填写！','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_tel_mail($username,2)=='result_false' ){
		
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('您的邮箱格式不正确！','alert_back','','error','');</script>";
		exit;
	
	}
	
	if (check_str_teshu($username)=='result_false' || substr($username,0,7)=='mdaima#'){//mdaima_为游客发贴标记邮箱前缀

		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('特殊字符检测失败！','alert_back','','error','');</script>";
		exit;
	
	}

	$sql="select username,pass from lei_user where username='".$username."' limit 1 " ;
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		if($rs["pass"]!='1'){
			$result->free();
			$mysqli->close();
			alert_ini_index();//输出alert所需文件
			echo "<script>alert_go('您处于锁定(审核)状态，无法找回密码，请联系QQ:858353007！','alert_back','','error','');</script>";
			exit;

		}
		
		//默认并不直接更新密码，需要用户点击激活邮件链接，才更新密码，防止恶意被用户利用，这样非自己操作时就受原密码登录影响

		//发邮件
		$smtpemailto 	= 	$username;//发送给谁，多个邮箱以半角逗号分隔，默认要发给自己
		$mailsubject 	= 	iconv('gbk','utf-8','您申请码代码-李雷博客的重置密码请求，请在30分钟内操作！');//邮件主题
		$mailtime		=	date("Y-m-d H:i:s");
		$utfmailbody	=	"请在30分钟内通过以下链接获取新的随机密码，使用随机密码登录后修改为您常用的密码。（超过30分钟链接自动失效！）<br><a href='http://".$var_domain."/back_safe.html?".encrypt_url('p=safe&u='.$username.'&time='.time(),$key_url_md_5)."' target='_blank'>http://".$var_domain."/back_safe.html?".encrypt_url('p=safe&u='.$username.'&time='.time(),$key_url_md_5)."</a><br><span style='color:#FF0000'>如非本人操作，请勿点击链接，忽略即可！（本邮件为系统自动发送，请勿回复）</span>";
		$utfmailbody 	= 	iconv('gbk','utf-8',$utfmailbody);
		$mailtype 		= 	"HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		
		include_once("./mdaima_var_inc/sendmail.php");//发送邮件类
		
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp->debug = FALSE;//是否显示发送的调试信息 FALSE or TRUE
		if($smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $utfmailbody, $mailtype)){
			//echo '发送成功';
		}
		
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('密码找回成功！已发送邮件到您注册时的邮箱，请重新激活并修改密码！','alert_go','','ok','http://".$var_domain."');</script>";
		exit;

	}else{
		$result->free();
		$mysqli->close();
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('注册时的邮箱不存在！','alert_back','','error','');</script>";
		exit;

	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>网站登录 - 码代码-李雷博客</title>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />

<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" /> 
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script language="javascript" src="/js/usb_key.js"></script>
<script language="javascript" src="/js/js_md5.js"></script>
<link href="/style.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
body {
	font-family:"Microsoft Yahei","微软雅黑",Tahoma,Arial,Helvetica,STHeiti;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background: #E1E2E4;
	min-height:6000px;
	overflow-y:hidden;
}
input{font-family:"Microsoft Yahei","微软雅黑",Tahoma,Arial,Helvetica,STHeiti;}
.login-wrap {
	position:absolute;
	top:190px;
	right:140px;
	z-index:999;
	
}
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #666666;
}
a:hover {
	text-decoration: none;
	color: #666666;
}
a:active {
	text-decoration: none;
	color: #666666;
}
.but1{float:left; height:50px; width:190px; font-size:14px; line-height:50px; text-align:center;}
.but2{float:left; height:50px; width:189px; background:#EEE; border:1px solid #CCCCCC; border-top:0; border-right:0;-moz-border-radius:0 5px 0 0;-webkit-border-radius:0 5px 0 0;border-radius:0 5px 0 0;line-height:50px; text-align:center;}

.but1_1{float:left; height:50px; width:189px; background:#EEE; border:1px solid #CCCCCC;border-left:0;border-top:0;-moz-border-radius:5px 0 0 0;-webkit-border-radius:5px 0 0 0;border-radius:5px 0 0 0; font-size:14px; line-height:50px; text-align:center;}
.but2_1{float:left; height:50px; width:190px;  line-height:50px; text-align:center;}

.login_u{clear:both; text-align:center; margin:0 auto;border:1px solid #CCCCCC;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px; width:300px; text-align:left; padding-left:10px;}
.login_u_error{border:1px solid #009999;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1;}

.login_p{clear:both; text-align:center; margin:0 auto;border:1px solid #CCCCCC;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px; width:300px; text-align:left; padding-left:10px;}
.login_p_error{border:1px solid #009999;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1;}

.login_u i,.login_p i,.reg_u i,.reg_p1 i,.reg_p2 i,.lose_u i{ margin-top:;*margin-top:-7px;_margin-top:-7px;}

.reg_u{clear:both; text-align:center; margin:0 auto;border:1px solid #CCCCCC;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px; width:300px; text-align:left; padding-left:10px;}
.reg_u_error{border:1px solid #009999;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1;}
	
.reg_p1{clear:both; text-align:center; margin:0 auto;border:1px solid #CCCCCC;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px; width:300px; text-align:left; padding-left:10px;}
.reg_p1_error{border:1px solid #009999;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1;}
	
.reg_p2{clear:both; text-align:center; margin:0 auto;border:1px solid #CCCCCC;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px; width:300px; text-align:left; padding-left:10px;}
.reg_p2_error{border:1px solid #009999;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1;}
	
.lose_u{clear:both; text-align:center; margin:0 auto;border:1px solid #CCCCCC;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px; width:300px; text-align:left; padding-left:10px;}
.lose_u_error{border:1px solid #009999;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1;}
-->
</style>
<link href="/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	window.onresize = window.onload = function(){
		var w,h
		if(!!(window.attachEvent && !window.opera))
		{
			h = document.documentElement.clientHeight;
			w = document.documentElement.clientWidth;
		}else{
			h =	window.innerHeight;
			w = window.innerWidth;
		}
		//document.getElementById('msg').value  ='窗口大小：' + 'width:' + w + '; height:'+h;
		var bgImg = document.getElementById('bg').getElementsByTagName('img')[0];
		bgImg.width = (w);
		bgImg.height= (w * 0.25) ;		
		
		var bgImg1 = document.getElementById('bg1').getElementsByTagName('img')[0];
		bgImg1.width = (w);
		bgImg1.height= (w * 0.25) ;
		
		if (h<=768){
			document.getElementById('login-wrap').style.top='120px';
		}else{
			document.getElementById('login-wrap').style.top='190px';
		}
								
	}		
	
	function changeform(formid){
		$("#form_c1").hide(); 
		$("#form_c2").hide(); 
		$("#form_c3").hide();
		if (formid=='1'){
			$('#but_f1').attr('class','but1');//还原按钮的默认样式
			$('#but_f2').attr('class','but2');//还原按钮的默认样式
		}else if (formid=='2'){
			$('#but_f1').attr('class','but1_1');//还原按钮的默认样式
			$('#but_f2').attr('class','but2_1');//还原按钮的默认样式
		}
		
		$("#form_c"+formid).fadeIn(); 
	}	
</script>

</head>

<body >
<?
if ($var_loading_index=='1'){//开启前台loading效果
?>
<link href="/css/nprogress.css" rel='stylesheet' />
<script src='/js/nprogress.js'></script>
<script src='/js/jquery.enplaceholder.js'></script>
<script>NProgress.set(0.4);NProgress.inc();NProgress.start();$(window).load(function() {NProgress.done();});</script>
<? }?>

<div id="bg" ><img src="/images/bg_shad_top_1.jpg" /></div>
<div id="bg1"><img src="/images/bg_shad_bottom_1.jpg" /></div>

<div class="login-wrap" id="login-wrap">
			<div style=" position:relative;width:380px; height:390px; background:#FFFFFF; float:right;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;box-shadow: 0 0 25px #ccc;opacity: 1;-o-box-shadow: 0 0 25px #ccc;-ms-box-shadow: 0 0 25px #ccc">
			
				<div id="but_f1" class="but1"><a href="javascript:;"  style="font-size:14px" onclick="changeform(1)">用户登录</a></div>
				<div id="but_f2" class="but2"><a href="javascript:;" style="font-size:14px" onclick="changeform(2)">用户注册</a></div>
				
				
				
				<div id="form_c1" style="clear:both;">
				<div style="clear:both; height:30px ;*height:10px ;_height:10px ; font-size:1px"></div>
				<form action="?<?=encrypt_url("action=go&url=".base64_encode($comeurl)."&time=".time(),$key_url_md_5)?>" method="post" name="form_login" id="form_login" onsubmit="return checkform_login()">
					<div id="login_u" class="login_u">
					
					<i class="icon-user"></i> <input id="username" name="username" type="text" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px; border:0;" value="<?=$_COOKIE["7d_cokie_u"]?>" placeholder="用户名/邮箱" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div id="login_p" class="login_p">
					
					<i class="icon-lock"></i> <input id="password" name="password" type="password" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" maxlength="11" placeholder="请输入密码" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block;">
					<input name="lg_go" type="submit" value="登录" style="border:0; background: #1E7EEA;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; height:45px; text-align:center; line-height:45px; color:#FFFFFF; width:310px; font-size:16px;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1; cursor:pointer;" />
					</div>
					
					
					<div style="height:15px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block; text-align:left;width:310px;margin:0 auto;">
						<a href="/" style="font-size:12px; color:#0099FF">网站首页</a><span style="margin:0 10px; color:#CCCCCC">|</span><a href="javascript:void(0);" onclick="changeform(3)" style="font-size:12px;color:#0099FF">找回密码</a>					</div>
					
					<div style="height:13px; border-bottom:1px solid #CCCCCC; width:310px;margin:0 auto; margin-bottom:10px; "></div>
					
					<div style="font-weight:bold;width:310px;margin:0 auto; font-size:12px; line-height:28px;">温馨提示：</div>
					<div style="width:310px;margin:0 auto; font-size:12px; line-height:23px; color: #666666">1.请使用邮箱作为用户名登录。</div>
					<div style="width:310px;margin:0 auto; font-size:12px;line-height:23px;color:#666666">2.登录后可赚取积分，享受折扣优惠。</div>
				</form>
				</div>
				
				
				
				<div id="form_c2" style="display:none; clear:both;">
				<div style="clear:both; height:30px ;*height:10px ;_height:10px ; font-size:1px"></div>
				<form action="?<?=encrypt_url("action=reg&time=".time(),$key_url_md_5)?>" method="post" name="form_register" id="form_register" onsubmit="return checkform_reg()">
					<div id="reg_u" class="reg_u">
					
					<i class="icon-user"></i> <input id="zcusername" name="zcusername" type="text" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" placeholder="以邮箱为用户名" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div id="reg_p1" class="reg_p1" >
					
					<i class="icon-lock"></i> <input id="password1" name="password1" type="password" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" maxlength="11" placeholder="请输入密码" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div id="reg_p2" class="reg_p2" >
					
					<i class="icon-lock"></i> <input id="password2" name="password2" type="password" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" maxlength="11" placeholder="请再次确认密码" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block;">
					<input name="lg_go" type="submit" value="快速注册" style="border:0; background: #FF6600;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; height:45px; text-align:center; line-height:45px; color:#FFFFFF; width:310px; font-size:16px;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1; cursor:pointer;" />
					</div>
					
					
					<div style="height:15px; clear:both"></div>
					
					<div style="height:13px; border-bottom:1px solid #CCCCCC; width:310px;margin:0 auto; margin-bottom:20px; "></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block; text-align:left;width:310px;margin:0 auto;">
						<a href="/" style="font-size:12px; color:#0099FF">网站首页</a><span style="margin:0 10px; color:#CCCCCC">|</span><a href="javascript:void(0);" onclick="changeform(3)" style="font-size:12px;color:#0099FF">找回密码</a>
					</div>

				</form>
				</div>
				
				
				
				<div id="form_c3" style="display:none; clear:both;">
				<div style="clear:both; height:30px ;*height:10px ;_height:10px ; font-size:1px"></div>
				<form action="?<?=encrypt_url("action=lose&time=".time(),$key_url_md_5)?>" method="post" name="form_lose" id="form_lose" onsubmit="return checkform_lose()">
					<div id="lose_u" class="lose_u">
					
					<i class="icon-user"></i> <input id="loseusername" name="loseusername" type="text" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" placeholder="请输入您注册时的邮箱" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block;">
					<input name="lg_go" type="submit" value="快速找回密码" style="border:0; background: #FF6600;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; height:45px; text-align:center; line-height:45px; color:#FFFFFF; width:310px; font-size:16px;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1; cursor:pointer;" />
					</div>
					
					
					<div style="height:15px; clear:both"></div>
					
					<div style="height:13px; border-bottom:1px solid #CCCCCC; width:310px;margin:0 auto; margin-bottom:20px; "></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block; text-align:left;width:310px;margin:0 auto; line-height:25px; color:#999999">
						说明：请输入您的邮箱作为找回密码的依据，系统会向您填写的邮箱中发一封激活新密码的邮件，请注意查看！
					</div>

				</form>
				</div>
				
				
				
			</div>
</div>

<div style="position:absolute; width:100%; line-height:30px; text-align:center; bottom:30px;">Copyright &copy; 2014-<?=date("Y")?> <?=$var_domain?> All Rights Reserved. &nbsp;&nbsp;&nbsp;<a href="http://<?=$var_domain?>" style="color:#111111" target="_blank">码代码-PHP技术经验教程分享-李雷博客</a></div>

<!--判断IE浏览器版本 -->
<script src="/js/ie.js"></script>
<!--判断IE浏览器版本 END-->
<script>
/*非IE或IE11以上，否则提示升级浏览器 ies=0非IE，!=0为IE*/

if (ies==0 || ies>=11){
	$('#username,#zcusername,#loseusername,#password,#password1,#password2').placeholder();
}else{
	$("#username").attr("title","用户名/邮箱");
	$("#zcusername").attr("title","以邮箱为用户名");
	$("#loseusername").attr("title","请输入您注册时的邮箱");
	$("#password").attr("title","请输入密码");
	$("#password1").attr("title","请输入密码");
	$("#password2").attr("title","请再次确认密码");
}
</script>

<? 
if ($_REQUEST["e"]=="register" ){
	$pd='2';//默认注册
}else{
	$pd='1';//登录
}?>
<input name="hidereg" id="hidereg" type="hidden" value="<?=$pd?>" />

<? 
if ($_REQUEST["e"]=="register" ){?>
	<script>changeform($("#hidereg").val())</script>
<? }?>

<script src="/js/bootstrap.min.js"></script>
<? include_once("./js/js_alert.php"); //调用MODULE弹出框?>

</body>
</html>
