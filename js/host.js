function checkfen(a){
	
	if ($("#host_jifen_"+a).val()=='' ){
		$("#host_jifen_"+a).val('0');
	}else{
		$("#host_jifen_"+a).val(Number($("#host_jifen_"+a).val()));
	}
	
	var jifen_all=document.getElementById("jifen_all").value;//剩余积分
	
	var max_fen=document.getElementById("max_fen_"+a).value;//单年最高积分
	var jiage=document.getElementById("jiage_"+a).value;//单年基础价格
	var youhui_ts=document.getElementById("youhui_ts_"+a);//提示
	
	var host_jifen=document.getElementById("host_jifen_"+a)//使用积分
	var host_nianxian=document.getElementById("host_nianxian_"+a)//年限
	var youhui=document.getElementById("youhui_"+a)//折后价

	if ( Number(host_jifen.value)>Number(jifen_all)){
		host_jifen.value=0;
		youhui.innerHTML=(jiage*host_nianxian.value)-host_jifen.value;
		youhui_ts.innerHTML='<i class="icon-info-sign"></i> 积分不足，您有 '+jifen_all+' 积分';
		$("#youhui_ts_"+a).fadeOut(500).fadeIn(500); 
	}else if ( Number(host_jifen.value)>Number(host_nianxian.value*max_fen)){
		host_jifen.value=host_nianxian.value*max_fen;
		youhui.innerHTML=(jiage*host_nianxian.value)-host_jifen.value;
		youhui_ts.innerHTML='<i class="icon-question-sign"></i> 最高可使用 '+(host_nianxian.value*max_fen)+' 积分';
		$("#youhui_ts_"+a).fadeOut(500).fadeIn(500); 
	}else{
		
		youhui.innerHTML=Number(jiage*host_nianxian.value)-Number(host_jifen.value);/*<span style="color:green">您有 '+jifen_all+' 积分</span>，*/	
		if (Number(host_jifen.value)==0 ){
			youhui_ts.innerHTML='<span style="color:green">提示：最多可抵扣 '+(host_nianxian.value*max_fen)+' 元×N年</span>';
		}else{
			youhui_ts.innerHTML='<span style="color:green">您使用'+(host_jifen.value)+'分，抵扣了 '+(host_jifen.value)+' 元</span>';
		}
	}
}

checkfen('1');checkfen('2');checkfen('3');checkfen('4');

function host_buy(a){ //多注意语法

	if ($("#host_jifen_"+a).val()=='' ){
		$("#host_jifen_"+a).val('0');
	}else{
		$("#host_jifen_"+a).val(Number($("#host_jifen_"+a).val()));
	}

	if ($("#user_zt").val()==''){//未登录 无法调用MODLE
		$("#youhui_ts_"+a).html('<i class="icon-info-sign"></i> 请登录后兑换！');  //给提示层写文字
		$("#youhui_ts_"+a).fadeOut(500).fadeIn(500); 
		return false;
	}else{
		if ($("#host_jifen_"+a).val()=='' || $("#host_jifen_"+a).val()==0){
			var tishi_str='（您没有使用积分，不享受优惠哦！）';
		}else{
			var tishi_str='（您将花费'+$("#host_jifen_"+a).val()+'积分，抵扣'+$("#host_jifen_"+a).val()+'元）';
		}
		alert_go('确认兑换？'+tishi_str,'button_click','','wen','buy_true("'+a+'")');
		return false;
	}
	
	
};

function buy_true(a){ //多注意语法
	
	$("#sub"+a).val('正在提交...');
	$('#sub'+a).attr('class','host_submit_wt');//提交时的样式
	$("#youhui_ts_"+a).html('');  //给提示层写文字
	document.getElementById("sub"+a).disabled='disabled';//暂时禁用
	var max_fen=$("#max_fen_"+a).val();//单年最高积分
	var jiage=$("#jiage_"+a).val();//单年基础价格
	var host_jifen=$("#host_jifen_"+a).val();//使用积分
	var host_nianxian=$("#host_nianxian_"+a).val();//年限
	var xinghao=$("#xinghao_"+a).val();//型号

	var ajaxform=$.post("/givehost.php",{action:'1',max_fen:max_fen,jiage:jiage,host_jifen:host_jifen,host_nianxian:host_nianxian,xinghao:xinghao},function(result){	
		
		//$("#question_statu").html(result);  //给提示层写文字
		if (result.indexOf("兑换成功") >= 0){
			$("#sub"+a).val('积分兑换');
			$('#sub'+a).attr('class','host_submit');//提交时的样式
			$("#youhui_ts_"+a).html(result);  //给提示层写文字
			setInterval(function(){ $("#youhui_ts_"+a).fadeOut(500).fadeIn(500); },100); 
			$("#host_jifen_"+a).val('0');
			document.getElementById("sub"+a).disabled='';//解除禁用
			
			var ajaxform=$.post("/givehost.php",{action:'2',jiage:jiage,host_jifen:host_jifen,host_nianxian:host_nianxian});

		}else {
			$("#youhui_ts_"+a).html(result);  //给提示层写文字
		}
	});
}