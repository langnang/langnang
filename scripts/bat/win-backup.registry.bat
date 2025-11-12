@echo off && chcp 65001 >null
set TITLE=BackupRegistry for Windows
title %TITLE% && echo [%date% %time%] %TITLE%

cd /d "%~dp0"

regedit /e "D:\main.reg"

pause & exit