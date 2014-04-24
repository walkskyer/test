<html>
<head>
    <title>simple html dom 测试</title>
</head>
<body>
<form method="post">
    <textarea name="url"><?php echo isset($_POST['url'])?$_POST['url']:'http://www.baidu.com';?></textarea>
    <input type="submit">
</form>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: walkskyer
 * Date: 14-4-23
 * Time: 下午5:49
 */
if(!isset($_POST['url'])) exit;
require_once('simple_html_dom.php');
$starttime =microtime_float();
$html = file_get_html($_POST['url']);
$endtime = microtime_float();
print $starttime.'<br>';
print $endtime.'<br>';
print $endtime-$starttime.'<br>';

// Find all images
foreach($html->find('img') as $element)
    echo $element->src . '<br>';
echo "---------------------------------------------------------------------------------------<br/>";
// Find all links
foreach($html->find('a') as $element)
    echo $element->href . '<br>';

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}