var i = 0;
function getColor(){
	i++;
	switch(i){ 
		case 1:return "#FF0000";
		case 2:return "#0000FF";
		case 3:return "#FF9900";
		case 4:return "#33CC00";
		case 5:return "#FF6699";
		default:return "black";
	}
}
function colorful(a){
	var o =document.getElementById(a);
	o.style.color=getColor();
	alert(a)
	if(i==5)i=0;
	setTimeout(function(){'colorful('+a+')'},300); 
}
