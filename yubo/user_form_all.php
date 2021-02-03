<li>
					<label>用户名：</label><input name="user_search" type="text" class="input length_3" id="user_search" value="<?=$user_search?>">
				</li>
				
				<li>
					<label>昵称：</label><input name="nicheng_search" type="text" class="input length_3" id="nicheng_search" value="<?=$nicheng_search?>" onFocus="check_pinzhong()" onKeyUp="check_pinzhong()" autocomplete="off" placeholder="昵称或拼音首字母">
					<div style="position:relative;">
						<div id="showdanwei"></div>
					</div>
				</li>
				
				<li>
					<label>手机号码：</label><input name="tel_search" type="text" class="input length_3" id="tel_search" value="<?=$tel_search?>" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>
				
				
				<li>
					<label>注册时间：</label><input name="date1_search" type="text" id="date1_search" value="<?=$date1_search?>" size="10"  onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true" class="input length_7" /> - <input name="date2_search" type="text" id="date2_search" value="<?=$date2_search?>" size="10" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true"  class="input length_7" />
				</li>
				
				<li>
					<label>排序：</label><select name="px_search" id="px_search" class="select_3" >
            <option value="" <? if ($px_search==''){?>selected="selected"<? }?>>--默认--</option>
			<option value="1" <? if ($px_search=='1'){?>selected="selected"<? }?>>--注册时间（正序）--</option>
			<option value="2" <? if ($px_search=='2'){?>selected="selected"<? }?>>--注册时间（倒序）--</option>
			<option value="3" <? if ($px_search=='3'){?>selected="selected"<? }?>>--活跃时间（正序）--</option>
			<option value="4" <? if ($px_search=='4'){?>selected="selected"<? }?>>--活跃时间（倒序）--</option>
          </select>
				</li>
				
				<li>
					<label>状态：</label><select name="zhuangtai_search" id="zhuangtai_search" class="select_3" >
            <option value="" <? if ($zhuangtai_search==''){?>selected="selected"<? }?>>--全部--</option>
			<option value="0" <? if ($zhuangtai_search=='0'){?>selected="selected"<? }?>>审核中</option>
			<option value="1" <? if ($zhuangtai_search=='1'){?>selected="selected"<? }?>>正常</option>
			<option value="90" <? if ($zhuangtai_search=='90'){?>selected="selected"<? }?>>回收站（已删除）</option>
          </select>
				</li>
				
				
				<li>
					<label>每页行数：</label><input name="pagenums_search" type="text" class="input length_3" id="pagenums_search" value="<?=$pagenums_search?>" maxlength="3" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>