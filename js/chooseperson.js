function chkall()
 {
	var ck=document.getElementsByName("persons");//����checkbox�������
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
	var obj=document.getElementsByName('persons'); //ѡ������name="'test'"�Ķ��󣬷������� 
	//ȡ�����������������ѭ��������ǲ��Ǳ�ѡ�� 
	var s=','; 
	for(var i=0; i<obj.length; i++){ 
		if(obj[i].checked) s+=obj[i].value+','; //���ѡ�У���value��ӵ�����s�� 
	} 
	//��ô���������s��ֵ��֪��ѡ�еĸ�ѡ���ֵ�� 
	//alert(s==''?'�㻹û��ѡ���κ����ݣ�':s); 
	
	var ajaxform=$.post("chooseperson.php",{content:s},function(result){														
		$("#choose_statu").html(result);  //����ʾ��д����
	});
	
}
*/

function chooseperson(a){ 
	var ajaxform=$.post("chooseperson.php",{content:a},function(result){														
		$("#choose_statu").html(result);  //����ʾ��д����
	});
	
} 

function chooseperson_check(a){ 
	if(document.getElementById("persons_"+a)){ //�жϱ�ǩ�Ƿ���ڣ���ֹJS����
		document.getElementById("persons_"+a).checked=false;//ͬ����ǰ�б��ѡ��״̬
		//alert(a)
	}
	
} 