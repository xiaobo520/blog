<?php

//=========================wap��ʼ��������=============================	

	$wap_index_pic_path='/';  //��ҳ�б�����ͼ·��
	$wap_webname='���ײ���';    //wapվ����
	$wap_domain='https://www.mdaima.com';    //PCվdomain

//=====================================================================
function time_show_wap($time){ //��ʱ��ͨ�� �죬ʱ���룬��ʾ

	$time_start=$time;
	if ($time==''){
		$time_result='--';
	}else{
		$time=time()-strtotime($time);
		if ($time<=60){ //1��������
			$time_result=$time." ��ǰ";
			
		}elseif($time<=60*60){ //1Сʱ����
			$time_result=floor($time/60)." ����ǰ";   //ceil����ȡ����floorС��������ȥȡ��
			
		}elseif($time<=(60*60*24*1)){ //1������
			$time_result=floor($time/3600)." Сʱǰ";
			
		}elseif($time<=(60*60*24*4)){ //3������
			$time_result=floor($time/3600/24)." ��ǰ";
			
		}else{
			$time_result=date("Y-m-d",strtotime($time_start));
			
		}
	}
	
	return $time_result;
}
?>