<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-4-18
 * Time: 上午9:35
 * File: array_tree.php
 * 测试两种算法实现的效果。昨天晚上躺在床上思考这个算法。想着是否可以使用unset的方法实现
 */
/**
 * 将数据格式化成树形结构
 * @author Xuefen.Tong
 * @param array $items
 * @return array
 */
function genTree($items) {
    $tree = array(); //格式化好的树
    foreach ($items as $item)
        if (isset($items[$item['pid']]))
            $items[$item['pid']]['son'][] = &$items[$item['id']];
        else
            $tree[] = &$items[$item['id']];
    return $tree;
}

/**
 * 将数据格式化成树形结构
 * @author Xuefen.Tong
 * @param array $items
 * @return array
 */
function genTreeX($items) {
    $unsetId = array(); //格式化好的树
    foreach ($items as $item)
        if (isset($items[$item['pid']])){
            $items[$item['pid']]['son'][] = &$items[$item['id']];
            /**
             * 这个地方我本来想的是直接用，unset($items[$item['id']])直接删除子类
             * 但是这个子类如果也存在子类，这种做法就有问题。
             * 事实证明还是上面的方法更有效率。
             */
            $unsetId[]=$item['id'];
        }
    foreach($unsetId as $id){
        unset($items[$id]);
    }
    return $items;
}

$items = array(
    1 => array('id' => 1, 'pid' => 0, 'name' => '江西省'),
    2 => array('id' => 2, 'pid' => 0, 'name' => '黑龙江省'),
    3 => array('id' => 3, 'pid' => 1, 'name' => '南昌市'),
    4 => array('id' => 4, 'pid' => 2, 'name' => '哈尔滨市'),
    5 => array('id' => 5, 'pid' => 2, 'name' => '鸡西市'),
    6 => array('id' => 6, 'pid' => 4, 'name' => '香坊区'),
    7 => array('id' => 7, 'pid' => 4, 'name' => '南岗区'),
    8 => array('id' => 8, 'pid' => 6, 'name' => '和兴路'),
    9 => array('id' => 9, 'pid' => 7, 'name' => '西大直街'),
    10 => array('id' => 10, 'pid' => 8, 'name' => '东北林业大学'),
    11 => array('id' => 11, 'pid' => 9, 'name' => '哈尔滨工业大学'),
    12 => array('id' => 12, 'pid' => 8, 'name' => '哈尔滨师范大学'),
    13 => array('id' => 13, 'pid' => 1, 'name' => '赣州市'),
    14 => array('id' => 14, 'pid' => 13, 'name' => '赣县'),
    15 => array('id' => 15, 'pid' => 13, 'name' => '于都县'),
    16 => array('id' => 16, 'pid' => 14, 'name' => '茅店镇'),
    17 => array('id' => 17, 'pid' => 14, 'name' => '大田乡'),
    18 => array('id' => 18, 'pid' => 16, 'name' => '义源村'),
    19 => array('id' => 19, 'pid' => 16, 'name' => '上坝村'),
);
var_dump($items);
echo "<pre>";
var_dump(genTree($items));
echo '</pre>';
var_dump($items);
echo "<pre>";
var_dump(genTreeX($items));
echo '</pre>';
//输出格式
/*
Array
(
[0] => Array
    (
        [id] => 1
        [pid] => 0
        [name] => 江西省
        [son] => Array
            (
                [0] => Array
                    (
                        [id] => 3
                        [pid] => 1
                        [name] => 南昌市
                    )

                [1] => Array
                    (
                        [id] => 13
                        [pid] => 1
                        [name] => 赣州市
                        [son] => Array
                            (
                                [0] => Array
                                    (
                                        [id] => 14
                                        [pid] => 13
                                        [name] => 赣县
                                        [son] => Array
                                            (
                                            [0] => Array
                                                (
                                                    [id] => 16
                                                    [pid] => 14
                                                    [name] => 茅店镇
                                                    [son] => Array
                                                        (
                                                        [0] => Array
                                                            (
                                                            [id] => 18
                                                            [pid] => 16
                                                            [name] => 义源村
                                                            )

                                                        [1] => Array
                                                            (
                                                            [id] => 19
                                                            [pid] => 16
                                                            [name] => 上坝村
                                                            )

                                                        )

                                                )

                                            [1] => Array
                                                (
                                                    [id] => 17
                                                    [pid] => 14
                                                    [name] => 大田乡
                                                )

                                            )

                                    )

                                [1] => Array
                                    (
                                        [id] => 15
                                        [pid] => 13
                                        [name] => 于都县
                                    )

                            )

                    )

            )

    )

[1] => Array
    (
        [id] => 2
        [pid] => 0
        [name] => 黑龙江省
        [son] => Array
            (
                [0] => Array
                    (
                        [id] => 4
                        [pid] => 2
                        [name] => 哈尔滨市
                        [son] => Array
                            (
                            [0] => Array
                                (
                                    [id] => 6
                                    [pid] => 4
                                    [name] => 香坊区
                                    [son] => Array
                                        (
                                        [0] => Array
                                            (
                                                [id] => 8
                                                [pid] => 6
                                                [name] => 和兴路
                                                [son] => Array
                                                    (
                                                        [0] => Array
                                                            (
                                                            [id] => 10
                                                            [pid] => 8
                                                            [name] =>
                                                             东北林业大学
                                                            )

                                                        [1] => Array
                                                            (
                                                            [id] => 12
                                                            [pid] => 8
                                                            [name] =>
                                                            哈尔滨师范大学
                                                            )

                                                    )

                                            )

                                        )

                                )

                            [1] => Array
                                (
                                    [id] => 7
                                    [pid] => 4
                                    [name] => 南岗区
                                    [son] => Array
                                        (
                                        [0] => Array
                                            (
                                            [id] => 9
                                            [pid] => 7
                                            [name] => 西大直街
                                            [son] => Array
                                                (
                                                [0] => Array
                                                    (
                                                    [id] => 11
                                                    [pid] => 9
                                                    [name] =>
                                                     哈尔滨工业大学
                                                    )

                                                )

                                            )

                                        )

                                )

                            )

                    )

                [1] => Array
                    (
                        [id] => 5
                        [pid] => 2
                        [name] => 鸡西市
                    )

            )

    )
)*/