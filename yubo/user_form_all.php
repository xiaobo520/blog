<li>
					<label>�û�����</label><input name="user_search" type="text" class="input length_3" id="user_search" value="<?=$user_search?>">
				</li>
				
				<li>
					<label>�ǳƣ�</label><input name="nicheng_search" type="text" class="input length_3" id="nicheng_search" value="<?=$nicheng_search?>" onFocus="check_pinzhong()" onKeyUp="check_pinzhong()" autocomplete="off" placeholder="�ǳƻ�ƴ������ĸ">
					<div style="position:relative;">
						<div id="showdanwei"></div>
					</div>
				</li>
				
				<li>
					<label>�ֻ����룺</label><input name="tel_search" type="text" class="input length_3" id="tel_search" value="<?=$tel_search?>" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>
				
				
				<li>
					<label>ע��ʱ�䣺</label><input name="date1_search" type="text" id="date1_search" value="<?=$date1_search?>" size="10"  onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true" class="input length_7" /> - <input name="date2_search" type="text" id="date2_search" value="<?=$date2_search?>" size="10" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true"  class="input length_7" />
				</li>
				
				<li>
					<label>����</label><select name="px_search" id="px_search" class="select_3" >
            <option value="" <? if ($px_search==''){?>selected="selected"<? }?>>--Ĭ��--</option>
			<option value="1" <? if ($px_search=='1'){?>selected="selected"<? }?>>--ע��ʱ�䣨����--</option>
			<option value="2" <? if ($px_search=='2'){?>selected="selected"<? }?>>--ע��ʱ�䣨����--</option>
			<option value="3" <? if ($px_search=='3'){?>selected="selected"<? }?>>--��Ծʱ�䣨����--</option>
			<option value="4" <? if ($px_search=='4'){?>selected="selected"<? }?>>--��Ծʱ�䣨����--</option>
          </select>
				</li>
				
				<li>
					<label>״̬��</label><select name="zhuangtai_search" id="zhuangtai_search" class="select_3" >
            <option value="" <? if ($zhuangtai_search==''){?>selected="selected"<? }?>>--ȫ��--</option>
			<option value="0" <? if ($zhuangtai_search=='0'){?>selected="selected"<? }?>>�����</option>
			<option value="1" <? if ($zhuangtai_search=='1'){?>selected="selected"<? }?>>����</option>
			<option value="90" <? if ($zhuangtai_search=='90'){?>selected="selected"<? }?>>����վ����ɾ����</option>
          </select>
				</li>
				
				
				<li>
					<label>ÿҳ������</label><input name="pagenums_search" type="text" class="input length_3" id="pagenums_search" value="<?=$pagenums_search?>" maxlength="3" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>