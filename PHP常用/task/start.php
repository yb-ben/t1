<?php

include '../../vendor/predis/predis/autoload.php';
include 'QueueDriver.php';
include 'Dispatcher.php';
include 'RedisQueue.php';
include '../db/Db.php';
include '../db/Connection.php';



$queueName = 'foo';
$client = new Predis\Client(['read_write_timeout' => 0]);
$redisQueue = new RedisQueue($client,$queueName);
$dispatcher = new Dispatcher($redisQueue);
$db = Db::getInstance()->connection('',['dbname' => 'test']);
$dispatcher->run(function ($params) use ($db){
    $db->update('update order_queue set status = 1 where id = ?', $params);
});