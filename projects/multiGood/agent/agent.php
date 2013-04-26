<?php

//简单的代理

$action = $_REQUEST['action'];
set_time_limit(0);


switch ($action) {
	//爬出搜索信息
	case 'fetch':
		$catchFrom = $_REQUEST['siteName'];
		$catchUrl = $_REQUEST['url'];
		$content = '';

		//控制发送请求的编码方式
		if (isset($_POST['charSet']) && $_POST['charSet'] != 'UTF-8') {
			$catchUrl = iconv('UTF-8', $_POST['charSet'], $catchUrl);
		}
		$content = file_get_contents($catchUrl);
		//控制返回编码类型
		if ($_POST['returnChar'] != "GBK") {
			echo $_POST['returnChar'];
			$content = iconv('GBK', $_POST['returnChar'], $content);
		}

		echo $content;
		break;

	//图片解码
	case "imgToNum":
		//加载图片处理类
		include 'decryImg.class.php';
		$result = array();

		$imgDecry = new decryImg(array(
								'wordWidth' => 8,
								'wordHeight' => 11,
								'offsetX' => 12,
								'offsetY' => 1,
								'wordSpacing' => 0
						));

		$result['num'] = $imgDecry->getNumFromImgUrl($_REQUEST['url']);
		$result['pos'] = $_REQUEST['pos'];
		echo json_encode($result);
}




