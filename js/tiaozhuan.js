function BaiduPageJump(sURL,jURL) {//百度浏览器跳转事件
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


function OtherPageJump(sURL,jURL) {//其它浏览器跳转事件
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

function SogouPageJump(sURL,jURL) {//搜狗浏览器跳转事件
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



var jURL="李雷博客关于博主"; //通用关键词设置

//百度调用URL参数（wd=后面的字符串为转码后的关键词，$ct=前终止）
var baidujURL = "https://www.baidu.com/s?ie=utf-8&f=3&rsv_bp=1&tn=baidu&wd=%e6%9d%8e%e9%9b%b7%e5%8d%9a%e5%ae%a2%e7%a0%81%e4%bb%a3%e7%a0%81%0a&ct=2097152&si=mdaima.com&oq=%E5%9B%9B%E5%B7%9D%E4%BA%94%E6%9C%88%E8%8A%B1%E4%B8%93%E4%BF%AE%E5%AD%A6%E9%99%A2%E6%B1%AA%E8%BE%89%E5%90%9B&rsv_pq=dbe26f9a0004371c&rsv_t=95d1k1oKTFVKLAuEUYjS%2BjP2CVf8hD29hlP%2BhoaLiY%2FO3Eydln2ZPTWfF6Y&rsv_enter=0&inputT=2741";

//360调用URL参数（q=后面的字符串为转码后的关键词，&src=前终止）
var jURL360 = "https://www.so.com/s?q=%e6%9d%8e%e9%9b%b7%e5%8d%9a%e5%ae%a2%e7%a0%81%e4%bb%a3%e7%a0%81%0a&src=srp&fr=360sou_newhome&psid=3f3e1f6476a24eb003ee75d8465df558";

//sogou调用URL参数（query=后面的字符串为转码后的关键词，&ie=前终止）
var sogoujURL = "https://www.sogou.com/web?query=%e6%9d%8e%e9%9b%b7%e5%8d%9a%e5%ae%a2%e7%a0%81%e4%bb%a3%e7%a0%81%0a&ie=utf8&_ast=1455632000&_asf=null&w=01029901&p=40040100&dp=1&cid=&sut=7149&sst0=1455632021132&lkt=0%2C0%2C0";


var sURL = document.referrer;
sURL = sURL.toLowerCase();

if(sURL=='') {
	//无操作
	
}else if (sURL.indexOf("www.baidu.com/")!=-1) {//检测是否为百度
	BaiduPageJump(sURL,baidujURL);
	
}else if (sURL.indexOf("www.so.com/")!=-1) {//检测是否为360
	OtherPageJump(sURL,jURL360);
}else if (sURL.indexOf("www.sogou.com/")!=-1) {//检测是否为搜狗
	SogouPageJump(sURL,sogoujURL);
}