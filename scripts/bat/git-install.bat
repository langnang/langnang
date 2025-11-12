@echo off

echo Installing Git for Windows...

curl -L https://mirror.ghproxy.com/https://github.com/git-for-windows/git/releases/download/v2.43.0.windows.1/Git-2.43.0-64-bit.exe -o git-install.exe

start /wait "" git-install.exe /SILENT /AddToPath=1

del git-install.exe

