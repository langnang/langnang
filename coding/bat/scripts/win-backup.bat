@echo off && chcp 65001 > null && del /f /q null
set TITLE=MainBackup for Windows
title %TITLE% && echo [%date% %time%] %TITLE%

echo 设备名称：%COMPUTERNAME%
set /a TIME_HOUR=%time:~0,2%+100
set DATE_TIME=%date:~3,4%%date:~8,2%%date:~11,2%%TIME_HOUR:~-2%%time:~3,2%%time:~6,2%%time:~9,2%
echo 日期时间：%DATE_TIME%
set BACKUP_PATH=D:\Documents\OneDrive\Backups\%COMPUTERNAME%

if not exist %BACKUP_PATH% ( md %BACKUP_PATH%)

regedit /e %BACKUP_PATH%\regedit_%DATE_TIME%_main.reg

echo 备份注册表于：%BACKUP_PATH%\regedit_main.%DATE_TIME%.reg

tree C: > "D:\Documents\OneDrive\Backups\%COMPUTERNAME%\tree_c.%DATE_TIME%.txt"

tree C: /f > "D:\Documents\OneDrive\Backups\%COMPUTERNAME%\tree_f_c.%DATE_TIME%.txt"
echo 备份[C]盘目录结构于：D:\Documents\OneDrive\Backups\%COMPUTERNAME%\tree_c.%DATE_TIME%.txt

tree D: > "D:\Documents\OneDrive\Backups\%COMPUTERNAME%\tree_d.%DATE_TIME%.txt"

tree D: > "C:\tree_d.%DATE_TIME%.txt"
move C:\tree_d.%DATE_TIME%.txt D:\Documents\OneDrive\Backups\%COMPUTERNAME%
tree D: /f > "C:\tree_f_d.%DATE_TIME%.txt"
move C:\tree_f_d.%DATE_TIME%.txt D:\Documents\OneDrive\Backups\%COMPUTERNAME%
echo 备份[D]盘目录结构于：D:\Documents\OneDrive\Backups\%COMPUTERNAME%\tree_d.%DATE_TIME%.txt

pause && exit