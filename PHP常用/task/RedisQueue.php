<?php


class RedisQueue implements QueueDriver
{

    private $_conn;

    private $name;

    public function __construct(Predis\Client $client,$name)
    {
        $this->_conn = $client;
        $this->name = $name;
    }

    public function pop(){
       return $this->_conn->blpop($this->name,0);
    }

    public function push($data){
        return $this->_conn->rpush($this->name,$data);
    }

    public function length(){
       return $this->_conn->llen($this->name);
    }

    public function __destruct()
    {
        $this->_conn->quit();
    }

}