<?
$action_pd=$url_info['action_pd'];

$title_search=quotes_gpc_pd($_POST['title_search'],1);
$date1_search=quotes_gpc_pd($_POST['date1_search'],1);
$date2_search=quotes_gpc_pd($_POST['date2_search'],1);
$px_search=quotes_gpc_pd($_POST['px_search'],1);
$pagenums_search=quotes_gpc_pd($_POST['pagenums_search'],1);
$zhuangtai_search=quotes_gpc_pd($_POST['zhuangtai_search'],1);
$jingdu_search=quotes_gpc_pd($_POST['jingdu_search'],1);
$id_search=quotes_gpc_pd($_POST['id_search'],1);
if ($id_search=='' ) $id_search=$url_info['id_search'];


if ($title_search=='' ) $title_search=$url_info['title_search'];
if ($date1_search=='' ) $date1_search=$url_info['date1_search'];
if ($date2_search=='' ) $date2_search=$url_info['date2_search'];
if ($px_search=='' ) $px_search=$url_info['px_search'];
if ($pagenums_search=='' ) $pagenums_search=$url_info['pagenums_search'];
if ($zhuangtai_search=='' ) $zhuangtai_search=$url_info['zhuangtai_search'];
if ($jingdu_search=='' ) $jingdu_search=$url_info['jingdu_search'];

$page=$url_info['page'];//跳转页码

if ($pagenums_search>100){
	echo "<script language=javascript>alert('每页行数最大为100！');javascript:history.back(-1);</script>";
	exit;
}

$title_search=keyword_replace($title_search);//替换keyword
//========================================

$pageurl="&action_pd=".$action_pd."&title_search=".$title_search."&zhuangtai_search=".$zhuangtai_search."&id_search=".$id_search."&date1_search=".$date1_search."&date2_search=".$date2_search."&px_search=".$px_search."&jingdu_search=".$jingdu_search."&pagenums_search=".$pagenums_search;
?>