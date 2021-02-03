// JavaScript Document
function goTopEx(){
	var obj=document.getElementById("goTopBtn");
	function getScrollTop(){
			return document.body.scrollTop||document.documentElement.scrollTop; 
		}
	function setScrollTop(value){
			document.documentElement.scrollTop=value;
			document.body.scrollTop=value;
			
		}    
	window.onscroll=function(){getScrollTop()>0?obj.style.display="":obj.style.display="none";}
	obj.onclick=function(){
		var goTop=setInterval(scrollMove,1);
		function scrollMove(){
				setScrollTop(getScrollTop()/1.1);
				if(getScrollTop()<1)clearInterval(goTop);
			}
	}
	
	//obj.style.top=(document.documentElement.clientHeight/2-70)+"px";  //简单层位置显示，不用JQ，先显示层，再用JS定位
	//obj.style.right="30px";
	
}