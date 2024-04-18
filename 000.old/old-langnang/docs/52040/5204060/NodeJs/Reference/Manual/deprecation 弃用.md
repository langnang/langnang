---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/deprecations.html
author: 
---

# deprecation 弃用 | Node.js API 文档

> ## Excerpt
> 仅文档弃用是仅在 Node.js API 文档中表达的弃用。
这些在运行 Node.js 时不会产生副作用。
某些仅文档的弃用在使用 --pending-deprecation 标志（或其替代的 NODE_PENDING_DEPRECATION=1 环境变量）启动时会触发运行时警告，类似于下面的运行时弃用。
支持该标志的仅文档弃用已在弃用的 API 列表 中明确标记。

---
仅文档弃用是仅在 Node.js API 文档中表达的弃用。 这些在运行 Node.js 时不会产生副作用。 某些仅文档的弃用在使用 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation) 标志（或其替代的 `NODE_PENDING_DEPRECATION=1` 环境变量）启动时会触发运行时警告，类似于下面的运行时弃用。 支持该标志的仅文档弃用已在[弃用的 API 列表](http://nodejs.cn/api-v12/deprecations.html#deprecations_list_of_deprecated_apis) 中明确标记。

默认情况下，运行时弃用将生成进程警告，该警告将在第一次使用弃用的 API 时打印到 `stderr`。 当使用 [`--throw-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_throw_deprecation) 命令行标志时，运行时弃用将导致抛出错误。

### 弃用的 API 列表[#](http://nodejs.cn/api-v12/deprecations.html#list-of-deprecated-apis)

#### DEP0001: `http.OutgoingMessage.prototype.flush`[#](http://nodejs.cn/api-v12/deprecations.html#dep0001-httpoutgoingmessageprototypeflush)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0001_http_outgoingmessage_prototype_flush.html)

类型: 运行时

`OutgoingMessage.prototype.flush()` 方法已弃用。 改用 `OutgoingMessage.prototype.flushHeaders()`。

#### DEP0002: `require('_linklist')`[#](http://nodejs.cn/api-v12/deprecations.html#dep0002-require_linklist)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0002_require_linklist.html)

类型: 生命结束

`_linklist` 模块已弃用。 请使用用户空间替代方案。

#### DEP0003: `_writableState.buffer`[#](http://nodejs.cn/api-v12/deprecations.html#dep0003-_writablestatebuffer)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0003_writablestate_buffer.html)

类型: 运行时

`_writableState.buffer` 属性已弃用。

#### DEP0004: `CryptoStream.prototype.readyState`[#](http://nodejs.cn/api-v12/deprecations.html#dep0004-cryptostreamprototypereadystate)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0004_cryptostream_prototype_readystate.html)

类型: 生命结束

`CryptoStream.prototype.readyState` 属性已被删除。

#### DEP0005: Buffer() 构造函数[#](http://nodejs.cn/api-v12/deprecations.html#dep0005-buffer-constructor)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0005_buffer_constructor.html)

类型: 运行时（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

由于可能导致意外安全问题的 API 可用性问题，`Buffer()` 函数和 `new Buffer()` 构造函数已弃用。

作为替代方案，使用以下方法之一构造 `Buffer` 对象：

-   [`Buffer.alloc(size[, fill[, encoding]])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_alloc_size_fill_encoding): 使用已初始化的内存创建 `Buffer`。
-   [`Buffer.allocUnsafe(size)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size): 使用未初始化的内存创建 `Buffer`。
-   [`Buffer.allocUnsafeSlow(size)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size): 使用未初始化的内存创建 `Buffer`。
-   [`Buffer.from(array)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_array): 使用 `array` 的副本创建 `Buffer`
-   [`Buffer.from(arrayBuffer[, byteOffset[, length]])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_arraybuffer_byteoffset_length) - 创建封装给定 `arrayBuffer` 的 `Buffer`。
-   [`Buffer.from(buffer)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_buffer): 创建拷贝 `buffer` 的 `Buffer`。
-   [`Buffer.from(string[, encoding])`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_from_string_encoding): 创建拷贝 `string` 的 `Buffer`。

没有 `--pending-deprecation`，运行时警告只会出现在不在 `node_modules` 中的代码。 这意味着在依赖项中使用 `Buffer()` 不会出现弃用警告。 对于 `--pending-deprecation`，无论在何处使用 `Buffer()`，都会产生运行时警告。

#### DEP0006: `child_process` `options.customFds`[#](http://nodejs.cn/api-v12/deprecations.html#dep0006-child_process-optionscustomfds)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0006_child_process_options_customfds.html)

类型: 生命结束

在 [`child_process`](http://nodejs.cn/api-v12/child_process.html) 模块的 `spawn()`、`fork()` 和 `exec()` 方法中，`options.customFds` 选项已弃用。 应该使用 `options.stdio` 选项。

#### DEP0007: 使用 worker.exitedAfterDisconnect 替换集群的 worker.suicide[#](http://nodejs.cn/api-v12/deprecations.html#dep0007-replace-cluster-workersuicide-with-workerexitedafterdisconnect)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0007_replace_cluster_worker_suicide_with_worker_exitedafterdisconnect.html)

类型: 生命结束

在 Node.js `cluster` 的早期版本中，名为 `suicide` 的布尔属性被添加到 `Worker` 对象中。 此属性的目的是提供 `Worker` 实例退出的方式和原因的指示。 在 Node.js 6.0.0 中， 旧属性已被弃用，并被新的 [`worker.exitedAfterDisconnect`](http://nodejs.cn/api-v12/cluster.html#cluster_worker_exitedafterdisconnect) 属性替换。 旧版的属性名称没有准确描述实际的语义，并且不必要地充满了情感。

#### DEP0008: `require('constants')`[#](http://nodejs.cn/api-v12/deprecations.html#dep0008-requireconstants)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0008_require_constants.html)

类型: 仅文档

`constants` 模块已弃用。 当需要访问与特定 Node.js 内置模块相关的常量时，开发者应改为参考相关模块公开的 `constants` 属性。 例如，`require('fs').constants` 和 `require('os').constants`。

#### DEP0009: 没有摘要的 crypto.pbkdf2[#](http://nodejs.cn/api-v12/deprecations.html#dep0009-cryptopbkdf2-without-digest)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0009_crypto_pbkdf2_without_digest.html)

类型: 运行时

在 Node.js 6.0 中，不指定摘要的 [`crypto.pbkdf2()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_pbkdf2_password_salt_iterations_keylen_digest_callback) API 已弃用，因为该方法默认使用非推荐的 `'SHA1'` 摘要。 以前，打印过弃用警告。 从 Node.js 8.0.0 开始，在 `digest` 设置为 `undefined` 的情况下调用 `crypto.pbkdf2()` 或 `crypto.pbkdf2Sync()` 将抛出 `TypeError`。

#### DEP0010: `crypto.createCredentials`[#](http://nodejs.cn/api-v12/deprecations.html#dep0010-cryptocreatecredentials)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0010_crypto_createcredentials.html)

类型: 生命结束

`crypto.createCredentials()` API 已被移除。 请改用 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options)。

#### DEP0011: `crypto.Credentials`[#](http://nodejs.cn/api-v12/deprecations.html#dep0011-cryptocredentials)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0011_crypto_credentials.html)

类型: 生命结束

`crypto.Credentials` 类已被删除。 请改用 [`tls.SecureContext`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options)。

#### DEP0012: `Domain.dispose`[#](http://nodejs.cn/api-v12/deprecations.html#dep0012-domaindispose)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0012_domain_dispose.html)

类型: 生命结束

`Domain.dispose()` 已被删除。 改为通过在域上设置的错误事件处理程序显式从失败的 I/O 操作中恢复。

#### DEP0013: 没有回调的 fs 异步函数[#](http://nodejs.cn/api-v12/deprecations.html#dep0013-fs-asynchronous-function-without-callback)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0013_fs_asynchronous_function_without_callback.html)

类型: 生命结束

在 Node.js 10.0.0 及更高版本中调用没有回调的异步函数会引发 `TypeError`。 参阅 [https://github.com/nodejs/node/pull/12562](https://github.com/nodejs/node/pull/12562)。

#### DEP0014: fs.read 旧版的字符串接口[#](http://nodejs.cn/api-v12/deprecations.html#dep0014-fsread-legacy-string-interface)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0014_fs_read_legacy_string_interface.html)

类型: 生命结束

[`fs.read()`](http://nodejs.cn/api-v12/fs.html#fs_fs_read_fd_buffer_offset_length_position_callback) 旧版的 `String` 接口已弃用。 改用文档中提到的 `Buffer` API。

#### DEP0015: fs.readSync 旧版的字符串接口[#](http://nodejs.cn/api-v12/deprecations.html#dep0015-fsreadsync-legacy-string-interface)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0015_fs_readsync_legacy_string_interface.html)

类型: 生命结束

[`fs.readSync()`](http://nodejs.cn/api-v12/fs.html#fs_fs_readsync_fd_buffer_offset_length_position) 旧版的 `String` 接口已弃用。 改用文档中提到的 `Buffer` API。

#### DEP0016: `GLOBAL`/`root`[#](http://nodejs.cn/api-v12/deprecations.html#dep0016-globalroot)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0016_global_root.html)

类型: 运行时

#### DEP0017: `Intl.v8BreakIterator`[#](http://nodejs.cn/api-v12/deprecations.html#dep0017-intlv8breakiterator)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0017_intl_v8breakiterator.html)

类型: 生命结束

`Intl.v8BreakIterator` 是非标准的扩展，已被删除。 参阅 [`Intl.Segmenter`](https://github.com/tc39/proposal-intl-segmenter)。

#### DEP0018: 未处理的 promise 拒绝[#](http://nodejs.cn/api-v12/deprecations.html#dep0018-unhandled-promise-rejections)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0018_unhandled_promise_rejections.html)

类型: 运行时

未处理的 promise 拒绝已弃用。 将来，未处理的 promise 拒绝将使用非零退出代码终止 Node.js 进程。

#### DEP0019: require('.') 在目录外解析[#](http://nodejs.cn/api-v12/deprecations.html#dep0019-require-resolved-outside-directory)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0019_require_resolved_outside_directory.html)

类型: 生命结束

在某些情况下，`require('.')` 可以在包目录之外解析。 此行为已被删除。

#### DEP0020: `Server.connections`[#](http://nodejs.cn/api-v12/deprecations.html#dep0020-serverconnections)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0020_server_connections.html)

类型: 运行时

[`Server.connections`](http://nodejs.cn/api-v12/net.html#net_server_connections) 属性已弃用。 请改用 [`Server.getConnections()`](http://nodejs.cn/api-v12/net.html#net_server_getconnections_callback) 方法。

#### DEP0021: `Server.listenFD`[#](http://nodejs.cn/api-v12/deprecations.html#dep0021-serverlistenfd)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0021_server_listenfd.html)

类型: 生命结束

`Server.listenFD()` 方法已被弃用并删除。 请改用 [`Server.listen({fd: <number>})`](http://nodejs.cn/api-v12/net.html#net_server_listen_handle_backlog_callback)。

#### DEP0022: `os.tmpDir()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0022-ostmpdir)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0022_os_tmpdir.html)

类型: 运行时

`os.tmpDir()` API 已弃用。 请改用 [`os.tmpdir()`](http://nodejs.cn/api-v12/os.html#os_os_tmpdir)。

#### DEP0023: `os.getNetworkInterfaces()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0023-osgetnetworkinterfaces)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0023_os_getnetworkinterfaces.html)

类型: 生命结束

`os.getNetworkInterfaces()` 方法已弃用。 请改用 [`os.networkInterfaces()`](http://nodejs.cn/api-v12/os.html#os_os_networkinterfaces) 方法。

#### DEP0024: `REPLServer.prototype.convertToContext()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0024-replserverprototypeconverttocontext)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0024_replserver_prototype_converttocontext.html)

类型: 生命结束

`REPLServer.prototype.convertToContext()` API 已被移除。

#### DEP0025: `require('sys')`[#](http://nodejs.cn/api-v12/deprecations.html#dep0025-requiresys)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0025_require_sys.html)

类型: 运行时

`sys` 模块已弃用。 请改用 [`util`](http://nodejs.cn/api-v12/util.html) 模块。

#### DEP0026: `util.print()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0026-utilprint)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0026_util_print.html)

类型: 生命结束

`util.print()` 已被删除。 请改用 [`console.log()`](http://nodejs.cn/api-v12/console.html#console_console_log_data_args)。

#### DEP0027: `util.puts()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0027-utilputs)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0027_util_puts.html)

类型: 生命结束

`util.puts()` 已被删除。 请改用 [`console.log()`](http://nodejs.cn/api-v12/console.html#console_console_log_data_args)。

#### DEP0028: `util.debug()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0028-utildebug)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0028_util_debug.html)

类型: 生命结束

`util.debug()` 已被删除。 请改用 [`console.error()`](http://nodejs.cn/api-v12/console.html#console_console_error_data_args)。

#### DEP0029: `util.error()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0029-utilerror)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0029_util_error.html)

类型: 生命结束

`util.error()` 已被删除。 请改用 [`console.error()`](http://nodejs.cn/api-v12/console.html#console_console_error_data_args)。

#### DEP0030: `SlowBuffer`[#](http://nodejs.cn/api-v12/deprecations.html#dep0030-slowbuffer)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0030_slowbuffer.html)

类型: 仅文档

[`SlowBuffer`](http://nodejs.cn/api-v12/buffer.html#buffer_class_slowbuffer) 类已弃用。 请改用 [`Buffer.allocUnsafeSlow(size)`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafeslow_size)。

#### DEP0031: `ecdh.setPublicKey()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0031-ecdhsetpublickey)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0031_ecdh_setpublickey.html)

类型: 仅文档

[`ecdh.setPublicKey()`](http://nodejs.cn/api-v12/crypto.html#crypto_ecdh_setpublickey_publickey_encoding) 方法现在已被弃用，因为它包含在 API 中没有用。

#### DEP0032: domain 模块[#](http://nodejs.cn/api-v12/deprecations.html#dep0032-domain-module)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0032_domain_module.html)

类型: 仅文档

[`domain`](http://nodejs.cn/api-v12/domain.html) 模块已弃用，不应使用。

#### DEP0033: `EventEmitter.listenerCount()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0033-eventemitterlistenercount)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0033_eventemitter_listenercount.html)

类型: 仅文档

[`EventEmitter.listenerCount(emitter, eventName)`](http://nodejs.cn/api-v12/events.html#events_eventemitter_listenercount_emitter_eventname) API 已弃用。 请改用 [`emitter.listenerCount(eventName)`](http://nodejs.cn/api-v12/events.html#events_emitter_listenercount_eventname)。

#### DEP0034: `fs.exists(path, callback)`[#](http://nodejs.cn/api-v12/deprecations.html#dep0034-fsexistspath-callback)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0034_fs_exists_path_callback.html)

类型: 仅文档

[`fs.exists(path, callback)`](http://nodejs.cn/api-v12/fs.html#fs_fs_exists_path_callback) API 已弃用。 请改用 [`fs.stat()`](http://nodejs.cn/api-v12/fs.html#fs_fs_stat_path_options_callback) 或 [`fs.access()`](http://nodejs.cn/api-v12/fs.html#fs_fs_access_path_mode_callback)。

#### DEP0035: `fs.lchmod(path, mode, callback)`[#](http://nodejs.cn/api-v12/deprecations.html#dep0035-fslchmodpath-mode-callback)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0035_fs_lchmod_path_mode_callback.html)

类型: 仅文档

[`fs.lchmod(path, mode, callback)`](http://nodejs.cn/api-v12/fs.html#fs_fs_lchmod_path_mode_callback) API 已弃用。

#### DEP0036: `fs.lchmodSync(path, mode)`[#](http://nodejs.cn/api-v12/deprecations.html#dep0036-fslchmodsyncpath-mode)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0036_fs_lchmodsync_path_mode.html)

类型: 仅文档

[`fs.lchmodSync(path, mode)`](http://nodejs.cn/api-v12/fs.html#fs_fs_lchmodsync_path_mode) API 已弃用。

#### DEP0037: `fs.lchown(path, uid, gid, callback)`[#](http://nodejs.cn/api-v12/deprecations.html#dep0037-fslchownpath-uid-gid-callback)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0037_fs_lchown_path_uid_gid_callback.html)

类型: 弃用已撤销

[`fs.lchown(path, uid, gid, callback)`](http://nodejs.cn/api-v12/fs.html#fs_fs_lchown_path_uid_gid_callback) API 已被弃用。 由于在 libuv 中添加了必要的支持 API，因此弃用已被撤销。

#### DEP0038: `fs.lchownSync(path, uid, gid)`[#](http://nodejs.cn/api-v12/deprecations.html#dep0038-fslchownsyncpath-uid-gid)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0038_fs_lchownsync_path_uid_gid.html)

类型: 弃用已撤销

[`fs.lchownSync(path, uid, gid)`](http://nodejs.cn/api-v12/fs.html#fs_fs_lchownsync_path_uid_gid) API 已被弃用。 由于在 libuv 中添加了必要的支持 API，因此弃用已被撤销。

#### DEP0039: `require.extensions`[#](http://nodejs.cn/api-v12/deprecations.html#dep0039-requireextensions)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0039_require_extensions.html)

类型: 仅文档

[`require.extensions`](http://nodejs.cn/api-v12/modules.html#modules_require_extensions) 属性已弃用。

#### DEP0040: punycode 模块[#](http://nodejs.cn/api-v12/deprecations.html#dep0040-punycode-module)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0040_punycode_module.html)

类型: 仅文档

[`punycode`](http://nodejs.cn/api-v12/punycode.html) 模块已弃用。 请使用用户空间替代方案。

#### DEP0041: NODE\_REPL\_HISTORY\_FILE 环境变量[#](http://nodejs.cn/api-v12/deprecations.html#dep0041-node_repl_history_file-environment-variable)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0041_node_repl_history_file_environment_variable.html)

类型: 生命结束

`NODE_REPL_HISTORY_FILE` 环境变量已被删除。 请改用 `NODE_REPL_HISTORY`。

#### DEP0042: `tls.CryptoStream`[#](http://nodejs.cn/api-v12/deprecations.html#dep0042-tlscryptostream)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0042_tls_cryptostream.html)

类型: 生命结束

[`tls.CryptoStream`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_cryptostream) 类已被删除。 请改用 [`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket)。

#### DEP0043: `tls.SecurePair`[#](http://nodejs.cn/api-v12/deprecations.html#dep0043-tlssecurepair)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0043_tls_securepair.html)

类型: 仅文档

[`tls.SecurePair`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_securepair) 类已弃用。 请改用 [`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket)。

#### DEP0044: `util.isArray()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0044-utilisarray)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0044_util_isarray.html)

类型: 仅文档

[`util.isArray()`](http://nodejs.cn/api-v12/util.html#util_util_isarray_object) API 已弃用。 请改用 `Array.isArray()`。

#### DEP0045: `util.isBoolean()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0045-utilisboolean)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0045_util_isboolean.html)

类型: 仅文档

[`util.isBoolean()`](http://nodejs.cn/api-v12/util.html#util_util_isboolean_object) API 已弃用。

#### DEP0046: `util.isBuffer()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0046-utilisbuffer)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0046_util_isbuffer.html)

类型: 仅文档

[`util.isBuffer()`](http://nodejs.cn/api-v12/util.html#util_util_isbuffer_object) API 已弃用。 请改用 [`Buffer.isBuffer()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_isbuffer_obj)。

#### DEP0047: `util.isDate()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0047-utilisdate)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0047_util_isdate.html)

类型: 仅文档

[`util.isDate()`](http://nodejs.cn/api-v12/util.html#util_util_isdate_object) API 已弃用。

#### DEP0048: `util.isError()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0048-utiliserror)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0048_util_iserror.html)

类型: 仅文档

[`util.isError()`](http://nodejs.cn/api-v12/util.html#util_util_iserror_object) API 已弃用。

#### DEP0049: `util.isFunction()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0049-utilisfunction)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0049_util_isfunction.html)

类型: 仅文档

[`util.isFunction()`](http://nodejs.cn/api-v12/util.html#util_util_isfunction_object) API 已弃用。

#### DEP0050: `util.isNull()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0050-utilisnull)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0050_util_isnull.html)

类型: 仅文档

[`util.isNull()`](http://nodejs.cn/api-v12/util.html#util_util_isnull_object) API 已弃用。

#### DEP0051: `util.isNullOrUndefined()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0051-utilisnullorundefined)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0051_util_isnullorundefined.html)

类型: 仅文档

[`util.isNullOrUndefined()`](http://nodejs.cn/api-v12/util.html#util_util_isnullorundefined_object) API 已弃用。

#### DEP0052: `util.isNumber()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0052-utilisnumber)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0052_util_isnumber.html)

类型: 仅文档

[`util.isNumber()`](http://nodejs.cn/api-v12/util.html#util_util_isnumber_object) API 已弃用。

#### DEP0053 `util.isObject()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0053-utilisobject)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0053_util_isobject.html)

类型: 仅文档

[`util.isObject()`](http://nodejs.cn/api-v12/util.html#util_util_isobject_object) API 已弃用。

#### DEP0054: `util.isPrimitive()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0054-utilisprimitive)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0054_util_isprimitive.html)

类型: 仅文档

[`util.isPrimitive()`](http://nodejs.cn/api-v12/util.html#util_util_isprimitive_object) API 已弃用。

#### DEP0055: `util.isRegExp()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0055-utilisregexp)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0055_util_isregexp.html)

类型: 仅文档

[`util.isRegExp()`](http://nodejs.cn/api-v12/util.html#util_util_isregexp_object) API 已弃用。

#### DEP0056: `util.isString()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0056-utilisstring)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0056_util_isstring.html)

类型: 仅文档

[`util.isString()`](http://nodejs.cn/api-v12/util.html#util_util_isstring_object) API 已弃用。

#### DEP0057: `util.isSymbol()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0057-utilissymbol)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0057_util_issymbol.html)

类型: 仅文档

[`util.isSymbol()`](http://nodejs.cn/api-v12/util.html#util_util_issymbol_object) API 已弃用。

#### DEP0058: `util.isUndefined()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0058-utilisundefined)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0058_util_isundefined.html)

类型: 仅文档

[`util.isUndefined()`](http://nodejs.cn/api-v12/util.html#util_util_isundefined_object) API 已弃用。

#### DEP0059: `util.log()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0059-utillog)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0059_util_log.html)

类型: 仅文档

[`util.log()`](http://nodejs.cn/api-v12/util.html#util_util_log_string) API 已弃用。

#### DEP0060: `util._extend()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0060-util_extend)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0060_util_extend.html)

类型: 仅文档

[`util._extend()`](http://nodejs.cn/api-v12/util.html#util_util_extend_target_source) API 已弃用。

#### DEP0061: `fs.SyncWriteStream`[#](http://nodejs.cn/api-v12/deprecations.html#dep0061-fssyncwritestream)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0061_fs_syncwritestream.html)

类型: 生命结束

`fs.SyncWriteStream` 类从未打算成为可公开访问的 API，因此已被删除。 没有可用的替代 API。 请使用用户空间替代方案。

#### DEP0062: `node --debug`[#](http://nodejs.cn/api-v12/deprecations.html#dep0062-node---debug)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0062_node_debug.html)

类型: 生命结束

`--debug` 激活旧版的 V8 调试器接口，该接口在 V8 5.8 中被删除。它被替换为使用 `--inspect` 激活的检查器。

#### DEP0063: `ServerResponse.prototype.writeHeader()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0063-serverresponseprototypewriteheader)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0063_serverresponse_prototype_writeheader.html)

类型: 仅文档

`http` 模块 `ServerResponse.prototype.writeHeader()` API 已弃用。 请改用 `ServerResponse.prototype.writeHead()`。

`ServerResponse.prototype.writeHeader()` 方法从未被记录为官方支持的 API。

#### DEP0064: `tls.createSecurePair()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0064-tlscreatesecurepair)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0064_tls_createsecurepair.html)

类型: 运行时

`tls.createSecurePair()` API 在 Node.js 0.11.3 的文档中已弃用。 用户应该改用 `tls.Socket`。

#### DEP0065: repl.REPL\_MODE\_MAGIC 和 NODE\_REPL\_MODE=magic[#](http://nodejs.cn/api-v12/deprecations.html#dep0065-replrepl_mode_magic-and-node_repl_modemagic)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0065_repl_repl_mode_magic_and_node_repl_mode_magic.html)

类型: 生命结束

`repl` 模块的 `REPL_MODE_MAGIC` 常量，用于 `replMode` 选项，已被删除。 自 Node.js 6.0.0 以来，当导入 V8 5.0 时，它的行为在功能上与 `REPL_MODE_SLOPPY` 相同。 请改用 `REPL_MODE_SLOPPY`。

`NODE_REPL_MODE` 环境变量用于设置交互式 `node` 会话的底层 `replMode`。 它的值 `magic` 也被删除了。 请改用 `sloppy`。

#### DEP0066: `OutgoingMessage.prototype._headers, OutgoingMessage.prototype._headerNames`[#](http://nodejs.cn/api-v12/deprecations.html#dep0066-outgoingmessageprototype_headers-outgoingmessageprototype_headernames)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0066_outgoingmessage_prototype_headers_outgoingmessage_prototype_headernames.html)

类型: 运行时

`http` 模块 `OutgoingMessage.prototype._headers` 和 `OutgoingMessage.prototype._headerNames` 属性已弃用。

`OutgoingMessage.prototype._headers` 和 `OutgoingMessage.prototype._headerNames` 属性从未被记录为官方支持的属性。

#### DEP0067: `OutgoingMessage.prototype._renderHeaders`[#](http://nodejs.cn/api-v12/deprecations.html#dep0067-outgoingmessageprototype_renderheaders)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0067_outgoingmessage_prototype_renderheaders.html)

类型: 仅文档

`http` 模块 `OutgoingMessage.prototype._renderHeaders()` API 已弃用。

`OutgoingMessage.prototype._renderHeaders` 属性从未被记录为官方支持的 API。

#### DEP0068: `node debug`[#](http://nodejs.cn/api-v12/deprecations.html#dep0068-node-debug)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0068_node_debug.html)

类型: 运行时

`node debug` 对应于旧版的命令行调试器，它已被替换为可通过 `node inspect` 获得的基于 V8 检查器的命令行调试器。

#### DEP0069: `vm.runInDebugContext(string)`[#](http://nodejs.cn/api-v12/deprecations.html#dep0069-vmrunindebugcontextstring)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0069_vm_runindebugcontext_string.html)

类型: 生命结束

DebugContext 已在 V8 中删除，在 Node.js 10+ 中不可用。

DebugContext 是实验性的 API。

#### DEP0070: `async_hooks.currentId()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0070-async_hookscurrentid)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0070_async_hooks_currentid.html)

类型: 生命结束

为清楚起见，`async_hooks.currentId()` 已重命名为 `async_hooks.executionAsyncId()`。

此更改是在 `async_hooks` 是实验性 API 时进行的。

#### DEP0071: `async_hooks.triggerId()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0071-async_hookstriggerid)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0071_async_hooks_triggerid.html)

类型: 生命结束

为清楚起见，`async_hooks.triggerId()` 已重命名为 `async_hooks.triggerAsyncId()`。

此更改是在 `async_hooks` 是实验性 API 时进行的。

#### DEP0072: `async_hooks.AsyncResource.triggerId()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0072-async_hooksasyncresourcetriggerid)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0072_async_hooks_asyncresource_triggerid.html)

类型: 生命结束

为清楚起见，`async_hooks.AsyncResource.triggerId()` 已重命名为 `async_hooks.AsyncResource.triggerAsyncId()`。

此更改是在 `async_hooks` 是实验性 API 时进行的。

#### DEP0073: net.Server 的几个内部属性[#](http://nodejs.cn/api-v12/deprecations.html#dep0073-several-internal-properties-of-netserver)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0073_several_internal_properties_of_net_server.html)

类型: 生命结束

不适当的名称访问 `net.Server` 实例的多个内部、未记录的属性已弃用。

由于原始的 API 未记录并且通常对非内部代码没有用处，因此不提供替代 API。

#### DEP0074: `REPLServer.bufferedCommand`[#](http://nodejs.cn/api-v12/deprecations.html#dep0074-replserverbufferedcommand)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0074_replserver_bufferedcommand.html)

类型: 运行时

`REPLServer.bufferedCommand` 属性已被 [`REPLServer.clearBufferedCommand()`](http://nodejs.cn/api-v12/repl.html#repl_replserver_clearbufferedcommand) 弃用。

#### DEP0075: `REPLServer.parseREPLKeyword()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0075-replserverparsereplkeyword)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0075_replserver_parsereplkeyword.html)

类型: 运行时

`REPLServer.parseREPLKeyword()` 已从用户空间可见性中删除。

#### DEP0076: `tls.parseCertString()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0076-tlsparsecertstring)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0076_tls_parsecertstring.html)

类型: 运行时

`tls.parseCertString()` 是简单的解析助手，被错误地公开了。 此函数通常可以替换为：

```
const querystring = require('querystring');
querystring.parse(str, '\n', '=');
```

此函数不完全等同于 `querystring.parse()`。 一个区别是 `querystring.parse()` 做 url 解码：

```
> querystring.parse('%E5%A5%BD=1', '\n', '=');
{ '好': '1' }
> tls.parseCertString('%E5%A5%BD=1');
{ '%E5%A5%BD': '1' }
```

#### DEP0077: `Module._debug()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0077-module_debug)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0077_module_debug.html)

类型: 运行时

`Module._debug()` 已弃用。

`Module._debug()` 函数从未被记录为官方支持的 API。

#### DEP0078: `REPLServer.turnOffEditorMode()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0078-replserverturnoffeditormode)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0078_replserver_turnoffeditormode.html)

类型: 运行时

`REPLServer.turnOffEditorMode()` 已从用户空间可见性中删除。

#### DEP0079: 通过 .inspect() 对对象进行自定义检查函数[#](http://nodejs.cn/api-v12/deprecations.html#dep0079-custom-inspection-function-on-objects-via-inspect)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0079_custom_inspection_function_on_objects_via_inspect.html)

类型: 生命结束

对象上名为 `inspect` 的属性来指定 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 的自定义检查函数已弃用。 改用 [`util.inspect.custom`](http://nodejs.cn/api-v12/util.html#util_util_inspect_custom)。

#### DEP0080: `path._makeLong()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0080-path_makelong)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0080_path_makelong.html)

类型: 仅文档

内部的 `path._makeLong()` 不打算供公众使用。 但是，用户空间模块发现它很有用。 内部的 API 已被弃用，取而代之的是相同的公共 `path.toNamespacedPath()` 方法。

#### DEP0081: 使用文件描述符的 fs.truncate()[#](http://nodejs.cn/api-v12/deprecations.html#dep0081-fstruncate-using-a-file-descriptor)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0081_fs_truncate_using_a_file_descriptor.html)

类型: 运行时

`fs.truncate()` `fs.truncateSync()` 使用文件描述符已被弃用。 请使用 `fs.ftruncate()` 或 `fs.ftruncateSync()` 来处理文件描述符。

#### DEP0082: `REPLServer.prototype.memory()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0082-replserverprototypememory)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0082_replserver_prototype_memory.html)

类型: 运行时

`REPLServer.prototype.memory()` 只对 `REPLServer` 本身的内部机制是必需的。 不要使用此函数。

#### DEP0083: 通过将 ecdhCurve 设置为 false 来禁用 ECDH[#](http://nodejs.cn/api-v12/deprecations.html#dep0083-disabling-ecdh-by-setting-ecdhcurve-to-false)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0083_disabling_ecdh_by_setting_ecdhcurve_to_false.html)

类型: 生命结束。

`tls.createSecureContext()` 和 `tls.TLSSocket` 的 `ecdhCurve` 选项可以设置为 `false` 以仅在服务器上完全禁用 ECDH。 在准备迁移到 OpenSSL 1.1.0 并与客户端保持一致时，此模式已弃用，现在不受支持。 改用 `ciphers` 参数。

#### DEP0084: 需要捆绑的内部依赖项[#](http://nodejs.cn/api-v12/deprecations.html#dep0084-requiring-bundled-internal-dependencies)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0084_requiring_bundled_internal_dependencies.html)

类型: 生命结束

从 Node.js 4.4.0 和 5.2.0 版本开始，一些仅供内部使用的模块被错误地通过 `require()` 暴露给用户代码。 这些模块是：

-   `v8/tools/codemap`
-   `v8/tools/consarray`
-   `v8/tools/csvparser`
-   `v8/tools/logreader`
-   `v8/tools/profile_view`
-   `v8/tools/profile`
-   `v8/tools/SourceMap`
-   `v8/tools/splaytree`
-   `v8/tools/tickprocessor-driver`
-   `v8/tools/tickprocessor`
-   `node-inspect/lib/_inspect`（从 7.6.0 开始）
-   `node-inspect/lib/internal/inspect_client`（从 7.6.0 开始）
-   `node-inspect/lib/internal/inspect_repl`（从 7.6.0 开始）

`v8/*` 模块没有任何导出，如果不按特定顺序导入实际上会抛出错误。 因此，几乎没有通过 `require()` 导入它们的合法用例。

如果这样做，则无需修改源代码。

#### DEP0085: AsyncHooks 的敏感 API[#](http://nodejs.cn/api-v12/deprecations.html#dep0085-asynchooks-sensitive-api)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0085_asynchooks_sensitive_api.html)

类型: 生命结束

AsyncHooks 的敏感 API 从未被记录并且存在各种小问题。 改用 `AsyncResource` API。 参阅 [https://github.com/nodejs/node/issues/15572](https://github.com/nodejs/node/issues/15572)。

#### DEP0086: 删除 runInAsyncIdScope[#](http://nodejs.cn/api-v12/deprecations.html#dep0086-remove-runinasyncidscope)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0086_remove_runinasyncidscope.html)

类型: 生命结束

`runInAsyncIdScope` 不会触发 `'before'` 或 `'after'` 事件，因此会导致很多问题。 参阅 [https://github.com/nodejs/node/issues/14328](https://github.com/nodejs/node/issues/14328)。

#### DEP0089: `require('assert')`[#](http://nodejs.cn/api-v12/deprecations.html#dep0089-requireassert)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0089_require_assert.html)

类型: 弃用已撤销

不建议直接导入断言，因为公开的函数使用松散的相等检查。 弃用被撤销是因为不鼓励使用 `assert` 模块，弃用导致开发者困惑。

#### DEP0090: 无效的 GCM 身份验证标签长度[#](http://nodejs.cn/api-v12/deprecations.html#dep0090-invalid-gcm-authentication-tag-lengths)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0090_invalid_gcm_authentication_tag_lengths.html)

类型: 生命结束

Node.js 用于支持调用 [`decipher.setAuthTag()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_setauthtag_buffer) 时 OpenSSL 接受的所有 GCM 身份验证标签长度。 从 Node.js v11.0.0 开始，只允许 128、120、112、104、96、64 和 32 位的身份验证标签长度。 根据 [NIST SP 800-38D](http://url.nodejs.cn/G26eau)，其他长度的身份验证标签无效。

#### DEP0091: `crypto.DEFAULT_ENCODING`[#](http://nodejs.cn/api-v12/deprecations.html#dep0091-cryptodefault_encoding)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0091_crypto_default_encoding.html)

类型: 运行时

[`crypto.DEFAULT_ENCODING`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_default_encoding) 属性已弃用。

#### DEP0092: 顶层 this 绑定到 module.exports[#](http://nodejs.cn/api-v12/deprecations.html#dep0092-top-level-this-bound-to-moduleexports)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0092_top_level_this_bound_to_module_exports.html)

类型: 仅文档

将属性分配给顶层 `this` 作为 `module.exports` 的替代方法已弃用。 开发者应该使用 `exports` 或 `module.exports`。

#### DEP0093: crypto.fips 已弃用和替换[#](http://nodejs.cn/api-v12/deprecations.html#dep0093-cryptofips-is-deprecated-and-replaced)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0093_crypto_fips_is_deprecated_and_replaced.html)

类型: 仅文档

[`crypto.fips`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_fips) 属性已弃用。 请改用 `crypto.setFips()` 和 `crypto.getFips()`。

#### DEP0094: 使用带有多个参数的 assert.fail()[#](http://nodejs.cn/api-v12/deprecations.html#dep0094-using-assertfail-with-more-than-one-argument)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0094_using_assert_fail_with_more_than_one_argument.html)

类型: 运行时

使用多个参数的 `assert.fail()` 已弃用。 仅使用一个参数使用 `assert.fail()` 或使用不同的 `assert` 模块方法。

#### DEP0095: `timers.enroll()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0095-timersenroll)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0095_timers_enroll.html)

类型: 运行时

`timers.enroll()` 已弃用。 请改用公开记录的 [`setTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_settimeout_callback_delay_args) 或 [`setInterval()`](http://nodejs.cn/api-v12/timers.html#timers_setinterval_callback_delay_args)。

#### DEP0096: `timers.unenroll()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0096-timersunenroll)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0096_timers_unenroll.html)

类型: 运行时

`timers.unenroll()` 已弃用。 请改用公开记录的 [`clearTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_cleartimeout_timeout) 或 [`clearInterval()`](http://nodejs.cn/api-v12/timers.html#timers_clearinterval_timeout)。

#### DEP0097: 具有域属性的 MakeCallback[#](http://nodejs.cn/api-v12/deprecations.html#dep0097-makecallback-with-domain-property)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0097_makecallback_with_domain_property.html)

类型: 运行时

添加 `domain` 属性携带上下文的 `MakeCallback` 的用户，应该开始使用 `MakeCallback` 或 `CallbackScope` 的 `async_context` 变体，或者高层的 `AsyncResource` 类。

#### DEP0098: AsyncHooks 嵌入器 AsyncResource.emitBefore 和 AsyncResource.emitAfter API[#](http://nodejs.cn/api-v12/deprecations.html#dep0098-asynchooks-embedder-asyncresourceemitbefore-and-asyncresourceemitafter-apis)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0098_asynchooks_embedder_asyncresource_emitbefore_and_asyncresource_emitafter_apis.html)

类型: 生命结束

AsyncHooks 提供的嵌入式 API 暴露了 `.emitBefore()` 和 `.emitAfter()` 方法，这些方法很容易被错误地使用，从而导致不可恢复的错误。

改用 [`asyncResource.runInAsyncScope()`](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_asyncresource_runinasyncscope_fn_thisarg_args) API，它提供了更安全、更方便的替代方案。 参阅 [https://github.com/nodejs/node/pull/18513](https://github.com/nodejs/node/pull/18513)。

#### DEP0099: 异步上下文不感知的 node::MakeCallback C++ API[#](http://nodejs.cn/api-v12/deprecations.html#dep0099-async-context-unaware-nodemakecallback-c-apis)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0099_async_context_unaware_node_makecallback_c_apis.html)

类型: 编译时

原生模块可用的某些版本的 `node::MakeCallback` API 已被弃用。 请使用接受 `async_context` 参数的 API 版本。

#### DEP0100: `process.assert()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0100-processassert)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0100_process_assert.html)

类型: 运行时

`process.assert()` 已弃用。 请改用 [`assert`](http://nodejs.cn/api-v12/assert.html) 模块。

这从来都不是记录的特性。

#### DEP0101: `--with-lttng`[#](http://nodejs.cn/api-v12/deprecations.html#dep0101---with-lttng)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0101_with_lttng.html)

类型: 生命结束

`--with-lttng` 编译时选项已被删除。

#### DEP0102: 在 Buffer#(read|write) 操作中使用 noAssert[#](http://nodejs.cn/api-v12/deprecations.html#dep0102-using-noassert-in-bufferreadwrite-operations)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0102_using_noassert_in_buffer_read_write_operations.html)

类型: 生命结束

使用 `noAssert` 参数不再起作用。 所有输入都将被验证，无论它是否设置为真。 跳过验证可能会导致难以发现错误和崩溃。

#### DEP0103: process.binding('util').is\[...\] 类型检查[#](http://nodejs.cn/api-v12/deprecations.html#dep0103-processbindingutilis-typechecks)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0103_process_binding_util_is_typechecks.html)

类型: 仅文档（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

一般应避免使用 `process.binding()`。 特别是类型检查方法可以使用 [`util.types`](http://nodejs.cn/api-v12/util.html#util_util_types) 代替。

此弃用已被 `process.binding()` API ([DEP0111](http://nodejs.cn/api-v12/deprecations.html#DEP0111)) 的弃用所取代。

#### DEP0104: process.env 字符串强制转换[#](http://nodejs.cn/api-v12/deprecations.html#dep0104-processenv-string-coercion)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0104_process_env_string_coercion.html)

类型: 仅文档（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

将非字符串属性赋值给 [`process.env`](http://nodejs.cn/api-v12/process.html#process_process_env) 时，赋值隐式转换为字符串。 如果分配的值不是字符串、布尔值或数字，则此行为已弃用。

请先将该属性转换为字符串，然后再将其分配给 `process.env`。

#### DEP0105: `decipher.finaltol`[#](http://nodejs.cn/api-v12/deprecations.html#dep0105-decipherfinaltol)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0105_decipher_finaltol.html)

类型: 生命结束

`decipher.finaltol()` 从未被记录，它是 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding) 的别名。 此 API 已移除，建议改用 [`decipher.final()`](http://nodejs.cn/api-v12/crypto.html#crypto_decipher_final_outputencoding)。

#### DEP0106: crypto.createCipher 和 crypto.createDecipher[#](http://nodejs.cn/api-v12/deprecations.html#dep0106-cryptocreatecipher-and-cryptocreatedecipher)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0106_crypto_createcipher_and_crypto_createdecipher.html)

类型: 运行时

应避免使用 [`crypto.createCipher()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createcipher_algorithm_password_options) 和 [`crypto.createDecipher()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createdecipher_algorithm_password_options)，因为它们使用弱密钥派生函数（不含盐的 MD5）和静态初始化向量。 推荐使用 [`crypto.pbkdf2()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_pbkdf2_password_salt_iterations_keylen_digest_callback) 或 [`crypto.scrypt()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_scrypt_password_salt_keylen_options_callback) 导出密钥，使用 [`crypto.createCipheriv()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createcipheriv_algorithm_key_iv_options) 和 [`crypto.createDecipheriv()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_createdecipheriv_algorithm_key_iv_options) 分别获取 [`Cipher`](http://nodejs.cn/api-v12/crypto.html#crypto_class_cipher) 和 [`Decipher`](http://nodejs.cn/api-v12/crypto.html#crypto_class_decipher) 对象。

#### DEP0107: `tls.convertNPNProtocols()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0107-tlsconvertnpnprotocols)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0107_tls_convertnpnprotocols.html)

类型: 生命结束

这是未记录的帮助函数，不打算在 Node.js 核心之外使用，并且因删除 NPN（下一个协议协商）支持而过时。

#### DEP0108: `zlib.bytesRead`[#](http://nodejs.cn/api-v12/deprecations.html#dep0108-zlibbytesread)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0108_zlib_bytesread.html)

类型: 运行时

弃用的 [`zlib.bytesWritten`](http://nodejs.cn/api-v12/zlib.html#zlib_zlib_byteswritten) 别名。 选择这个原始名称是因为将值解释为引擎读取的字节数也是有意义的，但与 Node.js 中以这些名称公开值的其他流不一致。

#### DEP0109: 无效 URL 的 http、https 和 tls 支持[#](http://nodejs.cn/api-v12/deprecations.html#dep0109-http-https-and-tls-support-for-invalid-urls)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0109_http_https_and_tls_support_for_invalid_urls.html)

类型: 运行时

一些以前支持（但严格无效）的 URL 已通过 [`http.request()`](http://nodejs.cn/api-v12/http.html#http_http_request_options_callback)、[`http.get()`](http://nodejs.cn/api-v12/http.html#http_http_get_options_callback)、[`https.request()`](http://nodejs.cn/api-v12/https.html#https_https_request_options_callback)、[`https.get()`](http://nodejs.cn/api-v12/https.html#https_https_get_options_callback) 和 [`tls.checkServerIdentity()`](http://nodejs.cn/api-v12/tls.html#tls_tls_checkserveridentity_hostname_cert) API 接受，因为它们已被旧版的 `url.parse()` API 接受。 上述 API 现在使用 WHATWG URL 解析器，它需要严格有效的 URL。 传入无效的 URL 已被弃用，未来将删除支持。

#### DEP0110: vm.Script 缓存的数据[#](http://nodejs.cn/api-v12/deprecations.html#dep0110-vmscript-cached-data)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0110_vm_script_cached_data.html)

类型: 仅文档

`produceCachedData` 选项已弃用。 改用 [`script.createCachedData()`](http://nodejs.cn/api-v12/vm.html#vm_script_createcacheddata)。

#### DEP0111: `process.binding()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0111-processbinding)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0111_process_binding.html)

类型: 仅文档（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

`process.binding()` 仅供 Node.js 内部代码使用。

#### DEP0112: dgram 私有的 API[#](http://nodejs.cn/api-v12/deprecations.html#dep0112-dgram-private-apis)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0112_dgram_private_apis.html)

类型: 运行时

`dgram` 模块以前包含几个 API，这些 API 从未打算在 Node.js 核心之外访问：`Socket.prototype._handle`、`Socket.prototype._receiving`、`Socket.prototype._bindState`、`Socket.prototype._queue`、`Socket.prototype._reuseAddr`、`Socket.prototype._healthCheck()`、`Socket.prototype._stopReceiving()` 和 `dgram._createSocketHandle()`。

#### DEP0113: `Cipher.setAuthTag()`, `Decipher.getAuthTag()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0113-ciphersetauthtag-deciphergetauthtag)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0113_cipher_setauthtag_decipher_getauthtag.html)

类型: 生命结束

`Cipher.setAuthTag()` 和 `Decipher.getAuthTag()` 不再可用。 它们从未被记录，并且在被调用时会抛出。

#### DEP0114: `crypto._toBuf()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0114-crypto_tobuf)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0114_crypto_tobuf.html)

类型: 生命结束

`crypto._toBuf()` 函数不是为 Node.js 核心之外的模块设计的，因此被移除了。

#### DEP0115: `crypto.prng()`, `crypto.pseudoRandomBytes()`, `crypto.rng()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0115-cryptoprng-cryptopseudorandombytes-cryptorng)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0115_crypto_prng_crypto_pseudorandombytes_crypto_rng.html)

类型: 仅文档（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

在 Node.js 的最新版本中，[`crypto.randomBytes()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_randombytes_size_callback) 和 `crypto.pseudoRandomBytes()` 没有区别。

#### DEP0116: 旧版的 URL API[#](http://nodejs.cn/api-v12/deprecations.html#dep0116-legacy-url-api)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0116_legacy_url_api.html)

类型: 仅文档

[旧版的 URL API](http://nodejs.cn/api-v12/url.html#url_legacy_url_api) 已弃用。 这包括 [`url.format()`](http://nodejs.cn/api-v12/url.html#url_url_format_urlobject)、[`url.parse()`](http://nodejs.cn/api-v12/url.html#url_url_parse_urlstring_parsequerystring_slashesdenotehost)、[`url.resolve()`](http://nodejs.cn/api-v12/url.html#url_url_resolve_from_to) 和[旧版的 `urlObject`](http://nodejs.cn/api-v12/url.html#url_legacy_urlobject)。 请改用 [WHATWG URL API](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api)。

#### DEP0117: 原生加密句柄[#](http://nodejs.cn/api-v12/deprecations.html#dep0117-native-crypto-handles)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0117_native_crypto_handles.html)

类型: 生命结束

以前版本的 Node.js 通过 `Cipher`、`Decipher`、`DiffieHellman`、`DiffieHellmanGroup`、`ECDH`、`Hash`、`Hmac`、`Sign` 和 `Verify` 类的 `_handle` 属性向内部原生对象公开句柄。 `_handle` 属性已被移除，因为不当使用原生对象会导致应用程序崩溃。

#### DEP0118: dns.lookup() 支持虚假的主机名[#](http://nodejs.cn/api-v12/deprecations.html#dep0118-dnslookup-support-for-a-falsy-host-name)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0118_dns_lookup_support_for_a_falsy_host_name.html)

类型: 运行时

由于向后兼容，以前的 Node.js 版本支持使用虚假主机名的 `dns.lookup()`（如 `dns.lookup(false)`）。 此行为未记录，被认为在现实世界的应用程序中未使用。 在以后的 Node.js 版本中会出现错误。

#### DEP0119: process.binding('uv').errname() 私有的 API[#](http://nodejs.cn/api-v12/deprecations.html#dep0119-processbindinguverrname-private-api)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0119_process_binding_uv_errname_private_api.html)

类型: 仅文档（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

`process.binding('uv').errname()` 已弃用。 请改用 [`util.getSystemErrorName()`](http://nodejs.cn/api-v12/util.html#util_util_getsystemerrorname_err)。

#### DEP0120: Windows 性能计数器支持[#](http://nodejs.cn/api-v12/deprecations.html#dep0120-windows-performance-counter-support)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0120_windows_performance_counter_support.html)

类型: 生命结束

Windows 性能计数器支持已从 Node.js 中删除。 未记录的 `COUNTER_NET_SERVER_CONNECTION()`、`COUNTER_NET_SERVER_CONNECTION_CLOSE()`、`COUNTER_HTTP_SERVER_REQUEST()`、`COUNTER_HTTP_SERVER_RESPONSE()`、`COUNTER_HTTP_CLIENT_REQUEST()` 和 `COUNTER_HTTP_CLIENT_RESPONSE()` 函数已被弃用。

#### DEP0121: `net._setSimultaneousAccepts()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0121-net_setsimultaneousaccepts)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0121_net_setsimultaneousaccepts.html)

类型: 运行时

未记录的 `net._setSimultaneousAccepts()` 函数最初用于在 Windows 上使用 `child_process` 和 `cluster` 模块时进行调试和性能调整。 该函数一般不实用，正在被删除。 请参阅此处的讨论：[https://github.com/nodejs/node/issues/18391](https://github.com/nodejs/node/issues/18391)

#### DEP0122: `tls` `Server.prototype.setOptions()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0122-tls-serverprototypesetoptions)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0122_tls_server_prototype_setoptions.html)

类型: 运行时

请改用 `Server.prototype.setSecureContext()`。

#### DEP0123: 将 TLS ServerName 设置为 IP 地址[#](http://nodejs.cn/api-v12/deprecations.html#dep0123-setting-the-tls-servername-to-an-ip-address)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0123_setting_the_tls_servername_to_an_ip_address.html)

类型: 运行时

[RFC 6066](http://url.nodejs.cn/g4nt9S) 不允许将 TLS ServerName 设置为 IP 地址。 这将在以后的版本中被忽略。

#### DEP0124: 使用 REPLServer.rli[#](http://nodejs.cn/api-v12/deprecations.html#dep0124-using-replserverrli)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0124_using_replserver_rli.html)

类型: 运行时

此属性是对实例本身的引用。

#### DEP0125: `require('_stream_wrap')`[#](http://nodejs.cn/api-v12/deprecations.html#dep0125-require_stream_wrap)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0125_require_stream_wrap.html)

类型: 运行时

`_stream_wrap` 模块已弃用。

#### DEP0126: `timers.active()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0126-timersactive)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0126_timers_active.html)

类型: 运行时

以前未记录的 `timers.active()` 已弃用。 请改用公开记录的 [`timeout.refresh()`](http://nodejs.cn/api-v12/timers.html#timers_timeout_refresh)。 如果需要重新引用超时，则可以使用 [`timeout.ref()`](http://nodejs.cn/api-v12/timers.html#timers_timeout_ref)，而不会影响 Node.js 10 以来的性能。

#### DEP0127: `timers._unrefActive()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0127-timers_unrefactive)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0127_timers_unrefactive.html)

类型: 运行时

以前未记录和私有的 `timers._unrefActive()` 已弃用。 请改用公开记录的 [`timeout.refresh()`](http://nodejs.cn/api-v12/timers.html#timers_timeout_refresh)。 如果需要取消引用超时，则可以使用 [`timeout.unref()`](http://nodejs.cn/api-v12/timers.html#timers_timeout_unref)，从 Node.js 10 开始不会影响性能。

#### DEP0128: 具有无效主条目和 index.js 文件的模块[#](http://nodejs.cn/api-v12/deprecations.html#dep0128-modules-with-an-invalid-main-entry-and-an-indexjs-file)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0128_modules_with_an_invalid_main_entry_and_an_index_js_file.html)

类型: 仅文档（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

具有无效 `main` 条目（例如 `./does-not-exist.js`）并且在顶层目录中也有 `index.js` 文件的模块将解析 `index.js` 文件。 这已被弃用，并且会在未来的 Node.js 版本中引发错误。

#### DEP0129: `ChildProcess._channel`[#](http://nodejs.cn/api-v12/deprecations.html#dep0129-childprocess_channel)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0129_childprocess_channel.html)

类型: 仅文档

由 `spawn()` 和类似函数返回的子进程对象的 `_channel` 属性不适合公共使用。 改用 `ChildProcess.channel`。

#### DEP0130: `Module.createRequireFromPath()`[#](http://nodejs.cn/api-v12/deprecations.html#dep0130-modulecreaterequirefrompath)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0130_module_createrequirefrompath.html)

类型: 仅文档

Module.createRequireFromPath() 已弃用。 请改用 [`module.createRequire()`](http://nodejs.cn/api-v12/module.html#module_module_createrequire_filename)。

#### DEP0131: 旧版的 HTTP 解析器[#](http://nodejs.cn/api-v12/deprecations.html#dep0131-legacy-http-parser)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0131_legacy_http_parser.html)

类型: 运行时

#### DEP0132: 使用回调的 worker.terminate()[#](http://nodejs.cn/api-v12/deprecations.html#dep0132-workerterminate-with-callback)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0132_worker_terminate_with_callback.html)

类型: 运行时

将回调传给 [`worker.terminate()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_terminate) 已弃用。 使用返回的 `Promise` 代替，或者监听工作进程的 `'exit'` 事件。

#### DEP0133: `http` `connection`[#](http://nodejs.cn/api-v12/deprecations.html#dep0133-http-connection)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0133_http_connection.html)

类型: 仅文档

选择 [`response.socket`](http://nodejs.cn/api-v12/http.html#http_response_socket) 胜过 [`response.connection`](http://nodejs.cn/api-v12/http.html#http_response_connection)、[`request.socket`](http://nodejs.cn/api-v12/http.html#http_request_socket) 胜过 [`request.connection`](http://nodejs.cn/api-v12/http.html#http_request_connection)。

#### DEP0134: `process._tickCallback`[#](http://nodejs.cn/api-v12/deprecations.html#dep0134-process_tickcallback)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0134_process_tickcallback.html)

类型: 仅文档（支持 [`--pending-deprecation`](http://nodejs.cn/api-v12/cli.html#cli_pending_deprecation)）

`process._tickCallback` 属性从未被记录为官方支持的 API。

#### DEP0136: `http` `finished`[#](http://nodejs.cn/api-v12/deprecations.html#dep0136-http-finished)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0136_http_finished.html)

类型: 仅文档

[`response.finished`](http://nodejs.cn/api-v12/http.html#http_response_finished) 表示 [`response.end()`](http://nodejs.cn/api-v12/http.html#http_response_end_data_encoding_callback) 是否已被调用，而不是 `'finish'` 是否已触发并刷新底层数据。

为保持现有行为，`response.finished` 应替换为 `response.writableEnded`。

#### DEP0139: 不使用参数的 process.umask()[#](http://nodejs.cn/api-v12/deprecations.html#dep0139-processumask-with-no-arguments)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0139_process_umask_with_no_arguments.html)

类型: 仅文档

不带参数调用 `process.umask()` 会导致进程范围的 umask 被写入两次。 这会在线程之间引入竞争条件，并且是一个潜在的安全漏洞。 没有安全、跨平台的替代 API。

#### DEP0144: `module.parent`[#](http://nodejs.cn/api-v12/deprecations.html#dep0144-moduleparent)

[中英对照](http://nodejs.cn/api-v12/deprecations/dep0144_module_parent.html)

类型: 仅文档

CommonJS 模块可以使用 `module.parent` 访问第一个需要它的模块。 此特性已被弃用，因为它在存在 ECMAScript 模块的情况下无法始终如一地工作，并且因为它给出了 CommonJS 模块图的不准确表示。

一些模块用它来检查它们是否是当前进程的入口点。 而是，建议比较 `require.main` 和 `module`：

```
if (require.main === module) {
  // 仅当当前文件是入口点时才会运行的代码部分。
}
```

当查找需要当前的 CommonJS 模块时，可以使用 `require.cache` 和 `module.children`：

```
const moduleParents = Object.values(require.cache)
  .filter((m) => m.children.includes(module));
```
