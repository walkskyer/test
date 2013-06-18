<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-6-18
 * Time: 上午10:08
 * File: monkeySelectKing.php
 * To change this template use File | Settings | File Templates.
 */
/**
 * n只猴子围坐成一个圈，按顺时针方向从1到n编号。
 * 然后从1号猴子开始沿顺时针方向从1开始报数，报到m的猴子出局，
 * 再从刚出局猴子的下一个位置重新开始报数，
 * 如此重复，直至剩下一个猴子，它就是大王。
 *
 * 设计并编写程序，实现如下功能：
 *（1）	要求由用户输入开始时的猴子数$n、报数的最后一个数$m。
 *（2）	给出当选猴王的初始编号。
 *http://www.oschina.net/code/snippet_616695_22224
 */
$n=10;
$m=9;

var_dump(monkeySelectKing($n,$m));

print_r(yuesefu($n,$m));

/**
 * @author Wu Junwei <www.wujunwei.net>
 *
 * @param int $n   开始时的猴子数量
 * @param int $m   报道的最后一个数(报到这个数的猴子被淘汰,然后下一个猴子重新从①开始报数)
 * @return int 猴子的初始编号
 */
function monkeySelectKing($n,$m){
    //猴子的初始数量不能小于2
    if ($n<2)
    {
        return false;
    }

    $arr=range(1,$n);      //将猴子分到一个数组里, 数组的值对应猴子的初始编号
    $unsetNum=0;           //定义一个变量,记录猴子的报数

    for ($i = 2; $i <=$n*$m ; $i++)   //总的循环次数不知道怎么计算,
    {                           //不过因为循环中设置了return,所以$m*$len效率还可以
        foreach ($arr as $k => $v)
        {
            $unsetNum++;        //每到一个猴子, 猴子报数+1

            //当猴子的报数等于淘汰的数字时:淘汰猴子(删除数组元素),报数归0(下一个猴子从1开始数)
            if ($unsetNum==$m)
            {
//                echo "<pre>";  //打开注释,可以看到具体的淘汰过程
//                print_r($arr);
                unset($arr[$k]);    //淘汰猴子
                $unsetNum=0;        //报数归零

                if (count($arr)==1) //判断数组的长度, 如果只剩一个猴子, 返回它的值
                {
                    return reset($arr);
                }
            }
        }
    }
    return null;
}

/***
 * 另一种解法，这个解法与我手动演算的结果不一致有时间自己研究下。
 * http://www.oschina.net/code/snippet_616695_22224
 */
function yuesefu($n,$m) {

    $r=0;

    for($i=2; $i<=$n; $i++) {

        $r=($r+$m)%$i;
    }

    return $r+1;

}