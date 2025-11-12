@echo off
reg.exe add "HKEY_CLASSES_ROOT\Directory\Background\shell\wt" /f /ve /d "Windows Terminal here"
reg.exe add "HKEY_CLASSES_ROOT\Directory\Background\shell\wt" /f /v "Icon" /t REG_EXPAND_SZ /d "path\terminal.ico"
reg.exe add "HKEY_CLASSES_ROOT\Directory\Background\shell\wt\command" /f /ve /t REG_EXPAND_SZ /d "\"%%LOCALAPPDATA%%\\Microsoft\\WindowsApps\\wt.exe\""
pause