<?php

/**
 * 图片解码类
 */
class decryImg {

	protected $imgPath; //图片路径
	protected $dataArray; //
	protected $imageSize;	//图片尺寸
	protected $data; //结果
	protected $keys; //解码对应关系
	protected $imgInfo; //对图片规格的描述

	public function __construct($imgInfo) {
		$this->keys = array(
				'0' => '0000000000000000001111000110011001100110011001100110011001100110011001100011110000000000',
				'1' => '0000000000000000000110000011100000011000000110000001100000011000000110000011110000000000',
				'2' => '0000000000000000001111000110011000000110000011000001100000110000011000000111111000000000',
				'3' => '0000000000000000001111000110011000000110000111000000011000000110011001100011110000000000',
				'4' => '0000000000000000000001000000110000011100001011000100110001111110000011000000110000000000',
				'5' => '0000000000000000001111100011000000110000001111000000011000000110011001100011110000000000',
				'6' => '0000000000000000000111000011000001100000011111000110011001100110011001100011110000000000',
				'7' => '0000000000000000011111100000011000001100000011000001100000011000001100000011000000000000',
				'8' => '0000000000000000001111000110011001100110001111000110011001100110011001100011110000000000',
				'9' => '0000000000000000001111000110011001100110011001100011111000000110000011000011100000000000',
				'.' => '0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'
		);
		$this->imgInfo = $imgInfo;
	}

	/**
	 * 获得图片的解码
	 * @return 解码结果
	 */
	public function getNumFromImgUrl($url) {
		$this->imgPath = $url;
		$this->_getHec();
		return $this->_run();
	}

	/**
	 * 将图片转成成数组
	 */
	private function _getHec() {
		$res = imagecreatefrompng($this->imgPath);
		$size = getimagesize($this->imgPath);
		$data = array();
		for ($i = 0; $i < $size[1]; ++$i) {
			for ($j = 0; $j < $size[0]; ++$j) {
				$rgb = imagecolorat($res, $j, $i);
				$rgbarray = imagecolorsforindex($res, $rgb);
				if ($rgbarray['red'] < 125 || $rgbarray['green'] < 125
								|| $rgbarray['blue'] < 125) {
					$data[$i][$j] = 1;
				} else {
					$data[$i][$j] = 0;
				}
			}
		}
		$this->dataArray = $data;
		$this->imageSize = $size;
	}

	/**
	 * 开始处理
	 * @return 解码结果
	 */
	private function _run() {
		$result = "";
		$data = array();
		$numCount; //字符数目
		$DotPlus = 0; //标记是否出现了小数点

		switch ($this->imageSize[0]) {
			case 45:
				$numCount = 4;
				break;
			case 55:
				$numCount = 5;
				break;
			case 60:
				$numCount = 6;
				break;
			case 70:
				$numCount = 7;
				break;
			case 80:
				$numCount = 8;
				break;
			default :
				$numCount = 9;
		}

		for ($i = 0; $i < $numCount; ++$i) {
			$x = ($i * ($this->imgInfo['wordWidth'] + $this->imgInfo['wordSpacing'])) + $this->imgInfo['offsetX'] + $DotPlus;
			$y = $this->imgInfo['offsetY'];

			array_push($data, '');
			for ($h = $y; $h < ($this->imgInfo['offsetY'] + $this->imgInfo['wordHeight']); ++$h) {
				for ($w = $x; $w < ($x + $this->imgInfo['wordWidth']); ++$w) {
					$data[$i] .=$this->dataArray[$h][$w];
				}
			}

			if (!in_array($data[$i], $this->keys)) {
				$DotPlus = 4 - $this->imgInfo['wordWidth'];
				$data[$i] = $this->keys['.'];
			}
		}

		$num = 0;
		// 进行关键字匹配
		foreach ($data as $numKey => $numString) {
			foreach ($this->keys as $key => $value) {
				if ($value === $numString) {
					$num = $key;
					break;
				}
			}
			$result.=$num;
		}
		$this->data = $result;
		return $result;
	}

}
