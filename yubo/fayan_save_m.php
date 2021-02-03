<?php
//用UTF-8编码，防止文字乱码

include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$action = quotes_gpc_pd($_POST['action'],1);
$id = quotes_gpc_pd($_POST['id'],1);
$table = quotes_gpc_pd($_POST['table'],1);
$message1 = $_POST['message1'];
//$message2 = $_POST['message2'];
//$message3 = $_POST['message3'];
$message1 = iconv("utf-8","gbk",$message1);
//$message2 = iconv("utf-8","gbk",$message2);
//$message3 = iconv("utf-8","gbk",$message3);

if ($action=='save' ){
		$indate=date("Y-m-d H:i:s");
		$sql="select content from ".$table." where id='".$id."' limit 1";
		$result=$mysqli->query($sql);
		if ($rs=$result->fetch_assoc()){
			$sql="update ".$table." set content='".$message1."' where id='".$id."' limit 1";
			$mysqli->query($sql);
			
			$echo_str="ok{#|#}".mysubstr(clear_all($message1),0, 55,'utf-8');
			
		}else{
			
			$echo_str="error{#|#}error"; //.iconv("gbk","utf-8",'ID编码错误')
		}
		
		echo $echo_str;
}


if ($id!=''  && $action=='read' ){

		$sql="select content from ".$table." where id='".$id."' limit 1";
		$result=$mysqli->query($sql);
		if ($rs=$result->fetch_assoc()){
			$message1=$rs["content"];
			//$message2=$rs["message2"];
			//$message3=$rs["message3"];
			
			//$echo_str="yes|".iconv("gbk","utf-8",$message1)."|".iconv("gbk","utf-8",$message2)."|".iconv("gbk","utf-8",$message3);
			$echo_str="yes|".$message1;
		}else{
			
			//$echo_str="no|||";
			$echo_str="no|";
		}
		
		echo $echo_str;

}



?>