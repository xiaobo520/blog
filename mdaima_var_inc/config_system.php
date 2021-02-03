<?php
//session_save_path("D:/appserv/session/xxhc/"); //必须放在session_start()前  暂未启用，目前采用定时刷新通讯
//ini_set('session.gc_maxlifetime',7200);//session超时 7200秒  暂未启用，目前采用定时刷新通讯
session_start();//开启session功能，此前不能有任何输出
header("Cache-control: private"); //开启网页表单缓存
header("Content-Type: text/html;charset=GB2312");
date_default_timezone_set ("PRC");//设置时区
set_time_limit(0);
ini_set('memory_limit','128M');
//phpinfo();

//#####################################################系统函数
function textareaencode($area_str){//存入数据库
	if ($area_str!=''){
		$area_str = str_replace(CHR(32),"&nbsp;",$area_str);
		$area_str = str_replace(CHR(13),"</BR>",$area_str); //回车
		//$area_str = str_replace(CHR(10),"</BR>",$area_str); //换行
		//$area_str = str_replace(array("\r\n", "\r", "\n"), "</BR>", $area_str); //数组替换，不同系统符号不同
		//$area_str = str_replace(CHR(10),"<BR>",$area_str);
	}
	return $area_str;
}

function textareadecode($area_str){//读取数据库
	if ($area_str!=''){
		$area_str = str_replace("&nbsp;",CHR(32),$area_str);
		$area_str = str_replace("</BR>",CHR(13),$area_str);
		$area_str = str_replace("<br>",CHR(13),$area_str);
		//$area_str = str_replace(CHR(10),"<BR>",$area_str);
	}
	return $area_str;
}

function text_word($area_str){//word规则的转换为统一
	if ($area_str!=''){
		$area_str = str_replace("</BR>","<br>",$area_str);
		$area_str = str_replace("<br />","<br>",$area_str);
		$area_str = str_replace("<br/>","<br>",$area_str);
		//$area_str = str_replace(CHR(10),"<BR>",$area_str);
	}
	return $area_str;
}

function text_excel($area_str){//word规则的转换为统一
	if ($area_str!=''){
		$area_str = str_replace("&nbsp;",CHR(32),$area_str);
		$area_str = str_replace("</BR>",CHR(13),$area_str);
		$area_str = str_replace("<br />",CHR(13),$area_str);
		$area_str = str_replace("<br/>",CHR(13),$area_str);
		$area_str = str_replace("</br>",CHR(13),$area_str);
		$area_str = str_replace("<p>",'',$area_str);
		$area_str = str_replace("</p>",'',$area_str);
		//$area_str = str_replace(CHR(10),"<BR>",$area_str);
	}
	return $area_str;
}

function clear_all($area_str){ //过滤成纯文本用于显示
	if ($area_str!=''){
		$area_str = trim($area_str); //清除字符串两边的空格
		$area_str = strip_tags($area_str,""); //利用php自带的函数清除html格式
		$area_str = str_replace("&nbsp;","",$area_str);
		
		$area_str = preg_replace("/\t/","",$area_str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
		$area_str = preg_replace("/\r\n/","",$area_str); 
		$area_str = preg_replace("/\r/","",$area_str); 
		$area_str = preg_replace("/\n/","",$area_str); 
		$area_str = preg_replace("/ /","",$area_str);
		$area_str = preg_replace("/  /","",$area_str);  //匹配html中的空格
		$area_str = trim($area_str); //返回字符串
	}
	return $area_str;
}

function getfirstchar($s0){  //获取首字母
	$fchar = ord($s0{0});
	if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
	$s1 = iconv("UTF-8","gb2312", $s0);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $s0){$s = $s1;}else{$s = $s0;}
	$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
	if($asc>=-20319 and $asc<=-20284)return "A"; 
	if($asc>=-20283 and $asc<=-19776)return "B"; 
	if($asc>=-19775 and $asc<=-19219)return "C"; 
	if($asc>=-19218 and $asc<=-18711)return "D"; 
	if($asc>=-18710 and $asc<=-18527)return "E"; 
	if($asc>=-18526 and $asc<=-18240)return "F"; 
	if($asc>=-18239 and $asc<=-17923)return "G"; 
	if($asc>=-17922 and $asc<=-17418)return "H"; 
	if($asc>=-17417 and $asc<=-16475)return "J"; 
	if($asc>=-16474 and $asc<=-16213)return "K"; 
	if($asc>=-16212 and $asc<=-15641)return "L"; 
	if($asc>=-15640 and $asc<=-15166)return "M"; 
	if($asc>=-15165 and $asc<=-14923)return "N"; 
	if($asc>=-14922 and $asc<=-14915)return "O"; 
	if($asc>=-14914 and $asc<=-14631)return "P"; 
	if($asc>=-14630 and $asc<=-14150)return "Q"; 
	if($asc>=-14149 and $asc<=-14091)return "R"; 
	if($asc>=-14090 and $asc<=-13319)return "S"; 
	if($asc>=-13318 and $asc<=-12839)return "T"; 
	if($asc>=-12838 and $asc<=-12557)return "W"; 
	if($asc>=-12556 and $asc<=-11848)return "X"; 
	if($asc>=-11847 and $asc<=-11056)return "Y"; 
	if($asc>=-11055 and $asc<=-10247)return "Z"; 
	return null;
}
		
function pinyin_g($zh){//转成拼音首字母，也可以使用 js/pinyin.js
	$ret = "";
	$s1 = iconv("UTF-8","gb2312", $zh);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $zh){$zh = $s1;}
	for($i = 0; $i < strlen($zh); $i++){
		$s1 = substr($zh,$i,1);
		$p = ord($s1);
		if($p > 160){
			$s2 = substr($zh,$i++,2);
			$ret .= getfirstchar($s2);
		}else{
			$ret .= $s1;
		}
	}
	return strtoupper($ret);
}

function jilu_in($username,$jifen,$leixing,$bz){ //记录积分操作  用户名，积分，类型  $caozuo：denglujiangli/huitie/sharejiangli/积分调整/微信关注/活动赠送
	$userip = $_SERVER['REMOTE_ADDR']; //获得用户ip 
	$indate= date("Y-m-d");
	$intime= date("Y-m-d H:i:s");
	global $mysqli;//定义$mysqli为全局变量
	
	if ($leixing=='denglujiangli'){
		$sql_cz="select id from lei_jifen where username='".$username."' and indate='".$indate."' and leixing='denglujiangli' ";//每人每天仅限一次领取
		$result=$mysqli->query($sql_cz);
		if(!$rs_cz=$result->fetch_assoc()){
		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//更新积分
			$mysqli->query($sql_in);
			
		}

	}
	
	if ($leixing=='sharejiangli'){
	
		$sql_jilu="select count(*) from lei_jifen where username='".$username."' and indate='".$indate."' and leixing='sharejiangli' ";
		$result_jilu=$mysqli->query($sql_jilu);
		$rs_jilu=$result_jilu->fetch_array();
		$jilucount=$rs_jilu[0];
		
		if ($jilucount<2){
		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//更新积分
			$mysqli->query($sql_in);
			
		}

	}
	
	
	
	if ($leixing=='huitie'){
		
		$sql_last="update lei_user set lasttime='".$intime."' where username='".$username."' limit 1";
		$mysqli->query($sql_last);

		$sql_jilu="select count(*) from lei_jifen where username='".$username."' and indate='".$indate."' and leixing='huitie' ";
		$result_jilu=$mysqli->query($sql_jilu);
		$rs_jilu=$result_jilu->fetch_array();
		$jilucount=$rs_jilu[0];
		if ($jilucount<5){//每天限回贴多少次回帖内给积分
		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//更新积分
			$mysqli->query($sql_in);
			
		}

	}
	
	if ($leixing=='pintu'){//拼图，每天限1次   有返回值

		$sql_jilu="select count(*) from lei_jifen where username='".$username."' and indate='".$indate."' and leixing='pintu' ";
		$result_jilu=$mysqli->query($sql_jilu);
		$rs_jilu=$result_jilu->fetch_array();
		$jilucount=$rs_jilu[0];
		if ($jilucount<1){
		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//更新积分
			$mysqli->query($sql_in);
			
			return '获取积分OK';
			
		}else{
			return '获取积分NO';
		}

	}
	
	if ($leixing=='qita' && $jifen<>0){//其它积分记录都使用这个函数，在备注中说明用途，包含虚拟主机兑换，积分可能为负值，如果为扣分项，历史总积分不能减

		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			if ($jifen>0){ //只有加分时历史积分才加，减分时不减
				$jifen_all_str=",jifen_all=jifen_all+".$jifen.""; 
			}else{
				$jifen_all_str="";
			}
			
			$sql_in="update lei_user set jifen=jifen+".$jifen."".$jifen_all_str." where username='".$username."' limit 1 ";//更新积分
			$mysqli->query($sql_in);

	}
	
	
	
}

function limit_check($limit_radio,$limit_user){ //权限判断  true代表有此权限
	if(strpos($limit_user,",".$limit_radio.",")!==false){ 
		return 'true'; 
	}else{ 
		return 'false';
	}
}

function isok_ip($ip){ //判断IP是否正确格式
	if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip)){ 
		return 'true'; 
	}else{ 
		return 'false';
	}
}

//检测IP地址段---------------
function check_ips($limit_ip_1,$limit_ip_2){//允许IP段1~2  check_ips ('127.0.0.1','127.1.0.1');
	if (isok_ip($limit_ip_1)=='false' || isok_ip($limit_ip_2)=='false' ){ //IP不符合规则
		return 'false';
		exit;
	}
	
	$userip = $_SERVER['REMOTE_ADDR']; //获得用户ip 
	$userip_array = explode(".", $userip);//把获得的ip切开成数组
	$limit_ip_array_1= explode(".", $limit_ip_1);
	$limit_ip_array_2= explode(".", $limit_ip_2);
	$ip_no='true';
	
	if( $userip_array[0]>$limit_ip_array_1[0] && $userip_array[0]<$limit_ip_array_2[0] ){//第1层 区间符合     例192.168.0.1
		$ip_no='true';//通过
	}else{
		if( $userip_array[0]>=$limit_ip_array_1[0] && $userip_array[0]<=$limit_ip_array_2[0] ){//第1层 相等符合
			if( $userip_array[1]>$limit_ip_array_1[1] && $userip_array[1]<$limit_ip_array_2[1] ){//第2层 区间符合
				$ip_no='true';//通过
			}else{
				if( $userip_array[1]>=$limit_ip_array_1[1] && $userip_array[1]<=$limit_ip_array_2[1] ){//第2层 相等符合
					if( $userip_array[2]>$limit_ip_array_1[2] && $userip_array[2]<$limit_ip_array_2[2] ){//第3层 区间符合
						$ip_no='true';//通过
					}else{
						if( $userip_array[2]>=$limit_ip_array_1[2] && $userip_array[2]<=$limit_ip_array_2[2] ){//第3层 相等符合
							if( $userip_array[3]>$limit_ip_array_1[3] && $userip_array[3]<$limit_ip_array_2[3] ){//第4层 区间符合
								$ip_no='true';//通过
							}else{
								if( $userip_array[3]>=$limit_ip_array_1[3] && $userip_array[3]<=$limit_ip_array_2[3] ){//第4层 相等符合
									$ip_no='true';//通过
								}else{
									$ip_no='false';
									$ip_nos='4';
								}
							}
						}else{
							$ip_no='false';
							$ip_nos='3';
						}
					}
				}else{
					$ip_no='false';
					$ip_nos='2';
				}
			}
			
		}else{
			$ip_no='false';
			$ip_nos='1';//错误码
		}
	}
	
	return $ip_no;
}
//检测IP地址段---------------

function randomkeys($length)  //生成php随机数
{
	$pattern='ABCDEFGHJKLMNPQRSTUVWXYZ';
	for($i=0;$i<$length;$i++)
	{
		$keyrand .= $pattern{mt_rand(0,23)};    
	}
	return $keyrand;
}

function give_dh_18(){//随时自动生成18位订单号码  精确到微秒，最后两位为随机
	return date('ymd').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99)); //0-99 中可能是1位数，则0补充
}

function keyword_replace($keyword){

	/*
	$keyword=str_replace("[","",$keyword);
	$keyword=str_replace("]","",$keyword);
	$keyword=str_replace("#","",$keyword);
	$keyword=str_replace("@","",$keyword);
	//$keyword=preg_replace('/ +/',' ',$keyword);
	$keyword=trim($keyword);
	*/
	
	// 注意：《》 这两个符号中的》在替换时会产生编码或是区位错误无法解决，造成计算字符个数不准确，所以不做替换(, "【", "】")
	
	$search_nohave   = array(",","/", "\\", ".", ";", ":", "\"", "!", "~", "`", "^", "(", ")", "?", "-", "\t", "\n", "'", "<", ">", "\r", "\r\n", "$", "&", "%", "#", "@", "+", "=", "{", "}", "[", "]", "：", "）", "（", "．", "。", "，", "！", "；", "“", "”", "‘", "’", "［", "］", "、", "—", "　", "－", "…");
	
	foreach ($search_nohave as $search_rep){
		$keyword = str_replace($search_rep,'',$keyword); 
	}
	
	
	return $keyword;
}

function quweima($str){   //转为区位码
	$str=str_replace(' ','',$str);
	$str_qwm = '';
	for($i=0; $i<strlen($str); $i++){
		
		if(preg_match("/^[a-z0-9]+$/i",$str[$i])){
			$str_qwm_new = str_pad($str[$i],6,"A");
		}else{
			$str_c=(@ord($str[$i])>0xa0?substr($str, $i++, 2):substr($str, $i, 1));//提字
			$str_qwm_new = sprintf("%02d%02d",ord($str_c[0])-160,ord($str_c[1])-160);//转为区位码
			$str_qwm_new = $str_qwm_new.$str_qwm_new;
		}

		$str_qwm = $str_qwm.$str_qwm_new." ";//重复组合，防止小于4字符，全文索引不认
	}
	$str_qwm =substr($str_qwm,0,-1);
	
	return $str_qwm;
 
}

function check_tel_mail($str,$leixing){ //检测手机号或邮件格式

	if ($leixing=='1'){
		$pattern="/^(?:13\d|15\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/"; //手机号码
	}elseif ($leixing=='2'){
		$pattern="/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/";//电子邮件
	}
	
	if (preg_match($pattern,$str)){ 
		$check_tel_mail_result='result_true';
	}else{ 
		$check_tel_mail_result='result_false';
	}
	
	return $check_tel_mail_result;
	//check_tel_mail($tel,1); 
} 

function check_str_teshu($str){ //检测特殊字符 小记：涉及 插入mysql 查询mysql 更新mysql 的操作中不能含有\ '，JS如AJAX进行URL参数传递时不能含有\ ' +，+会转为空白
	
	if (strpos($str,"'")===false && strpos($str,'\\')===false && strpos($str,'&')===false && strpos($str,'%')===false && strpos($str,'"')===false ){
		$check_result='result_true';
	}else{
		$check_result='result_false';
	}
	
	return $check_result;
}

function check_null($str){ //检测是否只输入的内容为空格
	
	$str=str_replace('&nbsp;','',$str);//过滤空格
	$str=str_replace(' ','',$str);
	$str=str_replace(PHP_EOL, '', $str); 

	if ($str==''){
		$check_result='0';//空 
	}else{
		$check_result='1';//非空
	}
	
	return $check_result;
} 

function time_show($time){ //将时间通过 天，时分秒，显示
	
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
			$time_result=date("Y-m-d H:i",strtotime($time_start));
			
		}
	}
	
	return $time_result;
} 

function bad_words_jc($words,$fenkefu,$bad_words_s){ //非法词语检测  被检测字词,分隔符,非法词列表
	
	$bad_value="nohave";
	$bad_words_s=explode($fenkefu,$bad_words_s);
	foreach ($bad_words_s as $bad_words_s_pd){
		if ( strpos(str_replace(' ','',$words),$bad_words_s_pd)!==false){//strpos 判断为 !==false  或 ===false
			 $bad_value="badfalse";
		}
	}
	return $bad_value;
	
}

function post_waibu(){//外部提交检测
	$servername=$_SERVER['SERVER_NAME'];//当前运行脚本所在服务器主机的名字。
	$sub_from=$_SERVER["HTTP_REFERER"];//链接到当前页面 的前一页面的 URL 地址
	$sub_len=strlen($servername);//统计服务器的名字长度
	$checkfrom=substr($sub_from,7,$sub_len);//截取提交到前一页面的url，不包含http:://的部分。
	if($checkfrom!=$servername){
		//echo "数据源非法！".$servername."--".$checkfrom;
		exit;
	}
}

function mysubstr($string, $start, $length ,$bianma){//截取字符串 
	//mb_strcut按字节  mb_substr 按字符  php_mbstring.dll  echo mb_substr('测试', 0, 7, 'utf-8');  

	return mb_substr($string, $start, $length, $bianma)."..."; 
} 
//mysubstr("这里是标题", 0, 30)


function keywordlight($keyword,$rstitle,$jingdu){//关键词加亮 jingdu =0 开启模糊，其余任何值为精确，但必须有初始值
	//keywordlight($title_search,clear_all($rs["title"]),'0');
	
	if ($keyword!==''){
	
		if ($jingdu=='0'){//开启模糊查询，利用区位码单字分隔
			$str_qwm = '';
			for($i=0; $i<strlen($keyword); $i++){
				$str_c=(@ord($keyword[$i])>0xa0?substr($keyword, $i++, 2):substr($keyword, $i, 1));//将字以空格断开
				$str_qwm = $str_qwm.$str_c." ";
			}
			
			$keyword=$str_qwm;
		}
		
		$word = explode(' ',$keyword);
		$length = count($word);
		for($iop = 0; $iop < $length; $iop++){  
			$rstitle=str_ireplace($word[$iop],"{##}".$word[$iop]."{@@}",$rstitle);
			
		}
		
		$rstitle=str_replace("{##}","<span style='color:#FF0000;' >",$rstitle); //转换成特殊标记，标题不能含有特殊文字
		$rstitle=str_replace("{@@}","</span>",$rstitle);
		
		return $rstitle;

	}else{
		return $rstitle;
	}
	
}  


function quotes_gpc_pd($gpc_value,$gpc_pd){ //quotes_gpc_pd("内容",1)    //转义字符   注意：checkbox[]数组时不能用这个，要不implode出错

	/*if (!get_magic_quotes_gpc()) {
		$gpc_value = addslashes($gpc_value);    // delete backslash(\)
	}
	
	if ($gpc_pd=='1') {
		$gpc_value=htmlspecialchars($gpc_value);
	}*/
	
	if (!get_magic_quotes_gpc()) {
		$gpc_value = addslashes($gpc_value);    // delete backslash(\)
	}
	
	if ($gpc_pd=='1') {
		$gpc_value=htmlspecialchars($gpc_value,ENT_COMPAT,'ISO-8859-1');
	}
	
	return $gpc_value; 
	
}



//---------------URL加密-----------------
function keyED($txt,$encrypt_key){       
    $encrypt_key =    md5($encrypt_key);
    $ctr=0;       
    $tmp = "";       
    for($i=0;$i<strlen($txt);$i++)       
    {           
        if ($ctr==strlen($encrypt_key))
        $ctr=0;           
        $tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
        $ctr++;       
    }       
    return $tmp;   
}    

function encrypt($txt,$key)   {
    $encrypt_key = md5(mt_rand(0,100));
    $ctr=0;       
    $tmp = "";      
     for ($i=0;$i<strlen($txt);$i++)       
     {
        if ($ctr==strlen($encrypt_key))
            $ctr=0;           
        $tmp.=substr($encrypt_key,$ctr,1) . (substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1));
        $ctr++;       
     }       
     return keyED($tmp,$key);
} 
   
function decrypt($txt,$key){       
    $txt = keyED($txt,$key);       
    $tmp = "";       
    for($i=0;$i<strlen($txt);$i++)       
    {           
        $md5 = substr($txt,$i,1);
        $i++;           
        $tmp.= (substr($txt,$i,1) ^ $md5);       
    }       
    return $tmp;
}

function encrypt_url($url,$key){
    return rawurlencode(base64_encode(encrypt($url,$key)));
}

function decrypt_url($url,$key){
    return decrypt(base64_decode(rawurldecode($url)),$key);
}

function geturl($str,$key){
    $str = decrypt_url($str,$key);
    $url_array = explode('&',$str);
    if (is_array($url_array))
    {
        foreach ($url_array as $var)
        {
            $var_array = explode("=",$var);
            $vars[$var_array[0]]=$var_array[1];
        }
    }
    return $vars;
}

$key_url_md_5 = 'lei_mdaima2015'; //独立的加密标记，防破解

/*读取方法
	<a href="abc.php?<?=encrypt_url("id=".$rs->id."&page=".$page."&time=".time(),$key_url_md_5)?>" >修改</a>

	$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
	$page=$get['page'];
	$id=$get['id'];
	
	var_dump($url_info); //输出变量
*/

//---------------URL加密-----------------


function url_jiahao($urlwords,$order){ //URL链接中的+号改为特殊字符 $order 1 转义，2还原
	
	if ($order=='1'){
		$urlwords=str_replace('+','{add}',$urlwords); //转义
	}elseif ($order=='2'){
		$urlwords=str_replace('{add}','+',$urlwords); //还原
	}
	return $urlwords;
	
}

function get_week($a){
	$weekarray=array("日","一","二","三","四","五","六");
	return "星期".$weekarray[date("w",strtotime($a))];
}

function alert_ini(){//输出alert所需文件
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '<head>';
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
	echo '<script type="text/javascript" charset="gbk" src="js/jquery.min.js"></script>';
	echo '<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">';
	echo '<link href="css/admin_style.css" rel="stylesheet" />';
	echo '<script src="js/bootstrap.min.js"></script>';
	echo '</head>';
	echo '<body>';
	include_once("js/js_alert.php");
	echo '</body></html>';
	
}

function alert_ini_index(){//输出alert所需文件
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '<head>';
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
	echo '<script type="text/javascript" charset="gbk" src="/js/jquery-1.8.3.min.js"></script>';
	echo '<link href="/css/bootstrap_modal.min.css" rel="stylesheet" media="screen">';
	echo '<link href="/style.css" rel="stylesheet" />';
	echo '<script src="/js/bootstrap.min.js"></script>';
	echo '</head>';
	echo '<body>';
	include_once("./js/js_alert.php");
	echo '</body></html>';
	
}


/****************************************************************************************************
*功能：对字符串进行加密处理
*参数一：需要加密的内容
*参数二：密钥
*/

$key_str_md_5='mdaima_1987_lei';  //密钥

function passport_encrypt($str,$key){ //加密函数
	srand((double)microtime() * 1000000);
	$encrypt_key=md5(rand(0, 32000));
	$ctr=0;
	$tmp='';
	for($i=0;$i<strlen($str);$i++){
		$ctr=$ctr==strlen($encrypt_key)?0:$ctr;
		$tmp.=$encrypt_key[$ctr].($str[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp,$key));
}


/*
*功能：对字符串进行解密处理
*参数一：需要解密的密文
*参数二：密钥
*/
function passport_decrypt($str,$key){ //解密函数
	$str=passport_key(base64_decode($str),$key);
	$tmp='';
	for($i=0;$i<strlen($str);$i++){
		$md5=$str[$i];
		$tmp.=$str[++$i] ^ $md5;
	}
	return $tmp;
}
 
 
/*
*辅助函数
*/
function passport_key($str,$encrypt_key){
	$encrypt_key=md5($encrypt_key);
	$ctr=0;
	$tmp='';
	for($i=0;$i<strlen($str);$i++){
		$ctr=$ctr==strlen($encrypt_key)?0:$ctr;
		$tmp.=$str[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}
 
//passport_encrypt($str,$key);

//****************************************************************************************************
 
 
 
function isMobile() {
  // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
  if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
    return true;
  }
  // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
  if (isset($_SERVER['HTTP_VIA'])) {
    // 找不到为flase,否则为true
    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
  }
  // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
    // 从HTTP_USER_AGENT中查找手机浏览器的关键字
    if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
      return true;
    }
  }
  // 协议法，因为有可能不准确，放到最后判断
  if (isset ($_SERVER['HTTP_ACCEPT'])) {
    // 如果只支持wml并且不支持html那一定是移动设备
    // 如果支持wml和html但是wml在html之前则是移动设备
    if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
      return true;
    }
  }
  return false;
}
?>