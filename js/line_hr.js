function line_bg(hrid){
	hidval=document.getElementById('hid_hr_id');

	if ((hidval.value).indexOf(hrid+",") >= 0){
		document.getElementById('line_hang_'+hrid).className='line_bg_2';
		hidval.value=(hidval.value).replace(hrid+",","");

	}else{
		document.getElementById('line_hang_'+hrid).className='line_bg_1';
		hidval.value=hidval.value+hrid+",";

	}
}

/*
<script language="javascript" type="text/javascript" src="js/line_hr.js"></script>

表单行中
<TR id="line_hang_<?=$rs->id?>" onClick="line_bg(<?=$rs->id?>)">

最后在表单中做一个隐藏记录
<input name="hid_hr_id" id="hid_hr_id" type="hidden" value="">

*/