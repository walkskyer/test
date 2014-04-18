<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-1-22
 * Time: 下午5:22
 * To change this template use File | Settings | File Templates.
 */
/* @var $resp SimpleXMLElement*/
?>
<?php
header("Content-type: text/html; charset=utf-8");
require_once "api/taobao/TopSdk.php";
//将下载SDK解压后top里的TopClient.php第8行$gatewayUrl的值改为沙箱地址:http://gw.api.tbsandbox.com/router/rest,
//正式环境时需要将该地址设置为:http://gw.api.taobao.com/router/rest

//实例化TopClient类
$c = new TopClient;
$c->gatewayUrl = 'http://gw.api.tbsandbox.com/router/rest';
$c->appkey = "1021371870";
$c->secretKey = "sandbox0ffdb75aa4fbbec0482b2c45e";

//实例化具体API对应的Request类
$req = new UserGetRequest;
$req->setFields("nick,sex,uid,created");
$req->setNick("sandbox_c_1");

//执行API请求并打印结果
$resp = $c->execute($req);
echo "result:";
var_dump($resp);
echo "<br>";
echo "nick:" . $req->getNick();
echo "<br> <br>";


$req = new TaobaokeCaturlGetRequest();
//$req->setFields("");
$req->setNick("sandbox_c_1");
$req->setCid(0);
//执行API请求并打印结果
$resp = $c->execute($req);
echo "result:";
var_dump($resp);
echo "<br>";
echo "nick:" . $req->getNick();
echo "<br> <br>";

$sportCat = 'cache/Itemcats.xml';
if (!file_exists($sportCat)) {
    $req = new ItemcatsGetRequest();
//$req->setFields("");
    $req->setParentCid(0);
//执行API请求并打印结果
    $resp = $c->execute($req);
    echo "result:";
//var_dump($resp);
    echo "<br>";
    /*echo "nick:".$req->getNick();*/
    file_exists($sportCat) && unlink($sportCat);
    $resp->asXML($sportCat);
}else{
    $resp=simplexml_load_file($sportCat);
}
echo list_cats($resp);
echo "<br> <br>";

$sportCat = 'cache/sportCate.xml';
if (!file_exists($sportCat)) {
    $req = new ItemcatsGetRequest();
//$req->setFields("");
    $req->setParentCid(50010728);
//执行API请求并打印结果
    $resp = $c->execute($req);
    echo "result:";
//var_dump($resp);
    echo "<br>";
    /*echo "nick:".$req->getNick();*/
    file_exists($sportCat) && unlink($sportCat);
    $resp->asXML($sportCat);
}else{
    $resp=simplexml_load_file($sportCat);
}
echo list_cats($resp);
echo "<br> <br>";

/**
 * @param SimpleXMLElement $resp
 * @return string
 */
function list_cats(SimpleXMLElement $resp){
    $list_cats = $resp->children();
    $content='';
    foreach ($list_cats->children() as $cat) {
        $content.="cid={$cat->cid}   name={$cat->name}    is_parent={$cat->is_parent}    parent_cid={$cat->parent_cid}<br>";
    }
    return $content;
}
?>