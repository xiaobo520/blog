<?
include_once("./mdaima_var_inc/config_system.php");
$wap_mobile='';
if (isMobile() && $_SESSION["mobile_wap"]!='pc'){
	$wap_mobile='true';
	include_once("wap/news_show_wap.php");
	exit;
}

include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");

$cid=$_REQUEST["id"];
$page_1=$_REQUEST["page_1"];

if ($_SESSION['blog_lileiuser']!="" && $_REQUEST['see']=='true'){//为后台预览效果准备
	$pass_str="";
}else{
	$pass_str=" and pass='1' ";
}

$sql="select * from lei_news where id='".$cid."' ".$pass_str." limit 1 ";
$result=$mysqli->query($sql);
if($rs=$result->fetch_assoc()){
	$title=$rs["title"];
	$indate=$rs["indate"];
	$laiyuan=$rs["laiyuan"];
	$guanjianci=$rs["guanjianci"];
	$simgpaths=$rs["simgpaths"];
	$hits=$rs["hits"]+1;
	$message=$rs["message"];
	$pass=$rs["pass"];
	$pinglun=$rs["pinglun"];
}else{
	echo "文章不存在！";
	$mysqli->close();
	exit;
} 

$sql="update lei_news set hits='".$hits."' where id='".$cid."' limit 1";//更新访问人数
$mysqli->query($sql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$title?>-码代码-大胆哥博客</title>
<meta name="Keywords" content="<?=$guanjianci?>">
<meta name="description" content="<?=mysubstr(clear_all($message),0,120, 'gbk')?>" />
<meta name="applicable-device" content="pc">
<link href="/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/lx.js"></script>
<script type="text/javascript" src="/js/answer.js" ></script>
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
		<div class="zhengwen_l_3">
			<div class="zhengwen_l_2">

				<div class="art_box">
					<h1 id="content_title"><?=$title?></h1>
					<div id="content_info">
						<div class="content_right" style="margin-top:31px;">
							<div class="bds_qzone_1_16" onclick="share_art('qzone')" ></div>
							<div class="bds_tsina_1_16" onclick="share_art('tsina')"></div>
							<div class="bds_tqq_1_16" onclick="share_art('tqq')"></div>
						</div>
						<div class="content_right"><i class="icon-time"></i> 更新：<?=$indate?></div>
						<div class="content_right"><i class="icon-eye-open"></i> 人气：<?=$hits?></div>
						<div class="content_right content_clear"><i class="icon-leaf"></i> 来源：<?=$laiyuan?></div>
						<div class="content_font" id="content_font">A+</div>
					</div>
					<div class="content_art">
						<?=$message?>
						<div class="clear"></div>
						
						<!--扫码打赏 -->
						<? include_once("./dashang.php"); ?>
						<!--扫码打赏 -->
						
						<div class="zhuanzai">转载请注明：<a href="https://<?=$var_domain?>/news/<?=$cid?>.html" ><?=$title?> | 码代码-大胆哥博客</a></div>
					</div>
				</div>
				
				<div class="clear"></div>
				
				<div class="content_gltitle">推荐的文章</div>
				<?
				$sql_search="select id,title from lei_news where pass='1' and id<>'".$cid."' order by rand() limit 4 ";
				$result=$mysqli->query($sql_search);
				$noid_news="'".$cid."',";
				while ($rs=$result->fetch_assoc()){
					$noid_news=$noid_news."'".$rs["id"]."',";
				?>
				<div class="content_guanlian"><i class="icon-chevron-right"></i> <a href="/news/<?=$rs["id"]?>.html" target="_blank" title="<?=$rs["title"]?>"><?=$rs["title"]?></a></div>
				<? }
				?>
				<div class="clear"></div>
				
				
			</div>
			
			
			<div class="clear"></div>
		<?
		if ($pinglun=='1'){//判断是否开启了评论
		?>
			<div class="zhengwen_l_3_1" id="fb_pinglun">
				<a name="pinglun_step" id="pinglun_step"></a>
				<div class="content_hf"><div style="float:left;font-weight:bold;font-size:16px;"># 发表我的评论</div><div id="second_hf"></div></div>
				<div class="hf_input">
					<script id="hf_box" name="hf_box" type="text/plain" style="height:100px; width:100%;"></script>
				</div>
				<div class="clear"></div>
				<div class="hf_button">
					<?
					if ($_SESSION['user_lei_username']!=""){
						$xuan_img=$userimg_sess;
					?>
						<div style="float:left">
							<img src="<?=$userimg_sess?>" class="hf_img"/>
						</div>
						<div class="hf_dluser">
							<div id="codeimg"><img id="refresh" src="/get_code.php" style="cursor:pointer"></div>
							<?=$nicheng_sess?>&nbsp;&nbsp;/&nbsp;&nbsp;<?=$_SESSION['user_lei_username']?>&nbsp;&nbsp;/&nbsp;&nbsp;<input name="code" type="text" class="hf_nc hf_nc_code" id="code" value="" size="4" maxlength="4" placeholder="验证码" autocomplete="off"/>
							<input name="nicheng" id="nicheng" type="hidden" value="<?=$nicheng_sess?>" />
							<input name="email" id="email" type="hidden" value="<?=$_SESSION['user_lei_username']?>" />
							<script>
								$('#code').placeholder();
								$("#code").click(function(){
									$("#codeimg").fadeIn();
									$("#question_statu").hide();
								});
								$("#refresh").click(function(){
									document.getElementById('refresh').src='/get_code.php?t='+Math.random();
									//$("#codeimg").fadeIn();
								});
							</script>
						</div>
					<? 
					}else{
						$touxiang_first='';
						for ($ti=1;$ti<26;$ti++){
							$touxiang_first=$touxiang_first.",".$ti;
						}
						$touxiang_first=substr($touxiang_first,1);
						$touxiang_rand=explode(',',$touxiang_first);
						shuffle($touxiang_rand);//打乱数组
						$xuan_img="/images/touxiang/".$touxiang_rand[0].".jpg";
					?>
						<div style="float:left">
							<img src="<?=$xuan_img?>" class="hf_img"/>
						</div>
						<div class="hf_dluser">
							<div id="codeimg"><img id="refresh" src="/get_code.php" style="cursor:pointer"></div>
							<input name="nicheng" type="text" class="hf_nc hf_nc_nc" id="nicheng" value="<?=$_COOKIE["yk_mdaima_nicheng"]?>" size="15" placeholder="请输入昵称" maxlength="10" />
							&nbsp;&nbsp;/&nbsp;&nbsp;<input name="email" type="text" class="hf_nc" id="email" value="<?=$_COOKIE["yk_mdaima_email"]?>" size="30" placeholder="请输入邮箱" />
							&nbsp;&nbsp;/&nbsp;&nbsp;<input name="code" type="text" class="hf_nc hf_nc_code" id="code" value="" size="4" maxlength="4" placeholder="验证码" autocomplete="off"/>
							<script>
								$('#nicheng,#code,#email').placeholder();
								$("#code").click(function(){
									$("#codeimg").fadeIn();
									$("#question_statu").hide();
								});
								$("#refresh").click(function(){
									document.getElementById('refresh').src='/get_code.php?t='+Math.random();
									//$("#codeimg").fadeIn();
								});
								/*$("#code").blur(function(){
									$("#codeimg").fadeOut();
								});*/
								
							</script>
						</div>
					<? }?>
					
					<div id="question_statu"></div>
					 
					<div style="float:right">
						<input name="cid" id="cid" type="hidden" value="<?=$cid?>" />
						<input name="xuan_img" id="xuan_img" type="hidden" value="<?=$xuan_img?>" />
						<input name="hfindate" id="hfindate" type="hidden" value="<?=date("Y-m-d")?>" />
						<input name="atab" id="atab" type="hidden" value="2" />
						<input name="answer" id="answer" type="button" value="<? if ($_SESSION['user_lei_username']==''){echo '免注册，快速评论';}else{?>发表评论<? }?>" class="pinglun_submit blue" onclick="answer()" />
					</div>
				</div>
				<div class="clear"></div>
				
				
			</div>
			
			<div class="clear"></div>
			
			
			<div class="zhengwen_l_3_1">
				<a name="huifu" id="huifu"></a>
				<div class="content_hf"># 最近评论</div>
				<div class="hf_button">
				<div id="huifubox">
					<?
					$sql_1="select count(*) from lei_news_hf where cid='".$cid."' and cid_hf='' and pass='1' ";
					$result_1=$mysqli->query($sql_1);
					$rs_page_1=$result_1->fetch_array();
					$pagenum_1=$var_huitie_list;   //每页显示条数
					$pageidcount_1=$rs_page_1[0];
					$allnum_1=ceil($rs_page_1[0]/$pagenum_1);//总页数
					
					if($page_1=="") $page_1=1;
					if($page_1<=1) $page_1=1;
					if($page_1>=$allnum_1)$page_1=$allnum_1;//因为page是从0开始的，所以要-1
					$pagestart_1=($page_1-1)*$pagenum_1;
					if($pagestart_1<=0) $pagestart_1=0; 
			
					$sql_2="select * from lei_news_hf where cid='".$cid."' and cid_hf='' and pass='1' order by id limit ".$pagestart_1.",".$pagenum_1." ";
					$iloi=0;
					$result_2=$mysqli->query($sql_2);
					while ($rs_2=$result_2->fetch_assoc()){
					$iloi++;
					?>
						<div id="pinglun_big_box">
							<div style="float:left; width:60px; text-align:left">
								<img src="<?=$rs_2["xuan_img"]?>" class="hf_img"/>
							</div>
							<div class="pinglun_usertitle">
								<div class="hf_user_info">
									<div class="hf_uandd">
									<? if (substr($rs_2["username"],0,7)=='mdaima#'){
										$vip_str='';
									}else{
										if ($rs_2["username"]=='mdaima@126.com'){
											$vip_str="<span class='col_bz'>V</span>";
										}else{
											$vip_str="<span class='col_pt'>V</span>";
										}
									}?>
									<?=$rs_2["nicheng"]?> <?=$vip_str?><span>&nbsp;&nbsp;/&nbsp;&nbsp;<?=time_show($rs_2["indate"])?></span>
									</div>
									<div class="hf_click"><a href="javascript:void(0);" onclick="second_hf('<?=$rs_2["id"]?>','<?=$rs_2["nicheng"]?>','<?=passport_encrypt($rs_2["username"],$key_str_md_5)?>')">回复<?=$iloi?>楼</a></div>
								</div>
								<div class="hf_message">
									<?=$rs_2["content"]?>
									
									<!--回复中是否有被评论的 二级评论-->
									<?
									$sql_4="select count(*) from lei_news_hf where cid_hf='".$rs_2["id"]."' and pass='1' ";
									$result_4=$mysqli->query($sql_4);
									$rs_page_4=$result_4->fetch_array();
									$pageidcount_4=$rs_page_4[0];
									if ($pageidcount_4>0){ //检查是否有回复
									?>
										<div class="hf_hf_two_list" >
										<?
										$sql_3="select * from lei_news_hf where cid_hf='".$rs_2["id"]."' and pass='1' order by id limit 0,5";
										$iloi3=0;
										$result_3=$mysqli->query($sql_3);
										while ($rs_3=$result_3->fetch_assoc()){
											$iloi3++;
											
											if ($iloi3!=1){//第一行的时候不显示这条横线?>
											<div class="hf_top_line"></div>
											<? 
											} ?>
											
											<div id="hf_hf_two">
												<div style="float:left; width:60px; text-align:left">
													<img src="<?=$rs_3["xuan_img"]?>" class="hf_img_f"/>
												</div>
												<div class="twoc">
													<div class="hf_user_info">
														<div class="hf_uandd">
														<? if (substr($rs_3["username"],0,7)=='mdaima#'){
															$vip_str='';
														}else{
															if ($rs_3["username"]=='mdaima@126.com'){
																$vip_str="<span class='col_bz'>V</span>";
															}else{
																$vip_str="<span class='col_pt'>V</span>";
															}
														}?>
														<?=$rs_3["nicheng"]?> <?=$vip_str?> <span style="font-size:14px; color: #999999">&nbsp;&nbsp;回复&nbsp;&nbsp;</span> <span style="font-size:14px; color: #009966; font-weight:bold;"><?=$rs_3["cid_str"]?></span><span>&nbsp;&nbsp;/&nbsp;&nbsp;<?=time_show($rs_3["indate"])?></span>
														</div>
														<div class="hf_click fulou"><a href="javascript:void(0);" onclick="second_hf('<?=$rs_2["id"]?>','<?=$rs_3["nicheng"]?>','<?=passport_encrypt($rs_3["username"],$key_str_md_5)?>')"> 回复-<?=$iloi3?>楼</a></div>
													</div>
													
													<div class="hf_message">
														<?=$rs_3["content"]?>
													</div>
												</div>
												<div class="clear"></div>
											</div>
											
										<? } 
											if ($pageidcount_4>5){ //超过5条显示查看 更多按钮?>
												<div id="more_line_<?=$rs_2["id"]?>" class="hf_top_line"></div>
												<div id="more_ans_show_<?=$rs_2["id"]?>"></div>
												<div id="more_ans_<?=$rs_2["id"]?>"></div>
												<div id="more_button_<?=$rs_2["id"]?>" class="more_button"><span onclick="more_answer('<?=$rs_2["id"]?>')">查看全部评论（还有条 <?=$pageidcount_4-5?> 评论）...</span></div>
												
											<? }?>
											
											<div id="hf_two_<?=$rs_2["id"]?>"></div><? //有二次回复的box?>
											<input name="meiyoubox_lou_<?=$rs_2["id"]?>" id="meiyoubox_lou_<?=$rs_2["id"]?>" type="hidden" value="yes" />
										</div>
										
									<? }else{ //一条二级回复都没有情况下，要先制定格式
									?>
										<div class="hf_hf_two_list" id="meiyoubox_<?=$rs_2["id"]?>" style="display:none;" >
											<input name="meiyoubox_lou_<?=$rs_2["id"]?>" id="meiyoubox_lou_<?=$rs_2["id"]?>" type="hidden" value="no" />
											<div id="hf_two_<?=$rs_2["id"]?>"></div>
										</div>
									<? }?>	
									<!--回复中是否有被评论的 END-->
									
								</div>
								
							</div>
						</div>
						
						<div class="hf_line"></div>
						<div class="clear"></div>
					<? }?>
				</div>
				
					<input name="gid" id="gid" type="hidden" value="" />
					<input name="guser" id="guser" type="hidden" value="" />
					<input name="gemail" id="gemail" type="hidden" value="" />
					<input name="ghref" id="ghref" type="hidden" value="1" />
					<input name="gmail_check" id="gmail_check" type="hidden" value="1" />
					<?
					if ($pageidcount_1==0){
						$no_value='yes';
					?>
						<div id="no_pinglun"><i class="icon-leaf"></i> 暂时还没有评论，要不要说点什么？</div>
					<? 
					}else{
						$no_value='no';?>
						<div style="float:right;">
							<? include_once("./v_i_page_show.php")?>
							<div class="clear"></div>
						</div>
					<? }?>
					
					<input name="no_pinglun_value" id="no_pinglun_value" type="hidden" value="<?=$no_value?>" />
				</div>
				<div class="clear"></div>

			</div>
			
			<? }?>
			
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

<script type="text/javascript">
$(document).ready(function(){
	$(".content_font").click(function(){
		$(".content_font").toggleClass("content_font_big");
		$(".content_art").toggleClass("content_art_big");
	});
});
</script>
<?
if ($pinglun=='1'){//判断是否开启了评论
?>
<script type="text/javascript" charset="gbk" src="/js/tooledit/ueditor_baidu/ueditor_2.config.js"></script>
<script type="text/javascript" charset="gbk" src="/js/tooledit/ueditor_baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="/js/tooledit/ueditor_baidu/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    var hf_box = UE.getEditor('hf_box');
</script>

<!--高亮代码 -->

<script type="text/javascript" src="/js/tooledit/ueditor_baidu/ueditor.parse.min.js"></script>
<script type="text/javascript" src="/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js"></script>
<link href="/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	uParse('.content_art',{
		'highlightJsUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js',
		'highlightCssUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css'
	});
	
	uParse('#huifubox',{
		'highlightJsUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js',
		'highlightCssUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css'
	});
	
	SyntaxHighlighter.all();
	
});
</script>
<? }else{?>
	<script type="text/javascript" src="/js/tooledit/ueditor_baidu/ueditor.parse.min.js"></script>
	<script type="text/javascript" src="/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js"></script>
	<link href="/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css" rel="stylesheet" type="text/css" />
	<script>
	$(document).ready(function(){
		uParse('.content_art',{
			'highlightJsUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js',
			'highlightCssUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css'
		});
		
		SyntaxHighlighter.all();
		
	});
	</script>
<? }?>


<script>
/*function share_art(webid){
	var url="http://<?=$var_domain?>/news/<?=$cid?>.html";
	var title="<?=$title?>";
	var pic='<?="http://".$var_domain.str_replace('../','/',$simgpaths)?>';
	var summary="<?=mysubstr(clear_all($message),0,105, 'gbk')?>";
	
	var ajax_bdshare=$.post("/share_jilu.php?i="+Math.random(),{webid:webid,url:url});
	var share_url="http://www.jiathis.com/send/?webid="+webid+"&url="+url+"&title="+title+"&summary="+summary+"&pic="+pic+"";
	window.open(share_url);
};*/
</script>


</body>
</html>
