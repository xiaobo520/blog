<?php
header("content-type:text/html; charset=gb2312");
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
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
	echo "<script language=javascript>alert('网页过期，禁止操作！');javascript:history.back(-1);</script>";
	exit;
}

if ($action=="excel" ){

	$objExcel = new PHPExcel();          
	$objWriter = new PHPExcel_Writer_Excel5($objExcel);          
	$objExcel->setActiveSheetIndex(0);       
	$objActSheet = $objExcel->getActiveSheet();    
	$objActSheet->setTitle(iconv('gbk','utf-8','Sheet1'));//表名称
	
	//######################################  列标题
	$objActSheet->getColumnDimension('A')->setWidth(8); //列宽
	$objActSheet->getColumnDimension('B')->setWidth(26); 
	$objActSheet->getColumnDimension('C')->setWidth(22);
	$objActSheet->getColumnDimension('D')->setWidth(35);
	$objActSheet->getColumnDimension('E')->setWidth(13);
	$objActSheet->getColumnDimension('F')->setWidth(22);
	$objActSheet->getColumnDimension('G')->setWidth(8);
	$objActSheet->getColumnDimension('H')->setWidth(51);
	
	$objActSheet->mergeCells('A1:H1');      // 合并
	$objActSheet->setCellValue('A1',iconv('gbk','utf-8','订单导出记录'));
	
	$objActSheet->mergeCells('A2:H2');      // 合并
	$objActSheet->setCellValue('A2',iconv('gbk','utf-8',date("Y年m月d日")));

	$objActSheet->setCellValue('A3',iconv('gbk','utf-8','序号'));
	$objActSheet->setCellValue('B3',iconv('gbk','utf-8','订单号'));    
	$objActSheet->setCellValue('C3',iconv('gbk','utf-8','用户名'));
	$objActSheet->setCellValue('D3',iconv('gbk','utf-8','主机型号'));
	$objActSheet->setCellValue('E3',iconv('gbk','utf-8','订/成价'));
	$objActSheet->setCellValue('F3',iconv('gbk','utf-8','购买时间'));
	$objActSheet->setCellValue('G3',iconv('gbk','utf-8','状态'));
	$objActSheet->setCellValue('H3',iconv('gbk','utf-8','主机信息'));


	//################################################################
	
	$result=$mysqli->query($sqls);
	$n=3;
	$i=0;
	while ($rs=$result->fetch_assoc()){
	
	$n=$n+1;
	$i=$i+1;
		$zt=$rs["zt"];
		if ($zt=='1'){
			$zt_str='待付款';
		}elseif ($zt=='2'){
			$zt_str='待开通';
		}elseif ($zt=='3'){
			$zt_str='已开通';
		}elseif ($zt=='90'){
			$zt_str='已取消';
		}else{
			$zt_str='--';
		}
		
		$kt_lxr=$rs["kt_lxr"];
		$kt_tel=$rs["kt_tel"];
		$kt_qq=$rs["kt_qq"];
		$kt_ftp_u=$rs["kt_ftp_u"];
		$kt_ftp_p=$rs["kt_ftp_p"];
		$kt_enddate=$rs["kt_enddate"];
		
		$zhuji_info="联系人姓名：".$kt_lxr."</br>绑定手机号：".$kt_tel."（主机到期时短信通知）</br>联系QQ：".$kt_qq."</br>FTP用户名：".$kt_ftp_u."</br>FTP密码：".$kt_ftp_p." （可登录控制面板自行修改）</br>到期日期：".$kt_enddate;
		//$objActSheet->getRowDimension($n)->setRowHeight(30); //高度 循环列
		//$objActSheet->getStyle('A'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//设置单元格边框Top
		//$objActSheet->getStyle('A'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//设置单元格边框 Left  
		//$objActSheet->getStyle('A'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//设置单元格边框Right   
		//$objActSheet->getStyle('A'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );//设置单元格边框Bottom
		
		//设置字符型iconv('gbk','utf-8',$rs->xingming)
		
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
	
	$objActSheet->mergeCells('B'.$n.':H'.$n);      // 合并
	$vas='导出时间：'.date("Y-m-d H:i:s");
	$objActSheet->setCellValue('B'.$n,iconv('gbk','utf-8',$vas));
	
	//================设置单元格格式，并复制此单元格的格式到指定区域
	
		$objStyleA1 = $objActSheet->getStyle('A1'); 
		 
		$objAlignA1 = $objStyleA1->getAlignment();  
		$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //左右居中 
		$objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //上下居中
		  
		$objFontA1 = $objStyleA1->getFont();  //字体及颜色 
		$objFontA1->setName(iconv('gbk','utf-8','黑体'));  
		$objFontA1->setSize(22);
		$objFontA1->getColor()->setARGB('FF000000'); 
		
		//$objActSheet->getStyle('A1')->getFont()->setName(iconv('gbk','utf-8','黑体')); //快捷方式指定字体 
		
		$objActSheet->getStyle('A3:H'.$n)->getAlignment()->setWrapText(true);//自动换行，从第一个未合并单位处设置起始
		//$objActSheet->getDefaultRowDimension()->setRowHeight(20);//默认行高，与自动换行冲突
		$objActSheet->getRowDimension('1')->setRowHeight(35);//指定第1行高  getColumnDimension('A')->setWidth(15);列宽
		$objActSheet->getRowDimension('2')->setRowHeight(25);//指定第2行高
		$objActSheet->getRowDimension('3')->setRowHeight(25);//指定第3行高
		$objActSheet->getRowDimension($n)->setRowHeight(90);//指定第3行高
		
		$objActSheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objActSheet->getStyle('A2')->getFont()->setSize(12);
		$objActSheet->getStyle('A2')->getFont()->setName(iconv('gbk','utf-8','宋体'));
		
		$objActSheet->getStyle('A3:B'.($n-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objActSheet->getStyle('A3:B'.($n-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
		$objStyleA5 = $objActSheet->getStyle('A3');//生成样式类
		$objBorderA5 = $objStyleA5->getBorders();//设置边框
		$objBorderA5->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA5->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA5->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA5->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		
		$objFontA5 = $objStyleA5->getFont();  //设置字体
		$objFontA5->setName(iconv('gbk','utf-8','宋体'));  
		$objFontA5->setSize(12);  
		//$objFontA5->setBold(true);  
		//$objFontA5->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);  
		//$objFontA5->getColor()->setARGB('FF999999');   

		$objActSheet->duplicateStyle($objStyleA5,'A3:H3');//执行复制样式操作
		
		
		
		$objStyleA6 = $objActSheet->getStyle('A3');//生成样式类
		$objBorderA6 = $objStyleA6->getBorders();//设置边框
		$objBorderA6->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA6->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA6->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		$objBorderA6->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );
		
		$objFontA6 = $objStyleA6->getFont();  //设置字体
		$objFontA6->setName(iconv('gbk','utf-8','宋体'));  
		$objFontA6->setSize(10);  
		$objActSheet->duplicateStyle($objStyleA6,'A4:H'.$n);//执行复制样式操作
		
		
		$objStyleA7 = $objActSheet->getStyle('A3');//生成样式类
		$objFontA7 = $objStyleA7->getFont();  //设置字体
		$objFontA7->setName(iconv('gbk','utf-8','黑体'));  
		$objFontA7->setSize(12);  
		$objFontA7->setBold(true); 
		$objActSheet->duplicateStyle($objStyleA7,'A3:H3');//执行复制样式操作
		
		
		$objStyleA8 = $objActSheet->getStyle('B'.$n);//生成样式类
		$objFontA8 = $objStyleA8->getFont();  //设置字体 
		$objFontA8->setBold(true); 
		$objFontA8->setSize(10);  
		$objActSheet->duplicateStyle($objStyleA8,'B'.$n);//执行复制样式操作
		
		
		
		$objStyleA9 = $objActSheet->getStyle('B4');//订单号加粗
		$objFontA9 = $objStyleA9->getFont();  //设置字体 
		$objFontA9->setBold(true); 
		$objFontA9->setSize(12);  
		$objActSheet->duplicateStyle($objStyleA9,'B4:B'.($n-1));//执行复制样式操作
		
		$objActSheet->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objActSheet->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	//================设置单元格格式，并复制此单元格的格式到指定区域 
	  
		$outputFileName = "out_xls/host.xls";       
		//到文件       
		$objWriter->save($outputFileName);       
		//下面这个输出我是有个页面用Ajax接收返回的信息
		//echo "<script>alert('报名信息汇总表导出成功！\\n\\n导出的表如需修改，请全选并设置单元格格式为“文本”后方可修改');location.href='out_excel/".$_SESSION['user_baoming_kaodian'].".xls';</script>";
		echo "<script>alert('数据导出成功！');</script>";
		?>
		<div style="text-align:center; margin-top:50px;">
		  <div style="margin:auto;width:460px; border:1px dashed #0066FF; background:#F5F5F5; padding:20px; line-height:30px; font-size:12px; text-align:left;">
			  <a href="down.php?<?=encrypt_url("&filename=主机订单记录统计表&url=".base64_encode('out_xls/host.xls')."&time=".time(),$key_url_md_5)?>" target="_blank" style="text-decoration:none">★点击下载</a>
		  </div>
		  <div style="text-align:center; margin-top:25px;"><input type="button" value=" 关闭 " name="button1" style=" width:80px; height:30px;" onClick="javascript:window.close();return false;" /></div>
		</div> 
		<?
} 


?>