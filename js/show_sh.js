function show_message(cid){ //多注意语法

	/* 另一种写法
	onlineimg=$("#onlineimg").val();
	maxlou=parseInt($("#maxlou").val())+1;
	*/

	var ajaxform=$.post("jilu_m.php",{cid:cid,action:'go',rid:Math.random()},function(result){	//cid:cid,atab:atab													
		
		if (result.indexOf("项目名称") >= 0){
			$("#show_message").html(result);  //给提示层写文字
		}else{
			$("#show_message").html('抱歉，暂时没有审核记录');  //给提示层写文字
		}
	});
	
};