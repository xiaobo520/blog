<?
$action_pd=$url_info['action_pd'];

$user_search=quotes_gpc_pd($_POST['user_search'],1);
$nicheng_search=quotes_gpc_pd($_POST['nicheng_search'],1);
$date1_search=quotes_gpc_pd($_POST['date1_search'],1);
$date2_search=quotes_gpc_pd($_POST['date2_search'],1);
$px_search=quotes_gpc_pd($_POST['px_search'],1);
$pagenums_search=quotes_gpc_pd($_POST['pagenums_search'],1);
$zhuangtai_search=quotes_gpc_pd($_POST['zhuangtai_search'],1);
$tel_search=quotes_gpc_pd($_POST['tel_search'],1);


if ($user_search=='' ) $user_search=$url_info['user_search'];
if ($nicheng_search=='' ) $nicheng_search=$url_info['nicheng_search'];
if ($date1_search=='' ) $date1_search=$url_info['date1_search'];
if ($date2_search=='' ) $date2_search=$url_info['date2_search'];
if ($px_search=='' ) $px_search=$url_info['px_search'];
if ($pagenums_search=='' ) $pagenums_search=$url_info['pagenums_search'];
if ($zhuangtai_search=='' ) $zhuangtai_search=$url_info['zhuangtai_search'];
if ($tel_search=='' ) $tel_search=$url_info['tel_search'];

$page=$url_info['page'];//跳转页码

if ($pagenums_search>100){
	echo "<script language=javascript>alert('每页行数最大为100！');javascript:history.back(-1);</script>";
	exit;
}

$user_search=keyword_replace($user_search);//替换keyword
//========================================

$pageurl="&action_pd=".$action_pd."&user_search=".$user_search."&nicheng_search=".$nicheng_search."&zhuangtai_search=".$zhuangtai_search."&date1_search=".$date1_search."&date2_search=".$date2_search."&px_search=".$px_search."&tel_search=".$tel_search."&pagenums_search=".$pagenums_search;
?>