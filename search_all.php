<?php
$keyword_search=quotes_gpc_pd($_POST['keyword_search'],1);

if ($keyword_search=='' ) $keyword_search=$_REQUEST['keyword_search'];

$page=$_REQUEST["page"];//��תҳ��
$search_open=$_REQUEST['search_open'];//��ȡ�Ƿ���������Ϊ

$keyword_search=keyword_replace($keyword_search);//�滻keyword
//========================================

$pageurl="&search_open=".$search_open."&see=".$see."&keyword_search=".$keyword_search."&pagenums_search=".$pagenums_search;

?>