<?php

//=========================wap初始变量设置=============================	

	$wap_index_pic_path='/';  //首页列表缩略图路径
	$wap_webname='李雷博客';    //wap站名称
	$wap_domain='https://www.mdaima.com';    //PC站domain

//=====================================================================
function time_show_wap($time){ //将时间通过 天，时分秒，显示

	$time_start=$time;
	if ($time==''){
		$time_result='--';
	}else{
		$time=time()-strtotime($time);
		if ($time<=60){ //1分钟以内
			$time_result=$time." 秒前";
			
		}elseif($time<=60*60){ //1小时以内
			$time_result=floor($time/60)." 分钟前";   //ceil向上取整，floor小数部分舍去取整
			
		}elseif($time<=(60*60*24*1)){ //1天以内
			$time_result=floor($time/3600)." 小时前";
			
		}elseif($time<=(60*60*24*4)){ //3天以内
			$time_result=floor($time/3600/24)." 天前";
			
		}else{
			$time_result=date("Y-m-d",strtotime($time_start));
			
		}
	}
	
	return $time_result;
}
?>