<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
//--------------������������
include_once("jingyan_post_all.php"); 
//--------------������������
$action=$url_info['action'];
$time=$url_info['time'];

//�޸��û�-��ʼ

if ($action=="add"){

	$title=quotes_gpc_pd($_POST['title'],1);
	$keyword=$_POST['keyword'];
	$laiyuan=quotes_gpc_pd($_POST['laiyuan'],1);
	$message=quotes_gpc_pd($_POST['message1'],0);
	$indate=quotes_gpc_pd($_POST['indate'],1);
	$pass=quotes_gpc_pd($_POST['pass'],1);
	$hits=quotes_gpc_pd($_POST['hits'],1);
	$shipin=quotes_gpc_pd($_POST['shipin'],1);
	$zhiding=quotes_gpc_pd($_POST['zhiding'],1);
	$pinglun=quotes_gpc_pd($_POST['pinglun'],1);
	$guanjianci=quotes_gpc_pd($_POST['guanjianci'],1);
	
	$article_suofang=quotes_gpc_pd($_POST['article_suofang'],1);
	$article_shuiyin=quotes_gpc_pd($_POST['article_shuiyin'],1);

	if ($title=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('���±��������д��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($keyword==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('���ݱ�ǩ��������д�����޷��ϱ�ǩ��������ӣ���','alert_back','','error','');</script>";
		exit;
	}
	
	if ($guanjianci==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�ؼ��ʣ�������д��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($message=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�������ݱ�����д','alert_back','','error','');</script>";
		exit;
	}
	
	if ($laiyuan=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('������Դ������д','alert_back','','error','');</script>";
		exit;
	}
	
	if ($hits=="" ){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('���·��ʴ���������д','alert_back','','error','');</script>";
		exit;
	}
	
	if ($indate==""){
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('�������ڣ�������д��','alert_back','','error','');</script>";
		exit;
	}
	
	if ($_FILES["file"]["error"] !=4){
		
		function fileext($filename) 
		{ 
			return substr(strrchr($filename, '.'), 1); 
		}
		
		$type=array("jpg","gif","png","jpeg");//���������ϴ��ļ������� "jpeg","png"

		if(!in_array(strtolower(fileext($_FILES['file']['name'])),$type)){
			
			alert_ini();//���alert�����ļ�
			echo "<script>alert_go('�ϴ��ļ����Ͳ���ȷ��','alert_back','','error','');</script>";
			exit;
		}
		
		if ($_FILES["file"]["size"] > 500*1024){
			alert_ini();//���alert�����ļ�
			echo "<script>alert_go('�ϴ��ļ���С��������[500K]��','alert_back','','error','');</script>";
			exit;
		}

		$filename=give_dh_18();
		
		$indate=date("Y-m-d H:i:s");
		$uppath="../upload_image/".date("Y",strtotime($indate))."/";  //Ŀ¼ֻ���𼶼�鲢����
		if(!file_exists($uppath)){ 
			mkdir($uppath,0777); //�½�Ŀ¼
			chmod($uppath,0777); //����Ȩ��
		}
		
		$uppath=$uppath.date("m",strtotime($indate))."/";  //Ŀ¼ֻ���𼶼�鲢����
		if(!file_exists($uppath)){ 
			mkdir($uppath,0777); //�½�Ŀ¼
			chmod($uppath,0777); //����Ȩ��
		}
		
		$uppath=$uppath.date("d",strtotime($indate))."/";
		if(!file_exists($uppath)){
			mkdir($uppath,0777); //�½�Ŀ¼
			chmod($uppath,0777); //����Ȩ��
		}
		
		//$filePath =$uppath.$filename.".".strtolower(fileext($_FILES['file']['name']));//�к�׺��
		
		$filePath =$uppath.md5($filename."image");//תΪ��ͼƬ��׺�����ƣ�������
		
		if ($_FILES["file"]["error"] > 0){
			echo "�ϴ���������: " . $_FILES["file"]["error"] . "<br />";
		}else{
			move_uploaded_file($_FILES["file"]["tmp_name"],$filePath);//�ϴ��ļ�,��̨�ϴ���ԭ·����ǰ̨����../
		}
	
	}else{
		alert_ini();//���alert�����ļ�
		echo "<script>alert_go('��ѡ������ͼƬ��','alert_back','','error','');</script>";
		exit;
	}
	
	//����ߴ��Զ����� $var_article_suofang='1';//���������Ƿ������е�ͼƬ�Զ����ŵ�ָ��������ڣ�1�ǣ�0��
	if ($article_suofang=='1'){
		if(preg_match("/<img.*>/",$message)){//�����ͼƬ
			
			include_once("../mdaima_var_inc/new_image.class.php");
			$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,stripslashes($message),$match); //count($match)  ��ȡ����ͼƬ·������
			$countm=count($match[1]); //1·����0��������ǩ<img>
			//print_r($match[1]);
			//exit;
			for ($i=0;$i<=$countm-1;$i++){
				@list($ws,$tt)=@getimagesize("..".$match[1][$i]);//ע��·��
				if ($ws>660 || $tt>700){  //��ȳ���660�򣬸߶ȳ���700���Ű�ָ���Ŀ�߱�������
					$image=new image("..".$match[1][$i], 1, "660", "700" ,"..".$match[1][$i]);
					$image->outimage();
				}
			}
			
		}
	}
	

	//ˮӡ��ͼƬ���������ִ�� $var_article_shuiyin='1';//���������Ƿ������е�ͼƬ�Զ����ˮӡ��1�ǣ�0��
	if ($article_shuiyin=='1'){
		if(preg_match("/<img.*>/",$message)){//�����ͼƬ
			
			include_once("../mdaima_var_inc/new_image.class.php");
			$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,stripslashes($message),$match); //count($match)  ��ȡ����ͼƬ·������
			$countm=count($match[1]); //1·����0��������ǩ<img>
			
			for ($i=0;$i<=$countm-1;$i++){
				@list($ws,$tt)=@getimagesize("..".$match[1][$i]);
				if ($ws>300 && $tt>50){  //��ȳ���350�ң��߶ȳ���250�������ˮӡ
					$image=new image("..".$match[1][$i], 3, "../images/shuiyin.gif", "9","..".$match[1][$i]);
					$image->outimage();
				}
			}
			
		}
	}


	$title_code = quweima($title);//������תΪ������λ����
	$keyword = implode(",",$keyword);//תΪ�ַ���
	
	$keyword = '-'.str_replace(",",'-,-',$keyword).'-';//����ַ���  -1-,-12-,-5-
	
	$sql="insert into lei_jingyan (title,title_code,keyword,message,indate,laiyuan,hits,pass,simgpaths,shipin,zhiding,huifuzt,guanjianci,pinglun) values ('".$title."','".$title_code."','".$keyword."','".$message."','".$indate."','".$laiyuan."',".$hits.",'".$pass."','".$filePath."','".$shipin."','".$zhiding."','0','".$guanjianci."','".$pinglun."') ";
	$mysqli->query($sql);

	$result_zidian=$mysqli->query("select last_insert_id()");//mysql_insert_id($mysqli);//��ȡ�Զ�����
	if($mysqllast=$result_zidian->fetch_assoc()){
		$aid=$mysqllast["last_insert_id()"];//����ID
	}
	
	$back_url=encrypt_url("&page=".$page."&aid=".$aid."&".$pageurl."&time=".time(),$key_url_md_5);
	
	alert_ini();//���alert�����ļ�
	echo "<script>alert_go('������ӳɹ���','alert_go','','ok','jingyan_list.php?".$back_url."');</script>";
	exit;
	
	$mysqli->close();

}
//����

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor_1.config.js"></script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="js/tooledit/ueditor_baidu/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>

</head>

<body>
<? include_once("js/js_alert.php"); //����MODULE������?>
<div class="wrap">	

	<div class="h_a">����˵��</div>
	<div class="prompt_text">
		<ol>
			<li>����״̬��Ϊ��δ�������͡�����������δ������״̬�µ�����ǰ̨����ʾ��</li>
		</ol>
	</div>

	<form name="formsa" id="formsa" method="POST" enctype="multipart/form-data" action="?<?=encrypt_url("&page=".$page."&".$pageurl."&action=add&time=".time(),$key_url_md_5)?>"><!--//���������� -->
	<div class="h_a">���PHP������Ϣ</div>
	<div class="table_full">
		<table width="100%" >
			<colgroup>
					<col class="th" >
					<col >
			</colgroup>
			<tr>
			  <th>���±���</th>
			  <td>
			  <input name="title" type="text" id="title" value="" class="input length_5" /></td>
		  </tr>
			
			<tr>
			  <th>���ݱ�ǩ</th>
			  <td>
						<?
						$sql_search2="select * from lei_keyword where pass='1' order by px";
						$result2=$mysqli->query($sql_search2);
						$i=0;
						while ($rs2=$result2->fetch_assoc()){
						$i++;

						?>	<div style="float:left; width:130px; height:25px;">
							<input name="keyword[]" type="checkbox" value="<?=$rs2["id"]?>" /> <?=$rs2["keyword"]?>
							</div>
						<? 
						}?></td>
		  </tr>
		    <tr>
		      <th>�ؼ���</th>
		      <td><input name="guanjianci" type="text" class="input length_5" id="guanjianci" value="" maxlength="30" />
		      &nbsp; ����ؼ��ʣ��԰�Ƕ��ţ�,���ֿ���SEO�ؼ������ã�</td>
	      </tr>
		    <tr>
		      <th>�Ƿ���Ƶ</th>
		      <td> <input name="shipin" type="text" id="shipin" value="" class="input length_5" />&nbsp;&nbsp;<input name="shipin_button" type="button" value=" ��дʱ���ʽ " onclick="document.getElementById('shipin').value='1Сʱ10��10��'" /> <input name="shipin_button" type="button" value=" ��� " onclick="document.getElementById('shipin').value=''" /></td>
	      </tr>
	      <tr>
			  <th>������Դ</th>
			  <td>
			  <input name="laiyuan" type="text" id="laiyuan" value="" class="input length_5" />&nbsp;&nbsp;<select id="zhuanye_as" name="zhuanye_as" onChange="document.getElementById('laiyuan').value=this.options[this.selectedIndex].value" >
				<option value="">---ѡ����Դ---</option>
				<option value="��վԭ��">��վԭ��</option>
				<option value="��վ����">��վ����</option>
				<option value="������ת��">������ת��</option>
				<option value="��Ѷ��">��Ѷ��</option>
				<option value="������">������</option>
				<option value="PHP100">PHP100</option>
				<option value="PHPCHINA">PHPCHINA</option>
			</select></td>
		  </tr>
		   <tr>
			  <th>���ʴ���</th>
			  <td>
			  <input name="hits" type="text" id="hits" value="0" class="input length_5" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onafterpaste="this.value=this.value.replace(/[^\d.]/g,'')"/></td>
		  </tr>
		  <tr>
			  <th>����ͼƬ</th>
			  <td><input name="file" type="file" id="file" class="input length_5"/>&nbsp; 180*130</td>
		  </tr>
			<tr>
			  <th>����״̬</th>
			  <td><select name="pass" class="select_5" id="pass">
						<option value="0" selected >δ����</option>
						<option value="1" >����</option>
					</select></td>
		  </tr>
			<tr>
			  <th>�Ƿ��ö�</th>
			  <td>
			    <input type="radio" name="zhiding" value="0" checked="checked" /> ���ö�&nbsp;&nbsp;
				<input type="radio" name="zhiding" value="1"  /> �ö�			  </td>
		  </tr>
		  <tr>
			  <th>�Ƿ�����</th>
			  <td>
			    <input type="radio" name="pinglun" value="0" /> ������&nbsp;&nbsp;
				<input type="radio" name="pinglun" value="1" checked="checked" /> ����			  </td>
		  </tr>
		  <tr>
			  <th>ͼƬ����</th>
			  <td>
			    <input name="article_suofang" type="checkbox" value="1" />
		      �Զ���������ͼƬ &nbsp;&nbsp;&nbsp;&nbsp;             
		      <input name="article_shuiyin" type="checkbox" value="1" />
Ϊ����ͼƬ���ˮӡ</td>
		  </tr>
			<tr>
			  <th>��������</th>
			  <td>
			  <input name="indate" type="text" id="indate" value="<?=date("Y-m-d H:i:s")?>" onFocus="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="true" class="input length_5" /></td>
		  </tr>
			

			<tr>
			  <th>��������</th>
			  <td><script id="editor1" name="message1" type="text/plain" style="width:99%;height:150px;"></script></td>
		  </tr>
		</table>
	</div>
	
	<div class="btn_wrap2">
		<div class="btn_wrap_pd2">
			
			<button class="btn btn_big btn_submit" type="button" onClick="alert_go('ȷ�ϱ������£�','submit','formsa','wen','')" >��������</button>
			&nbsp;
			<?
			$back_url=encrypt_url("&page=".$page."&".$pageurl."&time=".time(),$key_url_md_5);
			?>
			<button class="btn btn_big loading_it" type="button" onClick="document.location.href='jingyan_list.php?<?=$back_url?>';" > �����б� </button>
			
			
		</div>
	</div>

	</form>
</div>

<script type="text/javascript">
    var ue1 = UE.getEditor('editor1');
</script>
</body>
</html>
