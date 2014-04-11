<?php
/**
 * 测试时间函数.
 * User: walkskyer
 * Date: 14-4-11
 * Time: 上午11:19
 */
//秒
echo time();
echo '<br>';
//毫秒
echo microtime();
echo '<br>';
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
echo microtime_float();