---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/crawl-all-contents.html
author: seatle
---

# 如果内容页有分页，该如何爬取到完整数据？ · phpspider 开发文档

> ## Excerpt
>
> 如果要爬取的某个内容页中有多个分页，该如何爬取这个内容页的完整数据呢？这里就无法使用 on_list_page 回调函数了，而需要使用 field 中的 attached_url 来请求其他分页的数据。

---

## 如果内容页有分页，该如何爬取到完整数据？

> 如果要爬取的某个内容页中有多个分页，该如何爬取这个内容页的完整数据呢？这里就无法使用`on_list_page`回调函数了，而需要使用`field`中的`attached_url`来请求其他分页的数据。

举个栗子:  
爬取某网站文章时，发现有些文章有多个内容页面，处理过程如下：

```
$configs = array(
    // configs 的其他成员
    ...
    'fields' => array(
        array(
            'name' => "contents",
            'selector' => "//div[@id='pages']//a//@href",
            'repeated' => true,
            'children' => array(
                array(
                    // 抽取出其他分页的url待用
                    'name' => 'content_page_url',
                    'selector' => "//text()"
                ),
                array(
                    // 抽取其他分页的内容
                    'name' => 'page_content',
                    // 发送 attached_url 请求获取其他的分页数据
                    // attached_url 使用了上面抓取的 content_page_url
                    'source_type' => 'attached_url',
                    'attached_url' => 'content_page_url',
                    'selector' => "//*[@id='big-pic']"
                ),
            ),
        ),
    ),
);
```

在爬取到所有的分页数据之后，可以在`on_extract_page`回调函数中将这些数据组合成完整的数据

```
$spider->on_extract_field = function($fieldname, $data, $page)
{
    if ($fieldname == 'contents')
    {
        if (!empty($data))
        {
            $contents = $data;
            $data = "";
            foreach ($contents as $content)
            {
                $data .= $content['page_content'];
            }
        }
    }
    return $data;
};
```
