<?
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php"); 

if ($_SESSION['user_lei_username']!=''){//��¼�û��ż�¼����
	$webid=quotes_gpc_pd($_POST['webid'],1);
	$url=quotes_gpc_pd($_POST['url'],1);
	jilu_in($_SESSION['user_lei_username'],$var_jifen_bdshare,'sharejiangli',$webid."#".$url);//����
	
}

?>