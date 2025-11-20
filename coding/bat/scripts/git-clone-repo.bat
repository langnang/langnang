@echo off

:: Git 克隆
:: git clone https://github.com/{USERNAME}/{REPORISTORY}.git {DIRNAME}
::  -b {BRANCH}

echo [Git 克隆远程仓库]

:InputLocalPath
set /p local_path=请输入目标路径([默认] %~dp0): 

if "%local_path%"=="" set local_path=%~dp0

:: echo 目标路径: %local_path%

:InputRemoteUsername
set /p remote_username=请输入远程账户名:

if "%remote_username%"=="" (
    echo [错误] 未输入远程账户名
    goto :InputRemoteUsername
) 

:InputRemoteReporistory
set /p remote_reporistory=请输入远程仓库名: 

if "%remote_reporistory%"=="" (
    echo [错误] 请输入远程仓库名
    goto :InputRemoteReporistory
) 

:InputLocalReporistory
set /p local_reporistory=请输入本地目录名([默认] %remote_reporistory%): 

git clone "https://github.com/%remote_username%/%remote_reporistory%.git" "%local_reporistory%"