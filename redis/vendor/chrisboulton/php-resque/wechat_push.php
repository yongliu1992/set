<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/22
 * Time: 23:07
 */
require_once ("../../autoload.php");

use EasyWeChat\Foundation\Application;
class Wechat_push {

    public function perform(){
        # 执行Job
        for($i=0;$i<3;$i++){
            sleep(1);

            $options = [
                'debug'  => true,
                'app_id' => 'wxc9aba9022d9ccccccc',
                'secret' => 'd9196aaa21549fdc8e6exccccxcc',
                'token'  => 'a38ccccc',
                // 'aes_key' => null, // 可选
                'log' => [
                    'level' => 'debug',
                    'file'  => '/tmp/easywechat.log', // XXX: 绝对路径！！！！注意权限
                ],
                //...
            ];


            $app = new Application($options);
            $notice = $app->notice;
            //$userId = 'ozErPs1rrle6iGFwEF6VNMmNPups';
            $userId=$this->args['openid'];
            $templateId = '7WFWd8xhnffWd7TOPIa9VzlFIscI2c8hD_msRLiR3sQ';
            $url = 'http://overtrue.me';
            $order_no = mt_rand(1111111,99999999);
            $data = array(
                "first"    => array("恭喜你购买成功！\n", '#FF7F24'),
                "keyword1" => array("飞船", "#FFB6C1"),
                "keyword2" => array($order_no, "#FF0000"),
                "keyword3" => array("8888888.8元", "#FF1493"),
                "keyword4" => array(date("Y-m-d H:i:s")."\n", "#EEAEEE"),
                "remark"   => array("欢迎再次购买！", "#CDAD00"),
            );
            $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
            var_dump($result);

        }
       // echo date("Y-m-d H:i:s");
        //var_dump($this->args);

    }
}