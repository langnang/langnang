# 下载并解压 GoTTY 安装包
$ wget https://github.com/yudai/gotty/releases/download/v1.0.1/gotty_linux_amd64.tar.gz
$ tar -xzvf gotty_linux_amd64.tar.gz

# 复制可执行文件到指定目录并赋予执行权限
$ sudo cp gotty /usr/local/bin/
$ chmod +x /usr/local/bin/gotty

# 安装完成后，检查一下 Gotty 的版本，以验证是否安装正确。
$ gotty -version
#* gotty version 1.0.1
