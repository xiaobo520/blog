<li>
					<label>���±��⣺</label><input name="title_search" type="text" class="input length_3" id="title_search" value="<?=$title_search?>">
				</li>
				
				<li>
					<label>����ID��</label><input name="id_search" type="text" class="input length_3" id="id_search" value="<?=$id_search?>">
				</li>
								
				<?
				//if ($date1_search=='' || $date2_search==''){//Ĭ����ʾ���7���
					//$last_date=date("Y-m-d",strtotime("last Friday"));//next last
				//	$last_date=date("Y-m-d",strtotime("-7 day"));
				//	$date1_search=$last_date;
				//	$date2_search=date("Y-m-d");
				//}
				?>
				
				
				<li>
					<label>�������ڣ�</label><input name="date1_search" type="text" id="date1_search" value="<?=$date1_search?>" size="10"  onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true" class="input length_7" title="�������ڵĿ�ʼʱ��"/> - <input name="date2_search" type="text" id="date2_search" value="<?=$date2_search?>" size="10" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')" onFocus="WdatePicker({skin:'twoer'})" readonly="true"  class="input length_7" title="�������ڵ���ֹʱ��"/>
				</li>
				
				<li>
					<label>����</label><select name="px_search" id="px_search" class="select_3" >
            <option value="" <? if ($px_search==''){?>selected="selected"<? }?>>--Ĭ��--</option>
			<option value="1" <? if ($px_search=='1'){?>selected="selected"<? }?>>--����ʱ�䣨����--</option>
			<option value="2" <? if ($px_search=='2'){?>selected="selected"<? }?>>--����ʱ�䣨����--</option>
          </select>
				</li>
				
				<li>
					<label>״̬��</label><select name="zhuangtai_search" id="zhuangtai_search" class="select_3" >
            <option value="" <? if ($zhuangtai_search==''){?>selected="selected"<? }?>>--ȫ��--</option>
			<option value="0" <? if ($zhuangtai_search=='0'){?>selected="selected"<? }?>>δ����</option>
			<option value="1" <? if ($zhuangtai_search=='1'){?>selected="selected"<? }?>>����</option>
          </select>
				</li>
				
				<li>
					<label>��ѯ���ȣ�</label><select name="jingdu_search" id="jingdu_search" class="select_3" >
			<option value="0" <? if ($jingdu_search=='0' || $jingdu_search==''){?>selected="selected"<? }?> title="�ؼ��ʿ�������д�����ÿո�">ģ����ѯ</option>
			<option value="1" <? if ($jingdu_search=='1'){?>selected="selected"<? }?> title="�ؼ����Կո�ָ�">��ȷ��ѯ</option>
          </select>
				</li>

				
				
				<li>
					<label>ÿҳ������</label><input name="pagenums_search" type="text" class="input length_3" id="pagenums_search" value="<?=$pagenums_search?>" maxlength="3" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g,'')">
				</li>