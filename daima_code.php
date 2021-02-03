<?php
include_once("./mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php"); 

$action = $_POST['action'];
$id = $_POST['id'];

if (!is_numeric($id)){
	echo "<pre><code class='txt'>ERROR【3007】</code></pre>";
	exit;
}

if ($id!='' && $action=='show' ){
	$sql="select message from lei_daima where id='".$id."' limit 1";
	$result=$mysqli->query($sql);
		
	if($rs=$result->fetch_assoc()){
	
		$message=$rs["message"];

		echo $message;
		exit;
	}else{
		echo "<pre><code class='txt'>ERROR【3008】</code></pre>";
		$mysqli->close();
		exit;
	}
}

?>