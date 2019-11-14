#!/bin/bash

   #压缩文件
f="tarfile.tar.gz"
t=${f##*.}
#定义目标文件夹
arr=("dir1" "dir2")
dir=/tmp/test/
for element in ${arr[@]}
do
  if [ "$t" == "gz" ] ; then
     tar -zxf "$f" -C "$element"
     else
     tar -xf "$f" -C "$element"
  fi

done

#bb

#c