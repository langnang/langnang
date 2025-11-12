@echo off

setlocal enabledelayedexpansion

:WithBatch 
set "content="
for /f "usebackq delims=" %%a in (%FILE_PATH%) do (
    set "content=!content!%%a"
)
 
echo %content%

:WithPowerShell
for /f "delims=" %%i in ('powershell -Command "$obj = Get-Content '%JOSN_FILE_PATH%' | ConvertFrom-Json; $obj.country"') do set value=%%i
 
echo The value is: !value!