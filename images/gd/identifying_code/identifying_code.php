<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-4-28
 * Time: 上午9:02
 * File: identifying_code.php
 * To change this template use File | Settings | File Templates.
 */
/**
 * 使用PHP，结合session和GD库扩展开发的一个生成验证码的例子。可以很方便的用于项目中。而且样式美观大方。
 * 演示地址：http://www.pooy.net/captcha/
 * 原文出处：http://www.pooy.net/php-captcha.html
 * 下载地址：http://pan.baidu.com/share/link?shareid=471319&uk=3240790330
 */
//首先开启session
session_start();
//定义前台显示验证码长&宽
$image_width = 120;
$image_height = 40;
$characters_on_image = 6;
$font = './monofont.ttf';

//The characters that can be used in the CAPTCHA code.
//avoid confusing characters (l 1 and i for example)
$possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
$random_dots = 10;
$random_lines = 30;
$captcha_text_color="0x142864";
$captcha_noice_color = "0x142864";
//定义要生成验证码的字符串
$code = '';

$i = 0;
while ($i < $characters_on_image) {
    $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters)-1), 1);
    $i++;
}

$font_size = $image_height * 0.75;
$image = @imagecreate($image_width, $image_height);

/* setting the background, text and noise colours here */
$background_color = imagecolorallocate($image, 255, 255, 255);

$arr_text_color = hexrgb($captcha_text_color);
$text_color = imagecolorallocate($image, $arr_text_color['red'],
    $arr_text_color['green'], $arr_text_color['blue']);

$arr_noice_color = hexrgb($captcha_noice_color);
$image_noise_color = imagecolorallocate($image, $arr_noice_color['red'],
    $arr_noice_color['green'], $arr_noice_color['blue']);

/* generating the dots randomly in background */
for( $i=0; $i<$random_dots; $i++ ) {
    imagefilledellipse($image, mt_rand(0,$image_width),
        mt_rand(0,$image_height), 2, 3, $image_noise_color);
}

/* generating lines randomly in background of image */
for( $i=0; $i<$random_lines; $i++ ) {
    imageline($image, mt_rand(0,$image_width), mt_rand(0,$image_height),
        mt_rand(0,$image_width), mt_rand(0,$image_height), $image_noise_color);
}

/* create a text box and add 6 letters code in it */
$textbox = imagettfbbox($font_size, 0, $font, $code);
$x = ($image_width - $textbox[4])/2;
$y = ($image_height - $textbox[5])/2;
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code);

/* Show captcha image in the page html page */
header('Content-Type: image/jpeg');// defining the image type to be shown in browser widow
imagejpeg($image);//showing the image
imagedestroy($image);//destroying the image instance
//设置session，做验证
$_SESSION['6_letters_code'] = $code;

function hexrgb ($hexstr)
{
    $int = hexdec($hexstr);

    return array("red" => 0xFF & ($int >> 0x10),
        "green" => 0xFF & ($int >> 0x8),
        "blue" => 0xFF & $int);
}