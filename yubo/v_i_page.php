
<!--ҳ�� ��ʼ-->
	  <div class="pagination pagination-right">
	  <ul>
		<? 
		
		$pagenum=10;
		$lrpage=4;
		$mulu='';//ҳ��ָ��Ŀ¼��Ĭ��Ϊ�գ���/jingyan/
			if ($page<2) {
		?>      
			<li class="m_first"><a href="javascript:void(0);">&laquo;</a></li>
		<? }else{?>
			<li class="m_first" ><a href="?<?=encrypt_url("&page=1&".$pageurl."&aid=".$aid."&time=".time(),$key_url_md_5)?>" >&laquo;</a></li>
		<? }
		
			if ($allnum<=$pagenum){
			   for ($ii=1; $ii<=$allnum; $ii++) {?>
				<li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="?<?=encrypt_url("&page=".$ii."&aid=".$aid."&".$pageurl."&time=".time(),$key_url_md_5)?>" ><?=$ii?></a></li>
		<?     }
			}else{
			
				if ($page<$pagenum){
				  for ($ii=1; $ii<=$pagenum; $ii++) {
		?>
				  <li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="?<?=encrypt_url("&page=".$ii."&aid=".$aid."&".$pageurl."&time=".time(),$key_url_md_5)?>"><?=$ii?></a></li>
		<?        }
				}else{
				  if ($page+$lrpage>=$allnum){
					  $pageend=$allnum;
				  }else{
					  $pageend=$page+$lrpage;
				  }
				  
				  for ($ii=($page-$lrpage); $ii<=$pageend; $ii++){
		?>
				  <li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="?<?=encrypt_url("&page=".$ii."&aid=".$aid."&".$pageurl."&time=".time(),$key_url_md_5)?>"><?=$ii?></a></li>
		<?        }
				}
			}   
			
		   if ($allnum-$page<1) {?>
			  <li class="m_first"><a href="javascript:void(0);">��<?=$allnum?> &raquo;</a></li>
		<? }else{ ?>
			  <li class="m_first"><a href="?<?=encrypt_url("&page=".$allnum."&aid=".$aid."&".$pageurl."&time=".time(),$key_url_md_5)?>" >��<?=$allnum?> &raquo;</a></li>
		<? }?>
		
		<li class="m_first m_all_color"><a href="javascript:void(0);">�� <?=$pageidcount?> ��</a></li>
	</ul>
	</div>
<!--ҳ�� END -->
