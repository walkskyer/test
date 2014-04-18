<?php
$apiConfig['code'] = $_REQUEST['code'];
$apiConfig['client_id'] = '819857365775.apps.googleusercontent.com';
$apiConfig['client_secret'] = 'Edpe11joHS6WK7arCDb8jq84';
$apiConfig['redirect_uri'] = 'http://localhost/test/google-api-php-client/googleauth.php';
$apiConfig['grant_type'] = 'authorization_code';
$url = 'https://accounts.google.com/o/oauth2/token?'.http_build_query($apiConfig);

$ch = curl_init($url);

$data="hello:$url <br />";
echo $data;

/* curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true); ;
curl_setopt($ch,CURLOPT_CAINFO,dirname(__FILE__).'/cacert.pem');
 */
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $apiConfig);
$data = curl_exec($ch);
$curl_errno = curl_errno($ch);
$curl_error = curl_error($ch);

curl_close($ch);
echo '<br />data1='.$data;
echo $curl_error;
session_start();
$_SESSION['token']=$data;
?>