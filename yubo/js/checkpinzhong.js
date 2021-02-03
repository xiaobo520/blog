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


function check_pinzhong(){
	var divid=document.getElementById("nicheng_search")
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("抱歉，浏览器不支持")
		return
	} 
	var url="get_user.php"
	url=url+"?action=chk&pinzhong="+divid.value
	url=url+"&sid="+Math.random()
	
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

	
	function stateChanged() 
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	 var result_str=xmlHttp.responseText.split("|");
			
			 if (xmlHttp.responseText.indexOf("error_no_pz") >= 0){
				document.getElementById('showdanwei').style.display='none';
			 }else{
				document.getElementById("showdanwei").innerHTML=result_str[1];
				document.getElementById('showdanwei').style.display='block';
				
			}
		 } 
		 
	}

	

}

function focus2(){
	document.getElementById('danwei_search').focus(); //不获取焦点，要点两次
}
function close_pz(){
	document.getElementById('showdanwei').style.display='none';
}