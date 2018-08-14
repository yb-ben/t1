<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/14
 * Time: 下午2:45
 */

class RedisBucketDriver extends Bucket
{

    private  $connection ;

    public function __construct($redisClient)
    {
        $this->connection = $redisClient;
    }


    public function ready(){

    }


    public function start(){

    }


    public function stop(){}


    public function create(){}


    public function consume(){}


    public function destroy(){}


}