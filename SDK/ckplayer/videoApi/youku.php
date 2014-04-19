<?php

/***************************************
*
***************************************/
$id=htmlspecialchars($_REQUEST['id']);
$type=isset($_REQUEST['type'])?htmlspecialchars($_REQUEST['type']):'';
$debug = isset($_REQUEST['debug'])?true:false;

if(preg_match("#id\_(\w+)#", $id, $matches)){//如果传进的优酷网址，把id解析出来
	$id = $matches[1];
}

$id or exit('not id');

$address = getYouku($id);

$video = $address['flv'];

if($type =='mp4'){
	$video = $type =='mp4'?$address['mp4']:$address['flv'];	
}
if($debug){
    echo 'video:'.$video;
    var_dump($address);
}else{
    header('Location: '.$video);
}


function getYouku($id){
	$content=get_curl_contents('http://v.youku.com/player/getPlayList/VideoIDS/'.$id);
	$data=json_decode($content,true);
	$data=$data['data'][0];
	$data or exit('not content');
	foreach($data['streamfileids'] AS $k=>$v){
		$sid=getSid();
		$fileid=getfileid($v,$data['seed']);
		$one=($data['segs'][$k][0]);
		$address[$k] =  "http://f.youku.com/player/getFlvPath/sid/{$sid}_00/st/{$k}/fileid/{$fileid}?K={$one['k']}";
	}
	$address['info'] = $data;
	return $address;

}
//发送http请求
function get_curl_contents($url, $second = 5){
	if(function_exists('curl_init')) {
		$c = curl_init();
		curl_setopt($c,CURLOPT_URL,$url);
		$UserAgent=$_SERVER['HTTP_USER_AGENT'];
		curl_setopt($c,CURLOPT_USERAGENT,$UserAgent);
		curl_setopt($c,CURLOPT_HEADER,0);
		curl_setopt($c,CURLOPT_TIMEOUT,$second);
		curl_setopt($c,CURLOPT_RETURNTRANSFER, true);
		$cnt = curl_exec($c);
		$cnt=mb_check_encoding($cnt,'utf-8')?iconv('gbk','utf-8//IGNORE',$cnt):$cnt; //字符编码转换
		curl_close($c);
		return $cnt;
	}else{
		$cnt = file_get_contents($url);
		return $cnt;
	}
}
//生成Sid
function getSid() {
	$sid = time().(rand(0,9000)+10000);
	return $sid;
}
//解析key
function getkey($key1,$key2){
	$a = hexdec($key1);
	$b = $a ^ 0xA55AA5A5;
	$b = dechex($b);
	return $key2.$b;
}
//根据视频格式获取该格式视频的真实地址id
function getfileid($fileId,$seed) {
	$mixed = getMixString($seed);
	$ids = explode("*",$fileId);
	unset($ids[count($ids)-1]);
	$realId = "";
	for ($i=0;$i < count($ids);++$i) {
		$idx = $ids[$i];
		$realId .= substr($mixed,$idx,1);
	}
	return $realId;
}
//混合字符串
function getMixString($seed) {
	$mixed = "";
	$source = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/\\:._-1234567890";
	$len = strlen($source);
	for($i=0;$i< $len;++$i){
		$seed = ($seed * 211 + 30031) % 65536;
		$index = ($seed / 65536 * strlen($source));
		$c = substr($source,$index,1);
		$mixed .= $c;
		$source = str_replace($c, "",$source);
	}
	return $mixed;
}

