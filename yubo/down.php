<?
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

$url=base64_decode($url_info['url']);
$time=$url_info['time'];
$filename=$url_info['filename'];

if ( (time()-$time)>$var_outhours*3600 ){
	echo "<script language=javascript>alert('网页过期，禁止操作！');javascript:history.back(-1);</script>";
	exit;
}


function fileext($filename) 
{ 
	return substr(strrchr($filename, '.'), 1); 
}

if(is_file($url)) {
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".$filename.".".fileext($url).""); //basename  只要文件名 basename($path,".php");如果文件有 .php，则不会输出这个扩展名,显示不带有文件扩展名的文件名。
	readfile($url);
	exit;
}else{
	echo "文件不存在！";
	exit;
}

/*
用户上传模块，需要将用户上传的文件改名后保存，便于系统管理。但在用户下载文件时处于人性化考虑需要将上传的文件改回原来的名称，所以在上传时，需要保存用户原始文件的文件名，以备后面下载使用。下载时使用header函数进行相应的转化，代码如下：  
header(‘Content-type: application/octet-stream’);//输出的类型,根据下面提供的MIME表，选择相应的类型  
header(‘Content-Disposition: attachment; filename=”下载显示名字.rar”‘);//下载显示的名字  
readfile(‘服务器上的文件名.rar’);//要下的文件,包括路径  

常用的MIME类型  
.doc    application/msword  
.docx   application/vnd.openxmlformats-officedocument.wordprocessingml.document  
.rtf    application/rtf  
.xls    application/vnd.ms-excel application/x-excel  
.xlsx   application/vnd.openxmlformats-officedocument.spreadsheetml.sheet  
.ppt    application/vnd.ms-powerpoint  
.pptx   application/vnd.openxmlformats-officedocument.presentationml.presentation  
.pps   application/vnd.ms-powerpoint  
.ppsx  application/vnd.openxmlformats-officedocument.presentationml.slideshow  
.pdf   application/pdf  
.swf   application/x-shockwave-flash  
.dll   application/x-msdownload  
.exe   application/octet-stream  
.msi   application/octet-stream  
.chm   application/octet-stream  
.cab   application/octet-stream  
.ocx   application/octet-stream  
.rar  application/octet-stream  
.tar  application/x-tar  
.tgz  application/x-compressed  
.zip  application/x-zip-compressed  
.z    application/x-compress  
.wav   audio/wav  
.wma   audio/x-ms-wma  
.wmv   video/x-ms-wmv  
.mp3 .mp2 .mpe .mpeg .mpg   audio/mpeg  
.rm   application/vnd.rn-realmedia  
.mid .midi .rmi   audio/mid  
.bmp   image/bmp  
.gif   image/gif  
.png   image/png  
.tif .tiff    image/tiff  
.jpe .jpeg .jpg    image/jpeg  
.txt  text/plain  
.xml  text/xml  
.html text/html  
.css  text/css  
.js   text/javascript  
*/
?>