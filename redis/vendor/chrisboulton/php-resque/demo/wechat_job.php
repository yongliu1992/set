<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/22
 * Time: 22:07
 */

class Wechat_PHP_Job
{
    function perform()
    {
        //require_once ("../../../../we.php");
       for($i=0;$i<10;$i++){
           echo $i;
           sleep(1);
       }

    }
}