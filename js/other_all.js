
$(document).ready(function(){
						   
	$("#jingdu").click(function(){// 搜索精度
		//$(".jingdu").toggleClass("jingdu_click");
		//alert($.cookie('search_jingdu'));
		if( !document.cookie || !navigator.cookieEnabled){
			alert("您的浏览器未开启Cookie支持，部分功能无法使用！");
			return false;
		}else{
			if ($.cookie('search_jingdu')=='0' || $.cookie('search_jingdu')==null){
				document.getElementById("jingdu").className='jingdu jingdu_click';
				$.cookie('search_jingdu', '1', { expires: 365, path: '/' });
				document.getElementById("jingdu").innerHTML='<i class="icon-zoom-in icon-white" ></i> 精确';
			}else{
				document.getElementById("jingdu").className='jingdu';
				$.cookie('search_jingdu', '0', { expires: 365, path: '/' });
				document.getElementById("jingdu").innerHTML='<i class="icon-zoom-out icon-white" ></i> 模糊';
			}
		}
		
	});
	
	
	$("#search_fo").click(function(){// 搜索精度
		//$(".jingdu").toggleClass("jingdu_click");
		//alert($.cookie('search_jingdu'));
		if( !document.cookie || !navigator.cookieEnabled){
			alert("您的浏览器未开启Cookie支持，部分功能无法使用！");
			return false;
		}else{
			if ($.cookie('search_fo')=='0' || $.cookie('search_fo')==null){
				document.getElementById("search_fo").className='search_fo search_fo_click';
				$.cookie('search_fo', '1', { expires: 365, path: '/' });
				document.getElementById("search_fo").innerHTML='随手记';
				document.getElementById("index_search").action='/news/?search_open=ok';
			}else{
				document.getElementById("search_fo").className='search_fo';
				$.cookie('search_fo', '0', { expires: 365, path: '/' });
				document.getElementById("search_fo").innerHTML='PHP经验';
				document.getElementById("index_search").action='/jingyan/?search_open=ok';
			}
		}
		
	});
	
});


/*动感光波模式*/
/*document.write('<script src="/js/typing.js"></script>')*/

