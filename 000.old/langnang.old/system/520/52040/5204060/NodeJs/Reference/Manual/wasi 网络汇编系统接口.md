---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/wasi.html
author: 
---

# wasi 网络汇编系统接口 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/wasi/webassembly_system_interface_wasi.html)

**源代码:** [lib/wasi.js](https://github.com/nodejs/node/blob/v12.22.12/lib/wasi.js)

WASI API 提供了 [WebAssembly 系统接口](http://url.nodejs.cn/81GdrV)规范的实现。 WASI 让沙盒化的 WebAssembly 应用程序通过一系列类似 POSIX 的函数访问底层操作系统。

```
'use strict';
const fs = require('fs');
const { WASI } = require('wasi');
const wasi = new WASI({
  args: process.argv,
  env: process.env,
  preopens: {
    '/sandbox': '/some/real/path/that/wasm/can/access'
  }
});
const importObject = { wasi_snapshot_preview1: wasi.wasiImport };

(async () => {
  const wasm = await WebAssembly.compile(fs.readFileSync('./demo.wasm'));
  const instance = await WebAssembly.instantiate(wasm, importObject);

  wasi.start(instance);
})();
```

要运行上面的示例，则新建一个名为 `demo.wat` 的 WebAssembly 文本格式文件：

```
(module
    ;; Import the required fd_write WASI function which will write the given io vectors to stdout
    ;; The function signature for fd_write is:
    ;; (File Descriptor, *iovs, iovs_len, nwritten) -> Returns number of bytes written
    (import "wasi_snapshot_preview1" "fd_write" (func $fd_write (param i32 i32 i32 i32) (result i32)))

    (memory 1)
    (export "memory" (memory 0))

    ;; Write 'hello world\n' to memory at an offset of 8 bytes
    ;; Note the trailing newline which is required for the text to appear
    (data (i32.const 8) "hello world\n")

    (func $main (export "_start")
        ;; Creating a new io vector within linear memory
        (i32.store (i32.const 0) (i32.const 8))  ;; iov.iov_base - This is a pointer to the start of the 'hello world\n' string
        (i32.store (i32.const 4) (i32.const 12))  ;; iov.iov_len - The length of the 'hello world\n' string

        (call $fd_write
            (i32.const 1) ;; file_descriptor - 1 for stdout
            (i32.const 0) ;; *iovs - The pointer to the iov array, which is stored at memory location 0
            (i32.const 1) ;; iovs_len - We're printing 1 string stored in an iov - so one.
            (i32.const 20) ;; nwritten - A place in memory to store the number of bytes written
        )
        drop ;; Discard the number of bytes written from the top of the stack
    )
)
```

使用 [wabt](https://github.com/WebAssembly/wabt) 将 `.wat` 编译为 `.wasm`

```
$ wat2wasm demo.wat
```

运行此示例需要 `--experimental-wasi-unstable-preview1` 和 `--experimental-wasm-bigint` CLI 参数。

### `WASI` 类[#](http://nodejs.cn/api-v12/wasi.html#class-wasi)

[中英对照](http://nodejs.cn/api-v12/wasi/class_wasi.html)

新增于: v12.16.0

`WASI` 类提供了 WASI 系统调用 API 和其他方便的方法来使用基于 WASI 的应用程序。 每个 `WASI` 实例代表一个不同的沙箱环境。

#### `new WASI([options])`[#](http://nodejs.cn/api-v12/wasi.html#new-wasioptions)

[中英对照](http://nodejs.cn/api-v12/wasi/new_wasi_options.html)

新增于: v12.16.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `args` [<Array>](http://url.nodejs.cn/ZJSz23) 第一个参数是 WASI 命令本身的虚拟路径。 **默认值:** `[]`。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 类似于 `process.env` 的对象，WebAssembly 应用程序将其视为其环境。 **默认值:** `{}`。
    -   `preopens` [<Object>](http://url.nodejs.cn/jzn6Ao) 此对象表示 WebAssembly 应用程序的沙箱目录结构。 `preopens` 的字符串键被视为沙箱中的目录。 `preopens` 中对应的值是宿主机上这些目录的真实路径。
    -   `returnOnExit` [<boolean>](http://url.nodejs.cn/jFbvuT) 默认情况下，WASI 应用程序通过 `__wasi_proc_exit()` 函数终止 Node.js 进程。 将此选项设置为 `true` 会导致 `wasi.start()` 返回退出代码而不是终止进程。 **默认值:** `false`。
    -   `stdin` [<integer>](http://url.nodejs.cn/SXbo1v) 在 WebAssembly 应用程序中用作标准输入的文件描述符。 **默认值:** `0`。
    -   `stdout` [<integer>](http://url.nodejs.cn/SXbo1v) 在 WebAssembly 应用程序中用作标准输出的文件描述符。 **默认值:** `1`。
    -   `stderr` [<integer>](http://url.nodejs.cn/SXbo1v) 在 WebAssembly 应用程序中用作标准错误的文件描述符。 **默认值:** `2`。

#### `wasi.start(instance)`[#](http://nodejs.cn/api-v12/wasi.html#wasistartinstance)

[中英对照](http://nodejs.cn/api-v12/wasi/wasi_start_instance.html)

新增于: v12.16.0

-   `instance` [<WebAssembly.Instance>](http://url.nodejs.cn/dpJWED)

尝试通过调用 `_start()` 导出来开始执行 `instance` 作为 WASI 命令。 如果 `instance` 不包含 `_start()` 导出，或者 `instance` 包含 `_initialize()` 导出，则抛出异常。

`start()` 要求 `instance` 导出名为 `memory` 的 [`WebAssembly.Memory`](http://url.nodejs.cn/oNpEVb)。 如果 `instance` 没有 `memory` 导出，则抛出异常。

如果 `start()` 被多次调用，则抛出异常。

#### `wasi.initialize(instance)`[#](http://nodejs.cn/api-v12/wasi.html#wasiinitializeinstance)

[中英对照](http://nodejs.cn/api-v12/wasi/wasi_initialize_instance.html)

新增于: v12.19.0

-   `instance` [<WebAssembly.Instance>](http://url.nodejs.cn/dpJWED)

尝试通过调用 `_initialize()` 导出（如果存在）将 `instance` 初始化为 WASI 反应器。 如果 `instance` 包含 `_start()` 导出，则抛出异常。

`initialize()` 要求 `instance` 导出名为 `memory` 的 [`WebAssembly.Memory`](http://url.nodejs.cn/oNpEVb)。 如果 `instance` 没有 `memory` 导出，则抛出异常。

如果 `initialize()` 被多次调用，则抛出异常。

#### `wasi.wasiImport`[#](http://nodejs.cn/api-v12/wasi.html#wasiwasiimport)

[中英对照](http://nodejs.cn/api-v12/wasi/wasi_wasiimport.html)

新增于: v12.16.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

`wasiImport` 是实现 WASI 系统调用 API 的对象。 此对象应在 [`WebAssembly.Instance`](http://url.nodejs.cn/dpJWED) 实例化期间作为 `wasi_snapshot_preview1` 导入传入。
