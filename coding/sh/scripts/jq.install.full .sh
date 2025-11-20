!/bin/bash

echo "检查 jq ......"
jq --version
if [ $? -eq  0 ]; then
    echo "检查到 yq 已安装!"
else
    echo "安装 yq 应用..."
    # curl -sSL https://get.daocloud.io/docker | sh
    # echo "安装docker环境...安装完成!"
    case "$OSTYPE" in
        linux*)
            echo "当前操作系统是 Linux"
            # Debian/Ubuntu
            apt-get install yq

            # CentOS
            yum install yq
            # 或
            dnf install yq
        ;;
        darwin*)
            echo "当前操作系统是 MacOS"
            brew install yq
        ;;
        msys*|cygwin*)
            echo "当前操作系统是 Windows"
            # 安装chocolatey
            # https://github.com/mikefarah/yq/releases/download/v4.47.2/yq_windows_amd64.exe
            # https://github.com/jqlang/jq/releases/download/jq-1.8.1/jq-windows-amd64.exe
            @"%SystemRoot%\System32\WindowsPowerShell\v1.0\powershell.exe" -NoProfile -InputFormat None -ExecutionPolicy Bypass -Command "iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))" && SET "PATH=%PATH%;%ALLUSERSPROFILE%\chocolatey\bin"
            choco -v
            # 安装jq
            choco install jq
            chocolatey install jq
        ;;
        *)
            echo "未知操作系统: $OSTYPE"
        ;;
    esac
fi


