---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/querystring.html
author: 
---

# querystring 查询字符串 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/querystring/query_string.html)

**源代码:** [lib/querystring.js](https://github.com/nodejs/node/blob/v12.22.12/lib/querystring.js)

`querystring` 模块提供了用于解析和格式化网址查询字符串的实用工具。 可以使用以下方式访问它：

```
const querystring = require('querystring');
```

### `querystring.decode()`[#](http://nodejs.cn/api-v12/querystring.html#querystringdecode)

[中英对照](http://nodejs.cn/api-v12/querystring/querystring_decode.html)

新增于: v0.1.99

`querystring.decode()` 函数是 `querystring.parse()` 的别名。

### `querystring.encode()`[#](http://nodejs.cn/api-v12/querystring.html#querystringencode)

[中英对照](http://nodejs.cn/api-v12/querystring/querystring_encode.html)

新增于: v0.1.99

`querystring.encode()` 函数是 `querystring.stringify()` 的别名。

### `querystring.escape(str)`[#](http://nodejs.cn/api-v12/querystring.html#querystringescapestr)

[中英对照](http://nodejs.cn/api-v12/querystring/querystring_escape_str.html)

新增于: v0.1.25

-   `str` [<string>](http://url.nodejs.cn/9Tw2bK)

`querystring.escape()` 方法以针对网址查询字符串的特定要求优化的方式对给定的 `str` 执行网址百分比编码。

`querystring.escape()` 方法被 `querystring.stringify()` 使用，通常不会被直接使用。 导出它主要是为了允许应用程序代码在必要时通过将 `querystring.escape` 分配给替代函数来提供替换的百分比编码实现。

### `querystring.parse(str[, sep[, eq[, options]]])`[#](http://nodejs.cn/api-v12/querystring.html#querystringparsestr-sep-eq-options)

[中英对照](http://nodejs.cn/api-v12/querystring/querystring_parse_str_sep_eq_options.html)

-   `str` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的网址查询字符串
-   `sep` [<string>](http://url.nodejs.cn/9Tw2bK) 用于在查询字符串中分隔键值对的子字符串。 **默认值:** `'&'`。
-   `eq` [<string>](http://url.nodejs.cn/9Tw2bK)用于在查询字符串中分隔键和值的子字符串。 **默认值:** `'='`。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `decodeURIComponent` [<Function>](http://url.nodejs.cn/ceTQa6) 当对查询字符串中的百分比编码字符进行解码时使用的函数。 **默认值:** `querystring.unescape()`。
    -   `maxKeys` [<number>](http://url.nodejs.cn/SXbo1v) 指定要解析的最大键数。 指定 `0` 以删除键的计数限制。 **默认值:** `1000`。

`querystring.parse()` 方法将网址查询字符串 (`str`) 解析为键值对的集合。

例如，查询字符串 `'foo=bar&abc=xyz&abc=123'` 被解析为：

```
{
  foo: 'bar',
  abc: ['xyz', '123']
}
```

`querystring.parse()` 方法返回的对象通常不是从 JavaScript `Object` 继承的原型。 这意味着典型的 `Object` 方法，例如 `obj.toString()`、`obj.hasOwnProperty()` 和其他方法没有定义并且不会起作用。

默认情况下，查询字符串中的百分比编码字符将被假定为使用 UTF-8 编码。 如果使用替代的字符编码，则需要指定替代的 `decodeURIComponent` 选项：

```
// 假设 gbkDecodeURIComponent 函数已存在...

querystring.parse('w=%D6%D0%CE%C4&foo=bar', null, null,
                  { decodeURIComponent: gbkDecodeURIComponent });
```

### `querystring.stringify(obj[, sep[, eq[, options]]])`[#](http://nodejs.cn/api-v12/querystring.html#querystringstringifyobj-sep-eq-options)

[中英对照](http://nodejs.cn/api-v12/querystring/querystring_stringify_obj_sep_eq_options.html)

新增于: v0.1.25

-   `obj` [<Object>](http://url.nodejs.cn/jzn6Ao) 要序列化为网址查询字符串的对象
-   `sep` [<string>](http://url.nodejs.cn/9Tw2bK) 用于在查询字符串中分隔键值对的子字符串。 **默认值:** `'&'`。
-   `eq` [<string>](http://url.nodejs.cn/9Tw2bK)用于在查询字符串中分隔键和值的子字符串。 **默认值:** `'='`。
-   `options`
    -   `encodeURIComponent` [<Function>](http://url.nodejs.cn/ceTQa6) 当将网址不安全的字符转换为查询字符串中的百分比编码时使用的函数。 **默认值:** `querystring.escape()`。

`querystring.stringify()` 方法通过遍历对象的"自有属性"从给定的 `obj` 生成网址查询字符串。

```
querystring.stringify({ foo: 'bar', baz: ['qux', 'quux'], corge: '' });
// 返回 'foo=bar&baz=qux&baz=quux&corge='

querystring.stringify({ foo: 'bar', baz: 'qux' }, ';', ':');
// 返回 'foo:bar;baz:qux'
```

默认情况下，查询字符串中需要百分比编码的字符将被编码为 UTF-8。 如果需要替代的编码，则需要指定替代的 `encodeURIComponent` 选项：

```
// 假设 gbkEncodeURIComponent 函数已存在，

querystring.stringify({ w: '中文', foo: 'bar' }, null, null,
                      { encodeURIComponent: gbkEncodeURIComponent });
```

### `querystring.unescape(str)`[#](http://nodejs.cn/api-v12/querystring.html#querystringunescapestr)

[中英对照](http://nodejs.cn/api-v12/querystring/querystring_unescape_str.html)

新增于: v0.1.25

-   `str` [<string>](http://url.nodejs.cn/9Tw2bK)

`querystring.unescape()` 方法在给定的 `str` 上执行网址百分比编码字符的解码。

`querystring.unescape()` 方法被 `querystring.parse()` 使用，通常不会被直接使用。 导出它主要是为了允许应用程序代码在必要时通过将 `querystring.unescape` 分配给替代函数来提供替代的解码实现。

默认情况下，`querystring.unescape()` 方法将尝试使用 JavaScript 内置的 `decodeURIComponent()` 方法进行解码。 如果失败，则将使用更安全的不会因格式错误的网址而抛出错误的同类方法。
