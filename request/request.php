<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adminer
 * Date: 14-1-24
 * Time: 下午9:29
 * To change this template use File | Settings | File Templates.
 */
if(!empty($_GET)){
    echo 'get is not empty';
    echo var_dump($_GET);
    exit;
}
if(!empty($_POST)){
    echo 'post is not empty<br/>';
    echo var_dump($_POST);
    exit;
}
echo 'no post or get data';