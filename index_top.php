<?
$dh_url=$_SERVER["REQUEST_URI"];

if (strpos($dh_url,"/jingyan")!==false){
	$class_2='class="dh_focus"';
	
}elseif (strpos($dh_url,"/news")!==false){
	$class_3='class="dh_focus"';

}elseif (strpos($dh_url,"/lilei")!==false){
	$class_6='class="dh_focus"';

}else{
	$class_1='class="dh_focus"';

}

if ($_SESSION['user_lei_username']!=""){
	$sql="select nicheng,userimg from lei_user where username='".$_SESSION['user_lei_username']."' limit 1";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		$nicheng_sess=$rs["nicheng"];
		$userimg_sess=$rs["userimg"];
	}else{
		echo "系统错误或超时！[1312]";
		$mysqli->close();
		exit;
	}
}
?>
	<!--HEAD -->
<?
if ($var_loading_index=='1'){//开启前台loading效果
?>
<link href="/css/nprogress.css" rel='stylesheet' />
<script src='/js/nprogress.js'></script>
<script>NProgress.set(0.4);NProgress.inc();NProgress.start();$(window).load(function() {NProgress.done();});</script>
<? }?>
<script src='/js/jquery.enplaceholder.js'></script>

		<div class="header" >
			<div class="header_bg">
				<div id="admin">
					<i class="icon-user"></i> <? if ($_SESSION['user_lei_username']!=''){ ?>欢迎您，<a href="/home.html"><?=$nicheng_sess?></a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="/home.html"><?=$_SESSION['user_lei_username']?></a>，<a href="javascript:void(0);" onClick="alert_go('确认退出？','href','','wen','/login.html?<?=encrypt_url("action=out&&time=".time(),$key_url_md_5)?>')">退出</a><? }else{?>欢迎您来到，大胆博客&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/login.html" >登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/login.html?e=register" rel="nofollow">注册</a><? }?>
				</div>
				
				<div id="search" style="position:relative">
					<?
					if ($_COOKIE["search_jingdu"]=='1'){
						$jd_class='jingdu jingdu_click';
						$jd_str='<i class="icon-zoom-in icon-white" ></i> 精确';
					}elseif($_COOKIE["search_jingdu"]=='0'){
						$jd_class='jingdu';
						$jd_str='<i class="icon-zoom-out icon-white" ></i> 模糊';
					}else{
						$_COOKIE["search_jingdu"]='0';//默认为0
						$jd_class='jingdu';
						$jd_str='<i class="icon-zoom-out icon-white" ></i> 模糊';
					}
					
					if ($_COOKIE["search_fo"]=='1'){
						$fo_class='search_fo search_fo_click';
						$fo_str='随手记';
						$search_action='/news/';
					}else{
						$_COOKIE["search_fo"]='0';//默认为0
						$fo_class='search_fo';
						$fo_str='WEB前端';
						$search_action='/jingyan/';
					}
					?>
					<form id="index_search" name="index_search" method="post" action="<?=$search_action?>?search_open=ok">
						<div id="jingdu" class="<?=$jd_class?>"><?=$jd_str?></div>
						<div id="search_fo" class="<?=$fo_class?>"><?=$fo_str?></div>
						<div id="search_box">
							<i class="icon-search" ></i> <input id="search_input" name="keyword_search" type="text" value="<?=$keyword_search?>" maxlength="15" placeholder="请输入关键词、标签" />
						</div>
						<div id="search_submit" onclick="document.index_search.submit()">查询</div>
						<script>$('#search_input').placeholder();</script>
					</form>
				</div>
				
			</div>
		</div>
		
		<div class="dh_box" >
			<div class="dh_in">
				<div class="logo"><a href="/"><img src="/images/dadan.png" width="152" height="94" border="0" class="logo_a" /></a><img src="/images/banner.gif" width="319" height="73" border="0" id="logo_title" class="logo_b"/></div>
				<div class="head_link">
					<span <?=$class_1?>><a href="/">首页</a></span>
					<span <?=$class_2?>><a href="/jingyan/">WEB前端</a></span>
					<span <?=$class_3?>><a href="/news/">随手记</a></span>
					<span ><a href="/daima/" target="_blank" title="PHP代码库、代码片断">代码库</a></span>
					<span <?=$class_6?>><a href="/lilei.html">关于博主</a></span>
				</div>
			</div>
		</div>
		

		<div class="focus_box">
			<div id="focus_lx">
				<ul id="focus_lx_ul">
				
				<?
				if (strpos($dh_url,"/news")!==false){ //调整默认顺序
				?>
					<div id="focus_lx_li"><a href="/news/" target="_blank"><img src="/images/lx/3.jpg" alt="" width="1100" height="100" border="0"/></a></div>
					<div id="focus_lx_li"><a href="/lilei.html" target="_blank"><img src="/images/lx/1.jpg" alt="" width="1100" height="100" border="0" /></a></div>
					<div id="focus_lx_li"><a href="/host/" target="_blank"><img src="/images/lx/2.jpg" alt="" width="1100" height="100" border="0"/></a></div>
					
				<? }elseif (strpos($dh_url,"/host")!==false){?>
					<div id="focus_lx_li"><a href="/host/" target="_blank"><img src="/images/lx/2.jpg" alt="" width="1100" height="100" border="0"/></a></div>
					<div id="focus_lx_li"><a href="/lilei.html" target="_blank"><img src="/images/lx/1.jpg" alt="" width="1100" height="100" border="0" /></a></div>
					<div id="focus_lx_li"><a href="/news/" target="_blank"><img src="/images/lx/3.jpg" alt="" width="1100" height="100" border="0"/></a></div>
				<? }else{?>
					<div id="focus_lx_li"><a href="http://www.bbbug.com/" target="_blank"><img src="/images/lx/bbbug.gif" alt="" width="1100" height="100" border="0" /></a></div>
					<div id="focus_lx_li"><a href="/host/" target="_blank"><img src="/images/lx/2.jpg" alt="" width="1100" height="100" border="0"/></a></div>
					<div id="focus_lx_li"><a href="/news/" target="_blank"><img src="/images/lx/3.jpg" alt="" width="1100" height="100" border="0"/></a></div>
				<? }?>
				</ul>
			</div>
		</div>

	<!--HEAD -->