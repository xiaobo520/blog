<?php
$keyword_search=quotes_gpc_pd($_POST['keyword_search'],1);

if ($keyword_search=='' ) $keyword_search=$_REQUEST['keyword_search'];

$page=$_REQUEST["page"];//跳转页码
$search_open=$_REQUEST['search_open'];//获取是否有搜索行为

$keyword_search=keyword_replace($keyword_search);//替换keyword
//========================================

$pageurl="&search_open=".$search_open."&see=".$see."&keyword_search=".$keyword_search."&pagenums_search=".$pagenums_search;

?>