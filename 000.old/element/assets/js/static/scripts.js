"use strict";
(function (define) {
  define(function (require, exports, module) {
    const $ = require("jquery");
    const ClipboardJS = require("clipboard");
    window.download = require("downloadjs");
    const Mock = require("mockjs");
    const template = require("text!./../../../views/static/scripts.hbs");

    const MarkdownIt = require("markdown-it");
    const md = new MarkdownIt();
    const scripts = [
      {
        name: "rename",
        children: [
          {
            name: Mock.mock('@guid'),
            description: "批量修改当前文件夹下文件（夹）名中字符",
            script: `
@echo off
set /p str1= 请输入要替换的文件(文件夹)名字符串（可替换空格）：
set /p str2= 请输入替换后的文件(文件夹)名字符串（去除则直接回车）：
echo.
echo 正在修改文件(夹)名中，请稍候……
for /f "delims=" %%a in ('dir /s /b ^|sort /+65535') do (
  if "%%~nxa" neq "%~nx0" (
    set "file=%%a"
    set "name=%%~na"
    set "extension=%%~xa"
    call set "name=%%name:%str1%=%str2%%%"
    setlocal enabledelayedexpansion
    ren "!file!" "!name!!extension!" 2>nul
    endlocal
  )
)
exit
`,
          }
        ]
      },
      {
        name: "ffmpeg",
        description: "A complete, cross-platform solution to record, convert and stream audio and video.",
        children: [
          {
            name: "",
            description: "To set the video bitrate of the output file to 64 kbit/s.",
            script: `ffmpeg -i input.avi -b:v 64k -bufsize 64k output.avi`
          },
          {
            name: Mock.mock('@guid'),
            description: "提取视频片段",
            script: `ffmpeg -ss 00:03:00 -i video.mp4 -to 00:02:00 -c copy cut.mp4`,
          },
          {
            name: Mock.mock('@guid'),
            description: "提取视频帧", script: `ffmpeg -i "%1" %1-%03d.jpg`
          },
          {
            name: Mock.mock('@guid'),
            description: "将输出文件的视频比特率设置为64 kbit/s",
            script: `ffmpeg -i input.avi -b:v 64k -bufsize 64k output.avi`,
          },
          {
            name: "ffmpeg-mkv-ass",
            description: "ffmpeg批量提取MKV中内封ass字幕",
            script: `for %%i in (.\\*.mkv) do ffmpeg -i "%%i" -map 0:s:0 "%%~dpni.chs.ass"`,
          },
          {
            name: "ffmpeg-mkv-srt",
            description: "ffmpeg批量提取MKV中内封srt字幕",
            script: `for %%i in (.\\*.mkv) do ffmpeg -i "%%i" -vn -an -codec:s:0 srt "%%~dpni.chs.srt"`
          },
          {
            name: "mkv-2-mp4",
            description: "ffmpeg批量转MKV为MP4",
            script: `for %%i in (.\\*.mkv) do ffmpeg -i "%%i" -c copy "%%~dpni.mp4"`
          },
          {
            name: "4",
            description: "ffmpeg为视频附加字幕",
            script: `for %%i in (.\\*.mkv) do ffmpeg -i "%%i" -i "%%~dpni.chs.ass" "%%~dpni.mp4"`
          },
          {
            name: "5",
            description: "ffmpeg为视频内嵌ass字幕",
            script: `for %%i in (*.mkv) do ffmpeg -i "%%i" -vf subtitles="'%%~ni.chs.ass'" -threads 12 -preset ultrafast "%%~dpni.mp4"`
          },]
      },

    ];

    module.exports = function (options) {
      options.template = template;
      options.render(options.Handlebars.compile(template)(scripts))
      // options.render(content);
      new ClipboardJS(".fa-copy")
      // $(".row[data-title=\"ffmpeg\"]").html(content);
    };
  });
})(define);
