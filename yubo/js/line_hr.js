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

������
<TR id="line_hang_<?=$rs->id?>" onClick="line_bg(<?=$rs->id?>)">

����ڱ�����һ�����ؼ�¼
<input name="hid_hr_id" id="hid_hr_id" type="hidden" value="">

*/