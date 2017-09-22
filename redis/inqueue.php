<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/22
 * Time: 23:02
 */
require_once ("vendor/autoload.php");
date_default_timezone_set('PRC');
Resque::setBackend('127.0.0.1:6379');

$args = array(
    'time' => time(),
    'array' => array(
        'test' => 'phper',
    ),
);

Resque::enqueue('wechat', 'wechat_push', array('openid'=>'ozErPs1rrle6iGFwEF6VNMmNPups'),true);