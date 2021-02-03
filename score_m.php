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
<title>会员中心-码代码-李雷博客</title>
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
                          <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;积分类型：
                            <select name="leixing_search" id="leixing_search" class="select_2">
                              <option value="" <? if ($leixing_search=='' ){?>selected="selected"<? }?> >全部</option>
                              <option value="denglujiangli" <? if ($leixing_search=='denglujiangli'){?>selected="selected"<? }?> >登录奖励</option>
                              <option value="sharejiangli" <? if ($leixing_search=='sharejiangli'){?>selected="selected"<? }?> >分享奖励</option>
                              <option value="huitie" <? if ($leixing_search=='huitie'){?>selected="selected"<? }?> >回帖奖励</option>
                              <option value="pintu" <? if ($leixing_search=='pintu'){?>selected="selected"<? }?> >拼图游戏奖励</option>
							  <option value="qita" <? if ($leixing_search=='qita'){?>selected="selected"<? }?> >其它</option>
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
				    <td width="10%" align="center" bgcolor="#F9F9F9"><strong>序号</strong></td>
                    <td width="30%" height="45" align="center" bgcolor="#F9F9F9"><strong>积分类型</strong></td>
                    <td width="30%" height="45" align="center" bgcolor="#F9F9F9"><strong>积分</strong></td>
                    <td width="30%" height="45" align="center" bgcolor="#F9F9F9"><strong>积分时间</strong></td>
                  </tr>
				  </thead>
			<?
			
			if($date1_search=='' || $date2_search==''){//操作日期
				$indate_str='';
			}else{
				$indate_str=" and intime >= '".$date1_search." 00:00:00' and intime <= '".$date2_search." 23:59:59'  ";
			}

			if($leixing_search==''){
				$zhuangtai_str='';
			}else{
				$zhuangtai_str=" and leixing = '".$leixing_search."' ";
			}
			
			$sql_where=$indate_str.$zhuangtai_str;
			
			$sql_page="select count(*) from lei_jifen where username='".$_SESSION['user_lei_username']."' ".$sql_where." order by id desc ";
			
			
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
	
			$sql_search="select id,intime,jifen,leixing,bz from lei_jifen where username='".$_SESSION['user_lei_username']."' ".$sql_where." order by id desc limit ".$pagestart.",".$pagenum." ";
			$i=0;
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			$i++;
				if ($rs["leixing"]=='denglujiangli'){
					$leixing_str='登录奖励';
				}elseif ($rs["leixing"]=='sharejiangli'){
					$leixing_str='分享奖励';
				}elseif ($rs["leixing"]=='huitie'){
					$leixing_str='回帖奖励';
				}elseif ($rs["leixing"]=='pintu'){
					$leixing_str='拼图游戏奖励';
				}elseif ($rs["leixing"]=='qita'){
					$leixing_str='其它';
				}else{
					$leixing_str='--';
				}
			?>
                  <tr class="table_tr_hover">
                    <td width="10%" align="center" bgcolor="#FFFFFF"><?=$i+$pagestart?></td>
                    <td width="30%" height="45" align="center" bgcolor="#FFFFFF"><span title="<?=$rs["bz"]?>"><?=$leixing_str?></span></td>
                    <td width="30%" height="45" align="center" bgcolor="#FFFFFF"><?=$rs["jifen"]?> 分</td>
                    <td width="30%" height="45" align="center" bgcolor="#FFFFFF"><?=$rs["intime"]?></td>
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
	$("#mytable").tablesorter({  headers:{  1:{sorter:true}  }  });
</script>
<!--表格排序END -->
<? include_once("./index_foot.php"); ?>
<!--版权 -->



</body>
</html>
