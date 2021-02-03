function answer(){ //多注意语法
	$("#codeimg").hide();
	$("#answer").val('正在提交...');  //给提示层写文字
	document.getElementById("answer").disabled='disabled';//暂时禁用
	//$("#answer").css({'background':'#CCCCCC'});
	$('#answer').attr('class','pinglun_submit gray');//提交时的样式
	
	var content = hf_box.getContent();
	var cid=$("#cid").val();//文章ID
	//maxlou=parseInt($("#maxlou").val())+1;
	var nicheng=$("#nicheng").val();
	var email=$("#email").val();
	var atab=$("#atab").val();
	var hfindate=$("#hfindate").val();
	var xuan_img=$("#xuan_img").val();
	var code=$("#code").val();
	var gid=$("#gid").val();//被评论的ID，即框里的评论ID
	var guser=$("#guser").val();
	var gemail=$("#gemail").val();
	var ghref=$("#ghref").val();//共用特殊标记，记录唯一的跳转锚ID
	var gmail_check=$("#gmail_check").val();
	
	if (atab=='3'){
		bt_str='发表留言';
	}else{
		bt_str='发表评论';
	}

	var ajaxform=$.post("/giveanswer.php",{content:content,cid:cid,atab:atab,nicheng:nicheng,email:email,xuan_img:xuan_img,code:code,gid:gid,guser:guser,gemail:gemail,gmail_check:gmail_check},function(result){	
		//$("#question_statu").html(result);  //给提示层写文字
		if (result.indexOf("回复提交成功") >= 0){
			
			if (gid=='' && guser==''){//一级回复
				if ($("#no_pinglun_value").val()=='yes'){//如果是第一次回复，需要隐藏提示，并不带结尾的横线
					$("#no_pinglun").hide();
					$("#no_pinglun_value").val('no');
					var hf_line='';
				}else{
					var hf_line="<div class='hf_line'></div>";
				}
				var newstr="<div id='pinglun_big_box'><div style='float:left; width:60px; text-align:left'><img src='"+xuan_img+"' class='hf_img'/></div><div style='float:left; width:680px;'><div class='hf_user_info'><div class='hf_uandd'>"+nicheng+"<span>&nbsp;&nbsp;/&nbsp;&nbsp;"+hfindate+"</span></div></div><div class='hf_message'>"+content+"</div></div></div>"+hf_line;
				
				document.getElementById("huifubox").innerHTML=newstr+document.getElementById("huifubox").innerHTML;
				$("html,body").animate({scrollTop:$("#huifu").offset().top}, 500);
				//$("#maxlou").val(maxlou);
			}else{
				if ($("#meiyoubox_lou_"+gid).val()=='yes'){//判断如果已经有回复了，则带虚线
					var newstr_lou="<a name='huifu_href_"+gid+"_"+ghref+"' id='huifu_href_"+gid+"_"+ghref+"'></a><div class='hf_top_line'></div>";
					var nshow='yes';
					$("#ghref").val((ghref+1));//共用特殊标记
				}else{//首次回复，不加虚线
					var newstr_lou="<a name='huifu_href_"+gid+"_"+ghref+"' id='huifu_href_"+gid+"_"+ghref+"'></a>";//跳转位置的锚点
					$("#meiyoubox_lou_"+gid).val('yes');//已经有内容了，就标记为已经有了
					var nshow='no';
					$("#ghref").val((ghref+1));
				}
				var newstr=newstr_lou+"<div id='hf_hf_two'><div style='float:left; width:60px; text-align:left'><img src='"+xuan_img+"' class='hf_img_f'/></div><div style='float:left; width:550px;'><div class='hf_user_info'><div class='hf_uandd'>"+nicheng+" <span style='font-size:14px; color: #999999'>&nbsp;&nbsp;回复&nbsp;&nbsp;</span> <span style='font-size:14px; color: #009966; font-weight:bold;'>"+guser+"</span><span>&nbsp;&nbsp;/&nbsp;&nbsp;"+hfindate+"</span></div></div><div class='hf_message'>"+content+"</div></div><div class='clear'></div></div>";
				
				document.getElementById("hf_two_"+gid).innerHTML=document.getElementById("hf_two_"+gid).innerHTML+newstr;
				if (nshow=='no'){//严格检查，防止JS错误，只有每一次二级回复才有
					$("#meiyoubox_"+gid).show();  //显示
				}
				//document.location.href='#meiyoubox_lou_'+gid;
				$("html,body").animate({scrollTop:$("#huifu_href_"+gid+"_"+ghref).offset().top}, 500);
			}
			
			//应用代码高亮效果
			uParse('#huifubox',{
				'highlightJsUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js',
				'highlightCssUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css'
			});
			SyntaxHighlighter.all();
			
			UE.getEditor('hf_box').setContent('');//写空内容
			$("#answer").val(bt_str);  //按钮文字
			document.getElementById("answer").disabled='';
			$('#answer').attr('class','pinglun_submit blue');
			
			$("#question_statu").html(result);  //给提示层写文字
			$("#question_statu").show();  //提示层显示
			
			var ajaxform=$.post("/givemail.php",{content:content,cid:cid,atab:atab,nicheng:nicheng,email:email,gid:gid,guser:guser,gemail:gemail,gmail_check:gmail_check});
			
			$("#code").val('');//清空验证码
			second_hf_close();//二级回复状态还原
			setTimeout("qingkong()",3000);  //定时清空DIV状态

		}else {
			$("#question_statu").html(result);  //返回服务器给出的提示层文字
			$("#question_statu").fadeIn();  //提示层淡出
			setTimeout("qingkong()",3000);  //定时清空DIV状态
			$("#answer").val(bt_str);  //按钮文字
			document.getElementById("answer").disabled='';//解除禁用
			$('#answer').attr('class','pinglun_submit blue');//还原按钮的默认样式
		}
	});
	
};

function qingkong(){
	//$("#question_statu").html('');  //清空层文字
	$("#question_statu").fadeOut();  //给提示层写文字
	//UE.getEditor('hf_box').execCommand('cleardoc');//清空命令兼容性差
	//$("#answer").css({'background':'#FF9900'});
	//$("#question_statu").css({color:"",display:"none"}); //隐藏层文字
}

function second_hf(id,guser,gemail){//回复帖子的ID，被回复人，被回复人email
	var se_hf_str='';
	$("#gid").val(id);//被回复的一级回复ID（即文章的直接回复），二级回复为对回复人进行的评论（即在框里的回复）
	$("#guser").val(guser);//被回复人
	$("#gemail").val(gemail);//被回复人email
	
	$("#gmail_check").val('1');//每次点击都要默认为发送
	var atab=$("#atab").val();
	if (atab=='3'){
		var bt_str='博主留言';
	}else{
		var bt_str='文章评论';
	}

	var se_hf_str=se_hf_str+'<div id="hf_showuser" style="color:#666666;font-weight:normal; font-size:12px;float:left"><i class="icon-hand-right" ></i>&nbsp;&nbsp; 回复：'+guser+'</div><div style="color:#666666;font-weight:normal; font-size:12px;float:left">&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	var se_hf_str=se_hf_str+'<div class="icheckbox_flat-black checked" id="check_email" onclick="check_mail_v()"></div><div style="color:#666666;font-weight:normal; font-size:12px;float:left;">&nbsp;&nbsp;发邮件告诉TA&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	var se_hf_str=se_hf_str+'<div onclick="second_hf_close()" style="font-size:12px; font-weight:normal;background:#006666;color:#FFFFFF; padding:0 10px;line-height:35px; margin-top:8px; cursor:pointer;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;float:left;"><i class="icon-remove-sign icon-white" ></i> 取消对“'+guser+'”的回复，改为'+bt_str+'</div>';
	
	$("#second_hf").html(se_hf_str);
	$("#second_hf").fadeIn();
	UE.getEditor('hf_box').focus();
	$("html,body").animate({scrollTop:$("#pinglun_step").offset().top},600);//锚
	setInterval(function(){ $("#hf_showuser").fadeOut(500).fadeIn(500); },1500); 
}

function second_hf_close(){
	UE.getEditor('hf_box').focus();
	$("#second_hf").fadeOut();
	$("#gid").val('');
	$("#guser").val('');
	$("#gemail").val('');
}

function check_mail_v() {

    if ($("#gmail_check").val()=='1'){
		$("#gmail_check").val('0');
		$('#check_email').attr('class','icheckbox_flat-black');
	}else{
		$("#gmail_check").val('1');
		$('#check_email').attr('class','icheckbox_flat-black checked');
	}
};


function more_answer(cid){ //多注意语法
	var atab=$("#atab").val();
	$("#more_ans_show_"+cid).html('正在努力加载，请稍等...');  //给提示层写文字
	var ajaxform=$.post("/getmore.php",{cid:cid,atab:atab},function(result){
		$("#more_ans_show_"+cid).hide();
		$("#more_button_"+cid).hide();
		$("#more_line_"+cid).hide();
		document.getElementById("more_ans_"+cid).innerHTML=document.getElementById("more_ans_"+cid).innerHTML+result;
		//alert(result)
	})
}
