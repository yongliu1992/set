<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/7
 * Time: 07:33
 */

$tmp =
    'courseId=129&sign=0b5dadc76bbcfb48e70ff8c14b87f12c&timestamp=1505403841857.143799&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MDUzMTg1OTMsImp0aSI6ImNsYXNzLWNuLXRva2VuLWtvYWxhIiwiaXNzIjoiY2xhc3MuY24iLCJkYXRhIjp7InVzZXJJZCI6IjY4MTY5IiwibW9iaWxlIjoiMTgwMDAwMDAwMDAiLCJsb2dpblRva2VuIjoiYzQzNTJiOWEyZTkwZjczNmE4ZmVhYmY4NDc0MTU3NzgiLCJlZGl0aW9uSWQiOiIxIiwiZGV2aWNlVG9rZW4iOiIwNzAwM2MwN2ViMWY4OWI3YmI0MzFlYTAxNWM1MTM4MDA3MDAzYzA3ZWIxZjg5YjdiYjQzMWVhMDE1YzUxMzgwIn19.5aUPrY4NFddUCt9vJVk0YMHtKEcdw9ICFEqS0Fe35vw';




$login_url = 'http://http://api.koalapass.com/course/getChapter?'.$tmp;
var_dump(file_get_contents($tmp));exit;
$ch = curl_init($login_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

//parse_str($tmp,$post_fields);
//$post_fields = $tmp;
//$post_fields = http_build_query($post_fields);
//var_export($post_fields);exit;
$post_fields = $tmp;
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);

$res=curl_exec($ch);

curl_close($ch);

var_dump($res);exit;

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