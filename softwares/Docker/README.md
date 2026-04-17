# Docker

## 安装

### Install for Windows

```batch
# 迁移安装文件
move "C:\Program Files\Docker\*.*" "D:\Programs\Docker\"

# 创建符号链接
mklink /j "C:\Program Files\Docker" "D:\Programs\Docker"
```

1. 手动创建必要目录

在 D 盘创建以下目录：

```txt
C:\Program Files\Docker
C:\Users\%USERNAME%\AppData\Local\Docker
D:\Programs\Docker
D:\Programs\Docker\Data
确保目录名称与上述一致，否则可能导致安装失败。
```

2. 使用管理员权限安装

下载 Docker Desktop 安装程序后，打开命令提示符（以管理员身份运行），进入安装程序所在目录。例如：

运行以下命令进行安装：

```batch
cd D:\Downloads

curl -L "https://desktop.docker.com/win/main/amd64/Docker%20Desktop%20Installer.exe" -o "Docker Desktop Installer.exe"

@rem start /w "" "Docker Desktop Installer.exe" install -accept-license --installation-dir="D:\Programs\Docker" --wsl-default-data-root="D:\Programs\Docker\data" --windows-containers-default-data-root="D:\\Programs\\Docker"

start /w "" "Docker Desktop Installer.exe" install

docker version

docker run hello-world

@rem C:\Program Files\Docker
xcopy "C:\Program Files\Docker" "D:\Programs\Docker" /H /E /Y
rd "C:\Program Files\Docker" /S /Q
mklink /j "C:\Program Files\Docker" "D:\Programs\Docker"

@rem C:\Users\%USERNAME%\.docker
xcopy "C:\Users\%USERNAME%\.docker" "D:\Programs\Docker\.docker" /H /E /Y
rd "C:\Users\%USERNAME%\.docker" /S /Q
mklink /j "C:\Users\%USERNAME%\.docker" "D:\Programs\Docker\.docker"

@rem C:\Users\%USERNAME%\AppData\Local\Docker
xcopy "C:\Users\%USERNAME%\AppData\Local\Docker" "D:\Programs\Docker\AppData" /H /E /Y
rd "C:\Users\%USERNAME%\AppData\Local\Docker" /S /Q
mklink /j "C:\Users\%USERNAME%\AppData\Local\Docker" "D:\Programs\Docker\AppData"
```

3. 更新环境变量

如果安装完成后仍然报错，可能是环境变量未正确更新。使用 PowerShell 更新：

```ps1
$oldPath = [System.Environment]::GetEnvironmentVariable("Path", [System.EnvironmentVariableTarget]::Machine)
$newPath = $oldPath + ";D:\Programs\Docker\resources\bin"
[System.Environment]::SetEnvironmentVariable("Path", $newPath, [System.EnvironmentVariableTarget]::Machine)
```

完成后重启电脑。

4. 测试安装是否成功

在命令提示符中运行以下命令：

docker version
如果输出 Docker 版本信息，则说明安装成功。

5. 运行测试容器

验证 Docker 是否正常工作：

docker run hello-world

### Install for Linux(Ubuntu)

1. 卸载旧版本

首先，确保系统中没有旧版本的 Docker。

```shell
sudo apt-get remove docker docker-engine docker.io containerd runc
```

2.  更新软件包

更新系统的软件包索引。

```shell
sudo apt-get update
sudo apt-get upgrade
```

3.  安装依赖项

安装 Docker 所需的依赖项。

```shell
sudo apt-get install ca-certificates curl gnupg lsb-release
```

4.  添加 Docker 的 GPG 密钥

添加 Docker 的官方 GPG 密钥。

```shell
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
```

5.  设置 Docker 仓库

设置 Docker 的稳定版仓库。

```shell
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```

6.  安装 Docker 引擎

安装最新版本的 Docker 引擎和 containerd。

```shell
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-compose
```

7.  启动并验证 Docker 安装

启动 Docker 并验证是否安装成功。

```shell
sudo systemctl start docker
sudo docker run hello-world
```

如果看到 "Hello from Docker!" 的信息，则表示安装成功。

### Install for Linux(CentOS)

1. 卸载旧版本 Docker

如果系统中已安装旧版本的 Docker，请先卸载：

```shell
sudo yum remove docker \
docker-client \
docker-client-latest \
docker-common \
docker-latest \
docker-latest-logrotate \
docker-logrotate \
docker-engine
```

2. 安装依赖工具

安装 yum-utils 工具，用于管理软件包和配置仓库：

```shell
sudo yum install -y yum-utils
```

3. 添加 Docker 官方仓库

运行以下命令添加 Docker 的官方仓库：

```shell
sudo yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
```

4. 安装 Docker

使用以下命令安装 Docker：

```shell
sudo yum install -y docker-ce docker-ce-cli containerd.io
```

5. 启动并验证 Docker

启动 Docker 服务：

```shell
sudo systemctl start docker
```

验证是否成功运行：

```shell
sudo systemctl status docker
```

6. 设置开机自启

让 Docker 在系统启动时自动运行：

```shell
sudo systemctl enable docker
```

7. 测试安装

运行以下命令测试 Docker 是否正常工作：

```shell
sudo docker run hello-world
```

如果看到 "Hello from Docker!" 的欢迎信息，说明安装成功。

8. 配置镜像加速器（可选）

为提高国内拉取镜像的速度，可以配置阿里云镜像加速器：

创建配置文件目录：

```shell
sudo mkdir -p /etc/docker
```

编辑配置文件：

```shell
sudo tee /etc/docker/daemon.json <<-'EOF'
{
"registry-mirrors": ["https://<你的加速器地址>.mirror.aliyuncs.com"]
}
EOF
```

重启服务以应用配置：

```shell
sudo systemctl daemon-reload
sudo systemctl restart docker
```

通过以上步骤，您已成功在 CentOS 系统上安装并配置了 Docker。Docker 的强大功能将极大提升您的开发和部署效率！

### 中文化

```batch

```

## 关闭 Docker

```sh
# 禁用 docker 开机自启
systemctl disable docker
# 关停 docker 服务
systemctl stop docker
```

### Docker 网络模式：

Bridge 模式：默认的网络模式，容器通过虚拟网络桥进行通信。
Host 模式：容器与宿主机共享网络命名空间。
None 模式：禁用所有网络功能。
Overlay 模式：用于跨多个 Docker 主机的容器通信。
Macvlan 模式：每个容器拥有独立的 MAC 地址和 IP 地址。

### 端口映射：

通过将宿主机的端口映射到容器内的端口，实现外部网络对容器内服务的访问。

### 容器互联：

通过容器名称建立网络通信隧道，使容器之间可以相互通信。

### 容器访问宿主机数据库

- host:host.docker.internal

## FAQ 常见问题

- `This can prevent Docker from starting. Use at your own risk.`
- `connect ENOENT \\.\pipe\dockerBackendApiServer`
- `Docker Engine Stopped`
- `Extensions Failed to fetch extensions.`
- `An unexpected error occurred. Restart Docker Desktop.`
- `Docker Desktop distro installation failed`
- `WARNING: daemon is not using the default seccomp pro`
- `Error response from daemon: Get "https://registry-1.docker.io/v2/": net/http: request canceled while waiting for connection (Client.Timeout exceeded while awaiting headers)`

### `permission denied while trying to connect to the Docker daemon socket`

1. 切换到 root 用户

最直接的方法是切换到 root 用户来执行 Docker 命令。

```sh
su root
```

输入 root 用户的密码后，你可以正常操作 Docker 命令。

2. 将当前用户添加到 Docker 用户组

另一种方法是将当前用户添加到 Docker 用户组，这样就不需要每次都使用 sudo。

```sh
# 如果 docker 用户组不存在，创建它
sudo groupadd docker
# 将当前用户添加到 docker 用户组
sudo gpasswd -a $USER docker
sudo usermod -aG docker $USER
# 更新用户组
newgrp docker
```

### Docker 连接宿主机

IP: host.docker.internal

### DOcker 连接宿主机局域网内机器
