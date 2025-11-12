!/bin/bash

echo "检查 yq ......"
yq --version
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
            # https://github.com/mikefarah/yq/releases/download/v4.47.2/yq_windows_amd64.exe
            
            yq_url="https://ghproxy.com/https://github.com/mikefarah/yq/releases/download/v4.47.2/yq_windows_amd64.exe"
            curl -L https://gh-proxy.com/https://github.com/mikefarah/yq/releases/download/v4.47.2/yq_windows_amd64.exe -o yq.exe

            # mkdir D:\\Programs\\bin

            rm D:\\Programs\\Git\\cmd\\yq.exe
            mv yq.exe D:\\Programs\\Git\\cmd\\yq.exe
            # $env:Path += ";D:\Programs\bin"
            # command cmd /c "set PATH=%PATH%;D:\Programs\bin"
            # ShellExecute(NULL, "open", "cmd", "set PATH=%PATH%;D:\Programs\bin", NULL, SW_HIDE);
            # ShellExecute(NULL, "open", "cmd", "set PATH=%PATH%;D:\Programs\bin");
        ;;
        *)
            echo "未知操作系统: $OSTYPE"
        ;;
    esac
fi


