@echo off && chcp 65001 > null && del /f /q null
set TITLE=MainInfo for Windows
title %TITLE% && echo [%date% %time%] %TITLE%

set 

@REM echo 当前盘符：%~d0
@REM echo 当前盘符和路径：%~dp0
@REM echo 当前批处理全路径：%~f0
@REM echo 当前盘符和路径的短文件名格式：%~sdp0
@REM echo 当前CMD默认目录：%cd%
@REM echo 当前盘符："%~d0"
@REM echo 当前盘符和路径："%~dp0"
@REM echo 当前批处理全路径："%~f0"
@REM echo 当前盘符和路径的短文件名格式："%~sdp0"
@REM echo 当前CMD默认目录："%cd%"

@REM echo 当前文件全路径：%~0
@REM echo 当前盘符：%~d0
@REM echo 当前文件全路径：%~f0
@REM echo 当前文件路径%~p0
@REM echo 当前文件名：%~n0
@REM echo 当前文件拓展名：%~x0
@REM echo 当前文件短路径：%~s0
@REM echo 当前文件属性：%~a0
@REM echo 当前文件日期/时间：%~t0
@REM echo 当前文件大小：%~z0
@REM echo 当前文件全路径：%~$PATH:0

@REM echo %~dp0
@REM echo %~nx0
@REM echo %~fs0
@REM echo %~dp$PATH:0
@REM echo %~ftza0
@REM echo %~aztf0

:InfoOfFileHash

:InfoOfFileSize

:InfoOfFileBaseName

:InfoOfFileShortPath

:InfoOfFilePath

:InfoOfFileAttrubutes

:End
pause && exit

