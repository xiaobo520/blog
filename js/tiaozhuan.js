function BaiduPageJump(sURL,jURL) {//�ٶ��������ת�¼�
	var sBeginCode = "?wd=";
	var sBeginCode2 = "&wd=";
	var sEndCode = "###";
	var sEndCode2 = "&";

	var iPlace = sURL.indexOf(sBeginCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sBeginCode2);
	}
	sURL = sURL.substring(iPlace+4, sURL.length);

	var iPlace = sURL.indexOf(sEndCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sEndCode2);
	}
	if (iPlace != -1) {
		sURL = sURL.substring(0, iPlace);
	}

	if (navigator.userAgent.indexOf("MSIE") != -1) {
		window.opener.navigate(jURL);
	} 
	else {
		window.opener.location.href = jURL;
	}
}


function OtherPageJump(sURL,jURL) {//�����������ת�¼�
	var sBeginCode = "?q=";
	var sBeginCode2 = "&q=";
	var sEndCode = "###";
	var sEndCode2 = "&";

	var iPlace = sURL.indexOf(sBeginCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sBeginCode2);
	}
	sURL = sURL.substring(iPlace+3, sURL.length);

	var iPlace = sURL.indexOf(sEndCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sEndCode2);
	}
	if (iPlace != -1) {
		sURL = sURL.substring(0, iPlace);
	}

	if (navigator.userAgent.indexOf("MSIE") != -1) {
		window.opener.navigate(jURL);
	} 
	else {
		window.opener.location.href = jURL;
	}
}

function SogouPageJump(sURL,jURL) {//�ѹ��������ת�¼�
	var sBeginCode = "?query=";
	var sBeginCode2 = "&query=";
	var sEndCode = "###";
	var sEndCode2 = "&";

	var iPlace = sURL.indexOf(sBeginCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sBeginCode2);
	}
	sURL = sURL.substring(iPlace+7, sURL.length);

	var iPlace = sURL.indexOf(sEndCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sEndCode2);
	}
	if (iPlace != -1) {
		sURL = sURL.substring(0, iPlace);
	}

	if (navigator.userAgent.indexOf("MSIE") != -1) {
		window.opener.navigate(jURL);
	} 
	else {
		window.opener.location.href = jURL;
	}
}


function SosoPageJump(sURL,jURL) {
	var sBeginCode = "?w=";
	var sBeginCode2 = "&w=";
	var sEndCode = "###";
	var sEndCode2 = "&";

	var iPlace = sURL.indexOf(sBeginCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sBeginCode2);
	}
	sURL = sURL.substring(iPlace+3, sURL.length);

	var iPlace = sURL.indexOf(sEndCode);
	if (iPlace == -1) {
		iPlace = sURL.indexOf(sEndCode2);
	}
	if (iPlace != -1) {
		sURL = sURL.substring(0, iPlace);
	}

	if (navigator.userAgent.indexOf("MSIE") != -1) {
		window.opener.navigate(jURL);
	} 
	else {
		window.opener.location.href = jURL;
	}
}



var jURL="���ײ��͹��ڲ���"; //ͨ�ùؼ�������

//�ٶȵ���URL������wd=������ַ���Ϊת���Ĺؼ��ʣ�$ct=ǰ��ֹ��
var baidujURL = "https://www.baidu.com/s?ie=utf-8&f=3&rsv_bp=1&tn=baidu&wd=%e6%9d%8e%e9%9b%b7%e5%8d%9a%e5%ae%a2%e7%a0%81%e4%bb%a3%e7%a0%81%0a&ct=2097152&si=mdaima.com&oq=%E5%9B%9B%E5%B7%9D%E4%BA%94%E6%9C%88%E8%8A%B1%E4%B8%93%E4%BF%AE%E5%AD%A6%E9%99%A2%E6%B1%AA%E8%BE%89%E5%90%9B&rsv_pq=dbe26f9a0004371c&rsv_t=95d1k1oKTFVKLAuEUYjS%2BjP2CVf8hD29hlP%2BhoaLiY%2FO3Eydln2ZPTWfF6Y&rsv_enter=0&inputT=2741";

//360����URL������q=������ַ���Ϊת���Ĺؼ��ʣ�&src=ǰ��ֹ��
var jURL360 = "https://www.so.com/s?q=%e6%9d%8e%e9%9b%b7%e5%8d%9a%e5%ae%a2%e7%a0%81%e4%bb%a3%e7%a0%81%0a&src=srp&fr=360sou_newhome&psid=3f3e1f6476a24eb003ee75d8465df558";

//sogou����URL������query=������ַ���Ϊת���Ĺؼ��ʣ�&ie=ǰ��ֹ��
var sogoujURL = "https://www.sogou.com/web?query=%e6%9d%8e%e9%9b%b7%e5%8d%9a%e5%ae%a2%e7%a0%81%e4%bb%a3%e7%a0%81%0a&ie=utf8&_ast=1455632000&_asf=null&w=01029901&p=40040100&dp=1&cid=&sut=7149&sst0=1455632021132&lkt=0%2C0%2C0";


var sURL = document.referrer;
sURL = sURL.toLowerCase();

if(sURL=='') {
	//�޲���
	
}else if (sURL.indexOf("www.baidu.com/")!=-1) {//����Ƿ�Ϊ�ٶ�
	BaiduPageJump(sURL,baidujURL);
	
}else if (sURL.indexOf("www.so.com/")!=-1) {//����Ƿ�Ϊ360
	OtherPageJump(sURL,jURL360);
}else if (sURL.indexOf("www.sogou.com/")!=-1) {//����Ƿ�Ϊ�ѹ�
	SogouPageJump(sURL,sogoujURL);
}