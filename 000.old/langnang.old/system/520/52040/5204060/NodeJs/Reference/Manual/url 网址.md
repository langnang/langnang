---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/url.html
author: 
---

# url 网址 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/url/url.html)

**源代码:** [lib/url.js](https://github.com/nodejs/node/blob/v12.22.12/lib/url.js)

`url` 模块提供用于网址处理和解析的实用工具。 可以使用以下方式访问它：

```
const url = require('url');
```

### 网址字符串与网址对象[#](http://nodejs.cn/api-v12/url.html#url-strings-and-url-objects)

[中英对照](http://nodejs.cn/api-v12/url/url_strings_and_url_objects.html)

网址字符串是包含多个有意义组件的结构化字符串。 解析时，将返回包含每个组件的属性的网址对象。

`url` 模块提供了两种用于处理网址的 API：一种是 Node.js 特定的旧版 API，一种是实现了与 Web 浏览器使用的相同的 [WHATWG 网址标准](http://url.nodejs.cn/fKgW8d)的新版 API。

下面提供了 WHATWG 和 旧版 API 之间的比较。 在网址 `'http://user:pass@sub.example.com:8080/p/a/t/h?query=string#hash'` 上方显示的是由旧版 `url.parse()` 返回的对象的属性。 下方则是 WHATWG `URL` 对象的属性。

WHATWG 网址的 `origin` 属性包括 `protocol` 和 `host`，但不包括 `username` 或 `password`。

```
┌────────────────────────────────────────────────────────────────────────────────────────────────┐
│                                              href                                              │
├──────────┬──┬─────────────────────┬────────────────────────┬───────────────────────────┬───────┤
│ protocol │  │        auth         │          host          │           path            │ hash  │
│          │  │                     ├─────────────────┬──────┼──────────┬────────────────┤       │
│          │  │                     │    hostname     │ port │ pathname │     search     │       │
│          │  │                     │                 │      │          ├─┬──────────────┤       │
│          │  │                     │                 │      │          │ │    query     │       │
"  https:   //    user   :   pass   @ sub.example.com : 8080   /p/a/t/h  ?  query=string   #hash "
│          │  │          │          │    hostname     │ port │          │                │       │
│          │  │          │          ├─────────────────┴──────┤          │                │       │
│ protocol │  │ username │ password │          host          │          │                │       │
├──────────┴──┼──────────┴──────────┼────────────────────────┤          │                │       │
│   origin    │                     │         origin         │ pathname │     search     │ hash  │
├─────────────┴─────────────────────┴────────────────────────┴──────────┴────────────────┴───────┤
│                                              href                                              │
└────────────────────────────────────────────────────────────────────────────────────────────────┘
("" 行中的所有空格都应被忽略。它们纯粹是为了格式化。)
```

使用 WHATWG API 解析网址字符串：

```
const myURL =
  new URL('https://user:pass@sub.example.com:8080/p/a/t/h?query=string#hash');
```

使用旧版 API 解析网址字符串：

```
const url = require('url');
const myURL =
  url.parse('https://user:pass@sub.example.com:8080/p/a/t/h?query=string#hash');
```

### WHATWG 网址 API[#](http://nodejs.cn/api-v12/url.html#the-whatwg-url-api)

#### `URL` 类[#](http://nodejs.cn/api-v12/url.html#class-url)

[中英对照](http://nodejs.cn/api-v12/url/class_url.html)

浏览器兼容的 `URL` 类，按照 WHATWG 网址标准实现。 [解析网址的示例](http://url.nodejs.cn/NZjsQe)可以在标准本身中找到。 `URL` 类也在全局对象上可用。

按照浏览器的约定，`URL` 对象的所有属性都被实现为类原型上的获取器和设置器，而不是对象本身的数据属性。 因此，与[旧版 `urlObject`](http://nodejs.cn/api-v12/url.html#url_legacy_urlobject) 不同，在 `URL` 对象的任何属性上使用 `delete` 关键字（例如 `delete myURL.protocol`、`delete myURL.pathname` 等）没有任何作用，但仍会返回 `true`。

##### `new URL(input[, base])`[#](http://nodejs.cn/api-v12/url.html#new-urlinput-base)

[中英对照](http://nodejs.cn/api-v12/url/new_url_input_base.html)

-   `input` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的绝对或相对的输入网址。 如果 `input` 是相对的，则需要 `base`。 如果 `input` 是绝对的，则忽略 `base`。
-   `base` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 如果 `input` 不是绝对的，则为要解析的基本网址。

通过相对于 `base` 解析 `input` 来创建新的 `URL` 对象。 如果 `base` 作为字符串传入，则其将被解析为等效于 `new URL(base)`。

```
const myURL = new URL('/foo', 'https://example.org/');
// https://example.org/foo
```

网址构造函数可作为全局对象的属性访问。 也可以从内置的 url 模块中导入：

```
console.log(URL === require('url').URL); // 打印 'true'.
```

如果 `input` 或 `base` 不是有效的网址，则将抛出 `TypeError`。 注意，会将给定的值强制转换为字符串。 例如：

```
const myURL = new URL({ toString: () => 'https://example.org/' });
// https://example.org/
```

出现在 `input` 的主机名中的 Unicode 字符将使用 [Punycode](http://url.nodejs.cn/C2g98n) 算法自动转换为 ASCII。

```
const myURL = new URL('https://測試');
// https://xn--g6w251d/
```

只有在启用 [ICU](http://nodejs.cn/api-v12/intl.html#intl_options_for_building_node_js) 的情况下编译 `node` 可执行文件时，此功能才可用。 如果不是，则域名将原封不动地传入。

如果事先不知道 `input` 是否是绝对的网址并且提供了 `base`，则建议验证 `URL` 对象的 `origin` 是否符合预期。

```
let myURL = new URL('http://Example.com/', 'https://example.org/');
// http://example.com/

myURL = new URL('https://Example.com/', 'https://example.org/');
// https://example.com/

myURL = new URL('foo://Example.com/', 'https://example.org/');
// foo://Example.com/

myURL = new URL('http:Example.com/', 'https://example.org/');
// http://example.com/

myURL = new URL('https:Example.com/', 'https://example.org/');
// https://example.org/Example.com/

myURL = new URL('foo:Example.com/', 'https://example.org/');
// foo:Example.com/
```

##### `url.hash`[#](http://nodejs.cn/api-v12/url.html#urlhash)

[中英对照](http://nodejs.cn/api-v12/url/url_hash.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的片段部分。

```
const myURL = new URL('https://example.org/foo#bar');
console.log(myURL.hash);
// 打印 #bar

myURL.hash = 'baz';
console.log(myURL.href);
// 打印 https://example.org/foo#baz
```

分配给 `hash` 属性的值中包含的无效的网址字符会进行[百分比编码](http://nodejs.cn/api-v12/url.html#whatwg-percent-encoding)。 选择要进行百分比编码的字符可能与 [`url.parse()`](http://nodejs.cn/api-v12/url.html#url_url_parse_urlstring_parsequerystring_slashesdenotehost) 和 [`url.format()`](http://nodejs.cn/api-v12/url.html#url_url_format_urlobject) 方法产生的结果有所不同。

##### `url.host`[#](http://nodejs.cn/api-v12/url.html#urlhost)

[中英对照](http://nodejs.cn/api-v12/url/url_host.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的主机部分。

```
const myURL = new URL('https://example.org:81/foo');
console.log(myURL.host);
// 打印 example.org:81

myURL.host = 'example.com:82';
console.log(myURL.href);
// 打印 https://example.com:82/foo
```

分配给 `host` 属性的无效主机值将被忽略。

##### `url.hostname`[#](http://nodejs.cn/api-v12/url.html#urlhostname)

[中英对照](http://nodejs.cn/api-v12/url/url_hostname.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的主机名部分。 `url.host` 和 `url.hostname` 之间的主要区别在于 `url.hostname` 不包括端口。

```
const myURL = new URL('https://example.org:81/foo');
console.log(myURL.hostname);
// 打印 example.org

myURL.hostname = 'example.com:82';
console.log(myURL.href);
// 打印 https://example.com:81/foo
```

分配给 `hostname` 属性的无效主机名值将被忽略。

##### `url.href`[#](http://nodejs.cn/api-v12/url.html#urlhref)

[中英对照](http://nodejs.cn/api-v12/url/url_href.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置序列化的网址。

```
const myURL = new URL('https://example.org/foo');
console.log(myURL.href);
// 打印 https://example.org/foo

myURL.href = 'https://example.com/bar';
console.log(myURL.href);
// 打印 https://example.com/bar
```

获取 `href` 属性的值相当于调用 [`url.toString()`](http://nodejs.cn/api-v12/url.html#url_url_tostring)。

将此属性的值设置为新值相当于使用 [`new URL(value)`](http://nodejs.cn/api-v12/url.html#url_new_url_input_base) 创建新的 `URL` 对象。 `URL` 对象的每个属性都将被修改。

如果分配给 `href` 属性的值不是有效的网址，则将抛出 `TypeError`。

##### `url.origin`[#](http://nodejs.cn/api-v12/url.html#urlorigin)

[中英对照](http://nodejs.cn/api-v12/url/url_origin.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取网址的源的只读的序列化。

```
const myURL = new URL('https://example.org/foo/bar?baz');
console.log(myURL.origin);
// 打印 https://example.org
```

```
const idnURL = new URL('https://測試');
console.log(idnURL.origin);
// 打印 https://xn--g6w251d

console.log(idnURL.hostname);
// 打印 xn--g6w251d
```

##### `url.password`[#](http://nodejs.cn/api-v12/url.html#urlpassword)

[中英对照](http://nodejs.cn/api-v12/url/url_password.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的密码部分。

```
const myURL = new URL('https://abc:xyz@example.com');
console.log(myURL.password);
// 打印 xyz

myURL.password = '123';
console.log(myURL.href);
// 打印 https://abc:123@example.com
```

分配给 `password` 属性的值中包含的无效的网址字符会进行[百分比编码](http://nodejs.cn/api-v12/url.html#whatwg-percent-encoding)。 选择要进行百分比编码的字符可能与 [`url.parse()`](http://nodejs.cn/api-v12/url.html#url_url_parse_urlstring_parsequerystring_slashesdenotehost) 和 [`url.format()`](http://nodejs.cn/api-v12/url.html#url_url_format_urlobject) 方法产生的结果有所不同。

##### `url.pathname`[#](http://nodejs.cn/api-v12/url.html#urlpathname)

[中英对照](http://nodejs.cn/api-v12/url/url_pathname.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的路径部分。

```
const myURL = new URL('https://example.org/abc/xyz?123');
console.log(myURL.pathname);
// 打印 /abc/xyz

myURL.pathname = '/abcdef';
console.log(myURL.href);
// 打印 https://example.org/abcdef?123
```

分配给 `pathname` 属性的值中包含的无效的网址字符会进行[百分比编码](http://nodejs.cn/api-v12/url.html#whatwg-percent-encoding)。 选择要进行百分比编码的字符可能与 [`url.parse()`](http://nodejs.cn/api-v12/url.html#url_url_parse_urlstring_parsequerystring_slashesdenotehost) 和 [`url.format()`](http://nodejs.cn/api-v12/url.html#url_url_format_urlobject) 方法产生的结果有所不同。

##### `url.port`[#](http://nodejs.cn/api-v12/url.html#urlport)

[中英对照](http://nodejs.cn/api-v12/url/url_port.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的端口部分。

端口值可以是数字，也可以是包含 `0` 到 `65535`（含）范围内的数字的字符串。 将值设置为给定 `protocol` 的 `URL` 对象的默认端口将导致 `port` 值成为空字符串 (`''`)。

端口值可以是空字符串，在这种情况下端口取决于协议/方案：

| 协议 | 端口 |
| --- | --- |
| "ftp" | 21 |
| "file" |  |
| "gopher" | 70 |
| "http" | 80 |
| "https" | 443 |
| "ws" | 80 |
| "wss" | 443 |

为端口分配值后，该值将首先使用 `.toString()` 转换为字符串。

如果该字符串无效但以数字开头，则将前导数字分配给 `port`。 如果数字在上述范围之外，则将其忽略。

```
const myURL = new URL('https://example.org:8888');
console.log(myURL.port);
// 打印 8888

// 默认端口自动转换为空字符串
//（HTTPS 协议的默认端口是 443）
myURL.port = '443';
console.log(myURL.port);
// 打印空字符串
console.log(myURL.href);
// 打印 https://example.org/

myURL.port = 1234;
console.log(myURL.port);
// 打印 1234
console.log(myURL.href);
// 打印 https://example.org:1234/

// 完全无效的端口字符串被忽略
myURL.port = 'abcd';
console.log(myURL.port);
// 打印 1234

// 前导数字被视为端口号
myURL.port = '5678abcd';
console.log(myURL.port);
// 打印 5678

// 非整数被截断
myURL.port = 1234.5678;
console.log(myURL.port);
// 打印 1234

// 未用科学计数法表示的超出范围的数字将被忽略。
myURL.port = 1e10; // 10000000000，将按如下所述进行范围检查
console.log(myURL.port);
// 打印 1234
```

包含小数点的数字，例如浮点数或科学记数法中的数字，也不例外。 小数点前的前导数字将被设置为网址的端口，假设它们是有效的：

```
myURL.port = 4.567e21;
console.log(myURL.port);
// 打印 4（因为它是字符串 '4.567e21' 中的前导数字）
```

##### `url.protocol`[#](http://nodejs.cn/api-v12/url.html#urlprotocol)

[中英对照](http://nodejs.cn/api-v12/url/url_protocol.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的协议部分。

```
const myURL = new URL('https://example.org');
console.log(myURL.protocol);
// 打印 https:

myURL.protocol = 'ftp';
console.log(myURL.href);
// 打印 ftp://example.org/
```

分配给 `protocol` 属性的无效的网址协议值将被忽略。

###### 特殊协议[#](http://nodejs.cn/api-v12/url.html#special-schemes)

[中英对照](http://nodejs.cn/api-v12/url/special_schemes.html)

[WHATWG 网址标准](http://url.nodejs.cn/fKgW8d)认为少数网址协议方案在解析和序列化方式方面具有特殊性。 当使用这些特殊协议之一解析网址时，`url.protocol` 属性可能会更改为另一种特殊协议，但不能更改为非特殊协议，反之亦然。

例如，从 `http` 更改为 `https` 有效：

```
const u = new URL('http://example.org');
u.protocol = 'https';
console.log(u.href);
// https://example.org
```

但是，从 `http` 更改为假设的 `fish` 协议并不是因为新协议并不特殊。

```
const u = new URL('http://example.org');
u.protocol = 'fish';
console.log(u.href);
// http://example.org
```

同样，也不允许从非特殊协议更改为特殊协议：

```
const u = new URL('fish://example.org');
u.protocol = 'http';
console.log(u.href);
// fish://example.org
```

根据 WHATWG 网址标准，特殊协议方案有 `ftp`、`file`、`gopher`、`http`、`https`、`ws` 和 `wss`。

##### `url.search`[#](http://nodejs.cn/api-v12/url.html#urlsearch)

[中英对照](http://nodejs.cn/api-v12/url/url_search.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的序列化的查询部分。

```
const myURL = new URL('https://example.org/abc?123');
console.log(myURL.search);
// 打印 ?123

myURL.search = 'abc=xyz';
console.log(myURL.href);
// 打印 https://example.org/abc?abc=xyz
```

出现在分配给 `search` 属性的值中的任何无效的网址字符都将进行[百分比编码](http://nodejs.cn/api-v12/url.html#whatwg-percent-encoding)。 选择要进行百分比编码的字符可能与 [`url.parse()`](http://nodejs.cn/api-v12/url.html#url_url_parse_urlstring_parsequerystring_slashesdenotehost) 和 [`url.format()`](http://nodejs.cn/api-v12/url.html#url_url_format_urlobject) 方法产生的结果有所不同。

##### `url.searchParams`[#](http://nodejs.cn/api-v12/url.html#urlsearchparams)

[中英对照](http://nodejs.cn/api-v12/url/url_searchparams.html)

-   [<URLSearchParams>](http://nodejs.cn/api/url.html#class-urlsearchparams)

获取表示网址查询参数的 [`URLSearchParams`](http://nodejs.cn/api-v12/url.html#url_class_urlsearchparams) 对象。 此属性是只读的，但它提供的 `URLSearchParams` 对象可用于更改网址实例； 要替换网址的整个查询参数，则使用 [`url.search`](http://nodejs.cn/api-v12/url.html#url_url_search) 设置器。 有关详细信息，请参阅 [`URLSearchParams`](http://nodejs.cn/api-v12/url.html#url_class_urlsearchparams) 文档。

当使用 `.searchParams` 修改 `URL` 时要小心，因为根据 WHATWG 规范，`URLSearchParams` 对象使用不同的规则来确定要对哪些字符进行百分比编码。 例如，`URL` 对象不会对 ASCII 波浪号 (`~`) 字符进行百分比编码，而 `URLSearchParams` 将始终对其进行编码：

```
const myUrl = new URL('https://example.org/abc?foo=~bar');

console.log(myUrl.search);  // 打印 ?foo=~bar

// 通过 searchParams 修改网址...
myUrl.searchParams.sort();

console.log(myUrl.search);  // 打印 ?foo=%7Ebar
```

##### `url.username`[#](http://nodejs.cn/api-v12/url.html#urlusername)

[中英对照](http://nodejs.cn/api-v12/url/url_username.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

获取和设置网址的用户名部分。

```
const myURL = new URL('https://abc:xyz@example.com');
console.log(myURL.username);
// 打印 abc

myURL.username = '123';
console.log(myURL.href);
// 打印 https://123:xyz@example.com/
```

出现在分配给 `username` 属性的值中的任何无效的网址字符都将进行[百分比编码](http://nodejs.cn/api-v12/url.html#whatwg-percent-encoding)。 选择要进行百分比编码的字符可能与 [`url.parse()`](http://nodejs.cn/api-v12/url.html#url_url_parse_urlstring_parsequerystring_slashesdenotehost) 和 [`url.format()`](http://nodejs.cn/api-v12/url.html#url_url_format_urlobject) 方法产生的结果有所不同。

##### `url.toString()`[#](http://nodejs.cn/api-v12/url.html#urltostring)

[中英对照](http://nodejs.cn/api-v12/url/url_tostring.html)

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`URL` 对象上的 `toString()` 方法返回序列化的网址。 返回值等同于 [`url.href`](http://nodejs.cn/api-v12/url.html#url_url_href) 和 [`url.toJSON()`](http://nodejs.cn/api-v12/url.html#url_url_tojson) 的值。

由于需要符合标准，该方法不允许用户自定义网址的序列化过程。 为了获得更大的灵活性，可能会对 [`require('url').format()`](http://nodejs.cn/api-v12/url.html#url_url_format_url_options) 方法感兴趣。

##### `url.toJSON()`[#](http://nodejs.cn/api-v12/url.html#urltojson)

[中英对照](http://nodejs.cn/api-v12/url/url_tojson.html)

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`URL` 对象上的 `toJSON()` 方法返回序列化的网址。 返回值等同于 [`url.href`](http://nodejs.cn/api-v12/url.html#url_url_href) 和 [`url.toString()`](http://nodejs.cn/api-v12/url.html#url_url_tostring) 的值。

当 `URL` 对象用 [`JSON.stringify()`](http://url.nodejs.cn/bmLTNS) 序列化时，会自动调用此方法。

```
const myURLs = [
  new URL('https://www.example.com'),
  new URL('https://test.example.org')
];
console.log(JSON.stringify(myURLs));
// 打印 ["https://www.example.com/","https://test.example.org/"]
```

#### `URLSearchParams` 类[#](http://nodejs.cn/api-v12/url.html#class-urlsearchparams)

[中英对照](http://nodejs.cn/api-v12/url/class_urlsearchparams.html)

`URLSearchParams` API 提供对 `URL` 查询的读写访问。 `URLSearchParams` 类也可以与以下四个构造函数之一单独使用。 `URLSearchParams` 类也在全局对象上可用。

WHATWG `URLSearchParams` 接口和 [`querystring`](http://nodejs.cn/api-v12/querystring.html) 模块具有相似的用途，但 [`querystring`](http://nodejs.cn/api-v12/querystring.html) 模块的用途更通用，因为它允许自定义的分隔符（`&` 和 `=`）。 换句话说，此 API 纯粹是为网址查询字符串而设计。

```
const myURL = new URL('https://example.org/?abc=123');
console.log(myURL.searchParams.get('abc'));
// 打印 123

myURL.searchParams.append('abc', 'xyz');
console.log(myURL.href);
// 打印 https://example.org/?abc=123&abc=xyz

myURL.searchParams.delete('abc');
myURL.searchParams.set('a', 'b');
console.log(myURL.href);
// 打印 https://example.org/?a=b

const newSearchParams = new URLSearchParams(myURL.searchParams);
// 以上相当于
// const newSearchParams = new URLSearchParams(myURL.search);

newSearchParams.append('a', 'c');
console.log(myURL.href);
// 打印 https://example.org/?a=b
console.log(newSearchParams.toString());
// 打印 a=b&a=c

// newSearchParams.toString() 是隐式调用的
myURL.search = newSearchParams;
console.log(myURL.href);
// 打印 https://example.org/?a=b&a=c
newSearchParams.delete('a');
console.log(myURL.href);
// 打印 https://example.org/?a=b&a=c
```

##### `new URLSearchParams()`[#](http://nodejs.cn/api-v12/url.html#new-urlsearchparams)

[中英对照](http://nodejs.cn/api-v12/url/new_urlsearchparams.html)

实例化新的空 `URLSearchParams` 对象。

##### `new URLSearchParams(string)`[#](http://nodejs.cn/api-v12/url.html#new-urlsearchparamsstring)

[中英对照](http://nodejs.cn/api-v12/url/new_urlsearchparams_string.html)

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK) 查询字符串

将 `string` 解析为查询字符串，并使用它来实例化新的 `URLSearchParams` 对象。 前导 `'?'`（如果存在）将被忽略。

```
let params;

params = new URLSearchParams('user=abc&query=xyz');
console.log(params.get('user'));
// 打印 'abc'
console.log(params.toString());
// 打印 'user=abc&query=xyz'

params = new URLSearchParams('?user=abc&query=xyz');
console.log(params.toString());
// 打印 'user=abc&query=xyz'
```

##### `new URLSearchParams(obj)`[#](http://nodejs.cn/api-v12/url.html#new-urlsearchparamsobj)

[中英对照](http://nodejs.cn/api-v12/url/new_urlsearchparams_obj.html)

新增于: v7.10.0, v6.13.0

-   `obj` [<Object>](http://url.nodejs.cn/jzn6Ao) 表示键值对集合的对象

使用查询哈希映射实例化新的 `URLSearchParams` 对象。 `obj` 的每个属性的键和值总是被强制转换为字符串。

与 [`querystring`](http://nodejs.cn/api-v12/querystring.html) 模块不同，不允许以数组值的形式出现重复的键。 数组使用 [`array.toString()`](http://url.nodejs.cn/q2o4mr) 字符串化，它简单地用逗号连接所有数组元素。

```
const params = new URLSearchParams({
  user: 'abc',
  query: ['first', 'second']
});
console.log(params.getAll('query'));
// 打印 [ 'first,second' ]
console.log(params.toString());
// 打印 'user=abc&query=first%2Csecond'
```

##### `new URLSearchParams(iterable)`[#](http://nodejs.cn/api-v12/url.html#new-urlsearchparamsiterable)

[中英对照](http://nodejs.cn/api-v12/url/new_urlsearchparams_iterable.html)

新增于: v7.10.0, v6.13.0

-   `iterable` [<Iterable>](http://url.nodejs.cn/mQfCyy) 元素为键值对的可迭代对象

以类似于 [`Map`](http://url.nodejs.cn/EnuJtG) 的构造函数的方式使用可迭代映射实例化新的 `URLSearchParams` 对象。 `iterable` 可以是 `Array` 或任何可迭代对象。 这意味着 `iterable` 可以是另一个 `URLSearchParams`，在这种情况下，构造函数将简单地创建提供的 `URLSearchParams` 的克隆。 `iterable` 的元素是键值对，并且本身可以是任何可迭代对象。

允许重复的键。

```
let params;

// 使用数组
params = new URLSearchParams([
  ['user', 'abc'],
  ['query', 'first'],
  ['query', 'second']
]);
console.log(params.toString());
// 打印 'user=abc&query=first&query=second'

// 使用 Map 对象
const map = new Map();
map.set('user', 'abc');
map.set('query', 'xyz');
params = new URLSearchParams(map);
console.log(params.toString());
// 打印 'user=abc&query=xyz'

// 使用生成器函数
function* getQueryPairs() {
  yield ['user', 'abc'];
  yield ['query', 'first'];
  yield ['query', 'second'];
}
params = new URLSearchParams(getQueryPairs());
console.log(params.toString());
// 打印 'user=abc&query=first&query=second'

// 每个键值对必须恰好有两个元素
new URLSearchParams([
  ['user', 'abc', 'error']
]);
// 抛出 TypeError [ERR_INVALID_TUPLE]:
//        Each query pair must be an iterable [name, value] tuple
```

##### `urlSearchParams.append(name, value)`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamsappendname-value)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_append_name_value.html)

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `value` [<string>](http://url.nodejs.cn/9Tw2bK)

将新的名称-值对追加到查询字符串。

##### `urlSearchParams.delete(name)`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamsdeletename)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_delete_name.html)

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)

删除名称为 `name` 的所有名称-值对。

##### `urlSearchParams.entries()`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamsentries)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_entries.html)

-   返回: [<Iterator>](http://url.nodejs.cn/Y2SE1q)

在查询中的每个名称-值对上返回 ES6 `Iterator`。 迭代器的每一项都是 JavaScript `Array`。 `Array` 的第一项是 `name`，`Array` 的第二项是 `value`。

[`urlSearchParams[@@iterator]()`](http://nodejs.cn/api-v12/url.html#url_urlsearchparams_symbol_iterator) 的别名。

##### `urlSearchParams.forEach(fn[, thisArg])`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamsforeachfn-thisarg)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_foreach_fn_thisarg.html)

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6) 为查询中的每个名称-值对调用
-   `thisArg` [<Object>](http://url.nodejs.cn/jzn6Ao) 在调用 `fn` 时用作 `this` 值

迭代查询中的每个名称-值对并调用给定的函数。

```
const myURL = new URL('https://example.org/?a=b&c=d');
myURL.searchParams.forEach((value, name, searchParams) => {
  console.log(name, value, myURL.searchParams === searchParams);
});
// 打印:
//   a b true
//   c d true
```

##### `urlSearchParams.get(name)`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamsgetname)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_get_name.html)

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) 或 `null`，如果给定的 `name` 没有名称-值对。

返回名称为 `name` 的第一个名称-值对的值。 如果没有这样的对，则返回 `null`。

##### `urlSearchParams.getAll(name)`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamsgetallname)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_getall_name.html)

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

返回名称为 `name` 的所有名称-值对的值。 如果没有这样的对，则返回空数组。

##### `urlSearchParams.has(name)`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamshasname)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_has_name.html)

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果至少有一个名称-值对的名称为 `name`，则返回 `true`。

##### `urlSearchParams.keys()`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamskeys)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_keys.html)

-   返回: [<Iterator>](http://url.nodejs.cn/Y2SE1q)

在每个名称-值对的名称上返回 ES6 `Iterator`。

```
const params = new URLSearchParams('foo=bar&foo=baz');
for (const name of params.keys()) {
  console.log(name);
}
// 打印:
//   foo
//   foo
```

##### `urlSearchParams.set(name, value)`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamssetname-value)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_set_name_value.html)

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `value` [<string>](http://url.nodejs.cn/9Tw2bK)

将与 `name` 关联的 `URLSearchParams` 对象中的值设置为 `value`。 如果存在任何名称为 `name` 的预先存在的名称-值对，则将第一个此类对的值设置为 `value` 并删除所有其他名称。 如果没有，则将名称-值对追加到查询字符串。

```
const params = new URLSearchParams();
params.append('foo', 'bar');
params.append('foo', 'baz');
params.append('abc', 'def');
console.log(params.toString());
// 打印 foo=bar&foo=baz&abc=def

params.set('foo', 'def');
params.set('xyz', 'opq');
console.log(params.toString());
// 打印 foo=def&abc=def&xyz=opq
```

##### `urlSearchParams.sort()`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamssort)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_sort.html)

新增于: v7.7.0, v6.13.0

按名称对所有现有的名称-值对进行就地排序。 排序是使用[稳定排序算法](http://url.nodejs.cn/bDYCiv)完成的，因此保留了具有相同名称的名称-值对之间的相对顺序。

该方法尤其可用于增加缓存命中。

```
const params = new URLSearchParams('query[]=abc&type=search&query[]=123');
params.sort();
console.log(params.toString());
// 打印 query%5B%5D=abc&query%5B%5D=123&type=search
```

##### `urlSearchParams.toString()`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamstostring)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_tostring.html)

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回序列化为字符串的搜索参数，必要时使用百分比编码的字符。

##### `urlSearchParams.values()`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamsvalues)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_values.html)

-   返回: [<Iterator>](http://url.nodejs.cn/Y2SE1q)

在每个名称-值对的值上返回 ES6 `Iterator`。

##### `urlSearchParams[Symbol.iterator]()`[#](http://nodejs.cn/api-v12/url.html#urlsearchparamssymboliterator)

[中英对照](http://nodejs.cn/api-v12/url/urlsearchparams_symbol_iterator.html)

-   返回: [<Iterator>](http://url.nodejs.cn/Y2SE1q)

在查询字符串中的每个名称-值对上返回 ES6 `Iterator`。 迭代器的每一项都是 JavaScript `Array`。 `Array` 的第一项是 `name`，`Array` 的第二项是 `value`。

[`urlSearchParams.entries()`](http://nodejs.cn/api-v12/url.html#url_urlsearchparams_entries) 的别名。

```
const params = new URLSearchParams('foo=bar&xyz=baz');
for (const [name, value] of params) {
  console.log(name, value);
}
// 打印:
//   foo bar
//   xyz baz
```

#### `url.domainToASCII(domain)`[#](http://nodejs.cn/api-v12/url.html#urldomaintoasciidomain)

[中英对照](http://nodejs.cn/api-v12/url/url_domaintoascii_domain.html)

新增于: v7.4.0, v6.13.0

-   `domain` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回 `domain` 的 [Punycode](http://url.nodejs.cn/C2g98n) ASCII 序列化。 如果 `domain` 是无效域，则返回空字符串。

它执行与[`url.domainToUnicode()`](http://nodejs.cn/api-v12/url.html#url_url_domaintounicode_domain)相反的操作。

```
const url = require('url');
console.log(url.domainToASCII('español.com'));
// 打印 xn--espaol-zwa.com
console.log(url.domainToASCII('中文.com'));
// 打印 xn--fiq228c.com
console.log(url.domainToASCII('xn--iñvalid.com'));
// 打印 an empty string
```

#### `url.domainToUnicode(domain)`[#](http://nodejs.cn/api-v12/url.html#urldomaintounicodedomain)

[中英对照](http://nodejs.cn/api-v12/url/url_domaintounicode_domain.html)

新增于: v7.4.0, v6.13.0

-   `domain` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回 `domain` 的 Unicode 序列化。 如果 `domain` 是无效域，则返回空字符串。

它执行与[`url.domainToASCII()`](http://nodejs.cn/api-v12/url.html#url_url_domaintoascii_domain)相反的操作。

```
const url = require('url');
console.log(url.domainToUnicode('xn--espaol-zwa.com'));
// 打印 español.com
console.log(url.domainToUnicode('xn--fiq228c.com'));
// 打印 中文.com
console.log(url.domainToUnicode('xn--iñvalid.com'));
// 打印 an empty string
```

#### `url.fileURLToPath(url)`[#](http://nodejs.cn/api-v12/url.html#urlfileurltopathurl)

[中英对照](http://nodejs.cn/api-v12/url/url_fileurltopath_url.html)

新增于: v10.12.0

-   `url` [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<string>](http://url.nodejs.cn/9Tw2bK) 要转换为路径的文件网址字符串或网址对象。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) 完全解析的特定于平台的 Node.js 文件路径。

此函数可确保正确解码百分比编码字符，并确保跨平台有效的绝对路径字符串。

```
new URL('file:///C:/path/').pathname;    // 错误: /C:/path/
fileURLToPath('file:///C:/path/');       // 正确: C:\path\ (Windows)

new URL('file://nas/foo.txt').pathname;  // 错误: /foo.txt
fileURLToPath('file://nas/foo.txt');     // 正确: \\nas\foo.txt (Windows)

new URL('file:///你好.txt').pathname;    // 错误: /%E4%BD%A0%E5%A5%BD.txt
fileURLToPath('file:///你好.txt');       // 正确: /你好.txt (POSIX)

new URL('file:///hello world').pathname; // 错误: /hello%20world
fileURLToPath('file:///hello world');    // 正确: /hello world (POSIX)
```

#### `url.format(URL[, options])`[#](http://nodejs.cn/api-v12/url.html#urlformaturl-options)

[中英对照](http://nodejs.cn/api-v12/url/url_format_url_options.html)

新增于: v7.6.0

-   `URL` [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) [WHATWG 网址](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api)对象
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `auth` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果序列化的网址字符串应包含用户名和密码，则为 `true`，否则为 `false`。 **默认值:** `true`。
    -   `fragment` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果序列化的网址字符串应包含片段，则为 `true`，否则为 `false`。 **默认值:** `true`。
    -   `search` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果序列化的网址字符串应包含搜索查询，则为 `true`，否则为 `false`。 **默认值:** `true`。
    -   `unicode` [<boolean>](http://url.nodejs.cn/jFbvuT) `true` 如果出现在网址字符串的主机组件中的 Unicode 字符应该被直接编码而不是 Punycode 编码。 **默认值:** `false`。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回 [WHATWG 网址](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api)对象的网址 `String` 表示的可自定义的序列化。

网址对象具有 `toString()` 方法和 `href` 属性，用于返回网址的字符串序列化。 但是，这些都不能以任何方式自定义。 `url.format(URL[, options])` 方法允许对输出进行基本的自定义。

```
const myURL = new URL('https://a:b@測試?abc#foo');

console.log(myURL.href);
// 打印 https://a:b@xn--g6w251d/?abc#foo

console.log(myURL.toString());
// 打印 https://a:b@xn--g6w251d/?abc#foo

console.log(url.format(myURL, { fragment: false, unicode: true, auth: false }));
// 打印 'https://測試/?abc'
```

#### `url.pathToFileURL(path)`[#](http://nodejs.cn/api-v12/url.html#urlpathtofileurlpath)

[中英对照](http://nodejs.cn/api-v12/url/url_pathtofileurl_path.html)

新增于: v10.12.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 要转换为文件网址的路径。
-   返回: [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 文件网址对象。

该函数确保 `path` 被绝对解析，并且在转换为文件网址时正确编码网址控制字符。

```
new URL(__filename);                // 错误: 抛出错误 (POSIX)
new URL(__filename);                // 错误: C:\... (Windows)
pathToFileURL(__filename);          // 正确: file:///... (POSIX)
pathToFileURL(__filename);          // 正确: file:///C:/... (Windows)

new URL('/foo#1', 'file:');         // 错误: file:///foo#1
pathToFileURL('/foo#1');            // 正确: file:///foo%231 (POSIX)

new URL('/some/path%.c', 'file:'); // 错误: file:///some/path%.c
pathToFileURL('/some/path%.c');    // 正确: file:///some/path%25.c (POSIX)
```

### 旧版的网址 API[#](http://nodejs.cn/api-v12/url.html#legacy-url-api)

弃用于: v11.0.0

#### 旧版的 urlObject[#](http://nodejs.cn/api-v12/url.html#legacy-urlobject)

[中英对照](http://nodejs.cn/api-v12/url/legacy_urlobject.html)

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 WHATWG URL API 。

旧版的 `urlObject`（`require('url').Url`）由 `url.parse()` 函数创建和返回。

##### `urlObject.auth`[#](http://nodejs.cn/api-v12/url.html#urlobjectauth)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_auth.html)

`auth` 属性是网址的用户名和密码部分，也称为 userinfo。 此字符串子集跟在 `protocol` 和双斜杠（如果存在）之后，并在 `host` 组件之前，由 `@` 分隔。 该字符串要么是用户名，要么是由 `:` 分隔的用户名和密码。

例如：`'user:pass'`。

##### `urlObject.hash`[#](http://nodejs.cn/api-v12/url.html#urlobjecthash)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_hash.html)

`hash` 属性是网址的片段标识符部分，包括前导 `#` 字符。

例如：`'#hash'`。

##### `urlObject.host`[#](http://nodejs.cn/api-v12/url.html#urlobjecthost)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_host.html)

`host` 属性是网址的完整小写主机部分，包括 `port`（如果指定）。

例如：`'sub.example.com:8080'`。

##### `urlObject.hostname`[#](http://nodejs.cn/api-v12/url.html#urlobjecthostname)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_hostname.html)

`hostname` 属性是 `host` 组件的小写主机名部分，不包括 `port`。

例如：`'sub.example.com'`。

##### `urlObject.href`[#](http://nodejs.cn/api-v12/url.html#urlobjecthref)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_href.html)

`href` 属性是将 `protocol` 和 `host` 组件都转换为小写的完整网址字符串。

例如：`'http://user:pass@sub.example.com:8080/p/a/t/h?query=string#hash'`。

##### `urlObject.path`[#](http://nodejs.cn/api-v12/url.html#urlobjectpath)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_path.html)

`path` 属性是 `pathname` 和 `search` 组件的串联。

例如：`'/p/a/t/h?query=string'`。

不执行 `path` 的解码。

##### `urlObject.pathname`[#](http://nodejs.cn/api-v12/url.html#urlobjectpathname)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_pathname.html)

`pathname` 属性包含网址的整个路径部分。 这是 `host`（包括 `port`）之后和 `query` 或 `hash` 组件开始之前的所有内容，由 ASCII 问号 (`?`) 或哈希 (`#`) 字符分隔。

例如：`'/p/a/t/h'`。

不执行路径字符串的解码。

##### `urlObject.port`[#](http://nodejs.cn/api-v12/url.html#urlobjectport)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_port.html)

`port` 属性是 `host` 组件的数字端口部分。

例如：`'8080'`。

##### `urlObject.protocol`[#](http://nodejs.cn/api-v12/url.html#urlobjectprotocol)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_protocol.html)

`protocol` 属性标识网址的小写协议方案。

例如：`'http:'`。

##### `urlObject.query`[#](http://nodejs.cn/api-v12/url.html#urlobjectquery)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_query.html)

`query` 属性要么是不带前导 ASCII 问号 (`?`) 的查询字符串，要么是 [`querystring`](http://nodejs.cn/api-v12/querystring.html) 模块的 `parse()` 方法返回的对象。 `query` 属性是字符串还是对象由传给 `url.parse()` 的 `parseQueryString` 参数决定。

例如：`'query=string'` 或 `{'query': 'string'}`。

如果作为字符串返回，则不执行查询字符串的解码。 如果作为对象返回，则键和值都会被解码。

##### `urlObject.search`[#](http://nodejs.cn/api-v12/url.html#urlobjectsearch)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_search.html)

`search` 属性由网址的整个“查询字符串”部分组成，包括前导 ASCII 问号 (`?`) 字符。

例如：`'?query=string'`。

不执行查询字符串的解码。

##### `urlObject.slashes`[#](http://nodejs.cn/api-v12/url.html#urlobjectslashes)

[中英对照](http://nodejs.cn/api-v12/url/urlobject_slashes.html)

如果 `protocol` 中的冒号后需要两个 ASCII 正斜杠字符 (`/`)，则 `slashes` 属性是值为 `true` 的 `boolean`。

#### `url.format(urlObject)`[#](http://nodejs.cn/api-v12/url.html#urlformaturlobject)

[中英对照](http://nodejs.cn/api-v12/url/url_format_urlobject.html)

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 WHATWG URL API 。

-   `urlObject` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) 网址对象（由 `url.parse()` 返回或以其他方式构造）。 如果是字符串，则通过将其传给 `url.parse()` 将其转换为对象。

`url.format()` 方法返回从 `urlObject` 派生的格式化网址字符串。

```
url.format({
  protocol: 'https',
  hostname: 'example.com',
  pathname: '/some/path',
  query: {
    page: 1,
    format: 'json'
  }
});

// => 'https://example.com/some/path?page=1&format=json'
```

如果 `urlObject` 不是对象或字符串，则 `url.format()` 将抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

格式化过程如下：

-   创建新的空字符串 `result`。
-   如果 `urlObject.protocol` 是字符串，则按原样附加到 `result`。
-   否则，如果 `urlObject.protocol` 不是 `undefined` 并且不是字符串，则抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。
-   对于所有不以 ASCII 冒号（`:`）字符结尾的 `urlObject.protocol` 字符串值，文字字符串 `:` 将附加到 `result`。
-   如果以下任一条件为真，则文字串 `//` 将附加到 `result`:
    -   `urlObject.slashes` 属性为真；
    -   `urlObject.protocol` 以 `http`、`https`、`ftp`、`gopher` 或 `file` 开头；
-   如果 `urlObject.auth` 属性的值为真，并且 `urlObject.host` 或 `urlObject.hostname` 不是 `undefined`，则 `urlObject.auth` 的值将被强制转换为字符串并附加到 `result` 后跟文字串 `@`。
-   如果 `urlObject.host` 属性为 `undefined`，则：
    -   如果 `urlObject.hostname` 是字符串，则将其附加到 `result`。
    -   否则，如果 `urlObject.hostname` 不是 `undefined` 并且不是字符串，则抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。
    -   如果 `urlObject.port` 属性值为真，而 `urlObject.hostname` 不是 `undefined`:
        -   字面量字符串 `:` 附加到 `result`，并且
        -   `urlObject.port` 的值被强制转换为字符串并附加到 `result`。
-   否则，如果 `urlObject.host` 属性值为真，则将 `urlObject.host` 的值强制转换为字符串并附加到 `result`。
-   如果 `urlObject.pathname` 属性是非空的字符串：
    -   如果 `urlObject.pathname` 不以 ASCII 正斜杠 (`/`) 开头，则文本字符串 `'/'` 将附加到 `result`。
    -   `urlObject.pathname` 的值附加到 `result`。
-   否则，如果 `urlObject.pathname` 不是 `undefined` 并且不是字符串，则抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。
-   如果 `urlObject.search` 属性是 `undefined` 并且如果 `urlObject.query` 属性是 `Object`，则文字串 `?` 附加到 `result`，然后是调用 [`querystring`](http://nodejs.cn/api-v12/querystring.html) 模块的 `stringify()` 方法的输出，并传入 `urlObject.query` 的值。
-   否则，如果 `urlObject.search` 是一个字符串：
    -   如果 `urlObject.search` 的值不以 ASCII 问号 (`?`) 字符开头，则文本字符串 `?` 附加到 `result`。
    -   `urlObject.search` 的值附加到 `result`。
-   否则，如果 `urlObject.search` 不是 `undefined` 并且不是字符串，则抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。
-   如果 `urlObject.hash` 属性是字符串：
    -   如果 `urlObject.hash` 的值不以 ASCII 散列 (`#`) 字符开头，则文本字符串 `#` 将附加到 `result`。
    -   `urlObject.hash` 的值附加到 `result`。
-   否则，如果 `urlObject.hash` 属性不是 `undefined` 并且不是字符串，则抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。
-   `result` 返回。

#### `url.parse(urlString[, parseQueryString[, slashesDenoteHost]])`[#](http://nodejs.cn/api-v12/url.html#urlparseurlstring-parsequerystring-slashesdenotehost)

[中英对照](http://nodejs.cn/api-v12/url/url_parse_urlstring_parsequerystring_slashesdenotehost.html)

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 WHATWG URL API 。

-   `urlString` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的 URL 字符串。
-   `parseQueryString` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则 `query` 属性将始终设置为 [`querystring`](http://nodejs.cn/api-v12/querystring.html) 模块的 `parse()` 方法返回的对象。 如果为 `false`，则返回的网址对象上的 `query` 属性将是未解析、未解码的字符串。 **默认值:** `false`。
-   `slashesDenoteHost` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则文字串 `//` 之后和下一个 `/` 之前的第一个令牌将被解释为 `host`。 例如，给定 `//foo/bar`，结果将是 `{host: 'foo', pathname: '/bar'}` 而不是 `{pathname: '//foo/bar'}`。 **默认值:** `false`。

`url.parse()` 方法接受网址字符串，解析并返回网址对象。

如果 `urlString` 不是字符串，则抛出 `TypeError`。

如果 `auth` 属性存在但无法解码，则抛出 `URIError`。

不鼓励使用旧版的 `url.parse()` 方法。 用户应使用 WHATWG `URL` API。 由于 `url.parse()` 方法使用一种宽松的非标准算法来解析网址字符串，因此可能会引入安全问题。 具体来说，已经确定了[主机名欺骗](http://url.nodejs.cn/xLioCa)以及用户名和密码处理不当的问题。

#### `url.resolve(from, to)`[#](http://nodejs.cn/api-v12/url.html#urlresolvefrom-to)

[中英对照](http://nodejs.cn/api-v12/url/url_resolve_from_to.html)

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 WHATWG URL API 。

-   `from` [<string>](http://url.nodejs.cn/9Tw2bK) 正在解析的基本网址。
-   `to` [<string>](http://url.nodejs.cn/9Tw2bK) 正在解析的 HREF 网址。

`url.resolve()` 方法以类似于 Web 浏览器解析锚标记 HREF 的方式解析相对于基本网址的目标网址。

```
const url = require('url');
url.resolve('/one/two/three', 'four');         // '/one/two/four'
url.resolve('http://example.com/', '/one');    // 'http://example.com/one'
url.resolve('http://example.com/one', '/two'); // 'http://example.com/two'
```

### 网址中的百分号编码[#](http://nodejs.cn/api-v12/url.html#percent-encoding-in-urls)

[中英对照](http://nodejs.cn/api-v12/url/percent_encoding_in_urls.html)

网址只允许包含一定范围的字符。 任何超出该范围的字符都必须进行编码。 这些字符的编码方式以及要编码的字符完全取决于字符在网址结构中的位置。

#### 旧版的 API[#](http://nodejs.cn/api-v12/url.html#legacy-api)

[中英对照](http://nodejs.cn/api-v12/url/legacy_api.html)

在旧版 API 中，空格 (`' '`) 和以下字符将在网址对象的属性中自动转义：

```
< > " ` \r \n \t { } | \ ^ '
```

例如，ASCII 空格字符 (`' '`) 被编码为 `%20`。 ASCII 正斜杠 (`/`) 字符编码为 `%3C`。

#### WHATWG API[#](http://nodejs.cn/api-v12/url.html#whatwg-api)

[中英对照](http://nodejs.cn/api-v12/url/whatwg_api.html)

[WHATWG 网址标准](http://url.nodejs.cn/fKgW8d)使用比旧版 API 使用的方法更具选择性和细粒度的方法来选择编码字符。

WHATWG 算法定义了四个“百分比编码集”，用于描述必须进行百分比编码的字符范围：

-   C0 控制百分比编码集，包括 U+0000 到 U+001F（含）范围内的代码点和所有大于 U+007E 的代码点。
    
-   片段百分比编码集，包括 C0 控制百分比编码集和代码点 U+0020、U+0022、U+003C、U+003E 和 U+0060。
    
-   路径百分比编码集，包括 C0 控制百分比编码集和代码点 U+0020、U+0022、U+0023、U+003C、U+003E、U+003F、U+0060、U +007B 和 U+007D。
    
-   userinfo 编码集，包括路径百分比编码集和代码点 U+002F、U+003A、U+003B、U+003D、U+0040、U+005B、U+005C、U+005D、 U+005E 和 U+007C。
    

userinfo 百分比编码集专门用于网址中编码的用户名和密码。 路径百分比编码集用于大多数网址的路径。 片段百分比编码集用于网址片段。 除了所有其他情况外，C0 控制百分比编码集用于某些特定条件下的主机和路径。

当主机名中出现非 ASCII 字符时，主机名将使用 [Punycode](http://url.nodejs.cn/C2g98n) 算法进行编码。 但是请注意，主机名可能包含 Punycode 编码和百分比编码的字符：

```
const myURL = new URL('https://%CF%80.example.com/foo');
console.log(myURL.href);
// 打印 https://xn--1xa.example.com/foo
console.log(myURL.origin);
// 打印 https://xn--1xa.example.com
```
