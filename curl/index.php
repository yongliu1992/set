<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/7
 * Time: 07:33
 */
//使用curl 发送post请求
$login_url = 'http://xxx.com';
$ch = curl_init($login_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
$mobile = 13965011111;

$post_fields = [
    'pwd'=>'a3831524',
    'mobile'=>17600731111,
    'src'=>5
];

$post_fields = http_build_query($post_fields);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);

$res=curl_exec($ch);

curl_close($ch);

var_dump($res);exit;