@echo off
chcp 65001 > nul
setlocal enabledelayedexpansion

REM 获取系统用户名
for %%a in ("%userprofile%") do set "YourUsername=%%~nxa"
echo 正在获取系统用户名: %YourUsername%

REM 清理 .vscode 目录
set "vscodePath=%userprofile%\.vscode"
if exist "!vscodePath!" (
echo 正在检测 .vscode 文件夹
echo 检测到 .vscode 文件夹，开始清理
rmdir /s /q "!vscodePath!"
echo .vscode 文件夹已清理。
) else (
echo 未找到 .vscode 文件夹。跳过清理
)

echo

REM 清理 AppData/Roaming/Code 目录
set "codePath=%userprofile%\AppData\Roaming\Code"
if exist "!codePath!" (
echo 正在检测 Code 文件夹
echo 检测到 Code 文件夹，开始清理
rmdir /s /q "!codePath!"
echo Code 文件夹已清理。
) else (
echo 未找到 Code 文件夹。跳过清理
)

echo
echo 清理完成
pause