function checkfen(a){
	
	if ($("#host_jifen_"+a).val()=='' ){
		$("#host_jifen_"+a).val('0');
	}else{
		$("#host_jifen_"+a).val(Number($("#host_jifen_"+a).val()));
	}
	
	var jifen_all=document.getElementById("jifen_all").value;//ʣ�����
	
	var max_fen=document.getElementById("max_fen_"+a).value;//������߻���
	var jiage=document.getElementById("jiage_"+a).value;//��������۸�
	var youhui_ts=document.getElementById("youhui_ts_"+a);//��ʾ
	
	var host_jifen=document.getElementById("host_jifen_"+a)//ʹ�û���
	var host_nianxian=document.getElementById("host_nianxian_"+a)//����
	var youhui=document.getElementById("youhui_"+a)//�ۺ��

	if ( Number(host_jifen.value)>Number(jifen_all)){
		host_jifen.value=0;
		youhui.innerHTML=(jiage*host_nianxian.value)-host_jifen.value;
		youhui_ts.innerHTML='<i class="icon-info-sign"></i> ���ֲ��㣬���� '+jifen_all+' ����';
		$("#youhui_ts_"+a).fadeOut(500).fadeIn(500); 
	}else if ( Number(host_jifen.value)>Number(host_nianxian.value*max_fen)){
		host_jifen.value=host_nianxian.value*max_fen;
		youhui.innerHTML=(jiage*host_nianxian.value)-host_jifen.value;
		youhui_ts.innerHTML='<i class="icon-question-sign"></i> ��߿�ʹ�� '+(host_nianxian.value*max_fen)+' ����';
		$("#youhui_ts_"+a).fadeOut(500).fadeIn(500); 
	}else{
		
		youhui.innerHTML=Number(jiage*host_nianxian.value)-Number(host_jifen.value);/*<span style="color:green">���� '+jifen_all+' ����</span>��*/	
		if (Number(host_jifen.value)==0 ){
			youhui_ts.innerHTML='<span style="color:green">��ʾ�����ɵֿ� '+(host_nianxian.value*max_fen)+' Ԫ��N��</span>';
		}else{
			youhui_ts.innerHTML='<span style="color:green">��ʹ��'+(host_jifen.value)+'�֣��ֿ��� '+(host_jifen.value)+' Ԫ</span>';
		}
	}
}

checkfen('1');checkfen('2');checkfen('3');checkfen('4');

function host_buy(a){ //��ע���﷨

	if ($("#host_jifen_"+a).val()=='' ){
		$("#host_jifen_"+a).val('0');
	}else{
		$("#host_jifen_"+a).val(Number($("#host_jifen_"+a).val()));
	}

	if ($("#user_zt").val()==''){//δ��¼ �޷�����MODLE
		$("#youhui_ts_"+a).html('<i class="icon-info-sign"></i> ���¼��һ���');  //����ʾ��д����
		$("#youhui_ts_"+a).fadeOut(500).fadeIn(500); 
		return false;
	}else{
		if ($("#host_jifen_"+a).val()=='' || $("#host_jifen_"+a).val()==0){
			var tishi_str='����û��ʹ�û��֣��������Ż�Ŷ����';
		}else{
			var tishi_str='����������'+$("#host_jifen_"+a).val()+'���֣��ֿ�'+$("#host_jifen_"+a).val()+'Ԫ��';
		}
		alert_go('ȷ�϶һ���'+tishi_str,'button_click','','wen','buy_true("'+a+'")');
		return false;
	}
	
	
};

function buy_true(a){ //��ע���﷨
	
	$("#sub"+a).val('�����ύ...');
	$('#sub'+a).attr('class','host_submit_wt');//�ύʱ����ʽ
	$("#youhui_ts_"+a).html('');  //����ʾ��д����
	document.getElementById("sub"+a).disabled='disabled';//��ʱ����
	var max_fen=$("#max_fen_"+a).val();//������߻���
	var jiage=$("#jiage_"+a).val();//��������۸�
	var host_jifen=$("#host_jifen_"+a).val();//ʹ�û���
	var host_nianxian=$("#host_nianxian_"+a).val();//����
	var xinghao=$("#xinghao_"+a).val();//�ͺ�

	var ajaxform=$.post("/givehost.php",{action:'1',max_fen:max_fen,jiage:jiage,host_jifen:host_jifen,host_nianxian:host_nianxian,xinghao:xinghao},function(result){	
		
		//$("#question_statu").html(result);  //����ʾ��д����
		if (result.indexOf("�һ��ɹ�") >= 0){
			$("#sub"+a).val('���ֶһ�');
			$('#sub'+a).attr('class','host_submit');//�ύʱ����ʽ
			$("#youhui_ts_"+a).html(result);  //����ʾ��д����
			setInterval(function(){ $("#youhui_ts_"+a).fadeOut(500).fadeIn(500); },100); 
			$("#host_jifen_"+a).val('0');
			document.getElementById("sub"+a).disabled='';//�������
			
			var ajaxform=$.post("/givehost.php",{action:'2',jiage:jiage,host_jifen:host_jifen,host_nianxian:host_nianxian});

		}else {
			$("#youhui_ts_"+a).html(result);  //����ʾ��д����
		}
	});
}