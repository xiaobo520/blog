<?
$action_pd=$url_info['action_pd'];

$cid_search=quotes_gpc_pd($_POST['cid_search'],1);
$xinghao_search=quotes_gpc_pd($_POST['xinghao_search'],1);
$user_search=quotes_gpc_pd($_POST['user_search'],1);
$date1_search=quotes_gpc_pd($_POST['date1_search'],1);
$date2_search=quotes_gpc_pd($_POST['date2_search'],1);
$px_search=quotes_gpc_pd($_POST['px_search'],1);
$pagenums_search=quotes_gpc_pd($_POST['pagenums_search'],1);
$zhuangtai_search=quotes_gpc_pd($_POST['zhuangtai_search'],1);

if ($cid_search=='' ) $cid_search=$url_info['cid_search'];
if ($xinghao_search=='' ) $xinghao_search=$url_info['xinghao_search'];
if ($user_search=='' ) $user_search=$url_info['user_search'];
if ($date1_search=='' ) $date1_search=$url_info['date1_search'];
if ($date2_search=='' ) $date2_search=$url_info['date2_search'];
if ($px_search=='' ) $px_search=$url_info['px_search'];
if ($pagenums_search=='' ) $pagenums_search=$url_info['pagenums_search'];
if ($zhuangtai_search=='' ) $zhuangtai_search=$url_info['zhuangtai_search'];

$page=$url_info['page'];//跳转页码

if ($pagenums_search>100){
	echo "<script language=javascript>alert('每页行数最大为100！');javascript:history.back(-1);</script>";
	exit;
}

//$user_search=keyword_replace($user_search);//替换keyword
//========================================

$pageurl="&action_pd=".$action_pd."&user_search=".$user_search."&zhuangtai_search=".$zhuangtai_search."&date1_search=".$date1_search."&date2_search=".$date2_search."&px_search=".$px_search."&cid_search=".$cid_search."&xinghao_search=".$xinghao_search."&pagenums_search=".$pagenums_search;
//--------------搜索条件生成
?>