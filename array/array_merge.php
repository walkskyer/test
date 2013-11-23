<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adminer
 * Date: 13-11-23
 * Time: 下午12:19
 * To change this template use File | Settings | File Templates.
 */
/**
 * 测试二维数组的合并功能
 */
$a = array(
    'test1' => array(
        'f1' => array(
            array(
                array('hello', '>=', '')
            )
        ),
        'f2' => array(
            array(
                array('hello', '>=', ''),
                array('hello', '>=', ''),
            )
        ),
    ),
    'test2' => array(
        'f1' => array(
            array(
                array('hello', '>=', '')
            )
        ),
        'f2' => array(
            array(
                array('hello', '>=', ''),
                array('hello', '>=', ''),
            )
        ),
    )
);

$b=array('test2' => array(
    'f1' => array(
        array(
            array('hello1', '>=', '')
        )
    ),
));

$c=array_merge($a,$b);
var_dump($c);