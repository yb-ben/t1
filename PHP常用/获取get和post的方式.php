<?php
// post all
$post = $_POST;

// post x-www-urlencoded
$input = file_get_contents('php://input');
mb_parse_str($input,$post);

// post application/json
$input = file_get_contents('php://input');
$post = json_decode($input,true);



// post filter
$input = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);//去除标签 <> ，转义 ' " (去除标签，去除或编码特殊字符)

$input = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS); //HTML 转义字符 '"<>& 以及 ASCII 值小于 32 的字符。


// get all
$get = $_GET;

// get query string
mb_parse_str($_SERVER['QUERY_STRING'],$get);


// get filter
$input = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);//去除标签 <>及其随后内容 ，转义 ' " (去除标签，去除或编码特殊字符)
$input = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS); //HTML 转义字符 '"<>& 以及 ASCII 值小于 32 的字符。
