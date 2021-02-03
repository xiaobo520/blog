<?php
include_once("./mdaima_var_inc/config_system.php");
include_once("./mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("./mdaima_var_inc/conn.php");

$cid=$_POST['cid'];
$atab=$_POST['atab'];

if ($cid!="" ){
	
	if ($atab=='1'){ //更新主题表及回复表判定
		$answtalbe_an="lei_jingyan_hf";
	}elseif ($atab=='2'){
		$answtalbe_an="lei_news_hf";
	}elseif ($atab=='3'){
		$answtalbe_an="lei_message_hf";
	}
	
	$sql_3="select * from ".$answtalbe_an." where cid_hf='".$cid."' order by id limit 5,100";//从第5个开始
	$iloi3=5;
	$get_str='';
	$result_3=$mysqli->query($sql_3);
	while ($rs_3=$result_3->fetch_assoc()){
		$iloi3++;

		$get_str=$get_str."<div class='hf_top_line'></div><div id='hf_hf_two'><div style='float:left; width:60px; text-align:left'><img src='".$rs_3["xuan_img"]."' class='hf_img_f'/></div><div style='float:left; width:550px;'><div class='hf_user_info'><div class='hf_uandd'>".iconv("gbk","utf-8",$rs_3["nicheng"])." <span style='font-size:14px; color: #999999'>&nbsp;&nbsp;".iconv("gbk","utf-8",'回复')."&nbsp;&nbsp;</span> <span style='font-size:14px; color: #009966; font-weight:bold;'>".iconv("gbk","utf-8",$rs_3["cid_str"])."</span><span>&nbsp;&nbsp;/&nbsp;&nbsp;".iconv("gbk","utf-8",$rs_3["indate"])."</span></div><div class='hf_click fulou'><a href='javascript:void(0);' onclick=second_hf('".$cid."','".iconv('gbk','utf-8',$rs_3["nicheng"])."','".iconv('gbk','utf-8',passport_encrypt($rs_3["username"],$key_str_md_5))."')> ".iconv("gbk","utf-8",'回复-'.$iloi3.'楼')."</a></div></div><div class='hf_message'>".iconv("gbk","utf-8",$rs_3["content"])."</div></div><div class='clear'></div></div>";
		
	}
	echo $get_str;
}else{
	echo "<span style='color:red'>没有找到内容！</span>";
}
?>