<!--通栏 -->

<?
if ($wap_mobile!='true') exit;

$dh_url=$_SERVER["REQUEST_URI"];

$class_1='';
$class_2='';

if (strpos($dh_url,"/jingyan")!==false){
	$class_1='style="font-weight:bold"';
	
}elseif (strpos($dh_url,"/news")!==false){
	$class_2='style="font-weight:bold"';

}
?>
	<div style="position:fixed;width:100%; z-index:10000">
		<div class="tonglan">
			<div class="logo"><a href="/"><img src="/wap/images/dadan.png"></a></div>
			
			
			<div class="user_r" >
				<a href="/jingyan/" <?=$class_1?>><img src="/wap/images/ico-record.png"><br>web前端</a>
			</div>
			
			<div class="user_r" style="margin-right:2rem;">
				<a href="/news/" <?=$class_2?>><img src="/wap/images/ico-ucenter.png"><br>随手记</a>
			</div>
		</div>
	</div>
	<!--通栏end -->