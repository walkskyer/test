<?php
/**
 * Created by PhpStorm.
 * User: walkskyer
 * Date: 14-4-23
 * Time: 下午5:49
 */
require_once('simple_html_dom.php');
$html = file_get_html('http://www.baidu.com/');

// Find all images
foreach($html->find('img') as $element)
    echo $element->src . '<br>';
echo "---------------------------------------------------------------------------------------<br/>";
// Find all links
foreach($html->find('a') as $element)
    echo $element->href . '<br>';