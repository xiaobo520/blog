<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php");

if ($var_huitie_open=='close'){//�����ܿ���

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> �ظ�������ʱ�رգ�</span>";
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

if ($_SESSION['hfindate_ll']!="" ){//�й��ظ�Ҫ����Ƿ�Ƶ������
	$date1 = strtotime($_SESSION['hfindate_ll']); //������ת����ʱ���
	$date2 = time(); //ȡ��ǰʱ���ʱ���
	$days=($date2-$date1);
	
	if ($days<$var_huitie_time){  //����180��ظ�
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> �벻ҪƵ��������</span>";
		exit;
	}
}

if ($code!=$_SESSION["login_check_code"]){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> ��֤�벻��ȷ</span>";
	exit;

}

if (check_null($nicheng)=='0'){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> �����ǳƻ�û��д</span>";
	exit;

}

if (check_str_teshu($nicheng)=='result_false'){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> �ǳƲ��ܺ��������ַ�</span>";
	exit;

}

if (check_null($email)=='0'){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> �������仹û��д</span>";
	exit;

}

if (check_tel_mail($email,2)=='result_false' ){

	echo "<span style='color:red'><i class='icon-remove-sign' ></i> ���������ʽ����ȷ</span>";
	exit;

}

if (check_null($content)!='0' && $cid!="" ){

	if ( bad_words_jc($content," ",$bad_words)=='badfalse' ){//strpos �ж�Ϊ !==false  �� ===false
		echo "<span style='color:red'><i class='icon-remove-sign' ></i> ���ݺ��н��ôʻ㣡</span>";
		exit;
	}
	
	$content=preg_replace("(<a [^>]*>|</a>)","",$content);

	if ($atab=='1'){ //����������ظ����ж�
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
	
	if ($answtalbe_an!=''){ //���μ�� �ظ�����
	
		if ($_SESSION['user_lei_username']!=''){
			$cz_user=$_SESSION['user_lei_username'];
			jilu_in($cz_user,$var_jifen_huifu,'huitie','');//����
		}else{//��ע���Ա����¼�ǳƺ�ͷ��IDֵ��ͼ1-26
			$cz_user="mdaima#".$email;//��ǰ׺����ֹ�������û���дһ�����û�������������ݴ��ң���¼ʱ�������mdaima#��ͷ�Ĳ����¼
			$cz_user_cookie=$email;
			setcookie("yk_mdaima_nicheng",iconv("utf-8","gbk",$nicheng), time()+9999999);//ǰ����GBK���룬д�����ݿ��Ҳ��GBK��email������UTF8��Ĭ�Ͻ��յı�������utf8
			setcookie("yk_mdaima_email",iconv("utf-8","gbk",$cz_user_cookie), time()+9999999);
		}
		
		$sayip = $_SERVER['REMOTE_ADDR']; //����û�ip 
		
		if($gid==''){//��ͨһ���ظ�
			$sql="insert into ".$answtalbe_an." (cid,content,username,indate,nicheng,xuan_img,pass,ip) values ('".$cid."','".iconv("utf-8","gbk",$content)."','".$cz_user."','".$indate."','".iconv("utf-8","gbk",$nicheng)."','".$xuan_img."','".$var_pinglun_shenhe."','".$sayip."') ";//д��ظ���Ϣ
			$mysqli->query($sql);
			
		}else{//�����ظ�
			$sql="insert into ".$answtalbe_an." (cid,cid_hf,cid_str,content,username,indate,nicheng,xuan_img,pass,ip) values ('".$cid."','".$gid."','".iconv("utf-8","gbk",$guser)."','".iconv("utf-8","gbk",$content)."','".$cz_user."','".$indate."','".iconv("utf-8","gbk",$nicheng)."','".$xuan_img."','".$var_pinglun_shenhe."','".$sayip."') ";//д��ظ���Ϣ
			$mysqli->query($sql);
		}
		
		$sql="update lei_cs set zt_tixing_huitie=zt_tixing_huitie+1 where id='1' limit 1 ";//��̨���Ѹ���״̬������
		$mysqli->query($sql);
		
		if ($atab!='3'){//��ҳ�����ݲ�����״ֵ̬
			$sql="update ".$answtalbe." set huifuzt='1' where id='".$cid."' limit 1 ";//�����������»ظ���ʾ��Ϣ
			$mysqli->query($sql);
		}
		
		//д���Ծ��Ϣ
		$sql="select id from lei_huoyue where username='".$cz_user."' limit 1 ";
		$result=$mysqli->query($sql);
		if($rs=$result->fetch_assoc()){
			$sql="update lei_huoyue set indate='".$indate."',nicheng='".iconv("utf-8","gbk",$nicheng)."',xuan_img='".$xuan_img."' where username='".$cz_user."' ";
			$mysqli->query($sql);
		}else{
			$sql="insert into lei_huoyue (indate,nicheng,xuan_img,username) values ('".$indate."','".iconv("utf-8","gbk",$nicheng)."','".$xuan_img."','".$cz_user."') ";
			$mysqli->query($sql);
		}
		
		//ɾ������Ļ�Ծ��Ϣ
		$sql_search="select id from lei_huoyue order by indate desc limit 15 ";//��ȡ����15������
		$noid_huoyue="";
		$result=$mysqli->query($sql_search);
		while ($rs=$result->fetch_assoc()){
			$noid_huoyue=$noid_huoyue."'".$rs["id"]."',";
		}
		$noid_huoyue=substr($noid_huoyue,0,-1);
		$sql="delete from lei_huoyue where id not in (".$noid_huoyue.") ";//ɾ�����������
		$mysqli->query($sql);
		
		//*****************************************************************

		$_SESSION['hfindate_ll']=$indate;
		echo "<span style='color:green'><i class='icon-ok-sign' ></i> �ظ��ύ�ɹ���</span>";
		exit;

	}
	
	

}else{
	echo "<span style='color:red'><i class='icon-remove-sign' ></i> �ظ����ݲ���Ϊ�գ�</span>";

}
?>