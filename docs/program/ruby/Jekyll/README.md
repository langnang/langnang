# jekyll

## 开始

---
source: http://jekyllcn.com/docs/home/
author
---

### 欢迎

该站点的目标是成为 Jekyll 的全面指南。包括一些内容如：搭建和运行你的站点、创建以及管理内容、定制站点的展现和外观、在不同的环境中发布、以及参与到 Jekyll 将来的开发的一些建议。

#### Jekyll 究竟是什么？[Permalink](http://jekyllcn.com/docs/home/#jekyll-%E7%A9%B6%E7%AB%9F%E6%98%AF%E4%BB%80%E4%B9%88 "Permalink")

Jekyll 是一个简单的博客形态的静态站点生产机器。它有一个模版目录，其中包含原始文本格式的文档，通过一个转换器（如 [Markdown](http://daringfireball.net/projects/markdown/)）和我们的 [Liquid](https://github.com/Shopify/liquid/wiki) 渲染器转化成一个完整的可发布的静态网站，你可以发布在任何你喜爱的服务器上。Jekyll 也可以运行在 [GitHub Page](http://pages.github.com/) 上，也就是说，你可以使用 GitHub 的服务来搭建你的项目页面、博客或者网站，而且是**完全免费**的。

---
source: http://jekyllcn.com/docs/quickstart/
author: 
---

### 快速指南

以下是一个获取最简单 Jekyll 模板并生成静态页面并运行的例子。

```bash
~ $ gem install jekyll 
~ $ jekyll new myblog 
~ $ cd myblog 
~/myblog $ jekyll serve 
# => Now browse to http://localhost:4000
```

如果你希望把 jekyll 安装到当前目录，你可以运行 `jekyll new .` 来代替。如果当前目录非空，你还需要增添 `--force` 参数，所以命令应为 `jekyll new . --force`。

就是这么简单。从现在开始，你可以通过创建文章、改变头信息来控制模板和输出、修改 Jekyll 设置来使你的站点变得更有趣～

安装过程中有问题？去看看[安装](http://jekyllcn.com/docs/installation/)页面。

---
source: http://jekyllcn.com/docs/installation/
author: 
---

### 安装

安装完成 Jekyll 需要几分钟的时间。如果你觉得安装对你来说并不方便, 请 [file an issue](https://github.com/jekyll/jekyll/issues/new) (或者提交一个 pull request) 来描述一下你的遭遇并告诉我们如何使这个安装过程更加便捷。

#### 事先准备[Permalink](http://jekyllcn.com/docs/installation/#%E4%BA%8B%E5%85%88%E5%87%86%E5%A4%87 "Permalink")

安装 Jekyll 相当简单，但是你得先做好一些准备工作。开始前你需要确保你在系统里已经有如下配置。

-   [Ruby](http://www.ruby-lang.org/en/downloads/)（including development headers, Jekyll 2 需要 v1.9.3 及以上版本，Jekyll 3 需要 v2 及以上版本）
-   [RubyGems](http://rubygems.org/pages/download)
-   Linux, Un ix, or Mac OS X
-   [NodeJS](http://nodejs.org/), 或其他 JavaScript 运行环境（Jekyll 2 或更早版本需要 CoffeeScript 支持）。
-   [Python 2.7](https://www.python.org/downloads/)（Jekyll 2 或更早版本）

##### 在 Windows 下使用 Jekyll

虽然官方不建议在 Windows 下运行，但你可以看看这个文档： [Windows 环境文档](http://jekyllcn.com/docs/windows/#installation)

### 用 RubyGems 安装 Jekyll[Permalink](http://jekyllcn.com/docs/installation/#%E7%94%A8-rubygems-%E5%AE%89%E8%A3%85-jekyll "Permalink")

安装 Jekyll 的最好方式就是使用 [RubyGems](http://rubygems.org/pages/download). 你只需要打开终端输入以下命令就可以安装了：

```bash
$ gem install jekyll
```

所有的 Jekyll 的 gem 依赖包都会被自动安装，所以你完全不用去担心。如果你在安装中碰到了问题，请查看 [troubleshooting](http://jekyllcn.com/docs/troubleshooting/) 或者 [report an issue](https://github.com/jekyll/jekyll/issues/new) 那么 Jekyll 社区就会帮助你解决问题了。

##### 安装 Xcode Command-Line Tools

如果你是Mac用户，你就需要安装 Xcode 和 Command-Line Tools了。下载方式： `Preferences → Downloads → Components`。

### 安装预览版[Permalink](http://jekyllcn.com/docs/installation/#%E5%AE%89%E8%A3%85%E9%A2%84%E8%A7%88%E7%89%88 "Permalink")

要安装 Jekyll 预览版，需要在完成事先准备之后运行：

```bash
gem install jekyll --pre
```

这将会安装最新版本的 Jekyll。如果你想安装指定版本，只需要加上 `-v` 参数即可：

```bash
gem install jekyll -v '2.0.0.alpha.1'
```

如果你想安装 Jekyll 开发版，那就有点复杂。你将会拥有最新的特性，但是也不稳定，安装方式如下：

```bash
$ git clone git://github.com/jekyll/jekyll.git $ cd jekyll $ script/bootstrap $ bundle exec rake build $ ls pkg/*.gem | head -n 1 | xargs gem install -l
```

### 附加功能[Permalink](http://jekyllcn.com/docs/installation/#%E9%99%84%E5%8A%A0%E5%8A%9F%E8%83%BD "Permalink")

根据每个人使用方式的不同，Jekyll 还支持你安装一些附加功能。包括了对 LaTeX 的支持，以及使用动态内容渲染引擎。查看 [the extras page](http://jekyllcn.com/docs/extras/) 获得更多信息。

##### ProTip™: 允许代码高亮

如果你是一个使用 Jekyll 的程序员，用 [Pygments](http://pygments.org/) 或者 [Rouge](https://github.com/jayferd/rouge) 来支持代码高亮吧。当然，使用前请先查看 [文档](http://jekyllcn.com/docs/templates/#code_snippet_highlighting)。

### 已经安装老版本Jekyll？[Permalink](http://jekyllcn.com/docs/installation/#%E5%B7%B2%E7%BB%8F%E5%AE%89%E8%A3%85%E8%80%81%E7%89%88%E6%9C%ACjekyll "Permalink")

在使用Jekyll开发之前，你可能想要检查一下你的Jekyll是不是最新版本，想要查看你的Jekyll版本，执行下面命令之一：

```bash
$ jekyll --version $ gem list jekyll
```

你可以在[RubyGem](https://rubygems.org/gems/jekyll)找到任何gem软件包的最新版本，同时也可以通过`gem`命令行工具来查看：

```bash
$ gem search jekyll --remote
```

这样你会查到名为`jekyll`的gem包，并且在方括号中显示最新版本。另一个检查本机是否是最新版本的办法是执行命令`gem outdated`， 它会显示出当前系统中所有需要更新的gem包列表，如果你的jekyll不是最新版本，执行命令：

```bash
$ gem update jekyll
```

哦耶～你已经安装了所有需要的东西了，开始玩转 Jekyll 吧！
