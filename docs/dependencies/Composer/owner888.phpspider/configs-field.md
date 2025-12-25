---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/configs-field.html
author: seatle
---

# configs 详解——之 field · phpspider 开发文档

> ## Excerpt
>
> field 定义一个抽取项, 一个 field 可以定义下面这些东西

---

`field`定义一个抽取项, 一个`field`可以定义下面这些东西

### `name`

> 给此项数据起个变量名  
> 变量名中不能包含.  
> 如果抓取到的数据想要以文章或者问答的形式发布到网站(WeCenter,  
> WordPress, Discuz!等), field 的命名请参考两个完整 demo 中的命名, 否则无法发布成功

**String 类型 不能为空**

举个栗子:

给`field`起了个名字叫`content`

```
array(
    'name' => "content",
    'selector' => "//*[@id='single-next-link']"
)
```

### `selector`

> 定义抽取规则, 默认使用 xpath  
> 如果使用其他类型的, 需要指定 selector_type

**String 类型 不能为空**

举个栗子:  
使用 xpath 来抽取糗事百科的笑话内容，selector 的值就是内容的 xpath

```
array(
    'name' => "content",
    'selector' => "//*[@id='single-next-link']"
)
```

### `selector_type`

抽取规则的类型

> 目前可用[xpath](http://www.w3school.com.cn/xpath/index.asp), [jsonpath](http://www.cnblogs.com/draem0507/p/5111002.html), [regex](http://www.runoob.com/regexp/regexp-tutorial.html)  
> 默认`xpath`

**枚举类型**

栗子 1:  
selector 默认使用 xpath

```
array(
    'name' => "content",
    'selector' => "//*[@id='single-next-link']" // xpath抽取规则
)
```

栗子 2:  
使用正则表达式来抽取数据

```
array(
    'name' => "content",
    'selector_type' => 'regex',
    'selector' => '#<div\sclass="content">([^/]+)</div>#i' // regex抽取规则
)
```

### `required`

> 定义该`field`的值是否必须, 默认 false  
> 赋值为 true 的话, 如果该`field`没有抽取到内容, 该 field 对应的整条数据都将被丢弃

**布尔类型**

举个栗子:

```
array(
    'name' => "content",
    'selector' => "//*[@id='single-next-link']",
    'required' => true
)
```

### `repeated`

> 定义该`field`抽取到的内容是否是有多项, 默认`false`  
> 赋值为 true 的话, 无论该`field`是否真的是有多项, 抽取到的结果都是数组结构

**布尔类型**

举个栗子:  
爬取的网页中包含多条评论，所以抽取评论的时候要将 repeated 赋值为 true

```
array(
    'name' => "comments",
    'selector' => "//*[@id='zh-single-question-page']//a[contains(@class,'zm-item-tag')]",
    'repeated' => true
)
```

### `children`

> 为此`field`定义子项  
> 子项的定义仍然是一个`fields`数组  
> 没错, 这是一个树形结构

**数组类型**

举个栗子:  
抓取糗事百科的评论，每个评论爬取了内容，点赞数

```
array(
    'name' => "article_comments",
    'selector' => "//div[contains(@class,'comments-wrap')]",
    'children' => array(
        array(
            'name' => "replay",
            'selector' => "//div[contains(@class,'replay')]",
            'repeated' => true,
        ),
        array(
            'name' => "report",
            'selector' => "//div[contains(@class,'report')]",
            'repeated' => true,
        )
    )
)
```

### `source_type`

该 field 的数据源, 默认从当前的网页中抽取数据  
选择`attached_url`可以发起一个新的请求, 然后从请求返回的数据中抽取  
选择`url_context`可以从当前网页的 url 附加数据（点此查看“url 附加数据”实例解析）中抽取

**枚举类型**

### `attached_url`

当 source_type 设置为`attached_url`时, 定义新请求的 url

**String 类型**

举个栗子:  
当爬取的网页中某些内容需要异步加载请求时，就需要使用 attached_url，比如，抓取知乎回答中的评论部分，就是通过 AJAX 异步请求的数据

```
array(
    'name' => "comment_id",
    'selector' => "//div/@data-aid",
),
array(
    'name' => "comments",
    'source_type' => 'attached_url',
    // "comments"是从发送"attached_url"这个异步请求返回的数据中抽取的
    // "attachedUrl"支持引用上下文中的抓取到的"field", 这里就引用了上面抓取的"comment_id"
    'attached_url' => "https://www.zhihu.com/r/answers/{comment_id}/comments",
    'selector_type' => 'jsonpath'
    'selector' => "$.data",
    'repeated => true,
    'children' => array(
        ...
    )
}
```
