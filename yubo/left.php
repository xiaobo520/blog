<?php
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 
?>

<style type="text/css">
body {
	margin:0px;
	background: #F6F6F6;/*#FAFAFA*/
	overflow:scroll;
	overflow-x:hidden;
}

	li.title {list-style: none;}
	ul.ztree {overflow:hidden}/*����������ʽ*/
	li{ list-style:none}
	.rolinList{ height:auto;margin-left:-40px;*margin-left:5px;_margin-left:4px;}
</style>
	
	<link rel="stylesheet" href="css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.ztree.core-3.5.js"></script>
	<script type="text/javascript" src="js/jquery.ztree.exhide-3.5.min.js"></script>
	
	
	<!--<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>-->
	
	<SCRIPT type="text/javascript">
		<!--
		var setting = {
			view: {
				dblClickExpand: true,
				showLine: true,
				fontCss: getFont,
				nameIsHTML: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				onClick: onClick
			}
		};
		
		var setting2 = {
			view: {
				dblClickExpand: true,
				showLine: true,
				fontCss: getFont,
				nameIsHTML: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				onClick: onClick
			}
		};

		var zNodes =[
			{ id:1, pId:0, name:"ϵͳ��ҳ", open:true},
			//,iconOpen:"css/zTreeStyle/img/diy/note-remove.png", iconClose:"css/zTreeStyle/img/diy/note-add.png"
			{ id:11, pId:1, name:"ˢ�º�̨",url:"admin_index.php", target:"_top", icon:"css/zTreeStyle/img/diy/1_open.png"},
			{ id:12, pId:1, name:"�ҵ���Ϣ",url:"myinfo.php", target:"frmright", icon:"css/zTreeStyle/img/diy/id.png"},
			{ id:13, pId:1, name:"�����޸�",url:"password.php", target:"frmright", icon:"css/zTreeStyle/img/diy/lock.png"},
			{ id:14, pId:1, name:"��վ��ҳ",url:"/", target:"_blank", icon:"css/zTreeStyle/img/diy/help_circle.png"},

			

			{ id:99999, pId:0, name:"�˳�ϵͳ",open:true,isParent:true,url:"login_true.php?action=out", target:"_top"}
		
		];
		
		var zNodes2 =[
			{ id:2, pId:0, name:"վ�����", open:true,isHidden:false},
			{ id:22, pId:2, name:"ǰ̨����",open:false},
				{ id:221, pId:22, name:"���ڲ���",open:true,url:"message_edit.php?<?=encrypt_url("&id=1&time=".time(),$key_url_md_5)?>", target:"frmright", icon:"css/zTreeStyle/img/diy/user_gray.png"},
				{ id:222, pId:22, name:"��վ����",open:true,url:"message_edit.php?<?=encrypt_url("&id=2&time=".time(),$key_url_md_5)?>", target:"frmright", icon:"css/zTreeStyle/img/diy/newspaper.png"},
				{ id:223, pId:22, name:"��������",open:true,url:"message_edit.php?<?=encrypt_url("&id=3&time=".time(),$key_url_md_5)?>", target:"frmright", icon:"css/zTreeStyle/img/diy/table_edit.png"},
				{ id:224, pId:22, name:"��ϵ����",open:true,url:"message_edit.php?<?=encrypt_url("&id=4&time=".time(),$key_url_md_5)?>", target:"frmright", icon:"css/zTreeStyle/img/diy/recycle_bin_empty.png"},
				{ id:225, pId:22, name:"��ȡ����",open:true,url:"message_edit.php?<?=encrypt_url("&id=5&time=".time(),$key_url_md_5)?>", target:"frmright", icon:"css/zTreeStyle/img/diy/rss.png"},
				{ id:226, pId:22, name:"�������",open:true,url:"message_edit.php?<?=encrypt_url("&id=6&time=".time(),$key_url_md_5)?>", target:"frmright", icon:"css/zTreeStyle/img/diy/images_night_scene.png"},
				{ id:227, pId:22, name:"���ʽ",open:true,url:"message_edit.php?<?=encrypt_url("&id=7&time=".time(),$key_url_md_5)?>", target:"frmright", icon:"css/zTreeStyle/img/diy/money_yen.png"},
				{ id:228, pId:22, name:"��������",open:true,url:"link.php", target:"frmright", icon:"css/zTreeStyle/img/diy/bonsai.png"},
				{ id:229, pId:22, name:"��վ��ͼ",open:true,url:"map.php", target:"frmright", icon:"css/zTreeStyle/img/diy/direction_board.png"},
			{ id:33, pId:2, name:"ҵ�����",open:true},
			{ id:330, pId:33, name:"WEB",open:true,url:"jingyan_list.php", target:"frmright", icon:"css/zTreeStyle/img/diy/html.png"},
			{ id:331, pId:33, name:"���ּ�",open:true,url:"news_list.php", target:"frmright", icon:"css/zTreeStyle/img/diy/library_occupied.png"},
			{ id:333, pId:33, name:"��Ա����",open:true,url:"user.php", target:"frmright", icon:"css/zTreeStyle/img/diy/group_gear.png"},
			{ id:334, pId:33, name:"���Թ���",open:true,url:"fayan.php", target:"frmright", icon:"css/zTreeStyle/img/diy/tag_blue_edit.png"},
			{ id:335, pId:33, name:"���ֹ���",open:true,url:"jifen.php", target:"frmright", icon:"css/zTreeStyle/img/diy/coins.png"},
			{ id:336, pId:33, name:"ϵͳ����",open:true,url:"canshu.php", target:"frmright", icon:"css/zTreeStyle/img/diy/cog.png"},
			{ id:337, pId:33, name:"��ǩ����",open:true,url:"keyword_set.php", target:"frmright", icon:"css/zTreeStyle/img/diy/monitor.png"},
			{ id:338, pId:33, name:"MYSQL���",open:true,url:"status_mysql.php", target:"frmright", icon:"css/zTreeStyle/img/diy/8.png"},
			{ id:99999, pId:0, name:"�˳�ϵͳ",open:true,isParent:true,url:"login_true.php?action=out", target:"_top"},
			
			{ id:44, pId:2, name:"��������",open:false},
			{ id:441, pId:44, name:"��������",open:true,url:"daima_list.php", target:"frmright", icon:"css/zTreeStyle/img/diy/tag.png"}

		
		];
	

		function onClick(e,treeId, treeNode) {
			//$.fn.zTree.getZTreeObj("treeDemo").expandNode(treeNode);
			//$.fn.zTree.getZTreeObj("treeDemo2").expandNode(treeNode);
			//alert(treeId+","+treeNode.id + ", " + treeNode.name+","+treeNode.pId);
			if (treeNode.name!='��վ��ҳ' && treeNode.name!='�˳�ϵͳ'  && treeNode.name!='ϵͳ��ҳ'  && treeNode.name!='վ�����'  && treeNode.name!='ǰ̨����'  && treeNode.name!='ҵ�����' ){
				show_loading();//����loading
			}

		}
		
		
		function getFont(treeId, node) {
			return node.font ? node.font : {};
		}
		/*
		
		treeObj.hideNode(nodes[4]);//showNode,hideNode
		
		*/
		function getdanwei() {//��ʾ���ع���
			document.getElementById("treeDemo").style.display="none";
			document.getElementById("treeDemo2").style.display="none";
			
			document.getElementById("treeDemo2").style.display="";
		}
		
		function getfirst() {//��ʾ���ع���
			document.getElementById("treeDemo").style.display="none";
			document.getElementById("treeDemo2").style.display="none";
			
			document.getElementById("treeDemo").style.display="";
		}

		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			$.fn.zTree.init($("#treeDemo2"), setting2, zNodes2);
		});
		//-->
	</SCRIPT>
	
<noscript><iframe src="*.htm"></iframe></noscript>
<body oncontextmenu="return false" ondragstart="return false" onselectstart="return false" >


<? include_once("js/js_alert.php"); //����MODULE������?>

	<ul class="rolinList" id="rolin" >
		<li> 
			<div id="shulist" style="overflow-x:hidden;overflow-y:hidden; width:185px;*width:180px;_width:180px;padding-top:0;*padding-top:10px;_padding-top:10px;">
				<ul id="treeDemo" class="ztree" style="padding-bottom:10px; padding-top:10px;" ></ul>
				<ul id="treeDemo2" class="ztree" style="padding-bottom:10px; padding-top:10px; display:none" ></ul>
			</div>
		</li>
	</ul>
	
	<!--<script>
		(function($){
			$(window).load(function(){
				$.mCustomScrollbar.defaults.scrollButtons.enable=true;
				$("#rolin").mCustomScrollbar({
					autoHideScrollbar:true,
					scrollInertia:0,
					mouseWheelPixels:15,
					scrollButtons:{enable:false,scrollSpeed:20,scrollAmount:15},
					theme:"dark-3"
				});
				
				/*$("body").mCustomScrollbar({
					theme:"minimal"
				});*/

			});
			//���ҳ style="border-right:1px solid #cfd8e0; "
		})(jQuery);
	</script>-->
	
	<script>
	document.getElementById("shulist").style.height=(document.body.clientHeight-2)+"px"; 
	//document.getElementById("shulist").style.height=100+"px"; 
	
	
	$(window).load(function(){
		$("#shulist").mouseover(function () {
			$(this).css("overflow-y","auto");
		});
		$("#shulist").mouseleave(function () {
			$(this).css("overflow-y","hidden");
		});
	});

	</script>
</body>

	