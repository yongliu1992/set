<?php

require '../lib/Resque.php';
date_default_timezone_set('PRC');
Resque::setBackend('127.0.0.1:6379');

$args = array(
	'time' => time(),
	'array' => array(
		'test' => 'phper',
	),
);

Resque::enqueue('wechat', 'Mail', array('1dest@mail.com', 'hi!', 'this is a test conten222t'),true);
exit;
$jobId = Resque::enqueue('default', $argv[1], $args, true);
echo "Queued job ".$jobId."\n\n";
?>