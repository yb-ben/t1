<?php

use \Endroid\QrCode\QrCode as EndroidQrCode;

class QrCode extends Base
{
    protected $url;     //二维码路径

    protected $name;    //生成的二维码文件名

    protected $path;    //二维码存放位置

    protected $margin;  //白边大小

    protected $size;    //二维码大小


    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setMargin($margin)
    {
        $this->margin = $margin;
        return $this;
    }

    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * 创建二维码
     *
     * @return string  返回二维码存放路径
     */
    public function create()
    {
        $qrcode = new EndroidQrCode($this->url);

        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }

        $path_name = $this->path . '/' . $this->name;

        $qrcode->setMargin($this->margin);
        $qrcode->setSize($this->size);
        $qrcode->writeFile($path_name);

        return $path_name;
    }
}
