<?php
/**
 * Created by PhpStorm.
 * User: walkskyer
 * Date: 14-1-7
 * Time: 上午10:18
 */

if(!defined('API_PATH')) define('API_PATH',realpath(dirname(__FILE__).'/Classes'));
if(!function_exists('excel_2003')){
    /**
     * @param $data 存储数据的二维数组
     * @param $target_name 要保存的目标文件名称
     * @param $start_row 开始写入数据的行
     * @param $columns 需要写入数据的列
     * @param $template 模板文件
     * @param bool $output 是否直接通过网页下载
     */
    function excel_2003($data,$target_name,$start_row,$columns,$template,$output=true){
        if(empty($data))
        if(empty($start_row)) $start_row=1;
        /** PHPExcel */
        if(!empty($template)){
            require API_PATH.'/PHPExcel/Reader/Excel5.PHP';
            $reader=new PHPExcel_Reader_Excel5;
            $excel=$reader->load($template);//通过现有文件创建PHPExcel实例
        }
        $sheet=$excel->getActiveSheet();
        if(empty($columns)) $columns=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        $currRow=$start_row;
        foreach($data as $row){
            foreach($row as $key=>$val){
                $sheet->setCellValue($columns[$key].$currRow,$val);//使用这个方法PHPExcel会过滤数据
                //$sheet->setCellValueExplicit($columns[$key].$currRow,$val);//使用这个方法可以避免PHPExcel过滤数据，只将源数据作为文本直接输出。
            }
            $currRow++;
        }
        /** PHPExcel_Writer_Excel5 */
        include API_PATH.'/PHPExcel/Writer/Excel5.php';
        $writer=new PHPExcel_Writer_Excel5($excel);
        ob_end_clean();
        if($output){
            export_excel($target_name,false,$writer);
        }else{
            $writer->save('D:\\testExcel\\'.$target_name.'.xls');
        }
    }
}

if(!function_exists('export_excel')){
    /**
     * 将文件输出至网页下载，数据源可以是文件也可以是Excel实例
     * @param $outputName 要保存的文件名
     * @param bool $fileName 源文件名
     * @param bool $writer 源数据
     */
    function export_excel($outputName,$fileName=false, $writer=false){
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outputName.'.xls"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        if($fileName) echo file_get_contents(APPPATH.'excel/'.$outputName);
        elseif($writer) $writer->save('php://output');
    }
}