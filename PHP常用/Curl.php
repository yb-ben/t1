<?php

class Curl{

    protected $ch;
    protected $defaultOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_HEADER => true,
        CURLOPT_CONNECTTIMEOUT =>2,
        CURLOPT_SSL_VERIFYPEER =>false,
        CURLOPT_SSL_VERIFYHOST =>false,
    ];


    protected $options = [];
    protected $headers = [];
    protected $responseBody;
    protected $responseHeaders;
    protected $curlErrorCode;
    protected $curlErrorMessage;
    protected $curlInfo;
    protected $isSSL=false;

    protected $code;
    protected $contentType;
    protected $url ;


    public function __construct($url = null)
    {
        if (!extension_loaded('curl')) {
            throw new \Exception('The extension curl not found!');
        }
        $this->ch = curl_init();
        $this->initialize();
        $this->setUrl($url);
    }


    private function initialize(){
        curl_setopt_array($this->ch, $this->defaultOptions);
    }

    public function setOption($option,$value){
        $retval = curl_setopt($this->ch, $option, $value);
        if($retval){
            $this->options[$option] = $value;
        }
        return $retval;
    }

    public function setTimeout($timeout){
        return $this->setOption(CURLOPT_TIMEOUT, $timeout);
    }

    public function checkIfDefaultOption($option){
        return !array_key_exists($option,$this->defaultOptions);
    }

    public function setOptions($options){
        foreach ($options as $option => $value){
            if (!$this->setOption($option, $value)) {
                return false;
            }
        }
        return true;
    }

    public function setUrl($url)
    {
        if(strpos($url,'https') !== -1){
            $this->isSSL = true;
        }
        return $this->setOption(CURLOPT_URL, $url);
    }



    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
        $headers = array();
        foreach ($this->headers as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        return $this->setOption(CURLOPT_HTTPHEADER, $headers);
    }


    public function setHeaders($headers)
    {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }

        $headers = array();
        foreach ($this->headers as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        return $this->setOption(CURLOPT_HTTPHEADER, $headers);
    }

    public function getOpt($option)
    {
        return isset($this->options[$option]) ? $this->options[$option] : null;
    }

    public function reset(){
        if (function_exists('curl_reset') && is_resource($this->ch)) {
            curl_reset($this->ch);
        } else {
            $this->ch = curl_init();
        }
        return true;
    }

    public function exec(){
        $rawResponse = curl_exec($this->ch);
        $this->parseResponse($rawResponse);
        $this->curlErrorCode = curl_errno($this->ch);
        $this->curlErrorMessage = curl_error($this->ch);
        $this->curlInfo = curl_getinfo($this->ch);

        $this->code = $this->curlInfo['http_code'];
        $this->contentType = $this->curlInfo['content_type'];
        $this->url = $this->curlInfo['url'];

        return true;
    }

    private function parseResponse($raw)
    {
        list($responseHeaders,$responseBody) = explode("\r\n\r\n", $raw,2);
        $responseHeaders = explode("\r\n", $responseHeaders);
        unset($responseHeaders[0]);
        foreach ($responseHeaders as $value){
            list($key,$val) = explode(': ', $value);
            $this->responseHeaders[$key] = $val;
        }
        $this->responseBody = $responseBody;
        unset($raw);
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function getResponseHeaders(){
        return $this->responseHeaders;
    }

    public function isError(){
        return $this->curlErrorCode !== 0;
    }

    public function getErrorMessage(){
        return $this->curlErrorMessage;
    }

    public function getRequestInfo()
    {
        return $this->curlInfo;
    }


    public function setPost($data = null,$type = 'param'){
        $this->setOption(CURLOPT_POST, true);
        if($data) {
            if (is_array($data)) {
                if ($type === 'param') {
                    $data = http_build_query($data);
                    $this->setOption(CURLOPT_POSTFIELDS, $data);
                    $this->setHeader('Content-Type', 'application/x-www-form-urlencoded');
                } elseif ($type === 'json') {
                    $data = json_encode($data);
                    $this->setOption(CURLOPT_POSTFIELDS, $data);
                    $this->setHeader('Content-Type', 'application/json');
                }
            }
        }
        return true;
    }


    public function close(){
        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }
        $this->options = null;
    }


    public function __destruct()
    {
        $this->close();
    }
}

$curl = new Curl('http://localhost:8888/test.html');
$curl->exec();
echo $curl->getResponseBody();
print_r($curl->getResponseHeaders());
print_r($curl->getRequestInfo());