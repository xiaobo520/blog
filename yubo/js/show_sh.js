function show_message(cid){ //��ע���﷨

	/* ��һ��д��
	onlineimg=$("#onlineimg").val();
	maxlou=parseInt($("#maxlou").val())+1;
	*/

	var ajaxform=$.post("jilu_m.php",{cid:cid,action:'go',rid:Math.random()},function(result){	//cid:cid,atab:atab													
		
		if (result.indexOf("��Ŀ����") >= 0){
			$("#show_message").html(result);  //����ʾ��д����
		}else{
			$("#show_message").html('��Ǹ����ʱû����˼�¼');  //����ʾ��д����
		}
	});
	
};