
<!--ҳ�� ��ʼ-->
	  <div class="pagination pagination-centered" style="margin:1.5rem 0 1.5rem 0;">
	  <ul>
		<? 
		
		$pagenum=4;
		$lrpage=2;
		$mulu='';//ҳ��ָ��Ŀ¼��Ĭ��Ϊ�գ���/jingyan/

			if ($page<2) {
		?>      
			<li class="m_first"><a href="javascript:void(0);">&laquo;</a></li>
		<? }else{?>
			<li class="m_first" ><a href="<?=$mulu?>list-1.html<? if ($search_open=='ok'){ ?><? echo "?".$pageurl."&page=".$ii;}?>" >&laquo;</a></li>
		<? }
		
			if ($allnum<=$pagenum){
			   for ($ii=1; $ii<=$allnum; $ii++) {
			   //$search_open=='ok' �ж��Ƿ����û�������Ϊ�����������ܰ���������û������ʾ��β�Ŀհױ������ɾ���ǿ��֢�ַ��ˣ�
			   //�����ü��ܣ�����Ϊ���ܵ�ʱ���ǽ����յ�ȫ���ַ�����Ϊ���ݽ�������ҳ���������α��̬Ҳ������һ������ҳ�棬������ɵ���ַ�к�����ͨ�ͼ��ܻ�ϣ�����޷�����ʶ�����Ը�Ϊ��ͨ����
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
			  <li class="m_first"><a href="javascript:void(0);">��<?=$allnum?> &raquo;</a></li>
		<? }else{ ?>
			  <li class="m_first"><a href="<?=$mulu?>list-<?=$allnum?>.html<? if ($search_open=='ok'){ ?><? echo "?".$pageurl."&page=".$allnum;}?>" >��<?=$allnum?> &raquo;</a></li>
		<? }?>
		
		<!--<li class="m_first m_all_color"><a href="javascript:void(0);"># <?=$pageidcount?> #</a></li> -->
	</ul>
	</div>
<!--ҳ�� END -->
