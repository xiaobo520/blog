<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");

//$content = ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',quotes_gpc_pd($_POST['content'],0));
//$content = iconv("utf-8","gbk",$_POST['content']);
$content = $_POST['content'];
$cid=$_POST['cid'];
$nicheng=quotes_gpc_pd($_POST['nicheng'],1);
$email=$_POST['email'];
$atab=$_POST['atab'];
$gid=$_POST['gid'];
$guser=$_POST['guser'];
$gemail=str_replace('mdaima#','',passport_decrypt($_POST['gemail'],$key_str_md_5));//被回复人邮箱  answer.js有说明，不写入数据库，直接发邮件，一次过滤（就行，因为默认值是列表从库里取）的，会带标记
$gmail_check=$_POST['gmail_check'];
$indate=date("Y-m-d H:i:s");

if (check_null($email)=='0'){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 您的邮箱还没有写</span>";
	exit;

}

if (check_tel_mail($email,2)=='result_false' ){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 您的邮箱格式不正确</span>";
	exit;

}

if ($cid!="" ){


	if ($atab=='1'){ //更新主题表及回复表判定
		$answtalbe="lei_jingyan";
		$answtalbe_an="lei_jingyan_hf";
		$url="http://".$var_domain."/jingyan/".$cid.".html";
	}elseif ($atab=='2'){
		$answtalbe="lei_news";
		$answtalbe_an="lei_news_hf";
		$url="http://".$var_domain."/news/".$cid.".html";
	}elseif ($atab=='3'){
		$answtalbe="lei_message";
		$answtalbe_an="lei_message_hf";
		$url="http://".$var_domain."/lilei.html";
	}
	
	//*****************************************************************
	
	if ($answtalbe_an!=''){ //二次检测 回复表名
	
		if ($_SESSION['user_lei_username']!=''){
			$cz_user=$_SESSION['user_lei_username'];
		}else{//非注册会员，记录昵称和头像ID值，图1-26
			$cz_user=$email;//加前缀，防止被其它用户填写一样的用户名邮箱造成数据错乱，登录时限制如果mdaima#开头的不予登录
		}
		
		/*给主题人或被回复人发送，邮件发送放在最后，不会造成影响速度的情况*/
		if ($var_huitie_email=='open'){//评论以邮件形式提示开关，总开关
		
			$sql="select title from ".$answtalbe." where id='".$cid."' limit 1 ";//获取主题信息
			$result=$mysqli->query($sql);
			if($rs=$result->fetch_assoc()){

				$title="您在大胆哥博客的发言，有1条最新回复！";//通用，邮件主题，适应普通回复与博主留言
				
				$template = file_get_contents('./mdaima_var_inc/template.html');
				$template = str_replace('{title}',iconv("gbk","utf-8",$rs["title"]),$template);
				$template = str_replace('{hfuser}',str_replace(substr($cz_user,0,3),'***',$cz_user),$template);
				$template = str_replace('{hfnicheng}',$nicheng,$template);
				$template = str_replace('{hftime}',$indate,$template);
				$template = str_replace('{hfurl}',$url,$template);
				$template = str_replace('{message}',$content,$template);
				
				$mailbody=$template;

				if ($gmail_check=='1' && $gemail!=''){//评论以邮件形式,操作人选择是否给被回复的会员或游客发送邮件
					if (check_tel_mail($gemail,2)=='result_true' ){
						$g_send=','.$gemail;
					}else{
						$g_send='';
					}
				}else{
					$g_send='';
				}

				$smtpemailto 	= 	'mdaima@126.com'.$g_send;//发送给谁，多个邮箱以半角逗号分隔，默认要发给自己
				$mailsubject 	= 	$title;//邮件主题
				$mailtime		=	date("Y-m-d H:i:s");
				 
				$utfmailbody	=	$mailbody;//转换邮件编码 /邮件内容content与加的字符串编码不同，要统一
				$mailtype 		= 	"HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
				
				include_once("./mdaima_var_inc/sendmail.php");//发送邮件类
				
				$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
				$smtp->debug = FALSE;//是否显示发送的调试信息 FALSE or TRUE
				if($smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $utfmailbody, $mailtype)){
					//echo '发送成功';
				}

				//echo $gemail; //检查时状态值
					
			}
		}
	
	}

}
?>