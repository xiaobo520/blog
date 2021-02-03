<?php
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$action=$_REQUEST['action'];
$pinzhong=strtoupper(str_replace(' ','',$_REQUEST['pinzhong']));

if ($action=="chk"){

	if ($pinzhong=='' ){
		echo "error_no_pz|0";
		exit;
	}
	
	$sql="select id,nicheng from lei_user where nicheng like '%".$pinzhong."%' or nicheng_py like '%".$pinzhong."%' ";
	$result=$mysqli->query($sql);
	if($rs=$result->fetch_assoc()){
		
		$pinzhongs_str='';
		
		$sql_search2="select id,nicheng from lei_user where nicheng like '%".$pinzhong."%' or nicheng_py like '%".$pinzhong."%'  ";
		$result2=$mysqli->query($sql_search2);
		while ($rs2=$result2->fetch_assoc()){
			
			//hidefocus="true" onMouseOver="this.focus()"
			$pinzhongs_str=$pinzhongs_str.'<tr><td width="170" align="left" valign="middle" bgcolor="#ffffff">&nbsp; <a href="javascript:void(0);" hidefocus="true" onclick=document.getElementById("nicheng_search").value="'.$rs2["nicheng"].'";close_pz(); >'.$rs2["nicheng"].'</a></td></tr>';
		}
		
		$pinzhongs_str=$pinzhongs_str.'<tr><td width="170" align="left" valign="middle" bgcolor="#ffffff" >&nbsp; <a href="javascript:void(0);" hidefocus="true" onclick=close_pz(); style=color:blue><i class="icon-remove"></i>  关闭 </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" hidefocus="true" onclick=document.getElementById("nicheng_search").value="";close_pz(); style=color:blue><i class="icon-refresh"></i>  清空 </a></td></tr>';
		
		$pinzhongs_str_1='<table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >';
		
		$pinzhongs_str_2='</table>';
		
		$pinzhongs_str=$pinzhongs_str_1.$pinzhongs_str.$pinzhongs_str_2;
		
		$pinzhongs_str=mb_convert_encoding($pinzhongs_str, "UTF-8", "GBK");
		echo "right|".$pinzhongs_str;
		exit;
		
	}else{
		echo "error_no_pz|0";
		exit;
	}
	$mysqli->close();

}
?>
