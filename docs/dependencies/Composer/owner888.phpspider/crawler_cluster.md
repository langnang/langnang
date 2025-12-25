---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/crawler_cluster.html
author: seatle
---

# 如何实现多服务器集群爬虫？ · phpspider 开发文档

> ## Excerpt
>
> 很多时候，单机器爬取的效率并不高，对于京东、淘宝这种动则上千万页面的网站，真的会爬到天荒地老，如何快速爬取成了当今爬虫最难的课题，要说破解防盗页面以及内容正则匹配提取，真的是特别的小儿科。现在 PHPSpider 框架自带了集群功能，可以让初学者很轻易的在多台机器上运行同一分代码实现多机器爬取。

---

## 如何实现多服务器集群爬虫？

> 很多时候，单机器爬取的效率并不高，对于京东、淘宝这种动则上千万页面的网站，真的会爬到天荒地老，如何快速爬取成了当今爬虫最难的课题，要说破解防盗页面以及内容正则匹配提取，真的是特别的小儿科。  
> 现在 PHPSpider 框架自带了集群功能，可以让初学者很轻易的在多台机器上运行同一分代码实现多机器爬取。

下面我们看看运行多任务爬虫所需要的代码

```
$configs = array(
    'name' => '糗事百科测试样例',
    'multiserver' => true,  // 是否启动集群爬虫
    'serverid' => 1,        // 集群服务器ID
    ...
);
$spider = new phpspider($configs);
$spider->start();
```

运行界面：  
![](https://doc.phpspider.org/development_skills/pachong_false.gif)
