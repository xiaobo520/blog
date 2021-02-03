<?
$search_count_num=0;

	if($user_search==''){
		$username_str='';
	}else{
		$username_str=" and ( username like '".$user_search."%' ) "; // in ".$."
		$search_count_num++;
	}
	

	if($nicheng_search==''){
		$nicheng_str='';
	}else{
		$nicheng_str=" and ( nicheng like '%".$nicheng_search."%' ) "; // in ".$."
		$search_count_num++;
	}
	
	if($tel_search==''){
		$tel_str='';
	}else{
		$tel_str=" and ( tel like '".$tel_search."%' ) "; // in ".$."
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
		$zhuangtai_str=" and pass <> '90' ";
	}else{
		$zhuangtai_str=" and pass = '".$zhuangtai_search."' ";
		$search_count_num++;
	}
	
	if($px_search==''){
		$px_str=' order by id desc';
	}else{
		if ($px_search=='1'){	//注册时间（正序）
			$px_str=" order by id asc";
			
		}elseif($px_search=='2'){//注册时间（倒序）
			$px_str=" order by id desc";
			
		}elseif($px_search=='3'){//活跃时间（正序）
			$px_str=" order by lasttime asc";
			
		}elseif($px_search=='4'){//活跃时间（倒序）
			$px_str=" order by lasttime desc";
			
		}
	}
	
	$searchstr=" 1=1 ".$username_str." ".$indate_str." ".$nicheng_str." ".$zhuangtai_str." ".$tel_str." ";
?>