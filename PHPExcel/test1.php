<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-5-23
 * Time: 下午2:55
 * File: test1.php
 * To change this template use File | Settings | File Templates.
 */
/** Error reporting */
error_reporting(E_ALL);

/** Include path **/
//set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');
  
/** PHPExcel */  
include 'Classes/PHPExcel.php';


/**输出office2007的文件*/
include 'Classes/PHPExcel/Writer/Excel2007.php';
  
// 创建PHPExcel实例
echo date('H:i:s') . "Create new PHPExcel object\n";  
$objPHPExcel = new PHPExcel();  
  
// Set properties  
echo date('H:i:s') . "Set properties\n";  
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Test result file");
  
// Add some data  
echo date('H:i:s') . "Add some data\n";  
$objPHPExcel->setActiveSheetIndex(0);  
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Hello');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'world!');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Hello');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'world!');
  
// Rename sheet  
echo date('H:i:s') . "Rename sheet\n";  
$objPHPExcel->getActiveSheet()->setTitle('Simple');  
  
// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
$objPHPExcel->setActiveSheetIndex(0);  
  
// 保存 Excel 2007 文件
echo date('H:i:s') . "Write to Excel2007 format\n";  
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);  
$objWriter->save('D:\testExcel\test_'.rand(1,100).'.xlsx');
  
// Echo done  
echo date('H:i:s') . "Done writing file.";  