<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/21
 * Time: 20:28
 */

Class Task
{

    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function run(Connection $db)
    {
        return  $db->update('update order_queue set status = :status where id = :id', get_object_vars($this));
    }

}