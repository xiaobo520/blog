function mes_show(id,date){ 
	$("#hid_id").val(id);
	$("#hid_date").val(date);
	var ajaxform=$.post("rili_get.html",{action:'show',hid_date:date},function(result){	
		var result_str=result.split("|");												
		$("#xingming").val(result_str[1]);  //给提示层写文字
		$("#beiban").val(result_str[4]);  //给提示层写文字
		$("#bz").val(result_str[2]);  //给提示层写文字
		
		var t = document.getElementById("zhuangtai"); 
		//var selectValue=t.options[t.selectedIndex].value;//获取select的值
		for(i=0;i<t.length;i++){//给select赋值
		  if(result_str[3]==t.options[i].value){
			  t.options[i].selected=true
		  }
		}
		
		if (result_str[2]!=''){
			$("#tip_"+id).attr("title",result_str[2]);//title赋值
			$("#tip_"+id).css({display:"block"});
		}else{
			$("#tip_"+id).attr("title",'');
			$("#tip_"+id).css({display:"none"});
		}
		
		if (result_str[3]=='holiday'){
			$("#holiday_"+id).css({display:"block"});
		}else{
			$("#holiday_"+id).css({display:"none"});
		}
		
		if (result_str[3]=='work'){
			$("#work_"+id).css({display:"block"});
		}else{
			$("#work_"+id).css({display:"none"});
		}

		$("#message").fadeIn(200);
		//document.location.href="#bottom"; //返回底部
		$("#xingming").focus();
		$("#goTopBtn").click();
	});
	
} 

function mes_save(){ 
	hid_date=$("#hid_date").val();
	hid_id=$("#hid_id").val();
	xingming=$("#xingming").val();
	beiban=$("#beiban").val();
	bz=$("#bz").val();
	zhuangtai=$("#zhuangtai").val();
	var ajaxform=$.post("rili_get.html",{action:'save',xingming:xingming,beiban:beiban,bz:bz,zhuangtai:zhuangtai,hid_date:hid_date},function(result){														
		var result_str=result.split("|");	
		//alert(result)
		if (result_str[4]!=''){
			beiban_str="</br><span style='color:#666666;font-size:12px;'>"+result_str[4]+"</span>";
		}else{
			beiban_str="";
		}
		
		$("#xingming_"+hid_id).html(result_str[1]+beiban_str);  //给提示层写文字
		
		if (result_str[2]!=''){
			$("#tip_"+hid_id).attr("title",result_str[2]);
			$("#tip_"+hid_id).css({display:"block"});
		}else{
			$("#tip_"+hid_id).attr("title",'');
			$("#tip_"+hid_id).css({display:"none"});
		}
		
		if (result_str[3]=='holiday'){
			$("#holiday_"+hid_id).css({display:"block"});
		}else{
			$("#holiday_"+hid_id).css({display:"none"});
		}
		
		if (result_str[3]=='work'){
			$("#work_"+hid_id).css({display:"block"});
		}else{
			$("#work_"+hid_id).css({display:"none"});
		}
		
		$("#message").fadeOut(200);
		//document.location.href="#bottom"; //返回底部  //<a name="bottom" id="bottom"></a>
		$("#goTopBtn").click();
	});
	
} 

function mes_hide(){
	$("#message").fadeOut(200);
}