---
created: 2022-07-29T13:12:55 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/tty.html
author: 
---

# tty 终端 | Node.js API 文档

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

-   [tty 终端](http://nodejs.cn/api-v12/tty.html#tty)
    -   [`tty.ReadStream` 类](http://nodejs.cn/api-v12/tty.html#class-ttyreadstream)
        -   [`readStream.isRaw`](http://nodejs.cn/api-v12/tty.html#readstreamisraw)
        -   [`readStream.isTTY`](http://nodejs.cn/api-v12/tty.html#readstreamistty)
        -   [`readStream.setRawMode(mode)`](http://nodejs.cn/api-v12/tty.html#readstreamsetrawmodemode)
    -   [`tty.WriteStream` 类](http://nodejs.cn/api-v12/tty.html#class-ttywritestream)
        -   [`'resize'` 事件](http://nodejs.cn/api-v12/tty.html#event-resize)
        -   [`writeStream.clearLine(dir[, callback])`](http://nodejs.cn/api-v12/tty.html#writestreamclearlinedir-callback)
        -   [`writeStream.clearScreenDown([callback])`](http://nodejs.cn/api-v12/tty.html#writestreamclearscreendowncallback)
        -   [`writeStream.columns`](http://nodejs.cn/api-v12/tty.html#writestreamcolumns)
        -   [`writeStream.cursorTo(x[, y][, callback])`](http://nodejs.cn/api-v12/tty.html#writestreamcursortox-y-callback)
        -   [`writeStream.getColorDepth([env])`](http://nodejs.cn/api-v12/tty.html#writestreamgetcolordepthenv)
        -   [`writeStream.getWindowSize()`](http://nodejs.cn/api-v12/tty.html#writestreamgetwindowsize)
        -   [`writeStream.hasColors([count][, env])`](http://nodejs.cn/api-v12/tty.html#writestreamhascolorscount-env)
        -   [`writeStream.isTTY`](http://nodejs.cn/api-v12/tty.html#writestreamistty)
        -   [`writeStream.moveCursor(dx, dy[, callback])`](http://nodejs.cn/api-v12/tty.html#writestreammovecursordx-dy-callback)
        -   [`writeStream.rows`](http://nodejs.cn/api-v12/tty.html#writestreamrows)
    -   [`tty.isatty(fd)`](http://nodejs.cn/api-v12/tty.html#ttyisattyfd)

[中英对照](http://nodejs.cn/api-v12/tty/tty.html)

**源代码:** [lib/tty.js](https://github.com/nodejs/node/blob/v12.22.12/lib/tty.js)

`tty` 模块提供了 `tty.ReadStream` 和 `tty.WriteStream` 类。 在大多数情况下，没有必要或不可能直接使用此模块。 但是，可以使用以下方式访问它：

```
const tty = require('tty');
```

确定 Node.js 是否在终端上下文中运行的首选方法是检查 `process.stdout.isTTY` 属性的值是否为 `true`：

```
$ node -p -e "Boolean(process.stdout.isTTY)"
true
$ node -p -e "Boolean(process.stdout.isTTY)" | cat
false
```

在大多数情况下，应用程序几乎没有理由手动创建 `tty.ReadStream` 和 `tty.WriteStream` 类的实例。

### `tty.ReadStream` 类[#](http://nodejs.cn/api-v12/tty.html#class-ttyreadstream)

[中英对照](http://nodejs.cn/api-v12/tty/class_tty_readstream.html)

新增于: v0.5.8

-   继承自: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

代表终端的可读端。 在正常情况下，[`process.stdin`](http://nodejs.cn/api-v12/process.html#process_process_stdin) 将是 Node.js 进程中唯一的 `tty.ReadStream` 实例，应该没有理由创建额外的实例。

#### `readStream.isRaw`[#](http://nodejs.cn/api-v12/tty.html#readstreamisraw)

[中英对照](http://nodejs.cn/api-v12/tty/readstream_israw.html)

新增于: v0.7.7

`boolean` 值，如果终端当前配置为作为原始设备运行，则为 `true`。 默认为 `false`。

#### `readStream.isTTY`[#](http://nodejs.cn/api-v12/tty.html#readstreamistty)

[中英对照](http://nodejs.cn/api-v12/tty/readstream_istty.html)

新增于: v0.5.8

`boolean` 值，对于 `tty.ReadStream` 实例，始终为 `true`。

#### `readStream.setRawMode(mode)`[#](http://nodejs.cn/api-v12/tty.html#readstreamsetrawmodemode)

[中英对照](http://nodejs.cn/api-v12/tty/readstream_setrawmode_mode.html)

新增于: v0.7.7

-   `mode` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则将 `tty.ReadStream` 配置为作为原始设备运行。 如果为 `false`，则将 `tty.ReadStream` 配置为在其默认模式下运行。 `readStream.isRaw` 属性将设置为结果模式。
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2) 读取流实例。

允许配置 `tty.ReadStream`，使其作为原始设备运行。

当在原始模式下时，输入总是逐个字符可用，不包括修饰符。 此外，终端对字符的所有特殊处理都被禁用，包括回显输入字符。

### `tty.WriteStream` 类[#](http://nodejs.cn/api-v12/tty.html#class-ttywritestream)

[中英对照](http://nodejs.cn/api-v12/tty/class_tty_writestream.html)

新增于: v0.5.8

-   继承自: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

代表终端的可写端。 在正常情况下，[`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 和 [`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr) 将是为 Node.js 进程创建的唯一的 `tty.WriteStream` 实例，应该没有理由创建额外的实例。

#### `'resize'` 事件[#](http://nodejs.cn/api-v12/tty.html#event-resize)

[中英对照](http://nodejs.cn/api-v12/tty/event_resize.html)

新增于: v0.7.7

每当 `writeStream.columns` 或 `writeStream.rows` 属性发生更改时，则会触发 `'resize'` 事件。 当调用时，没有参数传给监听器回调。

```
process.stdout.on('resize', () => {
  console.log('screen size has changed!');
  console.log(`${process.stdout.columns}x${process.stdout.rows}`);
});
```

#### `writeStream.clearLine(dir[, callback])`[#](http://nodejs.cn/api-v12/tty.html#writestreamclearlinedir-callback)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_clearline_dir_callback.html)

-   `dir` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `-1`: 从光标向左
    -   `1`: 从光标向右
    -   `0`: 整行
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果流希望调用代码在继续写入其他数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`writeStream.clearLine()` 在 `dir` 标识的方向上清除此 `WriteStream` 的当前行。

#### `writeStream.clearScreenDown([callback])`[#](http://nodejs.cn/api-v12/tty.html#writestreamclearscreendowncallback)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_clearscreendown_callback.html)

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果流希望调用代码在继续写入其他数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`writeStream.clearScreenDown()` 从当前光标向下清除此 `WriteStream`。

#### `writeStream.columns`[#](http://nodejs.cn/api-v12/tty.html#writestreamcolumns)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_columns.html)

新增于: v0.7.7

`number` 指定终端当前具有的列数。 每当触发 `'resize'` 事件时，则会更新此属性。

#### `writeStream.cursorTo(x[, y][, callback])`[#](http://nodejs.cn/api-v12/tty.html#writestreamcursortox-y-callback)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_cursorto_x_y_callback.html)

-   `x` [<number>](http://url.nodejs.cn/SXbo1v)
-   `y` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果流希望调用代码在继续写入其他数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`writeStream.cursorTo()` 将此 `WriteStream` 的光标移动到指定位置。

#### `writeStream.getColorDepth([env])`[#](http://nodejs.cn/api-v12/tty.html#writestreamgetcolordepthenv)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_getcolordepth_env.html)

新增于: v9.9.0

-   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 包含要检查的环境变量的对象。 这使得模拟特定终端的使用成为可能。 **默认值:** `process.env`。
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

Returns:

-   `1` 表示支持 2 种颜色，
-   `4` 表示支持 16 种颜色，
-   `8` 表示支持 256 种颜色，
-   `24` 表示支持 16,777,216 种颜色。

使用此来确定终端支持的颜色。 由于终端颜色的性质，可能出现误报或漏报。 这取决于进程信息和环境变量，这些可能与使用的终端有关。 可以传入 `env` 对象来模拟特定终端的使用。 这对于检查特定环境设置的行为方式很有用。

要强制实施特定的颜色支持，则使用以下环境设置之一。

-   2 种颜色：`FORCE_COLOR = 0`（禁用颜色）
-   16 种颜色：`FORCE_COLOR = 1`
-   256 种颜色：`FORCE_COLOR = 2`
-   16,777,216 种颜色：`FORCE_COLOR = 3`

使用 `NO_COLOR` 和 `NODE_DISABLE_COLORS` 环境变量也可以禁用颜色支持。

#### `writeStream.getWindowSize()`[#](http://nodejs.cn/api-v12/tty.html#writestreamgetwindowsize)

新增于: v0.7.7

-   返回: [<number\[\]>](http://url.nodejs.cn/SXbo1v)

`writeStream.getWindowSize()` returns the size of the [TTY](http://nodejs.cn/api-v12/tty.html) corresponding to this `WriteStream`. The array is of the type `[numColumns, numRows]` where `numColumns` and `numRows` represent the number of columns and rows in the corresponding [TTY](http://nodejs.cn/api-v12/tty.html).

#### `writeStream.hasColors([count][, env])`[#](http://nodejs.cn/api-v12/tty.html#writestreamhascolorscount-env)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_hascolors_count_env.html)

新增于: v11.13.0

-   `count` [<integer>](http://url.nodejs.cn/SXbo1v) 请求的颜色数量（最小为 2）。 **默认值:** 16.
-   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 包含要检查的环境变量的对象。 这使得模拟特定终端的使用成为可能。 **默认值:** `process.env`。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `writeStream` 支持的颜色至少与 `count` 中提供的颜色一样多，则返回 `true`。 最小支持为 2（黑色和白色）。

这具有与 [`writeStream.getColorDepth()`](http://nodejs.cn/api-v12/tty.html#tty_writestream_getcolordepth_env) 中描述的相同的误报和漏报。

```
process.stdout.hasColors();
// 根据 `stdout` 是否支持至少 16 种颜色，返回 true 或 false。
process.stdout.hasColors(256);
// 根据 `stdout` 是否支持至少 256 种颜色，返回 true 或 false。
process.stdout.hasColors({ TMUX: '1' });
// 返回 true。
process.stdout.hasColors(2 ** 24, { TMUX: '1' });
// 返回 false（环境设置假装支持 2 ** 8 种颜色）。
```

#### `writeStream.isTTY`[#](http://nodejs.cn/api-v12/tty.html#writestreamistty)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_istty.html)

新增于: v0.5.8

`boolean` 值，始终为 `true`。

#### `writeStream.moveCursor(dx, dy[, callback])`[#](http://nodejs.cn/api-v12/tty.html#writestreammovecursordx-dy-callback)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_movecursor_dx_dy_callback.html)

-   `dx` [<number>](http://url.nodejs.cn/SXbo1v)
-   `dy` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果流希望调用代码在继续写入其他数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`writeStream.moveCursor()` 相对于其当前位置移动此 `WriteStream` 的光标。

#### `writeStream.rows`[#](http://nodejs.cn/api-v12/tty.html#writestreamrows)

[中英对照](http://nodejs.cn/api-v12/tty/writestream_rows.html)

新增于: v0.7.7

`number` 指定终端当前具有的行数。 每当触发 `'resize'` 事件时，则会更新此属性。

### `tty.isatty(fd)`[#](http://nodejs.cn/api-v12/tty.html#ttyisattyfd)

[中英对照](http://nodejs.cn/api-v12/tty/tty_isatty_fd.html)

新增于: v0.5.8

-   `fd` [<number>](http://url.nodejs.cn/SXbo1v) 数字文件描述符
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `fd` 与终端关联，则 `tty.isatty()` 方法返回 `true`，否则返回 `false`，包括每当 `fd` 不是非负整数时。
