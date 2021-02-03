<?
if ($wap_mobile!='true') exit;

include_once("mdaima_var_inc/config_system.php");
include_once("mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("mdaima_var_inc/conn.php"); 
include_once("wap/c_inc/c_inc.php"); 


?>
<!DOCTYPE html>
<html>
<head>
<title>PHP博客系统-由大胆哥博客 www.ubug.icu 开发并免费开源分享</title>
<meta name="description" content="PHPPHP博客系统-由大胆哥博客 www.ubug.icu 开发并免费开源分享" />
<meta name="keywords" content="PHP博客系统-由大胆哥博客 www.ubug.icu 开发并免费开源分享" />
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


			$i=0;
			$sql_read="select cid,indate,tables from lei_read order by indate desc limit 0,20 ";
			$result_read=$mysqli->query($sql_read);
			while ($rs_read=$result_read->fetch_assoc()){
			
				if ($rs_read["tables"]=='lei_jingyan'){
					$read_sql=",keyword,shipin";
					$read_mulu='jingyan';
				}elseif ($rs_read["tables"]=='lei_news'){
					$read_sql="";
					$read_mulu='news';
				}
				
				$sql_search="select id,title,laiyuan,indate,hits,pass,zhiding,simgpaths,message".$read_sql." from ".$rs_read["tables"]." where id='".$rs_read["cid"]."' ";
				$result=$mysqli->query($sql_search);
				if($rs=$result->fetch_assoc()){
				$i++;
				
				
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				
				<td valign="top" align="left">
					<div class="i_lb_r_title">
						<? if($rs["zhiding"]=='1'){//优先?>
							<span class="span-mark">置顶</span>
						<? }elseif($rs["hits"]>=1000){?>
							<span class="span-mark">热门</span>
						<? }elseif ($rs_read["tables"]=='lei_jingyan'){
								if ($rs["shipin"]!=''){?>
							<span class="span-mark">视频</span>
						<? 		}
							}?>
					<a href="<?=$read_mulu?>/<?=$rs["id"]?>.html" ><?=$rs["title"]?></a></div>
					<div class="i_lb_r_info">
						<?=mysubstr(clear_all($rs["message"]),0,105, 'gbk')?>
					</div>
					<div class="i_lb_r_date">
					更新：<?=time_show_wap($rs["indate"])?>&nbsp;&nbsp;&nbsp;&nbsp;人气：<?=$rs["hits"]?>
					</div>
				</td>
				
				<td class="i_lb_img_box" align="right"><a href="<?=$read_mulu?>/<?=$rs["id"]?>.html" ><img src="<?=str_replace('../',$wap_index_pic_path,$rs["simgpaths"])?>" class="i_lb_img"/></a></td>
			  </tr>
			</table>
			<? if ($i<=20){?>
			<div class="i_lb_r_hr"></div>
		  <? }
		  		}
		  }?>
		</div>
		<div style="clear:both; height:1px;"></div>
	</div>
	<!--列表end -->
	
	
	<? include_once("wap/foot.php"); ?>
	
	
	
</div>
<!--外部框end -->


</body>
</html>
