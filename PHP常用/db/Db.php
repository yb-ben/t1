<?php


class Db
{

    private static $_instance = null;

    private static $connection = [];

    protected static $config = [
        'driver' => 'mysql',
        'username' => 'root',
        'password' => '',
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => '',
        'charset' => 'utf8mb4'
    ];



    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(!self::$_instance instanceof self ){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function connection($name = '',$config = [], $isNew = false){
        if(!$isNew && isset(self::$connection[$name])){
            return self::$connection[$name];
        }
        $config  = empty($config)? self::$config :array_merge(self::$config,$config);
         $dsn = $config['driver'].':host='.$config['host'].';dbname='.$config['dbname'];
        return self::$connection[$dsn.';root='.$config['username']] = new Connection($dsn,$config['username'],$config['password']);
    }
}