#!/bin/bash

#ѹ���ļ�
f="tarfile"
#����Ŀ���ļ���
arr=("dir1" "dir2")

for element in ${arr[@]}
do
tar -zxvf $f $element
done