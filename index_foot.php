<!--������Ȩ -->

<div class="footcopyright">
	<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="14%" height="162" valign="top"><div class="shuomingtitle">��վ��ͼ</div>
				<div class="shuoming"><a href="/Sitemap.xml" target="_blank">XML��ͼ</a></div>
				<div class="shuoming"><a href="/news/" target="_blank">���ּ�</a></div>
				<div class="shuoming"><a href="/shengming.html" target="_blank" rel="nofollow">��վ����</a></div>
				<div class="shuoming"><a href="/?mobile=mobile">�����ƶ���</a></div></td>
			<td width="14%" valign="top"><div class="shuomingtitle">��Ա����</div>
				<div class="shuoming"><a href="/jingyan/" target="_blank">PHP�������</a></div>
				<div class="shuoming"><a href="/help.html" target="_blank" rel="nofollow">��������</a></div>
				<div class="shuoming"><a href="/host/" target="_blank">��������</a></div></td>
			<td width="14%" valign="top"><div class="shuomingtitle">��������</div>
				<div class="shuoming"><a href="/contact.html" target="_blank" rel="nofollow">��ϵ����</a></div>
				<div class="shuoming"><a href="/jifen.html" target="_blank" rel="nofollow">��ȡ����</a></div>
				<div class="shuoming qq">QQ��1274148741</div>
				<div class="shuoming" style="text-align:left"> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1274148741&site=qq&menu=yes"><img border="0" src="/images/button_qq.gif" title="����Ի��������������ֶһ�����"/></a> </div></td>
			<td width="14%" align="center" valign="middle"><div id="footlogo"></div></td>
			<td width="2%" align="left" valign="top">&nbsp;</td>
			<td width="14%" align="left" valign="top"><div class="shuomingtitle">������</div>
				<div class="shuoming"><a href="/advantage.html" target="_blank">�������</a></div>
				<div class="shuoming"><a href="/payment.html" target="_blank" rel="nofollow">���ʽ</a></div>
				<div class="shuoming"><a href="javascript:;">admin@yubo.tech</a></div></td>
			<td width="14%" align="left" valign="top"><span class="shuomingtitle">����΢��</span>
				<div class="shuoming"><a href="/images/qrcode.jpg" target="_blank" ><img src="/images/my.jpg" width="80" height="80" /></a></div></td>
			<td width="14%" align="left" valign="top"><span class="shuomingtitle">�ƶ��˷���</span>
				<div class="shuoming"><a href="/?mobile=mobile" ><img src="/images/url.png" width="80" height="80" /></a></div></td>
		</tr>
		<?
		  if ($link_index=='true'){
		  ?>
		<tr>
			<td height="10" colspan="8" style="font-size:1px;">&nbsp;</td>
		</tr>
		<tr>
			<td height="45" colspan="8" id="link"> �������ӣ�
				<? 
				$sql_search="select url,linkname from lei_link where pass='ͨ��' order by px ";
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
		  $link_index=='';//��ձ��
		  ?>
		<tr>
			<td height="65" colspan="4" class="footbq" >Copyright &copy; 2018-<?=date("Y")?>
				www.ubug.icu
				All Rights Reserved. <br />
				����֧�֣�<a href="https://www.ubug.icu" style="color:#999999" target="_blank">PHP����</a>ϵͳ���ɴ󵨲��� <a href="https://www.ubug.icu" style="color:#999999" target="_blank">www.ubug.icu</a> ��������ѿ�Դ����</a>&nbsp;&nbsp;&nbsp;ICP�����ţ���ICP��12345678�� </td>
			<td height="65" colspan="4" align="right" valign="middle"><img src="/images/1_03.gif" width="120" height="48" />&nbsp; <img src="/images/1_05.gif" width="120" height="48" />&nbsp; <img src="/images/cxrz5.gif" width="128" height="48" /> </td>
		</tr>
	</table>	
	<div id="clearfix"></div>
</div>
<!--������Ȩ END -->
<div id="clearfix"></div>
<script src="/js/scrolltop.js" type="text/javascript"></script>
<div id="goTopBtn" style="display:none;"></div>
<SCRIPT type=text/javascript>goTopEx();</SCRIPT>
<!--<script type="text/javascript">document.ondragstart = function() {return false;};</script> ��ֹ�϶� -->
<script>
	function share_mdaima(webid,url,title,summary,pic){
		/*if (url==''){var url=window.location.href;}
		if (title==''){var title="�����-�󵨲��� | רעPHP��������̷̳���";}
		if (pic==''){var pic="http://<?=$var_domain?>/images/logo.gif";}
		if (summary==''){var summary="����룬�󵨲��ͣ��ǲ�������PHPʵս��������Ļ��ۣ�ͨ������˵�����֡�����ʾ�����̳���Ƶ��������������PHP�������鼰��̼��ɣ��ṩ��������Աѧϰ�ͽ����"}
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
if ($_SESSION['user_lei_username']!=''){//��¼������ʾ��
?>
<link href="/css/bootstrap_modal.min.css" rel="stylesheet" media="screen">
<script src="/js/bootstrap.min.js"></script>
<? include_once("./js/js_alert.php"); //����MODULE������?>
<? }?>
<?
	@ $mysqli->close();
	@ $result->free();
?>
