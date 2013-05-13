<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-5-13
 * Time: 上午9:27
 * File: quick_sort.php
 * To change this template use File | Settings | File Templates.
 */
/**
 * 快速排序：
 * 1、从数列中挑出一个元素，称为 "基准"（pivot），
 * 2、重新排序数列，所有元素比基准值小的摆放在基准前面，所有元素比基准值大的摆在基准的后面（相同的数可以到任一边）。
 * 在这个分区退出之后，该基准就处于数列的中间位置。这个称为分区（partition）操作。
 * 3、递归地（recursive）把小于基准值元素的子数列和大于基准值元素的子数列排序。
 */
/**
 * 递归法实现的快速排序
 * @param $seq
 * @return array
 */
function quicksort($seq)
{
    if (count($seq) > 1) {
        $k = $seq[0];
        $x = array();
        $y = array();
        $_size = count($seq); //do not use count($seq) in loop for.
        for ($i = 1; $i < $_size; $i++) {
            if ($seq[$i] <= $k) {
                $x[] = $seq[$i];
            } else {
                $y[] = $seq[$i];
            }
        }
        $x = quicksort($x);
        $y = quicksort($y);
        return array_merge($x, array($k), $y);
    } else {
        return $seq;
    }
}

/**用迭代实现
 * @param $seq
 * @return array
 */
function quicksortX(&$seq)
{
    $stack = array($seq);
    $sort = array();
    while ($stack) {
        $arr = array_pop($stack);
        if(count($arr) <= 1){
            if (count($arr) == 1) {
                $sort[] = &$arr[0];
            }
            continue;
        }

        $k = $arr[0];
        $x = array();
        $y = array();
        $_size = count($arr);
        for ($i = 1; $i < $_size; $i++) {
            if ($arr[$i] <= $k) {
                $x[] = &$arr[$i];
            } else {
                $y[] = &$arr[$i];
            }
        }
        !empty($y) && array_push($stack, $y);
        array_push($stack, array($arr[0]));
        !empty($x) && array_push($stack, $x);
    }
    return $sort;
}
//$testArr = array(5545, 5, 6, 7675, 100, 9, 233, 566, 789, 456, 23, 55, 7, 4, 343, 564, 5, 45657, 8, 998, 9, 34, 34, 55, 6, 5, 6433, 67, 6, 6766, 4, 2, 42, 25634, 34343, 3, 3, 454, 4, 65, 6678, 57, 5455);
for($i=0;$i<20;$i++){
    $testArr[]=mt_rand(0,10000);
}
//var_dump($testArr);
echo count($testArr).'<br>';
$start=microtime();
echo count(quicksort($testArr)).'<br>';
echo microtime()-$start.'<br>';
var_dump(quicksort($testArr));
echo '------------------------------------------------------------------------<br>';
echo count($testArr).'<br>';
$start=microtime();
echo count(quicksortX($testArr)).'<br>';
echo microtime()-$start.'<br>';
var_dump(quicksortX($testArr));