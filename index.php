<?
include_once("./mdaima_var_inc/config_system.php");
$mobile=$_REQUEST["mobile"];
$wap_mobile='';

if($mobile=='pc'){
	$_SESSION["mobile_wap"]='pc';
}

if($mobile=='mobile'){
	$_SESSION["mobile_wap"]='';
}

if (isMobile() && $_SESSION["mobile_wap"]!='pc'){
	$wap_mobile='true';
	include_once("wap/index_wap.php");
	exit;
}


include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php");

$sql_search="delete from lei_read";//��ն�ȡID��������ҳ�������Ƿ�Ϊ�ö�(���ö�����ҳ��Ч)
$mysqli->query($sql_search);

$noid_jingyan="";
$noid_news="";

$sql_search="select id,indate,pass from lei_jingyan where pass='1' order by indate desc limit 10 ";
$result=$mysqli->query($sql_search);
while ($rs=$result->fetch_assoc()){
	$sql_in="insert into lei_read (cid,tables,indate) values ('".$rs["id"]."','lei_jingyan','".$rs["indate"]."') ";
	$mysqli->query($sql_in);
	$noid_jingyan=$noid_jingyan."'".$rs["id"]."',";//���Ȿҳ���ظ�
}

$sql_search="select id,indate,pass from lei_news where pass='1' order by indate desc limit 10 ";
$result=$mysqli->query($sql_search);
while ($rs=$result->fetch_assoc()){
	$sql_in="insert into lei_read (cid,tables,indate) values ('".$rs["id"]."','lei_news','".$rs["indate"]."') ";
	$mysqli->query($sql_in);
	$noid_news=$noid_news."'".$rs["id"]."',";//���Ȿҳ���ظ�
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>PHP����ϵͳ-�ɴ󵨸粩�� www.ubug.icu ��������ѿ�Դ����</title>
<meta name="description" content="PHPPHP����ϵͳ-�ɴ󵨸粩�� www.ubug.icu ��������ѿ�Դ����" />
<meta name="keywords" content="PHP����ϵͳ-�ɴ󵨸粩�� www.ubug.icu ��������ѿ�Դ����" />
<link href="/style.css?v=20151007" rel="stylesheet" type="text/css" />
<meta name="applicable-device" content="pc">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/lx.js"></script>
<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
</head>
<body>
<? include_once("./index_top.php"); ?>
<!-- ��BOX��ʼ -->
<div id="main_box">
	<!-- ����box -->
	<div class="content_box">
		<!-- ���� ��-->
		<div class="zhengwen_l_1">
			<? 
			$i=0;
			$sql_read="select cid,indate,tables from lei_read order by indate desc limit 0,5 ";
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
			<div class="wen">
				<? if($rs["zhiding"]=='1'){//����?>
				<div class="span-mark">�ö�</div>
				<? }elseif($rs["hits"]>=100){?>
				<div class="span-mark">����</div>
				<? }elseif ($rs_read["tables"]=='lei_jingyan'){
						if ($rs["shipin"]!=''){?>
				<div class="span-mark span-mark-blue">��Ƶ</div>
				<? 		}
					}?>
				<div class="news_title"><a href="/<?=$read_mulu?>/<?=$rs["id"]?>.html" target="_blank"><img src="<?=str_replace('../','/',$rs["simgpaths"])?>" width="180" height="130" border="0" id="<?=$read_mulu?>_img_<?=$rs["id"]?>" /></a></div>
				<div class="wen_box">
					<div class="title"><a href="/<?=$read_mulu?>/<?=$rs["id"]?>.html" target="_blank" id="<?=$read_mulu?>_title_<?=$rs["id"]?>">
						<?=$rs["title"]?>
						</a></div>
					<div class="miaoshu" id="<?=$read_mulu?>_miaoshu_<?=$rs["id"]?>">
						<?=mysubstr(clear_all($rs["message"]),0,105, 'gbk')?>
					</div>
					<div class="ms_info">
						<div class="ms_web"><i class="icon-fire"></i>
							<?=$rs["laiyuan"]?>
						</div>
						<div class="ms_date">
							<?=time_show($rs["indate"])?>
						</div>
						<?
						if ($rs_read["tables"]=='lei_jingyan'){
							if ($rs["shipin"]!=''){?>
						<div class="ms_time"><i class="icon-time"></i> ʱ����
							<?=$rs["shipin"]?>
						</div>
						<? }else{?>
						<div class="ms_tags">
							<?
								$keyword = str_replace("-",'',$rs["keyword"]);//����ַ���  -1-,-12-,-5-��Ϊ 1,12,5
								$keyword_array=explode(',',$keyword);
								$keyword_str='';
								for ($b=0;$b<count($keyword_array);$b++){
									$sql_search2="select * from lei_keyword where id='".$keyword_array[$b]."' order by px";
									$result2=$mysqli->query($sql_search2);
									while ($rs2=$result2->fetch_assoc()){
										$keyword_str.=$rs2["keyword"]."<span></span>";
									}
								}
								if ($keyword_str!=''){
									echo substr($keyword_str,0,-13);
								}
								?>
						</div>
						<? 	}
						}?>
						<div class="ms_share">
							<div class="bds_qzone_2_16" onclick="share_list('qzone','<?=$read_mulu?>','<?=$rs["id"]?>')" ></div>
							<div class="bds_tsina_2_16" onclick="share_list('tsina','<?=$read_mulu?>','<?=$rs["id"]?>')"></div>
							<div class="bds_tqq_2_16" onclick="share_list('tqq','<?=$read_mulu?>','<?=$rs["id"]?>')"></div>
						</div>
					</div>
				</div>
			</div>
			<? if ($i<5){?>
			<div class="title_hr"></div>
			<? }?>
			<? }
			}
			?>
			<div class="clear"></div>
		</div>
		<!-- ���� �� end -->
		<!-- ���� ��-->
		<div class="right_box">
			<div class="right_small">
				<div class="right_tag"><i class="icon-th-large"></i>&nbsp;&nbsp;��Ծ����</div>
				<div class="tuijian_img">
					<?
			$sql_search="select * from lei_huoyue order by indate desc limit 10 ";
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			?>
					<div><img src="<?=$rs["xuan_img"]?>" title="�ǳƣ�<?=$rs["nicheng"].CHR(13)."�����Ծ��".$rs["indate"]?>" class="hf_img_f_tuijian" /></div>
					<? }?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="right_small">
				<div class="right_tag"><i class="icon-tasks"></i>&nbsp;&nbsp;WEBǰ��</div>
				<div class="tuijian">
					<ul>
						<?
			
			$noid_jingyan=substr($noid_jingyan,0,-1);
			$sql_search="select id,title from lei_jingyan where pass='1' and id not in (".$noid_jingyan.") order by id desc limit 10 ";
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			?>
						<li>��&nbsp;&nbsp;<a href="/jingyan/<?=$rs["id"]?>.html" target="_blank" title="<?=$rs["title"]?>"><?=clear_all($rs["title"])?></a></li>
						<? }?>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			
			
			<div class="right_small" style="margin-bottom:0;">
				<div class="right_tag"><i class="icon-tasks"></i>&nbsp;&nbsp;������������</div>
				<div class="tuijian">
					<div class="tuijian_pinglun">
						<?
						$sql_search="select * from lei_news_hf where pass='1' union all select * from lei_jingyan_hf where pass='1' union all select * from lei_message_hf where pass='1' order by indate desc limit 10 ";
						$result=$mysqli->query($sql_search);
						while ($rs=$result->fetch_assoc()){
						?>
							<div class="pl_box">
								<div class="pl_nicheng"><img src="<?=$rs["xuan_img"]?>-S" /> <?=clear_all($rs["nicheng"])?></div>
								<div class="pl_message"><?=clear_all($rs["content"])?></div>
							</div>
						<? }?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			
			
			
		</div>
		<!-- ���� �� end -->
	</div>
	<!-- ����box end -->
	<div class="clear"></div>
	<div class="ad_1"><a href="https://www.ubug.icu/host/" target="_blank"><img src="/images/ad/ad_1.jpg" width="1080" height="100" /></a></div>
	<div class="clear"></div>
	<!-- ����box -->
	<div class="jy_box">
		<!-- ���� ��-->
		<div class="zhengwen_l_2">
			<? 
			$sql_read="select cid,indate,tables from lei_read order by indate desc limit 5,5 ";
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
			<div class="wen">
				<? if($rs["zhiding"]=='1'){//����?>
				<div class="span-mark">�ö�</div>
				<? }elseif($rs["hits"]>=100){?>
				<div class="span-mark">����</div>
				<? }elseif ($rs_read["tables"]=='lei_jingyan'){
						if ($rs["shipin"]!=''){?>
				<div class="span-mark span-mark-blue">��Ƶ</div>
				<? 		}
					}?>
				<div class="news_title"><a href="/<?=$read_mulu?>/<?=$rs["id"]?>.html" target="_blank"><img src="<?=str_replace('../','/',$rs["simgpaths"])?>" width="180" height="130" border="0" id="<?=$read_mulu?>_img_<?=$rs["id"]?>" /></a></div>
				<div class="wen_box">
					<div class="title"><a href="/<?=$read_mulu?>/<?=$rs["id"]?>.html" target="_blank" id="<?=$read_mulu?>_title_<?=$rs["id"]?>">
						<?=$rs["title"]?>
						</a></div>
					<div class="miaoshu" id="<?=$read_mulu?>_miaoshu_<?=$rs["id"]?>">
						<?=mysubstr(clear_all($rs["message"]),0,105, 'gbk')?>
					</div>
					<div class="ms_info">
						<div class="ms_web"><i class="icon-fire"></i>
							<?=$rs["laiyuan"]?>
						</div>
						<div class="ms_date">
							<?=time_show($rs["indate"])?>
						</div>
						<?
						if ($rs_read["tables"]=='lei_jingyan'){
							if ($rs["shipin"]!=''){?>
						<div class="ms_time"><i class="icon-time"></i> ʱ����
							<?=$rs["shipin"]?>
						</div>
						<? 
							}else{?>
						<div class="ms_tags">
							<?
								$keyword = str_replace("-",'',$rs["keyword"]);//����ַ���  -1-,-12-,-5-��Ϊ 1,12,5
								$keyword_array=explode(',',$keyword);
								$keyword_str='';
								for ($b=0;$b<count($keyword_array);$b++){
									$sql_search2="select * from lei_keyword where id='".$keyword_array[$b]."' order by px";
									$result2=$mysqli->query($sql_search2);
									while ($rs2=$result2->fetch_assoc()){
										$keyword_str.=$rs2["keyword"]."<span></span>";
									}
								}
								if ($keyword_str!=''){
									echo substr($keyword_str,0,-13);
								}
								?>
						</div>
						<? 	}
						}?>
						<div class="ms_share">
							<div class="bds_qzone_2_16" onclick="share_list('qzone','<?=$read_mulu?>','<?=$rs["id"]?>')" ></div>
							<div class="bds_tsina_2_16" onclick="share_list('tsina','<?=$read_mulu?>','<?=$rs["id"]?>')"></div>
							<div class="bds_tqq_2_16" onclick="share_list('tqq','<?=$read_mulu?>','<?=$rs["id"]?>')"></div>
						</div>
					</div>
				</div>
			</div>
			<? if ($i<10){?>
			<div class="title_hr"></div>
			<? }?>
			<? }
			}
			?>
			<div class="clear"></div>
		</div>
		<!-- ���� �� end -->
		<!-- ���� ��-->
		<div class="right_box">
			<div class="right_small">
				<div class="bozhu"><i class="icon-gift"></i>&nbsp;&nbsp;���ֻ</div>
				<div class="jifen"> <a href="/host/" target="_blank"><img src="/images/ad/ad_2.gif" width="260" height="260" /></a> </div>
				<div class="clear"></div>
			</div>
			<div class="right_small">
				<div class="right_tag"><i class="icon-question-sign"></i>&nbsp;&nbsp;���ּ�</div>
				<div class="tuijian">
					<ul>
						<?
			
			$noid_news=substr($noid_news,0,-1);
			$sql_search="select id,title from lei_news where pass='1' and id not in (".$noid_news.") order by id desc limit 8 ";
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			?>
						<li>��&nbsp;&nbsp;<a href="/news/<?=$rs["id"]?>.html" target="_blank" title="<?=$rs["title"]?>">
							<?=clear_all($rs["title"])?>
							</a></li>
						<? }?>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="right_small">
				<div class="right_tag"><i class="icon-share"></i>&nbsp;&nbsp;��ע����</div>
				<div class="bd_shbox">
					<div class="bds_qzone_0_32" onclick="share_mdaima('qzone','','','','')" ></div>
					<div class="bds_tsina_0_32" onclick="share_mdaima('tsina','','','','')"></div>
					<div class="bds_tqq_0_32" onclick="share_mdaima('tqq','','','','')"></div>
					<div class="bds_renren_0_32" onclick="share_mdaima('renren','','','','')"></div>
					<div class="bds_weixin_0_32" onclick="share_mdaima('weixin','','','','')"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="right_small" style="margin-bottom:0;">
				<div class="bozhu"><i class="icon-leaf"></i>&nbsp;&nbsp;��ϵ����</div>
				<div class="bozhu_lx"> <span>QQ��</span><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1274148741&site=qq&menu=yes">1274148741</a>&nbsp;&nbsp;&nbsp;<span>����΢�źţ�</span>xb95556
					<div class="qrcode"><img src="/images/mdaima.jpg" width="180" height="178" /></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<!-- ���� �� end -->
	</div>
	<!-- ����box end -->
	<div class="clear" style="height:15px;"></div>
</div>
<!-- ��BOX end -->
<!--��Ȩ -->
<div class="clear"></div>
<input id="src_hide" name="src_hide" type="hidden" value="2" />
<script>pintu();//Ĭ��ͼ�ı�� 255*255</script>
<?
$link_index='true';//��ʾ�������ӱ��
?>
<? include_once("./index_foot.php"); ?>
<!--��Ȩ -->
</body>
</html>
