<?
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$action_pd='question';

if ($action_pd=='question'){
	$questions_num=0;
	$result_zidian=$mysqli->query("show status like '%Questions%'");//connections  
	if($mysqllast=$result_zidian->fetch_assoc()){
		//$questions_num=$mysqllast['status'];//关联ID
		$questions_num=$mysqllast["Value"];
	}
	echo $questions_num;
	//print_r($mysqllast);
}

if ($action_pd=='memory'){ //需配合status_mysql中的报表名称对应
	//$to_ping = "127.0.0.1"; 
	//exec("ping ".$to_ping, $list);   //ping -n 1 www.baidu.com , tasklist
	//exec("tasklist", $list); 
	
	exec("tasklist", $list);
	$i=-1;
	foreach( $list as $s ){
		$i++;
		//echo $list[$i]."</br>";
		if ( strpos( $s , 'mysqld-nt.exe' ) !== false ){ //判断当前进程内存
			$show_0=preg_replace("/[\s]+/is"," ",$s); //替换多个空格为一个
			$show_1=explode(" ",$show_0);
			$show_2=str_replace(',','',$show_1[4]);//去掉科学计数法的逗号
			echo $show_2;
			break;
		}
	}
}
?>