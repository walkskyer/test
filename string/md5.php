<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adminer
 * Date: 13-5-12
 * Time: 上午10:52
 * To change this template use File | Settings | File Templates.
 */
/**
 * 可以测试md5函数并且用来生成字符串的md5值。
 */
$src = 'this is a test.';
$md5=md5($src);
echo $md5;
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>md5测试及md5值获取</title>
</head>
<body>
<form action="" method="post">
    <label for="str">转换字符串：</label><br>
    <p><textarea id="str" name="str"
        ><?php if(isset($_POST['str'])) echo $_POST['str'];?></textarea></p>
    <input type="submit" value="转换" />
</form>
<label for="md5_str">md5值：</label><br>
<textarea id="md5_str"><?php if(isset($_POST['str'])) echo md5($_POST['str']);?></textarea>
<style>
    textarea {
        width: 500px;
        height: 100px;
    }
</style>
</body>
</html>