<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
//--------------������������
include_once("host_post_all.php"); 
//--------------������������
$id=$url_info['id'];
$action=$url_info['action'];
$time=$url_info['time'];

//�޸��û�-��ʼ

if ($action=="edit"){

	$kt_lxr=quotes_gpc_pd($_POST['kt_lxr'],1);
	$kt_tel=quotes_gpc_pd($_POST['kt_tel'],1);
	$kt_qq=quotes_gpc_pd($_POST['kt_qq'],1);
	$kt_ftp_u=quotes_gpc_pd($_POST['kt_ftp_u'],1);
	$kt_ftp_p=quotes_gpc_pd($_POST['kt_ftp_p'],1);
	$kt_enddate=quotes_gpc_pd($_POST['kt_enddate'],1);
	$zt=quotes_gpc_pd($_POST['zt'],1);
	
	if ( $kt_tel!='' ){
		if (check_tel_mail($kt_tel,1)=='result_false'){
			alert_ini_index();//���alert�����ļ�
			echo "<script>alert_go('�ֻ�����Ǳ�׼��ʽ��','alert_back','','error','');</script>";
			exit;
		}
	}

	$sql="update lei_host set kt_lxr='".$kt_lxr."',kt_tel='".$kt_tel."',kt_qq='".$kt_qq."',kt_ftp_u='".$kt_ftp_u."',kt_ftp_p='".$kt_ftp_p."',kt_enddate='".$kt_enddate."',zt='".$zt."' where id='".$id."' limit 1";
	$mysqli->query($sql);
	
	$back_url=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('������Ϣ����ɹ���','alert_go','','ok','?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//����

$sql="select * from lei_host where id='".$id."' limit 1 ";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$dh=$rs["dh"];
	$username=$rs["username"];
	$jiage=$rs["jiage"];
	$host_nianxian=$rs["host_nianxian"];
	$host_jifen=$rs["host_jifen"];
	$xinghao=$rs["xinghao"];
	$indate=$rs["indate"];
	$zt=$rs["zt"];
	
	if ($zt=='1'){
		$zt_str='<span style="color:red">������</span>';
	}elseif ($zt=='2'){
		$zt_str='<span style="color:#FF9900">����ͨ</span>';
	}elseif ($zt=='3'){
		$zt_str='<span style="color:green">�ѿ�ͨ</span>';
	}elseif ($zt=='90'){
		$zt_str='<span style="color:blue;">��ȡ��</span>';
	}else{
		$zt_str='--';
	}
	
	$kt_lxr=$rs["kt_lxr"];
	$kt_tel=$rs["kt_tel"];
	$kt_qq=$rs["kt_qq"];
	$kt_ftp_u=$rs["kt_ftp_u"];
	$kt_ftp_p=$rs["kt_ftp_p"];
	$kt_enddate=$rs["kt_enddate"];
	
}else{
	echo "ϵͳ�����ʱ��";
	$mysqli->close();
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">
<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
<script language="JavaScript" type="text/javascript" src="js/pic.js"></script>
  
<style type="text/css">
#Layer1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:6;
}
.bar_load{position:relative;float:left; width:20px; height:20px; background:#FF9900; border:2px solid #E0E0E0;-moz-border-radius:12px;-webkit-border-radius:12px;border-radius:12px; text-align:center; line-height:20px; color:#FFFFFF; z-index:0;}/*Բ*/
.bar_load span{font-weight:bold;}/*Բ������ʽ*/
.bar_load div{position:absolute;top:30px; left:-40px;color:#666666; width:100px; text-align:center;}/*Բ�²�˵��������ʽ*/
.bar_load_ok{background: #00CC33;}/*Բ������ɫ-OK*/
.bar_load_ok div{ color: #00CC33}/*Բ������ɫ-OK*/

.bar_line{position:relative;float:left; width:150px; height:6px; background: #E0E0E0; margin-top:9px; margin-left:-2px;z-index:2;}/*��������ɫ*/
.bar_line div{float:left; width:100%; height:2px; background: #FF9933; margin-top:2px;z-index:1;}/*����ھ���ɫ*/
.bar_line_ok div{background: #00CC33;}/*����ھ���ɫ-OK*/

#qxdd {
	position:absolute;
	width:200px;
	height:115px;
	z-index:3;
	top:5px;
	left:350px;
}
.padding-left{ padding-left:10px;}
.padding-right{ padding-right:5px; font-weight:bold;}
</style>
</head>

<body>
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	

	<div class="h_a">��ͨ������Ϣ</div>

		<!--��Ϣ -->
				<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="margin:0 0 10px 0;">
                  <tr>
                    <td height="100" colspan="6" bgcolor="#FFFFFF">
					  <? if ($zt=='90' ){?>
					  <div style="position:relative">
					  	<div id="qxdd"><img src="/images/qx.gif" /></div>
					  </div>
					  <? }?>
					  
					<div style="margin:-20px auto 0 auto; text-align:center; width:540px;">
					
						<div class="bar_load bar_load_ok error_false">
							<span>1</span>
							<div>����һ�</div>
						</div>
						<div class="bar_line bar_line_ok error_false"><div></div></div>
						
						
						<div class="bar_load <? if ($zt=='2' || $zt=='3' ){?>bar_load_ok<? }?>">
							<span>2</span>
							<div>����֧��</div>
						</div>
						<div class="bar_line <? if ($zt=='2' || $zt=='3' ){?>bar_line_ok<? }?>"><div></div></div>
						
						
						<div class="bar_load <? if ($zt=='3' ){?>bar_load_ok<? }?>">
							<span>3</span>
							<div>׼����ͨ</div>
						</div>
						<div class="bar_line <? if ($zt=='3' ){?>bar_line_ok<? }?>"><div></div></div>
						
						
						<div  class="bar_load <? if ($zt=='3' ){?>bar_load_ok<? }?>">
							<span>4</span>
							<div>��ʽ��ͨ</div>
						</div>
					</div>					</td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">������ţ�</span></td>
                    <td width="18%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><?=$dh?></td>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">�����ͺţ�</span></td>
                    <td width="19%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><?=$xinghao?></td>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">����״̬��</span></td>
                    <td width="18%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><?=$zt_str?></td>
                  </tr>
                  
                  <tr>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">����ʱ�䣺</span></td>
                    <td width="18%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><?=$indate?></td>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right" ><span class="str_pad1">�������ۣ�</span></td>
                    <td width="19%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><?=$jiage?>
                      Ԫ</td>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">�������ޣ�</span></td>
                    <td width="18%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><?=$host_nianxian?>
                      ��</td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">ʹ�û��֣�</span></td>
                    <td width="18%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><span style="color: #009966; font-weight:bold; font-size:18px;"><?=$host_jifen?></span>
                      ��</td>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">�����۸�</span></td>
                    <td width="19%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><span style="color:#3399FF;font-weight:bold;font-size:18px;">
                      <?=($jiage*$host_nianxian)?>
                      </span> Ԫ </td>
                    <td width="15%" height="40" align="right" bgcolor="#FFF5F0" class="padding-right"><span class="str_pad1">�ɽ��۸�</span></td>
                    <td width="18%" height="40" align="left" bgcolor="#FFFFFF" class="padding-left"><span style="color: #FF0000; font-weight:bold; font-size:18px;">
                      <?=(($jiage*$host_nianxian)-$host_jifen)?>
                    </span> Ԫ</td>
                  </tr>
  </table>
				  <!--��Ϣ -->


	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&id=".$id."&".$pageurl."&action=edit&time=".time(),$key_url_md_5)?>"><!--//���������� -->
	
	
	<div class="h_a">�޸Ŀ�ͨ��Ϣ������״ֻ̬Ҫ���ǡ��ѿ�ͨ����������Ϣ�û����޷��鿴������</div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
		  <tr>
		      <th width="19%">��ϵ������</th>
		      <td width="33%"><input name="kt_lxr" type="text" class="input length_5" id="kt_lxr" value="<?=$kt_lxr?>" maxlength="30" /></td>
	          <td width="48%" rowspan="7">
		        <textarea name="tongzhi_str" id="tongzhi_str" style="width:100%; height:260px;"></textarea>		      </td>
		  </tr>
			
		  <tr>
			  <th>���ֻ���</th>
			  <td>
			  <input name="kt_tel" type="text" class="input length_5" id="kt_tel" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" value="<?=$kt_tel?>" maxlength="11" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
	      </tr>
		  
		  <tr>
			  <th>��ϵQQ</th>
			  <td>
			  <input name="kt_qq" type="text" id="kt_qq" value="<?=$kt_qq?>" class="input length_5" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
	      </tr>
		   <tr>
			  <th>FTP�û���</th>
			  <td><input name="kt_ftp_u" type="text" id="kt_ftp_u" value="<?=$kt_ftp_u?>" class="input length_5" /></td>
	      </tr>
		   <tr>
			  <th>FTP����</th>
			  <td><input name="kt_ftp_p" type="text" id="kt_ftp_p" value="<?=$kt_ftp_p?>" class="input length_5" /></td>
	      </tr>
			<tr>
			  <th>��������</th>
			  <td><input name="kt_enddate" type="text" id="kt_enddate" value="<?=$kt_enddate?>" class="input length_5" onFocus="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd'})"/></td>
	      </tr>
		  <tr>
			  <th>����״̬</th>
			  <td><select name="zt" class="select_5" id="zt">
						<option value="1" <? if ($zt=='1'){?>selected="selected"<? }?> >������</option>
						<option value="2" <? if ($zt=='2'){?>selected="selected"<? }?>>����ͨ</option>
						<option value="3" <? if ($zt=='3'){?>selected="selected"<? }?>>�ѿ�ͨ</option>
						<option value="90" <? if ($zt=='90'){?>selected="selected"<? }?>>��ȡ��</option>
					</select></td>
	      </tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('ȷ�ϱ�����Ϣ��','submit','formsa','wen','')" >������Ϣ</button>
			&nbsp;&nbsp;
			<button class="btn btn_big btn_success" type="button" onClick="tongzhi()" >����֪ͨ</button>
			&nbsp;&nbsp;
			<?
			$back_url=encrypt_url("&page=".$page."&aid=".$id."&".$pageurl."&time=".time(),$key_url_md_5);
			?>
			<button class="btn btn_big loading_it" type="button" onClick="document.location.href='host.php?<?=$back_url?>';" > �����б� </button>
			
			
		</div>
	</div>

	</form>
</div>

<div id="a1" style=" position:absolute; z-index:9999;"></div>
<script>
function tongzhi(){
	var str='';
	str=str+"��ϵ��������"+document.getElementById("kt_lxr").value+"\n";
	str=str+"���ֻ��ţ�"+document.getElementById("kt_tel").value+"����������ʱ����֪ͨ��"+"\n";
	str=str+"��ϵQQ��"+document.getElementById("kt_qq").value+"\n";
	str=str+"FTP�û�����"+document.getElementById("kt_ftp_u").value+"\n";
	str=str+"FTP���룺"+document.getElementById("kt_ftp_p").value+"\n";
	str=str+"�������ڣ�"+document.getElementById("kt_enddate").value+"\n\n";
	str=str+"����˵����\n"+"ҵ����ϵ�ˣ����ף�QQ���룺858353007\n����������壺http://www.myhostadmin.net\nICP��վ��������ϵͳ v4.0��http://beian.vhostgo.com/";
	
	document.getElementById("tongzhi_str").value=str;
}
tongzhi()
</script>
</body>
</html>
