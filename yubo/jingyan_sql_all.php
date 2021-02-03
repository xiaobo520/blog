<?
$search_count_num=0;

	if (check_null($title_search)!='0'){//查询条件
			
		if ($jingdu_search=='1'){
			//*********************************************
			function getfile($ss_str){      
				$array = explode(' ',$ss_str);
				return $array;     
			} 
			
			$word = getfile($title_search);
			$length = count($word);
			
			for($iop = 0; $iop < $length; $iop++){  
				$search_for=$search_for."title like '%".$word[$iop]."%' or ";//搜索分词
				$if_count.="if(instr(title, '".addslashes($word[$iop])."'),1,0)+"; //关键词排序计算
			}
			
			$search_for=substr($search_for,0,-3);
			$if_count=substr($if_count,0,-1)." as count"; //关键词排序计算 整合
			$title_str=" and ( ".$search_for." )";
			$search_count_num++;
			
			$search_score='';//强制清空
			//**********************************************
		}else{	
			$keyword_start =$title_search;//记录原始搜索词
			$title_search=keyword_replace($title_search);//替换keyword
			$splitnum_new = quweima($title_search);//转为可用于搜索的区位码索引
			
			$search_score=",MATCH(title_code) AGAINST ('".$splitnum_new."' IN BOOLEAN MODE) AS countscore";//置于select字段
			$search_for="MATCH(title_code) AGAINST ('".$splitnum_new."' IN BOOLEAN MODE) ";
			
			$px_search='title';//强调排序规则  “启动”标题评分排序

			$title_str=" and ( ".$search_for." )";
			$search_count_num++;
		}
	}else{
		$title_str="";
	}
	

	if($keyword_search==''){
		$keyword_str='';
	}else{
	
		$keyword_str=" and ( keyword like '%-".$keyword_search."-%' ) "; // in ".$."
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
		$zhuangtai_str='';
	}else{
		$zhuangtai_str=" and pass = '".$zhuangtai_search."' ";
		$search_count_num++;
	}
	
	if($id_search==''){
		$id_str='';
	}else{
		$id_str=" and id = '".$id_search."' ";
	}
	
	if($px_search==''){
		$px_str=' order by id desc';
	}else{
		if ($px_search=='title'){//按标题查询评分排序
			$px_str=" order by countscore desc ";
		}elseif ($px_search=='1'){	//申报时间（正序）
			$px_str=" order by id asc";
			
		}elseif($px_search=='2'){//申报时间（倒序）
			$px_str=" order by id desc";
			
		}
	}
	
	$searchstr=" 1=1 ".$title_str." ".$indate_str." ".$keyword_str." ".$zhuangtai_str." ".$id_str." ";
?>