<?
//各种权限访问各页面的限制功能 Begin  文件中引用的文件，不用设置
	$arr = explode('/',$_SERVER['PHP_SELF']);
	$this_urlfile=$arr[count($arr)-1];
	
	//##################################################公共URL即全部用户均允许的URL
	$url_allow="|myinfo_m.php|admin_index_m.php|top_m.php|index_main_m.php|left_m.php|bottom_m.php|password_m.php|checkpinzhong.php|online.php|checkbumen.php|choose_bumen_m.php|out_xls_m.php|yingyong_list_m.php|yingyong_info_m.php|yingyong_add_m.php|wenti_user_list_m.php|wenti_user_info_m.php|renyuan_m.php|renyuan_add_m.php|renyuan_xx_m.php|renyuan_duqu.php|chooseperson.php|wenti_list_m.php|wenti_add_m.php|wenti_info_m.php|set_cookie.php|wenti_print_m.php|sessionkeeper.php|";
	$url_allow=explode('|',$url_allow);
	foreach ($url_allow as $url_allow_gonggong){
		if ($this_urlfile==$url_allow_gonggong){
			$url_pdgg_str='true';
		}
	}
	
	if ($url_pdgg_str!='true'){//非公共URL，进行以下验证
	
		//##################################################管理员被允许的URL
		if ($_SESSION['blog_lileiflag']=='admin' ){//信息化处
			$url_allow="|canshu_m.php|renyuan_m.php|jilu_m.php|jilu_list_m.php|ribao_m.php|ribao_xx_m.php|ribao_add_m.php|ribao_tongji_m.php|ribao_tongji_xx_m.php|ribao_tongji_xx_2_m.php|zidian_m.php|zidian_add_m.php|wenti_list_m.php|wenti_info_m.php|wenti_add_m.php|ribao_zhongdian_m.php|ribao_keshi_m.php|ribao_keshi_list_m.php|ribao_chushi_m.php|out_ribao_m.php|ribao_chushi_list_m.php|ribao_save_m.php|status_question.php|status_mysql_m.php|wenti_tongji_m.php|tongji_tc.php|rili.php|rili_get_m.php|baogao_list_m.php|baogao_xx_m.php|baogao_add_m.php|baogao_print_m.php|baogao_out_word_m.php|zhiban_list_m.php|zhiban_xx_m.php|zhiban_add_m.php|zhiban_print_m.php|zhiban_out_word_m.php|xieshi_list_m.php|xieshi_xx_m.php|xieshi_add_m.php|xieshi_print_m.php|xieshi_out_word_m.php|";
			$url_allow=explode('|',$url_allow);
			foreach ($url_allow as $url_allow_pd){
				if ($this_urlfile==$url_allow_pd){
					$url_pd_str='true';
				}
			}
			if ($url_pd_str!='true'){
				echo "请勿越权访问[ ".$this_urlfile." ]";
				$url_pd_str='';
				exit;
			}
		}else{
			echo "请勿越权访问[ ".$this_urlfile." ]";
			$url_pd_str='';
			exit;
		}
		
	}
	
//各种权限访问各页面的限制功能 End
?>