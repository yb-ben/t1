<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/21
 * Time: 15:22
 */

class Connection
{

    protected $pdo ;



    protected $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    protected $hasPrepareSql = [

    ];

    public function __construct($dsn,$username,$password,$options = null)
    {
        $this->init($dsn,$username,$password,$options);
    }


    private function  init($dsn,$username,$password,$options){
        $this->pdo = new \PDO($dsn,$username,$password,is_array($options)? array_merge($this->options,$options):$this->options);
    }

    public function select($sql,$params = []){
        if (count($params) === 0) {
          $res = $this->pdo->query($sql);
        }else {
            $statement = $this->statement($sql);

            foreach ($params as $k => $v) {
                $statement->bindValue(is_integer($k)? $k+1:$k, $v, $this->parseType($v));
            }
            $res = $statement->execute();
        }
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }


    public function insert($sql,$params =[]){
        if(count($params) === 0){
            return $this->pdo->exec($sql);
        }
        $statement = $this->statement($sql);
        foreach ($params as $k => $v) {
            $statement->bindValue(is_integer($k)? $k+1:$k, $v, $this->parseType($v));
        }
        $statement->execute();
        return $this->pdo->lastInsertId();
    }


    public function update($sql,$params = []){
        if(count($params) === 0){
            return $this->pdo->exec($sql);
        }
        $statement = $this->statement($sql);
        foreach ($params as $k => $v) {
            $statement->bindValue(is_integer($k)? $k+1:$k, $v, $this->parseType($v));
        }
        $statement->execute();
        return $statement->rowCount();
    }

    public function delete($sql,$params = []){
        if(count($params) === 0){
             return  $this->pdo->exec($sql);
        }
        $statement = $this->statement($sql);
        foreach ($params as $k => $v) {
            $statement->bindValue(is_integer($k)? $k+1:$k, $v, $this->parseType($v));
        }
        $statement->execute();
        return $statement->rowCount();
    }


    private function statement($sql){

        if(isset($this->hasPrepareSql[$sql])){
            return $this->hasPrepareSql[$sql];
        }
        return  $this->hasPrepareSql[$sql] = $this->pdo->prepare($sql);
    }

    private function parseType($param){
        if(is_int($param))
            $type = PDO::PARAM_INT;
        else if (is_string($param))
            $type = PDO::PARAM_STR;
        else if(is_null($param))
            $type = PDO::PARAM_NULL;
        else if (is_bool($param))
            $type = PDO::PARAM_BOOL;
        else
            $type = PDO::PARAM_STR;
        return $type;
    }

    public function beginTransaction(){
        if ($this->pdo->inTransaction()) {
            throw new \Exception();
        }
        $this->pdo->beginTransaction();
    }

    public function rollback(){
        if (!$this->pdo->inTransaction()) {
            throw new \Exception();
        }
        $this->pdo->rollback();
    }

    public function commit(){
        if (!$this->pdo->inTransaction()) {
            throw new \Exception();
        }
        $this->pdo->commit();
    }

}