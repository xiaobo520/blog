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


function givecookie(pd_value)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("±§Ç¸£¬ä¯ÀÀÆ÷²»Ö§³Ö")
		return
	}
	
	if (pd_value=='close'){
		document.getElementById('m_search_close').style.display='none';
		document.getElementById('m_search_open').style.display='';
		$('#m_search_box').fadeOut();
		//$('#m_search_box').hide(500);
	}else{
		document.getElementById('m_search_open').style.display='none';
		document.getElementById('m_search_close').style.display='';
		$('#m_search_box').fadeIn();
		//$('#m_search_box').show(500);
		
	}
	
	var url="set_cookie.php"
	url=url+"?action=chk&pd_value="+pd_value
	url=url+"&sid="+Math.random()
	
	//xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
	

}