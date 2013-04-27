<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-4-27
 * Time: 上午9:12
 * File: palindrome.php
 * To change this template use File | Settings | File Templates.
 */
/**
 * 输出回文数
 * 来源网址:http://www.oschina.net/code/snippet_1023425_20741
 */
//给出两个数值X和Y，统计在这个区间里的回文数，并且要求它们的平方根也是回文数。其中 1<= x <= y < 10 14
error_reporting(E_ALL);
ini_set("display_errors", 1);
//避免超时
set_time_limit(0);
$t1=microtime();
function  isPlalindrome($num){
    $str="$num";
    $len=strlen($num);
    $k = intval($len/2);//获取中间位数
    for($j=0;$j<$k;$j++){
        if($str{$j}!=$str{$len-1-$j}){
            return false;
        }
    }
    return true;
}

function showPlalindrome($min,$max){
    //因为要计算在$min,$max间的回文数且其自身平方根也是回文数，所以相当于求一sqrt($min)~sqrt($max)间数，其平方在$min~$max间也是回文数
    //$min~$max是连续正整数，所以可以这样缩小很多计算量，否则……
    for($i=$min;$i<$max;$i++){
        if(isPlalindrome($i) &&isPlalindrome($n=$i*$i) ){
            echo $i.':'.$n." <br/>";
        }
    }
}

showPlalindrome(1,10000000);

$t2=microtime();

$starttime = explode(" ",$t1);
$endtime = explode(" ",$t2);
$totaltime = $endtime[0]-$starttime[0]+$endtime[1]-$starttime[1];
$timecost = sprintf("%s",$totaltime);
echo "页面运行时间: $timecost 秒";


?>