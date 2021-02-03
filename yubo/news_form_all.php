<li>
					<label>文章标题：</label><input name="title_search" type="text" class="input length_3" id="title_search" value="<?=$title_search?>">
				</li>
				
				<li>
					<label>文章ID：</label><input name="id_search" type="text" class="input length_3" id="id_search" value="<?=$id_search?>">
				</li>
								
				<?
				//if ($date1_search=='' || $date2_search==''){//默认显示最近7天的
					//$last_date=date("Y-m-d",strtotime("last Friday"));//next last
				//	$last_date=date("Y-m-d",strtotime("-7 day"));
				//	$date1_search=$last_date;
				//	$date2_search=date("Y-m-d");
				//}
				?>
				
				
				<li>
					<label>发布日期：</label><input name="date1_search" type="text" id="date1_search" value="<?=$date1_search?>" size="10"  onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true" class="input length_7" title="发布日期的开始时间"/> - <input name="date2_search" type="text" id="date2_search" value="<?=$date2_search?>" size="10" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true"  class="input length_7" title="发布日期的终止时间"/>
				</li>
				
				<li>
					<label>排序：</label><select name="px_search" id="px_search" class="select_3" >
            <option value="" <? if ($px_search==''){?>selected="selected"<? }?>>--默认--</option>
			<option value="1" <? if ($px_search=='1'){?>selected="selected"<? }?>>--发布时间（正序）--</option>
			<option value="2" <? if ($px_search=='2'){?>selected="selected"<? }?>>--发布时间（倒序）--</option>
          </select>
				</li>
				
				<li>
					<label>状态：</label><select name="zhuangtai_search" id="zhuangtai_search" class="select_3" >
            <option value="" <? if ($zhuangtai_search==''){?>selected="selected"<? }?>>--全部--</option>
			<option value="0" <? if ($zhuangtai_search=='0'){?>selected="selected"<? }?>>未发布</option>
			<option value="1" <? if ($zhuangtai_search=='1'){?>selected="selected"<? }?>>发布</option>
          </select>
				</li>
				
				<li>
					<label>查询精度：</label><select name="jingdu_search" id="jingdu_search" class="select_3" >
			<option value="0" <? if ($jingdu_search=='0' || $jingdu_search==''){?>selected="selected"<? }?> title="关键词可任意填写，不用空格">模糊查询</option>
			<option value="1" <? if ($jingdu_search=='1'){?>selected="selected"<? }?> title="关键词以空格分隔">精确查询</option>
          </select>
				</li>

				
				
				<li>
					<label>每页行数：</label><input name="pagenums_search" type="text" class="input length_3" id="pagenums_search" value="<?=$pagenums_search?>" maxlength="3" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>