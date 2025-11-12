@echo off & title

cd /d %~dp0

:: 设置输出文件夹
set "output_folder=mp3_files"
 
:: 创建输出文件夹
if not exist "%output_folder%" mkdir "%output_folder%"

:: 遍历视频文件
for %%a in (*.mp4) do (
	
	:: 执行FFmpeg命令
	echo Converting '%%~sa' to '%output_folder%\%%~na.mp3'
	
	:: -codec:a
	:: -q:a 压缩质量 4-9 数值越大 质量越差
	ffmpeg -i "%%~sa" -y -vn -codec:a libmp3lame -q:a 9 "%output_folder%\%%~na.mp3"

)

pause