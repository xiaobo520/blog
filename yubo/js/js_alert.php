
<script>
function alert_go(str,button,form,pic,url){
		/*
			str:�ı������
			button:��ť���ͣ������Ϊ��href����ȷ��,button��ťȷ��,submit�ύȷ��,alert����ʾ,alert_go��ʾ��ת��
			form:�ύ��ID��boxΪsubmitʱ�����
			pic:��ʾͼƬ���ͣ������Ϊwen,ok,error��
			url:���ӵ�ַ��boxΪhref��button��alert_go��alert_openʱ�����
			
			<a href="javascript:;" onClick="alert_go('ȷ�Ϸ�����','alert','formsa','wen','index.html?action=out');">�˳�</a>	
			
		*/
		$("#m_tishi_str").html(str); //��ʾ�ı�
		
		if (button=='href' || button=='button'){//����ת��
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=show_loading();document.location.href='"+url+"'>ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
			
		}else if (button=='submit'){//���ύ
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=show_loading();document.getElementById('"+form+"').submit()>ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
			
		}else if (button=='alert'){//����ʾ
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>֪����</button>");
			
		}else if (button=='alert_go'){//��ʾ��ת��
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' onClick=show_loading();document.location.href='"+url+"'>֪����</button>");
		}else if (button=='alert_back'){//��ʾ�󣬻���
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' onClick=show_loading();history.back(-1);>����</button>");
		}else if (button=='alert_open'){//��ʾ�󣬵����´���
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=alert_hides();window.open('"+url+"')>ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
		}
		
		if (pic=='ok'){//�ж���ʾͼƬ
			$("#m_tishi_pic").html("<img src='images/tishi_ok.gif' border='0' />");
		}else if (pic=='error'){
			$("#m_tishi_pic").html("<img src='images/tishi_error.gif' border='0' />");
		}else if (pic=='wen'){
			$("#m_tishi_pic").html("<img src='images/tishi_wen.gif' border='0' />");
		}

		$('#alert_go_div').modal('show');

}

function alert_hides(){
	$('#alert_go_div').modal('hide');
}



function hide_loading(){//���ּ���״̬��ʾ������������Զ��ж�
	
	if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
		parent.frames['topFrame'].$("#loading").fadeOut(500);//.fadeOut(500);  // ���IE�ں������
	}else{
		parent.frames['topFrame'].NProgress.done();// �����ں������
	}
}

function show_loading(){
	
	if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
		parent.frames['topFrame'].$("#loading").fadeIn(10);  //fadeIn(300);
	}else{
		parent.frames['topFrame'].NProgress.set(0.4); //"nprogress-bar  nprogress-peg  nprogress-spinner  nprogress-spinner-icon
		parent.frames['topFrame'].NProgress.inc();
		parent.frames['topFrame'].NProgress.start();
	}
}

//show_loading();//���ؼ���ʾ
/*
function userBrowser(){
    var browserName=navigator.userAgent.toLowerCase();
    if(/msie/i.test(browserName) && !/opera/.test(browserName)){
        alert("IE");
        return ;
    }else if(/firefox/i.test(browserName)){
        alert("Firefox");
        return ;
    }else if(/chrome/i.test(browserName) && /webkit/i.test(browserName) && /mozilla/i.test(browserName)){
        alert("Chrome");
        return ;
    }else if(/opera/i.test(browserName)){
        alert("Opera");
        return ;
    }else if(/webkit/i.test(browserName) &&!(/chrome/i.test(browserName) && /webkit/i.test(browserName) && /mozilla/i.test(browserName))){
        alert("Safari");
        return ;
    }else{
        alert("unKnow");
    }
}
userBrowser()

*/



//�жϼ���״̬
if (window.addEventListener){ // non-IE
	window.addEventListener("load", function() {
		if (document.readyState=="complete"){
			setTimeout(function(){hide_loading()},300); 
		}
	}, false);
}else{ // IE
	document.onreadystatechange = function() {
		if (document.readyState=="complete"){
			setTimeout(function(){hide_loading()},300); 
		}
	};
}



//parent.frames['topFrame'].document.getElementById('loading').style.display='';
//��������밴ť�������ֱ����ʾLOADING

//���ӻ�ť��Ҫ��ǰת��ȷ�ϵ� <a href="javascript:void(0)" onClick="javascript:if(confirm('ȷ�Ϸ�����')){show_loading();document.location.href='?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&time=".time(),$key_url_md_5)?>'}"><i class="icon-upload"></i> ����</a>
//onClick="javascript:if(confirm('ȷ�ϱ�����־��')){show_loading();}else{return false;}"

$(document).ready(function(){
	$(".loading_it").click(function(){//a.loading_itΪA������classΪloading_it�ı�ǩ �� .loading_itͨ��
		show_loading();
	});
});

/*
document.onclick = function(e){
	$("a.aaa")
	var o = window.event.srcElement || window.event.target;   //FireFoxe  || IE
	if (o.tagName=="A" || o.tagName=="BUTTON" ){//o.tagName=="A"   ��д
		 alert(o.className)
		 show_loading()
	}  
} 
*/
</script>
			
<div id="alert_go_div" class="modal hide fade no_bg" style="color:#111111; display:none;font-family:΢���ź�; width:420px;left:50%; margin-left:-210px;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">��</button>
	<h3># ������ʾ</h3>
  </div>
  
  <div class="modal-body">
		<!--���� -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="m_tishi_pic" width="60px" valign="middle">&nbsp;</td>
            <td id="m_tishi_str" style="font-size:14px">&nbsp;</td>
          </tr>
        </table>
		<!--���� -->
  </div>

  <div class="modal-footer">
	<span id="m_tishi_button1"></span>&nbsp;
	<span id="m_tishi_button2"></span>
  </div>
</div>