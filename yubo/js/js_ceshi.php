
<script type="text/javascript">
	function fn(cnum,cxuan){//ID1-,A
	var bugstr = document.exam1.danxuan.value; // 单选记录作答
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
			if(box[ii].checked){ //判断复选框是否选中 
			value=value+box[ii].value;
			} 
		} 
		if (value==""){value="#";}  //从有值选为无值是赋初始值#
		
		if (i==xuhao-1){            //当前选中的更新值
			bugstr2=bugstr2+value;
		}else{                      //不是当前选中的保持原值不变 
			bugstr2=bugstr2+bugstr1[i];
		}
		if (i<bugstr1.length-1){bugstr2=bugstr2+",";}
		
		var value="";  //初始变量，防止一个值多次重复
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
	var bugstr_1 = document.exam1.danxuan.value;//答题记录，与交卷确认
	var bugstr1_1=bugstr_1.split(",");
	var weidanstr_1="";	
	for (ii=0;ii<bugstr1_1.length-1;ii++)
	{
		if (bugstr1_1[ii]=="#"){weidanstr_1=weidanstr_1+(ii+1)+"、";}//"<a href=#a"+(ii+1)+">"+(ii+1)+"</a>、";
	}	
	
	var bugstr_2 = document.exam1.duoxuan.value;
	var bugstr1_2=bugstr_2.split(",");
	var weidanstr_2="";
	for (ii=0;ii<bugstr1_2.length-1;ii++)
	{
		if (bugstr1_2[ii]=="#"){weidanstr_2=weidanstr_2+(ii+1)+"、";}
	}	
	
	var bugstr_3 = document.exam1.pdxuan.value;
	var bugstr1_3=bugstr_3.split(",");
	var weidanstr_3="";
	for (ii=0;ii<bugstr1_3.length-1;ii++)
	{
		if (bugstr1_3[ii]=="#"){weidanstr_3=weidanstr_3+(ii+1)+"、";}
	}
	
	if (weidanstr_1==""){weidanstr_1="全部完成";}
	if (weidanstr_2==""){weidanstr_2="全部完成";}
	if (weidanstr_3==""){weidanstr_3="全部完成";}
	
	if (jj=="jiaojuan") {
		var tistr1="";
		if (weidanstr_1!="全部完成" || weidanstr_2!="全部完成" || weidanstr_3!="全部完成" ){tistr1="(以下题目未作答)";}
	
		document.getElementById("titles").innerHTML ="请您确认是否交卷？"+tistr1;
		//document.getElementById("tishisrc").src ="images/ask.gif"; <a href="#" onClick="tishi()" data-reveal-id="myModal" data-animation="fade" class="btn btn_success" >答题检查</a>
		document.getElementById("tibutton").innerHTML ="<input type='button' onclick=document.forms['exam1'].submit(); class='btn btn_success btn_big' value='确认交卷' /> ";
	}else{
		document.getElementById("titles").innerHTML ="您还没有完成的题目序号如下：";
		document.getElementById("tibutton").innerHTML ="";
	//document.getElementById("tishisrc").src ="images/info.gif";
	//document.getElementById("tibutton").innerHTML ="<input type='button' name='Submita' style='height:28px;' value=' 关 闭 ' onClick=massage_box.style.visibility='hidden';closeWindow(); />";
	}
	
	var endstr="";
	if (bugstr1_1.length>1){endstr=endstr+"★单选题："+weidanstr_1+"<br>";}
	if (bugstr1_2.length>1){endstr=endstr+"★多选题："+weidanstr_2+"<br>";}
	if (bugstr1_3.length>1){endstr=endstr+"★判断题："+weidanstr_3+"<br>";}
	
	document.getElementById("tishistr").innerHTML =endstr;
	
	//document.getElementById("massage_box").style.visibility='visible';
	//showMessageBox();
}
</script>

<script language="JavaScript">
	var examtime = <?=$timeover?>; //考试时间
	var intLeft = 60*examtime+1;
	
	function leavePage() {
		if (0 == intLeft){
			alert('考试时间到！') ;
			document.forms["exam1"].submit(); 
			}
		else{
			intLeft -= 1;
			min1=Math.floor(intLeft/60); //parseInt
				if(min1<1){min1="0";}
			min2=intLeft%60;
				if(min2<10){min2="0"+min2;} 
			document.getElementById("countdown").innerHTML = "<span class='timestyle timebg'>"+min1+"</span>" + " 分 " + "<span class='timestyle2 timebg'>"+min2+"</span>" +" 秒" + " ";
			sfen=examtime-min1-1;
			smiao=60-min2;
			if (smiao==60){sfen=sfen+1;smiao=0}
			document.exam1.shijianjl.value =sfen+" 分 " + smiao+ " 秒" + " ";
			document.exam1.shijian.value ="<span class=examtimeover>"+sfen+"</span>" + " 分 " + "<span class=examtimeover>"+smiao+"</span>" + " 秒" + " ";
			setTimeout("leavePage()", 1000);
			}
	}
	//setTimeout('leavePage()',1000)   //部份服务器必须 onload调用
</script>
