---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/http2.html
author: #
---

# http2 超文本传输协议2.0 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/http2/http_2.html)

**源代码:** [lib/http2.js](https://github.com/nodejs/node/blob/v12.22.12/lib/http2.js)

`http2` 模块提供了 [HTTP/2](http://url.nodejs.cn/3LCB4F) 协议的实现。 可以使用以下方式访问它：

```
const http2 = require('http2');
```

### 核心 API[#](http://nodejs.cn/api-v12/http2.html#core-api)

[中英对照](http://nodejs.cn/api-v12/http2/core_api.html)

核心 API 提供了低层的接口，专门围绕支持 HTTP/2 协议功能而设计。 它专为与现有 [HTTP/1](http://nodejs.cn/api-v12/http.html) 模块 API 兼容而设计。 但是，[兼容性 API](http://nodejs.cn/api-v12/http2.html#http2_compatibility_api)是。

与 `http` API 相比，`http2` 核心 API 在客户端和服务器之间更加对称。 例如，大多数事件，如 `'error'`、`'connect'` 和 `'stream'`，可以由客户端代码或服务器端代码触发。

#### 服务器端示例[#](http://nodejs.cn/api-v12/http2.html#server-side-example)

[中英对照](http://nodejs.cn/api-v12/http2/server_side_example.html)

以下说明了使用核心 API 的简单 HTTP/2 服务器。 由于没有已知的浏览器支持[未加密的 HTTP/2](http://url.nodejs.cn/yfVdqh)，所以在与浏览器客户端通信时必须使用 [`http2.createSecureServer()`](http://nodejs.cn/api-v12/http2.html#http2_http2_createsecureserver_options_onrequesthandler)。

```
const http2 = require('http2');
const fs = require('fs');

const server = http2.createSecureServer({
  key: fs.readFileSync('localhost-privkey.pem'),
  cert: fs.readFileSync('localhost-cert.pem')
});
server.on('error', (err) => console.error(err));

server.on('stream', (stream, headers) => {
  // 流是双工的
  stream.respond({
    'content-type': 'text/html; charset=utf-8',
    ':status': 200
  });
  stream.end('<h1>Hello World</h1>');
});

server.listen(8443);
```

要为此示例生成证书和密钥，则运行：

```
openssl req -x509 -newkey rsa:2048 -nodes -sha256 -subj '/CN=localhost' \
  -keyout localhost-privkey.pem -out localhost-cert.pem
```

#### 客户端示例[#](http://nodejs.cn/api-v12/http2.html#client-side-example)

[中英对照](http://nodejs.cn/api-v12/http2/client_side_example.html)

以下说明了 HTTP/2 客户端：

```
const http2 = require('http2');
const fs = require('fs');
const client = http2.connect('https://localhost:8443', {
  ca: fs.readFileSync('localhost-cert.pem')
});
client.on('error', (err) => console.error(err));

const req = client.request({ ':path': '/' });

req.on('response', (headers, flags) => {
  for (const name in headers) {
    console.log(`${name}: ${headers[name]}`);
  }
});

req.setEncoding('utf8');
let data = '';
req.on('data', (chunk) => { data += chunk; });
req.on('end', () => {
  console.log(`\n${data}`);
  client.close();
});
req.end();
```

#### `Http2Session` 类[#](http://nodejs.cn/api-v12/http2.html#class-http2session)

[中英对照](http://nodejs.cn/api-v12/http2/class_http2session.html)

新增于: v8.4.0

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`http2.Http2Session` 类的实例表示 HTTP/2 客户端和服务器之间的活动通信会话。 此类的实例_不_旨在由用户代码直接构造。

每个 `Http2Session` 实例将表现出略有不同的行为，具体取决于它是作为服务器还是客户端运行。 `http2session.type` 属性可用于确定 `Http2Session` 的运行模式。 在服务器端，用户代码很少有机会直接使用 `Http2Session` 对象，大多数操作通常是通过与 `Http2Server` 或 `Http2Stream` 对象的交互来执行的。

用户代码不会直接创建 `Http2Session` 实例。 服务器端 `Http2Session` 实例是在接收到新的 HTTP/2 连接时由 `Http2Server` 实例创建的。 客户端 `Http2Session` 实例是使用 `http2.connect()` 方法创建的。

##### Http2Session 与 Socket[#](http://nodejs.cn/api-v12/http2.html#http2session-and-sockets)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_and_sockets.html)

每个 `Http2Session` 实例在创建时都与 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 或 [`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket) 关联。 当 `Socket` 或 `Http2Session` 被摧毁时，两者都会被摧毁。

由于 HTTP/2 协议规定的特定序列化和处理要求，不建议用户代码从绑定到 `Http2Session` 的 `Socket` 实例读取数据或向其写入数据。 这样做会使 HTTP/2 会话进入不确定状态，导致会话和套接字变得不可用。

一旦将 `Socket` 绑定到 `Http2Session`，用户代码应仅依赖于 `Http2Session` 的 API。

##### `'close'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-close)

[中英对照](http://nodejs.cn/api-v12/http2/event_close.html)

新增于: v8.4.0

`'close'` 事件在 `Http2Session` 被销毁后触发。 其监听器不需要任何参数。

##### `'connect'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-connect)

[中英对照](http://nodejs.cn/api-v12/http2/event_connect.html)

新增于: v8.4.0

-   `session` [<Http2Session>](http://nodejs.cn/api/http2.html#class-http2session)
-   `socket` [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

一旦 `Http2Session` 成功连接到远程对等方并且通信可以开始，则会触发 `'connect'` 事件。

用户代码通常不会直接监听此事件。

##### `'error'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-error)

[中英对照](http://nodejs.cn/api-v12/http2/event_error.html)

新增于: v8.4.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x)

`'error'` 事件在处理 `Http2Session` 期间发生错误时触发。

##### `'frameError'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-frameerror)

[中英对照](http://nodejs.cn/api-v12/http2/event_frameerror.html)

新增于: v8.4.0

-   `type` [<integer>](http://url.nodejs.cn/SXbo1v) 帧类型。
-   `code` [<integer>](http://url.nodejs.cn/SXbo1v) 错误代码。
-   `id` [<integer>](http://url.nodejs.cn/SXbo1v) 流 id（或如果帧不与流相关联，则为 `0`）。

当尝试在会话上发送帧时发生错误时会触发 `'frameError'` 事件。 如果无法发送的帧与特定的 `Http2Stream` 相关联，则会尝试在 `Http2Stream` 上触发 `'frameError'` 事件。

如果 `'frameError'` 事件与流相关联，则该流将在 `'frameError'` 事件之后立即关闭并销毁。 如果事件与流无关，则 `Http2Session` 将在 `'frameError'` 事件之后立即关闭。

##### `'goaway'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-goaway)

[中英对照](http://nodejs.cn/api-v12/http2/event_goaway.html)

新增于: v8.4.0

-   `errorCode` [<number>](http://url.nodejs.cn/SXbo1v) `GOAWAY` 帧中指定的 HTTP/2 错误代码。
-   `lastStreamID` [<number>](http://url.nodejs.cn/SXbo1v) 远程对等方成功处理的最后一个流的 ID（如果未指定 ID，则为 `0`）。
-   `opaqueData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 如果 `GOAWAY` 帧中包含其他不透明数据，则将传入包含该数据的 `Buffer` 实例。

接收到 `GOAWAY` 帧时触发 `'goaway'` 事件。

`'goaway'` 事件触发时，`Http2Session` 实例会自动关闭。

##### `'localSettings'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-localsettings)

[中英对照](http://nodejs.cn/api-v12/http2/event_localsettings.html)

新增于: v8.4.0

-   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object) 接收到了 `SETTINGS` 帧的副本。

当接收到确认 `SETTINGS` 帧时触发 `'localSettings'` 事件。

当使用 `http2session.settings()` 提交新的设置时，修改后的设置在 `'localSettings'` 事件触发后才会生效。

```
session.settings({ enablePush: false });

session.on('localSettings', (settings) => {
  /* 使用新的设置 */
});
```

##### `'ping'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-ping)

[中英对照](http://nodejs.cn/api-v12/http2/event_ping.html)

新增于: v10.12.0

-   `payload` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `PING` 帧 8 字节有效载荷

每当从连接的对等方接收到 `PING` 帧时，则会触发 `'ping'` 事件。

##### `'remoteSettings'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-remotesettings)

[中英对照](http://nodejs.cn/api-v12/http2/event_remotesettings.html)

新增于: v8.4.0

-   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object) 接收到了 `SETTINGS` 帧的副本。

当从连接的对等方接收到新的 `SETTINGS` 帧时，则会触发 `'remoteSettings'` 事件。

```
session.on('remoteSettings', (settings) => {
  /* 使用新的设置 */
});
```

##### `'stream'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-stream)

[中英对照](http://nodejs.cn/api-v12/http2/event_stream.html)

新增于: v8.4.0

-   `stream` [<Http2Stream>](http://nodejs.cn/api/http2.html#class-http2stream) 对流的引用
-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object) 描述标头的对象
-   `flags` [<number>](http://url.nodejs.cn/SXbo1v) 相关的数字标志
-   `rawHeaders` [<Array>](http://url.nodejs.cn/ZJSz23) 包含原始标头名称后跟它们各自值的数组。

创建新的 `Http2Stream` 时会触发 `'stream'` 事件。

```
const http2 = require('http2');
session.on('stream', (stream, headers, flags) => {
  const method = headers[':method'];
  const path = headers[':path'];
  // ...
  stream.respond({
    ':status': 200,
    'content-type': 'text/plain; charset=utf-8'
  });
  stream.write('hello ');
  stream.end('world');
});
```

在服务器端，用户代码通常不会直接监听此事件，而是为分别由 `http2.createServer()` 和 `http2.createSecureServer()` 返回的 `net.Server` 或 `tls.Server` 实例触发的 `'stream'` 事件注册句柄，如下例所示：

```
const http2 = require('http2');

// 创建未加密的 HTTP/2 服务器
const server = http2.createServer();

server.on('stream', (stream, headers) => {
  stream.respond({
    'content-type': 'text/html; charset=utf-8',
    ':status': 200
  });
  stream.on('error', (error) => console.error(error));
  stream.end('<h1>Hello World</h1>');
});

server.listen(80);
```

即使 HTTP/2 流和网络套接字不是 1:1 对应，网络错误也会破坏每个单独的流，必须在流级别上处理，如上所示。

##### `'timeout'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-timeout)

[中英对照](http://nodejs.cn/api-v12/http2/event_timeout.html)

新增于: v8.4.0

使用 `http2session.setTimeout()` 方法为此 `Http2Session` 设置超时时间后，如果在配置的毫秒数后 `Http2Session` 上没有活动，则触发 `'timeout'` 事件。 其监听器不需要任何参数。

```
session.setTimeout(2000);
session.on('timeout', () => { /* .. */ });
```

##### `http2session.alpnProtocol`[#](http://nodejs.cn/api-v12/http2.html#http2sessionalpnprotocol)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_alpnprotocol.html)

新增于: v9.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK) | [<undefined>](http://url.nodejs.cn/8ym6ow)

如果 `Http2Session` 尚未连接到套接字，则值为 `undefined`，如果 `Http2Session` 未连接到 `TLSSocket`，则值为 `h2c`，或者将返回已连接的 `TLSSocket` 自己的 `alpnProtocol` 属性的值。

##### `http2session.close([callback])`[#](http://nodejs.cn/api-v12/http2.html#http2sessionclosecallback)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_close_callback.html)

新增于: v9.4.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

正常地关闭 `Http2Session`，允许任何现有的流自行完成并防止创建新的 `Http2Stream` 实例。 一旦关闭，如果没有打开的 `Http2Stream` 实例，则 `http2session.destroy()` _可能_会被调用。

如果指定，则 `callback` 函数将注册为 `'close'` 事件的句柄。

##### `http2session.closed`[#](http://nodejs.cn/api-v12/http2.html#http2sessionclosed)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_closed.html)

新增于: v9.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果此 `Http2Session` 实例已关闭，则为 `true`，否则为 `false`。

##### `http2session.connecting`[#](http://nodejs.cn/api-v12/http2.html#http2sessionconnecting)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_connecting.html)

新增于: v10.0.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果此 `Http2Session` 实例仍在连接，则将是 `true`，在触发 `connect` 事件和/或调用 `http2.connect` 回调之前将设置为 `false`。

##### `http2session.destroy([error][, code])`[#](http://nodejs.cn/api-v12/http2.html#http2sessiondestroyerror-code)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_destroy_error_code.html)

新增于: v8.4.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x) 如果 `Http2Session` 因错误而被销毁，则为 `Error` 对象。
-   `code` [<number>](http://url.nodejs.cn/SXbo1v) 要在最终 `GOAWAY` 帧中发送的 HTTP/2 错误代码。 如果未指定，且 `error` 未未定义，则默认为 `INTERNAL_ERROR`，否则默认为 `NO_ERROR`。

立即终止 `Http2Session` 和相关联的 `net.Socket` 或 `tls.TLSSocket`。

一旦销毁，则 `Http2Session` 将触发 `'close'` 事件。 如果 `error` 未定义，则将在 `'close'` 事件之前立即触发 `'error'` 事件。

如果有任何剩余的与 `Http2Session` 关联的开放 `Http2Streams`，则它们也会被销毁。

##### `http2session.destroyed`[#](http://nodejs.cn/api-v12/http2.html#http2sessiondestroyed)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_destroyed.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果此 `Http2Session` 实例已被销毁且不能再使用，则为 `true`，否则为 `false`。

##### `http2session.encrypted`[#](http://nodejs.cn/api-v12/http2.html#http2sessionencrypted)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_encrypted.html)

新增于: v9.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT) | [<undefined>](http://url.nodejs.cn/8ym6ow)

如果 `Http2Session` 会话套接字尚未连接，则值为 `undefined`，如果 `Http2Session` 与 `TLSSocket` 连接，则值为 `true`，如果 `Http2Session` 连接到任何其他类型的套接字或流，则值为 `false`。

##### `http2session.goaway([code[, lastStreamID[, opaqueData]]])`[#](http://nodejs.cn/api-v12/http2.html#http2sessiongoawaycode-laststreamid-opaquedata)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_goaway_code_laststreamid_opaquedata.html)

新增于: v9.4.0

-   `code` [<number>](http://url.nodejs.cn/SXbo1v) HTTP/2 错误代码
-   `lastStreamID` [<number>](http://url.nodejs.cn/SXbo1v) 最后处理的 `Http2Stream` 的数字 ID
-   `opaqueData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) `TypedArray` 或 `DataView` 实例，包含要在 `GOAWAY` 帧中携带的附加数据。

将 `GOAWAY` 帧传输到连接的对等方_而不_关闭 `Http2Session`。

##### `http2session.localSettings`[#](http://nodejs.cn/api-v12/http2.html#http2sessionlocalsettings)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_localsettings.html)

新增于: v8.4.0

-   [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object)

描述此 `Http2Session` 当前本地设置的无原型对象。 本地设置是本地的此 `Http2Session` 实例。

##### `http2session.originSet`[#](http://nodejs.cn/api-v12/http2.html#http2sessionoriginset)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_originset.html)

新增于: v9.4.0

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<undefined>](http://url.nodejs.cn/8ym6ow)

如果 `Http2Session` 连接到 `TLSSocket`，则 `originSet` 属性将返回 `Array` 的起源，`Http2Session` 可能被认为是权威的。

`originSet` 属性仅在使用安全 TLS 连接时可用。

##### `http2session.pendingSettingsAck`[#](http://nodejs.cn/api-v12/http2.html#http2sessionpendingsettingsack)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_pendingsettingsack.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

指示 `Http2Session` 当前是否正在等待已发送的 `SETTINGS` 帧的确认。 调用 `http2session.settings()` 方法后会是 `true`。 一旦所有发送的 `SETTINGS` 帧都被确认，将是 `false`。

##### `http2session.ping([payload, ]callback)`[#](http://nodejs.cn/api-v12/http2.html#http2sessionpingpayload-callback)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_ping_payload_callback.html)

新增于: v8.9.3

-   `payload` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 可选的 ping 负载。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

向连接的 HTTP/2 对等方发送 `PING` 帧。 必须提供 `callback` 函数。 如果发送了 `PING`，则该方法将返回 `true`，否则返回 `false`。

未完成的（未确认的）ping 的最大数量由 `maxOutstandingPings` 配置选项决定。 默认最大值为 10。

如果提供，则 `payload` 必须是 `Buffer`、`TypedArray` 或 `DataView`，其中包含 8 个字节的数据，这些数据将与 `PING` 一起传输并与 ping 确认一起返回。

回调将使用三个参数调用：一个错误参数（如果 `PING` 被成功确认，则它将是 `null`），一个 `duration` 参数（报告自发送 ping 和收到确认以来经过的毫秒数），以及一个 `Buffer`（包含 8 字节 `PING` 有效载荷）。

```
session.ping(Buffer.from('abcdefgh'), (err, duration, payload) => {
  if (!err) {
    console.log(`Ping acknowledged in ${duration} milliseconds`);
    console.log(`With payload '${payload.toString()}'`);
  }
});
```

如果未指定 `payload` 参数，则默认负载将是标记 `PING` 持续时间开始的 64 位时间戳（小端）。

##### `http2session.ref()`[#](http://nodejs.cn/api-v12/http2.html#http2sessionref)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_ref.html)

新增于: v9.4.0

在此 `Http2Session` 实例的底层 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 上调用 [`ref()`](http://nodejs.cn/api-v12/net.html#net_socket_ref)。

##### `http2session.remoteSettings`[#](http://nodejs.cn/api-v12/http2.html#http2sessionremotesettings)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_remotesettings.html)

新增于: v8.4.0

-   [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object)

描述此 `Http2Session` 当前远程设置的无原型对象。 远程设置由连接的 HTTP/2 对等方设置。

##### `http2session.setTimeout(msecs, callback)`[#](http://nodejs.cn/api-v12/http2.html#http2sessionsettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_settimeout_msecs_callback.html)

新增于: v8.4.0

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

用于设置 `msecs` 毫秒后 `Http2Session` 上没有活动时调用的回调函数。 给定的 `callback` 已注册为 `'timeout'` 事件的监听器。

##### `http2session.socket`[#](http://nodejs.cn/api-v12/http2.html#http2sessionsocket)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_socket.html)

新增于: v8.4.0

-   [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) | [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket)

返回 `Proxy` 对象，它充当 `net.Socket`（或 `tls.TLSSocket`），但将可用方法限制为可安全使用 HTTP/2 的方法。

`destroy`、`emit`、`end`、`pause`、`read`、`resume`、以及 `write` 将抛出错误代码为 `ERR_HTTP2_NO_SOCKET_MANIPULATION`。 有关详细信息，请参阅 [`Http2Session` 和套接字](http://nodejs.cn/api-v12/http2.html#http2_http2session_and_sockets)。

将在此 `Http2Session` 上调用 `setTimeout` 方法。

所有其他交互将直接路由到套接字。

##### `http2session.state`[#](http://nodejs.cn/api-v12/http2.html#http2sessionstate)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_state.html)

新增于: v8.4.0

提供有关 `Http2Session` 当前状态的其他信息。

-   [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `effectiveLocalWindowSize` [<number>](http://url.nodejs.cn/SXbo1v) `Http2Session` 的当前本地（接收）流控制窗口大小。
    -   `effectiveRecvDataLength` [<number>](http://url.nodejs.cn/SXbo1v) 自上次流控制 `WINDOW_UPDATE` 以来已接收的当前字节数。
    -   `nextStreamID` [<number>](http://url.nodejs.cn/SXbo1v) 下一次此 `Http2Session` 创建新 `Http2Stream` 时要使用的数字标识符。
    -   `localWindowSize` [<number>](http://url.nodejs.cn/SXbo1v) 远程对等方在不接收 `WINDOW_UPDATE` 的情况下可以发送的字节数。
    -   `lastProcStreamID` [<number>](http://url.nodejs.cn/SXbo1v) 最近收到 `HEADERS` 或 `DATA` 帧的 `Http2Stream` 的数字 ID。
    -   `remoteWindowSize` [<number>](http://url.nodejs.cn/SXbo1v) 此 `Http2Session` 在不接收 `WINDOW_UPDATE` 的情况下可以发送的字节数。
    -   `outboundQueueSize` [<number>](http://url.nodejs.cn/SXbo1v) 当前在此 `Http2Session` 的出站队列中的帧数。
    -   `deflateDynamicTableSize` [<number>](http://url.nodejs.cn/SXbo1v) 出站标头压缩状态表的当前大小（以字节为单位）。
    -   `inflateDynamicTableSize` [<number>](http://url.nodejs.cn/SXbo1v) 入站标头压缩状态表的当前大小（以字节为单位）。

描述当前 `Http2Session` 状态的对象。

##### `http2session.settings([settings][, callback])`[#](http://nodejs.cn/api-v12/http2.html#http2sessionsettingssettings-callback)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_settings_settings_callback.html)

新增于: v8.4.0

-   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 一旦会话连接或会话已连接时立即调用的回调。
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x) | [<null>](http://url.nodejs.cn/334hvC)
    -   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object) 更新后的 `settings` 对象。
    -   `duration` [<integer>](http://url.nodejs.cn/SXbo1v)

更新此 `Http2Session` 的当前本地设置并向连接的 HTTP/2 对等方发送新的 `SETTINGS` 帧。

一旦调用，当会话等待远程对等方确认新设置时，`http2session.pendingSettingsAck` 属性将为 `true`。

在收到 `SETTINGS` 确认并触发 `'localSettings'` 事件之前，新设置不会生效。 可以在确认未决时发送多个 `SETTINGS` 帧。

##### `http2session.type`[#](http://nodejs.cn/api-v12/http2.html#http2sessiontype)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_type.html)

新增于: v8.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

如果此 `Http2Session` 实例是服务器，则 `http2session.type` 将等于 `http2.constants.NGHTTP2_SESSION_SERVER`，如果该实例是客户端，则 `http2.constants.NGHTTP2_SESSION_CLIENT` 将等于。

##### `http2session.unref()`[#](http://nodejs.cn/api-v12/http2.html#http2sessionunref)

[中英对照](http://nodejs.cn/api-v12/http2/http2session_unref.html)

新增于: v9.4.0

在此 `Http2Session` 实例的底层 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 上调用 [`unref()`](http://nodejs.cn/api-v12/net.html#net_socket_unref)。

#### `ServerHttp2Session` 类[#](http://nodejs.cn/api-v12/http2.html#class-serverhttp2session)

新增于: v8.4.0

-   继承自: [<Http2Session>](http://nodejs.cn/api/http2.html#class-http2session)

##### `serverhttp2session.altsvc(alt, originOrStream)`[#](http://nodejs.cn/api-v12/http2.html#serverhttp2sessionaltsvcalt-originorstream)

[中英对照](http://nodejs.cn/api-v12/http2/serverhttp2session_altsvc_alt_originorstream.html)

新增于: v9.4.0

-   `alt` [<string>](http://url.nodejs.cn/9Tw2bK) [RFC 7838](http://url.nodejs.cn/9HhkZV) 定义的替代服务配置的描述。
-   `originOrStream` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<Object>](http://url.nodejs.cn/jzn6Ao) 指定来源的 URL 字符串（或具有 `origin` 属性的 `Object`）或由 `http2stream.id` 属性给出的活动 `Http2Stream` 的数字标识符。

向连接的客户端提交 `ALTSVC` 帧（由 [RFC 7838](http://url.nodejs.cn/9HhkZV) 定义）。

```
const http2 = require('http2');

const server = http2.createServer();
server.on('session', (session) => {
  // 为源 https://example.org:80 设置 altsvc
  session.altsvc('h2=":8000"', 'https://example.org:80');
});

server.on('stream', (stream) => {
  // 为特定流设置 altsvc
  stream.session.altsvc('h2=":8000"', stream.id);
});
```

发送带有特定流 ID 的 `ALTSVC` 帧表示备用服务与给定 `Http2Stream` 的来源相关联。

`alt` 和原点字符串_必须_只包含 ASCII 字节，并且严格解释为 ASCII 字节序列。 可以传入特殊值 `'clear'` 以清除给定域的任何先前设置的替代服务。

当为 `originOrStream` 参数传入字符串时，则它将被解析为 URL 并导出来源。 例如，HTTP URL `'https://example.org/foo/bar'` 的来源是 ASCII 字符串 `'https://example.org'`。 如果给定的字符串无法解析为 URL，或者无法导出有效的来源，则会抛出错误。

`URL` 对象，或任何具有 `origin` 属性的对象，都可以作为 `originOrStream` 传入，在这种情况下，将使用 `origin` 属性的值。 `origin` 属性的值_必须_是正确序列化的 ASCII 源。

##### 指定备选服务器[#](http://nodejs.cn/api-v12/http2.html#specifying-alternative-services)

[中英对照](http://nodejs.cn/api-v12/http2/specifying_alternative_services.html)

`alt` 参数的格式由 [RFC 7838](http://url.nodejs.cn/9HhkZV) 严格定义为 ASCII 字符串，其中包含与特定主机和端口相关联的"替代"协议的逗号分隔列表。

例如，值 `'h2="example.org:81"'` 表示 HTTP/2 协议在主机 `'example.org'` 上的 TCP/IP 端口 81 上可用。 主机和端口_必须_包含在引号 (`"`) 字符内。

可以指定多个备选方案，例如：`'h2="example.org:81", h2=":82"'`。

协议标识符（示例中的 `'h2'`）可以是任何有效的 [ALPN 协议 ID](http://url.nodejs.cn/3rCqYH)。

这些值的语法未经 Node.js 实现验证，而是按照用户提供的或从对等方接收的方式传入。

##### `serverhttp2session.origin(...origins)`[#](http://nodejs.cn/api-v12/http2.html#serverhttp2sessionoriginorigins)

[中英对照](http://nodejs.cn/api-v12/http2/serverhttp2session_origin_origins.html)

新增于: v10.12.0

-   `origins` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) | [<Object>](http://url.nodejs.cn/jzn6Ao) 一个或多个 URL 字符串作为单独的参数传入。

向连接的客户端提交 `ORIGIN` 帧（由 [RFC 8336](http://url.nodejs.cn/EfWiwY) 定义），以通告服务器能够为其提供权威响应的源集。

```
const http2 = require('http2');
const options = getSecureOptionsSomehow();
const server = http2.createSecureServer(options);
server.on('stream', (stream) => {
  stream.respond();
  stream.end('ok');
});
server.on('session', (session) => {
  session.origin('https://example.com', 'https://example.org');
});
```

当字符串作为 `origin` 传入时，则它会被解析为 URL 并导出来源。 例如，HTTP URL `'https://example.org/foo/bar'` 的来源是 ASCII 字符串 `'https://example.org'`。 如果给定的字符串无法解析为 URL，或者无法导出有效的来源，则会抛出错误。

`URL` 对象，或任何具有 `origin` 属性的对象，都可以作为 `origin` 传入，在这种情况下，将使用 `origin` 属性的值。 `origin` 属性的值_必须_是正确序列化的 ASCII 源。

或者，在使用 `http2.createSecureServer()` 方法创建新的 HTTP/2 服务器时可以使用 `origins` 选项：

```
const http2 = require('http2');
const options = getSecureOptionsSomehow();
options.origins = ['https://example.com', 'https://example.org'];
const server = http2.createSecureServer(options);
server.on('stream', (stream) => {
  stream.respond();
  stream.end('ok');
});
```

#### `ClientHttp2Session` 类[#](http://nodejs.cn/api-v12/http2.html#class-clienthttp2session)

新增于: v8.4.0

-   继承自: [<Http2Session>](http://nodejs.cn/api/http2.html#class-http2session)

##### `'altsvc'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-altsvc)

[中英对照](http://nodejs.cn/api-v12/http2/event_altsvc.html)

新增于: v9.4.0

-   `alt` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `origin` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `streamId` [<number>](http://url.nodejs.cn/SXbo1v)

每当客户端接收到 `ALTSVC` 帧时，则会触发 `'altsvc'` 事件。 事件使用 `ALTSVC` 值、来源和流 ID 触发。 如果在 `ALTSVC` 帧中没有提供 `origin`，则 `origin` 将是空字符串。

```
const http2 = require('http2');
const client = http2.connect('https://example.org');

client.on('altsvc', (alt, origin, streamId) => {
  console.log(alt);
  console.log(origin);
  console.log(streamId);
});
```

##### `'origin'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-origin)

[中英对照](http://nodejs.cn/api-v12/http2/event_origin.html)

新增于: v10.12.0

-   `origins` [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

每当客户端接收到 `ORIGIN` 帧时，则会触发 `'origin'` 事件。 该事件使用 `origin` 字符串的数组触发。 `http2session.originSet` 将被更新以包含接收到的来源。

```
const http2 = require('http2');
const client = http2.connect('https://example.org');

client.on('origin', (origins) => {
  for (let n = 0; n < origins.length; n++)
    console.log(origins[n]);
});
```

只有在使用安全 TLS 连接时才会触发 `'origin'` 事件。

##### `clienthttp2session.request(headers[, options])`[#](http://nodejs.cn/api-v12/http2.html#clienthttp2sessionrequestheaders-options)

[中英对照](http://nodejs.cn/api-v12/http2/clienthttp2session_request_headers_options.html)

新增于: v8.4.0

-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)
    
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    
    -   `endStream` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `Http2Stream` _可写_端最初应该关闭（例如发送不应期待有效负载正文的 `GET` 请求时），则为 `true`。
    -   `exclusive` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 和 `parent` 标识父流时，创建的流将成为父流的唯一直接依赖项，所有其他现有依赖项都成为新创建流的依赖项。 **默认值:** `false`。
    -   `parent` [<number>](http://url.nodejs.cn/SXbo1v) 指定新创建的流所依赖的流的数字标识符。
    -   `weight` [<number>](http://url.nodejs.cn/SXbo1v) 指定流相对于具有相同 `parent` 的其他流的相对依赖性。 该值为 `1` 到 `256`（含）之间的数字。
    -   `waitForTrailers` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，`Http2Stream` 将在发送完最后的 `DATA` 帧后触发 `'wantTrailers'` 事件。
-   返回: [<ClientHttp2Stream>](http://nodejs.cn/api/http2.html#class-clienthttp2stream)
    

仅对于 HTTP/2 客户端 `Http2Session` 实例，`http2session.request()` 创建并返回 `Http2Stream` 实例，该实例可用于向连接的服务器发送 HTTP/2 请求。

此方法仅在 `http2session.type` 等于 `http2.constants.NGHTTP2_SESSION_CLIENT` 时可用。

```
const http2 = require('http2');
const clientSession = http2.connect('https://localhost:1234');
const {
  HTTP2_HEADER_PATH,
  HTTP2_HEADER_STATUS
} = http2.constants;

const req = clientSession.request({ [HTTP2_HEADER_PATH]: '/' });
req.on('response', (headers) => {
  console.log(headers[HTTP2_HEADER_STATUS]);
  req.on('data', (chunk) => { /* .. */ });
  req.on('end', () => { /* .. */ });
});
```

当设置了 `options.waitForTrailers` 选项时，在将要发送的最后一块有效负载数据排队后立即触发 `'wantTrailers'` 事件。 然后可以调用 `http2stream.sendTrailers()` 方法将尾随标头发送到对等方。

当设置了 `options.waitForTrailers`，则传输完最后的 `DATA` 帧时，`Http2Stream` 不会自动关闭。 用户代码必须调用 `http2stream.sendTrailers()` 或 `http2stream.close()` 来关闭 `Http2Stream`。

`:method` 和 `:path` 伪标头在 `headers` 中没有指定，它们分别默认为：

-   `:method` = `'GET'`
-   `:path` = `/`

#### `Http2Stream` 类[#](http://nodejs.cn/api-v12/http2.html#class-http2stream)

[中英对照](http://nodejs.cn/api-v12/http2/class_http2stream.html)

新增于: v8.4.0

-   继承自: [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

`Http2Stream` 类的每个实例代表一个通过 `Http2Session` 实例的双向 HTTP/2 通信流。 任何单个 `Http2Session` 在其生命周期中最多可能有 231\-1 个 `Http2Stream` 实例。

用户代码不会直接构造 `Http2Stream` 实例。 而是，这些是通过 `Http2Session` 实例创建、管理并提供给用户代码的。 在服务器上，创建 `Http2Stream` 实例是为了响应传入的 HTTP 请求（并通过 `'stream'` 事件传给用户代码），或者响应对 `http2stream.pushStream()` 方法的调用。 在客户端，当调用 `http2session.request()` 方法或响应传入的 `'push'` 事件时，会创建并返回 `Http2Stream` 实例。

`Http2Stream` 类是 [`ServerHttp2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_serverhttp2stream) 和 [`ClientHttp2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_clienthttp2stream) 类的基础，每个类分别由服务器端或客户端专门使用。

所有 `Http2Stream` 实例都是 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流。 `Duplex` 的 `Writable` 端用于向连接的对端发送数据，而 `Readable` 端用于接收连接的对端发送的数据。

所有 `Http2Stream` 的默认文本字符编码为 UTF-8。 作为最佳实践，建议在使用 `Http2Stream` 发送文本时，应设置 `'content-type'` 标头并应标识使用的字符编码。

```
stream.respond({
  'content-type': 'text/html; charset=utf-8',
  ':status': 200
});
```

##### Http2Stream 的生命周期[#](http://nodejs.cn/api-v12/http2.html#http2stream-lifecycle)

###### 创建[#](http://nodejs.cn/api-v12/http2.html#creation)

[中英对照](http://nodejs.cn/api-v12/http2/creation.html)

在服务器端，[`ServerHttp2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_serverhttp2stream) 的实例是在以下任一情况下创建的：

-   接收到新的 HTTP/2 `HEADERS` 帧，其中包含以前未使用的流 ID；
-   调用了 `http2stream.pushStream()` 方法。

在客户端，[`ClientHttp2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_clienthttp2stream) 的实例是在调用 `http2session.request()` 方法时创建的。

在客户端，如果父 `Http2Session` 尚未完全建立，则 `http2session.request()` 返回的 `Http2Stream` 实例可能不会立即准备好使用。 在这种情况下，在 `Http2Stream` 上调用的操作将被缓冲，直到触发 `'ready'` 事件。 用户代码应该很少，如果有的话，需要直接处理 `'ready'` 事件。 `Http2Stream` 的就绪状态可以通过检查 `http2stream.id` 的值来确定。 如果值为 `undefined`，则流尚未准备好使用。

###### 销毁[#](http://nodejs.cn/api-v12/http2.html#destruction)

[中英对照](http://nodejs.cn/api-v12/http2/destruction.html)

所有 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 实例都在以下情况下被销毁：

-   已连接的对等方接收到流的 `RST_STREAM` 帧，并且（仅对于客户端流）已读取待处理数据。
-   调用了 `http2stream.close()` 方法，并且（仅对于客户端流）已读取待处理数据。
-   调用 `http2stream.destroy()` 或 `http2session.destroy()` 方法。

当 `Http2Stream` 实例被销毁时，则将尝试向连接的对等方发送 `RST_STREAM` 帧。

当 `Http2Stream` 实例被销毁时，则将会触发 `'close'` 事件。 因为 `Http2Stream` 是 `stream.Duplex` 的实例，所以如果流数据当前正在流动，则 `'end'` 事件也会被触发。 如果 `http2stream.destroy()` 被作为第一个参数传入的 `Error` 被调用，则 `'error'` 事件也可能被触发。

在 `Http2Stream` 被销毁后，`http2stream.destroyed` 属性将是 `true`，`http2stream.rstCode` 属性将指定 `RST_STREAM` 错误代码。 `Http2Stream` 实例一旦销毁就不再可用。

##### `'aborted'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-aborted)

[中英对照](http://nodejs.cn/api-v12/http2/event_aborted.html)

新增于: v8.4.0

每当 `Http2Stream` 实例在通信中途异常中止时，就会触发 `'aborted'` 事件。 其监听器不需要任何参数。

只有在 `Http2Stream` 可写端尚未结束时才会触发 `'aborted'` 事件。

##### `'close'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-close_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_close_1.html)

新增于: v8.4.0

`'close'` 事件在 `Http2Stream` 被销毁时触发。 一旦触发此事件，则 `Http2Stream` 实例将不再可用。

可以使用 `http2stream.rstCode` 属性检索关闭流时使用的 HTTP/2 错误代码。 如果代码是除 `NGHTTP2_NO_ERROR` (`0`) 以外的任何值，则也将触发 `'error'` 事件。

##### `'error'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-error_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_error_1.html)

新增于: v8.4.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x)

`'error'` 事件在处理 `Http2Stream` 期间发生错误时触发。

##### `'frameError'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-frameerror_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_frameerror_1.html)

新增于: v8.4.0

-   `type` [<integer>](http://url.nodejs.cn/SXbo1v) 帧类型。
-   `code` [<integer>](http://url.nodejs.cn/SXbo1v) 错误代码。
-   `id` [<integer>](http://url.nodejs.cn/SXbo1v) 流 id（或如果帧不与流相关联，则为 `0`）。

当尝试发送帧时发生错误时会触发 `'frameError'` 事件。 当调用时，句柄函数将接收标识帧类型的整数参数和标识错误代码的整数参数。 `Http2Stream` 实例将在 `'frameError'` 事件触发后立即销毁。

##### `'ready'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-ready)

[中英对照](http://nodejs.cn/api-v12/http2/event_ready.html)

新增于: v8.4.0

`'ready'` 事件在 `Http2Stream` 已打开、已分配 `id` 且可以使用时触发。 监听器不需要任何参数。

##### `'timeout'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-timeout_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_timeout_1.html)

新增于: v8.4.0

在使用 `http2stream.setTimeout()` 设置的毫秒数内没有收到此 `Http2Stream` 的活动后，则将触发 `'timeout'` 事件。 其监听器不需要任何参数。

##### `'trailers'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-trailers)

[中英对照](http://nodejs.cn/api-v12/http2/event_trailers.html)

新增于: v8.4.0

-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object) 描述标头的对象
-   `flags` [<number>](http://url.nodejs.cn/SXbo1v) 相关的数字标志

当接收到与尾随标头字段关联的标头块时，则会触发 `'trailers'` 事件。 监听器回调传入 [HTTP/2 标头对象](http://nodejs.cn/api-v12/http2.html#http2_headers_object)和与标头关联的标志。

如果在收到预告片之前调用 `http2stream.end()` 并且未读取或监听传入数据，则可能不会触发此事件。

```
stream.on('trailers', (headers, flags) => {
  console.log(headers);
});
```

##### `'wantTrailers'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-wanttrailers)

[中英对照](http://nodejs.cn/api-v12/http2/event_wanttrailers.html)

新增于: v10.0.0

`'wantTrailers'` 事件在 `Http2Stream` 已将要在帧上发送的最后 `DATA` 帧排队并且 `Http2Stream` 准备好发送尾随标头时触发。 在发起请求或响应时，必须设置 `waitForTrailers` 选项才能触发此事件。

##### `http2stream.aborted`[#](http://nodejs.cn/api-v12/http2.html#http2streamaborted)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_aborted.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `Http2Stream` 实例异常中止，则设置为 `true`。 当设置时，则 `'aborted'` 事件将被触发。

##### `http2stream.bufferSize`[#](http://nodejs.cn/api-v12/http2.html#http2streambuffersize)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_buffersize.html)

新增于: v11.2.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

此属性显示当前缓冲要写入的字符数。 详见 [`net.Socket.bufferSize`](http://nodejs.cn/api-v12/net.html#net_socket_buffersize)。

##### `http2stream.close(code[, callback])`[#](http://nodejs.cn/api-v12/http2.html#http2streamclosecode-callback)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_close_code_callback.html)

新增于: v8.4.0

-   `code` [<number>](http://url.nodejs.cn/SXbo1v) 标识错误代码的无符号 32 位整数。 **默认值:** `http2.constants.NGHTTP2_NO_ERROR` （`0x00`）。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 注册了可选函数来监听 `'close'` 事件。

通过向连接的 HTTP/2 对等体发送 `RST_STREAM` 帧来关闭 `Http2Stream` 实例。

##### `http2stream.closed`[#](http://nodejs.cn/api-v12/http2.html#http2streamclosed)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_closed.html)

新增于: v9.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `Http2Stream` 实例已关闭，则设置为 `true`。

##### `http2stream.destroyed`[#](http://nodejs.cn/api-v12/http2.html#http2streamdestroyed)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_destroyed.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `Http2Stream` 实例已被销毁且不再可用，则设置为 `true`。

##### `http2stream.endAfterHeaders`[#](http://nodejs.cn/api-v12/http2.html#http2streamendafterheaders)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_endafterheaders.html)

新增于: v10.11.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果在接收到的请求或响应 HEADERS 帧中设置了 `END_STREAM` 标志，则设置 `true`，表示不应接收额外的数据并且 `Http2Stream` 的可读端将被关闭。

##### `http2stream.id`[#](http://nodejs.cn/api-v12/http2.html#http2streamid)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_id.html)

新增于: v8.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<undefined>](http://url.nodejs.cn/8ym6ow)

此 `Http2Stream` 实例的数字流标识符 如果尚未分配流标识符，则设置为 `undefined`。

##### `http2stream.pending`[#](http://nodejs.cn/api-v12/http2.html#http2streampending)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_pending.html)

新增于: v9.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果尚未为 `Http2Stream` 实例分配数字流标识符，则设置为 `true`。

##### `http2stream.priority(options)`[#](http://nodejs.cn/api-v12/http2.html#http2streampriorityoptions)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_priority_options.html)

新增于: v8.4.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `exclusive` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 和 `parent` 标识父流时，此流将成为父流的唯一直接依赖项，所有其他现有依赖项都成为此流的依赖项。 **默认值:** `false`。
    -   `parent` [<number>](http://url.nodejs.cn/SXbo1v) 指定此流所依赖的流的数字标识符。
    -   `weight` [<number>](http://url.nodejs.cn/SXbo1v) 指定流相对于具有相同 `parent` 的其他流的相对依赖性。 该值为 `1` 到 `256`（含）之间的数字。
    -   `silent` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，本地改变优先级，而不向连接的对端发送 `PRIORITY` 帧。

更新此 `Http2Stream` 实例的优先级。

##### `http2stream.rstCode`[#](http://nodejs.cn/api-v12/http2.html#http2streamrstcode)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_rstcode.html)

新增于: v8.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

设置为 `RST_STREAM` [错误代码](http://nodejs.cn/api-v12/http2.html#error_codes)在从连接的对等方接收到 `RST_STREAM` 帧、调用 `http2stream.close()` 或 `http2stream.destroy()` 后销毁 `Http2Stream` 时报告。 如果 `Http2Stream` 尚未关闭，则为 `undefined`。

##### `http2stream.sentHeaders`[#](http://nodejs.cn/api-v12/http2.html#http2streamsentheaders)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_sentheaders.html)

新增于: v9.5.0

-   [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)

包含为此 `Http2Stream` 发送的出站标头的对象。

##### `http2stream.sentInfoHeaders`[#](http://nodejs.cn/api-v12/http2.html#http2streamsentinfoheaders)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_sentinfoheaders.html)

新增于: v9.5.0

-   [<HTTP/2 Headers Object\[\]>](http://nodejs.cn/api/http2.html#headers-object)

包含为此 `Http2Stream` 发送的出站信息（附加）标头的对象数组。

##### `http2stream.sentTrailers`[#](http://nodejs.cn/api-v12/http2.html#http2streamsenttrailers)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_senttrailers.html)

新增于: v9.5.0

-   [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)

包含为此 `HttpStream` 发送的出站尾随标头的对象。

##### `http2stream.session`[#](http://nodejs.cn/api-v12/http2.html#http2streamsession)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_session.html)

新增于: v8.4.0

-   [<Http2Session>](http://nodejs.cn/api/http2.html#class-http2session)

对拥有此 `Http2Stream` 的 `Http2Session` 实例的引用。 在 `Http2Stream` 实例销毁后，值为 `undefined`。

##### `http2stream.setTimeout(msecs, callback)`[#](http://nodejs.cn/api-v12/http2.html#http2streamsettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_settimeout_msecs_callback.html)

新增于: v8.4.0

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

```
const http2 = require('http2');
const client = http2.connect('http://example.org:8000');
const { NGHTTP2_CANCEL } = http2.constants;
const req = client.request({ ':path': '/' });

// 如果 5 秒后没有活动，则取消流
req.setTimeout(5000, () => req.close(NGHTTP2_CANCEL));
```

##### `http2stream.state`[#](http://nodejs.cn/api-v12/http2.html#http2streamstate)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_state.html)

新增于: v8.4.0

提供有关 `Http2Stream` 当前状态的其他信息。

-   [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `localWindowSize` [<number>](http://url.nodejs.cn/SXbo1v) 连接的对等体可以为此 `Http2Stream` 发送的字节数，而不会收到 `WINDOW_UPDATE`。
    -   `state` [<number>](http://url.nodejs.cn/SXbo1v) 指示由 `nghttp2` 确定的 `Http2Stream` 的低层当前状态的标志。
    -   `localClose` [<number>](http://url.nodejs.cn/SXbo1v) 如果此 `Http2Stream` 已在本地关闭，则为 `1`。
    -   `remoteClose` [<number>](http://url.nodejs.cn/SXbo1v) 如果此 `Http2Stream` 已远程关闭，则为 `1`。
    -   `sumDependencyWeight` [<number>](http://url.nodejs.cn/SXbo1v) 使用 `PRIORITY` 帧指定的依赖于此 `Http2Stream` 的所有 `Http2Stream` 实例的总权重。
    -   `weight` [<number>](http://url.nodejs.cn/SXbo1v) 此 `Http2Stream` 的优先权重。

此 `Http2Stream` 的当前状态。

##### `http2stream.sendTrailers(headers)`[#](http://nodejs.cn/api-v12/http2.html#http2streamsendtrailersheaders)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_sendtrailers_headers.html)

新增于: v10.0.0

-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)

向连接的 HTTP/2 对等端发送尾随的 `HEADERS` 帧。 此方法将导致 `Http2Stream` 立即关闭，并且只能在 `'wantTrailers'` 事件触发后调用。 当发送请求或发送响应时，必须设置 `options.waitForTrailers` 选项，以便在最后的 `DATA` 帧之后保持 `Http2Stream` 打开，以便可以发送尾随标头。

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream) => {
  stream.respond(undefined, { waitForTrailers: true });
  stream.on('wantTrailers', () => {
    stream.sendTrailers({ xyz: 'abc' });
  });
  stream.end('Hello World');
});
```

HTTP/1 规范禁止尾随标头包含 HTTP/2 伪标头字段（例如 `':method'`、`':path'` 等）。

#### `ClientHttp2Stream` 类[#](http://nodejs.cn/api-v12/http2.html#class-clienthttp2stream)

[中英对照](http://nodejs.cn/api-v12/http2/class_clienthttp2stream.html)

新增于: v8.4.0

-   继承自 [<Http2Stream>](http://nodejs.cn/api/http2.html#class-http2stream)

`ClientHttp2Stream` 类是 `Http2Stream` 的扩展，专门用于 HTTP/2 客户端。 客户端上的 `Http2Stream` 实例提供仅与客户端相关的事件，例如 `'response'` 和 `'push'`。

##### `'continue'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-continue)

[中英对照](http://nodejs.cn/api-v12/http2/event_continue.html)

新增于: v8.5.0

当服务器发送 `100 Continue` 状态时触发，通常是因为请求包含 `Expect: 100-continue`。 这是客户端应该发送请求正文的指令。

##### `'headers'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-headers)

[中英对照](http://nodejs.cn/api-v12/http2/event_headers.html)

新增于: v8.4.0

当接收到流的附加标头块时，例如接收到 `1xx` 信息标头块时，则会触发 `'headers'` 事件。 监听器回调传入 [HTTP/2 标头对象](http://nodejs.cn/api-v12/http2.html#http2_headers_object)和与标头关联的标志。

```
stream.on('headers', (headers, flags) => {
  console.log(headers);
});
```

##### `'push'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-push)

[中英对照](http://nodejs.cn/api-v12/http2/event_push.html)

新增于: v8.4.0

当接收到服务器推送流的响应头时，则会触发 `'push'` 事件。 监听器回调传入 [HTTP/2 标头对象](http://nodejs.cn/api-v12/http2.html#http2_headers_object)和与标头关联的标志。

```
stream.on('push', (headers, flags) => {
  console.log(headers);
});
```

##### `'response'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-response)

[中英对照](http://nodejs.cn/api-v12/http2/event_response.html)

新增于: v8.4.0

当从连接的 HTTP/2 服务器收到此流的响应 `HEADERS` 帧时，则将触发 `'response'` 事件。 监听器使用两个参数调用：包含接收到的 [HTTP/2 标头对象](http://nodejs.cn/api-v12/http2.html#http2_headers_object)的 `Object`，以及与标头关联的标志。

```
const http2 = require('http2');
const client = http2.connect('https://localhost');
const req = client.request({ ':path': '/' });
req.on('response', (headers, flags) => {
  console.log(headers[':status']);
});
```

#### `ServerHttp2Stream` 类[#](http://nodejs.cn/api-v12/http2.html#class-serverhttp2stream)

[中英对照](http://nodejs.cn/api-v12/http2/class_serverhttp2stream.html)

新增于: v8.4.0

-   继承自: [<Http2Stream>](http://nodejs.cn/api/http2.html#class-http2stream)

`ServerHttp2Stream` 类是 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 的扩展，专门用于 HTTP/2 服务器。 服务器上的 `Http2Stream` 实例提供了仅与服务器相关的其他方法，例如 `http2stream.pushStream()` 和 `http2stream.respond()`。

##### `http2stream.additionalHeaders(headers)`[#](http://nodejs.cn/api-v12/http2.html#http2streamadditionalheadersheaders)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_additionalheaders_headers.html)

新增于: v8.4.0

-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)

向连接的 HTTP/2 对等方发送额外的信息性 `HEADERS` 帧。

##### `http2stream.headersSent`[#](http://nodejs.cn/api-v12/http2.html#http2streamheaderssent)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_headerssent.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果标头被发送则为 true，否则为 false（只读）。

##### `http2stream.pushAllowed`[#](http://nodejs.cn/api-v12/http2.html#http2streampushallowed)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_pushallowed.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

只读属性映射到远程客户端最近的 `SETTINGS` 帧的 `SETTINGS_ENABLE_PUSH` 标志。 如果远程节点接受推送流，则为 `true`，否则为 `false`。 同一个 `Http2Session` 中的每个 `Http2Stream` 的设置都是相同的。

##### `http2stream.pushStream(headers[, options], callback)`[#](http://nodejs.cn/api-v12/http2.html#http2streampushstreamheaders-options-callback)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_pushstream_headers_options_callback.html)

新增于: v8.4.0

-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `exclusive` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 和 `parent` 标识父流时，创建的流将成为父流的唯一直接依赖项，所有其他现有依赖项都成为新创建流的依赖项。 **默认值:** `false`。
    -   `parent` [<number>](http://url.nodejs.cn/SXbo1v) 指定新创建的流所依赖的流的数字标识符。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 推送流启动后调用的回调。
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `pushStream` [<ServerHttp2Stream>](http://nodejs.cn/api/http2.html#class-serverhttp2stream) 返回的 `pushStream` 对象。
    -   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object) 用于启动 `pushStream` 的标头对象。

启动推送流。 使用为作为第二个参数传入的推送流创建的新 `Http2Stream` 实例或作为第一个参数传入的 `Error` 调用回调。

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream) => {
  stream.respond({ ':status': 200 });
  stream.pushStream({ ':path': '/' }, (err, pushStream, headers) => {
    if (err) throw err;
    pushStream.respond({ ':status': 200 });
    pushStream.end('some pushed data');
  });
  stream.end('some data');
});
```

`HEADERS` 帧中不允许设置推流的权重。 将 `weight` 值传给 `http2stream.priority`，并将 `silent` 选项设置为 `true`，以启用并发流之间的服务器端带宽平衡。

不允许从推送的流中调用 `http2stream.pushStream()` 并且会抛出错误。

##### `http2stream.respond([headers[, options]])`[#](http://nodejs.cn/api-v12/http2.html#http2streamrespondheaders-options)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_respond_headers_options.html)

-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `endStream` [<boolean>](http://url.nodejs.cn/jFbvuT) 设置为 `true` 表示响应将不包含有效负载数据。
    -   `waitForTrailers` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，`Http2Stream` 将在发送完最后的 `DATA` 帧后触发 `'wantTrailers'` 事件。

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream) => {
  stream.respond({ ':status': 200 });
  stream.end('some data');
});
```

当设置了 `options.waitForTrailers` 选项时，`'wantTrailers'` 事件将在将要发送的最后一块有效负载数据排队后立即发出。 然后可以使用 `http2stream.sendTrailers()` 方法将尾随标头字段发送到对等方。

当设置了 `options.waitForTrailers`，则传输完最后的 `DATA` 帧时，`Http2Stream` 不会自动关闭。 用户代码必须调用 `http2stream.sendTrailers()` 或 `http2stream.close()` 来关闭 `Http2Stream`。

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream) => {
  stream.respond({ ':status': 200 }, { waitForTrailers: true });
  stream.on('wantTrailers', () => {
    stream.sendTrailers({ ABC: 'some value to send' });
  });
  stream.end('some data');
});
```

##### `http2stream.respondWithFD(fd[, headers[, options]])`[#](http://nodejs.cn/api-v12/http2.html#http2streamrespondwithfdfd-headers-options)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_respondwithfd_fd_headers_options.html)

-   `fd` [<number>](http://url.nodejs.cn/SXbo1v) | [<FileHandle>](http://nodejs.cn/api/fs.html#class-filehandle) 可读的文件描述符。
-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `statCheck` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `waitForTrailers` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，`Http2Stream` 将在发送完最后的 `DATA` 帧后触发 `'wantTrailers'` 事件。
    -   `offset` [<number>](http://url.nodejs.cn/SXbo1v) 开始读取的偏移位置。
    -   `length` [<number>](http://url.nodejs.cn/SXbo1v) 从文件描述符发送的数据量。

启动响应，其数据从给定的文件描述符中读取。 不对给定的文件描述符进行验证。 如果在尝试使用文件描述符读取数据时发生错误，则 `Http2Stream` 将使用标准 `INTERNAL_ERROR` 代码使用 `RST_STREAM` 帧关闭。

当使用时，`Http2Stream` 对象的 `Duplex` 接口会自动关闭。

```
const http2 = require('http2');
const fs = require('fs');

const server = http2.createServer();
server.on('stream', (stream) => {
  const fd = fs.openSync('/some/file', 'r');

  const stat = fs.fstatSync(fd);
  const headers = {
    'content-length': stat.size,
    'last-modified': stat.mtime.toUTCString(),
    'content-type': 'text/plain; charset=utf-8'
  };
  stream.respondWithFD(fd, headers);
  stream.on('close', () => fs.closeSync(fd));
});
```

可以指定可选的 `options.statCheck` 函数，让用户代码有机会根据给定文件描述符的 `fs.Stat` 详细信息设置其他内容标头。 如果提供了 `statCheck` 函数，则 `http2stream.respondWithFD()` 方法将执行 `fs.fstat()` 调用以收集有关提供的文件描述符的详细信息。

`offset` 和 `length` 选项可用于限制对特定范围子集的响应。 例如，这可用于支持 HTTP 范围请求。

文件描述符或 `FileHandle` 在流关闭时没有关闭，所以一旦不再需要它就需要手动关闭。 不支持对多个流同时使用相同的文件描述符，这可能会导致数据丢失。 支持在流结束后重新使用文件描述符。

当设置了 `options.waitForTrailers` 选项时，`'wantTrailers'` 事件将在将要发送的最后一块有效负载数据排队后立即发出。 然后可以使用 `http2stream.sendTrailers()` 方法将尾随标头字段发送到对等方。

当设置了 `options.waitForTrailers`，则传输完最后的 `DATA` 帧时，`Http2Stream` 不会自动关闭。 用户代码_必须_调用 `http2stream.sendTrailers()` 或 `http2stream.close()` 来关闭 `Http2Stream`。

```
const http2 = require('http2');
const fs = require('fs');

const server = http2.createServer();
server.on('stream', (stream) => {
  const fd = fs.openSync('/some/file', 'r');

  const stat = fs.fstatSync(fd);
  const headers = {
    'content-length': stat.size,
    'last-modified': stat.mtime.toUTCString(),
    'content-type': 'text/plain; charset=utf-8'
  };
  stream.respondWithFD(fd, headers, { waitForTrailers: true });
  stream.on('wantTrailers', () => {
    stream.sendTrailers({ ABC: 'some value to send' });
  });

  stream.on('close', () => fs.closeSync(fd));
});
```

##### `http2stream.respondWithFile(path[, headers[, options]])`[#](http://nodejs.cn/api-v12/http2.html#http2streamrespondwithfilepath-headers-options)

[中英对照](http://nodejs.cn/api-v12/http2/http2stream_respondwithfile_path_headers_options.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `statCheck` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `onError` [<Function>](http://url.nodejs.cn/ceTQa6) 在发送前发生错误时调用的回调函数。
    -   `waitForTrailers` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，`Http2Stream` 将在发送完最后的 `DATA` 帧后触发 `'wantTrailers'` 事件。
    -   `offset` [<number>](http://url.nodejs.cn/SXbo1v) 开始读取的偏移位置。
    -   `length` [<number>](http://url.nodejs.cn/SXbo1v) 从文件描述符发送的数据量。

发送普通文件作为响应。 `path` 必须指定常规文件，否则将在 `Http2Stream` 对象上触发 `'error'` 事件。

当使用时，`Http2Stream` 对象的 `Duplex` 接口会自动关闭。

可以指定可选的 `options.statCheck` 函数，让用户代码有机会根据给定文件的 `fs.Stat` 详细信息设置其他内容标题：

如果在尝试读取文件数据时发生错误，将使用标准 `INTERNAL_ERROR` 代码使用 `RST_STREAM` 帧关闭 `Http2Stream`。 如果定义了 `onError` 回调，则它将被调用。 否则流将被破坏。

使用文件路径的示例：

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream) => {
  function statCheck(stat, headers) {
    headers['last-modified'] = stat.mtime.toUTCString();
  }

  function onError(err) {
    if (err.code === 'ENOENT') {
      stream.respond({ ':status': 404 });
    } else {
      stream.respond({ ':status': 500 });
    }
    stream.end();
  }

  stream.respondWithFile('/some/file',
                         { 'content-type': 'text/plain; charset=utf-8' },
                         { statCheck, onError });
});
```

`options.statCheck` 函数也可以通过返回 `false` 来取消发送操作。 例如，条件请求可能会检查统计结果以确定文件是否已被修改以返回适当的 `304` 响应：

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream) => {
  function statCheck(stat, headers) {
    // 检查这里的统计数据...
    stream.respond({ ':status': 304 });
    return false; // 取消发送操作
  }
  stream.respondWithFile('/some/file',
                         { 'content-type': 'text/plain; charset=utf-8' },
                         { statCheck });
});
```

将自动设置 `content-length` 标头字段。

`offset` 和 `length` 选项可用于限制对特定范围子集的响应。 例如，这可用于支持 HTTP 范围请求。

`options.onError` 函数也可用于处理在启动文件传递之前可能发生的所有错误。 默认行为是销毁流。

当设置了 `options.waitForTrailers` 选项时，`'wantTrailers'` 事件将在将要发送的最后一块有效负载数据排队后立即发出。 然后可以使用 `http2stream.sendTrailers()` 方法将尾随标头字段发送到对等方。

当设置了 `options.waitForTrailers`，则传输完最后的 `DATA` 帧时，`Http2Stream` 不会自动关闭。 用户代码必须调用 `http2stream.sendTrailers()` 或 `http2stream.close()` 来关闭 `Http2Stream`。

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream) => {
  stream.respondWithFile('/some/file',
                         { 'content-type': 'text/plain; charset=utf-8' },
                         { waitForTrailers: true });
  stream.on('wantTrailers', () => {
    stream.sendTrailers({ ABC: 'some value to send' });
  });
});
```

#### `Http2Server` 类[#](http://nodejs.cn/api-v12/http2.html#class-http2server)

[中英对照](http://nodejs.cn/api-v12/http2/class_http2server.html)

新增于: v8.4.0

-   继承自: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

`Http2Server` 的实例是使用 `http2.createServer()` 函数创建的。 `Http2Server` 类不是由 `http2` 模块直接导出的。

##### `'checkContinue'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-checkcontinue)

[中英对照](http://nodejs.cn/api-v12/http2/event_checkcontinue.html)

新增于: v8.5.0

-   `request` [<http2.Http2ServerRequest>](http://nodejs.cn/api/http2.html#class-http2http2serverrequest)
-   `response` [<http2.Http2ServerResponse>](http://nodejs.cn/api/http2.html#class-http2http2serverresponse)

如果注册了 [`'request'`](http://nodejs.cn/api-v12/http2.html#http2_event_request) 监听器或为 [`http2.createServer()`](http://nodejs.cn/api-v12/http2.html#http2_http2_createserver_options_onrequesthandler) 提供了回调函数，则每次收到带有 HTTP `Expect: 100-continue` 的请求时都会触发 `'checkContinue'` 事件。 如果没有监听此事件，则服务器会自动响应状态为 `100 Continue`。

如果客户端应该继续发送请求正文，则处理此事件涉及调用 [`response.writeContinue()`](http://nodejs.cn/api-v12/http2.html#http2_response_writecontinue)，或者如果客户端不应该继续发送请求正文，则生成适当的 HTTP 响应（例如 400 Bad Request）。

处理和处理此事件时，不会触发 [`'request'`](http://nodejs.cn/api-v12/http2.html#http2_event_request) 事件。

#### `'connection'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-connection)

[中英对照](http://nodejs.cn/api-v12/http2/event_connection.html)

新增于: v8.4.0

-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

当建立新的 TCP 流时会触发此事件。 `socket` 通常是 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 类型的对象。 通常用户不会想访问这个事件。

此事件也可以由用户显式发出，以将连接注入 HTTP 服务器。 在这种情况下，任何 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流都可以通过。

##### `'request'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-request)

[中英对照](http://nodejs.cn/api-v12/http2/event_request.html)

新增于: v8.4.0

-   `request` [<http2.Http2ServerRequest>](http://nodejs.cn/api/http2.html#class-http2http2serverrequest)
-   `response` [<http2.Http2ServerResponse>](http://nodejs.cn/api/http2.html#class-http2http2serverresponse)

每次有请求时触发。 每个会话可能有多个请求。 请参阅[兼容性 API](http://nodejs.cn/api-v12/http2.html#http2_compatibility_api)。

##### `'session'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-session)

[中英对照](http://nodejs.cn/api-v12/http2/event_session.html)

新增于: v8.4.0

当 `Http2Server` 创建新的 `Http2Session` 时，则会触发 `'session'` 事件。

##### `'sessionError'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-sessionerror)

[中英对照](http://nodejs.cn/api-v12/http2/event_sessionerror.html)

新增于: v8.4.0

当与 `Http2Server` 关联的 `Http2Session` 对象触发 `'error'` 事件时，则将触发 `'sessionError'` 事件。

##### `'stream'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-stream_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_stream_1.html)

新增于: v8.4.0

当与服务器关联的 `Http2Session` 触发 `'stream'` 事件时，则将触发 `'stream'` 事件。

```
const http2 = require('http2');
const {
  HTTP2_HEADER_METHOD,
  HTTP2_HEADER_PATH,
  HTTP2_HEADER_STATUS,
  HTTP2_HEADER_CONTENT_TYPE
} = http2.constants;

const server = http2.createServer();
server.on('stream', (stream, headers, flags) => {
  const method = headers[HTTP2_HEADER_METHOD];
  const path = headers[HTTP2_HEADER_PATH];
  // ...
  stream.respond({
    [HTTP2_HEADER_STATUS]: 200,
    [HTTP2_HEADER_CONTENT_TYPE]: 'text/plain; charset=utf-8'
  });
  stream.write('hello ');
  stream.end('world');
});
```

##### `'timeout'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-timeout_2)

[中英对照](http://nodejs.cn/api-v12/http2/event_timeout_2.html)

新增于: v8.4.0

当服务器上在使用 `http2server.setTimeout()` 设置的给定毫秒数内没有活动时，则会触发 `'timeout'` 事件。 **默认值:** 2 分钟。

##### `server.close([callback])`[#](http://nodejs.cn/api-v12/http2.html#serverclosecallback)

[中英对照](http://nodejs.cn/api-v12/http2/server_close_callback.html)

新增于: v8.4.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

停止服务器建立新会话。 由于 HTTP/2 会话的持久性，这不会阻止创建新的请求流。 要正常地关闭服务器，则在所有活动会话上调用 [`http2session.close()`](http://nodejs.cn/api-v12/http2.html#http2_http2session_close_callback)。

如果提供了 `callback`，则在所有活动会话都关闭之前不会调用它，尽管服务器已经停止允许新会话。 有关详细信息，请参阅 [`net.Server.close()`](http://nodejs.cn/api-v12/net.html#net_server_close_callback)。

##### `server.setTimeout([msecs][, callback])`[#](http://nodejs.cn/api-v12/http2.html#serversettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http2/server_settimeout_msecs_callback.html)

新增于: v8.4.0

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `120000` （2 分钟）
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<Http2Server>](http://nodejs.cn/api/http2.html#class-http2server)

用于设置 http2 服务器请求的超时值，设置 `msecs` 毫秒后 `Http2Server` 上没有活动时调用的回调函数。

给定的回调已注册为 `'timeout'` 事件的监听器。

#### `Http2SecureServer` 类[#](http://nodejs.cn/api-v12/http2.html#class-http2secureserver)

[中英对照](http://nodejs.cn/api-v12/http2/class_http2secureserver.html)

新增于: v8.4.0

-   继承自: [<tls.Server>](http://nodejs.cn/api/tls.html#class-tlsserver)

`Http2SecureServer` 的实例是使用 `http2.createSecureServer()` 函数创建的。 `Http2SecureServer` 类不是由 `http2` 模块直接导出的。

##### `'checkContinue'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-checkcontinue_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_checkcontinue_1.html)

新增于: v8.5.0

-   `request` [<http2.Http2ServerRequest>](http://nodejs.cn/api/http2.html#class-http2http2serverrequest)
-   `response` [<http2.Http2ServerResponse>](http://nodejs.cn/api/http2.html#class-http2http2serverresponse)

如果注册了 [`'request'`](http://nodejs.cn/api-v12/http2.html#http2_event_request) 监听器或为 [`http2.createSecureServer()`](http://nodejs.cn/api-v12/http2.html#http2_http2_createsecureserver_options_onrequesthandler) 提供了回调函数，则每次收到带有 HTTP `Expect: 100-continue` 的请求时都会触发 `'checkContinue'` 事件。 如果没有监听此事件，则服务器会自动响应状态为 `100 Continue`。

如果客户端应该继续发送请求正文，则处理此事件涉及调用 [`response.writeContinue()`](http://nodejs.cn/api-v12/http2.html#http2_response_writecontinue)，或者如果客户端不应该继续发送请求正文，则生成适当的 HTTP 响应（例如 400 Bad Request）。

处理和处理此事件时，不会触发 [`'request'`](http://nodejs.cn/api-v12/http2.html#http2_event_request) 事件。

#### `'connection'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-connection_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_connection_1.html)

新增于: v8.4.0

-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

此事件在建立新的 TCP 流时触发，在 TLS 握手开始之前。 `socket` 通常是 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 类型的对象。 通常用户不会想访问这个事件。

此事件也可以由用户显式发出，以将连接注入 HTTP 服务器。 在这种情况下，任何 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流都可以通过。

##### `'request'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-request_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_request_1.html)

新增于: v8.4.0

-   `request` [<http2.Http2ServerRequest>](http://nodejs.cn/api/http2.html#class-http2http2serverrequest)
-   `response` [<http2.Http2ServerResponse>](http://nodejs.cn/api/http2.html#class-http2http2serverresponse)

每次有请求时触发。 每个会话可能有多个请求。 请参阅[兼容性 API](http://nodejs.cn/api-v12/http2.html#http2_compatibility_api)。

##### `'session'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-session_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_session_1.html)

新增于: v8.4.0

当 `Http2SecureServer` 创建新的 `Http2Session` 时，则会触发 `'session'` 事件。

##### `'sessionError'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-sessionerror_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_sessionerror_1.html)

新增于: v8.4.0

当与 `Http2SecureServer` 关联的 `Http2Session` 对象触发 `'error'` 事件时，则将触发 `'sessionError'` 事件。

##### `'stream'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-stream_2)

[中英对照](http://nodejs.cn/api-v12/http2/event_stream_2.html)

新增于: v8.4.0

当与服务器关联的 `Http2Session` 触发 `'stream'` 事件时，则将触发 `'stream'` 事件。

```
const http2 = require('http2');
const {
  HTTP2_HEADER_METHOD,
  HTTP2_HEADER_PATH,
  HTTP2_HEADER_STATUS,
  HTTP2_HEADER_CONTENT_TYPE
} = http2.constants;

const options = getOptionsSomehow();

const server = http2.createSecureServer(options);
server.on('stream', (stream, headers, flags) => {
  const method = headers[HTTP2_HEADER_METHOD];
  const path = headers[HTTP2_HEADER_PATH];
  // ...
  stream.respond({
    [HTTP2_HEADER_STATUS]: 200,
    [HTTP2_HEADER_CONTENT_TYPE]: 'text/plain; charset=utf-8'
  });
  stream.write('hello ');
  stream.end('world');
});
```

##### `'timeout'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-timeout_3)

[中英对照](http://nodejs.cn/api-v12/http2/event_timeout_3.html)

新增于: v8.4.0

当服务器上在使用 `http2secureServer.setTimeout()` 设置的给定毫秒数内没有活动时，则会触发 `'timeout'` 事件。 **默认值:** 2 分钟。

##### `'unknownProtocol'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-unknownprotocol)

[中英对照](http://nodejs.cn/api-v12/http2/event_unknownprotocol.html)

新增于: v8.4.0

当连接的客户端无法协商允许的协议（即 HTTP/2 或 HTTP/1.1）时，则会触发 `'unknownProtocol'` 事件。 事件句柄接收套接字进行处理。 如果没有为该事件注册监听器，则连接将终止。 可以使用传给 [`http2.createSecureServer()`](http://nodejs.cn/api-v12/http2.html#http2_http2_createsecureserver_options_onrequesthandler) 的 `'unknownProtocolTimeout'` 选项指定超时。 请参阅[兼容性 API](http://nodejs.cn/api-v12/http2.html#http2_compatibility_api)。

##### `server.close([callback])`[#](http://nodejs.cn/api-v12/http2.html#serverclosecallback_1)

[中英对照](http://nodejs.cn/api-v12/http2/server_close_callback_1.html)

新增于: v8.4.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

停止服务器建立新会话。 由于 HTTP/2 会话的持久性，这不会阻止创建新的请求流。 要正常地关闭服务器，则在所有活动会话上调用 [`http2session.close()`](http://nodejs.cn/api-v12/http2.html#http2_http2session_close_callback)。

如果提供了 `callback`，则在所有活动会话都关闭之前不会调用它，尽管服务器已经停止允许新会话。 有关详细信息，请参阅 [`tls.Server.close()`](http://nodejs.cn/api-v12/tls.html#tls_server_close_callback)。

##### `server.setTimeout([msecs][, callback])`[#](http://nodejs.cn/api-v12/http2.html#serversettimeoutmsecs-callback_1)

[中英对照](http://nodejs.cn/api-v12/http2/server_settimeout_msecs_callback_1.html)

新增于: v8.4.0

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `120000` （2 分钟）
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<Http2SecureServer>](http://nodejs.cn/api/http2.html#class-http2secureserver)

用于设置 http2 安全服务器请求的超时值，设置 `msecs` 毫秒后 `Http2SecureServer` 上没有活动时调用的回调函数。

给定的回调已注册为 `'timeout'` 事件的监听器。

#### `http2.createServer(options[, onRequestHandler])`[#](http://nodejs.cn/api-v12/http2.html#http2createserveroptions-onrequesthandler)

[中英对照](http://nodejs.cn/api-v12/http2/http2_createserver_options_onrequesthandler.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `maxDeflateDynamicTableSize` [<number>](http://url.nodejs.cn/SXbo1v) 设置用于压缩标头字段的最大动态表大小。 **默认值:** `4Kib`。
        
    -   `maxSettings` [<number>](http://url.nodejs.cn/SXbo1v) 设置每 `SETTINGS` 帧的最大设置条目数。 允许的最小值为 `1`。 **默认值:** `32`。
        
    -   `maxSessionMemory`[<number>](http://url.nodejs.cn/SXbo1v) 设置 `Http2Session` 允许使用的最大内存。 该值以兆字节数表示，例如 `1` 等于 1 兆字节。 允许的最小值为 `1`。 这是一个基于信用的限制，现有的 `Http2Stream` 可能会导致超出此限制，但超过此限制时，新的 `Http2Stream` 实例将被拒绝。 当前 `Http2Stream` 会话数、标头压缩表的当前内存使用、当前排队等待发送的数据以及未确认的 `PING` 和 `SETTINGS` 帧都计入当前限制。 **默认值:** `10`。
        
    -   `maxHeaderListPairs` [<number>](http://url.nodejs.cn/SXbo1v) 设置标头条目的最大数量。 这类似于 [`http.Server#maxHeadersCount`](http://nodejs.cn/api-v12/http.html#http_server_maxheaderscount) 或 [`http.ClientRequest#maxHeadersCount`](http://nodejs.cn/api-v12/http.html#http_request_maxheaderscount)。 最小值为 `4`。 **默认值:** `128`。
        
    -   `maxOutstandingPings` [<number>](http://url.nodejs.cn/SXbo1v) 设置未确认的未确认 ping 的最大数量。 **默认值:** `10`。
        
    -   `maxSendHeaderBlockLength` [<number>](http://url.nodejs.cn/SXbo1v) 设置序列化的、压缩的标头块的最大允许大小。 尝试发送超出此限制的标头将导致触发 `'frameError'` 事件并且流被关闭和销毁。
        
    -   `paddingStrategy` [<number>](http://url.nodejs.cn/SXbo1v) 用于确定用于 `HEADERS` 和 `DATA` 帧的填充量的策略。 **默认值:** `http2.constants.PADDING_STRATEGY_NONE`。 值可能是以下之一：
        
        -   `http2.constants.PADDING_STRATEGY_NONE`:
            
        -   `http2.constants.PADDING_STRATEGY_MAX`:
            
        -   `http2.constants.PADDING_STRATEGY_CALLBACK`:
            
        -   `http2.constants.PADDING_STRATEGY_ALIGNED`:
            
    -   `peerMaxConcurrentStreams` [<number>](http://url.nodejs.cn/SXbo1v) 设置远程对等方的最大并发流数，就好像已收到 `SETTINGS` 帧一样。 如果远程对等方为 `maxConcurrentStreams` 设置了自己的值，则将被覆盖。 **默认值:** `100`。
        
    -   `maxSessionInvalidFrames` [<integer>](http://url.nodejs.cn/SXbo1v) 设置会话关闭前允许的最大无效帧数。 **默认值:** `1000`。
        
    -   `maxSessionRejectedStreams` [<integer>](http://url.nodejs.cn/SXbo1v) 设置会话关闭前允许的创建流拒绝的最大数量。 每个拒绝都与 `NGHTTP2_ENHANCE_YOUR_CALM` 错误相关联，该错误应该告诉对等方不要再打开任何流，因此继续打开流被视为行为不端的对等方的标志。 **默认值:** `100`。
        
    -   `selectPadding` [<Function>](http://url.nodejs.cn/ceTQa6)
        
    -   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object) 连接时发送到远程对等方的初始设置。
        
    -   `Http1IncomingMessage` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage) 指定用于 HTTP/1 回退的 `IncomingMessage` 类。 用于扩展原始的 `http.IncomingMessage`。 **默认值:** `http.IncomingMessage`。
        
    -   `Http1ServerResponse` [<http.ServerResponse>](http://nodejs.cn/api/http.html#class-httpserverresponse) 指定用于 HTTP/1 回退的 `ServerResponse` 类。 用于扩展原始的 `http.ServerResponse`。 **默认值:** `http.ServerResponse`。
        
    -   `Http2ServerRequest` [<http2.Http2ServerRequest>](http://nodejs.cn/api/http2.html#class-http2http2serverrequest) 指定要使用的 `Http2ServerRequest` 类。 用于扩展原始的 `Http2ServerRequest`。 **默认值:** `Http2ServerRequest`。
        
    -   `Http2ServerResponse` [<http2.Http2ServerResponse>](http://nodejs.cn/api/http2.html#class-http2http2serverresponse) 指定要使用的 `Http2ServerResponse` 类。 用于扩展原始的 `Http2ServerResponse`。 **默认值:** `Http2ServerResponse`。
        
    -   `unknownProtocolTimeout` [<number>](http://url.nodejs.cn/SXbo1v) 指定在触发 [`'unknownProtocol'`](http://nodejs.cn/api-v12/http2.html#http2_event_unknownprotocol) 时服务器应等待的超时（以毫秒为单位）。 如果到那时套接字还没有被销毁，则服务器将销毁它。 **默认值:** `10000`。
        
    -   ...: 可以提供任何 [`net.createServer()`](http://nodejs.cn/api-v12/net.html#net_net_createserver_options_connectionlistener) 选项。
        
-   `onRequestHandler` [<Function>](http://url.nodejs.cn/ceTQa6) 参见[兼容性 API](http://nodejs.cn/api-v12/http2.html#http2_compatibility_api)
-   返回: [<Http2Server>](http://nodejs.cn/api/http2.html#class-http2server)

返回创建和管理 `Http2Session` 实例的 `net.Server` 实例。

由于没有已知的浏览器支持[未加密的 HTTP/2](http://url.nodejs.cn/yfVdqh)，所以在与浏览器客户端通信时必须使用 [`http2.createSecureServer()`](http://nodejs.cn/api-v12/http2.html#http2_http2_createsecureserver_options_onrequesthandler)。

```
const http2 = require('http2');

// 创建未加密的 HTTP/2 服务器。
// 由于没有已知的浏览器支持
// 未加密的 HTTP/2，
// 所以在与浏览器客户端通信时必须使用 `http2.createSecureServer()`。
const server = http2.createServer();

server.on('stream', (stream, headers) => {
  stream.respond({
    'content-type': 'text/html; charset=utf-8',
    ':status': 200
  });
  stream.end('<h1>Hello World</h1>');
});

server.listen(80);
```

#### `http2.createSecureServer(options[, onRequestHandler])`[#](http://nodejs.cn/api-v12/http2.html#http2createsecureserveroptions-onrequesthandler)

[中英对照](http://nodejs.cn/api-v12/http2/http2_createsecureserver_options_onrequesthandler.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `allowHTTP1` [<boolean>](http://url.nodejs.cn/jFbvuT) 当设置为 `true` 时，不支持 HTTP/2 的传入客户端连接将降级为 HTTP/1.x。 参见 [`'unknownProtocol'`](http://nodejs.cn/api-v12/http2.html#http2_event_unknownprotocol) 事件。 参见 [ALPN 协商](http://nodejs.cn/api-v12/http2.html#http2_alpn_negotiation)。 **默认值:** `false`。
        
    -   `maxDeflateDynamicTableSize` [<number>](http://url.nodejs.cn/SXbo1v) 设置用于压缩标头字段的最大动态表大小。 **默认值:** `4Kib`。
        
    -   `maxSettings` [<number>](http://url.nodejs.cn/SXbo1v) 设置每 `SETTINGS` 帧的最大设置条目数。 允许的最小值为 `1`。 **默认值:** `32`。
        
    -   `maxSessionMemory`[<number>](http://url.nodejs.cn/SXbo1v) 设置 `Http2Session` 允许使用的最大内存。 该值以兆字节数表示，例如 `1` 等于 1 兆字节。 允许的最小值为 `1`。 这是一个基于信用的限制，现有的 `Http2Stream` 可能会导致超出此限制，但超过此限制时，新的 `Http2Stream` 实例将被拒绝。 当前 `Http2Stream` 会话数、标头压缩表的当前内存使用、当前排队等待发送的数据以及未确认的 `PING` 和 `SETTINGS` 帧都计入当前限制。 **默认值:** `10`。
        
    -   `maxHeaderListPairs` [<number>](http://url.nodejs.cn/SXbo1v) 设置标头条目的最大数量。 这类似于 [`http.Server#maxHeadersCount`](http://nodejs.cn/api-v12/http.html#http_server_maxheaderscount) 或 [`http.ClientRequest#maxHeadersCount`](http://nodejs.cn/api-v12/http.html#http_request_maxheaderscount)。 最小值为 `4`。 **默认值:** `128`。
        
    -   `maxOutstandingPings` [<number>](http://url.nodejs.cn/SXbo1v) 设置未确认的未确认 ping 的最大数量。 **默认值:** `10`。
        
    -   `maxSendHeaderBlockLength` [<number>](http://url.nodejs.cn/SXbo1v) 设置序列化的、压缩的标头块的最大允许大小。 尝试发送超出此限制的标头将导致触发 `'frameError'` 事件并且流被关闭和销毁。
        
    -   `paddingStrategy` [<number>](http://url.nodejs.cn/SXbo1v) 用于确定用于 `HEADERS` 和 `DATA` 帧的填充量的策略。 **默认值:** `http2.constants.PADDING_STRATEGY_NONE`。 值可能是以下之一：
        
        -   `http2.constants.PADDING_STRATEGY_NONE`:
            
        -   `http2.constants.PADDING_STRATEGY_MAX`:
            
        -   `http2.constants.PADDING_STRATEGY_CALLBACK`:
            
        -   `http2.constants.PADDING_STRATEGY_ALIGNED`:
            
    -   `peerMaxConcurrentStreams` [<number>](http://url.nodejs.cn/SXbo1v) 设置远程对等方的最大并发流数，就好像已收到 `SETTINGS` 帧一样。 如果远程对等方为 `maxConcurrentStreams` 设置了自己的值，则将被覆盖。 **默认值:** `100`。
        
    -   `maxSessionInvalidFrames` [<integer>](http://url.nodejs.cn/SXbo1v) 设置会话关闭前允许的最大无效帧数。 **默认值:** `1000`。
        
    -   `maxSessionRejectedStreams` [<integer>](http://url.nodejs.cn/SXbo1v) 设置会话关闭前允许的创建流拒绝的最大数量。 每个拒绝都与 `NGHTTP2_ENHANCE_YOUR_CALM` 错误相关联，该错误应该告诉对等方不要再打开任何流，因此继续打开流被视为行为不端的对等方的标志。 **默认值:** `100`。
        
    -   `selectPadding` [<Function>](http://url.nodejs.cn/ceTQa6)
        
    -   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object) 连接时发送到远程对等方的初始设置。
        
    -   ...: 可以提供任何 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener) 选项。 对于服务器，通常需要身份选项（`pfx` 或 `key`/`cert`）。
        
    -   `origins` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 在创建新服务器 `Http2Session` 后立即在 `ORIGIN` 帧内发送的原始字符串数组。
        
    -   `unknownProtocolTimeout` [<number>](http://url.nodejs.cn/SXbo1v) 指定在触发 [`'unknownProtocol'`](http://nodejs.cn/api-v12/http2.html#http2_event_unknownprotocol) 事件时服务器应等待的超时（以毫秒为单位）。 如果到那时套接字还没有被销毁，则服务器将销毁它。 **默认值:** `10000`。
        
-   `onRequestHandler` [<Function>](http://url.nodejs.cn/ceTQa6) 参见[兼容性 API](http://nodejs.cn/api-v12/http2.html#http2_compatibility_api)
-   返回: [<Http2SecureServer>](http://nodejs.cn/api/http2.html#class-http2secureserver)

返回创建和管理 `Http2Session` 实例的 `tls.Server` 实例。

```
const http2 = require('http2');
const fs = require('fs');

const options = {
  key: fs.readFileSync('server-key.pem'),
  cert: fs.readFileSync('server-cert.pem')
};

// 创建安全的 HTTP/2 服务器
const server = http2.createSecureServer(options);

server.on('stream', (stream, headers) => {
  stream.respond({
    'content-type': 'text/html; charset=utf-8',
    ':status': 200
  });
  stream.end('<h1>Hello World</h1>');
});

server.listen(80);
```

#### `http2.connect(authority[, options][, listener])`

[中英对照](http://nodejs.cn/api-v12/http2/http2_connect_authority_options_listener.html)

-   `authority` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 要连接的远程 HTTP/2 服务器。 这必须是带有 `http://` 或 `https://` 前缀、主机名和 IP 端口（如果使用非默认端口）的最小有效 URL 的形式。 URL 中的用户信息（用户 ID 和密码）、路径、查询字符串和片段详细信息将被忽略。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `maxDeflateDynamicTableSize` [<number>](http://url.nodejs.cn/SXbo1v) 设置用于压缩标头字段的最大动态表大小。 **默认值:** `4Kib`。
        
    -   `maxSettings` [<number>](http://url.nodejs.cn/SXbo1v) 设置每 `SETTINGS` 帧的最大设置条目数。 允许的最小值为 `1`。 **默认值:** `32`。
        
    -   `maxSessionMemory`[<number>](http://url.nodejs.cn/SXbo1v) 设置 `Http2Session` 允许使用的最大内存。 该值以兆字节数表示，例如 `1` 等于 1 兆字节。 允许的最小值为 `1`。 这是一个基于信用的限制，现有的 `Http2Stream` 可能会导致超出此限制，但超过此限制时，新的 `Http2Stream` 实例将被拒绝。 当前 `Http2Stream` 会话数、标头压缩表的当前内存使用、当前排队等待发送的数据以及未确认的 `PING` 和 `SETTINGS` 帧都计入当前限制。 **默认值:** `10`。
        
    -   `maxHeaderListPairs` [<number>](http://url.nodejs.cn/SXbo1v) 设置标头条目的最大数量。 这类似于 [`http.Server#maxHeadersCount`](http://nodejs.cn/api-v12/http.html#http_server_maxheaderscount) 或 [`http.ClientRequest#maxHeadersCount`](http://nodejs.cn/api-v12/http.html#http_request_maxheaderscount)。 最小值为 `1`。 **默认值:** `128`。
        
    -   `maxOutstandingPings` [<number>](http://url.nodejs.cn/SXbo1v) 设置未确认的未确认 ping 的最大数量。 **默认值:** `10`。
        
    -   `maxReservedRemoteStreams` [<number>](http://url.nodejs.cn/SXbo1v) 设置客户端在任何给定时间将接受的最大保留推送流数。 一旦当前预留的推送流数量超过此限制，则服务器发送的新推送流将被自动拒绝。 最小允许值为 0。 最大允许值为 232\-1。 负值将此选项设置为最大允许值。 **默认值:** `200`。
        
    -   `maxSendHeaderBlockLength` [<number>](http://url.nodejs.cn/SXbo1v) 设置序列化的、压缩的标头块的最大允许大小。 尝试发送超出此限制的标头将导致触发 `'frameError'` 事件并且流被关闭和销毁。
        
    -   `paddingStrategy` [<number>](http://url.nodejs.cn/SXbo1v) 用于确定用于 `HEADERS` 和 `DATA` 帧的填充量的策略。 **默认值:** `http2.constants.PADDING_STRATEGY_NONE`。 值可能是以下之一：
        
        -   `http2.constants.PADDING_STRATEGY_NONE`:
            
        -   `http2.constants.PADDING_STRATEGY_MAX`:
            
        -   `http2.constants.PADDING_STRATEGY_CALLBACK`:
            
        -   `http2.constants.PADDING_STRATEGY_ALIGNED`:
            
    -   `peerMaxConcurrentStreams` [<number>](http://url.nodejs.cn/SXbo1v) 设置远程对等方的最大并发流数，就好像已收到 `SETTINGS` 帧一样。 如果远程对等方为 `maxConcurrentStreams` 设置了自己的值，则将被覆盖。 **默认值:** `100`。
        
    -   `selectPadding` [<Function>](http://url.nodejs.cn/ceTQa6)
        
    -   `protocol` [<string>](http://url.nodejs.cn/9Tw2bK) 要连接的协议，如果在 `authority` 中没有设置。 值可以是 `'http:'` 或 `'https:'`。 **默认值:** `'https:'`
        
    -   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object) 连接时发送到远程对等方的初始设置。
        
    -   `createConnection` [<Function>](http://url.nodejs.cn/ceTQa6) 可选的回调，它接收传给 `connect` 和 `options` 对象的 `URL` 实例，并返回将用作此会话连接的任何 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流。
        
    -   ...: 可以提供任何 [`net.connect()`](http://nodejs.cn/api-v12/net.html#net_net_connect) 或 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 选项。
        
    -   `unknownProtocolTimeout` [<number>](http://url.nodejs.cn/SXbo1v) 指定在触发 [`'unknownProtocol'`](http://nodejs.cn/api-v12/http2.html#http2_event_unknownprotocol) 事件时服务器应等待的超时（以毫秒为单位）。 如果到那时套接字还没有被销毁，则服务器将销毁它。 **默认值:** `10000`。
        
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 将注册为 [`'connect'`](http://nodejs.cn/api-v12/http2.html#http2_event_connect) 事件的单次监听器。
-   返回: [<ClientHttp2Session>](http://nodejs.cn/api/http2.html#class-clienthttp2session)

返回 `ClientHttp2Session` 实例。

```
const http2 = require('http2');
const client = http2.connect('https://localhost:1234');

/* 使用客户端 */

client.close();
```

#### `http2.constants`[#](http://nodejs.cn/api-v12/http2.html#http2constants)

新增于: v8.4.0

##### RST\_STREAM 与 GOAWAY 的错误码[#](http://nodejs.cn/api-v12/http2.html#error-codes-for-rst_stream-and-goaway)

[中英对照](http://nodejs.cn/api-v12/http2/error_codes_for_rst_stream_and_goaway.html)

| Value | Name | Constant |
| --- | --- | --- |
| `0x00` | 没有错误 | `http2.constants.NGHTTP2_NO_ERROR` |
| `0x01` | 协议错误 | `http2.constants.NGHTTP2_PROTOCOL_ERROR` |
| `0x02` | 内部错误 | `http2.constants.NGHTTP2_INTERNAL_ERROR` |
| `0x03` | 流量控制错误 | `http2.constants.NGHTTP2_FLOW_CONTROL_ERROR` |
| `0x04` | 设置超时 | `http2.constants.NGHTTP2_SETTINGS_TIMEOUT` |
| `0x05` | 流关闭 | `http2.constants.NGHTTP2_STREAM_CLOSED` |
| `0x06` | 帧大小错误 | `http2.constants.NGHTTP2_FRAME_SIZE_ERROR` |
| `0x07` | 拒绝流 | `http2.constants.NGHTTP2_REFUSED_STREAM` |
| `0x08` | 取消 | `http2.constants.NGHTTP2_CANCEL` |
| `0x09` | 压缩错误 | `http2.constants.NGHTTP2_COMPRESSION_ERROR` |
| `0x0a` | 连接错误 | `http2.constants.NGHTTP2_CONNECT_ERROR` |
| `0x0b` | 增强你的冷静 | `http2.constants.NGHTTP2_ENHANCE_YOUR_CALM` |
| `0x0c` | 安全性不足 | `http2.constants.NGHTTP2_INADEQUATE_SECURITY` |
| `0x0d` | 需要 HTTP/1.1 | `http2.constants.NGHTTP2_HTTP_1_1_REQUIRED` |

当服务器上在使用 `http2server.setTimeout()` 设置的给定毫秒数内没有活动时，则会触发 `'timeout'` 事件。

#### `http2.getDefaultSettings()`[#](http://nodejs.cn/api-v12/http2.html#http2getdefaultsettings)

[中英对照](http://nodejs.cn/api-v12/http2/http2_getdefaultsettings.html)

新增于: v8.4.0

-   返回: [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object)

返回包含 `Http2Session` 实例默认设置的对象。 此方法每次调用时都会返回新的对象实例，因此可以安全地修改返回的实例以供使用。

#### `http2.getPackedSettings([settings])`[#](http://nodejs.cn/api-v12/http2.html#http2getpackedsettingssettings)

[中英对照](http://nodejs.cn/api-v12/http2/http2_getpackedsettings_settings.html)

新增于: v8.4.0

-   `settings` [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object)
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

返回 `Buffer` 实例，其中包含 [HTTP/2](http://url.nodejs.cn/3LCB4F) 规范中指定的给定 HTTP/2 设置的序列化表示。 这旨在与 `HTTP2-Settings` 标头字段一起使用。

```
const http2 = require('http2');

const packed = http2.getPackedSettings({ enablePush: false });

console.log(packed.toString('base64'));
// 打印: AAIAAAAA
```

#### `http2.getUnpackedSettings(buf)`[#](http://nodejs.cn/api-v12/http2.html#http2getunpackedsettingsbuf)

[中英对照](http://nodejs.cn/api-v12/http2/http2_getunpackedsettings_buf.html)

新增于: v8.4.0

-   `buf` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) 打包的设置。
-   返回: [<HTTP/2 Settings Object>](http://nodejs.cn/api/http2.html#settings-object)

返回 [HTTP/2 设置对象](http://nodejs.cn/api-v12/http2.html#http2_settings_object)，其中包含 `http2.getPackedSettings()` 生成的给定 `Buffer` 的反序列化设置。

#### 标头对象[#](http://nodejs.cn/api-v12/http2.html#headers-object)

[中英对照](http://nodejs.cn/api-v12/http2/headers_object.html)

标头在 JavaScript 对象上表示为自身的属性。 属性键将被序列化为小写。 属性值应该是字符串（如果不是，它们将被强制转换为字符串）或 `Array` 个字符串（以便为每个标头字段发送一个以上的值）。

```
const headers = {
  ':status': '200',
  'content-type': 'text-plain',
  'ABC': ['has', 'more', 'than', 'one', 'value']
};

stream.respond(headers);
```

传给回调函数的标头对象将有一个 `null` 原型。 这意味着 `Object.prototype.toString()` 和 `Object.prototype.hasOwnProperty()` 等普通 JavaScript 对象方法将不起作用。

对于传入的标头：

-   `:status` 标头转换为 `number`。
-   重复的 `:status`, `:method`, `:authority`, `:scheme`, `:path`, `:protocol`, `age`, `authorization`, `access-control-allow-credentials`, `access-control-max-age`, `access-control-request-method`, `content-encoding`, `content-language`, `content-length`, `content-location`, `content-md5`, `content-range`, `content-type`, `date`, `dnt`, `etag`, `expires`, `from`, `if-match`, `if-modified-since`, `if-none-match`, `if-range`, `if-unmodified-since`, `last-modified`, `location`, `max-forwards`, `proxy-authorization`, `range`, `referer`,`retry-after`, `tk`, `upgrade-insecure-requests`, `user-agent` 或 `x-content-type-options` 被丢弃。
-   `set-cookie` 始终是数组。 重复项被添加到数组中。
-   对于重复的 `cookie` 标头，其值使用 '; ' 连接。
-   对于所有其他标头，其值使用 ', ' 连接。

```
const http2 = require('http2');
const server = http2.createServer();
server.on('stream', (stream, headers) => {
  console.log(headers[':path']);
  console.log(headers.ABC);
});
```

#### 设置对象[#](http://nodejs.cn/api-v12/http2.html#settings-object)

[中英对照](http://nodejs.cn/api-v12/http2/settings_object.html)

`http2.getDefaultSettings()`、`http2.getPackedSettings()`、`http2.createServer()`、`http2.createSecureServer()`、`http2session.settings()`、`http2session.localSettings` 和 `http2session.remoteSettings` API 返回或接收一个对象作为输入，该对象定义了 `Http2Session` 对象的配置设置。 这些对象是包含以下属性的普通 JavaScript 对象。

-   `headerTableSize` [<number>](http://url.nodejs.cn/SXbo1v) 指定用于标头压缩的最大字节数。 最小允许值为 0。 最大允许值为 232\-1。 **默认值:** `4096`。
-   `enablePush` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果在 `Http2Session` 实例上允许 HTTP/2 推送流，则指定 `true`。 **默认值:** `true`。
-   `initialWindowSize` [<number>](http://url.nodejs.cn/SXbo1v) 指定_发送者的_初始窗口大小（以字节为单位），用于流级流量控制。 最小允许值为 0。 最大允许值为 232\-1。 **默认值:** `65535`。
-   `maxFrameSize` [<number>](http://url.nodejs.cn/SXbo1v) 指定最大帧有效载荷的字节大小。 最小允许值为 16,384。 最大允许值为 224\-1。 **默认值:** `16384`。
-   `maxConcurrentStreams` [<number>](http://url.nodejs.cn/SXbo1v) 指定 `Http2Session` 上允许的最大并发流数。 没有默认值意味着，至少在理论上，232\-1 个流可以在 `Http2Session` 中的任何给定时间同时打开。 最小值为 0。 最大允许值为 232\-1。 **默认值:** `4294967295`。
-   `maxHeaderListSize` [<number>](http://url.nodejs.cn/SXbo1v) 指定将被接受的标头列表的最大大小（未压缩的八位字节）。 最小允许值为 0。 最大允许值为 232\-1。 **默认值:** `65535`。
-   `maxHeaderSize` [<number>](http://url.nodejs.cn/SXbo1v) `maxHeaderListSize` 的别名。
-   `enableConnectProtocol`[<boolean>](http://url.nodejs.cn/jFbvuT) 如果要启用由 [RFC 8441](http://url.nodejs.cn/7ohy1C) 定义的"扩展连接协议"，则指定 `true`。 此设置仅在服务器发送时才有意义。 一旦为给定的 `Http2Session` 启用了 `enableConnectProtocol` 设置，就无法禁用它。 **默认值:** `false`。

设置对象上的所有附加属性都将被忽略。

#### Using `options.selectPadding()`[#](http://nodejs.cn/api-v12/http2.html#using-optionsselectpadding)

When `options.paddingStrategy` is equal to `http2.constants.PADDING_STRATEGY_CALLBACK`, the HTTP/2 implementation will consult the `options.selectPadding()` callback function, if provided, to determine the specific amount of padding to use per `HEADERS` and `DATA` frame.

The `options.selectPadding()` function receives two numeric arguments, `frameLen` and `maxFrameLen` and must return a number `N` such that `frameLen <= N <= maxFrameLen`.

```
const http2 = require('http2');
const server = http2.createServer({
  paddingStrategy: http2.constants.PADDING_STRATEGY_CALLBACK,
  selectPadding(frameLen, maxFrameLen) {
    return maxFrameLen;
  }
});
```

The `options.selectPadding()` function is invoked once for _every_ `HEADERS` and `DATA` frame. This has a definite noticeable impact on performance.

#### 错误处理[#](http://nodejs.cn/api-v12/http2.html#error-handling)

[中英对照](http://nodejs.cn/api-v12/http2/error_handling.html)

使用 `http2` 模块时可能会出现几种类型的错误情况：

当传入不正确的参数、选项或设置值时，则会发生验证错误。 这些将始终由同步 `throw` 报告。

在不正确的时间尝试操作时会发生状态错误（例如，尝试在流关闭后在流上发送数据）。 这些将使用同步 `throw` 或通过 `Http2Stream`、`Http2Session` 或 HTTP/2 服务器对象上的 `'error'` 事件报告，具体取决于错误发生的位置和时间。

当 HTTP/2 会话意外失败时会发生内部错误。 这些将通过 `Http2Session` 或 HTTP/2 服务器对象上的 `'error'` 事件报告。

当违反各种 HTTP/2 协议约束时会发生协议错误。 这些将使用同步 `throw` 或通过 `Http2Stream`、`Http2Session` 或 HTTP/2 服务器对象上的 `'error'` 事件报告，具体取决于错误发生的位置和时间。

#### 标头键值中的无效字符[#](http://nodejs.cn/api-v12/http2.html#invalid-character-handling-in-header-names-and-values)

[中英对照](http://nodejs.cn/api-v12/http2/invalid_character_handling_in_header_names_and_values.html)

HTTP/2 实现比 HTTP/1 实现更严格地处理 HTTP 标头名称和值中的无效字符。

标头字段名称_不区分大小写_，并严格作为小写字符串通过网络传输。 Node.js 提供的 API 允许将标头名称设置为混合大小写字符串（例如 `Content-Type`），但会在传输时将其转换为小写（例如 `content-type`）。

标头字段名称_必须仅_包含以下一个或多个 ASCII 字符：`a`\-`z`、`A`\-`Z`、`0`\-`9`、`!`、`#`、`$`、`%`、`&`、`'`、`*`、`+`、`-`、`.`、`^`、`_`、`` ` `` （反引号）、`|`、以及 `~`。

在 HTTP 标头字段名称中使用无效字符将导致流关闭并报告协议错误。

根据 HTTP 规范的要求，标头字段值的处理更为宽松，但_不应_包含换行符或回车符，并且_应_仅限于 US-ASCII 字符。

#### 推送流到客户端[#](http://nodejs.cn/api-v12/http2.html#push-streams-on-the-client)

[中英对照](http://nodejs.cn/api-v12/http2/push_streams_on_the_client.html)

要在客户端接收推送流，则在 `ClientHttp2Session` 上为 `'stream'` 事件设置监听器：

```
const http2 = require('http2');

const client = http2.connect('http://localhost');

client.on('stream', (pushedStream, requestHeaders) => {
  pushedStream.on('push', (responseHeaders) => {
    // 处理响应头
  });
  pushedStream.on('data', (chunk) => { /* 处理推送的数据 */ });
});

const req = client.request({ ':path': '/' });
```

#### 支持 CONNECT 方法[#](http://nodejs.cn/api-v12/http2.html#supporting-the-connect-method)

[中英对照](http://nodejs.cn/api-v12/http2/supporting_the_connect_method.html)

`CONNECT` 方法用于允许 HTTP/2 服务器用作 TCP/IP 连接的代理。

简单的 TCP 服务器：

```
const net = require('net');

const server = net.createServer((socket) => {
  let name = '';
  socket.setEncoding('utf8');
  socket.on('data', (chunk) => name += chunk);
  socket.on('end', () => socket.end(`hello ${name}`));
});

server.listen(8000);
```

HTTP/2 CONNECT 代理：

```
const http2 = require('http2');
const { NGHTTP2_REFUSED_STREAM } = http2.constants;
const net = require('net');

const proxy = http2.createServer();
proxy.on('stream', (stream, headers) => {
  if (headers[':method'] !== 'CONNECT') {
    // 只接受 CONNECT 请求
    stream.close(NGHTTP2_REFUSED_STREAM);
    return;
  }
  const auth = new URL(`tcp://${headers[':authority']}`);
  // 验证主机名和端口是此代理应该连接的对象
  // 是一个很好的主意。
  const socket = net.connect(auth.port, auth.hostname, () => {
    stream.respond();
    socket.pipe(stream);
    stream.pipe(socket);
  });
  socket.on('error', (error) => {
    stream.close(http2.constants.NGHTTP2_CONNECT_ERROR);
  });
});

proxy.listen(8001);
```

HTTP/2 CONNECT 客户端：

```
const http2 = require('http2');

const client = http2.connect('http://localhost:8001');

// 不得为 CONNECT 请求指定 ':path' 和 ':scheme' 标头，
// 否则将引发错误。
const req = client.request({
  ':method': 'CONNECT',
  ':authority': `localhost:${port}`
});

req.on('response', (headers) => {
  console.log(headers[http2.constants.HTTP2_HEADER_STATUS]);
});
let data = '';
req.setEncoding('utf8');
req.on('data', (chunk) => data += chunk);
req.on('end', () => {
  console.log(`The server says: ${data}`);
  client.close();
});
req.end('Jane');
```

#### 扩展的 CONNECT 协议[#](http://nodejs.cn/api-v12/http2.html#the-extended-connect-protocol)

[中英对照](http://nodejs.cn/api-v12/http2/the_extended_connect_protocol.html)

[RFC 8441](http://url.nodejs.cn/7ohy1C) 定义了 HTTP/2 的“扩展连接协议”扩展，可用于引导使用 `Http2Stream` 使用 `CONNECT` 方法作为其他通信协议（例如 WebSockets）的隧道。

扩展连接协议的使用由 HTTP/2 服务器通过使用 `enableConnectProtocol` 设置启用：

```
const http2 = require('http2');
const settings = { enableConnectProtocol: true };
const server = http2.createServer({ settings });
```

一旦客户端从服务器收到指示可以使用扩展 CONNECT 的 `SETTINGS` 帧，它可能会发送使用 `':protocol'` HTTP/2 伪标头的 `CONNECT` 请求：

```
const http2 = require('http2');
const client = http2.connect('http://localhost:8080');
client.on('remoteSettings', (settings) => {
  if (settings.enableConnectProtocol) {
    const req = client.request({ ':method': 'CONNECT', ':protocol': 'foo' });
    // ...
  }
});
```

### 兼容的 API[#](http://nodejs.cn/api-v12/http2.html#compatibility-api)

[中英对照](http://nodejs.cn/api-v12/http2/compatibility_api.html)

兼容性 API 的目标是在使用 HTTP/2 时提供与 HTTP/1 类似的开发者体验，从而可以开发同时支持 [HTTP/1](http://nodejs.cn/api-v12/http.html) 和 HTTP/2 的应用程序。 此 API 仅针对 [HTTP/1](http://nodejs.cn/api-v12/http.html) 的**公共 API**。 然而，许多模块使用内部方法或状态，而那些不受支持，因为它是完全不同的实现。

以下示例使用兼容性 API 创建 HTTP/2 服务器：

```
const http2 = require('http2');
const server = http2.createServer((req, res) => {
  res.setHeader('Content-Type', 'text/html');
  res.setHeader('X-Foo', 'bar');
  res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
  res.end('ok');
});
```

为了创建混合的 [HTTPS](http://nodejs.cn/api-v12/https.html) 和 HTTP/2 服务器，请参阅 [ALPN 协商](http://nodejs.cn/api-v12/http2.html#http2_alpn_negotiation)章节。 不支持从非 tls HTTP/1 服务器升级。

HTTP/2 兼容性 API 由 [`Http2ServerRequest`](http://nodejs.cn/api-v12/http2.html#http2_class_http2_http2serverrequest) 和 [`Http2ServerResponse`](http://nodejs.cn/api-v12/http2.html#http2_class_http2_http2serverresponse) 组成。 其目标是与 HTTP/1 的 API 兼容，但其并没有隐藏协议之间的差异。 例如，HTTP 代码的状态消息被忽略。

#### ALPN 协商[#](http://nodejs.cn/api-v12/http2.html#alpn-negotiation)

[中英对照](http://nodejs.cn/api-v12/http2/alpn_negotiation.html)

ALPN 协商允许在同一个套接字上同时支持 [HTTPS](http://nodejs.cn/api-v12/https.html) 和 HTTP/2。 `req` 和 `res` 对象可以是 HTTP/1 或 HTTP/2，并且应用程序**必须**将自己限制在 [HTTP/1](http://nodejs.cn/api-v12/http.html) 的公共 API，并检测是否可以使用更多HTTP/2 的高级特性。

以下示例创建了支持两种协议的服务器：

```
const { createSecureServer } = require('http2');
const { readFileSync } = require('fs');

const cert = readFileSync('./cert.pem');
const key = readFileSync('./key.pem');

const server = createSecureServer(
  { cert, key, allowHTTP1: true },
  onRequest
).listen(4443);

function onRequest(req, res) {
  // 检测是 HTTPS 请求还是 HTTP/2
  const { socket: { alpnProtocol } } = req.httpVersion === '2.0' ?
    req.stream.session : req;
  res.writeHead(200, { 'content-type': 'application/json' });
  res.end(JSON.stringify({
    alpnProtocol,
    httpVersion: req.httpVersion
  }));
}
```

`'request'` 事件在 [HTTPS](http://nodejs.cn/api-v12/https.html) 和 HTTP/2 上的工作方式相同。

#### `http2.Http2ServerRequest` 类[#](http://nodejs.cn/api-v12/http2.html#class-http2http2serverrequest)

[中英对照](http://nodejs.cn/api-v12/http2/class_http2_http2serverrequest.html)

新增于: v8.4.0

-   继承自: [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

`Http2ServerRequest` 对象由 [`http2.Server`](http://nodejs.cn/api-v12/http2.html#http2_class_http2server) 或 [`http2.SecureServer`](http://nodejs.cn/api-v12/http2.html#http2_class_http2secureserver) 创建并作为第一个参数传给 [`'request'`](http://nodejs.cn/api-v12/http2.html#http2_event_request) 事件。 它可用于访问请求状态、标头和数据。

##### `'aborted'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-aborted_1)

[中英对照](http://nodejs.cn/api-v12/http2/event_aborted_1.html)

新增于: v8.4.0

每当 `Http2ServerRequest` 实例在通信中途异常中止时，就会触发 `'aborted'` 事件。

只有在 `Http2ServerRequest` 可写端尚未结束时才会触发 `'aborted'` 事件。

##### `'close'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-close_2)

[中英对照](http://nodejs.cn/api-v12/http2/event_close_2.html)

新增于: v8.4.0

表示底层的 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 已关闭。 就像 `'end'` 一样，此事件每个响应只触发一次。

##### `request.aborted`[#](http://nodejs.cn/api-v12/http2.html#requestaborted)

[中英对照](http://nodejs.cn/api-v12/http2/request_aborted.html)

新增于: v10.1.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果请求已中止，则 `request.aborted` 属性将为 `true`。

##### `request.authority`[#](http://nodejs.cn/api-v12/http2.html#requestauthority)

[中英对照](http://nodejs.cn/api-v12/http2/request_authority.html)

新增于: v8.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

请求权限伪头域。 它也可以通过 `req.headers[':authority']` 访问。

##### `request.complete`[#](http://nodejs.cn/api-v12/http2.html#requestcomplete)

[中英对照](http://nodejs.cn/api-v12/http2/request_complete.html)

新增于: v12.10.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果请求已完成、中止或销毁，则 `request.complete` 属性将为 `true`。

##### `request.destroy([error])`[#](http://nodejs.cn/api-v12/http2.html#requestdestroyerror)

[中英对照](http://nodejs.cn/api-v12/http2/request_destroy_error.html)

新增于: v8.4.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x)

在收到 [`Http2ServerRequest`](http://nodejs.cn/api-v12/http2.html#http2_class_http2_http2serverrequest) 的 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 上调用 `destroy()`。 如果提供了 `error`，则会触发 `'error'` 事件，并将 `error` 作为参数传给该事件的任何监听器。

如果流已经被销毁，则什么也不做。

##### `request.headers`[#](http://nodejs.cn/api-v12/http2.html#requestheaders)

[中英对照](http://nodejs.cn/api-v12/http2/request_headers.html)

新增于: v8.4.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

请求/响应头对象。

标头名称和值的键值对。 标头名称是小写的。

```
// 打印如下内容：
//
// { 'user-agent': 'curl/7.22.0',
//   host: '127.0.0.1:8000',
//   accept: '*/*' }
console.log(request.headers);
```

请参阅 [HTTP/2 标头对象](http://nodejs.cn/api-v12/http2.html#http2_headers_object)。

在 HTTP/2 中，请求路径、主机名、协议和方法表示为带有 `:` 字符（例如 `':path'`）前缀的特殊标头。 这些特殊的标头将包含在 `request.headers` 对象中。 必须注意不要无意中修改了这些特殊的标头，否则可能会出现错误。 例如，从请求中删除所有标头将导致发生错误：

```
removeAllHeaders(request.headers);
assert(request.url);   // 失败，因为 :path 标头已被删除
```

##### `request.httpVersion`[#](http://nodejs.cn/api-v12/http2.html#requesthttpversion)

[中英对照](http://nodejs.cn/api-v12/http2/request_httpversion.html)

新增于: v8.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

在服务器请求的情况下，客户端发送的 HTTP 版本。 在客户端响应的情况下，连接到服务器的 HTTP 版本。 返回 `'2.0'`。

`message.httpVersionMajor` 是第一个整数，`message.httpVersionMinor` 是第二个。

##### `request.method`[#](http://nodejs.cn/api-v12/http2.html#requestmethod)

[中英对照](http://nodejs.cn/api-v12/http2/request_method.html)

新增于: v8.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

请求方法作为字符串。 只读。 示例：`'GET'`、`'DELETE'`。

##### `request.rawHeaders`[#](http://nodejs.cn/api-v12/http2.html#requestrawheaders)

[中英对照](http://nodejs.cn/api-v12/http2/request_rawheaders.html)

新增于: v8.4.0

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

原始请求/响应头完全按照收到的方式列出。

键和值在同一个列表中。 它不是元组列表。 因此，偶数偏移是键值，奇数偏移是关联的值。

标头名称不小写，重复项不合并。

```
// 打印如下内容：
//
// [ 'user-agent',
//   'this is invalid because there can be only one',
//   'User-Agent',
//   'curl/7.22.0',
//   'Host',
//   '127.0.0.1:8000',
//   'ACCEPT',
//   '*/*' ]
console.log(request.rawHeaders);
```

##### `request.rawTrailers`[#](http://nodejs.cn/api-v12/http2.html#requestrawtrailers)

[中英对照](http://nodejs.cn/api-v12/http2/request_rawtrailers.html)

新增于: v8.4.0

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

原始请求/响应尾标的键和值与收到的完全一样。 仅在 `'end'` 事件中填充。

##### `request.scheme`[#](http://nodejs.cn/api-v12/http2.html#requestscheme)

[中英对照](http://nodejs.cn/api-v12/http2/request_scheme.html)

新增于: v8.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

请求协议伪标头域，指示目标 URL 的协议部分。

##### `request.setTimeout(msecs, callback)`[#](http://nodejs.cn/api-v12/http2.html#requestsettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http2/request_settimeout_msecs_callback.html)

新增于: v8.4.0

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<http2.Http2ServerRequest>](http://nodejs.cn/api/http2.html#class-http2http2serverrequest)

将 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 的超时值设置为 `msecs`。 如果提供了回调，则将其添加为响应对象上 `'timeout'` 事件的监听器。

如果没有 `'timeout'` 监听器被添加到请求、响应或服务器中，则当它们超时时 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream)s 将被销毁。 如果将句柄分配给请求、响应或服务器的 `'timeout'` 事件，则必须显式处理超时套接字。

##### `request.socket`[#](http://nodejs.cn/api-v12/http2.html#requestsocket)

[中英对照](http://nodejs.cn/api-v12/http2/request_socket.html)

新增于: v8.4.0

-   [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) | [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket)

返回 `Proxy` 对象，该对象充当 `net.Socket`（或 `tls.TLSSocket`），但应用了基于 HTTP/2 逻辑的获取器、设置器、以及方法。

`destroyed`、`readable` 和 `writable` 属性将从 `request.stream` 检索并设置。

`destroy`, `emit`, `end`, `on` 和 `once` 方法将在 `request.stream` 上调用。

`setTimeout` 方法将在 `request.stream.session` 上调用。

`pause`, `read`, `resume`, and `write` 将抛出错误代码为 `ERR_HTTP2_NO_SOCKET_MANIPULATION`。 有关详细信息，请参阅 [`Http2Session` 和套接字](http://nodejs.cn/api-v12/http2.html#http2_http2session_and_sockets)。

所有其他交互将直接路由到套接字。 支持 TLS，使用 [`request.socket.getPeerCertificate()`](http://nodejs.cn/api-v12/tls.html#tls_tlssocket_getpeercertificate_detailed) 获取客户端的认证信息。

##### `request.stream`[#](http://nodejs.cn/api-v12/http2.html#requeststream)

[中英对照](http://nodejs.cn/api-v12/http2/request_stream.html)

新增于: v8.4.0

-   [<Http2Stream>](http://nodejs.cn/api/http2.html#class-http2stream)

支持请求的 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 对象。

##### `request.trailers`[#](http://nodejs.cn/api-v12/http2.html#requesttrailers)

[中英对照](http://nodejs.cn/api-v12/http2/request_trailers.html)

新增于: v8.4.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

请求/响应尾标对象。 仅在 `'end'` 事件中填充。

##### `request.url`[#](http://nodejs.cn/api-v12/http2.html#requesturl)

[中英对照](http://nodejs.cn/api-v12/http2/request_url.html)

新增于: v8.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

请求的网址字符串。 这仅包含实际 HTTP 请求中存在的网址。 如果请求是：

```
GET /status?name=ryan HTTP/1.1
Accept: text/plain
```

则 `request.url` 将是：

```
'/status?name=ryan'
```

要将 url 解析成它的部分，可以使用 `require('url').parse(request.url)`：

```
$ node
> require('url').parse('/status?name=ryan')
Url {
  protocol: null,
  slashes: null,
  auth: null,
  host: null,
  port: null,
  hostname: null,
  hash: null,
  search: '?name=ryan',
  query: 'name=ryan',
  pathname: '/status',
  path: '/status?name=ryan',
  href: '/status?name=ryan' }
```

```
$ node
> require('url').parse('/status?name=ryan', true)
Url {
  protocol: null,
  slashes: null,
  auth: null,
  host: null,
  port: null,
  hostname: null,
  hash: null,
  search: '?name=ryan',
  query: { name: 'ryan' },
  pathname: '/status',
  path: '/status?name=ryan',
  href: '/status?name=ryan' }
```

#### `http2.Http2ServerResponse` 类[#](http://nodejs.cn/api-v12/http2.html#class-http2http2serverresponse)

[中英对照](http://nodejs.cn/api-v12/http2/class_http2_http2serverresponse.html)

新增于: v8.4.0

-   继承自: [<Stream>](http://nodejs.cn/api/stream.html#stream)

此对象由 HTTP 服务器内部创建，而不是由用户创建。 它作为第二个参数传给 [`'request'`](http://nodejs.cn/api-v12/http2.html#http2_event_request) 事件。

##### `'close'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-close_3)

[中英对照](http://nodejs.cn/api-v12/http2/event_close_3.html)

新增于: v8.4.0

表示底层的 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 在 [`response.end()`](http://nodejs.cn/api-v12/http2.html#http2_response_end_data_encoding_callback) 被调用或能够刷新之前终止。

##### `'finish'` 事件[#](http://nodejs.cn/api-v12/http2.html#event-finish)

[中英对照](http://nodejs.cn/api-v12/http2/event_finish.html)

新增于: v8.4.0

发送响应时触发。 更具体地说，当响应标头和正文的最后一段已移交给 HTTP/2 多路复用以通过网络传输时，则将触发此事件。 这并不意味着客户端已收到任何东西。

在此事件之后，响应对象上将不再触发更多事件。

##### `response.addTrailers(headers)`[#](http://nodejs.cn/api-v12/http2.html#responseaddtrailersheaders)

[中英对照](http://nodejs.cn/api-v12/http2/response_addtrailers_headers.html)

新增于: v8.4.0

-   `headers` [<Object>](http://url.nodejs.cn/jzn6Ao)

此方法向响应添加 HTTP 尾随标头（标头，但位于消息末尾）。

尝试设置包含无效字符的标头字段名称或值将导致抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

##### `response.connection`[#](http://nodejs.cn/api-v12/http2.html#responseconnection)

[中英对照](http://nodejs.cn/api-v12/http2/response_connection.html)

新增于: v8.4.0

-   [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) | [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket)

参见 [`response.socket`](http://nodejs.cn/api-v12/http2.html#http2_response_socket)。

##### `response.end([data[, encoding]][, callback])`[#](http://nodejs.cn/api-v12/http2.html#responseenddata-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/http2/response_end_data_encoding_callback.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

此方法向服务器发出信号，表明所有响应头和正文都已发送；该服务器应认为此消息已完成。 `response.end()` 方法必须在每个响应上调用。

如果指定了 `data`，则相当于调用 [`response.write(data, encoding)`](http://nodejs.cn/api-v12/http.html#http_response_write_chunk_encoding_callback) 后跟 `response.end(callback)`。

如果指定了 `callback`，则将在响应流完成时调用。

##### `response.finished`[#](http://nodejs.cn/api-v12/http2.html#responsefinished)

[中英对照](http://nodejs.cn/api-v12/http2/response_finished.html)

新增于: v8.4.0弃用于: v12.16.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

指示响应是否已完成的布尔值。 从 `false` 开始。 在 [`response.end()`](http://nodejs.cn/api-v12/http2.html#http2_response_end_data_encoding_callback) 执行后，值为 `true`。

##### `response.getHeader(name)`[#](http://nodejs.cn/api-v12/http2.html#responsegetheadername)

[中英对照](http://nodejs.cn/api-v12/http2/response_getheader_name.html)

新增于: v8.4.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

读出已排队但未发送到客户端的标头。 该名称不区分大小写。

```
const contentType = response.getHeader('content-type');
```

##### `response.getHeaderNames()`[#](http://nodejs.cn/api-v12/http2.html#responsegetheadernames)

[中英对照](http://nodejs.cn/api-v12/http2/response_getheadernames.html)

新增于: v8.4.0

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

返回包含当前传出标头的唯一名称的数组。 所有标头名称均为小写。

```
response.setHeader('Foo', 'bar');
response.setHeader('Set-Cookie', ['foo=bar', 'bar=baz']);

const headerNames = response.getHeaderNames();
// headerNames === ['foo', 'set-cookie']
```

##### `response.getHeaders()`[#](http://nodejs.cn/api-v12/http2.html#responsegetheaders)

[中英对照](http://nodejs.cn/api-v12/http2/response_getheaders.html)

新增于: v8.4.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回当前传出标头的浅拷贝。 由于使用了浅拷贝，因此无需额外调用各种与标头相关的 http 模块方法即可更改数组值。 返回对象的键是标头名称，值是相应的标头值。 所有标头名称均为小写。

`response.getHeaders()` 方法返回的对象通常不是从 JavaScript `Object` 继承的原型。 这意味着典型的 `Object` 方法，例如 `obj.toString()`、`obj.hasOwnProperty()` 和其他方法没有定义并且不会起作用。

```
response.setHeader('Foo', 'bar');
response.setHeader('Set-Cookie', ['foo=bar', 'bar=baz']);

const headers = response.getHeaders();
// headers === { foo: 'bar', 'set-cookie': ['foo=bar', 'bar=baz'] }
```

##### `response.hasHeader(name)`[#](http://nodejs.cn/api-v12/http2.html#responsehasheadername)

[中英对照](http://nodejs.cn/api-v12/http2/response_hasheader_name.html)

新增于: v8.4.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `name` 标识的标头当前设置在传出标头中，则返回 `true`。 标头名称匹配不区分大小写。

```
const hasContentType = response.hasHeader('content-type');
```

##### `response.headersSent`[#](http://nodejs.cn/api-v12/http2.html#responseheaderssent)

[中英对照](http://nodejs.cn/api-v12/http2/response_headerssent.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果标头被发送则为 true，否则为 false（只读）。

##### `response.removeHeader(name)`[#](http://nodejs.cn/api-v12/http2.html#responseremoveheadername)

[中英对照](http://nodejs.cn/api-v12/http2/response_removeheader_name.html)

新增于: v8.4.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)

删除已排队等待隐式发送的标头。

```
response.removeHeader('Content-Encoding');
```

##### `response.sendDate`[#](http://nodejs.cn/api-v12/http2.html#responsesenddate)

[中英对照](http://nodejs.cn/api-v12/http2/response_senddate.html)

新增于: v8.4.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果为真，则 Date 标头将自动生成并在响应中发送，如果它尚未出现在标头中。 默认为真。

这应该仅在测试时禁用； HTTP 需要响应中的 Date 标头。

##### `response.setHeader(name, value)`[#](http://nodejs.cn/api-v12/http2.html#responsesetheadername-value)

[中英对照](http://nodejs.cn/api-v12/http2/response_setheader_name_value.html)

新增于: v8.4.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `value` [<string>](http://url.nodejs.cn/9Tw2bK) | [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

为隐式标头设置单个标头值。 如果该标头已经存在于待发送的标头中，则其值将被替换。 在此处使用字符串数组发送具有相同名称的多个标头。

```
response.setHeader('Content-Type', 'text/html; charset=utf-8');
```

或者

```
response.setHeader('Set-Cookie', ['type=ninja', 'language=javascript']);
```

尝试设置包含无效字符的标头字段名称或值将导致抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

当标头已使用 [`response.setHeader()`](http://nodejs.cn/api-v12/http2.html#http2_response_setheader_name_value) 设置时，则它们将与任何传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http2.html#http2_response_writehead_statuscode_statusmessage_headers) 的标头合并，其中传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http2.html#http2_response_writehead_statuscode_statusmessage_headers) 的标头优先。

```
// 返回 content-type = text/plain
const server = http2.createServer((req, res) => {
  res.setHeader('Content-Type', 'text/html; charset=utf-8');
  res.setHeader('X-Foo', 'bar');
  res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
  res.end('ok');
});
```

##### `response.setTimeout(msecs[, callback])`[#](http://nodejs.cn/api-v12/http2.html#responsesettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http2/response_settimeout_msecs_callback.html)

新增于: v8.4.0

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<http2.Http2ServerResponse>](http://nodejs.cn/api/http2.html#class-http2http2serverresponse)

将 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 的超时值设置为 `msecs`。 如果提供了回调，则将其添加为响应对象上 `'timeout'` 事件的监听器。

如果没有 `'timeout'` 监听器被添加到请求、响应或服务器中，则当它们超时时 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream)s 将被销毁。 如果将句柄分配给请求、响应或服务器的 `'timeout'` 事件，则必须显式处理超时套接字。

##### `response.socket`[#](http://nodejs.cn/api-v12/http2.html#responsesocket)

[中英对照](http://nodejs.cn/api-v12/http2/response_socket.html)

新增于: v8.4.0

-   [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) | [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket)

返回 `Proxy` 对象，该对象充当 `net.Socket`（或 `tls.TLSSocket`），但应用了基于 HTTP/2 逻辑的获取器、设置器、以及方法。

`destroyed`、`readable` 和 `writable` 属性将从 `response.stream` 检索并设置。

`destroy`, `emit`, `end`, `on` 和 `once` 方法将在 `response.stream` 上调用。

`setTimeout` 方法将在 `response.stream.session` 上调用。

`pause`, `read`, `resume`, and `write` 将抛出错误代码为 `ERR_HTTP2_NO_SOCKET_MANIPULATION`。 有关详细信息，请参阅 [`Http2Session` 和套接字](http://nodejs.cn/api-v12/http2.html#http2_http2session_and_sockets)。

所有其他交互将直接路由到套接字。

```
const http2 = require('http2');
const server = http2.createServer((req, res) => {
  const ip = req.socket.remoteAddress;
  const port = req.socket.remotePort;
  res.end(`Your IP address is ${ip} and your source port is ${port}.`);
}).listen(3000);
```

##### `response.statusCode`[#](http://nodejs.cn/api-v12/http2.html#responsestatuscode)

[中英对照](http://nodejs.cn/api-v12/http2/response_statuscode.html)

新增于: v8.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

使用隐式标头（不显式调用 [`response.writeHead()`](http://nodejs.cn/api-v12/http2.html#http2_response_writehead_statuscode_statusmessage_headers)）时，此属性控制在标头刷新时将发送到客户端的状态码。

```
response.statusCode = 404;
```

响应头发送到客户端后，该属性表示发送出去的状态码。

##### `response.statusMessage`[#](http://nodejs.cn/api-v12/http2.html#responsestatusmessage)

[中英对照](http://nodejs.cn/api-v12/http2/response_statusmessage.html)

新增于: v8.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

HTTP/2（RFC 7540 8.1.2.4）不支持状态消息。 它返回空字符串。

##### `response.stream`[#](http://nodejs.cn/api-v12/http2.html#responsestream)

[中英对照](http://nodejs.cn/api-v12/http2/response_stream.html)

新增于: v8.4.0

-   [<Http2Stream>](http://nodejs.cn/api/http2.html#class-http2stream)

支持响应的 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 对象。

##### `response.writableEnded`[#](http://nodejs.cn/api-v12/http2.html#responsewritableended)

[中英对照](http://nodejs.cn/api-v12/http2/response_writableended.html)

新增于: v12.9.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

在调用 [`response.end()`](http://nodejs.cn/api-v12/http2.html#http2_response_end_data_encoding_callback) 之后是 `true`。 此属性不指示数据是否已刷新，为此则使用 [`writable.writableFinished`](http://nodejs.cn/api-v12/stream.html#stream_writable_writablefinished) 代替。

##### `response.write(chunk[, encoding][, callback])`[#](http://nodejs.cn/api-v12/http2.html#responsewritechunk-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/http2/response_write_chunk_encoding_callback.html)

新增于: v8.4.0

-   `chunk` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果此方法被调用且 [`response.writeHead()`](http://nodejs.cn/api-v12/http2.html#http2_response_writehead_statuscode_statusmessage_headers) 还没被调用，则会切换到隐式的标头模式并刷新隐式的标头。

这会发送一块响应正文。 可以多次调用此方法以提供正文的连续部分。

在 `http` 模块中，当请求是 HEAD 请求时，响应正文会被省略。 同样，`204` 和 `304` 响应不得包含消息正文。

`chunk` 可以是字符串或缓冲区。 如果 `chunk` 是字符串，则第二个参数指定如何将其编码为字节流。 默认情况下 `encoding` 是 `'utf8'`。 当刷新数据块时将调用 `callback`。

这是原始的 HTTP 正文，与可能使用的更高级别的多部分正文编码无关。

第一次调用 [`response.write()`](http://nodejs.cn/api-v12/http2.html#http2_response_write_chunk_encoding_callback) 时，它会将缓存的标头信息和正文的第一个块发送给客户端。 第二次调用 [`response.write()`](http://nodejs.cn/api-v12/http2.html#http2_response_write_chunk_encoding_callback) 时，Node.js 会假定数据将被流式传输，并单独发送新数据。 也就是说，响应被缓冲到正文的第一个块。

如果整个数据被成功刷新到内核缓冲区，则返回 `true`。 如果所有或部分数据在用户内存中排队，则返回 `false`。 当缓冲区再次空闲时，则将触发 `'drain'`。

##### `response.writeContinue()`[#](http://nodejs.cn/api-v12/http2.html#responsewritecontinue)

[中英对照](http://nodejs.cn/api-v12/http2/response_writecontinue.html)

新增于: v8.4.0

向客户端发送状态 `100 Continue`，表示应该发送请求体。 查看 `Http2Server` 和 `Http2SecureServer` 上的 [`'checkContinue'`](http://nodejs.cn/api-v12/http2.html#http2_event_checkcontinue) 事件。

##### `response.writeHead(statusCode[, statusMessage][, headers])`[#](http://nodejs.cn/api-v12/http2.html#responsewriteheadstatuscode-statusmessage-headers)

[中英对照](http://nodejs.cn/api-v12/http2/response_writehead_statuscode_statusmessage_headers.html)

-   `statusCode` [<number>](http://url.nodejs.cn/SXbo1v)
-   `statusMessage` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `headers` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   返回: [<http2.Http2ServerResponse>](http://nodejs.cn/api/http2.html#class-http2http2serverresponse)

向请求发送响应头。 状态码是 3 位的 HTTP 状态码，如 `404`。 最后一个参数 `headers` 是响应头。

返回对 `Http2ServerResponse` 的引用，以便可以链式调用。

为了与 [HTTP/1](http://nodejs.cn/api-v12/http.html) 兼容，可以将人类可读的 `statusMessage` 作为第二个参数传入。 但是，由于 `statusMessage` 在 HTTP/2 中没有意义，该参数将无效并且将触发进程警告。

```
const body = 'hello world';
response.writeHead(200, {
  'Content-Length': Buffer.byteLength(body),
  'Content-Type': 'text/plain; charset=utf-8' });
```

`Content-Length` 以字节而不是字符给出。 `Buffer.byteLength()` API 可用于确定给定编码中的字节数。 在出站消息上，Node.js 不会检查 Content-Length 和正在传输的正文的长度是否相等。 但是，在接收消息时，Node.js 会在 `Content-Length` 与实际负载大小不匹配时自动拒绝消息。

在调用 [`response.end()`](http://nodejs.cn/api-v12/http2.html#http2_response_end_data_encoding_callback) 之前，此方法最多可以在一条消息上调用一次。

如果在调用此之前调用了 [`response.write()`](http://nodejs.cn/api-v12/http2.html#http2_response_write_chunk_encoding_callback) 或 [`response.end()`](http://nodejs.cn/api-v12/http2.html#http2_response_end_data_encoding_callback)，则将计算隐式/可变的标头并调用此函数。

当标头已使用 [`response.setHeader()`](http://nodejs.cn/api-v12/http2.html#http2_response_setheader_name_value) 设置时，则它们将与任何传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http2.html#http2_response_writehead_statuscode_statusmessage_headers) 的标头合并，其中传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http2.html#http2_response_writehead_statuscode_statusmessage_headers) 的标头优先。

```
// 返回 content-type = text/plain
const server = http2.createServer((req, res) => {
  res.setHeader('Content-Type', 'text/html; charset=utf-8');
  res.setHeader('X-Foo', 'bar');
  res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
  res.end('ok');
});
```

尝试设置包含无效字符的标头字段名称或值将导致抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

##### `response.createPushResponse(headers, callback)`[#](http://nodejs.cn/api-v12/http2.html#responsecreatepushresponseheaders-callback)

[中英对照](http://nodejs.cn/api-v12/http2/response_createpushresponse_headers_callback.html)

新增于: v8.4.0

-   `headers` [<HTTP/2 Headers Object>](http://nodejs.cn/api/http2.html#headers-object) 描述标头的对象
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 在 `http2stream.pushStream()` 完成后调用，或者在尝试创建推送的 `Http2Stream` 失败或被拒绝时调用，或者在调用 `http2stream.pushStream()` 方法之前关闭 `Http2ServerRequest` 的状态
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `stream` [<ServerHttp2Stream>](http://nodejs.cn/api/http2.html#class-serverhttp2stream) 新创建的 `ServerHttp2Stream` 对象

使用给定的标头调用 [`http2stream.pushStream()`](http://nodejs.cn/api-v12/http2.html#http2_http2stream_pushstream_headers_options_callback)，如果成功，则将给定的 [`Http2Stream`](http://nodejs.cn/api-v12/http2.html#http2_class_http2stream) 包装在新创建的 `Http2ServerResponse` 上作为回调参数。 当 `Http2ServerRequest` 关闭时，回调被调用，错误为 `ERR_HTTP2_INVALID_STREAM`。

### 采集 HTTP/2 性能指标[#](http://nodejs.cn/api-v12/http2.html#collecting-http2-performance-metrics)

[中英对照](http://nodejs.cn/api-v12/http2/collecting_http_2_performance_metrics.html)

[性能观察](http://nodejs.cn/api-v12/perf_hooks.html) API 可用于收集每个 `Http2Session` 和 `Http2Stream` 实例的基本性能指标。

```
const { PerformanceObserver } = require('perf_hooks');

const obs = new PerformanceObserver((items) => {
  const entry = items.getEntries()[0];
  console.log(entry.entryType);  // 打印 'http2'
  if (entry.name === 'Http2Session') {
    // 条目包含有关 Http2Session 的统计信息
  } else if (entry.name === 'Http2Stream') {
    // 条目包含有关 Http2Stream 的统计信息
  }
});
obs.observe({ entryTypes: ['http2'] });
```

`PerformanceEntry` 的 `entryType` 属性将等于 `'http2'`。

`PerformanceEntry` 的 `name` 属性将等于 `'Http2Stream'` 或 `'Http2Session'`。

如果 `name` 等于 `Http2Stream`，则 `PerformanceEntry` 将包含以下附加属性：

-   `bytesRead` [<number>](http://url.nodejs.cn/SXbo1v) 为此 `Http2Stream` 接收的 `DATA` 帧字节数。
-   `bytesWritten` [<number>](http://url.nodejs.cn/SXbo1v) 为此 `Http2Stream` 发送的 `DATA` 帧字节数。
-   `id` [<number>](http://url.nodejs.cn/SXbo1v) 关联 `Http2Stream` 的标识符
-   `timeToFirstByte` [<number>](http://url.nodejs.cn/SXbo1v) 从 `PerformanceEntry` `startTime` 到接收到第一个 `DATA` 帧之间经过的毫秒数。
-   `timeToFirstByteSent` [<number>](http://url.nodejs.cn/SXbo1v) 从 `PerformanceEntry` `startTime` 到发送的第一个 `DATA` 帧之间经过的毫秒数。
-   `timeToFirstHeader` [<number>](http://url.nodejs.cn/SXbo1v) 从 `PerformanceEntry` `startTime` 到接收到第一个标头之间经过的毫秒数。

如果 `name` 等于 `Http2Session`，则 `PerformanceEntry` 将包含以下附加属性：

-   `bytesRead` [<number>](http://url.nodejs.cn/SXbo1v) 为此 `Http2Session` 接收的字节数。
-   `bytesWritten` [<number>](http://url.nodejs.cn/SXbo1v) 为此 `Http2Session` 发送的字节数。
-   `framesReceived` [<number>](http://url.nodejs.cn/SXbo1v) `Http2Session` 接收到的 HTTP/2 帧数。
-   `framesSent` [<number>](http://url.nodejs.cn/SXbo1v) `Http2Session` 发送的 HTTP/2 帧数。
-   `maxConcurrentStreams` [<number>](http://url.nodejs.cn/SXbo1v) `Http2Session` 生命周期内同时打开的最大流数。
-   `pingRTT` [<number>](http://url.nodejs.cn/SXbo1v) 从发送 `PING` 帧到接收到它的确认所经过的毫秒数。 只有在 `Http2Session` 上发送了 `PING` 帧时才会出现。
-   `streamAverageDuration` [<number>](http://url.nodejs.cn/SXbo1v) 所有 `Http2Stream` 实例的平均持续时间（以毫秒为单位）
-   `streamCount` [<number>](http://url.nodejs.cn/SXbo1v) `Http2Session` 处理的 `Http2Stream` 实例的数量。
-   `type` [<string>](http://url.nodejs.cn/9Tw2bK) `'server'` 或 `'client'` 来标识 `Http2Session` 的类型。
