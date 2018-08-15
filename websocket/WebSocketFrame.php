<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/13
 * Time: 下午7:43
 */

class WebSocketFrame
{
    const WS_OP_AGAIN = 0X0;//还有后续分片
    const WS_OP_TEXT = 0X1;//文本
    const WS_OP_BINARY = 0X2;//二进制
    const WS_OP_CLOSE = 0X8;//关闭
    const WS_OP_PING = 0X9;
    const WS_OP_PONG = 0XA;

    public static $opcodes = [
        self::WS_OP_AGAIN,self::WS_OP_TEXT,self::WS_OP_BINARY,self::WS_OP_PING,self::WS_OP_PONG,self::WS_OP_CLOSE
    ];



    public $fin = 1;

    public $rsv = 0;

    public $opcode ;

    public $mask = 0;


    public $sevenBit = 0;

    public  $payloadLen = 0;

    public $maskingKey = '' ;// if MASK set to 1;

    public $payloadData = '' ;

    public $length = 0 ;

    /**
     * WebSocketFrame constructor.
     * @param int $fin
     * @param int $rsv
     * @param $opcode
     * @param int $mask
     * @param int $sevenBit
     * @param int $payloadLen
     * @param string $maskingKey
     * @param string $payloadData
     * @param int $length
     */
    public function __construct(int $fin, int $rsv, $opcode, int $mask, int $sevenBit, int $payloadLen, string $maskingKey, string $payloadData, int $length)
    {
        $this->fin = $fin;
        $this->rsv = $rsv;
        $this->opcode = $opcode;
        $this->mask = $mask;
        $this->sevenBit = $sevenBit;
        $this->payloadLen = $payloadLen;
        $this->maskingKey = $maskingKey;
        $this->payloadData = $payloadData;
        $this->length = $length;
    }

}