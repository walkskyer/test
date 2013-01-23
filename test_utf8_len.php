<?php
$str="你好世界!";
$len=strlen($str);
echo "len=$len<br />";
$mb_len=mb_strlen($str,'utf-8');
echo "mb_len=$mb_len";
?>