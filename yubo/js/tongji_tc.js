

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


function check_tongji_tc()
{
	var divid=document.getElementById("tongji_tc")
	//date_tj_1=document.getElementById("date_tj_1").value;
	//date_tj_2=document.getElementById("date_tj_2").value;

	//获取当前选中的SELECT值
	//var riqitype=document.getElementById("riqitype")
	//var riqitype_value= riqitype.options[riqitype.options.selectedIndex].value;

	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("抱歉，浏览器不支持")
		return
	} 
	var url="tongji_tc.php"
	//url=url+"?action=chk&date_tj_1="+date_tj_1+"&date_tj_2="+date_tj_2+"&riqitype="+riqitype_value;
	url=url+"?action=chk";
	url=url+"&sid="+Math.random();
	
	divid.innerHTML="<div style='margin-top:20px;color:green'>请稍后，加载加......</div>";
	
	//return false; //中止
	
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

	
	function stateChanged() 
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	 //var result_str=xmlHttp.responseText.split("|");
			
			 
				document.getElementById("tongji_tc").innerHTML=xmlHttp.responseText;
				$("#mytable").tablesorter({  headers:{  1:{sorter:true}  }  });
				//document.getElementById('tongji_tc').style.display='';
				document.location.href="#bottom"; //返回底部
		 } 
	}

	

}

