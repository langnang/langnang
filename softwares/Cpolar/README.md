# Cpolar

## 安装

### Linux 安装

**安装依赖**：确保系统已安装 curl。

```sh
sudo apt-get install curl # Ubuntu 系列
sudo yum install curl # CentOS 系列
```

**下载并安装** Cpolar：

```sh
curl -L https://www.cpolar.com/static/downloads/install-release-cpolar.sh | sudo bash
```

**验证安装**：运行以下命令查看版本号，显示版本号即表示安装成功。

```sh
cpolar version
```

**配置 Cpolar**

- **Token 认证**： 登录 Cpolar 官网 注册账号。 在“验证”页面获取认证 Token。 执行以下命令完成认证： cpolar authtoken <你的 Token>
- **设置为系统服务**：
  - 启用 Cpolar 开机自启动：`sudo systemctl enable cpolar`
  - 启动服务：`sudo systemctl start cpolar`
  - 检查服务状态：`sudo systemctl status cpolar`

### Windows 安装

**下载 cpolar**
cpolar 易于安装。下载具有零运行时依赖性的单个二进制文件。

- [Windows](https://www.cpolar.com/static/downloads/releases/3.3.18/cpolar-stable-windows-amd64-setup.zip?_gl=1*qoevdp*_ga*MTQ1MTgxNDkzMC4xNzQ0ODc2MjAz*_ga_WF16DPKZZ1*czE3NTc3NTMwMzEkbzMkZzEkdDE3NTc3NTUyNTckajUzJGwwJGgw)

**解压缩安装**
在 Linux 或 OSX 上，您可以使用以下命令从终端解压缩 cpolar。 在 Windows 上，只需双击 cpolar.zip 即可。

```
$ unzip /path/to/cpolar.zip
```

大多数人将 cpolar 保存在他们的用户文件夹中或设置别名以便于访问。

**连接您的帐户**
运行此命令会将您帐户的 authtoken 添加到您的 cpolar.yml 文件中。 这将为您提供更多功能，所有打开的隧道将在此处的仪表板中列出。

```
$ ./cpolar authtoken MDE4YTMwOWEtOTFhZS00MWQ3LTg4MGUtNTczZDBlYTk4NTc3
```

**燃烧起来,动起来**
阅读有关如何使用 cpolar 的文档。 通过从命令行运行它来尝试：

```
$ ./cpolar help
```

要在端口 80 上启动 HTTP 隧道，请运行以下命令：

$ ./cpolar http 80

## 议题
