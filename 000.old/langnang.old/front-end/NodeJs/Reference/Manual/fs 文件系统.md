---
created: 2022-07-29T13:12:52 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/fs.html
author: 
---

# fs 文件系统 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/fs/file_system.html)

**源代码:** [lib/fs.js](https://github.com/nodejs/node/blob/v12.22.12/lib/fs.js)

`fs` 模块能够以标准 POSIX 函数为模型的方式与文件系统进行交互。

```
const fs = require('fs');
```

### 同步的示例[#](http://nodejs.cn/api-v12/fs.html#synchronous-example)

[中英对照](http://nodejs.cn/api-v12/fs/synchronous_example.html)

异常会被立即地抛出，可以使用 `try…catch` 来处理，也可以允许冒泡。

```
const fs = require('fs');

try {
  fs.unlinkSync('/tmp/hello');
  console.log('successfully deleted /tmp/hello');
} catch (err) {
  // 处理错误
}
```

### 回调的示例[#](http://nodejs.cn/api-v12/fs.html#callback-example)

[中英对照](http://nodejs.cn/api-v12/fs/callback_example.html)

回调的形式将完成回调函数作为其最后一个参数并且异步地调用该操作。 传给完成回调的参数取决于方法，但是第一个参数始终预留用于异常。 如果操作成功地完成，则第一个参数为 `null` 或 `undefined`。

```
const fs = require('fs');

fs.unlink('/tmp/hello', (err) => {
  if (err) throw err;
  console.log('successfully deleted /tmp/hello');
});
```

### Promise 的示例[#](http://nodejs.cn/api-v12/fs.html#promise-example)

Promise-based operations return a `Promise` that is resolved when the asynchronous operation is complete.

```
const fs = require('fs').promises;

(async function(path) {
  try {
    await fs.unlink(path);
    console.log(`successfully deleted ${path}`);
  } catch (error) {
    console.error('there was an error:', error.message);
  }
})('/tmp/hello');
```

### 回调与基于 promise 的操作的顺序[#](http://nodejs.cn/api-v12/fs.html#ordering-of-callback-and-promise-based-operations)

[中英对照](http://nodejs.cn/api-v12/fs/ordering_of_callback_and_promise_based_operations.html)

例如，以下内容容易出错，因为 `fs.stat()` 操作可能会在 `fs.rename()` 操作之前完成：

```
fs.rename('/tmp/hello', '/tmp/world', (err) => {
  if (err) throw err;
  console.log('renamed complete');
});
fs.stat('/tmp/world', (err, stats) => {
  if (err) throw err;
  console.log(`stats: ${JSON.stringify(stats)}`);
});
```

```
fs.rename('/tmp/hello', '/tmp/world', (err) => {
  if (err) throw err;
  fs.stat('/tmp/world', (err, stats) => {
    if (err) throw err;
    console.log(`stats: ${JSON.stringify(stats)}`);
  });
});
```

```
const fs = require('fs').promises;

(async function(from, to) {
  try {
    await fs.rename(from, to);
    const stats = await fs.stat(to);
    console.log(`stats: ${JSON.stringify(stats)}`);
  } catch (error) {
    console.error('there was an error:', error.message);
  }
})('/tmp/hello', '/tmp/world');
```

### 文件路径[#](http://nodejs.cn/api-v12/fs.html#file-paths)

[中英对照](http://nodejs.cn/api-v12/fs/file_paths.html)

字符串形式的路径被解释为标识绝对或相对文件名的 UTF-8 字符序列。 相对路径将相对于通过调用 `process.cwd()` 确定的当前工作目录进行解析。

在 POSIX 上使用绝对路径的示例：

```
const fs = require('fs');

fs.open('/open/some/file.txt', 'r', (err, fd) => {
  if (err) throw err;
  fs.close(fd, (err) => {
    if (err) throw err;
  });
});
```

在 POSIX 上使用相对路径的示例（相对于 `process.cwd()`）:

```
fs.open('file.txt', 'r', (err, fd) => {
  if (err) throw err;
  fs.close(fd, (err) => {
    if (err) throw err;
  });
});
```

使用 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer) 指定的路径主要用于将文件路径视为不透明字节序列的某些 POSIX 操作系统。 在此类系统上，单个文件路径可能包含使用多种字符编码的子序列。 与字符串路径一样，`Buffer` 路径可以是相对的或绝对的：

在 POSIX 上使用绝对路径的示例：

```
fs.open(Buffer.from('/open/some/file.txt'), 'r', (err, fd) => {
  if (err) throw err;
  fs.close(fd, (err) => {
    if (err) throw err;
  });
});
```

在 Windows 上，Node.js 遵循独立驱动器工作目录的概念。 当使用不带反斜杠的驱动器路径时，可以观察到此行为。 例如，`fs.readdirSync('C:\\')` 可能返回与 `fs.readdirSync('C:')` 不同的结果。 有关详细信息，请参阅[此 MSDN 页面](http://url.nodejs.cn/qMc4eE)。

#### URL object support[#](http://nodejs.cn/api-v12/fs.html#url-object-support)

[中英对照](http://nodejs.cn/api-v12/fs/url_object_support.html)

新增于: v7.6.0

```
const fs = require('fs');
const fileUrl = new URL('file:///tmp/hello');

fs.readFileSync(fileUrl);
```

`file:` URL 始终是绝对路径。

```
// 在 Windows 上：

// - 带有主机名的 WHATWG 文件 URL 转换为 UNC 路径
// file://hostname/p/a/t/h/file => \\hostname\p\a\t\h\file
fs.readFileSync(new URL('file://hostname/p/a/t/h/file'));

// - 带有驱动器号的 WHATWG 文件 URL 转换为绝对路径
// file:///C:/tmp/hello => C:\tmp\hello
fs.readFileSync(new URL('file:///C:/tmp/hello'));

// - 没有主机名的 WHATWG 文件 URL 必须有驱动器号
fs.readFileSync(new URL('file:///notdriveletter/p/a/t/h/file'));
fs.readFileSync(new URL('file:///c/p/a/t/h/file'));
// TypeError [ERR_INVALID_FILE_URL_PATH]: File URL path must be absolute
```

```
// 在其他平台上：

// - 不支持带有主机名的 WHATWG 文件 URL
// file://hostname/p/a/t/h/file => throw!
fs.readFileSync(new URL('file://hostname/p/a/t/h/file'));
// TypeError [ERR_INVALID_FILE_URL_PATH]: must be absolute

// - WHATWG 文件 URL 转换为绝对路径
// file:///tmp/hello => /tmp/hello
fs.readFileSync(new URL('file:///tmp/hello'));
```

```
// 在 Windows 上
fs.readFileSync(new URL('file:///C:/p/a/t/h/%2F'));
fs.readFileSync(new URL('file:///C:/p/a/t/h/%2f'));
/* TypeError [ERR_INVALID_FILE_URL_PATH]: File URL path must not include encoded
\ or / characters */

// 在 POSIX 上
fs.readFileSync(new URL('file:///p/a/t/h/%2F'));
fs.readFileSync(new URL('file:///p/a/t/h/%2f'));
/* TypeError [ERR_INVALID_FILE_URL_PATH]: File URL path must not include encoded
/ characters */
```

```
// 在 Windows 上
fs.readFileSync(new URL('file:///C:/path/%5C'));
fs.readFileSync(new URL('file:///C:/path/%5c'));
/* TypeError [ERR_INVALID_FILE_URL_PATH]: File URL path must not include encoded
\ or / characters */
```

### 文件描述符[#](http://nodejs.cn/api-v12/fs.html#file-descriptors)

[中英对照](http://nodejs.cn/api-v12/fs/file_descriptors.html)

在 POSIX 系统上，对于每个进程，内核维护一个当前打开的文件和资源表。 每个打开的文件都分配了一个简单的数字标识符，称为_文件描述符_。 在系统级，所有文件系统操作都使用这些文件描述符来识别和跟踪每个特定文件。 Windows 系统使用不同但概念上相似的机制来跟踪资源。

分配后，文件描述符可用于从文件读取数据、向文件写入数据或请求有关文件的信息。

```
fs.open('/open/some/file.txt', 'r', (err, fd) => {
  if (err) throw err;
  fs.fstat(fd, (err, stat) => {
    if (err) throw err;
    // 使用统计

    // 
    fs.close(fd, (err) => {
      if (err) throw err;
    });
  });
});
```

否则将导致内存泄漏，最终导致应用程序崩溃。

### 线程池的使用[#](http://nodejs.cn/api-v12/fs.html#threadpool-usage)

[中英对照](http://nodejs.cn/api-v12/fs/threadpool_usage.html)

有关更多信息，请参阅 [`UV_THREADPOOL_SIZE`](http://nodejs.cn/api-v12/cli.html#cli_uv_threadpool_size_size) 文档。

### `fs.Dir` 类[#](http://nodejs.cn/api-v12/fs.html#class-fsdir)

[中英对照](http://nodejs.cn/api-v12/fs/class_fs_dir.html)

新增于: v12.12.0

表示目录流的类。

由 [`fs.opendir()`](http://nodejs.cn/api-v12/fs.html#fs_fs_opendir_path_options_callback)、[`fs.opendirSync()`](http://nodejs.cn/api-v12/fs.html#fs_fs_opendirsync_path_options) 或 [`fsPromises.opendir()`](http://nodejs.cn/api-v12/fs.html#fs_fspromises_opendir_path_options) 创建。

```
const fs = require('fs');

async function print(path) {
  const dir = await fs.promises.opendir(path);
  for await (const dirent of dir) {
    console.log(dirent.name);
  }
}
print('./').catch(console.error);
```

#### `dir.close()`[#](http://nodejs.cn/api-v12/fs.html#dirclose)

[中英对照](http://nodejs.cn/api-v12/fs/dir_close.html)

新增于: v12.12.0

-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步地关闭目录的底层资源句柄。 后续读取将导致错误。

#### `dir.close(callback)`[#](http://nodejs.cn/api-v12/fs.html#dirclosecallback)

[中英对照](http://nodejs.cn/api-v12/fs/dir_close_callback.html)

新增于: v12.12.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步地关闭目录的底层资源句柄。 后续读取将导致错误。

资源句柄关闭后将调用 `callback`。

#### `dir.closeSync()`[#](http://nodejs.cn/api-v12/fs.html#dirclosesync)

[中英对照](http://nodejs.cn/api-v12/fs/dir_closesync.html)

新增于: v12.12.0

同步地关闭目录的底层资源句柄。 后续读取将导致错误。

#### `dir.path`[#](http://nodejs.cn/api-v12/fs.html#dirpath)

[中英对照](http://nodejs.cn/api-v12/fs/dir_path.html)

新增于: v12.12.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

提供给 [`fs.opendir()`](http://nodejs.cn/api-v12/fs.html#fs_fs_opendir_path_options_callback)、[`fs.opendirSync()`](http://nodejs.cn/api-v12/fs.html#fs_fs_opendirsync_path_options) 或 [`fsPromises.opendir()`](http://nodejs.cn/api-v12/fs.html#fs_fspromises_opendir_path_options) 的此目录的只读路径。

#### `dir.read()`[#](http://nodejs.cn/api-v12/fs.html#dirread)

[中英对照](http://nodejs.cn/api-v12/fs/dir_read.html)

新增于: v12.12.0

-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8) 包含 [<fs.Dirent>](http://nodejs.cn/api/fs.html#class-fsdirent) | [<null>](http://url.nodejs.cn/334hvC)

通过 [`readdir(3)`](http://url.nodejs.cn/QvrbKw) 异步地读取下一个目录条目作为 [`fs.Dirent`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dirent)。

此函数返回的目录条目没有操作系统底层目录机制提供的特定顺序。

#### `dir.read(callback)`[#](http://nodejs.cn/api-v12/fs.html#dirreadcallback)

[中英对照](http://nodejs.cn/api-v12/fs/dir_read_callback.html)

新增于: v12.12.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `dirent` [<fs.Dirent>](http://nodejs.cn/api/fs.html#class-fsdirent) | [<null>](http://url.nodejs.cn/334hvC)

通过 [`readdir(3)`](http://url.nodejs.cn/QvrbKw) 异步地读取下一个目录条目作为 [`fs.Dirent`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dirent)。

读取完成后，将使用 [`fs.Dirent`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dirent) 或 `null`（如果读取不到更多的目录条目）调用 `callback`。

此函数返回的目录条目没有操作系统底层目录机制提供的特定顺序。

#### `dir.readSync()`[#](http://nodejs.cn/api-v12/fs.html#dirreadsync)

[中英对照](http://nodejs.cn/api-v12/fs/dir_readsync.html)

新增于: v12.12.0

-   返回: [<fs.Dirent>](http://nodejs.cn/api/fs.html#class-fsdirent) | [<null>](http://url.nodejs.cn/334hvC)

如果读取不到更多的目录条目，则将返回 `null`。

此函数返回的目录条目没有操作系统底层目录机制提供的特定顺序。

#### `dir[Symbol.asyncIterator]()`[#](http://nodejs.cn/api-v12/fs.html#dirsymbolasynciterator)

[中英对照](http://nodejs.cn/api-v12/fs/dir_symbol_asynciterator.html)

新增于: v12.12.0

-   返回: [<AsyncIterator>](http://url.nodejs.cn/HnG4ws) [<fs.Dirent>](http://nodejs.cn/api/fs.html#class-fsdirent) 的

异步迭代器返回的条目始终是 [`fs.Dirent`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dirent)。 来自 `dir.read()` 的 `null` 情况是在内部处理的。

有关示例，请参见 [`fs.Dir`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dir)。

此迭代器返回的目录条目没有操作系统底层目录机制提供的特定顺序。

### `fs.Dirent` 类[#](http://nodejs.cn/api-v12/fs.html#class-fsdirent)

[中英对照](http://nodejs.cn/api-v12/fs/class_fs_dirent.html)

新增于: v10.10.0

目录条目的表示，可以是目录中的文件或子目录，通过从 [`fs.Dir`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dir) 读取返回。 目录条目是文件名和文件类型对的组合。

#### `dirent.isBlockDevice()`[#](http://nodejs.cn/api-v12/fs.html#direntisblockdevice)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_isblockdevice.html)

新增于: v10.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Dirent` 对象描述块设备，则返回 `true`。

#### `dirent.isCharacterDevice()`[#](http://nodejs.cn/api-v12/fs.html#direntischaracterdevice)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_ischaracterdevice.html)

新增于: v10.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Dirent` 对象描述字符设备，则返回 `true`。

#### `dirent.isDirectory()`[#](http://nodejs.cn/api-v12/fs.html#direntisdirectory)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_isdirectory.html)

新增于: v10.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Dirent` 对象描述文件系统目录，则返回 `true`。

#### `dirent.isFIFO()`[#](http://nodejs.cn/api-v12/fs.html#direntisfifo)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_isfifo.html)

新增于: v10.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Dirent` 对象描述先进先出 (FIFO) 管道，则返回 `true`。

#### `dirent.isFile()`[#](http://nodejs.cn/api-v12/fs.html#direntisfile)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_isfile.html)

新增于: v10.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Dirent` 对象描述常规文件，则返回 `true`。

#### `dirent.isSocket()`[#](http://nodejs.cn/api-v12/fs.html#direntissocket)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_issocket.html)

新增于: v10.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Dirent` 对象描述套接字，则返回 `true`。

#### `dirent.isSymbolicLink()`[#](http://nodejs.cn/api-v12/fs.html#direntissymboliclink)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_issymboliclink.html)

新增于: v10.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Dirent` 对象描述符号链接，则返回 `true`。

#### `dirent.name`[#](http://nodejs.cn/api-v12/fs.html#direntname)

[中英对照](http://nodejs.cn/api-v12/fs/dirent_name.html)

新增于: v10.10.0

-   [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

此 `fs.Dirent` 对象引用的文件名。 该值的类型由传给 [`fs.readdir()`](http://nodejs.cn/api-v12/fs.html#fs_fs_readdir_path_options_callback) 或 [`fs.readdirSync()`](http://nodejs.cn/api-v12/fs.html#fs_fs_readdirsync_path_options) 的 `options.encoding` 决定。

### `fs.FSWatcher` 类[#](http://nodejs.cn/api-v12/fs.html#class-fsfswatcher)

[中英对照](http://nodejs.cn/api-v12/fs/class_fs_fswatcher.html)

新增于: v0.5.8

-   继承自 [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

成功调用 [`fs.watch()`](http://nodejs.cn/api-v12/fs.html#fs_fs_watch_filename_options_listener) 方法将返回新的 `fs.FSWatcher` 对象。

每当修改指定的被监视文件时，所有 `fs.FSWatcher` 对象都会触发 `'change'` 事件。

#### `'change'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-change)

[中英对照](http://nodejs.cn/api-v12/fs/event_change.html)

新增于: v0.5.8

-   `eventType` [<string>](http://url.nodejs.cn/9Tw2bK) 发生的变更事件的类型
-   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 更改的文件名（如果相关/可用）

当监视的目录或文件中的某些内容发生更改时触发。 在 [`fs.watch()`](http://nodejs.cn/api-v12/fs.html#fs_fs_watch_filename_options_listener) 中查看更多详细信息。

根据操作系统支持，可能不提供 `filename` 参数。 如果提供了 `filename`，如果 `fs.watch()` 在其 `encoding` 选项设置为 `'buffer'` 的情况下被调用，它将作为 `Buffer` 提供，否则 `filename` 将是 UTF-8 字符串。

```
// 通过 fs.watch() 监听器处理的示例
fs.watch('./tmp', { encoding: 'buffer' }, (eventType, filename) => {
  if (filename) {
    console.log(filename);
    // 打印: <Buffer ...>
  }
});
```

#### `'close'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-close)

[中英对照](http://nodejs.cn/api-v12/fs/event_close.html)

新增于: v10.0.0

当监视器停止监视变化时触发。 关闭的 `fs.FSWatcher` 对象在事件句柄中不再可用。

#### `'error'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-error)

[中英对照](http://nodejs.cn/api-v12/fs/event_error.html)

新增于: v0.5.8

-   `error` [<Error>](http://url.nodejs.cn/qZ873x)

在监视文件时发生错误时触发。 出错的 `fs.FSWatcher` 对象在事件句柄中不再可用。

#### `watcher.close()`[#](http://nodejs.cn/api-v12/fs.html#watcherclose)

[中英对照](http://nodejs.cn/api-v12/fs/watcher_close.html)

新增于: v0.5.8

停止监视给定 `fs.FSWatcher` 上的更改。 一旦停止，`fs.FSWatcher` 对象就不再可用。

#### `watcher.ref()`[#](http://nodejs.cn/api-v12/fs.html#watcherref)

[中英对照](http://nodejs.cn/api-v12/fs/watcher_ref.html)

新增于: v12.20.0

-   返回: [<fs.FSWatcher>](http://nodejs.cn/api/fs.html#class-fsfswatcher)

调用时，只要 `FSWatcher` 处于活动状态，就请求 Node.js 事件循环不退出。 多次调用 `watcher.ref()` 将不起作用。

默认情况下，所有 `FSWatcher` 对象都被“引用”，这使得通常不需要调用 `watcher.ref()` 除非之前已经调用过 `watcher.unref()`。

#### `watcher.unref()`[#](http://nodejs.cn/api-v12/fs.html#watcherunref)

[中英对照](http://nodejs.cn/api-v12/fs/watcher_unref.html)

新增于: v12.20.0

-   返回: [<fs.FSWatcher>](http://nodejs.cn/api/fs.html#class-fsfswatcher)

调用时，活动的 `FSWatcher` 对象不需要 Node.js 事件循环保持活动状态。 如果没有其他活动保持事件循环运行，则进程可能会在调用 `FSWatcher` 对象的回调之前退出。 多次调用 `watcher.unref()` 将不起作用。

### `fs.StatWatcher` 类[#](http://nodejs.cn/api-v12/fs.html#class-fsstatwatcher)

[中英对照](http://nodejs.cn/api-v12/fs/class_fs_statwatcher.html)

新增于: v12.20.0

-   继承自 [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

成功调用 `fs.watchFile()` 方法将返回新的 `fs.StatWatcher` 对象。

#### `watcher.ref()`[#](http://nodejs.cn/api-v12/fs.html#watcherref_1)

[中英对照](http://nodejs.cn/api-v12/fs/watcher_ref_1.html)

新增于: v12.20.0

-   返回: [<fs.StatWatcher>](http://nodejs.cn/api/fs.html#class-fsstatwatcher)

调用时，只要 `StatWatcher` 处于活动状态，就请求 Node.js 事件循环不退出。 多次调用 `watcher.ref()` 将不起作用。

默认情况下，所有 `StatWatcher` 对象都被“引用”，这使得通常不需要调用 `watcher.ref()` 除非之前已经调用过 `watcher.unref()`。

#### `watcher.unref()`[#](http://nodejs.cn/api-v12/fs.html#watcherunref_1)

[中英对照](http://nodejs.cn/api-v12/fs/watcher_unref_1.html)

新增于: v12.20.0

-   返回: [<fs.StatWatcher>](http://nodejs.cn/api/fs.html#class-fsstatwatcher)

调用时，活动的 `StatWatcher` 对象不需要 Node.js 事件循环保持活动状态。 如果没有其他活动保持事件循环运行，则进程可能会在调用 `StatWatcher` 对象的回调之前退出。 多次调用 `watcher.unref()` 将不起作用。

### `fs.ReadStream` 类[#](http://nodejs.cn/api-v12/fs.html#class-fsreadstream)

[中英对照](http://nodejs.cn/api-v12/fs/class_fs_readstream.html)

新增于: v0.1.93

-   继承自: [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

`fs.ReadStream` 的实例是使用 [`fs.createReadStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createreadstream_path_options) 函数创建和返回的。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-close_1)

[中英对照](http://nodejs.cn/api-v12/fs/event_close_1.html)

新增于: v0.1.93

当 `fs.ReadStream` 的底层文件描述符已关闭时触发。

#### `'open'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-open)

[中英对照](http://nodejs.cn/api-v12/fs/event_open.html)

新增于: v0.1.93

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v) `ReadStream` 使用的整数文件描述符。

当 `fs.ReadStream` 的文件描述符被打开时触发。

#### `'ready'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-ready)

[中英对照](http://nodejs.cn/api-v12/fs/event_ready.html)

新增于: v9.11.0

当 `fs.ReadStream` 准备好使用时触发。

`'open'` 后立即触发。

#### `readStream.bytesRead`[#](http://nodejs.cn/api-v12/fs.html#readstreambytesread)

[中英对照](http://nodejs.cn/api-v12/fs/readstream_bytesread.html)

新增于: v6.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

到目前为止已读取的字节数。

#### `readStream.path`[#](http://nodejs.cn/api-v12/fs.html#readstreampath)

[中英对照](http://nodejs.cn/api-v12/fs/readstream_path.html)

新增于: v0.1.93

-   [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

流正在读取的文件的路径，如 `fs.createReadStream()` 的第一个参数中所指定。 如果 `path` 作为字符串传入，则 `readStream.path` 将是字符串。 如果 `path` 作为 `Buffer` 传入，则 `readStream.path` 将是 `Buffer`。

#### `readStream.pending`[#](http://nodejs.cn/api-v12/fs.html#readstreampending)

[中英对照](http://nodejs.cn/api-v12/fs/readstream_pending.html)

新增于: v11.2.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果底层文件尚未打开，即在触发 `'ready'` 事件之前，则此属性为 `true`。

### `fs.Stats` 类[#](http://nodejs.cn/api-v12/fs.html#class-fsstats)

[中英对照](http://nodejs.cn/api-v12/fs/class_fs_stats.html)

`fs.Stats` 对象提供有关文件的信息。

从 [`fs.stat()`](http://nodejs.cn/api-v12/fs.html#fs_fs_stat_path_options_callback)、[`fs.lstat()`](http://nodejs.cn/api-v12/fs.html#fs_fs_lstat_path_options_callback) 和 [`fs.fstat()`](http://nodejs.cn/api-v12/fs.html#fs_fs_fstat_fd_options_callback) 及其同步方法返回的对象属于此类型。 如果传给这些方法的 `options` 中的 `bigint` 为 true，则数值将为 `bigint` 而不是 `number`，并且该对象将包含额外的以 `Ns` 为后缀的纳秒精度属性。

```
Stats {
  dev: 2114,
  ino: 48064969,
  mode: 33188,
  nlink: 1,
  uid: 85,
  gid: 100,
  rdev: 0,
  size: 527,
  blksize: 4096,
  blocks: 8,
  atimeMs: 1318289051000.1,
  mtimeMs: 1318289051000.1,
  ctimeMs: 1318289051000.1,
  birthtimeMs: 1318289051000.1,
  atime: Mon, 10 Oct 2011 23:24:11 GMT,
  mtime: Mon, 10 Oct 2011 23:24:11 GMT,
  ctime: Mon, 10 Oct 2011 23:24:11 GMT,
  birthtime: Mon, 10 Oct 2011 23:24:11 GMT }
```

`bigint` 版本：

```
BigIntStats {
  dev: 2114n,
  ino: 48064969n,
  mode: 33188n,
  nlink: 1n,
  uid: 85n,
  gid: 100n,
  rdev: 0n,
  size: 527n,
  blksize: 4096n,
  blocks: 8n,
  atimeMs: 1318289051000n,
  mtimeMs: 1318289051000n,
  ctimeMs: 1318289051000n,
  birthtimeMs: 1318289051000n,
  atimeNs: 1318289051000000000n,
  mtimeNs: 1318289051000000000n,
  ctimeNs: 1318289051000000000n,
  birthtimeNs: 1318289051000000000n,
  atime: Mon, 10 Oct 2011 23:24:11 GMT,
  mtime: Mon, 10 Oct 2011 23:24:11 GMT,
  ctime: Mon, 10 Oct 2011 23:24:11 GMT,
  birthtime: Mon, 10 Oct 2011 23:24:11 GMT }
```

#### `stats.isBlockDevice()`[#](http://nodejs.cn/api-v12/fs.html#statsisblockdevice)

[中英对照](http://nodejs.cn/api-v12/fs/stats_isblockdevice.html)

新增于: v0.1.10

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Stats` 对象描述块设备，则返回 `true`。

#### `stats.isCharacterDevice()`[#](http://nodejs.cn/api-v12/fs.html#statsischaracterdevice)

[中英对照](http://nodejs.cn/api-v12/fs/stats_ischaracterdevice.html)

新增于: v0.1.10

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Stats` 对象描述字符设备，则返回 `true`。

#### `stats.isDirectory()`[#](http://nodejs.cn/api-v12/fs.html#statsisdirectory)

[中英对照](http://nodejs.cn/api-v12/fs/stats_isdirectory.html)

新增于: v0.1.10

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Stats` 对象描述文件系统目录，则返回 `true`。

#### `stats.isFIFO()`[#](http://nodejs.cn/api-v12/fs.html#statsisfifo)

[中英对照](http://nodejs.cn/api-v12/fs/stats_isfifo.html)

新增于: v0.1.10

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Stats` 对象描述先进先出 (FIFO) 管道，则返回 `true`。

#### `stats.isFile()`[#](http://nodejs.cn/api-v12/fs.html#statsisfile)

[中英对照](http://nodejs.cn/api-v12/fs/stats_isfile.html)

新增于: v0.1.10

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Stats` 对象描述常规文件，则返回 `true`。

#### `stats.isSocket()`[#](http://nodejs.cn/api-v12/fs.html#statsissocket)

[中英对照](http://nodejs.cn/api-v12/fs/stats_issocket.html)

新增于: v0.1.10

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Stats` 对象描述套接字，则返回 `true`。

#### `stats.isSymbolicLink()`[#](http://nodejs.cn/api-v12/fs.html#statsissymboliclink)

[中英对照](http://nodejs.cn/api-v12/fs/stats_issymboliclink.html)

新增于: v0.1.10

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `fs.Stats` 对象描述符号链接，则返回 `true`。

此方法仅在使用 [`fs.lstat()`](http://nodejs.cn/api-v12/fs.html#fs_fs_lstat_path_options_callback) 时有效。

#### `stats.dev`[#](http://nodejs.cn/api-v12/fs.html#statsdev)

[中英对照](http://nodejs.cn/api-v12/fs/stats_dev.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

包含文件的设备的数字标识符。

#### `stats.ino`[#](http://nodejs.cn/api-v12/fs.html#statsino)

[中英对照](http://nodejs.cn/api-v12/fs/stats_ino.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

文件的文件系统特定的索引节点编号。

#### `stats.mode`[#](http://nodejs.cn/api-v12/fs.html#statsmode)

[中英对照](http://nodejs.cn/api-v12/fs/stats_mode.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

描述文件类型和模式的位字段。

#### `stats.nlink`[#](http://nodejs.cn/api-v12/fs.html#statsnlink)

[中英对照](http://nodejs.cn/api-v12/fs/stats_nlink.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

文件存在的硬链接数。

#### `stats.uid`[#](http://nodejs.cn/api-v12/fs.html#statsuid)

[中英对照](http://nodejs.cn/api-v12/fs/stats_uid.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

拥有文件的用户的数字用户标识符 (POSIX)。

#### `stats.gid`[#](http://nodejs.cn/api-v12/fs.html#statsgid)

[中英对照](http://nodejs.cn/api-v12/fs/stats_gid.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

拥有文件的群组的数字群组标识符 (POSIX)。

#### `stats.rdev`[#](http://nodejs.cn/api-v12/fs.html#statsrdev)

[中英对照](http://nodejs.cn/api-v12/fs/stats_rdev.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

如果文件代表设备，则为数字设备标识符。

#### `stats.size`[#](http://nodejs.cn/api-v12/fs.html#statssize)

[中英对照](http://nodejs.cn/api-v12/fs/stats_size.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

文件的大小（以字节为单位）。

#### `stats.blksize`[#](http://nodejs.cn/api-v12/fs.html#statsblksize)

[中英对照](http://nodejs.cn/api-v12/fs/stats_blksize.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

i/o 操作的文件系统块大小。

#### `stats.blocks`[#](http://nodejs.cn/api-v12/fs.html#statsblocks)

[中英对照](http://nodejs.cn/api-v12/fs/stats_blocks.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

为此文件分配的块数。

#### `stats.atimeMs`[#](http://nodejs.cn/api-v12/fs.html#statsatimems)

[中英对照](http://nodejs.cn/api-v12/fs/stats_atimems.html)

新增于: v8.1.0

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

指示最后一次访问此文件的时间戳，以 POSIX Epoch 以来的毫秒数表示。

#### `stats.mtimeMs`[#](http://nodejs.cn/api-v12/fs.html#statsmtimems)

[中英对照](http://nodejs.cn/api-v12/fs/stats_mtimems.html)

新增于: v8.1.0

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

指示最后一次修改此文件的时间戳，以 POSIX Epoch 以来的毫秒数表示。

#### `stats.ctimeMs`[#](http://nodejs.cn/api-v12/fs.html#statsctimems)

[中英对照](http://nodejs.cn/api-v12/fs/stats_ctimems.html)

新增于: v8.1.0

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

指示最后一次更改文件状态的时间戳，以 POSIX Epoch 以来的毫秒数表示。

#### `stats.birthtimeMs`[#](http://nodejs.cn/api-v12/fs.html#statsbirthtimems)

[中英对照](http://nodejs.cn/api-v12/fs/stats_birthtimems.html)

新增于: v8.1.0

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<bigint>](http://url.nodejs.cn/gJMq1y)

指示此文件创建时间的时间戳，以 POSIX Epoch 以来的毫秒数表示。

#### `stats.atimeNs`[#](http://nodejs.cn/api-v12/fs.html#statsatimens)

[中英对照](http://nodejs.cn/api-v12/fs/stats_atimens.html)

新增于: v12.10.0

-   [<bigint>](http://url.nodejs.cn/gJMq1y)

仅在 `bigint: true` 传入到生成对象的方法中时出现。 指示最后一次访问此文件的时间戳，以 POSIX Epoch 以来的纳秒数表示。

#### `stats.mtimeNs`[#](http://nodejs.cn/api-v12/fs.html#statsmtimens)

[中英对照](http://nodejs.cn/api-v12/fs/stats_mtimens.html)

新增于: v12.10.0

-   [<bigint>](http://url.nodejs.cn/gJMq1y)

仅在 `bigint: true` 传入到生成对象的方法中时出现。 指示最后一次修改此文件的时间戳，以 POSIX Epoch 以来的纳秒数表示。

#### `stats.ctimeNs`[#](http://nodejs.cn/api-v12/fs.html#statsctimens)

[中英对照](http://nodejs.cn/api-v12/fs/stats_ctimens.html)

新增于: v12.10.0

-   [<bigint>](http://url.nodejs.cn/gJMq1y)

仅在 `bigint: true` 传入到生成对象的方法中时出现。 指示最后一次更改文件状态的时间戳，以 POSIX Epoch 以来的纳秒数表示。

#### `stats.birthtimeNs`[#](http://nodejs.cn/api-v12/fs.html#statsbirthtimens)

[中英对照](http://nodejs.cn/api-v12/fs/stats_birthtimens.html)

新增于: v12.10.0

-   [<bigint>](http://url.nodejs.cn/gJMq1y)

仅在 `bigint: true` 传入到生成对象的方法中时出现。 指示此文件创建时间的时间戳，以 POSIX Epoch 以来的纳秒数表示。

#### `stats.atime`[#](http://nodejs.cn/api-v12/fs.html#statsatime)

[中英对照](http://nodejs.cn/api-v12/fs/stats_atime.html)

新增于: v0.11.13

-   [<Date>](http://url.nodejs.cn/A9TMoa)

指示最后一次访问此文件的时间戳。

#### `stats.mtime`[#](http://nodejs.cn/api-v12/fs.html#statsmtime)

[中英对照](http://nodejs.cn/api-v12/fs/stats_mtime.html)

新增于: v0.11.13

-   [<Date>](http://url.nodejs.cn/A9TMoa)

指示最后一次修改此文件的时间戳。

#### `stats.ctime`[#](http://nodejs.cn/api-v12/fs.html#statsctime)

[中英对照](http://nodejs.cn/api-v12/fs/stats_ctime.html)

新增于: v0.11.13

-   [<Date>](http://url.nodejs.cn/A9TMoa)

指示最后一次更改文件状态的时间戳。

#### `stats.birthtime`[#](http://nodejs.cn/api-v12/fs.html#statsbirthtime)

[中英对照](http://nodejs.cn/api-v12/fs/stats_birthtime.html)

新增于: v0.11.13

-   [<Date>](http://url.nodejs.cn/A9TMoa)

指示此文件创建时间的时间戳。

#### 统计的时间值[#](http://nodejs.cn/api-v12/fs.html#stat-time-values)

[中英对照](http://nodejs.cn/api-v12/fs/stat_time_values.html)

`atimeMs`、`mtimeMs`、`ctimeMs`、`birthtimeMs` 属性是数值，以毫秒为单位保存相应的时间。 它们的精度是特定于平台的。 当 `bigint: true` 传给生成对象的方法时，属性将是[长整数](http://url.nodejs.cn/3Jk6h6)，否则它们将是[数字](http://url.nodejs.cn/SXbo1v)。

`atimeNs`、`mtimeNs`、`ctimeNs`、`birthtimeNs` 属性是以纳秒为单位保存相应时间的[长整数](http://url.nodejs.cn/3Jk6h6)。 它们仅在 `bigint: true` 传入到生成对象的方法中时出现。 它们的精度是特定于平台的。

`atime`、`mtime`、`ctime` 和 `birthtime` 是不同时间的 [`Date`](http://url.nodejs.cn/A9TMoa) 对象替代表示。 `Date` 和数字值是不关联的。 分配新的数值或改变 `Date` 值不会反映在相应的替代表示中。

统计对象中的时间具有以下语义：

-   `atime` "访问时间": 上次访问文件数据的时间。 由 [`mknod(2)`](http://url.nodejs.cn/dC6BPb)、 [`utimes(2)`](http://url.nodejs.cn/58Fxaj) 和 [`read(2)`](http://url.nodejs.cn/3BmXqe) 系统调用更改。
-   `mtime` "修改时间": 上次修改文件数据的时间。 由 [`mknod(2)`](http://url.nodejs.cn/dC6BPb)、 [`utimes(2)`](http://url.nodejs.cn/58Fxaj) 和 [`write(2)`](http://url.nodejs.cn/NmUvmK) 系统调用更改。
-   `ctime` "更改时间": 上次更改文件状态（修改索引节点数据）的时间。 由 [`chmod(2)`](http://url.nodejs.cn/K3psEw)、 [`chown(2)`](http://url.nodejs.cn/vSBegL)、 [`link(2)`](http://url.nodejs.cn/U8H1mr)、 [`mknod(2)`](http://url.nodejs.cn/dC6BPb)、 [`rename(2)`](http://url.nodejs.cn/YbqghQ)、 [`unlink(2)`](http://url.nodejs.cn/gjRRsM)、 [`utimes(2)`](http://url.nodejs.cn/58Fxaj)、 [`read(2)`](http://url.nodejs.cn/3BmXqe) 和 [`write(2)`](http://url.nodejs.cn/NmUvmK) 系统调用更改。
-   `birthtime` "创建时间": 文件创建时间。 创建文件时设置一次。 在创建时间不可用的文件系统上，该字段可能改为保存 `ctime` 或 `1970-01-01T00:00Z`（即 Unix 纪元时间戳 `0`）。 在这种情况下，该值可能大于 `atime` 或 `mtime`。 在 Darwin 和其他 FreeBSD 变体上，如果使用 [`utimes(2)`](http://url.nodejs.cn/58Fxaj) 系统调用将 `atime` 显式设置为比当前 `birthtime` 更早的值，也会被设置。

在 Node.js 0.12 之前，`ctime` 是 Windows 系统上的 `birthtime`。 从 0.12 开始，`ctime` 不是“创建时间”，在 Unix 系统上，它从来都不是。

### `fs.WriteStream` 类[#](http://nodejs.cn/api-v12/fs.html#class-fswritestream)

[中英对照](http://nodejs.cn/api-v12/fs/class_fs_writestream.html)

新增于: v0.1.93

-   继承自 [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)

`fs.WriteStream` 的实例是使用 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options) 函数创建和返回的。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-close_2)

[中英对照](http://nodejs.cn/api-v12/fs/event_close_2.html)

新增于: v0.1.93

当 `WriteStream` 的底层文件描述符已关闭时触发。

#### `'open'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-open_1)

[中英对照](http://nodejs.cn/api-v12/fs/event_open_1.html)

新增于: v0.1.93

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v) `WriteStream` 使用的整数文件描述符。

打开 `WriteStream` 的文件时触发。

#### `'ready'` 事件[#](http://nodejs.cn/api-v12/fs.html#event-ready_1)

[中英对照](http://nodejs.cn/api-v12/fs/event_ready_1.html)

新增于: v9.11.0

当 `fs.WriteStream` 准备好使用时触发。

`'open'` 后立即触发。

#### `writeStream.bytesWritten`[#](http://nodejs.cn/api-v12/fs.html#writestreambyteswritten)

[中英对照](http://nodejs.cn/api-v12/fs/writestream_byteswritten.html)

新增于: v0.4.7

到目前为止写入的字节数。 不包括仍在排队等待写入的数据。

#### `writeStream.path`[#](http://nodejs.cn/api-v12/fs.html#writestreampath)

[中英对照](http://nodejs.cn/api-v12/fs/writestream_path.html)

新增于: v0.1.93

流正在写入的文件的路径，如 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options) 的第一个参数中所指定。 如果 `path` 作为字符串传入，则 `writeStream.path` 将是字符串。 如果 `path` 作为 `Buffer` 传入，则 `writeStream.path` 将是 `Buffer`。

#### `writeStream.pending`[#](http://nodejs.cn/api-v12/fs.html#writestreampending)

[中英对照](http://nodejs.cn/api-v12/fs/writestream_pending.html)

新增于: v11.2.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果底层文件尚未打开，即在触发 `'ready'` 事件之前，则此属性为 `true`。

### `fs.access(path[, mode], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsaccesspath-mode-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_access_path_mode_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `fs.constants.F_OK`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

测试用户对 `path` 指定的文件或目录的权限。 `mode` 参数是可选的整数，指定要执行的可访问性检查。 查看[文件访问的常量](http://nodejs.cn/api-v12/fs.html#fs_file_access_constants)以获取可能的 `mode` 值。 可以创建由两个或多个值的按位或组成的掩码（例如 `fs.constants.W_OK | fs.constants.R_OK`）。

最后一个参数 `callback` 是回调函数，其使用一个可能的错误参数调用。 如果任何可访问性检查失败，则错误参数将是 `Error` 对象。 以下示例检查 `package.json` 是否存在，以及是否可读或可写。

```
const file = 'package.json';

// 检查当前目录中是否存在该文件。
fs.access(file, fs.constants.F_OK, (err) => {
  console.log(`${file} ${err ? 'does not exist' : 'exists'}`);
});

// 检查文件是否可读。
fs.access(file, fs.constants.R_OK, (err) => {
  console.log(`${file} ${err ? 'is not readable' : 'is readable'}`);
});

// 检查文件是否可写。
fs.access(file, fs.constants.W_OK, (err) => {
  console.log(`${file} ${err ? 'is not writable' : 'is writable'}`);
});

// 检查当前目录中是否存在文件，是否可写。
fs.access(file, fs.constants.F_OK | fs.constants.W_OK, (err) => {
  if (err) {
    console.error(
      `${file} ${err.code === 'ENOENT' ? 'does not exist' : 'is read-only'}`);
  } else {
    console.log(`${file} exists, and it is writable`);
  }
});
```

在调用 `fs.open()`、`fs.readFile()` 或 `fs.writeFile()` 之前，不要使用 `fs.access()` 检查文件的可访问性。 这样做会引入竞争条件，因为其他进程可能会在两次调用之间更改文件的状态。 而是，用户代码应直接打开/读取/写入文件，并处理无法访问文件时引发的错误。

**写入（不推荐）**

```
fs.access('myfile', (err) => {
  if (!err) {
    console.error('myfile already exists');
    return;
  }

  fs.open('myfile', 'wx', (err, fd) => {
    if (err) throw err;
    writeMyData(fd);
  });
});
```

**写入（推荐）**

```
fs.open('myfile', 'wx', (err, fd) => {
  if (err) {
    if (err.code === 'EEXIST') {
      console.error('myfile already exists');
      return;
    }

    throw err;
  }

  writeMyData(fd);
});
```

**读取（不推荐）**

```
fs.access('myfile', (err) => {
  if (err) {
    if (err.code === 'ENOENT') {
      console.error('myfile does not exist');
      return;
    }

    throw err;
  }

  fs.open('myfile', 'r', (err, fd) => {
    if (err) throw err;
    readMyData(fd);
  });
});
```

**读取（推荐）**

```
fs.open('myfile', 'r', (err, fd) => {
  if (err) {
    if (err.code === 'ENOENT') {
      console.error('myfile does not exist');
      return;
    }

    throw err;
  }

  readMyData(fd);
});
```

上面的“不推荐”示例检查可访问性，然后使用该文件；“推荐”示例更好，因为它们直接使用文件并处理错误（如果有）。

通常，仅当文件不会被直接使用时才检查文件的可访问性，例如当它的可访问性是来自另一个进程的信号时。

在 Windows 上，目录上的访问控制策略 (ACL) 可能会限制对文件或目录的访问。 但是，`fs.access()` 函数不检查 ACL，因此即使 ACL 限制用户读取或写入路径，也可能报告路径可访问。

### `fs.accessSync(path[, mode])`[#](http://nodejs.cn/api-v12/fs.html#fsaccesssyncpath-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fs_accesssync_path_mode.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `fs.constants.F_OK`

同步地测试用户对 `path` 指定的文件或目录的权限。 `mode` 参数是可选的整数，指定要执行的可访问性检查。 查看[文件访问的常量](http://nodejs.cn/api-v12/fs.html#fs_file_access_constants)以获取可能的 `mode` 值。 可以创建由两个或多个值的按位或组成的掩码（例如 `fs.constants.W_OK | fs.constants.R_OK`）。

如果任何可访问性检查失败，将抛出 `Error`。 否则，该方法将返回 `undefined`。

```
try {
  fs.accessSync('etc/passwd', fs.constants.R_OK | fs.constants.W_OK);
  console.log('can read/write');
} catch (err) {
  console.error('no access!');
}
```

### `fs.appendFile(path, data[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsappendfilepath-data-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_appendfile_path_data_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<number>](http://url.nodejs.cn/SXbo1v) 文件名或文件描述符
-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'a'`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步地将数据追加到文件，如果该文件尚不存在，则创建该文件。 `data` 可以是字符串或 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer)。

```
fs.appendFile('message.txt', 'data to append', (err) => {
  if (err) throw err;
  console.log('The "data to append" was appended to file!');
});
```

如果 `options` 是字符串，则它指定编码：

```
fs.appendFile('message.txt', 'data to append', 'utf8', callback);
```

可以将 `path` 指定为已打开用于追加（使用 `fs.open()` 或 `fs.openSync()`）的数字文件描述符。 文件描述符不会自动关闭。

```
fs.open('message.txt', 'a', (err, fd) => {
  if (err) throw err;
  fs.appendFile(fd, 'data to append', 'utf8', (err) => {
    fs.close(fd, (err) => {
      if (err) throw err;
    });
    if (err) throw err;
  });
});
```

### `fs.appendFileSync(path, data[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsappendfilesyncpath-data-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_appendfilesync_path_data_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<number>](http://url.nodejs.cn/SXbo1v) 文件名或文件描述符
-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'a'`。

同步地将数据追加到文件中，如果文件尚不存在则创建该文件。 `data` 可以是字符串或 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer)。

```
try {
  fs.appendFileSync('message.txt', 'data to append');
  console.log('The "data to append" was appended to file!');
} catch (err) {
  /* 处理错误 */
}
```

如果 `options` 是字符串，则它指定编码：

```
fs.appendFileSync('message.txt', 'data to append', 'utf8');
```

可以将 `path` 指定为已打开用于追加（使用 `fs.open()` 或 `fs.openSync()`）的数字文件描述符。 文件描述符不会自动关闭。

```
let fd;

try {
  fd = fs.openSync('message.txt', 'a');
  fs.appendFileSync(fd, 'data to append', 'utf8');
} catch (err) {
  /* 处理错误 */
} finally {
  if (fd !== undefined)
    fs.closeSync(fd);
}
```

### `fs.chmod(path, mode, callback)`[#](http://nodejs.cn/api-v12/fs.html#fschmodpath-mode-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_chmod_path_mode_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步地更改文件的权限。 除了可能的异常之外，没有为完成回调提供任何参数。

另见: [`chmod(2)`](http://url.nodejs.cn/K3psEw)。

```
fs.chmod('my_file.txt', 0o775, (err) => {
  if (err) throw err;
  console.log('The permissions for file "my_file.txt" have been changed!');
});
```

#### 文件的模式[#](http://nodejs.cn/api-v12/fs.html#file-modes)

[中英对照](http://nodejs.cn/api-v12/fs/file_modes.html)

`fs.chmod()` 和 `fs.chmodSync()` 方法中使用的 `mode` 参数是使用以下常量的逻辑或创建的数字位掩码：

| 常量 | 八进制 | 描述 |
| --- | --- | --- |
| `fs.constants.S_IRUSR` | `0o400` | 所有者可读取 |
| `fs.constants.S_IWUSR` | `0o200` | 所有者可写入 |
| `fs.constants.S_IXUSR` | `0o100` | 所有者可执行/搜索 |
| `fs.constants.S_IRGRP` | `0o40` | 群组可读取 |
| `fs.constants.S_IWGRP` | `0o20` | 群组可写入 |
| `fs.constants.S_IXGRP` | `0o10` | 群组可执行/搜索 |
| `fs.constants.S_IROTH` | `0o4` | 其他人可读取 |
| `fs.constants.S_IWOTH` | `0o2` | 其他人可写入 |
| `fs.constants.S_IXOTH` | `0o1` | 其他人可执行/搜索 |

构建 `mode` 的一种更简单的方法是使用三个八进制数字的序列（例如 `765`）。 最左边的数字（示例中的 `7`）指定文件所有者的权限。 中间的数字（示例中的 `6`）指定群组的权限。 最右边的数字（示例中的 `5`）指定其他人的权限。

| Number | 描述 |
| --- | --- |
| `7` | 可读、可写和可执行 |
| `6` | 可读和可写 |
| `5` | 可读和可执行 |
| `4` | 只读 |
| `3` | 可写和可执行 |
| `2` | 只写 |
| `1` | 只可执行 |
| `0` | 无权限 |

例如，八进制值 `0o765` 表示：

-   所有者可以读取、写入和执行文件。
-   群组可以读取和写入文件。
-   其他人可以读取和执行文件。

在需要文件模式的地方使用原始数字时，任何大于 `0o777` 的值都可能导致特定于平台的行为不支持一致工作。 因此，像 `S_ISVTX`、`S_ISGID` 或 `S_ISUID` 这样的常量不会在 `fs.constants` 中暴露。

注意事项：在 Windows 上只能更改写入权限，并没有实现群组、所有者或其他人权限之间的区别。

### `fs.chmodSync(path, mode)`[#](http://nodejs.cn/api-v12/fs.html#fschmodsyncpath-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fs_chmodsync_path_mode.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v)

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.chmod()`](http://nodejs.cn/api-v12/fs.html#fs_fs_chmod_path_mode_callback)。

另见: [`chmod(2)`](http://url.nodejs.cn/K3psEw)。

### `fs.chown(path, uid, gid, callback)`[#](http://nodejs.cn/api-v12/fs.html#fschownpath-uid-gid-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_chown_path_uid_gid_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步地更改文件的所有者和群组。 除了可能的异常之外，没有为完成回调提供任何参数。

另见: [`chown(2)`](http://url.nodejs.cn/vSBegL)。

### `fs.chownSync(path, uid, gid)`[#](http://nodejs.cn/api-v12/fs.html#fschownsyncpath-uid-gid)

[中英对照](http://nodejs.cn/api-v12/fs/fs_chownsync_path_uid_gid.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)

同步地更改文件的所有者和群组。 返回 `undefined`。 这是 [`fs.chown()`](http://nodejs.cn/api-v12/fs.html#fs_fs_chown_path_uid_gid_callback) 的同步版本。

另见: [`chown(2)`](http://url.nodejs.cn/vSBegL)。

### `fs.close(fd, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsclosefd-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_close_fd_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`close(2)`](http://url.nodejs.cn/vCJCMG)。 除了可能的异常之外，没有为完成回调提供任何参数。

通过任何其他 `fs` 操作对当前正在使用的任何文件描述符 (`fd`) 调用 `fs.close()`，则可能会导致未定义的行为。

### `fs.closeSync(fd)`[#](http://nodejs.cn/api-v12/fs.html#fsclosesyncfd)

[中英对照](http://nodejs.cn/api-v12/fs/fs_closesync_fd.html)

新增于: v0.1.21

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)

同步的 [`close(2)`](http://url.nodejs.cn/vCJCMG)。 返回 `undefined`。

通过任何其他 `fs` 操作对当前正在使用的任何文件描述符 (`fd`) 调用 `fs.closeSync()`，则可能会导致未定义的行为。

### `fs.constants`[#](http://nodejs.cn/api-v12/fs.html#fsconstants)

[中英对照](http://nodejs.cn/api-v12/fs/fs_constants.html)

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

返回一个包含文件系统操作常用常量的对象。

### `fs.copyFile(src, dest[, flags], callback)`[#](http://nodejs.cn/api-v12/fs.html#fscopyfilesrc-dest-flags-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_copyfile_src_dest_flags_callback.html)

-   `src` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 要复制的源文件名
-   `dest` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 复制操作的目标文件名
-   `flags` [<number>](http://url.nodejs.cn/SXbo1v) 复制操作的修饰符。 **默认值:** `0`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

异步地将 `src` 复制到 `dest`。 默认情况下，如果 `dest` 已经存在，则会被覆盖。 除了可能的异常之外，没有给回调函数提供任何参数。 Node.js 不保证复制操作的原子性。 如果在打开目标文件进行写入后发生错误，Node.js 将尝试删除目标文件。

`flags` 是可选的整数，用于指定复制操作的行为。 可以创建由两个或多个值的按位或组成的掩码（例如 `fs.constants.COPYFILE_EXCL | fs.constants.COPYFILE_FICLONE`）。

-   `fs.constants.COPYFILE_EXCL`: 如果 `dest` 已经存在，则复制操作将失败。
-   `fs.constants.COPYFILE_FICLONE`: 复制操作将尝试创建写时复制引用链接。 如果平台不支持写时复制，则使用后备复制机制。
-   `fs.constants.COPYFILE_FICLONE_FORCE`: 复制操作将尝试创建写时复制引用链接。 如果平台不支持写时复制，则该操作将失败。

```
const fs = require('fs');

// 默认情况下将创建或覆盖 destination.txt。
fs.copyFile('source.txt', 'destination.txt', (err) => {
  if (err) throw err;
  console.log('source.txt was copied to destination.txt');
});
```

```
const fs = require('fs');
const { COPYFILE_EXCL } = fs.constants;

// 通过使用 COPYFILE_EXCL，如果 destination.txt 存在，则该操作将失败。
fs.copyFile('source.txt', 'destination.txt', COPYFILE_EXCL, callback);
```

### `fs.copyFileSync(src, dest[, flags])`[#](http://nodejs.cn/api-v12/fs.html#fscopyfilesyncsrc-dest-flags)

[中英对照](http://nodejs.cn/api-v12/fs/fs_copyfilesync_src_dest_flags.html)

-   `src` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 要复制的源文件名
-   `dest` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 复制操作的目标文件名
-   `flags` [<number>](http://url.nodejs.cn/SXbo1v) 复制操作的修饰符。 **默认值:** `0`。

同步地复制 `src` 到 `dest`。 默认情况下，如果 `dest` 已经存在，则会被覆盖。 返回 `undefined`。 Node.js 不保证复制操作的原子性。 如果在打开目标文件进行写入后发生错误，Node.js 将尝试删除目标文件。

`flags` 是可选的整数，用于指定复制操作的行为。 可以创建由两个或多个值的按位或组成的掩码（例如 `fs.constants.COPYFILE_EXCL | fs.constants.COPYFILE_FICLONE`）。

-   `fs.constants.COPYFILE_EXCL`: 如果 `dest` 已经存在，则复制操作将失败。
-   `fs.constants.COPYFILE_FICLONE`: 复制操作将尝试创建写时复制引用链接。 如果平台不支持写时复制，则使用后备复制机制。
-   `fs.constants.COPYFILE_FICLONE_FORCE`: 复制操作将尝试创建写时复制引用链接。 如果平台不支持写时复制，则该操作将失败。

```
const fs = require('fs');

// 默认情况下将创建或覆盖 destination.txt。
fs.copyFileSync('source.txt', 'destination.txt');
console.log('source.txt was copied to destination.txt');
```

```
const fs = require('fs');
const { COPYFILE_EXCL } = fs.constants;

// 通过使用 COPYFILE_EXCL，如果 destination.txt 存在，则该操作将失败。
fs.copyFileSync('source.txt', 'destination.txt', COPYFILE_EXCL);
```

### `fs.createReadStream(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fscreatereadstreampath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_createreadstream_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `flags` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'r'`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `null`
    -   `fd` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `null`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `autoClose` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `true`
    -   `emitClose` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
    -   `start` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `end` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `Infinity`
    -   `highWaterMark` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `64 * 1024`
    -   `fs` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `null`
-   返回: [<fs.ReadStream>](http://nodejs.cn/api/fs.html#class-fsreadstream) 参见[可读流](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable)。

与可读流的 16 kb 默认 `highWaterMark` 不同，此方法返回的流的默认 `highWaterMark` 为 64 kb。

`options` 可以包括 `start` 和 `end` 值，以从文件中读取一定范围的字节，而不是整个文件。 `start` 和 `end` 都包含在内并且从 0 开始计数，允许的值在 \[0, [`Number.MAX_SAFE_INTEGER`](http://url.nodejs.cn/e9ereu)\] 范围内。 如果指定了 `fd` 并且 `start` 被省略或 `undefined`，则 `fs.createReadStream()` 从当前文件位置顺序读取。 `encoding` 可以是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer) 接受的任何一种。

如果指定了 `fd`，则 `ReadStream` 将忽略 `path` 参数并使用指定的文件描述符。 这意味着不会触发 `'open'` 事件。 `fd` 应该是阻塞的；非阻塞 `fd` 应该传给 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket)。

如果 `fd` 指向仅支持阻塞读取的字符设备（例如键盘或声卡），则读取操作不会在数据可用之前完成。 这可以防止进程退出和流自然关闭。

将 `emitClose` 选项设置为 `true` 以更改此行为。

通过提供 `fs` 选项，可以覆盖 `open`、`read` 和 `close` 的相应 `fs` 实现。 提供 `fs` 选项时，需要覆盖 `open`、`read` 和 `close`。

```
const fs = require('fs');
// 从某个字符设备创建流。
const stream = fs.createReadStream('/dev/input/event0');
setTimeout(() => {
  stream.close(); // 这可能不会关闭流。
  // 人为地标记流结束，就好像底层资源自己指示了文件结束一样，允许流关闭。
  // 这不会取消挂起的读操作，如果有这样的操作，进程可能仍然无法成功退出，直到它完成。
  stream.push(null);
  stream.read(0);
}, 100);
```

如果 `autoClose` 为 false，则即使出现错误，文件描述符也不会关闭。 关闭它并确保没有文件描述符泄漏是应用程序的责任。 如果 `autoClose` 设置为 true（默认行为），则在 `'error'` 或 `'end'` 时，文件描述符将自动关闭。

`mode` 设置文件模式（权限和粘滞位），但前提是文件已创建。

读取 100 个字节长的文件的最后 10 个字节的示例：

```
fs.createReadStream('sample.txt', { start: 90, end: 99 });
```

如果 `options` 是字符串，则它指定编码。

### `fs.createWriteStream(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fscreatewritestreampath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_createwritestream_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `flags` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'w'`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
    -   `fd` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `null`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `autoClose` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `true`
    -   `emitClose` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
    -   `start` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `fs` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `null`
-   返回: [<fs.WriteStream>](http://nodejs.cn/api/fs.html#class-fswritestream) 参见[可写流](http://nodejs.cn/api-v12/fs.html#stream_class_stream_writable)。

`options` 还可以包括 `start` 选项，以允许在文件开头的某个位置写入数据，允许的值在 \[0, [`Number.MAX_SAFE_INTEGER`](http://url.nodejs.cn/e9ereu)\] 范围内。

`encoding` 可以是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer) 接受的任何一种。

如果将 `autoClose` 设置为 true（默认行为），则在 `'error'` 或 `'finish'` 时文件描述符将自动关闭。 如果 `autoClose` 为 false，则即使出现错误，文件描述符也不会关闭。 关闭它并确保没有文件描述符泄漏是应用程序的责任。

将 `emitClose` 选项设置为 `true` 以更改此行为。

通过提供 `fs` 选项，可以覆盖 `open`、`write`、`writev` 和 `close` 的相应 `fs` 实现。 在没有 `writev()` 的情况下覆盖 `write()` 会降低性能，因为某些优化 (`_writev()`) 将被禁用。 提供 `fs` 选项时，需要覆盖 `open`、`close`、以及 `write` 和 `writev` 中的至少一个。

与 [`ReadStream`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_readstream) 一样，如果指定了 `fd`，则 [`WriteStream`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_writestream) 将忽略 `path` 参数并使用指定的文件描述符。 这意味着不会触发 `'open'` 事件。 `fd` 应该是阻塞的；非阻塞 `fd` 应该传给 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket)。

如果 `options` 是字符串，则它指定编码。

### `fs.exists(path, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsexistspath-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_exists_path_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `exists` [<boolean>](http://url.nodejs.cn/jFbvuT)

通过检查文件系统来测试给定的路径是否存在。 然后使用 true 或 false 调用 `callback` 参数：

```
fs.exists('/etc/passwd', (exists) => {
  console.log(exists ? 'it\'s there' : 'no passwd!');
});
```

**此回调的参数与其他 Node.js 回调不一致。** 通常，Node.js 回调的第一个参数是 `err` 参数，后跟可选的其他参数。 `fs.exists()` 回调只有一个布尔参数。 这是推荐 `fs.access()` 而不是 `fs.exists()` 的原因之一。

不推荐在调用 `fs.open()`、`fs.readFile()` 或 `fs.writeFile()` 之前使用 `fs.exists()` 检查文件是否存在。 这样做会引入竞争条件，因为其他进程可能会在两次调用之间更改文件的状态。 而是，用户代码应该直接打开/读取/写入文件，并在文件不存在时处理引发的错误。

**写入（不推荐）**

```
fs.exists('myfile', (exists) => {
  if (exists) {
    console.error('myfile already exists');
  } else {
    fs.open('myfile', 'wx', (err, fd) => {
      if (err) throw err;
      writeMyData(fd);
    });
  }
});
```

**写入（推荐）**

```
fs.open('myfile', 'wx', (err, fd) => {
  if (err) {
    if (err.code === 'EEXIST') {
      console.error('myfile already exists');
      return;
    }

    throw err;
  }

  writeMyData(fd);
});
```

**读取（不推荐）**

```
fs.exists('myfile', (exists) => {
  if (exists) {
    fs.open('myfile', 'r', (err, fd) => {
      if (err) throw err;
      readMyData(fd);
    });
  } else {
    console.error('myfile does not exist');
  }
});
```

**读取（推荐）**

```
fs.open('myfile', 'r', (err, fd) => {
  if (err) {
    if (err.code === 'ENOENT') {
      console.error('myfile does not exist');
      return;
    }

    throw err;
  }

  readMyData(fd);
});
```

上面的“不推荐”示例检查是否存在，然后使用该文件；“推荐”示例更好，因为它们直接使用文件并处理错误（如果有）。

通常，仅当文件不会被直接使用时才检查文件是否存在，例如当它的存在是来自另一个进程的信号时。

### `fs.existsSync(path)`[#](http://nodejs.cn/api-v12/fs.html#fsexistssyncpath)

[中英对照](http://nodejs.cn/api-v12/fs/fs_existssync_path.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果路径存在则返回 `true`，否则返回 `false`。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.exists()`](http://nodejs.cn/api-v12/fs.html#fs_fs_exists_path_callback)。

`fs.exists()` 已弃用，但 `fs.existsSync()` 不是。 `fs.exists()` 的 `callback` 参数接受与其他 Node.js 回调不一致的参数。 `fs.existsSync()` 不使用回调。

```
if (fs.existsSync('/etc/passwd')) {
  console.log('The path exists.');
}
```

### `fs.fchmod(fd, mode, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsfchmodfd-mode-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fchmod_fd_mode_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`fchmod(2)`](http://url.nodejs.cn/L3LQRh)。 除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.fchmodSync(fd, mode)`[#](http://nodejs.cn/api-v12/fs.html#fsfchmodsyncfd-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fchmodsync_fd_mode.html)

新增于: v0.4.7

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v)

同步的 [`fchmod(2)`](http://url.nodejs.cn/L3LQRh)。 返回 `undefined`。

### `fs.fchown(fd, uid, gid, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsfchownfd-uid-gid-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fchown_fd_uid_gid_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`fchown(2)`](http://url.nodejs.cn/vZfXQ2)。 除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.fchownSync(fd, uid, gid)`[#](http://nodejs.cn/api-v12/fs.html#fsfchownsyncfd-uid-gid)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fchownsync_fd_uid_gid.html)

新增于: v0.4.7

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)

同步的 [`fchown(2)`](http://url.nodejs.cn/vZfXQ2)。 返回 `undefined`。

### `fs.fdatasync(fd, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsfdatasyncfd-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fdatasync_fd_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`fdatasync(2)`](http://url.nodejs.cn/AEp6fv)。 除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.fdatasyncSync(fd)`[#](http://nodejs.cn/api-v12/fs.html#fsfdatasyncsyncfd)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fdatasyncsync_fd.html)

新增于: v0.1.96

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)

同步的 [`fdatasync(2)`](http://url.nodejs.cn/AEp6fv)。 返回 `undefined`。

### `fs.fstat(fd[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsfstatfd-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fstat_fd_options_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `stats` [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)

异步的 [`fstat(2)`](http://url.nodejs.cn/anrsLJ)。 回调有两个参数 `(err, stats)`，其中 `stats` 是 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象。

### `fs.fstatSync(fd[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsfstatsyncfd-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fstatsync_fd_options.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   返回: [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)

同步的 [`fstat(2)`](http://url.nodejs.cn/anrsLJ)。

### `fs.fsync(fd, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsfsyncfd-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fsync_fd_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`fsync(2)`](http://url.nodejs.cn/d4u3Ks)。 除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.fsyncSync(fd)`[#](http://nodejs.cn/api-v12/fs.html#fsfsyncsyncfd)

[中英对照](http://nodejs.cn/api-v12/fs/fs_fsyncsync_fd.html)

新增于: v0.1.96

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)

同步的 [`fsync(2)`](http://url.nodejs.cn/d4u3Ks)。 返回 `undefined`。

### `fs.ftruncate(fd[, len], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsftruncatefd-len-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_ftruncate_fd_len_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `len` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`ftruncate(2)`](http://url.nodejs.cn/nU6hxN)。 除了可能的异常之外，没有为完成回调提供任何参数。

如果文件描述符引用的文件大于 `len` 个字节，则文件中将仅保留前 `len` 个字节。

例如，以下程序仅保留文件的前四个字节：

```
console.log(fs.readFileSync('temp.txt', 'utf8'));
// 打印: Node.js

// 
const fd = fs.openSync('temp.txt', 'r+');

// 
fs.ftruncate(fd, 4, (err) => {
  assert.ifError(err);
  console.log(fs.readFileSync('temp.txt', 'utf8'));
});
// 打印: Node
```

如果文件先前小于 `len` 个字节，则将其扩展，并且扩展部分将使用空字节（`'\0'`）填充：

```
console.log(fs.readFileSync('temp.txt', 'utf8'));
// 打印: Node.js

// 
const fd = fs.openSync('temp.txt', 'r+');

// 
fs.ftruncate(fd, 10, (err) => {
  assert.ifError(err);
  console.log(fs.readFileSync('temp.txt'));
});
// 打印: <Buffer 4e 6f 64 65 2e 6a 73 00 00 00>
// 
```

### `fs.ftruncateSync(fd[, len])`[#](http://nodejs.cn/api-v12/fs.html#fsftruncatesyncfd-len)

[中英对照](http://nodejs.cn/api-v12/fs/fs_ftruncatesync_fd_len.html)

新增于: v0.8.6

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `len` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`

返回 `undefined`。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.ftruncate()`](http://nodejs.cn/api-v12/fs.html#fs_fs_ftruncate_fd_len_callback)。

### `fs.futimes(fd, atime, mtime, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsfutimesfd-atime-mtime-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_futimes_fd_atime_mtime_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

更改提供的文件描述符引用的对象的文件系统时间戳。 参见 [`fs.utimes()`](http://nodejs.cn/api-v12/fs.html#fs_fs_utimes_path_atime_mtime_callback)。

此函数在 7.1 之前的 AIX 版本上不起作用，它将返回错误 `UV_ENOSYS`。

### `fs.futimesSync(fd, atime, mtime)`[#](http://nodejs.cn/api-v12/fs.html#fsfutimessyncfd-atime-mtime)

[中英对照](http://nodejs.cn/api-v12/fs/fs_futimessync_fd_atime_mtime.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)

[`fs.futimes()`](http://nodejs.cn/api-v12/fs.html#fs_fs_futimes_fd_atime_mtime_callback) 的同步版本。 返回 `undefined`。

### `fs.lchmod(path, mode, callback)`[#](http://nodejs.cn/api-v12/fs.html#fslchmodpath-mode-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lchmod_path_mode_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`lchmod(2)`](http://url.nodejs.cn/yC9BxV)。 除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.lchmodSync(path, mode)`[#](http://nodejs.cn/api-v12/fs.html#fslchmodsyncpath-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lchmodsync_path_mode.html)

弃用于: v0.4.7

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<integer>](http://url.nodejs.cn/SXbo1v)

同步的 [`lchmod(2)`](http://url.nodejs.cn/yC9BxV)。 返回 `undefined`。

### `fs.lchown(path, uid, gid, callback)`[#](http://nodejs.cn/api-v12/fs.html#fslchownpath-uid-gid-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lchown_path_uid_gid_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`lchown(2)`](http://url.nodejs.cn/fGGBXD)。 除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.lchownSync(path, uid, gid)`[#](http://nodejs.cn/api-v12/fs.html#fslchownsyncpath-uid-gid)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lchownsync_path_uid_gid.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)

同步的 [`lchown(2)`](http://url.nodejs.cn/fGGBXD)。 返回 `undefined`。

### `fs.lutimes(path, atime, mtime, callback)`[#](http://nodejs.cn/api-v12/fs.html#fslutimespath-atime-mtime-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lutimes_path_atime_mtime_callback.html)

新增于: v12.19.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

以与 [`fs.utimes()`](http://nodejs.cn/api-v12/fs.html#fs_fs_utimes_path_atime_mtime_callback) 相同的方式更改文件的访问和修改时间，不同之处在于，如果路径引用符号链接，则不会取消引用该链接：而是，符号链接本身的时间戳会更改。

除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.lutimesSync(path, atime, mtime)`[#](http://nodejs.cn/api-v12/fs.html#fslutimessyncpath-atime-mtime)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lutimessync_path_atime_mtime.html)

新增于: v12.19.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)

更改 `path` 引用的符号链接的文件系统时间戳。 返回 `undefined`，或在参数不正确或操作失败时抛出异常。 这是 [`fs.lutimes()`](http://nodejs.cn/api-v12/fs.html#fs_fs_lutimes_path_atime_mtime_callback) 的同步版本。

### `fs.link(existingPath, newPath, callback)`[#](http://nodejs.cn/api-v12/fs.html#fslinkexistingpath-newpath-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_link_existingpath_newpath_callback.html)

-   `existingPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `newPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`link(2)`](http://url.nodejs.cn/U8H1mr)。 除了可能的异常之外，没有为完成回调提供任何参数。

### `fs.linkSync(existingPath, newPath)`[#](http://nodejs.cn/api-v12/fs.html#fslinksyncexistingpath-newpath)

[中英对照](http://nodejs.cn/api-v12/fs/fs_linksync_existingpath_newpath.html)

-   `existingPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `newPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)

同步的 [`link(2)`](http://url.nodejs.cn/U8H1mr)。 返回 `undefined`。

### `fs.lstat(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fslstatpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lstat_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `stats` [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)

异步的 [`lstat(2)`](http://url.nodejs.cn/fGaHTu)。 回调有两个参数 `(err, stats)`，其中 `stats` 是 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象。 `lstat()` 与 `stat()` 相同，除了如果 `path` 是符号链接，则被统计的是链接本身，而不是它引用的文件。

### `fs.lstatSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fslstatsyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_lstatsync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   返回: [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)

同步的 [`lstat(2)`](http://url.nodejs.cn/fGaHTu)。

### `fs.mkdir(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsmkdirpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_mkdir_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `recursive` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
    -   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) Windows 上不支持。 **默认值:** `0o777`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步地创建目录。

回调给出一个可能的异常和创建的第一个目录路径（如果 `recursive` 为 `true`），`(err, [path])`。

当 `path` 是已存在的目录时，调用 `fs.mkdir()` 仅在 `recursive` 为 false 时才导致错误。

```
// 创建 /tmp/a/apple，不管 `/tmp` 和 /tmp/a 是否存在。
fs.mkdir('/tmp/a/apple', { recursive: true }, (err) => {
  if (err) throw err;
});
```

在 Windows 上，即使使用递归，在根目录上使用 `fs.mkdir()` 也会导致错误：

```
fs.mkdir('/', { recursive: true }, (err) => {
  // => [Error: EPERM: operation not permitted, mkdir 'C:\']
});
```

另见: [`mkdir(2)`](http://url.nodejs.cn/ebLzdi)。

### `fs.mkdirSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsmkdirsyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_mkdirsync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `recursive` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
    -   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) Windows 上不支持。 **默认值:** `0o777`。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<undefined>](http://url.nodejs.cn/8ym6ow)

同步地创建目录。 返回 `undefined` 或创建的第一个目录路径（如果 `recursive` 为 `true`）。 这是 [`fs.mkdir()`](http://nodejs.cn/api-v12/fs.html#fs_fs_mkdir_path_options_callback) 的同步版本。

另见: [`mkdir(2)`](http://url.nodejs.cn/ebLzdi)。

### `fs.mkdtemp(prefix[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsmkdtempprefix-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_mkdtemp_prefix_options_callback.html)

-   `prefix` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `directory` [<string>](http://url.nodejs.cn/9Tw2bK)

创建唯一的临时目录。

生成六个随机字符，附加在所需的 `prefix` 后面以创建唯一的临时目录。 由于平台的不一致，请避免在 `prefix` 中尾随 `X` 字符。 某些平台，尤其是 BSD，可能返回六个以上的随机字符，并将 `prefix` 中的尾随 `X` 字符替换为随机字符。

创建的目录路径作为字符串传递给回调的第二个参数。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定要使用的字符编码）的对象。

```
fs.mkdtemp(path.join(os.tmpdir(), 'foo-'), (err, directory) => {
  if (err) throw err;
  console.log(directory);
  // 打印: /tmp/foo-itXde2 or C:\Users\...\AppData\Local\Temp\foo-itXde2
});
```

`fs.mkdtemp()` 方法会将六个随机选择的字符直接附加到 `prefix` 字符串。 例如，给定目录 `/tmp`，如果要在 `/tmp` 内创建临时目录，则 `prefix` 必须以平台特定的尾随路径分隔符（`require('path').sep`）结尾。

```
// 新临时目录的父目录
const tmpDir = os.tmpdir();

// 这个方法是*不正确的*：
fs.mkdtemp(tmpDir, (err, directory) => {
  if (err) throw err;
  console.log(directory);
  // 将打印类似于 `/tmpabc123` 的内容。
  // 在文件系统根目录创建一个新的临时目录，而不是在 /tmp 目录中。
});

// 这个方法是*正确的*：
const { sep } = require('path');
fs.mkdtemp(`${tmpDir}${sep}`, (err, directory) => {
  if (err) throw err;
  console.log(directory);
  // 将打印类似于 `/tmp/abc123` 的内容。
  // 在 /tmp 目录中创建一个新的临时目录。
});
```

### `fs.mkdtempSync(prefix[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsmkdtempsyncprefix-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_mkdtempsync_prefix_options.html)

新增于: v5.10.0

-   `prefix` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回创建的目录路径。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.mkdtemp()`](http://nodejs.cn/api-v12/fs.html#fs_fs_mkdtemp_prefix_options_callback)。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定要使用的字符编码）的对象。

### `fs.open(path[, flags[, mode]], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsopenpath-flags-mode-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_open_path_flags_mode_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `flags` [<string>](http://url.nodejs.cn/9Tw2bK) | [<number>](http://url.nodejs.cn/SXbo1v) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'r'`。
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666` （可读可写）
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)

异步地打开文件。 参见 [`open(2)`](http://url.nodejs.cn/ss2dGs)。

`mode` 设置文件模式（权限和粘滞位），但前提是文件已创建。 在 Windows 上，只能操作写入权限；请参阅 [`fs.chmod()`](http://nodejs.cn/api-v12/fs.html#fs_fs_chmod_path_mode_callback)。

回调有两个参数 `(err, fd)`。

在 Windows 上预留了一些字符（`< > : " / \ | ? *`），如[命名文件、路径和命名空间](http://url.nodejs.cn/GmL95W)所记录。 在 NTFS 下，如果文件名包含冒号，则 Node.js 将打开文件系统流，如[此 MSDN 页面](http://url.nodejs.cn/FY8iKV)所述。

基于 `fs.open()` 的函数也表现出这种行为：`fs.writeFile()`、`fs.readFile()` 等。

### `fs.opendir(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsopendirpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_opendir_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `bufferSize` [<number>](http://url.nodejs.cn/SXbo1v) 当从目录读取时，在内部缓冲的目录条目数。 值越大，性能越好，但内存使用率越高。 **默认值:** `32`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `dir` [<fs.Dir>](http://nodejs.cn/api/fs.html#class-fsdir)

异步地打开目录。 参见 [`opendir(3)`](http://url.nodejs.cn/KKZ5fX)。

创建 [`fs.Dir`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dir)，其中包含用于从目录读取和清理目录的所有进一步的函数。

`encoding` 选项设置在打开目录和随后的读取操作时 `path` 的编码。

### `fs.opendirSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsopendirsyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_opendirsync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `bufferSize` [<number>](http://url.nodejs.cn/SXbo1v) 当从目录读取时，在内部缓冲的目录条目数。 值越大，性能越好，但内存使用率越高。 **默认值:** `32`
-   返回: [<fs.Dir>](http://nodejs.cn/api/fs.html#class-fsdir)

同步地打开目录。 参见 [`opendir(3)`](http://url.nodejs.cn/KKZ5fX)。

创建 [`fs.Dir`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dir)，其中包含用于从目录读取和清理目录的所有进一步的函数。

`encoding` 选项设置在打开目录和随后的读取操作时 `path` 的编码。

### `fs.openSync(path[, flags, mode])`[#](http://nodejs.cn/api-v12/fs.html#fsopensyncpath-flags-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fs_opensync_path_flags_mode.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `flags` [<string>](http://url.nodejs.cn/9Tw2bK) | [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `'r'`。 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

返回表示文件描述符的整数。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.open()`](http://nodejs.cn/api-v12/fs.html#fs_fs_open_path_flags_mode_callback)。

### `fs.read(fd, buffer, offset, length, position, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsreadfd-buffer-offset-length-position-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_read_fd_buffer_offset_length_position_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `bytesRead` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

从 `fd` 指定的文件中读取数据。

回调被赋予三个参数，`(err, bytesRead, buffer)`。

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，则其将为具有 `bytesRead` 和 `buffer` 属性的 `Object` 返回 `Promise`。

### `fs.read(fd, [options,] callback)`[#](http://nodejs.cn/api-v12/fs.html#fsreadfd-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_read_fd_options_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) **默认值:** `Buffer.alloc(16384)`
    -   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
    -   `length` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `buffer.length`
    -   `position` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `null`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `bytesRead` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

与上面的 `fs.read` 函数类似，此版本采用可选的 `options` 对象。 如果未指定 `options` 对象，则默认使用上述值。

### `fs.readdir(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsreaddirpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readdir_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
    -   `withFileTypes` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `files` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) | [<fs.Dirent\[\]>](http://nodejs.cn/api/fs.html#class-fsdirent)

异步的 [`readdir(3)`](http://url.nodejs.cn/QvrbKw)。 读取目录的内容。 回调有两个参数 `(err, files)`，其中 `files` 是目录中文件名的数组，不包括 `'.'` 和 `'..'`。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于传给回调的文件名的字符编码）的对象。 如果 `encoding` 设置为 `'buffer'`，则返回的文件名将作为 `Buffer` 对象传入。

如果 `options.withFileTypes` 设置为 `true`，则 `files` 数组将包含 [`fs.Dirent`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dirent) 对象。

### `fs.readdirSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsreaddirsyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readdirsync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
    -   `withFileTypes` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) | [<fs.Dirent\[\]>](http://nodejs.cn/api/fs.html#class-fsdirent)

同步的 [`readdir(3)`](http://url.nodejs.cn/QvrbKw)。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于返回的文件名的字符编码）的对象。 如果 `encoding` 设置为 `'buffer'`，则返回的文件名将作为 `Buffer` 对象传入。

如果 `options.withFileTypes` 设置为 `true`，则结果将包含 [`fs.Dirent`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dirent) 对象。

### `fs.readFile(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsreadfilepath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readfile_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<integer>](http://url.nodejs.cn/SXbo1v) 文件名或文件描述符
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `null`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'r'`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

异步地读取文件的全部内容。

```
fs.readFile('/etc/passwd', (err, data) => {
  if (err) throw err;
  console.log(data);
});
```

回调传入了两个参数 `(err, data)`，其中 `data` 是文件的内容。

如果未指定编码，则返回原始缓冲区。

如果 `options` 是字符串，则它指定编码：

```
fs.readFile('/etc/passwd', 'utf8', callback);
```

当路径是目录时，`fs.readFile()` 和 [`fs.readFileSync()`](http://nodejs.cn/api-v12/fs.html#fs_fs_readfilesync_path_options) 的行为是特定于平台的。 在 macOS、Linux 和 Windows 上，将返回错误。 在 FreeBSD 上，将返回目录内容的表示。

```
// macOS、Linux 和 Windows
fs.readFile('<directory>', (err, data) => {
  // => [Error: EISDIR: illegal operation on a directory, read <directory>]
});

//  FreeBSD
fs.readFile('<directory>', (err, data) => {
  // => null, <data>
});
```

`fs.readFile()` 函数缓冲整个文件。 为了最小化内存成本，在可能的情况下优先通过 `fs.createReadStream()` 进行流式传输。

#### 文件描述符[#](http://nodejs.cn/api-v12/fs.html#file-descriptors_1)

[中英对照](http://nodejs.cn/api-v12/fs/file_descriptors_1.html)

1.  任何指定的文件描述符都必须支持读取。
2.  如果将文件描述符指定为 `path`，则它将不会自动关闭。
3.  读数将从当前位置开始。 例如，如果文件已经具有 `'Hello World'` 并且使用文件描述符读取了六个字节，则使用相同文件描述符对 `fs.readFile()` 的调用将得到 `'World'`，而不是 `'Hello World'`。

### `fs.readFileSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsreadfilesyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readfilesync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<integer>](http://url.nodejs.cn/SXbo1v) 文件名或文件描述符
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `null`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'r'`。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

返回 `path` 的内容。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.readFile()`](http://nodejs.cn/api-v12/fs.html#fs_fs_readfile_path_options_callback)。

如果指定了 `encoding` 选项，则此函数返回字符串。 否则它返回缓冲区。

与 [`fs.readFile()`](http://nodejs.cn/api-v12/fs.html#fs_fs_readfile_path_options_callback) 类似，当路径为目录时，`fs.readFileSync()` 的行为是特定于平台的。

```
// macOS、Linux 和 Windows
fs.readFileSync('<directory>');
// => [Error: EISDIR: illegal operation on a directory, read <directory>]

//  FreeBSD
fs.readFileSync('<directory>'); // => <data>
```

### `fs.readlink(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsreadlinkpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readlink_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `linkString` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

异步的 [`readlink(2)`](http://url.nodejs.cn/CFw99K)。 回调有两个参数 `(err, linkString)`。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于传给回调的链接路径的字符编码）的对象。 如果将 `encoding` 设置为 `'buffer'`，则返回的链接路径将作为 `Buffer` 对象传入。

### `fs.readlinkSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsreadlinksyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readlinksync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

同步的 [`readlink(2)`](http://url.nodejs.cn/CFw99K)。 返回符号链接的字符串值。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于返回的链接路径的字符编码）的对象。 如果将 `encoding` 设置为 `'buffer'`，则返回的链接路径将作为 `Buffer` 对象传入。

### `fs.readSync(fd, buffer, offset, length, position)`[#](http://nodejs.cn/api-v12/fs.html#fsreadsyncfd-buffer-offset-length-position)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readsync_fd_buffer_offset_length_position.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

返回 `bytesRead` 的数量。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.read()`](http://nodejs.cn/api-v12/fs.html#fs_fs_read_fd_buffer_offset_length_position_callback)。

### `fs.readSync(fd, buffer, [options])`[#](http://nodejs.cn/api-v12/fs.html#fsreadsyncfd-buffer-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readsync_fd_buffer_options.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
    -   `length` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `buffer.length`
    -   `position` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `null`
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

返回 `bytesRead` 的数量。

与上面的 `fs.readSync` 函数类似，此版本采用可选的 `options` 对象。 如果未指定 `options` 对象，则默认使用上述值。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.read()`](http://nodejs.cn/api-v12/fs.html#fs_fs_read_fd_buffer_offset_length_position_callback)。

### `fs.readv(fd, buffers[, position], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsreadvfd-buffers-position-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readv_fd_buffers_position_callback.html)

新增于: v12.17.0

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `bytesRead` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)

从 `fd` 指定的文件中读取并使用 `readv()` 写入 `ArrayBufferView` 数组。

`position` 是从文件开头应该读取数据的偏移量。 如果 `typeof position !== 'number'`，则从当前位置读取数据。

回调将被赋予三个参数：`err`、`bytesRead` 和 `buffers`。 `bytesRead` 是从文件中读取的字节数。

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，则其将为具有 `bytesRead` 和 `buffers` 属性的 `Object` 返回 `Promise`。

### `fs.readvSync(fd, buffers[, position])`[#](http://nodejs.cn/api-v12/fs.html#fsreadvsyncfd-buffers-position)

[中英对照](http://nodejs.cn/api-v12/fs/fs_readvsync_fd_buffers_position.html)

新增于: v12.17.0

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 读取的字节数。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.readv()`](http://nodejs.cn/api-v12/fs.html#fs_fs_readv_fd_buffers_position_callback)。

### `fs.realpath(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsrealpathpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_realpath_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `resolvedPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

通过解析 `.`、`..` 和符号链接异步地计算规范路径名。

规范路径名不一定是唯一的。 硬链接和绑定挂载可以通过许多路径名暴露文件系统实体。

此函数的行为类似于 [`realpath(3)`](http://url.nodejs.cn/k8V6gK)，但有一些例外：

1.  在不区分大小写的文件系统上不执行大小写转换。
    
2.  符号链接的最大数量与平台无关，并且通常（远）高于原生 [`realpath(3)`](http://url.nodejs.cn/k8V6gK) 实现支持的数量。
    

`callback` 有两个参数 `(err, resolvedPath)`。 可以使用 `process.cwd` 来解析相对路径。

仅支持可以转换为 UTF8 字符串的路径。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于传给回调的路径的字符编码）的对象。 如果 `encoding` 设置为 `'buffer'`，则返回的路径将作为 `Buffer` 对象传入。

如果 `path` 解析为套接字或管道，则该函数将返回该对象的系统相关名称。

### `fs.realpath.native(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsrealpathnativepath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_realpath_native_path_options_callback.html)

新增于: v9.2.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `resolvedPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

异步的 [`realpath(3)`](http://url.nodejs.cn/k8V6gK)。

`callback` 有两个参数 `(err, resolvedPath)`。

仅支持可以转换为 UTF8 字符串的路径。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于传给回调的路径的字符编码）的对象。 如果 `encoding` 设置为 `'buffer'`，则返回的路径将作为 `Buffer` 对象传入。

在 Linux 上，将 Node.js 与 musl libc 链接时，必须将 procfs 文件系统挂载在 `/proc` 上，此函数才能起作用。 Glibc 没有此限制。

### `fs.realpathSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsrealpathsyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_realpathsync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

返回解析的路径名。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.realpath()`](http://nodejs.cn/api-v12/fs.html#fs_fs_realpath_path_options_callback)。

### `fs.realpathSync.native(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsrealpathsyncnativepath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_realpathsync_native_path_options.html)

新增于: v9.2.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

同步的 [`realpath(3)`](http://url.nodejs.cn/k8V6gK)。

仅支持可以转换为 UTF8 字符串的路径。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于返回的路径的字符编码）的对象。 如果 `encoding` 设置为 `'buffer'`，则返回的路径将作为 `Buffer` 对象传入。

在 Linux 上，将 Node.js 与 musl libc 链接时，必须将 procfs 文件系统挂载在 `/proc` 上，此函数才能起作用。 Glibc 没有此限制。

### `fs.rename(oldPath, newPath, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsrenameoldpath-newpath-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_rename_oldpath_newpath_callback.html)

-   `oldPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `newPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

将 `oldPath` 处的文件异步重命名为作为 `newPath` 提供的路径名。 如果 `newPath` 已经存在，则它将被覆盖。 如果 `newPath` 是目录，则会引发错误。 除了可能的异常之外，没有为完成回调提供任何参数。

另见: [`rename(2)`](http://url.nodejs.cn/YbqghQ)。

```
fs.rename('oldFile.txt', 'newFile.txt', (err) => {
  if (err) throw err;
  console.log('Rename complete!');
});
```

### `fs.renameSync(oldPath, newPath)`[#](http://nodejs.cn/api-v12/fs.html#fsrenamesyncoldpath-newpath)

[中英对照](http://nodejs.cn/api-v12/fs/fs_renamesync_oldpath_newpath.html)

-   `oldPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `newPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)

同步的 [`rename(2)`](http://url.nodejs.cn/YbqghQ)。 返回 `undefined`。

### `fs.rmdir(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsrmdirpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_rmdir_path_options_callback.html)

[稳定性: 1](http://nodejs.cn/api/documentation.html#stability-index) - Recursive removal 是实验的。

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `maxRetries` [<integer>](http://url.nodejs.cn/SXbo1v) 此选项表示重试次数。 如果 `recursive` 选项不为 `true`，则忽略此选项。 **默认值:** `0`。
    -   `recursive` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则执行递归目录删除。 在递归模式下，当 `path` 不存在时不报错，当操作失败时则重试。 **默认值:** `false`。
    -   `retryDelay` [<integer>](http://url.nodejs.cn/SXbo1v) 重试之间等待的时间（以毫秒为单位）。 如果 `recursive` 选项不为 `true`，则忽略此选项。 **默认值:** `100`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`rmdir(2)`](http://url.nodejs.cn/BuUYuq)。 除了可能的异常之外，没有为完成回调提供任何参数。

在文件（而不是目录）上使用 `fs.rmdir()`，则在 Windows 上会导致 `ENOENT` 错误，在 POSIX 上会导致 `ENOTDIR` 错误。

### `fs.rmdirSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsrmdirsyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_rmdirsync_path_options.html)

[稳定性: 1](http://nodejs.cn/api/documentation.html#stability-index) - Recursive removal 是实验的。

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `maxRetries` [<integer>](http://url.nodejs.cn/SXbo1v) 此选项表示重试次数。 如果 `recursive` 选项不为 `true`，则忽略此选项。 **默认值:** `0`。
    -   `recursive` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则执行递归目录删除。 在递归模式下，当 `path` 不存在时不报错，当操作失败时则重试。 **默认值:** `false`。
    -   `retryDelay` [<integer>](http://url.nodejs.cn/SXbo1v) 重试之间等待的时间（以毫秒为单位）。 如果 `recursive` 选项不为 `true`，则忽略此选项。 **默认值:** `100`。

同步的 [`rmdir(2)`](http://url.nodejs.cn/BuUYuq)。 返回 `undefined`。

在文件（而不是目录）上使用 `fs.rmdirSync()`，则在 Windows 上会导致 `ENOENT` 错误，在 POSIX 上会导致 `ENOTDIR` 错误。

### `fs.stat(path[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fsstatpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_stat_path_options_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `stats` [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)

异步的 [`stat(2)`](http://url.nodejs.cn/7U6CBC)。 回调有两个参数 `(err, stats)`，其中 `stats` 是 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象。

如果出现错误，`err.code` 将是[常见系统错误](http://nodejs.cn/api-v12/errors.html#errors_common_system_errors)之一。

不推荐在调用 `fs.open()`、`fs.readFile()` 或 `fs.writeFile()` 之前使用 `fs.stat()` 检查文件是否存在。 而是，用户代码应该直接打开/读取/写入文件，并在文件不可用时处理引发的错误。

要检查文件是否存在而不对其进行操作，建议使用 [`fs.access()`](http://nodejs.cn/api-v12/fs.html#fs_fs_access_path_mode_callback)。

例如，给定以下目录结构：

```
- txtDir
-- file.txt
- app.js
```

下一个程序将检查给定路径的统计信息：

```
const fs = require('fs');

const pathsToCheck = ['./txtDir', './txtDir/file.txt'];

for (let i = 0; i < pathsToCheck.length; i++) {
  fs.stat(pathsToCheck[i], function(err, stats) {
    console.log(stats.isDirectory());
    console.log(stats);
  });
}
```

结果输出将类似于：

```
true
Stats {
  dev: 16777220,
  mode: 16877,
  nlink: 3,
  uid: 501,
  gid: 20,
  rdev: 0,
  blksize: 4096,
  ino: 14214262,
  size: 96,
  blocks: 0,
  atimeMs: 1561174653071.963,
  mtimeMs: 1561174614583.3518,
  ctimeMs: 1561174626623.5366,
  birthtimeMs: 1561174126937.2893,
  atime: 2019-06-22T03:37:33.072Z,
  mtime: 2019-06-22T03:36:54.583Z,
  ctime: 2019-06-22T03:37:06.624Z,
  birthtime: 2019-06-22T03:28:46.937Z
}
false
Stats {
  dev: 16777220,
  mode: 33188,
  nlink: 1,
  uid: 501,
  gid: 20,
  rdev: 0,
  blksize: 4096,
  ino: 14214074,
  size: 8,
  blocks: 8,
  atimeMs: 1561174616618.8555,
  mtimeMs: 1561174614584,
  ctimeMs: 1561174614583.8145,
  birthtimeMs: 1561174007710.7478,
  atime: 2019-06-22T03:36:56.619Z,
  mtime: 2019-06-22T03:36:54.584Z,
  ctime: 2019-06-22T03:36:54.584Z,
  birthtime: 2019-06-22T03:26:47.711Z
}
```

### `fs.statSync(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fsstatsyncpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_statsync_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   返回: [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)

同步的 [`stat(2)`](http://url.nodejs.cn/7U6CBC)。

### `fs.symlink(target, path[, type], callback)`[#](http://nodejs.cn/api-v12/fs.html#fssymlinktarget-path-type-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_symlink_target_path_type_callback.html)

-   `target` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `type` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

除了可能的异常之外，没有为完成回调提供任何参数。

`type` 参数仅在 Windows 上可用，在其他平台上被忽略。 可以设置为 `'dir'`、`'file'` 或 `'junction'`。 如果未设置 `type` 参数，Node.js 将自动检测 `target` 类型并使用 `'file'` 或 `'dir'`。 如果 `target` 不存在，将使用 `'file'`。 Windows 交接点要求目标路径是绝对路径。 使用 `'junction'` 时，`target` 参数将自动规范化为绝对路径。

相对目标相对于链接的父目录。

```
fs.symlink('./mew', './example/mewtwo', callback);
```

上面的示例在 `example` 中创建符号链接 `mewtwo`，其指向同一个目录中的 `mew`：

```
$ tree example/
example/
├── mew
└── mewtwo -> ./mew
```

### `fs.symlinkSync(target, path[, type])`[#](http://nodejs.cn/api-v12/fs.html#fssymlinksynctarget-path-type)

[中英对照](http://nodejs.cn/api-v12/fs/fs_symlinksync_target_path_type.html)

-   `target` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `type` [<string>](http://url.nodejs.cn/9Tw2bK)

返回 `undefined`。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.symlink()`](http://nodejs.cn/api-v12/fs.html#fs_fs_symlink_target_path_type_callback)。

### `fs.truncate(path[, len], callback)`[#](http://nodejs.cn/api-v12/fs.html#fstruncatepath-len-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_truncate_path_len_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `len` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步的 [`truncate(2)`](http://url.nodejs.cn/9o417s)。 除了可能的异常之外，没有为完成回调提供任何参数。 文件描述符也可以作为第一个参数传入。 在这种情况下，`fs.ftruncate()` 被调用。

不推荐传入文件描述符，并且可能会导致将来抛出错误。

### `fs.truncateSync(path[, len])`[#](http://nodejs.cn/api-v12/fs.html#fstruncatesyncpath-len)

[中英对照](http://nodejs.cn/api-v12/fs/fs_truncatesync_path_len.html)

新增于: v0.8.6

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `len` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`

同步的 [`truncate(2)`](http://url.nodejs.cn/9o417s)。 返回 `undefined`。 文件描述符也可以作为第一个参数传入。 在这种情况下，`fs.ftruncateSync()` 被调用。

不推荐传入文件描述符，并且可能会导致将来抛出错误。

### `fs.unlink(path, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsunlinkpath-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_unlink_path_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

异步地删除文件或符号链接。 除了可能的异常之外，没有为完成回调提供任何参数。

```
// 假设 'path/file.txt' 是普通文件。
fs.unlink('path/file.txt', (err) => {
  if (err) throw err;
  console.log('path/file.txt was deleted');
});
```

`fs.unlink()` 不适用于目录，无论是空目录还是其他目录。 要删除目录，请使用 [`fs.rmdir()`](http://nodejs.cn/api-v12/fs.html#fs_fs_rmdir_path_options_callback)。

另见: [`unlink(2)`](http://url.nodejs.cn/gjRRsM)。

### `fs.unlinkSync(path)`[#](http://nodejs.cn/api-v12/fs.html#fsunlinksyncpath)

[中英对照](http://nodejs.cn/api-v12/fs/fs_unlinksync_path.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)

同步的 [`unlink(2)`](http://url.nodejs.cn/gjRRsM)。 返回 `undefined`。

### `fs.unwatchFile(filename[, listener])`[#](http://nodejs.cn/api-v12/fs.html#fsunwatchfilefilename-listener)

[中英对照](http://nodejs.cn/api-v12/fs/fs_unwatchfile_filename_listener.html)

新增于: v0.1.31

-   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 可选，先前使用 `fs.watchFile()` 附加的监听器。

停止监视 `filename` 的变化。 如果指定了 `listener`，则仅删除该特定监听器。 否则，所有监听器都将被删除，从而有效地停止监视 `filename`。

使用未被监视的文件名调用 `fs.unwatchFile()` 是空操作，而不是错误。

使用 [`fs.watch()`](http://nodejs.cn/api-v12/fs.html#fs_fs_watch_filename_options_listener) 比 `fs.watchFile()` 和 `fs.unwatchFile()` 更高效。 应尽可能使用 `fs.watch()` 而不是 `fs.watchFile()` 和 `fs.unwatchFile()`。

### `fs.utimes(path, atime, mtime, callback)`[#](http://nodejs.cn/api-v12/fs.html#fsutimespath-atime-mtime-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_utimes_path_atime_mtime_callback.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

更改 `path` 引用的对象的文件系统时间戳。

`atime` 和 `mtime` 参数遵循以下规则：

-   值可以是代表 Unix 纪元时间的数字、`Date`、或数字字符串（例如 `'123456789.0'`）。
-   如果该值不能转换为数字，或者是 `NaN`，`Infinity` 或 `-Infinity`，则将抛出 `Error`。

### `fs.utimesSync(path, atime, mtime)`[#](http://nodejs.cn/api-v12/fs.html#fsutimessyncpath-atime-mtime)

[中英对照](http://nodejs.cn/api-v12/fs/fs_utimessync_path_atime_mtime.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)

返回 `undefined`。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.utimes()`](http://nodejs.cn/api-v12/fs.html#fs_fs_utimes_path_atime_mtime_callback)。

### `fs.watch(filename[, options][, listener])`[#](http://nodejs.cn/api-v12/fs.html#fswatchfilename-options-listener)

[中英对照](http://nodejs.cn/api-v12/fs/fs_watch_filename_options_listener.html)

-   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `persistent` [<boolean>](http://url.nodejs.cn/jFbvuT) 指示只要正在监视文件，进程是否应继续运行。 **默认值:** `true`。
    -   `recursive` [<boolean>](http://url.nodejs.cn/jFbvuT) 指示是应监视所有子目录，还是仅监视当前目录。 **默认值:** `false`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 指定用于传给监听器的文件名的字符编码。 **默认值:** `'utf8'`。
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) | [<undefined>](http://url.nodejs.cn/8ym6ow) **默认值:** `undefined`
    -   `eventType` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   返回: [<fs.FSWatcher>](http://nodejs.cn/api/fs.html#class-fsfswatcher)

监视 `filename` 的变化，其中 `filename` 是文件或目录。

第二个参数是可选的。 如果 `options` 作为字符串提供，则它指定 `encoding`。 否则 `options` 应作为对象传入。

监听器回调有两个参数 `(eventType, filename)`。 `eventType` 是 `'rename'` 或 `'change'`，`filename` 是触发事件的文件的名称。

在大多数平台上，只要目录中文件名出现或消失，就会触发 `'rename'`。

监听器回调绑定到由 [`fs.FSWatcher`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_fswatcher) 触发的 `'change'` 事件，但它与 `eventType` 的 `'change'` 值不同。

#### 注意事项[#](http://nodejs.cn/api-v12/fs.html#caveats)

[中英对照](http://nodejs.cn/api-v12/fs/caveats.html)

`fs.watch` API 跨平台并非 100% 一致，并且在某些情况下不可用。

递归选项仅在 macOS 和 Windows 上受支持。

在 Windows 上，如果监视目录被移动或重命名，则不会触发任何事件。 删除监视目录时报 `EPERM` 错误。

##### 可用性[#](http://nodejs.cn/api-v12/fs.html#availability)

[中英对照](http://nodejs.cn/api-v12/fs/availability.html)

此功能取决于底层操作系统提供了一种通知文件系统更改的方法。

-   在 Linux 系统上，这使用 [`inotify(7)`](http://url.nodejs.cn/2vfjsf)。
-   在 BSD 系统上，这使用 [`kqueue(2)`](http://url.nodejs.cn/sKFUBp)。
-   在 macOS 上，这对文件使用 [`kqueue(2)`](http://url.nodejs.cn/sKFUBp)，对目录使用 [`FSEvents`](http://url.nodejs.cn/Asxgry)。
-   在 SunOS 系统（包括 Solaris 和 SmartOS）上，这使用 [`event ports`](http://url.nodejs.cn/bqLYZP)。
-   在 Windows 系统上，此功能取决于 [`ReadDirectoryChangesW`](http://url.nodejs.cn/Tbrfbe)。

-   在 IBM i 系统上，不支持此功能。

例如，使用虚拟化软件（例如 Vagrant 或 Docker）时，在网络文件系统（NFS、SMB等）或主机文件系统上监视文件或目录可能不可靠，在某些情况下甚至是不可能的。

仍然可以使用 `fs.watchFile()`，它使用 stat 轮询，但这种方法较慢且不太可靠。

##### 索引节点[#](http://nodejs.cn/api-v12/fs.html#inodes)

[中英对照](http://nodejs.cn/api-v12/fs/inodes.html)

在 Linux 和 macOS 系统上，`fs.watch()` 解析[索引节点](http://url.nodejs.cn/ofGTst)的路径并监视索引节点。 如果监视路径被删除并重新创建，则会为其分配一个新的索引节点。 监视将触发删除事件，但将继续监视原始索引节点。 不会发出新索引节点的事件。 这是预期的行为。

AIX 文件在文件的生命周期内保留相同的索引节点。 在 AIX 上保存和关闭监视文件将产生两个通知（一个用于添加新内容，另一个用于截断）。

##### 文件名参数[#](http://nodejs.cn/api-v12/fs.html#filename-argument)

[中英对照](http://nodejs.cn/api-v12/fs/filename_argument.html)

仅在 Linux、macOS、Windows 和 AIX 上支持在回调中提供 `filename` 参数。 即使在支持的平台上，也不能保证始终提供 `filename`。 因此，不要假设回调中总是提供 `filename` 参数，如果它为 `null`，则有一些回退逻辑。

```
fs.watch('somedir', (eventType, filename) => {
  console.log(`event type is: ${eventType}`);
  if (filename) {
    console.log(`filename provided: ${filename}`);
  } else {
    console.log('filename not provided');
  }
});
```

### `fs.watchFile(filename[, options], listener)`[#](http://nodejs.cn/api-v12/fs.html#fswatchfilefilename-options-listener)

[中英对照](http://nodejs.cn/api-v12/fs/fs_watchfile_filename_options_listener.html)

-   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
    -   `persistent` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `true`
    -   `interval` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `5007`
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `current` [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)
    -   `previous` [<fs.Stats>](http://nodejs.cn/api/fs.html#class-fsstats)
-   返回: [<fs.StatWatcher>](http://nodejs.cn/api/fs.html#class-fsstatwatcher)

监视 `filename` 的变化。 每次访问文件时都会调用回调 `listener`。

可以省略 `options` 参数。 如果提供，它应该是一个对象。 `options` 对象可以包含名为 `persistent` 的布尔值，其指示当文件正在被监视时，进程是否应该继续运行。 `options` 对象可以指定 `interval` 属性，指示应该轮询目标的频率（以毫秒为单位）。

`listener` 具有两个参数，当前的统计对象和上一个统计对象：

```
fs.watchFile('message.text', (curr, prev) => {
  console.log(`the current mtime is: ${curr.mtime}`);
  console.log(`the previous mtime was: ${prev.mtime}`);
});
```

这些统计对象是 `fs.Stat` 的实例。 如果 `bigint` 选项为 `true`，则这些对象中的数值被指定为 `BigInt`。

要在文件被修改（而不仅仅是访问）时得到通知，则需要比较 `curr.mtime` 和 `prev.mtime`。

当 `fs.watchFile` 操作导致 `ENOENT` 错误时，它将调用监听器一次，且所有字段均清零（或者，对于日期，则为 Unix Epoch）。 如果文件是后来创建的，则将使用最新的统计对象再次调用监听器。 这是自 v0.10 以来的功能变化。

使用 [`fs.watch()`](http://nodejs.cn/api-v12/fs.html#fs_fs_watch_filename_options_listener) 比 `fs.watchFile` 和 `fs.unwatchFile` 更高效。 应尽可能使用 `fs.watch` 而不是 `fs.watchFile` 和 `fs.unwatchFile`。

当 `fs.watchFile()` 正在监视的文件消失并重新出现时，则第二个回调事件（文件的重新出现）中的 `previous` 的内容将与第一个回调事件（文件的消失）中的 `previous` 的内容相同。

这发生在：

-   文件被删除，然后恢复
-   文件被重命名，然后再次重命名回其原始名称

### `fs.write(fd, buffer[, offset[, length[, position]]], callback)`[#](http://nodejs.cn/api-v12/fs.html#fswritefd-buffer-offset-length-position-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_write_fd_buffer_offset_length_position_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `bytesWritten` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)

将 `buffer` 写入 `fd` 指定的文件。

`offset` 确定要写入的缓冲区部分，`length` 是整数，指定要写入的字节数。

`position` 指从文件开头数据应被写入的偏移量。 如果 `typeof position !== 'number'`，则数据将写入当前位置。 参见 [`pwrite(2)`](http://url.nodejs.cn/2qJ9AM)。

回调将提供三个参数 `(err, bytesWritten, buffer)`，其中 `bytesWritten` 指定从 `buffer` 写入的字节数。

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，则其将为具有 `bytesWritten` 和 `buffer` 属性的 `Object` 返回 `Promise`。

在同一个文件上多次使用 `fs.write()` 而不等待回调是不安全的。 对于这种情况，建议使用 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options)。

在 Linux 上，以追加模式打开文件时，位置写入不起作用。 内核会忽略位置参数，并始终将数据追加到文件末尾。

### `fs.write(fd, string[, position[, encoding]], callback)`[#](http://nodejs.cn/api-v12/fs.html#fswritefd-string-position-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_write_fd_string_position_encoding_callback.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `written` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `string` [<string>](http://url.nodejs.cn/9Tw2bK)

将 `string` 写入 `fd` 指定的文件。

`position` 指从文件开头数据应被写入的偏移量。 如果 `typeof position !== 'number'`，则数据将写入当前位置。 参见 [`pwrite(2)`](http://url.nodejs.cn/2qJ9AM)。

`encoding` 是预期的字符串编码。

回调将接收参数 `(err, written, string)`，其中 `written` 指定传入的字符串需要被写入的字节数。 写入的字节数不一定与写入的字符串字符数相同。 参见 [`Buffer.byteLength`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_bytelength_string_encoding)。

在同一个文件上多次使用 `fs.write()` 而不等待回调是不安全的。 对于这种情况，建议使用 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options)。

在 Linux 上，以追加模式打开文件时，位置写入不起作用。 内核会忽略位置参数，并始终将数据追加到文件末尾。

在 Windows 上，如果文件描述符连接到控制台（例如 `fd == 1` 或 `stdout`），则默认情况下无论使用何种编码，都无法正确呈现包含非 ASCII 字符的字符串。 通过使用 `chcp 65001` 命令更改激活的代码页，可以将控制台配置为可正确呈现 UTF-8。 有关更多详细信息，请参阅 [chcp](http://url.nodejs.cn/NAMZkR) 文档。

### `fs.writeFile(file, data[, options], callback)`[#](http://nodejs.cn/api-v12/fs.html#fswritefilefile-data-options-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_writefile_file_data_options_callback.html)

-   `file` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<integer>](http://url.nodejs.cn/SXbo1v) 文件名或文件描述符
-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'w'`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

当 `file` 是文件名时，将数据异步地写入文件，如果文件已存在则替换该文件。 `data` 可以是字符串或缓冲区。

当 `file` 是文件描述符时，其行为类似于直接调用 `fs.write()`（推荐）。 请参阅以下有关使用文件描述符的说明。

如果 `data` 是缓冲区，则忽略 `encoding` 选项。

```
const data = new Uint8Array(Buffer.from('Hello Node.js'));
fs.writeFile('message.txt', data, (err) => {
  if (err) throw err;
  console.log('The file has been saved!');
});
```

如果 `options` 是字符串，则它指定编码：

```
fs.writeFile('message.txt', 'Hello Node.js', 'utf8', callback);
```

在同一个文件上多次使用 `fs.writeFile()` 而不等待回调是不安全的。 对于这种情况，建议使用 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options)。

#### 将 fs.writeFile() 与文件描述符一起使用[#](http://nodejs.cn/api-v12/fs.html#using-fswritefile-with-file-descriptors)

[中英对照](http://nodejs.cn/api-v12/fs/using_fs_writefile_with_file_descriptors.html)

当 `file` 是文件描述符时，其行为几乎与直接调用 `fs.write()` 相同，例如：

```
fs.write(fd, Buffer.from(data, options.encoding), callback);
```

其含义是常见的混淆来源。 在文件描述符的情况下，文件不会被替换！ 数据不一定写入文件的开头，文件的原始数据可以保留在新写入的数据之前和/或之后。

例如，如果连续调用 `fs.writeFile()` 两次，首先写入字符串 `'Hello'`，然后写入字符串 `', World'`，该文件将包含 `'Hello, World'`，并且可能包含文件的一些原始数据（这取决于原始文件的大小和文件描述符的位置）。 如果使用文件名而不是描述符，则文件将保证仅包含 `', World'`。

### `fs.writeFileSync(file, data[, options])`[#](http://nodejs.cn/api-v12/fs.html#fswritefilesyncfile-data-options)

[中英对照](http://nodejs.cn/api-v12/fs/fs_writefilesync_file_data_options.html)

-   `file` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<integer>](http://url.nodejs.cn/SXbo1v) 文件名或文件描述符
-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'w'`。

返回 `undefined`。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.writeFile()`](http://nodejs.cn/api-v12/fs.html#fs_fs_writefile_file_data_options_callback)。

### `fs.writeSync(fd, buffer[, offset[, length[, position]]])`[#](http://nodejs.cn/api-v12/fs.html#fswritesyncfd-buffer-offset-length-position)

[中英对照](http://nodejs.cn/api-v12/fs/fs_writesync_fd_buffer_offset_length_position.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 写入的字节数。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.write(fd, buffer...)`](http://nodejs.cn/api-v12/fs.html#fs_fs_write_fd_buffer_offset_length_position_callback)。

### `fs.writeSync(fd, string[, position[, encoding]])`[#](http://nodejs.cn/api-v12/fs.html#fswritesyncfd-string-position-encoding)

[中英对照](http://nodejs.cn/api-v12/fs/fs_writesync_fd_string_position_encoding.html)

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 写入的字节数。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.write(fd, string...)`](http://nodejs.cn/api-v12/fs.html#fs_fs_write_fd_string_position_encoding_callback)。

### `fs.writev(fd, buffers[, position], callback)`[#](http://nodejs.cn/api-v12/fs.html#fswritevfd-buffers-position-callback)

[中英对照](http://nodejs.cn/api-v12/fs/fs_writev_fd_buffers_position_callback.html)

新增于: v12.9.0

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `bytesWritten` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)

使用 `writev()` 将 `ArrayBufferView` 数组写入 `fd` 指定的文件。

`position` 是该数据应写入的文件开头的偏移量。 如果 `typeof position !== 'number'`，则数据将写入当前位置。

回调将被赋予三个参数：`err`、`bytesWritten` 和 `buffers`。 `bytesWritten` 是从 `buffers` 写入的字节数。

在同一个文件上多次使用 `fs.writev()` 而不等待回调是不安全的。 对于这种情况，请使用 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options)。

在 Linux 上，以追加模式打开文件时，位置写入不起作用。 内核会忽略位置参数，并始终将数据追加到文件末尾。

### `fs.writevSync(fd, buffers[, position])`[#](http://nodejs.cn/api-v12/fs.html#fswritevsyncfd-buffers-position)

[中英对照](http://nodejs.cn/api-v12/fs/fs_writevsync_fd_buffers_position.html)

新增于: v12.9.0

-   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 写入的字节数。

有关详细信息，请参阅此 API 的异步版本的文档：[`fs.writev()`](http://nodejs.cn/api-v12/fs.html#fs_fs_writev_fd_buffers_position_callback)。

### `fs` Promises API[#](http://nodejs.cn/api-v12/fs.html#fs-promises-api)

[中英对照](http://nodejs.cn/api-v12/fs/fs_promises_api.html)

API 可通过 `require('fs').promises` 访问。

#### `FileHandle` 类[#](http://nodejs.cn/api-v12/fs.html#class-filehandle)

[中英对照](http://nodejs.cn/api-v12/fs/class_filehandle.html)

新增于: v10.0.0

而是，始终显式关闭 `FileHandle`。 Node.js 将来可能会更改此行为。

##### `filehandle.appendFile(data, options)`[#](http://nodejs.cn/api-v12/fs.html#filehandleappendfiledata-options)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_appendfile_data_options.html)

新增于: v10.0.0

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

[`filehandle.writeFile()`](http://nodejs.cn/api-v12/fs.html#fs_filehandle_writefile_data_options) 的别名。

当在文件句柄上进行操作时，则无法将模式更改为使用 [`fsPromises.open()`](http://nodejs.cn/api-v12/fs.html#fs_fspromises_open_path_flags_mode) 设置的模式。 因此，这相当于 [`filehandle.writeFile()`](http://nodejs.cn/api-v12/fs.html#fs_filehandle_writefile_data_options)。

##### `filehandle.chmod(mode)`[#](http://nodejs.cn/api-v12/fs.html#filehandlechmodmode)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_chmod_mode.html)

新增于: v10.0.0

-   `mode` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

修改文件的权限。

##### `filehandle.chown(uid, gid)`[#](http://nodejs.cn/api-v12/fs.html#filehandlechownuid-gid)

新增于: v10.0.0

-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

Changes the ownership of the file then resolves the `Promise` with no arguments upon success.

##### `filehandle.close()`[#](http://nodejs.cn/api-v12/fs.html#filehandleclose)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_close.html)

新增于: v10.0.0

-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

关闭文件描述符。

```
const fsPromises = require('fs').promises;
async function openAndClose() {
  let filehandle;
  try {
    filehandle = await fsPromises.open('thefile.txt', 'r');
  } finally {
    if (filehandle !== undefined)
      await filehandle.close();
  }
}
```

##### `filehandle.datasync()`[#](http://nodejs.cn/api-v12/fs.html#filehandledatasync)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_datasync.html)

新增于: v10.0.0

-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步的 [`fdatasync(2)`](http://url.nodejs.cn/AEp6fv)。

##### `filehandle.fd`[#](http://nodejs.cn/api-v12/fs.html#filehandlefd)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_fd.html)

新增于: v10.0.0

-   [<number>](http://url.nodejs.cn/SXbo1v) 由 `FileHandle` 对象管理的数字文件描述符。

##### `filehandle.read(buffer, offset, length, position)`[#](http://nodejs.cn/api-v12/fs.html#filehandlereadbuffer-offset-length-position)

新增于: v10.0.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

Read data from the file.

`buffer` is the buffer that the data will be written to.

`offset` is the offset in the buffer to start writing at.

`length` is an integer specifying the number of bytes to read.

`position` is an argument specifying where to begin reading from in the file. If `position` is `null`, data will be read from the current file position, and the file position will be updated. If `position` is an integer, the file position will remain unchanged.

Following successful read, the `Promise` is resolved with an object with a `bytesRead` property specifying the number of bytes read, and a `buffer` property that is a reference to the passed in `buffer` argument.

##### `filehandle.read(options)`[#](http://nodejs.cn/api-v12/fs.html#filehandlereadoptions)

新增于: v12.17.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) **默认值:** `Buffer.alloc(16384)`
    -   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
    -   `length` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `buffer.length`
    -   `position` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `null`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

##### `filehandle.readFile(options)`[#](http://nodejs.cn/api-v12/fs.html#filehandlereadfileoptions)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_readfile_options.html)

新增于: v10.0.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `null`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步地读取文件的全部内容。

如果未指定编码（使用 `options.encoding`），则数据作为 `Buffer` 对象返回。 否则，数据将为字符串。

如果 `options` 是字符串，则它指定编码。

`FileHandle` 必须支持读取。

如果在文件句柄上进行了一次或多次 `filehandle.read()` 调用，然后进行 `filehandle.readFile()` 调用，则将从当前位置读取数据，直到文件末尾。 它并不总是从文件的开头读取。

##### `filehandle.readv(buffers[, position])`[#](http://nodejs.cn/api-v12/fs.html#filehandlereadvbuffers-position)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_readv_buffers_position.html)

新增于: v12.17.0

-   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

从文件读取并写入 `ArrayBufferView` 的数组

如果 `typeof position !== 'number'`，则从当前位置读取数据。

##### `filehandle.stat([options])`[#](http://nodejs.cn/api-v12/fs.html#filehandlestatoptions)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_stat_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

##### `filehandle.sync()`[#](http://nodejs.cn/api-v12/fs.html#filehandlesync)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_sync.html)

新增于: v10.0.0

-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步的 [`fsync(2)`](http://url.nodejs.cn/d4u3Ks)。

##### `filehandle.truncate(len)`[#](http://nodejs.cn/api-v12/fs.html#filehandletruncatelen)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_truncate_len.html)

新增于: v10.0.0

-   `len` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

如果文件大于 `len` 个字节，则仅前 `len` 个字节将保留在文件中。

例如，以下程序仅保留文件的前四个字节：

```
const fs = require('fs');
const fsPromises = fs.promises;

console.log(fs.readFileSync('temp.txt', 'utf8'));
// 打印: Node.js

async function doTruncate() {
  let filehandle = null;
  try {
    filehandle = await fsPromises.open('temp.txt', 'r+');
    await filehandle.truncate(4);
  } finally {
    if (filehandle) {
      // 
      await filehandle.close();
    }
  }
  console.log(fs.readFileSync('temp.txt', 'utf8'));  // 打印: Node
}

doTruncate().catch(console.error);
```

如果文件先前小于 `len` 个字节，则将其扩展，并且扩展部分将使用空字节（`'\0'`）填充：

```
const fs = require('fs');
const fsPromises = fs.promises;

console.log(fs.readFileSync('temp.txt', 'utf8'));
// 打印: Node.js

async function doTruncate() {
  let filehandle = null;
  try {
    filehandle = await fsPromises.open('temp.txt', 'r+');
    await filehandle.truncate(10);
  } finally {
    if (filehandle) {
      // 
      await filehandle.close();
    }
  }
  console.log(fs.readFileSync('temp.txt', 'utf8'));  // 
}

doTruncate().catch(console.error);
```

##### `filehandle.utimes(atime, mtime)`[#](http://nodejs.cn/api-v12/fs.html#filehandleutimesatime-mtime)

新增于: v10.0.0

-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

Change the file system timestamps of the object referenced by the `FileHandle` then resolves the `Promise` with no arguments upon success.

This function does not work on AIX versions before 7.1, it will resolve the `Promise` with an error using code `UV_ENOSYS`.

##### `filehandle.write(buffer[, offset[, length[, position]]])`[#](http://nodejs.cn/api-v12/fs.html#filehandlewritebuffer-offset-length-position)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_write_buffer_offset_length_position.html)

新增于: v10.0.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

将 `buffer` 写入文件。

`offset` 确定要写入的缓冲区部分，`length` 是整数，指定要写入的字节数。

`position` 指从文件开头数据应被写入的偏移量。 如果 `typeof position !== 'number'`，则数据将写入当前位置。 参见 [`pwrite(2)`](http://url.nodejs.cn/2qJ9AM)。

对于这种情况，请使用 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options)。

在 Linux 上，以追加模式打开文件时，位置写入不起作用。 内核会忽略位置参数，并始终将数据追加到文件末尾。

##### `filehandle.write(string[, position[, encoding]])`[#](http://nodejs.cn/api-v12/fs.html#filehandlewritestring-position-encoding)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_write_string_position_encoding.html)

新增于: v10.0.0

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

将 `string` 写入文件。

`position` 指从文件开头数据应被写入的偏移量。

参见 [`pwrite(2)`](http://url.nodejs.cn/2qJ9AM)。

`encoding` 是预期的字符串编码。

对于这种情况，请使用 [`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options)。

在 Linux 上，以追加模式打开文件时，位置写入不起作用。 内核会忽略位置参数，并始终将数据追加到文件末尾。

##### `filehandle.writeFile(data, options)`[#](http://nodejs.cn/api-v12/fs.html#filehandlewritefiledata-options)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_writefile_data_options.html)

新增于: v10.0.0

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步地将数据写入文件，如果文件已经存在，则替换该文件。 `data` 可以是字符串或缓冲区。

如果 `data` 是缓冲区，则忽略 `encoding` 选项。

如果 `options` 是字符串，则它指定编码。

`FileHandle` 必须支持写入。

如果在文件句柄上进行了一次或多次 `filehandle.write()` 调用，然后进行 `filehandle.writeFile()` 调用，则数据将从当前位置写入，直到文件末尾。 它并不总是从文件的开头写入。

##### `filehandle.writev(buffers[, position])`[#](http://nodejs.cn/api-v12/fs.html#filehandlewritevbuffers-position)

[中英对照](http://nodejs.cn/api-v12/fs/filehandle_writev_buffers_position.html)

新增于: v12.9.0

-   `buffers` [<ArrayBufferView\[\]>](http://url.nodejs.cn/qijt55)
-   `position` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

将 `ArrayBufferView` 的数组写入文件。

`position` 是该数据应写入的文件开头的偏移量。 如果 `typeof position !== 'number'`，则数据将写入当前位置。

在 Linux 上，以追加模式打开文件时，位置写入不起作用。 内核会忽略位置参数，并始终将数据追加到文件末尾。

#### `fsPromises.access(path[, mode])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesaccesspath-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_access_path_mode.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `fs.constants.F_OK`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

测试用户对 `path` 指定的文件或目录的权限。 `mode` 参数是可选的整数，指定要执行的可访问性检查。 查看[文件访问的常量](http://nodejs.cn/api-v12/fs.html#fs_file_access_constants)以获取可能的 `mode` 值。 可以创建由两个或多个值的按位或组成的掩码（例如 `fs.constants.W_OK | fs.constants.R_OK`）。

以下示例检查当前进程是否可以读写文件 `/etc/passwd`。

```
const fs = require('fs');
const fsPromises = fs.promises;

fsPromises.access('/etc/passwd', fs.constants.R_OK | fs.constants.W_OK)
  .then(() => console.log('can access'))
  .catch(() => console.error('cannot access'));
```

不建议在调用 `fsPromises.open()` 之前使用 `fsPromises.access()` 检查文件的可访问性。 这样做会引入竞争条件，因为其他进程可能会在两次调用之间更改文件的状态。 而是，用户代码应直接打开/读取/写入文件，并处理无法访问文件时引发的错误。

#### `fsPromises.appendFile(path, data[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesappendfilepath-data-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_appendfile_path_data_options.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<FileHandle>](http://nodejs.cn/api/fs.html#class-filehandle) 文件名或 `FileHandle`
-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'a'`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步地将数据追加到文件，如果该文件尚不存在，则创建该文件。 `data` 可以是字符串或 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer)。

如果 `options` 是字符串，则它指定编码。

可以将 `path` 指定为已打开用于追加（使用 `fsPromises.open()`）的 `FileHandle`。

#### `fsPromises.chmod(path, mode)`[#](http://nodejs.cn/api-v12/fs.html#fspromiseschmodpath-mode)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

Changes the permissions of a file then resolves the `Promise` with no arguments upon succces.

#### `fsPromises.chown(path, uid, gid)`[#](http://nodejs.cn/api-v12/fs.html#fspromiseschownpath-uid-gid)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

Changes the ownership of a file then resolves the `Promise` with no arguments upon success.

#### `fsPromises.copyFile(src, dest[, flags])`[#](http://nodejs.cn/api-v12/fs.html#fspromisescopyfilesrc-dest-flags)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_copyfile_src_dest_flags.html)

-   `src` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 要复制的源文件名
-   `dest` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 复制操作的目标文件名
-   `flags` [<number>](http://url.nodejs.cn/SXbo1v) 复制操作的修饰符。 **默认值:** `0`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步地将 `src` 复制到 `dest`。 默认情况下，如果 `dest` 已经存在，则会被覆盖。

Node.js 不保证复制操作的原子性。 如果在打开目标文件进行写入后发生错误，Node.js 将尝试删除目标文件。

`flags` 是可选的整数，用于指定复制操作的行为。 可以创建由两个或多个值的按位或组成的掩码（例如 `fs.constants.COPYFILE_EXCL | fs.constants.COPYFILE_FICLONE`）。

-   `fs.constants.COPYFILE_EXCL`: 如果 `dest` 已经存在，则复制操作将失败。
-   `fs.constants.COPYFILE_FICLONE`: 复制操作将尝试创建写时复制引用链接。 如果平台不支持写时复制，则使用后备复制机制。
-   `fs.constants.COPYFILE_FICLONE_FORCE`: 复制操作将尝试创建写时复制引用链接。 如果平台不支持写时复制，则该操作将失败。

```
const fsPromises = require('fs').promises;

// 默认情况下将创建或覆盖 destination.txt。
fsPromises.copyFile('source.txt', 'destination.txt')
  .then(() => console.log('source.txt was copied to destination.txt'))
  .catch(() => console.log('The file could not be copied'));
```

```
const fs = require('fs');
const fsPromises = fs.promises;
const { COPYFILE_EXCL } = fs.constants;

// 通过使用 COPYFILE_EXCL，如果 destination.txt 存在，则该操作将失败。
fsPromises.copyFile('source.txt', 'destination.txt', COPYFILE_EXCL)
  .then(() => console.log('source.txt was copied to destination.txt'))
  .catch(() => console.log('The file could not be copied'));
```

#### `fsPromises.lchmod(path, mode)`[#](http://nodejs.cn/api-v12/fs.html#fspromiseslchmodpath-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_lchmod_path_mode.html)

弃用于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `mode` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

此方法仅在 macOS 上实现。

#### `fsPromises.lchown(path, uid, gid)`[#](http://nodejs.cn/api-v12/fs.html#fspromiseslchownpath-uid-gid)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_lchown_path_uid_gid.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `uid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `gid` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

#### `fsPromises.lutimes(path, atime, mtime)`[#](http://nodejs.cn/api-v12/fs.html#fspromiseslutimespath-atime-mtime)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_lutimes_path_atime_mtime.html)

新增于: v12.19.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

以与 [`fsPromises.utimes()`](http://nodejs.cn/api-v12/fs.html#fs_fspromises_utimes_path_atime_mtime) 相同的方式更改文件的访问和修改时间，不同之处在于，如果路径引用符号链接，则不会取消引用该链接：而是，符号链接本身的时间戳会更改。

#### `fsPromises.link(existingPath, newPath)`[#](http://nodejs.cn/api-v12/fs.html#fspromiseslinkexistingpath-newpath)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_link_existingpath_newpath.html)

新增于: v10.0.0

-   `existingPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `newPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步的 [`link(2)`](http://url.nodejs.cn/U8H1mr)。

#### `fsPromises.lstat(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromiseslstatpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_lstat_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步的 [`lstat(2)`](http://url.nodejs.cn/fGaHTu)。

#### `fsPromises.mkdir(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesmkdirpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_mkdir_path_options.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `recursive` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
    -   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) Windows 上不支持。 **默认值:** `0o777`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

当 `path` 是已存在的目录时，调用 `fsPromises.mkdir()` 仅在 `recursive` 为 false 时才导致拒绝。

#### `fsPromises.mkdtemp(prefix[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesmkdtempprefix-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_mkdtemp_prefix_options.html)

新增于: v10.0.0

-   `prefix` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

通过在所提供的 `prefix` 的末尾附加六个随机字符来生成唯一的目录名称。 由于平台的不一致，请避免在 `prefix` 中尾随 `X` 字符。 某些平台，尤其是 BSD，可能返回六个以上的随机字符，并将 `prefix` 中的尾随 `X` 字符替换为随机字符。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定要使用的字符编码）的对象。

```
fsPromises.mkdtemp(path.join(os.tmpdir(), 'foo-'))
  .catch(console.error);
```

`fsPromises.mkdtemp()` 方法会将六个随机选择的字符直接附加到 `prefix` 字符串。 例如，给定目录 `/tmp`，如果要在 `/tmp` 内创建临时目录，则 `prefix` 必须以平台特定的尾随路径分隔符（`require('path').sep`）结尾。

#### `fsPromises.open(path, flags[, mode])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesopenpath-flags-mode)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_open_path_flags_mode.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `flags` [<string>](http://url.nodejs.cn/9Tw2bK) | [<number>](http://url.nodejs.cn/SXbo1v) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'r'`。
-   `mode` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666` （可读可写）
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

参见 [`open(2)`](http://url.nodejs.cn/ss2dGs)。

`mode` 设置文件模式（权限和粘滞位），但前提是文件已创建。

在 Windows 上预留了一些字符（`< > : " / \ | ? *`），如[命名文件、路径和命名空间](http://url.nodejs.cn/GmL95W)所记录。 在 NTFS 下，如果文件名包含冒号，则 Node.js 将打开文件系统流，如[此 MSDN 页面](http://url.nodejs.cn/FY8iKV)所述。

#### `fsPromises.opendir(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesopendirpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_opendir_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `bufferSize` [<number>](http://url.nodejs.cn/SXbo1v) 当从目录读取时，在内部缓冲的目录条目数。 值越大，性能越好，但内存使用率越高。 **默认值:** `32`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8) 包含 [<fs.Dir>](http://nodejs.cn/api/fs.html#class-fsdir)

异步地打开目录。 参见 [`opendir(3)`](http://url.nodejs.cn/KKZ5fX)。

创建 [`fs.Dir`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dir)，其中包含用于从目录读取和清理目录的所有进一步的函数。

`encoding` 选项设置在打开目录和随后的读取操作时 `path` 的编码。

使用异步迭代的示例：

```
const fs = require('fs');

async function print(path) {
  const dir = await fs.promises.opendir(path);
  for await (const dirent of dir) {
    console.log(dirent.name);
  }
}
print('./').catch(console.error);
```

#### `fsPromises.readdir(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesreaddirpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_readdir_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
    -   `withFileTypes` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于文件名的字符编码）的对象。 如果 `encoding` 设置为 `'buffer'`，则返回的文件名将作为 `Buffer` 对象传入。

如果 `options.withFileTypes` 设置为 `true`，则解决的数组将包含 [`fs.Dirent`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dirent) 对象。

```
const fs = require('fs');

async function print(path) {
  const files = await fs.promises.readdir(path);
  for (const file of files) {
    console.log(file);
  }
}
print('./').catch(console.error);
```

#### `fsPromises.readFile(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesreadfilepath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_readfile_path_options.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<FileHandle>](http://nodejs.cn/api/fs.html#class-filehandle) 文件名或 `FileHandle`
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `null`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'r'`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步地读取文件的全部内容。

如果未指定编码（使用 `options.encoding`），则数据作为 `Buffer` 对象返回。 否则，数据将为字符串。

如果 `options` 是字符串，则它指定编码。

当 `path` 是目录时，`fsPromises.readFile()` 的行为是特定于平台的。 在 macOS、Linux 和 Windows 上，promise 将使用错误拒绝。 在 FreeBSD 上，将返回目录内容的表示。

任何指定的 `FileHandle` 必须支持读取。

#### `fsPromises.readlink(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesreadlinkpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_readlink_path_options.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步的 [`readlink(2)`](http://url.nodejs.cn/CFw99K)。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于返回的链接路径的字符编码）的对象。 如果将 `encoding` 设置为 `'buffer'`，则返回的链接路径将作为 `Buffer` 对象传入。

#### `fsPromises.realpath(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesrealpathpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_realpath_path_options.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

仅支持可以转换为 UTF8 字符串的路径。

可选的 `options` 参数可以是指定编码的字符串，也可以是具有 `encoding` 属性（指定用于路径的字符编码）的对象。 如果 `encoding` 设置为 `'buffer'`，则返回的路径将作为 `Buffer` 对象传入。

在 Linux 上，将 Node.js 与 musl libc 链接时，必须将 procfs 文件系统挂载在 `/proc` 上，此函数才能起作用。 Glibc 没有此限制。

#### `fsPromises.rename(oldPath, newPath)`[#](http://nodejs.cn/api-v12/fs.html#fspromisesrenameoldpath-newpath)

新增于: v10.0.0

-   `oldPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `newPath` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

Renames `oldPath` to `newPath` and resolves the `Promise` with no arguments upon success.

#### `fsPromises.rmdir(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesrmdirpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_rmdir_path_options.html)

[稳定性: 1](http://nodejs.cn/api/documentation.html#stability-index) - Recursive removal 是实验的。

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `maxRetries` [<integer>](http://url.nodejs.cn/SXbo1v) 此选项表示重试次数。 如果 `recursive` 选项不为 `true`，则忽略此选项。 **默认值:** `0`。
    -   `recursive` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则执行递归目录删除。 在递归模式下，当 `path` 不存在时不报错，当操作失败时则重试。 **默认值:** `false`。
    -   `retryDelay` [<integer>](http://url.nodejs.cn/SXbo1v) 重试之间等待的时间（以毫秒为单位）。 如果 `recursive` 选项不为 `true`，则忽略此选项。 **默认值:** `100`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

#### `fsPromises.stat(path[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromisesstatpath-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_stat_path_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `bigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 返回的 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象中的数值是否应为 `bigint`。 **默认值:** `false`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

#### `fsPromises.symlink(target, path[, type])`[#](http://nodejs.cn/api-v12/fs.html#fspromisessymlinktarget-path-type)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_symlink_target_path_type.html)

新增于: v10.0.0

-   `target` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `type` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'file'`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

`type` 参数仅在 Windows 平台上使用，可以是 `'dir'`、`'file'` 或 `'junction'` 之一。 Windows 交接点要求目标路径是绝对路径。 使用 `'junction'` 时，`target` 参数将自动规范化为绝对路径。

#### `fsPromises.truncate(path[, len])`[#](http://nodejs.cn/api-v12/fs.html#fspromisestruncatepath-len)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `len` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

Truncates the `path` then resolves the `Promise` with no arguments upon success. The `path` _must_ be a string or `Buffer`.

#### `fsPromises.unlink(path)`[#](http://nodejs.cn/api-v12/fs.html#fspromisesunlinkpath)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_unlink_path.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步的 [`unlink(2)`](http://url.nodejs.cn/gjRRsM)。

#### `fsPromises.utimes(path, atime, mtime)`[#](http://nodejs.cn/api-v12/fs.html#fspromisesutimespath-atime-mtime)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_utimes_path_atime_mtime.html)

新增于: v10.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `atime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   `mtime` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Date>](http://url.nodejs.cn/A9TMoa)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

`atime` 和 `mtime` 参数遵循以下规则：

-   值可以是代表 Unix 纪元时间的数字、`Date`、或数字字符串（例如 `'123456789.0'`）。
-   如果该值不能转换为数字，或者是 `NaN`，`Infinity` 或 `-Infinity`，则将抛出 `Error`。

#### `fsPromises.writeFile(file, data[, options])`[#](http://nodejs.cn/api-v12/fs.html#fspromiseswritefilefile-data-options)

[中英对照](http://nodejs.cn/api-v12/fs/fspromises_writefile_file_data_options.html)

新增于: v10.0.0

-   `file` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<FileHandle>](http://nodejs.cn/api/fs.html#class-filehandle) 文件名或 `FileHandle`
-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) **默认值:** `'utf8'`
    -   `mode` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0o666`
    -   `flag` [<string>](http://url.nodejs.cn/9Tw2bK) 请参阅[对文件系统 `flags` 的支持](http://nodejs.cn/api-v12/fs.html#fs_file_system_flags)。 **默认值:** `'w'`。
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

异步地将数据写入文件，如果文件已经存在，则替换该文件。 `data` 可以是字符串或缓冲区。

如果 `data` 是缓冲区，则忽略 `encoding` 选项。

如果 `options` 是字符串，则它指定编码。

任何指定的 `FileHandle` 都必须支持写入。

### FS 常量[#](http://nodejs.cn/api-v12/fs.html#fs-constants)

[中英对照](http://nodejs.cn/api-v12/fs/fs_constants_1.html)

以下常量由 `fs.constants` 导出。

并非每个常量都适用于每个操作系统。

要使用多个常量，请使用按位或 `|` 运算符。

示例：

```
const fs = require('fs');

const {
  O_RDWR,
  O_CREAT,
  O_EXCL
} = fs.constants;

fs.open('/path/to/my/file', O_RDWR | O_CREAT | O_EXCL, (err, fd) => {
  // ...
});
```

#### 文件访问的常量[#](http://nodejs.cn/api-v12/fs.html#file-access-constants)

[中英对照](http://nodejs.cn/api-v12/fs/file_access_constants.html)

以下常量旨在与 [`fs.access()`](http://nodejs.cn/api-v12/fs.html#fs_fs_access_path_mode_callback) 一起使用。

| 常量 | 描述 |
| --- | --- |
| `F_OK` | 指示文件对调用进程可见的标志。 这对于确定文件是否存在很有用，但没有说明 `rwx` 权限。 未指定模式时的默认值。 |
| `R_OK` | 指示文件可以被调用进程读取的标志。 |
| `W_OK` | 指示文件可以被调用进程写入的标志。 |
| `X_OK` | 指示文件可以被调用进程执行的标志。 这在 Windows 上不起作用（行为类似于 `fs.constants.F_OK`）。 |

#### 文件复制的常量[#](http://nodejs.cn/api-v12/fs.html#file-copy-constants)

[中英对照](http://nodejs.cn/api-v12/fs/file_copy_constants.html)

以下常量旨在与 [`fs.copyFile()`](http://nodejs.cn/api-v12/fs.html#fs_fs_copyfile_src_dest_flags_callback) 一起使用。

| 常量 | 描述 |
| --- | --- |
| `COPYFILE_EXCL` | 如果存在，如果目标路径已经存在，复制操作将失败并显示错误。 |
| `COPYFILE_FICLONE` | 如果存在，复制操作将尝试创建写时复制引用链接。 如果底层平台不支持写时复制，则使用回退复制机制。 |
| `COPYFILE_FICLONE_FORCE` | 如果存在，复制操作将尝试创建写时复制引用链接。 如果底层平台不支持写时复制，则操作将失败并显示错误。 |

#### 文件打开的常量[#](http://nodejs.cn/api-v12/fs.html#file-open-constants)

[中英对照](http://nodejs.cn/api-v12/fs/file_open_constants.html)

以下常量旨在与 `fs.open()` 一起使用。

| 常量 | 描述 |
| --- | --- |
| `O_RDONLY` | 指示打开文件以进行只读访问的标志。 |
| `O_WRONLY` | 指示打开文件以进行只写访问的标志。 |
| `O_RDWR` | 指示打开文件以进行读写访问的标志。 |
| `O_CREAT` | 如果文件不存在则指示创建文件的标志。 |
| `O_EXCL` | 如果设置了 `O_CREAT` 标志并且文件已经存在，则指示打开文件应该失败的标志。 |
| `O_NOCTTY` | 标志表示如果路径标识一个终端设备，打开路径不应导致该终端成为进程的控制终端（如果进程还没有一个）。 |
| `O_TRUNC` | 标志表示如果文件存在并且是一个普通文件，并且该文件被成功打开以进行写访问，则其长度应被截断为零。 |
| `O_APPEND` | 指示数据将追加到文件末尾的标志。 |
| `O_DIRECTORY` | 如果路径不是目录，则表示打开应该失败的标志。 |
| `O_NOATIME` | 指示对文件系统的读取访问的标志将不再导致与文件关联的 `atime` 信息的更新。 此标志仅在 Linux 操作系统上可用。 |
| `O_NOFOLLOW` | 如果路径是符号链接，则表示打开应该失败的标志。 |
| `O_SYNC` | 指示文件为同步 I/O 打开的标志，写操作等待文件完整性。 |
| `O_DSYNC` | 指示文件为同步 I/O 打开的标志，写操作等待数据完整性。 |
| `O_SYMLINK` | 指示打开符号链接本身而不是它指向的资源的标志。 |
| `O_DIRECT` | 设置后，将尝试最小化文件 I/O 的缓存影响。 |
| `O_NONBLOCK` | 指示在可能的情况下以非阻塞模式打开文件的标志。 |
| `UV_FS_O_FILEMAP` | 设置后，将使用内存文件映射来访问文件。 此标志仅在 Windows 操作系统上可用。 在其他操作系统上，此标志被忽略。 |

#### 文件类型的常量[#](http://nodejs.cn/api-v12/fs.html#file-type-constants)

[中英对照](http://nodejs.cn/api-v12/fs/file_type_constants.html)

以下常量旨在与 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象的 `mode` 属性一起使用，以确定文件的类型。

| 常量 | 描述 |
| --- | --- |
| `S_IFMT` | 用于提取文件类型代码的位掩码。 |
| `S_IFREG` | 常规文件的文件类型常量。 |
| `S_IFDIR` | 目录的文件类型常量。 |
| `S_IFCHR` | 面向字符的设备文件的文件类型常量。 |
| `S_IFBLK` | 面向块的设备文件的文件类型常量。 |
| `S_IFIFO` | FIFO/管道的文件类型常量。 |
| `S_IFLNK` | 符号链接的文件类型常量。 |
| `S_IFSOCK` | 套接字的文件类型常量。 |

#### 文件模式的常量[#](http://nodejs.cn/api-v12/fs.html#file-mode-constants)

[中英对照](http://nodejs.cn/api-v12/fs/file_mode_constants.html)

以下常量旨在与 [`fs.Stats`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_stats) 对象的 `mode` 属性一起使用，以确定文件的访问权限。

| 常量 | 描述 |
| --- | --- |
| `S_IRWXU` | 文件模式指示所有者可读、可写和可执行。 |
| `S_IRUSR` | 文件模式指示所有者可读。 |
| `S_IWUSR` | 文件模式指示所有者可写。 |
| `S_IXUSR` | 文件模式指示所有者可执行。 |
| `S_IRWXG` | 文件模式指示群组可读、可写和可执行。 |
| `S_IRGRP` | 文件模式指示群组可读。 |
| `S_IWGRP` | 文件模式指示群组可写。 |
| `S_IXGRP` | 文件模式指示群组可执行。 |
| `S_IRWXO` | 文件模式指示其他人可读、可写和可执行。 |
| `S_IROTH` | 文件模式指示其他人可读。 |
| `S_IWOTH` | 文件模式指示其他人可写。 |
| `S_IXOTH` | 文件模式指示其他人可执行。 |

### 文件系统标志[#](http://nodejs.cn/api-v12/fs.html#file-system-flags)

[中英对照](http://nodejs.cn/api-v12/fs/file_system_flags.html)

以下标志在 `flag` 选项接受字符串的任何地方可用。

-   `'a'`: 打开文件进行追加。 如果文件不存在，则创建该文件。
    
-   `'ax'`: 类似于 `'a'` 但如果路径存在则失败。
    
-   `'a+'`: 打开文件进行读取和追加。 如果文件不存在，则创建该文件。
    
-   `'ax+'`: 类似于 `'a+'` 但如果路径存在则失败。
    
-   `'as'`: 以同步模式打开文件进行追加。 如果文件不存在，则创建该文件。
    
-   `'as+'`: 以同步模式打开文件进行读取和追加。 如果文件不存在，则创建该文件。
    
-   `'r'`: 打开文件进行读取。 如果文件不存在，则会发生异常。
    
-   `'r+'`: 打开文件进行读写。 如果文件不存在，则会发生异常。
    
-   `'rs+'`: 以同步模式打开文件进行读写。 指示操作系统绕过本地文件系统缓存。
    
    这主要用于在 NFS 挂载上打开文件，因为它允许跳过可能过时的本地缓存。 它对 I/O 性能有非常实际的影响，因此除非需要，否则不建议使用此标志。
    
    这不会将 `fs.open()` 或 `fsPromises.open()` 变成同步阻塞调用。 如果需要同步操作，应该使用类似 `fs.openSync()` 的东西。
    
-   `'w'`: 打开文件进行写入。 创建（如果它不存在）或截断（如果它存在）该文件。
    
-   `'wx'`: 类似于 `'w'` 但如果路径存在则失败。
    
-   `'w+'`: 打开文件进行读写。 创建（如果它不存在）或截断（如果它存在）该文件。
    
-   `'wx+'`: 类似于 `'w+'` 但如果路径存在则失败。
    

`flag` 也可以是 [`open(2)`](http://url.nodejs.cn/ss2dGs) 记录的数字；常用的常量可从 `fs.constants` 获得。 在 Windows 上，标志会在适用的情况下转换为等效的标志，例如 `O_WRONLY` 至 `FILE_GENERIC_WRITE`，或 `O_EXCL|O_CREAT` 至 `CREATE_NEW`，为 `CreateFileW` 所接受。

如果路径已经存在，则独占标志 `'x'`（ [`open(2)`](http://url.nodejs.cn/ss2dGs) 中的 `O_EXCL` 标志）会导致操作返回错误。 在 POSIX 上，如果路径是符号链接，即使链接指向不存在的路径，使用 `O_EXCL` 也会返回错误。

在 Linux 上，以追加模式打开文件时，位置写入不起作用。 内核会忽略位置参数，并始终将数据追加到文件末尾。

某些标志的行为是特定于平台的。 因此，在 macOS 和 Linux 上使用 `'a+'` 标志打开目录，如下例所示，将返回错误。 而在 Windows 和 FreeBSD 上，将返回文件描述符或 `FileHandle`。

```
// macOS 和 Linux
fs.open('<directory>', 'a+', (err, fd) => {
  // => [Error: EISDIR: illegal operation on a directory, open <directory>]
});

// Windows 和 FreeBSD
fs.open('<directory>', 'a+', (err, fd) => {
  // => null, <fd>
});
```

在 Windows 上，使用 `'w'` 标志（通过 `fs.open()` 或 `fs.writeFile()` 或 `fsPromises.open()`）打开现有隐藏文件将失败并抛出 `EPERM`。 可以使用 `'r+'` 标志打开现有的隐藏文件进行写入。

调用 `fs.ftruncate()` 或 `filehandle.truncate()` 可用于重置文件内容。
