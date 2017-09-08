<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/7
 * Time: 07:42
 */

function writeLog($path,$text) {
    if(is_array($text))$text = var_export($text,ture);
    file_put_contents ( $path, date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
}