<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-3-6
 * Time: 下午3:50
 * File: index.php
 * To change this template use File | Settings | File Templates.
 */
$qun_url = 'http://qun.qzone.qq.com/group#!/125913866/home'; //qq登陆url
$p = "";
$qun_cookie='';

$dz_url='http://www.88jianshen.com.zwj/member.php?mod=logging&action=login&loginsubmit=yes&handlekey=login&loginhash=Lduo0';
$pz_form='username=test100&password=t123456';
$useragent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";

$ch = curl_init($qun_url);


curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookies.txt');
curl_setopt($ch,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookies.txt');
//curl_setopt($ch, CURLOPT_REFERER, $referer);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //CURLOPT_FOLLOWLOCATION  启用时会将服务器服务器返回的"Location: " 放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS 可以限定递归返回的数量。
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $pz_form);
$result=curl_exec($ch);
echo $result;
$ret = $result;
list($header, $data) = explode("\r\n\r\n", $result, 2);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
echo $data;
curl_close($ch);
