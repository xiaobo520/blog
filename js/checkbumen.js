var xmlHttp

function GetXmlHttpObject(){
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
	
}


function check_danwei(){
	var divid=document.getElementById("chushiname")
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("抱歉，浏览器不支持")
		return
	} 
	var url="checkbumen.php"
	url=url+"?action=chk&p=1&pinzhong="+divid.value
	url=url+"&sid="+Math.random()
	
	xmlHttp.onreadystatechange=stateChanged1 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

	
	function stateChanged1() 
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	 var result_str=xmlHttp.responseText.split("|");
			
			 if (xmlHttp.responseText.indexOf("error_no_pz") >= 0){
				document.getElementById('showdanwei2').style.display='none';
			 }else{
				document.getElementById("showdanwei2").innerHTML=result_str[1];
				document.getElementById('showdanwei2').style.display='block';
				
			}
		 } 
		 
	}

	

}

function focus2(){
	document.getElementById('chushiname').focus(); //不获取焦点，要点两次
}

function close_pz(){
	document.getElementById('showdanwei2').style.display='none';
}

function html_open(a){
	window.open (a,'newwindow','height=300,width=400,top=50,left=200,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no') 
}