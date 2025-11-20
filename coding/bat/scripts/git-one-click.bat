@echo off && chcp 65001 >null

title OneClick for Git && echo [%date% %time%] OneClick for Git

:choice
echo 请选择一个选项:
echo [1] install
echo [2] init
echo [3] clone
echo [4] checkout
echo [5] commit
echo [6] fetch
echo [7] push
echo [9] uninstall
choice /C 1239 /N /M "请输入您的选择:"
if %ERRORLEVEL%==1 (
    echo 您选择了选项: install
    goto :install
) else if %ERRORLEVEL%==2 (
    echo 您选择了选项: init
    goto :init
) else if %ERRORLEVEL%==2  (
    echo 您选择了选项: clone
    goto :clone
) else (
    echo 您选择了选项: uninstall
    goto :uninstall
)
pause && exit

:install
echo install
pause && exit
:init
call %~dp0init.bat
pause && exit
:clone
echo clone
pause && exit
:uninstall
echo uninstall
pause && exit