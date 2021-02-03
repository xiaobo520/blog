<?php
//session_save_path("D:/appserv/session/xxhc/"); //�������session_start()ǰ  ��δ���ã�Ŀǰ���ö�ʱˢ��ͨѶ
//ini_set('session.gc_maxlifetime',7200);//session��ʱ 7200��  ��δ���ã�Ŀǰ���ö�ʱˢ��ͨѶ
session_start();//����session���ܣ���ǰ�������κ����
header("Cache-control: private"); //������ҳ������
header("Content-Type: text/html;charset=GB2312");
date_default_timezone_set ("PRC");//����ʱ��
set_time_limit(0);
ini_set('memory_limit','128M');
//phpinfo();

//#####################################################ϵͳ����
function textareaencode($area_str){//�������ݿ�
	if ($area_str!=''){
		$area_str = str_replace(CHR(32),"&nbsp;",$area_str);
		$area_str = str_replace(CHR(13),"</BR>",$area_str); //�س�
		//$area_str = str_replace(CHR(10),"</BR>",$area_str); //����
		//$area_str = str_replace(array("\r\n", "\r", "\n"), "</BR>", $area_str); //�����滻����ͬϵͳ���Ų�ͬ
		//$area_str = str_replace(CHR(10),"<BR>",$area_str);
	}
	return $area_str;
}

function textareadecode($area_str){//��ȡ���ݿ�
	if ($area_str!=''){
		$area_str = str_replace("&nbsp;",CHR(32),$area_str);
		$area_str = str_replace("</BR>",CHR(13),$area_str);
		$area_str = str_replace("<br>",CHR(13),$area_str);
		//$area_str = str_replace(CHR(10),"<BR>",$area_str);
	}
	return $area_str;
}

function text_word($area_str){//word�����ת��Ϊͳһ
	if ($area_str!=''){
		$area_str = str_replace("</BR>","<br>",$area_str);
		$area_str = str_replace("<br />","<br>",$area_str);
		$area_str = str_replace("<br/>","<br>",$area_str);
		//$area_str = str_replace(CHR(10),"<BR>",$area_str);
	}
	return $area_str;
}

function text_excel($area_str){//word�����ת��Ϊͳһ
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

function clear_all($area_str){ //���˳ɴ��ı�������ʾ
	if ($area_str!=''){
		$area_str = trim($area_str); //����ַ������ߵĿո�
		$area_str = strip_tags($area_str,""); //����php�Դ��ĺ������html��ʽ
		$area_str = str_replace("&nbsp;","",$area_str);
		
		$area_str = preg_replace("/\t/","",$area_str); //ʹ��������ʽ�滻���ݣ��磺�ո񣬻��У������滻Ϊ�ա�
		$area_str = preg_replace("/\r\n/","",$area_str); 
		$area_str = preg_replace("/\r/","",$area_str); 
		$area_str = preg_replace("/\n/","",$area_str); 
		$area_str = preg_replace("/ /","",$area_str);
		$area_str = preg_replace("/  /","",$area_str);  //ƥ��html�еĿո�
		$area_str = trim($area_str); //�����ַ���
	}
	return $area_str;
}

function getfirstchar($s0){  //��ȡ����ĸ
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
		
function pinyin_g($zh){//ת��ƴ������ĸ��Ҳ����ʹ�� js/pinyin.js
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

function jilu_in($username,$jifen,$leixing,$bz){ //��¼���ֲ���  �û��������֣�����  $caozuo��denglujiangli/huitie/sharejiangli/���ֵ���/΢�Ź�ע/�����
	$userip = $_SERVER['REMOTE_ADDR']; //����û�ip 
	$indate= date("Y-m-d");
	$intime= date("Y-m-d H:i:s");
	global $mysqli;//����$mysqliΪȫ�ֱ���
	
	if ($leixing=='denglujiangli'){
		$sql_cz="select id from lei_jifen where username='".$username."' and indate='".$indate."' and leixing='denglujiangli' ";//ÿ��ÿ�����һ����ȡ
		$result=$mysqli->query($sql_cz);
		if(!$rs_cz=$result->fetch_assoc()){
		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//���»���
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
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//���»���
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
		if ($jilucount<5){//ÿ���޻������ٴλ����ڸ�����
		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//���»���
			$mysqli->query($sql_in);
			
		}

	}
	
	if ($leixing=='pintu'){//ƴͼ��ÿ����1��   �з���ֵ

		$sql_jilu="select count(*) from lei_jifen where username='".$username."' and indate='".$indate."' and leixing='pintu' ";
		$result_jilu=$mysqli->query($sql_jilu);
		$rs_jilu=$result_jilu->fetch_array();
		$jilucount=$rs_jilu[0];
		if ($jilucount<1){
		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			$sql_in="update lei_user set jifen=jifen+".$jifen.",jifen_all=jifen_all+".$jifen." where username='".$username."' limit 1 ";//���»���
			$mysqli->query($sql_in);
			
			return '��ȡ����OK';
			
		}else{
			return '��ȡ����NO';
		}

	}
	
	if ($leixing=='qita' && $jifen<>0){//�������ּ�¼��ʹ������������ڱ�ע��˵����;���������������һ������ֿ���Ϊ��ֵ�����Ϊ�۷����ʷ�ܻ��ֲ��ܼ�

		
			$sql_in="insert into lei_jifen (username,indate,intime,jifen,leixing,ip,bz) values ('".$username."','".$indate."','".$intime."','".$jifen."','".$leixing."','".$userip."','".$bz."') ";
			$mysqli->query($sql_in);
			
			if ($jifen>0){ //ֻ�мӷ�ʱ��ʷ���ֲżӣ�����ʱ����
				$jifen_all_str=",jifen_all=jifen_all+".$jifen.""; 
			}else{
				$jifen_all_str="";
			}
			
			$sql_in="update lei_user set jifen=jifen+".$jifen."".$jifen_all_str." where username='".$username."' limit 1 ";//���»���
			$mysqli->query($sql_in);

	}
	
	
	
}

function limit_check($limit_radio,$limit_user){ //Ȩ���ж�  true�����д�Ȩ��
	if(strpos($limit_user,",".$limit_radio.",")!==false){ 
		return 'true'; 
	}else{ 
		return 'false';
	}
}

function isok_ip($ip){ //�ж�IP�Ƿ���ȷ��ʽ
	if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip)){ 
		return 'true'; 
	}else{ 
		return 'false';
	}
}

//���IP��ַ��---------------
function check_ips($limit_ip_1,$limit_ip_2){//����IP��1~2  check_ips ('127.0.0.1','127.1.0.1');
	if (isok_ip($limit_ip_1)=='false' || isok_ip($limit_ip_2)=='false' ){ //IP�����Ϲ���
		return 'false';
		exit;
	}
	
	$userip = $_SERVER['REMOTE_ADDR']; //����û�ip 
	$userip_array = explode(".", $userip);//�ѻ�õ�ip�п�������
	$limit_ip_array_1= explode(".", $limit_ip_1);
	$limit_ip_array_2= explode(".", $limit_ip_2);
	$ip_no='true';
	
	if( $userip_array[0]>$limit_ip_array_1[0] && $userip_array[0]<$limit_ip_array_2[0] ){//��1�� �������     ��192.168.0.1
		$ip_no='true';//ͨ��
	}else{
		if( $userip_array[0]>=$limit_ip_array_1[0] && $userip_array[0]<=$limit_ip_array_2[0] ){//��1�� ��ȷ���
			if( $userip_array[1]>$limit_ip_array_1[1] && $userip_array[1]<$limit_ip_array_2[1] ){//��2�� �������
				$ip_no='true';//ͨ��
			}else{
				if( $userip_array[1]>=$limit_ip_array_1[1] && $userip_array[1]<=$limit_ip_array_2[1] ){//��2�� ��ȷ���
					if( $userip_array[2]>$limit_ip_array_1[2] && $userip_array[2]<$limit_ip_array_2[2] ){//��3�� �������
						$ip_no='true';//ͨ��
					}else{
						if( $userip_array[2]>=$limit_ip_array_1[2] && $userip_array[2]<=$limit_ip_array_2[2] ){//��3�� ��ȷ���
							if( $userip_array[3]>$limit_ip_array_1[3] && $userip_array[3]<$limit_ip_array_2[3] ){//��4�� �������
								$ip_no='true';//ͨ��
							}else{
								if( $userip_array[3]>=$limit_ip_array_1[3] && $userip_array[3]<=$limit_ip_array_2[3] ){//��4�� ��ȷ���
									$ip_no='true';//ͨ��
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
			$ip_nos='1';//������
		}
	}
	
	return $ip_no;
}
//���IP��ַ��---------------

function randomkeys($length)  //����php�����
{
	$pattern='ABCDEFGHJKLMNPQRSTUVWXYZ';
	for($i=0;$i<$length;$i++)
	{
		$keyrand .= $pattern{mt_rand(0,23)};    
	}
	return $keyrand;
}

function give_dh_18(){//��ʱ�Զ�����18λ��������  ��ȷ��΢�룬�����λΪ���
	return date('ymd').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99)); //0-99 �п�����1λ������0����
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
	
	// ע�⣺���� �����������еġ����滻ʱ��������������λ�����޷��������ɼ����ַ�������׼ȷ�����Բ����滻(, "��", "��")
	
	$search_nohave   = array(",","/", "\\", ".", ";", ":", "\"", "!", "~", "`", "^", "(", ")", "?", "-", "\t", "\n", "'", "<", ">", "\r", "\r\n", "$", "&", "%", "#", "@", "+", "=", "{", "}", "[", "]", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��");
	
	foreach ($search_nohave as $search_rep){
		$keyword = str_replace($search_rep,'',$keyword); 
	}
	
	
	return $keyword;
}

function quweima($str){   //תΪ��λ��
	$str=str_replace(' ','',$str);
	$str_qwm = '';
	for($i=0; $i<strlen($str); $i++){
		
		if(preg_match("/^[a-z0-9]+$/i",$str[$i])){
			$str_qwm_new = str_pad($str[$i],6,"A");
		}else{
			$str_c=(@ord($str[$i])>0xa0?substr($str, $i++, 2):substr($str, $i, 1));//����
			$str_qwm_new = sprintf("%02d%02d",ord($str_c[0])-160,ord($str_c[1])-160);//תΪ��λ��
			$str_qwm_new = $str_qwm_new.$str_qwm_new;
		}

		$str_qwm = $str_qwm.$str_qwm_new." ";//�ظ���ϣ���ֹС��4�ַ���ȫ����������
	}
	$str_qwm =substr($str_qwm,0,-1);
	
	return $str_qwm;
 
}

function check_tel_mail($str,$leixing){ //����ֻ��Ż��ʼ���ʽ

	if ($leixing=='1'){
		$pattern="/^(?:13\d|15\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/"; //�ֻ�����
	}elseif ($leixing=='2'){
		$pattern="/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/";//�����ʼ�
	}
	
	if (preg_match($pattern,$str)){ 
		$check_tel_mail_result='result_true';
	}else{ 
		$check_tel_mail_result='result_false';
	}
	
	return $check_tel_mail_result;
	//check_tel_mail($tel,1); 
} 

function check_str_teshu($str){ //��������ַ� С�ǣ��漰 ����mysql ��ѯmysql ����mysql �Ĳ����в��ܺ���\ '��JS��AJAX����URL��������ʱ���ܺ���\ ' +��+��תΪ�հ�
	
	if (strpos($str,"'")===false && strpos($str,'\\')===false && strpos($str,'&')===false && strpos($str,'%')===false && strpos($str,'"')===false ){
		$check_result='result_true';
	}else{
		$check_result='result_false';
	}
	
	return $check_result;
}

function check_null($str){ //����Ƿ�ֻ���������Ϊ�ո�
	
	$str=str_replace('&nbsp;','',$str);//���˿ո�
	$str=str_replace(' ','',$str);
	$str=str_replace(PHP_EOL, '', $str); 

	if ($str==''){
		$check_result='0';//�� 
	}else{
		$check_result='1';//�ǿ�
	}
	
	return $check_result;
} 

function time_show($time){ //��ʱ��ͨ�� �죬ʱ���룬��ʾ
	
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
			$time_result=date("Y-m-d H:i",strtotime($time_start));
			
		}
	}
	
	return $time_result;
} 

function bad_words_jc($words,$fenkefu,$bad_words_s){ //�Ƿ�������  ������ִ�,�ָ���,�Ƿ����б�
	
	$bad_value="nohave";
	$bad_words_s=explode($fenkefu,$bad_words_s);
	foreach ($bad_words_s as $bad_words_s_pd){
		if ( strpos(str_replace(' ','',$words),$bad_words_s_pd)!==false){//strpos �ж�Ϊ !==false  �� ===false
			 $bad_value="badfalse";
		}
	}
	return $bad_value;
	
}

function post_waibu(){//�ⲿ�ύ���
	$servername=$_SERVER['SERVER_NAME'];//��ǰ���нű����ڷ��������������֡�
	$sub_from=$_SERVER["HTTP_REFERER"];//���ӵ���ǰҳ�� ��ǰһҳ��� URL ��ַ
	$sub_len=strlen($servername);//ͳ�Ʒ����������ֳ���
	$checkfrom=substr($sub_from,7,$sub_len);//��ȡ�ύ��ǰһҳ���url��������http:://�Ĳ��֡�
	if($checkfrom!=$servername){
		//echo "����Դ�Ƿ���".$servername."--".$checkfrom;
		exit;
	}
}

function mysubstr($string, $start, $length ,$bianma){//��ȡ�ַ��� 
	//mb_strcut���ֽ�  mb_substr ���ַ�  php_mbstring.dll  echo mb_substr('����', 0, 7, 'utf-8');  

	return mb_substr($string, $start, $length, $bianma)."..."; 
} 
//mysubstr("�����Ǳ���", 0, 30)


function keywordlight($keyword,$rstitle,$jingdu){//�ؼ��ʼ��� jingdu =0 ����ģ���������κ�ֵΪ��ȷ���������г�ʼֵ
	//keywordlight($title_search,clear_all($rs["title"]),'0');
	
	if ($keyword!==''){
	
		if ($jingdu=='0'){//����ģ����ѯ��������λ�뵥�ַָ�
			$str_qwm = '';
			for($i=0; $i<strlen($keyword); $i++){
				$str_c=(@ord($keyword[$i])>0xa0?substr($keyword, $i++, 2):substr($keyword, $i, 1));//�����Կո�Ͽ�
				$str_qwm = $str_qwm.$str_c." ";
			}
			
			$keyword=$str_qwm;
		}
		
		$word = explode(' ',$keyword);
		$length = count($word);
		for($iop = 0; $iop < $length; $iop++){  
			$rstitle=str_ireplace($word[$iop],"{##}".$word[$iop]."{@@}",$rstitle);
			
		}
		
		$rstitle=str_replace("{##}","<span style='color:#FF0000;' >",$rstitle); //ת���������ǣ����ⲻ�ܺ�����������
		$rstitle=str_replace("{@@}","</span>",$rstitle);
		
		return $rstitle;

	}else{
		return $rstitle;
	}
	
}  


function quotes_gpc_pd($gpc_value,$gpc_pd){ //quotes_gpc_pd("����",1)    //ת���ַ�   ע�⣺checkbox[]����ʱ�����������Ҫ��implode����

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



//---------------URL����-----------------
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

$key_url_md_5 = 'lei_mdaima2015'; //�����ļ��ܱ�ǣ����ƽ�

/*��ȡ����
	<a href="abc.php?<?=encrypt_url("id=".$rs->id."&page=".$page."&time=".time(),$key_url_md_5)?>" >�޸�</a>

	$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);
	$page=$get['page'];
	$id=$get['id'];
	
	var_dump($url_info); //�������
*/

//---------------URL����-----------------


function url_jiahao($urlwords,$order){ //URL�����е�+�Ÿ�Ϊ�����ַ� $order 1 ת�壬2��ԭ
	
	if ($order=='1'){
		$urlwords=str_replace('+','{add}',$urlwords); //ת��
	}elseif ($order=='2'){
		$urlwords=str_replace('{add}','+',$urlwords); //��ԭ
	}
	return $urlwords;
	
}

function get_week($a){
	$weekarray=array("��","һ","��","��","��","��","��");
	return "����".$weekarray[date("w",strtotime($a))];
}

function alert_ini(){//���alert�����ļ�
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

function alert_ini_index(){//���alert�����ļ�
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
*���ܣ����ַ������м��ܴ���
*����һ����Ҫ���ܵ�����
*����������Կ
*/

$key_str_md_5='mdaima_1987_lei';  //��Կ

function passport_encrypt($str,$key){ //���ܺ���
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
*���ܣ����ַ������н��ܴ���
*����һ����Ҫ���ܵ�����
*����������Կ
*/
function passport_decrypt($str,$key){ //���ܺ���
	$str=passport_key(base64_decode($str),$key);
	$tmp='';
	for($i=0;$i<strlen($str);$i++){
		$md5=$str[$i];
		$tmp.=$str[++$i] ^ $md5;
	}
	return $tmp;
}
 
 
/*
*��������
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
  // �����HTTP_X_WAP_PROFILE��һ�����ƶ��豸
  if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
    return true;
  }
  // ���via��Ϣ����wap��һ�����ƶ��豸,���ַ����̻����θ���Ϣ
  if (isset($_SERVER['HTTP_VIA'])) {
    // �Ҳ���Ϊflase,����Ϊtrue
    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
  }
  // �Բз����ж��ֻ����͵Ŀͻ��˱�־,�������д���ߡ�����'MicroMessenger'�ǵ���΢��
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
    // ��HTTP_USER_AGENT�в����ֻ�������Ĺؼ���
    if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
      return true;
    }
  }
  // Э�鷨����Ϊ�п��ܲ�׼ȷ���ŵ�����ж�
  if (isset ($_SERVER['HTTP_ACCEPT'])) {
    // ���ֻ֧��wml���Ҳ�֧��html��һ�����ƶ��豸
    // ���֧��wml��html����wml��html֮ǰ�����ƶ��豸
    if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
      return true;
    }
  }
  return false;
}
?>