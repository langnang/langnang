---
created: 2024-07-04T10:29:04 (UTC +08:00)
tags: [laravel,laravel论坛,laravel社区,laravel教程,laravel视频,laravel开源,laravel新手,laravel5]
source: https://learnku.com/docs/laravel/8.x/installation/9354
author: Summer
title: 安装（Installation）
---

## 安装

### 服务器要求

Laravel 框架对系统有一些要求。所有这些要求 [Laravel Homestead](https://learnku.com/docs/laravel/8.x/homestead) 虚拟机都能满足，因此强烈推荐你使用 Homestead 做为你的本地 Laravel 开发环境。

当然，如果你不使用 Homestead，请确保你的服务器满足以下要求：

- PHP >= 7.3
- BCMath PHP 拓展
- Ctype PHP 拓展
- Fileinfo PHP 拓展
- JSON PHP 拓展
- Mbstring PHP 拓展
- OpenSSL PHP 拓展
- PDO PHP 拓展
- Tokenizer PHP 拓展
- XML PHP 拓展

### 安装 Laravel

Laravel 使用 [Composer](https://getcomposer.org/) 来管理项目依赖。因此，在使用 Laravel 之前，请确保您的机器上已经安装了 Composer。

#### 通过 Laravel 安装器

首先，使用 Composer 安装 Laravel 安装器：

```php
composer global require laravel/installer
```

确保将 Composer 的全局 vendor bin 目录放置在你的系统环境变量 `$PATH` 中，以便系统可以找到 Laravel 的可执行文件。在不同的操作系统中，该目录的路径也不相同；下面列出一些常见的位置：

- macOS: `$HOME/.composer/vendor/bin`
- Windows: `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`
- GNU / Linux 发行版: `$HOME/.config/composer/vendor/bin` 或者 `$HOME/.composer/vendor/bin`

您也可以通过运行 `composer global about` 命令查找并查看 Composer 的全局安装路径。

安装完成后，`laravel new` 命令会在你指定的目录创建一个全新的 Laravel 项目。例如 `laravel new blog` 将会创建一个名为 `blog` 的目录，并已安装好 Laravel 所有的依赖项:

#### 通过 Composer 创建项目

或者，你也可以在终端中运行 `create-project` 命令来安装 Laravel：

```php
composer create-project --prefer-dist laravel/laravel blog
// 安装指定版本
composer create-project --prefer-dist laravel/laravel blog 8.*
```

#### 本地开发环境

如果你在本地安装了 PHP，并且你想使用 PHP 内置的服务器来为你的应用程序提供服务，则可以使用 Artisan 命令 `serve`。该命令会在 `http://localhost:8000` 上启动开发服务器：

你也可以通过 [Homestead](https://learnku.com/docs/laravel/8.x/homestead) 和 [Valet](https://learnku.com/docs/laravel/8.x/valet) 获得更加强大的本地开发能力。

### 配置

#### 公共目录

安装完 Laravel 之后，你必须将 web 服务器根目录指向 `public` 目录。该目录下的 `index.php` 文件将作为所有进入应用程序的 HTTP 请求的前端控制器。

#### 配置文件

Laravel 框架的所有配置文件都放在 `config` 目录中。每个选项都有注释，方便你随时查看文件并熟悉可用的选项。

#### 目录权限

安装完 Laravel 后，你可能需要给这两个文件配置读写权限：`storage` 目录和 `bootstrap/cache` 目录应该允许 Web 服务器写入，否则 Laravel 程序将无法运行。如果你使用的是 [Homestead](https://learnku.com/docs/laravel/8.x/homestead) 虚拟机，这些权限已经为你配置好了。

#### 应用密钥

安装好 Laravel 之后，下一件应该做的事就是将应用程序的密钥设置为随机字符串。如果你是通过 Composer 或 Laravel 安装器来安装的 Laravel，那这个密钥已经为你通过 `php artisan key:generate` 命令设置好了。

通常来说，这个字符串的长度应为 32 个字符。密钥可以在 `.env` 环境配置文件中设置。前提是你已经把 `.env.example` 文件重命名为 `.env`。**如果没有设置好应用密钥，你的用户会话和其他加密数据就不再安全！**

#### 其他配置

除了以上的配置，Laravel 几乎就不需要再额外配置些什么了。你随时就能开始开发！但是，可能的话，还是希望你查看 `config/app.php` 文件及其注释。其中包含了几个你可能想要根据你的应用来更改的选项，比如 `timezone` 和 `locale`。

你还可能想要配置 Laravel 的其他几个组件，例如：

## Web 服务器配置

### 目录配置

Laravel 应该始终在您的 Web 服务器配置的「Web 目录」的根目录之外使用。您不应该尝试在「Web 目录」的子目录中使用 Laravel 应用程序。尝试这样做可能会暴露应用程序中存在的敏感文件。

### 优雅链接

#### Apache

Laravel 中包含了一个 `public/.htaccess` 文件，通常用于在资源路径中隐藏 `index.php` 的前端控制器。在用 Apache 为 Laravel 提供服务之前，确保启用了 `mod_rewrite` 模块，这样 `.htaccess` 文件才能被服务器解析。

如果 Laravel 附带的 `.htaccess` 文件不起作用，尝试下面的方法替代：

```php
Options +FollowSymLinks -Indexes RewriteEngine On RewriteCond %{HTTP:Authorization} . RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}] RewriteCond %{REQUEST_FILENAME} !-d RewriteCond %{REQUEST_FILENAME} !-f RewriteRule ^ index.php [L]
```

#### Nginx

如果你使用 Nginx ，在你的站点配置中加入以下配置，所有的请求将会引导至 `index.php` 前端控制器：

```php
location / { try_files $uri $uri/ /index.php?$query_string; }
```

当你使用 [Homestead](https://learnku.com/docs/laravel/8.x/homestead) 或 [Valet](https://learnku.com/docs/laravel/8.x/valet) 时，优雅链接将会自动配置好。

> 本译文仅用于学习和交流目的，转载请务必注明文章译者、出处、和本文链接  
> 我们的翻译工作遵照 [CC 协议](https://learnku.com/docs/guide/cc4.0/6589)，如果我们的工作有侵犯到您的权益，请及时联系我们。

___

> 原文地址：[https://learnku.com/docs/laravel/8.x/ins...](https://learnku.com/docs/laravel/8.x/installation/9354)
>
> 译文地址：[https://learnku.com/docs/laravel/8.x/ins...](https://learnku.com/docs/laravel/8.x/installation/9354)
