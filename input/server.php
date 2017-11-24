<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 24/11/2017
 * Time: 11:38
 */

echo  "-------\$_POST------------------\n";
echo var_dump($_POST) . "\n";
echo "-------php://input-------------\n";
$raw_post_data = file_get_contents("php://input","r");
echo $raw_post_data . "\n";