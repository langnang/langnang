---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/stream.html
author: 
---

# stream 流 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/stream/stream.html)

**源代码:** [lib/stream.js](https://github.com/nodejs/node/blob/v12.22.12/lib/stream.js)

流是用于在 Node.js 中处理流数据的抽象接口。 `stream` 模块提供了用于实现流接口的 API。

Node.js 提供了许多流对象。 例如，[对 HTTP 服务器的请求](http://nodejs.cn/api-v12/http.html#http_class_http_incomingmessage)和 [`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 都是流的实例。

流可以是可读的、可写的、或两者兼而有之。 所有的流都是 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) 的实例。

要访问 `stream` 模块：

```
const stream = require('stream');
```

`stream` 模块对于创建新类型的流实例很有用。 通常不需要使用 `stream` 模块来消费流。

### 本文档的组织结构[#](http://nodejs.cn/api-v12/stream.html#organization-of-this-document)

[中英对照](http://nodejs.cn/api-v12/stream/organization_of_this_document.html)

本文档包含两个主要章节和第三章节的注意事项。 第一章节描述了如何在应用程序中使用现有的流。 第二章节描述了如何创建新类型的流。

### 流的类型[#](http://nodejs.cn/api-v12/stream.html#types-of-streams)

[中英对照](http://nodejs.cn/api-v12/stream/types_of_streams.html)

Node.js 中有四种基本的流类型：

-   [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable): 可以写入数据的流（例如，[`fs.createWriteStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createwritestream_path_options)）。
-   [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable): 可以从中读取数据的流（例如，[`fs.createReadStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createreadstream_path_options)）。
-   [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex): `Readable` 和 `Writable` 的流（例如，[`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket)）。
-   [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform): 可以在写入和读取数据时修改或转换数据的 `Duplex` 流（例如，[`zlib.createDeflate()`](http://nodejs.cn/api-v12/zlib.html#zlib_zlib_createdeflate_options)）。

此外，此模块还包括实用函数 [`stream.pipeline()`](http://nodejs.cn/api-v12/stream.html#stream_stream_pipeline_streams_callback)、[`stream.finished()`](http://nodejs.cn/api-v12/stream.html#stream_stream_finished_stream_options_callback)、和 [`stream.Readable.from()`](http://nodejs.cn/api-v12/stream.html#stream_stream_readable_from_iterable_options)。

#### 对象模式[#](http://nodejs.cn/api-v12/stream.html#object-mode)

[中英对照](http://nodejs.cn/api-v12/stream/object_mode.html)

Node.js API 创建的所有流都只对字符串和 `Buffer`（或 `Uint8Array`）对象进行操作。 但是，流的实现可以使用其他类型的 JavaScript 值（除了 `null`，它在流中具有特殊用途）。 这样的流被认为是在"对象模式"下运行的。

流的实例在创建流时使用 `objectMode` 选项切换到对象模式。 尝试将现有的流切换到对象模式是不安全的。

#### 缓冲[#](http://nodejs.cn/api-v12/stream.html#buffering)

[中英对照](http://nodejs.cn/api-v12/stream/buffering.html)

可能缓冲的数据量取决于传给流的构造函数的 `highWaterMark` 选项。 对于普通的流，`highWaterMark` 选项指定[字节的总数](http://nodejs.cn/api-v12/stream.html#stream_highwatermark_discrepancy_after_calling_readable_setencoding)。 对于在对象模式下操作的流，`highWaterMark` 指定对象的总数。

当实现调用 [`stream.push(chunk)`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding) 时，数据缓存在 `Readable` 流中。 如果流的消费者没有调用 [`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size)，则数据会一直驻留在内部队列中，直到被消费。

一旦内部读取缓冲区的总大小达到 `highWaterMark` 指定的阈值，则流将暂时停止从底层资源读取数据，直到可以消费当前缓冲的数据（也就是，流将停止调用内部的用于填充读取缓冲区 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法）。

当重复调用 [`writable.write(chunk)`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 方法时，数据会缓存在 `Writable` 流中。 虽然内部的写入缓冲区的总大小低于 `highWaterMark` 设置的阈值，但对 `writable.write()` 的调用将返回 `true`。 一旦内部缓冲区的大小达到或超过 `highWaterMark`，则将返回 `false`。

`stream` API 的一个关键目标，尤其是 [`stream.pipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pipe_destination_options) 方法，是将数据缓冲限制在可接受的水平，以便不同速度的来源和目标不会压倒可用内存。

`highWaterMark` 选项是阈值，而不是限制：它规定了流在停止请求更多数据之前缓冲的数据量。 它通常不强制执行严格的内存限制。 特定的流实现可能会选择实施更严格的限制，但这样做是可选的。

由于 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 和 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流都是 `Readable` 和 `Writable`，因此每个流都维护两个独立的内部缓冲区，用于读取和写入，允许每一端独立操作，同时保持适当且高效的数据流。 例如，[`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 实例是 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流，其 `Readable` 端允许消费从套接字接收的数据，其 `Writable` 端允许将数据写入套接字。 因为数据可能以比接收数据更快或更慢的速度写入套接字，所以每一端都应该独立于另一端进行操作（和缓冲）。

### 流消费者的 API[#](http://nodejs.cn/api-v12/stream.html#api-for-stream-consumers)

[中英对照](http://nodejs.cn/api-v12/stream/api_for_stream_consumers.html)

几乎所有的 Node.js 应用程序，无论多么简单，都以某种方式使用流。 以下是在实现 HTTP 服务器的 Node.js 应用程序中使用流的示例：

```
const http = require('http');

const server = http.createServer((req, res) => {
  // `req` 是 http.IncomingMessage，它是可读流。
  // `res` 是 http.ServerResponse，它是可写流。

  let body = '';
  // 以 utf8 字符串形式获取数据。
  // 如果未设置编码，则将接收缓冲区对象。
  req.setEncoding('utf8');

  // 一旦添加了监听器，则可读流就会触发 'data' 事件。
  req.on('data', (chunk) => {
    body += chunk;
  });

  // 'end' 事件表示已经接收到整个正文。
  req.on('end', () => {
    try {
      const data = JSON.parse(body);
      // 给用户回写一些有趣的东西：
      res.write(typeof data);
      res.end();
    } catch (er) {
      // 哦哦！糟糕的 json！
      res.statusCode = 400;
      return res.end(`error: ${er.message}`);
    }
  });
});

server.listen(1337);

// $ curl localhost:1337 -d "{}"
// object
// $ curl localhost:1337 -d "\"foo\""
// string
// $ curl localhost:1337 -d "not json"
// error: Unexpected token o in JSON at position 1
```

[`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流（例如示例中的 `res`）暴露了用于将数据写入流的方法，例如 `write()` 和 `end()`。

当数据可从流中读取时，[`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流使用 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) API 来通知应用程序代码。 可以通过多种方式从流中读取可用数据。

[`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 和 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流都以各种方式使用 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) API 来传达流的当前状态。

[`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 和 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流都是 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 和 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable)。

向流中写入数据或从流中消费数据的应用程序不需要直接实现流的接口，并且通常没有理由调用 `require('stream')`。

希望实现新类型的流的开发者应参考[流实现者的 API](http://nodejs.cn/api-v12/stream.html#stream_api_for_stream_implementers) 章节。

#### 可写流[#](http://nodejs.cn/api-v12/stream.html#writable-streams)

[中英对照](http://nodejs.cn/api-v12/stream/writable_streams.html)

可写流是数据写入目标的抽象。

[`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流的示例包括：

-   [客户端上的 HTTP 请求](http://nodejs.cn/api-v12/http.html#http_class_http_clientrequest)
-   [服务器上的 HTTP 响应](http://nodejs.cn/api-v12/http.html#http_class_http_serverresponse)
-   [文件系统写入流](http://nodejs.cn/api-v12/fs.html#fs_class_fs_writestream)
-   [压缩流](http://nodejs.cn/api-v12/zlib.html)
-   [加密流](http://nodejs.cn/api-v12/crypto.html)
-   [TCP 套接字](http://nodejs.cn/api-v12/net.html#net_class_net_socket)
-   [子进程标准输入](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stdin)
-   [`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout)、[`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr)

其中一些示例实际上是实现 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 接口的 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流。

所有的 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流都实现了 `stream.Writable` 类定义的接口。

虽然 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流的特定实例可能以各种方式不同，但所有的 `Writable` 流都遵循相同的基本使用模式，如下例所示：

```
const myStream = getWritableStreamSomehow();
myStream.write('some data');
myStream.write('some more data');
myStream.end('done writing data');
```

##### `stream.Writable` 类[#](http://nodejs.cn/api-v12/stream.html#class-streamwritable)

新增于: v0.9.4

###### `'close'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-close)

[中英对照](http://nodejs.cn/api-v12/stream/event_close.html)

当流及其任何底层资源（例如文件描述符）已关闭时，则会触发 `'close'` 事件。 该事件表明将不再触发更多事件，并且不会发生进一步的计算。

如果 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流是使用 `emitClose` 选项创建的，则始终会触发 `'close'` 事件。

###### `'drain'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-drain)

[中英对照](http://nodejs.cn/api-v12/stream/event_drain.html)

新增于: v0.9.4

如果对 [`stream.write(chunk)`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 的调用返回 `false`，则 `'drain'` 事件将在适合继续将数据写入流时触发。

```
// 将数据写入提供的可写流一百万次。
// 注意背压。
function writeOneMillionTimes(writer, data, encoding, callback) {
  let i = 1000000;
  write();
  function write() {
    let ok = true;
    do {
      i--;
      if (i === 0) {
        // 最后一次！
        writer.write(data, encoding, callback);
      } else {
        // 看看是应该继续，还是等待。
        // 不要传入回调，因为还没有完成。
        ok = writer.write(data, encoding);
      }
    } while (i > 0 && ok);
    if (i > 0) {
      // 必须早点停下来！
      // 等它排空时再写一些。
      writer.once('drain', write);
    }
  }
}
```

###### `'error'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-error)

[中英对照](http://nodejs.cn/api-v12/stream/event_error.html)

新增于: v0.9.4

-   [<Error>](http://url.nodejs.cn/qZ873x)

如果在写入或管道数据时发生错误，则会触发 `'error'` 事件。 监听器回调在调用时传入单个 `Error` 参数。

###### `'finish'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-finish)

[中英对照](http://nodejs.cn/api-v12/stream/event_finish.html)

新增于: v0.9.4

在调用 [`stream.end()`](http://nodejs.cn/api-v12/stream.html#stream_writable_end_chunk_encoding_callback) 方法之后，并且所有数据都已刷新到底层系统，则触发 `'finish'` 事件。

```
const writer = getWritableStreamSomehow();
for (let i = 0; i < 100; i++) {
  writer.write(`hello, #${i}!\n`);
}
writer.on('finish', () => {
  console.log('All writes are now complete.');
});
writer.end('This is the end\n');
```

###### `'pipe'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-pipe)

[中英对照](http://nodejs.cn/api-v12/stream/event_pipe.html)

新增于: v0.9.4

-   `src` [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable) 管道到此可写流的源流

当在可读流上调用 [`stream.pipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pipe_destination_options) 方法将此可写流添加到其目标集时，则触发 `'pipe'` 事件。

```
const writer = getWritableStreamSomehow();
const reader = getReadableStreamSomehow();
writer.on('pipe', (src) => {
  console.log('Something is piping into the writer.');
  assert.equal(src, reader);
});
reader.pipe(writer);
```

###### `'unpipe'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-unpipe)

[中英对照](http://nodejs.cn/api-v12/stream/event_unpipe.html)

新增于: v0.9.4

-   `src` [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable) [取消管道](http://nodejs.cn/api-v12/stream.html#stream_readable_unpipe_destination)此可写流的源流

当在 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流上调用 [`stream.unpipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_unpipe_destination) 方法时，则会触发 `'unpipe'` 事件，从其目标集合中删除此 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable)。

当 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流管道进入它时，如果此 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流触发错误，则这也会触发。

```
const writer = getWritableStreamSomehow();
const reader = getReadableStreamSomehow();
writer.on('unpipe', (src) => {
  console.log('Something has stopped piping into the writer.');
  assert.equal(src, reader);
});
reader.pipe(writer);
reader.unpipe(writer);
```

###### `writable.cork()`[#](http://nodejs.cn/api-v12/stream.html#writablecork)

[中英对照](http://nodejs.cn/api-v12/stream/writable_cork.html)

新增于: v0.11.2

`writable.cork()` 方法强制所有写入的数据都缓存在内存中。 当调用 [`stream.uncork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_uncork) 或 [`stream.end()`](http://nodejs.cn/api-v12/stream.html#stream_writable_end_chunk_encoding_callback) 方法时，缓冲的数据将被刷新。

`writable.cork()` 的主要目的是适应将几个小块快速连续写入流的情况。 `writable.cork()` 不是立即将它们转发到底层目标，而是缓冲所有块，直到 `writable.uncork()` 被调用，如果存在，`writable.uncork()` 会将它们全部传给 `writable._writev()`。 这可以防止在等待处理第一个小块时正在缓冲数据的行头阻塞情况。 但是，在不实现 `writable._writev()` 的情况下使用 `writable.cork()` 可能会对吞吐量产生不利影响。

另请参阅：[`writable.uncork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_uncork)、[`writable._writev()`](http://nodejs.cn/api-v12/stream.html#stream_writable_writev_chunks_callback)。

###### `writable.destroy([error])`[#](http://nodejs.cn/api-v12/stream.html#writabledestroyerror)

[中英对照](http://nodejs.cn/api-v12/stream/writable_destroy_error.html)

新增于: v8.0.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x) 可选，与 `'error'` 事件一起触发的错误。
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

销毁流 可选地触发 `'error'` 事件，并且触发 `'close'` 事件（除非 `emitClose` 设置为 `false`）。 在此调用之后，则可写流已结束，随后对 `write()` 或 `end()` 的调用将导致 `ERR_STREAM_DESTROYED` 错误。 这是销毁流的破坏性和直接的方式。 先前对 `write()` 的调用可能没有排空，并且可能触发 `ERR_STREAM_DESTROYED` 错误。 如果数据应该在关闭之前刷新，或者在销毁流之前等待 `'drain'` 事件，则使用 `end()` 而不是销毁。 实现者不应覆盖此方法，而应实现 [`writable._destroy()`](http://nodejs.cn/api-v12/stream.html#stream_writable_destroy_err_callback)。

###### `writable.destroyed`[#](http://nodejs.cn/api-v12/stream.html#writabledestroyed)

[中英对照](http://nodejs.cn/api-v12/stream/writable_destroyed.html)

新增于: v8.0.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

在调用 [`writable.destroy()`](http://nodejs.cn/api-v12/stream.html#stream_writable_destroy_error) 之后是 `true`。

###### `writable.end([chunk[, encoding]][, callback])`[#](http://nodejs.cn/api-v12/stream.html#writableendchunk-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/stream/writable_end_chunk_encoding_callback.html)

-   `chunk` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<any>](http://url.nodejs.cn/6sTGdS) 可选的要写入的数据。 对于不在对象模式下操作的流，`chunk` 必须是字符串、`Buffer` 或 `Uint8Array`。 对于对象模式的流，`chunk` 可以是除 `null` 之外的任何 JavaScript 值。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `chunk` 为字符串时的编码
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

调用 `writable.end()` 方法表示不再有数据写入 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable)。 可选的 `chunk` 和 `encoding` 参数允许在关闭流之前立即写入最后一个额外的数据块。

在调用 [`stream.end()`](http://nodejs.cn/api-v12/stream.html#stream_writable_end_chunk_encoding_callback) 之后调用 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 方法将引发错误。

```
// 写入 'hello, ' 然后以 'world!' 结尾。
const fs = require('fs');
const file = fs.createWriteStream('example.txt');
file.write('hello, ');
file.end('world!');
// 现在不允许写入更多！
```

###### `writable.setDefaultEncoding(encoding)`[#](http://nodejs.cn/api-v12/stream.html#writablesetdefaultencodingencoding)

[中英对照](http://nodejs.cn/api-v12/stream/writable_setdefaultencoding_encoding.html)

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 新的默认编码
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

`writable.setDefaultEncoding()` 方法为 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流设置默认的 `encoding`。

###### `writable.uncork()`[#](http://nodejs.cn/api-v12/stream.html#writableuncork)

[中英对照](http://nodejs.cn/api-v12/stream/writable_uncork.html)

新增于: v0.11.2

`writable.uncork()` 方法会刷新自调用 [`stream.cork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_cork) 以来缓冲的所有数据。

当使用 [`writable.cork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_cork) 和 `writable.uncork()` 管理写入流的缓冲时，建议使用 `process.nextTick()` 延迟对 `writable.uncork()` 的调用。 这样做允许对在给定 Node.js 事件循环阶段中发生的所有 `writable.write()` 调用进行批处理。

```
stream.cork();
stream.write('some ');
stream.write('data ');
process.nextTick(() => stream.uncork());
```

如果在一个流上多次调用 [`writable.cork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_cork) 方法，则必须调用相同数量的 `writable.uncork()` 调用来刷新缓冲的数据。

```
stream.cork();
stream.write('some ');
stream.cork();
stream.write('data ');
process.nextTick(() => {
  stream.uncork();
  // 在第二次调用 uncork() 之前不会刷新数据。
  stream.uncork();
});
```

另见: [`writable.cork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_cork)。

###### `writable.writable`[#](http://nodejs.cn/api-v12/stream.html#writablewritable)

新增于: v11.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

Is `true` if it is safe to call [`writable.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback).

###### `writable.writableEnded`[#](http://nodejs.cn/api-v12/stream.html#writablewritableended)

[中英对照](http://nodejs.cn/api-v12/stream/writable_writableended.html)

新增于: v12.9.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

在调用 [`writable.end()`](http://nodejs.cn/api-v12/stream.html#stream_writable_end_chunk_encoding_callback) 之后是 `true`。 此属性不指示数据是否已刷新，为此则使用 [`writable.writableFinished`](http://nodejs.cn/api-v12/stream.html#stream_writable_writablefinished) 代替。

###### `writable.writableCorked`[#](http://nodejs.cn/api-v12/stream.html#writablewritablecorked)

[中英对照](http://nodejs.cn/api-v12/stream/writable_writablecorked.html)

新增于: v12.16.0

-   [<integer>](http://url.nodejs.cn/SXbo1v)

需要调用 [`writable.uncork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_uncork) 以完全解开流的次数。

###### `writable.writableFinished`[#](http://nodejs.cn/api-v12/stream.html#writablewritablefinished)

[中英对照](http://nodejs.cn/api-v12/stream/writable_writablefinished.html)

新增于: v12.6.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

在触发 [`'finish'`](http://nodejs.cn/api-v12/stream.html#stream_event_finish) 事件之前立即设置为 `true`。

###### `writable.writableHighWaterMark`[#](http://nodejs.cn/api-v12/stream.html#writablewritablehighwatermark)

[中英对照](http://nodejs.cn/api-v12/stream/writable_writablehighwatermark.html)

新增于: v9.3.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

返回构造此 `Writable` 时传入的 `highWaterMark` 的值。

###### `writable.writableLength`[#](http://nodejs.cn/api-v12/stream.html#writablewritablelength)

[中英对照](http://nodejs.cn/api-v12/stream/writable_writablelength.html)

新增于: v9.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

此属性包含队列中准备写入的字节数（或对象数）。 该值提供有关 `highWaterMark` 状态的内省数据。

###### `writable.writableObjectMode`[#](http://nodejs.cn/api-v12/stream.html#writablewritableobjectmode)

[中英对照](http://nodejs.cn/api-v12/stream/writable_writableobjectmode.html)

新增于: v12.3.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

给定 `Writable` 流的属性 `objectMode` 的获取器。

###### `writable.write(chunk[, encoding][, callback])`[#](http://nodejs.cn/api-v12/stream.html#writablewritechunk-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/stream/writable_write_chunk_encoding_callback.html)

-   `chunk` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<any>](http://url.nodejs.cn/6sTGdS) 可选的要写入的数据。 对于不在对象模式下操作的流，`chunk` 必须是字符串、`Buffer` 或 `Uint8Array`。 对于对象模式的流，`chunk` 可以是除 `null` 之外的任何 JavaScript 值。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果 `chunk` 为字符串，则为编码。 **默认值:** `'utf8'`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果流希望调用代码在继续写入其他数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`writable.write()` 方法将一些数据写入流，并在数据完全处理后调用提供的 `callback`。 如果发生错误，则 `callback` 可能会或可能不会使用错误作为其第一个参数进行调用。 要可靠地检测写入错误，则为 `'error'` 事件添加监听器。

如果在接纳 `chunk` 后，内部缓冲区小于当创建流时配置的 `highWaterMark`，则返回值为 `true`。 如果返回 `false`，则应停止进一步尝试将数据写入流，直到触发 [`'drain'`](http://nodejs.cn/api-v12/stream.html#stream_event_drain) 事件。

当流没有排空时，对 `write()` 的调用将缓冲 `chunk`，并返回 false。 一旦所有当前缓冲的块都被排空（操作系统接受交付），则将触发 `'drain'` 事件。 建议一旦 `write()` 返回 false，则在触发 `'drain'` 事件之前不再写入块。 虽然允许在未排空的流上调用 `write()`，但 Node.js 将缓冲所有写入的块，直到出现最大内存使用量，此时它将无条件中止。 即使在它中止之前，高内存使用量也会导致垃圾收集器性能不佳和高 RSS（通常不会释放回系统，即使在不再需要内存之后）。 由于如果远程对等方不读取数据，TCP 套接字可能永远不会排空，因此写入未排空的套接字可能会导致可远程利用的漏洞。

在流未排空时写入数据对于 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 来说尤其成问题，因为 `Transform` 流是默认暂停，直到它们被管道传输、或添加 `'data'` 或 `'readable'` 事件句柄。

如果要写入的数据可以按需生成或获取，则建议将逻辑封装成 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 并且使用 [`stream.pipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pipe_destination_options)。 但是，如果首选调用 `write()`，则可以使用 [`'drain'`](http://nodejs.cn/api-v12/stream.html#stream_event_drain) 事件遵守背压并避免内存问题：

```
function write(data, cb) {
  if (!stream.write(data)) {
    stream.once('drain', cb);
  } else {
    process.nextTick(cb);
  }
}

// 在执行任何其他写入之前等待回调被调用。
write('hello', () => {
  console.log('Write completed, do more writes now.');
});
```

对象模式下的 `Writable` 流将始终忽略 `encoding` 参数。

#### 可读流[#](http://nodejs.cn/api-v12/stream.html#readable-streams)

[中英对照](http://nodejs.cn/api-v12/stream/readable_streams.html)

可读流是对被消费的数据的来源的抽象。

`Readable` 流的示例包括：

-   [客户端上的 HTTP 响应](http://nodejs.cn/api-v12/http.html#http_class_http_incomingmessage)
-   [服务器上的 HTTP 请求](http://nodejs.cn/api-v12/http.html#http_class_http_incomingmessage)
-   [文件系统读取流](http://nodejs.cn/api-v12/fs.html#fs_class_fs_readstream)
-   [压缩流](http://nodejs.cn/api-v12/zlib.html)
-   [加密流](http://nodejs.cn/api-v12/crypto.html)
-   [TCP 套接字](http://nodejs.cn/api-v12/net.html#net_class_net_socket)
-   [子进程的标准输出和标准错误](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stdout)
-   [`process.stdin`](http://nodejs.cn/api-v12/process.html#process_process_stdin)

所有的 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流都实现了 `stream.Readable` 类定义的接口。

##### 两种读取模式[#](http://nodejs.cn/api-v12/stream.html#two-reading-modes)

[中英对照](http://nodejs.cn/api-v12/stream/two_reading_modes.html)

`Readable` 流以两种模式之一有效地运行：流动和暂停。 这些模式与[对象模式](http://nodejs.cn/api-v12/stream.html#stream_object_mode)是分开的。 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流可以处于或不处于对象模式，无论其是处于流动模式还是暂停模式。

-   在流动模式下，数据会自动从底层系统读取，并通过 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) 接口使用事件尽快提供给应用程序。
    
-   在暂停模式下，必须显式调用 [`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 方法以从流中读取数据块。
    

所有的 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流都以暂停模式开始，但可以通过以下方式之一切换到流动模式：

-   添加 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件句柄。
-   调用 [`stream.resume()`](http://nodejs.cn/api-v12/stream.html#stream_readable_resume) 方法。
-   调用 [`stream.pipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pipe_destination_options) 方法将数据发送到 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable)。

`Readable` 可以使用以下方法之一切换回暂停模式：

-   如果没有管道目标，则通过调用 [`stream.pause()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pause) 方法。
-   如果有管道目标，则删除所有管道目标。 可以通过调用 [`stream.unpipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_unpipe_destination) 方法删除多个管道目标。

要记住的重要概念是，在提供消费或忽略该数据的机制之前，`Readable` 不会产生数据。 如果消费机制被禁用或移除，则 `Readable` 将尝试停止产生数据。

出于向后兼容性的原因，删除 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件句柄不会自动暂停流。 此外，如果有管道目标，则调用 [`stream.pause()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pause) 将不能保证一旦这些目标排空并要求更多数据，流将保持暂停状态。

如果 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 切换到流动模式并且没有消费者可用于处理数据，则数据将被丢失。 例如，当调用 `readable.resume()` 方法而没有绑定到 `'data'` 事件的监听器时，或者当从流中删除 `'data'` 事件句柄时，就会发生这种情况。

添加 [`'readable'`](http://nodejs.cn/api-v12/stream.html#stream_event_readable) 事件句柄会自动使流停止流动，并且必须通过 [`readable.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 来消费数据。 如果删除了 [`'readable'`](http://nodejs.cn/api-v12/stream.html#stream_event_readable) 事件句柄，则如果有 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件句柄，流将再次开始流动。

##### 三种状态[#](http://nodejs.cn/api-v12/stream.html#three-states)

[中英对照](http://nodejs.cn/api-v12/stream/three_states.html)

`Readable` 流的操作的"两种模式"是对 `Readable` 流实现中发生的更复杂的内部状态管理的简化抽象。

具体来说，在任何给定的时间点，每个 `Readable` 都处于三种可能的状态之一：

-   `readable.readableFlowing === null`
-   `readable.readableFlowing === false`
-   `readable.readableFlowing === true`

当 `readable.readableFlowing` 为 `null` 时，则不提供消费流数据的机制。 因此，流不会生成数据。 在此状态下，为 `'data'` 事件绑定监听器、调用 `readable.pipe()` 方法、或调用 `readable.resume()` 方法会将 `readable.readableFlowing` 切换到 `true`，从而使 `Readable` 在生成数据时开始主动触发事件。

调用`readable.pause()`、`readable.unpipe()`、或者接收背压都会导致 `readable.readableFlowing` 被设置为 `false`，暂时停止事件的流动，但不会停止数据的生成。 在此状态下，为 `'data'` 事件绑定监听器不会将 `readable.readableFlowing` 切换到 `true`。

```
const { PassThrough, Writable } = require('stream');
const pass = new PassThrough();
const writable = new Writable();

pass.pipe(writable);
pass.unpipe(writable);
// readableFlowing 现在为 false。

pass.on('data', (chunk) => { console.log(chunk.toString()); });
pass.write('ok');  // 不会触发 'data'。
pass.resume();     // 必须调用才能使流触发 'data'。
```

虽然 `readable.readableFlowing` 是 `false`，但数据可能会在流的内部缓冲区中累积。

##### 选择一种接口风格[#](http://nodejs.cn/api-v12/stream.html#choose-one-api-style)

[中英对照](http://nodejs.cn/api-v12/stream/choose_one_api_style.html)

`Readable` 流的 API 跨越多个 Node.js 版本的演进，并提供了多种消费流数据的方法。 一般情况下，开发者应该选择其中一种消费数据的方式，切忌使用多种方式消费单一流中的数据。 具体来说，使用 `on('data')`、`on('readable')`、`pipe()` 或异步迭代器的组合可能会导致不直观的行为。

建议大多数用户使用 `readable.pipe()` 方法，因为它已被实施以提供使用流数据的最简单方法。 需要对数据传输和生成进行更细粒度控制的开发者可以使用 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) 和 `readable.on('readable')`/`readable.read()` 或 `readable.pause()`/`readable.resume()` API。

##### `stream.Readable` 类[#](http://nodejs.cn/api-v12/stream.html#class-streamreadable)

新增于: v0.9.4

###### `'close'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-close_1)

[中英对照](http://nodejs.cn/api-v12/stream/event_close_1.html)

当流及其任何底层资源（例如文件描述符）已关闭时，则会触发 `'close'` 事件。 该事件表明将不再触发更多事件，并且不会发生进一步的计算。

如果 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流是使用 `emitClose` 选项创建的，则始终会触发 `'close'` 事件。

###### `'data'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-data)

[中英对照](http://nodejs.cn/api-v12/stream/event_data.html)

新增于: v0.9.4

-   `chunk` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<any>](http://url.nodejs.cn/6sTGdS) 数据块。 对于不在对象模式下操作的流，块将是字符串或 `Buffer`。 对于处于对象模式的流，块可以是除 `null` 之外的任何 JavaScript 值。

每当流将数据块的所有权移交给消费者时，则会触发 `'data'` 事件。 每当通过调用 `readable.pipe()`、`readable.resume()`、或通过将监听器回调绑定到 `'data'` 事件而将流切换到流动模式时，就会发生这种情况。 每当调用 `readable.read()` 方法并且可以返回数据块时，也会触发 `'data'` 事件。

将 `'data'` 事件监听器绑定到尚未显式暂停的流，则会将流切换到流动模式。 数据将在可用时立即传入。

如果使用 `readable.setEncoding()` 方法为流指定了默认编码，则监听器回调将把数据块作为字符串传入；否则数据将作为 `Buffer` 传入。

```
const readable = getReadableStreamSomehow();
readable.on('data', (chunk) => {
  console.log(`Received ${chunk.length} bytes of data.`);
});
```

###### `'end'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-end)

[中英对照](http://nodejs.cn/api-v12/stream/event_end.html)

新增于: v0.9.4

当流中没有更多数据可供消费时，则会触发 `'end'` 事件。

除非数据被完全地消费，否则不会触发 `'end'` 事件。 这可以通过将流切换到流动模式来实现，或者通过重复调用 [`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 直到所有数据都被消费完。

```
const readable = getReadableStreamSomehow();
readable.on('data', (chunk) => {
  console.log(`Received ${chunk.length} bytes of data.`);
});
readable.on('end', () => {
  console.log('There will be no more data.');
});
```

###### `'error'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-error_1)

[中英对照](http://nodejs.cn/api-v12/stream/event_error_1.html)

新增于: v0.9.4

-   [<Error>](http://url.nodejs.cn/qZ873x)

`'error'` 事件可以随时由 `Readable` 的实现触发。 通常，如果底层流由于底层内部故障而无法生成数据，或者当流实现尝试推送无效数据块时，可能会发生这种情况。

监听器回调将传入单个 `Error` 对象。

###### `'pause'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-pause)

[中英对照](http://nodejs.cn/api-v12/stream/event_pause.html)

新增于: v0.9.4

当调用 [`stream.pause()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pause) 并且 `readableFlowing` 不是 `false` 时，则会触发 `'pause'` 事件。

###### `'readable'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-readable)

[中英对照](http://nodejs.cn/api-v12/stream/event_readable.html)

当有可从流中读取的数据时，则会触发 `'readable'` 事件。 在某些情况下，为 `'readable'` 事件绑定监听器会导致一些数据被读入内部缓冲区。

```
const readable = getReadableStreamSomehow();
readable.on('readable', function() {
  // 现在有一些数据要读取。
  let data;

  while (data = this.read()) {
    console.log(data);
  }
});
```

一旦到达流数据的末尾但在 `'end'` 事件被触发之前，`'readable'` 事件也将被触发。

实际上，`'readable'` 事件表明流有新的信息：新的数据可用或已到达流末尾。 在前一种情况下，[`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 将返回可用的数据。 在后一种情况下，[`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 将返回 `null`。 例如，在以下示例中，`foo.txt` 是一个空文件：

```
const fs = require('fs');
const rr = fs.createReadStream('foo.txt');
rr.on('readable', () => {
  console.log(`readable: ${rr.read()}`);
});
rr.on('end', () => {
  console.log('end');
});
```

运行此脚本的输出是：

```
$ node test.js
readable: null
end
```

一般来说，`readable.pipe()` 和 `'data'` 事件机制比 `'readable'` 事件更容易理解。 但是，处理 `'readable'` 可能会导致吞吐量增加。

如果同时使用 `'readable'` 和 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data)，则 `'readable'` 优先控制流，即只有在调用 [`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 时才会触发 `'data'`。 `readableFlowing` 属性将变为 `false`。 如果在移除 `'readable'` 时有 `'data'` 个监听器，则流将开始流动，即 `'data'` 事件将在不调用 `.resume()` 的情况下触发。

###### `'resume'` 事件[#](http://nodejs.cn/api-v12/stream.html#event-resume)

[中英对照](http://nodejs.cn/api-v12/stream/event_resume.html)

新增于: v0.9.4

当调用 [`stream.resume()`](http://nodejs.cn/api-v12/stream.html#stream_readable_resume) 并且 `readableFlowing` 不是 `true` 时，则会触发 `'resume'` 事件。

###### `readable.destroy([error])`[#](http://nodejs.cn/api-v12/stream.html#readabledestroyerror)

[中英对照](http://nodejs.cn/api-v12/stream/readable_destroy_error.html)

新增于: v8.0.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x) 将作为 `'error'` 事件中的有效负载传递的错误
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

销毁流 可选地触发 `'error'` 事件，并且触发 `'close'` 事件（除非 `emitClose` 设置为 `false`）。 在此调用之后，可读流将释放任何内部资源，随后对 `push()` 的调用将被忽略。 实现者不应覆盖此方法，而应实现 [`readable._destroy()`](http://nodejs.cn/api-v12/stream.html#stream_readable_destroy_err_callback)。

###### `readable.destroyed`[#](http://nodejs.cn/api-v12/stream.html#readabledestroyed)

[中英对照](http://nodejs.cn/api-v12/stream/readable_destroyed.html)

新增于: v8.0.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

在调用 [`readable.destroy()`](http://nodejs.cn/api-v12/stream.html#stream_readable_destroy_error) 之后是 `true`。

###### `readable.isPaused()`[#](http://nodejs.cn/api-v12/stream.html#readableispaused)

[中英对照](http://nodejs.cn/api-v12/stream/readable_ispaused.html)

新增于: v0.11.14

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

`readable.isPaused()` 方法返回 `Readable` 的当前运行状态。 这主要由作为 `readable.pipe()` 方法基础的机制使用。 在大多数典型情况下，没有理由直接使用此方法。

```
const readable = new stream.Readable();

readable.isPaused(); // === false
readable.pause();
readable.isPaused(); // === true
readable.resume();
readable.isPaused(); // === false
```

###### `readable.pause()`[#](http://nodejs.cn/api-v12/stream.html#readablepause)

[中英对照](http://nodejs.cn/api-v12/stream/readable_pause.html)

新增于: v0.9.4

-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

`readable.pause()` 方法将导致处于流动模式的流停止触发 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件，切换出流动模式。 任何可用的数据都将保留在内部缓冲区中。

```
const readable = getReadableStreamSomehow();
readable.on('data', (chunk) => {
  console.log(`Received ${chunk.length} bytes of data.`);
  readable.pause();
  console.log('There will be no additional data for 1 second.');
  setTimeout(() => {
    console.log('Now data will start flowing again.');
    readable.resume();
  }, 1000);
});
```

如果有 `'readable'` 事件监听器，则 `readable.pause()` 方法不起作用。

###### `readable.pipe(destination[, options])`[#](http://nodejs.cn/api-v12/stream.html#readablepipedestination-options)

[中英对照](http://nodejs.cn/api-v12/stream/readable_pipe_destination_options.html)

新增于: v0.9.4

-   `destination` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable) 写入数据的目标
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 管道选项
    -   `end` [<boolean>](http://url.nodejs.cn/jFbvuT) 当读取结束时结束写入。 **默认值:** `true`。
-   返回: [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable) 目标，如果它是 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 或 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流，则允许使用管道链

`readable.pipe()` 方法将 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流绑定到 `readable`，使其自动切换到流动模式并将其所有数据推送到绑定的 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable)。 数据流将被自动管理，以便目标 `Writable` 流不会被更快的 `Readable` 流漫过。

以下示例将 `readable` 中的所有数据通过管道传输到名为 `file.txt` 的文件中：

```
const fs = require('fs');
const readable = getReadableStreamSomehow();
const writable = fs.createWriteStream('file.txt');
// 可读流的所有数据进入 'file.txt'。
readable.pipe(writable);
```

可以将多个 `Writable` 流绑定到单个 `Readable` 流。

`readable.pipe()` 方法返回对目标流的引用，从而可以建立管道流链：

```
const fs = require('fs');
const r = fs.createReadStream('file.txt');
const z = zlib.createGzip();
const w = fs.createWriteStream('file.txt.gz');
r.pipe(z).pipe(w);
```

默认情况下，当源 `Readable` 流触发 [`'end'`](http://nodejs.cn/api-v12/stream.html#stream_event_end) 时，则在目标 `Writable` 流上调用 [`stream.end()`](http://nodejs.cn/api-v12/stream.html#stream_writable_end_chunk_encoding_callback)，因此目标不再可写。 要禁用此默认行为，可以将 `end` 选项作为 `false` 传入，从而使目标流保持打开状态：

```
reader.pipe(writer, { end: false });
reader.on('end', () => {
  writer.end('Goodbye\n');
});
```

有个重要的注意事项，如果 `Readable` 流在处理过程中触发错误，则 `Writable` 目标不会自动关闭。 如果发生错误，则需要手动关闭每个流以防止内存泄漏。

[`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr) 和 [`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) `Writable` 流在 Node.js 进程退出之前永远不会关闭，无论指定的选项如何。

###### `readable.read([size])`[#](http://nodejs.cn/api-v12/stream.html#readablereadsize)

[中英对照](http://nodejs.cn/api-v12/stream/readable_read_size.html)

新增于: v0.9.4

-   `size` [<number>](http://url.nodejs.cn/SXbo1v) 用于指定要读取的数据量的可选参数。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<null>](http://url.nodejs.cn/334hvC) | [<any>](http://url.nodejs.cn/6sTGdS)

`readable.read()` 方法从内部缓冲区中取出一些数据并返回。 如果没有可供读取的数据，则返回 `null`。 默认情况下，数据将作为 `Buffer` 对象返回，除非使用 `readable.setEncoding()` 方法指定了编码、或者流是在对象模式下操作。

可选的 `size` 参数指定要读取的特定字节数。 如果无法读取 `size` 字节，则将返回 `null`，除非流已结束，在这种情况下，将返回内部缓冲区中剩余的所有数据。

如果未指定 `size` 参数，则将返回内部缓冲区中包含的所有数据。

`readable.read()` 方法应该只在暂停模式下操作的 `Readable` 流上调用。 在流动模式下，会自动调用 `readable.read()`，直到内部缓冲区完全排空。

```
const readable = getReadableStreamSomehow();

// 随着数据被缓冲，'readable' 可能会被多次触发
readable.on('readable', () => {
  let chunk;
  console.log('Stream is readable (new data received in buffer)');
  // 使用循环来确保读取所有当前可用的数据
  while (null !== (chunk = readable.read())) {
    console.log(`Read ${chunk.length} bytes of data...`);
  }
});

// 当没有更多可用数据时，则触发一次 'end'。
readable.on('end', () => {
  console.log('Reached end of stream.');
});
```

每次调用 `readable.read()` 都会返回一个数据块或 `null`。 块不是串联的。 需要 `while` 循环来消费当前缓冲区中的所有数据。 当读取大文件时，`.read()` 可能会返回 `null`，到目前为止已经消费了所有缓冲的内容，但是还有更多的数据尚未缓冲。 在这种情况下，当缓冲区中有更多数据时，将触发新的 `'readable'` 事件。 最后，当没有更多数据时，则将触发 `'end'` 事件。

因此，要从 `readable` 读取文件的全部内容，必须跨越多个 `'readable'` 事件来收集块：

```
const chunks = [];

readable.on('readable', () => {
  let chunk;
  while (null !== (chunk = readable.read())) {
    chunks.push(chunk);
  }
});

readable.on('end', () => {
  const content = chunks.join('');
});
```

对象模式下的 `Readable` 流将始终从对 [`readable.read(size)`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 的调用返回单个条目，而不管 `size` 参数的值如何。

如果 `readable.read()` 方法返回数据块，则还将触发 `'data'` 事件。

在 [`'end'`](http://nodejs.cn/api-v12/stream.html#stream_event_end) 事件触发后调用 [`stream.read([size])`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 将返回 `null`。 不会引发运行时错误。

###### `readable.readable`[#](http://nodejs.cn/api-v12/stream.html#readablereadable)

新增于: v11.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

Is `true` if it is safe to call [`readable.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size).

###### `readable.readableEncoding`[#](http://nodejs.cn/api-v12/stream.html#readablereadableencoding)

[中英对照](http://nodejs.cn/api-v12/stream/readable_readableencoding.html)

新增于: v12.7.0

-   [<null>](http://url.nodejs.cn/334hvC) | [<string>](http://url.nodejs.cn/9Tw2bK)

给定 `Readable` 流的属性 `encoding` 的获取器。 可以使用 [`readable.setEncoding()`](http://nodejs.cn/api-v12/stream.html#stream_readable_setencoding_encoding) 方法设置 `encoding` 属性。

###### `readable.readableEnded`[#](http://nodejs.cn/api-v12/stream.html#readablereadableended)

[中英对照](http://nodejs.cn/api-v12/stream/readable_readableended.html)

新增于: v12.9.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

当触发 [`'end'`](http://nodejs.cn/api-v12/stream.html#stream_event_end) 事件时变为 `true`。

###### `readable.readableFlowing`[#](http://nodejs.cn/api-v12/stream.html#readablereadableflowing)

[中英对照](http://nodejs.cn/api-v12/stream/readable_readableflowing.html)

新增于: v9.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

此属性反映了 `Readable` 流的当前状态，如[三种状态](http://nodejs.cn/api-v12/stream.html#stream_three_states)章节所述。

###### `readable.readableHighWaterMark`[#](http://nodejs.cn/api-v12/stream.html#readablereadablehighwatermark)

[中英对照](http://nodejs.cn/api-v12/stream/readable_readablehighwatermark.html)

新增于: v9.3.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

返回构造此 `Readable` 时传入的 `highWaterMark` 的值。

###### `readable.readableLength`[#](http://nodejs.cn/api-v12/stream.html#readablereadablelength)

[中英对照](http://nodejs.cn/api-v12/stream/readable_readablelength.html)

新增于: v9.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

此属性包含队列中准备读取的字节数（或对象数）。 该值提供有关 `highWaterMark` 状态的内省数据。

###### `readable.readableObjectMode`[#](http://nodejs.cn/api-v12/stream.html#readablereadableobjectmode)

[中英对照](http://nodejs.cn/api-v12/stream/readable_readableobjectmode.html)

新增于: v12.3.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

给定 `Readable` 流的属性 `objectMode` 的获取器。

###### `readable.resume()`[#](http://nodejs.cn/api-v12/stream.html#readableresume)

[中英对照](http://nodejs.cn/api-v12/stream/readable_resume.html)

-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

`readable.resume()` 方法使被显式暂停的 `Readable` 流恢复触发 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件，将流切换到流动模式。

`readable.resume()` 方法可用于完全地消费流中的数据，而无需实际处理任何数据：

```
getReadableStreamSomehow()
  .resume()
  .on('end', () => {
    console.log('Reached the end, but did not read anything.');
  });
```

如果有 `'readable'` 事件监听器，则 `readable.resume()` 方法不起作用。

###### `readable.setEncoding(encoding)`[#](http://nodejs.cn/api-v12/stream.html#readablesetencodingencoding)

[中英对照](http://nodejs.cn/api-v12/stream/readable_setencoding_encoding.html)

新增于: v0.9.4

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 要使用的编码。
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

`readable.setEncoding()` 方法为从 `Readable` 流读取的数据设置字符编码。

默认情况下，没有分配编码，流数据将作为 `Buffer` 对象返回。 设置编码会导致流数据作为指定编码的字符串而不是 `Buffer` 对象返回。 例如，调用 `readable.setEncoding('utf8')` 将导致输出数据被解释为 UTF-8 数据，并作为字符串传入。 调用 `readable.setEncoding('hex')` 将使数据以十六进制字符串格式进行编码。

`Readable` 流将正确地处理通过流传递的多字节字符，否则如果简单地从流中提取为 `Buffer` 对象，这些字符将无法正确解码。

```
const readable = getReadableStreamSomehow();
readable.setEncoding('utf8');
readable.on('data', (chunk) => {
  assert.equal(typeof chunk, 'string');
  console.log('Got %d characters of string data:', chunk.length);
});
```

###### `readable.unpipe([destination])`[#](http://nodejs.cn/api-v12/stream.html#readableunpipedestination)

[中英对照](http://nodejs.cn/api-v12/stream/readable_unpipe_destination.html)

新增于: v0.9.4

-   `destination` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable) 可选的要取消管道的特定流
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

`readable.unpipe()` 方法分离先前使用 [`stream.pipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pipe_destination_options) 方法绑定的 `Writable` 流。

如果未指定 `destination`，则所有管道都将分离。

如果指定了 `destination`，但没有为其设置管道，则该方法不执行任何操作。

```
const fs = require('fs');
const readable = getReadableStreamSomehow();
const writable = fs.createWriteStream('file.txt');
// 可读流的所有数据进入 'file.txt'，
// 但只有第一秒。
readable.pipe(writable);
setTimeout(() => {
  console.log('Stop writing to file.txt.');
  readable.unpipe(writable);
  console.log('Manually close the file stream.');
  writable.end();
}, 1000);
```

###### `readable.unshift(chunk[, encoding])`[#](http://nodejs.cn/api-v12/stream.html#readableunshiftchunk-encoding)

[中英对照](http://nodejs.cn/api-v12/stream/readable_unshift_chunk_encoding.html)

-   `chunk` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) | [<any>](http://url.nodejs.cn/6sTGdS) 要取消转移到读取队列的数据块。 对于不在对象模式下操作的流，`chunk` 必须是字符串、`Buffer`、`Uint8Array`、或 `null`。 对于对象模式的流，`chunk` 可以是任何 JavaScript 值。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 字符串块的编码。 必须是有效的 `Buffer` 编码，例如 `'utf8'` 或 `'ascii'`。

将 `chunk` 作为 `null` 传入信号流结束 (EOF)，其行为与 `readable.push(null)` 相同，之后无法写入更多数据。 EOF 信号放在缓冲区的末尾，任何缓冲的数据仍将被刷新。

`readable.unshift()` 方法将数据块推回内部缓冲区。 这在某些情况下很有用，其中流被代码消费，需要"取消消耗"它已经从源中提取的一定数量的数据，以便数据可以传给其他方。

[`'end'`](http://nodejs.cn/api-v12/stream.html#stream_event_end) 事件触发后不能调用 `stream.unshift(chunk)` 方法，否则会抛出运行时错误。

使用 `stream.unshift()` 的开发者通常应该考虑改用 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流。 有关更多信息，请参阅[流实现者的 API](http://nodejs.cn/api-v12/stream.html#stream_api_for_stream_implementers) 章节。

```
// 拉出由 \n\n 分隔的标题。
// 如果获取太多，则使用 unshift()。
// 使用 (error, header, stream) 调用回调。
const { StringDecoder } = require('string_decoder');
function parseHeader(stream, callback) {
  stream.on('error', callback);
  stream.on('readable', onReadable);
  const decoder = new StringDecoder('utf8');
  let header = '';
  function onReadable() {
    let chunk;
    while (null !== (chunk = stream.read())) {
      const str = decoder.write(chunk);
      if (str.match(/\n\n/)) {
        // 找到标题边界。
        const split = str.split(/\n\n/);
        header += split.shift();
        const remaining = split.join('\n\n');
        const buf = Buffer.from(remaining, 'utf8');
        stream.removeListener('error', callback);
        // 在取消移位之前删除 'readable' 监听器。
        stream.removeListener('readable', onReadable);
        if (buf.length)
          stream.unshift(buf);
        // 现在可以从流中读取消息的正文。
        callback(null, header, stream);
      } else {
        // 仍在阅读标题。
        header += str;
      }
    }
  }
}
```

与 [`stream.push(chunk)`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding) 不同，`stream.unshift(chunk)` 不会通过重置流的内部读取状态来结束读取过程。 如果在读取期间调用 `readable.unshift()`（即从自定义流上的 [`stream._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 实现中调用），这可能会导致意外结果。 在立即调用 [`stream.push('')`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding) 之后调用 `readable.unshift()` 将适当地重置读取状态，但是最好避免在执行读取过程中调用 `readable.unshift()`。

###### `readable.wrap(stream)`[#](http://nodejs.cn/api-v12/stream.html#readablewrapstream)

[中英对照](http://nodejs.cn/api-v12/stream/readable_wrap_stream.html)

新增于: v0.9.4

-   `stream` [<Stream>](http://nodejs.cn/api/stream.html#stream) “旧式”的可读流
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

在 Node.js 0.10 之前，流没有实现当前定义的整个 `stream` 模块 API。 （有关更多信息，请参阅[兼容性](http://nodejs.cn/api-v12/stream.html#stream_compatibility_with_older_node_js_versions)。）

当使用旧的 Node.js 库，它触发 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件并且有一个 [`stream.pause()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pause) 方法只是建议性的，`readable.wrap()` 方法可用于创建一个使用旧流作为其数据源的 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流。

很少需要使用 `readable.wrap()`，但提供该方法是为了方便与较旧的 Node.js 应用程序和库进行交互。

```
const { OldReader } = require('./old-api-module.js');
const { Readable } = require('stream');
const oreader = new OldReader();
const myReader = new Readable().wrap(oreader);

myReader.on('readable', () => {
  myReader.read(); // 等等。
});
```

###### `readable[Symbol.asyncIterator]()`[#](http://nodejs.cn/api-v12/stream.html#readablesymbolasynciterator)

[中英对照](http://nodejs.cn/api-v12/stream/readable_symbol_asynciterator.html)

-   返回: [<AsyncIterator>](http://url.nodejs.cn/HnG4ws) 以完全消费流。

```
const fs = require('fs');

async function print(readable) {
  readable.setEncoding('utf8');
  let data = '';
  for await (const chunk of readable) {
    data += chunk;
  }
  console.log(data);
}

print(fs.createReadStream('file')).catch(console.error);
```

如果循环以 `break` 或 `throw` 终止，则流将被销毁。 换句话说，遍历流将完全消费流。 流将以大小等于 `highWaterMark` 选项的块读取。 在上面的代码示例中，如果文件的数据少于 64KB，则数据将位于单个块中，因为没有为 [`fs.createReadStream()`](http://nodejs.cn/api-v12/fs.html#fs_fs_createreadstream_path_options) 提供 `highWaterMark` 选项。

#### 双工流与转换流[#](http://nodejs.cn/api-v12/stream.html#duplex-and-transform-streams)

##### `stream.Duplex` 类[#](http://nodejs.cn/api-v12/stream.html#class-streamduplex)

[中英对照](http://nodejs.cn/api-v12/stream/class_stream_duplex.html)

双工流是同时实现 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 和 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 接口的流。

`Duplex` 流的示例包括：

-   [TCP 套接字](http://nodejs.cn/api-v12/net.html#net_class_net_socket)
-   [压缩流](http://nodejs.cn/api-v12/zlib.html)
-   [加密流](http://nodejs.cn/api-v12/crypto.html)

##### `stream.Transform` 类[#](http://nodejs.cn/api-v12/stream.html#class-streamtransform)

[中英对照](http://nodejs.cn/api-v12/stream/class_stream_transform.html)

新增于: v0.9.4

转换流是 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流，其中输出以某种方式与输入相关。 与所有 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流一样，`Transform` 流实现了 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 和 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 接口。

`Transform` 流的示例包括：

-   [压缩流](http://nodejs.cn/api-v12/zlib.html)
-   [加密流](http://nodejs.cn/api-v12/crypto.html)

###### `transform.destroy([error])`[#](http://nodejs.cn/api-v12/stream.html#transformdestroyerror)

[中英对照](http://nodejs.cn/api-v12/stream/transform_destroy_error.html)

新增于: v8.0.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x)
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

销毁流，并可选择地触发 `'error'` 事件。 在此调用之后，转换流将释放任何内部资源。 实现者不应覆盖此方法，而应实现 [`readable._destroy()`](http://nodejs.cn/api-v12/stream.html#stream_readable_destroy_err_callback)。 `Transform` 的 `_destroy()` 的默认实现也会触发 `'close'`，除非 `emitClose` 设置为 false。

#### `stream.finished(stream[, options], callback)`[#](http://nodejs.cn/api-v12/stream.html#streamfinishedstream-options-callback)

[中英对照](http://nodejs.cn/api-v12/stream/stream_finished_stream_options_callback.html)

新增于: v10.0.0

-   `stream` [<Stream>](http://nodejs.cn/api/stream.html#stream) 可读和/或可写的流。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `error` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 `false`，则对 `emit('error', err)` 的调用不会被视为已完成。 **默认值**: `true`.
    -   `readable` [<boolean>](http://url.nodejs.cn/jFbvuT) 当设置为 `false` 时，即使流可能仍然可读，也会在流结束时调用回调。 **默认值**: `true`.
    -   `writable` [<boolean>](http://url.nodejs.cn/jFbvuT) 当设置为 `false` 时，即使流可能仍可写，也会在流结束时调用回调。 **默认值**: `true`.
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 采用可选的错误参数的回调函数。
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6) 清除所有已注册监听器的函数。

当流不再可读、可写或遇到错误或过早关闭事件时获得通知的函数。

```
const { finished } = require('stream');

const rs = fs.createReadStream('archive.tar');

finished(rs, (err) => {
  if (err) {
    console.error('Stream failed.', err);
  } else {
    console.log('Stream is done reading.');
  }
});

rs.resume(); // 排空流。
```

在流被过早销毁（如中止的 HTTP 请求）并且不会触发 `'end'` 或 `'finish'` 的错误处理场景中特别有用。

`finished` API 也是可 promise 化的；

```
const finished = util.promisify(stream.finished);

const rs = fs.createReadStream('archive.tar');

async function run() {
  await finished(rs);
  console.log('Stream is done reading.');
}

run().catch(console.error);
rs.resume(); // 排空流。
```

`stream.finished()` 在调用 `callback` 后离开悬空事件监听器（特别是 `'error'`、`'end'`、`'finish'` 和 `'close'`）。 这样做的原因是意外的 `'error'` 事件（由于不正确的流实现）不会导致意外崩溃。 如果这是不需要的行为，则需要在回调中调用返回的清理函数：

```
const cleanup = finished(rs, (err) => {
  cleanup();
  // ...
});
```

#### `stream.pipeline(...streams, callback)`[#](http://nodejs.cn/api-v12/stream.html#streampipelinestreams-callback)

[中英对照](http://nodejs.cn/api-v12/stream/stream_pipeline_streams_callback.html)

新增于: v10.0.0

-   `...streams` [<Stream>](http://nodejs.cn/api/stream.html#stream)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当管道完全完成时调用。
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)

```
const { pipeline } = require('stream');
const fs = require('fs');
const zlib = require('zlib');

// 使用管道 API 可以轻松地将一系列流传输到一起，
// 并在管道完全完成时收到通知。

// 有效地 gzip 潜在巨大的 tar 文件的管道：

pipeline(
  fs.createReadStream('archive.tar'),
  zlib.createGzip(),
  fs.createWriteStream('archive.tar.gz'),
  (err) => {
    if (err) {
      console.error('Pipeline failed.', err);
    } else {
      console.log('Pipeline succeeded.');
    }
  }
);
```

`pipeline` API 也是可 promise 化的：

```
const pipeline = util.promisify(stream.pipeline);

async function run() {
  await pipeline(
    fs.createReadStream('archive.tar'),
    zlib.createGzip(),
    fs.createWriteStream('archive.tar.gz')
  );
  console.log('Pipeline succeeded.');
}

run().catch(console.error);
```

`stream.pipeline()` 将在所有流上调用 `stream.destroy(err)`，除了：

-   已触发 `'end'` 或 `'close'` 的 `Readable` 流。
-   已触发 `'finish'` 或 `'close'` 的 `Writable` 流。

在调用 `callback` 后，`stream.pipeline()` 在流上留下悬空事件监听器。 在失败后重用流的情况下，这可能会导致事件监听器泄漏和吞下错误。

#### `stream.Readable.from(iterable, [options])`[#](http://nodejs.cn/api-v12/stream.html#streamreadablefromiterable-options)

[中英对照](http://nodejs.cn/api-v12/stream/stream_readable_from_iterable_options.html)

新增于: v12.3.0, v10.17.0

-   `iterable` [<Iterable>](http://url.nodejs.cn/mQfCyy) 实现 `Symbol.asyncIterator` 或 `Symbol.iterator` 可迭代协议的对象。 如果传入空值，则触发 'error' 事件。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 提供给 `new stream.Readable([options])` 的选项。 默认情况下，`Readable.from()` 会将 `options.objectMode` 设置为 `true`，除非通过将 `options.objectMode` 设置为 `false` 来明确选择退出。
-   返回: [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

一个从迭代器中创建可读流的实用方法。

```
const { Readable } = require('stream');

async function * generate() {
  yield 'hello';
  yield 'streams';
}

const readable = Readable.from(generate());

readable.on('data', (chunk) => {
  console.log(chunk);
});
```

出于性能原因，调用 `Readable.from(string)` 或 `Readable.from(buffer)` 不会迭代字符串或缓冲区以匹配其他流语义。

### 流实现者的 API[#](http://nodejs.cn/api-v12/stream.html#api-for-stream-implementers)

[中英对照](http://nodejs.cn/api-v12/stream/api_for_stream_implementers.html)

`stream` 模块 API 旨在使使用 JavaScript 的原型继承模型轻松实现流成为可能。

首先，流开发者将声明新的 JavaScript 类，该类扩展四个基本流类（`stream.Writable`、`stream.Readable`、`stream.Duplex` 或 `stream.Transform`）之一，确保它们调用适当的父类构造函数：

```
const { Writable } = require('stream');

class MyWritable extends Writable {
  constructor({ highWaterMark, ...options }) {
    super({
      highWaterMark,
      autoDestroy: true,
      emitClose: true
    });
    // ...
  }
}
```

当扩展流时，在将这些选项转发给基本构造函数之前，请记住用户可以和应该提供哪些选项。 例如，如果实现对 `autoDestroy` 和 `emitClose` 选项做出假设，则不允许用户覆盖这些。 显式转发哪些选项，而不是隐式转发所有选项。

然后，新的流类必须实现一个或多个特定方法，具体取决于正在创建的流的类型，如下图所示：

| 用例 | 类 | 要实现的方法 |
| --- | --- | --- |
| 只读 | [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) | [`_read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) |
| 只写 | [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) | [`_write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback_1), [`_writev()`](http://nodejs.cn/api-v12/stream.html#stream_writable_writev_chunks_callback), [`_final()`](http://nodejs.cn/api-v12/stream.html#stream_writable_final_callback) |
| 可读可写 | [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) | [`_read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1), [`_write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback_1), [`_writev()`](http://nodejs.cn/api-v12/stream.html#stream_writable_writev_chunks_callback), [`_final()`](http://nodejs.cn/api-v12/stream.html#stream_writable_final_callback) |
| 对写入的数据进行操作，然后读取结果 | [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) | [`_transform()`](http://nodejs.cn/api-v12/stream.html#stream_transform_transform_chunk_encoding_callback), [`_flush()`](http://nodejs.cn/api-v12/stream.html#stream_transform_flush_callback), [`_final()`](http://nodejs.cn/api-v12/stream.html#stream_writable_final_callback) |

流的实现代码永远不应该调用供消费者使用的流的“公共”方法（如[流消费者的 API](http://nodejs.cn/api-v12/stream.html#stream_api_for_stream_consumers) 章节所述）。 这样做可能会对使用流的应用程序代码产生不利的副作用。

避免覆盖公共方法，例如 `write()`、`end()`、`cork()`、`uncork()`、`read()` 和 `destroy()`，或触发内部事件，例如 `'error'`、`'data'`、`'end'`、`'finish'` 和 `'close'` 到 `.emit()`。 这样做可能会破坏当前和未来的流的不变量，从而导致行为和/或与其他流、流实用程序和用户期望的兼容性问题。

#### 简单的实现[#](http://nodejs.cn/api-v12/stream.html#simplified-construction)

[中英对照](http://nodejs.cn/api-v12/stream/simplified_construction.html)

新增于: v1.2.0

对于许多简单的情况，可以在不依赖继承的情况下构造流。 这可以通过直接创建 `stream.Writable`、`stream.Readable`、`stream.Duplex` 或 `stream.Transform` 对象的实例并传入适当的方法作为构造函数选项来实现。

```
const { Writable } = require('stream');

const myWritable = new Writable({
  write(chunk, encoding, callback) {
    // ...
  }
});
```

#### 实现可写流[#](http://nodejs.cn/api-v12/stream.html#implementing-a-writable-stream)

[中英对照](http://nodejs.cn/api-v12/stream/implementing_a_writable_stream.html)

`stream.Writable` 类被扩展以实现 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流。

自定义的 `Writable` 流必须调用 `new stream.Writable([options])` 构造函数并实现 `writable._write()` 和/或 `writable._writev()` 方法。

##### `new stream.Writable([options])`[#](http://nodejs.cn/api-v12/stream.html#new-streamwritableoptions)

[中英对照](http://nodejs.cn/api-v12/stream/new_stream_writable_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `highWaterMark` [<number>](http://url.nodejs.cn/SXbo1v) [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 开始返回 `false` 时的缓冲级别。 **默认值:** `16384` (16KB) 或 `16` 表示 `objectMode` 流。
    -   `decodeStrings` [<boolean>](http://url.nodejs.cn/jFbvuT) 是否将传给 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 的 `string` 编码为 `Buffer`（使用 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 调用中指定的编码），然后再将它们传给 [`stream._write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback_1)。 其他类型的数据不会被转换（即 `Buffer` 不会被解码为 `string`）。 设置为 false 将阻止 `string` 被转换。 **默认值:** `true`。
    -   `defaultEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 当没有将编码指定为 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 的参数时使用的默认编码。 **默认值:** `'utf8'`。
    -   `objectMode` [<boolean>](http://url.nodejs.cn/jFbvuT) [`stream.write(anyObj)`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 是否为有效操作。 当设置后，如果流实现支持，则可以写入字符串、`Buffer` 或 `Uint8Array` 以外的 JavaScript 值。 **默认值:** `false`。
    -   `emitClose` [<boolean>](http://url.nodejs.cn/jFbvuT) 流被销毁后是否应该触发 `'close'`。 **默认值:** `true`。
    -   `write` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback_1) 方法的实现。
    -   `writev` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._writev()`](http://nodejs.cn/api-v12/stream.html#stream_writable_writev_chunks_callback) 方法的实现。
    -   `destroy` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._destroy()`](http://nodejs.cn/api-v12/stream.html#stream_writable_destroy_err_callback) 方法的实现。
    -   `final` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._final()`](http://nodejs.cn/api-v12/stream.html#stream_writable_final_callback) 方法的实现。
    -   `autoDestroy` [<boolean>](http://url.nodejs.cn/jFbvuT) 此流是否应在结束后自动调用自身的 `.destroy()`。 **默认值:** `false`。

```
const { Writable } = require('stream');

class MyWritable extends Writable {
  constructor(options) {
    // 调用 stream.Writable() 构造函数。
    super(options);
    // ...
  }
}
```

或者，当使用 ES6 之前的风格构造函数时：

```
const { Writable } = require('stream');
const util = require('util');

function MyWritable(options) {
  if (!(this instanceof MyWritable))
    return new MyWritable(options);
  Writable.call(this, options);
}
util.inherits(MyWritable, Writable);
```

或者，使用简化的构造函数方法：

```
const { Writable } = require('stream');

const myWritable = new Writable({
  write(chunk, encoding, callback) {
    // ...
  },
  writev(chunks, callback) {
    // ...
  }
});
```

##### `writable._write(chunk, encoding, callback)`[#](http://nodejs.cn/api-v12/stream.html#writable_writechunk-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/stream/writable_write_chunk_encoding_callback_1.html)

-   `chunk` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<any>](http://url.nodejs.cn/6sTGdS) 要写入的 `Buffer`，从 `string` 转换为 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback)。 如果流的 `decodeStrings` 选项是 `false` 或者流在对象模式下运行，则块将不会被转换，而是传给 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 的任何内容。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果块是字符串，则 `encoding` 是该字符串的字符编码。 如果块是 `Buffer`，或者如果流在对象模式下运行，则可以忽略 `encoding`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当对提供的块的处理完成时调用此函数（可选地带有错误参数）。

所有 `Writable` 流实现都必须提供 [`writable._write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback_1) 和/或 [`writable._writev()`](http://nodejs.cn/api-v12/stream.html#stream_writable_writev_chunks_callback) 方法来将数据发送到底层资源。

[`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流提供了它们自己的 [`writable._write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback_1) 实现。

此函数不得由应用程序代码直接调用。 它应该由子类实现，并且只能由内部 `Writable` 类方法调用。

如果调用失败，则传给 `callback` 的第一个参数必须是 `Error` 对象，如果写入成功，则传入 `null` 对象。

在调用 `writable._write()` 和调用 `callback` 之间发生的对 `writable.write()` 的所有调用都将导致写入的数据被缓冲。 当调用 `callback` 时，流可能会触发 [`'drain'`](http://nodejs.cn/api-v12/stream.html#stream_event_drain) 事件。 如果流实现能够同时处理多个数据块，则应实现 `writable._writev()` 方法。

如果在构造函数选项中将 `decodeStrings` 属性显式设置为 `false`，则 `chunk` 将保持传给 `.write()` 的相同对象，并且可能是字符串而不是 `Buffer`。 这是为了支持对某些字符串数据编码进行优化处理的实现。 在这种情况下，`encoding` 参数将指示字符串的字符编码。 否则，可以安全地忽略 `encoding` 参数。

`writable._write()` 方法以下划线为前缀，因为它是定义它的类的内部方法，不应由用户程序直接调用。

##### `writable._writev(chunks, callback)`[#](http://nodejs.cn/api-v12/stream.html#writable_writevchunks-callback)

[中英对照](http://nodejs.cn/api-v12/stream/writable_writev_chunks_callback.html)

-   `chunks` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)
    
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当对提供的块的处理完成时要调用的回调函数（可选地带有错误参数）。
    

此函数不得由应用程序代码直接调用。 它应该由子类实现，并且只能由内部 `Writable` 类方法调用。

`writable._writev()` 方法可以在能够同时处理多个数据块的流实现中作为 `writable._write()` 的补充或替代来实现。 如果实现并且有来自先前写入的缓冲数据，则将调用 `_writev()` 而不是 `_write()`。

`writable._writev()` 方法以下划线为前缀，因为它是定义它的类的内部方法，不应由用户程序直接调用。

##### `writable._destroy(err, callback)`[#](http://nodejs.cn/api-v12/stream.html#writable_destroyerr-callback)

[中英对照](http://nodejs.cn/api-v12/stream/writable_destroy_err_callback.html)

新增于: v8.0.0

-   `err` [<Error>](http://url.nodejs.cn/qZ873x) 可能的错误。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 采用可选的错误参数的回调函数。

`_destroy()` 方法由 [`writable.destroy()`](http://nodejs.cn/api-v12/stream.html#stream_writable_destroy_error) 调用。 它可以被子类覆盖，但不能直接调用。

##### `writable._final(callback)`[#](http://nodejs.cn/api-v12/stream.html#writable_finalcallback)

[中英对照](http://nodejs.cn/api-v12/stream/writable_final_callback.html)

新增于: v8.0.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 完成写入任何剩余数据后调用此函数（可选地带有错误参数）。

不得直接调用 `_final()` 方法。 它可以由子类实现，如果是，则只能由内部 `Writable` 类方法调用。

这个可选函数将在流关闭之前被调用，将 `'finish'` 事件延迟到 `callback` 被调用。 这对于在流结束之前关闭资源或写入缓冲数据很有用。

##### 写入时出错[#](http://nodejs.cn/api-v12/stream.html#errors-while-writing)

[中英对照](http://nodejs.cn/api-v12/stream/errors_while_writing.html)

在 [`writable._write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback_1)、[`writable._writev()`](http://nodejs.cn/api-v12/stream.html#stream_writable_writev_chunks_callback) 和 [`writable._final()`](http://nodejs.cn/api-v12/stream.html#stream_writable_final_callback) 方法的处理过程中发生的错误必须通过调用回调并将错误作为第一个参数传入来传播。 从这些方法中抛出 `Error` 或手动触发 `'error'` 事件会导致未定义的行为。

如果 `Readable` 流在 `Writable` 触发错误时通过管道传输到 `Writable` 流，则 `Readable` 流将被取消管道。

```
const { Writable } = require('stream');

const myWritable = new Writable({
  write(chunk, encoding, callback) {
    if (chunk.toString().indexOf('a') >= 0) {
      callback(new Error('chunk is invalid'));
    } else {
      callback();
    }
  }
});
```

##### 可写流的示例[#](http://nodejs.cn/api-v12/stream.html#an-example-writable-stream)

[中英对照](http://nodejs.cn/api-v12/stream/an_example_writable_stream.html)

下面说明了一个相当简单（有些毫无意义）的自定义 `Writable` 流的实现。 虽然这个特定的 `Writable` 流实例没有任何真正的特殊用途，但该示例说明了自定义 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流实例的每个必需元素：

```
const { Writable } = require('stream');

class MyWritable extends Writable {
  _write(chunk, encoding, callback) {
    if (chunk.toString().indexOf('a') >= 0) {
      callback(new Error('chunk is invalid'));
    } else {
      callback();
    }
  }
}
```

##### 在可写流中解码缓冲区[#](http://nodejs.cn/api-v12/stream.html#decoding-buffers-in-a-writable-stream)

[中英对照](http://nodejs.cn/api-v12/stream/decoding_buffers_in_a_writable_stream.html)

解码缓冲区是一项常见任务，例如，在使用输入为字符串的转换器时。 在使用多字节字符编码（例如 UTF-8）时，这不是一个简单的过程。 以下示例显示如何使用 `StringDecoder` 和 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 解码多字节字符串。

```
const { Writable } = require('stream');
const { StringDecoder } = require('string_decoder');

class StringWritable extends Writable {
  constructor(options) {
    super(options);
    this._decoder = new StringDecoder(options && options.defaultEncoding);
    this.data = '';
  }
  _write(chunk, encoding, callback) {
    if (encoding === 'buffer') {
      chunk = this._decoder.write(chunk);
    }
    this.data += chunk;
    callback();
  }
  _final(callback) {
    this.data += this._decoder.end();
    callback();
  }
}

const euro = [[0xE2, 0x82], [0xAC]].map(Buffer.from);
const w = new StringWritable();

w.write('currency: ');
w.write(euro[0]);
w.end(euro[1]);

console.log(w.data); // currency: €
```

#### 实现可读流[#](http://nodejs.cn/api-v12/stream.html#implementing-a-readable-stream)

[中英对照](http://nodejs.cn/api-v12/stream/implementing_a_readable_stream.html)

`stream.Readable` 类被扩展以实现 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流。

自定义 `Readable` 流必须调用 `new stream.Readable([options])` 构造函数并实现 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法。

##### `new stream.Readable([options])`[#](http://nodejs.cn/api-v12/stream.html#new-streamreadableoptions)

[中英对照](http://nodejs.cn/api-v12/stream/new_stream_readable_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `highWaterMark` [<number>](http://url.nodejs.cn/SXbo1v) 在停止从底层资源读取之前存储在内部缓冲区中的[最大字节数](http://nodejs.cn/api-v12/stream.html#stream_highwatermark_discrepancy_after_calling_readable_setencoding)。 **默认值:** `16384` (16KB) 或 `16` 表示 `objectMode` 流。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果指定，则缓冲区将使用指定的编码解码为字符串。 **默认值:** `null`。
    -   `objectMode` [<boolean>](http://url.nodejs.cn/jFbvuT) 此流是否应表现为对象流。 这意味着 [`stream.read(n)`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 返回单个值而不是大小为 `n` 的 `Buffer`。 **默认值:** `false`。
    -   `emitClose` [<boolean>](http://url.nodejs.cn/jFbvuT) 流被销毁后是否应该触发 `'close'`。 **默认值:** `true`。
    -   `read` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法的实现。
    -   `destroy` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._destroy()`](http://nodejs.cn/api-v12/stream.html#stream_readable_destroy_err_callback) 方法的实现。
    -   `autoDestroy` [<boolean>](http://url.nodejs.cn/jFbvuT) 此流是否应在结束后自动调用自身的 `.destroy()`。 **默认值:** `false`。

```
const { Readable } = require('stream');

class MyReadable extends Readable {
  constructor(options) {
    // 调用 stream.Readable(options) 构造函数。
    super(options);
    // ...
  }
}
```

或者，当使用 ES6 之前的风格构造函数时：

```
const { Readable } = require('stream');
const util = require('util');

function MyReadable(options) {
  if (!(this instanceof MyReadable))
    return new MyReadable(options);
  Readable.call(this, options);
}
util.inherits(MyReadable, Readable);
```

或者，使用简化的构造函数方法：

```
const { Readable } = require('stream');

const myReadable = new Readable({
  read(size) {
    // ...
  }
});
```

##### `readable._read(size)`[#](http://nodejs.cn/api-v12/stream.html#readable_readsize)

[中英对照](http://nodejs.cn/api-v12/stream/readable_read_size_1.html)

新增于: v0.9.4

-   `size` [<number>](http://url.nodejs.cn/SXbo1v) 异步地读取的字节数

此函数不得由应用程序代码直接调用。 它应该由子类实现，并且只能由内部 `Readable` 类方法调用。

所有 `Readable` 流实现都必须提供 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法的实现，以从底层资源中获取数据。

调用 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 时，如果资源中的数据可用，则实现应开始使用 [`this.push(dataChunk)`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding) 方法将该数据推送到读取队列中。

一旦调用了 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法，则不会再次调用它，直到通过 [`readable.push()`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding) 方法推送更多数据。 空缓冲区和字符串等空数据不会导致调用 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1)。

`size` 参数是建议性的。 对于“读取”是返回数据的单个操作的实现，可以使用 `size` 参数来确定要获取多少数据。 其他实现可能会忽略此参数，并在数据可用时简单地提供数据。 在调用 [`stream.push(chunk)`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding) 之前不需要“等待”直到 `size` 个字节可用。

[`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法以下划线为前缀，因为它是定义它的类的内部方法，不应由用户程序直接调用。

##### `readable._destroy(err, callback)`[#](http://nodejs.cn/api-v12/stream.html#readable_destroyerr-callback)

[中英对照](http://nodejs.cn/api-v12/stream/readable_destroy_err_callback.html)

新增于: v8.0.0

-   `err` [<Error>](http://url.nodejs.cn/qZ873x) 可能的错误。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 采用可选的错误参数的回调函数。

`_destroy()` 方法由 [`readable.destroy()`](http://nodejs.cn/api-v12/stream.html#stream_readable_destroy_error) 调用。 它可以被子类覆盖，但不能直接调用。

##### `readable.push(chunk[, encoding])`[#](http://nodejs.cn/api-v12/stream.html#readablepushchunk-encoding)

[中英对照](http://nodejs.cn/api-v12/stream/readable_push_chunk_encoding.html)

-   `chunk` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) | [<any>](http://url.nodejs.cn/6sTGdS) 要推入读取队列的数据块。 对于不在对象模式下操作的流，`chunk` 必须是字符串、`Buffer` 或 `Uint8Array`。 对于对象模式的流，`chunk` 可以是任何 JavaScript 值。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 字符串块的编码。 必须是有效的 `Buffer` 编码，例如 `'utf8'` 或 `'ascii'`。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果可以继续推送额外的数据块，则为 `true`；否则为 `false`。

当 `chunk` 为 `Buffer`、`Uint8Array` 或 `string` 时，数据的 `chunk` 将被添加到内部队列中供流的用户消费。 将 `chunk` 作为 `null` 传递信号表示流结束 (EOF)，之后不能再写入数据。

当 `Readable` 处于暂停模式时，在 [`'readable'`](http://nodejs.cn/api-v12/stream.html#stream_event_readable) 事件触发时调用 [`readable.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 方法可以读出添加了 `readable.push()` 的数据。

当 `Readable` 工作在流动模式时，添加了 `readable.push()` 的数据将通过触发 `'data'` 事件来传递。

`readable.push()` 方法设计得尽可能灵活。 例如，当封装提供某种形式的暂停/恢复机制和数据回调的低层源时，低层源可以由自定义 `Readable` 实例封装：

```
// `_source` 是一个具有 readStop() 和 readStart() 方法的对象，
// 当有数据时调用 `ondata` 成员，
// 当数据结束时调用 `onend` 成员。

class SourceWrapper extends Readable {
  constructor(options) {
    super(options);

    this._source = getLowLevelSourceObject();

    // 每次有数据时，将其推入内部缓冲区。
    this._source.ondata = (chunk) => {
      // 如果 push() 返回 false，则停止从源读取。
      if (!this.push(chunk))
        this._source.readStop();
    };

    // 当源结束时，推送 EOF 信令 `null` 块。
    this._source.onend = () => {
      this.push(null);
    };
  }
  // 当流想要拉入更多数据时将调用 _read() 。
  // 在这种情况下，会忽略建议的大小参数。
  _read(size) {
    this._source.readStart();
  }
}
```

`readable.push()` 方法用于将内容推送到内部缓冲区中。 它可以由 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法驱动。

对于非对象模式的流，如果 `readable.push()` 的 `chunk` 参数为 `undefined`，它将被视为空字符串或缓冲区。 有关详细信息，请参阅 [`readable.push('')`](http://nodejs.cn/api-v12/stream.html#stream_readable_push)。

##### 读取时出错[#](http://nodejs.cn/api-v12/stream.html#errors-while-reading)

[中英对照](http://nodejs.cn/api-v12/stream/errors_while_reading.html)

[`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 处理过程中发生的错误必须通过 [`readable.destroy(err)`](http://nodejs.cn/api-v12/stream.html#stream_readable_destroy_err_callback) 方法传播。 从 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 中抛出 `Error` 或手动触发 `'error'` 事件会导致未定义的行为。

```
const { Readable } = require('stream');

const myReadable = new Readable({
  read(size) {
    const err = checkSomeErrorCondition();
    if (err) {
      this.destroy(err);
    } else {
      // 做一些工作。
    }
  }
});
```

##### 可读流的示例[#](http://nodejs.cn/api-v12/stream.html#an-example-counting-stream)

[中英对照](http://nodejs.cn/api-v12/stream/an_example_counting_stream.html)

下面是一个 `Readable` 流的基本示例，它按升序触发从 1 到 1,000,000 的数字，然后结束。

```
const { Readable } = require('stream');

class Counter extends Readable {
  constructor(opt) {
    super(opt);
    this._max = 1000000;
    this._index = 1;
  }

  _read() {
    const i = this._index++;
    if (i > this._max)
      this.push(null);
    else {
      const str = String(i);
      const buf = Buffer.from(str, 'ascii');
      this.push(buf);
    }
  }
}
```

#### 实现双工流[#](http://nodejs.cn/api-v12/stream.html#implementing-a-duplex-stream)

[中英对照](http://nodejs.cn/api-v12/stream/implementing_a_duplex_stream.html)

[`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流是同时实现 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 和 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 的流，例如 TCP 套接字连接。

因为 JavaScript 不支持多重继承，所以扩展了 `stream.Duplex` 类以实现 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流（与扩展 `stream.Readable` 和 `stream.Writable` 类相反）。

`stream.Duplex` 类原型继承自 `stream.Readable` 并寄生于 `stream.Writable`，但由于覆盖了 `stream.Writable` 上的 [`Symbol.hasInstance`](http://url.nodejs.cn/D1EDvM)，`instanceof` 将适用于两个基类。

自定义的 `Duplex` 流必须调用 `new stream.Duplex([options])` 构造函数并实现 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 和 `writable._write()` 方法。

##### `new stream.Duplex(options)`[#](http://nodejs.cn/api-v12/stream.html#new-streamduplexoptions)

[中英对照](http://nodejs.cn/api-v12/stream/new_stream_duplex_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 传给 `Writable` 和 `Readable` 构造函数。 还具有以下字段：
    -   `allowHalfOpen` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 `false`，则流将在可读端结束时自动结束可写端。 **默认值:** `true`。
    -   `readable` [<boolean>](http://url.nodejs.cn/jFbvuT) 设置 `Duplex` 是否可读。 **默认值:** `true`。
    -   `writable` [<boolean>](http://url.nodejs.cn/jFbvuT) 设置 `Duplex` 是否可写。 **默认值:** `true`。
    -   `readableObjectMode` [<boolean>](http://url.nodejs.cn/jFbvuT) 为流的可读端设置 `objectMode`。 如果 `objectMode` 是 `true`，则无效。 **默认值:** `false`。
    -   `writableObjectMode` [<boolean>](http://url.nodejs.cn/jFbvuT) 为流的可写端设置 `objectMode`。 如果 `objectMode` 是 `true`，则无效。 **默认值:** `false`。
    -   `readableHighWaterMark` [<number>](http://url.nodejs.cn/SXbo1v) 为流的可读端设置 `highWaterMark`。 如果提供 `highWaterMark`，则无效。
    -   `writableHighWaterMark` [<number>](http://url.nodejs.cn/SXbo1v) 为流的可写端设置 `highWaterMark`。 如果提供 `highWaterMark`，则无效。

```
const { Duplex } = require('stream');

class MyDuplex extends Duplex {
  constructor(options) {
    super(options);
    // ...
  }
}
```

或者，当使用 ES6 之前的风格构造函数时：

```
const { Duplex } = require('stream');
const util = require('util');

function MyDuplex(options) {
  if (!(this instanceof MyDuplex))
    return new MyDuplex(options);
  Duplex.call(this, options);
}
util.inherits(MyDuplex, Duplex);
```

或者，使用简化的构造函数方法：

```
const { Duplex } = require('stream');

const myDuplex = new Duplex({
  read(size) {
    // ...
  },
  write(chunk, encoding, callback) {
    // ...
  }
});
```

##### 双工流的例子[#](http://nodejs.cn/api-v12/stream.html#an-example-duplex-stream)

[中英对照](http://nodejs.cn/api-v12/stream/an_example_duplex_stream.html)

下面说明了一个简单的 `Duplex` 流的示例，它封装了一个假设的低层源对象，可以向其中写入数据，也可以从中读取数据，尽管使用的 API 与 Node.js 流不兼容。 下面说明了一个简单的 `Duplex` 流的示例，它缓冲通过 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 接口传入的写入数据，然后通过 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 接口读回。

```
const { Duplex } = require('stream');
const kSource = Symbol('source');

class MyDuplex extends Duplex {
  constructor(source, options) {
    super(options);
    this[kSource] = source;
  }

  _write(chunk, encoding, callback) {
    // 底层源代码只处理字符串。
    if (Buffer.isBuffer(chunk))
      chunk = chunk.toString();
    this[kSource].writeSomeData(chunk);
    callback();
  }

  _read(size) {
    this[kSource].fetchSomeData(size, (data, encoding) => {
      this.push(Buffer.from(data, encoding));
    });
  }
}
```

`Duplex` 流最重要的方面是 `Readable` 和 `Writable` 端彼此独立运行，尽管它们共存于单个对象实例中。

##### 对象模式的双工流[#](http://nodejs.cn/api-v12/stream.html#object-mode-duplex-streams)

[中英对照](http://nodejs.cn/api-v12/stream/object_mode_duplex_streams.html)

对于 `Duplex` 流，可以分别使用 `readableObjectMode` 和 `writableObjectMode` 选项为 `Readable` 或 `Writable` 侧专门设置 `objectMode`。

例如，在下面的示例中，创建了新的 `Transform` 流（它是 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流），它具有对象模式的 `Writable` 端，该端接受 JavaScript 数字，这些数字在 `Readable` 端转换为十六进制字符串。

```
const { Transform } = require('stream');

// 所有转换流也是双工流。
const myTransform = new Transform({
  writableObjectMode: true,

  transform(chunk, encoding, callback) {
    // 如有必要，将块强制为数字。
    chunk |= 0;

    // 将块转换为其他东西。
    const data = chunk.toString(16);

    // 将数据推送到可读队列中。
    callback(null, '0'.repeat(data.length % 2) + data);
  }
});

myTransform.setEncoding('ascii');
myTransform.on('data', (chunk) => console.log(chunk));

myTransform.write(1);
// 打印: 01
myTransform.write(10);
// 打印: 0a
myTransform.write(100);
// 打印: 64
```

#### 实现转换流[#](http://nodejs.cn/api-v12/stream.html#implementing-a-transform-stream)

[中英对照](http://nodejs.cn/api-v12/stream/implementing_a_transform_stream.html)

[`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流是 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流，其中输出以某种方式从输入计算。 示例包括压缩、加密、或解密数据的[压缩](http://nodejs.cn/api-v12/zlib.html)流或[加密](http://nodejs.cn/api-v12/crypto.html)流。

不要求输出与输入大小相同、块数相同或同时到达。 例如，`Hash` 流只会有一个单一的输出块，它在输入结束时提供。 `zlib` 流将产生比其输入小得多或大得多的输出。

`stream.Transform` 类被扩展以实现 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流。

`stream.Transform` 类原型上继承自 `stream.Duplex` 并实现其自己版本的 `writable._write()` 和 [`readable._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 方法。 自定义的 `Transform` 实现必须实现 [`transform._transform()`](http://nodejs.cn/api-v12/stream.html#stream_transform_transform_chunk_encoding_callback) 方法，也可以实现 [`transform._flush()`](http://nodejs.cn/api-v12/stream.html#stream_transform_flush_callback) 方法。

使用 `Transform` 流时必须小心，因为如果不消耗 `Readable` 端的输出，写入流的数据可能导致流的 `Writable` 端暂停。

##### `new stream.Transform([options])`[#](http://nodejs.cn/api-v12/stream.html#new-streamtransformoptions)

[中英对照](http://nodejs.cn/api-v12/stream/new_stream_transform_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 传给 `Writable` 和 `Readable` 构造函数。 还具有以下字段：
    -   `transform` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._transform()`](http://nodejs.cn/api-v12/stream.html#stream_transform_transform_chunk_encoding_callback) 方法的实现。
    -   `flush` [<Function>](http://url.nodejs.cn/ceTQa6) [`stream._flush()`](http://nodejs.cn/api-v12/stream.html#stream_transform_flush_callback) 方法的实现。

```
const { Transform } = require('stream');

class MyTransform extends Transform {
  constructor(options) {
    super(options);
    // ...
  }
}
```

或者，当使用 ES6 之前的风格构造函数时：

```
const { Transform } = require('stream');
const util = require('util');

function MyTransform(options) {
  if (!(this instanceof MyTransform))
    return new MyTransform(options);
  Transform.call(this, options);
}
util.inherits(MyTransform, Transform);
```

或者，使用简化的构造函数方法：

```
const { Transform } = require('stream');

const myTransform = new Transform({
  transform(chunk, encoding, callback) {
    // ...
  }
});
```

##### 'finish' 与 'end' 事件[#](http://nodejs.cn/api-v12/stream.html#events-finish-and-end)

[中英对照](http://nodejs.cn/api-v12/stream/events_finish_and_end.html)

`'finish'` 事件在调用 [`stream.end()`](http://nodejs.cn/api-v12/stream.html#stream_writable_end_chunk_encoding_callback) 并且所有块都已被 [`stream._transform()`](http://nodejs.cn/api-v12/stream.html#stream_transform_transform_chunk_encoding_callback) 处理后触发。 `'end'` 事件在所有数据输出后触发，该事件发生在调用 [`transform._flush()`](http://nodejs.cn/api-v12/stream.html#stream_transform_flush_callback) 中的回调之后。

##### `transform._flush(callback)`[#](http://nodejs.cn/api-v12/stream.html#transform_flushcallback)

[中英对照](http://nodejs.cn/api-v12/stream/transform_flush_callback.html)

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 在刷新剩余数据时调用的回调函数（可选地带有错误参数和数据）。

此函数不得由应用程序代码直接调用。 它应该由子类实现，并且只能由内部 `Readable` 类方法调用。

在某些情况下，转换操作可能需要在流的末尾触发额外的数据位。 例如，`zlib` 压缩流将存储用于优化压缩输出的内部状态量。 但是，当流结束时，需要刷新额外的数据，以便完成压缩数据。

自定义的 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 实现可以实现 `transform._flush()` 方法。 当没有更多的写入数据被消耗时，但在触发 [`'end'`](http://nodejs.cn/api-v12/stream.html#stream_event_end) 事件以表示 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 流结束之前，将调用此方法。

在 `transform._flush()` 实现中，`transform.push()` 方法可以被调用零次或多次，视情况而定。 必须在刷新操作完成时调用 `callback` 函数。

`transform._flush()` 方法以下划线为前缀，因为它是定义它的类的内部方法，不应由用户程序直接调用。

##### `transform._transform(chunk, encoding, callback)`[#](http://nodejs.cn/api-v12/stream.html#transform_transformchunk-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/stream/transform_transform_chunk_encoding_callback.html)

-   `chunk` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<any>](http://url.nodejs.cn/6sTGdS) 要转换的 `Buffer`，从 `string` 转换为 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback)。 如果流的 `decodeStrings` 选项是 `false` 或者流在对象模式下运行，则块将不会被转换，而是传给 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 的任何内容。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果块是字符串，则这是编码类型。 如果块是缓冲区，则这是特殊值 `'buffer'`。 在这种情况下忽略它。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 在处理提供的 `chunk` 后调用的回调函数（可选地带有错误参数和数据）。

此函数不得由应用程序代码直接调用。 它应该由子类实现，并且只能由内部 `Readable` 类方法调用。

所有 `Transform` 流实现都必须提供 `_transform()` 方法来接受输入并产生输出。 `transform._transform()` 实现处理写入的字节，计算输出，然后使用 `transform.push()` 方法将该输出传给可读部分。

`transform.push()` 方法可以被调用零次或多次以从单个输入块生成输出，这取决于作为块的结果要输出多少。

任何给定的输入数据块都可能不会产生任何输出。

`callback` 函数必须在当前块被完全消耗时才被调用。 如果在处理输入时发生错误，则传给 `callback` 的第一个参数必须是 `Error` 对象，否则传给 `null`。 如果将第二个参数传给 `callback`，它将被转发到 `transform.push()` 方法。 换句话说，以下内容是等效的：

```
transform.prototype._transform = function(data, encoding, callback) {
  this.push(data);
  callback();
};

transform.prototype._transform = function(data, encoding, callback) {
  callback(null, data);
};
```

`transform._transform()` 方法以下划线为前缀，因为它是定义它的类的内部方法，不应由用户程序直接调用。

`transform._transform()` 永远不会被并行调用；流实现了一个队列机制，为了接收下一个块，必须同步或异步调用 `callback`。

##### `stream.PassThrough` 类[#](http://nodejs.cn/api-v12/stream.html#class-streampassthrough)

[中英对照](http://nodejs.cn/api-v12/stream/class_stream_passthrough.html)

`stream.PassThrough` 类是 [`Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform) 流的简单实现，它只是将输入字节传到输出。 它的目的主要是用于示例和测试，但在某些用例中，`stream.PassThrough` 可用作新型流的构建块。

### 其他注意事项[#](http://nodejs.cn/api-v12/stream.html#additional-notes)

#### 流与异步生成器和异步迭代器的兼容性[#](http://nodejs.cn/api-v12/stream.html#streams-compatibility-with-async-generators-and-async-iterators)

[中英对照](http://nodejs.cn/api-v12/stream/streams_compatibility_with_async_generators_and_async_iterators.html)

在 JavaScript 中异步生成器和迭代器的支持下，异步生成器在这一点上实际上是一流的语言级流构造。

下面提供了一些将 Node.js 流与异步生成器和异步迭代器一起使用的常见互操作案例。

##### 使用异步迭代器消费可读流[#](http://nodejs.cn/api-v12/stream.html#consuming-readable-streams-with-async-iterators)

[中英对照](http://nodejs.cn/api-v12/stream/consuming_readable_streams_with_async_iterators.html)

```
(async function() {
  for await (const chunk of readable) {
    console.log(chunk);
  }
})();
```

异步迭代器在流上注册一个永久的错误句柄，以防止任何未处理的销毁后错误。

##### 使用异步生成器创建可读流[#](http://nodejs.cn/api-v12/stream.html#creating-readable-streams-with-async-generators)

[中英对照](http://nodejs.cn/api-v12/stream/creating_readable_streams_with_async_generators.html)

可以使用 `Readable.from()` 实用方法从异步生成器构建 Node.js 可读流：

```
const { Readable } = require('stream');

async function * generate() {
  yield 'a';
  yield 'b';
  yield 'c';
}

const readable = Readable.from(generate());

readable.on('data', (chunk) => {
  console.log(chunk);
});
```

##### 从异步迭代器管道到可写流[#](http://nodejs.cn/api-v12/stream.html#piping-to-writable-streams-from-async-iterators)

In the scenario of writing to a writable stream from an async iterator, ensure the correct handling of backpressure and errors.

```
const { once } = require('events');
const finished = util.promisify(stream.finished);

const writable = fs.createWriteStream('./file');

function drain(writable) {
  if (writable.destroyed) {
    return Promise.reject(new Error('premature close'));
  }
  return Promise.race([
    once(writable, 'drain'),
    once(writable, 'close')
      .then(() => Promise.reject(new Error('premature close')))
  ]);
}

async function pump(iterable, writable) {
  for await (const chunk of iterable) {
    // Handle backpressure on write().
    if (!writable.write(chunk)) {
      await drain(writable);
    }
  }
  writable.end();
}

(async function() {
  // Ensure completion without errors.
  await Promise.all([
    pump(iterable, writable),
    finished(writable)
  ]);
})();
```

In the above, errors on `write()` would be caught and thrown by the `once()` listener for the `'drain'` event, since `once()` will also handle the `'error'` event. To ensure completion of the write stream without errors, it is safer to use the `finished()` method as above, instead of using the `once()` listener for the `'finish'` event. Under certain cases, an `'error'` event could be emitted by the writable stream after `'finish'` and as `once()` will release the `'error'` handler on handling the `'finish'` event, it could result in an unhandled error.

Alternatively, the readable stream could be wrapped with `Readable.from()` and then piped via `.pipe()`:

```
const finished = util.promisify(stream.finished);

const writable = fs.createWriteStream('./file');

(async function() {
  const readable = Readable.from(iterable);
  readable.pipe(writable);
  // Ensure completion without errors.
  await finished(writable);
})();
```

Or, using `stream.pipeline()` to pipe streams:

```
const pipeline = util.promisify(stream.pipeline);

const writable = fs.createWriteStream('./file');

(async function() {
  const readable = Readable.from(iterable);
  await pipeline(readable, writable);
})();
```

#### 兼容旧版本的 Node.js[#](http://nodejs.cn/api-v12/stream.html#compatibility-with-older-nodejs-versions)

[中英对照](http://nodejs.cn/api-v12/stream/compatibility_with_older_node_js_versions.html)

在 Node.js 0.10 之前，`Readable` 流接口更简单，但功能更弱，实用性也更低。

-   [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件将立即开始触发，而不是等待对 [`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 方法的调用。 需要执行一些工作来决定如何处理数据的应用程序需要将读取数据存储到缓冲区中，这样数据就不会丢失。
-   [`stream.pause()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pause) 方法是建议性的，而不是保证性的。 这意味着即使流处于暂停状态，仍然需要准备接收 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件。

在 Node.js 0.10 中，添加了 [`Readable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable) 类。 为了与旧的 Node.js 程序向后兼容，当添加 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件处理程序或调用 [`stream.resume()`](http://nodejs.cn/api-v12/stream.html#stream_readable_resume) 方法时，`Readable` 流会切换到“流动模式”。 效果是，即使不使用新的 [`stream.read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size) 方法和 [`'readable'`](http://nodejs.cn/api-v12/stream.html#stream_event_readable) 事件，也不再需要担心丢失 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 块。

虽然大多数应用程序将继续正常运行，但这会在以下情况下引入边缘情况：

-   未添加 [`'data'`](http://nodejs.cn/api-v12/stream.html#stream_event_data) 事件监听器。
-   永远不会调用 [`stream.resume()`](http://nodejs.cn/api-v12/stream.html#stream_readable_resume) 方法。
-   流不会通过管道传输到任何可写目的地。

例如，考虑以下代码：

```
// 警告！破碎的！
net.createServer((socket) => {

  // 添加了 'end' 监听器，但从不使用数据。
  socket.on('end', () => {
    // 它永远不会到达这里。
    socket.end('The message was received but was not processed.\n');
  });

}).listen(1337);
```

在 Node.js 0.10 之前，传入的消息数据将被简单地丢弃。 但是，在 Node.js 0.10 及更高版本中，套接字永远处于暂停状态。

这种情况下的解决方法是调用 [`stream.resume()`](http://nodejs.cn/api-v12/stream.html#stream_readable_resume) 方法开始数据流：

```
// 解决方法。
net.createServer((socket) => {
  socket.on('end', () => {
    socket.end('The message was received but was not processed.\n');
  });

  // 启动数据流，丢弃它。
  socket.resume();
}).listen(1337);
```

除了新的 `Readable` 流切换到流动模式之外，0.10 之前的样式流可以使用 [`readable.wrap()`](http://nodejs.cn/api-v12/stream.html#stream_readable_wrap_stream) 方法封装在 `Readable` 类中。

#### `readable.read(0)`[#](http://nodejs.cn/api-v12/stream.html#readableread0)

[中英对照](http://nodejs.cn/api-v12/stream/readable_read_0.html)

在某些情况下，需要触发底层可读流机制的刷新，而不实际消耗任何数据。 在这种情况下，可以调用 `readable.read(0)`，它总是返回 `null`。

如果内部读取缓冲区在 `highWaterMark` 之下，并且当前没有读取流，那么调用 `stream.read(0)` 将触发低级 [`stream._read()`](http://nodejs.cn/api-v12/stream.html#stream_readable_read_size_1) 调用。

虽然大多数应用程序几乎不需要这样做，但在 Node.js 中也有这样做的情况，特别是在 `Readable` 流类内部。

#### `readable.push('')`[#](http://nodejs.cn/api-v12/stream.html#readablepush)

[中英对照](http://nodejs.cn/api-v12/stream/readable_push.html)

不推荐使用 `readable.push('')`。

将零字节字符串 `Buffer` 或 `Uint8Array` 推送到非对象模式的流有一个有趣的副作用。 因为是对 [`readable.push()`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding) 的调用，所以调用会结束读取过程。 然而，因为参数是空字符串，没有数据被添加到可读缓冲区，所以用户没有任何东西可以消费。

#### 调用 \`readable.setEncoding()\` 之后 \`highWaterMark\` 的差异[#](http://nodejs.cn/api-v12/stream.html#highwatermark-discrepancy-after-calling-readablesetencoding)

[中英对照](http://nodejs.cn/api-v12/stream/highwatermark_discrepancy_after_calling_readable_setencoding.html)

`readable.setEncoding()` 的使用将改变 `highWaterMark` 在非对象模式下的操作方式。

通常，当前缓冲区的大小是根据 `highWaterMark` 以字节为单位来衡量的。 但是，在调用 `setEncoding()` 之后，比较函数将开始以字符为单位测量缓冲区的大小。

在 `latin1` 或 `ascii` 的常见情况下，这不是问题。 但建议在处理可能包含多字节字符的字符串时注意这种行为。
