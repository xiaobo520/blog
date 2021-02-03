<div class="right_box">
			
			<div class="right_small">
				<div class="bozhu"><i class="icon-gift"></i>&nbsp;&nbsp;积分活动</div>
				<div class="jifen">
					<a href="/host/" target="_blank"><img src="/images/ad/ad_2.gif" width="260" height="260" /></a>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="right_small">
				<div class="right_tag"><i class="icon-th-large"></i>&nbsp;&nbsp;随手记</div>
				<div class="tuijian">
					<ul>
			<?
			if ($noid_news!=''){
				$noid_news=substr($noid_news,0,-1);
			}else{
				$noid_news="'000'";
			}
			
			$sql_search="select id,title from lei_news where pass='1' and id not in (".$noid_news.") order by id desc limit 10 ";
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			?>
						<li>●&nbsp;&nbsp;<a href="/news/<?=$rs["id"]?>.html" target="_blank" title="<?=$rs["title"]?>"><?=clear_all($rs["title"])?></a></li>
			<? }
			$noid_news='';
			?>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="right_small">
				<div class="right_tag"><i class="icon-question-sign"></i>&nbsp;&nbsp;WEB前端</div>
				<div class="tuijian">
					<ul>
			<?
			if ($noid_jingyan!=''){
				$noid_jingyan=substr($noid_jingyan,0,-1);
			}else{
				$noid_jingyan="'000'";
			}
			
			$sql_search="select id,title from lei_jingyan where pass='1' and id not in (".$noid_jingyan.") order by id desc limit 10 ";
			$result=$mysqli->query($sql_search);
			while ($rs=$result->fetch_assoc()){
			?>
						<li>●&nbsp;&nbsp;<a href="/jingyan/<?=$rs["id"]?>.html" target="_blank" title="<?=$rs["title"]?>"><?=clear_all($rs["title"])?></a></li>
			<? }
			$noid_jingyan='';
			?>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="right_small">
				<div class="right_tag"><i class="icon-share"></i>&nbsp;&nbsp;关注分享</div>
				<div class="bd_shbox">
					<div class="bds_qzone_0_32" onclick="share_mdaima('qzone','','','','')" ></div>
					<div class="bds_tsina_0_32" onclick="share_mdaima('tsina','','','','')"></div>
					<div class="bds_tqq_0_32" onclick="share_mdaima('tqq','','','','')"></div>
					<div class="bds_renren_0_32" onclick="share_mdaima('renren','','','','')"></div>
					<div class="bds_weixin_0_32" onclick="share_mdaima('weixin','','','','')"></div>
				</div>
				
				<div class="clear"></div>
			</div>
			
			
			<div class="right_small" style="margin-bottom:0;">
				<div class="bozhu"><i class="icon-leaf"></i>&nbsp;&nbsp;联系博主</div>
				<div class="bozhu_lx">
					<span>QQ：</span><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1274148741&site=qq&menu=yes">1274148741</a>&nbsp;&nbsp;&nbsp;<span>个人微信号：</span>xb95556
					<div class="qrcode"><img src="/images/mdaima.jpg" width="180" height="178" /></div>
				</div>
				<div class="clear"></div>
			</div>
			
		</div>