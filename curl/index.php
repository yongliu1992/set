<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/7
 * Time: 07:33
 */

$tmp =array (
    'payment_type' => '1',
    'trade_no' => '2017090721001004020259788723',
    'subject' => '很美丽',
    'buyer_email' => 'a38***@126.com',
    'gmt_create' => '2017-09-07 16:21:53',
    'notify_type' => 'trade_status_sync',
    'quantity' => '1',
    'out_trade_no' => '20170907162140997922',
    'seller_id' => '2088021970397651',
    'notify_time' => '2017-09-07 16:21:54',
    'trade_status' => 'TRADE_SUCCESS',
    'is_total_fee_adjust' => 'N',
    'total_fee' => '0.01',
    'gmt_payment' => '2017-09-07 16:21:54',
    'seller_email' => 'marcsong@zggonglue.com',
    'price' => '0.01',
    'buyer_id' => '2088102328382023',
    'notify_id' => '5ca75d65013dca0b4dbea057a288c09g5m',
    'use_coupon' => 'N',
    'sign_type' => 'MD5',
    'sign' => '05d5b0ac55ba3d5216b526986ad279cc',
);

$login_url = 'http://php.shaoziketang.com/user/login';
$login_url = 'http://php.shaoziketang.com/callback/ali';
$ch = curl_init($login_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
$mobile = 13965019845;
$post_fields = [
    'pwd'=>'123456',
    'mobile'=>17600736503,
    'src'=>4
];
$post_fields = $tmp;
$post_fields = http_build_query($post_fields);
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