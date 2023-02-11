---
created: 2022-07-29T13:12:52 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/crypto.html
author: 
---

# crypto 加密 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/crypto/crypto.html)

**源代码:** [lib/crypto.js](https://github.com/nodejs/node/blob/v12.22.12/lib/crypto.js)

`crypto` 模块提供了加密功能，其中包括了用于 OpenSSL 散列、HMAC、加密、解密、签名、以及验证的函数的一整套封装。

使用 `require('crypto')` 访问此模块。

```
const crypto = require('crypto');

const secret = 'abcdefg';
const hash = crypto.createHmac('sha256', secret)
                   .update('I love cupcakes')
                   .digest('hex');
console.log(hash);
// 打印:
//   c0fa1bc00531bd78ef38c628449c5102aeabd49b5dc3a2a516ea6ea959d6658e
```

### 确定加密支持是否不可用[#](http://nodejs.cn/api-v12/crypto.html#determining-if-crypto-support-is-unavailable)

[中英对照](http://nodejs.cn/api-v12/crypto/determining_if_crypto_support_is_unavailable.html)

可以在不支持 `crypto` 模块的情况下构建 Node.js。 在这种情况下，调用 `require('crypto')` 将导致抛出错误。

```
let crypto;
try {
  crypto = require('crypto');
} catch (err) {
  console.log('crypto support is disabled!');
}
```

### `Certificate` 类[#](http://nodejs.cn/api-v12/crypto.html#class-certificate)

[中英对照](http://nodejs.cn/api-v12/crypto/class_certificate.html)

新增于: v0.11.8

SPKAC 是最初由 Netscape 实现的证书签名请求机制，并被正式指定为 [HTML5 的 `keygen` 元素](http://url.nodejs.cn/2T24oh)的一部分。

`<keygen>` 已弃用，因为 [HTML 5.2](http://url.nodejs.cn/WMZ1Ef) 和新项目不应再使用此元素。

`crypto` 模块提供了用于处理 SPKAC 数据的 `Certificate` 类。 最常见的用法是处理由 HTML5 `<keygen>` 元素生成的输出。 Node.js 在内部使用 [OpenSSL 的 SPKAC 实现](http://url.nodejs.cn/qh2GSY)。

#### `Certificate.exportChallenge(spkac)`[#](http://nodejs.cn/api-v12/crypto.html#certificateexportchallengespkac)

[中英对照](http://nodejs.cn/api-v12/crypto/certificate_exportchallenge_spkac.html)

新增于: v9.0.0

-   `spkac` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `spkac` 数据结构的挑战组件，包括公钥和挑战。

```
const { Certificate } = require('crypto');
const spkac = getSpkacSomehow();
const challenge = Certificate.exportChallenge(spkac);
console.log(challenge.toString('utf8'));
// 打印: the challenge as a UTF8 string
```

#### `Certificate.exportPublicKey(spkac[, encoding])`[#](http://nodejs.cn/api-v12/crypto.html#certificateexportpublickeyspkac-encoding)

[中英对照](http://nodejs.cn/api-v12/crypto/certificate_exportpublickey_spkac_encoding.html)

新增于: v9.0.0

-   `spkac` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `spkac` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `spkac` 数据结构的公钥组件，包括公钥和挑战。

```
const { Certificate } = require('crypto');
const spkac = getSpkacSomehow();
const publicKey = Certificate.exportPublicKey(spkac);
console.log(publicKey);
// 打印: the public key as <Buffer ...>
```

#### `Certificate.verifySpkac(spkac)`[#](http://nodejs.cn/api-v12/crypto.html#certificateverifyspkacspkac)

[中英对照](http://nodejs.cn/api-v12/crypto/certificate_verifyspkac_spkac.html)

新增于: v9.0.0

-   `spkac` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果给定的 `spkac` 数据结构有效，则为 `true`，否则为 `false`。

```
const { Certificate } = require('crypto');
const spkac = getSpkacSomehow();
console.log(Certificate.verifySpkac(Buffer.from(spkac)));
// 打印: true 或 false
```

#### 旧版的 API[#](http://nodejs.cn/api-v12/crypto.html#legacy-api)

As a still supported legacy interface, it is possible to create new instances of the `crypto.Certificate` class as illustrated in the examples below.

##### `new crypto.Certificate()`[#](http://nodejs.cn/api-v12/crypto.html#new-cryptocertificate)

[中英对照](http://nodejs.cn/api-v12/crypto/new_crypto_certificate.html)

可以使用 `new` 关键字或通过调用 `crypto.Certificate()` 作为函数来创建 `Certificate` 类的实例：

```
const crypto = require('crypto');

const cert1 = new crypto.Certificate();
const cert2 = crypto.Certificate();
```

##### `certificate.exportChallenge(spkac)`[#](http://nodejs.cn/api-v12/crypto.html#certificateexportchallengespkac_1)

[中英对照](http://nodejs.cn/api-v12/crypto/certificate_exportchallenge_spkac_1.html)

新增于: v0.11.8

-   `spkac` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `spkac` 数据结构的挑战组件，包括公钥和挑战。

```
const cert = require('crypto').Certificate();
const spkac = getSpkacSomehow();
const challenge = cert.exportChallenge(spkac);
console.log(challenge.toString('utf8'));
// 打印: the challenge as a UTF8 string
```

##### `certificate.exportPublicKey(spkac)`[#](http://nodejs.cn/api-v12/crypto.html#certificateexportpublickeyspkac)

[中英对照](http://nodejs.cn/api-v12/crypto/certificate_exportpublickey_spkac.html)

新增于: v0.11.8

-   `spkac` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `spkac` 数据结构的公钥组件，包括公钥和挑战。

```
const cert = require('crypto').Certificate();
const spkac = getSpkacSomehow();
const publicKey = cert.exportPublicKey(spkac);
console.log(publicKey);
// 打印: the public key as <Buffer ...>
```

##### `certificate.verifySpkac(spkac)`[#](http://nodejs.cn/api-v12/crypto.html#certificateverifyspkacspkac_1)

[中英对照](http://nodejs.cn/api-v12/crypto/certificate_verifyspkac_spkac_1.html)

新增于: v0.11.8

-   `spkac` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果给定的 `spkac` 数据结构有效，则为 `true`，否则为 `false`。

```
const cert = require('crypto').Certificate();
const spkac = getSpkacSomehow();
console.log(cert.verifySpkac(Buffer.from(spkac)));
// 打印: true 或 false
```

### `Cipher` 类[#](http://nodejs.cn/api-v12/crypto.html#class-cipher)

[中英对照](http://nodejs.cn/api-v12/crypto/class_cipher.html)

新增于: v0.1.94

-   继承自: [<stream.Transform>](http://nodejs.cn/api/stream.html#class-streamtransform)

`Cipher` 类的实例用于加密数据。 可以通过以下两种方式之一使用该类：

-   作为既可读又可写的[流](http://nodejs.cn/api-v12/stream.html)，其中写入未加密的纯数据以在可读端生成加密的数据，或
-   使用 [`cipher.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_update_data_inputencoding_outputencoding) 和 [`cipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_final_outputencoding) 方法生成加密的数据。

[`crypto.createCipher()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createcipher_algorithm_password_options) 或 [`crypto.createCipheriv()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createcipheriv_algorithm_key_iv_options) 方法用于创建 `Cipher` 实例。 `Cipher` 对象不能直接使用 `new` 关键字创建。

示例：使用 `Cipher` 对象作为流：

```
const crypto = require('crypto');

const algorithm = 'aes-192-cbc';
const password = 'Password used to generate key';
// 密钥长度取决于算法。
// 在这种情况下，对于 aes192，它是 24 字节（192 位）。
// 请改用异步的 `crypto.scrypt()`。
const key = crypto.scryptSync(password, 'salt', 24);
// 使用 `crypto.randomBytes()` 生成随机的 iv，
// 而不是此处显示的静态的 iv。
const iv = Buffer.alloc(16, 0); // 初始化向量。

const cipher = crypto.createCipheriv(algorithm, key, iv);

let encrypted = '';
cipher.on('readable', () => {
  let chunk;
  while (null !== (chunk = cipher.read())) {
    encrypted += chunk.toString('hex');
  }
});
cipher.on('end', () => {
  console.log(encrypted);
  // 打印: e5f79c5915c02171eec6b212d5520d44480993d7d622a7c4c2da32f6efda0ffa
});

cipher.write('some clear text data');
cipher.end();
```

示例：使用 `Cipher` 和管道流：

```
const crypto = require('crypto');
const fs = require('fs');

const algorithm = 'aes-192-cbc';
const password = 'Password used to generate key';
// 请改用异步的 `crypto.scrypt()`。
const key = crypto.scryptSync(password, 'salt', 24);
// 使用 `crypto.randomBytes()` 生成随机的 iv，
// 而不是此处显示的静态的 iv。
const iv = Buffer.alloc(16, 0); // 初始化向量。

const cipher = crypto.createCipheriv(algorithm, key, iv);

const input = fs.createReadStream('test.js');
const output = fs.createWriteStream('test.enc');

input.pipe(cipher).pipe(output);
```

示例：使用 [`cipher.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_update_data_inputencoding_outputencoding) 和 [`cipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_final_outputencoding) 方法：

```
const crypto = require('crypto');

const algorithm = 'aes-192-cbc';
const password = 'Password used to generate key';
// 请改用异步的 `crypto.scrypt()`。
const key = crypto.scryptSync(password, 'salt', 24);
// 使用 `crypto.randomBytes` 生成随机的 iv，
// 而不是此处显示的静态的 iv。
const iv = Buffer.alloc(16, 0); // 初始化向量。

const cipher = crypto.createCipheriv(algorithm, key, iv);

let encrypted = cipher.update('some clear text data', 'utf8', 'hex');
encrypted += cipher.final('hex');
console.log(encrypted);
// 打印: e5f79c5915c02171eec6b212d5520d44480993d7d622a7c4c2da32f6efda0ffa
```

#### `cipher.final([outputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#cipherfinaloutputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/cipher_final_outputencoding.html)

新增于: v0.1.94

-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) 任何剩余的加密内容。 如果指定了 `outputEncoding`，则返回字符串。 如果未提供 `outputEncoding`，则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

一旦调用了 `cipher.final()` 方法，则 `Cipher` 对象就不能再用于加密数据。 多次尝试调用 `cipher.final()` 将导致抛出错误。

#### `cipher.setAAD(buffer[, options])`[#](http://nodejs.cn/api-v12/crypto.html#ciphersetaadbuffer-options)

[中英对照](http://nodejs.cn/api-v12/crypto/cipher_setaad_buffer_options.html)

新增于: v1.0.0

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
    -   `plaintextLength` [<number>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Cipher>](http://nodejs.cn/api/crypto.html#class-cipher) 用于方法链。

当使用认证的加密模式时（当前支持 `GCM`、`CCM` 和 `OCB`），则 `cipher.setAAD()` 方法设置用于额外的认证数据 (AAD) 输入参数的值。

`options` 选项对于 `GCM` 和 `OCB` 是可选的。 使用 `CCM` 时，必须指定 `plaintextLength` 选项，其值必须与明文的字节长度匹配。 请参见 [CCM 模式](http://nodejs.cn/api-v12/crypto.html#crypto_ccm_mode)。

`cipher.setAAD()` 方法必须在 [`cipher.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_update_data_inputencoding_outputencoding) 之前调用。

#### `cipher.getAuthTag()`[#](http://nodejs.cn/api-v12/crypto.html#ciphergetauthtag)

[中英对照](http://nodejs.cn/api-v12/crypto/cipher_getauthtag.html)

新增于: v1.0.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 当使用认证的加密模式时（当前支持 `GCM`、`CCM` 和 `OCB`），则 `cipher.getAuthTag()` 方法返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)，其中包含根据给定数据计算出的认证标签。

只有在使用 [`cipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_final_outputencoding) 方法完成加密后才应调用 `cipher.getAuthTag()` 方法。

#### `cipher.setAutoPadding([autoPadding])`[#](http://nodejs.cn/api-v12/crypto.html#ciphersetautopaddingautopadding)

[中英对照](http://nodejs.cn/api-v12/crypto/cipher_setautopadding_autopadding.html)

新增于: v0.7.1

-   `autoPadding` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `true`
-   返回: [<Cipher>](http://nodejs.cn/api/crypto.html#class-cipher) 用于方法链。

当使用块加密算法时，`Cipher` 类会自动向输入数据添加填充到适当的块大小。 要禁用默认填充调用 `cipher.setAutoPadding(false)`。

当 `autoPadding` 为 `false` 时，整个输入数据的长度必须是密码块大小的倍数，否则 [`cipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_final_outputencoding) 将抛出错误。 禁用自动填充对于非标准填充很有用，例如使用 `0x0` 而不是 PKCS 填充。

`cipher.setAutoPadding()` 方法必须在 [`cipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_final_outputencoding) 之前调用。

#### `cipher.update(data[, inputEncoding][, outputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#cipherupdatedata-inputencoding-outputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/cipher_update_data_inputencoding_outputencoding.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 数据的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

使用 `data` 更新密码。 如果给定了 `inputEncoding` 参数，则 `data` 参数是使用指定编码的字符串。 如果未给定 `inputEncoding` 参数，则 `data` 必须是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。 如果 `data` 是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`，则忽略 `inputEncoding`。

`outputEncoding` 指定加密数据的输出格式。 如果指定了 `outputEncoding`，则返回使用指定编码的字符串。 如果未提供 `outputEncoding`，则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

可以使用新数据多次调用 `cipher.update()` 方法，直到调用 [`cipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_final_outputencoding)。 在 [`cipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_final_outputencoding) 之后调用 `cipher.update()` 将导致抛出错误。

### `Decipher` 类[#](http://nodejs.cn/api-v12/crypto.html#class-decipher)

[中英对照](http://nodejs.cn/api-v12/crypto/class_decipher.html)

新增于: v0.1.94

-   继承自: [<stream.Transform>](http://nodejs.cn/api/stream.html#class-streamtransform)

`Decipher` 类的实例用于解密数据。 可以通过以下两种方式之一使用该类：

-   作为既可读又可写的[流](http://nodejs.cn/api-v12/stream.html)，其中写入纯加密数据以在可读端生成未加密数据，或
-   使用 [`decipher.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_update_data_inputencoding_outputencoding) 和 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding) 方法生成未加密的数据。

[`crypto.createDecipher()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createdecipher_algorithm_password_options) 或 [`crypto.createDecipheriv()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createdecipheriv_algorithm_key_iv_options) 方法用于创建 `Decipher` 实例。 `Decipher` 对象不能直接使用 `new` 关键字创建。

示例：使用 `Decipher` 对象作为流：

```
const crypto = require('crypto');

const algorithm = 'aes-192-cbc';
const password = 'Password used to generate key';
// 密钥长度取决于算法。
// 在这种情况下，对于 aes192，它是 24 字节（192 位）。
// 请改用异步的 `crypto.scrypt()`。
const key = crypto.scryptSync(password, 'salt', 24);
// IV 通常与密文一起传入。
const iv = Buffer.alloc(16, 0); // 初始化向量。

const decipher = crypto.createDecipheriv(algorithm, key, iv);

let decrypted = '';
decipher.on('readable', () => {
  while (null !== (chunk = decipher.read())) {
    decrypted += chunk.toString('utf8');
  }
});
decipher.on('end', () => {
  console.log(decrypted);
  // 打印: some clear text data
});

// 使用相同的算法、密钥和 iv 加密。
const encrypted =
  'e5f79c5915c02171eec6b212d5520d44480993d7d622a7c4c2da32f6efda0ffa';
decipher.write(encrypted, 'hex');
decipher.end();
```

示例：使用 `Decipher` 和管道流：

```
const crypto = require('crypto');
const fs = require('fs');

const algorithm = 'aes-192-cbc';
const password = 'Password used to generate key';
// 请改用异步的 `crypto.scrypt()`。
const key = crypto.scryptSync(password, 'salt', 24);
// IV 通常与密文一起传入。
const iv = Buffer.alloc(16, 0); // 初始化向量。

const decipher = crypto.createDecipheriv(algorithm, key, iv);

const input = fs.createReadStream('test.enc');
const output = fs.createWriteStream('test.js');

input.pipe(decipher).pipe(output);
```

示例：使用 [`decipher.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_update_data_inputencoding_outputencoding) 和 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding) 方法：

```
const crypto = require('crypto');

const algorithm = 'aes-192-cbc';
const password = 'Password used to generate key';
// 请改用异步的 `crypto.scrypt()`。
const key = crypto.scryptSync(password, 'salt', 24);
// IV 通常与密文一起传入。
const iv = Buffer.alloc(16, 0); // 初始化向量。

const decipher = crypto.createDecipheriv(algorithm, key, iv);

// 使用相同的算法、密钥和 iv 加密。
const encrypted =
  'e5f79c5915c02171eec6b212d5520d44480993d7d622a7c4c2da32f6efda0ffa';
let decrypted = decipher.update(encrypted, 'hex', 'utf8');
decrypted += decipher.final('utf8');
console.log(decrypted);
// 打印: some clear text data
```

#### `decipher.final([outputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#decipherfinaloutputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/decipher_final_outputencoding.html)

新增于: v0.1.94

-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) 任何剩余的解密内容。 如果指定了 `outputEncoding`，则返回字符串。 如果未提供 `outputEncoding`，则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

一旦调用了 `decipher.final()` 方法，就不能再使用 `Decipher` 对象来解密数据。 多次尝试调用 `decipher.final()` 将导致抛出错误。

#### `decipher.setAAD(buffer[, options])`[#](http://nodejs.cn/api-v12/crypto.html#deciphersetaadbuffer-options)

[中英对照](http://nodejs.cn/api-v12/crypto/decipher_setaad_buffer_options.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
    -   `plaintextLength` [<number>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Decipher>](http://nodejs.cn/api/crypto.html#class-decipher) 用于方法链。

当使用认证的加密模式时（当前支持 `GCM`、`CCM` 和 `OCB`），则 `decipher.setAAD()` 方法设置用于额外的认证数据 (AAD) 输入参数的值。

`options` 参数对于 `GCM` 是可选的。 使用 `CCM` 时，必须指定 `plaintextLength` 选项，其值必须与密文的字节长度匹配。 请参见 [CCM 模式](http://nodejs.cn/api-v12/crypto.html#crypto_ccm_mode)。

`decipher.setAAD()` 方法必须在 [`decipher.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_update_data_inputencoding_outputencoding) 之前调用。

#### `decipher.setAuthTag(buffer)`[#](http://nodejs.cn/api-v12/crypto.html#deciphersetauthtagbuffer)

[中英对照](http://nodejs.cn/api-v12/crypto/decipher_setauthtag_buffer.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Decipher>](http://nodejs.cn/api/crypto.html#class-decipher) 用于方法链。

当使用认证的加密方式时（目前支持 `GCM`、`CCM`、`OCB`），则使用 `decipher.setAuthTag()` 方法传入接收到的认证标签。 如果没有提供标签，或者密文被篡改，则抛出 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding)，表示由于认证失败，密文应该被丢弃。 如果标签长度根据 [NIST SP 800-38D](http://url.nodejs.cn/G26eau) 无效或与 `authTagLength` 选项的值不匹配，则 `decipher.setAuthTag()` 将抛出错误。

对于 `CCM` 模式，必须在 [`decipher.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_update_data_inputencoding_outputencoding) 之前调用 `decipher.setAuthTag()` 方法，对于 `GCM` 和 `OCB` 模式，必须在 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding) 之前调用。 `decipher.setAuthTag()` 只能被调用一次。

#### `decipher.setAutoPadding([autoPadding])`[#](http://nodejs.cn/api-v12/crypto.html#deciphersetautopaddingautopadding)

[中英对照](http://nodejs.cn/api-v12/crypto/decipher_setautopadding_autopadding.html)

新增于: v0.7.1

-   `autoPadding` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `true`
-   返回: [<Decipher>](http://nodejs.cn/api/crypto.html#class-decipher) 用于方法链。

当数据在没有标准块填充的情况下加密时，调用 `decipher.setAutoPadding(false)` 将禁用自动填充以防止 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding) 检查和删除填充。

仅当输入数据的长度是密码块大小的倍数时，关闭自动填充才会起作用。

`decipher.setAutoPadding()` 方法必须在 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding) 之前调用。

#### `decipher.update(data[, inputEncoding][, outputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#decipherupdatedata-inputencoding-outputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/decipher_update_data_inputencoding_outputencoding.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `data` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

用 `data` 更新解密。 如果给定了 `inputEncoding` 参数，则 `data` 参数是使用指定编码的字符串。 如果未给定 `inputEncoding` 参数，则 `data` 必须是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。 如果 `data` 是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)，则忽略 `inputEncoding`。

`outputEncoding` 指定加密数据的输出格式。 如果指定了 `outputEncoding`，则返回使用指定编码的字符串。 如果未提供 `outputEncoding`，则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

可以使用新数据多次调用 `decipher.update()` 方法，直到调用 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding)。 在 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding) 之后调用 `decipher.update()` 将导致抛出错误。

### `DiffieHellman` 类[#](http://nodejs.cn/api-v12/crypto.html#class-diffiehellman)

[中英对照](http://nodejs.cn/api-v12/crypto/class_diffiehellman.html)

新增于: v0.5.0

`DiffieHellman` 类是用于创建 Diffie-Hellman 密钥交换的实用工具。

可以使用 [`crypto.createDiffieHellman()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_creatediffiehellman_prime_primeencoding_generator_generatorencoding) 函数创建 `DiffieHellman` 类的实例。

```
const crypto = require('crypto');
const assert = require('assert');

// 生成 Alice 的密钥...
const alice = crypto.createDiffieHellman(2048);
const aliceKey = alice.generateKeys();

// 生成 Bob 的密钥...
const bob = crypto.createDiffieHellman(alice.getPrime(), alice.getGenerator());
const bobKey = bob.generateKeys();

// 交换并生成密钥...
const aliceSecret = alice.computeSecret(bobKey);
const bobSecret = bob.computeSecret(aliceKey);

// OK
assert.strictEqual(aliceSecret.toString('hex'), bobSecret.toString('hex'));
```

#### `diffieHellman.computeSecret(otherPublicKey[, inputEncoding][, outputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmancomputesecretotherpublickey-inputencoding-outputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_computesecret_otherpublickey_inputencoding_outputencoding.html)

新增于: v0.5.0

-   `otherPublicKey` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `otherPublicKey` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

使用 `otherPublicKey` 作为对方的公钥计算共享密钥，并返回计算出的共享密钥。 使用指定的 `inputEncoding` 解释提供的密钥，使用指定的 `outputEncoding` 对密钥进行编码。 如果未提供 `inputEncoding`，则 `otherPublicKey` 应为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

如果给定 `outputEncoding`，则返回字符串； 否则，返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `diffieHellman.generateKeys([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmangeneratekeysencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_generatekeys_encoding.html)

新增于: v0.5.0

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

生成私钥和公钥 Diffie-Hellman 密钥值，并返回指定 `encoding` 中的公钥。 此密钥应转让给另一方。 如果提供了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `diffieHellman.getGenerator([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmangetgeneratorencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_getgenerator_encoding.html)

新增于: v0.5.0

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

返回指定 `encoding` 中的 Diffie-Hellman 生成器。 如果提供了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `diffieHellman.getPrime([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmangetprimeencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_getprime_encoding.html)

新增于: v0.5.0

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

返回指定 `encoding` 中的 Diffie-Hellman 素数。 如果提供了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `diffieHellman.getPrivateKey([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmangetprivatekeyencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_getprivatekey_encoding.html)

新增于: v0.5.0

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

返回指定 `encoding` 中的 Diffie-Hellman 私钥。 如果提供了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `diffieHellman.getPublicKey([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmangetpublickeyencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_getpublickey_encoding.html)

新增于: v0.5.0

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

返回指定 `encoding` 中的 Diffie-Hellman 公钥。 如果提供了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `diffieHellman.setPrivateKey(privateKey[, encoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmansetprivatekeyprivatekey-encoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_setprivatekey_privatekey_encoding.html)

新增于: v0.5.0

-   `privateKey` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `privateKey` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

设置 Diffie-Hellman 私钥。 如果提供了 `encoding` 参数，则 `privateKey` 应该是字符串。 如果未提供 `encoding`，则 `privateKey` 应为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

#### `diffieHellman.setPublicKey(publicKey[, encoding])`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmansetpublickeypublickey-encoding)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_setpublickey_publickey_encoding.html)

新增于: v0.5.0

-   `publicKey` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `publicKey` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

设置 Diffie-Hellman 公钥。 如果提供了 `encoding` 参数，则 `publicKey` 应该是字符串。 如果未提供 `encoding`，则 `publicKey` 应为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

#### `diffieHellman.verifyError`[#](http://nodejs.cn/api-v12/crypto.html#diffiehellmanverifyerror)

[中英对照](http://nodejs.cn/api-v12/crypto/diffiehellman_verifyerror.html)

新增于: v0.11.12

包含在 `DiffieHellman` 对象初始化期间执行的检查所产生的任何警告和/或错误的位字段。

以下值对此属性有效（如 `constants` 模块中所定义）：

-   `DH_CHECK_P_NOT_SAFE_PRIME`
-   `DH_CHECK_P_NOT_PRIME`
-   `DH_UNABLE_TO_CHECK_GENERATOR`
-   `DH_NOT_SUITABLE_GENERATOR`

### `DiffieHellmanGroup` 类[#](http://nodejs.cn/api-v12/crypto.html#class-diffiehellmangroup)

[中英对照](http://nodejs.cn/api-v12/crypto/class_diffiehellmangroup.html)

新增于: v0.7.5

```
const name = 'modp1';
const dh = crypto.createDiffieHellmanGroup(name);
```

`name` 取自 [RFC 2412](http://url.nodejs.cn/6ouCbA)（modp1 和 2）和 [RFC 3526](http://url.nodejs.cn/m8pGEe)：

```
$ perl -ne 'print "$1\n" if /"(modp\d+)"/' src/node_crypto_groups.h
modp1  #  768 位
modp2  # 1024 位
modp5  # 1536 位
modp14 # 2048 位
modp15 # 等等。
modp16
modp17
modp18
```

### `ECDH` 类[#](http://nodejs.cn/api-v12/crypto.html#class-ecdh)

[中英对照](http://nodejs.cn/api-v12/crypto/class_ecdh.html)

新增于: v0.11.14

`ECDH` 类是用于创建椭圆曲线 Diffie-Hellman (ECDH) 密钥交换的实用工具。

可以使用 [`crypto.createECDH()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createecdh_curvename) 函数创建 `ECDH` 类的实例。

```
const crypto = require('crypto');
const assert = require('assert');

// 生成 Alice 的密钥...
const alice = crypto.createECDH('secp521r1');
const aliceKey = alice.generateKeys();

// 生成 Bob 的密钥...
const bob = crypto.createECDH('secp521r1');
const bobKey = bob.generateKeys();

// 交换并生成密钥...
const aliceSecret = alice.computeSecret(bobKey);
const bobSecret = bob.computeSecret(aliceKey);

assert.strictEqual(aliceSecret.toString('hex'), bobSecret.toString('hex'));
// OK
```

#### `ECDH.convertKey(key, curve[, inputEncoding[, outputEncoding[, format]]])`[#](http://nodejs.cn/api-v12/crypto.html#static-method-ecdhconvertkeykey-curve-inputencoding-outputencoding-format)

[中英对照](http://nodejs.cn/api-v12/crypto/static_method_ecdh_convertkey_key_curve_inputencoding_outputencoding_format.html)

新增于: v10.0.0

-   `key` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `curve` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `key` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `format` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'uncompressed'`
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

将 `key` 和 `curve` 指定的 EC Diffie-Hellman 公钥转换为 `format` 指定的格式。 `format` 参数指定点编码，可以是 `'compressed'`、`'uncompressed'` 或 `'hybrid'`。 提供的密钥使用指定的 `inputEncoding` 进行解释，返回的密钥使用指定的 `outputEncoding` 进行编码。

使用 [`crypto.getCurves()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_getcurves) 获取可用曲线名称的列表。 在最近的 OpenSSL 版本中，`openssl ecparam -list_curves` 还将显示每个可用椭圆曲线的名称和描述。

如果未指定 `format`，该点将以 `'uncompressed'` 格式返回。

如果未提供 `inputEncoding`，则 `key` 应为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

示例（解压缩密钥）：

```
const { createECDH, ECDH } = require('crypto');

const ecdh = createECDH('secp256k1');
ecdh.generateKeys();

const compressedKey = ecdh.getPublicKey('hex', 'compressed');

const uncompressedKey = ECDH.convertKey(compressedKey,
                                        'secp256k1',
                                        'hex',
                                        'hex',
                                        'uncompressed');

// 转换后的密钥和未压缩的公钥应该是一样的
console.log(uncompressedKey === ecdh.getPublicKey('hex'));
```

#### `ecdh.computeSecret(otherPublicKey[, inputEncoding][, outputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#ecdhcomputesecretotherpublickey-inputencoding-outputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/ecdh_computesecret_otherpublickey_inputencoding_outputencoding.html)

-   `otherPublicKey` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `otherPublicKey` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

使用 `otherPublicKey` 作为对方的公钥计算共享密钥，并返回计算出的共享密钥。 提供的密钥使用指定的 `inputEncoding` 进行解释，返回的密钥使用指定的 `outputEncoding` 进行编码。 如果未提供 `inputEncoding`，则 `otherPublicKey` 应为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

如果给定 `outputEncoding`，将返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

当 `otherPublicKey` 位于椭圆曲线之外时，`ecdh.computeSecret` 将抛出 `ERR_CRYPTO_ECDH_INVALID_PUBLIC_KEY` 错误。 由于 `otherPublicKey` 通常由远程用户通过不安全的网络提供，因此请务必相应地处理此异常。

#### `ecdh.generateKeys([encoding[, format]])`[#](http://nodejs.cn/api-v12/crypto.html#ecdhgeneratekeysencoding-format)

[中英对照](http://nodejs.cn/api-v12/crypto/ecdh_generatekeys_encoding_format.html)

新增于: v0.11.14

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `format` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'uncompressed'`
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

生成私有和公共 EC Diffie-Hellman 密钥值，并返回指定 `format` 和 `encoding` 中的公钥。 此密钥应转让给另一方。

`format` 参数指定点编码，可以是 `'compressed'` 或 `'uncompressed'`。 如果未指定 `format`，则该点将以 `'uncompressed'` 格式返回。

如果提供了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `ecdh.getPrivateKey([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#ecdhgetprivatekeyencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/ecdh_getprivatekey_encoding.html)

新增于: v0.11.14

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) 指定 `encoding` 中的 EC Diffie-Hellman。

如果指定了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `ecdh.getPublicKey([encoding][, format])`[#](http://nodejs.cn/api-v12/crypto.html#ecdhgetpublickeyencoding-format)

[中英对照](http://nodejs.cn/api-v12/crypto/ecdh_getpublickey_encoding_format.html)

新增于: v0.11.14

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `format` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'uncompressed'`
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) 指定 `encoding` 和 `format` 中的 EC Diffie-Hellman 公钥。

`format` 参数指定点编码，可以是 `'compressed'` 或 `'uncompressed'`。 如果未指定 `format`，该点将以 `'uncompressed'` 格式返回。

如果指定了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

#### `ecdh.setPrivateKey(privateKey[, encoding])`[#](http://nodejs.cn/api-v12/crypto.html#ecdhsetprivatekeyprivatekey-encoding)

[中英对照](http://nodejs.cn/api-v12/crypto/ecdh_setprivatekey_privatekey_encoding.html)

新增于: v0.11.14

-   `privateKey` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `privateKey` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

设置 EC Diffie-Hellman 私钥。 如果提供了 `encoding`，则 `privateKey` 应该是字符串；否则 `privateKey` 应该是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

如果 `privateKey` 对于创建 `ECDH` 对象时指定的曲线无效，则会引发错误。 在设置私钥时，相关的公共点（密钥）也会生成并设置在 `ECDH` 对象中。

#### `ecdh.setPublicKey(publicKey[, encoding])`[#](http://nodejs.cn/api-v12/crypto.html#ecdhsetpublickeypublickey-encoding)

[中英对照](http://nodejs.cn/api-v12/crypto/ecdh_setpublickey_publickey_encoding.html)

新增于: v0.11.14弃用于: v5.2.0

-   `publicKey` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) `publicKey` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

设置 EC Diffie-Hellman 公钥。 如果提供了 `encoding`，则 `publicKey` 应该是字符串；否则应为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

通常没有理由调用这个方法，因为 `ECDH` 只需要一个私钥和对方的公钥来计算共享秘密。 通常会调用 [`ecdh.generateKeys()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_generatekeys_encoding_format) 或 [`ecdh.setPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_setprivatekey_privatekey_encoding)。 [`ecdh.setPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_setprivatekey_privatekey_encoding) 方法尝试生成与正在设置的私钥相关联的公共点/密钥。

示例（获取共享密钥）：

```
const crypto = require('crypto');
const alice = crypto.createECDH('secp256k1');
const bob = crypto.createECDH('secp256k1');

// 这是指定 Alice 以前的私钥之一的快捷方式。
// 在实际应用中使用这种可预测的私钥是不明智的。
alice.setPrivateKey(
  crypto.createHash('sha256').update('alice', 'utf8').digest()
);

// Bob 使用新生成的加密强伪随机密钥对
bob.generateKeys();

const aliceSecret = alice.computeSecret(bob.getPublicKey(), null, 'hex');
const bobSecret = bob.computeSecret(alice.getPublicKey(), null, 'hex');

// aliceSecret 和 bobSecret 应该是相同的共享秘密值
console.log(aliceSecret === bobSecret);
```

### `Hash` 类[#](http://nodejs.cn/api-v12/crypto.html#class-hash)

[中英对照](http://nodejs.cn/api-v12/crypto/class_hash.html)

新增于: v0.1.92

-   继承自: [<stream.Transform>](http://nodejs.cn/api/stream.html#class-streamtransform)

`Hash` 类是用于创建数据的哈希摘要的实用工具。 它可以通过以下两种方式之一使用：

-   作为既可读又可写的[流](http://nodejs.cn/api-v12/stream.html)，其中写入数据以在可读端生成计算的哈希摘要，或者
-   使用 [`hash.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_update_data_inputencoding) 和 [`hash.digest()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_digest_encoding) 方法生成计算的哈希。

[`crypto.createHash()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createhash_algorithm_options) 方法用于创建 `Hash` 实例。 `Hash` 对象不能直接使用 `new` 关键字创建。

示例：使用 `Hash` 对象作为流：

```
const crypto = require('crypto');
const hash = crypto.createHash('sha256');

hash.on('readable', () => {
  // 哈希流只生成
  // 一个元素。
  const data = hash.read();
  if (data) {
    console.log(data.toString('hex'));
    // 打印:
    //   6a2da20943931e9834fc12cfe5bb47bbd9ae43489a30726962b576f4e3993e50
  }
});

hash.write('some data to hash');
hash.end();
```

示例：使用 `Hash` 和管道流：

```
const crypto = require('crypto');
const fs = require('fs');
const hash = crypto.createHash('sha256');

const input = fs.createReadStream('test.js');
input.pipe(hash).pipe(process.stdout);
```

示例：使用 [`hash.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_update_data_inputencoding) 和 [`hash.digest()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_digest_encoding) 方法：

```
const crypto = require('crypto');
const hash = crypto.createHash('sha256');

hash.update('some data to hash');
console.log(hash.digest('hex'));
// 打印:
//   6a2da20943931e9834fc12cfe5bb47bbd9ae43489a30726962b576f4e3993e50
```

#### `hash.copy([options])`[#](http://nodejs.cn/api-v12/crypto.html#hashcopyoptions)

[中英对照](http://nodejs.cn/api-v12/crypto/hash_copy_options.html)

新增于: v12.16.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
-   返回: [<Hash>](http://nodejs.cn/api/crypto.html#class-hash)

创建新的 `Hash` 对象，其中包含当前 `Hash` 对象的内部状态的深层副本。

可选的 `options` 参数控制流的行为。 对于 XOF 哈希函数（例如 `'shake256'`），可以使用 `outputLength` 选项指定所需的输出长度（以字节为单位）。

在调用 [`hash.digest()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_digest_encoding) 方法后尝试复制 `Hash` 对象时会引发错误。

```
// 计算滚动哈希。
const crypto = require('crypto');
const hash = crypto.createHash('sha256');

hash.update('one');
console.log(hash.copy().digest('hex'));

hash.update('two');
console.log(hash.copy().digest('hex'));

hash.update('three');
console.log(hash.copy().digest('hex'));

// 等等。
```

#### `hash.digest([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#hashdigestencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/hash_digest_encoding.html)

新增于: v0.1.92

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

计算传给被哈希的所有数据的摘要（使用 [`hash.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_update_data_inputencoding) 方法）。 如果提供了 `encoding`，则将返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

`Hash` 对象在调用 `hash.digest()` 方法后不能再次使用。 多次调用将导致抛出错误。

#### `hash.update(data[, inputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#hashupdatedata-inputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/hash_update_data_inputencoding.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `data` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

使用给定的 `data` 更新哈希内容，其编码在 `inputEncoding` 中给出。 如果未提供 `encoding`，且 `data` 是字符串，则强制为 `'utf8'` 编码。 如果 `data` 是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`，则忽略 `inputEncoding`。

这可以在流式传输时使用新数据多次调用。

### `Hmac` 类[#](http://nodejs.cn/api-v12/crypto.html#class-hmac)

[中英对照](http://nodejs.cn/api-v12/crypto/class_hmac.html)

新增于: v0.1.94

-   继承自: [<stream.Transform>](http://nodejs.cn/api/stream.html#class-streamtransform)

`Hmac` 类是用于创建加密 HMAC 摘要的实用工具。 它可以通过以下两种方式之一使用：

-   作为既可读又可写的[流](http://nodejs.cn/api-v12/stream.html)，其中写入数据以在可读端生成计算的 HMAC 摘要，或
-   使用 [`hmac.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_hmac_update_data_inputencoding) 和 [`hmac.digest()`](http://nodejs.cn/api-v12/crypto.html#crypto_hmac_digest_encoding) 方法生成计算出的 HMAC 摘要。

[`crypto.createHmac()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createhmac_algorithm_key_options) 方法用于创建 `Hmac` 实例。 `Hmac` 对象不能直接使用 `new` 关键字创建。

示例：使用 `Hmac` 对象作为流：

```
const crypto = require('crypto');
const hmac = crypto.createHmac('sha256', 'a secret');

hmac.on('readable', () => {
  // 哈希流只生成
  // 一个元素。
  const data = hmac.read();
  if (data) {
    console.log(data.toString('hex'));
    // 打印:
    //   7fd04df92f636fd450bc841c9418e5825c17f33ad9c87c518115a45971f7f77e
  }
});

hmac.write('some data to hash');
hmac.end();
```

示例：使用 `Hmac` 和管道流：

```
const crypto = require('crypto');
const fs = require('fs');
const hmac = crypto.createHmac('sha256', 'a secret');

const input = fs.createReadStream('test.js');
input.pipe(hmac).pipe(process.stdout);
```

示例：使用 [`hmac.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_hmac_update_data_inputencoding) 和 [`hmac.digest()`](http://nodejs.cn/api-v12/crypto.html#crypto_hmac_digest_encoding) 方法：

```
const crypto = require('crypto');
const hmac = crypto.createHmac('sha256', 'a secret');

hmac.update('some data to hash');
console.log(hmac.digest('hex'));
// 打印:
//   7fd04df92f636fd450bc841c9418e5825c17f33ad9c87c518115a45971f7f77e
```

#### `hmac.digest([encoding])`[#](http://nodejs.cn/api-v12/crypto.html#hmacdigestencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/hmac_digest_encoding.html)

新增于: v0.1.94

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

计算使用 [`hmac.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_hmac_update_data_inputencoding) 传入的所有数据的 HMAC 摘要。 如果提供了 `encoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)；

`Hmac` 对象在 `hmac.digest()` 被调用后不能再次使用。 多次调用 `hmac.digest()` 将导致抛出错误。

#### `hmac.update(data[, inputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#hmacupdatedata-inputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/hmac_update_data_inputencoding.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `data` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

使用给定的 `data` 更新 `Hmac` 内容，其编码在 `inputEncoding` 中给出。 如果未提供 `encoding`，且 `data` 是字符串，则强制为 `'utf8'` 编码。 如果 `data` 是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`，则忽略 `inputEncoding`。

这可以在流式传输时使用新数据多次调用。

### `KeyObject` 类[#](http://nodejs.cn/api-v12/crypto.html#class-keyobject)

[中英对照](http://nodejs.cn/api-v12/crypto/class_keyobject.html)

Node.js 使用 `KeyObject` 类来表示对称或非对称密钥，每种密钥暴露不同的功能。 [`crypto.createSecretKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createsecretkey_key)、[`crypto.createPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createpublickey_key) 和 [`crypto.createPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createprivatekey_key) 方法用于创建 `KeyObject` 实例。 `KeyObject` 对象不能直接使用 `new` 关键字创建。

由于改进的安全功能，大多数应用程序应该考虑使用新的 `KeyObject` API 而不是将密钥作为字符串或 `Buffer` 传入。

`KeyObject` 实例可以通过 [`postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_port_postmessage_value_transferlist) 传给其他线程。 接收者获得克隆的 `KeyObject`，`KeyObject` 不需要在 `transferList` 参数中列出。

#### `keyObject.asymmetricKeyType`[#](http://nodejs.cn/api-v12/crypto.html#keyobjectasymmetrickeytype)

[中英对照](http://nodejs.cn/api-v12/crypto/keyobject_asymmetrickeytype.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

对于非对称密钥，此属性表示密钥的类型。 支持的密钥类型有：

-   `'rsa'` (OID 1.2.840.113549.1.1.1)
-   `'rsa-pss'` (OID 1.2.840.113549.1.1.10)
-   `'dsa'` (OID 1.2.840.10040.4.1)
-   `'ec'` (OID 1.2.840.10045.2.1)
-   `'x25519'` (OID 1.3.101.110)
-   `'x448'` (OID 1.3.101.111)
-   `'ed25519'` (OID 1.3.101.112)
-   `'ed448'` (OID 1.3.101.113)
-   `'dh'` (OID 1.2.840.113549.1.3.1)

对于无法识别的 `KeyObject` 类型和对称密钥，此属性为 `undefined`。

#### `keyObject.export([options])`[#](http://nodejs.cn/api-v12/crypto.html#keyobjectexportoptions)

[中英对照](http://nodejs.cn/api-v12/crypto/keyobject_export_options.html)

新增于: v11.6.0

-   `options`: [<Object>](http://url.nodejs.cn/jzn6Ao)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

对于对称密钥，此函数分配一个包含密钥材料的 `Buffer` 并忽略任何选项。

对于非对称密钥，`options` 参数用于确定导出格式。

对于公钥，可以使用以下编码选项：

-   `type`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pkcs1'`（仅限 RSA）或 `'spki'` 之一。
-   `format`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pem'` 或 `'der'`。

对于私钥，可以使用以下编码选项：

-   `type`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pkcs1'`（仅限 RSA）、`'pkcs8'` 或 `'sec1'`（仅限 EC）之一。
-   `format`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pem'` 或 `'der'`。
-   `cipher`: [<string>](http://url.nodejs.cn/9Tw2bK) 如果指定，则私钥将使用给定的 `cipher` 和 `passphrase` 使用基于 PKCS#5 v2.0 密码的加密进行加密。
-   `passphrase`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 用于加密的密码，参见 `cipher`。

选择 PEM 编码时，结果将是字符串，否则它将是包含编码为 DER 的数据的缓冲区。

PKCS#1、SEC1 和 PKCS#8 类型的密钥可以通过使用 `cipher` 和 `format` 选项的组合进行加密。 PKCS#8 `type` 可以与任何 `format` 一起使用，通过指定 `cipher` 来加密任何密钥算法（RSA、EC 或 DH）。 当使用 PEM `format` 时，PKCS#1 和 SEC1 只能通过指定 `cipher` 来加密。 为了获得最大的兼容性，对加密的私钥使用 PKCS#8。 由于 PKCS#8 定义了自己的加密机制，因此在加密 PKCS#8 密钥时不支持 PEM 级加密。 PKCS#8 加密参见 [RFC 5208](http://url.nodejs.cn/2NHVsz)，PKCS#1 和 SEC1 加密参见 [RFC 1421](http://url.nodejs.cn/DreNtw)。

#### `keyObject.symmetricKeySize`[#](http://nodejs.cn/api-v12/crypto.html#keyobjectsymmetrickeysize)

[中英对照](http://nodejs.cn/api-v12/crypto/keyobject_symmetrickeysize.html)

新增于: v11.6.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

对于秘密密钥，此属性表示密钥的大小（以字节为单位）。 对于非对称密钥，此属性为 `undefined`。

#### `keyObject.type`[#](http://nodejs.cn/api-v12/crypto.html#keyobjecttype)

[中英对照](http://nodejs.cn/api-v12/crypto/keyobject_type.html)

新增于: v11.6.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

根据此 `KeyObject` 的类型，此属性是 `'secret'` 表示秘密（对称）密钥，`'public'` 表示公共（非对称）密钥或 `'private'` 表示私有（非对称）密钥。

### `Sign` 类[#](http://nodejs.cn/api-v12/crypto.html#class-sign)

[中英对照](http://nodejs.cn/api-v12/crypto/class_sign.html)

新增于: v0.1.92

-   继承自: [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)

`Sign` 类是用于生成签名的实用工具。 它可以通过以下两种方式之一使用：

-   作为可写[流](http://nodejs.cn/api-v12/stream.html)，写入要签名的数据，使用 [`sign.sign()`](http://nodejs.cn/api-v12/crypto.html#crypto_sign_sign_privatekey_outputencoding) 方法生成并返回签名，或者
-   使用 [`sign.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_sign_update_data_inputencoding) 和 [`sign.sign()`](http://nodejs.cn/api-v12/crypto.html#crypto_sign_sign_privatekey_outputencoding) 方法生成签名。

[`crypto.createSign()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createsign_algorithm_options) 方法用于创建 `Sign` 实例。 参数是要使用的哈希函数的字符串名称。 `Sign` 对象不能直接使用 `new` 关键字创建。

示例：使用 `Sign` 和 [`Verify`](http://nodejs.cn/api-v12/crypto.html#crypto_class_verify) 对象作为流：

```
const crypto = require('crypto');

const { privateKey, publicKey } = crypto.generateKeyPairSync('ec', {
  namedCurve: 'sect239k1'
});

const sign = crypto.createSign('SHA256');
sign.write('some data to sign');
sign.end();
const signature = sign.sign(privateKey, 'hex');

const verify = crypto.createVerify('SHA256');
verify.write('some data to sign');
verify.end();
console.log(verify.verify(publicKey, signature, 'hex'));
// 打印: true
```

示例：使用 [`sign.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_sign_update_data_inputencoding) 和 [`verify.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_verify_update_data_inputencoding) 方法：

```
const crypto = require('crypto');

const { privateKey, publicKey } = crypto.generateKeyPairSync('rsa', {
  modulusLength: 2048,
});

const sign = crypto.createSign('SHA256');
sign.update('some data to sign');
sign.end();
const signature = sign.sign(privateKey);

const verify = crypto.createVerify('SHA256');
verify.update('some data to sign');
verify.end();
console.log(verify.verify(publicKey, signature));
// 打印: true
```

#### `sign.sign(privateKey[, outputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#signsignprivatekey-outputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/sign_sign_privatekey_outputencoding.html)

-   `privateKey` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `dsaEncoding` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `padding` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `saltLength` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `outputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 返回值的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

使用 [`sign.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_sign_update_data_inputencoding) 或 [`sign.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 计算通过的所有数据的签名。

如果 `privateKey` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `privateKey` 传给 [`crypto.createPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createprivatekey_key) 一样。 如果是对象，则可以传入以下额外属性：

-   `dsaEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 对于 DSA 和 ECDSA，此选项指定生成签名的格式。 它可以是以下之一：
    
    -   `'der'`（默认）：DER 编码的 ASN.1 签名结构编码 `(r, s)`。
    -   `'ieee-p1363'`: IEEE-P1363 中提议的签名格式 `r || s`。
-   `padding` [<integer>](http://url.nodejs.cn/SXbo1v) RSA 的可选填充值，以下之一：
    
    -   `crypto.constants.RSA_PKCS1_PADDING`（默认）
    -   `crypto.constants.RSA_PKCS1_PSS_PADDING`
    
    `RSA_PKCS1_PSS_PADDING` 将使用具有与 [RFC 4055](http://url.nodejs.cn/o3Gr5v) 的第 3.1 章节中指定的消息签名相同的散列函数的 MGF1，除非 MGF1 散列函数已被指定为符合 [RFC 4055](http://url.nodejs.cn/o3Gr5v) 的第 3.3 章节的密钥的一部分。
    
-   `saltLength` [<integer>](http://url.nodejs.cn/SXbo1v) 填充为 `RSA_PKCS1_PSS_PADDING` 时的盐长度。 特殊值 `crypto.constants.RSA_PSS_SALTLEN_DIGEST` 将盐长度设置为摘要大小，`crypto.constants.RSA_PSS_SALTLEN_MAX_SIGN`（默认值）将其设置为最大允许值。
    

如果提供了 `outputEncoding`，则返回字符串；否则返回 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

`Sign` 对象在调用 `sign.sign()` 方法后不能再次使用。 多次调用 `sign.sign()` 将导致抛出错误。

#### `sign.update(data[, inputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#signupdatedata-inputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/sign_update_data_inputencoding.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `data` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

使用给定的 `data` 更新 `Sign` 内容，其编码在 `inputEncoding` 中给出。 如果未提供 `encoding`，且 `data` 是字符串，则强制为 `'utf8'` 编码。 如果 `data` 是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`，则忽略 `inputEncoding`。

这可以在流式传输时使用新数据多次调用。

### `Verify` 类[#](http://nodejs.cn/api-v12/crypto.html#class-verify)

[中英对照](http://nodejs.cn/api-v12/crypto/class_verify.html)

新增于: v0.1.92

-   继承自: [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)

`Verify` 类是用于验证签名的实用工具。 它可以通过以下两种方式之一使用：

-   作为可写[流](http://nodejs.cn/api-v12/stream.html)，其中写入的数据用于根据提供的签名进行验证，或者
-   使用 [`verify.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_verify_update_data_inputencoding) 和 [`verify.verify()`](http://nodejs.cn/api-v12/crypto.html#crypto_verify_verify_object_signature_signatureencoding) 方法来验证签名。

[`crypto.createVerify()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createverify_algorithm_options) 方法用于创建 `Verify` 实例。 `Verify` 对象不能直接使用 `new` 关键字创建。

有关示例，请参见 [`Sign`](http://nodejs.cn/api-v12/crypto.html#crypto_class_sign)。

#### `verify.update(data[, inputEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#verifyupdatedata-inputencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/verify_update_data_inputencoding.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `inputEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `data` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。

使用给定的 `data` 更新 `Verify` 内容，其编码在 `inputEncoding` 中给出。 如果未提供 `inputEncoding`，且 `data` 是字符串，则强制为 `'utf8'` 编码。 如果 `data` 是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`，则忽略 `inputEncoding`。

这可以在流式传输时使用新数据多次调用。

#### `verify.verify(object, signature[, signatureEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#verifyverifyobject-signature-signatureencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/verify_verify_object_signature_signatureencoding.html)

-   `object` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `dsaEncoding` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `padding` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `saltLength` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `signature` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `signatureEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `signature` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) `true` 或 `false` 取决于数据和公钥签名的有效性。

使用给定的 `object` 和 `signature` 验证提供的数据。

如果 `object` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `object` 传给 [`crypto.createPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createpublickey_key) 一样。 如果是对象，则可以传入以下额外属性：

-   `dsaEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 对于 DSA 和 ECDSA，此选项指定生成签名的格式。 它可以是以下之一：
    
    -   `'der'`（默认）：DER 编码的 ASN.1 签名结构编码 `(r, s)`。
    -   `'ieee-p1363'`: IEEE-P1363 中提议的签名格式 `r || s`。
-   `padding` [<integer>](http://url.nodejs.cn/SXbo1v) RSA 的可选填充值，以下之一：
    
    -   `crypto.constants.RSA_PKCS1_PADDING`（默认）
    -   `crypto.constants.RSA_PKCS1_PSS_PADDING`
    
    `RSA_PKCS1_PSS_PADDING` 将使用具有相同散列函数的 MGF1，用于验证 [RFC 4055](http://url.nodejs.cn/o3Gr5v) 的第 3.1 章节中指定的消息，除非 MGF1 散列函数已被指定为符合 [RFC 4055](http://url.nodejs.cn/o3Gr5v) 的第 3.3 章节的密钥的一部分。
    
-   `saltLength` [<integer>](http://url.nodejs.cn/SXbo1v) 填充为 `RSA_PKCS1_PSS_PADDING` 时的盐长度。 特殊值 `crypto.constants.RSA_PSS_SALTLEN_DIGEST` 将盐长度设置为摘要大小，`crypto.constants.RSA_PSS_SALTLEN_AUTO`（默认值）使其自动确定。
    

`signature` 参数是先前计算的数据签名，在 `signatureEncoding` 中。 如果指定了 `signatureEncoding`，则 `signature` 应该是字符串； 否则 `signature` 应该是 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

`verify` 对象在 `verify.verify()` 被调用后不能再次使用。 多次调用 `verify.verify()` 将导致抛出错误。

因为公钥可以从私钥导出，所以可以传递私钥而不是公钥。

### 加密模块的方法和属性[#](http://nodejs.cn/api-v12/crypto.html#crypto-module-methods-and-properties)

#### `crypto.constants`[#](http://nodejs.cn/api-v12/crypto.html#cryptoconstants)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_constants.html)

新增于: v6.3.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao) 包含用于加密和安全相关操作的常用常量的对象。 当前定义的特定常量在[加密常量](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_constants_1)中进行了描述。

#### `crypto.DEFAULT_ENCODING`[#](http://nodejs.cn/api-v12/crypto.html#cryptodefault_encoding)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_default_encoding.html)

新增于: v0.9.3弃用于: v10.0.0

用于可以采用字符串或[缓冲区](http://nodejs.cn/api-v12/buffer.html)的函数的默认编码。 默认值为 `'buffer'`，这使得方法默认为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 对象。

提供 `crypto.DEFAULT_ENCODING` 机制是为了与期望 `'latin1'` 作为默认编码的遗留程序向后兼容。

新应用程序应该期望默认值为 `'buffer'`。

此属性已弃用。

#### `crypto.fips`[#](http://nodejs.cn/api-v12/crypto.html#cryptofips)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_fips.html)

新增于: v6.0.0弃用于: v10.0.0

用于检查和控制当前是否正在使用符合 FIPS 的加密提供程序的属性。 设置为 true 需要 Node.js 的 FIPS 构建。

此属性已弃用。 请改用 `crypto.setFips()` 和 `crypto.getFips()`。

#### `crypto.createCipher(algorithm, password[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatecipheralgorithm-password-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createcipher_algorithm_password_options.html)

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `password` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
-   返回: [<Cipher>](http://nodejs.cn/api/crypto.html#class-cipher)

创建并返回使用给定 `algorithm` 和 `password` 的 `Cipher` 对象。

`options` 参数控制流的行为，并且是可选的，除非使用 CCM 或 OCB 模式的加密（例如 `'aes-128-ccm'`）。 在这种情况下，需要 `authTagLength` 选项并指定身份验证标签的长度（以字节为单位），请参阅 [CCM 模式](http://nodejs.cn/api-v12/crypto.html#crypto_ccm_mode)。 在 GCM 模式下，`authTagLength` 选项不是必需的，但可用于设置 `getAuthTag()` 将返回的身份验证标签的长度，默认为 16 字节。

`algorithm` 依赖于 OpenSSL，例如 `'aes192'` 等。 在 OpenSSL 的最新版本中，`openssl list -cipher-algorithms`（在 OpenSSL 的旧版本中为 `openssl list-cipher-algorithms`）将显示可用的加密算法。

`password` 用于派生密钥和初始化向量 (IV)。 该值必须是 `'latin1'` 编码的字符串、[`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

`crypto.createCipher()` 的实现使用 OpenSSL 函数 [`EVP_BytesToKey`](http://url.nodejs.cn/d3vRBX) 派生密钥，摘要算法设置为 MD5，一次迭代，不加盐。 缺少盐允许字典攻击，因为相同的密码总是创建相同的密钥。 低迭代次数和非加密安全散列算法允许非常快速地测试密码。

根据 OpenSSL 建议使用更现代的算法而不是 [`EVP_BytesToKey`](http://url.nodejs.cn/d3vRBX)，建议开发人员使用 [`crypto.scrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_scrypt_password_salt_keylen_options_callback) 自行派生密钥和 IV，并使用 [`crypto.createCipheriv()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createcipheriv_algorithm_key_iv_options) 创建 `Cipher` 对象。 用户不应在 `crypto.createCipher()` 中使用计数器模式（例如 CTR、GCM 或 CCM）的密码。 使用它们时会发出警告，以避免导致漏洞的 IV 重用风险。 对于在 GCM 中重用 IV 的情况，请参阅 [Nonce-Disrespecting Adversaries](http://url.nodejs.cn/i26CfC) 以获取详细信息。

#### `crypto.createCipheriv(algorithm, key, iv[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatecipherivalgorithm-key-iv-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createcipheriv_algorithm_key_iv_options.html)

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `key` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
-   `iv` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<null>](http://url.nodejs.cn/334hvC)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
-   返回: [<Cipher>](http://nodejs.cn/api/crypto.html#class-cipher)

使用给定的 `algorithm`、`key` 和初始化向量（`iv`）创建并返回 `Cipher` 对象。

`options` 参数控制流的行为，并且是可选的，除非使用 CCM 或 OCB 模式的加密（例如 `'aes-128-ccm'`）。 在这种情况下，需要 `authTagLength` 选项并指定身份验证标签的长度（以字节为单位），请参阅 [CCM 模式](http://nodejs.cn/api-v12/crypto.html#crypto_ccm_mode)。 在 GCM 模式下，`authTagLength` 选项不是必需的，但可用于设置 `getAuthTag()` 将返回的身份验证标签的长度，默认为 16 字节。

`algorithm` 依赖于 OpenSSL，例如 `'aes192'` 等。 在 OpenSSL 的最新版本中，`openssl list -cipher-algorithms`（在 OpenSSL 的旧版本中为 `openssl list-cipher-algorithms`）将显示可用的加密算法。

`key` 是 `algorithm` 使用的原始密钥，`iv` 是[初始化向量](http://url.nodejs.cn/mMnDDL)。 两个参数都必须是 `'utf8'` 编码的字符串、[缓冲区](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。 `key` 可以是 `secret` 类型的 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)。 如果加密不需要初始化向量，则 `iv` 可以是 `null`。

初始化向量应该是不可预测的和独特的；理想情况下，它们将是加密随机的。 它们不必是机密的：IV 通常不加密就添加到密文消息中。 必须是不可预测的和独特的，但不必是机密的，这听起来可能有些矛盾。请记住，一定不能让攻击者提前预测到给定的 IV。

#### `crypto.createDecipher(algorithm, password[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatedecipheralgorithm-password-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createdecipher_algorithm_password_options.html)

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `password` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
-   返回: [<Decipher>](http://nodejs.cn/api/crypto.html#class-decipher)

创建并返回使用给定的 `algorithm` 和 `password`（键）的 `Decipher` 对象。

`options` 参数控制流的行为，并且是可选的，除非使用 CCM 或 OCB 模式的加密（例如 `'aes-128-ccm'`）。 在这种情况下，需要 `authTagLength` 选项并指定身份验证标签的长度（以字节为单位），请参阅 [CCM 模式](http://nodejs.cn/api-v12/crypto.html#crypto_ccm_mode)。

`crypto.createDecipher()` 的实现使用 OpenSSL 函数 [`EVP_BytesToKey`](http://url.nodejs.cn/d3vRBX) 派生密钥，摘要算法设置为 MD5，一次迭代，不加盐。 缺少盐允许字典攻击，因为相同的密码总是创建相同的密钥。 低迭代次数和非加密安全散列算法允许非常快速地测试密码。

根据 OpenSSL 建议使用更现代的算法而不是 [`EVP_BytesToKey`](http://url.nodejs.cn/d3vRBX)，建议开发人员使用 [`crypto.scrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_scrypt_password_salt_keylen_options_callback) 自行派生密钥和 IV，并使用 [`crypto.createDecipheriv()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createdecipheriv_algorithm_key_iv_options) 创建 `Decipher` 对象。

#### `crypto.createDecipheriv(algorithm, key, iv[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatedecipherivalgorithm-key-iv-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createdecipheriv_algorithm_key_iv_options.html)

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `key` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
-   `iv` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<null>](http://url.nodejs.cn/334hvC)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
-   返回: [<Decipher>](http://nodejs.cn/api/crypto.html#class-decipher)

创建并返回使用给定的 `algorithm`、`key` 和初始化向量（`iv`）的 `Decipher` 对象。

`options` 参数控制流的行为，并且是可选的，除非使用 CCM 或 OCB 模式的加密（例如 `'aes-128-ccm'`）。 在这种情况下，需要 `authTagLength` 选项并指定身份验证标签的长度（以字节为单位），请参阅 [CCM 模式](http://nodejs.cn/api-v12/crypto.html#crypto_ccm_mode)。 在 GCM 模式下，`authTagLength` 选项不是必需的，但可用于将接受的身份验证标签限制为指定的长度。

`algorithm` 依赖于 OpenSSL，例如 `'aes192'` 等。 在 OpenSSL 的最新版本中，`openssl list -cipher-algorithms`（在 OpenSSL 的旧版本中为 `openssl list-cipher-algorithms`）将显示可用的加密算法。

`key` 是 `algorithm` 使用的原始密钥，`iv` 是[初始化向量](http://url.nodejs.cn/mMnDDL)。 两个参数都必须是 `'utf8'` 编码的字符串、[缓冲区](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。 `key` 可以是 `secret` 类型的 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)。 如果加密不需要初始化向量，则 `iv` 可以是 `null`。

初始化向量应该是不可预测的和独特的；理想情况下，它们将是加密随机的。 它们不必是机密的：IV 通常不加密就添加到密文消息中。 必须是不可预测的和独特的，但不必是机密的，这听起来可能有些矛盾。请记住，一定不能让攻击者提前预测到给定的 IV。

#### `crypto.createDiffieHellman(prime[, primeEncoding][, generator][, generatorEncoding])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatediffiehellmanprime-primeencoding-generator-generatorencoding)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_creatediffiehellman_prime_primeencoding_generator_generatorencoding.html)

-   `prime` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `primeEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `prime` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   `generator` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) **默认值:** `2`
-   `generatorEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) `generator` 字符串的[编码](http://nodejs.cn/api-v12/buffer.html#buffer_buffers_and_character_encodings)。
-   返回: [<DiffieHellman>](http://nodejs.cn/api/crypto.html#class-diffiehellman)

使用提供的 `prime` 和可选的特定 `generator` 创建 `DiffieHellman` 密钥交换对象。

`generator` 参数可以是数字、字符串或 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。 如果未指定 `generator`，则使用值 `2`。

如果指定了 `primeEncoding`，则 `prime` 应该是字符串；否则应为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

如果指定了 `generatorEncoding`，则 `generator` 应该是字符串；否则应为数字 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)、`TypedArray` 或 `DataView`。

#### `crypto.createDiffieHellman(primeLength[, generator])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatediffiehellmanprimelength-generator)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_creatediffiehellman_primelength_generator.html)

新增于: v0.5.0

-   `primeLength` [<number>](http://url.nodejs.cn/SXbo1v)
-   `generator` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `2`
-   返回: [<DiffieHellman>](http://nodejs.cn/api/crypto.html#class-diffiehellman)

创建 `DiffieHellman` 密钥交换对象并使用可选的特定数字 `generator` 生成 `primeLength` 位的质数。 如果未指定 `generator`，则使用值 `2`。

#### `crypto.createDiffieHellmanGroup(name)`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatediffiehellmangroupname)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_creatediffiehellmangroup_name.html)

新增于: v0.9.3

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<DiffieHellmanGroup>](http://nodejs.cn/api/crypto.html#class-diffiehellmangroup)

[`crypto.getDiffieHellman()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_getdiffiehellman_groupname) 的别名

#### `crypto.createECDH(curveName)`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreateecdhcurvename)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createecdh_curvename.html)

新增于: v0.11.14

-   `curveName` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<ECDH>](http://nodejs.cn/api/crypto.html#class-ecdh)

使用 `curveName` 字符串指定的预定义曲线创建椭圆曲线 Diffie-Hellman (`ECDH`) 密钥交换对象。 使用 [`crypto.getCurves()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_getcurves) 获取可用曲线名称的列表。 在最近的 OpenSSL 版本中，`openssl ecparam -list_curves` 还将显示每个可用椭圆曲线的名称和描述。

#### `crypto.createHash(algorithm[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatehashalgorithm-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createhash_algorithm_options.html)

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
-   返回: [<Hash>](http://nodejs.cn/api/crypto.html#class-hash)

创建并返回 `Hash` 对象，该对象可用于使用给定的 `algorithm` 生成哈希摘要。 可选的 `options` 参数控制流的行为。 对于 XOF 哈希函数（例如 `'shake256'`），可以使用 `outputLength` 选项指定所需的输出长度（以字节为单位）。

`algorithm` 取决于平台上 OpenSSL 版本支持的可用算法。 例如 `'sha256'`、`'sha512'` 等。 在 OpenSSL 的最新版本中，`openssl list -digest-algorithms`（在 OpenSSL 的旧版本中为 `openssl list-message-digest-algorithms`）将显示可用的摘要算法。

示例：生成文件的 sha256 总和

```
const filename = process.argv[2];
const crypto = require('crypto');
const fs = require('fs');

const hash = crypto.createHash('sha256');

const input = fs.createReadStream(filename);
input.on('readable', () => {
  // 哈希流只生成
  // 一个元素。
  const data = input.read();
  if (data)
    hash.update(data);
  else {
    console.log(`${hash.digest('hex')} ${filename}`);
  }
});
```

#### `crypto.createHmac(algorithm, key[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatehmacalgorithm-key-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createhmac_algorithm_key_options.html)

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `key` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.transform` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_transform_options)
-   返回: [<Hmac>](http://nodejs.cn/api/crypto.html#class-hmac)

创建并返回使用给定的 `algorithm` 和 `key` 的 `Hmac` 对象。 可选的 `options` 参数控制流的行为。

`algorithm` 取决于平台上 OpenSSL 版本支持的可用算法。 例如 `'sha256'`、`'sha512'` 等。 在 OpenSSL 的最新版本中，`openssl list -digest-algorithms`（在 OpenSSL 的旧版本中为 `openssl list-message-digest-algorithms`）将显示可用的摘要算法。

`key` 是用于生成加密 HMAC 哈希的 HMAC 密钥。 如果是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则其类型必须是 `secret`。

示例：生成文件的 sha256 HMAC

```
const filename = process.argv[2];
const crypto = require('crypto');
const fs = require('fs');

const hmac = crypto.createHmac('sha256', 'a secret');

const input = fs.createReadStream(filename);
input.on('readable', () => {
  // 哈希流只生成
  // 一个元素。
  const data = input.read();
  if (data)
    hmac.update(data);
  else {
    console.log(`${hmac.digest('hex')} ${filename}`);
  }
});
```

#### `crypto.createPrivateKey(key)`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreateprivatekeykey)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createprivatekey_key.html)

新增于: v11.6.0

-   `key` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
    -   `key`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 密钥材料，采用 PEM 或 DER 格式。
    -   `format`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pem'` 或 `'der'`。 **默认值:** `'pem'`。
    -   `type`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pkcs1'`、`'pkcs8'` 或 `'sec1'`。 仅当 `format` 为 `'der'` 时才需要此选项，否则将被忽略。
    -   `passphrase`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 用于解密的密码。
-   返回: [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)

创建并返回包含私钥的新密钥对象。 如果 `key` 是字符串或 `Buffer`，则假定 `format` 是 `'pem'`；否则，`key` 必须是具有上述属性的对象。

如果私钥被加密，则必须指定 `passphrase`。 密码的长度限制为 1024 字节。

#### `crypto.createPublicKey(key)`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatepublickeykey)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createpublickey_key.html)

-   `key` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `key`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
    -   `format`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pem'` 或 `'der'`。 **默认值:** `'pem'`。
    -   `type`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'pkcs1'` 或 `'spki'`。 仅当 `format` 为 `'der'` 时才需要此选项。
-   返回: [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)

创建并返回包含公钥的新密钥对象。 如果 `key` 是字符串或 `Buffer`，则假定 `format` 是 `'pem'`； 如果 `key` 是类型为 `'private'` 的 `KeyObject`，则公钥来自给定的私钥； 否则，`key` 必须是具有上述属性的对象。

如果格式为 `'pem'`，则 `'key'` 也可能是 X.509 证书。

因为公钥可以从私钥导出，所以可以传递私钥而不是公钥。 在这种情况下，此函数的行为就像 [`crypto.createPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createprivatekey_key) 已被调用，除了返回的 `KeyObject` 的类型将为 `'public'` 并且无法从返回的 `KeyObject` 中提取私钥。 同样，如果给定了类型为 `'private'` 的 `KeyObject`，则新的类型为 `'public'` 的 `KeyObject` 将被返回，并且无法从返回的对象中提取私钥。

#### `crypto.createSecretKey(key)`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatesecretkeykey)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createsecretkey_key.html)

新增于: v11.6.0

-   `key` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   返回: [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)

创建并返回新的密钥对象，其中包含用于对称加密或 `Hmac` 的密钥。

#### `crypto.createSign(algorithm[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreatesignalgorithm-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createsign_algorithm_options.html)

新增于: v0.1.92

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.Writable` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_writable_options)
-   返回: [<Sign>](http://nodejs.cn/api/crypto.html#class-sign)

创建并返回使用给定的 `algorithm` 的 `Sign` 对象。 使用 [`crypto.getHashes()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_gethashes) 获取可用摘要算法的名称。 可选的 `options` 参数控制 `stream.Writable` 行为。

在某些情况下，可以使用签名算法的名称（例如 `'RSA-SHA256'`）而不是摘要算法来创建 `Sign` 实例。 这将使用相应的摘要算法。 这不适用于所有签名算法，例如 `'ecdsa-with-SHA256'`，因此最好始终使用摘要算法名称。

#### `crypto.createVerify(algorithm[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptocreateverifyalgorithm-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_createverify_algorithm_options.html)

新增于: v0.1.92

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) [`stream.Writable` 选项](http://nodejs.cn/api-v12/stream.html#stream_new_stream_writable_options)
-   返回: [<Verify>](http://nodejs.cn/api/crypto.html#class-verify)

创建并返回使用给定算法的 `Verify` 对象。 使用 [`crypto.getHashes()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_gethashes) 获取可用签名算法的名称数组。 可选的 `options` 参数控制 `stream.Writable` 行为。

在某些情况下，可以使用签名算法的名称（例如 `'RSA-SHA256'`）而不是摘要算法来创建 `Verify` 实例。 这将使用相应的摘要算法。 这不适用于所有签名算法，例如 `'ecdsa-with-SHA256'`，因此最好始终使用摘要算法名称。

#### `crypto.diffieHellman(options)`[#](http://nodejs.cn/api-v12/crypto.html#cryptodiffiehellmanoptions)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_diffiehellman_options.html)

新增于: v12.17.0

-   `options`: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `privateKey`: [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `publicKey`: [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

基于 `privateKey` 和 `publicKey` 计算 Diffie-Hellman 秘密。 两个密钥必须具有相同的 `asymmetricKeyType`，它必须是 `'dh'`（对于 Diffie-Hellman）、`'ec'`（对于 ECDH）、`'x448'` 或 `'x25519'`（对于 ECDH-ES）之一。

#### `crypto.generateKeyPair(type, options, callback)`[#](http://nodejs.cn/api-v12/crypto.html#cryptogeneratekeypairtype-options-callback)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_generatekeypair_type_options_callback.html)

-   `type`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'rsa'`、`'dsa'`、`'ec'`、`'ed25519'`、`'ed448'`、`'x25519'`、`'x448'` 或 `'dh'`。
-   `options`: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `modulusLength`: [<number>](http://url.nodejs.cn/SXbo1v) 以位为单位的密钥大小（RSA、DSA）。
    -   `publicExponent`: [<number>](http://url.nodejs.cn/SXbo1v) 公共指数 (RSA)。 **默认值:** `0x10001`。
    -   `divisorLength`: [<number>](http://url.nodejs.cn/SXbo1v) `q` 的比特大小 (DSA)。
    -   `namedCurve`: [<string>](http://url.nodejs.cn/9Tw2bK) 要使用的曲线名称 (EC)。
    -   `prime`: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 素数参数 (DH)。
    -   `primeLength`: [<number>](http://url.nodejs.cn/SXbo1v) 以比特为单位的质数长度 (DH)。
    -   `generator`: [<number>](http://url.nodejs.cn/SXbo1v) 自定义生成器 (DH)。 **默认值:** `2`。
    -   `groupName`: [<string>](http://url.nodejs.cn/9Tw2bK) Diffie-Hellman 组名 (DH)。 参见 [`crypto.getDiffieHellman()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_getdiffiehellman_groupname)。
    -   `publicKeyEncoding`: [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`keyObject.export()`](http://nodejs.cn/api-v12/crypto.html#crypto_keyobject_export_options)。
    -   `privateKeyEncoding`: [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`keyObject.export()`](http://nodejs.cn/api-v12/crypto.html#crypto_keyobject_export_options)。
-   `callback`: [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err`: [<Error>](http://url.nodejs.cn/qZ873x)
    -   `publicKey`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `privateKey`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)

生成给定 `type` 的新非对称密钥对。 目前支持 RSA、DSA、EC、Ed25519、Ed448、X25519、X448 和 DH。

如果指定了 `publicKeyEncoding` 或 `privateKeyEncoding`，则此函数的行为就像对其结果调用了 [`keyObject.export()`](http://nodejs.cn/api-v12/crypto.html#crypto_keyobject_export_options)。 否则，密钥的相应部分将作为 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject) 返回。

建议将公钥编码为 `'spki'`，私钥编码为 `'pkcs8'`，并加密以进行长期存储：

```
const { generateKeyPair } = require('crypto');
generateKeyPair('rsa', {
  modulusLength: 4096,
  publicKeyEncoding: {
    type: 'spki',
    format: 'pem'
  },
  privateKeyEncoding: {
    type: 'pkcs8',
    format: 'pem',
    cipher: 'aes-256-cbc',
    passphrase: 'top secret'
  }
}, (err, publicKey, privateKey) => {
  // 处理错误并使用生成的密钥对。
});
```

完成后，`callback` 将被调用，`err` 设置为 `undefined`，`publicKey` / `privateKey` 代表生成的密钥对。

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，则其将为具有 `publicKey` 和 `privateKey` 属性的 `Object` 返回 `Promise`。

#### `crypto.generateKeyPairSync(type, options)`[#](http://nodejs.cn/api-v12/crypto.html#cryptogeneratekeypairsynctype-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_generatekeypairsync_type_options.html)

-   `type`: [<string>](http://url.nodejs.cn/9Tw2bK) 必须是 `'rsa'`、`'dsa'`、`'ec'`、`'ed25519'`、`'ed448'`、`'x25519'`、`'x448'` 或 `'dh'`。
-   `options`: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `modulusLength`: [<number>](http://url.nodejs.cn/SXbo1v) 以位为单位的密钥大小（RSA、DSA）。
    -   `publicExponent`: [<number>](http://url.nodejs.cn/SXbo1v) 公共指数 (RSA)。 **默认值:** `0x10001`。
    -   `divisorLength`: [<number>](http://url.nodejs.cn/SXbo1v) `q` 的比特大小 (DSA)。
    -   `namedCurve`: [<string>](http://url.nodejs.cn/9Tw2bK) 要使用的曲线名称 (EC)。
    -   `prime`: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 素数参数 (DH)。
    -   `primeLength`: [<number>](http://url.nodejs.cn/SXbo1v) 以比特为单位的质数长度 (DH)。
    -   `generator`: [<number>](http://url.nodejs.cn/SXbo1v) 自定义生成器 (DH)。 **默认值:** `2`。
    -   `groupName`: [<string>](http://url.nodejs.cn/9Tw2bK) Diffie-Hellman 组名 (DH)。 参见 [`crypto.getDiffieHellman()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_getdiffiehellman_groupname)。
    -   `publicKeyEncoding`: [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`keyObject.export()`](http://nodejs.cn/api-v12/crypto.html#crypto_keyobject_export_options)。
    -   `privateKeyEncoding`: [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`keyObject.export()`](http://nodejs.cn/api-v12/crypto.html#crypto_keyobject_export_options)。
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `publicKey`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `privateKey`: [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)

生成给定 `type` 的新非对称密钥对。 目前支持 RSA、DSA、EC、Ed25519、Ed448、X25519、X448 和 DH。

如果指定了 `publicKeyEncoding` 或 `privateKeyEncoding`，则此函数的行为就像对其结果调用了 [`keyObject.export()`](http://nodejs.cn/api-v12/crypto.html#crypto_keyobject_export_options)。 否则，密钥的相应部分将作为 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject) 返回。

对公钥进行编码时，建议使用`'spki'`。 对私钥进行编码时，建议使用强密码的`'pkcs8'`，并对密码进行保密。

```
const { generateKeyPairSync } = require('crypto');
const { publicKey, privateKey } = generateKeyPairSync('rsa', {
  modulusLength: 4096,
  publicKeyEncoding: {
    type: 'spki',
    format: 'pem'
  },
  privateKeyEncoding: {
    type: 'pkcs8',
    format: 'pem',
    cipher: 'aes-256-cbc',
    passphrase: 'top secret'
  }
});
```

返回值 `{ publicKey, privateKey }` 表示生成的密钥对。 选择 PEM 编码时，相应的密钥将是字符串，否则它将是包含编码为 DER 的数据的缓冲区。

#### `crypto.getCiphers()`[#](http://nodejs.cn/api-v12/crypto.html#cryptogetciphers)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_getciphers.html)

新增于: v0.9.3

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 包含支持的密码算法名称的数组。

```
const ciphers = crypto.getCiphers();
console.log(ciphers); // ['aes-128-cbc', 'aes-128-ccm', ...]
```

#### `crypto.getCurves()`[#](http://nodejs.cn/api-v12/crypto.html#cryptogetcurves)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_getcurves.html)

新增于: v2.3.0

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 包含支持的椭圆曲线名称的数组。

```
const curves = crypto.getCurves();
console.log(curves); // ['Oakley-EC2N-3', 'Oakley-EC2N-4', ...]
```

#### `crypto.getDiffieHellman(groupName)`[#](http://nodejs.cn/api-v12/crypto.html#cryptogetdiffiehellmangroupname)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_getdiffiehellman_groupname.html)

新增于: v0.7.5

-   `groupName` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<DiffieHellmanGroup>](http://nodejs.cn/api/crypto.html#class-diffiehellmangroup)

创建预定义的 `DiffieHellmanGroup` 密钥交换对象。 支持的组是：`'modp1'`、`'modp2'`、`'modp5'`（在 [RFC 2412](http://url.nodejs.cn/6ouCbA) 中定义，但请参阅[注意事项](http://nodejs.cn/api-v12/crypto.html#crypto_support_for_weak_or_compromised_algorithms)）和 `'modp14'`、`'modp15'`、`'modp16'`、`'modp17'`、`'modp18'`（在 [RFC 3526](http://url.nodejs.cn/m8pGEe) 中定义）。 返回的对象模仿 [`crypto.createDiffieHellman()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_creatediffiehellman_prime_primeencoding_generator_generatorencoding) 创建的对象的接口，但不允许更改键（例如，使用 [`diffieHellman.setPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_diffiehellman_setpublickey_publickey_encoding)）。 使用这种方法的优点是双方不必事先生成或交换组模数，既节省了处理器时间又节省了通信时间。

示例（获取共享密钥）：

```
const crypto = require('crypto');
const alice = crypto.getDiffieHellman('modp14');
const bob = crypto.getDiffieHellman('modp14');

alice.generateKeys();
bob.generateKeys();

const aliceSecret = alice.computeSecret(bob.getPublicKey(), null, 'hex');
const bobSecret = bob.computeSecret(alice.getPublicKey(), null, 'hex');

/* aliceSecret 和 bobSecret 应该是一样的 */
console.log(aliceSecret === bobSecret);
```

#### `crypto.getFips()`[#](http://nodejs.cn/api-v12/crypto.html#cryptogetfips)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_getfips.html)

新增于: v10.0.0

-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 当且仅当当前使用符合 FIPS 的加密提供程序时为 `1`，否则为 `0`。 未来的语义化主版本可能会将此 API 的返回类型更改为 [<boolean>](http://url.nodejs.cn/jFbvuT)。

#### `crypto.getHashes()`[#](http://nodejs.cn/api-v12/crypto.html#cryptogethashes)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_gethashes.html)

新增于: v0.9.3

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 支持的哈希算法名称的数组，例如 `'RSA-SHA256'`。 哈希算法也称为"摘要"算法。

```
const hashes = crypto.getHashes();
console.log(hashes); // ['DSA', 'DSA-SHA', 'DSA-SHA1', ...]
```

#### `crypto.pbkdf2(password, salt, iterations, keylen, digest, callback)`[#](http://nodejs.cn/api-v12/crypto.html#cryptopbkdf2password-salt-iterations-keylen-digest-callback)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_pbkdf2_password_salt_iterations_keylen_digest_callback.html)

-   `password` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `salt` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `iterations` [<number>](http://url.nodejs.cn/SXbo1v)
-   `keylen` [<number>](http://url.nodejs.cn/SXbo1v)
-   `digest` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `derivedKey` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

提供异步基于密码的密钥派生函数 2 (PBKDF2) 实现。 应用由 `digest` 指定的选定 HMAC 摘要算法以从 `password`、`salt` 和 `iterations` 导出请求字节长度 (`keylen`) 的密钥。

提供的 `callback` 函数使用两个参数调用：`err` 和 `derivedKey`。 如果在派生密钥时发生错误，则设置 `err`；否则 `err` 将是 `null`。 默认情况下，成功生成的 `derivedKey` 将作为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 传给回调。 如果任何输入参数指定了无效的值或类型，则会抛出错误。

如果 `digest` 是 `null`，则将使用 `'sha1'`。 此行为已弃用，请显式指定 `digest`。

`iterations` 参数必须是尽可能高的数字。 迭代次数越多，派生密钥就越安全，但需要更长的时间才能完成。

`salt` 应该尽可能唯一。 建议盐是随机的，长度至少为 16 字节。 有关详细信息，请参阅 [NIST SP 800-132](http://url.nodejs.cn/DbTtwt)。

```
const crypto = require('crypto');
crypto.pbkdf2('secret', 'salt', 100000, 64, 'sha512', (err, derivedKey) => {
  if (err) throw err;
  console.log(derivedKey.toString('hex'));  // '3745e48...08d59ae'
});
```

`crypto.DEFAULT_ENCODING` 属性可用于更改 `derivedKey` 传给回调的方式。 但是，此属性已被弃用，应避免使用。

```
const crypto = require('crypto');
crypto.DEFAULT_ENCODING = 'hex';
crypto.pbkdf2('secret', 'salt', 100000, 512, 'sha512', (err, derivedKey) => {
  if (err) throw err;
  console.log(derivedKey);  // '3745e48...aa39b34'
});
```

可以使用 [`crypto.getHashes()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_gethashes) 检索支持的摘要函数数组。

此 API 使用 libuv 的线程池，这对某些应用程序可能会产生意外的负面性能影响；有关更多信息，请参阅 [`UV_THREADPOOL_SIZE`](http://nodejs.cn/api-v12/cli.html#cli_uv_threadpool_size_size) 文档。

#### `crypto.pbkdf2Sync(password, salt, iterations, keylen, digest)`[#](http://nodejs.cn/api-v12/crypto.html#cryptopbkdf2syncpassword-salt-iterations-keylen-digest)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_pbkdf2sync_password_salt_iterations_keylen_digest.html)

-   `password` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `salt` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `iterations` [<number>](http://url.nodejs.cn/SXbo1v)
-   `keylen` [<number>](http://url.nodejs.cn/SXbo1v)
-   `digest` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

提供同步的基于密码的密钥派生函数 2 (PBKDF2) 实现。 应用由 `digest` 指定的选定 HMAC 摘要算法以从 `password`、`salt` 和 `iterations` 导出请求字节长度 (`keylen`) 的密钥。

如果发生错误，将抛出 `Error`，否则派生密钥将作为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 返回。

如果 `digest` 是 `null`，则将使用 `'sha1'`。 此行为已弃用，请显式指定 `digest`。

`iterations` 参数必须是尽可能高的数字。 迭代次数越多，派生密钥就越安全，但需要更长的时间才能完成。

`salt` 应该尽可能唯一。 建议盐是随机的，长度至少为 16 字节。 有关详细信息，请参阅 [NIST SP 800-132](http://url.nodejs.cn/DbTtwt)。

```
const crypto = require('crypto');
const key = crypto.pbkdf2Sync('secret', 'salt', 100000, 64, 'sha512');
console.log(key.toString('hex'));  // '3745e48...08d59ae'
```

`crypto.DEFAULT_ENCODING` 属性可用于更改返回 `derivedKey` 的方式。 但是，此属性已被弃用，应避免使用。

```
const crypto = require('crypto');
crypto.DEFAULT_ENCODING = 'hex';
const key = crypto.pbkdf2Sync('secret', 'salt', 100000, 512, 'sha512');
console.log(key);  // '3745e48...aa39b34'
```

可以使用 [`crypto.getHashes()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_gethashes) 检索支持的摘要函数数组。

#### `crypto.privateDecrypt(privateKey, buffer)`[#](http://nodejs.cn/api-v12/crypto.html#cryptoprivatedecryptprivatekey-buffer)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_privatedecrypt_privatekey_buffer.html)

-   `privateKey` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `oaepHash` [<string>](http://url.nodejs.cn/9Tw2bK) 用于 OAEP 填充和 MGF1 的哈希函数。 **默认值:** `'sha1'`
    -   `oaepLabel` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 用于 OAEP 填充的标签。 如果未指定，则不使用标签。
    -   `padding` [<crypto.constants>](http://nodejs.cn/api/crypto.html#cryptoconstants) `crypto.constants` 中定义的可选填充值，可以是：`crypto.constants.RSA_NO_PADDING`、`crypto.constants.RSA_PKCS1_PADDING` 或 `crypto.constants.RSA_PKCS1_OAEP_PADDING`。
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 带有解密内容的新 `Buffer`。

用 `privateKey` 解密 `buffer`。 `buffer` 之前使用相应的公钥加密，例如使用 [`crypto.publicEncrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_publicencrypt_key_buffer)。

如果 `privateKey` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `privateKey` 传给 [`crypto.createPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createprivatekey_key) 一样。 如果是对象，则可以传入 `padding` 属性。 否则，该函数使用 `RSA_PKCS1_OAEP_PADDING`。

#### `crypto.privateEncrypt(privateKey, buffer)`[#](http://nodejs.cn/api-v12/crypto.html#cryptoprivateencryptprivatekey-buffer)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_privateencrypt_privatekey_buffer.html)

-   `privateKey` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `key` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject) PEM 编码的私钥。
    -   `passphrase` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 可选的私钥密码。
    -   `padding` [<crypto.constants>](http://nodejs.cn/api/crypto.html#cryptoconstants) `crypto.constants` 中定义的可选填充值，可以是：`crypto.constants.RSA_NO_PADDING` 或 `crypto.constants.RSA_PKCS1_PADDING`。
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 带有加密内容的新 `Buffer`。

用 `privateKey` 加密 `buffer`。 返回的数据可以使用相应的公钥解密，例如使用 [`crypto.publicDecrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_publicdecrypt_key_buffer)。

如果 `privateKey` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `privateKey` 传给 [`crypto.createPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createprivatekey_key) 一样。 如果是对象，则可以传入 `padding` 属性。 否则，该函数使用 `RSA_PKCS1_PADDING`。

#### `crypto.publicDecrypt(key, buffer)`[#](http://nodejs.cn/api-v12/crypto.html#cryptopublicdecryptkey-buffer)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_publicdecrypt_key_buffer.html)

-   `key` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `passphrase` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 可选的私钥密码。
    -   `padding` [<crypto.constants>](http://nodejs.cn/api/crypto.html#cryptoconstants) `crypto.constants` 中定义的可选填充值，可以是：`crypto.constants.RSA_NO_PADDING` 或 `crypto.constants.RSA_PKCS1_PADDING`。
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 带有解密内容的新 `Buffer`。

使用 `key`.`buffer` 解密 `buffer` 之前使用相应的私钥加密，例如使用 [`crypto.privateEncrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_privateencrypt_privatekey_buffer)。

如果 `key` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `key` 传给 [`crypto.createPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createpublickey_key) 一样。 如果是对象，则可以传入 `padding` 属性。 否则，该函数使用 `RSA_PKCS1_PADDING`。

由于 RSA 公钥可以从私钥派生，因此可以传入私钥而不是公钥。

#### `crypto.publicEncrypt(key, buffer)`[#](http://nodejs.cn/api-v12/crypto.html#cryptopublicencryptkey-buffer)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_publicencrypt_key_buffer.html)

-   `key` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
    -   `key` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject) PEM 编码的公钥或私钥。
    -   `oaepHash` [<string>](http://url.nodejs.cn/9Tw2bK) 用于 OAEP 填充和 MGF1 的哈希函数。 **默认值:** `'sha1'`
    -   `oaepLabel` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 用于 OAEP 填充的标签。 如果未指定，则不使用标签。
    -   `passphrase` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 可选的私钥密码。
    -   `padding` [<crypto.constants>](http://nodejs.cn/api/crypto.html#cryptoconstants) `crypto.constants` 中定义的可选填充值，可以是：`crypto.constants.RSA_NO_PADDING`、`crypto.constants.RSA_PKCS1_PADDING` 或 `crypto.constants.RSA_PKCS1_OAEP_PADDING`。
-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 带有加密内容的新 `Buffer`。

用 `key` 加密 `buffer` 的内容，并返回带有加密内容的新 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。 返回的数据可以使用相应的私钥解密，例如使用 [`crypto.privateDecrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_privatedecrypt_privatekey_buffer)。

如果 `key` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `key` 传给 [`crypto.createPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createpublickey_key) 一样。 如果是对象，则可以传入 `padding` 属性。 否则，该函数使用 `RSA_PKCS1_OAEP_PADDING`。

由于 RSA 公钥可以从私钥派生，因此可以传入私钥而不是公钥。

#### `crypto.randomBytes(size[, callback])`[#](http://nodejs.cn/api-v12/crypto.html#cryptorandombytessize-callback)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_randombytes_size_callback.html)

-   `size` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `buf` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 如果未提供 `callback` 函数。

生成加密强伪随机数据。 `size` 参数是数字，指示要生成的字节数。

如果提供了 `callback` 函数，则异步生成字节，并使用两个参数调用 `callback` 函数：`err` 和 `buf`。 如果发生错误，则 `err` 将是 `Error` 对象；否则就是 `null`。 `buf` 参数是包含生成字节的 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。

```
// 异步的
const crypto = require('crypto');
crypto.randomBytes(256, (err, buf) => {
  if (err) throw err;
  console.log(`${buf.length} bytes of random data: ${buf.toString('hex')}`);
});
```

如果未提供 `callback` 函数，则同步生成随机字节并作为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 返回。 如果生成字节出现问题，则会抛出错误。

```
// 同步的
const buf = crypto.randomBytes(256);
console.log(
  `${buf.length} bytes of random data: ${buf.toString('hex')}`);
```

`crypto.randomBytes()` 方法将不会完成，直到有足够的可用熵。 这通常不会超过几毫秒。 可以想象，生成随机字节的唯一时间可能会阻塞更长的时间是在启动之后，此时整个系统的熵仍然很低。

此 API 使用 libuv 的线程池，这对某些应用程序可能会产生意外的负面性能影响；有关更多信息，请参阅 [`UV_THREADPOOL_SIZE`](http://nodejs.cn/api-v12/cli.html#cli_uv_threadpool_size_size) 文档。

`crypto.randomBytes()` 的异步版本是在单个线程池请求中执行的。 为了最大限度地减少线程池任务长度变化，在执行客户端请求时将大型 `randomBytes` 请求分区。

#### `crypto.randomFillSync(buffer[, offset][, size])`[#](http://nodejs.cn/api-v12/crypto.html#cryptorandomfillsyncbuffer-offset-size)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_randomfillsync_buffer_offset_size.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 必须提供。
-   `offset` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
-   `size` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `buffer.length - offset`
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 对象作为 `buffer` 参数传入。

[`crypto.randomFill()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_randomfill_buffer_offset_size_callback) 的同步版本。

```
const buf = Buffer.alloc(10);
console.log(crypto.randomFillSync(buf).toString('hex'));

crypto.randomFillSync(buf, 5);
console.log(buf.toString('hex'));

// 以上等价于以下内容：
crypto.randomFillSync(buf, 5, 5);
console.log(buf.toString('hex'));
```

任何 `TypedArray` 或 `DataView` 实例都可以作为 `buffer` 传入。

```
const a = new Uint32Array(10);
console.log(Buffer.from(crypto.randomFillSync(a).buffer,
                        a.byteOffset, a.byteLength).toString('hex'));

const b = new Float64Array(10);
console.log(Buffer.from(crypto.randomFillSync(b).buffer,
                        b.byteOffset, b.byteLength).toString('hex'));

const c = new DataView(new ArrayBuffer(10));
console.log(Buffer.from(crypto.randomFillSync(c).buffer,
                        c.byteOffset, c.byteLength).toString('hex'));
```

#### `crypto.randomFill(buffer[, offset][, size], callback)`[#](http://nodejs.cn/api-v12/crypto.html#cryptorandomfillbuffer-offset-size-callback)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_randomfill_buffer_offset_size_callback.html)

-   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 必须提供。
-   `offset` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
-   `size` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `buffer.length - offset`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) `function(err, buf) {}`.

此函数类似于 [`crypto.randomBytes()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_randombytes_size_callback)，但要求第一个参数是将被填充的 [`Buffer`](http://nodejs.cn/api-v12/buffer.html)。 它还要求传入回调。

如果未提供 `callback` 函数，则会抛出错误。

```
const buf = Buffer.alloc(10);
crypto.randomFill(buf, (err, buf) => {
  if (err) throw err;
  console.log(buf.toString('hex'));
});

crypto.randomFill(buf, 5, (err, buf) => {
  if (err) throw err;
  console.log(buf.toString('hex'));
});

// 以上等价于以下内容：
crypto.randomFill(buf, 5, 5, (err, buf) => {
  if (err) throw err;
  console.log(buf.toString('hex'));
});
```

任何 `TypedArray` 或 `DataView` 实例都可以作为 `buffer` 传入。

```
const a = new Uint32Array(10);
crypto.randomFill(a, (err, buf) => {
  if (err) throw err;
  console.log(Buffer.from(buf.buffer, buf.byteOffset, buf.byteLength)
    .toString('hex'));
});

const b = new Float64Array(10);
crypto.randomFill(b, (err, buf) => {
  if (err) throw err;
  console.log(Buffer.from(buf.buffer, buf.byteOffset, buf.byteLength)
    .toString('hex'));
});

const c = new DataView(new ArrayBuffer(10));
crypto.randomFill(c, (err, buf) => {
  if (err) throw err;
  console.log(Buffer.from(buf.buffer, buf.byteOffset, buf.byteLength)
    .toString('hex'));
});
```

此 API 使用 libuv 的线程池，这对某些应用程序可能会产生意外的负面性能影响；有关更多信息，请参阅 [`UV_THREADPOOL_SIZE`](http://nodejs.cn/api-v12/cli.html#cli_uv_threadpool_size_size) 文档。

`crypto.randomFill()` 的异步版本是在单个线程池请求中执行的。 为了最大限度地减少线程池任务长度变化，在执行客户端请求时将大型 `randomFill` 请求分区。

#### `crypto.randomInt([min, ]max[, callback])`[#](http://nodejs.cn/api-v12/crypto.html#cryptorandomintmin-max-callback)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_randomint_min_max_callback.html)

新增于: v12.19.0

-   `min` [<integer>](http://url.nodejs.cn/SXbo1v) 随机范围的开始（包括）。 **默认值**: `0`.
-   `max` [<integer>](http://url.nodejs.cn/SXbo1v) 随机范围的结束（不包括）。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) `function(err, n) {}`.

返回随机整数 `n`，使得 `min <= n < max`。 这种实现避免了[模偏差](http://url.nodejs.cn/ucie85)。

范围 (`max - min`) 必须小于 248。 `min` 和 `max` 必须是[安全整数](http://url.nodejs.cn/km9EMH)。

如果不提供 `callback` 函数，则同步生成随机整数。

```
// 异步的
crypto.randomInt(3, (err, n) => {
  if (err) throw err;
  console.log(`Random number chosen from (0, 1, 2): ${n}`);
});
```

```
// 同步的
const n = crypto.randomInt(3);
console.log(`Random number chosen from (0, 1, 2): ${n}`);
```

```
// 带有 `min` 参数
const n = crypto.randomInt(1, 7);
console.log(`The dice rolled: ${n}`);
```

#### `crypto.scrypt(password, salt, keylen[, options], callback)`[#](http://nodejs.cn/api-v12/crypto.html#cryptoscryptpassword-salt-keylen-options-callback)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_scrypt_password_salt_keylen_options_callback.html)

-   `password` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `salt` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `keylen` [<number>](http://url.nodejs.cn/SXbo1v)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cost` [<number>](http://url.nodejs.cn/SXbo1v) CPU/内存成本参数。 必须是大于 1 的 2 的幂。 **默认值:** `16384`。
    -   `blockSize` [<number>](http://url.nodejs.cn/SXbo1v) 块大小参数。 **默认值:** `8`。
    -   `parallelization` [<number>](http://url.nodejs.cn/SXbo1v) 并行化参数。 **默认值:** `1`。
    -   `N` [<number>](http://url.nodejs.cn/SXbo1v) `cost` 的别名。 只能指定两者之一。
    -   `r` [<number>](http://url.nodejs.cn/SXbo1v) `blockSize` 的别名。 只能指定两者之一。
    -   `p` [<number>](http://url.nodejs.cn/SXbo1v) `parallelization` 的别名。 只能指定两者之一。
    -   `maxmem` [<number>](http://url.nodejs.cn/SXbo1v) 内存上限。 当（大约）`128 * N * r > maxmem` 时，则为错误。 **默认值:** `32 * 1024 * 1024`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `derivedKey` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

提供异步 [scrypt](http://url.nodejs.cn/757w2j) 实现。 Scrypt 是一个基于密码的密钥派生函数，其设计在计算和内存方面都非常昂贵，以使蛮力攻击毫无回报。

`salt` 应该尽可能唯一。 建议盐是随机的，长度至少为 16 字节。 有关详细信息，请参阅 [NIST SP 800-132](http://url.nodejs.cn/DbTtwt)。

`callback` 函数使用两个参数调用：`err` 和 `derivedKey`。 当密钥派生失败时 `err` 为异常对象，否则 `err` 为 `null`。 `derivedKey` 作为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 传给回调。

当任何输入参数指定无效值或类型时，将抛出异常。

```
const crypto = require('crypto');
// 使用出厂默认设置。
crypto.scrypt('secret', 'salt', 64, (err, derivedKey) => {
  if (err) throw err;
  console.log(derivedKey.toString('hex'));  // '3745e48...08d59ae'
});
// 使用自定义 N 参数。必须是二的幂。
crypto.scrypt('secret', 'salt', 64, { N: 1024 }, (err, derivedKey) => {
  if (err) throw err;
  console.log(derivedKey.toString('hex'));  // '3745e48...aa39b34'
});
```

#### `crypto.scryptSync(password, salt, keylen[, options])`[#](http://nodejs.cn/api-v12/crypto.html#cryptoscryptsyncpassword-salt-keylen-options)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_scryptsync_password_salt_keylen_options.html)

-   `password` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `salt` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `keylen` [<number>](http://url.nodejs.cn/SXbo1v)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cost` [<number>](http://url.nodejs.cn/SXbo1v) CPU/内存成本参数。 必须是大于 1 的 2 的幂。 **默认值:** `16384`。
    -   `blockSize` [<number>](http://url.nodejs.cn/SXbo1v) 块大小参数。 **默认值:** `8`。
    -   `parallelization` [<number>](http://url.nodejs.cn/SXbo1v) 并行化参数。 **默认值:** `1`。
    -   `N` [<number>](http://url.nodejs.cn/SXbo1v) `cost` 的别名。 只能指定两者之一。
    -   `r` [<number>](http://url.nodejs.cn/SXbo1v) `blockSize` 的别名。 只能指定两者之一。
    -   `p` [<number>](http://url.nodejs.cn/SXbo1v) `parallelization` 的别名。 只能指定两者之一。
    -   `maxmem` [<number>](http://url.nodejs.cn/SXbo1v) 内存上限。 当（大约）`128 * N * r > maxmem` 时，则为错误。 **默认值:** `32 * 1024 * 1024`。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

提供同步的 [scrypt](http://url.nodejs.cn/757w2j) 实现。 Scrypt 是一个基于密码的密钥派生函数，其设计在计算和内存方面都非常昂贵，以使蛮力攻击毫无回报。

`salt` 应该尽可能唯一。 建议盐是随机的，长度至少为 16 字节。 有关详细信息，请参阅 [NIST SP 800-132](http://url.nodejs.cn/DbTtwt)。

当密钥派生失败时抛出异常，否则派生的密钥作为 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 返回。

当任何输入参数指定无效值或类型时，将抛出异常。

```
const crypto = require('crypto');
// 使用出厂默认设置。
const key1 = crypto.scryptSync('secret', 'salt', 64);
console.log(key1.toString('hex'));  // '3745e48...08d59ae'
// 使用自定义 N 参数。必须是二的幂。
const key2 = crypto.scryptSync('secret', 'salt', 64, { N: 1024 });
console.log(key2.toString('hex'));  // '3745e48...aa39b34'
```

#### `crypto.setEngine(engine[, flags])`[#](http://nodejs.cn/api-v12/crypto.html#cryptosetengineengine-flags)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_setengine_engine_flags.html)

新增于: v0.11.11

-   `engine` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `flags` [<crypto.constants>](http://nodejs.cn/api/crypto.html#cryptoconstants) **默认值:** `crypto.constants.ENGINE_METHOD_ALL`

为部分或所有 OpenSSL 功能（由标志选择）加载并设置 `engine`。

`engine` 可以是 id 或引擎共享库的路径。

可选的 `flags` 参数默认使用 `ENGINE_METHOD_ALL`。 `flags` 是采用以下标志之一或混合的位字段（在 `crypto.constants` 中定义）：

-   `crypto.constants.ENGINE_METHOD_RSA`
-   `crypto.constants.ENGINE_METHOD_DSA`
-   `crypto.constants.ENGINE_METHOD_DH`
-   `crypto.constants.ENGINE_METHOD_RAND`
-   `crypto.constants.ENGINE_METHOD_EC`
-   `crypto.constants.ENGINE_METHOD_CIPHERS`
-   `crypto.constants.ENGINE_METHOD_DIGESTS`
-   `crypto.constants.ENGINE_METHOD_PKEY_METHS`
-   `crypto.constants.ENGINE_METHOD_PKEY_ASN1_METHS`
-   `crypto.constants.ENGINE_METHOD_ALL`
-   `crypto.constants.ENGINE_METHOD_NONE`

以下标志在 OpenSSL-1.1.0 中已弃用。

-   `crypto.constants.ENGINE_METHOD_ECDH`
-   `crypto.constants.ENGINE_METHOD_ECDSA`
-   `crypto.constants.ENGINE_METHOD_STORE`

#### `crypto.setFips(bool)`[#](http://nodejs.cn/api-v12/crypto.html#cryptosetfipsbool)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_setfips_bool.html)

新增于: v10.0.0

-   `bool` [<boolean>](http://url.nodejs.cn/jFbvuT) `true` 启用 FIPS 模式。

在启用 FIPS 的 Node.js 构建中启用符合 FIPS 的加密提供程序。 如果 FIPS 模式不可用，则会抛出错误。

#### `crypto.sign(algorithm, data, key)`[#](http://nodejs.cn/api-v12/crypto.html#cryptosignalgorithm-data-key)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_sign_algorithm_data_key.html)

新增于: v12.0.0

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) | [<undefined>](http://url.nodejs.cn/8ym6ow)
-   `data` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `key` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

使用给定的私钥和算法计算并返回 `data` 的签名。 如果 `algorithm` 是 `null` 或 `undefined`，则算法取决于密钥类型（尤其是 Ed25519 和 Ed448）。

如果 `key` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `key` 传给 [`crypto.createPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createprivatekey_key) 一样。 如果是对象，则可以传入以下额外属性：

-   `dsaEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 对于 DSA 和 ECDSA，此选项指定生成签名的格式。 它可以是以下之一：
    
    -   `'der'`（默认）：DER 编码的 ASN.1 签名结构编码 `(r, s)`。
    -   `'ieee-p1363'`: IEEE-P1363 中提议的签名格式 `r || s`。
-   `padding` [<integer>](http://url.nodejs.cn/SXbo1v) RSA 的可选填充值，以下之一：
    
    -   `crypto.constants.RSA_PKCS1_PADDING`（默认）
    -   `crypto.constants.RSA_PKCS1_PSS_PADDING`
    
    `RSA_PKCS1_PSS_PADDING` 将使用 MGF1 与用于签署消息的相同散列函数，如 [RFC 4055](http://url.nodejs.cn/o3Gr5v) 的第 3.1 节中指定的那样。
    
-   `saltLength` [<integer>](http://url.nodejs.cn/SXbo1v) 填充为 `RSA_PKCS1_PSS_PADDING` 时的盐长度。 特殊值 `crypto.constants.RSA_PSS_SALTLEN_DIGEST` 将盐长度设置为摘要大小，`crypto.constants.RSA_PSS_SALTLEN_MAX_SIGN`（默认值）将其设置为最大允许值。
    

#### `crypto.timingSafeEqual(a, b)`[#](http://nodejs.cn/api-v12/crypto.html#cryptotimingsafeequala-b)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_timingsafeequal_a_b.html)

新增于: v6.6.0

-   `a` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `b` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

该函数基于恒定时间算法。 如果 `a` 等于 `b`，则返回 true，而不会泄露允许攻击者猜测其中一个值的时间信息。 这适用于比较 HMAC 摘要或秘密值，如身份验证 cookie 或[功能网址](http://url.nodejs.cn/RjMmbw)。

使用 `crypto.timingSafeEqual` 并不能保证周围的代码是时间安全的。 应注意确保周围的代码不会引入时序漏洞。

#### `crypto.verify(algorithm, data, key, signature)`[#](http://nodejs.cn/api-v12/crypto.html#cryptoverifyalgorithm-data-key-signature)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_verify_algorithm_data_key_signature.html)

新增于: v12.0.0

-   `algorithm` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) | [<undefined>](http://url.nodejs.cn/8ym6ow)
-   `data` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   `key` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<KeyObject>](http://nodejs.cn/api/crypto.html#class-keyobject)
-   `signature` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

使用给定的密钥和算法验证 `data` 的给定签名。 如果 `algorithm` 是 `null` 或 `undefined`，则算法取决于密钥类型（尤其是 Ed25519 和 Ed448）。

如果 `key` 不是 [`KeyObject`](http://nodejs.cn/api-v12/crypto.html#crypto_class_keyobject)，则此函数的行为就像将 `key` 传给 [`crypto.createPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createpublickey_key) 一样。 如果是对象，则可以传入以下额外属性：

-   `dsaEncoding` [<string>](http://url.nodejs.cn/9Tw2bK) 对于 DSA 和 ECDSA，此选项指定生成签名的格式。 它可以是以下之一：
    
    -   `'der'`（默认）：DER 编码的 ASN.1 签名结构编码 `(r, s)`。
    -   `'ieee-p1363'`: IEEE-P1363 中提议的签名格式 `r || s`。
-   `padding` [<integer>](http://url.nodejs.cn/SXbo1v) RSA 的可选填充值，以下之一：
    
    -   `crypto.constants.RSA_PKCS1_PADDING`（默认）
    -   `crypto.constants.RSA_PKCS1_PSS_PADDING`
    
    `RSA_PKCS1_PSS_PADDING` 将使用 MGF1 与用于签署消息的相同散列函数，如 [RFC 4055](http://url.nodejs.cn/o3Gr5v) 的第 3.1 节中指定的那样。
    
-   `saltLength` [<integer>](http://url.nodejs.cn/SXbo1v) 填充为 `RSA_PKCS1_PSS_PADDING` 时的盐长度。 特殊值 `crypto.constants.RSA_PSS_SALTLEN_DIGEST` 将盐长度设置为摘要大小，`crypto.constants.RSA_PSS_SALTLEN_MAX_SIGN`（默认值）将其设置为最大允许值。
    

`signature` 参数是先前为 `data` 计算的签名。

因为公钥可以从私钥派生出来，所以可以为 `key` 传入私钥或公钥。

### 注意事项[#](http://nodejs.cn/api-v12/crypto.html#notes)

#### 旧版的流 API（Node.js v0.10 之前）[#](http://nodejs.cn/api-v12/crypto.html#legacy-streams-api-prior-to-nodejs-010)

[中英对照](http://nodejs.cn/api-v12/crypto/legacy_streams_api_prior_to_node_js_0_10.html)

加密模块是在 Node.js 出现统一的流 API 概念之前添加的，在 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 对象用于处理二进制数据之前。 因此，许多 `crypto` 定义的类具有在其他实现[流](http://nodejs.cn/api-v12/stream.html) API 的 Node.js 类（例如 `update()`、`final()` 或 `digest()`）上通常找不到的方法。 此外，许多方法默认接受并返回 `'latin1'` 编码字符串，而不是 `Buffer`。 此默认值在 Node.js v0.8 之后更改为默认使用 [`Buffer`](http://nodejs.cn/api-v12/buffer.html) 对象。

#### ECDH 近期的变化[#](http://nodejs.cn/api-v12/crypto.html#recent-ecdh-changes)

[中英对照](http://nodejs.cn/api-v12/crypto/recent_ecdh_changes.html)

`ECDH` 与非动态生成的密钥对的使用已得到简化。 现在，可以使用预选的私钥调用 [`ecdh.setPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_setprivatekey_privatekey_encoding)，并且关联的公钥（密钥）将被计算并存储在对象中。 这允许代码仅存储和提供 EC 密钥对的私有部分。 [`ecdh.setPrivateKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_setprivatekey_privatekey_encoding) 现在还验证私钥对所选曲线是否有效。

[`ecdh.setPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_setpublickey_publickey_encoding) 方法现在已被弃用，因为它包含在 API 中没有用。 要么应设置先前存储的私钥，它会自动生成关联的公钥，要么应调用 [`ecdh.generateKeys()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_generatekeys_encoding_format)。 使用 [`ecdh.setPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_setpublickey_publickey_encoding) 的主要缺点是它可用于将 ECDH 密钥对置于不一致的状态。

#### 弱算法或受损算法的支持[#](http://nodejs.cn/api-v12/crypto.html#support-for-weak-or-compromised-algorithms)

[中英对照](http://nodejs.cn/api-v12/crypto/support_for_weak_or_compromised_algorithms.html)

`crypto` 模块仍然支持一些已经被破坏并且目前不推荐使用的算法。 API 还允许使用对于安全使用来说太弱的小密钥大小的密码和散列。

用户应根据自己的安全要求对选择加密算法和密钥大小负全部责任。

基于 [NIST SP 800-131A](http://url.nodejs.cn/tNMwGm) 的建议：

-   MD5 和 SHA-1 在需要抗碰撞性（例如数字签名）的情况下不再被接受。
-   RSA、DSA 和 DH 算法使用的密钥建议至少 2048 位，ECDSA 和 ECDH 的曲线至少 224 位，才能安全使用几年。
-   `modp1`、`modp2`、`modp5` 的 DH 组密钥长度小于 2048 位，不推荐使用。

有关其他建议和详细信息，请参阅参考资料。

#### CCM 模式[#](http://nodejs.cn/api-v12/crypto.html#ccm-mode)

[中英对照](http://nodejs.cn/api-v12/crypto/ccm_mode.html)

CCM 是支持的 [AEAD 算法](http://url.nodejs.cn/oJCCfc)之一。 使用此模式的应用程序在使用密码 API 时必须遵守某些限制：

-   身份验证标签长度必须在密码创建期间通过设置 `authTagLength` 选项指定，并且必须是 4、6、8、10、12、14 或 16 字节之一。
-   初始化向量 (nonce) `N` 的长度必须介于 7 到 13 个字节 (`7 ≤ N ≤ 13`) 之间。
-   明文的长度限制为 `2 ** (8 * (15 - N))` 个字节。
-   解密时，必须在调用 `update()` 之前通过 `setAuthTag()` 设置认证标签。 否则，解密将失败并且 `final()` 将根据 [RFC 3610](http://url.nodejs.cn/w4NGuq) 的第 2.6 节抛出错误。
-   在 CCM 模式下使用 `write(data)`、`end(data)` 或 `pipe()` 等流方法可能会失败，因为 CCM 无法处理每个实例的多个数据块。
-   当传入额外的认证数据 (AAD) 时，必须通过 `plaintextLength` 选项将实际消息的长度（以字节为单位）传递给 `setAAD()`。 许多加密库在密文中包含认证标签，这意味着它们产生长度为 `plaintextLength + authTagLength` 的密文。 Node.js 不包含认证标签，所以密文长度始终为 `plaintextLength`。 如果没有使用 AAD，则这不是必需的。
-   由于 CCM 一次处理整个消息，因此只能调用 `update()` 一次。
-   即使调用 `update()` 足以加密/解密消息，应用程序必须调用 `final()` 来计算或验证身份验证标签。

```
const crypto = require('crypto');

const key = 'keykeykeykeykeykeykeykey';
const nonce = crypto.randomBytes(12);

const aad = Buffer.from('0123456789', 'hex');

const cipher = crypto.createCipheriv('aes-192-ccm', key, nonce, {
  authTagLength: 16
});
const plaintext = 'Hello world';
cipher.setAAD(aad, {
  plaintextLength: Buffer.byteLength(plaintext)
});
const ciphertext = cipher.update(plaintext, 'utf8');
cipher.final();
const tag = cipher.getAuthTag();

// 现在传输 { ciphertext, nonce, tag }。

const decipher = crypto.createDecipheriv('aes-192-ccm', key, nonce, {
  authTagLength: 16
});
decipher.setAuthTag(tag);
decipher.setAAD(aad, {
  plaintextLength: ciphertext.length
});
const receivedPlaintext = decipher.update(ciphertext, null, 'utf8');

try {
  decipher.final();
} catch (err) {
  console.error('Authentication failed!');
  return;
}

console.log(receivedPlaintext);
```

### 加密常量[#](http://nodejs.cn/api-v12/crypto.html#crypto-constants)

[中英对照](http://nodejs.cn/api-v12/crypto/crypto_constants_1.html)

`crypto.constants` 导出的以下常量适用于 `crypto`、`tls` 和 `https` 模块的各种用途，并且通常特定于 OpenSSL。

#### OpenSSL 选项[#](http://nodejs.cn/api-v12/crypto.html#openssl-options)

[中英对照](http://nodejs.cn/api-v12/crypto/openssl_options.html)

| 常量 | 描述 |
| --- | --- |
| `SSL_OP_ALL` | 在 OpenSSL 中应用多个错误解决方法。 详情请参阅 [https://www.openssl.org/docs/man1.0.2/ssl/SSL\_CTX\_set\_options.html](https://www.openssl.org/docs/man1.0.2/ssl/SSL_CTX_set_options.html)。 |
| `SSL_OP_ALLOW_NO_DHE_KEX` | 指示 OpenSSL 允许 TLS v1.3 的非基于 \[EC\]DHE 的密钥交换模式 |
| `SSL_OP_ALLOW_UNSAFE_LEGACY_RENEGOTIATION` | 允许在 OpenSSL 和未打补丁的客户端或服务器之间进行旧版的不安全重新协商。 详情请参阅 [https://www.openssl.org/docs/man1.0.2/ssl/SSL\_CTX\_set\_options.html](https://www.openssl.org/docs/man1.0.2/ssl/SSL_CTX_set_options.html)。 |
| `SSL_OP_CIPHER_SERVER_PREFERENCE` | 在选择密码时尝试使用服务器的首选项而不是客户端的首选项。 行为取决于协议版本。 详情请参阅 [https://www.openssl.org/docs/man1.0.2/ssl/SSL\_CTX\_set\_options.html](https://www.openssl.org/docs/man1.0.2/ssl/SSL_CTX_set_options.html)。 |
| `SSL_OP_CISCO_ANYCONNECT` | 指示 OpenSSL 使用思科的 "speshul" 版本的 DTLSBADVER。 |
| `SSL_OP_COOKIE_EXCHANGE` | 指示 OpenSSL 打开 cookie 交换。 |
| `SSL_OP_CRYPTOPRO_TLSEXT_BUG` | 指示 OpenSSL 从早期版本的 cryptopro 草案中添加 server-hello 扩展。 |
| `SSL_OP_DONT_INSERT_EMPTY_FRAGMENTS` | 指示 OpenSSL 禁用在 OpenSSL 0.9.6d 中添加的 SSL 3.0/TLS 1.0 漏洞解决方法。 |
| `SSL_OP_EPHEMERAL_RSA` | 指示 OpenSSL 在执行 RSA 操作时始终使用 tmp\_rsa 密钥。 |
| `SSL_OP_LEGACY_SERVER_CONNECT` | 允许初始连接到不支持 RI 的服务器。 |
| `SSL_OP_MICROSOFT_BIG_SSLV3_BUFFER` |  |
| `SSL_OP_MICROSOFT_SESS_ID_BUG` |  |
| `SSL_OP_MSIE_SSLV2_RSA_PADDING` | 指示 OpenSSL 禁用 SSL 2.0 服务器实现中的中间人协议版本漏洞的解决方法。 |
| `SSL_OP_NETSCAPE_CA_DN_BUG` |  |
| `SSL_OP_NETSCAPE_CHALLENGE_BUG` |  |
| `SSL_OP_NETSCAPE_DEMO_CIPHER_CHANGE_BUG` |  |
| `SSL_OP_NETSCAPE_REUSE_CIPHER_CHANGE_BUG` |  |
| `SSL_OP_NO_COMPRESSION` | 指示 OpenSSL 禁用对 SSL/TLS 压缩的支持。 |
| `SSL_OP_NO_ENCRYPT_THEN_MAC` | 指示 OpenSSL 禁用 encrypt-then-MAC。 |
| `SSL_OP_NO_QUERY_MTU` |  |
| `SSL_OP_NO_RENEGOTIATION` | 指示 OpenSSL 禁用重新协商。 |
| `SSL_OP_NO_SESSION_RESUMPTION_ON_RENEGOTIATION` | 指示 OpenSSL 在执行重新协商时始终启动新会话。 |
| `SSL_OP_NO_SSLv2` | 指示 OpenSSL 关闭 SSL v2 |
| `SSL_OP_NO_SSLv3` | 指示 OpenSSL 关闭 SSL v3 |
| `SSL_OP_NO_TICKET` | 指示 OpenSSL 禁用 RFC4507bis 票证的使用。 |
| `SSL_OP_NO_TLSv1` | 指示 OpenSSL 关闭 TLS v1 |
| `SSL_OP_NO_TLSv1_1` | 指示 OpenSSL 关闭 TLS v1.1 |
| `SSL_OP_NO_TLSv1_2` | 指示 OpenSSL 关闭 TLS v1.2 |
| `SSL_OP_NO_TLSv1_3` | 指示 OpenSSL 关闭 TLS v1.3 |
| `SSL_OP_PKCS1_CHECK_1` |  |
| `SSL_OP_PKCS1_CHECK_2` |  |
| `SSL_OP_PRIORITIZE_CHACHA` | 当客户端这样做时，指示 OpenSSL 服务器优先考虑 ChaCha20Poly1305。 如果 `SSL_OP_CIPHER_SERVER_PREFERENCE` 未启用，则此选项无效。 |
| `SSL_OP_SINGLE_DH_USE` | 指示 OpenSSL 在使用临时/短暂 DH 参数时始终创建新密钥。 |
| `SSL_OP_SINGLE_ECDH_USE` | 指示 OpenSSL 在使用临时/短暂 ECDH 参数时始终创建新密钥。 |
| `SSL_OP_SSLEAY_080_CLIENT_DH_BUG` |  |
| `SSL_OP_SSLREF2_REUSE_CERT_TYPE_BUG` |  |
| `SSL_OP_TLS_BLOCK_PADDING_BUG` |  |
| `SSL_OP_TLS_D5_BUG` |  |
| `SSL_OP_TLS_ROLLBACK_BUG` | 指示 OpenSSL 禁用版本回滚攻击检测。 |

#### OpenSSL 引擎的常量[#](http://nodejs.cn/api-v12/crypto.html#openssl-engine-constants)

[中英对照](http://nodejs.cn/api-v12/crypto/openssl_engine_constants.html)

| 常量 | 描述 |
| --- | --- |
| `ENGINE_METHOD_RSA` | 将引擎使用限制为 RSA |
| `ENGINE_METHOD_DSA` | 将引擎使用限制为 DSA |
| `ENGINE_METHOD_DH` | 将引擎使用限制为 DH |
| `ENGINE_METHOD_RAND` | 将引擎使用限制为 RAND |
| `ENGINE_METHOD_EC` | 将引擎使用限制为 EC |
| `ENGINE_METHOD_CIPHERS` | 将引擎使用限制为 CIPHERS |
| `ENGINE_METHOD_DIGESTS` | 将引擎使用限制为 DIGESTS |
| `ENGINE_METHOD_PKEY_METHS` | 将引擎使用限制为 PKEY\_METHDS |
| `ENGINE_METHOD_PKEY_ASN1_METHS` | 将引擎使用限制为 PKEY\_ASN1\_METHS |
| `ENGINE_METHOD_ALL` |  |
| `ENGINE_METHOD_NONE` |  |

#### 其他 OpenSSL 常量[#](http://nodejs.cn/api-v12/crypto.html#other-openssl-constants)

[中英对照](http://nodejs.cn/api-v12/crypto/other_openssl_constants.html)

有关详细信息，请参阅 [SSL OP 标志列表](http://url.nodejs.cn/QxXQf5)。

| 常量 | 描述 |
| --- | --- |
| `DH_CHECK_P_NOT_SAFE_PRIME` |  |
| `DH_CHECK_P_NOT_PRIME` |  |
| `DH_UNABLE_TO_CHECK_GENERATOR` |  |
| `DH_NOT_SUITABLE_GENERATOR` |  |
| `ALPN_ENABLED` |  |
| `RSA_PKCS1_PADDING` |  |
| `RSA_SSLV23_PADDING` |  |
| `RSA_NO_PADDING` |  |
| `RSA_PKCS1_OAEP_PADDING` |  |
| `RSA_X931_PADDING` |  |
| `RSA_PKCS1_PSS_PADDING` |  |
| `RSA_PSS_SALTLEN_DIGEST` | 在签名或验证时将 `RSA_PKCS1_PSS_PADDING` 的盐长度设置为摘要大小。 |
| `RSA_PSS_SALTLEN_MAX_SIGN` | 将 `RSA_PKCS1_PSS_PADDING` 的盐长度设置为签名数据时的最大允许值。 |
| `RSA_PSS_SALTLEN_AUTO` | 导致在验证签名时自动确定 `RSA_PKCS1_PSS_PADDING` 的盐长度。 |
| `POINT_CONVERSION_COMPRESSED` |  |
| `POINT_CONVERSION_UNCOMPRESSED` |  |
| `POINT_CONVERSION_HYBRID` |  |

#### Node.js 加密常量[#](http://nodejs.cn/api-v12/crypto.html#nodejs-crypto-constants)

[中英对照](http://nodejs.cn/api-v12/crypto/node_js_crypto_constants.html)

| 常量 | 描述 |
| --- | --- |
| `defaultCoreCipherList` | 指定 Node.js 使用的内置默认密码列表。 |
| `defaultCipherList` | 指定当前 Node.js 进程使用的活动默认密码列表。 |
