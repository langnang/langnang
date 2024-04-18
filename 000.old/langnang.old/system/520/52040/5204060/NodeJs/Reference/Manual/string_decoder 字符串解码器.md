---
created: 2022-07-29T13:12:55 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/string_decoder.html
author: 
---

# string_decoder 字符串解码器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/string_decoder/string_decoder.html)

**源代码:** [lib/string\_decoder.js](https://github.com/nodejs/node/blob/v12.22.12/lib/string_decoder.js)

`string_decoder` 模块提供了用于将 `Buffer` 对象解码为字符串（以保留编码的多字节 UTF-8 和 UTF-16 字符的方式）的 API。 可以使用以下方式访问它：

```
const { StringDecoder } = require('string_decoder');
```

下面的示例展示了 `StringDecoder` 类的基本用法。

```
const { StringDecoder } = require('string_decoder');
const decoder = new StringDecoder('utf8');

const cent = Buffer.from([0xC2, 0xA2]);
console.log(decoder.write(cent));

const euro = Buffer.from([0xE2, 0x82, 0xAC]);
console.log(decoder.write(euro));
```

当 `Buffer` 实例被写入 `StringDecoder` 实例时，会使用内部的缓冲区来确保解码后的字符串不包含任何不完整的多字节字符。 这些都保存在缓冲区中，直到下一次调用 `stringDecoder.write()` 或调用 `stringDecoder.end()`。

在以下示例中，欧洲欧元符号 (`€`) 的三个 UTF-8 编码的字节通过三次单独的操作写入：

```
const { StringDecoder } = require('string_decoder');
const decoder = new StringDecoder('utf8');

decoder.write(Buffer.from([0xE2]));
decoder.write(Buffer.from([0x82]));
console.log(decoder.end(Buffer.from([0xAC])));
```

### `StringDecoder` 类[#](http://nodejs.cn/api-v12/string_decoder.html#class-stringdecoder)

#### `new StringDecoder([encoding])`[#](http://nodejs.cn/api-v12/string_decoder.html#new-stringdecoderencoding)

[中英对照](http://nodejs.cn/api-v12/string_decoder/new_stringdecoder_encoding.html)

新增于: v0.1.99

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `StringDecoder` 将使用的字符[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。 **默认值:** `'utf8'`。

创建新的 `StringDecoder` 实例。

#### `stringDecoder.end([buffer])`[#](http://nodejs.cn/api-v12/string_decoder.html#stringdecoderendbuffer)

[中英对照](http://nodejs.cn/api-v12/string_decoder/stringdecoder_end_buffer.html)

新增于: v0.9.3

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 包含要解码的字节的 `Buffer`、`TypedArray` 或 `DataView`。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

以字符串形式返回存储在内部缓冲区中的任何剩余的输入。 表示不完整的 UTF-8 和 UTF-16 字符的字节将被替换为适合字符编码的替换字符。

如果提供了 `buffer` 参数，则在返回剩余的输入之前执行对 `stringDecoder.write()` 的最后一次调用。

#### `stringDecoder.write(buffer)`[#](http://nodejs.cn/api-v12/string_decoder.html#stringdecoderwritebuffer)

[中英对照](http://nodejs.cn/api-v12/string_decoder/stringdecoder_write_buffer.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 包含要解码的字节的 `Buffer`、`TypedArray` 或 `DataView`。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回已解码的字符串，确保从返回的字符串中省略 `Buffer`、`TypedArray` 或 `DataView` 末尾的任何不完整的多字节字符，并将其存储在内部缓冲区中，以备下次调用 `stringDecoder.write()` 或 `stringDecoder.end()` 时使用。
