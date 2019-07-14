<?php

//输出转义
$output = filter_var($output, FILTER_SANITIZE_FULL_SPECIAL_CHARS);//针对html实体
$output = filter_var($output, FILTER_SANITIZE_STRING);//去除标签，针对html实体
$output = filter_var($output, FILTER_SANITIZE_ENCODED);//针对输出到 href src script
htmlspecialchars($output);
htmlentities($output);