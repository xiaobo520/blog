<?
include_once("./mdaima_var_inc/config_system.php");
$wap_mobile='';
if (isMobile() && $_SESSION["mobile_wap"]!='pc'){
	$wap_mobile='true';
	include_once("wap/jingyan_m_wap.php");
	exit;
}

include_once("./mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("./mdaima_var_inc/conn.php"); 

include_once("./search_all.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>PHP�������-�󵨸粩��</title>
<meta name="description" content="��������6��PHPʵս��������Ļ��ۣ�����ͨ������˵�����֡�����ʾ�����̳���Ƶ������������ԭ����PHP�������鼰��̼��ɣ�" />
<meta name="keywords" content="PHP����,PHP�̳�,PHP,PHP����,PHP�������,PHP��Դ,PHP��̳" />
<meta name="applicable-device" content="pc">
<link href="/style.css" rel="stylesheet" type="text/css" />
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
	<div class="jy_box">
		<!-- ���� ��-->
		<div class="zhengwen_l_2">
			<? 
			
			if (check_null($keyword_search)!='0'){//��ѯ����
				if ($_COOKIE["search_jingdu"]=='1'){//��ȷ
					//*********************************************
					function getfile($ss_str){      
						$array = explode(' ',$ss_str);
						return $array;     
					} 
					
					$word = getfile($keyword_search);
					$length = count($word);
					
					for($iop = 0; $iop < $length; $iop++){  
						$search_for=$search_for."title like '%".$word[$iop]."%' or ";//�����ִ�
						$if_count.="if(instr(title, '".addslashes($word[$iop])."'),1,0)+"; //�ؼ����������
					}
					
					$search_for=substr($search_for,0,-3);
					$if_count=substr($if_count,0,-1)." as count"; //�ؼ���������� ����
					$title_str=" and ( ".$search_for." )";
					$search_count_num++;
					
					$search_score='';//ǿ�����
					$px_search='';
					//**********************************************
				}else{	
					$keyword_start =$keyword_search;//��¼ԭʼ������
					$keyword_search=keyword_replace($keyword_search);//�滻keyword
					$splitnum_new = quweima($keyword_search);//תΪ��������������λ������
					
					$search_score=",MATCH(title_code) AGAINST ('".$splitnum_new."' IN BOOLEAN MODE) AS countscore";//����select�ֶ�
					$search_for="MATCH(title_code) AGAINST ('".$splitnum_new."' IN BOOLEAN MODE) ";
					
					$px_search='title';//ǿ���������  ��������������������
		
					$title_str=" and ( ".$search_for." )";
					$search_count_num++;
				}
				
			}else{
				$title_str="";
			}

			if ($_SESSION['blog_lileiuser']!="" && $_REQUEST['see']=='true'){//Ϊ��̨Ԥ��Ч��׼��
				$pass_str=" 1=1 ";
			}else{
				$pass_str=" pass='1' ";
			}
			
			if ($px_search=='title'){//�������ѯ��������
				$px_str=" order by countscore desc ";
			}else{//�걨ʱ�䣨����
				$px_str=" order by zhiding desc,indate desc ";
				
			}
			
			$sql_page="select count(*) from lei_jingyan where ".$pass_str." ".$title_str." ";
			
			
			$result_page=$mysqli->query($sql_page);
			$rs_page=$result_page->fetch_array();
			$pagenum=8;   //ÿҳ��ʾ����
			$pageidcount=$rs_page[0];
			$allnum=ceil($rs_page[0]/$pagenum);//��ҳ��
			
			if($page=="") $page=1;
			if($page<=1) $page=1;
			if($page>=$allnum)$page=$allnum;//��Ϊpage�Ǵ�0��ʼ�ģ�����Ҫ-1
			$pagestart=($page-1)*$pagenum;
			if($pagestart<=0) $pagestart=0; 
	
			$sql_search="select id,title,laiyuan,indate,hits,pass,keyword,shipin,zhiding,simgpaths,message".$search_score." from lei_jingyan where ".$pass_str." ".$title_str." ".$px_str." limit ".$pagestart.",".$pagenum." ";
			$i=0;
			$noid_jingyan='';
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			$i++;
				$noid_jingyan=$noid_jingyan."'".$rs["id"]."',";
			?>
			<div class="wen">
				<? if($rs["zhiding"]=='1'){?>
				<div class="span-mark">�ö�</div>
				<? }elseif ($rs["shipin"]!=''){//����?>
				<div class="span-mark span-mark-blue">��Ƶ</div>
				<? }elseif($rs["hits"]>=1000){?>
				<div class="span-mark">����</div>
				<? }?>
				<div class="news_title"><a href="/jingyan/<?=$rs["id"]?>.html" target="_blank"><img src="<?=str_replace('../','/',$rs["simgpaths"])?>" width="180" height="130" border="0" id="jingyan_img_<?=$rs["id"]?>" /></a></div>
				<div class="wen_box">
					<?
					if ($_COOKIE["search_jingdu"]!='1' && $_COOKIE["search_jingdu"]!='0'){//�жϾ���cookie�Ƿ���ֵ��֧�֣��ݴ��ж�
						$cookie_jingdu='0';
					}else{
						$cookie_jingdu=$_COOKIE["search_jingdu"];
					}
					?>
					<div class="title"><a href="/jingyan/<?=$rs["id"]?>.html" target="_blank" id="jingyan_title_<?=$rs["id"]?>"><?=keywordlight($keyword_search,$rs["title"],$cookie_jingdu);?></a></div>
					<div class="miaoshu" id="jingyan_miaoshu_<?=$rs["id"]?>"><?=mysubstr(clear_all($rs["message"]),0,105, 'gbk')?></div>
					<div class="ms_info">
						<div class="ms_web"><i class="icon-fire"></i> <?=$rs["laiyuan"]?></div>
						
						<div class="ms_date"><?=time_show($rs["indate"])?></div>
						<? if ($rs["shipin"]!=''){?>
						<div class="ms_time"><i class="icon-time"></i> ʱ����<?=$rs["shipin"]?></div>
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
						<? }?>
						
						<div class="ms_share">
							<div class="bds_qzone_2_16" onclick="share_list('qzone','jingyan','<?=$rs["id"]?>')" ></div>
							<div class="bds_tsina_2_16" onclick="share_list('tsina','jingyan','<?=$rs["id"]?>')"></div>
							<div class="bds_tqq_2_16" onclick="share_list('tqq','jingyan','<?=$rs["id"]?>')"></div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="title_hr"></div>
			
			<? }?>
			<div class="clear"></div>
			
			<!--����ҳ�� -->
			<? include_once("./v_i_page.php")?>
			<!--����ҳ�� END-->
			
			<div class="clear"></div>
			
		</div>
		<!-- ���� �� end -->
		
		<!-- ���� ��-->
		<? include_once("./art_right.php"); ?>
		<!-- ���� �� end -->
		
	</div>
	<!-- ����box end -->
	
	
	<div class="clear" style="height:15px;"></div>
	
	</div>
	<!-- ��BOX end -->


<!--��Ȩ -->
<div class="clear"></div>
<? include_once("./index_foot.php"); ?>
<!--��Ȩ -->

</body>
</html>
