function alert_go(str,button,form,pic,url){
		/*
			str:�ı������
			button:��ť���ͣ������Ϊ��href����ȷ��,button��ťȷ��,submit�ύȷ��,alert����ʾ,alert_go��ʾ��ת��
			form:�ύ��ID��boxΪsubmitʱ�����
			pic:��ʾͼƬ���ͣ������Ϊwen,ok,error��
			url:���ӵ�ַ��boxΪhref��button��alert_go��alert_openʱ�����jsʱΪ�¼�function��
			
			<a href="javascript:;" onClick="alert_go('ȷ�Ϸ�����','alert','formsa','wen','index.html?action=out');">�˳�</a>	
			
		*/
		$("#m_tishi_str").html(str); //��ʾ�ı�
		
		if (button=='href' || button=='button'){//����ת��
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();document.location.href='"+url+"'>ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
			
		}else if (button=='submit'){//���ύ
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();document.getElementById('"+form+"').submit()>ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
			
		}else if (button=='alert'){//����ʾ
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>֪����</button>");
			
		}else if (button=='alert_go'){//��ʾ��ת��
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();document.location.href='"+url+"'>֪����</button>");
		}else if (button=='alert_back'){//��ʾ�󣬻���
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' autocomplete='off' onClick=history.back(-1);>����</button>");
		}else if (button=='alert_open'){//��ʾ�󣬵����´���
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();window.open('"+url+"')>ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
		}else if (button=='button_click'){//��ʾ��ִ����һ��js�¼�
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick='alert_out();"+url+"'>ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
		}else if (button=='js'){//��ʾ��ִ��JS
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=alert_hides();"+url+">ȷ��</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>ȡ��</button>");
		}
		
		if (pic=='ok'){//�ж���ʾͼƬ
			$("#m_tishi_pic").html("<img src='/images/tishi_ok.gif' border='0' />");
		}else if (pic=='error'){
			$("#m_tishi_pic").html("<img src='/images/tishi_error.gif' border='0' />");
		}else if (pic=='wen'){
			$("#m_tishi_pic").html("<img src='/images/tishi_wen.gif' border='0' />");
		}

		$('#alert_go_div').modal('show');

}

function alert_out(){
	$('#alert_go_div').modal('hide');
}