
<!--页码 开始-->
	  <div class="pagination pagination-right">
	  <ul>
		<? 
		$page=$page_1;
		$allnum=$allnum_1;
		$pageidcount=$pageidcount_1;
		
		$pagenum=10;
		$lrpage=4;
		$mulu='';//页码指向目录，默认为空，或/jingyan/

			if ($page<2) {
		?>      
			<li class="m_first"><a href="javascript:void(0);">&laquo;</a></li>
		<? }else{?>
			<li class="m_first" ><a href="<?=$mulu?><?=$cid?>-1.html#huifu" >&laquo;</a></li>
		<? }
		
			if ($allnum<=$pagenum){
			   for ($ii=1; $ii<=$allnum; $ii++) {?>
				<li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="<?=$mulu?><?=$cid?>-<?=$ii?>.html#huifu" ><?=$ii?></a></li>
		<?     }
			}else{
			
				if ($page<$pagenum){
				  for ($ii=1; $ii<=$pagenum; $ii++) {
		?>
				  <li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="<?=$mulu?><?=$cid?>-<?=$ii?>.html#huifu"><?=$ii?></a></li>
		<?        }
				}else{
				  if ($page+$lrpage>=$allnum){
					  $pageend=$allnum;
				  }else{
					  $pageend=$page+$lrpage;
				  }
				  
				  for ($ii=($page-$lrpage); $ii<=$pageend; $ii++){
		?>
				  <li <? if ($page==$ii) { ?>class="disabled"<? }else{?>class="active"<? }?>><a href="<?=$mulu?><?=$cid?>-<?=$ii?>.html#huifu"><?=$ii?></a></li>
		<?        }
				}
			}   
			
		   if ($allnum-$page<1) {?>
			  <li class="m_first"><a href="javascript:void(0);">…<?=$allnum?> &raquo;</a></li>
		<? }else{ ?>
			  <li class="m_first"><a href="<?=$mulu?><?=$cid?>-<?=$allnum?>.html#huifu" >…<?=$allnum?> &raquo;</a></li>
		<? }?>
		
		<li class="m_first m_all_color"><a href="javascript:void(0);">共 <?=$pageidcount?> 条评论</a></li>
	</ul>
	</div>
<!--页码 END -->
