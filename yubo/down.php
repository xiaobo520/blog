<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

$url=base64_decode($url_info['url']);
$time=$url_info['time'];
$filename=$url_info['filename'];

if ( (time()-$time)>$var_outhours*3600 ){
	echo "<script language=javascript>alert('��ҳ���ڣ���ֹ������');javascript:history.back(-1);</script>";
	exit;
}


function fileext($filename) 
{ 
	return substr(strrchr($filename, '.'), 1); 
}

if(is_file($url)) {
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".$filename.".".fileext($url).""); //basename  ֻҪ�ļ��� basename($path,".php");����ļ��� .php���򲻻���������չ��,��ʾ�������ļ���չ�����ļ�����
	readfile($url);
	exit;
}else{
	echo "�ļ������ڣ�";
	exit;
}

/*
�û��ϴ�ģ�飬��Ҫ���û��ϴ����ļ������󱣴棬����ϵͳ���������û������ļ�ʱ�������Ի�������Ҫ���ϴ����ļ��Ļ�ԭ�������ƣ��������ϴ�ʱ����Ҫ�����û�ԭʼ�ļ����ļ������Ա���������ʹ�á�����ʱʹ��header����������Ӧ��ת�����������£�  
header(��Content-type: application/octet-stream��);//���������,���������ṩ��MIME��ѡ����Ӧ������  
header(��Content-Disposition: attachment; filename=��������ʾ����.rar����);//������ʾ������  
readfile(���������ϵ��ļ���.rar��);//Ҫ�µ��ļ�,����·��  

���õ�MIME����  
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