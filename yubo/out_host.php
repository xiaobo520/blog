<?php
header("content-type:text/html; charset=gb2312");
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 
set_time_limit(0);
ini_set('memory_limit','256M');

require_once("../PHPExcel.php"); 
require_once("../PHPExcel/Writer/Excel5.php"); 

$url_info = geturl($_SERVER[QUERY_STRING],$key_url_md_5);

$action=$url_info['action'];
$sqls=base64_decode($url_info['sqls']);
$time=$url_info['time'];


//clear_all(

if ( (time()-$time)>$var_outhours*3600 ){
	echo "<script language=javascript>alert('��ҳ���ڣ���ֹ������');javascript:history.back(-1);</script>";
	exit;
}

if ($action=="excel" ){

	$objExcel = new PHPExcel();          
	$objWriter = new PHPExcel_Writer_Excel5($objExcel);          
	$objExcel->setActiveSheetIndex(0);       
	$objActSheet = $objExcel->getActiveSheet();    
	$objActSheet->setTitle(iconv('gbk','utf-8','Sheet1'));//������
	
	//######################################  �б���
	$objActSheet->getColumnDimension('A')->setWidth(8); //�п�
	$objActSheet->getColumnDimension('B')->setWidth(26); 
	$objActSheet->getColumnDimension('C')->setWidth(22);
	$objActSheet->getColumnDimension('D')->setWidth(35);
	$objActSheet->getColumnDimension('E')->setWidth(13);
	$objActSheet->getColumnDimension('F')->setWidth(22);
	$objActSheet->getColumnDimension('G')->setWidth(8);
	$objActSheet->getColumnDimension('H')->setWidth(51);
	
	$objActSheet->mergeCells('A1:H1');      // �ϲ�
	$objActSheet->setCellValue('A1',iconv('gbk','utf-8','����������¼'));
	
	$objActSheet->mergeCells('A2:H2');      // �ϲ�
	$objActSheet->setCellValue('A2',iconv('gbk','utf-8',date("Y��m��d��")));

	$objActSheet->setCellValue('A3',iconv('gbk','utf-8','���'));
	$objActSheet->setCellValue('B3',iconv('gbk','utf-8','������'));    
	$objActSheet->setCellValue('C3',iconv('gbk','utf-8','�û���'));
	$objActSheet->setCellValue('D3',iconv('gbk','utf-8','�����ͺ�'));
	$objActSheet->setCellValue('E3',iconv('gbk','utf-8','��/�ɼ�'));
	$objActSheet->setCellValue('F3',iconv('gbk','utf-8','����ʱ��'));
	$objActSheet->setCellValue('G3',iconv('gbk','utf-8','״̬'));
	$objActSheet->setCellValue('H3',iconv('gbk','utf-8','������Ϣ'));


	//################################################################
	
	$result=$mysqli->query($sqls);
	$n=3;
	$i=0;
	while ($rs=$result->fetch_assoc()){
	
	$n=$n+1;
	$i=$i+1;
		$zt=$rs["zt"];
		if ($zt=='1'){
			$zt_str='������';
		}elseif ($zt=='2'){
			$zt_str='����ͨ';
		}elseif ($zt=='3'){
			$zt_str='�ѿ�ͨ';
		}elseif ($zt=='90'){
			$zt_str='��ȡ��';
		}else{
			$zt_str='--';
		}
		
		$kt_lxr=$rs["kt_lxr"];
		$kt_tel=$rs["kt_tel"];
		$kt_qq=$rs["kt_qq"];
		$kt_ftp_u=$rs["kt_ftp_u"];
		$kt_ftp_p=$rs["kt_ftp_p"];
		$kt_enddate=$rs["kt_enddate"];
		
		$zhuji_info="��ϵ��������".$kt_lxr."</br>���ֻ��ţ�".$kt_tel."����������ʱ����֪ͨ��</br>��ϵQQ��".$kt_qq."</br>FTP�û�����".$kt_ftp_u."</br>FTP���룺".$kt_ftp_p." ���ɵ�¼������������޸ģ�</br>�������ڣ�".$kt_enddate;
		//$objActSheet->getRowDimension($n)->setRowHeight(30); //�߶� ѭ����
		//$objActSheet->getStyle('A'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//���õ�Ԫ��߿�Top
		//$objActSheet->getStyle('A'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//���õ�Ԫ��߿� Left  
		//$objActSheet->getStyle('A'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//���õ�Ԫ��߿�Right   
		//$objActSheet->getStyle('A'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//���õ�Ԫ��߿�Bottom
		
		//�����ַ���iconv('gbk','utf-8',$rs->xingming)
		
		$objActSheet->setCellValueExplicit('A'.$n,iconv('gbk','utf-8',$i),PHPExcel_Cell_DataType::TYPE_STRING);  
		$objActSheet->setCellValueExplicit('B'.$n,iconv('gbk','utf-8',text_excel($rs["dh"])),PHPExcel_Cell_DataType::TYPE_STRING); 
		$objActSheet->setCellValueExplicit('C'.$n,iconv('gbk','utf-8',text_excel($rs["username"])),PHPExcel_Cell_DataType::TYPE_STRING); 
		$objActSheet->setCellValueExplicit('D'.$n,iconv('gbk','utf-8',text_excel($rs["xinghao"])),PHPExcel_Cell_DataType::TYPE_STRING); 
		$objActSheet->setCellValueExplicit('E'.$n,iconv('gbk','utf-8',text_excel(($rs["jiage"]*$rs["host_nianxian"])." / ".($rs["jiage"]*$rs["host_nianxian"]-$rs["host_jifen"]))),PHPExcel_Cell_DataType::TYPE_STRING); 
		$objActSheet->setCellValueExplicit('F'.$n,iconv('gbk','utf-8',text_excel($rs["indate"])),PHPExcel_Cell_DataType::TYPE_STRING); 
		$objActSheet->setCellValueExplicit('G'.$n,iconv('gbk','utf-8',text_excel($zt_str)),PHPExcel_Cell_DataType::TYPE_STRING); 
		$objActSheet->setCellValueExplicit('H'.$n,iconv('gbk','utf-8',text_excel($zhuji_info)),PHPExcel_Cell_DataType::TYPE_STRING); 


	}   
	
	$n=$n+1;
	
	$objActSheet->mergeCells('B'.$n.':H'.$n);      // �ϲ�
	$vas='����ʱ�䣺'.date("Y-m-d H:i:s");
	$objActSheet->setCellValue('B'.$n,iconv('gbk','utf-8',$vas));
	
	//================���õ�Ԫ���ʽ�������ƴ˵�Ԫ��ĸ�ʽ��ָ������
	
		$objStyleA1 = $objActSheet->getStyle('A1'); 
		 
		$objAlignA1 = $objStyleA1->getAlignment();  
		$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //���Ҿ��� 
		$objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //���¾���
		  
		$objFontA1 = $objStyleA1->getFont();  //���弰��ɫ 
		$objFontA1->setName(iconv('gbk','utf-8','����'));  
		$objFontA1->setSize(22);
		$objFontA1->getColor()->setARGB('FF000000'); 
		
		//$objActSheet->getStyle('A1')->getFont()->setName(iconv('gbk','utf-8','����')); //��ݷ�ʽָ������ 
		
		$objActSheet->getStyle('A3:H'.$n)->getAlignment()->setWrapText(true);//�Զ����У��ӵ�һ��δ�ϲ���λ��������ʼ
		//$objActSheet->getDefaultRowDimension()->setRowHeight(20);//Ĭ���иߣ����Զ����г�ͻ
		$objActSheet->getRowDimension('1')->setRowHeight(35);//ָ����1�и�  getColumnDimension('A')->setWidth(15);�п�
		$objActSheet->getRowDimension('2')->setRowHeight(25);//ָ����2�и�
		$objActSheet->getRowDimension('3')->setRowHeight(25);//ָ����3�и�
		$objActSheet->getRowDimension($n)->setRowHeight(90);//ָ����3�и�
		
		$objActSheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objActSheet->getStyle('A2')->getFont()->setSize(12);
		$objActSheet->getStyle('A2')->getFont()->setName(iconv('gbk','utf-8','����'));
		
		$objActSheet->getStyle('A3:B'.($n-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objActSheet->getStyle('A3:B'.($n-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
		$objStyleA5 = $objActSheet->getStyle('A3');//������ʽ��
		$objBorderA5 = $objStyleA5->getBorders();//���ñ߿�
		$objBorderA5->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA5->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA5->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA5->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		
		$objFontA5 = $objStyleA5->getFont();  //��������
		$objFontA5->setName(iconv('gbk','utf-8','����'));  
		$objFontA5->setSize(12);  
		//$objFontA5->setBold(true);  
		//$objFontA5->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);  
		//$objFontA5->getColor()->setARGB('FF999999');   

		$objActSheet->duplicateStyle($objStyleA5,'A3:H3');//ִ�и�����ʽ����
		
		
		
		$objStyleA6 = $objActSheet->getStyle('A3');//������ʽ��
		$objBorderA6 = $objStyleA6->getBorders();//���ñ߿�
		$objBorderA6->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA6->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA6->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA6->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		
		$objFontA6 = $objStyleA6->getFont();  //��������
		$objFontA6->setName(iconv('gbk','utf-8','����'));  
		$objFontA6->setSize(10);  
		$objActSheet->duplicateStyle($objStyleA6,'A4:H'.$n);//ִ�и�����ʽ����
		
		
		$objStyleA7 = $objActSheet->getStyle('A3');//������ʽ��
		$objFontA7 = $objStyleA7->getFont();  //��������
		$objFontA7->setName(iconv('gbk','utf-8','����'));  
		$objFontA7->setSize(12);  
		$objFontA7->setBold(true); 
		$objActSheet->duplicateStyle($objStyleA7,'A3:H3');//ִ�и�����ʽ����
		
		
		$objStyleA8 = $objActSheet->getStyle('B'.$n);//������ʽ��
		$objFontA8 = $objStyleA8->getFont();  //�������� 
		$objFontA8->setBold(true); 
		$objFontA8->setSize(10);  
		$objActSheet->duplicateStyle($objStyleA8,'B'.$n);//ִ�и�����ʽ����
		
		
		
		$objStyleA9 = $objActSheet->getStyle('B4');//�����żӴ�
		$objFontA9 = $objStyleA9->getFont();  //�������� 
		$objFontA9->setBold(true); 
		$objFontA9->setSize(12);  
		$objActSheet->duplicateStyle($objStyleA9,'B4:B'.($n-1));//ִ�и�����ʽ����
		
		$objActSheet->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objActSheet->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	//================���õ�Ԫ���ʽ�������ƴ˵�Ԫ��ĸ�ʽ��ָ������ 
	  
		$outputFileName = "out_xls/host.xls";       
		//���ļ�       
		$objWriter->save($outputFileName);       
		//���������������и�ҳ����Ajax���շ��ص���Ϣ
		//echo "<script>alert('������Ϣ���ܱ����ɹ���\\n\\n�����ı������޸ģ���ȫѡ�����õ�Ԫ���ʽΪ���ı����󷽿��޸�');location.href='out_excel/".$_SESSION['user_baoming_kaodian'].".xls';</script>";
		echo "<script>alert('���ݵ����ɹ���');</script>";
		?>
		<div style="text-align:center; margin-top:50px;">
		  <div style="margin:auto;width:460px; border:1px dashed #0066FF; background:#F5F5F5; padding:20px; line-height:30px; font-size:12px; text-align:left;">
			  <a href="down.php?<?=encrypt_url("&filename=����������¼ͳ�Ʊ�&url=".base64_encode('out_xls/host.xls')."&time=".time(),$key_url_md_5)?>" target="_blank" style="text-decoration:none">��������</a>
		  </div>
		  <div style="text-align:center; margin-top:25px;"><input type="button" value=" �ر� " name="button1" style=" width:80px; height:30px;" onClick="javascript:window.close();return false;" /></div>
		</div> 
		<?
} 


?>