<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-5-23
 * Time: 下午3:03
 * File: test_sqmy.php
 * To change this template use File | Settings | File Templates.
 */
/**
 * 这个是基于模版的excel操作方式
 */
define('API_PATH',realpath(dirname(__FILE__).'/Classes'));
/** PHPExcel */
//include API_PATH.'/PHPExcel.php';

//使用97-2003版本
require API_PATH.'/PHPExcel/Reader/Excel5.PHP';
$reader=new PHPExcel_Reader_Excel5;
$excel=$reader->load('test_template.xls');//通过现有文件创建PHPExcel实例
$sheet=$excel->getActiveSheet();

$columns=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R');
$rows=8+3;//从第三行开始实际输出8行。模版中实际的数据位置。
for($i=3;$i < $rows;$i++){
    foreach ($columns as $key=>$col) {
        $sheet->setCellValue($col.$i,$col.$i);
    }
}
/** PHPExcel_Writer_Excel5 */
include API_PATH.'/PHPExcel/Writer/Excel5.php';
$writer=new PHPExcel_Writer_Excel5($excel);
$writer->save('D:\testExcel\test_temp_'.rand(1,100).'.xls');

echo '文档保存完毕';