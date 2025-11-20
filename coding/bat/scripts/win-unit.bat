@echo off && chcp 65001 >null
set TITLE=MainUnit for Windows
title %TITLE% && echo [%date% %time%] %TITLE%

:Start
echo [001] *CreateFile* 创建文件
echo [002] *DeleteFile* 删除文件
echo [003] *RenameFile* 重命名文件

set /p UNIT_CODE=请输入要执行的单元编号(编码)：


if "%UNIT_CODE%"=="" ( 
    goto :Start 
) else ( 
    goto :%UNIT_CODE% 
)
pause & exit

:001 
:CreateFile

echo "CreateFile"

goto :Start & pause & exit