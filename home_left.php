<?
include_once("./mdaima_var_inc/checkall_home.php");
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" align="right" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:13px;">
      <tr>
        <td height="29" align="center" class="font15">会员中心</td>
        </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">
	<table width="80%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="5" colspan="2" align="center"><hr size="1" style="color:#CCCCCC"/></td>
          </tr>
          <tr>
            <td width="30%" height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><img src="/images/report_user.png" width="32" height="32" border="0" /></td>
            <td width="70%" height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><a href="/home.html" class="a4"><? if ($home_css=="1") {?><span style="color:#966135;font-size:13px;"><? }?>用户信息<? if ($home_css=="1") {?></span><? }?></a></td>
          </tr>
		  <tr>
            <td height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><img src="/images/lock_edit.png" width="32" height="32" border="0" /></td>
            <td height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><a href="/password.html" class="a4"><? if ($home_css=="5") {?><span style="color:#966135;font-size:13px;"><? }?>修改密码<? if ($home_css=="5") {?></span><? }?></a></td>
		  </tr>
		  <tr>
            <td height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><img src="/images/copy_doc.png" width="32" height="32" border="0" /></td>
            <td height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><a href="/myfatie.html" class="a4"><? if ($home_css=="4") {?><span style="color:#966135;font-size:13px;"><? }?>我的发言<? if ($home_css=="4") {?></span><? }?></a></td>
		  </tr>
		  
		  <tr>
            <td height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><img src="/images/edit.png" width="32" height="32" border="0" /></td>
            <td height="55" align="left" style="border-bottom:1px dashed #DFDFDF"><a href="/score.html" class="a4"><? if ($home_css=="3") {?><span style="color:#966135;font-size:13px;"><? }?>积分记录<? if ($home_css=="3") {?></span><? }?></a></td>
		  </tr>
		  
		  <tr>
            <td height="55" align="left"><img src="/images/graphite_computer_on.png" width="32" height="32" border="0" /></td>
            <td height="55" align="left"><a href="javascript:void(0);" class="a4" onClick="alert_go('确认退出？','href','','wen','/login.html?<?=encrypt_url("action=out&&time=".time(),$key_url_md_5)?>')">退出登录</a></td>
		  </tr>
		 
      </table>
	<p>&nbsp;</p></td>
  </tr>
</table>

