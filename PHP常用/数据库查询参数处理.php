<?php

//不适用参数化sql时参数处理
$func1 = function ($str){
    if(is_string($str)){
        $str = "'".addslashes($str)."'";
    }
    return $str;
};

//使用pdo参数绑定及类型限定，检查字符串或整形
$func2 = function ($param) {
    if (is_string($param)) {
        return PDO::PARAM_STR;
    }
    if (is_integer($param)) {
        return PDO::PARAM_INT;
    }
    return false;
};


