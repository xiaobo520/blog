
function show(event,_this,mess) {
	event = event || window.event;
	var t1="<table     cellspacing='1' cellpadding='10' style='border-color:#CCCCCC;background-color:#FFFFFF;font-size:12px;border-style:solid;    border-width:thin;text-align:center;'><tr><td><img src='" + _this   + "' width='150' height='200' >    <br>"+mess+"</td></tr></table>";
	document.getElementById("a1").innerHTML =t1;
	//document.getElementById("a1").innerHTML = "<img src='" + _this.src + "' >";
	document.getElementById("a1").style.top  = $(window).scrollTop() + event.clientY + 10 + "px";//ÐèÒªJQ
	document.getElementById("a1").style.left = document.body.scrollLeft + event.clientX + 10 + "px";
	document.getElementById("a1").style.display = "block";
	//alert ($(window).scrollTop()+'----'+event.clientY); //document.body.scrollTop
	}

function hide(_this) {
	document.getElementById("a1").innerHTML = "";
	document.getElementById("a1").style.display = "none";
}