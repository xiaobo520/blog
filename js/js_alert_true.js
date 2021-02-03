function alert_go(str,button,form,pic,url){
		/*
			str:文本（必填）
			button:按钮类型（必填，可为：href链接确认,button按钮确认,submit提交确认,alert仅提示,alert_go提示并转向）
			form:提交表单ID（box为submit时，必填）
			pic:提示图片类型（必填，可为wen,ok,error）
			url:链接地址（box为href、button、alert_go、alert_open时，必填，js时为事件function）
			
			<a href="javascript:;" onClick="alert_go('确认发布？','alert','formsa','wen','index.html?action=out');">退出</a>	
			
		*/
		$("#m_tishi_str").html(str); //提示文本
		
		if (button=='href' || button=='button'){//链接转向
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();document.location.href='"+url+"'>确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
			
		}else if (button=='submit'){//表单提交
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();document.getElementById('"+form+"').submit()>确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
			
		}else if (button=='alert'){//简单提示
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>知道了</button>");
			
		}else if (button=='alert_go'){//提示后转向
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();document.location.href='"+url+"'>知道了</button>");
		}else if (button=='alert_back'){//提示后，回退
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' autocomplete='off' onClick=history.back(-1);>返回</button>");
		}else if (button=='alert_open'){//提示后，弹出新窗口
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick=alert_out();window.open('"+url+"')>确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
		}else if (button=='button_click'){//提示后，执行下一个js事件
			$("#m_tishi_button1").html("<button class='btn btn_error' autocomplete='off' onClick='alert_out();"+url+"'>确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
		}else if (button=='js'){//提示后，执行JS
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=alert_hides();"+url+">确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
		}
		
		if (pic=='ok'){//判断提示图片
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