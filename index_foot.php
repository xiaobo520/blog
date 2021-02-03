<!--底栏版权 -->

<div class="footcopyright">
	<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="14%" height="162" valign="top"><div class="shuomingtitle">网站地图</div>
				<div class="shuoming"><a href="/Sitemap.xml" target="_blank">XML地图</a></div>
				<div class="shuoming"><a href="/news/" target="_blank">随手记</a></div>
				<div class="shuoming"><a href="/shengming.html" target="_blank" rel="nofollow">本站声明</a></div>
				<div class="shuoming"><a href="/?mobile=mobile">博客移动版</a></div></td>
			<td width="14%" valign="top"><div class="shuomingtitle">会员服务</div>
				<div class="shuoming"><a href="/jingyan/" target="_blank">PHP经验分享</a></div>
				<div class="shuoming"><a href="/help.html" target="_blank" rel="nofollow">帮助中心</a></div>
				<div class="shuoming"><a href="/host/" target="_blank">虚拟主机</a></div></td>
			<td width="14%" valign="top"><div class="shuomingtitle">关于我们</div>
				<div class="shuoming"><a href="/contact.html" target="_blank" rel="nofollow">联系我们</a></div>
				<div class="shuoming"><a href="/jifen.html" target="_blank" rel="nofollow">获取积分</a></div>
				<div class="shuoming qq">QQ：1274148741</div>
				<div class="shuoming" style="text-align:left"> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1274148741&site=qq&menu=yes"><img border="0" src="/images/button_qq.gif" title="点击对话（虚拟主机积分兑换办理）"/></a> </div></td>
			<td width="14%" align="center" valign="middle"><div id="footlogo"></div></td>
			<td width="2%" align="left" valign="top">&nbsp;</td>
			<td width="14%" align="left" valign="top"><div class="shuomingtitle">广告服务</div>
				<div class="shuoming"><a href="/advantage.html" target="_blank">广告优势</a></div>
				<div class="shuoming"><a href="/payment.html" target="_blank" rel="nofollow">付款方式</a></div>
				<div class="shuoming"><a href="javascript:;">admin@yubo.tech</a></div></td>
			<td width="14%" align="left" valign="top"><span class="shuomingtitle">加我微信</span>
				<div class="shuoming"><a href="/images/qrcode.jpg" target="_blank" ><img src="/images/my.jpg" width="80" height="80" /></a></div></td>
			<td width="14%" align="left" valign="top"><span class="shuomingtitle">移动端访问</span>
				<div class="shuoming"><a href="/?mobile=mobile" ><img src="/images/url.png" width="80" height="80" /></a></div></td>
		</tr>
		<?
		  if ($link_index=='true'){
		  ?>
		<tr>
			<td height="10" colspan="8" style="font-size:1px;">&nbsp;</td>
		</tr>
		<tr>
			<td height="45" colspan="8" id="link"> 友情链接：
				<? 
				$sql_search="select url,linkname from lei_link where pass='通过' order by px ";
				$result=$mysqli->query($sql_search);
				while ($rs=$result->fetch_assoc()){
			?>
				<a href="<?=$rs["url"]?>" target="_blank">
				<?=$rs["linkname"]?>
				</a>
				<? }?>
			</td>
		</tr>
		<tr>
			<td height="10" colspan="8" style="font-size:1px;">&nbsp;</td>
		</tr>
		<? }else{ ?>
		<tr>
			<td height="6" colspan="8" style="font-size:1px;border-bottom:2px groove #505050;">&nbsp;</td>
		</tr>
		<tr>
			<td height="5" colspan="8" style="font-size:1px;">&nbsp;</td>
		</tr>
		<?
		  }
		  $link_index=='';//清空标记
		  ?>
		<tr>
			<td height="65" colspan="4" class="footbq" >Copyright &copy; 2018-<?=date("Y")?>
				www.ubug.icu
				All Rights Reserved. <br />
				技术支持：<a href="https://www.ubug.icu" style="color:#999999" target="_blank">PHP博客</a>系统，由大胆博客 <a href="https://www.ubug.icu" style="color:#999999" target="_blank">www.ubug.icu</a> 开发并免费开源分享</a>&nbsp;&nbsp;&nbsp;ICP备案号：浙ICP备12345678号 </td>
			<td height="65" colspan="4" align="right" valign="middle"><img src="/images/1_03.gif" width="120" height="48" />&nbsp; <img src="/images/1_05.gif" width="120" height="48" />&nbsp; <img src="/images/cxrz5.gif" width="128" height="48" /> </td>
		</tr>
	</table>	
	<div id="clearfix"></div>
</div>
<!--底栏版权 END -->
<div id="clearfix"></div>
<script src="/js/scrolltop.js" type="text/javascript"></script>
<div id="goTopBtn" style="display:none;"></div>
<SCRIPT type=text/javascript>goTopEx();</SCRIPT>
<!--<script type="text/javascript">document.ondragstart = function() {return false;};</script> 禁止拖动 -->
<script>
	function share_mdaima(webid,url,title,summary,pic){
		/*if (url==''){var url=window.location.href;}
		if (title==''){var title="码代码-大胆博客 | 专注PHP技术经验教程分享！";}
		if (pic==''){var pic="http://<?=$var_domain?>/images/logo.gif";}
		if (summary==''){var summary="码代码，大胆博客，是博主多年PHP实战开发经验的积累，通过简洁的说明文字、功能示例、教程视频，分享博主大量的PHP开发经验及编程技巧，提供给开发人员学习和借鉴！"}
		var ajax_bdshare=$.post("/share_jilu.php?i="+Math.random(),{webid:webid,url:url});
		var share_url="http://www.jiathis.com/send/?webid="+webid+"&url="+url+"&title="+title+"&summary="+summary+"&pic="+pic+"";
		window.open(share_url);*/
	};
	
	function share_list(webid,mulu,cid){
		/*var url="http://<?=$var_domain?>/"+mulu+"/"+cid+".html";
		var title=document.getElementById(mulu+"_title_"+cid).innerHTML;
		var pic=document.getElementById(mulu+"_img_"+cid).src;
		var summary=document.getElementById(mulu+"_miaoshu_"+cid).innerHTML;
		var ajax_bdshare=$.post("/share_jilu.php?i="+Math.random(),{webid:webid,url:url});
		var share_url="http://www.jiathis.com/send/?webid="+webid+"&url="+url+"&title="+title+"&summary="+summary+"&pic="+pic+"";
		window.open(share_url);*/
	};


	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "https://hm.baidu.com/hm.js?2b3cdf5725f9a92afc5477f40b44765a";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();

</script>
<script src="/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/js/other_all.js" type="text/javascript"></script>
<?
if ($_SESSION['user_lei_username']!=''){//登录加载提示框
?>
<link href="/css/bootstrap_modal.min.css" rel="stylesheet" media="screen">
<script src="/js/bootstrap.min.js"></script>
<? include_once("./js/js_alert.php"); //调用MODULE弹出框?>
<? }?>
<?
	@ $mysqli->close();
	@ $result->free();
?>
