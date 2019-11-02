#!/bin/bash

#压缩文件
f="tarfile"
#定义目标文件夹
arr=("dir1" "dir2")

for element in ${arr[@]}
do
tar -zxvf $f $element
done