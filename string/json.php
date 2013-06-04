<?php
/**
 * 测试json数据的输出。.
 * User: weijie
 * Date: 13-6-4
 * Time: 上午11:22
 * File: json.php
 * To change this template use File | Settings | File Templates.
 */
class Test{
    public $text='Hello Text! I\'m in class!';
    public $class='Text';
}
$json=array(
    'text'=>'Hello World!I\'m in array!',
    'type'=>'array',
);
echo json_encode(new Test());