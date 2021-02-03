<?
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");
include_once("./mdaima_var_inc/checkall_home.php");
include_once("./dh_config.php");


$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
$action=$url_info['action'];
$page=$url_info['page'];//跳转页码

$leixing_search=quotes_gpc_pd($_POST['leixing_search'],1);
$date1_search=quotes_gpc_pd($_POST['date1_search'],1);
$date2_search=quotes_gpc_pd($_POST['date2_search'],1);

if ($leixing_search=='' ) $leixing_search=$url_info['leixing_search'];
if ($date1_search=='' ) $date1_search=$url_info['date1_search'];
if ($date2_search=='' ) $date2_search=$url_info['date2_search'];

$pageurl_home="&action_pd=".$action_pd."&leixing_search=".$leixing_search."&date1_search=".$date1_search."&date2_search=".$date2_search."&pagenums_search=".$pagenums_search;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员中心-大胆哥博客</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/lx.js"></script>
<script language="javascript" type="text/javascript" src="/js/my97datepicker/WdatePicker.js"></script>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
</head>

<body>

<? include_once("./index_top.php"); ?>
	
	<!-- 大BOX开始 -->
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
                  <td width="70%" height="32" align="right"><a href="/" class="a1">首页</a> &gt;&gt; 会员中心&nbsp;&nbsp;</td>
                </tr>
              </table>
			  </td>
            </tr>
			<tr>
              <td height="12" background="/images/dw2.jpg"></td>
            </tr>
            <tr>
              <td valign="top">
			  
			  <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">
                  <tr>
                    <td align="left">
					<form id="form1" name="form1" method="post" action="?<?=encrypt_url("action=search"."&time=".time(),$key_url_md_5)?>">
					
					
                      <table width="29%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td nowrap="nowrap">日期：
                            <input name="date1_search" type="text" class="input length_7" id="date1_search" value="<?=$date1_search?>" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onfocus="WdatePicker({skin:'twoer'})" readonly="true"/>
-
<input name="date2_search" type="text" class="input length_7" id="date2_search" value="<?=$date2_search?>" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onfocus="WdatePicker({skin:'twoer'})" readonly="true"/></td>
                          <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;版块分类：
                            <select name="leixing_search" id="leixing_search" class="select_2">
                              <option value="1" <? if ($leixing_search=='1' || $leixing_search==''){?>selected="selected"<? }?> >PHP经验分享</option>
                              <option value="2" <? if ($leixing_search=='2'){?>selected="selected"<? }?> >随手记</option>
                              <option value="3" <? if ($leixing_search=='3'){?>selected="selected"<? }?> >关于博主</option>
                            </select></td>
                          <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn_submit" type="submit">搜索</button></td>
                        </tr>
                      </table>
                      </form>
                    </td>
                  </tr>
                </table>
				
				
                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#EAEAEA" style="margin-top:5px;" id="mytable">
                  <thead>
				  <tr>
				    <td width="8%" align="center" bgcolor="#F9F9F9"><strong>序号</strong></td>
                    <td width="74%" height="45" align="center" bgcolor="#F9F9F9"><strong>博文标题 / </strong><strong>回复内容</strong></td>
                    <td width="18%" height="45" align="center" bgcolor="#F9F9F9"><strong>回复时间</strong></td>
                  </tr>
				  </thead>
			<?
			
			if($date1_search=='' || $date2_search==''){//操作日期
				$indate_str='';
			}else{
				$indate_str=" and indate >= '".$date1_search." 00:00:00' and indate <= '".$date2_search." 23:59:59'  ";
			}
			
			if ($leixing_search=='1'){ //更新主题表及回复表判定
				$answtalbe="lei_jingyan";
				$answtalbe_an="lei_jingyan_hf";
				$answtalbe_mulu="/jingyan/";
			}elseif ($leixing_search=='2'){
				$answtalbe="lei_news";
				$answtalbe_an="lei_news_hf";
				$answtalbe_mulu="/news/";
			}elseif ($leixing_search=='3'){
				$answtalbe="lei_message";
				$answtalbe_an="lei_message_hf";
				$answtalbe_mulu="/lilei-";
			}else{
				$answtalbe="lei_jingyan";
				$answtalbe_an="lei_jingyan_hf";
				$answtalbe_mulu="/jingyan/";
			}
			
			$sql_where=$indate_str;
			
			$sql_page="select count(*) from ".$answtalbe_an." where username='".$_SESSION['user_lei_username']."' ".$sql_where." order by id ";
			
			
			$result_page=$mysqli->query($sql_page);
			$rs_page=$result_page->fetch_array();
			$pagenum=10;   //每页显示条数
			$pageidcount=$rs_page[0];
			$allnum=ceil($rs_page[0]/$pagenum);//总页数
			
			if($page=="") $page=1;
			if($page<=1) $page=1;
			if($page>=$allnum)$page=$allnum;//因为page是从0开始的，所以要-1
			$pagestart=($page-1)*$pagenum;
			if($pagestart<=0) $pagestart=0; 
	
			$sql_search="select id,cid,content,indate,pass from ".$answtalbe_an." where username='".$_SESSION['user_lei_username']."' ".$sql_where." order by id desc limit ".$pagestart.",".$pagenum." ";
			$i=0;
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			$i++;

				$sql1="select * from ".$answtalbe." where id='".$rs["cid"]."' limit 1 ";
				$result1=$mysqli->query($sql1);
				if($rs1=$result1->fetch_assoc()){
					$title=$rs1["title"];
				}else{
					$title='未知';
				} 
			?>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF" <? if ($rs["pass"]=='0'){?> style=" background: #FF9900;color:#FFFFFF; font-weight:bold;" title="审核中"<? }?>><?=$i+$pagestart?></td>
                    <td height="45" align="left" bgcolor="#FFFFFF" style="padding:10px 10px; line-height:25px;word-wrap : break-word;word-break : break-all;">
					<a href="<?=$answtalbe_mulu?><?=$rs["cid"]?>.html" target="_blank" style="font-weight:bold;"><?=clear_all($title);?></a><br />
                    <div class="fatie_hover"><?=mysubstr(clear_all($rs["content"]),0,200, 'gbk')?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$answtalbe_mulu?><?=$rs["cid"]?>.html" target="_blank" style="font-weight:bold; color: #0099FF">[详细]</a>
					</div></td>
                    <td height="45" align="center" bgcolor="#FFFFFF"><?=$rs["indate"]?></td>
                  </tr>
            <? }?>
                </table>
			  
              </td>
            </tr>
          </table>
		  
		    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0">
			  <tr>
				<td><? include_once("./v_i_page_home.php"); ?></td>
			  </tr>
			</table>

		  </td>
        </tr>
      </table>
		</div>
		
		<div class="clear" style="height:15px;"></div>
	
	</div>
	<!-- 大BOX end -->


<!--版权 -->
<div class="clear"></div>
<!--表格排序-->
<link href="/css/theme.default.css" rel="stylesheet"><!--表格排序样式 -->
<script language="JavaScript" type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
	$("#mytable").tablesorter({  headers:{  1:{sorter:false}/*, 2:{sorter:false}*/  }  });
</script>
<!--表格排序END -->
<? include_once("./index_foot.php"); ?>
<!--版权 -->



</body>
</html>
