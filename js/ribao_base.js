function ribao_save(){ 
	//$("#hid_id").val(id);
	var id=$("#hide_read").val();

	//$("#hid_date").val(date);
	$("#readzt").html("保存中，请稍后...");
	$("#readzt").fadeIn(1);
	message1=UE.getEditor('message1').getContent();
	message2=UE.getEditor('message2').getContent();
	message3=UE.getEditor('message3').getContent();
	
	//alert (message1.replace(/[\r\n]/g,"</br>")); //.replace(/[ ]/g,""));    //去掉空格
	//return false;
	
	//("ribao_save_m.php?sid="+Math.random(),$("a_"+id).serialize(),function(result){
																			 
	var ajaxform=$.post("ribao_save_m.php?sid="+Math.random(),{action:'save',id:id,message1:message1,message2:message2,message3:message3},function(result){	
		

		var result_str=result.split("{#|#}");												
		//$("#xingming").val(result_str[1]);  //给提示层写文字

		if (result_str[0]=='error'){
			$("#readzt").html("参数错误！");
			//$("#tip_"+id).css({display:"block"});
		}else if(result_str[0]=='ok'){
			$("#readzt").html("保存成功！");
			$("#key_"+id).html(result_str[1]);
			$("#readzt").fadeOut(2000);
			//$("#key_"+id).html(UE.getEditor('message3_'+id).getContentTxt());
			//$("#my_to_alert").fadeOut(1000);
			//$("#readzt").fadeOut(3000,function(){span_hide(id)})
			
		}


		//$("#message").fadeIn(200);
		//document.location.href="#bottom"; //返回底部
		//$("#xingming").focus();
		//$("#goTopBtn").click();
	});
	
} 


function ribao_read(id){ 
	$("#hide_read").val(id);
	$("#readzt").html("读取中，请稍后...");
	$("#readzt").fadeIn(1);
	
	var ajaxform=$.post("ribao_save_m.php?sid="+Math.random(),{action:'read',id:id},function(result){	
		var result_str=result.split("|");	

		if (result_str[0]=='yes'){
			UE.getEditor('message1').setContent(result_str[1]);
			UE.getEditor('message2').setContent(result_str[2]);
			UE.getEditor('message3').setContent(result_str[3]);
			
			$("#readzt").html("");
			$("#readzt").fadeOut(1);

		}else{
			$("#readzt").html("读取中失败...");
			$("#readzt").fadeIn(2000);	
		}
		//document.location.href="#bottom"; //返回底部
		//$("#xingming").focus();
		//$("#goTopBtn").click();
	});
	
} 


function span_hide(id){
	$("#span_"+id).html("");
}
