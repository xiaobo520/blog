
<script>
function alert_go(str,button,form,pic,url){
		/*
			str:文本（必填）
			button:按钮类型（必填，可为：href链接确认,button按钮确认,submit提交确认,alert仅提示,alert_go提示并转向）
			form:提交表单ID（box为submit时，必填）
			pic:提示图片类型（必填，可为wen,ok,error）
			url:链接地址（box为href、button、alert_go、alert_open时，必填）
			
			<a href="javascript:;" onClick="alert_go('确认发布？','alert','formsa','wen','index.html?action=out');">退出</a>	
			
		*/
		$("#m_tishi_str").html(str); //提示文本
		
		if (button=='href' || button=='button'){//链接转向
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=show_loading();document.location.href='"+url+"'>确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
			
		}else if (button=='submit'){//表单提交
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=show_loading();document.getElementById('"+form+"').submit()>确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
			
		}else if (button=='alert'){//简单提示
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>知道了</button>");
			
		}else if (button=='alert_go'){//提示后转向
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' onClick=show_loading();document.location.href='"+url+"'>知道了</button>");
		}else if (button=='alert_back'){//提示后，回退
			$("#m_tishi_button1").html("");
			$("#m_tishi_button2").html("<button class='btn btn_error' onClick=show_loading();history.back(-1);>返回</button>");
		}else if (button=='alert_open'){//提示后，弹出新窗口
			$("#m_tishi_button1").html("<button class='btn btn_error' onClick=alert_hides();window.open('"+url+"')>确认</button>");
			$("#m_tishi_button2").html("<button class='btn btn_submit' data-dismiss='modal' aria-hidden='true'>取消</button>");
		}
		
		if (pic=='ok'){//判断提示图片
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



function hide_loading(){//两种加载状态显示，根据浏览器自动判断
	
	if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
		parent.frames['topFrame'].$("#loading").fadeOut(500);//.fadeOut(500);  // 针对IE内核浏览器
	}else{
		parent.frames['topFrame'].NProgress.done();// 其它内核浏览器
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

//show_loading();//加载即显示
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



//判断加载状态
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
//监控链接与按钮，点击后将直接显示LOADING

//链接或按钮需要提前转向确认的 <a href="javascript:void(0)" onClick="javascript:if(confirm('确认发布？')){show_loading();document.location.href='?<?=encrypt_url("&id=".$rs["id"]."&page=".$page."&".$pageurl."&action=shangbao&time=".time(),$key_url_md_5)?>'}"><i class="icon-upload"></i> 发布</a>
//onClick="javascript:if(confirm('确认保存日志？')){show_loading();}else{return false;}"

$(document).ready(function(){
	$(".loading_it").click(function(){//a.loading_it为A链接中class为loading_it的标签 或 .loading_it通用
		show_loading();
	});
});

/*
document.onclick = function(e){
	$("a.aaa")
	var o = window.event.srcElement || window.event.target;   //FireFoxe  || IE
	if (o.tagName=="A" || o.tagName=="BUTTON" ){//o.tagName=="A"   大写
		 alert(o.className)
		 show_loading()
	}  
} 
*/
</script>
			
<div id="alert_go_div" class="modal hide fade no_bg" style="color:#111111; display:none;font-family:微软雅黑; width:420px;left:50%; margin-left:-210px;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3># 操作提示</h3>
  </div>
  
  <div class="modal-body">
		<!--内容 -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="m_tishi_pic" width="60px" valign="middle">&nbsp;</td>
            <td id="m_tishi_str" style="font-size:14px">&nbsp;</td>
          </tr>
        </table>
		<!--内容 -->
  </div>

  <div class="modal-footer">
	<span id="m_tishi_button1"></span>&nbsp;
	<span id="m_tishi_button2"></span>
  </div>
</div>