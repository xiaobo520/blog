
<!--页码 开始-->
	  <div class="pagination pagination-centered" style="margin:1.5rem 0 1.5rem 0;">
	  <ul>
		<? 
		
		$pagenum=4;
		$lrpage=2;
		$mulu='';//页码指向目录，默认为空，或/jingyan/

			if ($page<2) {
		?>      
			<li class="m_first"><a href="javascript:void(0);">&laquo;</a></li>
		<? }else{?>
			<li class="m_first" ><a href="<?=$mulu?>list-1.html<? if ($search_open=='ok'){ ?><? echo "?".$pageurl."&page=".$ii;}?>" >&laquo;</a></li>
		<? }
		
			if ($allnum<=$pagenum){
			   for ($ii=1; $ii<=$allnum; $ii++) {
			   //$search_open=='ok' 判断是否有用户搜索行为，如果有则加密包含变量，没有则不显示结尾的空白变量，干净（强迫症又犯了）
			   //不采用加密，是因为解密的时候是将接收的全部字符串做为内容解析，而页码里采用了伪静态也传递了一个参数页面，造成生成的网址中含有普通和加密混合，造成无法正常识别，所以改为普通明文
			   ?>
				<li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="<?=$mulu?>list-<?=$ii?>.html<? if ($search_open=='ok'){ ?><? echo "?".$pageurl."&page=".$ii;}?>" ><?=$ii?></a></li>
		<?     }
			}else{
			
				if ($page<$pagenum){
				  for ($ii=1; $ii<=$pagenum; $ii++) {
		?>
				  <li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="<?=$mulu?>list-<?=$ii?>.html<? if ($search_open=='ok'){ ?><? echo "?".$pageurl."&page=".$ii;}?>"><?=$ii?></a></li>
		<?        }
				}else{
				  if ($page+$lrpage>=$allnum){
					  $pageend=$allnum;
				  }else{
					  $pageend=$page+$lrpage;
				  }
				  
				  for ($ii=($page-$lrpage); $ii<=$pageend; $ii++){
		?>
				  <li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="<?=$mulu?>list-<?=$ii?>.html<? if ($search_open=='ok'){ ?><? echo "?".$pageurl."&page=".$ii;}?>"><?=$ii?></a></li>
		<?        }
				}
			}   
			
		   if ($allnum-$page<1) {?>
			  <li class="m_first"><a href="javascript:void(0);">…<?=$allnum?> &raquo;</a></li>
		<? }else{ ?>
			  <li class="m_first"><a href="<?=$mulu?>list-<?=$allnum?>.html<? if ($search_open=='ok'){ ?><? echo "?".$pageurl."&page=".$allnum;}?>" >…<?=$allnum?> &raquo;</a></li>
		<? }?>
		
		<!--<li class="m_first m_all_color"><a href="javascript:void(0);"># <?=$pageidcount?> #</a></li> -->
	</ul>
	</div>
<!--页码 END -->
