<?php
/**
 * 格式化url
 * 将url转换成绝对url输出
 * @param unknown_type $url
 * @param unknown_type $base_url
 */
function url_format($url,$base_url){
	if($base_url == '' || empty($base_url)) {
		$list_rule = $this->get_rule_bytype('list');
		$base_url = $list_rule['first_url'];
	}
	if(is_string($url)) {
		if(substr($url, 0, 7) == 'http://') { //是否以http://开头
			return $url;
		}
		if(substr($url, 0, 1) == '/') { //相对根目录的路径
			$url_arr = parse_url($base_url);
			$url = 'http://' . $url_arr['host'] . $url;
			return $url;
		}elseif(substr($url, 0, 11) == 'javascript:' || $url == '#') { //错误的url
			return FALSE;
		}else { //相对当前目录
			

			$end_str = $base_url{strlen($base_url) - 1};
			if($base_url{strlen($base_url) - 1} != '/') {
				$dir = dirname($base_url) . '/';
			}else {
				$dir = $base_url;
			}
			
			if(substr($dir, 0, 7) == 'http://') {
				$url = $dir . $url;
			}else {
				$url = 'http://' . $dir . $url;
			}
			return $url;
		}
	}
}
$url='index_2.htm';
echo url_format($url, 'http://sports.39.net/ydxm/jxyd/ds/exe/');