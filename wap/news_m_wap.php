<?
if ($wap_mobile!='true') exit;

include_once("mdaima_var_inc/config_system.php");
include_once("mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("mdaima_var_inc/conn.php"); 
include_once("wap/c_inc/c_inc.php"); 

$page=$_REQUEST["page"];//��תҳ��
?>
<!DOCTYPE html>
<html>
<head>
<title>���ּ�-�����-���ײ���</title>
<meta name="description" content="����������PHP������ͬʱ��Ҳһ����������̬����¼����¼���˵���и��룡" />
<meta name="keywords" content="��������,������Ѷ,��������Ѷ,�������,PHP����,PHP��Դ,����������" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta http-equiv="cache-control" content="no-cache" />
<meta name="applicable-device" content="mobile">
<meta http-equiv="pragram" content="no-cache">
<meta meta name="format-detection" content="telephone=no,email=no,adress=no" />
<link href="/wap/style.css?v=2020031000016" rel="stylesheet" media="screen">
<script type="text/javascript" src="/wap/js/jquery-1.7.1.min.js"></script>
</head>
<body>

<? include_once("wap/top.php"); ?>

	
<!--�ⲿ�� -->
<div class="box">
	

	
	
	<!--�б� -->
	<div class="clearfix" id="i_liebiao" >
		<div>
		  <? 

			$read_mulu='news';
			
			$sql_page="select count(*) from lei_news where pass='1' ";
			$result_page=$mysqli->query($sql_page);
			$rs_page=$result_page->fetch_array();
			$pagenum=15;   //ÿҳ��ʾ����
			$pageidcount=$rs_page[0];
			$allnum=ceil($rs_page[0]/$pagenum);//��ҳ��
			
			if($page=="") $page=1;
			if($page<=1) $page=1;
			if($page>=$allnum)$page=$allnum;//��Ϊpage�Ǵ�0��ʼ�ģ�����Ҫ-1
			$pagestart=($page-1)*$pagenum;
			if($pagestart<=0) $pagestart=0; 
	
			$sql_search="select id,title,laiyuan,indate,hits,pass,zhiding,simgpaths,message from lei_news where pass='1' order by zhiding desc,indate desc  limit ".$pagestart.",".$pagenum." ";
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				
				<td valign="top" align="left">
					<div class="i_lb_r_title">
						<? if($rs["zhiding"]=='1'){//����?>
							<span class="span-mark">�ö�</span>
						<? }elseif($rs["hits"]>=1000){?>
							<span class="span-mark">����</span>
						<? }?>
					<a href="/<?=$read_mulu?>/<?=$rs["id"]?>.html" ><?=$rs["title"]?></a></div>
					<div class="i_lb_r_info">
						<?=mysubstr(clear_all($rs["message"]),0,105, 'gbk')?>
					</div>
					<div class="i_lb_r_date">
					���£�<?=time_show_wap($rs["indate"])?>&nbsp;&nbsp;&nbsp;&nbsp;������<?=$rs["hits"]?>
					</div>
				</td>
				
				<td class="i_lb_img_box" align="right"><a href="/<?=$read_mulu?>/<?=$rs["id"]?>.html" ><img src="<?=str_replace('../',$wap_index_pic_path,$rs["simgpaths"])?>" class="i_lb_img"/></a></td>
			  </tr>
			</table>

			<div class="i_lb_r_hr"></div>
		  <? 
		  }?>
		</div>
		<div style="clear:both; height:1px;"></div>
		
		<!--����ҳ�� -->
			<? include_once("wap/v_i_page.php")?>
			<!--����ҳ�� END-->
			
			
	</div>
	<!--�б�end -->
	
	
	<? include_once("wap/foot.php"); ?>
	
	
</div>
<!--�ⲿ��end -->


</body>
</html>
