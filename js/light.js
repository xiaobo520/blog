
/*
$(document).ready(function() {
	hljs.initHighlightingOnLoad();
	$('pre code').each(function(i, block) {
		hljs.highlightBlock(block);
	});
});


//�к�//numbering for pre>code blocks
function code_num(){
	$('pre code').each(function(){
		var lines = $(this).text().split('\n').length - 1;
		var $numbering = $('<ul/>').addClass('pre-numbering');
		$(this)
			.addClass('has-numbering')
			.parent()
			.append($numbering);
		for(i=1;i<=lines;i++){
			$numbering.append($('<li/>').text(i));
		}
	});
};


*/
function iefor(){
	var explorer =navigator.userAgent ;
	//ie 
	if (explorer.indexOf("MSIE") >= 0) {
		alert("��̫ϲ���谭WEBǰ����Ƶ�IE���������ʾ�հ����Կ��飡");
		document.getElementById("body").innerHTML='';
		return false;
	}
	//firefox 
	else if (explorer.indexOf("Firefox") >= 0) {
		//alert("Firefox");
	}
	//Chrome
	else if(explorer.indexOf("Chrome") >= 0){
		//alert("Chrome");
	}
	//Opera
	else if(explorer.indexOf("Opera") >= 0){
		//alert("Opera");
	}
	//Safari
	else if(explorer.indexOf("Safari") >= 0){
		//alert("Safari");
	} 
	//Netscape
	else if(explorer.indexOf("Netscape")>= 0) { 
		//alert('Netscape'); 
	} 
}


function auto_w_h(a){//aΪ����ʱ���������Ŀ����Ҫ��̬��ȥ
	document.getElementById("left_box").style.height=parseInt(parseInt($(window).height())-115+20-40-parseInt(a))+"px"; //20Ϊ���ع������Ŀ����  40Ϊleft_box border 20*2
	document.getElementById("right_box").style.height=parseInt(parseInt($(window).height())-155+20-parseInt(a))+"px"; 
	
	/*��ʾ�㶨λ*/
	document.getElementById("alerts").style.marginLeft=parseInt(parseInt($("#right_box").width())/2-100)+"px"; 
	document.getElementById("alerts").style.marginTop=parseInt(parseInt($("#right_box").height())/2-50)+"px"; 
	
	/*����������*/
	document.getElementById("alerts_bg").style.width=parseInt($("#right_box").width())+"px"; 
	document.getElementById("alerts_bg").style.height=parseInt($("#right_box").height())+"px"; 
	
	//document.getElementById("righta").style.width=parseInt(parseInt(window.screen.availWidth)-840)+"px";
}

//alert(    window.screen.availWidth    )
	
$(window).load(function(){
	/*$("#left_box").mouseover(function () {
		$(this).css("overflow-y","auto");
		auto_w_h(20)
	});

	$("#left_box").mouseleave(function () {
		$(this).css("overflow-y","hidden");
		auto_w_h(20);
	});
	
	$("#right_box").mouseover(function () {
		$(this).css("overflow-y","auto");
		auto_w_h(20)
	});
	$("#right_box").mouseleave(function () {
		$(this).css("overflow-y","hidden");
		auto_w_h(20);
	});*/
	
	auto_w_h(20);
	//code_num();
	
	
	//iefor();

}); 


window.onresize = function(){//�����¼����
	auto_w_h(20);
	//code_num();
}

$("#right_box").scroll(function(){//�������䶨λ
	document.getElementById("alerts").style.marginTop=parseInt(parseInt($("#right_box").height())/2-50+$("#right_box").scrollTop())+"px"; 
	document.getElementById("alerts_bg").style.height=parseInt($("#right_box").height()+$("#right_box").scrollTop())+"px"; 
});

/*
function changeStyle(v){
	document.getElementById("daima_style").href = "/css/gaoliang/" + v + ".css";
	
	if (v=='atelier-dune-dark'){
		document.getElementById("right_box").style.background="#20201d";
	}else if (v=='atelier-cave-dark'){
		document.getElementById("right_box").style.background="#19171c";
	}else if (v=='default'){
		document.getElementById("right_box").style.background="#F0F0F0";
	}else if (v=='atelier-lakeside-light'){
		document.getElementById("right_box").style.background="#ebf8ff";
	}else if (v=='agate'){
		document.getElementById("right_box").style.background="#333";
	}
	
	if( !document.cookie || !navigator.cookieEnabled){
		alert("���������δ����Cookie֧�֣����ֹ����޷�ʹ�ã�");
		return false;
	}else{
		$.cookie('daima_style', v, { expires: 365, path: '/' });
	}
	
}
*/

function show_daima(id){ //��ע���﷨
	
	$("#alerts_bg").fadeIn(200);  //��ʾ�㵭��
	$("#alerts").fadeIn(200);  //��ʾ�㵭��
	var ajaxform=$.post("/daima_code.php",{id:id,action:'show'},function(result){

		

		
		
		
		/*
		hljs.initHighlightingOnLoad();
		$('pre code').each(function(i, block) {
			hljs.highlightBlock(block);
		});
		*/
		auto_w_h(20);
		
		$("#get_code").html(result); //����ʾ��д����
		
		uParse('.content_art',{
			'highlightJsUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js',
			'highlightCssUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css'
			
		});
	
		SyntaxHighlighter.all();
		
		$("#alerts_bg").delay(500).fadeOut(200);  //��ʾ�㵭������ʱ
		$("#alerts").delay(500).fadeOut(200);  //��ʾ�㵭��
		
		//code_num();
		
	})
}

