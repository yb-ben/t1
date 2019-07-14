<?php

/*
* 2019/4/9 
* 转换Data-url类型
*	
*/
class DataUrl{
    
protected $mimeTypes = array(

'txt' => 'text/plain',
'htm' => 'text/html',
'html' => 'text/html',
'php' => 'text/html',
'css' => 'text/css',
'js' => 'application/javascript',
'json' => 'application/json',
'xml' => 'application/xml',
'swf' => 'application/x-shockwave-flash',
'flv' => 'video/x-flv',

    // images
'png' => 'image/png',
'jpe' => 'image/jpeg',
'jpeg' => 'image/jpeg',
'jpg' => 'image/jpeg',
'gif' => 'image/gif',
'bmp' => 'image/bmp',
'ico' => 'image/vnd.microsoft.icon',
'tiff' => 'image/tiff',
'tif' => 'image/tiff',
'svg' => 'image/svg+xml',
'svgz' => 'image/svg+xml',

    // archives
'zip' => 'application/zip',
'rar' => 'application/x-rar-compressed',
'exe' => 'application/x-msdownload',
'msi' => 'application/x-msdownload',
'cab' => 'application/vnd.ms-cab-compressed',

    // audio/video
'mp3' => 'audio/mpeg',
'qt' => 'video/quicktime',
'mov' => 'video/quicktime',

    // adobe
'pdf' => 'application/pdf',
'psd' => 'image/vnd.adobe.photoshop',
'ai' => 'application/postscript',
'eps' => 'application/postscript',
'ps' => 'application/postscript',


);

    protected $maxFileSize;
    public $errstr = '';

    public function __construct($maxFileSize = 0)
    {
        $this->setMaxFileSize($maxFileSize);
    }

    public function setMaxFileSize($maxFileSize){
        $maxFileSize<0 && $maxFileSize = 0;
        $this->maxFileSize = $maxFileSize;
    }

    public function getDataUrl($filename){
        if (!file_exists($filename)) {
            $this->errstr = 'This file is invalid!';
            return false;
        }
        $buffer = @file_get_contents($filename);
        if(function_exists('mime_content_type')){
            $mime = mime_content_type($filename);
        }elseif(function_exists('finfo_open')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($buffer);
            finfo_close($finfo);
            if (!$mime) {
                $this->errstr = 'Can\'t not detect the mime type!';
                return false;
            }
        }elseif( -1 !== ($pos=strrpos('.',$filename))){
            $mime = substr($filename,$pos);
        }else{
            $mime = 'application/octet-stream';
        }
        if($mime !=='application/octet-stream' && !in_array($mime,$this->mimeTypes)){
            $this->errstr = "The $mime type can not handle!";
            return false;
        }
        if($this->maxFileSize && strlen($buffer) > $this->maxFileSize){
            $this->errstr = 'The file is too large!';
            return false;
        }
        $str= 'data:'.$mime.';base64,'.str_replace("\r\n", '', base64_encode($buffer));
        unset($buffer);
        return $str;
    }

    public function getLastError(){
        return $this->errstr;
    }
}
