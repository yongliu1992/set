<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/7
 * Time: 07:36
 */
//获取客户端post 数据流


$post1 = file_get_contents("php://input");

parse_str($post1,$_POST);