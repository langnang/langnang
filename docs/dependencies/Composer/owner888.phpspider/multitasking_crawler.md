---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/multitasking_crawler.html
author: seatle
---

# 如何实现多任务爬虫？ · phpspider 开发文档

> ## Excerpt
>
> 天下爬虫，唯快不破，配合多进程使用，phpspider 可以快到你怕，下面我们来看看如何实现一个多任爬虫.

---

## 如何实现多任务爬虫？

天下爬虫，唯快不破，配合多进程使用，phpspider 可以快到你怕，下面我们来看看如何实现一个多任爬虫.

举个栗子：  
同时开启 8 个任务

```
$configs = array(
    'name' => '糗事百科测试样例',
    'tasknum' => 8,   // 爬虫任务数
    ...
);
$spider = new phpspider($configs);
$spider->start();
```

运行界面：  
![](https://doc.phpspider.org/development_skills/pachong.gif)
