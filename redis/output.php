<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/18
 * Time: 22:23
 */
$redis = new Redis();
$redis->connect('localhost');
$value = $redis->lpop('myWorkList');

if($value){

    echo "出队的值".$value;

}else{

    echo "出队完成";

}
