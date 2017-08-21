<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/8/21
 * Time: 23:03
 */

header("Content-type: image/jpeg");
$dst='t2.jpeg';
//得到原始图片信息
$dst_im = imagecreatefromjpeg($dst);
$dst_info = getimagesize($dst);


//水印图像
$src = "t3.jpeg";
$src_im = imagecreatefromjpeg($src);
$src_info = getimagesize($src);

//水印透明度
$alpha = 6;

//合并水印图片
imagecopymerge($dst_im,$src_im,120,522,0,0,$src_info[0],
    $src_info[1],$alpha);

//输出合并后水印图片
imagejpeg($dst_im);
imagedestroy($dst_im);
imagedestroy($src_im);