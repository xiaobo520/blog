<?
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
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

	$password=quotes_gpc_pd($_POST['password'],1);  //ת��
	$username=quotes_gpc_pd($_POST['username'],1);
	
	
	if (check_null($password)=='0' || check_null($username)=='0' ){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�û��������������д��','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_str_teshu($username)=='result_false' || check_str_teshu($password)=='result_false' || substr($username,0,7)=='mdaima#'){//mdaima_Ϊ�οͷ����������ǰ׺

		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�����ַ����ʧ�ܣ�','alert_back','','error','');</script>";
		exit;
	
	}

	$sql="select username,password,pass from lei_user where username='".$username."' limit 1 " ;
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		if($rs["pass"]!='1'){
			$result->free();
			$mysqli->close();
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('����������(���)״̬���޷���¼��','alert_back','','error','');</script>";
			exit;

		}

		//substr(md5("1"),8,16); // 16λMD5����
		
		//�ύǰ�Ѿ�JS��MD5�ӹ����ˣ����޸�������ȣ�����һ��
		if(md5($password.md5('@lei_user7d'))==$rs["password"] ){ //  *******************��Ϊ����  || substr(md5($password),8,16)==$rs->password

			$_SESSION['user_lei_username']=$rs["username"];
			setcookie("7d_cokie_u",$rs["username"],time()+9999999); // $_COOKIE["7d_cokie_u"]
			//setcookie("7d_cokie_p",$password,time()+9999999); // $_COOKIE["7d_cokie_u"]
			
			
			jilu_in($username,$var_jifen_denglu,'denglujiangli','');//����

			$result->free();
			$mysqli->close();
			
			echo "<script>location.href='".$comeurl."';</script>";
			exit;
		} 
		else{

			$result->free();
			$mysqli->close();
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('�û��������벻��ȷ��','alert_back','','error','');</script>";
			exit;
		}

	}else{
		$result->free();
		$mysqli->close();
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�û��������벻��ȷ��','alert_back','','error','');</script>";
		exit;

	}

}


if ($action=="reg"){

	$password1=quotes_gpc_pd($_POST['password1'],1);  //ת��
	$password2=quotes_gpc_pd($_POST['password2'],1);  //ת��
	$username=quotes_gpc_pd(str_replace(' ','',$_POST['zcusername']),1);
	
	if (check_null($password1)=='0' || check_null($username)=='0' ){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�û��������������д��','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_tel_mail($username,2)=='result_false' ){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�����û��������䣩��ʽ����ȷ��','alert_back','','error','');</script>";
		exit;
	
	}
	
	if ($password1!=$password2){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�����������벻һ�£�','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_str_teshu($username)=='result_false' || check_str_teshu($password)=='result_false' || substr($username,0,7)=='mdaima#'){//mdaima_Ϊ�οͷ����������ǰ׺

		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�����ַ����ʧ�ܣ�','alert_back','','error','');</script>";
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
		shuffle($touxiang_rand);//��������
		$xuan_img="/images/touxiang/".$touxiang_rand[0].".jpg";

		$sql="insert into lei_user (username,userimg,password,nicheng,nicheng_py,pass,jifen,jifen_all,indate,lasttime) values ('".$username."','".$xuan_img."','".md5(md5($password1).md5('@lei_user7d'))."','���������','mdmwy','".$var_register_pass."','0','0','".$indate."','".$indate."') ";
		$mysqli->query($sql);
		
		$sql="update lei_cs set zt_tixing_reg=zt_tixing_reg+1 where id='1' limit 1 ";//��̨���Ѹ���״̬��ע��
		$mysqli->query($sql);
		
		//substr(md5("1"),8,16); // 16λMD5����*******************��Ϊ����  || substr(md5($password),8,16)==$rs->password

		if($var_register_pass=='1'){ //  Ĭ��ע��Ϳ�ͨ�ſ��Ե�¼

			$_SESSION['user_lei_username']=$username;
			setcookie("7d_cokie_u",$username,time()+9999999); // $_COOKIE["7d_cokie_u"]
			//setcookie("7d_cokie_p",$password,time()+9999999); // $_COOKIE["7d_cokie_u"]
			
			jilu_in($username,$var_jifen_reg,'qita','ע�ά��');//����
			jilu_in($username,$var_jifen_denglu,'denglujiangli','');//����

			$result->free();
			$mysqli->close();
			
			echo "<script>location.href='home.html';</script>";
			exit;
		}else{
			$result->free();
			$mysqli->close();
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('ע��ɹ�����ȴ�������ˣ����ͨ�����ʼ�֪ͨ����','alert_go','','ok','http://".$var_domain."');</script>";
			exit;
	
		}

	}else{
		$result->free();
		$mysqli->close();
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�û��������䣩�Ѿ���ע���ˣ�������ѡ��','alert_back','','error','');</script>";
		exit;

	}

}


if ($action=="lose"){
	
	$username=quotes_gpc_pd($_POST['loseusername'],1);
	
	
	
	if (check_null($username)=='0' ){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('ע��ʱ�����������д��','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_tel_mail($username,2)=='result_false' ){
		
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('���������ʽ����ȷ��','alert_back','','error','');</script>";
		exit;
	
	}
	
	if (check_str_teshu($username)=='result_false' || substr($username,0,7)=='mdaima#'){//mdaima_Ϊ�οͷ����������ǰ׺

		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�����ַ����ʧ�ܣ�','alert_back','','error','');</script>";
		exit;
	
	}

	$sql="select username,pass from lei_user where username='".$username."' limit 1 " ;
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){

		if($rs["pass"]!='1'){
			$result->free();
			$mysqli->close();
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('����������(���)״̬���޷��һ����룬����ϵQQ:858353007��','alert_back','','error','');</script>";
			exit;

		}
		
		//Ĭ�ϲ���ֱ�Ӹ������룬��Ҫ�û���������ʼ����ӣ��Ÿ������룬��ֹ���ⱻ�û����ã��������Լ�����ʱ����ԭ�����¼Ӱ��

		//���ʼ�
		$smtpemailto 	= 	$username;//���͸�˭����������԰�Ƕ��ŷָ���Ĭ��Ҫ�����Լ�
		$mailsubject 	= 	iconv('gbk','utf-8','�����������-���ײ��͵�����������������30�����ڲ�����');//�ʼ�����
		$mailtime		=	date("Y-m-d H:i:s");
		$utfmailbody	=	"����30������ͨ���������ӻ�ȡ�µ�������룬ʹ����������¼���޸�Ϊ�����õ����롣������30���������Զ�ʧЧ����<br><a href='http://".$var_domain."/back_safe.html?".encrypt_url('p=safe&u='.$username.'&time='.time(),$key_url_md_5)."' target='_blank'>http://".$var_domain."/back_safe.html?".encrypt_url('p=safe&u='.$username.'&time='.time(),$key_url_md_5)."</a><br><span style='color:#FF0000'>��Ǳ��˲��������������ӣ����Լ��ɣ������ʼ�Ϊϵͳ�Զ����ͣ�����ظ���</span>";
		$utfmailbody 	= 	iconv('gbk','utf-8',$utfmailbody);
		$mailtype 		= 	"HTML";//�ʼ���ʽ��HTML/TXT��,TXTΪ�ı��ʼ�
		
		include_once("./mdaima_var_inc/sendmail.php");//�����ʼ���
		
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//�������һ��true�Ǳ�ʾʹ�������֤,����ʹ�������֤.
		$smtp->debug = FALSE;//�Ƿ���ʾ���͵ĵ�����Ϣ FALSE or TRUE
		if($smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $utfmailbody, $mailtype)){
			//echo '���ͳɹ�';
		}
		
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�����һسɹ����ѷ����ʼ�����ע��ʱ�����䣬�����¼���޸����룡','alert_go','','ok','http://".$var_domain."');</script>";
		exit;

	}else{
		$result->free();
		$mysqli->close();
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('ע��ʱ�����䲻���ڣ�','alert_back','','error','');</script>";
		exit;

	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��վ��¼ - �����-���ײ���</title>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />

<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" /> 
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script language="javascript" src="/js/usb_key.js"></script>
<script language="javascript" src="/js/js_md5.js"></script>
<link href="/style.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
body {
	font-family:"Microsoft Yahei","΢���ź�",Tahoma,Arial,Helvetica,STHeiti;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background: #E1E2E4;
	min-height:6000px;
	overflow-y:hidden;
}
input{font-family:"Microsoft Yahei","΢���ź�",Tahoma,Arial,Helvetica,STHeiti;}
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
		//document.getElementById('msg').value  ='���ڴ�С��' + 'width:' + w + '; height:'+h;
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
			$('#but_f1').attr('class','but1');//��ԭ��ť��Ĭ����ʽ
			$('#but_f2').attr('class','but2');//��ԭ��ť��Ĭ����ʽ
		}else if (formid=='2'){
			$('#but_f1').attr('class','but1_1');//��ԭ��ť��Ĭ����ʽ
			$('#but_f2').attr('class','but2_1');//��ԭ��ť��Ĭ����ʽ
		}
		
		$("#form_c"+formid).fadeIn(); 
	}	
</script>

</head>

<body >
<?
if ($var_loading_index=='1'){//����ǰ̨loadingЧ��
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
			
				<div id="but_f1" class="but1"><a href="javascript:;"  style="font-size:14px" onclick="changeform(1)">�û���¼</a></div>
				<div id="but_f2" class="but2"><a href="javascript:;" style="font-size:14px" onclick="changeform(2)">�û�ע��</a></div>
				
				
				
				<div id="form_c1" style="clear:both;">
				<div style="clear:both; height:30px ;*height:10px ;_height:10px ; font-size:1px"></div>
				<form action="?<?=encrypt_url("action=go&url=".base64_encode($comeurl)."&time=".time(),$key_url_md_5)?>" method="post" name="form_login" id="form_login" onsubmit="return checkform_login()">
					<div id="login_u" class="login_u">
					
					<i class="icon-user"></i> <input id="username" name="username" type="text" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px; border:0;" value="<?=$_COOKIE["7d_cokie_u"]?>" placeholder="�û���/����" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div id="login_p" class="login_p">
					
					<i class="icon-lock"></i> <input id="password" name="password" type="password" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" maxlength="11" placeholder="����������" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block;">
					<input name="lg_go" type="submit" value="��¼" style="border:0; background: #1E7EEA;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; height:45px; text-align:center; line-height:45px; color:#FFFFFF; width:310px; font-size:16px;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1; cursor:pointer;" />
					</div>
					
					
					<div style="height:15px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block; text-align:left;width:310px;margin:0 auto;">
						<a href="/" style="font-size:12px; color:#0099FF">��վ��ҳ</a><span style="margin:0 10px; color:#CCCCCC">|</span><a href="javascript:void(0);" onclick="changeform(3)" style="font-size:12px;color:#0099FF">�һ�����</a>					</div>
					
					<div style="height:13px; border-bottom:1px solid #CCCCCC; width:310px;margin:0 auto; margin-bottom:10px; "></div>
					
					<div style="font-weight:bold;width:310px;margin:0 auto; font-size:12px; line-height:28px;">��ܰ��ʾ��</div>
					<div style="width:310px;margin:0 auto; font-size:12px; line-height:23px; color: #666666">1.��ʹ��������Ϊ�û�����¼��</div>
					<div style="width:310px;margin:0 auto; font-size:12px;line-height:23px;color:#666666">2.��¼���׬ȡ���֣������ۿ��Żݡ�</div>
				</form>
				</div>
				
				
				
				<div id="form_c2" style="display:none; clear:both;">
				<div style="clear:both; height:30px ;*height:10px ;_height:10px ; font-size:1px"></div>
				<form action="?<?=encrypt_url("action=reg&time=".time(),$key_url_md_5)?>" method="post" name="form_register" id="form_register" onsubmit="return checkform_reg()">
					<div id="reg_u" class="reg_u">
					
					<i class="icon-user"></i> <input id="zcusername" name="zcusername" type="text" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" placeholder="������Ϊ�û���" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div id="reg_p1" class="reg_p1" >
					
					<i class="icon-lock"></i> <input id="password1" name="password1" type="password" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" maxlength="11" placeholder="����������" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div id="reg_p2" class="reg_p2" >
					
					<i class="icon-lock"></i> <input id="password2" name="password2" type="password" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" maxlength="11" placeholder="���ٴ�ȷ������" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block;">
					<input name="lg_go" type="submit" value="����ע��" style="border:0; background: #FF6600;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; height:45px; text-align:center; line-height:45px; color:#FFFFFF; width:310px; font-size:16px;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1; cursor:pointer;" />
					</div>
					
					
					<div style="height:15px; clear:both"></div>
					
					<div style="height:13px; border-bottom:1px solid #CCCCCC; width:310px;margin:0 auto; margin-bottom:20px; "></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block; text-align:left;width:310px;margin:0 auto;">
						<a href="/" style="font-size:12px; color:#0099FF">��վ��ҳ</a><span style="margin:0 10px; color:#CCCCCC">|</span><a href="javascript:void(0);" onclick="changeform(3)" style="font-size:12px;color:#0099FF">�һ�����</a>
					</div>

				</form>
				</div>
				
				
				
				<div id="form_c3" style="display:none; clear:both;">
				<div style="clear:both; height:30px ;*height:10px ;_height:10px ; font-size:1px"></div>
				<form action="?<?=encrypt_url("action=lose&time=".time(),$key_url_md_5)?>" method="post" name="form_lose" id="form_lose" onsubmit="return checkform_lose()">
					<div id="lose_u" class="lose_u">
					
					<i class="icon-user"></i> <input id="loseusername" name="loseusername" type="text" style="height:38px; width:200px; line-height:32px;*line-height:38px;_line-height:38px;  padding:0 10px;border:0;" value="" placeholder="��������ע��ʱ������" />
					</div>
					
					<div style="height:20px; clear:both"></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block;">
					<input name="lg_go" type="submit" value="�����һ�����" style="border:0; background: #FF6600;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; height:45px; text-align:center; line-height:45px; color:#FFFFFF; width:310px; font-size:16px;box-shadow: 0px 0px 10px #CCCCCC;
	-moz-box-shadow: 0px 0px 10px #CCCCCC;
	-webkit-box-shadow: 0px 0px 10px #CCCCCC;
	-o-box-shadow: 0px 0px 10px #CCCCCC;
	-ms-box-shadow: 0px 0px 10px #CCCCCC;
	opacity: 1; cursor:pointer;" />
					</div>
					
					
					<div style="height:15px; clear:both"></div>
					
					<div style="height:13px; border-bottom:1px solid #CCCCCC; width:310px;margin:0 auto; margin-bottom:20px; "></div>
					
					<div style="clear:both; text-align:center; margin:0 auto; display:block; text-align:left;width:310px;margin:0 auto; line-height:25px; color:#999999">
						˵��������������������Ϊ�һ���������ݣ�ϵͳ��������д�������з�һ�⼤����������ʼ�����ע��鿴��
					</div>

				</form>
				</div>
				
				
				
			</div>
</div>

<div style="position:absolute; width:100%; line-height:30px; text-align:center; bottom:30px;">Copyright &copy; 2014-<?=date("Y")?> <?=$var_domain?> All Rights Reserved. &nbsp;&nbsp;&nbsp;<a href="http://<?=$var_domain?>" style="color:#111111" target="_blank">�����-PHP��������̷̳���-���ײ���</a></div>

<!--�ж�IE������汾 -->
<script src="/js/ie.js"></script>
<!--�ж�IE������汾 END-->
<script>
/*��IE��IE11���ϣ�������ʾ��������� ies=0��IE��!=0ΪIE*/

if (ies==0 || ies>=11){
	$('#username,#zcusername,#loseusername,#password,#password1,#password2').placeholder();
}else{
	$("#username").attr("title","�û���/����");
	$("#zcusername").attr("title","������Ϊ�û���");
	$("#loseusername").attr("title","��������ע��ʱ������");
	$("#password").attr("title","����������");
	$("#password1").attr("title","����������");
	$("#password2").attr("title","���ٴ�ȷ������");
}
</script>

<? 
if ($_REQUEST["e"]=="register" ){
	$pd='2';//Ĭ��ע��
}else{
	$pd='1';//��¼
}?>
<input name="hidereg" id="hidereg" type="hidden" value="<?=$pd?>" />

<? 
if ($_REQUEST["e"]=="register" ){?>
	<script>changeform($("#hidereg").val())</script>
<? }?>

<script src="/js/bootstrap.min.js"></script>
<? include_once("./js/js_alert.php"); //����MODULE������?>

</body>
</html>
