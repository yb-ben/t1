<?php
/*include '../../vendor/predis/predis/autoload.php';
include '../db/Connection.php';
include '../db/Db.php';
include 'QueueDriver.php';
include 'RedisQueue.php';
$db = Db::getInstance();

$conn = $db->connection('',['dbname' => 'test' ]);

$conn->beginTransaction();
try {
    $id = $conn->insert('INSERT INTO order_queue (mobile,status) values (:mobile,:status);',
        [':mobile' => '10086', ':status' => 0]);
    $redisQueue = new RedisQueue(new \Predis\Client, 'foo');
    $redisQueue->push(['uid' => $id]);
    $conn->commit();
}catch (\PDOException $e){
    $conn->rollback();
}catch (\Throwable $t){
    die('fail');
}
echo 'ok',PHP_EOL;*/

