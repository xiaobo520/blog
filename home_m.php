<?
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");
include_once("./mdaima_var_inc/checkall_home.php");
include_once("./dh_config.php");
include_once("./mdaima_var_inc/new_image.class.php");




$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$page=$url_info['page'];
$id=$url_info['id'];
$action=$url_info['action'];

if ($action=="edit"){

	$nicheng=str_replace(' ','',quotes_gpc_pd($_POST['nicheng'],1));
	
	$img=quotes_gpc_pd($_POST['img'],1);
	
	if (check_null($nicheng)=='0'){ //检测手机或邮件
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('昵称不能为空！','alert_back','','error','');</script>";
		exit;
	}
	
	if (check_str_teshu($nicheng)=='result_false'){ //检测手机或邮件
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('昵称不能含有特殊字符！','alert_back','','error','');</script>";
		exit;
	}
	
	if ( bad_words_jc($nicheng," ",$bad_words)=='badfalse' ){//strpos 判断为 !==false  或 ===false
		alert_ini_index();//输出alert所需文件
		echo "<script>alert_go('内容中不能含有非法词汇！','alert_back','','error','');</script>";
		exit;
	}
	
	$sql="select id,indate from lei_user where username='".$_SESSION['user_lei_username']."' limit 1";
	$result=$mysqli->query($sql);
	
	if($rs=$result->fetch_assoc()){
		$picid="user_".md5($rs["indate"].$rs["id"]);
		$indate=$rs["indate"];
	}else{
		echo "系统错误或超时！";
		$mysqli->close();
		exit;
	}
	
	if ($_FILES["file"]["error"] !=4){	

		$uppath="images/user/".date("Ym",strtotime($indate))."/";  //目录只能逐级检查并建立
		if(!file_exists($uppath)){ 
			mkdir($uppath,0777); //新建目录
			chmod($uppath,0777); //附加权限
		}
		
		$uppath=$uppath.date("d",strtotime($indate))."/";
		if(!file_exists($uppath)){
			mkdir($uppath,0777); //新建目录
			chmod($uppath,0777); //附加权限
		}
	
		$filename=$picid;  //原文件名：$_FILES["file"]["name"]
		
		$maxsize=200; //K
		
		if ( $_FILES["file"]["type"] != "image/gif" && $_FILES["file"]["type"] != "image/jpeg" && $_FILES["file"]["type"] != "image/pjpeg"){
			echo "<script language=javascript>alert('上传图片类型不正确！限 jpg，gif 格式');javascript:history.back(-1);</script>";
			exit;
		}
		
		if ($_FILES["file"]["size"] > $maxsize*1024){//512K
			echo "<script language=javascript>alert('上传图片大小不能超过".$maxsize."K！');javascript:history.back(-1);</script>";
			exit;
		}
		
		if ($_FILES["file"]["error"] > 0){
			echo "上传参数错误: " . $_FILES["file"]["error"] . "<br />";
		}else{
			move_uploaded_file($_FILES["file"]["tmp_name"],$uppath.$filename);//上传文件
			$newimgname=$uppath.$filename; //重新更名
			
			/*
			@list($ws,$tt)=@getimagesize($newimgname);
			if ($ws>120 || $tt>120){  //注册新会员同此项尺寸
				$image=new image($newimgname, 1, "120", "120",$newimgname);
				$image->outimage();
			}
			*/

		}
		$shengcheng='yes';//原始图不执行生成操作
		$newimgname_in="/".$newimgname;
	}else{
		$newimgname_in=$img; //新缩放后的
		$shengcheng='no';//原始系统自带图不执行生成操作
	}
	
	/*
	@list($ws,$tt)=@getimagesize($newimgname);
	if ($ws>45 || $tt>45){  //路径为，注册时，按注册日期生成的日期目录 （注册日期不会改变）
		$image=new image($newimgname, 1, "45", "45","images/user/".date("Ym",strtotime($indate))."/".date("d",strtotime($indate))."/".md5($_SESSION['user_lei_dogs_username']."_s"));
		$image->outimage();
	}
	*/
	
	if ($shengcheng=='yes'){//生成操作
		$newimgname_s=$newimgname."-S";
		$image=new image($newimgname, 1, "50", "50",$newimgname_s);//生成首页小图标
		$image->outimage();
	}

	$nicheng_py=pinyin_g($nicheng);
	
	$sql="update lei_user set nicheng='".$nicheng."',nicheng_py='".$nicheng_py."',userimg='".$newimgname_in."' where username='".$_SESSION['user_lei_username']."' limit 1";
	$mysqli->query($sql);

	alert_ini_index();//输出alert所需文件
	echo "<script>alert_go('信息保存成功！','alert_go','','ok','?');</script>";
	exit;

	$mysqli->close();

}






$sql="select id,nicheng,indate,jifen,jifen_all,lasttime,userimg from lei_user where username='".$_SESSION['user_lei_username']."' limit 1";
$result=$mysqli->query($sql);
	
if($rs=$result->fetch_assoc()){
	$nicheng=$rs["nicheng"];
	$indate=$rs["indate"];
	$jifen=$rs["jifen"];
	$jifen_all=$rs["jifen_all"]; //历史总积分
	$lasttime=$rs["lasttime"];
	$img=$rs["userimg"];

}else{
	echo "系统错误或超时！【302】！";
	$mysqli->close();
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员中心-大胆哥博客</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/lx.js"></script>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" /> 

<script>
function xztx(a) {
var i=0
	for (i=1;i<=26;i++){
		document.getElementById('touxiang_'+i).className='regtouxiang';
	}
	document.getElementById('touxiang_'+a).className='regtouxiangxz';
	$("#showtx").hide();  //显示
	document.getElementById('showtx').src="/images/touxiang/"+a+".jpg";
	$("#showtx").fadeIn();  //显示
	document.form1.img.value="/images/touxiang/"+a+".jpg";
}
</script>

</head>

<body>

<? include_once("./index_top.php"); ?>
	
	<!-- 大BOX开始 -->
	<div id="main_box">
	<div class="home_box" >
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #CCCCCC">
        <tr>
          <td width="22%" align="center" valign="top" bgcolor="#F5F3F1"><?php include_once("./home_left.php");?></td>
          <td width="78%" align="center" valign="top" bgcolor="#FFFFFF">
		  
		    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="44" align="right" valign="bottom">
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="30%" height="32" align="left" class="font15"><?=$daohang?></td>
                  <td width="70%" height="32" align="right"><a href="/" class="a1">首页</a> &gt;&gt; 会员中心&nbsp;&nbsp;</td>
                </tr>
              </table>
			  </td>
            </tr>
			<tr>
              <td height="12" background="/images/dw2.jpg"></td>
            </tr>
            <tr>
              <td valign="top"><form id="form1" name="form1" method="post" action="?<?=encrypt_url("action=edit"."&time=".time(),$key_url_md_5)?>" enctype="multipart/form-data">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#EAEAEA" style="margin-top:15px;">
                  <tr>
                    <td width="21%" height="45" bgcolor="#F9F9F9">&nbsp;</td>
                    <td width="79%" height="45" bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">用户名：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2" ><?=$_SESSION['user_lei_username']?></td>
                  </tr>
                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9" ><span class="str_pad1">昵称：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2">
						<input name="nicheng" type="text" class="form_home_text" id="nicheng" value="<?=$nicheng?>" maxlength="10" />
					</td>
                  </tr>


                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9" class="str_pad1" style="line-height:30px;">头像：<br />
                    <a href="javascript:void(0)" onclick="document.getElementById('zidingyi').style.display='';" style="color:#0066FF">[ 自定义本地上传 ]</a> </td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2">
					
					  <table width="100%" height="100" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="92"><img src="<?=$img?>?i=<?=rand()?>" style="border:1px solid #E6E6E6; padding:1px" id="showtx" width="75" height="75"/></td>
                          <td style=" padding-top:2px;">
							<? 
							  for ($i=1;$i<=26;$i++){
							?>
							  <div style="width:39px; height:39px; float:left; margin-left:3px; margin-top:3px; cursor:pointer;">
								<img src="/images/touxiang/<?=$i?>.jpg" id="touxiang_<?=$i?>" width="30" height="30" class="regtouxiang" onclick="xztx(<?=$i?>)"/>							  </div>
							<? 
							  }
							?>						  </td>
                        </tr>
                      </table>					</td>
                  </tr>
                  <tr id="zidingyi" style="display:none">
                    <td height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">上传本地头像：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><input name="file" type="file" id="file" style=" border:1px solid #CCCCCC; background:#FFFFFF;height:35px;width:317px;line-height:35px;"/>   * 建议尺寸比例1：1&nbsp;&nbsp; 尺寸：150*150 </td>
                  </tr>
                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">剩余积分：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><span style="color: #B75B00; font-weight:bold">
                      <?=$jifen?>
                    </span> 分</td>
                  </tr>
                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">历史积分：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><span style="color:#B75B00; font-weight:bold">
                      <?=$jifen_all?>
                    </span> 分</td>
                  </tr>
                  
                  <? if (strtotime(date("Ymd"))-$vipendtime<=0){?>
                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">VIP有效期至：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><?=date("Y-m-d",$vipendtime)?>，还有 <span style="color:#B75B00; font-weight:bold"><?=round(($vipendtime-strtotime(date("Y-m-d")))/24/3600)?></span> 天到期</td>
                  </tr>
				  <? }?>
				  
                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">注册时间：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><?=$indate?></td>
                  </tr>
                  <tr>
                    <td height="45" align="right" bgcolor="#F9F9F9"><span class="str_pad1">最近活跃发言时间：</span></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" class="str_pad2"><?=$lasttime?></td>
                  </tr>
                  
                  <tr>
                    <td height="67" bgcolor="#F9F9F9">
						<input name="img" type="hidden" id="img" value="<?=$img?>"/><!--不用/根目录 -->					</td>
                    <td height="67" align="left" bgcolor="#FFFFFF" class="str_pad2">
					<button class="btn btn_big btn_submit" type="button" onClick="alert_go('确认保存信息？','submit','form1','wen','')" >保存信息</button>
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
	<!-- 大BOX end -->


<!--版权 -->
<div class="clear"></div>
<? include_once("./index_foot.php"); ?>
<!--版权 -->



</body>
</html>
