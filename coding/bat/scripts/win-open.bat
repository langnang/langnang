@echo off && chcp 65001 >null
set TITLE=MainOpen for Windows
title %TITLE% && echo [%date% %time%] %TITLE%

:Common
cd /d "%~dp0"
if /i "%1"=="" (
    goto :support-commands
    pause & exit
) 
goto :%1
pause & exit

:chrome 
:: 打开谷歌浏览器
start chrome
pause & exit

:cmd
:: 打开命令行窗口
start cmd
pause & exit

:edge
:: 打开Edge浏览器
start msedge
pause & exit

:environment-variables
:: 打开环境变量设置窗口 
rundll32.exe sysdm.cpl,EditEnvironmentVariables
pause & exit

:explorer
:: 打开资源管理器
explorer ""
pause & exit

:help

pause & exit

:support-commands
echo chrome
echo cmd
echo commands
echo edge
echo environment-variables
echo explorer
echo help
echo support-commands
pause & exit


