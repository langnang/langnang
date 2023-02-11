---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/zlib.html
author: 
---

# zlib 压缩 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/zlib/zlib.html)

**源代码:** [lib/zlib.js](https://github.com/nodejs/node/blob/v12.22.12/lib/zlib.js)

`zlib` 模块提供了使用 Gzip、Deflate/Inflate、以及 Brotli 实现的压缩功能。

要访问它：

```
const zlib = require('zlib');
```

压缩和解压缩是围绕 Node.js [流 API](http://url.nodejs.cn/ZKnFQT) 构建的。

压缩或解压缩流（例如文件）可以通过将源流通过 `zlib` `Transform` 流管道传输到目标流来完成：

```
const { createGzip } = require('zlib');
const { pipeline } = require('stream');
const {
  createReadStream,
  createWriteStream
} = require('fs');

const gzip = createGzip();
const source = createReadStream('input.txt');
const destination = createWriteStream('input.txt.gz');

pipeline(source, gzip, destination, (err) => {
  if (err) {
    console.error('An error occurred:', err);
    process.exitCode = 1;
  }
});

// 或者，promise 化

const { promisify } = require('util');
const pipe = promisify(pipeline);

async function do_gzip(input, output) {
  const gzip = createGzip();
  const source = createReadStream(input);
  const destination = createWriteStream(output);
  await pipe(source, gzip, destination);
}

do_gzip('input.txt', 'input.txt.gz')
  .catch((err) => {
    console.error('An error occurred:', err);
    process.exitCode = 1;
  });
```

也可以一步压缩或解压缩数据：

```
const { deflate, unzip } = require('zlib');

const input = '.................................';
deflate(input, (err, buffer) => {
  if (err) {
    console.error('An error occurred:', err);
    process.exitCode = 1;
  }
  console.log(buffer.toString('base64'));
});

const buffer = Buffer.from('eJzT0yMAAGTvBe8=', 'base64');
unzip(buffer, (err, buffer) => {
  if (err) {
    console.error('An error occurred:', err);
    process.exitCode = 1;
  }
  console.log(buffer.toString());
});

// 或者，promise 化

const { promisify } = require('util');
const do_unzip = promisify(unzip);

do_unzip(buffer)
  .then((buf) => console.log(buf.toString()))
  .catch((err) => {
    console.error('An error occurred:', err);
    process.exitCode = 1;
  });
```

### 线程池的使用与性能的考虑[#](http://nodejs.cn/api-v12/zlib.html#threadpool-usage-and-performance-considerations)

[中英对照](http://nodejs.cn/api-v12/zlib/threadpool_usage_and_performance_considerations.html)

所有 `zlib` API，除了那些显式同步的 API，都使用 Node.js 内部线程池。 这可能会在某些应用程序中导致令人惊讶的效果和性能限制。

同时创建和使用大量压缩对象会导致显着的内存碎片。

```
const zlib = require('zlib');

const payload = Buffer.from('This is some data');

// 警告：不要这样做！
for (let i = 0; i < 30000; ++i) {
  zlib.deflate(payload, (err, buffer) => {});
}
```

在前面的示例中，同时创建了 30,000 个 deflate 实例。 由于某些操作系统处理内存分配和释放的方式，这可能会导致显着的内存碎片。

强烈建议缓存压缩操作的结果以避免重复工作。

### 压缩 HTTP 的请求和响应[#](http://nodejs.cn/api-v12/zlib.html#compressing-http-requests-and-responses)

[中英对照](http://nodejs.cn/api-v12/zlib/compressing_http_requests_and_responses.html)

`zlib` 模块可用于实现对 [HTTP](http://url.nodejs.cn/V2pkDN) 定义的 `gzip`、`deflate` 和 `br` 内容编码机制的支持。

HTTP [`Accept-Encoding`](http://url.nodejs.cn/5V7Je1) 标头在 http 请求中用于标识客户端接受的压缩编码。 [`Content-Encoding`](http://url.nodejs.cn/znTJvg) 标头用于标识实际应用于消息的压缩编码。

下面给出的示例经过彻底简化以显示基本概念。 使用 `zlib` 编码可能很昂贵，结果应该被缓存。 有关 `zlib` 使用中涉及的速度/内存/压缩权衡的更多信息，请参阅[内存使用调整](http://nodejs.cn/api-v12/zlib.html#zlib_memory_usage_tuning)。

```
// 客户端请求示例
const zlib = require('zlib');
const http = require('http');
const fs = require('fs');
const { pipeline } = require('stream');

const request = http.get({ host: 'example.com',
                           path: '/',
                           port: 80,
                           headers: { 'Accept-Encoding': 'br,gzip,deflate' } });
request.on('response', (response) => {
  const output = fs.createWriteStream('example.com_index.html');

  const onError = (err) => {
    if (err) {
      console.error('An error occurred:', err);
      process.exitCode = 1;
    }
  };

  switch (response.headers['content-encoding']) {
    case 'br':
      pipeline(response, zlib.createBrotliDecompress(), output, onError);
      break;
    // 或者，只需使用 zlib.createUnzip() 来处理以下两种情况：
    case 'gzip':
      pipeline(response, zlib.createGunzip(), output, onError);
      break;
    case 'deflate':
      pipeline(response, zlib.createInflate(), output, onError);
      break;
    default:
      pipeline(response, output, onError);
      break;
  }
});
```

```
// 服务器示例
// 对每个请求运行 gzip 操作是非常昂贵的。
// 缓存压缩的缓冲区会更有效率。
const zlib = require('zlib');
const http = require('http');
const fs = require('fs');
const { pipeline } = require('stream');

http.createServer((request, response) => {
  const raw = fs.createReadStream('index.html');
  // 存储资源的压缩版本和未压缩版本。
  response.setHeader('Vary', 'Accept-Encoding');
  let acceptEncoding = request.headers['accept-encoding'];
  if (!acceptEncoding) {
    acceptEncoding = '';
  }

  const onError = (err) => {
    if (err) {
      // 如果发生错误，则无能为力，
      // 因为服务器已经发送了 200 响应代码，
      // 并且已经向客户端发送了一些数据。
      // 能做的最好的事情
      // 就是立即终止响应并记录错误。
      response.end();
      console.error('An error occurred:', err);
    }
  };

  // 注意：这不是一个符合标准的接受编码解析器。
  // 参见 https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.3
  if (/\bdeflate\b/.test(acceptEncoding)) {
    response.writeHead(200, { 'Content-Encoding': 'deflate' });
    pipeline(raw, zlib.createDeflate(), response, onError);
  } else if (/\bgzip\b/.test(acceptEncoding)) {
    response.writeHead(200, { 'Content-Encoding': 'gzip' });
    pipeline(raw, zlib.createGzip(), response, onError);
  } else if (/\bbr\b/.test(acceptEncoding)) {
    response.writeHead(200, { 'Content-Encoding': 'br' });
    pipeline(raw, zlib.createBrotliCompress(), response, onError);
  } else {
    response.writeHead(200, {});
    pipeline(raw, response, onError);
  }
}).listen(1337);
```

默认情况下，`zlib` 方法在解压缩截断数据时会抛出错误。 但是，如果已知数据不完整，或者希望仅检查压缩文件的开头，则可以通过更改用于解压缩输入的最后一个块的刷新方法来抑制默认错误处理数据：

```
// 这是上述示例中缓冲区的截断版本
const buffer = Buffer.from('eJzT0yMA', 'base64');

zlib.unzip(
  buffer,
  // 对于 Brotli，相当于 zlib.constants.BROTLI_OPERATION_FLUSH
  { finishFlush: zlib.constants.Z_SYNC_FLUSH },
  (err, buffer) => {
    if (err) {
      console.error('An error occurred:', err);
      process.exitCode = 1;
    }
    console.log(buffer.toString());
  });
```

这不会改变其他错误抛出情况下的行为，例如当输入数据的格式无效时。 使用此方法，将无法确定输入是否提前结束或缺少完整性检查，因此需要手动检查解压结果是否有效。

### 内存使用的调整[#](http://nodejs.cn/api-v12/zlib.html#memory-usage-tuning)

#### 对于基于 zlib 的流[#](http://nodejs.cn/api-v12/zlib.html#for-zlib-based-streams)

[中英对照](http://nodejs.cn/api-v12/zlib/for_zlib_based_streams.html)

从 `zlib/zconf.h` 开始，针对 Node.js 使用进行了修改：

deflate 的内存要求是（以字节为单位）：

```
(1 << (windowBits + 2)) + (1 << (memLevel + 9))
```

即：`windowBits` 的 128K = 15 + `memLevel` 的 128K = 8（默认值）加上小对象的几千字节。

例如，要将默认内存要求从 256K 减少到 128K，应将选项设置为：

```
const options = { windowBits: 14, memLevel: 7 };
```

然而，这通常会降低压缩性能。

inflate 的内存要求是（以字节为单位）`1 << windowBits`。 也就是说，`windowBits` 的 32K = 15（默认值）加上小对象的几千字节。

这是对大小为 `chunkSize` 的单个内部输出平板缓冲区的补充，默认为 16K。

`zlib` 压缩的速度受 `level` 设置的影响最大。 更高的级别将导致更好的压缩，但需要更长的时间才能完成。 较低的级别将导致较少的压缩，但会更快。

一般来说，更大的内存使用选项意味着 Node.js 必须对 `zlib` 进行更少的调用，因为它能够在每个 `write` 操作上处理更多的数据。 所以，这是影响速度的另一个因素，以内存使用为代价。

#### 对于基于 Brotli 的流[#](http://nodejs.cn/api-v12/zlib.html#for-brotli-based-streams)

[中英对照](http://nodejs.cn/api-v12/zlib/for_brotli_based_streams.html)

有与基于 Brotli 的流的 zlib 选项等效的选项，尽管这些选项的范围与 zlib 的范围不同：

-   zlib 的 `level` 选项匹配 Brotli 的 `BROTLI_PARAM_QUALITY` 选项。
-   zlib 的 `windowBits` 选项匹配 Brotli 的 `BROTLI_PARAM_LGWIN` 选项。

有关 Brotli 特定选项的更多详细信息，请参见[下文](http://nodejs.cn/api-v12/zlib.html#zlib_brotli_constants)。

### 刷新[#](http://nodejs.cn/api-v12/zlib.html#flushing)

[中英对照](http://nodejs.cn/api-v12/zlib/flushing.html)

在压缩流上调用 [`.flush()`](http://nodejs.cn/api-v12/zlib.html#zlib_zlib_flush_kind_callback) 将使 `zlib` 返回尽可能多的当前输出。 这可能以降低压缩质量为代价，但在需要尽快提供数据时非常有用。

在以下示例中，`flush()` 用于将压缩的部分 HTTP 响应写入客户端：

```
const zlib = require('zlib');
const http = require('http');
const { pipeline } = require('stream');

http.createServer((request, response) => {
  // 为了简单起见，省略了接受编码检查。
  response.writeHead(200, { 'content-encoding': 'gzip' });
  const output = zlib.createGzip();
  let i;

  pipeline(output, response, (err) => {
    if (err) {
      // 如果发生错误，则无能为力，
      // 因为服务器已经发送了 200 响应代码，
      // 并且已经向客户端发送了一些数据。
      // 能做的最好的事情
      // 就是立即终止响应并记录错误。
      clearInterval(i);
      response.end();
      console.error('An error occurred:', err);
    }
  });

  i = setInterval(() => {
    output.write(`The current time is ${Date()}\n`, () => {
      // 数据已传给 zlib，
      // 但压缩算法可能已决定缓冲数据以进行更有效的压缩。
      // 一旦客户端准备好接收数据，
      // 调用 .flush() 将使数据可用。
      output.flush();
    });
  }, 1000);
}).listen(1337);
```

### 常量[#](http://nodejs.cn/api-v12/zlib.html#constants)

新增于: v0.5.8

#### zlib 常量[#](http://nodejs.cn/api-v12/zlib.html#zlib-constants)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_constants.html)

`zlib.h` 中定义的所有常量也在 `require('zlib').constants` 上定义。 在正常的操作过程中，没有必要使用这些常量。 它们被记录在案，因此它们的存在不足为奇。 本章节几乎直接取自 [zlib 文档](http://url.nodejs.cn/P77W2D)。

以前，常量可直接从 `require('zlib')` 获得，例如 `zlib.Z_NO_FLUSH`。 目前仍然可以直接从模块访问常量，但已弃用。

允许的刷新值。

-   `zlib.constants.Z_NO_FLUSH`
-   `zlib.constants.Z_PARTIAL_FLUSH`
-   `zlib.constants.Z_SYNC_FLUSH`
-   `zlib.constants.Z_FULL_FLUSH`
-   `zlib.constants.Z_FINISH`
-   `zlib.constants.Z_BLOCK`
-   `zlib.constants.Z_TREES`

压缩/解压缩函数的返回代码。 负值是错误，正值用于特殊但正常的事件。

-   `zlib.constants.Z_OK`
-   `zlib.constants.Z_STREAM_END`
-   `zlib.constants.Z_NEED_DICT`
-   `zlib.constants.Z_ERRNO`
-   `zlib.constants.Z_STREAM_ERROR`
-   `zlib.constants.Z_DATA_ERROR`
-   `zlib.constants.Z_MEM_ERROR`
-   `zlib.constants.Z_BUF_ERROR`
-   `zlib.constants.Z_VERSION_ERROR`

压缩级别。

-   `zlib.constants.Z_NO_COMPRESSION`
-   `zlib.constants.Z_BEST_SPEED`
-   `zlib.constants.Z_BEST_COMPRESSION`
-   `zlib.constants.Z_DEFAULT_COMPRESSION`

压缩策略。

-   `zlib.constants.Z_FILTERED`
-   `zlib.constants.Z_HUFFMAN_ONLY`
-   `zlib.constants.Z_RLE`
-   `zlib.constants.Z_FIXED`
-   `zlib.constants.Z_DEFAULT_STRATEGY`

#### Brotli 常量[#](http://nodejs.cn/api-v12/zlib.html#brotli-constants)

[中英对照](http://nodejs.cn/api-v12/zlib/brotli_constants.html)

新增于: v11.7.0

有几个选项和其他常量可用于基于 Brotli 的流：

##### 刷新操作[#](http://nodejs.cn/api-v12/zlib.html#flush-operations)

[中英对照](http://nodejs.cn/api-v12/zlib/flush_operations.html)

以下值是基于 Brotli 的流的有效刷新操作：

-   `zlib.constants.BROTLI_OPERATION_PROCESS`（所有操作的默认值）
-   `zlib.constants.BROTLI_OPERATION_FLUSH`（调用 `.flush()` 时的默认值）
-   `zlib.constants.BROTLI_OPERATION_FINISH`（最后一个块的默认值）
-   `zlib.constants.BROTLI_OPERATION_EMIT_METADATA`
    -   这个特定的操作可能很难在 Node.js 上下文中使用，因为流层很难知道哪些数据会在这个帧中结束。 此外，目前无法通过 Node.js API 使用这些数据。

##### 压缩器选项[#](http://nodejs.cn/api-v12/zlib.html#compressor-options)

[中英对照](http://nodejs.cn/api-v12/zlib/compressor_options.html)

可以在 Brotli 编码器上设置几个选项，影响压缩效率和速度。 键和值都可以作为 `zlib.constants` 对象的属性访问。

最重要的选项是：

-   `BROTLI_PARAM_MODE`
    -   `BROTLI_MODE_GENERIC`（默认）
    -   `BROTLI_MODE_TEXT`，针对 UTF-8 文本进行了调整
    -   `BROTLI_MODE_FONT`，针对 WOFF 2.0 字体进行了调整
-   `BROTLI_PARAM_QUALITY`
    -   范围从 `BROTLI_MIN_QUALITY` 到 `BROTLI_MAX_QUALITY`，默认为 `BROTLI_DEFAULT_QUALITY`。
-   `BROTLI_PARAM_SIZE_HINT`
    -   表示预期输入大小的整数值；对于未知的输入大小，默认为 `0`。

可以设置以下标志以对压缩算法和内存使用调整进行高级控制：

-   `BROTLI_PARAM_LGWIN`
    -   范围从 `BROTLI_MIN_WINDOW_BITS` 到 `BROTLI_MAX_WINDOW_BITS`，默认为 `BROTLI_DEFAULT_WINDOW`，如果设置了 `BROTLI_PARAM_LARGE_WINDOW` 标志，则最高可达 `BROTLI_LARGE_MAX_WINDOW_BITS`。
-   `BROTLI_PARAM_LGBLOCK`
    -   范围从 `BROTLI_MIN_INPUT_BLOCK_BITS` 到 `BROTLI_MAX_INPUT_BLOCK_BITS`。
-   `BROTLI_PARAM_DISABLE_LITERAL_CONTEXT_MODELING`
    -   降低压缩率以提高解压速度的布尔标志。
-   `BROTLI_PARAM_LARGE_WINDOW`
    -   启用“大窗口 Brotli”模式的布尔标志（与 [RFC 7932](http://url.nodejs.cn/PWCvBQ) 中标准化的 Brotli 格式不兼容）。
-   `BROTLI_PARAM_NPOSTFIX`
    -   范围从 `0` 到 `BROTLI_MAX_NPOSTFIX`。
-   `BROTLI_PARAM_NDIRECT`
    -   范围从 `0` 到 `15 << NPOSTFIX`，步长为 `1 << NPOSTFIX`。

##### 解压器选项[#](http://nodejs.cn/api-v12/zlib.html#decompressor-options)

[中英对照](http://nodejs.cn/api-v12/zlib/decompressor_options.html)

这些高级选项可用于控制减压：

-   `BROTLI_DECODER_PARAM_DISABLE_RING_BUFFER_REALLOCATION`
    -   影响内部内存分配模式的布尔标志。
-   `BROTLI_DECODER_PARAM_LARGE_WINDOW`
    -   启用“大窗口 Brotli”模式的布尔标志（与 [RFC 7932](http://url.nodejs.cn/PWCvBQ) 中标准化的 Brotli 格式不兼容）。

### `Options` 类[#](http://nodejs.cn/api-v12/zlib.html#class-options)

[中英对照](http://nodejs.cn/api-v12/zlib/class_options.html)

每个基于 zlib 的类都有一个 `options` 对象。 不需要任何选项。

某些选项仅在压缩时相关，而被解压缩类忽略。

-   `flush` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `zlib.constants.Z_NO_FLUSH`
-   `finishFlush` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `zlib.constants.Z_FINISH`
-   `chunkSize` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `16 * 1024`
-   `windowBits` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `level` [<integer>](http://url.nodejs.cn/SXbo1v) （仅压缩）
-   `memLevel` [<integer>](http://url.nodejs.cn/SXbo1v) （仅压缩）
-   `strategy` [<integer>](http://url.nodejs.cn/SXbo1v) （仅压缩）
-   `dictionary` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) （仅 deflate/inflate，默认情况下为空字典）
-   `info` [<boolean>](http://url.nodejs.cn/jFbvuT) （如果是 `true`，则返回具有 `buffer` 和 `engine` 的对象。）
-   `maxOutputLength` [<integer>](http://url.nodejs.cn/SXbo1v) 使用[便捷方法](http://nodejs.cn/api-v12/zlib.html#zlib_convenience_methods)时限制输出大小。 **默认值:** [`buffer.kMaxLength`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_kmaxlength)

有关更多信息，请参阅 [`deflateInit2` 和 `inflateInit2`](http://url.nodejs.cn/6nXpkH) 文档。

### `BrotliOptions` 类[#](http://nodejs.cn/api-v12/zlib.html#class-brotlioptions)

[中英对照](http://nodejs.cn/api-v12/zlib/class_brotlioptions.html)

每个基于 Brotli 的类都有一个 `options` 对象。 所有选项都是可选的。

-   `flush` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `zlib.constants.BROTLI_OPERATION_PROCESS`
-   `finishFlush` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `zlib.constants.BROTLI_OPERATION_FINISH`
-   `chunkSize` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `16 * 1024`
-   `params` [<Object>](http://url.nodejs.cn/jzn6Ao) 包含索引 [Brotli 参数](http://nodejs.cn/api-v12/zlib.html#zlib_brotli_constants)的键值对象。
-   `maxOutputLength` [<integer>](http://url.nodejs.cn/SXbo1v) 使用[便捷方法](http://nodejs.cn/api-v12/zlib.html#zlib_convenience_methods)时限制输出大小。 **默认值:** [`buffer.kMaxLength`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_kmaxlength)

例如：

```
const stream = zlib.createBrotliCompress({
  chunkSize: 32 * 1024,
  params: {
    [zlib.constants.BROTLI_PARAM_MODE]: zlib.constants.BROTLI_MODE_TEXT,
    [zlib.constants.BROTLI_PARAM_QUALITY]: 4,
    [zlib.constants.BROTLI_PARAM_SIZE_HINT]: fs.statSync(inputFile).size
  }
});
```

### `zlib.BrotliCompress` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibbrotlicompress)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_brotlicompress.html)

新增于: v11.7.0

使用 Brotli 算法压缩数据。

### `zlib.BrotliDecompress` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibbrotlidecompress)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_brotlidecompress.html)

新增于: v11.7.0

使用 Brotli 算法解压缩数据。

### `zlib.Deflate` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibdeflate)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_deflate.html)

新增于: v0.5.8

使用 deflate 压缩数据。

### `zlib.DeflateRaw` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibdeflateraw)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_deflateraw.html)

新增于: v0.5.8

使用 deflate 压缩数据，并且不附加 `zlib` 标头。

### `zlib.Gunzip` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibgunzip)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_gunzip.html)

解压缩 gzip 流。

### `zlib.Gzip` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibgzip)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_gzip.html)

新增于: v0.5.8

使用 gzip 压缩数据。

### `zlib.Inflate` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibinflate)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_inflate.html)

解压缩 deflate 流。

### `zlib.InflateRaw` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibinflateraw)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_inflateraw.html)

解压缩原始的 deflate 流。

### `zlib.Unzip` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibunzip)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_unzip.html)

新增于: v0.5.8

通过自动检测标头来解压缩 Gzip 或 Deflate 压缩的流。

### `zlib.ZlibBase` 类[#](http://nodejs.cn/api-v12/zlib.html#class-zlibzlibbase)

[中英对照](http://nodejs.cn/api-v12/zlib/class_zlib_zlibbase.html)

不是由 `zlib` 模块导出的。 它记录在此处，因为它是压缩器/解压缩器类的基类。

这个类继承自 [`stream.Transform`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_transform)，允许在管道和类似的流操作中使用 `zlib` 对象。

#### `zlib.bytesRead`[#](http://nodejs.cn/api-v12/zlib.html#zlibbytesread)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_bytesread.html)

新增于: v8.1.0弃用于: v10.0.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

弃用的 [`zlib.bytesWritten`](http://nodejs.cn/api-v12/zlib.html#zlib_zlib_byteswritten) 别名。 选择这个原始名称是因为将值解释为引擎读取的字节数也是有意义的，但与 Node.js 中以这些名称公开值的其他流不一致。

#### `zlib.bytesWritten`[#](http://nodejs.cn/api-v12/zlib.html#zlibbyteswritten)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_byteswritten.html)

新增于: v10.0.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

`zlib.bytesWritten` 属性指定在处理字节（压缩或解压缩，视派生类而定）之前写入引擎的字节数。

#### `zlib.close([callback])`[#](http://nodejs.cn/api-v12/zlib.html#zlibclosecallback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_close_callback.html)

新增于: v0.9.4

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

关闭底层句柄。

#### `zlib.flush([kind, ]callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibflushkind-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_flush_kind_callback.html)

新增于: v0.5.8

-   `kind` **默认值:** `zlib.constants.Z_FULL_FLUSH` 用于基于 zlib 的流，`zlib.constants.BROTLI_OPERATION_FLUSH` 用于基于 Brotli 的流。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

刷新挂起的数据。 不要轻率地称之为，过早刷新会对压缩算法的有效性产生负面影响。

调用它只会从内部 `zlib` 状态刷新数据，并且不会在流级别执行任何类型的刷新。 相反，它的行为类似于对 `.write()` 的正常调用，即它将排队等待其他未决写入，并且仅在从流中读取数据时才产生输出。

#### `zlib.params(level, strategy, callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibparamslevel-strategy-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_params_level_strategy_callback.html)

新增于: v0.11.4

-   `level` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `strategy` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

此函数仅适用于基于 zlib 的流，即不适用于 Brotli。

动态更新压缩级别和压缩策略。 仅适用于 deflate 算法。

#### `zlib.reset()`[#](http://nodejs.cn/api-v12/zlib.html#zlibreset)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_reset.html)

新增于: v0.7.0

将压缩器/解压缩器重置为出厂默认设置。 仅适用于 inflate 和 deflate 算法。

### `zlib.constants`[#](http://nodejs.cn/api-v12/zlib.html#zlibconstants)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_constants_1.html)

新增于: v7.0.0

提供枚举 Zlib 相关常量的对象。

### `zlib.createBrotliCompress([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreatebrotlicompressoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_createbrotlicompress_options.html)

新增于: v11.7.0

-   `options` [<brotli options>](http://nodejs.cn/api/zlib.html#class-brotlioptions)

创建并返回新的 [`BrotliCompress`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_brotlicompress) 对象。

### `zlib.createBrotliDecompress([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreatebrotlidecompressoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_createbrotlidecompress_options.html)

新增于: v11.7.0

-   `options` [<brotli options>](http://nodejs.cn/api/zlib.html#class-brotlioptions)

创建并返回新的 [`BrotliDecompress`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_brotlidecompress) 对象。

### `zlib.createDeflate([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreatedeflateoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_createdeflate_options.html)

新增于: v0.5.8

-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

创建并返回新的 [`Deflate`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_deflate) 对象。

### `zlib.createDeflateRaw([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreatedeflaterawoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_createdeflateraw_options.html)

新增于: v0.5.8

-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

创建并返回新的 [`DeflateRaw`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_deflateraw) 对象。

当原始 deflate 流的 `windowBits` 设置为 8 时，zlib 从 1.2.8 到 1.2.11 的升级改变了行为。 如果最初设置为 8，则 zlib 会自动将 `windowBits` 设置为 9。 较新版本的 zlib 会抛出异常，因此 Node.js 恢复了将值从 8 升级到 9 的原始行为，因为将 `windowBits = 9` 传给 zlib 实际上会产生一个仅有效使用 8 位窗口的压缩流。

### `zlib.createGunzip([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreategunzipoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_creategunzip_options.html)

新增于: v0.5.8

-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

创建并返回新的 [`Gunzip`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_gunzip) 对象。

### `zlib.createGzip([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreategzipoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_creategzip_options.html)

新增于: v0.5.8

-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

创建并返回新的 [`Gzip`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_gzip) 对象。 查看[示例](http://nodejs.cn/api-v12/zlib.html#zlib_zlib)。

### `zlib.createInflate([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreateinflateoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_createinflate_options.html)

新增于: v0.5.8

-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

创建并返回新的 [`Inflate`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_inflate) 对象。

### `zlib.createInflateRaw([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreateinflaterawoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_createinflateraw_options.html)

新增于: v0.5.8

-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

创建并返回新的 [`InflateRaw`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_inflateraw) 对象。

### `zlib.createUnzip([options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibcreateunzipoptions)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_createunzip_options.html)

新增于: v0.5.8

-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

创建并返回新的 [`Unzip`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_unzip) 对象。

### 便捷方法[#](http://nodejs.cn/api-v12/zlib.html#convenience-methods)

[中英对照](http://nodejs.cn/api-v12/zlib/convenience_methods.html)

所有这些都将 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_class_buffer)、[`TypedArray`](http://url.nodejs.cn/oh3CkV)、[`DataView`](http://url.nodejs.cn/yCdVkD)、[`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 或字符串作为第一个参数，可选的第二个参数为 `zlib` 类提供选项，并将使用 `callback(error, result)` 调用提供的回调。

每个方法都有一个对应的 `*Sync` 方法，它们接受相同的参数，但没有回调。

#### `zlib.brotliCompress(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibbrotlicompressbuffer-options-callback)

新增于: v11.7.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<brotli options>](http://nodejs.cn/api/zlib.html#class-brotlioptions)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.brotliCompressSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibbrotlicompresssyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_brotlicompresssync_buffer_options.html)

新增于: v11.7.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<brotli options>](http://nodejs.cn/api/zlib.html#class-brotlioptions)

使用 [`BrotliCompress`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_brotlicompress) 压缩数据块。

#### `zlib.brotliDecompress(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibbrotlidecompressbuffer-options-callback)

新增于: v11.7.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<brotli options>](http://nodejs.cn/api/zlib.html#class-brotlioptions)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.brotliDecompressSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibbrotlidecompresssyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_brotlidecompresssync_buffer_options.html)

新增于: v11.7.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<brotli options>](http://nodejs.cn/api/zlib.html#class-brotlioptions)

使用 [`BrotliDecompress`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_brotlidecompress) 解压缩数据块。

#### `zlib.deflate(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibdeflatebuffer-options-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_deflate_buffer_options_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.deflateSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibdeflatesyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_deflatesync_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

使用 [`Deflate`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_deflate) 压缩数据块。

#### `zlib.deflateRaw(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibdeflaterawbuffer-options-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_deflateraw_buffer_options_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.deflateRawSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibdeflaterawsyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_deflaterawsync_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

使用 [`DeflateRaw`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_deflateraw) 压缩数据块。

#### `zlib.gunzip(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibgunzipbuffer-options-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_gunzip_buffer_options_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.gunzipSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibgunzipsyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_gunzipsync_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

使用 [`Gunzip`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_gunzip) 解压缩数据块。

#### `zlib.gzip(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibgzipbuffer-options-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_gzip_buffer_options_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.gzipSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibgzipsyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_gzipsync_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

使用 [`Gzip`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_gzip) 压缩数据块。

#### `zlib.inflate(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibinflatebuffer-options-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_inflate_buffer_options_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.inflateSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibinflatesyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_inflatesync_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

使用 [`Inflate`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_inflate) 解压缩数据块。

#### `zlib.inflateRaw(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibinflaterawbuffer-options-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_inflateraw_buffer_options_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.inflateRawSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibinflaterawsyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_inflaterawsync_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

使用 [`InflateRaw`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_inflateraw) 解压缩数据块。

#### `zlib.unzip(buffer[, options], callback)`[#](http://nodejs.cn/api-v12/zlib.html#zlibunzipbuffer-options-callback)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_unzip_buffer_options_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

#### `zlib.unzipSync(buffer[, options])`[#](http://nodejs.cn/api-v12/zlib.html#zlibunzipsyncbuffer-options)

[中英对照](http://nodejs.cn/api-v12/zlib/zlib_unzipsync_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<zlib options>](http://nodejs.cn/api/zlib.html#class-options)

使用 [`Unzip`](http://nodejs.cn/api-v12/zlib.html#zlib_class_zlib_unzip) 解压缩数据块。
