<?php
/**
 * 文件大小格式化
 * @param $bytes 文件大小（字节 Byte)
 * @return string
 */
function cmf_file_size_format($bytes)
{
    $type = ['B', 'KB', 'MB', 'GB', 'TB'];
    for ($i = 0; $bytes >= 1024; $i++)//单位每增大1024，则单位数组向后移动一位表示相应的单位
    {
        $bytes /= 1024;
    }
    return (floor($bytes * 100) / 100) . $type[$i];//floor是取整函数，为了防止出现一串的小数，这里取了两位小数
}