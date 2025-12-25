---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/incremental_collection.html
author: seatle
---

# 如何实现增量采集？ · phpspider 开发文档

> ## Excerpt
>
> 默认情况下，入口 URL、列表 URL 和内容 URL 这所有的 URL 都有去重机制，就会对增量采集造成一定的麻烦。框架开放了 add_scan_url() 接口，让用户可以在一次完整采集过后，添加新的入口 URL(比如之前的入口 URL、最新列表 URL)来进行增量采集。通过 add_scan_url() 方法添加的 URL，不会被框架去重，从而达到增量采集的效果。。。

---

## 如何实现增量采集？

> 默认情况下，入口 URL、列表 URL 和内容 URL 这所有的 URL 都有去重机制，就会对增量采集造成一定的麻烦。  
> 框架开放了 add_scan_url() 接口，让用户可以在一次完整采集过后，添加新的入口 URL(比如之前的入口 URL、最新列表 URL)来进行增量采集。  
> 通过 add_scan_url() 方法添加的 URL，不会被框架去重，从而达到增量采集的效果。。。

举个栗子:  
我已经把糗事百科一次性采集完了，而糗百的内容更新都在首页，所以我可以在一次完整采集以后，把首页加入增量采集

```
$spider->on_start = function($phpspider)
{
    // add_sacn_url 没有URL去重机制，可用作增量更新
    $phpspider->add_scan_url("http://www.qiushibaike.com/");
};
```
