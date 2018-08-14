<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/14
 * Time: 上午9:23
 */

class Kernel
{

    private $decoder;
    private $encoder;

    private $sendLimitSize;
    private $receiveLimitSize;

    public function __construct($config)
    {

    }

    public function receive($rawData){

        $this->decoder->parseFrame($rawData);
    }

}