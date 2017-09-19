<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/18
 * Time: 22:23
 */
$redis = new Redis();
$redis->connect('localhost');
$arr = array('h','e','l','l','o','w','o','r','l','d');

foreach($arr as $k=>$v){

    $redis->rpush("myWorkList",$v);

}