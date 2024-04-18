---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/errors.html
author: #
---

# Error 错误 | Node.js API 文档

> ## Excerpt
> Node.js 引发的所有 JavaScript 和系统错误都继承自标准的 JavaScript <Error> 类（或者是其实例），并且保证至少提供该类上可用的属性。

---
Node.js 引发的所有 JavaScript 和系统错误都继承自标准的 JavaScript [<Error>](http://url.nodejs.cn/qZ873x) 类（或者是其实例），并且保证至少提供该类上可用的属性。

### Node.js 错误码[#](http://nodejs.cn/api-v12/errors.html#nodejs-error-codes)

#### `ERR_AMBIGUOUS_ARGUMENT`[#](http://nodejs.cn/api-v12/errors.html#err_ambiguous_argument)

[中英对照](http://nodejs.cn/api-v12/errors/err_ambiguous_argument.html)

函数参数的使用方式表明函数签名可能会被误解。 当 `assert.throws(block, message)` 中的 `message` 参数与 `block` 抛出的错误消息匹配时，则由 `assert` 模块抛出错误，因为这种用法表明用户认为 `message` 是预期的消息，而不是 `block` 不抛出时 `AssertionError` 将显示的消息。

#### `ERR_ARG_NOT_ITERABLE`[#](http://nodejs.cn/api-v12/errors.html#err_arg_not_iterable)

[中英对照](http://nodejs.cn/api-v12/errors/err_arg_not_iterable.html)

需要可迭代的参数（即适用于 `for...of` 循环的值），但未提供给 Node.js API。

#### `ERR_ASSERTION`[#](http://nodejs.cn/api-v12/errors.html#err_assertion)

[中英对照](http://nodejs.cn/api-v12/errors/err_assertion.html)

特殊类型的错误，每当 Node.js 检测到不应该发生的异常逻辑违规时就会触发。 这些通常由 `assert` 模块引发。

#### `ERR_ASYNC_CALLBACK`[#](http://nodejs.cn/api-v12/errors.html#err_async_callback)

[中英对照](http://nodejs.cn/api-v12/errors/err_async_callback.html)

试图将不是函数的东西注册为 `AsyncHooks` 回调。

#### `ERR_ASYNC_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_async_type)

[中英对照](http://nodejs.cn/api-v12/errors/err_async_type.html)

异步资源的类型无效。 如果使用公共的嵌入器 API，则用户还可以定义自己的类型。

#### `ERR_BROTLI_COMPRESSION_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_brotli_compression_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_brotli_compression_failed.html)

传给 Brotli 流的数据未成功压缩。

#### `ERR_BROTLI_INVALID_PARAM`[#](http://nodejs.cn/api-v12/errors.html#err_brotli_invalid_param)

[中英对照](http://nodejs.cn/api-v12/errors/err_brotli_invalid_param.html)

在构建 Brotli 流期间传入了无效的参数键。

#### `ERR_BUFFER_CONTEXT_NOT_AVAILABLE`[#](http://nodejs.cn/api-v12/errors.html#err_buffer_context_not_available)

[中英对照](http://nodejs.cn/api-v12/errors/err_buffer_context_not_available.html)

尝试从插件或嵌入器代码创建 Node.js `Buffer` 实例，而在与 Node.js 实例无关的 JS 引擎上下文中。 传给 `Buffer` 方法的数据将在方法返回时被释放。

当遇到此错误时，创建 `Buffer` 实例的一种可能的替代方法是创建普通的 `Uint8Array`，它仅在生成的对象的原型上有所不同。 `Uint8Array` 通常在 `Buffer` 所在的所有的 Node.js 核心 API 中被接受；它们在所有上下文中都可用。

#### `ERR_BUFFER_OUT_OF_BOUNDS`[#](http://nodejs.cn/api-v12/errors.html#err_buffer_out_of_bounds)

[中英对照](http://nodejs.cn/api-v12/errors/err_buffer_out_of_bounds.html)

尝试了超出 `Buffer` 范围的操作。

#### `ERR_BUFFER_TOO_LARGE`[#](http://nodejs.cn/api-v12/errors.html#err_buffer_too_large)

[中英对照](http://nodejs.cn/api-v12/errors/err_buffer_too_large.html)

已尝试创建大于最大允许大小的 `Buffer`。

#### `ERR_CANNOT_WATCH_SIGINT`[#](http://nodejs.cn/api-v12/errors.html#err_cannot_watch_sigint)

[中英对照](http://nodejs.cn/api-v12/errors/err_cannot_watch_sigint.html)

Node.js 无法监视 `SIGINT` 信号。

#### `ERR_CHILD_CLOSED_BEFORE_REPLY`[#](http://nodejs.cn/api-v12/errors.html#err_child_closed_before_reply)

[中英对照](http://nodejs.cn/api-v12/errors/err_child_closed_before_reply.html)

在父进程收到回复之前子进程已关闭。

#### `ERR_CHILD_PROCESS_IPC_REQUIRED`[#](http://nodejs.cn/api-v12/errors.html#err_child_process_ipc_required)

[中英对照](http://nodejs.cn/api-v12/errors/err_child_process_ipc_required.html)

当在没有指定进程间通信通道的情况下衍生子进程时使用。

#### `ERR_CHILD_PROCESS_STDIO_MAXBUFFER`[#](http://nodejs.cn/api-v12/errors.html#err_child_process_stdio_maxbuffer)

[中英对照](http://nodejs.cn/api-v12/errors/err_child_process_stdio_maxbuffer.html)

当主进程试图从子进程的标准错误或标准输出读取数据、并且数据的长度比 `maxBuffer` 选项长时使用。

#### `ERR_CONSOLE_WRITABLE_STREAM`[#](http://nodejs.cn/api-v12/errors.html#err_console_writable_stream)

[中英对照](http://nodejs.cn/api-v12/errors/err_console_writable_stream.html)

`Console` 在没有 `stdout` 流的情况下被实例化，或者 `Console` 有不可写的 `stdout` 或 `stderr` 流。

#### `ERR_CONSTRUCT_CALL_REQUIRED`[#](http://nodejs.cn/api-v12/errors.html#err_construct_call_required)

[中英对照](http://nodejs.cn/api-v12/errors/err_construct_call_required.html)

在没有 `new` 的情况下调用了类的构造函数。

#### `ERR_CONSTRUCT_CALL_INVALID`[#](http://nodejs.cn/api-v12/errors.html#err_construct_call_invalid)

[中英对照](http://nodejs.cn/api-v12/errors/err_construct_call_invalid.html)

调用了不可调用的类构造函数。

#### `ERR_CPU_USAGE`[#](http://nodejs.cn/api-v12/errors.html#err_cpu_usage)

[中英对照](http://nodejs.cn/api-v12/errors/err_cpu_usage.html)

无法处理来自 `process.cpuUsage` 的原生调用。

#### `ERR_CRYPTO_CUSTOM_ENGINE_NOT_SUPPORTED`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_custom_engine_not_supported)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_custom_engine_not_supported.html)

请求的客户端证书引擎不受所使用的 OpenSSL 版本支持。

#### `ERR_CRYPTO_ECDH_INVALID_FORMAT`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_ecdh_invalid_format)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_ecdh_invalid_format.html)

`format` 参数的无效值被传给 `crypto.ECDH()` 类 `getPublicKey()` 方法。

#### `ERR_CRYPTO_ECDH_INVALID_PUBLIC_KEY`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_ecdh_invalid_public_key)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_ecdh_invalid_public_key.html)

`key` 参数的无效值已传给 `crypto.ECDH()` 类 `computeSecret()` 方法。 这意味着公钥位于椭圆曲线之外。

#### `ERR_CRYPTO_ENGINE_UNKNOWN`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_engine_unknown)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_engine_unknown.html)

无效的加密引擎标识符被传给 [`require('crypto').setEngine()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_setengine_engine_flags)。

#### `ERR_CRYPTO_FIPS_FORCED`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_fips_forced)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_fips_forced.html)

使用了 [`--force-fips`](http://nodejs.cn/api-v12/cli.html#cli_force_fips) 命令行参数，但尝试在 `crypto` 模块中启用或禁用 FIPS 模式。

#### `ERR_CRYPTO_FIPS_UNAVAILABLE`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_fips_unavailable)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_fips_unavailable.html)

尝试启用或禁用 FIPS 模式，但 FIPS 模式不可用。

#### `ERR_CRYPTO_HASH_FINALIZED`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_hash_finalized)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_hash_finalized.html)

[`hash.digest()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_digest_encoding) 被多次调用。 对于 `Hash` 对象的每个实例，调用 `hash.digest()` 方法的次数不得超过一次。

#### `ERR_CRYPTO_HASH_UPDATE_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_hash_update_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_hash_update_failed.html)

[`hash.update()`](http://nodejs.cn/api-v12/crypto.html#crypto_hash_update_data_inputencoding) 因任何原因失败。 这应该很少发生，如果有的话。

#### `ERR_CRYPTO_INCOMPATIBLE_KEY`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_incompatible_key)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_incompatible_key.html)

给定的加密密钥与尝试的操作不兼容。

#### `ERR_CRYPTO_INCOMPATIBLE_KEY_OPTIONS`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_incompatible_key_options)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_incompatible_key_options.html)

所选的公钥或私钥编码与其他选项不兼容。

#### `ERR_CRYPTO_INVALID_DIGEST`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_invalid_digest)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_invalid_digest.html)

指定了无效的[加密摘要算法](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_gethashes)。

#### `ERR_CRYPTO_INVALID_KEY_OBJECT_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_invalid_key_object_type)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_invalid_key_object_type.html)

给定的加密密钥对象的类型对于尝试的操作无效。

#### `ERR_CRYPTO_INVALID_STATE`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_invalid_state)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_invalid_state.html)

对处于无效状态的对象使用了加密方法。 例如，在调用 `cipher.final()` 之前调用 [`cipher.getAuthTag()`](http://nodejs.cn/api-v12/crypto.html#crypto_cipher_getauthtag)。

#### `ERR_CRYPTO_PBKDF2_ERROR`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_pbkdf2_error)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_pbkdf2_error.html)

PBKDF2 算法因不明原因失败。 OpenSSL 没有提供更多细节，因此 Node.js 也没有。

#### `ERR_CRYPTO_SCRYPT_INVALID_PARAMETER`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_scrypt_invalid_parameter)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_scrypt_invalid_parameter.html)

一个或多个 [`crypto.scrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_scrypt_password_salt_keylen_options_callback) 或 [`crypto.scryptSync()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_scryptsync_password_salt_keylen_options) 参数超出其合法范围。

#### `ERR_CRYPTO_SCRYPT_NOT_SUPPORTED`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_scrypt_not_supported)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_scrypt_not_supported.html)

Node.js 是在没有 `scrypt` 支持的情况下编译的。 官方发布的二进制文件不可能，但自定义构建可能会发生，包括发行版构建。

#### `ERR_CRYPTO_SIGN_KEY_REQUIRED`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_sign_key_required)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_sign_key_required.html)

未向 [`sign.sign()`](http://nodejs.cn/api-v12/crypto.html#crypto_sign_sign_privatekey_outputencoding) 方法提供签名 `key`。

#### `ERR_CRYPTO_TIMING_SAFE_EQUAL_LENGTH`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_timing_safe_equal_length)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_timing_safe_equal_length.html)

[`crypto.timingSafeEqual()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_timingsafeequal_a_b) 是用不同长度的 `Buffer`、`TypedArray` 或 `DataView` 参数调用的。

#### `ERR_CRYPTO_UNKNOWN_CIPHER`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_unknown_cipher)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_unknown_cipher.html)

指定了未知的密码。

#### `ERR_CRYPTO_UNKNOWN_DH_GROUP`[#](http://nodejs.cn/api-v12/errors.html#err_crypto_unknown_dh_group)

[中英对照](http://nodejs.cn/api-v12/errors/err_crypto_unknown_dh_group.html)

给定了未知的 Diffie-Hellman 组名。 有关有效组名的列表，请参阅 [`crypto.getDiffieHellman()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_getdiffiehellman_groupname)。

#### `ERR_DIR_CLOSED`[#](http://nodejs.cn/api-v12/errors.html#err_dir_closed)

[中英对照](http://nodejs.cn/api-v12/errors/err_dir_closed.html)

[`fs.Dir`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dir) 先前已关闭。

#### `ERR_DIR_CONCURRENT_OPERATION`[#](http://nodejs.cn/api-v12/errors.html#err_dir_concurrent_operation)

[中英对照](http://nodejs.cn/api-v12/errors/err_dir_concurrent_operation.html)

新增于: v12.18.1

尝试在具有正在进行的异步操作的 [`fs.Dir`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_dir) 上进行同步的读取或关闭的调用。

#### `ERR_DNS_SET_SERVERS_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_dns_set_servers_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_dns_set_servers_failed.html)

`c-ares` 设置域名系统服务器失败。

#### `ERR_DOMAIN_CALLBACK_NOT_AVAILABLE`[#](http://nodejs.cn/api-v12/errors.html#err_domain_callback_not_available)

[中英对照](http://nodejs.cn/api-v12/errors/err_domain_callback_not_available.html)

`domain` 模块不可用，因为它无法建立所需的错误处理钩子，因为 [`process.setUncaughtExceptionCaptureCallback()`](http://nodejs.cn/api-v12/process.html#process_process_setuncaughtexceptioncapturecallback_fn) 已在较早的时间点被调用。

#### `ERR_DOMAIN_CANNOT_SET_UNCAUGHT_EXCEPTION_CAPTURE`[#](http://nodejs.cn/api-v12/errors.html#err_domain_cannot_set_uncaught_exception_capture)

[中英对照](http://nodejs.cn/api-v12/errors/err_domain_cannot_set_uncaught_exception_capture.html)

无法调用 [`process.setUncaughtExceptionCaptureCallback()`](http://nodejs.cn/api-v12/process.html#process_process_setuncaughtexceptioncapturecallback_fn)，因为 `domain` 模块已在较早的时间点加载。

堆栈跟踪扩展到包括加载 `domain` 模块的时间点。

#### `ERR_ENCODING_INVALID_ENCODED_DATA`[#](http://nodejs.cn/api-v12/errors.html#err_encoding_invalid_encoded_data)

[中英对照](http://nodejs.cn/api-v12/errors/err_encoding_invalid_encoded_data.html)

根据提供的编码，提供给 `TextDecoder()` API 的数据无效。

#### `ERR_ENCODING_NOT_SUPPORTED`[#](http://nodejs.cn/api-v12/errors.html#err_encoding_not_supported)

[中英对照](http://nodejs.cn/api-v12/errors/err_encoding_not_supported.html)

提供给 `TextDecoder()` API 的编码不是 [WHATWG 支持的编码](http://nodejs.cn/api-v12/util.html#util_whatwg_supported_encodings)之一。

#### `ERR_EXECUTION_ENVIRONMENT_NOT_AVAILABLE`[#](http://nodejs.cn/api-v12/errors.html#err_execution_environment_not_available)

[中英对照](http://nodejs.cn/api-v12/errors/err_execution_environment_not_available.html)

JS 执行上下文与 Node.js 环境无关。 当 Node.js 用作嵌入式库并且 JS 引擎的一些钩子没有正确地设置时，可能会发生这种情况。

#### `ERR_FALSY_VALUE_REJECTION`[#](http://nodejs.cn/api-v12/errors.html#err_falsy_value_rejection)

[中英对照](http://nodejs.cn/api-v12/errors/err_falsy_value_rejection.html)

通过 `util.callbackify()` 回调的 `Promise` 使用非真值拒绝。

#### `ERR_FS_FILE_TOO_LARGE`[#](http://nodejs.cn/api-v12/errors.html#err_fs_file_too_large)

[中英对照](http://nodejs.cn/api-v12/errors/err_fs_file_too_large.html)

已尝试读取大小大于 `Buffer` 允许的最大大小的文件。

#### `ERR_FS_INVALID_SYMLINK_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_fs_invalid_symlink_type)

[中英对照](http://nodejs.cn/api-v12/errors/err_fs_invalid_symlink_type.html)

传给 [`fs.symlink()`](http://nodejs.cn/api-v12/fs.html#fs_fs_symlink_target_path_type_callback) 或 [`fs.symlinkSync()`](http://nodejs.cn/api-v12/fs.html#fs_fs_symlinksync_target_path_type) 方法的符号链接类型无效。

#### `ERR_HTTP_HEADERS_SENT`[#](http://nodejs.cn/api-v12/errors.html#err_http_headers_sent)

[中英对照](http://nodejs.cn/api-v12/errors/err_http_headers_sent.html)

在已发送标头后尝试添加更多标头。

#### `ERR_HTTP_INVALID_HEADER_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_http_invalid_header_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_http_invalid_header_value.html)

指定了无效的 HTTP 标头值。

#### `ERR_HTTP_INVALID_STATUS_CODE`[#](http://nodejs.cn/api-v12/errors.html#err_http_invalid_status_code)

[中英对照](http://nodejs.cn/api-v12/errors/err_http_invalid_status_code.html)

状态代码超出了常规状态码的范围（100-999）。

#### `ERR_HTTP_TRAILER_INVALID`[#](http://nodejs.cn/api-v12/errors.html#err_http_trailer_invalid)

[中英对照](http://nodejs.cn/api-v12/errors/err_http_trailer_invalid.html)

即使传输编码不支持，也设置了 `Trailer` 标头。

#### `ERR_HTTP2_ALTSVC_INVALID_ORIGIN`[#](http://nodejs.cn/api-v12/errors.html#err_http2_altsvc_invalid_origin)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_altsvc_invalid_origin.html)

HTTP/2 ALTSVC 帧需要有效的来源。

#### `ERR_HTTP2_ALTSVC_LENGTH`[#](http://nodejs.cn/api-v12/errors.html#err_http2_altsvc_length)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_altsvc_length.html)

HTTP/2 ALTSVC 帧限制为最多 16,382 个有效载荷字节。

#### `ERR_HTTP2_CONNECT_AUTHORITY`

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_connect_authority.html)

对于使用 `CONNECT` 方法的 HTTP/2 请求，需要 `:authority` 伪标头。

#### `ERR_HTTP2_CONNECT_PATH`[#](http://nodejs.cn/api-v12/errors.html#err_http2_connect_path)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_connect_path.html)

对于使用 `CONNECT` 方法的 HTTP/2 请求，禁止使用 `:path` 伪标头。

#### `ERR_HTTP2_CONNECT_SCHEME`[#](http://nodejs.cn/api-v12/errors.html#err_http2_connect_scheme)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_connect_scheme.html)

对于使用 `CONNECT` 方法的 HTTP/2 请求，禁止使用 `:scheme` 伪标头。

#### `ERR_HTTP2_ERROR`[#](http://nodejs.cn/api-v12/errors.html#err_http2_error)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_error.html)

发生了非特定的 HTTP/2 错误。

#### `ERR_HTTP2_GOAWAY_SESSION`[#](http://nodejs.cn/api-v12/errors.html#err_http2_goaway_session)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_goaway_session.html)

新的 HTTP/2 流可能不会在 `Http2Session` 从连接的对等方接收到 `GOAWAY` 帧后打开。

#### `ERR_HTTP2_HEADERS_AFTER_RESPOND`[#](http://nodejs.cn/api-v12/errors.html#err_http2_headers_after_respond)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_headers_after_respond.html)

在启动 HTTP/2 响应后指定了额外的标头。

#### `ERR_HTTP2_HEADERS_SENT`[#](http://nodejs.cn/api-v12/errors.html#err_http2_headers_sent)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_headers_sent.html)

试图发送多个响应头。

#### `ERR_HTTP2_HEADER_SINGLE_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_http2_header_single_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_header_single_value.html)

为只需要一个值的 HTTP/2 标头字段提供了多个值。

#### `ERR_HTTP2_INFO_STATUS_NOT_ALLOWED`[#](http://nodejs.cn/api-v12/errors.html#err_http2_info_status_not_allowed)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_info_status_not_allowed.html)

信息性 HTTP 状态码（`1xx`）不能设置为 HTTP/2 响应的响应状态代码。

#### `ERR_HTTP2_INVALID_CONNECTION_HEADERS`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_connection_headers)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_connection_headers.html)

HTTP/1 连接特定标头禁止在 HTTP/2 请求和响应中使用。

#### `ERR_HTTP2_INVALID_HEADER_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_header_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_header_value.html)

指定了无效的 HTTP/2 标头值。

#### `ERR_HTTP2_INVALID_INFO_STATUS`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_info_status)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_info_status.html)

指定了无效的 HTTP 信息状态代码。 信息状态代码必须是 `100` 和 `199`（含）之间的整数。

#### `ERR_HTTP2_INVALID_ORIGIN`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_origin)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_origin.html)

HTTP/2 `ORIGIN` 帧需要有效的来源。

#### `ERR_HTTP2_INVALID_PACKED_SETTINGS_LENGTH`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_packed_settings_length)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_packed_settings_length.html)

传给 `http2.getUnpackedSettings()` API 的输入 `Buffer` 和 `Uint8Array` 实例的长度必须是 6 的倍数。

#### `ERR_HTTP2_INVALID_PSEUDOHEADER`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_pseudoheader)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_pseudoheader.html)

只能使用有效的 HTTP/2 伪标头（`:status`、`:path`、`:authority`、`:scheme` 和 `:method`）。

#### `ERR_HTTP2_INVALID_SESSION`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_session)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_session.html)

对已被销毁的 `Http2Session` 对象执行了操作。

#### `ERR_HTTP2_INVALID_SETTING_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_setting_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_setting_value.html)

为 HTTP/2 设置指定了无效值。

#### `ERR_HTTP2_INVALID_STREAM`[#](http://nodejs.cn/api-v12/errors.html#err_http2_invalid_stream)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_invalid_stream.html)

对已被销毁的流执行了操作。

#### `ERR_HTTP2_MAX_PENDING_SETTINGS_ACK`[#](http://nodejs.cn/api-v12/errors.html#err_http2_max_pending_settings_ack)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_max_pending_settings_ack.html)

每当一个 HTTP/2 `SETTINGS` 帧被发送到连接的对端时，对端需要发送确认其已经收到并应用了新的 `SETTINGS`。 默认情况下，可以在任何给定时间发送最大数量的未确认 `SETTINGS` 帧。 当达到该限制时使用此错误码。

#### `ERR_HTTP2_NESTED_PUSH`[#](http://nodejs.cn/api-v12/errors.html#err_http2_nested_push)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_nested_push.html)

试图从推送流中启动新的推送流。 不允许嵌套推送流。

#### `ERR_HTTP2_NO_SOCKET_MANIPULATION`[#](http://nodejs.cn/api-v12/errors.html#err_http2_no_socket_manipulation)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_no_socket_manipulation.html)

试图直接操作（读取、写入、暂停、恢复等）连接到 `Http2Session` 的套接字。

#### `ERR_HTTP2_ORIGIN_LENGTH`[#](http://nodejs.cn/api-v12/errors.html#err_http2_origin_length)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_origin_length.html)

HTTP/2 `ORIGIN` 帧的长度限制为 16382 字节。

#### `ERR_HTTP2_OUT_OF_STREAMS`[#](http://nodejs.cn/api-v12/errors.html#err_http2_out_of_streams)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_out_of_streams.html)

在单个 HTTP/2 会话上创建的流数达到了最大限制。

#### `ERR_HTTP2_PAYLOAD_FORBIDDEN`[#](http://nodejs.cn/api-v12/errors.html#err_http2_payload_forbidden)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_payload_forbidden.html)

已为禁止负载的 HTTP 响应码指定了消息负载。

#### `ERR_HTTP2_PING_CANCEL`[#](http://nodejs.cn/api-v12/errors.html#err_http2_ping_cancel)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_ping_cancel.html)

HTTP/2 发送回显信息被取消。

#### `ERR_HTTP2_PING_LENGTH`[#](http://nodejs.cn/api-v12/errors.html#err_http2_ping_length)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_ping_length.html)

HTTP/2 发送回显信息负载的长度必须正好是 8 个字节。

#### `ERR_HTTP2_PSEUDOHEADER_NOT_ALLOWED`[#](http://nodejs.cn/api-v12/errors.html#err_http2_pseudoheader_not_allowed)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_pseudoheader_not_allowed.html)

HTTP/2 伪标头使用不当。 伪标头是以 `:` 前缀开头的标头键名。

#### `ERR_HTTP2_PUSH_DISABLED`[#](http://nodejs.cn/api-v12/errors.html#err_http2_push_disabled)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_push_disabled.html)

尝试创建推送流，但已被客户端禁用。

#### `ERR_HTTP2_SEND_FILE`[#](http://nodejs.cn/api-v12/errors.html#err_http2_send_file)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_send_file.html)

尝试使用 `Http2Stream.prototype.responseWithFile()` API 发送目录。

#### `ERR_HTTP2_SEND_FILE_NOSEEK`[#](http://nodejs.cn/api-v12/errors.html#err_http2_send_file_noseek)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_send_file_noseek.html)

尝试使用 `Http2Stream.prototype.responseWithFile()` API 发送常规文件以外的内容，但提供了 `offset` 或 `length` 选项。

#### `ERR_HTTP2_SESSION_ERROR`[#](http://nodejs.cn/api-v12/errors.html#err_http2_session_error)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_session_error.html)

`Http2Session` 以非零错误码关闭。

#### `ERR_HTTP2_SETTINGS_CANCEL`[#](http://nodejs.cn/api-v12/errors.html#err_http2_settings_cancel)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_settings_cancel.html)

`Http2Session` 设置取消。

#### `ERR_HTTP2_SOCKET_BOUND`[#](http://nodejs.cn/api-v12/errors.html#err_http2_socket_bound)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_socket_bound.html)

试图将 `Http2Session` 对象连接到已经绑定到另一个 `Http2Session` 对象的 `net.Socket` 或 `tls.TLSSocket`。

#### `ERR_HTTP2_SOCKET_UNBOUND`[#](http://nodejs.cn/api-v12/errors.html#err_http2_socket_unbound)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_socket_unbound.html)

尝试使用已关闭的 `Http2Session` 的 `socket` 属性。

#### `ERR_HTTP2_STATUS_101`[#](http://nodejs.cn/api-v12/errors.html#err_http2_status_101)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_status_101.html)

在 HTTP/2 中禁止使用 `101` 信息状态码。

#### `ERR_HTTP2_STATUS_INVALID`[#](http://nodejs.cn/api-v12/errors.html#err_http2_status_invalid)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_status_invalid.html)

指定了无效的 HTTP 状态码。 状态码必须是介于 `100` 和 `599`（含）之间的整数。

#### `ERR_HTTP2_STREAM_CANCEL`[#](http://nodejs.cn/api-v12/errors.html#err_http2_stream_cancel)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_stream_cancel.html)

在将任何数据传输到连接的对等方之前，`Http2Stream` 已被破坏。

#### `ERR_HTTP2_STREAM_ERROR`[#](http://nodejs.cn/api-v12/errors.html#err_http2_stream_error)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_stream_error.html)

在 `RST_STREAM` 帧中指定了非零错误码。

#### `ERR_HTTP2_STREAM_SELF_DEPENDENCY`[#](http://nodejs.cn/api-v12/errors.html#err_http2_stream_self_dependency)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_stream_self_dependency.html)

当在为 HTTP/2 流设置优先级时，该流可能被标记为父流的依赖项。 当试图标记流并依赖于它自己时，将使用此错误码。

#### `ERR_HTTP2_TRAILERS_ALREADY_SENT`[#](http://nodejs.cn/api-v12/errors.html#err_http2_trailers_already_sent)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_trailers_already_sent.html)

已在 `Http2Stream` 上发送了尾随标头。

#### `ERR_HTTP2_TRAILERS_NOT_READY`[#](http://nodejs.cn/api-v12/errors.html#err_http2_trailers_not_ready)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_trailers_not_ready.html)

在 `Http2Stream` 对象上触发 `'wantTrailers'` 事件之后，才能调用 `http2stream.sendTrailers()` 方法。 只有为 `Http2Stream` 设置了 `waitForTrailers` 选项，才会触发 `'wantTrailers'` 事件。

#### `ERR_HTTP2_UNSUPPORTED_PROTOCOL`[#](http://nodejs.cn/api-v12/errors.html#err_http2_unsupported_protocol)

[中英对照](http://nodejs.cn/api-v12/errors/err_http2_unsupported_protocol.html)

`http2.connect()` 传入的网址使用除 `http:` 或 `https:` 以外的任何协议。

#### `ERR_INTERNAL_ASSERTION`[#](http://nodejs.cn/api-v12/errors.html#err_internal_assertion)

[中英对照](http://nodejs.cn/api-v12/errors/err_internal_assertion.html)

Node.js 中存在错误或 Node.js 内部使用不正确。 要修复该错误，请在 [https://github.com/nodejs/node/issues](https://github.com/nodejs/node/issues) 上打开问题。

#### `ERR_INCOMPATIBLE_OPTION_PAIR`[#](http://nodejs.cn/api-v12/errors.html#err_incompatible_option_pair)

[中英对照](http://nodejs.cn/api-v12/errors/err_incompatible_option_pair.html)

选项对彼此不兼容，不能同时使用。

#### `ERR_INPUT_TYPE_NOT_ALLOWED`[#](http://nodejs.cn/api-v12/errors.html#err_input_type_not_allowed)

[中英对照](http://nodejs.cn/api-v12/errors/err_input_type_not_allowed.html)

`--input-type` 标志用于尝试执行文件。 此标志只能与通过 `--eval`、`--print` 或 `STDIN` 的输入一起使用。

#### `ERR_INSPECTOR_ALREADY_ACTIVATED`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_already_activated)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_already_activated.html)

在使用 `inspector` 模块时，当检查器已经开始监听端口时尝试激活。 在不同地址上激活之前使用 `inspector.close()`。

#### `ERR_INSPECTOR_ALREADY_CONNECTED`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_already_connected)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_already_connected.html)

在使用 `inspector` 模块时，当检查器已经连接时尝试连接。

#### `ERR_INSPECTOR_CLOSED`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_closed)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_closed.html)

在使用 `inspector` 模块时，在会话已经关闭后尝试使用检查器。

#### `ERR_INSPECTOR_COMMAND`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_command)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_command.html)

通过 `inspector` 模块发出命令时发生错误。

#### `ERR_INSPECTOR_NOT_ACTIVE`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_not_active)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_not_active.html)

当调用 `inspector.waitForDebugger()` 时，`inspector` 未激活。

#### `ERR_INSPECTOR_NOT_AVAILABLE`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_not_available)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_not_available.html)

`inspector` 模块无法使用。

#### `ERR_INSPECTOR_NOT_CONNECTED`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_not_connected)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_not_connected.html)

在使用 `inspector` 模块时，尝试在连接前使用检查器。

#### `ERR_INSPECTOR_NOT_WORKER`[#](http://nodejs.cn/api-v12/errors.html#err_inspector_not_worker)

[中英对照](http://nodejs.cn/api-v12/errors/err_inspector_not_worker.html)

在主线程上调用了只能从工作线程使用的 API。

#### `ERR_INVALID_ADDRESS_FAMILY`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_address_family)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_address_family.html)

Node.js API 无法识别提供的地址族。

#### `ERR_INVALID_ARG_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_arg_type)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_arg_type.html)

传给 Node.js API 的参数类型错误。

#### `ERR_INVALID_ARG_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_arg_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_arg_value.html)

为给定参数传入了无效或不受支持的值。

#### `ERR_INVALID_ASYNC_ID`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_async_id)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_async_id.html)

使用 `AsyncHooks` 传入了无效的 `asyncId` 或 `triggerAsyncId`。 小于 -1 的标识不应该发生。

#### `ERR_INVALID_BUFFER_SIZE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_buffer_size)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_buffer_size.html)

在 `Buffer` 上执行了交换，但其大小与操作不兼容。

#### `ERR_INVALID_CALLBACK`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_callback)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_callback.html)

需要回调函数，但未提供给 Node.js API。

#### `ERR_INVALID_CHAR`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_char)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_char.html)

在标头中检测到无效字符。

#### `ERR_INVALID_CURSOR_POS`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_cursor_pos)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_cursor_pos.html)

给定流上的游标不能移动到没有指定列的指定行。

#### `ERR_INVALID_FD`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_fd)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_fd.html)

文件描述符无效（例如，它是负值）。

#### `ERR_INVALID_FD_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_fd_type)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_fd_type.html)

文件描述符的类型无效。

#### `ERR_INVALID_FILE_URL_HOST`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_file_url_host)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_file_url_host.html)

使用 `file:` 网址的 Node.js API（例如 [`fs`](http://nodejs.cn/api-v12/fs.html) 模块中的某些函数）遇到了主机不兼容的文件网址。 这种情况只能发生在只支持 `localhost` 或空主机的类 Unix 系统上。

#### `ERR_INVALID_FILE_URL_PATH`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_file_url_path)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_file_url_path.html)

使用 `file:` 网址的 Node.js API（例如 [`fs`](http://nodejs.cn/api-v12/fs.html) 模块中的某些函数）遇到路径不兼容的文件网址。 确定是否可以使用路径的确切语义是平台相关的。

#### `ERR_INVALID_HANDLE_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_handle_type)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_handle_type.html)

试图通过进程间通信通道向子进程发送不受支持的"句柄"。 有关详细信息，请参阅 [`subprocess.send()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_send_message_sendhandle_options_callback) 和 [`process.send()`](http://nodejs.cn/api-v12/process.html#process_process_send_message_sendhandle_options_callback)。

#### `ERR_INVALID_HTTP_TOKEN`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_http_token)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_http_token.html)

提供了无效的 HTTP 令牌。

#### `ERR_INVALID_IP_ADDRESS`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_ip_address)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_ip_address.html)

IP 地址无效。

#### `ERR_INVALID_MODULE_SPECIFIER`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_module_specifier)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_module_specifier.html)

导入的模块字符串是无效的网址、包名称、或包子路径说明符。

#### `ERR_INVALID_OPT_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_opt_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_opt_value.html)

在选项对象中传入了无效或意外的值。

#### `ERR_INVALID_OPT_VALUE_ENCODING`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_opt_value_encoding)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_opt_value_encoding.html)

传入了无效或未知的文件编码。

#### `ERR_INVALID_PACKAGE_CONFIG`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_package_config)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_package_config.html)

发现无效的 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件，该文件解析失败。

#### `ERR_INVALID_PACKAGE_TARGET`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_package_target)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_package_target.html)

`package.json` [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段包含用于尝试模块解析的无效目标映射值。

#### `ERR_INVALID_PERFORMANCE_MARK`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_performance_mark)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_performance_mark.html)

在使用性能计时 API (`perf_hooks`) 时，性能标记无效。

#### `ERR_INVALID_PROTOCOL`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_protocol)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_protocol.html)

无效的 `options.protocol` 被传给了 `http.request()`。

#### `ERR_INVALID_REPL_EVAL_CONFIG`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_repl_eval_config)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_repl_eval_config.html)

`breakEvalOnSigint` 和 `eval` 选项都在 [`REPL`](http://nodejs.cn/api-v12/repl.html) 配置中设置，这是不支持的。

#### `ERR_INVALID_REPL_INPUT`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_repl_input)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_repl_input.html)

输入不能在 [`REPL`](http://nodejs.cn/api-v12/repl.html) 中使用。

#### `ERR_INVALID_RETURN_PROPERTY`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_return_property)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_return_property.html)

如果函数选项在执行时没有为其返回的对象属性之一提供有效值时，则抛出错误。

#### `ERR_INVALID_RETURN_PROPERTY_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_return_property_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_return_property_value.html)

如果函数选项在执行时没有为其返回的对象属性之一提供预期值类型时，则抛出错误。

#### `ERR_INVALID_RETURN_VALUE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_return_value)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_return_value.html)

如果函数选项在执行时没有返回预期的值类型时（例如当函数应该返回 promise），则抛出错误。

#### `ERR_INVALID_SYNC_FORK_INPUT`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_sync_fork_input)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_sync_fork_input.html)

`Buffer`、`TypedArray`、`DataView`、或 `string` 作为标准输入输出的输入提供给异步的衍生。 有关更多信息，请参阅 [`child_process`](http://nodejs.cn/api-v12/child_process.html) 模块的文档。

#### `ERR_INVALID_THIS`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_this)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_this.html)

使用不兼容的 `this` 值调用了 Node.js API 函数

```
const urlSearchParams = new URLSearchParams('foo=bar&baz=new');

const buf = Buffer.alloc(1);
urlSearchParams.has.call(buf, 'foo');
// 抛出使用代码 'ERR_INVALID_THIS' 的 TypeError
```

#### `ERR_INVALID_TRANSFER_OBJECT`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_transfer_object)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_transfer_object.html)

无效的传输对象被传给 `postMessage()`。

#### `ERR_INVALID_TUPLE`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_tuple)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_tuple.html)

提供给 [WHATWG](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) [`URLSearchParams` 构造函数](http://nodejs.cn/api-v12/url.html#url_new_urlsearchparams_iterable) 的 `iterable` 中的元素不代表 `[name, value]` 元组，也就是说，如果元素不可迭代，或者不完全由两个元素组成。

#### `ERR_INVALID_URI`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_uri)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_uri.html)

传入了无效的网址。

#### `ERR_INVALID_URL`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_url)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_url.html)

无效的网址被传给 [WHATWG](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) [`URL` 构造函数](http://nodejs.cn/api-v12/url.html#url_new_url_input_base) 进行解析。 抛出的错误对象通常有附加的属性 `'input'`，其中包含解析失败的网址。

#### `ERR_INVALID_URL_SCHEME`[#](http://nodejs.cn/api-v12/errors.html#err_invalid_url_scheme)

[中英对照](http://nodejs.cn/api-v12/errors/err_invalid_url_scheme.html)

试图将不兼容方案（协议）的网址用于特定目的。 它仅用于 [`fs`](http://nodejs.cn/api-v12/fs.html) 模块中的 [WHATWG 网址 API](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 支持（仅接受具有 `'file'` 方案的网址），但将来也可能用于其他 Node.js API。

#### `ERR_IPC_CHANNEL_CLOSED`[#](http://nodejs.cn/api-v12/errors.html#err_ipc_channel_closed)

[中英对照](http://nodejs.cn/api-v12/errors/err_ipc_channel_closed.html)

尝试使用已关闭的进程间通信通道。

#### `ERR_IPC_DISCONNECTED`[#](http://nodejs.cn/api-v12/errors.html#err_ipc_disconnected)

[中英对照](http://nodejs.cn/api-v12/errors/err_ipc_disconnected.html)

试图断开已经断开的进程间通信通道。 有关更多信息，请参阅 [`child_process`](http://nodejs.cn/api-v12/child_process.html) 模块的文档。

#### `ERR_IPC_ONE_PIPE`[#](http://nodejs.cn/api-v12/errors.html#err_ipc_one_pipe)

[中英对照](http://nodejs.cn/api-v12/errors/err_ipc_one_pipe.html)

尝试使用多个进程间通信通道创建子 Node.js 进程。 有关更多信息，请参阅 [`child_process`](http://nodejs.cn/api-v12/child_process.html) 模块的文档。

#### `ERR_IPC_SYNC_FORK`[#](http://nodejs.cn/api-v12/errors.html#err_ipc_sync_fork)

[中英对照](http://nodejs.cn/api-v12/errors/err_ipc_sync_fork.html)

尝试使用同步衍生的 Node.js 进程打开进程间通信通道。 有关更多信息，请参阅 [`child_process`](http://nodejs.cn/api-v12/child_process.html) 模块的文档。

#### `ERR_MANIFEST_ASSERT_INTEGRITY`[#](http://nodejs.cn/api-v12/errors.html#err_manifest_assert_integrity)

[中英对照](http://nodejs.cn/api-v12/errors/err_manifest_assert_integrity.html)

尝试加载资源，但该资源与策略清单定义的完整性不匹配。 有关详细信息，请参阅[策略](http://nodejs.cn/api-v12/policy.html)清单的文档。

#### `ERR_MANIFEST_DEPENDENCY_MISSING`[#](http://nodejs.cn/api-v12/errors.html#err_manifest_dependency_missing)

[中英对照](http://nodejs.cn/api-v12/errors/err_manifest_dependency_missing.html)

已尝试加载资源，但该资源未列为尝试加载它的位置的依赖项。 有关详细信息，请参阅[策略](http://nodejs.cn/api-v12/policy.html)清单的文档。

#### `ERR_MANIFEST_INTEGRITY_MISMATCH`[#](http://nodejs.cn/api-v12/errors.html#err_manifest_integrity_mismatch)

[中英对照](http://nodejs.cn/api-v12/errors/err_manifest_integrity_mismatch.html)

已尝试加载策略清单，但该清单包含多个彼此不匹配的资源条目。 更新清单条目以解决此错误。 有关详细信息，请参阅[策略](http://nodejs.cn/api-v12/policy.html)清单的文档。

#### `ERR_MANIFEST_INVALID_RESOURCE_FIELD`[#](http://nodejs.cn/api-v12/errors.html#err_manifest_invalid_resource_field)

[中英对照](http://nodejs.cn/api-v12/errors/err_manifest_invalid_resource_field.html)

策略清单资源的其中一个字段的值无效。 更新清单条目以解决此错误。 有关详细信息，请参阅[策略](http://nodejs.cn/api-v12/policy.html)清单的文档。

#### `ERR_MANIFEST_PARSE_POLICY`[#](http://nodejs.cn/api-v12/errors.html#err_manifest_parse_policy)

[中英对照](http://nodejs.cn/api-v12/errors/err_manifest_parse_policy.html)

已尝试加载策略清单，但无法解析该清单。 有关详细信息，请参阅[策略](http://nodejs.cn/api-v12/policy.html)清单的文档。

#### `ERR_MANIFEST_TDZ`[#](http://nodejs.cn/api-v12/errors.html#err_manifest_tdz)

[中英对照](http://nodejs.cn/api-v12/errors/err_manifest_tdz.html)

已尝试从策略清单中读取，但清单初始化尚未发生。 这可能是 Node.js 中的错误。

#### `ERR_MANIFEST_UNKNOWN_ONERROR`[#](http://nodejs.cn/api-v12/errors.html#err_manifest_unknown_onerror)

[中英对照](http://nodejs.cn/api-v12/errors/err_manifest_unknown_onerror.html)

已加载策略清单，但其 "onerror" 行为的值未知。 有关详细信息，请参阅[策略](http://nodejs.cn/api-v12/policy.html)清单的文档。

#### `ERR_MEMORY_ALLOCATION_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_memory_allocation_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_memory_allocation_failed.html)

尝试分配内存（通常在 C++ 层），但是失败。

#### `ERR_MESSAGE_TARGET_CONTEXT_UNAVAILABLE`[#](http://nodejs.cn/api-v12/errors.html#err_message_target_context_unavailable)

[中英对照](http://nodejs.cn/api-v12/errors/err_message_target_context_unavailable.html)

新增于: v12.19.0

无法在目标[虚拟机](http://nodejs.cn/api-v12/vm.html) `Context` 中反序列化发布到 [`MessagePort`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_messageport) 的消息。 目前并非所有 Node.js 对象都可以在任何上下文中成功实例化，在这种情况下，尝试使用 `postMessage()` 传输它们可能会在接收端失败。

#### `ERR_METHOD_NOT_IMPLEMENTED`[#](http://nodejs.cn/api-v12/errors.html#err_method_not_implemented)

[中英对照](http://nodejs.cn/api-v12/errors/err_method_not_implemented.html)

需要方法，但未实现。

#### `ERR_MISSING_ARGS`[#](http://nodejs.cn/api-v12/errors.html#err_missing_args)

[中英对照](http://nodejs.cn/api-v12/errors/err_missing_args.html)

未传入 Node.js API 的必需参数。 这仅用于严格遵守 API 规范（在某些情况下可能接受 `func(undefined)` 但不接受 `func()`）。 在大多数原生 Node.js API 中，`func(undefined)` 和 `func()` 的处理方式相同，可以使用 [`ERR_INVALID_ARG_TYPE`](http://nodejs.cn/api-v12/errors.html#ERR_INVALID_ARG_TYPE) 错误码代替。

#### `ERR_MISSING_DYNAMIC_INSTANTIATE_HOOK`[#](http://nodejs.cn/api-v12/errors.html#err_missing_dynamic_instantiate_hook)

An [ES Module](http://nodejs.cn/api-v12/esm.html) loader hook specified `format: 'dynamic'` but did not provide a `dynamicInstantiate` hook.

#### `ERR_MISSING_OPTION`[#](http://nodejs.cn/api-v12/errors.html#err_missing_option)

[中英对照](http://nodejs.cn/api-v12/errors/err_missing_option.html)

对于接受选项对象的 API，某些选项可能是强制性的。 如果缺少必需的选项，则会抛出此代码。

#### `ERR_MISSING_MESSAGE_PORT_IN_TRANSFER_LIST`[#](http://nodejs.cn/api-v12/errors.html#err_missing_message_port_in_transfer_list)

[中英对照](http://nodejs.cn/api-v12/errors/err_missing_message_port_in_transfer_list.html)

通常，这是 `MessagePort`。

#### `ERR_MISSING_PASSPHRASE`[#](http://nodejs.cn/api-v12/errors.html#err_missing_passphrase)

[中英对照](http://nodejs.cn/api-v12/errors/err_missing_passphrase.html)

已尝试在未指定密码的情况下读取加密密钥。

#### `ERR_MISSING_PLATFORM_FOR_WORKER`[#](http://nodejs.cn/api-v12/errors.html#err_missing_platform_for_worker)

[中英对照](http://nodejs.cn/api-v12/errors/err_missing_platform_for_worker.html)

此 Node.js 实例使用的 V8 平台不支持创建工作线程。 这是由于缺乏对工作线程的嵌入支持造成的。 特别是，此错误不会发生在 Node.js 的标准构建中。

#### `ERR_MODULE_NOT_FOUND`[#](http://nodejs.cn/api-v12/errors.html#err_module_not_found)

[中英对照](http://nodejs.cn/api-v12/errors/err_module_not_found.html)

无法解析 [ES 模块](http://nodejs.cn/api-v12/esm.html)。

#### `ERR_MULTIPLE_CALLBACK`[#](http://nodejs.cn/api-v12/errors.html#err_multiple_callback)

[中英对照](http://nodejs.cn/api-v12/errors/err_multiple_callback.html)

回调被多次调用。

回调几乎总是意味着只被调用一次，因为查询可以被履行或被拒绝，但不能同时被执行。 后者可以通过多次调用回调来实现。

#### `ERR_NAPI_CONS_FUNCTION`[#](http://nodejs.cn/api-v12/errors.html#err_napi_cons_function)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_cons_function.html)

在使用 `N-API` 时，传入的构造函数不是函数。

#### `ERR_NAPI_INVALID_DATAVIEW_ARGS`[#](http://nodejs.cn/api-v12/errors.html#err_napi_invalid_dataview_args)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_invalid_dataview_args.html)

在调用 `napi_create_dataview()` 时，给定的 `offset` 超出了数据视图的边界或 `offset + length` 大于给定的 `buffer` 的长度。

#### `ERR_NAPI_INVALID_TYPEDARRAY_ALIGNMENT`[#](http://nodejs.cn/api-v12/errors.html#err_napi_invalid_typedarray_alignment)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_invalid_typedarray_alignment.html)

在调用 `napi_create_typedarray()` 时，提供的 `offset` 不是元素大小的倍数

#### `ERR_NAPI_INVALID_TYPEDARRAY_LENGTH`[#](http://nodejs.cn/api-v12/errors.html#err_napi_invalid_typedarray_length)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_invalid_typedarray_length.html)

在调用 `napi_create_typedarray()` 时，`(length * size_of_element) + byte_offset` 大于给定的 `buffer` 的长度。

#### `ERR_NAPI_TSFN_CALL_JS`[#](http://nodejs.cn/api-v12/errors.html#err_napi_tsfn_call_js)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_tsfn_call_js.html)

调用线程安全函数的 JavaScript 部分时出错。

#### `ERR_NAPI_TSFN_GET_UNDEFINED`[#](http://nodejs.cn/api-v12/errors.html#err_napi_tsfn_get_undefined)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_tsfn_get_undefined.html)

尝试检索 JavaScript `undefined` 值时出错。

#### `ERR_NAPI_TSFN_START_IDLE_LOOP`[#](http://nodejs.cn/api-v12/errors.html#err_napi_tsfn_start_idle_loop)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_tsfn_start_idle_loop.html)

在主线程上，值从空闲循环中与线程安全函数关联的队列中删除。 此错误表示尝试启动循环时发生错误。

#### `ERR_NAPI_TSFN_STOP_IDLE_LOOP`[#](http://nodejs.cn/api-v12/errors.html#err_napi_tsfn_stop_idle_loop)

[中英对照](http://nodejs.cn/api-v12/errors/err_napi_tsfn_stop_idle_loop.html)

一旦队列中没有更多的条目，则空闲循环必须暂停。 此错误表明空闲循环未能停止

#### `ERR_NO_CRYPTO`[#](http://nodejs.cn/api-v12/errors.html#err_no_crypto)

[中英对照](http://nodejs.cn/api-v12/errors/err_no_crypto.html)

尝试使用加密特性，而 Node.js 没有使用 OpenSSL 加密支持进行编译。

#### `ERR_NO_ICU`[#](http://nodejs.cn/api-v12/errors.html#err_no_icu)

[中英对照](http://nodejs.cn/api-v12/errors/err_no_icu.html)

尝试使用需要 [ICU](http://nodejs.cn/api-v12/intl.html#intl_internationalization_support) 的特性，但 Node.js 没有在 ICU 支持下编译。

#### `ERR_NON_CONTEXT_AWARE_DISABLED`[#](http://nodejs.cn/api-v12/errors.html#err_non_context_aware_disabled)

[中英对照](http://nodejs.cn/api-v12/errors/err_non_context_aware_disabled.html)

在不允许加载的进程中加载了非上下文感知的原生插件。

#### `ERR_OUT_OF_RANGE`[#](http://nodejs.cn/api-v12/errors.html#err_out_of_range)

[中英对照](http://nodejs.cn/api-v12/errors/err_out_of_range.html)

给定的值超出了可接受的范围。

#### `ERR_PACKAGE_IMPORT_NOT_DEFINED`[#](http://nodejs.cn/api-v12/errors.html#err_package_import_not_defined)

[中英对照](http://nodejs.cn/api-v12/errors/err_package_import_not_defined.html)

`package.json` [`"imports"`](http://nodejs.cn/api-v12/packages.html#packages_imports) 字段未定义给定的内部包说明符映射。

#### `ERR_PACKAGE_PATH_NOT_EXPORTED`[#](http://nodejs.cn/api-v12/errors.html#err_package_path_not_exported)

[中英对照](http://nodejs.cn/api-v12/errors/err_package_path_not_exported.html)

`package.json` [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段没有导出请求的子路径。 因为导出是封装的，没有导出的私有内部模块无法通过包解析导入，除非使用绝对网址。

#### `ERR_PROTO_ACCESS`[#](http://nodejs.cn/api-v12/errors.html#err_proto_access)

[中英对照](http://nodejs.cn/api-v12/errors/err_proto_access.html)

已禁止使用 [`--disable-proto=throw`](http://nodejs.cn/api-v12/cli.html#cli_disable_proto_mode) 访问 `Object.prototype.__proto__`。 [`Object.getPrototypeOf`](http://url.nodejs.cn/ffTW6j) 和 [`Object.setPrototypeOf`](http://url.nodejs.cn/5m9sGE) 应该用于获取和设置对象的原型。

#### `ERR_REQUIRE_ESM`[#](http://nodejs.cn/api-v12/errors.html#err_require_esm)

[中英对照](http://nodejs.cn/api-v12/errors/err_require_esm.html)

尝试将 `require()` 设为 [ES 模块](http://nodejs.cn/api-v12/esm.html)。

#### `ERR_SCRIPT_EXECUTION_INTERRUPTED`[#](http://nodejs.cn/api-v12/errors.html#err_script_execution_interrupted)

[中英对照](http://nodejs.cn/api-v12/errors/err_script_execution_interrupted.html)

脚本执行被 `SIGINT` 中断（例如，Ctrl+C 被按下。）

#### `ERR_SCRIPT_EXECUTION_TIMEOUT`[#](http://nodejs.cn/api-v12/errors.html#err_script_execution_timeout)

[中英对照](http://nodejs.cn/api-v12/errors/err_script_execution_timeout.html)

脚本执行超时，可能是由于正在执行的脚本中存在错误。

#### `ERR_SERVER_ALREADY_LISTEN`[#](http://nodejs.cn/api-v12/errors.html#err_server_already_listen)

[中英对照](http://nodejs.cn/api-v12/errors/err_server_already_listen.html)

当 `net.Server` 已经在监听时调用了 [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 方法。 这适用于 `net.Server` 的所有实例，包括 HTTP、HTTPS 和 HTTP/2 `Server` 实例。

#### `ERR_SERVER_NOT_RUNNING`[#](http://nodejs.cn/api-v12/errors.html#err_server_not_running)

[中英对照](http://nodejs.cn/api-v12/errors/err_server_not_running.html)

当 `net.Server` 未运行时调用了 [`server.close()`](http://nodejs.cn/api-v12/net.html#net_server_close_callback) 方法。 这适用于 `net.Server` 的所有实例，包括 HTTP、HTTPS 和 HTTP/2 `Server` 实例。

#### `ERR_SOCKET_ALREADY_BOUND`[#](http://nodejs.cn/api-v12/errors.html#err_socket_already_bound)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_already_bound.html)

试图绑定已经绑定的套接字。

#### `ERR_SOCKET_BAD_BUFFER_SIZE`[#](http://nodejs.cn/api-v12/errors.html#err_socket_bad_buffer_size)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_bad_buffer_size.html)

为 [`dgram.createSocket()`](http://nodejs.cn/api-v12/dgram.html#dgram_dgram_createsocket_options_callback) 中的 `recvBufferSize` 或 `sendBufferSize` 选项传入了无效的（负数的）大小。

#### `ERR_SOCKET_BAD_PORT`[#](http://nodejs.cn/api-v12/errors.html#err_socket_bad_port)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_bad_port.html)

期望端口 >= 0 和 < 65536 的 API 函数收到无效值。

#### `ERR_SOCKET_BAD_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_socket_bad_type)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_bad_type.html)

需要套接字类型（`udp4` 或 `udp6`）的 API 函数收到无效值。

#### `ERR_SOCKET_BUFFER_SIZE`[#](http://nodejs.cn/api-v12/errors.html#err_socket_buffer_size)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_buffer_size.html)

在使用 [`dgram.createSocket()`](http://nodejs.cn/api-v12/dgram.html#dgram_dgram_createsocket_options_callback) 时，无法确定接收或发送 `Buffer` 的大小。

#### `ERR_SOCKET_CANNOT_SEND`[#](http://nodejs.cn/api-v12/errors.html#err_socket_cannot_send)

Data could be sent on a socket.

#### `ERR_SOCKET_CLOSED`[#](http://nodejs.cn/api-v12/errors.html#err_socket_closed)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_closed.html)

试图在已经关闭的套接字上进行操作。

#### `ERR_SOCKET_DGRAM_IS_CONNECTED`[#](http://nodejs.cn/api-v12/errors.html#err_socket_dgram_is_connected)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_dgram_is_connected.html)

在已连接的套接字上进行了 [`dgram.connect()`](http://nodejs.cn/api-v12/dgram.html#dgram_socket_connect_port_address_callback) 调用。

#### `ERR_SOCKET_DGRAM_NOT_CONNECTED`[#](http://nodejs.cn/api-v12/errors.html#err_socket_dgram_not_connected)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_dgram_not_connected.html)

在断开连接的套接字上进行了 [`dgram.disconnect()`](http://nodejs.cn/api-v12/dgram.html#dgram_socket_disconnect) 或 [`dgram.remoteAddress()`](http://nodejs.cn/api-v12/dgram.html#dgram_socket_remoteaddress) 调用。

#### `ERR_SOCKET_DGRAM_NOT_RUNNING`[#](http://nodejs.cn/api-v12/errors.html#err_socket_dgram_not_running)

[中英对照](http://nodejs.cn/api-v12/errors/err_socket_dgram_not_running.html)

进行了调用，并且 UDP 子系统没有运行。

#### `ERR_SRI_PARSE`[#](http://nodejs.cn/api-v12/errors.html#err_sri_parse)

[中英对照](http://nodejs.cn/api-v12/errors/err_sri_parse.html)

为子资源完整性检查提供了字符串，但无法解析。 通过查看[子资源完整性规范](http://url.nodejs.cn/JDfR74)来检查完整性属性的格式。

#### `ERR_STREAM_CANNOT_PIPE`[#](http://nodejs.cn/api-v12/errors.html#err_stream_cannot_pipe)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_cannot_pipe.html)

试图在 [`Writable`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_writable) 流上调用 [`stream.pipe()`](http://nodejs.cn/api-v12/stream.html#stream_readable_pipe_destination_options)

#### `ERR_STREAM_DESTROYED`[#](http://nodejs.cn/api-v12/errors.html#err_stream_destroyed)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_destroyed.html)

调用了无法完成的流方法，因为使用 `stream.destroy()` 销毁了该流。

#### `ERR_STREAM_NULL_VALUES`[#](http://nodejs.cn/api-v12/errors.html#err_stream_null_values)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_null_values.html)

试图用 `null` 块调用 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback)。

#### `ERR_STREAM_PREMATURE_CLOSE`[#](http://nodejs.cn/api-v12/errors.html#err_stream_premature_close)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_premature_close.html)

`stream.finished()` 和 `stream.pipeline()` 返回的错误，当流或管道以非正常方式结束且没有显式错误时。

#### `ERR_STREAM_PUSH_AFTER_EOF`[#](http://nodejs.cn/api-v12/errors.html#err_stream_push_after_eof)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_push_after_eof.html)

在将 `null`（EOF）推送到流后，尝试调用 [`stream.push()`](http://nodejs.cn/api-v12/stream.html#stream_readable_push_chunk_encoding)。

#### `ERR_STREAM_UNSHIFT_AFTER_END_EVENT`[#](http://nodejs.cn/api-v12/errors.html#err_stream_unshift_after_end_event)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_unshift_after_end_event.html)

在触发 `'end'` 事件后尝试调用 [`stream.unshift()`](http://nodejs.cn/api-v12/stream.html#stream_readable_unshift_chunk_encoding)。

#### `ERR_STREAM_WRAP`[#](http://nodejs.cn/api-v12/errors.html#err_stream_wrap)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_wrap.html)

如果在套接字上设置了字符串解码器或解码器在 `objectMode` 中，则防止中止。

```
const Socket = require('net').Socket;
const instance = new Socket();

instance.setEncoding('utf8');
```

#### `ERR_STREAM_WRITE_AFTER_END`[#](http://nodejs.cn/api-v12/errors.html#err_stream_write_after_end)

[中英对照](http://nodejs.cn/api-v12/errors/err_stream_write_after_end.html)

在调用 `stream.end()` 后尝试调用 [`stream.write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback)。

#### `ERR_STRING_TOO_LONG`[#](http://nodejs.cn/api-v12/errors.html#err_string_too_long)

[中英对照](http://nodejs.cn/api-v12/errors/err_string_too_long.html)

尝试创建长度超过最大允许长度的字符串。

#### `ERR_SYNTHETIC`[#](http://nodejs.cn/api-v12/errors.html#err_synthetic)

[中英对照](http://nodejs.cn/api-v12/errors/err_synthetic.html)

用于捕获诊断报告调用堆栈的人为错误对象。

#### `ERR_SYSTEM_ERROR`[#](http://nodejs.cn/api-v12/errors.html#err_system_error)

[中英对照](http://nodejs.cn/api-v12/errors/err_system_error.html)

Node.js 进程中发生了未指定或非特定的系统错误。 错误对象将具有带有附加详细信息的 `err.info` 对象属性。

#### `ERR_TLS_CERT_ALTNAME_FORMAT`[#](http://nodejs.cn/api-v12/errors.html#err_tls_cert_altname_format)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_cert_altname_format.html)

如果用户提供的 `subjectaltname` 属性违反编码规则，则 `checkServerIdentity` 会抛出此错误。 Node.js 本身生成的证书对象始终符合编码规则，永远不会出现此错误。

#### `ERR_TLS_CERT_ALTNAME_INVALID`[#](http://nodejs.cn/api-v12/errors.html#err_tls_cert_altname_invalid)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_cert_altname_invalid.html)

在使用 TLS 时，对等方的主机名/IP 与其证书中的任何 `subjectAltNames` 都不匹配。

#### `ERR_TLS_DH_PARAM_SIZE`[#](http://nodejs.cn/api-v12/errors.html#err_tls_dh_param_size)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_dh_param_size.html)

在使用 TLS 时，为 Diffie-Hellman（`DH`）密钥协商协议提供的参数太小。 默认情况下，密钥长度必须大于或等于 1024 位以避免漏洞，尽管强烈建议使用 2048 位或更大以增强安全性。

#### `ERR_TLS_HANDSHAKE_TIMEOUT`[#](http://nodejs.cn/api-v12/errors.html#err_tls_handshake_timeout)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_handshake_timeout.html)

TLS/SSL 握手超时。 在这种情况下，服务器也必须中止连接。

#### `ERR_TLS_INVALID_CONTEXT`[#](http://nodejs.cn/api-v12/errors.html#err_tls_invalid_context)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_invalid_context.html)

新增于: v12.16.0

上下文必须是 `SecureContext`。

#### `ERR_TLS_INVALID_STATE`[#](http://nodejs.cn/api-v12/errors.html#err_tls_invalid_state)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_invalid_state.html)

新增于: v12.17.0

必须连接并安全地建立 TLS 套接字。 确保在继续之前触发 'secure' 事件。

#### `ERR_TLS_INVALID_PROTOCOL_METHOD`[#](http://nodejs.cn/api-v12/errors.html#err_tls_invalid_protocol_method)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_invalid_protocol_method.html)

指定的 `secureProtocol` 方法无效。 它要么未知，要么因为不安全而被禁用。

#### `ERR_TLS_INVALID_PROTOCOL_VERSION`[#](http://nodejs.cn/api-v12/errors.html#err_tls_invalid_protocol_version)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_invalid_protocol_version.html)

有效的 TLS 协议版本为 `'TLSv1'`、`'TLSv1.1'` 或 `'TLSv1.2'`。

#### `ERR_TLS_PROTOCOL_VERSION_CONFLICT`[#](http://nodejs.cn/api-v12/errors.html#err_tls_protocol_version_conflict)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_protocol_version_conflict.html)

尝试设置 TLS 协议 `minVersion` 或 `maxVersion` 与尝试显式设置 `secureProtocol` 冲突。 使用一种或另一种机制。

#### `ERR_TLS_RENEGOTIATION_DISABLED`[#](http://nodejs.cn/api-v12/errors.html#err_tls_renegotiation_disabled)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_renegotiation_disabled.html)

试图在禁用 TLS 的套接字实例上重新协商 TLS。

#### `ERR_TLS_REQUIRED_SERVER_NAME`[#](http://nodejs.cn/api-v12/errors.html#err_tls_required_server_name)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_required_server_name.html)

在使用 TLS 时，调用 `server.addContext()` 方法时没有在第一个参数中提供主机名。

#### `ERR_TLS_SESSION_ATTACK`[#](http://nodejs.cn/api-v12/errors.html#err_tls_session_attack)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_session_attack.html)

检测到过多的 TLS 重新协商，这是拒绝服务攻击的潜在载体。

#### `ERR_TLS_SNI_FROM_SERVER`[#](http://nodejs.cn/api-v12/errors.html#err_tls_sni_from_server)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_sni_from_server.html)

试图从 TLS 服务器端套接字发出服务器名称指示，它仅对客户端有效。

#### `ERR_TLS_PSK_SET_IDENTIY_HINT_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_tls_psk_set_identiy_hint_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_tls_psk_set_identiy_hint_failed.html)

未能设置 PSK 身份提示。 提示可能太长。

#### `ERR_TRACE_EVENTS_CATEGORY_REQUIRED`[#](http://nodejs.cn/api-v12/errors.html#err_trace_events_category_required)

[中英对照](http://nodejs.cn/api-v12/errors/err_trace_events_category_required.html)

`trace_events.createTracing()` 方法至少需要一个跟踪事件类别。

#### `ERR_TRACE_EVENTS_UNAVAILABLE`[#](http://nodejs.cn/api-v12/errors.html#err_trace_events_unavailable)

[中英对照](http://nodejs.cn/api-v12/errors/err_trace_events_unavailable.html)

无法加载 `trace_events` 模块，因为 Node.js 是使用 `--without-v8-platform` 标志编译的。

#### `ERR_TRANSFERRING_EXTERNALIZED_SHAREDARRAYBUFFER`[#](http://nodejs.cn/api-v12/errors.html#err_transferring_externalized_sharedarraybuffer)

[中英对照](http://nodejs.cn/api-v12/errors/err_transferring_externalized_sharedarraybuffer.html)

在序列化过程中遇到内存不是由 JavaScript 引擎或 Node.js 管理的 `SharedArrayBuffer`。 这样的 `SharedArrayBuffer` 无法序列化。

这只会发生在原生插件在 "externalized" 模式下创建 `SharedArrayBuffer`s 或将现有的 `SharedArrayBuffer` 置于外部模式时。

#### `ERR_TRANSFORM_ALREADY_TRANSFORMING`[#](http://nodejs.cn/api-v12/errors.html#err_transform_already_transforming)

[中英对照](http://nodejs.cn/api-v12/errors/err_transform_already_transforming.html)

`Transform` 流在它仍在转换时完成。

#### `ERR_TRANSFORM_WITH_LENGTH_0`[#](http://nodejs.cn/api-v12/errors.html#err_transform_with_length_0)

[中英对照](http://nodejs.cn/api-v12/errors/err_transform_with_length_0.html)

`Transform` 流完成，数据仍在写入缓冲区中。

#### `ERR_TTY_INIT_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_tty_init_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_tty_init_failed.html)

由于系统错误，终端的初始化失败。

#### `ERR_UNAVAILABLE_DURING_EXIT`[#](http://nodejs.cn/api-v12/errors.html#err_unavailable_during_exit)

[中英对照](http://nodejs.cn/api-v12/errors/err_unavailable_during_exit.html)

函数在 [`process.on('exit')`](http://nodejs.cn/api-v12/process.html#Event:-%60'exit'%60) 句柄中调用，不应在 [`process.on('exit')`](http://nodejs.cn/api-v12/process.html#Event:-%60'exit'%60) 句柄中调用。

#### `ERR_UNCAUGHT_EXCEPTION_CAPTURE_ALREADY_SET`[#](http://nodejs.cn/api-v12/errors.html#err_uncaught_exception_capture_already_set)

[中英对照](http://nodejs.cn/api-v12/errors/err_uncaught_exception_capture_already_set.html)

[`process.setUncaughtExceptionCaptureCallback()`](http://nodejs.cn/api-v12/process.html#process_process_setuncaughtexceptioncapturecallback_fn) 被调用了两次，没有先将回调重置为 `null`。

此错误旨在防止意外覆盖从另一个模块注册的回调。

#### `ERR_UNESCAPED_CHARACTERS`[#](http://nodejs.cn/api-v12/errors.html#err_unescaped_characters)

[中英对照](http://nodejs.cn/api-v12/errors/err_unescaped_characters.html)

收到包含未转义字符的字符串。

#### `ERR_UNHANDLED_ERROR`[#](http://nodejs.cn/api-v12/errors.html#err_unhandled_error)

[中英对照](http://nodejs.cn/api-v12/errors/err_unhandled_error.html)

发生未处理的错误（例如，当 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) 触发 `'error'` 事件但未注册 `'error'` 句柄时）。

#### `ERR_UNKNOWN_BUILTIN_MODULE`[#](http://nodejs.cn/api-v12/errors.html#err_unknown_builtin_module)

[中英对照](http://nodejs.cn/api-v12/errors/err_unknown_builtin_module.html)

用于识别通常不应由用户代码触发的特定类型的内部 Node.js 错误。 此错误的实例指向 Node.js 二进制文件本身的内部错误。

#### `ERR_UNKNOWN_CREDENTIAL`[#](http://nodejs.cn/api-v12/errors.html#err_unknown_credential)

[中英对照](http://nodejs.cn/api-v12/errors/err_unknown_credential.html)

传入了不存在的 Unix 群组或用户标识符。

#### `ERR_UNKNOWN_ENCODING`[#](http://nodejs.cn/api-v12/errors.html#err_unknown_encoding)

[中英对照](http://nodejs.cn/api-v12/errors/err_unknown_encoding.html)

传给 API 的编码选项无效或未知。

#### `ERR_UNKNOWN_FILE_EXTENSION`[#](http://nodejs.cn/api-v12/errors.html#err_unknown_file_extension)

[中英对照](http://nodejs.cn/api-v12/errors/err_unknown_file_extension.html)

试图加载具有未知或不受支持的文件扩展名的模块。

#### `ERR_UNKNOWN_MODULE_FORMAT`[#](http://nodejs.cn/api-v12/errors.html#err_unknown_module_format)

[中英对照](http://nodejs.cn/api-v12/errors/err_unknown_module_format.html)

试图加载格式未知或不受支持的模块。

#### `ERR_UNKNOWN_SIGNAL`[#](http://nodejs.cn/api-v12/errors.html#err_unknown_signal)

[中英对照](http://nodejs.cn/api-v12/errors/err_unknown_signal.html)

无效或未知的进程信号已传给需要有效信号的 API（例如 [`subprocess.kill()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_kill_signal)）。

#### `ERR_UNSUPPORTED_DIR_IMPORT`[#](http://nodejs.cn/api-v12/errors.html#err_unsupported_dir_import)

[中英对照](http://nodejs.cn/api-v12/errors/err_unsupported_dir_import.html)

`import` 目录网址不受支持。 而是，在 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件的 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段中，[使用其名称自引用包](http://nodejs.cn/api-v12/packages.html#packages_self_referencing_a_package_using_its_name)和[定义自定义的子路径](http://nodejs.cn/api-v12/packages.html#packages_subpath_exports)。

```
import './'; // 不支持的
import './index.js'; // 支持的
import 'package-name'; // 支持的
```

#### `ERR_UNSUPPORTED_ESM_URL_SCHEME`[#](http://nodejs.cn/api-v12/errors.html#err_unsupported_esm_url_scheme)

[中英对照](http://nodejs.cn/api-v12/errors/err_unsupported_esm_url_scheme.html)

不支持带有 `file` 和 `data` 以外的网址方案的 `import`。

#### `ERR_VALID_PERFORMANCE_ENTRY_TYPE`[#](http://nodejs.cn/api-v12/errors.html#err_valid_performance_entry_type)

While using the Performance Timing API (`perf_hooks`), no valid performance entry types were found.

#### `ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING`[#](http://nodejs.cn/api-v12/errors.html#err_vm_dynamic_import_callback_missing)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_dynamic_import_callback_missing.html)

未指定动态导入回调。

#### `ERR_VM_MODULE_ALREADY_LINKED`[#](http://nodejs.cn/api-v12/errors.html#err_vm_module_already_linked)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_module_already_linked.html)

由于以下原因之一，尝试链接的模块不符合链接条件：

-   已链接（`linkingStatus` 为 `'linked'`）
-   正在链接（`linkingStatus` 为 `'linking'`）
-   此模块的链接失败（`linkingStatus` 为 `'errored'`）

#### `ERR_VM_MODULE_CACHED_DATA_REJECTED`[#](http://nodejs.cn/api-v12/errors.html#err_vm_module_cached_data_rejected)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_module_cached_data_rejected.html)

传给模块构造函数的 `cachedData` 选项无效。

#### `ERR_VM_MODULE_CANNOT_CREATE_CACHED_DATA`[#](http://nodejs.cn/api-v12/errors.html#err_vm_module_cannot_create_cached_data)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_module_cannot_create_cached_data.html)

不能为已经评估过的模块创建缓存数据。

#### `ERR_VM_MODULE_DIFFERENT_CONTEXT`[#](http://nodejs.cn/api-v12/errors.html#err_vm_module_different_context)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_module_different_context.html)

从链接器函数返回的模块来自与父模块不同的上下文。 链接的模块必须共享相同的上下文。

#### `ERR_VM_MODULE_LINKING_ERRORED`[#](http://nodejs.cn/api-v12/errors.html#err_vm_module_linking_errored)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_module_linking_errored.html)

链接器函数返回链接失败的模块。

#### `ERR_VM_MODULE_NOT_MODULE`[#](http://nodejs.cn/api-v12/errors.html#err_vm_module_not_module)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_module_not_module.html)

链接 promise 的履行值不是 `vm.Module` 对象。

#### `ERR_VM_MODULE_STATUS`[#](http://nodejs.cn/api-v12/errors.html#err_vm_module_status)

[中英对照](http://nodejs.cn/api-v12/errors/err_vm_module_status.html)

当前模块的状态不允许此操作。 错误的具体含义取决于具体的函数。

#### `ERR_WASI_ALREADY_STARTED`[#](http://nodejs.cn/api-v12/errors.html#err_wasi_already_started)

[中英对照](http://nodejs.cn/api-v12/errors/err_wasi_already_started.html)

WASI 实例已经启动。

#### `ERR_WASI_NOT_STARTED`[#](http://nodejs.cn/api-v12/errors.html#err_wasi_not_started)

[中英对照](http://nodejs.cn/api-v12/errors/err_wasi_not_started.html)

WASI 实例尚未启动。

#### `ERR_WORKER_INIT_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_worker_init_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_init_failed.html)

`Worker` 初始化失败。

#### `ERR_WORKER_INVALID_EXEC_ARGV`[#](http://nodejs.cn/api-v12/errors.html#err_worker_invalid_exec_argv)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_invalid_exec_argv.html)

传给 `Worker` 构造函数的 `execArgv` 选项包含无效标志。

#### `ERR_WORKER_NOT_RUNNING`[#](http://nodejs.cn/api-v12/errors.html#err_worker_not_running)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_not_running.html)

操作失败，因为 `Worker` 实例当前未运行。

#### `ERR_WORKER_OUT_OF_MEMORY`[#](http://nodejs.cn/api-v12/errors.html#err_worker_out_of_memory)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_out_of_memory.html)

`Worker` 实例因达到其内存限制而终止。

#### `ERR_WORKER_PATH`[#](http://nodejs.cn/api-v12/errors.html#err_worker_path)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_path.html)

工作线程主脚本的路径既不是绝对路径也不是以 `./` 或 `../` 开头的相对路径。

#### `ERR_WORKER_UNSERIALIZABLE_ERROR`[#](http://nodejs.cn/api-v12/errors.html#err_worker_unserializable_error)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_unserializable_error.html)

从工作线程序列化未捕获异常的所有尝试都失败了。

#### `ERR_WORKER_UNSUPPORTED_EXTENSION`[#](http://nodejs.cn/api-v12/errors.html#err_worker_unsupported_extension)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_unsupported_extension.html)

用于工作程序主脚本的路径名具有未知的文件扩展名。

#### `ERR_WORKER_UNSUPPORTED_OPERATION`[#](http://nodejs.cn/api-v12/errors.html#err_worker_unsupported_operation)

[中英对照](http://nodejs.cn/api-v12/errors/err_worker_unsupported_operation.html)

工作线程不支持请求的功能。

#### `ERR_ZLIB_INITIALIZATION_FAILED`[#](http://nodejs.cn/api-v12/errors.html#err_zlib_initialization_failed)

[中英对照](http://nodejs.cn/api-v12/errors/err_zlib_initialization_failed.html)

由于配置不正确，创建 [`zlib`](http://nodejs.cn/api-v12/zlib.html) 对象失败。

#### `HPE_HEADER_OVERFLOW`[#](http://nodejs.cn/api-v12/errors.html#hpe_header_overflow)

[中英对照](http://nodejs.cn/api-v12/errors/hpe_header_overflow.html)

接收到了太多的 HTTP 标头数据。 为了防止恶意或配置错误的客户端，如果接收到超过 8KB 的 HTTP 标头数据，则 HTTP 解析将中止，而不会创建请求或响应对象，并且会触发带有此代码的 `Error`。

#### `HPE_UNEXPECTED_CONTENT_LENGTH`[#](http://nodejs.cn/api-v12/errors.html#hpe_unexpected_content_length)

[中英对照](http://nodejs.cn/api-v12/errors/hpe_unexpected_content_length.html)

服务器正在发送 `Content-Length` 标头和 `Transfer-Encoding: chunked`。

`Transfer-Encoding: chunked` 允许服务器为动态生成的内容维护 HTTP 持久连接。 在这种情况下，无法使用 `Content-Length` HTTP 标头。

使用 `Content-Length` 或 `Transfer-Encoding: chunked`。

#### `MODULE_NOT_FOUND`[#](http://nodejs.cn/api-v12/errors.html#module_not_found)

[中英对照](http://nodejs.cn/api-v12/errors/module_not_found.html)

尝试执行 [`require()`](http://nodejs.cn/api-v12/modules.html#modules_require_id) 或 `import` 操作时无法解析模块文件。
