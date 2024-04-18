---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/buffer.html
author: 
---

# buffer 缓冲区 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/buffer/buffer.html)

**源代码:** [lib/buffer.js](https://github.com/nodejs/node/blob/v12.22.12/lib/buffer.js)

`Buffer` 对象用于表示固定长度的字节序列。 许多 Node.js API 都支持 `Buffer`。

`Buffer` 类是 JavaScript [`Uint8Array`](http://url.nodejs.cn/ZbDkpm) 类的子类，并使用涵盖额外用例的方法对其进行扩展。 Node.js API 在支持 `Buffer` 的地方也接受普通的 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。

`Buffer` 类在全局作用域内，因此不需要使用 `require('buffer').Buffer`。

```
// 创建长度为 10 的以零填充的缓冲区。
const buf1 = Buffer.alloc(10);

// 创建长度为 10 的缓冲区，
// 使用值为 `1` 的字节填充。
const buf2 = Buffer.alloc(10, 1);

// 创建长度为 10 的未初始化的缓冲区。
// 这比调用 Buffer.alloc() 快，
// 但返回的缓冲区实例可能包含旧数据，
// 需要使用 fill()、write() 、
// 或其他填充缓冲区内容的函数重写。
const buf3 = Buffer.allocUnsafe(10);

// 创建包含字节 [1, 2, 3] 的缓冲区。
const buf4 = Buffer.from([1, 2, 3]);

// 创建包含字节 [1, 1, 1, 1] 的缓冲区，
// 所有条目都使用 `(value & 255)` 截断以符合范围 0–255。
const buf5 = Buffer.from([257, 257.5, -255, '1']);

// 创建包含字符串 'tést' 的 UTF-8 编码字节的缓冲区：
// [0x74, 0xc3, 0xa9, 0x73, 0x74]（十六进制）
// [116, 195, 169, 115, 116]（十进制）
const buf6 = Buffer.from('tést');

// 创建包含 Latin-1 字节 [0x74, 0xe9, 0x73, 0x74] 的缓冲区。
const buf7 = Buffer.from('tést', 'latin1');
```

### 缓冲区与字符编码[#](http://nodejs.cn/api-v12/buffer.html#buffers-and-character-encodings)

[中英对照](http://nodejs.cn/api-v12/buffer/buffers_and_character_encodings.html)

当在 `Buffer` 和字符串之间进行转换时，可以指定字符编码。 如果未指定字符编码，则默认使用 UTF-8。

```
const buf = Buffer.from('hello world', 'utf8');

console.log(buf.toString('hex'));
// 打印: 68656c6c6f20776f726c64
console.log(buf.toString('base64'));
// 打印: aGVsbG8gd29ybGQ=

console.log(Buffer.from('fhqwhgads', 'utf8'));
// 打印: <Buffer 66 68 71 77 68 67 61 64 73>
console.log(Buffer.from('fhqwhgads', 'utf16le'));
// 打印: <Buffer 66 00 68 00 71 00 77 00 68 00 67 00 61 00 64 00 73 00>
```

Node.js 目前支持的字符编码如下：

-   `'utf8'`: 多字节编码的 Unicode 字符。 许多网页和其他文档格式使用 [UTF-8](http://url.nodejs.cn/mzW5jo)。 这是默认的字符编码。 当将 `Buffer` 解码为不完全包含有效 UTF-8 数据的字符串时，则 Unicode 替换字符 `U+FFFD` � 将用于表示这些错误。
    
-   `'utf16le'`: 多字节编码的 Unicode 字符。 与 `'utf8'` 不同，字符串中的每个字符都将使用 2 或 4 个字节进行编码。 Node.js 仅支持 [UTF-16](http://url.nodejs.cn/CJHzJq) 的[小端序](http://url.nodejs.cn/HY3tVp)变体。
    
-   `'latin1'`: Latin-1 代表 [ISO-8859-1](http://url.nodejs.cn/z8AaDs)。 此字符编码仅支持 `U+0000` 至 `U+00FF` 的 Unicode 字符。 每个字符都使用单个字节进行编码。 不符合该范围的字符将被截断并映射到该范围内的字符。
    

使用以上编码之一将 `Buffer` 转换为字符串称为解码，将字符串转换为 `Buffer` 称为编码。

对于二进制转文本的编码，命名约定是相反的：将 `Buffer` 转换为字符串通常称为编码，将字符串转换为 `Buffer` 通常称为解码。

-   `'base64'`: [Base64](http://url.nodejs.cn/fum2xU) 编码。 当从字符串创建 `Buffer` 时，此编码还将正确接受 [RFC 4648，第 5 节](http://url.nodejs.cn/j8aS4R)中指定的 "URL 和文件名安全字母表"。 base64 编码的字符串中包含的空白字符（例如空格、制表符和换行符）会被忽略。
    
-   `'hex'`: 将每个字节编码为两个十六进制字符。 当解码仅包含有效十六进制字符的字符串时，可能会发生数据截断。 请参阅下面的示例。
    

还支持以下旧版字符编码：

-   `'ascii'`: 仅适用于 7 位 [ASCII](http://url.nodejs.cn/pLT1D9) 数据。 当将字符串编码为 `Buffer` 时，这等效于使用 `'latin1'`。 当将 `Buffer` 解码为字符串时，使用此编码将在解码为 `'latin1'` 之前额外取消设置每个字节的最高位。 通常，没有理由使用此编码，因为在编码或解码纯 ASCII 文本时，`'utf8'`（或者，如果已知数据始终是纯 ASCII，则为 `'latin1'`）将是更好的选择。 它仅用于旧版兼容性。
    
-   `'binary'`: `'latin1'` 的别名。 有关此主题的更多背景信息，请参阅[二进制字符串](http://url.nodejs.cn/x5E3Yh)。 此编码的名称很容易让人误解，因为这里列出的所有编码都在字符串和二进制数据之间进行转换。 对于字符串和 `Buffer` 之间的转换，通常 `'utf-8'` 是正确的选择。
    
-   `'ucs2'`: `'utf16le'` 的别名。 UCS-2 过去指的是 UTF-16 的一种变体，它不支持代码点大于 U+FFFF 的字符。 在 Node.js 中，始终支持这些代码点。
    

```
Buffer.from('1ag', 'hex');
// 打印 <Buffer 1a>，当遇到第一个非十六进制值 ('g') 时，则截断数据。

Buffer.from('1a7g', 'hex');
// 打印 <Buffer 1a>，当数据以一位数 ('7') 结尾时，则截断数据。

Buffer.from('1634', 'hex');
// 打印 <Buffer 16 34>，表现所有数据。
```

现代 Web 浏览器遵循 [WHATWG 编码标准](http://url.nodejs.cn/sasgQF)，其将 `'latin1'` 和 `'ISO-8859-1'` 别名为 `'win-1252'`。 这意味着在执行 `http.get()` 之类的操作时，如果返回的字符集是 WHATWG 规范中列出的字符集之一，则服务器实际上可能返回 `'win-1252'` 编码的数据，使用 `'latin1'` 编码可能会错误地解码字符。

### 缓冲区与 TypedArray[#](http://nodejs.cn/api-v12/buffer.html#buffers-and-typedarrays)

[中英对照](http://nodejs.cn/api-v12/buffer/buffers_and_typedarrays.html)

`Buffer` 实例也是 JavaScript [`Uint8Array`](http://url.nodejs.cn/ZbDkpm) 和 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 实例。 所有 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 方法都可在 `Buffer` 上使用。 但是，`Buffer` API 和 [`TypedArray`](http://url.nodejs.cn/oh3CkV) API 之间存在细微的不兼容。

特别是：

-   [`TypedArray#slice()`](http://url.nodejs.cn/22j33F) 创建 `TypedArray` 部分的副本，而 [`Buffer#slice()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_slice_start_end) 在现有 `Buffer` 上创建视图而不进行复制。 这种行为可能会有意外，并且仅存在于旧版兼容性中。 [`TypedArray#subarray()`](http://url.nodejs.cn/tNCCFf) 可用于在 `Buffer` 和其他 `TypedArray` 上实现 [`Buffer#slice()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_slice_start_end) 的行为。
-   [`buf.toString()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_tostring_encoding_start_end) 与其对应的 `TypedArray` 不兼容。
-   多种方法，例如 [`buf.indexOf()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_indexof_value_byteoffset_encoding)，支持额外的参数。

有两种方式可以从 `Buffer` 创建新的 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 实例：

-   将 `Buffer` 传给 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 构造函数将复制 `Buffer` 的内容，解释为整数数组，而不是目标类型的字节序列。

```
const buf = Buffer.from([1, 2, 3, 4]);
const uint32array = new Uint32Array(buf);

console.log(uint32array);

// 打印: Uint32Array(4) [ 1, 2, 3, 4 ]
```

-   传入 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 底层的 `Buffer` 将创建与 `Buffer` 共享其内存的 [`TypedArray`](http://url.nodejs.cn/oh3CkV)。

```
const buf = Buffer.from('hello', 'utf16le');
const uint16arr = new Uint16Array(
  buf.buffer,
  buf.byteOffset,
  buf.length / Uint16Array.BYTES_PER_ELEMENT);

console.log(uint16array);

// 打印: Uint16Array(5) [ 104, 101, 108, 108, 111 ]
```

通过以相同的方式使用 `TypedArray` 对象的 `.buffer` 属性，可以创建新的 `Buffer`，它与 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 实例共享相同的分配内存。 [`Buffer.from()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_arraybuffer_byteoffset_length) 在这种情况下表现得像 `new Uint8Array()`。

```
const arr = new Uint16Array(2);

arr[0] = 5000;
arr[1] = 4000;

// 复制 `arr` 的内容。
const buf1 = Buffer.from(arr);

// 与 `arr` 共享内存。
const buf2 = Buffer.from(arr.buffer);

console.log(buf1);
// 打印: <Buffer 88 a0>
console.log(buf2);
// 打印: <Buffer 88 13 a0 0f>

arr[1] = 6000;

console.log(buf1);
// 打印: <Buffer 88 a0>
console.log(buf2);
// 打印: <Buffer 88 13 70 17>
```

使用 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 的 `.buffer` 创建 `Buffer` 时，可以通过传入 `byteOffset` 和 `length` 参数仅使用底层 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 的一部分。

```
const arr = new Uint16Array(20);
const buf = Buffer.from(arr.buffer, 0, 16);

console.log(buf.length);
// 打印: 16
```

`Buffer.from()` 和 [`TypedArray.from()`](http://url.nodejs.cn/jLHsN8) 具有不同的签名和实现。 具体来说，[`TypedArray`](http://url.nodejs.cn/oh3CkV) 变体接受第二个参数，该参数是在类型化数组的每个元素上调用的映射函数：

-   `TypedArray.from(source[, mapFn[, thisArg]])`

但是，`Buffer.from()` 方法不支持使用映射函数：

-   [`Buffer.from(array)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_array)
-   [`Buffer.from(buffer)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_buffer)
-   [`Buffer.from(arrayBuffer[, byteOffset[, length]])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_arraybuffer_byteoffset_length)
-   [`Buffer.from(string[, encoding])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_string_encoding)

### 缓冲区与迭代器[#](http://nodejs.cn/api-v12/buffer.html#buffers-and-iteration)

[中英对照](http://nodejs.cn/api-v12/buffer/buffers_and_iteration.html)

可以使用 `for..of` 语法迭代 `Buffer` 实例：

```
const buf = Buffer.from([1, 2, 3]);

for (const b of buf) {
  console.log(b);
}
// 打印:
//   1
//   2
//   3
```

此外，[`buf.values()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_values)、[`buf.keys()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_keys) 和 [`buf.entries()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_entries) 方法可用于创建迭代器。

### `Buffer` 类[#](http://nodejs.cn/api-v12/buffer.html#class-buffer)

[中英对照](http://nodejs.cn/api-v12/buffer/class_buffer.html)

`Buffer` 类是直接处理二进制数据的全局类型。 它可以使用多种方式构建。

#### `Buffer.alloc(size[, fill[, encoding]])`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferallocsize-fill-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_alloc_size_fill_encoding.html)

-   `size` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 所需的长度。
-   `fill` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<integer>](http://url.nodejs.cn/SXbo1v) 用于预填充新 `Buffer` 的值。 **默认值:** `0`。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果 `fill` 是字符串，则这就是它的编码。 **默认值:** `'utf8'`。

分配 `size` 个字节的新 `Buffer`。 如果 `fill` 为 `undefined`，则 `Buffer` 将以零填充。

```
const buf = Buffer.alloc(5);

console.log(buf);
// 打印: <Buffer 00 00 00 00 00>
```

如果 `size` 大于 [`buffer.constants.MAX_LENGTH`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_constants_max_length) 或小于 0，则抛出 [`ERR_INVALID_OPT_VALUE`](http://nodejs.cn/api-v12/errors.html#ERR_INVALID_OPT_VALUE)。

如果指定了 `fill`，则分配的 `Buffer` 将通过调用 [`buf.fill(fill)`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_fill_value_offset_end_encoding) 进行初始化。

```
const buf = Buffer.alloc(5, 'a');

console.log(buf);
// 打印: <Buffer 61 61 61 61 61>
```

如果同时指定了 `fill` 和 `encoding`，则分配的 `Buffer` 将通过调用 [`buf.fill(fill, encoding)`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_fill_value_offset_end_encoding) 进行初始化。

```
const buf = Buffer.alloc(11, 'aGVsbG8gd29ybGQ=', 'base64');

console.log(buf);
// 打印: <Buffer 68 65 6c 6c 6f 20 77 6f 72 6c 64>
```

调用 [`Buffer.alloc()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_alloc_size_fill_encoding) 可能比替代的 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 慢得多，但可确保新创建的 `Buffer` 实例的内容永远不会包含来自先前分配的敏感数据，包括可能尚未分配给 `Buffer` 的数据。

如果 `size` 不是数值，则会抛出 `TypeError`。

#### `Buffer.allocUnsafe(size)`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferallocunsafesize)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_allocunsafe_size.html)

-   `size` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 所需的长度。

分配 `size` 个字节的新 `Buffer`。 如果 `size` 大于 [`buffer.constants.MAX_LENGTH`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_constants_max_length) 或小于 0，则抛出 [`ERR_INVALID_OPT_VALUE`](http://nodejs.cn/api-v12/errors.html#ERR_INVALID_OPT_VALUE)。

以这种方式创建的 `Buffer` 实例的底层内存不会被初始化。 新创建的 `Buffer` 的内容是未知的，可能包含敏感的数据。 使用 [`Buffer.alloc()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_alloc_size_fill_encoding) 来用零初始化 `Buffer` 实例。

```
const buf = Buffer.allocUnsafe(10);

console.log(buf);
// 打印（内容可能会有所不同）: <Buffer a0 8b 28 3f 01 00 00 00 50 32>

buf.fill(0);

console.log(buf);
// 打印: <Buffer 00 00 00 00 00 00 00 00 00 00>
```

如果 `size` 不是数值，则会抛出 `TypeError`。

`Buffer` 模块预先分配了大小为 [`Buffer.poolSize`](http://nodejs.cn/api-v12/buffer.html#buffer_class_property_buffer_poolsize) 的内部 `Buffer` 实例作为池，用于快速分配使用 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size)、[`Buffer.from(array)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_array)、[`Buffer.concat()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_concat_list_totallength) 创建的新 `Buffer` 实例，仅当 `size` 小于或等于 `Buffer.poolSize >> 1`（[`Buffer.poolSize`](http://nodejs.cn/api-v12/buffer.html#buffer_class_property_buffer_poolsize) 除以二再向下取整）时才使用弃用的 `new Buffer(size)` 构造函数。

使用此预先分配的内部内存池是调用 `Buffer.alloc(size, fill)` 与调用 `Buffer.alloc(size, fill)` 之间的关键区别。 具体来说，`Buffer.alloc(size, fill)` 永远不会使用内部 `Buffer` 池，而 `Buffer.allocUnsafe(size).fill(fill)` 会在 `size` 小于或等于 [`Buffer.poolSize`](http://nodejs.cn/api-v12/buffer.html#buffer_class_property_buffer_poolsize) 的一半时使用内部 `Buffer` 池。 当应用程序需要 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 提供的额外性能时，差异很细微，但可能很重要。

#### `Buffer.allocUnsafeSlow(size)`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferallocunsafeslowsize)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_allocunsafeslow_size.html)

新增于: v5.12.0

-   `size` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 所需的长度。

分配 `size` 个字节的新 `Buffer`。 如果 `size` 大于 [`buffer.constants.MAX_LENGTH`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_constants_max_length) 或小于 0，则抛出 [`ERR_INVALID_OPT_VALUE`](http://nodejs.cn/api-v12/errors.html#ERR_INVALID_OPT_VALUE)。 如果 `size` 为 0，则创建零长度 `Buffer`。

以这种方式创建的 `Buffer` 实例的底层内存不会被初始化。 新创建的 `Buffer` 的内容是未知的，可能包含敏感的数据。 使用 [`buf.fill(0)`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_fill_value_offset_end_encoding) 用零初始化此类 `Buffer` 实例。

当使用 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 分配新的 `Buffer` 实例时，4KB 以下的分配将从单个预先分配的 `Buffer` 中切分。 这允许应用程序避免创建许多单独分配的 `Buffer` 实例的垃圾收集开销。 这种方法无需跟踪和清理尽可能多的单个 `ArrayBuffer` 对象，从而提高了性能和内存使用率。

但是，在开发人员可能需要在不确定的时间内从池中保留一小块内存的情况下，使用 `Buffer.allocUnsafeSlow()` 创建未池化的 `Buffer` 实例然后复制出相关位可能是合适的。

```
// 需要保留一些小块内存。
const store = [];

socket.on('readable', () => {
  let data;
  while (null !== (data = readable.read())) {
    // 为保留的数据分配。
    const sb = Buffer.allocUnsafeSlow(10);

    // 将数据复制到新分配中。
    data.copy(sb, 0, 0, 10);

    store.push(sb);
  }
});
```

如果 `size` 不是数值，则会抛出 `TypeError`。

#### `Buffer.byteLength(string[, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferbytelengthstring-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_bytelength_string_encoding.html)

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<SharedArrayBuffer>](http://url.nodejs.cn/6J6LBy) 用于计算长度的值。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果 `string` 是字符串，则这就是它的编码。 **默认值:** `'utf8'`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `string` 中包含的字节数。

使用 `encoding` 编码时返回字符串的字节长度。 这与 [`String.prototype.length`](http://url.nodejs.cn/TmnY1C) 不同，[`String.prototype.length`](http://url.nodejs.cn/TmnY1C) 不考虑用于将字符串转换为字节的编码。

对于包含非 base64/hex 编码数据（例如空格）的字符串，返回值可能大于从字符串创建的 `Buffer` 的长度。

```
const str = '\u00bd + \u00bc = \u00be';

console.log(`${str}: ${str.length} characters, ` +
            `${Buffer.byteLength(str, 'utf8')} bytes`);
// 打印: ½ + ¼ = ¾: 9 characters, 12 bytes
```

当 `string` 为 `Buffer`/[`DataView`](http://url.nodejs.cn/yCdVkD)/[`TypedArray`](http://url.nodejs.cn/oh3CkV)/[`ArrayBuffer`](http://url.nodejs.cn/mUbfvF)/[`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy) 时，返回 `.byteLength` 报告的字节长度。

#### `Buffer.compare(buf1, buf2)`[#](http://nodejs.cn/api-v12/buffer.html#static-method-buffercomparebuf1-buf2)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_compare_buf1_buf2.html)

-   `buf1` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `buf2` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `-1`、`0` 或 `1`，取决于比较的结果。 详见 [`buf.compare()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_compare_target_targetstart_targetend_sourcestart_sourceend)。

比较 `buf1` 和 `buf2`，通常用于对 `Buffer` 实例的数组进行排序。 这相当于调用 [`buf1.compare(buf2)`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_compare_target_targetstart_targetend_sourcestart_sourceend)。

```
const buf1 = Buffer.from('1234');
const buf2 = Buffer.from('0123');
const arr = [buf1, buf2];

console.log(arr.sort(Buffer.compare));
// 打印: [ <Buffer 30 31 32 33>, <Buffer 31 32 33 34> ]
// （此结果相当于：[buf2, buf1]。）
```

#### `Buffer.concat(list[, totalLength])`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferconcatlist-totallength)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_concat_list_totallength.html)

-   `list` [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array\[\]>](http://url.nodejs.cn/ZbDkpm) 要连接的 `Buffer` 或 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm) 实例的列表。
-   `totalLength` [<integer>](http://url.nodejs.cn/SXbo1v) 连接时 `list` 中 `Buffer` 实例的总长度。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

返回新的 `Buffer`，它是将 `list` 中的所有 `Buffer` 实例连接在一起的结果。

如果列表没有条目，或者 `totalLength` 为 0，则返回新的零长度 `Buffer`。

如果未提供 `totalLength`，则从 `list` 中的 `Buffer` 实例通过相加其长度来计算。

如果提供了 `totalLength`，则将其强制为无符号整数。 如果 `list` 中 `Buffer` 的组合长度超过 `totalLength`，则结果截断为 `totalLength`。

```
// 从三个 `Buffer` 实例的列表创建单个 `Buffer`。

const buf1 = Buffer.alloc(10);
const buf2 = Buffer.alloc(14);
const buf3 = Buffer.alloc(18);
const totalLength = buf1.length + buf2.length + buf3.length;

console.log(totalLength);
// 打印: 42

const bufA = Buffer.concat([buf1, buf2, buf3], totalLength);

console.log(bufA);
// 打印: <Buffer 00 00 00 00 ...>
console.log(bufA.length);
// 打印: 42
```

`Buffer.concat()` 也像 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 一样使用内部 `Buffer` 池。

#### `Buffer.from(array)`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferfromarray)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_from_array.html)

新增于: v5.10.0

-   `array` [<integer\[\]>](http://url.nodejs.cn/SXbo1v)

使用 `0` – `255` 范围内的字节 `array` 分配新的 `Buffer`。 该范围之外的数组条目将被截断以符合它。

```
// 创建包含字符串 'buffer' 的 UTF-8 字节的新缓冲区。
const buf = Buffer.from([0x62, 0x75, 0x66, 0x66, 0x65, 0x72]);
```

如果 `array` 不是 `Array` 或其他适用于 `Buffer.from()` 变体的类型，则将抛出 `TypeError`。

`Buffer.from(array)` 和 [`Buffer.from(string)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_string_encoding) 也像 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 一样使用内部 `Buffer` 池。

#### `Buffer.from(arrayBuffer[, byteOffset[, length]])`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferfromarraybuffer-byteoffset-length)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_from_arraybuffer_byteoffset_length.html)

新增于: v5.10.0

-   `arrayBuffer` [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<SharedArrayBuffer>](http://url.nodejs.cn/6J6LBy) [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF)、[`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy)，例如 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 的 `.buffer` 属性。
-   `byteOffset` [<integer>](http://url.nodejs.cn/SXbo1v) 要暴露的第一个字节的索引。 **默认值:** `0`。
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v) 要暴露的字节数。 **默认值:** `arrayBuffer.byteLength - byteOffset`。

这将创建 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 的视图，而无需复制底层内存。

```
const arr = new Uint16Array(2);

arr[0] = 5000;
arr[1] = 4000;

// 与 `arr` 共享内存。
const buf = Buffer.from(arr.buffer);

console.log(buf);
// 打印: <Buffer 88 13 a0 0f>

// 更改原始的 Uint16Array 也会更改缓冲区。
arr[1] = 6000;

console.log(buf);
// 打印: <Buffer 88 13 70 17>
```

可选的 `byteOffset` 和 `length` 参数指定了 `arrayBuffer` 中将由 `Buffer` 共享的内存范围。

```
const ab = new ArrayBuffer(10);
const buf = Buffer.from(ab, 0, 2);

console.log(buf.length);
// 打印: 2
```

如果 `arrayBuffer` 不是 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 或 [`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy) 或其他适用于 `Buffer.from()` 变体的类型，则将抛出 `TypeError`。

#### `Buffer.from(buffer)`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferfrombuffer)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_from_buffer.html)

新增于: v5.10.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) 要从中复制数据的现有 `Buffer` 或 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。

将传入的 `buffer` 数据复制到新的 `Buffer` 实例上。

```
const buf1 = Buffer.from('buffer');
const buf2 = Buffer.from(buf1);

buf1[0] = 0x61;

console.log(buf1.toString());
// 打印: auffer
console.log(buf2.toString());
// 打印: buffer
```

如果 `buffer` 不是 `Buffer` 或其他适用于 `Buffer.from()` 变体的类型，则将抛出 `TypeError`。

#### `Buffer.from(object[, offsetOrEncoding[, length]])`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferfromobject-offsetorencoding-length)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_from_object_offsetorencoding_length.html)

新增于: v8.2.0

-   `object` [<Object>](http://url.nodejs.cn/jzn6Ao) 支持 `Symbol.toPrimitive` 或 `valueOf()` 的对象。
-   `offsetOrEncoding` [<integer>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) 字节偏移量或编码。
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v) 长度。

对于 `valueOf()` 函数返回的值不严格等于 `object` 的对象，则返回 `Buffer.from(object.valueOf(), offsetOrEncoding, length)`。

```
const buf = Buffer.from(new String('this is a test'));
// 打印: <Buffer 74 68 69 73 20 69 73 20 61 20 74 65 73 74>
```

对于支持 `Symbol.toPrimitive` 的对象，则返回 `Buffer.from(object[Symbol.toPrimitive]('string'), offsetOrEncoding)`。

```
class Foo {
  [Symbol.toPrimitive]() {
    return 'this is a test';
  }
}

const buf = Buffer.from(new Foo(), 'utf8');
// 打印: <Buffer 74 68 69 73 20 69 73 20 61 20 74 65 73 74>
```

如果 `object` 没有提到的方法或不是适合 `Buffer.from()` 变体的另一种类型，则将抛出 `TypeError`。

#### `Buffer.from(string[, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferfromstring-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_from_string_encoding.html)

新增于: v5.10.0

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK) 要编码的字符串。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `string` 的编码。 **默认值:** `'utf8'`。

创建包含 `string` 的新 `Buffer`。 `encoding` 参数标识将 `string` 转换为字节时要使用的字符编码。

```
const buf1 = Buffer.from('this is a tést');
const buf2 = Buffer.from('7468697320697320612074c3a97374', 'hex');

console.log(buf1.toString());
// 打印: this is a tést
console.log(buf2.toString());
// 打印: this is a tést
console.log(buf1.toString('latin1'));
// 打印: this is a tÃ©st
```

如果 `string` 不是字符串或其他适用于 `Buffer.from()` 变体的类型，则将抛出 `TypeError`。

#### `Buffer.isBuffer(obj)`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferisbufferobj)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_isbuffer_obj.html)

新增于: v0.1.101

-   `obj` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `obj` 是 `Buffer`，则返回 `true`，否则返回 `false`。

#### `Buffer.isEncoding(encoding)`[#](http://nodejs.cn/api-v12/buffer.html#static-method-bufferisencodingencoding)

[中英对照](http://nodejs.cn/api-v12/buffer/static_method_buffer_isencoding_encoding.html)

新增于: v0.9.1

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 要检查的字符编码名称。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `encoding` 是支持的字符编码的名称，则返回 `true`，否则返回 `false`。

```
console.log(Buffer.isEncoding('utf-8'));
// 打印: true

console.log(Buffer.isEncoding('hex'));
// 打印: true

console.log(Buffer.isEncoding('utf/8'));
// 打印: false

console.log(Buffer.isEncoding(''));
// 打印: false
```

#### `Buffer.poolSize`[#](http://nodejs.cn/api-v12/buffer.html#class-property-bufferpoolsize)

[中英对照](http://nodejs.cn/api-v12/buffer/class_property_buffer_poolsize.html)

新增于: v0.11.3

-   [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `8192`

这是用于池的预分配内部 `Buffer` 实例的大小（以字节为单位）。 该值可以修改。

#### `buf[index]`[#](http://nodejs.cn/api-v12/buffer.html#bufindex)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_index.html)

-   `index` [<integer>](http://url.nodejs.cn/SXbo1v)

索引运算符 `[index]` 可用于获取和设置 `buf` 中位置 `index` 处的八位字节。 这些值是指单个字节，因此合法值范围介于 `0x00` 和 `0xFF`（十六进制）或 `0` 和 `255`（十进制）之间。

该运算符继承自 `Uint8Array`，因此其越界访问行为与 `Uint8Array` 相同。 换句话说，当 `index` 为负或大于等于 `buf.length` 时，`buf[index]` 返回 `undefined`，如果 `index` 为负或 `>= buf.length`，`buf[index] = value` 不修改缓冲区。

```
// 每次一个字节地将 ASCII 字符串复制到 `Buffer` 中。
// （这仅适用于 ASCII-only 字符串。通常，应该使用 `Buffer.from()` 来执行此转换。）

const str = 'Node.js';
const buf = Buffer.allocUnsafe(str.length);

for (let i = 0; i < str.length; i++) {
  buf[i] = str.charCodeAt(i);
}

console.log(buf.toString('utf8'));
// 打印: Node.js
```

#### `buf.buffer`[#](http://nodejs.cn/api-v12/buffer.html#bufbuffer)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_buffer.html)

-   [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) 创建此 `Buffer` 对象所基于的底层 `ArrayBuffer` 对象。

不保证此 `ArrayBuffer` 与原始 `Buffer` 完全对应。 有关详细信息，请参阅 `buf.byteOffset` 上的说明。

```
const arrayBuffer = new ArrayBuffer(16);
const buffer = Buffer.from(arrayBuffer);

console.log(buffer.buffer === arrayBuffer);
// 打印: true
```

#### `buf.byteOffset`[#](http://nodejs.cn/api-v12/buffer.html#bufbyteoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_byteoffset.html)

-   [<integer>](http://url.nodejs.cn/SXbo1v) `Buffer` 底层 `ArrayBuffer` 对象的 `byteOffset`。

当在 `Buffer.from(ArrayBuffer, byteOffset, length)` 中设置 `byteOffset` 时，或者有时在分配小于 `Buffer.poolSize` 的 `Buffer` 时，缓冲区不会从底层 `ArrayBuffer` 上的零偏移量开始。

这在使用 `buf.buffer` 直接访问底层 `ArrayBuffer` 时可能会导致问题，因为 `ArrayBuffer` 的其他部分可能与 `Buffer` 对象本身无关。

创建与 `Buffer` 共享内存的 `TypedArray` 对象时的常见问题是，在这种情况下，需要正确指定 `byteOffset`：

```
// 创建小于 `Buffer.poolSize` 的缓冲区。
const nodeBuffer = new Buffer.from([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

// 当将 Node.js 缓冲区转换为 Int8Array 时，
// 使用 byteOffset 仅引用包含 `nodeBuffer` 内存的 `nodeBuffer.buffer` 部分。
new Int8Array(nodeBuffer.buffer, nodeBuffer.byteOffset, nodeBuffer.length);
```

#### `buf.compare(target[, targetStart[, targetEnd[, sourceStart[, sourceEnd]]]])`[#](http://nodejs.cn/api-v12/buffer.html#bufcomparetarget-targetstart-targetend-sourcestart-sourceend)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_compare_target_targetstart_targetend_sourcestart_sourceend.html)

-   `target` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) 用于比较 `buf` 的 `Buffer` 或 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。
-   `targetStart` [<integer>](http://url.nodejs.cn/SXbo1v) `target` 内开始比较的偏移量。 **默认值:** `0`。
-   `targetEnd` [<integer>](http://url.nodejs.cn/SXbo1v) `target` 中结束比较（不包括）的偏移量。 **默认值:** `target.length`。
-   `sourceStart` [<integer>](http://url.nodejs.cn/SXbo1v) `buf` 内开始比较的偏移量。 **默认值:** `0`。
-   `sourceEnd` [<integer>](http://url.nodejs.cn/SXbo1v) `buf` 中结束比较（不包括）的偏移量。 **默认值:** [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length).
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

将 `buf` 与 `target` 进行比较并返回数字，该数字指示 `buf` 在排序顺序中是在 `target` 之前、之后还是与 `target` 相同。 比较基于每个 `Buffer` 中的实际字节序列。

-   如果 `target` 与 `buf` 相同，则返回 `0`
-   如果排序时 `target` 应该在 `buf` 之前，则返回 `1`。
-   如果排序时 `target` 应该在 `buf` 之后，则返回 `-1`。

```
const buf1 = Buffer.from('ABC');
const buf2 = Buffer.from('BCD');
const buf3 = Buffer.from('ABCD');

console.log(buf1.compare(buf1));
// 打印: 0
console.log(buf1.compare(buf2));
// 打印: -1
console.log(buf1.compare(buf3));
// 打印: -1
console.log(buf2.compare(buf1));
// 打印: 1
console.log(buf2.compare(buf3));
// 打印: 1
console.log([buf1, buf2, buf3].sort(Buffer.compare));
// 打印: [ <Buffer 41 42 43>, <Buffer 41 42 43 44>, <Buffer 42 43 44> ]
// （此结果相当于：[buf1, buf3, buf2]。）
```

可选的 `targetStart`、`targetEnd`、`sourceStart` 和 `sourceEnd` 参数可用于分别将比较限制在 `target` 和 `buf` 内的特定范围内。

```
const buf1 = Buffer.from([1, 2, 3, 4, 5, 6, 7, 8, 9]);
const buf2 = Buffer.from([5, 6, 7, 8, 9, 1, 2, 3, 4]);

console.log(buf1.compare(buf2, 5, 9, 0, 4));
// 打印: 0
console.log(buf1.compare(buf2, 0, 6, 4));
// 打印: -1
console.log(buf1.compare(buf2, 5, 6, 5));
// 打印: 1
```

如果 `targetStart < 0`、`sourceStart < 0`、`targetEnd > target.byteLength` 或 `sourceEnd > source.byteLength`，则抛出 [`ERR_OUT_OF_RANGE`](http://nodejs.cn/api-v12/errors.html#ERR_OUT_OF_RANGE)。

#### `buf.copy(target[, targetStart[, sourceStart[, sourceEnd]]])`[#](http://nodejs.cn/api-v12/buffer.html#bufcopytarget-targetstart-sourcestart-sourceend)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_copy_target_targetstart_sourcestart_sourceend.html)

新增于: v0.1.90

-   `target` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) 要复制到的 `Buffer` 或 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。
-   `targetStart` [<integer>](http://url.nodejs.cn/SXbo1v) `target` 内开始写入的偏移量。 **默认值:** `0`。
-   `sourceStart` [<integer>](http://url.nodejs.cn/SXbo1v) `buf` 内开始复制的偏移量。 **默认值:** `0`。
-   `sourceEnd` [<integer>](http://url.nodejs.cn/SXbo1v) `buf` 内停止复制的偏移量（不包括）。 **默认值:** [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length).
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) 复制的字节数。

将数据从 `buf` 的区域复制到 `target` 的区域，即使 `target` 内存区域与 `buf` 重叠。

[`TypedArray#set()`](http://url.nodejs.cn/yiGcc3) 执行相同的操作，可用于所有 TypedArray，包括 Node.js `Buffer`，尽管它采用不同的函数参数。

```
// 创建两个 `Buffer` 实例。
const buf1 = Buffer.allocUnsafe(26);
const buf2 = Buffer.allocUnsafe(26).fill('!');

for (let i = 0; i < 26; i++) {
  // 97 是 'a' 的十进制 ASCII 值。
  buf1[i] = i + 97;
}

// 将 `buf1` 字节 16 到 19 复制到 `buf2` 中，从 `buf2` 的字节 8 开始。
buf1.copy(buf2, 8, 16, 20);
// 这相当于：
// buf2.set(buf1.subarray(16, 20), 8);

console.log(buf2.toString('ascii', 0, 25));
// 打印: !!!!!!!!qrst!!!!!!!!!!!!!
```

```
// 创建 `Buffer` 并将数据从一个区域复制到同一 `Buffer` 内的重叠区域。

const buf = Buffer.allocUnsafe(26);

for (let i = 0; i < 26; i++) {
  // 97 是 'a' 的十进制 ASCII 值。
  buf[i] = i + 97;
}

buf.copy(buf, 0, 4, 10);

console.log(buf.toString());
// 打印: efghijghijklmnopqrstuvwxyz
```

#### `buf.entries()`[#](http://nodejs.cn/api-v12/buffer.html#bufentries)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_entries.html)

新增于: v1.1.0

-   返回: [<Iterator>](http://url.nodejs.cn/Y2SE1q)

从 `buf` 的内容创建并返回 `[index, byte]` 对的[迭代器](http://url.nodejs.cn/KK7Xfc)。

```
// 记录 `Buffer` 的全部内容。

const buf = Buffer.from('buffer');

for (const pair of buf.entries()) {
  console.log(pair);
}
// 打印:
//   [0, 98]
//   [1, 117]
//   [2, 102]
//   [3, 102]
//   [4, 101]
//   [5, 114]
```

#### `buf.equals(otherBuffer)`[#](http://nodejs.cn/api-v12/buffer.html#bufequalsotherbuffer)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_equals_otherbuffer.html)

-   `otherBuffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) 用于比较 `buf` 的 `Buffer` 或 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `buf` 和 `otherBuffer` 具有完全相同的字节，则返回 `true`，否则返回 `false`。 相当于 [`buf.compare(otherBuffer) === 0`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_compare_target_targetstart_targetend_sourcestart_sourceend)。

```
const buf1 = Buffer.from('ABC');
const buf2 = Buffer.from('414243', 'hex');
const buf3 = Buffer.from('ABCD');

console.log(buf1.equals(buf2));
// 打印: true
console.log(buf1.equals(buf3));
// 打印: false
```

#### `buf.fill(value[, offset[, end]][, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#buffillvalue-offset-end-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_fill_value_offset_end_encoding.html)

-   `value` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<integer>](http://url.nodejs.cn/SXbo1v) 用于填充 `buf` 的值。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 在开始填充 `buf` 之前要跳过的字节数。 **默认值:** `0`。
-   `end` [<integer>](http://url.nodejs.cn/SXbo1v) 停止填充 `buf`（不包括在内）的位置。 **默认值:** [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length).
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果 `value` 是字符串，则为 `value` 的编码。 **默认值:** `'utf8'`。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `buf` 的引用。

用指定的 `value` 填充 `buf`。 如果没有给定 `offset` 和 `end`，则整个 `buf` 都会被填满：

```
// 用 ASCII 字符 'h' 填充 `Buffer`。

const b = Buffer.allocUnsafe(50).fill('h');

console.log(b.toString());
// 打印: hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
```

如果 `value` 不是字符串、`Buffer` 或整数，则将其强制为 `uint32` 值。 如果结果整数大于 `255`（十进制），则 `buf` 将填充 `value & 255`。

如果 `fill()` 操作的最终写入落在多字节字符上，则仅写入适合 `buf` 的该字符的字节：

```
// 用在 UTF-8 中占用两个字节的字符填充 `Buffer`。

console.log(Buffer.allocUnsafe(5).fill('\u0222'));
// 打印: <Buffer c8 a2 c8 a2 c8>
```

如果 `value` 包含无效字符，则截断；如果没有有效的填充数据，则抛出异常：

```
const buf = Buffer.allocUnsafe(5);

console.log(buf.fill('a'));
// 打印: <Buffer 61 61 61 61 61>
console.log(buf.fill('aazz', 'hex'));
// 打印: <Buffer aa aa aa aa aa>
console.log(buf.fill('zz', 'hex'));
// 抛出异常。
```

#### `buf.includes(value[, byteOffset][, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#bufincludesvalue-byteoffset-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_includes_value_byteoffset_encoding.html)

新增于: v5.3.0

-   `value` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<integer>](http://url.nodejs.cn/SXbo1v) 要搜索的内容。
-   `byteOffset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始搜索 `buf` 的位置。 如果为负数，则从 `buf` 的末尾开始计算偏移量。 **默认值:** `0`。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果 `value` 是字符串，则这就是它的编码。 **默认值:** `'utf8'`。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果在 `buf` 中找到 `value`，则为 `true`，否则为 `false`。

相当于 [`buf.indexOf() !== -1`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_indexof_value_byteoffset_encoding)。

```
const buf = Buffer.from('this is a buffer');

console.log(buf.includes('this'));
// 打印: true
console.log(buf.includes('is'));
// 打印: true
console.log(buf.includes(Buffer.from('a buffer')));
// 打印: true
console.log(buf.includes(97));
// 打印: true （97 是 'a' 的十进制 ASCII 值）
console.log(buf.includes(Buffer.from('a buffer example')));
// 打印: false
console.log(buf.includes(Buffer.from('a buffer example').slice(0, 8)));
// 打印: true
console.log(buf.includes('this', 4));
// 打印: false
```

#### `buf.indexOf(value[, byteOffset][, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#bufindexofvalue-byteoffset-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_indexof_value_byteoffset_encoding.html)

-   `value` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<integer>](http://url.nodejs.cn/SXbo1v) 要搜索的内容。
-   `byteOffset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始搜索 `buf` 的位置。 如果为负数，则从 `buf` 的末尾开始计算偏移量。 **默认值:** `0`。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果 `value` 是字符串，则这是用于确定将在 `buf` 中搜索的字符串的二进制表示的编码。 **默认值:** `'utf8'`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `buf` 中第一次出现 `value` 的索引，如果 `buf` 不包含 `value`，则为 `-1`。

如果 `value` 是：

-   字符串，`value` 根据 `encoding` 中的字符编码进行解释。
-   `Buffer` 或 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm), `value` 将全部使用。 要比较部分 `Buffer`，则使用 [`buf.slice()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_slice_start_end)。
-   数字，`value` 将被解释为 `0` 和 `255` 之间的无符号 8 位整数值。

```
const buf = Buffer.from('this is a buffer');

console.log(buf.indexOf('this'));
// 打印: 0
console.log(buf.indexOf('is'));
// 打印: 2
console.log(buf.indexOf(Buffer.from('a buffer')));
// 打印: 8
console.log(buf.indexOf(97));
// 打印: 8 （97 是 'a' 的十进制 ASCII 值）
console.log(buf.indexOf(Buffer.from('a buffer example')));
// 打印: -1
console.log(buf.indexOf(Buffer.from('a buffer example').slice(0, 8)));
// 打印: 8

const utf16Buffer = Buffer.from('\u039a\u0391\u03a3\u03a3\u0395', 'utf16le');

console.log(utf16Buffer.indexOf('\u03a3', 0, 'utf16le'));
// 打印: 4
console.log(utf16Buffer.indexOf('\u03a3', -4, 'utf16le'));
// 打印: 6
```

如果 `value` 不是字符串、数字或 `Buffer`，则此方法将抛出 `TypeError`。 如果 `value` 是数字，则它将被强制转换为有效的字节值（0 到 255 之间的整数）。

如果 `byteOffset` 不是数字，则会被强制为数字。 如果强制转换的结果是 `NaN` 或 `0`，则将搜索整个缓冲区。 此行为与 [`String#indexOf()`](http://url.nodejs.cn/Uqm5hr) 匹配。

```
const b = Buffer.from('abcdef');

// 传入数字值，但不是有效字节。
// 打印: 2, 相当于搜索 99 或 'c'。
console.log(b.indexOf(99.9));
console.log(b.indexOf(256 + 99));

// 传入强制为 NaN 或 0 的 byteOffset。
// 打印: 1, 搜索整个缓冲区。
console.log(b.indexOf('b', undefined));
console.log(b.indexOf('b', {}));
console.log(b.indexOf('b', null));
console.log(b.indexOf('b', []));
```

如果 `value` 为空字符串或空 `Buffer` 且 `byteOffset` 小于 `buf.length`，则返回 `byteOffset`。 如果 `value` 为空且 `byteOffset` 至少为 `buf.length`，则返回 `buf.length`。

#### `buf.keys()`[#](http://nodejs.cn/api-v12/buffer.html#bufkeys)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_keys.html)

新增于: v1.1.0

-   返回: [<Iterator>](http://url.nodejs.cn/Y2SE1q)

创建并返回 `buf` 个键（索引）的[迭代器](http://url.nodejs.cn/KK7Xfc)。

```
const buf = Buffer.from('buffer');

for (const key of buf.keys()) {
  console.log(key);
}
// 打印:
//   0
//   1
//   2
//   3
//   4
//   5
```

#### `buf.lastIndexOf(value[, byteOffset][, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#buflastindexofvalue-byteoffset-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_lastindexof_value_byteoffset_encoding.html)

-   `value` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<integer>](http://url.nodejs.cn/SXbo1v) 要搜索的内容。
-   `byteOffset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始搜索 `buf` 的位置。 如果为负数，则从 `buf` 的末尾开始计算偏移量。 **默认值:** `buf.length - 1`。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 如果 `value` 是字符串，则这是用于确定将在 `buf` 中搜索的字符串的二进制表示的编码。 **默认值:** `'utf8'`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `buf` 中最后一次出现 `value` 的索引，如果 `buf` 不包含 `value`，则为 `-1`。

与 [`buf.indexOf()`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_indexof_value_byteoffset_encoding) 相同，除了找到最后一次出现的 `value` 而不是第一次出现。

```
const buf = Buffer.from('this buffer is a buffer');

console.log(buf.lastIndexOf('this'));
// 打印: 0
console.log(buf.lastIndexOf('buffer'));
// 打印: 17
console.log(buf.lastIndexOf(Buffer.from('buffer')));
// 打印: 17
console.log(buf.lastIndexOf(97));
// 打印: 15 （97 是 'a' 的十进制 ASCII 值）
console.log(buf.lastIndexOf(Buffer.from('yolo')));
// 打印: -1
console.log(buf.lastIndexOf('buffer', 5));
// 打印: 5
console.log(buf.lastIndexOf('buffer', 4));
// 打印: -1

const utf16Buffer = Buffer.from('\u039a\u0391\u03a3\u03a3\u0395', 'utf16le');

console.log(utf16Buffer.lastIndexOf('\u03a3', undefined, 'utf16le'));
// 打印: 6
console.log(utf16Buffer.lastIndexOf('\u03a3', -5, 'utf16le'));
// 打印: 4
```

如果 `value` 不是字符串、数字或 `Buffer`，则此方法将抛出 `TypeError`。 如果 `value` 是数字，则它将被强制转换为有效的字节值（0 到 255 之间的整数）。

如果 `byteOffset` 不是数字，则会被强制为数字。 任何强制到 `NaN` 的参数，如 `{}` 或 `undefined`，都将搜索整个缓冲区。 此行为与 [`String#lastIndexOf()`](http://url.nodejs.cn/2oXRjB) 匹配。

```
const b = Buffer.from('abcdef');

// 传入数字值，但不是有效字节。
// 打印: 2, 相当于搜索 99 或 'c'。
console.log(b.lastIndexOf(99.9));
console.log(b.lastIndexOf(256 + 99));

// 传入强制为 NaN 的 byteOffset。
// 打印: 1, 搜索整个缓冲区。
console.log(b.lastIndexOf('b', undefined));
console.log(b.lastIndexOf('b', {}));

// 传递强制为 0 的 byteOffset。
// 打印: -1, 相当于传入 0。
console.log(b.lastIndexOf('b', null));
console.log(b.lastIndexOf('b', []));
```

如果 `value` 为空字符串或空 `Buffer`，则返回 `byteOffset`。

#### `buf.length`[#](http://nodejs.cn/api-v12/buffer.html#buflength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_length.html)

新增于: v0.1.90

-   [<integer>](http://url.nodejs.cn/SXbo1v)

返回 `buf` 中的字节数。

```
// 创建 `Buffer` 并使用 UTF-8 向其写入一个较短的字符串。

const buf = Buffer.alloc(1234);

console.log(buf.length);
// 打印: 1234

buf.write('some string', 0, 'utf8');

console.log(buf.length);
// 打印: 1234
```

#### `buf.parent`[#](http://nodejs.cn/api-v12/buffer.html#bufparent)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_parent.html)

弃用于: v8.0.0

`buf.parent` 属性是 `buf.buffer` 的弃用别名。

#### `buf.readBigInt64BE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadbigint64beoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readbigint64be_offset.html)

新增于: v12.0.0, v10.20.0

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<bigint>](http://url.nodejs.cn/gJMq1y)

从指定的 `offset` 处的 `buf` 读取有符号的大端序 64 位整数。

从 `Buffer` 读取的整数被解释为二进制补码有符号值。

#### `buf.readBigInt64LE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadbigint64leoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readbigint64le_offset.html)

新增于: v12.0.0

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<bigint>](http://url.nodejs.cn/gJMq1y)

从指定的 `offset` 处的 `buf` 读取有符号的小端序 64 位整数。

从 `Buffer` 读取的整数被解释为二进制补码有符号值。

#### `buf.readBigUInt64BE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadbiguint64beoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readbiguint64be_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<bigint>](http://url.nodejs.cn/gJMq1y)

从指定的 `offset` 处的 `buf` 读取无符号的大端序 64 位整数。

```
const buf = Buffer.from([0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 0xff, 0xff]);

console.log(buf.readBigUInt64BE(0));
// 打印: 4294967295n
```

#### `buf.readBigUInt64LE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadbiguint64leoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readbiguint64le_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<bigint>](http://url.nodejs.cn/gJMq1y)

从指定的 `offset` 处的 `buf` 读取无符号的小端序 64 位整数。

```
const buf = Buffer.from([0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 0xff, 0xff]);

console.log(buf.readBigUInt64LE(0));
// 打印: 18446744069414584320n
```

#### `buf.readDoubleBE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreaddoublebeoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readdoublebe_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

从指定 `offset` 处的 `buf` 读取 64 位大端序双精度值。

```
const buf = Buffer.from([1, 2, 3, 4, 5, 6, 7, 8]);

console.log(buf.readDoubleBE(0));
// 打印: 8.20788039913184e-304
```

#### `buf.readDoubleLE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreaddoubleleoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readdoublele_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

从指定 `offset` 处的 `buf` 读取 64 位小端序双精度值。

```
const buf = Buffer.from([1, 2, 3, 4, 5, 6, 7, 8]);

console.log(buf.readDoubleLE(0));
// 打印: 5.447603722011605e-270
console.log(buf.readDoubleLE(1));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readFloatBE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadfloatbeoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readfloatbe_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

从指定 `offset` 处的 `buf` 读取 32 位大端序浮点数。

```
const buf = Buffer.from([1, 2, 3, 4]);

console.log(buf.readFloatBE(0));
// 打印: 2.387939260590663e-38
```

#### `buf.readFloatLE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadfloatleoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readfloatle_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

从指定 `offset` 处的 `buf` 读取 32 位小端序浮点数。

```
const buf = Buffer.from([1, 2, 3, 4]);

console.log(buf.readFloatLE(0));
// 打印: 1.539989614439558e-36
console.log(buf.readFloatLE(1));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readInt8([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadint8offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readint8_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 1`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取有符号的 8 位整数。

从 `Buffer` 读取的整数被解释为二进制补码有符号值。

```
const buf = Buffer.from([-1, 5]);

console.log(buf.readInt8(0));
// 打印: -1
console.log(buf.readInt8(1));
// 打印: 5
console.log(buf.readInt8(2));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readInt16BE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadint16beoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readint16be_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取有符号的大端序 16 位整数。

从 `Buffer` 读取的整数被解释为二进制补码有符号值。

```
const buf = Buffer.from([0, 5]);

console.log(buf.readInt16BE(0));
// 打印: 5
```

#### `buf.readInt16LE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadint16leoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readint16le_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取有符号的小端序 16 位整数。

从 `Buffer` 读取的整数被解释为二进制补码有符号值。

```
const buf = Buffer.from([0, 5]);

console.log(buf.readInt16LE(0));
// 打印: 1280
console.log(buf.readInt16LE(1));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readInt32BE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadint32beoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readint32be_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取有符号的大端序 32 位整数。

从 `Buffer` 读取的整数被解释为二进制补码有符号值。

```
const buf = Buffer.from([0, 0, 0, 5]);

console.log(buf.readInt32BE(0));
// 打印: 5
```

#### `buf.readInt32LE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreadint32leoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readint32le_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取有符号的小端序 32 位整数。

从 `Buffer` 读取的整数被解释为二进制补码有符号值。

```
const buf = Buffer.from([0, 0, 0, 5]);

console.log(buf.readInt32LE(0));
// 打印: 83886080
console.log(buf.readInt32LE(1));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readIntBE(offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufreadintbeoffset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readintbe_offset_bytelength.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要读取的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取 `byteLength` 个字节，并将结果解释为支持最高 48 位精度的大端序、二进制补码有符号值。

```
const buf = Buffer.from([0x12, 0x34, 0x56, 0x78, 0x90, 0xab]);

console.log(buf.readIntBE(0, 6).toString(16));
// 打印: 1234567890ab
console.log(buf.readIntBE(1, 6).toString(16));
// 抛出 ERR_OUT_OF_RANGE。
console.log(buf.readIntBE(1, 0).toString(16));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readIntLE(offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufreadintleoffset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readintle_offset_bytelength.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要读取的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取 `byteLength` 个字节，并将结果解释为支持最高 48 位精度的小端序、二进制补码有符号值。

```
const buf = Buffer.from([0x12, 0x34, 0x56, 0x78, 0x90, 0xab]);

console.log(buf.readIntLE(0, 6).toString(16));
// 打印: -546f87a9cbee
```

#### `buf.readUInt8([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreaduint8offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readuint8_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 1`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定 `offset` 处的 `buf` 读取无符号 8 位整数。

```
const buf = Buffer.from([1, -2]);

console.log(buf.readUInt8(0));
// 打印: 1
console.log(buf.readUInt8(1));
// 打印: 254
console.log(buf.readUInt8(2));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readUInt16BE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreaduint16beoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readuint16be_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取无符号的大端序 16 位整数。

```
const buf = Buffer.from([0x12, 0x34, 0x56]);

console.log(buf.readUInt16BE(0).toString(16));
// 打印: 1234
console.log(buf.readUInt16BE(1).toString(16));
// 打印: 3456
```

#### `buf.readUInt16LE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreaduint16leoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readuint16le_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取无符号的小端序 16 位整数。

```
const buf = Buffer.from([0x12, 0x34, 0x56]);

console.log(buf.readUInt16LE(0).toString(16));
// 打印: 3412
console.log(buf.readUInt16LE(1).toString(16));
// 打印: 5634
console.log(buf.readUInt16LE(2).toString(16));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readUInt32BE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreaduint32beoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readuint32be_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取无符号的大端序 32 位整数。

```
const buf = Buffer.from([0x12, 0x34, 0x56, 0x78]);

console.log(buf.readUInt32BE(0).toString(16));
// 打印: 12345678
```

#### `buf.readUInt32LE([offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufreaduint32leoffset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readuint32le_offset.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取无符号的小端序 32 位整数。

```
const buf = Buffer.from([0x12, 0x34, 0x56, 0x78]);

console.log(buf.readUInt32LE(0).toString(16));
// 打印: 78563412
console.log(buf.readUInt32LE(1).toString(16));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readUIntBE(offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufreaduintbeoffset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readuintbe_offset_bytelength.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要读取的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取 `byteLength` 个字节，并将结果解释为支持最高 48 位精度的无符号大端序整数。

```
const buf = Buffer.from([0x12, 0x34, 0x56, 0x78, 0x90, 0xab]);

console.log(buf.readUIntBE(0, 6).toString(16));
// 打印: 1234567890ab
console.log(buf.readUIntBE(1, 6).toString(16));
// 抛出 ERR_OUT_OF_RANGE。
```

#### `buf.readUIntLE(offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufreaduintleoffset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_readuintle_offset_bytelength.html)

-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始读取之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要读取的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

从指定的 `offset` 处的 `buf` 读取 `byteLength` 个字节，并将结果解释为支持最高 48 位精度的无符号小端序整数。

```
const buf = Buffer.from([0x12, 0x34, 0x56, 0x78, 0x90, 0xab]);

console.log(buf.readUIntLE(0, 6).toString(16));
// 打印: ab9078563412
```

#### `buf.subarray([start[, end]])`[#](http://nodejs.cn/api-v12/buffer.html#bufsubarraystart-end)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_subarray_start_end.html)

新增于: v3.0.0

-   `start` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 将开始的位置。 **默认值:** `0`。
-   `end` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 将结束的位置（不包括在内）。 **默认值:** [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length).
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

返回新的 `Buffer`，其引用与原始缓冲区相同的内存，但由 `start` 和 `end` 索引进行偏移和裁剪。

指定 `end` 大于 [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length) 将返回与 `end` 等于 [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length) 相同的结果。

该方法继承自 [`TypedArray#subarray()`](http://url.nodejs.cn/tNCCFf)。

修改新的 `Buffer` 切片会修改原来 `Buffer` 中的内存，因为两个对象分配的内存是重叠的。

```
// 用 ASCII 字母创建 `Buffer`，取一个切片，并从原来的 `Buffer` 修改一个字节。

const buf1 = Buffer.allocUnsafe(26);

for (let i = 0; i < 26; i++) {
  // 97 是 'a' 的十进制 ASCII 值。
  buf1[i] = i + 97;
}

const buf2 = buf1.subarray(0, 3);

console.log(buf2.toString('ascii', 0, buf2.length));
// 打印: abc

buf1[0] = 33;

console.log(buf2.toString('ascii', 0, buf2.length));
// 打印: !bc
```

指定负索引会导致相对于 `buf` 的末尾而不是开头生成切片。

```
const buf = Buffer.from('buffer');

console.log(buf.subarray(-6, -1).toString());
// 打印: buffe
// (相当于 buf.subarray(0, 5).)

console.log(buf.subarray(-6, -2).toString());
// 打印: buff
// (相当于 buf.subarray(0, 4).)

console.log(buf.subarray(-5, -2).toString());
// 打印: uff
// (相当于 buf.subarray(1, 4).)
```

#### `buf.slice([start[, end]])`[#](http://nodejs.cn/api-v12/buffer.html#bufslicestart-end)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_slice_start_end.html)

-   `start` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 将开始的位置。 **默认值:** `0`。
-   `end` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 将结束的位置（不包括在内）。 **默认值:** [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length).
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

返回新的 `Buffer`，其引用与原始缓冲区相同的内存，但由 `start` 和 `end` 索引进行偏移和裁剪。

这与 `buf.subarray()` 的行为相同。

此方法与 `Uint8Array.prototype.slice()`（`Buffer` 的超类）不兼容。 要复制切片，则使用 `Uint8Array.prototype.slice()`。

```
const buf = Buffer.from('buffer');

const copiedBuf = Uint8Array.prototype.slice.call(buf);
copiedBuf[0]++;
console.log(copiedBuf.toString());
// 打印: cuffer

console.log(buf.toString());
// 打印: buffer
```

#### `buf.swap16()`[#](http://nodejs.cn/api-v12/buffer.html#bufswap16)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_swap16.html)

新增于: v5.10.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `buf` 的引用。

将 `buf` 解释为无符号 16 位整数数组，并就地交换字节顺序。 如果 [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length) 不是 2 的倍数，则抛出 [`ERR_INVALID_BUFFER_SIZE`](http://nodejs.cn/api-v12/errors.html#ERR_INVALID_BUFFER_SIZE)。

```
const buf1 = Buffer.from([0x1, 0x2, 0x3, 0x4, 0x5, 0x6, 0x7, 0x8]);

console.log(buf1);
// 打印: <Buffer 01 02 03 04 05 06 07 08>

buf1.swap16();

console.log(buf1);
// 打印: <Buffer 02 01 04 03 06 05 08 07>

const buf2 = Buffer.from([0x1, 0x2, 0x3]);

buf2.swap16();
// 抛出 ERR_INVALID_BUFFER_SIZE。
```

`buf.swap16()` 的一种方便用法是在 UTF-16 小端序和 UTF-16 大端序之间执行快速就地转换：

```
const buf = Buffer.from('This is little-endian UTF-16', 'utf16le');
buf.swap16(); // 转换为大端序 UTF-16 文本。
```

#### `buf.swap32()`[#](http://nodejs.cn/api-v12/buffer.html#bufswap32)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_swap32.html)

新增于: v5.10.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `buf` 的引用。

将 `buf` 解释为无符号 32 位整数数组，并就地交换字节顺序。 如果 [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length) 不是 4 的倍数，则抛出 [`ERR_INVALID_BUFFER_SIZE`](http://nodejs.cn/api-v12/errors.html#ERR_INVALID_BUFFER_SIZE)。

```
const buf1 = Buffer.from([0x1, 0x2, 0x3, 0x4, 0x5, 0x6, 0x7, 0x8]);

console.log(buf1);
// 打印: <Buffer 01 02 03 04 05 06 07 08>

buf1.swap32();

console.log(buf1);
// 打印: <Buffer 04 03 02 01 08 07 06 05>

const buf2 = Buffer.from([0x1, 0x2, 0x3]);

buf2.swap32();
// 抛出 ERR_INVALID_BUFFER_SIZE。
```

#### `buf.swap64()`[#](http://nodejs.cn/api-v12/buffer.html#bufswap64)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_swap64.html)

新增于: v6.3.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `buf` 的引用。

将 `buf` 解释为 64 位数字数组，并就地交换字节顺序。 如果 [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length) 不是 8 的倍数，则抛出 [`ERR_INVALID_BUFFER_SIZE`](http://nodejs.cn/api-v12/errors.html#ERR_INVALID_BUFFER_SIZE)。

```
const buf1 = Buffer.from([0x1, 0x2, 0x3, 0x4, 0x5, 0x6, 0x7, 0x8]);

console.log(buf1);
// 打印: <Buffer 01 02 03 04 05 06 07 08>

buf1.swap64();

console.log(buf1);
// 打印: <Buffer 08 07 06 05 04 03 02 01>

const buf2 = Buffer.from([0x1, 0x2, 0x3]);

buf2.swap64();
// 抛出 ERR_INVALID_BUFFER_SIZE。
```

#### `buf.toJSON()`[#](http://nodejs.cn/api-v12/buffer.html#buftojson)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_tojson.html)

新增于: v0.9.2

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回 `buf` 的 JSON 表示。 [`JSON.stringify()`](http://url.nodejs.cn/bmLTNS) 在字符串化 `Buffer` 实例时隐式调用此函数。

`Buffer.from()` 接受从此方法返回的格式的对象。 特别是，`Buffer.from(buf.toJSON())` 的工作方式类似于 `Buffer.from(buf)`。

```
const buf = Buffer.from([0x1, 0x2, 0x3, 0x4, 0x5]);
const json = JSON.stringify(buf);

console.log(json);
// 打印: {"type":"Buffer","data":[1,2,3,4,5]}

const copy = JSON.parse(json, (key, value) => {
  return value && value.type === 'Buffer' ?
    Buffer.from(value) :
    value;
});

console.log(copy);
// 打印: <Buffer 01 02 03 04 05>
```

#### `buf.toString([encoding[, start[, end]]])`[#](http://nodejs.cn/api-v12/buffer.html#buftostringencoding-start-end)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_tostring_encoding_start_end.html)

新增于: v0.1.90

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 要使用的字符编码。 **默认值:** `'utf8'`。
-   `start` [<integer>](http://url.nodejs.cn/SXbo1v) 开始解码的字节偏移量。 **默认值:** `0`。
-   `end` [<integer>](http://url.nodejs.cn/SXbo1v) 停止解码的字节偏移量（不包括在内）。 **默认值:** [`buf.length`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_length).
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

根据 `encoding` 中指定的字符编码将 `buf` 解码为字符串。 `start` 和 `end` 可以传入仅解码 `buf` 的子集。

如果 `encoding` 是 `'utf8'` 并且输入中的字节序列不是有效的 UTF-8，则每个无效字节都将替换为替换字符 `U+FFFD`。

字符串实例（以 UTF-16 代码单元表示）的最大长度可用作 [`buffer.constants.MAX_STRING_LENGTH`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_constants_max_string_length)。

```
const buf1 = Buffer.allocUnsafe(26);

for (let i = 0; i < 26; i++) {
  // 97 是 'a' 的十进制 ASCII 值。
  buf1[i] = i + 97;
}

console.log(buf1.toString('utf8'));
// 打印: abcdefghijklmnopqrstuvwxyz
console.log(buf1.toString('utf8', 0, 5));
// 打印: abcde

const buf2 = Buffer.from('tést');

console.log(buf2.toString('hex'));
// 打印: 74c3a97374
console.log(buf2.toString('utf8', 0, 3));
// 打印: té
console.log(buf2.toString(undefined, 0, 3));
// 打印: té
```

#### `buf.values()`[#](http://nodejs.cn/api-v12/buffer.html#bufvalues)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_values.html)

新增于: v1.1.0

-   返回: [<Iterator>](http://url.nodejs.cn/Y2SE1q)

为 `buf` 值（字节）创建并返回[迭代器](http://url.nodejs.cn/KK7Xfc)。 当在 `for..of` 语句中使用 `Buffer` 时，会自动调用此函数。

```
const buf = Buffer.from('buffer');

for (const value of buf.values()) {
  console.log(value);
}
// 打印:
//   98
//   117
//   102
//   102
//   101
//   114

for (const value of buf) {
  console.log(value);
}
// 打印:
//   98
//   117
//   102
//   102
//   101
//   114
```

#### `buf.write(string[, offset[, length]][, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritestring-offset-length-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_write_string_offset_length_encoding.html)

新增于: v0.1.90

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK) 要写入 `buf` 的字符串。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入 `string` 之前要跳过的字节数。 **默认值:** `0`。
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入的最大字节数（写入的字节数不会超过 `buf.length - offset`）。 **默认值:** `buf.length - offset`。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `string` 的字符编码。 **默认值:** `'utf8'`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) 写入的字节数。

根据 `encoding` 中的字符编码将 `string` 写入 `buf` 的 `offset` 处。 `length` 参数是要写入的字节数。 如果 `buf` 没有足够的空间来容纳整个字符串，则只会写入 `string` 的一部分。 但是，不会写入部分编码的字符。

```
const buf = Buffer.alloc(256);

const len = buf.write('\u00bd + \u00bc = \u00be', 0);

console.log(`${len} bytes: ${buf.toString('utf8', 0, len)}`);
// 打印: 12 bytes: ½ + ¼ = ¾

const buffer = Buffer.alloc(10);

const length = buffer.write('abcd', 8);

console.log(`${length} bytes: ${buffer.toString('utf8', 8, 10)}`);
// 打印: 2 bytes : ab
```

#### `buf.writeBigInt64BE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritebigint64bevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writebigint64be_value_offset.html)

新增于: v12.0.0

-   `value` [<bigint>](http://url.nodejs.cn/gJMq1y) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。

`value` 被解释和写入为二进制补码有符号整数。

```
const buf = Buffer.allocUnsafe(8);

buf.writeBigInt64BE(0x0102030405060708n, 0);

console.log(buf);
// 打印: <Buffer 01 02 03 04 05 06 07 08>
```

#### `buf.writeBigInt64LE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritebigint64levalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writebigint64le_value_offset.html)

新增于: v12.0.0, v10.20.0

-   `value` [<bigint>](http://url.nodejs.cn/gJMq1y) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`。

`value` 被解释和写入为二进制补码有符号整数。

```
const buf = Buffer.allocUnsafe(8);

buf.writeBigInt64LE(0x0102030405060708n, 0);

console.log(buf);
// 打印: <Buffer 08 07 06 05 04 03 02 01>
```

#### `buf.writeBigUInt64BE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritebiguint64bevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writebiguint64be_value_offset.html)

-   `value` [<bigint>](http://url.nodejs.cn/gJMq1y) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。

```
const buf = Buffer.allocUnsafe(8);

buf.writeBigUInt64BE(0xdecafafecacefaden, 0);

console.log(buf);
// 打印: <Buffer de ca fa fe ca ce fa de>
```

#### `buf.writeBigUInt64LE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritebiguint64levalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writebiguint64le_value_offset.html)

-   `value` [<bigint>](http://url.nodejs.cn/gJMq1y) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足：`0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`

```
const buf = Buffer.allocUnsafe(8);

buf.writeBigUInt64LE(0xdecafafecacefaden, 0);

console.log(buf);
// 打印: <Buffer de fa ce ca fe fa ca de>
```

#### `buf.writeDoubleBE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritedoublebevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writedoublebe_value_offset.html)

-   `value` [<number>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。 `value` 必须是 JavaScript 数字 当 `value` 不是 JavaScript 数字时，则行为未定义。

```
const buf = Buffer.allocUnsafe(8);

buf.writeDoubleBE(123.456, 0);

console.log(buf);
// 打印: <Buffer 40 5e dd 2f 1a 9f be 77>
```

#### `buf.writeDoubleLE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritedoublelevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writedoublele_value_offset.html)

-   `value` [<number>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 8`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`。 `value` 必须是 JavaScript 数字 当 `value` 不是 JavaScript 数字时，则行为未定义。

```
const buf = Buffer.allocUnsafe(8);

buf.writeDoubleLE(123.456, 0);

console.log(buf);
// 打印: <Buffer 77 be 9f 1a 2f dd 5e 40>
```

#### `buf.writeFloatBE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritefloatbevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writefloatbe_value_offset.html)

-   `value` [<number>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。 当 `value` 不是 JavaScript 数字时，则行为未定义。

```
const buf = Buffer.allocUnsafe(4);

buf.writeFloatBE(0xcafebabe, 0);

console.log(buf);
// 打印: <Buffer 4f 4a fe bb>
```

#### `buf.writeFloatLE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwritefloatlevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writefloatle_value_offset.html)

-   `value` [<number>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`。 当 `value` 不是 JavaScript 数字时，则行为未定义。

```
const buf = Buffer.allocUnsafe(4);

buf.writeFloatLE(0xcafebabe, 0);

console.log(buf);
// 打印: <Buffer bb fe 4a 4f>
```

#### `buf.writeInt8(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteint8value-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeint8_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 1`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 写入 `buf` 中指定的 `offset`。 `value` 必须是有效的有符号 8 位整数。 当 `value` 不是有符号的 8 位整数时，则行为未定义。

`value` 被解释和写入为二进制补码有符号整数。

```
const buf = Buffer.allocUnsafe(2);

buf.writeInt8(2, 0);
buf.writeInt8(-2, 1);

console.log(buf);
// 打印: <Buffer 02 fe>
```

#### `buf.writeInt16BE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteint16bevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeint16be_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的有符号 16 位整数。 当 `value` 不是有符号的 16 位整数时，则行为未定义。

`value` 被解释和写入为二进制补码有符号整数。

```
const buf = Buffer.allocUnsafe(2);

buf.writeInt16BE(0x0102, 0);

console.log(buf);
// 打印: <Buffer 01 02>
```

#### `buf.writeInt16LE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteint16levalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeint16le_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的有符号 16 位整数。 当 `value` 不是有符号的 16 位整数时，则行为未定义。

`value` 被解释和写入为二进制补码有符号整数。

```
const buf = Buffer.allocUnsafe(2);

buf.writeInt16LE(0x0304, 0);

console.log(buf);
// 打印: <Buffer 04 03>
```

#### `buf.writeInt32BE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteint32bevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeint32be_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的有符号 32 位整数。 当 `value` 不是有符号的 32 位整数时，则行为未定义。

`value` 被解释和写入为二进制补码有符号整数。

```
const buf = Buffer.allocUnsafe(4);

buf.writeInt32BE(0x01020304, 0);

console.log(buf);
// 打印: <Buffer 01 02 03 04>
```

#### `buf.writeInt32LE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteint32levalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeint32le_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的有符号 32 位整数。 当 `value` 不是有符号的 32 位整数时，则行为未定义。

`value` 被解释和写入为二进制补码有符号整数。

```
const buf = Buffer.allocUnsafe(4);

buf.writeInt32LE(0x05060708, 0);

console.log(buf);
// 打印: <Buffer 08 07 06 05>
```

#### `buf.writeIntBE(value, offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteintbevalue-offset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeintbe_value_offset_bytelength.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 的 `byteLength` 个字节作为大端序写入 `buf` 中指定的 `offset`。 支持最高 48 位的精度。 当 `value` 不是有符号整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(6);

buf.writeIntBE(0x1234567890ab, 0, 6);

console.log(buf);
// 打印: <Buffer 12 34 56 78 90 ab>
```

#### `buf.writeIntLE(value, offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteintlevalue-offset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeintle_value_offset_bytelength.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 的 `byteLength` 个字节作为小端序写入 `buf` 中指定的 `offset`。 支持最高 48 位的精度。 当 `value` 不是有符号整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(6);

buf.writeIntLE(0x1234567890ab, 0, 6);

console.log(buf);
// 打印: <Buffer ab 90 78 56 34 12>
```

#### `buf.writeUInt8(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteuint8value-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeuint8_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 1`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 写入 `buf` 中指定的 `offset`。 `value` 必须是有效的无符号 8 位整数。 当 `value` 不是无符号 8 位整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(4);

buf.writeUInt8(0x3, 0);
buf.writeUInt8(0x4, 1);
buf.writeUInt8(0x23, 2);
buf.writeUInt8(0x42, 3);

console.log(buf);
// 打印: <Buffer 03 04 23 42>
```

#### `buf.writeUInt16BE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteuint16bevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeuint16be_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的无符号 16 位整数。 当 `value` 不是无符号 16 位整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(4);

buf.writeUInt16BE(0xdead, 0);
buf.writeUInt16BE(0xbeef, 2);

console.log(buf);
// 打印: <Buffer de ad be ef>
```

#### `buf.writeUInt16LE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteuint16levalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeuint16le_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 2`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的无符号 16 位整数。 当 `value` 不是无符号 16 位整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(4);

buf.writeUInt16LE(0xdead, 0);
buf.writeUInt16LE(0xbeef, 2);

console.log(buf);
// 打印: <Buffer ad de ef be>
```

#### `buf.writeUInt32BE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteuint32bevalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeuint32be_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为大端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的无符号 32 位整数。 当 `value` 不是无符号 32 位整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(4);

buf.writeUInt32BE(0xfeedface, 0);

console.log(buf);
// 打印: <Buffer fe ed fa ce>
```

#### `buf.writeUInt32LE(value[, offset])`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteuint32levalue-offset)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeuint32le_value_offset.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - 4`。 **默认值:** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 作为小端序写入 `buf` 中指定的 `offset`。 `value` 必须是有效的无符号 32 位整数。 当 `value` 不是无符号 32 位整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(4);

buf.writeUInt32LE(0xfeedface, 0);

console.log(buf);
// 打印: <Buffer ce fa ed fe>
```

#### `buf.writeUIntBE(value, offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteuintbevalue-offset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeuintbe_value_offset_bytelength.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 的 `byteLength` 个字节作为大端序写入 `buf` 中指定的 `offset`。 支持最高 48 位的精度。 当 `value` 不是无符号整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(6);

buf.writeUIntBE(0x1234567890ab, 0, 6);

console.log(buf);
// 打印: <Buffer 12 34 56 78 90 ab>
```

#### `buf.writeUIntLE(value, offset, byteLength)`[#](http://nodejs.cn/api-v12/buffer.html#bufwriteuintlevalue-offset-bytelength)

[中英对照](http://nodejs.cn/api-v12/buffer/buf_writeuintle_value_offset_bytelength.html)

-   `value` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入 `buf` 的数字。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 开始写入之前要跳过的字节数。 必须满足 `0 <= offset <= buf.length - byteLength`。
-   `byteLength` [<integer>](http://url.nodejs.cn/SXbo1v) 要写入的字节数。 必须满足 `0 < byteLength <= 6`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) `offset` 加上写入的字节数。

将 `value` 的 `byteLength` 个字节作为小端序写入 `buf` 中指定的 `offset`。 支持最高 48 位的精度。 当 `value` 不是无符号整数时，则行为未定义。

```
const buf = Buffer.allocUnsafe(6);

buf.writeUIntLE(0x1234567890ab, 0, 6);

console.log(buf);
// 打印: <Buffer ab 90 78 56 34 12>
```

#### `new Buffer(array)`[#](http://nodejs.cn/api-v12/buffer.html#new-bufferarray)

[中英对照](http://nodejs.cn/api-v12/buffer/new_buffer_array.html)

-   `array` [<integer\[\]>](http://url.nodejs.cn/SXbo1v) 要从中复制的字节数组。

参见 [`Buffer.from(array)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_array)。

#### `new Buffer(arrayBuffer[, byteOffset[, length]])`[#](http://nodejs.cn/api-v12/buffer.html#new-bufferarraybuffer-byteoffset-length)

[中英对照](http://nodejs.cn/api-v12/buffer/new_buffer_arraybuffer_byteoffset_length.html)

-   `arrayBuffer` [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<SharedArrayBuffer>](http://url.nodejs.cn/6J6LBy) [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF)、[`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy)、或 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 的 `.buffer` 属性。
-   `byteOffset` [<integer>](http://url.nodejs.cn/SXbo1v) 要暴露的第一个字节的索引。 **默认值:** `0`。
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v) 要暴露的字节数。 **默认值:** `arrayBuffer.byteLength - byteOffset`。

参见 [`Buffer.from(arrayBuffer[, byteOffset[, length]])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_arraybuffer_byteoffset_length)。

#### `new Buffer(buffer)`[#](http://nodejs.cn/api-v12/buffer.html#new-bufferbuffer)

[中英对照](http://nodejs.cn/api-v12/buffer/new_buffer_buffer.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) 要从中复制数据的现有 `Buffer` 或 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。

参见 [`Buffer.from(buffer)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_buffer)。

#### `new Buffer(size)`[#](http://nodejs.cn/api-v12/buffer.html#new-buffersize)

[中英对照](http://nodejs.cn/api-v12/buffer/new_buffer_size.html)

-   `size` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `Buffer` 所需的长度。

参见 [`Buffer.alloc()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_alloc_size_fill_encoding) 和 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size)。 构造函数的此变体等效于 [`Buffer.alloc()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_alloc_size_fill_encoding)。

#### `new Buffer(string[, encoding])`[#](http://nodejs.cn/api-v12/buffer.html#new-bufferstring-encoding)

[中英对照](http://nodejs.cn/api-v12/buffer/new_buffer_string_encoding.html)

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK) 要编码的字符串。
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `string` 的编码。 **默认值:** `'utf8'`。

参见 [`Buffer.from(string[, encoding])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_string_encoding)。

### 缓冲区模块 API[#](http://nodejs.cn/api-v12/buffer.html#buffer-module-apis)

[中英对照](http://nodejs.cn/api-v12/buffer/buffer_module_apis.html)

虽然 `Buffer` 对象可作为全局对象使用，但还有其他与 `Buffer` 相关的 API 仅可通过使用 `require('buffer')` 访问的 `buffer` 模块使用。

#### `buffer.INSPECT_MAX_BYTES`[#](http://nodejs.cn/api-v12/buffer.html#bufferinspect_max_bytes)

[中英对照](http://nodejs.cn/api-v12/buffer/buffer_inspect_max_bytes.html)

新增于: v0.5.4

-   [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `50`

返回调用 `buf.inspect()` 时将返回的最大字节数。 这可以被用户模块覆盖。 有关 `buf.inspect()` 行为的更多详细信息，请参阅 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options)。

#### `buffer.kMaxLength`[#](http://nodejs.cn/api-v12/buffer.html#bufferkmaxlength)

[中英对照](http://nodejs.cn/api-v12/buffer/buffer_kmaxlength.html)

新增于: v3.0.0

-   [<integer>](http://url.nodejs.cn/SXbo1v) 单个 `Buffer` 实例允许的最大大小。

[`buffer.constants.MAX_LENGTH`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_constants_max_length) 的别名。

#### `buffer.transcode(source, fromEnc, toEnc)`[#](http://nodejs.cn/api-v12/buffer.html#buffertranscodesource-fromenc-toenc)

[中英对照](http://nodejs.cn/api-v12/buffer/buffer_transcode_source_fromenc_toenc.html)

-   `source` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) `Buffer` 或 `Uint8Array` 实例。
-   `fromEnc` [<string>](http://url.nodejs.cn/9Tw2bK) 当前编码。
-   `toEnc` [<string>](http://url.nodejs.cn/9Tw2bK) 目标编码。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

将给定的 `Buffer` 或 `Uint8Array` 实例从一种字符编码重新编码为另一种。 返回新的 `Buffer` 实例。

如果 `fromEnc` 或 `toEnc` 指定无效的字符编码或不允许从 `fromEnc` 转换为 `toEnc`，则抛出错误。

`buffer.transcode()` 支持的编码有：`'ascii'`、`'utf8'`、`'utf16le'`、`'ucs2'`、`'latin1'` 和 `'binary'`。

如果给定的字节序列不能在目标编码中充分表示，则转码过程将使用替换字符。 例如：

```
const buffer = require('buffer');

const newBuf = buffer.transcode(Buffer.from('€'), 'utf8', 'ascii');
console.log(newBuf.toString('ascii'));
// 打印: '?'
```

由于欧元 (`€`) 符号在 US-ASCII 中无法表示，因此在转码后的 `Buffer` 中将其替换为 `?`。

#### `SlowBuffer` 类[#](http://nodejs.cn/api-v12/buffer.html#class-slowbuffer)

[中英对照](http://nodejs.cn/api-v12/buffer/class_slowbuffer.html)

弃用于: v6.0.0

参见 [`Buffer.allocUnsafeSlow()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size)。 从构造函数总是返回 `Buffer` 实例而不是 `SlowBuffer` 实例的意义上来说，这从来都不是一个类。

##### `new SlowBuffer(size)`[#](http://nodejs.cn/api-v12/buffer.html#new-slowbuffersize)

[中英对照](http://nodejs.cn/api-v12/buffer/new_slowbuffer_size.html)

弃用于: v6.0.0

-   `size` [<integer>](http://url.nodejs.cn/SXbo1v) 新的 `SlowBuffer` 所需的长度。

参见 [`Buffer.allocUnsafeSlow()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size)。

#### 缓冲区常量[#](http://nodejs.cn/api-v12/buffer.html#buffer-constants)

新增于: v8.2.0

##### `buffer.constants.MAX_LENGTH`[#](http://nodejs.cn/api-v12/buffer.html#bufferconstantsmax_length)

[中英对照](http://nodejs.cn/api-v12/buffer/buffer_constants_max_length.html)

新增于: v8.2.0

-   [<integer>](http://url.nodejs.cn/SXbo1v) 单个 `Buffer` 实例允许的最大大小。

在 32 位架构上，此值目前是 230 - 1 (~1GB)。

此值也可用作 [`buffer.kMaxLength`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_kmaxlength)。

##### `buffer.constants.MAX_STRING_LENGTH`[#](http://nodejs.cn/api-v12/buffer.html#bufferconstantsmax_string_length)

[中英对照](http://nodejs.cn/api-v12/buffer/buffer_constants_max_string_length.html)

新增于: v8.2.0

-   [<integer>](http://url.nodejs.cn/SXbo1v) 单个 `string` 实例允许的最大长度。

表示 `string` 原语可以拥有的最大 `length`，以 UTF-16 代码单元计算。

此值可能取决于正在使用的 JS 引擎。

### Buffer.from()、Buffer.alloc() 与 Buffer.allocUnsafe()[#](http://nodejs.cn/api-v12/buffer.html#bufferfrom-bufferalloc-and-bufferallocunsafe)

[中英对照](http://nodejs.cn/api-v12/buffer/buffer_from_buffer_alloc_and_buffer_allocunsafe.html)

在 Node.js 6.0.0 之前的版本中，`Buffer` 实例是使用 `Buffer` 构造函数创建的，它根据提供的参数以不同的方式分配返回的 `Buffer`：

-   将数字作为第一个参数传给 `Buffer()`（例如 `new Buffer(10)`）会分配指定大小的新 `Buffer` 对象。 在 Node.js 8.0.0 之前，为此类 `Buffer` 实例分配的内存未初始化并且可能包含敏感数据。 此类 `Buffer` 实例必须随后通过使用 [`buf.fill(0)`](http://nodejs.cn/api-v12/buffer.html#buffer_buf_fill_value_offset_end_encoding) 或在从 `Buffer` 读取数据之前写入整个 `Buffer` 来初始化。 虽然此行为是为了提高性能，但开发经验表明，在创建快速但未初始化的 `Buffer` 与创建较慢但更安全的 `Buffer` 之间需要更明确的区别。 从 Node.js 8.0.0 开始，`Buffer(num)` 和 `new Buffer(num)` 返回带有初始化内存的 `Buffer`。
-   传入字符串、数组或 `Buffer` 作为第一个参数会将传入的对象的数据复制到 `Buffer`。
-   传入 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 或 [`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy) 返回 `Buffer`，它与给定的数组缓冲区共享分配的内存。

由于 `new Buffer()` 的行为因第一个参数的类型而异，因此当未执行参数验证或 `Buffer` 初始化时，可能会无意中将安全性和可靠性问题引入到应用程序中。

例如，如果攻击者可以使应用程序接收到预期为字符串的数字，则应用程序可能会调用 `new Buffer(100)` 而不是 `new Buffer("100")`，从而导致它分配 100 字节的缓冲区，而不是分配内容为 `"100"` 的 3 字节缓冲区。 这通常可以使用 JSON API 调用实现。 由于 JSON 区分数字和字符串类型，因此它允许在未充分验证其输入的天真编写的应用程序可能期望始终接收字符串的情况下注入数字。 在 Node.js 8.0.0 之前，100 字节的缓冲区可能包含任意预先存在的内存数据，因此可用于向远程攻击者公开内存机密。 从 Node.js 8.0.0 开始，不会发生内存暴露，因为数据是零填充的。 但是，其他攻击仍然是可能的，例如导致服务器分配非常大的缓冲区，导致性能下降或因内存耗尽而崩溃。

为了使 `Buffer` 实例的创建更可靠且不易出错，`new Buffer()` 构造函数的各种形式已被弃用，并由单独的 `Buffer.from()`、[`Buffer.alloc()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_alloc_size_fill_encoding) 和 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 方法取代。

开发人员应将 `new Buffer()` 构造函数的所有现有用途迁移到这些新 API 之一。

-   [`Buffer.from(array)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_array) 返回新的 `Buffer`，其中包含提供的八位字节的副本。
-   [`Buffer.from(arrayBuffer[, byteOffset[, length]])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_arraybuffer_byteoffset_length) 返回新的 `Buffer`，它与给定的 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 共享相同的分配内存。
-   [`Buffer.from(buffer)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_buffer) 返回新的 `Buffer`，其中包含给定 `Buffer` 内容的副本。
-   [`Buffer.from(string[, encoding])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_string_encoding) 返回新的 `Buffer`，其中包含所提供字符串的副本。
-   [`Buffer.alloc(size[, fill[, encoding]])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_alloc_size_fill_encoding) 返回指定大小的新初始化 `Buffer`。 此方法比 [`Buffer.allocUnsafe(size)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 慢，但保证新创建的 `Buffer` 实例永远不会包含可能敏感的旧数据。 如果 `size` 不是数值，则会抛出 `TypeError`。
-   [`Buffer.allocUnsafe(size)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 和 [`Buffer.allocUnsafeSlow(size)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size) 分别返回指定 `size` 的新的未初始化的 `Buffer`。 由于 `Buffer` 未初始化，分配的内存段可能包含潜在敏感的旧数据。

如果 `size` 小于或等于 [`Buffer.poolSize`](http://nodejs.cn/api-v12/buffer.html#buffer_class_property_buffer_poolsize) 的一半，则 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 和 [`Buffer.from(array)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_array) 返回的 `Buffer` 实例可以从共享内部内存池中分配。 [`Buffer.allocUnsafeSlow()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size) 返回的实例从不使用共享内部内存池。

#### \--zero-fill-buffers 命令行选项[#](http://nodejs.cn/api-v12/buffer.html#the---zero-fill-buffers-command-line-option)

[中英对照](http://nodejs.cn/api-v12/buffer/the_zero_fill_buffers_command_line_option.html)

新增于: v5.10.0

如果没有该选项，则使用 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size)、[`Buffer.allocUnsafeSlow()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size) 和 `new SlowBuffer(size)` 创建的缓冲区不会填零。 使用此标志会对性能产生可衡量的负面影响。 仅在必要时使用 `--zero-fill-buffers` 选项以强制新分配的 `Buffer` 实例不能包含可能敏感的旧数据。

```
$ node --zero-fill-buffers
> Buffer.allocUnsafe(5);
<Buffer 00 00 00 00 00>
```

#### Buffer.allocUnsafe() 与 Buffer.allocUnsafeSlow() 不安全的原因[#](http://nodejs.cn/api-v12/buffer.html#what-makes-bufferallocunsafe-and-bufferallocunsafeslow-unsafe)

[中英对照](http://nodejs.cn/api-v12/buffer/what_makes_buffer_allocunsafe_and_buffer_allocunsafeslow_unsafe.html)

调用 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 和 [`Buffer.allocUnsafeSlow()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size) 时，分配的内存段未初始化（未清零）。 虽然这种设计使内存分配非常快，但分配的内存段可能包含潜在敏感的旧数据。 使用 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 创建的 `Buffer` 而不完全覆盖内存可以允许在读取 `Buffer` 内存时泄漏这些旧数据。

虽然使用 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size) 有明显的性能优势，但必须格外小心，以避免将安全漏洞引入应用程序。
