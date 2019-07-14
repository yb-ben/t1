<?php

function httpRequest($url,$method = 'GET',$data=[],$headers=[],$timeout = 5,$ssl_verfiy = false,$cacert= null){
    if (!extension_loaded('curl')) {
        throw new \Exception('The function need the curl extension');
    }

    $ssl = substr($url, 0, 8) == "https://" ? true : false;
    $curl = curl_init();
    switch($method){
        case 'GET':
            $method = CURLOPT_HTTPGET;break;
        case 'POST':
            $method = CURLOPT_POST;break;
        case 'PUT':
            $method = CURLOPT_PUT;break;
        default:
            throw new \Exception("The $method is unsupported!");
    }
    curl_setopt($curl,$method,1);
    curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);//设置header
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);//curl_exec返回响应内容
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);//超时
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout-2);
    curl_setopt($curl,CURLOPT_HEADER,true);
    if($method === 'POST' && !empty($data))
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    if($ssl) {
        if (!$ssl_verfiy) {
            //不验证证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }else{
            if (!is_file($cacert)) {
                throw new \Exception('cacert is not a file');
            }
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
            curl_setopt($curl, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        }
    }
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        throw new \Exception(curl_error($curl));
    }
    $info = curl_getinfo($curl);
    curl_close($curl);
    list($responseHeaders,$responseBody) = explode("\r\n\r\n", $response,2);
    $responseHeaders = explode("\r\n",$responseHeaders);
    return ['info'=>$info,'headers'=>$responseHeaders,'body'=>$responseBody];
}


function httpRequest(string $url,Array $options = []){

    $default = [
        'http'=>[
            'method'=>'GET',
        ]
    ];
    $options = array_replace_recursive($default, $options);
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    return $response;
}



function multiHttpRequest($options){
    if(count($options) === 0)
        return;
    $chs = [];
    $mh = curl_multi_init();
    foreach ($options as $k => $v) {
       $chs[$k] = curl_init();
       curl_setopt_array($chs[$k],$v);
       curl_multi_add_handle($mh, $chs[$k]);
    }

    do {
        $mrc =curl_multi_exec($mh, $running);
    } while ($mrc === CURLM_CALL_MULTI_PERFORM);
    while ($running && $mrc === CURLM_OK) {
        if (curl_multi_select($mh) === -1) {
            usleep(1);
        }
        do {
            $mrc = curl_multi_exec($mh, $running);
        } while ($mrc === CURLM_CALL_MULTI_PERFORM);
    }

    $contents = [];
    foreach ($chs as $k => $v){
        $contents[$k] = curl_multi_getcontent($v);
        curl_multi_remove_handle($mh, $v);
        curl_close($chs[$k]);
    }
    curl_multi_close($mh);
    return $contents;
}