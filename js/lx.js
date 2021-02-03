$(function() {
	var sWidth = $("#focus_lx").width(); //获取焦点图的宽度（显示面积）
	var len = $("#focus_lx #focus_lx_ul #focus_lx_li").length; //获取焦点图个数
	var index_lx = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
	var btn = "<div class='btnBg'></div><div class='btn_lx'>";
	for(var i=0; i < len; i++) {
		btn += "<span id='button_jslx'></span>";
	}
	btn += "</div>";
	$("#focus_lx").append(btn);
	$("#focus_lx .btnBg").css("opacity",0.5);

	//为小按钮添加鼠标滑入事件，以显示相应的内容
	$("#focus_lx .btn_lx #button_jslx").css("opacity",0.4).mouseenter(function() {
		index_lx = $("#focus_lx .btn_lx #button_jslx").index(this);
		showPics(index_lx);
	}).eq(0).trigger("mouseenter");

	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	$("#focus_lx #focus_lx_ul").css("width",sWidth * (len));
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$("#focus_lx").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index_lx);
			index_lx++;
			if(index_lx == len) {index_lx = 0;}
		},4000); //此4000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index_lx值显示相应的内容
	function showPics(index_lx) { //普通切换
		var nowLeft = -index_lx*sWidth; //根据index_lx值计算ul元素的left值
		$("#focus_lx #focus_lx_ul").stop(true,false).animate({"left":nowLeft},600); //通过animate()调整ul元素滚动到计算出的position
		//$("#focus_lx .btn_lx #button_jslx").removeClass("on").eq(index_lx).addClass("on"); //为当前的按钮切换到选中的效果
		$("#focus_lx .btn_lx #button_jslx").stop(true,false).animate({"opacity":"0.4"},600).eq(index_lx).stop(true,false).animate({"opacity":"1"},600); //为当前的按钮切换到选中的效果
	}
});

//if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iOS|iPad|Backerry|WebOS|Symbian|Windows Phone|Phone)/i))) { 
    //document.location.href="/wap/";
//}

