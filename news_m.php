<?
include_once("./mdaima_var_inc/config_system.php");
$wap_mobile='';
if (isMobile() && $_SESSION["mobile_wap"]!='pc'){
	$wap_mobile='true';
	include_once("wap/news_m_wap.php");
	exit;
}

include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php"); 

include_once("./search_all.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>随手记-码代码-大胆哥博客</title>
<meta name="description" content="博主在钻研PHP技术的同时，也一样关心社会百态，记录社会事件评说心中感想！" />
<meta name="keywords" content="博客新闻,大胆哥资讯,互联网资讯,社会新闻,PHP新闻,PHP资源,互联网新闻" />
<meta name="applicable-device" content="pc">
<link href="/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/lx.js"></script>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" /> 
</head>

<body>

<? include_once("./index_top.php"); ?>
	
	<!-- 大BOX开始 -->
	<div id="main_box">
	
	<!-- 经验box -->
	<div class="jy_box">
		<!-- 经验 左-->
		<div class="zhengwen_l_2">
			<? 
			
			if (check_null($keyword_search)!='0'){//查询条件
				if ($_COOKIE["search_jingdu"]=='1'){//精确
					//*********************************************
					function getfile($ss_str){      
						$array = explode(' ',$ss_str);
						return $array;     
					} 
					
					$word = getfile($keyword_search);
					$length = count($word);
					
					for($iop = 0; $iop < $length; $iop++){  
						$search_for=$search_for."title like '%".$word[$iop]."%' or ";//搜索分词
						$if_count.="if(instr(title, '".addslashes($word[$iop])."'),1,0)+"; //关键词排序计算
					}
					
					$search_for=substr($search_for,0,-3);
					$if_count=substr($if_count,0,-1)." as count"; //关键词排序计算 整合
					$title_str=" and ( ".$search_for." )";
					$search_count_num++;
					
					$search_score='';//强制清空
					$px_search='';
					//**********************************************
				}else{	
					$keyword_start =$keyword_search;//记录原始搜索词
					$keyword_search=keyword_replace($keyword_search);//替换keyword
					$splitnum_new = quweima($keyword_search);//转为可用于搜索的区位码索引
					
					$search_score=",MATCH(title_code) AGAINST ('".$splitnum_new."' IN BOOLEAN MODE) AS countscore";//置于select字段
					$search_for="MATCH(title_code) AGAINST ('".$splitnum_new."' IN BOOLEAN MODE) ";
					
					$px_search='title';//强调排序规则  “启动”标题评分排序
		
					$title_str=" and ( ".$search_for." )";
					$search_count_num++;
				}
				
			}else{
				$title_str="";
			}

			if ($_SESSION['blog_lileiuser']!="" && $_REQUEST['see']=='true'){//为后台预览效果准备
				$pass_str=" 1=1 ";
			}else{
				$pass_str=" pass='1' ";
			}
			
			if ($px_search=='title'){//按标题查询评分排序
				$px_str=" order by countscore desc ";
			}else{//申报时间（倒序）
				$px_str=" order by zhiding desc,indate desc ";
				
			}
			
			$sql_page="select count(*) from lei_news where ".$pass_str." ".$title_str." ";
			
			
			$result_page=$mysqli->query($sql_page);
			$rs_page=$result_page->fetch_array();
			$pagenum=8;   //每页显示条数
			$pageidcount=$rs_page[0];
			$allnum=ceil($rs_page[0]/$pagenum);//总页数
			
			if($page=="") $page=1;
			if($page<=1) $page=1;
			if($page>=$allnum)$page=$allnum;//因为page是从0开始的，所以要-1
			$pagestart=($page-1)*$pagenum;
			if($pagestart<=0) $pagestart=0; 
	
			$sql_search="select id,title,laiyuan,indate,hits,pass,zhiding,simgpaths,message".$search_score." from lei_news where ".$pass_str." ".$title_str." ".$px_str." limit ".$pagestart.",".$pagenum." ";
			$i=0;
			$noid_news='';
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			$i++;
				$noid_news=$noid_news."'".$rs["id"]."',";
				
			?>
			<div class="wen">
				<? if($rs["zhiding"]=='1'){?>
				<div class="span-mark">置顶</div>
				<? }elseif($rs["hits"]>=1000){?>
				<div class="span-mark">热门</div>
				<? }?>
				<div class="news_title"><a href="/news/<?=$rs["id"]?>.html" target="_blank"><img src="<?=str_replace('../','/',$rs["simgpaths"])?>" width="180" height="130" border="0" id="news_img_<?=$rs["id"]?>" /></a></div>
				<div class="wen_box">
					<?
					if ($_COOKIE["search_jingdu"]!='1' && $_COOKIE["search_jingdu"]!='0'){//判断精度cookie是否有值或支持，容错判断
						$cookie_jingdu='0';
					}else{
						$cookie_jingdu=$_COOKIE["search_jingdu"];
					}
					?>
					<div class="title"><a href="/news/<?=$rs["id"]?>.html" target="_blank" id="news_title_<?=$rs["id"]?>"><?=keywordlight($keyword_search,$rs["title"],$cookie_jingdu);?></a></div>
					<div class="miaoshu" id="news_miaoshu_<?=$rs["id"]?>"><?=mysubstr(clear_all($rs["message"]),0,105, 'gbk')?></div>
					<div class="ms_info">
						<div class="ms_web"><i class="icon-fire"></i> <?=$rs["laiyuan"]?></div>
						
						<div class="ms_date"><?=time_show($rs["indate"])?></div>
						
						<div class="ms_share">
							<div class="bds_qzone_2_16" onclick="share_list('qzone','news','<?=$rs["id"]?>')" ></div>
							<div class="bds_tsina_2_16" onclick="share_list('tsina','news','<?=$rs["id"]?>')"></div>
							<div class="bds_tqq_2_16" onclick="share_list('tqq','news','<?=$rs["id"]?>')"></div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="title_hr"></div>
			
			<? }?>
			<div class="clear"></div>
			
			<!--引用页码 -->
			<? include_once("./v_i_page.php")?>
			<!--引用页码 END-->
			
			<div class="clear"></div>
			
		</div>
		<!-- 经验 左 end -->
		
		<!-- 经验 右-->
		<? include_once("./art_right.php"); ?>
		<!-- 经验 右 end -->
		
	</div>
	<!-- 经验box end -->
	
	
	<div class="clear" style="height:15px;"></div>
	
	</div>
	<!-- 大BOX end -->


<!--版权 -->
<div class="clear"></div>
<? include_once("./index_foot.php"); ?>
<!--版权 -->

</body>
</html>
