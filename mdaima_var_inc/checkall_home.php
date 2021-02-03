<?php
include_once("./mdaima_var_inc/config_system.php");

if($_SESSION['user_lei_username']=='' || !isset($_SESSION['user_lei_username']) ){
	echo "<script language=javascript>alert('±§Ç¸£¬ÇëÏÈµÇÂ¼£¡');top.location.href='login.html';</script>";
	exit;
}
?>