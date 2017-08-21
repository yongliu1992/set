<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/8/21
 * Time: 23:28
 */
$redis = new redis();
$redis->connect('localhost');
$redis->set('kkk','ddd');
//发送短信
$mobile=13691300670;
$redis->zAdd('captcha'.$mobile,time(),$mobile.time());
$count=$redis->zCount('captcha'.$mobile,time()-3600,time());//考虑移除过久之前的数据
if($count>10){
    echo '次数太多了';
}
