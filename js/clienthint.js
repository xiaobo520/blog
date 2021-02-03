var xmlHttp

function showHint(z_xitong)
{
if (z_xitong.length==0 )
  { 
  document.getElementById("txtHint").innerHTML=""
  return
  }
else{
	document.getElementById("txtHint").innerHTML="读取中，请稍后..."
	}
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("抱歉，浏览器不支持")
  return
  } 
var url="renyuan_duqu.php"
url=url+"?z_xitong="+z_xitong
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("txtHint").innerHTML=xmlHttp.responseText 
 } 
}

function GetXmlHttpObject()
{
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