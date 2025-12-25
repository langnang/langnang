---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/
author: seatle
---

# 概述 · phpspider 开发文档

> ## Excerpt
>
> 《我用爬虫一天时间“偷了”知乎一百万用户，只为证明 PHP 是世界上最好的语言 》所使用的程序框架

---

## PHP 蜘蛛爬虫开发文档

《我用爬虫一天时间“偷了”知乎一百万用户，只为证明 PHP 是世界上最好的语言 》所使用的程序框架

编写 PHP 网络爬虫, 需要具备以下技能:

- 爬虫采用 PHP 编写
- 从网页中抽取数据需要用 XPath ( [XPath 选择器教程](http://www.w3school.com.cn/xpath/index.asp) )
- 当然我们还可以使用 CSS 选择器 ( [CSS 选择器教程](http://www.w3school.com.cn/cssref/css_selectors.asp) )
- 很多情况下都会用到正则表达式 ( [正则表达式教程](https://www.w3cschool.cn/regexp/) )
- Chrome 的开发者工具是神器, 很多 AJAX 请求需要用它来分析

**注意：本框架只能在命令行下运行，命令行、命令行、命令行，重要的事情说三遍 ^\_^**

- [第一个 demo](./demo-start.md)
- [configs 详解——之成员](./configs-members.md)
- [configs 详解——之 field](./configs-field.md)
- [configs 详解——之 requests](./requests.md)
- [configs 详解——之 selector](./selector.md)
- [configs 详解——之 db](./db.md)
<!-- - [configs 详解——之 log](./) -->
- [爬虫进阶开发——之内置方法](./methods.md)
- [爬虫进阶开发——之回调函数](./callback.md)
- [爬虫进阶开发——xpath 选择器常见用法](./xpath.md)
- [爬虫进阶开发——之技巧篇](./development_skills.md)
  - [如何进行运行前测试？](./quick_test.md)
  - [如何实现模拟登录？](./simulateLanding.md)
  - [如何实现增量采集？](./incremental_collection.md)
  - [如果内容页有分页，该如何爬取到完整数据？](./crawl-all-contents.md)
  - [如何实现多任务爬虫？](./multitasking_crawler.md)
  - [如何实现多服务器集群爬虫？](./crawler_cluster.md)
  - [file_get_contents 设置代理抓取页面](./file_get_contents-proxy.md)
  - [如何提前生成列表页 URL 再提取内容？](./custom_rules_list_page.md)
  - [如何去掉网页中的广告?](./remove_ads.md)
  - [如何爬取列表页中的数据?](./url_context.md)
  - [开发 PHPSpider 爬虫的常用工具](./developer_tools.md)
