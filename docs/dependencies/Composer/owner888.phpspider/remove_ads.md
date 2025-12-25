---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/remove_ads.html
author: seatle
---

# 如何去掉网页中的广告? · phpspider 开发文档

> ## Excerpt
>
> 当成功爬取到的网页数据中有很多不相干的 html 广告标签时, 你是否会感到无可奈何, 有时候即使将 XPath 的效果发挥到极致, 也无法去掉顽固的 html 广告标签, 咋整呢?

---

## 如何去掉网页中的广告?

> 当成功爬取到的网页数据中有很多不相干的 html 广告标签时, 你是否会感到无可奈何, 有时候即使将 XPath 的效果发挥到极致, 也无法去掉顽固的 html 广告标签, 咋整呢?

本节给你介绍通过 selector 类的 remove 方法去除 html 广告标签, 可提取有用数据或清理无用数据.

举个栗子:

在爬取某论坛问答帖时, 发现有很多 html 广告标签以及一些无用数据, 就需要在 on_extract_field 回调函数中调用 selector 的 remove 方法了

```
$configs = array(
    // configs的其他成员
    ...
    'fields' => array(
        array(
            'name' => "question_detail",
            'selector' => "XXX",
        ),
    ),
);
$spider->on_extract_field = function($fieldname, $data, $page)
{
    if ($fieldname == 'question_detail')
    {
        // 将data中符合XPath: "//div[contains(@class,'a_pr')]"的数据去掉
        $data = selector::remove($data, "//div[contains(@class,'a_pr')]");
        return $data;
    }
};
```

有时, 如果无用数据太多, 最好调用 selector 的 select 方法直接将有用的数据提取出来, 这么做会比调用 remove 方法更加方便.
