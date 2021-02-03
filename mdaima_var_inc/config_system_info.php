<?php                    
$var_domain='www.mdaima.com';    //域名
$var_loading_index='1';     //是否开启前台loading效果1开启，0关闭
$var_jifen_denglu=5;   //登录积分，每天限制次数变量在config_system.php设置，同时更改host.html
$var_jifen_bdshare=5;   //百度分享积分
$var_jifen_huifu=2;   //回贴积分
$var_jifen_pintu=3;   //拼图积分
$var_jifen_reg=20;   //注册送积分。
$var_pinglun_shenhe='1';   //默认的评论审核状态，1为默认通过，0为默认未通过（需博主审核后前台才显示）
$var_huitie_open='open';   //除单个文章限制是否可以评论，也可以通过这里临时设置全站禁止评论，开启后显示“回复功能暂时关闭”，oepn开，close关
$var_huitie_time=5;   //回复时间限制，单位：秒
$var_huitie_list=5;   //文章详细页面的回复列表显示多少条回复留言

####################--发邮件--####################（JQ异步，不影响页面速度）
$var_huitie_email='open';    //回贴EMAIL通知“总”开关（此项关闭后，勾选发给被回贴人也无效，博主也无法收到），oepn开，close关		
$smtpserver = "smtp.126.com";    //SMTP服务器
$smtpserverport =25;    //SMTP服务器端口
$smtpusermail 	= "mdaimacom@qq.com";    //SMTP服务器的用户邮箱
$smtpuser = "mdaima";    //SMTP服务器的用户帐号
$smtppass = "111222";    //SMTP服务器的用户密码 客户端授权密码：dbwuievastscbxzm
####################--发邮件--####################

####################--短信--####################   www.ucpaas.com，mdaima@126.com/15901121235，7788945b
$sms_host_open=  '0';    //后台信息变动提醒，短信功能开关 1开，0关，用于有新主机订单时给博主发送短信提醒  （JQ异步，不影响页面速度）
$sms_accountsid = "3333";
$sms_token = '111';
$sms_appId = "2222";
####################--短信--####################

$var_register_pass='1';         //用户注册的默认开通状态，1开通，0需要审核
$var_outhours=2;    //后台操作链接过期时间，单位小时
$bad_words="春药 一夜情 包二奶 催情 迷药 草你妈 傻逼";    #非法词汇列表（以空格分隔）
           ?>