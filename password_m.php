<?
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php");
include_once("./mdaima_var_inc/checkall_home.php");
include_once("./dh_config.php");


$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$action=$url_info['action'];

if ($action=="edit"){

	$password=quotes_gpc_pd($_POST['passwordold'],1);
	$pass1=quotes_gpc_pd($_POST['pass1'],1);
	$pass2=quotes_gpc_pd($_POST['pass2'],1);
	
	if ($password=="" || $pass1=="" || $pass2=="" ){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�¾��������ȫ����д��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($pass1!==$pass2 ){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�������������벻һ�£�','alert_back','','error','');</script>";
		exit;
	}
	
	if (strlen($pass1)<6){
		alert_ini_index();//���alert�����ļ�
		echo "<script>alert_go('�����볤�Ȳ���С��6λ��','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select username,password,pass from lei_user where username='".$_SESSION['user_lei_username']."' limit 1";
	$result=$mysqli->query($sql);
		
	if($rs=$result->fetch_assoc()){
	
		if( md5(md5($password).md5('@lei_user7d'))==$rs["password"]){ //
		
			$sql="update lei_user set password='".md5(md5($pass1).md5('@lei_user7d'))."' where username='".$_SESSION['user_lei_username']."' limit 1 ";
			$mysqli->query($sql);
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('�����޸ĳɹ���','alert_go','','ok','?');</script>";
			exit;
		}else{
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('ԭ���벻��ȷ��','alert_back','','error','');</script>";
			exit;
		}
	}else{
		$mysqli->close();
		echo "<script language=javascript>alert('��Ϣ����401����');javascript:history.back(-1);</script>";
		exit;
	}

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��Ա����-�����-���ײ���</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/lx.js"></script>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" /> 
</head>

<body>

<? include_once("./index_top.php"); ?>
	
	<!-- ��BOX��ʼ -->
	<div id="main_box">
	<div class="home_box">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #CCCCCC">
        <tr>
          <td width="22%" align="center" valign="top" bgcolor="#F5F3F1"><?php include_once("./home_left.php");?></td>
          <td width="78%" align="center" valign="top" bgcolor="#FFFFFF">
		  
		    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="44" align="right" valign="bottom">
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="30%" height="32" align="left" class="font15"><?=$daohang?></td>
                  <td width="70%" height="32" align="right"><a href="/" class="a1">��ҳ</a> &gt;&gt; ��Ա����&nbsp;&nbsp;</td>
                </tr>
              </table>
			  </td>
            </tr>
			<tr>
              <td height="12" background="/images/dw2.jpg"></td>
            </tr>
            <tr>
              <td valign="top"><form id="form1" name="form1" method="post" action="?<?=encrypt_url("action=edit&time=".time(),$key_url_md_5)?>">
                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#EAEAEA" style="margin-top:5px;">
                  <tr>
                    <td width="21%" height="45" bgcolor="#F9F9F9">&nbsp;</td>
                    <td width="79%" height="45" bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="21%" height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">�û�����</span></td>
                    <td width="79%" height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><?=$_SESSION['user_lei_username']?></td>
                  </tr>
                  <tr>
                    <td width="21%" height="45" align="right" bgcolor="#F9F9F9" ><span class="str_pad1">ԭ���룺</span></td>
                    <td width="79%" height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><input name="passwordold" type="password" class="form_home_text" id="passwordold" maxlength="18"/></td>
                  </tr>
                  <tr>
                    <td width="21%" height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">�����룺</span></td>
                    <td width="79%" height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><input name="pass1" type="password" class="form_home_text" id="pass1" maxlength="18"/></td>
                  </tr>
                  <tr>
                    <td width="21%" height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">ȷ�������룺</span></td>
                    <td width="79%" height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><input name="pass2" type="password" class="form_home_text" id="pass2" maxlength="18"/></td>
                  </tr>
                  <tr>
                    <td width="21%" height="67" bgcolor="#F9F9F9">&nbsp;</td>
                    <td width="79%" height="67" align="left" bgcolor="#FFFFFF" class="str_pad2">
					<button class="btn btn_big btn_submit" type="button" onClick="alert_go('ȷ���޸����룿','submit','form1','wen','')" >�޸�����</button>
					</td>
                  </tr>
                </table>
              </form>
			  
              </td>
            </tr>
          </table>
		  <p>&nbsp;</p></td>
        </tr>
      </table>
		</div>
		
		<div class="clear" style="height:15px;"></div>
	
	</div>
	<!-- ��BOX end -->


<!--��Ȩ -->
<div class="clear"></div>

<? include_once("./index_foot.php"); ?>
<!--��Ȩ -->



</body>
</html>
