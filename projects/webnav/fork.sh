#!/bin/bash

echo "Welcome to fork website repositories"

echo "..."

# 请选择仓库
echo "Please select repository:"
 
select fruit in   "WebStackPage/WebStackPage.github.io"   "香蕉"   "橙子"   "葡萄"
do
  case $fruit in
    "WebStackPage/WebStackPage.github.io")
      echo "你选择了苹果"
      local_dir="html/WebStackPage.github.io"
      break
      ;;
    "香蕉")
      echo "你选择了香蕉"
      local_dir="html/WebStackPage.github.io"
      break
      ;;
    "橙子")
      echo "你选择了橙子"
      local_dir="html/WebStackPage.github.io"
      break
      ;;
    "葡萄")
      echo "你选择了葡萄"
      local_dir="html/WebStackPage.github.io"
      break
      ;;
    *)
      echo "无效的选择!"
      break
      ;;
  esac
done
 
echo "你最终选择了: $fruit $local_dir"

# git clone https://github.com/WebStackPage/WebStackPage.github.io.git

# git clone git@github.com:WebStackPage/WebStackPage.github.io.git html/WebStackPage.github.io


echo "Press any key to continue..."

read -n 1