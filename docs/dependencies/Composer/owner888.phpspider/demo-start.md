---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/demo-start.html
author: seatle
---

# 第一个 demo · phpspider 开发文档

> ## Excerpt
>
> 爬虫采用 PHP 编写, 下面以糗事百科为例, 来看一下我们的爬虫长什么样子:

---

爬虫采用 PHP 编写, 下面以糗事百科为例, 来看一下我们的爬虫长什么样子:

### 安装

#### 1、通过 GitHub 下载

```
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
```

#### 2、通过 composer 下载

```
composer require owner888/phpspider
```

```
require './vendor/autoload.php';
use phpspider\core\phpspider;
```

#### 3、加上一段很讨厌的注释，别问我为什么，我就是这么讨厌 ^\_^

```
/* Do NOT delete this comment */
/* 不要删除这段注释 */
```

```
$configs = array(
    'name' => '糗事百科',
    'domains' => array(
        'qiushibaike.com',
        'www.qiushibaike.com'
    ),
    'scan_urls' => array(
        'http://www.qiushibaike.com/'
    ),
    'content_url_regexes' => array(
        "http://www.qiushibaike.com/article/\d+"
    ),
    'list_url_regexes' => array(
        "http://www.qiushibaike.com/8hr/page/\d+\?s=\d+"
    ),
    'fields' => array(
        array(
            // 抽取内容页的文章内容
            'name' => "article_content",
            'selector' => "//*[@id='single-next-link']",
            'required' => true
        ),
        array(
            // 抽取内容页的文章作者
            'name' => "article_author",
            'selector' => "//div[contains(@class,'author')]//h2",
            'required' => true
        ),
    ),
);
$spider = new phpspider($configs);
$spider->start();
```

爬虫的整体框架就是这样, 首先定义了一个$configs数组, 里面设置了待爬网站的一些信息, 然后通过调用`$spider = new phpspider($configs);`和`$spider->start();`来配置并启动爬虫.

#### 运行界面如下:

![](https://doc.phpspider.org/pachong.gif)

$configs 对象如何定义, 后面会作详细介绍.^\_^
