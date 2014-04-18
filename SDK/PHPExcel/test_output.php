<?php
/**
 * Created by PhpStorm.
 * User: walkskyer
 * Date: 14-1-7
 * Time: 下午3:37
 */
include 'excel_helper.php';
$data=array(array('123','456'),array('你好！','谁是好人','谁是坏人'),array('山东省','济南市','市中区','王官庄小区'));
excel_2003($data,'测试文件',3,'','test_template_output.xls');