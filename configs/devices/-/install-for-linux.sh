#!/bin/bash

user_name=""
password=""
device_addr=""


#! dministrator 未出现在 sudoers 文件中
# su root
# bash: usermod: 未找到命令
# sudo usermod -aG sudo dministrator

# Cpolar  
# Cpolar 安装 
# bash: curl: 未找到命令
# sudo apt install curl         [On Debian, Ubuntu and Mint]
# sudo yum install curl         [On RHEL/CentOS/Fedora and Rocky/AlmaLinux]
# sudo emerge -a sys-apps/curl  [On Gentoo Linux]
# sudo apk add curl             [On Alpine Linux]
# sudo pacman -S curl           [On Arch Linux]
# sudo zypper install curl      [On OpenSUSE]    
# sudo pkg install curl         [On FreeBSD]
feat_cpolar(){
    curl -L https://www.cpolar.com/static/downloads/install-release-cpolar.sh | sudo bash

    cpolar version

    # 设置开机自启
    sudo systemctl enable cpolar

    # 启动服务
    sudo systemctl start cpolar

    # 查看服务状态
    sudo systemctl status cpolar
}

## Docker 
feat_docker(){
    do_install(){}
    do_uninstall(){}
}
## Docker 安装&配置

# 卸载旧版本
# 如果你之前安装过 Docker Engine 之前，你需要卸载旧版本，避免冲突：

for pkg in docker.io docker-doc docker-compose podman-docker containerd runc; do sudo apt-get remove $pkg; done
# 使用官方安装脚本自动安装

curl -fsSL https://get.docker.com -o get-docker.sh
curl -fsSL https://get.docker.com | bash -s docker --mirror Aliyun
#! curl: (35) OpenSSL SSL_connect: SSL_ERROR_SYSCALL in connection to get.docker.com:443 
#! curl: (35) Recv failure: Connection reset by peer
# [CentOS] sudo yum update openssl
sudo sh get-docker.sh -s docker --mirror Aliyun

#! permission denied while trying to connect to the docker API at unix:///var/run/docker.sock

#! permission denied while trying to connect to the Docker daemon socket at unix:///var/run/docker.sock: Get "http://%2Fvar%2Frun%2Fdocker.sock/v1.51/containers/json": dial unix /var/run/docker.sock: connect: permission denied
# ssh $user_name@$device_addr "grep docker /etc/group; sudo usermod -aG docker \$USER ;"
grep docker /etc/group 
sudo usermod -aG docker $USER 
newgrp docker

# 启动并验证 Docker
# 启动 Docker 并设置为开机自启：
sudo systemctl start docker
sudo systemctl enable docker
#! Failed to start docker.service: Unit docker.service not found.
#* sudo apt update
#* sudo apt install docker.io
# 你可以使用以下命令来验证 Docker 是否安装成功：
sudo docker --version

# 安装 Docker Compose

sudo apt-get install docker-compose-plugin
#! E: Unable to locate package docker-compose-plugin
# 1. 更新软件包索引
#? sudo apt-get update
# 2. 安装 Docker Compose 插件
#? sudo apt-get install -y ca-certificates curl gnupg
#? sudo install -m 0755 -d /etc/apt/keyrings
#? curl -fsSL https://mirrors.aliyun.com/docker-ce/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
#? echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://mirrors.aliyun.com/docker-ce/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
#? sudo chmod a+r /etc/apt/keyrings/docker.gpg 
# 更新软件包列表并安装插件：
#? sudo apt-get update
#? sudo apt-get install -y docker-compose-plugin

#! Fedora
DOCKER_CONFIG=${DOCKER_CONFIG:-$HOME/.docker}
mkdir -p $DOCKER_CONFIG/cli-plugins
curl -SL https://github.com/docker/compose/releases/download/{{% param "compose_version" %}}/docker-compose-linux-x86_64 -o $DOCKER_CONFIG/cli-plugins/docker-compose


# 安装 Docker-Compose
# 下载二进制文件
# 从 GitHub 下载最新版 Docker Compose 的二进制文件：
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
# 国内加速下载（解决 GitHub 访问慢的问题）：
# 使用 ghproxy 代理
sudo curl -L "https://ghproxy.com/https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
# 赋予执行权限
sudo chmod +x /usr/local/bin/docker-compose
# （可选）创建符号链接、
# 将二进制文件链接到 /usr/bin 目录，方便全局调用：
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
# 验证安装
docker-compose --version
# 成功安装会显示版本号，例如：Docker Compose version v2.27.0 313732。

#! docker: Error response from daemon: Get "https://registry-1.docker.io/v2/": context deadline exceeded
echo -e "{\n\t\"registry-mirrors\": [\"https://docker.1ms.run\", \"https://docker.xuanyuan.me\", \"https://dislabaiot.xyz\", \"https://docker.sunzishaokao.com\", \"https://hub.rat.dev\", \"https://doublezonline.cloud\", \"https://dislabaiot.xyz\", \"https://docker.m.daocloud.io\", \"https://docker.1panel.live\", \"https://hub.rat.dev\", \"http://docker.m.daocloud.io\", \"http://docker.imgdb.de\", \"http://docker.hlmirror.com\", \"http://lispy.org\", \"https://docker.m.daocloud.io\", \"https://docker.1panel.live\", \"http://mirrors.ustc.edu.cn\", \"https://hub.rat.dev\", \"https://cr.console.aliyun.com\"]\n}" > /etc/docker/daemon.json
# 重载生效
sudo systemctl daemon-reload
# 重启服务
sudo systemctl restart docker
# 查看是否配置成功
docker info
# 运行以下测试命令确保 Docker 正常工作：
sudo docker run --name hello-world hello-world

docker ps

#! Job for docker.service failed because the control process exited with error code.
#! See "systemctl status docker.service" and "journalctl -xeu docker.service" for details.

# 卸载 docker
# 删除安装包：
sudo apt-get purge docker-ce
# 删除镜像、容器、配置文件等内容：
sudo rm -rf /var/lib/docker

# Linux修改主机名

# 方法 1：使用 hostnamectl 命令

# 查看当前主机名

hostname

hostnamectl
# 设置新主机名 使用以下命令替换为新的主机名：

sudo hostnamectl set-hostname 新主机名
# 验证更改 再次运行 hostnamectl 查看更新后的主机名。


# ** WARNING: connection is not using a post-quantum key exchange algorithm.
# ** This session may be vulnerable to "store now, decrypt later" attacks.
# ** The server may need to be upgraded. See https://openssh.com/pq.html


#! docker: failed to decode referrers index: invalid character '<' looking for beginning of value