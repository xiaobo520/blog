<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");

if ($var_huitie_open=='close'){//回贴总开关

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 回复功能暂时关闭！</span>";
	exit;
	
}

//$content = ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',quotes_gpc_pd($_POST['content'],0));
//$content = iconv("utf-8","gbk",$_POST['content']);
$content = quotes_gpc_pd($_POST['content'],0);
$cid=$_POST['cid'];
$nicheng=quotes_gpc_pd($_POST['nicheng'],1);
$email=quotes_gpc_pd($_POST['email'],1);
$atab=$_POST['atab'];
$xuan_img=$_POST['xuan_img'];
$code=strtoupper($_POST['code']);
$gid=$_POST['gid'];
$guser=$_POST['guser'];
$gemail=$_POST['gemail'];
$gmail_check=$_POST['gmail_check'];
$indate=date("Y-m-d H:i:s");

if ($_SESSION['hfindate_ll']!="" ){//有过回复要检查是否频繁发言
	$date1 = strtotime($_SESSION['hfindate_ll']); //把日期转换成时间戳
	$date2 = time(); //取当前时间的时间戳
	$days=($date2-$date1);
	
	if ($days<$var_huitie_time){  //限制180秒回复
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> 请不要频繁发贴！</span>";
		exit;
	}
}

if ($code!=$_SESSION["login_check_code"]){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 验证码不正确</span>";
	exit;

}

if (check_null($nicheng)=='0'){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 您的昵称还没有写</span>";
	exit;

}

if (check_str_teshu($nicheng)=='result_false'){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 昵称不能含有特殊字符</span>";
	exit;

}

if (check_null($email)=='0'){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 您的邮箱还没有写</span>";
	exit;

}

if (check_tel_mail($email,2)=='result_false' ){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 您的邮箱格式不正确</span>";
	exit;

}

if (check_null($content)!='0' && $cid!="" ){

	if ( bad_words_jc($content," ",$bad_words)=='badfalse' ){//strpos 判断为 !==false  或 ===false
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> 内容含有禁用词汇！</span>";
		exit;
	}
	
	$content=preg_replace("(<a [^>]*>|</a>)","",$content);

	if ($atab=='1'){ //更新主题表及回复表判定
		$answtalbe="lei_jingyan";
		$answtalbe_an="lei_jingyan_hf";
	}elseif ($atab=='2'){
		$answtalbe="lei_news";
		$answtalbe_an="lei_news_hf";
	}elseif ($atab=='3'){
		$answtalbe="lei_message";
		$answtalbe_an="lei_message_hf";
	}
	
	//*****************************************************************
	
	if ($answtalbe_an!=''){ //二次检测 回复表名
	
		if ($_SESSION['user_lei_username']!=''){
			$cz_user=$_SESSION['user_lei_username'];
			jilu_in($cz_user,$var_jifen_huifu,'huitie','');//积分
		}else{//非注册会员，记录昵称和头像ID值，图1-26
			$cz_user="mdaima#".$email;//加前缀，防止被其它用户填写一样的用户名邮箱造成数据错乱，登录时限制如果mdaima#开头的不予登录
			$cz_user_cookie=$email;
			setcookie("yk_mdaima_nicheng",iconv("utf-8","gbk",$nicheng), time()+9999999);//前端是GBK编码，写入数据库的也是GBK，email发送是UTF8和默认接收的变量都是utf8
			setcookie("yk_mdaima_email",iconv("utf-8","gbk",$cz_user_cookie), time()+9999999);
		}
		
		$sayip = $_SERVER['REMOTE_ADDR']; //获得用户ip 
		
		if($gid==''){//普通一级回复
			$sql="insert into ".$answtalbe_an." (cid,content,username,indate,nicheng,xuan_img,pass,ip) values ('".$cid."','".iconv("utf-8","gbk",$content)."','".$cz_user."','".$indate."','".iconv("utf-8","gbk",$nicheng)."','".$xuan_img."','".$var_pinglun_shenhe."','".$sayip."') ";//写入回复信息
			$mysqli->query($sql);
			
		}else{//二级回复
			$sql="insert into ".$answtalbe_an." (cid,cid_hf,cid_str,content,username,indate,nicheng,xuan_img,pass,ip) values ('".$cid."','".$gid."','".iconv("utf-8","gbk",$guser)."','".iconv("utf-8","gbk",$content)."','".$cz_user."','".$indate."','".iconv("utf-8","gbk",$nicheng)."','".$xuan_img."','".$var_pinglun_shenhe."','".$sayip."') ";//写入回复信息
			$mysqli->query($sql);
		}
		
		$sql="update lei_cs set zt_tixing_huitie=zt_tixing_huitie+1 where id='1' limit 1 ";//后台提醒更新状态，回帖
		$mysqli->query($sql);
		
		if ($atab!='3'){//单页面内容不接收状态值
			$sql="update ".$answtalbe." set huifuzt='1' where id='".$cid."' limit 1 ";//更新主题文章回复提示信息
			$mysqli->query($sql);
		}
		
		//写入活跃信息
		$sql="select id from lei_huoyue where username='".$cz_user."' limit 1 ";
		$result=$mysqli->query($sql);
		if($rs=$result->fetch_assoc()){
			$sql="update lei_huoyue set indate='".$indate."',nicheng='".iconv("utf-8","gbk",$nicheng)."',xuan_img='".$xuan_img."' where username='".$cz_user."' ";
			$mysqli->query($sql);
		}else{
			$sql="insert into lei_huoyue (indate,nicheng,xuan_img,username) values ('".$indate."','".iconv("utf-8","gbk",$nicheng)."','".$xuan_img."','".$cz_user."') ";
			$mysqli->query($sql);
		}
		
		//删除多余的活跃信息
		$sql_search="select id from lei_huoyue order by indate desc limit 15 ";//读取最新15条保留
		$noid_huoyue="";
		$result=$mysqli->query($sql_search);
		while ($rs=$result->fetch_assoc()){
			$noid_huoyue=$noid_huoyue."'".$rs["id"]."',";
		}
		$noid_huoyue=substr($noid_huoyue,0,-1);
		$sql="delete from lei_huoyue where id not in (".$noid_huoyue.") ";//删除最新以外的
		$mysqli->query($sql);
		
		//*****************************************************************

		$_SESSION['hfindate_ll']=$indate;
		echo "<span style='color:green'><i class='icon-ok-sign' ></i> 回复提交成功！</span>";
		exit;

	}
	
	

}else{
	echo "<span style='color:red'><i class='icon-remove-sign' ></i> 回复内容不能为空！</span>";

}
?>