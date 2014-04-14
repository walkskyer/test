<?php
/**
 * Created by PhpStorm.
 * User: walkskyer
 * Date: 14-4-14
 * Time: 上午11:59
 */
/**
 * 在非discuz应用中获取uid的一个方法。前提是当前脚本要与discuz处于同一目录下。
 */
require './source/class/class_core.php';
$discuz = & discuz_core::instance();
$discuz->init_cron = false;
$discuz->init_session = false;
$discuz->init();
echo $_G['uid'];