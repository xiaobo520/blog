<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$action_pd='question';

if ($action_pd=='question'){
	$questions_num=0;
	$result_zidian=$mysqli->query("show status like '%Questions%'");//connections  
	if($mysqllast=$result_zidian->fetch_assoc()){
		//$questions_num=$mysqllast['status'];//����ID
		$questions_num=$mysqllast["Value"];
	}
	echo $questions_num;
	//print_r($mysqllast);
}

if ($action_pd=='memory'){ //�����status_mysql�еı������ƶ�Ӧ
	//$to_ping = "127.0.0.1"; 
	//exec("ping ".$to_ping, $list);   //ping -n 1 www.baidu.com , tasklist
	//exec("tasklist", $list); 
	
	exec("tasklist", $list);
	$i=-1;
	foreach( $list as $s ){
		$i++;
		//echo $list[$i]."</br>";
		if ( strpos( $s , 'mysqld-nt.exe' ) !== false ){ //�жϵ�ǰ�����ڴ�
			$show_0=preg_replace("/[\s]+/is"," ",$s); //�滻����ո�Ϊһ��
			$show_1=explode(" ",$show_0);
			$show_2=str_replace(',','',$show_1[4]);//ȥ����ѧ�������Ķ���
			echo $show_2;
			break;
		}
	}
}
?>