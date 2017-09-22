<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/22
 * Time: 22:32
 */

class Mail{
    public function setUp(){
        # 这个方法会在perform()之前运行，可以用来做一些初始化工作
        # 如连接数据库、处理参数等
    }

    public function perform(){
        # 执行Job
        var_dump($this->args);
        echo mt_rand(1,10);
    }

    public function tearDown(){
        # 会在perform()之后运行，可以用来做一些清理工作
    }
}