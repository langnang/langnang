@echo off

echo '使用ssh连接，请先将公钥保存到GIT服务端,HTTP连接改动git url'

echo start git clone

git clone git@github.com:langnang-temp/vue-template.git ClientApp

echo 'git clone finish!'

rd ClientApp\.git /s /Q
rd ClientApp\.github /s /Q

pause