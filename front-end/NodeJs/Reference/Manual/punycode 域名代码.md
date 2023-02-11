---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/punycode.html
author: 
---

# punycode 域名代码 | Node.js API 文档

> ## Excerpt
> 中英对照

---
-   [关于本文档](http://nodejs.cn/api-v12/documentation.html)
-   [用法与示例](http://nodejs.cn/api-v12/synopsis.html)

___

-   [assert断言](http://nodejs.cn/api-v12/assert.html)
-   [async\_hooks异步钩子](http://nodejs.cn/api-v12/async_hooks.html)
-   [buffer缓冲区](http://nodejs.cn/api-v12/buffer.html)
-   [C++插件](http://nodejs.cn/api-v12/addons.html)
-   [C/C++插件(使用Node-API)](http://nodejs.cn/api-v12/n-api.html)
-   [C++嵌入器](http://nodejs.cn/api-v12/embedding.html)
-   [child\_process子进程](http://nodejs.cn/api-v12/child_process.html)
-   [cluster集群](http://nodejs.cn/api-v12/cluster.html)
-   [CLI命令行](http://nodejs.cn/api-v12/cli.html)
-   [console控制台](http://nodejs.cn/api-v12/console.html)
-   [crypto加密](http://nodejs.cn/api-v12/crypto.html)
-   [debugger调试器](http://nodejs.cn/api-v12/debugger.html)
-   [deprecation弃用](http://nodejs.cn/api-v12/deprecations.html)
-   [dgram数据报](http://nodejs.cn/api-v12/dgram.html)
-   [dns域名服务器](http://nodejs.cn/api-v12/dns.html)
-   [domain域](http://nodejs.cn/api-v12/domain.html)
-   [Error错误](http://nodejs.cn/api-v12/errors.html)
-   [events事件触发器](http://nodejs.cn/api-v12/events.html)
-   [fs文件系统](http://nodejs.cn/api-v12/fs.html)
-   [global全局变量](http://nodejs.cn/api-v12/globals.html)
-   [http超文本传输协议](http://nodejs.cn/api-v12/http.html)
-   [http2超文本传输协议2.0](http://nodejs.cn/api-v12/http2.html)
-   [https安全超文本传输协议](http://nodejs.cn/api-v12/https.html)
-   [inspector检查器](http://nodejs.cn/api-v12/inspector.html)
-   [Intl国际化](http://nodejs.cn/api-v12/intl.html)
-   [module模块](http://nodejs.cn/api-v12/module.html)
-   [module/cjsCommonJS模块](http://nodejs.cn/api-v12/modules.html)
-   [module/esmECMAScript模块](http://nodejs.cn/api-v12/esm.html)
-   [module/package包模块](http://nodejs.cn/api-v12/packages.html)
-   [net网络](http://nodejs.cn/api-v12/net.html)
-   [os操作系统](http://nodejs.cn/api-v12/os.html)
-   [path路径](http://nodejs.cn/api-v12/path.html)
-   [perf\_hooks性能钩子](http://nodejs.cn/api-v12/perf_hooks.html)
-   [policy安全策略](http://nodejs.cn/api-v12/policy.html)
-   [process进程](http://nodejs.cn/api-v12/process.html)
-   [punycode域名代码](http://nodejs.cn/api-v12/punycode.html)
-   [querystring查询字符串](http://nodejs.cn/api-v12/querystring.html)
-   [readline逐行读取](http://nodejs.cn/api-v12/readline.html)
-   [repl交互式解释器](http://nodejs.cn/api-v12/repl.html)
-   [report诊断报告](http://nodejs.cn/api-v12/report.html)
-   [stream流](http://nodejs.cn/api-v12/stream.html)
-   [string\_decoder字符串解码器](http://nodejs.cn/api-v12/string_decoder.html)
-   [timers定时器](http://nodejs.cn/api-v12/timers.html)
-   [tls安全传输层](http://nodejs.cn/api-v12/tls.html)
-   [trace\_events跟踪事件](http://nodejs.cn/api-v12/tracing.html)
-   [tty终端](http://nodejs.cn/api-v12/tty.html)
-   [url网址](http://nodejs.cn/api-v12/url.html)
-   [util实用工具](http://nodejs.cn/api-v12/util.html)
-   [v8引擎](http://nodejs.cn/api-v12/v8.html)
-   [vm虚拟机](http://nodejs.cn/api-v12/vm.html)
-   [wasi网络汇编系统接口](http://nodejs.cn/api-v12/wasi.html)
-   [worker\_threads工作线程](http://nodejs.cn/api-v12/worker_threads.html)
-   [zlib压缩](http://nodejs.cn/api-v12/zlib.html)

目录

-   [punycode 域名代码](http://nodejs.cn/api-v12/punycode.html#punycode)
    -   [`punycode.decode(string)`](http://nodejs.cn/api-v12/punycode.html#punycodedecodestring)
    -   [`punycode.encode(string)`](http://nodejs.cn/api-v12/punycode.html#punycodeencodestring)
    -   [`punycode.toASCII(domain)`](http://nodejs.cn/api-v12/punycode.html#punycodetoasciidomain)
    -   [`punycode.toUnicode(domain)`](http://nodejs.cn/api-v12/punycode.html#punycodetounicodedomain)
    -   [`punycode.ucs2`](http://nodejs.cn/api-v12/punycode.html#punycodeucs2)
        -   [`punycode.ucs2.decode(string)`](http://nodejs.cn/api-v12/punycode.html#punycodeucs2decodestring)
        -   [`punycode.ucs2.encode(codePoints)`](http://nodejs.cn/api-v12/punycode.html#punycodeucs2encodecodepoints)
    -   [`punycode.version`](http://nodejs.cn/api-v12/punycode.html#punycodeversion)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode.html)

弃用于: v7.0.0

**源代码:** [lib/punycode.js](https://github.com/nodejs/node/blob/v12.22.12/lib/punycode.js)

**Node.js 中捆绑的 punycode 模块版本正在被弃用**。 在 Node.js 的未来主版本中，此模块将被删除。 当前依赖 `punycode` 模块的用户应该改用用户区提供的 [Punycode.js](http://url.nodejs.cn/xyCDet) 模块。

`punycode` 模块是 [Punycode.js](http://url.nodejs.cn/xyCDet) 模块的捆绑版本。 可以使用以下方式访问它：

```
const punycode = require('punycode');
```

[Punycode](http://url.nodejs.cn/orDVEj) 是 RFC 3492 定义的字符编码方案，主要用于国际化域名。 由于 URL 中的主机名仅限于 ASCII 字符，因此必须使用 Punycode 方案将包含非 ASCII 字符的域名转换为 ASCII。 例如，翻译成英文单词的日文字符 `'example'` 是 `'例'`。 国际化域名 `'例.com'`（相当于 `'example.com'`）由 Punycode 表示为 ASCII 字符串 `'xn--fsq.com'`。

`punycode` 模块提供了 Punycode 标准的简单实现。

`punycode` 模块是 Node.js 使用的第三方依赖项，为方便开发者提供。 对模块的修复或其他修改必须指向 [Punycode.js](http://url.nodejs.cn/xyCDet) 项目。

### `punycode.decode(string)`[#](http://nodejs.cn/api-v12/punycode.html#punycodedecodestring)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode_decode_string.html)

新增于: v0.5.1

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)

`punycode.decode()` 方法将纯 ASCII 字符的 [Punycode](http://url.nodejs.cn/orDVEj) 字符串转换为等效的 Unicode 代码点字符串。

```
punycode.decode('maana-pta'); // 'mañana'
punycode.decode('--dqo34k'); // '☃-⌘'
```

### `punycode.encode(string)`[#](http://nodejs.cn/api-v12/punycode.html#punycodeencodestring)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode_encode_string.html)

新增于: v0.5.1

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)

`punycode.encode()` 方法将一串 Unicode 代码点转换为仅包含 ASCII 字符的 [Punycode](http://url.nodejs.cn/orDVEj) 字符串。

```
punycode.encode('mañana'); // 'maana-pta'
punycode.encode('☃-⌘'); // '--dqo34k'
```

### `punycode.toASCII(domain)`[#](http://nodejs.cn/api-v12/punycode.html#punycodetoasciidomain)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode_toascii_domain.html)

新增于: v0.6.1

-   `domain` [<string>](http://url.nodejs.cn/9Tw2bK)

`punycode.toASCII()` 方法将表示国际化域名的 Unicode 字符串转换为 [Punycode](http://url.nodejs.cn/orDVEj)。 只转换域名的非 ASCII 部分。 在已经只包含 ASCII 字符的字符串上调用 `punycode.toASCII()` 将无效。

```
// 编码域名
punycode.toASCII('mañana.com');  // 'xn--maana-pta.com'
punycode.toASCII('☃-⌘.com');   // 'xn----dqo34k.com'
punycode.toASCII('example.com'); // 'example.com'
```

### `punycode.toUnicode(domain)`[#](http://nodejs.cn/api-v12/punycode.html#punycodetounicodedomain)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode_tounicode_domain.html)

新增于: v0.6.1

-   `domain` [<string>](http://url.nodejs.cn/9Tw2bK)

`punycode.toUnicode()` 方法将表示包含 [Punycode](http://url.nodejs.cn/orDVEj) 编码字符的域名的字符串转换为 Unicode。 只转换域名的 [Punycode](http://url.nodejs.cn/orDVEj) 编码部分。

```
// 解码域名
punycode.toUnicode('xn--maana-pta.com'); // 'mañana.com'
punycode.toUnicode('xn----dqo34k.com');  // '☃-⌘.com'
punycode.toUnicode('example.com');       // 'example.com'
```

### `punycode.ucs2`[#](http://nodejs.cn/api-v12/punycode.html#punycodeucs2)

新增于: v0.7.0

#### `punycode.ucs2.decode(string)`[#](http://nodejs.cn/api-v12/punycode.html#punycodeucs2decodestring)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode_ucs2_decode_string.html)

新增于: v0.7.0

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)

`punycode.ucs2.decode()` 方法返回一个数组，其中包含字符串中每个 Unicode 符号的数字代码点值。

```
punycode.ucs2.decode('abc'); // [0x61, 0x62, 0x63]
// U+1D306 中心四元组的代理对：
punycode.ucs2.decode('\uD834\uDF06'); // [0x1D306]
```

#### `punycode.ucs2.encode(codePoints)`[#](http://nodejs.cn/api-v12/punycode.html#punycodeucs2encodecodepoints)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode_ucs2_encode_codepoints.html)

新增于: v0.7.0

-   `codePoints` [<integer\[\]>](http://url.nodejs.cn/SXbo1v)

`punycode.ucs2.encode()` 方法返回基于数字代码点值数组的字符串。

```
punycode.ucs2.encode([0x61, 0x62, 0x63]); // 'abc'
punycode.ucs2.encode([0x1D306]); // '\uD834\uDF06'
```

### `punycode.version`[#](http://nodejs.cn/api-v12/punycode.html#punycodeversion)

[中英对照](http://nodejs.cn/api-v12/punycode/punycode_version.html)

新增于: v0.6.1

-   [<string>](http://url.nodejs.cn/9Tw2bK)

返回标识当前 [Punycode.js](http://url.nodejs.cn/xyCDet) 版本号的字符串。
