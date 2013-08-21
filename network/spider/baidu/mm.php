<?php
/**
 * 获取百度上的高质量妹子图.
 * 来源url：http://www.oschina.net/code/snippet_577797_23921
 * User: weijie
 * Date: 13-8-21
 * Time: 上午9:13
 * File: mm.php
 * To change this template use File | Settings | File Templates.
 */
$p = isset($_GET['p'])?intval($_GET['p']):1;
$page = $p * 20;
$p = $p + 1;
echo '<center><a href="?p=' . $p . '">Next Page</a></center>';
$url = 'http://m.baidu.com/img?tn=bdjsonliulan&pu=sz%401320_2001&bd_page_type=1&tag1=%E7%BE%8E%E5%A5%B3&realword=%E7%BE%8E%E5%A5%B3&word=%E7%BE%8E%E5%A5%B3&pn=' . $page . '&rn=20';
echo '<center><a href="' . $url . '" target="_blank">baidu</a></center>';
$jsoncode = file_get_contents($url);
$mm = json_decode($jsoncode);
for ($i = 0; $i < 20; $i++) {
    echo '<center><img width="640px" src="' . $mm->data[$i]->picurl . '"></center><br>';
}
echo '<center><a href="?p=' . $p . '">Next Page</a></center>';