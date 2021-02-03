<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 
set_time_limit(0);//不限制运行时间

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$action=$url_info['action'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" />
<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>
<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="js/my97datepicker/WdatePicker.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div class="wrap">	


	<div class="h_a">请选择操作项目</div>
	
	<div class="search_type cc mb10">
		<div class="btn_side">
			<button class="btn btn_submit btn_big" type="button" onClick="alert_go('确认优化数据库？','href','','wen','?<?=encrypt_url("&action=mysql&time=".time(),$key_url_md_5)?>')" ><i class="icon-hdd icon-white"></i> 优化数据库</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn_success btn_big" type="button" onClick="alert_go('确认生成网站地图？','href','','wen','?<?=encrypt_url("&action=xml&time=".time(),$key_url_md_5)?>')" ><i class="icon-map-marker icon-white"></i> 生成网站地图</button>
		</div>
	</div>
	
	
	
	<!--优化数据库 -->
	
	<? 
	if ($action=='mysql'){
		$mysqli->query("set names gb2312"); 
		//$dbname='lei_dogs';    //数据库名
		
		$sql_status=" SHOW TABLE STATUS FROM me0001 ";
		if ($result=$mysqli->query($sql_status)){ 
			while ($rs=$result->fetch_array()){ //用数组
				$tables_row[]=$rs; 
			}
		}else{
			echo "Error";
			exit;
		}
	?>
	
	<div class="table_list">
	<table width="100%">
	
		<thead>
			<tr>
			  <td colspan="9" align="center" style="font-size:24px;" >数据库优化及状态信息</td>
			</tr>
		</thead>
		<tr>
			<td width="12%" height="65" align="center" ><strong> 表的名<br />
			Name</strong></td>
			<td width="9%" height="65" align="center" ><strong> 存储引擎 <br />
			Engine</strong></td>
			<td width="7%" height="65" align="center" ><strong> 行数 <br />
			Rows</strong></td>
			<td width="13%" height="65" align="center" ><strong> 数据文件的长度 <br />
			Data_length</strong></td>
			<td width="11%" height="65" align="center" ><strong> 索引长度 <br />
			Index_length</strong></td>
			<td width="11%" height="65" align="center" ><strong> Auto_increment</strong></td>
			<td width="16%" height="65" align="center" ><strong>Update_time</strong></td>
			<td width="11%" height="65" align="center" ><strong> 字符集和整序 <br />
			Collation</strong></td>
			<td width="10%" height="65" align="center" ><strong> 评注<br />
			Comment</strong></td>
	  </tr>
  <?
    //print_r($tables_row);
    $i=0;
	foreach($tables_row as $value_row){  
		$mysqli->query ("optimize table ".$value_row[0]." ");//优化各个表
		$i++;
?>
		  <tr>
			<td height="35" align="center" ><?=$value_row[0]?></td>
			<td height="35" align="center" ><?=$value_row[1]?></td>
			<td height="35" align="center" ><?=$value_row[4]?></td>
			<td height="35" align="center" ><?=$value_row[6]?></td>
			<td height="35" align="center" ><?=$value_row[8]?></td>
			<td height="35" align="center" ><?=$value_row[10]?></td>
			<td height="35" align="center" ><?=$value_row[12]?></td>
			<td height="35" align="center" ><?=$value_row[14]?></td>
			<td height="35" align="center" ><?=$value_row[17]?></td>
		  </tr>
<?
	} 
?>  
	</table>
	</div>
	
	<div style="text-align:right; line-height:40px; font-size:22px;">
		共计：<span style="font-weight:bold; color:#FF0000"><?=$i?></span> 个表，优化完成。
	</div>
	
	<? }?>
	
	<!--生成XML地图 -->
	<?
	if ($action=='xml'){
		if (!function_exists(file_get_contents)){ //例：检测 file_get_contents() 函数是否可用
			echo "函数不可用";
			exit;
		}
		
		##-------------------
		
		$mapname="../Sitemap-Mb.xml";//XML地图模版
		$outmap="../Sitemap.xml";//XML地图名称
		if (file_exists($outmap)) {
			if (!unlink($outmap)){
			  echo ("XML文件删除失败");
			  exit;
			}
		}
		$FileStr=file_get_contents($mapname);//获取XML模版
		
		//-------------------------
			$sql_search_pro="select id from lei_jingyan where pass='1' order by id desc limit 50";
			$result_pro=$mysqli->query($sql_search_pro);
			while ($rs_pro=$result_pro->fetch_assoc()){
				$functionstr=$functionstr."<url>\n";
					$functionstr=$functionstr."<loc>http://".$var_domain."/jingyan/".$rs_pro["id"].".html</loc>\n";
					$functionstr=$functionstr."<lastmod>".date('Y-m-d')."</lastmod>\n";
					$functionstr=$functionstr."<changefreq>weekly</changefreq>\n";
					$functionstr=$functionstr."<priority>0.7</priority>\n";
				$functionstr=$functionstr."</url>\n";
			}
			
			$sql_search_pro="select id from lei_news where pass='1' order by id desc limit 50";
			$result_pro=$mysqli->query($sql_search_pro);
			while ($rs_pro=$result_pro->fetch_assoc()){
				$functionstr=$functionstr."<url>\n";
					$functionstr=$functionstr."<loc>http://".$var_domain."/news/".$rs_pro["id"].".html</loc>\n";
					$functionstr=$functionstr."<lastmod>".date('Y-m-d')."</lastmod>\n";
					$functionstr=$functionstr."<changefreq>weekly</changefreq>\n";
					$functionstr=$functionstr."<priority>0.7</priority>\n";
				$functionstr=$functionstr."</url>\n";
			}
				
		//-------------------------

		$FileStr=str_replace("{#function#}",$functionstr,$FileStr);

		file_put_contents($outmap,$FileStr);
		
		alert_ini();//输出alert所需文件
		echo "<script>alert_go('XML网站地图生成成功！','alert','','ok','?".$back_url."');</script>";//不需要返回参数
		exit;

	}
	?>
	<!--生成XML地图 -->
	
	
</div>


</body>
</html>
