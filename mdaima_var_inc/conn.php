<?
	error_reporting(0);
	
	$mysqli=new mysqli("localhost", "zblog_yubo", "88888888", "zblog_yubo");
	if(mysqli_connect_errno()){
		echo "´íÎó£º".mysqli_connect_error();
		exit;
	}else{
		$mysqli->query("set names 'gbk'");
	}
	
	//$mysqli->close();
	//$result->free();
	
?>