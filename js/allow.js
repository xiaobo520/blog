
	function document.onkeydown()    
/*onload 事件中加入 oncontextmenu="return false" ondragstart="return false" onselectstart="return false" 禁止右键
源码中加入 <noscript><iframe src=*.html></iframe></noscript> 防止另存为

功能：禁止右键，禁止另存为，禁止查看源码，禁止选择，屏蔽F11 F5等
*/
{    
    if ((window.event.altKey)&&    
    ((window.event.keyCode==37)|| //屏蔽 Alt+ 方向键 ←    
    (window.event.keyCode==39))) //屏蔽 Alt+ 方向键 →    
    {    
        alert("不准你使用ALT+方向键前进或后退网页！");    
        event.returnValue=false;    
    }     
    if ((event.keyCode==8) || //屏蔽退格删除键    
    (event.keyCode==116)|| //屏蔽 F5 刷新键    
    (event.ctrlKey && event.keyCode==82)) //Ctrl + R    
    {    
        event.keyCode=0;    
        event.returnValue=false;    
    }    
    if (event.keyCode==122){event.keyCode=0;event.returnValue=false;}   //屏蔽F11    
    if (event.ctrlKey && event.keyCode==78) event.returnValue=false;    //屏蔽 Ctrl+n    
    if (event.shiftKey && event.keyCode==121)event.returnValue=false;   //屏蔽 shift+F10    
    if (window.event.srcElement.tagName == "A" && window.event.shiftKey) window.event.returnValue = false;//屏蔽 shift 加鼠标左键新开一网页    
    if ((window.event.altKey)&&(window.event.keyCode==115))             //屏蔽Alt+F4    
    {    
        window.showModelessDialog("about:blank","","dialogWidth:0px;dialogheight:0px"); //将关闭时间给了这个dialog   
        return false;    
    }    
}    


//处理键盘事件 禁止后退键（Backspace）密码或单行、多行文本框除外
function forbidBackSpace(e) {
	var ev = e || window.event; //获取event对象 
	var obj = ev.target || ev.srcElement; //获取事件源 
	var t = obj.type || obj.getAttribute('type'); //获取事件源类型 
	//获取作为判断条件的事件类型 
	var vReadOnly = obj.readOnly;
	var vDisabled = obj.disabled;
	//处理undefined值情况 
	vReadOnly = (vReadOnly == undefined) ? false : vReadOnly;
	vDisabled = (vDisabled == undefined) ? true : vDisabled;
	//当敲Backspace键时，事件源类型为密码或单行、多行文本的， 
	//并且readOnly属性为true或disabled属性为true的，则退格键失效 
	var flag1 = ev.keyCode == 8 && (t == "password" || t == "text" || t == "textarea") && (vReadOnly == true || vDisabled == true);
	//当敲Backspace键时，事件源类型非密码或单行、多行文本的，则退格键失效 
	var flag2 = ev.keyCode == 8 && t != "password" && t != "text" && t != "textarea";
	//判断 
	if (flag2 || flag1) return false;
}
//禁止后退键 作用于Firefox、Opera
document.onkeypress = forbidBackSpace;
//禁止后退键  作用于IE、Chrome
document.onkeydown = forbidBackSpace;
