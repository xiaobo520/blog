
<script type="text/javascript">
	function fn(cnum,cxuan){//ID1-,A
	var bugstr = document.exam1.danxuan.value; // ��ѡ��¼����
	var bugstr1=bugstr.split(",");
	var bugstr2="";
	var weidanum=0;
	for (i=0;i<bugstr1.length-1;i++)
	{
		
		if (i==cnum-1){
			bugstr2=bugstr2+cxuan;
		}else{
			bugstr2=bugstr2+bugstr1[i];
		}
		if (i<bugstr1.length-1){bugstr2=bugstr2+",";}
	}
	
	var bugstr2a=bugstr2.split(",");
	for (ii=0;ii<bugstr2a.length-1;ii++)
	{
		if (bugstr2a[ii]=="#"){weidanum=weidanum+1;}
	}
	
	document.exam1.danxuan.value=bugstr2;
	document.getElementById("dx1").innerHTML=bugstr2a.length-1-weidanum;
	//document.write(bugstr2)
	//alert(bugstr2);
	//var reg = new RegExp(cnum+'*,');  
	//bugstr = bugstr.replace(reg,cnum+cxuan+',');
}
</script>




<script type="text/javascript">
	function fn1(cnum,cxuan,xuhao){//ID1-,A
	var bugstr = document.exam1.duoxuan.value;
	var bugstr1=bugstr.split(",");
	var bugstr2="";
	var weidanum=0;
	var boxstr="lei_db_tiku_b_"+cnum;
	var value="";
	var box=document.getElementsByName(boxstr);
	for (i=0;i<bugstr1.length-1;i++)
	{
		
		for (var ii=0;ii<box.length;ii++ ){ 
			if(box[ii].checked){ //�жϸ�ѡ���Ƿ�ѡ�� 
			value=value+box[ii].value;
			} 
		} 
		if (value==""){value="#";}  //����ֵѡΪ��ֵ�Ǹ���ʼֵ#
		
		if (i==xuhao-1){            //��ǰѡ�еĸ���ֵ
			bugstr2=bugstr2+value;
		}else{                      //���ǵ�ǰѡ�еı���ԭֵ���� 
			bugstr2=bugstr2+bugstr1[i];
		}
		if (i<bugstr1.length-1){bugstr2=bugstr2+",";}
		
		var value="";  //��ʼ��������ֹһ��ֵ����ظ�
	}
	
	var bugstr2a=bugstr2.split(",");
	for (iii=0;iii<bugstr2a.length-1;iii++)
	{
		if (bugstr2a[iii]=="#"){weidanum=weidanum+1;}
	}
	
	document.exam1.duoxuan.value=bugstr2;
	document.getElementById("dx2").innerHTML=bugstr2a.length-1-weidanum;
}
</script>

<script type="text/javascript">
	function fn2(cnum,cxuan){//ID1-,A
	var bugstr = document.exam1.pdxuan.value;
	var bugstr1=bugstr.split(",");
	var bugstr2="";
	var weidanum=0;
	for (i=0;i<bugstr1.length-1;i++)
	{
		
		if (i==cnum-1){
			bugstr2=bugstr2+cxuan;
		}else{
			bugstr2=bugstr2+bugstr1[i];
		}
		if (i<bugstr1.length-1){bugstr2=bugstr2+",";}
	}
	
	var bugstr2a=bugstr2.split(",");
	for (ii=0;ii<bugstr2a.length-1;ii++)
	{
		if (bugstr2a[ii]=="#"){weidanum=weidanum+1;}
	}
	
	document.exam1.pdxuan.value=bugstr2;
	document.getElementById("dx3").innerHTML=bugstr2a.length-1-weidanum;
	//document.write(bugstr2)
	//alert(bugstr2);
	//var reg = new RegExp(cnum+'*,');  
	//bugstr = bugstr.replace(reg,cnum+cxuan+',');
}
</script>



<script type="text/javascript">
function tishi(jj){
	var bugstr_1 = document.exam1.danxuan.value;//�����¼���뽻��ȷ��
	var bugstr1_1=bugstr_1.split(",");
	var weidanstr_1="";	
	for (ii=0;ii<bugstr1_1.length-1;ii++)
	{
		if (bugstr1_1[ii]=="#"){weidanstr_1=weidanstr_1+(ii+1)+"��";}//"<a href=#a"+(ii+1)+">"+(ii+1)+"</a>��";
	}	
	
	var bugstr_2 = document.exam1.duoxuan.value;
	var bugstr1_2=bugstr_2.split(",");
	var weidanstr_2="";
	for (ii=0;ii<bugstr1_2.length-1;ii++)
	{
		if (bugstr1_2[ii]=="#"){weidanstr_2=weidanstr_2+(ii+1)+"��";}
	}	
	
	var bugstr_3 = document.exam1.pdxuan.value;
	var bugstr1_3=bugstr_3.split(",");
	var weidanstr_3="";
	for (ii=0;ii<bugstr1_3.length-1;ii++)
	{
		if (bugstr1_3[ii]=="#"){weidanstr_3=weidanstr_3+(ii+1)+"��";}
	}
	
	if (weidanstr_1==""){weidanstr_1="ȫ�����";}
	if (weidanstr_2==""){weidanstr_2="ȫ�����";}
	if (weidanstr_3==""){weidanstr_3="ȫ�����";}
	
	if (jj=="jiaojuan") {
		var tistr1="";
		if (weidanstr_1!="ȫ�����" || weidanstr_2!="ȫ�����" || weidanstr_3!="ȫ�����" ){tistr1="(������Ŀδ����)";}
	
		document.getElementById("titles").innerHTML ="����ȷ���Ƿ񽻾�"+tistr1;
		//document.getElementById("tishisrc").src ="images/ask.gif"; <a href="#" onClick="tishi()" data-reveal-id="myModal" data-animation="fade" class="btn btn_success" >������</a>
		document.getElementById("tibutton").innerHTML ="<input type='button' onclick=document.forms['exam1'].submit(); class='btn btn_success btn_big' value='ȷ�Ͻ���' /> ";
	}else{
		document.getElementById("titles").innerHTML ="����û����ɵ���Ŀ������£�";
		document.getElementById("tibutton").innerHTML ="";
	//document.getElementById("tishisrc").src ="images/info.gif";
	//document.getElementById("tibutton").innerHTML ="<input type='button' name='Submita' style='height:28px;' value=' �� �� ' onClick=massage_box.style.visibility='hidden';closeWindow(); />";
	}
	
	var endstr="";
	if (bugstr1_1.length>1){endstr=endstr+"�ﵥѡ�⣺"+weidanstr_1+"<br>";}
	if (bugstr1_2.length>1){endstr=endstr+"���ѡ�⣺"+weidanstr_2+"<br>";}
	if (bugstr1_3.length>1){endstr=endstr+"���ж��⣺"+weidanstr_3+"<br>";}
	
	document.getElementById("tishistr").innerHTML =endstr;
	
	//document.getElementById("massage_box").style.visibility='visible';
	//showMessageBox();
}
</script>

<script language="JavaScript">
	var examtime = <?=$timeover?>; //����ʱ��
	var intLeft = 60*examtime+1;
	
	function leavePage() {
		if (0 == intLeft){
			alert('����ʱ�䵽��') ;
			document.forms["exam1"].submit(); 
			}
		else{
			intLeft -= 1;
			min1=Math.floor(intLeft/60); //parseInt
				if(min1<1){min1="0";}
			min2=intLeft%60;
				if(min2<10){min2="0"+min2;} 
			document.getElementById("countdown").innerHTML = "<span class='timestyle timebg'>"+min1+"</span>" + " �� " + "<span class='timestyle2 timebg'>"+min2+"</span>" +" ��" + " ";
			sfen=examtime-min1-1;
			smiao=60-min2;
			if (smiao==60){sfen=sfen+1;smiao=0}
			document.exam1.shijianjl.value =sfen+" �� " + smiao+ " ��" + " ";
			document.exam1.shijian.value ="<span class=examtimeover>"+sfen+"</span>" + " �� " + "<span class=examtimeover>"+smiao+"</span>" + " ��" + " ";
			setTimeout("leavePage()", 1000);
			}
	}
	//setTimeout('leavePage()',1000)   //���ݷ��������� onload����
</script>
