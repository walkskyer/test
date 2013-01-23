<?php
/**
 * 根据文件名，以及读取文章的方式，返回文章内容。
 * @param string $filename
 * @param string $type
 */
function get_f_content($filename,$type = 'file_get_contents'){
	ini_set('user_agent', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
	
	$temp_data = '';
	if($type == 'file_get_contents' || empty($type)) {
		$temp_data = file_get_contents($filename);
	}elseif($type == 'curl') {
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $filename);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$temp_data = curl_exec($ch);*/
		$temp_data = curl_get_file_contents($filename);
	}elseif($type == 'file') {
		$file_fp = fopen($filename, 'rb');
		$file_temp = null;
		if($file_fp) {
			while(!feof($file_fp)) {
				$temp_data .= fread($file_fp, 2014 * 8);
			}
		}
	
	}elseif($type == 'ob') {
	
	}else {
		return FALSE;
	}
	return $temp_data;
}

function curl_get_file_contents($url,$referer = '',$curl_loops = 0,$curl_max_loops = 0){
	$curl_loops = $curl_loops ? $curl_loops : 0; //避免后面的递归调用进入死循环
	$curl_max_loops = $curl_max_loops ? $curl_max_loops : 3;
	
	$useragent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
	if($curl_loops ++ >= $curl_max_loops) {
		$curl_loops = 0;
		return false;
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); //
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	$data = curl_exec($ch);
	$ret = $data;
	list($header, $data) = explode("\r\n\r\n", $data, 2);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	curl_close($ch);
	if($http_code == 301 || $http_code == 302) {
		$matches = array();
		preg_match('/Location:(.*?)\n/', $header, $matches);
		$url = @parse_url(trim(array_pop($matches)));
		if(!$url) {
			$curl_loops = 0;
			return $data;
		}
		$new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . (isset($url['query']) ? '?' . $url['query'] : '');
		$new_url = stripslashes($new_url);
		return curl_get_file_contents($new_url, $last_url, $curl_loops, $curl_max_loops);
	}else {
		$curl_loops = 0;
		list($header, $data) = explode("\r\n\r\n", $ret, 2);
		return $data;
	}
}
$filename='http://nba.hupu.com/wiki/c_playbook_1__';
$type='curl';
echo get_f_content($filename,$type);
?>