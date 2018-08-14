<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/10
 * Time: 下午4:34
 */

class Frame
{

   public $opcode;

   public $length ;

   public $data ;

    /**
     * Frame constructor.
     * @param $type
     * @param $length
     * @param $data
     */
    public function __construct($opcode, $length, $data)
    {
        $this->opcode= $opcode;
        $this->length = $length;
        $this->data = $data;
    }


}