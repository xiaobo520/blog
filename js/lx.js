$(function() {
	var sWidth = $("#focus_lx").width(); //��ȡ����ͼ�Ŀ�ȣ���ʾ�����
	var len = $("#focus_lx #focus_lx_ul #focus_lx_li").length; //��ȡ����ͼ����
	var index_lx = 0;
	var picTimer;
	
	//���´���������ְ�ť�Ͱ�ť��İ�͸������������һҳ����һҳ������ť
	var btn = "<div class='btnBg'></div><div class='btn_lx'>";
	for(var i=0; i < len; i++) {
		btn += "<span id='button_jslx'></span>";
	}
	btn += "</div>";
	$("#focus_lx").append(btn);
	$("#focus_lx .btnBg").css("opacity",0.5);

	//ΪС��ť�����껬���¼�������ʾ��Ӧ������
	$("#focus_lx .btn_lx #button_jslx").css("opacity",0.4).mouseenter(function() {
		index_lx = $("#focus_lx .btn_lx #button_jslx").index(this);
		showPics(index_lx);
	}).eq(0).trigger("mouseenter");

	//����Ϊ���ҹ�����������liԪ�ض�����ͬһ�����󸡶�������������Ҫ�������ΧulԪ�صĿ��
	$("#focus_lx #focus_lx_ul").css("width",sWidth * (len));
	
	//��껬�Ͻ���ͼʱֹͣ�Զ����ţ�����ʱ��ʼ�Զ�����
	$("#focus_lx").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index_lx);
			index_lx++;
			if(index_lx == len) {index_lx = 0;}
		},4000); //��4000�����Զ����ŵļ������λ������
	}).trigger("mouseleave");
	
	//��ʾͼƬ���������ݽ��յ�index_lxֵ��ʾ��Ӧ������
	function showPics(index_lx) { //��ͨ�л�
		var nowLeft = -index_lx*sWidth; //����index_lxֵ����ulԪ�ص�leftֵ
		$("#focus_lx #focus_lx_ul").stop(true,false).animate({"left":nowLeft},600); //ͨ��animate()����ulԪ�ع������������position
		//$("#focus_lx .btn_lx #button_jslx").removeClass("on").eq(index_lx).addClass("on"); //Ϊ��ǰ�İ�ť�л���ѡ�е�Ч��
		$("#focus_lx .btn_lx #button_jslx").stop(true,false).animate({"opacity":"0.4"},600).eq(index_lx).stop(true,false).animate({"opacity":"1"},600); //Ϊ��ǰ�İ�ť�л���ѡ�е�Ч��
	}
});

//if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iOS|iPad|Backerry|WebOS|Symbian|Windows Phone|Phone)/i))) { 
    //document.location.href="/wap/";
//}

