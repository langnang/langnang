---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/custom_rules_list_page.html
author: seatle
---

# 如何提前生成列表页 URL 再提取内容？ · phpspider 开发文档

> ## Excerpt
>
> 通常情况下，爬虫会从起始页(scan_urls)开始通过列表页规则(list_url_regexes)寻找列表页，内容页同理，但是很多时候，第三方网站为了防止采集，会采用 ajax 的方式，不把列表页直接显式放在页面内容，而是通过 js 生成，又或者是直接显示前 10 页，因为正常的用户也只需要浏览前 10 页的数据就够了，现在我们针对这两种方式来看看抓取方法

---

> 通常情况下，爬虫会从起始页(scan_urls)开始通过列表页规则(list_url_regexes)寻找列表页，内容页同理，但是很多时候，第三方网站为了防止采集，会采用 ajax 的方式，不把列表页直接显式放在页面内容，而是通过 js 生成，又或者是直接显示前 10 页，因为正常的用户也只需要浏览前 10 页的数据就够了，现在我们针对这两种方式来看看抓取方法

只显示前 10 页的网页我们可以先生成列表页 URL 入队列

```
$configs = array(
    // configs的其他成员
    ...
    'scan_urls' => array(
        'https://www.itjuzi.com/investfirm?user_id=305129'
    ),
    'list_url_regexes' => array(
        "https://www.itjuzi.com/investfirm\?user_id=305129&page=\d+"
    ),
    ...
);

$spider->on_start = function ($spider)
{
    // 生成列表页URL入队列
    for ($i = 0; $i <= 652; $i++)
    {
        $url = "https://www.itjuzi.com/investfirm?user_id=305129&page={$i}";
        $spider->add_url($url);
    }
};
```
