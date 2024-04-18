---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/globals.html
author: 
---

# global 全局变量 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/globals/global_objects.html)

这些对象在所有模块中都可用。 以下变量可能看起来是全局的，但实际上不是。 它们只存在于模块的作用域中，参见[模块系统文档](http://nodejs.cn/api-v12/modules.html)：

-   [`__dirname`](http://nodejs.cn/api-v12/modules.html#modules_dirname)
-   [`__filename`](http://nodejs.cn/api-v12/modules.html#modules_filename)
-   [`exports`](http://nodejs.cn/api-v12/modules.html#modules_exports)
-   [`module`](http://nodejs.cn/api-v12/modules.html#modules_module)
-   [`require()`](http://nodejs.cn/api-v12/modules.html#modules_require_id)

此处列出的对象特定于 Node.js。 有些[内置对象](http://url.nodejs.cn/GMhHSn)是 JavaScript 语言本身的一部分，它们也可以全局地访问。

### `Buffer` 类[#](http://nodejs.cn/api-v12/globals.html#class-buffer)

[中英对照](http://nodejs.cn/api-v12/globals/class_buffer.html)

新增于: v0.1.103

-   [<Function>](http://url.nodejs.cn/ceTQa6)

用于处理二进制数据。 参阅[缓冲区章节](http://nodejs.cn/api-v12/buffer.html)。

### `__dirname`[#](http://nodejs.cn/api-v12/globals.html#__dirname)

[中英对照](http://nodejs.cn/api-v12/globals/dirname.html)

此变量可能看起来是全局的，但实际上不是。 参见 [`__dirname`](http://nodejs.cn/api-v12/modules.html#modules_dirname)。

### `__filename`[#](http://nodejs.cn/api-v12/globals.html#__filename)

[中英对照](http://nodejs.cn/api-v12/globals/filename.html)

此变量可能看起来是全局的，但实际上不是。 参见 [`__filename`](http://nodejs.cn/api-v12/modules.html#modules_filename)。

### `clearImmediate(immediateObject)`[#](http://nodejs.cn/api-v12/globals.html#clearimmediateimmediateobject)

[中英对照](http://nodejs.cn/api-v12/globals/clearimmediate_immediateobject.html)

新增于: v0.9.1

[`clearImmediate`](http://nodejs.cn/api-v12/timers.html#timers_clearimmediate_immediate) 在[定时器](http://nodejs.cn/api-v12/timers.html)章节进行了描述。

### `clearInterval(intervalObject)`[#](http://nodejs.cn/api-v12/globals.html#clearintervalintervalobject)

[中英对照](http://nodejs.cn/api-v12/globals/clearinterval_intervalobject.html)

新增于: v0.0.1

[`clearInterval`](http://nodejs.cn/api-v12/timers.html#timers_clearinterval_timeout) 在[定时器](http://nodejs.cn/api-v12/timers.html)章节进行了描述。

### `clearTimeout(timeoutObject)`[#](http://nodejs.cn/api-v12/globals.html#cleartimeouttimeoutobject)

[中英对照](http://nodejs.cn/api-v12/globals/cleartimeout_timeoutobject.html)

新增于: v0.0.1

[`clearTimeout`](http://nodejs.cn/api-v12/timers.html#timers_cleartimeout_timeout) 在[定时器](http://nodejs.cn/api-v12/timers.html)章节进行了描述。

### `console`[#](http://nodejs.cn/api-v12/globals.html#console)

[中英对照](http://nodejs.cn/api-v12/globals/console.html)

新增于: v0.1.100

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

用于打印到标准输出和标准错误。 参阅 [`console`](http://nodejs.cn/api-v12/console.html) 章节。

### `exports`[#](http://nodejs.cn/api-v12/globals.html#exports)

[中英对照](http://nodejs.cn/api-v12/globals/exports.html)

此变量可能看起来是全局的，但实际上不是。 参见 [`exports`](http://nodejs.cn/api-v12/modules.html#modules_exports)。

### `global`[#](http://nodejs.cn/api-v12/globals.html#global)

[中英对照](http://nodejs.cn/api-v12/globals/global.html)

新增于: v0.1.27

-   [<Object>](http://url.nodejs.cn/jzn6Ao) 全局的命名空间对象。

在浏览器中，顶层的作用域是全局作用域。 这意味着在浏览器中，`var something` 将定义新的全局变量。 在 Node.js 中这是不同的。 顶层作用域不是全局作用域；Node.js 模块内的 `var something` 将是该模块本地的。

### `module`[#](http://nodejs.cn/api-v12/globals.html#module)

[中英对照](http://nodejs.cn/api-v12/globals/module.html)

此变量可能看起来是全局的，但实际上不是。 参见 [`module`](http://nodejs.cn/api-v12/modules.html#modules_module)。

### `process`[#](http://nodejs.cn/api-v12/globals.html#process)

[中英对照](http://nodejs.cn/api-v12/globals/process.html)

新增于: v0.1.7

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

进程对象。 参阅 [`process` 对象](http://nodejs.cn/api-v12/process.html#process_process)章节。

### `queueMicrotask(callback)`[#](http://nodejs.cn/api-v12/globals.html#queuemicrotaskcallback)

[中英对照](http://nodejs.cn/api-v12/globals/queuemicrotask_callback.html)

新增于: v11.0.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 要排队的函数。

`queueMicrotask()` 方法将微任务排队以调用 `callback`。 如果 `callback` 抛出异常，则将触发 [`process` 对象](http://nodejs.cn/api-v12/process.html#process_process)的 `'uncaughtException'` 事件。

微任务队列由 V8 管理，并且可以以类似于 [`process.nextTick()`](http://nodejs.cn/api-v12/process.html#process_process_nexttick_callback_args) 队列的方式使用，后者由 Node.js 管理。 在 Node.js 事件循环的每次轮询中，`process.nextTick()` 队列总是在微任务队列之前处理。

```
// 在这里，`queueMicrotask()` 用于确保 'load' 事件总是异步地触发，
// 并且因此始终如一。
// 在这里使用 `process.nextTick()` 会导致 'load' 事件
// 总是在任何其他 promise 作业之前触发。

DataHandler.prototype.load = async function load(key) {
  const hit = this._cache.get(url);
  if (hit !== undefined) {
    queueMicrotask(() => {
      this.emit('load', hit);
    });
    return;
  }

  const data = await fetchData(key);
  this._cache.set(url, data);
  this.emit('load', data);
};
```

### `require()`[#](http://nodejs.cn/api-v12/globals.html#require)

[中英对照](http://nodejs.cn/api-v12/globals/require.html)

此变量可能看起来是全局的，但实际上不是。 参见 [`require()`](http://nodejs.cn/api-v12/modules.html#modules_require_id)。

### `setImmediate(callback[, ...args])`[#](http://nodejs.cn/api-v12/globals.html#setimmediatecallback-args)

[中英对照](http://nodejs.cn/api-v12/globals/setimmediate_callback_args.html)

新增于: v0.9.1

[`setImmediate`](http://nodejs.cn/api-v12/timers.html#timers_setimmediate_callback_args) 在[定时器](http://nodejs.cn/api-v12/timers.html)章节进行了描述。

### `setInterval(callback, delay[, ...args])`[#](http://nodejs.cn/api-v12/globals.html#setintervalcallback-delay-args)

[中英对照](http://nodejs.cn/api-v12/globals/setinterval_callback_delay_args.html)

新增于: v0.0.1

[`setInterval`](http://nodejs.cn/api-v12/timers.html#timers_setinterval_callback_delay_args) 在[定时器](http://nodejs.cn/api-v12/timers.html)章节进行了描述。

### `setTimeout(callback, delay[, ...args])`[#](http://nodejs.cn/api-v12/globals.html#settimeoutcallback-delay-args)

[中英对照](http://nodejs.cn/api-v12/globals/settimeout_callback_delay_args.html)

新增于: v0.0.1

[`setTimeout`](http://nodejs.cn/api-v12/timers.html#timers_settimeout_callback_delay_args) 在[定时器](http://nodejs.cn/api-v12/timers.html)章节进行了描述。

### `TextDecoder`[#](http://nodejs.cn/api-v12/globals.html#textdecoder)

[中英对照](http://nodejs.cn/api-v12/globals/textdecoder.html)

新增于: v11.0.0

WHATWG `TextDecoder` 类。 参阅 [`TextDecoder`](http://nodejs.cn/api-v12/util.html#util_class_util_textdecoder) 章节。

### `TextEncoder`[#](http://nodejs.cn/api-v12/globals.html#textencoder)

[中英对照](http://nodejs.cn/api-v12/globals/textencoder.html)

新增于: v11.0.0

WHATWG `TextEncoder` 类。 参阅 [`TextEncoder`](http://nodejs.cn/api-v12/util.html#util_class_util_textencoder) 章节。

### `URL`[#](http://nodejs.cn/api-v12/globals.html#url)

[中英对照](http://nodejs.cn/api-v12/globals/url.html)

新增于: v10.0.0

WHATWG `URL` 类。 参阅 [`URL`](http://nodejs.cn/api-v12/url.html#url_class_url) 章节。

### `URLSearchParams`[#](http://nodejs.cn/api-v12/globals.html#urlsearchparams)

[中英对照](http://nodejs.cn/api-v12/globals/urlsearchparams.html)

新增于: v10.0.0

WHATWG `URLSearchParams` 类。 参阅 [`URLSearchParams`](http://nodejs.cn/api-v12/url.html#url_class_urlsearchparams) 章节。

### `WebAssembly`[#](http://nodejs.cn/api-v12/globals.html#webassembly)

[中英对照](http://nodejs.cn/api-v12/globals/webassembly.html)

新增于: v8.0.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

该对象充当所有 W3C [WebAssembly](http://url.nodejs.cn/cEivN6) 相关功能的命名空间。 有关用法和兼容性，请参阅 [Mozilla 开发者网络](http://url.nodejs.cn/g23oec)。
