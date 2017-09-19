<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/18
 * Time: 23:18
 */

require 'vendor/autoload.php';
Resue::setBakend('localhost:6379');


$args = array(
    'name' => 'Chris'
);
Resque::enqueue('default', 'My_Job', $args);