@echo off 

:: Jump to the directory where this file reside.
cd /d "%~dp0"

:: Batch
git clone git@github.com:langnang-scripts/bat.ffmpeg.git bat/ffmpeg
git clone git@github.com:langnang-scripts/bat.g-i-t.git bat/g-i-t
git clone git@github.com:langnang-scripts/bat.windows.git bat/windows

:: VBScript
git clone git@github.com:langnang-scripts/vbs.windows.git vbs/windows