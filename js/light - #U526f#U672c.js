hljs.initHighlightingOnLoad();

$(document).ready(function() {
	$('pre code').each(function(i, block) {
		hljs.highlightBlock(block);
	});
});

/*
	//行号
	
	code.has-numbering {
		margin-left: 45px;
	}
	
	.pre-numbering {
		position: absolute;
		top:11px;
		left:0;
		width: 45px;
		padding: 7px 0 0 0;
		line-height:15px;
		background-color: #fff;
		text-align: center;
		color: #AAA;
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	
	//numbering for pre>code blocks
	$(function(){
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
	});

*/

function auto_w_h(){//document.body.scrollTop
	document.getElementById("shulist_box").style.height=parseInt(parseInt(window.screen.availHeight)-285)+"px"; 
	document.getElementById("pianduan_box").style.height=parseInt(parseInt(window.screen.availHeight)-285)+"px"; 
	
	document.getElementById("pianduan_box").style.width=parseInt(parseInt(document.body.clientWidth)-320)+"px"; 
	document.getElementById("pianduan").style.width=parseInt(parseInt(document.body.clientWidth)-340)+"px"; //去滚动条
}

$(window).load(function(){
	$("#shulist_box").mouseover(function () {
		$(this).css("overflow-y","auto");
	});

	$("#shulist_box").mouseleave(function () {
		$(this).css("overflow-y","hidden");
	});
	
	$("#pianduan_box").mouseover(function () {
		$(this).css("overflow-y","auto");
		auto_w_h()
	});
	$("#pianduan_box").mouseleave(function () {
		$(this).css("overflow-y","hidden");
		auto_w_h()
	});
	
	auto_w_h();
	
});

$(window).load(function() { 
	$("#pianduan_box").css("overflow-y","auto");
	auto_w_h();
	$("#pianduan_box").css("overflow-y","hidden");
}); 


window.onresize = function(){
	$("#pianduan_box").css("overflow-y","auto");
	auto_w_h();
	$("#pianduan_box").css("overflow-y","hidden");
}

