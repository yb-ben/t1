<?php
class Download{

    protected $sizeLimit = 0;
    protected $type = null; //file ,data
    protected $size = null;
    protected $header = [];
    protected $expire = 360;
    protected $openinBrower ;
    protected $name;
    protected $data;
    protected $code = 200;

    public function output($file,$isData = false)
    {
        if($isData){
            $this->type = 'data';
            $this->size = strlen($file);
            $mimeType = 'application/octet-stream';

        }elseif (is_file($file)) {
            $file = realpath($file);
            $this->type = 'file';
            $this->size = filesize($file);
            $mimeType = $this->getMimeType($file);
        }
        else{
            throw new \Exception('非法数据');
        }

        $name = $this->name;
        if(empty($name)){
            if ($this->type === 'file') {
                $name = basename($file);
            }else{
                $name = date('YmdHis' . rand(10000, 99999));
            }
        }

        ob_end_clean();//清除缓冲区


        $this->header['Pragma']                    = 'public';
        $this->header['Content-Type']              = $mimeType ;
        $this->header['Cache-control']             = 'max-age=' . $this->expire;
        $this->header['Content-Disposition']       = $this->openinBrower ? 'inline' : 'attachment; filename="' . $name . '"';
        $this->header['Content-Length']            = $this->size;
        $this->header['Content-Transfer-Encoding'] = 'binary';
        $this->header['Expires']                   = gmdate("D, d M Y H:i:s", time() + $this->expire) . ' GMT';

        $this->lastModified(gmdate('D, d M Y H:i:s', time()) . ' GMT');

        $this->data = ($this->type === 'file') ? file_get_contents($file) : $file;
        return $this;
    }

    public function send(){
        http_response_code($this->code);
        $this->sendHeader();
        echo $this->data;
        if (function_exists('fastcgi_finish_request')) {
            // 提高页面响应
            fastcgi_finish_request();
        }
    }

    public function sendHeader(){
        foreach ($this->header as $k => $v){
            header("$k: $v");
        }
        return $this;
    }

    public function setCode($code){
        $this->code = $code;
        return $this;
    }

    public function mimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    public function expire($expire)
    {
        $this->expire = $expire;
        return $this;
    }

    public function lastModified($time)
    {
        $this->header['Last-Modified'] = $time;

        return $this;
    }

    public function setSizeLimit(int $sizeLimit){
        if($sizeLimit < 0){
            throw new \Exception('size limit can not less than 0');
        }
        $this->sizeLimit = $sizeLimit;
    }

    public function openinBrower($openinBrower) {
        $this->openinBrower = $openinBrower;
        return $this;
    }

    protected function getMimeType($filename)
    {
        if (!empty($this->mimeType)) {
            return $this->mimeType;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        return finfo_file($finfo, $filename);
    }

    public function name($filename, $extension = true)
    {
        $this->name = $filename;

        if ($extension && false === strpos($filename, '.')) {
            $this->name .= '.' . pathinfo($this->data, PATHINFO_EXTENSION);
        }

        return $this;
    }
}
