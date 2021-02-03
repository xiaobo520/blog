function chkall()
 {
	var ck=document.getElementsByName("persons");//定义checkbox数组变量
	for(var i=0;i<ck.length;i++)
	{
		if (ck[i].disabled!=true){
			 ck[i].checked=!ck[i].checked; 
		}  
	}
	chooseperson();
 }
	 
/*	 
function chooseperson(){ 
	var obj=document.getElementsByName('persons'); //选择所有name="'test'"的对象，返回数组 
	//取到对象数组后，我们来循环检测它是不是被选中 
	var s=','; 
	for(var i=0; i<obj.length; i++){ 
		if(obj[i].checked) s+=obj[i].value+','; //如果选中，将value添加到变量s中 
	} 
	//那么现在来检测s的值就知道选中的复选框的值了 
	//alert(s==''?'你还没有选择任何内容！':s); 
	
	var ajaxform=$.post("chooseperson.php",{content:s},function(result){														
		$("#choose_statu").html(result);  //给提示层写文字
	});
	
}
*/

function chooseperson(a){ 
	var ajaxform=$.post("chooseperson.php",{content:a},function(result){														
		$("#choose_statu").html(result);  //给提示层写文字
	});
	
} 

function chooseperson_check(a){ 
	if(document.getElementById("persons_"+a)){ //判断标签是否存在，防止JS报错
		document.getElementById("persons_"+a).checked=false;//同步当前列表的选择状态
		//alert(a)
	}
	
} 