<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-4-26
 * Time: 上午10:01
 * File: image_builder.php
 * To change this template use File | Settings | File Templates.
 */
/**
 * 图像生成器
 * 来源：http://www.oschina.net/code/snippet_1029558_20655
 * 测试了一下没有效果。等哪天再试一下。
 */
interface IImageFilter
{
    public function Process(&$image, array $options = null);
}


/**
 * 简易图像生成器。 大水车学习版
 *  easy imagebulider
 *
 */
class ImageBuilder
{
    /**
     * 图像宽度。
     * @var integer
     */
    public $Width = 100;
    /**
     * 图像高度。
     * @var integer
     */
    public $Height = 50;
    /**
     * 背景颜色，无符号整数，颜色值。
     * @var integer
     */
    public $BackColor = 0xFFFFFF;
    /**
     * 是否透明化处理。
     * @var boolean
     */
    public $Transparent = false;
    /**
     * 字体文件。默认为 Arial Unicode。
     * @var string
     */
    public $FontFile = 'ARIALUNI.TTF';
    /**
     * 输出类型： PNG, JPG, GIF，默认为 PNG。
     * @var string
     */
    public $Type = 'jpg';

    private
        $_image = null;

    /**
     * 构造器。
     * @param integer $width 宽度。
     * @param integer $height 高度。
     * @param integer $backColor 背景颜色。
     * @param bool $transparent 是否透明。
     */
    public function __construct($width = 100, $height = 50, $backColor = 0xFFFFFF, $transparent = false)
    {
        $this->Width = $width;
        $this->Height = $height;
        $this->BackColor = $backColor;

        $this->_image = imagecreatetruecolor($this->Width, $this->Height);

        if (headers_sent()) {
            throw new RuntimeException('Header sent.');
        }

        // 初始化背景
        $backColor = imagecolorallocate($this->_image,
            (int)($this->BackColor % 0x1000000 / 0x10000),
            (int)($this->BackColor % 0x10000 / 0x100),
            $this->BackColor % 0x100);

        imagefilledrectangle($this->_image, 0, 0, $this->Width, $this->Height, $this->BackColor);

        imagecolordeallocate($this->_image, $this->BackColor);

        if ($transparent) {
            // 设置透明
            imagecolortransparent($this->_image, $this->BackColor);
        }
    }

    /**
     * 呈现的图片或文本，数组，按定义的顺序。
     * 元素为 x, y, type=text|image, content=图片路径或文本
     * @param $renders 要呈现的内容。
     * 模式如下：
     * array(
     *                 array(
     *                         'x'                => 0,
     *                         'y'                => 0,
     *                         'type'        => 'text',
     *                         'content'=>'图片路径或文本内容',
     *                         // 下面是文本的附加属性
     *                         'font'        => null,
     *                         'fontsize'        => 30,
     *                         'angle'                => 0,
     *                         'color'                => 0x000000
     *                 )
     * );
     */
    public function Render(array $renders)
    {
        foreach ($renders as $r) {
            if (!is_array($r) || !isset($r['type']) || !isset($r['content'])) {
                continue;
            }

            $type = $r['type'];
            $x = isset($r['x']) ? $r['x'] : 0;
            $y = isset($r['y']) ? $r['y'] : 0;
            $ResizeRate = isset($r['ResizeRate']) ? $r['ResizeRate'] : 1;
            $AutoResize = isset($r['AutoResize']) ? $r['AutoResize'] : 0;
            $content = $r['content'];

            if ($type === 'text') {
                $fontsize = isset($r['fontsize']) ? $r['fontsize'] : 30;
                $angle = isset($r['angle']) ? $r['angle'] : 0;
                $foreColor = isset($r['color']) ? $r['color'] : 0x000000;
                $fontfile = isset($r['font']) ? $r['font'] : null;

                $this->RenderText($content, $x, $y, $fontsize, $angle, $foreColor, $fontfile);
            } else {
                $this->RenderImage($content, $x, $y, $ResizeRate, $AutoResize);
            }
        }
    }

    /**
     * 呈现文本。
     * @param string $text 文本。
     * @param integer $x 横坐标。
     * @param integer $y 纵坐标。
     * @param integer $size 字体尺寸，像素。
     * @param integer $angle 角度。
     * @param integer $foreColor 文本颜色。
     * @param string $fontfile 字体文件路径。
     */
    public function RenderText($text, $x = 0, $y = 0, $size = 30, $angle = 0, $foreColor = 0x000000, $fontfile = null)
    {
        $c = func_num_args();
        if ($c === 1 && is_array($text)) {
            extract($text);
        }

        if ($text === '') {
            return;
        }

        $fontfile = is_null($fontfile) ? $this->FontFile : $fontfile;

        $foreColor = imagecolorallocate($this->_image,
            (int)($foreColor % 0x1000000 / 0x10000),
            (int)($foreColor % 0x10000 / 0x100),
            $foreColor % 0x100);

        imagettftext($this->_image, $size, $angle, $x, $y, $foreColor, $fontfile, $text);
        imagecolordeallocate($this->_image, $foreColor);
    }

    /**
     * 呈现图像，按 1:1 大小简单输出。
     * @param string $src 图像文件。
     * @param integer $x 横坐标。
     * @param integer $y 纵坐标。
     */
    public function RenderImage($src, $x = 0, $y = 0, $ResizeRate = 1, $AutoResize = 1)
    {
        $c = func_num_args();
        if ($c === 1 && is_array($src)) {
            extract($src);
        }

        if ($src === '') {
            return;
        }

        $meta = getimagesize($src);
        $w = $meta[0];
        $h = $meta[1];
        $new_width = $w / $ResizeRate;
        $new_height = $h / $ResizeRate;

        switch ($meta[2]) {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($src);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($src);
                break;

            case IMAGETYPE_JPEG:
            default:
                $image = imagecreatefromjpeg($src);
                break;
        }

        //imagecopy($this->_image, $image, $x, $y, 0, 0, $w, $h); //简单输出
        if ($AutoResize == 1) {
            $this->Width; //当前底图的宽
            $this->Height; //当前底图的高
            $MaxSizeWidth = $this->Width - (2 * $x); //缩小后的图片的最大宽度
            $MaxSizeHeight = $this->Height - (2 * $y); //缩小后的图片的最大高度
//                        echo $MaxSizeWidth;
//                        echo $MaxSizeHeight;
            if (($MaxSizeWidth >= $w) && ($MaxSizeHeight >= $h)) { //宽高都小，可以不缩小的情况，直接居中{
                $outputSx = ($this->Width - $w) / 2;
                $outputSy = ($this->Height - $h) / 2;
                imagecopyresized($this->_image, $image, $outputSx, $outputSy, 0, 0, $w, $h, $w, $h);
            } else {
                $DstWHRate = $MaxSizeWidth / $MaxSizeHeight; //缩小后的长宽比
                $SrcWhRate = $w / $h; //需要缩小的图片
                if ($DstWHRate >= $SrcWhRate) {
                    $ResizeRate = ($h / $MaxSizeHeight); //获得缩放比例
                } else {
                    $ResizeRate = ($w / $MaxSizeWidth); //获得缩放比例
                }
                $new_width = ceil($w / $ResizeRate);
                $new_height = ceil($h / $ResizeRate);
                $outputSx = ceil(($this->Width - $new_width) / 2);
                $outputSy = ceil(($this->Height - $new_height) / 2);
                imagecopyresized($this->_image, $image, $outputSx, $outputSy, 0, 0, $new_width, $new_height, $w, $h);
            }
//                        echo $w;
//                        echo $h;
        } else {
            imagecopyresampled($this->_image, $image, $x, $y, 0, 0, $new_width, $new_height, $w, $h);
        }

        imagedestroy($image);
    }

    /**
     * 输出内容到浏览器。
     */
    public function Flush()
    {
        switch (strtoupper($this->Type)) {
            case 'JPG':
                imagejpeg($this->_image);
                break;
            case 'GIF':
                imagegif($this->_image);
                break;
            default:
                imagepng($this->_image);
                break;
        }
    }

    /**
     * 输出到文件或返回内容。
     * @param string $filename
     * @Return void 如果未提供文件名，则返回图像内容。如果提供了文件名则输出到文件中。
     */
    public function Output($filename = null)
    {
        if (!empty($filename)) {
            switch (strtoupper($this->Type)) {
                case 'JPG':
                    imagejpeg($this->_image, $filename);
                    break;
                case 'GIF':
                    imagegif($this->_image, $filename);
                    break;
                default:
                    imagepng($this->_image, $filename);
                    break;
            }
        } else {
            ob_start();
            switch (strtoupper($this->Type)) {
                case 'JPG':
                    imagejpeg($this->_image);
                    break;
                case 'GIF':
                    imagegif($this->_image);
                    break;
                default:
                    imagepng($this->_image);
                    break;
            }
            $r = ob_get_contents();
            ob_end_clean();
            return $r;
        }
    }

    /**
     * 释放资源，当对象实例卸载时也被隐式调用。
     */
    public function Dispose()
    {
        if (!is_null($this->_image)) {
            imagedestroy($this->_image);
            $this->_image = null;
        }
    }

    public function __destruct()
    {
        $this->Dispose();
    }

    /**
     * 直接呈现。
     * @param integer $width 图像宽度。
     * @param integer $height 图像高度。
     * @param integer $backColor 背景颜色。
     * @param array $renders 呈现内容，同 Render 方法定义。
     */
    public static function DirectRender($width = 100, $height = 50, $backColor = 0xFFFFFF, array $renders, $type = "jpg")
    {
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header("Content-type: image/" . ($type === 'JPG' ? 'jpeg' : strtolower($type)));
        $b = new self($width, $height, $backColor);
        $b->Render($renders);
        $b->Flush();
        $b->Dispose();
    }

    /**
     * 呈现到文件或返回图像数据。
     * @param integer $width 图像宽度。
     * @param integer $height 图像高度。
     * @param integer $backColor 背景颜色。
     * @param array $renders 呈现内容，同 Render 方法定义。
     * @param string $filename 呈现到的文件名，不提供则直接返回内容。
     */
    public static function RenderTo($width = 100, $height = 50, $backColor = 0xFFFFFF, array $renders, $filename = null)
    {
        $b = new self($width, $height, $backColor);
        $b->Render($renders);
        $r = $b->Output($filename);
        $b->Dispose();
        return $r;
    }

}

// 简单组合文本和图片，并且返回图像数据。
ImageBuilder::DirectRender(900, 700, 0xF0F0F0, array(
        array('x' => 0, 'y' => 0, 'type' => 'image', 'content' => 'bg/asw.gif'),
        array('x' => 260, 'y' => 30, 'type' => 'image', 'content' => '1.jpg'),
        array('x' => 75, 'y' => 54, 'type' => 'text', 'content' => '大水车', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 75, 'y' => 86, 'type' => 'text', 'content' => '中性', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 155, 'y' => 86, 'type' => 'text', 'content' => '宅族', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 75, 'y' => 116, 'type' => 'text', 'content' => '1980', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 135, 'y' => 116, 'type' => 'text', 'content' => '11', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 170, 'y' => 116, 'type' => 'text', 'content' => '11', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 75, 'y' => 146, 'type' => 'text', 'content' => '湖北省仙桃市靠山屯村', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 75, 'y' => 166, 'type' => 'text', 'content' => '六蛋七巷 8 弄 110 号', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000),
        array('x' => 145, 'y' => 219, 'type' => 'text', 'content' => '312306198011113298', 'fontsize' => 12, 'font' => 'ARIALUNI.TTF', 'color' => 0x000000)
    )
);