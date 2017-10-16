<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/7
 * Time: 07:42
 */
echo 34;
//var_dump(111);
echo 91;
echo 333;
exit;
function writeLog($path,$text) {
    if(is_array($text))$text = var_export($text,ture);
    file_put_contents ( $path, date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
}

function formatNum($number){
    $number=substr($number,0,2);
    $arr=array("零","一","二","三","四","五","六","七","八","九");
    if(strlen($number)==1){
        $result=$arr[$number];
    }else{
        if($number==10){
            $result="十";
        }else{
            if($number<20){
                $result="十";
            }else{
                $result=$arr[substr($number,0,1)]."十";
            }
            if(substr($number,1,1)!="0"){
                $result.=$arr[substr($number,1,1)];
            }
        }
    }
    return $result;
}
//去除数组中重复的值
 function unique_arr($array2D,$stkeep=false,$ndformat=true)
{
    // 判断是否保留一级数组键 (一级数组键可以为非数字)
    if($stkeep) $stArr = array_keys($array2D);
    // 判断是否保留二级数组键 (所有二级数组键必须相同)ps
    if($ndformat) $ndArr = array_keys(end($array2D));
    //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
    foreach ($array2D as $v){
        $v = join(",",$v);
        $temp[] = $v;
    }
    //去掉重复的字符串,也就是重复的一维数组
    $temp = array_unique($temp);
    //再将拆开的数组重新组装
    foreach ($temp as $k => $v)
    {
        if($stkeep) $k = $stArr[$k];
        if($ndformat)
        {
            $tempArr = explode(",",$v);
            foreach($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;
        }
        else $output[$k] = explode(",",$v);
    }
    return $output;
}


function secMobile($phone)
{

    return  preg_replace("/^([0-9]{3})[0-9]{4}([0-9]{4})$/", "\$1****\$2",$phone);
}


