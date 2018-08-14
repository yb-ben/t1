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

    private $fin = 1;

    private $rsv = 0;

    private $opcode ;

    private $mask = 0;



    private $sevenBit = 0;

    private  $payloadLen = 0;

    private $maskingKey = '' ;// if MASK set to 1;

    private $payloadData = '' ;

    private $length = 0 ;

    public function setFin(){}

    public function setOpcode(){}

    public function setPayloadData(){}


    /**
     * @return array
     */
    public static function getOpcodes(): array
    {
        return self::$opcodes;
    }

    /**
     * @return int
     */
    public function getFin(): int
    {
        return $this->fin;
    }

    /**
     * @return int
     */
    public function getRsv(): int
    {
        return $this->rsv;
    }

    /**
     * @return mixed
     */
    public function getOpcode()
    {
        return $this->opcode;
    }

    /**
     * @return int
     */
    public function getMask(): int
    {
        return $this->mask;
    }

    /**
     * @return int
     */
    public function getSevenBit(): int
    {
        return $this->sevenBit;
    }

    /**
     * @return int
     */
    public function getPayloadLen(): int
    {
        return $this->payloadLen;
    }

    /**
     * @return string
     */
    public function getMaskingKey(): string
    {
        return $this->maskingKey;
    }

    /**
     * @return string
     */
    public function getPayloadData(): string
    {
        return $this->payloadData;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

}