<?
$search_count_num=0;

	if($cid_search==''){
		$cid_str='';
	}else{
		$cid_str=" and ( dh like '".$cid_search."%' ) "; // in ".$."
		$search_count_num++;
	}
	
	if($user_search==''){
		$user_str='';
	}else{
		$user_str=" and ( username like '".$user_search."%' ) "; // in ".$."
		$search_count_num++;
	}
	
	if($xinghao_search==''){
		$xinghao_str='';
	}else{
		$xinghao_str=" and ( xinghao like '%".$xinghao_search."%' ) "; // in ".$."
		$search_count_num++;
	}

	if($date1_search=='' || $date2_search==''){//操作日期
		//$nowdate=date("Y-m-d",strtotime("-7 day"));//默认显示最近7天的
		//$nowdate=date("Y-m-d",strtotime("last Friday"));//next last
		//$date1_search=$nowdate;
		//$date2_search=date("Y-m-d");
		
		//$indate_str=" and indate >= '".$date1_search." 00:00:00' and indate <= '".$date2_search." 23:59:59'  ";
		$indate_str='';
	}else{
		$indate_str=" and indate >= '".$date1_search." 00:00:00' and indate <= '".$date2_search." 23:59:59'  ";
		$search_count_num++;
	}
	
	
	
	if($zhuangtai_search==''){
		$zhuangtai_str=" ";
	}else{
		$zhuangtai_str=" and zt = '".$zhuangtai_search."' ";
		$search_count_num++;
	}
	
	
	if($px_search==''){
		$px_str=' order by id desc';
	}else{
		if ($px_search=='1'){	//注册时间（正序）
			$px_str=" order by id asc";
			
		}elseif($px_search=='2'){//注册时间（倒序）
			$px_str=" order by id desc";
			
		}
	}
	
	$searchstr=" 1=1 ".$cid_str." ".$user_str." ".$xinghao_str." ".$username_str." ".$indate_str." ".$zhuangtai_str." ";
?>