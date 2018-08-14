<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/14
 * Time: 下午2:33
 */

class Bucket
{

    protected $poolSize ;//桶大小

    protected  $createSeconds ;// 产生间隔

    protected  $createCount ; // 产生数量

    protected $currentPoolSize ;


    public  function create(){
        if($this->currentPoolSize < $this->poolSize)
            $this->currentPoolSize += $this->createSeconds;
    }


    public function consume(){
        if($this->currentPoolSize > 0 ){
            $this->currentPoolSize -= 1;
            return true;
        }else
            return false;
    }



}