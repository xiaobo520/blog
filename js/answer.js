function answer(){ //��ע���﷨
	$("#codeimg").hide();
	$("#answer").val('�����ύ...');  //����ʾ��д����
	document.getElementById("answer").disabled='disabled';//��ʱ����
	//$("#answer").css({'background':'#CCCCCC'});
	$('#answer').attr('class','pinglun_submit gray');//�ύʱ����ʽ
	
	var content = hf_box.getContent();
	var cid=$("#cid").val();//����ID
	//maxlou=parseInt($("#maxlou").val())+1;
	var nicheng=$("#nicheng").val();
	var email=$("#email").val();
	var atab=$("#atab").val();
	var hfindate=$("#hfindate").val();
	var xuan_img=$("#xuan_img").val();
	var code=$("#code").val();
	var gid=$("#gid").val();//�����۵�ID�������������ID
	var guser=$("#guser").val();
	var gemail=$("#gemail").val();
	var ghref=$("#ghref").val();//���������ǣ���¼Ψһ����תêID
	var gmail_check=$("#gmail_check").val();
	
	if (atab=='3'){
		bt_str='��������';
	}else{
		bt_str='��������';
	}

	var ajaxform=$.post("/giveanswer.php",{content:content,cid:cid,atab:atab,nicheng:nicheng,email:email,xuan_img:xuan_img,code:code,gid:gid,guser:guser,gemail:gemail,gmail_check:gmail_check},function(result){	
		//$("#question_statu").html(result);  //����ʾ��д����
		if (result.indexOf("�ظ��ύ�ɹ�") >= 0){
			
			if (gid=='' && guser==''){//һ���ظ�
				if ($("#no_pinglun_value").val()=='yes'){//����ǵ�һ�λظ�����Ҫ������ʾ����������β�ĺ���
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
				if ($("#meiyoubox_lou_"+gid).val()=='yes'){//�ж�����Ѿ��лظ��ˣ��������
					var newstr_lou="<a name='huifu_href_"+gid+"_"+ghref+"' id='huifu_href_"+gid+"_"+ghref+"'></a><div class='hf_top_line'></div>";
					var nshow='yes';
					$("#ghref").val((ghref+1));//����������
				}else{//�״λظ�����������
					var newstr_lou="<a name='huifu_href_"+gid+"_"+ghref+"' id='huifu_href_"+gid+"_"+ghref+"'></a>";//��תλ�õ�ê��
					$("#meiyoubox_lou_"+gid).val('yes');//�Ѿ��������ˣ��ͱ��Ϊ�Ѿ�����
					var nshow='no';
					$("#ghref").val((ghref+1));
				}
				var newstr=newstr_lou+"<div id='hf_hf_two'><div style='float:left; width:60px; text-align:left'><img src='"+xuan_img+"' class='hf_img_f'/></div><div style='float:left; width:550px;'><div class='hf_user_info'><div class='hf_uandd'>"+nicheng+" <span style='font-size:14px; color: #999999'>&nbsp;&nbsp;�ظ�&nbsp;&nbsp;</span> <span style='font-size:14px; color: #009966; font-weight:bold;'>"+guser+"</span><span>&nbsp;&nbsp;/&nbsp;&nbsp;"+hfindate+"</span></div></div><div class='hf_message'>"+content+"</div></div><div class='clear'></div></div>";
				
				document.getElementById("hf_two_"+gid).innerHTML=document.getElementById("hf_two_"+gid).innerHTML+newstr;
				if (nshow=='no'){//�ϸ��飬��ֹJS����ֻ��ÿһ�ζ����ظ�����
					$("#meiyoubox_"+gid).show();  //��ʾ
				}
				//document.location.href='#meiyoubox_lou_'+gid;
				$("html,body").animate({scrollTop:$("#huifu_href_"+gid+"_"+ghref).offset().top}, 500);
			}
			
			//Ӧ�ô������Ч��
			uParse('#huifubox',{
				'highlightJsUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCore.js',
				'highlightCssUrl':'/js/tooledit/ueditor_baidu/third-party/SyntaxHighlighter/shCoreDefault.css'
			});
			SyntaxHighlighter.all();
			
			UE.getEditor('hf_box').setContent('');//д������
			$("#answer").val(bt_str);  //��ť����
			document.getElementById("answer").disabled='';
			$('#answer').attr('class','pinglun_submit blue');
			
			$("#question_statu").html(result);  //����ʾ��д����
			$("#question_statu").show();  //��ʾ����ʾ
			
			var ajaxform=$.post("/givemail.php",{content:content,cid:cid,atab:atab,nicheng:nicheng,email:email,gid:gid,guser:guser,gemail:gemail,gmail_check:gmail_check});
			
			$("#code").val('');//�����֤��
			second_hf_close();//�����ظ�״̬��ԭ
			setTimeout("qingkong()",3000);  //��ʱ���DIV״̬

		}else {
			$("#question_statu").html(result);  //���ط�������������ʾ������
			$("#question_statu").fadeIn();  //��ʾ�㵭��
			setTimeout("qingkong()",3000);  //��ʱ���DIV״̬
			$("#answer").val(bt_str);  //��ť����
			document.getElementById("answer").disabled='';//�������
			$('#answer').attr('class','pinglun_submit blue');//��ԭ��ť��Ĭ����ʽ
		}
	});
	
};

function qingkong(){
	//$("#question_statu").html('');  //��ղ�����
	$("#question_statu").fadeOut();  //����ʾ��д����
	//UE.getEditor('hf_box').execCommand('cleardoc');//�����������Բ�
	//$("#answer").css({'background':'#FF9900'});
	//$("#question_statu").css({color:"",display:"none"}); //���ز�����
}

function second_hf(id,guser,gemail){//�ظ����ӵ�ID�����ظ��ˣ����ظ���email
	var se_hf_str='';
	$("#gid").val(id);//���ظ���һ���ظ�ID�������µ�ֱ�ӻظ����������ظ�Ϊ�Իظ��˽��е����ۣ����ڿ���Ļظ���
	$("#guser").val(guser);//���ظ���
	$("#gemail").val(gemail);//���ظ���email
	
	$("#gmail_check").val('1');//ÿ�ε����ҪĬ��Ϊ����
	var atab=$("#atab").val();
	if (atab=='3'){
		var bt_str='��������';
	}else{
		var bt_str='��������';
	}

	var se_hf_str=se_hf_str+'<div id="hf_showuser" style="color:#666666;font-weight:normal; font-size:12px;float:left"><i class="icon-hand-right" ></i>&nbsp;&nbsp; �ظ���'+guser+'</div><div style="color:#666666;font-weight:normal; font-size:12px;float:left">&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	var se_hf_str=se_hf_str+'<div class="icheckbox_flat-black checked" id="check_email" onclick="check_mail_v()"></div><div style="color:#666666;font-weight:normal; font-size:12px;float:left;">&nbsp;&nbsp;���ʼ�����TA&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	var se_hf_str=se_hf_str+'<div onclick="second_hf_close()" style="font-size:12px; font-weight:normal;background:#006666;color:#FFFFFF; padding:0 10px;line-height:35px; margin-top:8px; cursor:pointer;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;float:left;"><i class="icon-remove-sign icon-white" ></i> ȡ���ԡ�'+guser+'���Ļظ�����Ϊ'+bt_str+'</div>';
	
	$("#second_hf").html(se_hf_str);
	$("#second_hf").fadeIn();
	UE.getEditor('hf_box').focus();
	$("html,body").animate({scrollTop:$("#pinglun_step").offset().top},600);//ê
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


function more_answer(cid){ //��ע���﷨
	var atab=$("#atab").val();
	$("#more_ans_show_"+cid).html('����Ŭ�����أ����Ե�...');  //����ʾ��д����
	var ajaxform=$.post("/getmore.php",{cid:cid,atab:atab},function(result){
		$("#more_ans_show_"+cid).hide();
		$("#more_button_"+cid).hide();
		$("#more_line_"+cid).hide();
		document.getElementById("more_ans_"+cid).innerHTML=document.getElementById("more_ans_"+cid).innerHTML+result;
		//alert(result)
	})
}
