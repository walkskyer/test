<?php
/**
 * 初始化数据库功能
 */

date_default_timezone_set ('Asia/Shanghai');

$db_host = 'localhost';//mysql数据库服务器,比如localhost:3306
$db_user = 'dbuser'; //mysql数据库默认用户名
$db_password = 'dbpwd'; //mysql数据库默认密码
$db_database = 'dbname'; //默认数据库名
global $db_tablePreStr;
$db_tablePreStr = 'mh_';//表前缀
global $countPerPage;
$countPerPage = 20;//表前缀

$db = mysql_connect($db_host, $db_user,$db_password)
    or die ('无法建立数据库连接: ' . mysql_error());


mysql_select_db($db_database, $db)
    or die ('数据库名称错误: ' . mysql_error());

mysql_query("set names utf8");


$sqlstr =file_get_contents('./db.sql');
create_db($sqlstr);

function create_db($sqlstr){
    echo '<pre>';
    foreach ( explode(';',$sqlstr) as $sql) {
        echo $sql;
        if (!mysql_query($sql)) {
            var_dump($sql);
            echo  mysql_error();
            break;
        };
    }
    echo '</pre>';
}

?>