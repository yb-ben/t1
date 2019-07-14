<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/21
 * Time: 20:48
 */

interface QueueDriver
{

    public function pop();
    public function push($data);
    public function length();

}