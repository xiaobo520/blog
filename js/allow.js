
	function document.onkeydown()    
/*onload �¼��м��� oncontextmenu="return false" ondragstart="return false" onselectstart="return false" ��ֹ�Ҽ�
Դ���м��� <noscript><iframe src=*.html></iframe></noscript> ��ֹ���Ϊ

���ܣ���ֹ�Ҽ�����ֹ���Ϊ����ֹ�鿴Դ�룬��ֹѡ������F11 F5��
*/
{    
    if ((window.event.altKey)&&    
    ((window.event.keyCode==37)|| //���� Alt+ ����� ��    
    (window.event.keyCode==39))) //���� Alt+ ����� ��    
    {    
        alert("��׼��ʹ��ALT+�����ǰ���������ҳ��");    
        event.returnValue=false;    
    }     
    if ((event.keyCode==8) || //�����˸�ɾ����    
    (event.keyCode==116)|| //���� F5 ˢ�¼�    
    (event.ctrlKey && event.keyCode==82)) //Ctrl + R    
    {    
        event.keyCode=0;    
        event.returnValue=false;    
    }    
    if (event.keyCode==122){event.keyCode=0;event.returnValue=false;}   //����F11    
    if (event.ctrlKey && event.keyCode==78) event.returnValue=false;    //���� Ctrl+n    
    if (event.shiftKey && event.keyCode==121)event.returnValue=false;   //���� shift+F10    
    if (window.event.srcElement.tagName == "A" && window.event.shiftKey) window.event.returnValue = false;//���� shift ���������¿�һ��ҳ    
    if ((window.event.altKey)&&(window.event.keyCode==115))             //����Alt+F4    
    {    
        window.showModelessDialog("about:blank","","dialogWidth:0px;dialogheight:0px"); //���ر�ʱ��������dialog   
        return false;    
    }    
}    


//��������¼� ��ֹ���˼���Backspace��������С������ı������
function forbidBackSpace(e) {
	var ev = e || window.event; //��ȡevent���� 
	var obj = ev.target || ev.srcElement; //��ȡ�¼�Դ 
	var t = obj.type || obj.getAttribute('type'); //��ȡ�¼�Դ���� 
	//��ȡ��Ϊ�ж��������¼����� 
	var vReadOnly = obj.readOnly;
	var vDisabled = obj.disabled;
	//����undefinedֵ��� 
	vReadOnly = (vReadOnly == undefined) ? false : vReadOnly;
	vDisabled = (vDisabled == undefined) ? true : vDisabled;
	//����Backspace��ʱ���¼�Դ����Ϊ������С������ı��ģ� 
	//����readOnly����Ϊtrue��disabled����Ϊtrue�ģ����˸��ʧЧ 
	var flag1 = ev.keyCode == 8 && (t == "password" || t == "text" || t == "textarea") && (vReadOnly == true || vDisabled == true);
	//����Backspace��ʱ���¼�Դ���ͷ�������С������ı��ģ����˸��ʧЧ 
	var flag2 = ev.keyCode == 8 && t != "password" && t != "text" && t != "textarea";
	//�ж� 
	if (flag2 || flag1) return false;
}
//��ֹ���˼� ������Firefox��Opera
document.onkeypress = forbidBackSpace;
//��ֹ���˼�  ������IE��Chrome
document.onkeydown = forbidBackSpace;
