<?
if ($wap_mobile!='true') exit;

include_once("mdaima_var_inc/config_system.php");
include_once("mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("mdaima_var_inc/conn.php"); 
include_once("wap/c_inc/c_inc.php"); 

$page=$_REQUEST["page"];//跳转页码
?>
<!DOCTYPE html>
<html>
<head>
<title>随手记-码代码-李雷博客</title>
<meta name="description" content="博主在钻研PHP技术的同时，也一样关心社会百态，记录社会事件评说心中感想！" />
<meta name="keywords" content="博客新闻,李雷资讯,互联网资讯,社会新闻,PHP新闻,PHP资源,互联网新闻" />
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

	
<!--外部框 -->
<div class="box">
	

	
	
	<!--列表 -->
	<div class="clearfix" id="i_liebiao" >
		<div>
		  <? 

			$read_mulu='news';
			
			$sql_page="select count(*) from lei_news where pass='1' ";
			$result_page=$mysqli->query($sql_page);
			$rs_page=$result_page->fetch_array();
			$pagenum=15;   //每页显示条数
			$pageidcount=$rs_page[0];
			$allnum=ceil($rs_page[0]/$pagenum);//总页数
			
			if($page=="") $page=1;
			if($page<=1) $page=1;
			if($page>=$allnum)$page=$allnum;//因为page是从0开始的，所以要-1
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
						<? if($rs["zhiding"]=='1'){//优先?>
							<span class="span-mark">置顶</span>
						<? }elseif($rs["hits"]>=1000){?>
							<span class="span-mark">热门</span>
						<? }?>
					<a href="/<?=$read_mulu?>/<?=$rs["id"]?>.html" ><?=$rs["title"]?></a></div>
					<div class="i_lb_r_info">
						<?=mysubstr(clear_all($rs["message"]),0,105, 'gbk')?>
					</div>
					<div class="i_lb_r_date">
					更新：<?=time_show_wap($rs["indate"])?>&nbsp;&nbsp;&nbsp;&nbsp;人气：<?=$rs["hits"]?>
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
		
		<!--引用页码 -->
			<? include_once("wap/v_i_page.php")?>
			<!--引用页码 END-->
			
			
	</div>
	<!--列表end -->
	
	
	<? include_once("wap/foot.php"); ?>
	
	
</div>
<!--外部框end -->


</body>
</html>
