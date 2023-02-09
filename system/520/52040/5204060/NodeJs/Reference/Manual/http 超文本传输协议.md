---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/http.html
author: 
---

# http 超文本传输协议 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/http/http.html)

**源代码:** [lib/http.js](https://github.com/nodejs/node/blob/v12.22.12/lib/http.js)

要使用 HTTP 服务器和客户端，则必须 `require('http')`。

Node.js 中的 HTTP 接口旨在支持该协议的许多传统上难以使用的功能。 特别是大的，可能是块编码的消息。 接口从不缓冲整个请求或响应，因此用户能够流式传输数据。

HTTP 消息头由类似如下的对象表示：

```
{ 'content-length': '123',
  'content-type': 'text/plain',
  'connection': 'keep-alive',
  'host': 'mysite.com',
  'accept': '*/*' }
```

键是小写的。 值不会被修改。

为了支持所有可能的 HTTP 应用程序，Node.js HTTP API 是非常低层的。 它只进行流处理和消息解析。 它将消息解析为标头和正文，但不解析实际的标头或正文。

有关如何处理重复标头的详细信息，请参阅 [`message.headers`](http://nodejs.cn/api-v12/http.html#http_message_headers)。

接收到的原始标头保留在 `rawHeaders` 属性中，其是 `[key, value, key2, value2, ...]` 数组。 例如，上面的消息头对象有类似如下的 `rawHeaders` 列表：

```
[ 'ConTent-Length', '123456',
  'content-LENGTH', '123',
  'content-type', 'text/plain',
  'CONNECTION', 'keep-alive',
  'Host', 'mysite.com',
  'accepT', '*/*' ]
```

### `http.Agent` 类[#](http://nodejs.cn/api-v12/http.html#class-httpagent)

[中英对照](http://nodejs.cn/api-v12/http/class_http_agent.html)

新增于: v0.3.4

`Agent` 负责管理 HTTP 客户端连接的持久性和重用。 它维护一个给定主机和端口的待处理请求队列，为每个请求重用单个套接字连接，直到队列为空，此时套接字要么被销毁，要么放入池中，在那里它会被再次用于请求到相同的主机和端口。 是销毁还是池化取决于 `keepAlive` [选项](http://nodejs.cn/api-v12/http.html#http_new_agent_options)。

池化的连接会为其启用 TCP Keep-Alive，但服务器可能仍会关闭空闲连接，在这种情况下，它们将从池中删除，并在为该主机和端口发出新的 HTTP 请求时建立新连接。 服务器也可能拒绝允许通过同一个连接的多个请求，在这种情况下，必须为每个请求重新建立连接，并且不能池化。 `Agent` 仍将向该服务器发出请求，但每个请求都将通过新连接发生。

当客户端或服务器关闭连接时，它会从池中删除。 池中任何未使用的套接字都将被取消引用，以免在没有未完成请求时保持 Node.js 进程运行。 （见 [`socket.unref()`](http://nodejs.cn/api-v12/net.html#net_socket_unref)）。

一个很好的做法是，当不再使用时则 [`destroy()`](http://nodejs.cn/api-v12/http.html#http_agent_destroy) `Agent` 实例，因为未使用的套接字会消耗操作系统资源。

当套接字触发 `'close'` 事件或 `'agentRemove'` 事件时，则套接字将从代理中删除。 当打算让 HTTP 请求长时间打开而不将其保留在代理中时，可以执行类似以下的操作：

```
http.get(options, (res) => {
  // 做些事情
}).on('socket', (socket) => {
  socket.emit('agentRemove');
});
```

代理也可用于单个请求。 通过提供 `{agent: false}` 作为 `http.get()` 或 `http.request()` 函数的选项，则单次使用的具有默认选项的 `Agent` 将用于客户端连接。

`agent:false`:

```
http.get({
  hostname: 'localhost',
  port: 80,
  path: '/',
  agent: false  // 仅为这个请求创建新代理
}, (res) => {
  // 使用响应做些事情
});
```

#### `new Agent([options])`[#](http://nodejs.cn/api-v12/http.html#new-agentoptions)

[中英对照](http://nodejs.cn/api-v12/http/new_agent_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 要在代理上设置的可配置选项集。 可以有以下字段：
    -   `keepAlive` [<boolean>](http://url.nodejs.cn/jFbvuT) 即使没有未完成的请求，也要保留套接字，这样它们就可以用于未来的请求，而无需重新建立 TCP 连接。 不要与 `Connection` 标头的 `keep-alive` 值混淆。 使用代理时总是发送 `Connection: keep-alive` 标头，除非显式指定了 `Connection` 标头或当 `keepAlive` 和 `maxSockets` 选项分别设置为 `false` 和 `Infinity`，在这种情况下将使用 `Connection: close`。 **默认值:** `false`。
    -   `keepAliveMsecs` [<number>](http://url.nodejs.cn/SXbo1v) 当 `keepAlive` 选项为 `false` 或 `undefined` 时则忽略。 **默认值:** `1000`。
    -   `maxSockets` [<number>](http://url.nodejs.cn/SXbo1v) 每个主机允许的最大套接字数量。 每个请求将使用新的套接字，直到达到最大值。 **默认值:** `Infinity`。
    -   `maxTotalSockets` [<number>](http://url.nodejs.cn/SXbo1v) 所有主机总共允许的最大套接字数量。 每个请求将使用新的套接字，直到达到最大值。 **默认值:** `Infinity`。
    -   `maxFreeSockets` [<number>](http://url.nodejs.cn/SXbo1v) 在空闲状态下打开的最大套接字数量。 仅当 `keepAlive` 设置为 `true` 时才相关。 **默认值:** `256`。
    -   `scheduling` [<string>](http://url.nodejs.cn/9Tw2bK) 选择下一个要使用的空闲套接字时应用的调度策略。 它可以是 `'fifo'` 或 `'lifo'`。 两种调度策略的主要区别在于 `'lifo'` 选择最近使用的套接字，而 `'fifo'` 选择最近最少使用的套接字。 在每秒请求率较低的情况下，`'lifo'` 调度将降低选择可能因不活动而被服务器关闭的套接字的风险。 在每秒请求率较高的情况下，`'fifo'` 调度将最大化打开套接字的数量，而 `'lifo'` 调度将保持尽可能低。 **默认值:** `'fifo'`。
    -   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) 套接字超时（以毫秒为单位）。 这将在创建套接字时设置超时。

[`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 中的 `options` 也受支持。

[`http.request()`](http://nodejs.cn/api-v12/http.html#http_http_request_options_callback) 使用的默认 [`http.globalAgent`](http://nodejs.cn/api-v12/http.html#http_http_globalagent) 将所有这些值设置为各自的默认值。

要配置其中任何一个，则必须创建自定义的 [`http.Agent`](http://nodejs.cn/api-v12/http.html#http_class_http_agent) 实例。

```
const http = require('http');
const keepAliveAgent = new http.Agent({ keepAlive: true });
options.agent = keepAliveAgent;
http.request(options, onResponseCallback);
```

#### `agent.createConnection(options[, callback])`[#](http://nodejs.cn/api-v12/http.html#agentcreateconnectionoptions-callback)

[中英对照](http://nodejs.cn/api-v12/http/agent_createconnection_options_callback.html)

新增于: v0.11.4

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 包含连接详细信息的选项。 查看 [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_options_connectlistener) 以获取选项的格式
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 接收创建的套接字的回调函数
-   返回: [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

生成用于 HTTP 请求的套接字/流。

默认情况下，此函数与 [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_options_connectlistener) 相同。 但是，如果需要更大的灵活性，自定义代理可能会覆盖此方法。

可以通过以下两种方式之一提供套接字/流：通过从此函数返回套接字/流，或将套接字/流传给 `callback`。

此方法保证返回 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例，除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型。

`callback` 的参数为 `(err, stream)`。

#### `agent.keepSocketAlive(socket)`[#](http://nodejs.cn/api-v12/http.html#agentkeepsocketalivesocket)

[中英对照](http://nodejs.cn/api-v12/http/agent_keepsocketalive_socket.html)

新增于: v8.1.0

-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

当 `socket` 从请求中分离并且可以由 `Agent` 持久化时调用。 默认行为是：

```
socket.setKeepAlive(true, this.keepAliveMsecs);
socket.unref();
return true;
```

此方法可以被特定的 `Agent` 子类覆盖。 如果此方法返回假值，则套接字将被销毁，而不是将其持久化以供下一个请求使用。

`socket` 参数可以是 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

#### `agent.reuseSocket(socket, request)`[#](http://nodejs.cn/api-v12/http.html#agentreusesocketsocket-request)

[中英对照](http://nodejs.cn/api-v12/http/agent_reusesocket_socket_request.html)

新增于: v8.1.0

-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)
-   `request` [<http.ClientRequest>](http://nodejs.cn/api/http.html#class-httpclientrequest)

当 `socket` 由于保持活动选项而持久化后附加到 `request` 时调用。 默认行为是：

```
socket.ref();
```

此方法可以被特定的 `Agent` 子类覆盖。

`socket` 参数可以是 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

#### `agent.destroy()`[#](http://nodejs.cn/api-v12/http.html#agentdestroy)

[中英对照](http://nodejs.cn/api-v12/http/agent_destroy.html)

新增于: v0.11.4

销毁代理当前正在使用的所有套接字。

通常没有必要这样做。

#### `agent.freeSockets`[#](http://nodejs.cn/api-v12/http.html#agentfreesockets)

[中英对照](http://nodejs.cn/api-v12/http/agent_freesockets.html)

新增于: v0.11.4

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

当启用 `keepAlive` 时，包含当前等待代理使用的套接字数组的对象。 不要修改。

`freeSockets` 列表中的套接字将被自动销毁并从 `'timeout'` 上的数组中删除。

#### `agent.getName(options)`[#](http://nodejs.cn/api-v12/http.html#agentgetnameoptions)

[中英对照](http://nodejs.cn/api-v12/http/agent_getname_options.html)

新增于: v0.11.4

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 一组提供名称生成信息的选项
    -   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 向其发出请求的服务器的域名或 IP 地址
    -   `port` [<number>](http://url.nodejs.cn/SXbo1v) 远程服务器端口
    -   `localAddress` [<string>](http://url.nodejs.cn/9Tw2bK) 发出请求时绑定网络连接的本地接口
    -   `family` [<integer>](http://url.nodejs.cn/SXbo1v) 如果这不等于 `undefined`，则必须是 4 或 6。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

获取一组请求选项的唯一名称，以确定是否可以重用连接。 对于 HTTP 代理，则这将返回 `host:port:localAddress` 或 `host:port:localAddress:family`。 对于 HTTPS 代理，则名称包括 CA、证书、密码和其他确定套接字可重用性的 HTTPS/TLS 特定选项。

#### `agent.maxFreeSockets`[#](http://nodejs.cn/api-v12/http.html#agentmaxfreesockets)

[中英对照](http://nodejs.cn/api-v12/http/agent_maxfreesockets.html)

新增于: v0.11.7

-   [<number>](http://url.nodejs.cn/SXbo1v)

默认设置为 256。 对于启用了 `keepAlive` 的代理，这将设置在空闲状态下将保持打开的最大套接字数量。

#### `agent.maxSockets`[#](http://nodejs.cn/api-v12/http.html#agentmaxsockets)

[中英对照](http://nodejs.cn/api-v12/http/agent_maxsockets.html)

新增于: v0.3.6

-   [<number>](http://url.nodejs.cn/SXbo1v)

默认设置为 `Infinity`。 确定代理可以为每个来源打开多少个并发套接字。 来源是 [`agent.getName()`](http://nodejs.cn/api-v12/http.html#http_agent_getname_options) 的返回值。

#### `agent.maxTotalSockets`[#](http://nodejs.cn/api-v12/http.html#agentmaxtotalsockets)

[中英对照](http://nodejs.cn/api-v12/http/agent_maxtotalsockets.html)

新增于: v12.19.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

默认设置为 `Infinity`。 确定代理可以打开多少个并发套接字。 与 `maxSockets` 不同，此参数适用于所有来源。

#### `agent.requests`[#](http://nodejs.cn/api-v12/http.html#agentrequests)

[中英对照](http://nodejs.cn/api-v12/http/agent_requests.html)

新增于: v0.5.9

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

包含尚未分配给套接字的请求队列的对象。 不要修改。

#### `agent.sockets`[#](http://nodejs.cn/api-v12/http.html#agentsockets)

[中英对照](http://nodejs.cn/api-v12/http/agent_sockets.html)

新增于: v0.3.6

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

包含代理当前正在使用的套接字数组的对象。 不要修改。

### `http.ClientRequest` 类[#](http://nodejs.cn/api-v12/http.html#class-httpclientrequest)

[中英对照](http://nodejs.cn/api-v12/http/class_http_clientrequest.html)

新增于: v0.1.17

-   继承自: [<Stream>](http://nodejs.cn/api/stream.html#stream)

此对象从 [`http.request()`](http://nodejs.cn/api-v12/http.html#http_http_request_options_callback) 内部创建并返回。 它表示正在进行的请求，其标头已入队。 使用 [`setHeader(name, value)`](http://nodejs.cn/api-v12/http.html#http_request_setheader_name_value)、[`getHeader(name)`](http://nodejs.cn/api-v12/http.html#http_request_getheader_name)、[`removeHeader(name)`](http://nodejs.cn/api-v12/http.html#http_request_removeheader_name) API 时，标头仍然是可变的。 实际标头将与第一个数据块一起发送或在调用 [`request.end()`](http://nodejs.cn/api-v12/http.html#http_request_end_data_encoding_callback) 时发送。

要获得响应，则将 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response) 的监听器添加到请求对象。 当接收到响应头时，则请求对象会触发 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response)。 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response) 事件使用一个参数执行，该参数是 [`http.IncomingMessage`](http://nodejs.cn/api-v12/http.html#http_class_http_incomingmessage) 的实例。

在 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response) 事件期间，可以向响应对象添加监听器；特别是监听 `'data'` 事件。

如果没有添加 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response) 句柄，则响应将被完全丢弃。 但是，如果添加了 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response) 事件句柄，则必须消费响应对象中的数据，方法是在有 `'readable'` 事件时调用 `response.read()`，或者添加 `'data'` 句柄，或者调用 `.resume()` 方法。 在数据被消费之前，不会触发 `'end'` 事件。 此外，在读取数据之前，其会消耗内存，最终可能导致进程内存不足的错误。

与 `request` 对象不同，如果响应过早关闭，则 `response` 对象不会触发 `'error'` 事件，而是触发 `'aborted'` 事件。

Node.js 不会检查内容长度和已经传输的正文的长度是否相等。

#### `'abort'` 事件[#](http://nodejs.cn/api-v12/http.html#event-abort)

[中英对照](http://nodejs.cn/api-v12/http/event_abort.html)

新增于: v1.4.1

当请求被客户端中止时触发。 此事件仅在第一次调用 `abort()` 时触发。

#### `'connect'` 事件[#](http://nodejs.cn/api-v12/http.html#event-connect)

[中英对照](http://nodejs.cn/api-v12/http/event_connect.html)

新增于: v0.7.0

-   `response` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage)
-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)
-   `head` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

每次服务器使用 `CONNECT` 方法响应请求时触发。 如果未监听此事件，则接收 `CONNECT` 方法的客户端将关闭其连接。

除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型，否则此事件保证传入 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

演示如何监听 `'connect'` 事件的客户端和服务器对：

```
const http = require('http');
const net = require('net');
const { URL } = require('url');

// 创建 HTTP 隧道代理
const proxy = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('okay');
});
proxy.on('connect', (req, clientSocket, head) => {
  // 连接到源服务器
  const { port, hostname } = new URL(`http://${req.url}`);
  const serverSocket = net.connect(port || 80, hostname, () => {
    clientSocket.write('HTTP/1.1 200 Connection Established\r\n' +
                    'Proxy-agent: Node.js-Proxy\r\n' +
                    '\r\n');
    serverSocket.write(head);
    serverSocket.pipe(clientSocket);
    clientSocket.pipe(serverSocket);
  });
});

// 现在代理正在运行
proxy.listen(1337, '127.0.0.1', () => {

  // 向隧道代理发出请求
  const options = {
    port: 1337,
    host: '127.0.0.1',
    method: 'CONNECT',
    path: 'www.google.com:80'
  };

  const req = http.request(options);
  req.end();

  req.on('connect', (res, socket, head) => {
    console.log('got connected!');

    // 通过 HTTP 隧道发出请求
    socket.write('GET / HTTP/1.1\r\n' +
                 'Host: www.google.com:80\r\n' +
                 'Connection: close\r\n' +
                 '\r\n');
    socket.on('data', (chunk) => {
      console.log(chunk.toString());
    });
    socket.on('end', () => {
      proxy.close();
    });
  });
});
```

#### `'continue'` 事件[#](http://nodejs.cn/api-v12/http.html#event-continue)

[中英对照](http://nodejs.cn/api-v12/http/event_continue.html)

新增于: v0.3.2

当服务器发送 '100 Continue' HTTP 响应时触发，通常是因为请求包含 'Expect: 100-continue'。 这是客户端应该发送请求正文的指令。

#### `'information'` 事件[#](http://nodejs.cn/api-v12/http.html#event-information)

[中英对照](http://nodejs.cn/api-v12/http/event_information.html)

新增于: v10.0.0

-   `info` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `httpVersion` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `httpVersionMajor` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `httpVersionMinor` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `statusCode` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `statusMessage` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `headers` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `rawHeaders` [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

当服务器发送 1xx 中间响应（不包括 101 升级）时触发。 此事件的监听器将接收一个对象，其中包含 HTTP 版本、状态码、状态消息、键值标头对象和带有原始标头名称及其各自值的数组。

```
const http = require('http');

const options = {
  host: '127.0.0.1',
  port: 8080,
  path: '/length_request'
};

// 发出请求
const req = http.request(options);
req.end();

req.on('information', (info) => {
  console.log(`Got information prior to main response: ${info.statusCode}`);
});
```

101 升级状态不会触发此事件，因为它们脱离了传统的 HTTP 请求/响应链，例如 Web 套接字、就地 TLS 升级或 HTTP 2.0。 要收到 101 升级通知，请改为监听 [`'upgrade'`](http://nodejs.cn/api-v12/http.html#http_event_upgrade) 事件。

#### `'response'` 事件[#](http://nodejs.cn/api-v12/http.html#event-response)

[中英对照](http://nodejs.cn/api-v12/http/event_response.html)

新增于: v0.1.0

-   `response` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage)

当接收到对此请求的响应时触发。 此事件仅触发一次。

#### `'socket'` 事件[#](http://nodejs.cn/api-v12/http.html#event-socket)

[中英对照](http://nodejs.cn/api-v12/http/event_socket.html)

新增于: v0.5.3

-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型，否则此事件保证传入 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

#### `'timeout'` 事件[#](http://nodejs.cn/api-v12/http.html#event-timeout)

[中英对照](http://nodejs.cn/api-v12/http/event_timeout.html)

新增于: v0.7.8

当底层套接字因不活动而超时时触发。 这仅通知套接字已空闲。 必须手动中止请求。

另见: [`request.setTimeout()`](http://nodejs.cn/api-v12/http.html#http_request_settimeout_timeout_callback)。

#### `'upgrade'` 事件[#](http://nodejs.cn/api-v12/http.html#event-upgrade)

[中英对照](http://nodejs.cn/api-v12/http/event_upgrade.html)

新增于: v0.1.94

-   `response` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage)
-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)
-   `head` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

每次服务器响应升级请求时触发。 如果未监听此事件且响应状态码为 101 Switching Protocols，则接收升级标头的客户端将关闭其连接。

除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型，否则此事件保证传入 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

演示如何监听 `'upgrade'` 事件的客户端服务器对。

```
const http = require('http');

// 创建 HTTP 服务器
const server = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('okay');
});
server.on('upgrade', (req, socket, head) => {
  socket.write('HTTP/1.1 101 Web Socket Protocol Handshake\r\n' +
               'Upgrade: WebSocket\r\n' +
               'Connection: Upgrade\r\n' +
               '\r\n');

  socket.pipe(socket); // 回声
});

// 现在该服务器正在运行
server.listen(1337, '127.0.0.1', () => {

  // 发出请求
  const options = {
    port: 1337,
    host: '127.0.0.1',
    headers: {
      'Connection': 'Upgrade',
      'Upgrade': 'websocket'
    }
  };

  const req = http.request(options);
  req.end();

  req.on('upgrade', (res, socket, upgradeHead) => {
    console.log('got upgraded!');
    socket.end();
    process.exit(0);
  });
});
```

#### `request.abort()`[#](http://nodejs.cn/api-v12/http.html#requestabort)

[中英对照](http://nodejs.cn/api-v12/http/request_abort.html)

新增于: v0.3.8

将请求标记为中止。 调用它会导致响应中的剩余数据被丢弃并销毁套接字。

#### `request.aborted`[#](http://nodejs.cn/api-v12/http.html#requestaborted)

[中英对照](http://nodejs.cn/api-v12/http/request_aborted.html)

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果请求已中止，则 `request.aborted` 属性将为 `true`。

#### `request.connection`[#](http://nodejs.cn/api-v12/http.html#requestconnection)

[中英对照](http://nodejs.cn/api-v12/http/request_connection.html)

新增于: v0.3.0

-   [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

参见 [`request.socket`](http://nodejs.cn/api-v12/http.html#http_request_socket)。

#### `request.end([data[, encoding]][, callback])`[#](http://nodejs.cn/api-v12/http.html#requestenddata-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/http/request_end_data_encoding_callback.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

完成发送请求。 如果正文的任何部分未发送，则会将它们刷新到流中。 如果请求被分块，则将发送终止的 `'0\r\n\r\n'`。

如果指定了 `data`，则相当于调用 [`request.write(data, encoding)`](http://nodejs.cn/api-v12/http.html#http_request_write_chunk_encoding_callback) 后跟 `request.end(callback)`。

如果指定了 `callback`，则将在请求流完成时调用。

#### `request.finished`[#](http://nodejs.cn/api-v12/http.html#requestfinished)

[中英对照](http://nodejs.cn/api-v12/http/request_finished.html)

新增于: v0.0.1弃用于: v12.16.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 [`request.end()`](http://nodejs.cn/api-v12/http.html#http_request_end_data_encoding_callback) 已被调用，则 `request.finished` 属性将为 `true`。 如果请求是通过 [`http.get()`](http://nodejs.cn/api-v12/http.html#http_http_get_options_callback) 发起的，则会自动调用 `request.end()`。

#### `request.flushHeaders()`[#](http://nodejs.cn/api-v12/http.html#requestflushheaders)

[中英对照](http://nodejs.cn/api-v12/http/request_flushheaders.html)

新增于: v1.6.0

刷新请求头。

出于效率原因，Node.js 通常会缓冲请求头，直到调用 `request.end()` 或写入第一块请求数据。 然后尝试将请求头和数据打包到单个 TCP 数据包中。

这通常是需要的（节省了 TCP 往返），但是当第一个数据直到可能很晚才发送时才需要。 `request.flushHeaders()` 绕过优化并启动请求。

#### `request.getHeader(name)`[#](http://nodejs.cn/api-v12/http.html#requestgetheadername)

[中英对照](http://nodejs.cn/api-v12/http/request_getheader_name.html)

新增于: v1.6.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<any>](http://url.nodejs.cn/6sTGdS)

读取请求的标头。 该名称不区分大小写。 返回值的类型取决于提供给 [`request.setHeader()`](http://nodejs.cn/api-v12/http.html#http_request_setheader_name_value) 的参数。

```
request.setHeader('content-type', 'text/html');
request.setHeader('Content-Length', Buffer.byteLength(body));
request.setHeader('Cookie', ['type=ninja', 'language=javascript']);
const contentType = request.getHeader('Content-Type');
// 'contentType' 是 'text/html'
const contentLength = request.getHeader('Content-Length');
// 'contentLength' 是数字类型
const cookie = request.getHeader('Cookie');
// 'cookie' 是 string[] 类型
```

#### `request.maxHeadersCount`[#](http://nodejs.cn/api-v12/http.html#requestmaxheaderscount)

[中英对照](http://nodejs.cn/api-v12/http/request_maxheaderscount.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `2000`

限制最大响应头计数。 如果设置为 0，则不会应用任何限制。

#### `request.path`[#](http://nodejs.cn/api-v12/http.html#requestpath)

[中英对照](http://nodejs.cn/api-v12/http/request_path.html)

新增于: v0.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK) 请求的路径。

#### `request.method`[#](http://nodejs.cn/api-v12/http.html#requestmethod)

[中英对照](http://nodejs.cn/api-v12/http/request_method.html)

新增于: v0.1.97

-   [<string>](http://url.nodejs.cn/9Tw2bK) 请求的方法。

#### `request.host`[#](http://nodejs.cn/api-v12/http.html#requesthost)

[中英对照](http://nodejs.cn/api-v12/http/request_host.html)

新增于: v12.19.0

-   [<string>](http://url.nodejs.cn/9Tw2bK) 请求的主机。

#### `request.protocol`[#](http://nodejs.cn/api-v12/http.html#requestprotocol)

[中英对照](http://nodejs.cn/api-v12/http/request_protocol.html)

新增于: v12.19.0

-   [<string>](http://url.nodejs.cn/9Tw2bK) 请求的协议。

#### `request.removeHeader(name)`[#](http://nodejs.cn/api-v12/http.html#requestremoveheadername)

[中英对照](http://nodejs.cn/api-v12/http/request_removeheader_name.html)

新增于: v1.6.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)

删除已定义到标头对象中的标头。

```
request.removeHeader('Content-Type');
```

#### `request.reusedSocket`[#](http://nodejs.cn/api-v12/http.html#requestreusedsocket)

[中英对照](http://nodejs.cn/api-v12/http/request_reusedsocket.html)

新增于: v12.16.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT) 请求是否通过重用的套接字发送。

当通过启用保持活动的代理发送请求时，可能会重用底层套接字。 但是如果服务器在不幸的时间关闭连接，客户端可能会遇到 'ECONNRESET' 错误。

```
const http = require('http');

// 服务器默认有 5 秒保持活动超时
http
  .createServer((req, res) => {
    res.write('hello\n');
    res.end();
  })
  .listen(3000);

setInterval(() => {
  // 调整保持活动代理
  http.get('http://localhost:3000', { agent }, (res) => {
    res.on('data', (data) => {
      // 什么都不做
    });
  });
}, 5000); // 以 5 秒的间隔发送请求，因此很容易达到空闲超时
```

通过标记请求是否重用套接字，可以基于它进行自动错误重试。

```
const http = require('http');
const agent = new http.Agent({ keepAlive: true });

function retriableRequest() {
  const req = http
    .get('http://localhost:3000', { agent }, (res) => {
      // ...
    })
    .on('error', (err) => {
      // 检查是否需要重试
      if (req.reusedSocket && err.code === 'ECONNRESET') {
        retriableRequest();
      }
    });
}

retriableRequest();
```

#### `request.setHeader(name, value)`[#](http://nodejs.cn/api-v12/http.html#requestsetheadername-value)

[中英对照](http://nodejs.cn/api-v12/http/request_setheader_name_value.html)

新增于: v1.6.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `value` [<any>](http://url.nodejs.cn/6sTGdS)

为标头对象设置单个标头值。 如果该标头已经存在于待发送的标头中，则其值将被替换。 在此处使用字符串数组发送具有相同名称的多个标头。 非字符串值将不加修改地存储。 因此，[`request.getHeader()`](http://nodejs.cn/api-v12/http.html#http_request_getheader_name) 可能返回非字符串值。 但是，非字符串值将转换为字符串以进行网络传输。

```
request.setHeader('Content-Type', 'application/json');
```

或者

```
request.setHeader('Cookie', ['type=ninja', 'language=javascript']);
```

#### `request.setNoDelay([noDelay])`[#](http://nodejs.cn/api-v12/http.html#requestsetnodelaynodelay)

[中英对照](http://nodejs.cn/api-v12/http/request_setnodelay_nodelay.html)

新增于: v0.5.9

-   `noDelay` [<boolean>](http://url.nodejs.cn/jFbvuT)

一旦套接字被分配给这个请求并被连接，则 [`socket.setNoDelay()`](http://nodejs.cn/api-v12/net.html#net_socket_setnodelay_nodelay) 将被调用。

#### `request.setSocketKeepAlive([enable][, initialDelay])`[#](http://nodejs.cn/api-v12/http.html#requestsetsocketkeepaliveenable-initialdelay)

[中英对照](http://nodejs.cn/api-v12/http/request_setsocketkeepalive_enable_initialdelay.html)

新增于: v0.5.9

-   `enable` [<boolean>](http://url.nodejs.cn/jFbvuT)
-   `initialDelay` [<number>](http://url.nodejs.cn/SXbo1v)

一旦套接字被分配给这个请求并被连接，则 [`socket.setKeepAlive()`](http://nodejs.cn/api-v12/net.html#net_socket_setkeepalive_enable_initialdelay) 将被调用。

#### `request.setTimeout(timeout[, callback])`[#](http://nodejs.cn/api-v12/http.html#requestsettimeouttimeout-callback)

[中英对照](http://nodejs.cn/api-v12/http/request_settimeout_timeout_callback.html)

-   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) 请求超时前的毫秒数。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 发生超时时要调用的可选函数。 与绑定到 `'timeout'` 事件相同。
-   返回: [<http.ClientRequest>](http://nodejs.cn/api/http.html#class-httpclientrequest)

一旦套接字被分配给这个请求并被连接，则 [`socket.setTimeout()`](http://nodejs.cn/api-v12/net.html#net_socket_settimeout_timeout_callback) 将被调用。

#### `request.socket`[#](http://nodejs.cn/api-v12/http.html#requestsocket)

[中英对照](http://nodejs.cn/api-v12/http/request_socket.html)

新增于: v0.3.0

-   [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

对底层套接字的引用。 通常用户不会想要访问这个属性。 特别是，由于协议解析器附加到套接字的方式，套接字将不会触发 `'readable'` 事件。

```
const http = require('http');
const options = {
  host: 'www.google.com',
};
const req = http.get(options);
req.end();
req.once('response', (res) => {
  const ip = req.socket.localAddress;
  const port = req.socket.localPort;
  console.log(`Your IP address is ${ip} and your source port is ${port}.`);
  // 消费响应对象
});
```

该属性保证是 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例，除非用户指定了 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型。

#### `request.writableEnded`[#](http://nodejs.cn/api-v12/http.html#requestwritableended)

[中英对照](http://nodejs.cn/api-v12/http/request_writableended.html)

新增于: v12.9.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

在调用 [`request.end()`](http://nodejs.cn/api-v12/http.html#http_request_end_data_encoding_callback) 之后是 `true`。 此属性不指示数据是否已刷新，为此则使用 [`request.writableFinished`](http://nodejs.cn/api-v12/http.html#http_request_writablefinished) 代替。

#### `request.writableFinished`[#](http://nodejs.cn/api-v12/http.html#requestwritablefinished)

[中英对照](http://nodejs.cn/api-v12/http/request_writablefinished.html)

新增于: v12.7.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果所有数据都已在 [`'finish'`](http://nodejs.cn/api-v12/http.html#http_event_finish) 事件触发之前立即刷新到底层系统，则为 `true`。

#### `request.write(chunk[, encoding][, callback])`[#](http://nodejs.cn/api-v12/http.html#requestwritechunk-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/http/request_write_chunk_encoding_callback.html)

新增于: v0.1.29

-   `chunk` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

发送一块正文。

`encoding` 参数是可选的，仅当 `chunk` 是字符串时才适用。 默认为 `'utf8'`。

`callback` 参数是可选的，将在刷新此数据块时调用，但前提是该块非空。

如果整个数据被成功刷新到内核缓冲区，则返回 `true`。 如果所有或部分数据在用户内存中排队，则返回 `false`。 当缓冲区再次空闲时，则将触发 `'drain'`。

当使用空字符串或缓冲区调用 `write` 函数时，则什么都不做并等待更多输入。

### `http.Server` 类[#](http://nodejs.cn/api-v12/http.html#class-httpserver)

新增于: v0.1.17

-   继承自: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

#### `'checkContinue'` 事件[#](http://nodejs.cn/api-v12/http.html#event-checkcontinue)

[中英对照](http://nodejs.cn/api-v12/http/event_checkcontinue.html)

新增于: v0.3.0

-   `request` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage)
-   `response` [<http.ServerResponse>](http://nodejs.cn/api/http.html#class-httpserverresponse)

每次收到带有 HTTP `Expect: 100-continue` 的请求时触发。 如果未监听此事件，则服务器将根据需要自动响应 `100 Continue`。

如果客户端应该继续发送请求正文，则处理此事件涉及调用 [`response.writeContinue()`](http://nodejs.cn/api-v12/http.html#http_response_writecontinue)，或者如果客户端不应该继续发送请求正文，则生成适当的 HTTP 响应（例如 400 Bad Request）。

处理和处理此事件时，不会触发 [`'request'`](http://nodejs.cn/api-v12/http.html#http_event_request) 事件。

#### `'checkExpectation'` 事件[#](http://nodejs.cn/api-v12/http.html#event-checkexpectation)

[中英对照](http://nodejs.cn/api-v12/http/event_checkexpectation.html)

新增于: v5.5.0

-   `request` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage)
-   `response` [<http.ServerResponse>](http://nodejs.cn/api/http.html#class-httpserverresponse)

每次收到带有 HTTP `Expect` 标头的请求时触发，其中值不是 `100-continue`。 如果未监听此事件，则服务器将根据需要自动响应 `417 Expectation Failed`。

处理和处理此事件时，不会触发 [`'request'`](http://nodejs.cn/api-v12/http.html#http_event_request) 事件。

#### `'clientError'` 事件[#](http://nodejs.cn/api-v12/http.html#event-clienterror)

[中英对照](http://nodejs.cn/api-v12/http/event_clienterror.html)

-   `exception` [<Error>](http://url.nodejs.cn/qZ873x)
-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

如果客户端连接触发 `'error'` 事件，则会在此处转发。 此事件的监听器负责关闭/销毁底层套接字。 例如，可能希望使用自定义 HTTP 响应更优雅地关闭套接字，而不是突然切断连接。

除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型，否则此事件保证传入 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

默认行为是在 [`HPE_HEADER_OVERFLOW`](http://nodejs.cn/api-v12/errors.html#errors_hpe_header_overflow) 错误的情况下尝试使用 HTTP '400 Bad Request' 或 HTTP '431 Request Header Fields Too Large' 关闭套接字。 如果套接字不可写或已经写入数据，则会立即被销毁。

`socket` 是错误源自的 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 对象。

```
const http = require('http');

const server = http.createServer((req, res) => {
  res.end();
});
server.on('clientError', (err, socket) => {
  socket.end('HTTP/1.1 400 Bad Request\r\n\r\n');
});
server.listen(8000);
```

当 `'clientError'` 事件发生时，没有 `request` 或 `response` 对象，因此发送的任何 HTTP 响应，包括响应头和有效负载，都必须直接写入 `socket` 对象。 必须注意确保响应是格式正确的 HTTP 响应消息。

`err` 是 `Error` 的实例，有两个额外的列：

-   `bytesParsed`: Node.js 可能正确解析的请求数据包的字节数；
-   `rawPacket`: 当前请求的原始数据包。

在某些情况下，客户端已经收到响应和/或套接字已经被销毁，例如 `ECONNRESET` 错误。 在尝试向套接字发送数据之前，最好检查它是否仍然可写。

```
server.on('clientError', (err, socket) => {
  if (err.code === 'ECONNRESET' || !socket.writable) {
    return;
  }

  socket.end('HTTP/1.1 400 Bad Request\r\n\r\n');
});
```

#### `'close'` 事件[#](http://nodejs.cn/api-v12/http.html#event-close)

[中英对照](http://nodejs.cn/api-v12/http/event_close.html)

新增于: v0.1.4

服务器关闭时触发。

#### `'connect'` 事件[#](http://nodejs.cn/api-v12/http.html#event-connect_1)

[中英对照](http://nodejs.cn/api-v12/http/event_connect_1.html)

新增于: v0.7.0

-   `request` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage) HTTP 请求的参数，如它在 [`'request'`](http://nodejs.cn/api-v12/http.html#http_event_request) 事件中
-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 服务器和客户端之间的网络套接字
-   `head` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 隧道流的第一个数据包（可能为空）

每次客户端请求 HTTP `CONNECT` 方法时触发。 如果未监听此事件，则请求 `CONNECT` 方法的客户端将关闭其连接。

除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型，否则此事件保证传入 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

触发此事件后，请求的套接字将没有 `'data'` 事件监听器，这意味着需要绑定它才能处理发送到该套接字上的服务器的数据。

#### `'connection'` 事件[#](http://nodejs.cn/api-v12/http.html#event-connection)

[中英对照](http://nodejs.cn/api-v12/http/event_connection.html)

新增于: v0.1.0

-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

当建立新的 TCP 流时会触发此事件。 `socket` 通常是 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 类型的对象。 通常用户不会想访问这个事件。 特别是，由于协议解析器附加到套接字的方式，套接字将不会触发 `'readable'` 事件。 `socket` 也可以在 `request.connection` 上访问。

此事件也可以由用户显式发出，以将连接注入 HTTP 服务器。 在这种情况下，任何 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流都可以通过。

如果此处调用 `socket.setTimeout()`，则当套接字已服务请求时（如果 `server.keepAliveTimeout` 非零）超时将替换为 `server.keepAliveTimeout`。

除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型，否则此事件保证传入 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

#### `'request'` 事件[#](http://nodejs.cn/api-v12/http.html#event-request)

[中英对照](http://nodejs.cn/api-v12/http/event_request.html)

新增于: v0.1.0

-   `request` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage)
-   `response` [<http.ServerResponse>](http://nodejs.cn/api/http.html#class-httpserverresponse)

每次有请求时触发。 每个连接可能有多个请求（在 HTTP Keep-Alive 连接的情况下）。

#### `'upgrade'` 事件[#](http://nodejs.cn/api-v12/http.html#event-upgrade_1)

[中英对照](http://nodejs.cn/api-v12/http/event_upgrade_1.html)

-   `request` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage) HTTP 请求的参数，如它在 [`'request'`](http://nodejs.cn/api-v12/http.html#http_event_request) 事件中
-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 服务器和客户端之间的网络套接字
-   `head` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 升级流的第一个数据包（可能为空）

每次客户端请求 HTTP 升级时触发。 监听此事件是可选的，客户端不能坚持协议更改。

触发此事件后，请求的套接字将没有 `'data'` 事件监听器，这意味着需要绑定它才能处理发送到该套接字上的服务器的数据。

除非用户指定 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型，否则此事件保证传入 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例。

#### `server.close([callback])`[#](http://nodejs.cn/api-v12/http.html#serverclosecallback)

[中英对照](http://nodejs.cn/api-v12/http/server_close_callback.html)

新增于: v0.1.90

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

停止服务器接受新连接。 参见 [`net.Server.close()`](http://nodejs.cn/api-v12/net.html#net_server_close_callback)。

#### `server.headersTimeout`[#](http://nodejs.cn/api-v12/http.html#serverheaderstimeout)

[中英对照](http://nodejs.cn/api-v12/http/server_headerstimeout.html)

新增于: v11.3.0

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `60000`

限制解析器等待接收完整 HTTP 标头的时间。

在不活动的情况下，[`server.timeout`](http://nodejs.cn/api-v12/http.html#http_server_timeout) 中定义的规则适用。 但是，如果标头发送非常缓慢（默认情况下，每 2 分钟最多一个字节），基于不活动的超时仍然允许连接保持打开状态。 为了防止这种情况，每当标头数据到达时，都会进行额外的检查，以确保自连接建立以来没有超过 `server.headersTimeout` 毫秒。 如果检查失败，则会在服务器对象上触发 `'timeout'` 事件，并且（默认情况下）套接字将被销毁。 有关如何自定义超时行为的更多信息，请参阅 [`server.timeout`](http://nodejs.cn/api-v12/http.html#http_server_timeout)。

#### `server.listen()`[#](http://nodejs.cn/api-v12/http.html#serverlisten)

[中英对照](http://nodejs.cn/api-v12/http/server_listen.html)

启动 HTTP 服务器监听连接。 此方法与 [`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 中的 [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 相同。

#### `server.listening`[#](http://nodejs.cn/api-v12/http.html#serverlistening)

[中英对照](http://nodejs.cn/api-v12/http/server_listening.html)

新增于: v5.7.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT) 指示服务器是否正在监听连接。

#### `server.maxHeadersCount`[#](http://nodejs.cn/api-v12/http.html#servermaxheaderscount)

[中英对照](http://nodejs.cn/api-v12/http/server_maxheaderscount.html)

新增于: v0.7.0

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `2000`

限制最大传入标头计数。 如果设置为 0，则不会应用任何限制。

#### `server.setTimeout([msecs][, callback])`[#](http://nodejs.cn/api-v12/http.html#serversettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http/server_settimeout_msecs_callback.html)

新增于: v0.9.12

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `120000` （2 分钟）
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<http.Server>](http://nodejs.cn/api/http.html#class-httpserver)

设置套接字的超时值，并在服务器对象上触发 `'timeout'` 事件，如果发生超时，则将套接字作为参数传入。

如果 Server 对象上有 `'timeout'` 事件监听器，则将使用超时套接字作为参数调用它。

但是，如果将回调分配给服务器的 `'timeout'` 事件，则必须显式处理超时。

#### `server.timeout`[#](http://nodejs.cn/api-v12/http.html#servertimeout)

[中英对照](http://nodejs.cn/api-v12/http/server_timeout.html)

新增于: v0.9.12

-   [<number>](http://url.nodejs.cn/SXbo1v) 以毫秒为单位的超时时间。 **默认值:** `120000`

假定套接字超时之前不活动的毫秒数。

值 `0` 将禁用传入连接的超时行为。

套接字超时逻辑是在连接上设置的，因此更改此值只会影响到服务器的新连接，而不会影响任何现有连接。

#### `server.keepAliveTimeout`[#](http://nodejs.cn/api-v12/http.html#serverkeepalivetimeout)

[中英对照](http://nodejs.cn/api-v12/http/server_keepalivetimeout.html)

新增于: v8.0.0

-   [<number>](http://url.nodejs.cn/SXbo1v) 以毫秒为单位的超时时间。 **默认值:** `5000` （5秒）

在完成写入最后一个响应之后，在套接字将被销毁之前，服务器需要等待额外传入数据的不活动毫秒数。 如果服务器在 keep-alive 超时触发之前收到新数据，则将重置常规的不活动超时，即 [`server.timeout`](http://nodejs.cn/api-v12/http.html#http_server_timeout)。

值 `0` 将禁用传入连接上的保持活动超时行为。 值 `0` 使 http 服务器的行为类似于 8.0.0 之前的 Node.js 版本，后者没有保持活动超时。

套接字超时逻辑是在连接上设置的，因此更改此值只会影响到服务器的新连接，而不会影响任何现有连接。

### `http.ServerResponse` 类[#](http://nodejs.cn/api-v12/http.html#class-httpserverresponse)

[中英对照](http://nodejs.cn/api-v12/http/class_http_serverresponse.html)

新增于: v0.1.17

-   继承自: [<Stream>](http://nodejs.cn/api/stream.html#stream)

此对象由 HTTP 服务器内部创建，而不是由用户创建。 它作为第二个参数传给 [`'request'`](http://nodejs.cn/api-v12/http.html#http_event_request) 事件。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/http.html#event-close_1)

新增于: v0.6.7

Indicates that the the response is completed, or its underlying connection was terminated prematurely (before the response completion).

#### `'finish'` 事件[#](http://nodejs.cn/api-v12/http.html#event-finish)

[中英对照](http://nodejs.cn/api-v12/http/event_finish.html)

新增于: v0.3.6

发送响应时触发。 更具体地说，当响应头和正文的最后一段已移交给操作系统以通过网络传输时，则将触发此事件。 这并不意味着客户端已收到任何东西。

#### `response.addTrailers(headers)`[#](http://nodejs.cn/api-v12/http.html#responseaddtrailersheaders)

[中英对照](http://nodejs.cn/api-v12/http/response_addtrailers_headers.html)

新增于: v0.3.0

-   `headers` [<Object>](http://url.nodejs.cn/jzn6Ao)

此方法向响应添加 HTTP 尾随标头（标头，但位于消息末尾）。

只有在响应使用分块编码时才会触发尾标； 如果不是（例如，如果请求是 HTTP/1.0），则它们将被静默丢弃。

HTTP 要求发送 `Trailer` 标头以发出尾标，其值中包含标头字段列表。 例如，

```
response.writeHead(200, { 'Content-Type': 'text/plain',
                          'Trailer': 'Content-MD5' });
response.write(fileData);
response.addTrailers({ 'Content-MD5': '7895bf4b8828b55ceaf47747b4bca667' });
response.end();
```

尝试设置包含无效字符的标头字段名称或值将导致抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

#### `response.connection`[#](http://nodejs.cn/api-v12/http.html#responseconnection)

[中英对照](http://nodejs.cn/api-v12/http/response_connection.html)

新增于: v0.3.0

-   [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

参见 [`response.socket`](http://nodejs.cn/api-v12/http.html#http_response_socket)。

#### `response.cork()`[#](http://nodejs.cn/api-v12/http.html#responsecork)

[中英对照](http://nodejs.cn/api-v12/http/response_cork.html)

新增于: v12.16.0

参见 [`writable.cork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_cork)。

#### `response.end([data[, encoding]][, callback])`[#](http://nodejs.cn/api-v12/http.html#responseenddata-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/http/response_end_data_encoding_callback.html)

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

此方法向服务器发出信号，表明所有响应头和正文都已发送；该服务器应认为此消息已完成。 `response.end()` 方法必须在每个响应上调用。

如果指定了 `data`，则其效果类似于调用 [`response.write(data, encoding)`](http://nodejs.cn/api-v12/http.html#http_response_write_chunk_encoding_callback) 后跟 `response.end(callback)`。

如果指定了 `callback`，则将在响应流完成时调用。

#### `response.finished`[#](http://nodejs.cn/api-v12/http.html#responsefinished)

[中英对照](http://nodejs.cn/api-v12/http/response_finished.html)

新增于: v0.0.2弃用于: v12.16.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 [`response.end()`](http://nodejs.cn/api-v12/http.html#http_response_end_data_encoding_callback) 已被调用，则 `response.finished` 属性将为 `true`。

#### `response.flushHeaders()`[#](http://nodejs.cn/api-v12/http.html#responseflushheaders)

[中英对照](http://nodejs.cn/api-v12/http/response_flushheaders.html)

新增于: v1.6.0

刷新响应头。 另见: [`request.flushHeaders()`](http://nodejs.cn/api-v12/http.html#http_request_flushheaders)。

#### `response.getHeader(name)`[#](http://nodejs.cn/api-v12/http.html#responsegetheadername)

[中英对照](http://nodejs.cn/api-v12/http/response_getheader_name.html)

新增于: v0.4.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<any>](http://url.nodejs.cn/6sTGdS)

读取已排队但未发送到客户端的标头。 该名称不区分大小写。 返回值的类型取决于提供给 [`response.setHeader()`](http://nodejs.cn/api-v12/http.html#http_response_setheader_name_value) 的参数。

```
response.setHeader('Content-Type', 'text/html');
response.setHeader('Content-Length', Buffer.byteLength(body));
response.setHeader('Set-Cookie', ['type=ninja', 'language=javascript']);
const contentType = response.getHeader('content-type');
// contentType 是 'text/html'
const contentLength = response.getHeader('Content-Length');
// contentLength 是数字类型
const setCookie = response.getHeader('set-cookie');
// setCookie 是 string[] 类型
```

#### `response.getHeaderNames()`[#](http://nodejs.cn/api-v12/http.html#responsegetheadernames)

[中英对照](http://nodejs.cn/api-v12/http/response_getheadernames.html)

新增于: v7.7.0

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

返回包含当前传出标头的唯一名称的数组。 所有标头名称均为小写。

```
response.setHeader('Foo', 'bar');
response.setHeader('Set-Cookie', ['foo=bar', 'bar=baz']);

const headerNames = response.getHeaderNames();
// headerNames === ['foo', 'set-cookie']
```

#### `response.getHeaders()`[#](http://nodejs.cn/api-v12/http.html#responsegetheaders)

[中英对照](http://nodejs.cn/api-v12/http/response_getheaders.html)

新增于: v7.7.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回当前传出标头的浅拷贝。 由于使用了浅拷贝，因此无需额外调用各种与标头相关的 http 模块方法即可更改数组值。 返回对象的键是标头名称，值是相应的标头值。 所有标头名称均为小写。

`response.getHeaders()` 方法返回的对象通常不是从 JavaScript `Object` 继承的原型。 这意味着典型的 `Object` 方法，例如 `obj.toString()`、`obj.hasOwnProperty()` 和其他方法没有定义并且不会起作用。

```
response.setHeader('Foo', 'bar');
response.setHeader('Set-Cookie', ['foo=bar', 'bar=baz']);

const headers = response.getHeaders();
// headers === { foo: 'bar', 'set-cookie': ['foo=bar', 'bar=baz'] }
```

#### `response.hasHeader(name)`[#](http://nodejs.cn/api-v12/http.html#responsehasheadername)

[中英对照](http://nodejs.cn/api-v12/http/response_hasheader_name.html)

新增于: v7.7.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `name` 标识的标头当前设置在传出标头中，则返回 `true`。 标头名称匹配不区分大小写。

```
const hasContentType = response.hasHeader('content-type');
```

#### `response.headersSent`[#](http://nodejs.cn/api-v12/http.html#responseheaderssent)

[中英对照](http://nodejs.cn/api-v12/http/response_headerssent.html)

新增于: v0.9.3

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

布尔值（只读）。 如果标头被发送，则为真，否则为假。

#### `response.removeHeader(name)`[#](http://nodejs.cn/api-v12/http.html#responseremoveheadername)

[中英对照](http://nodejs.cn/api-v12/http/response_removeheader_name.html)

新增于: v0.4.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)

删除排队等待隐式发送的标头。

```
response.removeHeader('Content-Encoding');
```

#### `response.sendDate`[#](http://nodejs.cn/api-v12/http.html#responsesenddate)

[中英对照](http://nodejs.cn/api-v12/http/response_senddate.html)

新增于: v0.7.5

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果为真，则 Date 标头将自动生成并在响应中发送，如果它尚未出现在标头中。 默认为真。

这应该仅在测试时禁用； HTTP 需要响应中的 Date 标头。

#### `response.setHeader(name, value)`[#](http://nodejs.cn/api-v12/http.html#responsesetheadername-value)

[中英对照](http://nodejs.cn/api-v12/http/response_setheader_name_value.html)

新增于: v0.4.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `value` [<any>](http://url.nodejs.cn/6sTGdS)

为隐式标头设置单个标头值。 如果该标头已经存在于待发送的标头中，则其值将被替换。 在此处使用字符串数组发送具有相同名称的多个标头。 非字符串值将不加修改地存储。 因此，[`response.getHeader()`](http://nodejs.cn/api-v12/http.html#http_response_getheader_name) 可能返回非字符串值。 但是，非字符串值将转换为字符串以进行网络传输。

```
response.setHeader('Content-Type', 'text/html');
```

或者

```
response.setHeader('Set-Cookie', ['type=ninja', 'language=javascript']);
```

尝试设置包含无效字符的标头字段名称或值将导致抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

当标头已使用 [`response.setHeader()`](http://nodejs.cn/api-v12/http.html#http_response_setheader_name_value) 设置时，则它们将与任何传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers) 的标头合并，其中传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers) 的标头优先。

```
// 返回 content-type = text/plain
const server = http.createServer((req, res) => {
  res.setHeader('Content-Type', 'text/html');
  res.setHeader('X-Foo', 'bar');
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('ok');
});
```

如果调用了 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers) 方法而该方法没有被调用，则会直接将提供的标头值写入网络通道，而不进行内部缓存，标头的 [`response.getHeader()`](http://nodejs.cn/api-v12/http.html#http_response_getheader_name) 不会产生预期的结果。 如果希望在将来可能进行检索和修改时逐步填充标头，则使用 [`response.setHeader()`](http://nodejs.cn/api-v12/http.html#http_response_setheader_name_value) 而不是 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers)。

#### `response.setTimeout(msecs[, callback])`[#](http://nodejs.cn/api-v12/http.html#responsesettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http/response_settimeout_msecs_callback.html)

新增于: v0.9.12

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<http.ServerResponse>](http://nodejs.cn/api/http.html#class-httpserverresponse)

将套接字的超时值设置为 `msecs`。 如果提供了回调，则将其添加为响应对象上 `'timeout'` 事件的监听器。

如果没有向请求、响应或服务器添加 `'timeout'` 监听器，则套接字在超时时会被销毁。 如果将句柄分配给请求、响应或服务器的 `'timeout'` 事件，则必须显式处理超时套接字。

#### `response.socket`[#](http://nodejs.cn/api-v12/http.html#responsesocket)

[中英对照](http://nodejs.cn/api-v12/http/response_socket.html)

新增于: v0.3.0

-   [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

对底层套接字的引用。 通常用户不会想要访问这个属性。 特别是，由于协议解析器附加到套接字的方式，套接字将不会触发 `'readable'` 事件。 在 `response.end()` 之后，该属性为空。

```
const http = require('http');
const server = http.createServer((req, res) => {
  const ip = res.socket.remoteAddress;
  const port = res.socket.remotePort;
  res.end(`Your IP address is ${ip} and your source port is ${port}.`);
}).listen(3000);
```

该属性保证是 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例，除非用户指定了 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型。

#### `response.statusCode`[#](http://nodejs.cn/api-v12/http.html#responsestatuscode)

[中英对照](http://nodejs.cn/api-v12/http/response_statuscode.html)

新增于: v0.4.0

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `200`

使用隐式标头（不显式调用 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers)）时，此属性控制在标头刷新时将发送到客户端的状态码。

```
response.statusCode = 404;
```

响应头发送到客户端后，该属性表示发送出去的状态码。

#### `response.statusMessage`[#](http://nodejs.cn/api-v12/http.html#responsestatusmessage)

[中英对照](http://nodejs.cn/api-v12/http/response_statusmessage.html)

新增于: v0.11.8

-   [<string>](http://url.nodejs.cn/9Tw2bK)

当使用隐式标头（不显式调用 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers)）时，此属性控制在标头刷新时将发送到客户端的状态消息。 如果保留为 `undefined`，则将使用状态码的标准消息。

```
response.statusMessage = 'Not found';
```

响应头发送到客户端后，该属性表示发送出去的状态消息。

#### `response.uncork()`[#](http://nodejs.cn/api-v12/http.html#responseuncork)

[中英对照](http://nodejs.cn/api-v12/http/response_uncork.html)

新增于: v12.16.0

参见 [`writable.uncork()`](http://nodejs.cn/api-v12/stream.html#stream_writable_uncork)。

#### `response.writableEnded`[#](http://nodejs.cn/api-v12/http.html#responsewritableended)

[中英对照](http://nodejs.cn/api-v12/http/response_writableended.html)

新增于: v12.9.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

在调用 [`response.end()`](http://nodejs.cn/api-v12/http.html#http_response_end_data_encoding_callback) 之后是 `true`。 此属性不指示数据是否已刷新，为此则使用 [`response.writableFinished`](http://nodejs.cn/api-v12/http.html#http_response_writablefinished) 代替。

#### `response.writableFinished`[#](http://nodejs.cn/api-v12/http.html#responsewritablefinished)

[中英对照](http://nodejs.cn/api-v12/http/response_writablefinished.html)

新增于: v12.7.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果所有数据都已在 [`'finish'`](http://nodejs.cn/api-v12/http.html#http_event_finish) 事件触发之前立即刷新到底层系统，则为 `true`。

#### `response.write(chunk[, encoding][, callback])`[#](http://nodejs.cn/api-v12/http.html#responsewritechunk-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/http/response_write_chunk_encoding_callback.html)

新增于: v0.1.29

-   `chunk` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果此方法被调用且 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers) 还没被调用，则会切换到隐式的标头模式并刷新隐式的标头。

这会发送一块响应正文。 可以多次调用此方法以提供正文的连续部分。

在 `http` 模块中，当请求是 HEAD 请求时，响应正文会被省略。 同样，`204` 和 `304` 响应不得包含消息正文。

`chunk` 可以是字符串或缓冲区。 如果 `chunk` 是字符串，则第二个参数指定如何将其编码为字节流。 当刷新数据块时将调用 `callback`。

这是原始的 HTTP 正文，与可能使用的更高级别的多部分正文编码无关。

第一次调用 [`response.write()`](http://nodejs.cn/api-v12/http.html#http_response_write_chunk_encoding_callback) 时，它会将缓存的标头信息和正文的第一个块发送给客户端。 第二次调用 [`response.write()`](http://nodejs.cn/api-v12/http.html#http_response_write_chunk_encoding_callback) 时，Node.js 会假定数据将被流式传输，并单独发送新数据。 也就是说，响应被缓冲到正文的第一个块。

如果整个数据被成功刷新到内核缓冲区，则返回 `true`。 如果所有或部分数据在用户内存中排队，则返回 `false`。 当缓冲区再次空闲时，则将触发 `'drain'`。

#### `response.writeContinue()`[#](http://nodejs.cn/api-v12/http.html#responsewritecontinue)

[中英对照](http://nodejs.cn/api-v12/http/response_writecontinue.html)

新增于: v0.3.0

向客户端发送 HTTP/1.1 100 Continue 消息，指示应发送请求正文。 请参阅 `Server` 上的 [`'checkContinue'`](http://nodejs.cn/api-v12/http.html#http_event_checkcontinue) 事件。

#### `response.writeHead(statusCode[, statusMessage][, headers])`[#](http://nodejs.cn/api-v12/http.html#responsewriteheadstatuscode-statusmessage-headers)

[中英对照](http://nodejs.cn/api-v12/http/response_writehead_statuscode_statusmessage_headers.html)

-   `statusCode` [<number>](http://url.nodejs.cn/SXbo1v)
-   `statusMessage` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `headers` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   返回: [<http.ServerResponse>](http://nodejs.cn/api/http.html#class-httpserverresponse)

向请求发送响应头。 状态码是 3 位的 HTTP 状态码，如 `404`。 最后一个参数 `headers` 是响应头。 可选地给定人类可读的 `statusMessage` 作为第二个参数。

返回对 `ServerResponse` 的引用，以便可以链式调用。

```
const body = 'hello world';
response
  .writeHead(200, {
    'Content-Length': Buffer.byteLength(body),
    'Content-Type': 'text/plain'
  })
  .end(body);
```

此方法只能在消息上调用一次，并且必须在调用 [`response.end()`](http://nodejs.cn/api-v12/http.html#http_response_end_data_encoding_callback) 之前调用。

如果在调用此之前调用了 [`response.write()`](http://nodejs.cn/api-v12/http.html#http_response_write_chunk_encoding_callback) 或 [`response.end()`](http://nodejs.cn/api-v12/http.html#http_response_end_data_encoding_callback)，则将计算隐式/可变的标头并调用此函数。

当标头已使用 [`response.setHeader()`](http://nodejs.cn/api-v12/http.html#http_response_setheader_name_value) 设置时，则它们将与任何传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers) 的标头合并，其中传给 [`response.writeHead()`](http://nodejs.cn/api-v12/http.html#http_response_writehead_statuscode_statusmessage_headers) 的标头优先。

如果调用了此方法，且还没调用 [`response.setHeader()`](http://nodejs.cn/api-v12/http.html#http_response_setheader_name_value)，则会直接将提供的标头值写入网络通道且内部不缓存，在标头上 [`response.getHeader()`](http://nodejs.cn/api-v12/http.html#http_response_getheader_name) 不会产生预期的结果。 如果需要逐步填充标头并在未来进行潜在的检索和修改，则改用 [`response.setHeader()`](http://nodejs.cn/api-v12/http.html#http_response_setheader_name_value)。

```
// 返回 content-type = text/plain
const server = http.createServer((req, res) => {
  res.setHeader('Content-Type', 'text/html');
  res.setHeader('X-Foo', 'bar');
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('ok');
});
```

`Content-Length` 以字节为单位，而不是字符。 使用 [`Buffer.byteLength()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_bytelength_string_encoding) 来确定正文的长度（以字节为单位）。 Node.js 不会检查 `Content-Length` 和已经传输的正文的长度是否相等。

尝试设置包含无效字符的标头字段名称或值将导致抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

#### `response.writeProcessing()`[#](http://nodejs.cn/api-v12/http.html#responsewriteprocessing)

[中英对照](http://nodejs.cn/api-v12/http/response_writeprocessing.html)

新增于: v10.0.0

向客户端发送 HTTP/1.1 102 Processing 消息，表示应发送请求正文。

### `http.IncomingMessage` 类[#](http://nodejs.cn/api-v12/http.html#class-httpincomingmessage)

[中英对照](http://nodejs.cn/api-v12/http/class_http_incomingmessage.html)

-   继承自: [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

`IncomingMessage` 对象由 [`http.Server`](http://nodejs.cn/api-v12/http.html#http_class_http_server) 或 [`http.ClientRequest`](http://nodejs.cn/api-v12/http.html#http_class_http_clientrequest) 创建，并分别作为第一个参数传给 [`'request'`](http://nodejs.cn/api-v12/http.html#http_event_request) 和 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response) 事件。 它可用于访问响应状态、标头和数据。

#### `'aborted'` 事件[#](http://nodejs.cn/api-v12/http.html#event-aborted)

[中英对照](http://nodejs.cn/api-v12/http/event_aborted.html)

新增于: v0.3.8

当请求被中止时触发。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/http.html#event-close_2)

[中英对照](http://nodejs.cn/api-v12/http/event_close_2.html)

新增于: v0.4.2

表示底层连接已关闭。

#### `message.aborted`[#](http://nodejs.cn/api-v12/http.html#messageaborted)

[中英对照](http://nodejs.cn/api-v12/http/message_aborted.html)

新增于: v10.1.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果请求已中止，则 `message.aborted` 属性将为 `true`。

#### `message.complete`[#](http://nodejs.cn/api-v12/http.html#messagecomplete)

[中英对照](http://nodejs.cn/api-v12/http/message_complete.html)

新增于: v0.3.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果已接收并成功解析完整的 HTTP 消息，则 `message.complete` 属性将为 `true`。

此属性作为一种确定客户端或服务器是否在连接终止之前完全传输消息的方法特别有用：

```
const req = http.request({
  host: '127.0.0.1',
  port: 8080,
  method: 'POST'
}, (res) => {
  res.resume();
  res.on('end', () => {
    if (!res.complete)
      console.error(
        'The connection was terminated while the message was still being sent');
  });
});
```

#### `message.destroy([error])`[#](http://nodejs.cn/api-v12/http.html#messagedestroyerror)

[中英对照](http://nodejs.cn/api-v12/http/message_destroy_error.html)

-   `error` [<Error>](http://url.nodejs.cn/qZ873x)
-   返回: [<this>](http://url.nodejs.cn/v7Fsu2)

在接收到 `IncomingMessage` 的套接字上调用 `destroy()`。 如果提供了 `error`，则在套接字上触发 `'error'` 事件，并将 `error` 作为参数传给该事件的任何监听器。

#### `message.headers`[#](http://nodejs.cn/api-v12/http.html#messageheaders)

[中英对照](http://nodejs.cn/api-v12/http/message_headers.html)

新增于: v0.1.5

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

原始标头中的重复项按以下方式处理，具体取决于标头名称：

-   重复的 `age`、`authorization`、`content-length`、`content-type`、`etag`、`expires`、`from`、`host`、`if-modified-since`、`if-unmodified-since`、`last-modified`、`location`、`max-forwards`、`proxy-authorization`、`referer`、`retry-after`、`server` 或 `user-agent` 被丢弃。
-   `set-cookie` 始终是数组。 重复项被添加到数组中。
-   对于重复的 `cookie` 标头，其值使用 '; ' 连接。
-   对于所有其他标头，其值使用 ', ' 连接。

#### `message.httpVersion`[#](http://nodejs.cn/api-v12/http.html#messagehttpversion)

[中英对照](http://nodejs.cn/api-v12/http/message_httpversion.html)

新增于: v0.1.1

-   [<string>](http://url.nodejs.cn/9Tw2bK)

在服务器请求的情况下，客户端发送的 HTTP 版本。 在客户端响应的情况下，连接到服务器的 HTTP 版本。 可能是 `'1.1'` 或 `'1.0'`。

`message.httpVersionMajor` 是第一个整数，`message.httpVersionMinor` 是第二个。

#### `message.method`[#](http://nodejs.cn/api-v12/http.html#messagemethod)

[中英对照](http://nodejs.cn/api-v12/http/message_method.html)

新增于: v0.1.1

-   [<string>](http://url.nodejs.cn/9Tw2bK)

**仅适用于从 [`http.Server`](http://nodejs.cn/api-v12/http.html#http_class_http_server) 获得的请求。**

请求方法作为字符串。 只读。 示例：`'GET'`、`'DELETE'`。

#### `message.rawHeaders`[#](http://nodejs.cn/api-v12/http.html#messagerawheaders)

[中英对照](http://nodejs.cn/api-v12/http/message_rawheaders.html)

新增于: v0.11.6

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

#### `message.rawTrailers`[#](http://nodejs.cn/api-v12/http.html#messagerawtrailers)

[中英对照](http://nodejs.cn/api-v12/http/message_rawtrailers.html)

新增于: v0.11.6

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

原始请求/响应尾标的键和值与收到的完全一样。 仅在 `'end'` 事件中填充。

#### `message.setTimeout(msecs[, callback])`[#](http://nodejs.cn/api-v12/http.html#messagesettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/http/message_settimeout_msecs_callback.html)

新增于: v0.5.9

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage)

调用 `message.connection.setTimeout(msecs, callback)`。

#### `message.socket`[#](http://nodejs.cn/api-v12/http.html#messagesocket)

[中英对照](http://nodejs.cn/api-v12/http/message_socket.html)

新增于: v0.3.0

-   [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

与连接关联的 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 对象。

使用 HTTPS 支持，使用 [`request.socket.getPeerCertificate()`](http://nodejs.cn/api-v12/tls.html#tls_tlssocket_getpeercertificate_detailed) 获取客户端的身份验证详细信息。

该属性保证是 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 类（[<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 的子类）的实例，除非用户指定了 [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 以外的套接字类型。

#### `message.statusCode`[#](http://nodejs.cn/api-v12/http.html#messagestatuscode)

[中英对照](http://nodejs.cn/api-v12/http/message_statuscode.html)

新增于: v0.1.1

-   [<number>](http://url.nodejs.cn/SXbo1v)

**仅对从 [`http.ClientRequest`](http://nodejs.cn/api-v12/http.html#http_class_http_clientrequest) 获得的响应有效。**

3 位 HTTP 响应状态码。 例如 `404`。

#### `message.statusMessage`[#](http://nodejs.cn/api-v12/http.html#messagestatusmessage)

[中英对照](http://nodejs.cn/api-v12/http/message_statusmessage.html)

新增于: v0.11.10

-   [<string>](http://url.nodejs.cn/9Tw2bK)

**仅对从 [`http.ClientRequest`](http://nodejs.cn/api-v12/http.html#http_class_http_clientrequest) 获得的响应有效。**

HTTP 响应状态消息（原因短语）。 例如 `OK` 或 `Internal Server Error`。

#### `message.trailers`[#](http://nodejs.cn/api-v12/http.html#messagetrailers)

[中英对照](http://nodejs.cn/api-v12/http/message_trailers.html)

新增于: v0.3.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

请求/响应尾标对象。 仅在 `'end'` 事件中填充。

#### `message.url`[#](http://nodejs.cn/api-v12/http.html#messageurl)

[中英对照](http://nodejs.cn/api-v12/http/message_url.html)

新增于: v0.1.90

-   [<string>](http://url.nodejs.cn/9Tw2bK)

**仅适用于从 [`http.Server`](http://nodejs.cn/api-v12/http.html#http_class_http_server) 获得的请求。**

请求的网址字符串。 这仅包含实际 HTTP 请求中存在的网址。 接受以下请求：

```
GET /status?name=ryan HTTP/1.1
Accept: text/plain
```

要将网址解析为它的部分：

```
new URL(request.url, `http://${request.headers.host}`);
```

当 `request.url` 为 `'/status?name=ryan'` 且 `request.headers.host` 为 `'localhost:3000'` 时：

```
$ node
> new URL(request.url, `http://${request.headers.host}`)
URL {
  href: 'http://localhost:3000/status?name=ryan',
  origin: 'http://localhost:3000',
  protocol: 'http:',
  username: '',
  password: '',
  host: 'localhost:3000',
  hostname: 'localhost',
  port: '3000',
  pathname: '/status',
  search: '?name=ryan',
  searchParams: URLSearchParams { 'name' => 'ryan' },
  hash: ''
}
```

### `http.METHODS`[#](http://nodejs.cn/api-v12/http.html#httpmethods)

[中英对照](http://nodejs.cn/api-v12/http/http_methods.html)

新增于: v0.11.8

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

解析器支持的 HTTP 方法列表。

### `http.STATUS_CODES`[#](http://nodejs.cn/api-v12/http.html#httpstatus_codes)

[中英对照](http://nodejs.cn/api-v12/http/http_status_codes.html)

新增于: v0.1.22

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

所有标准 HTTP 响应状态代码的集合，以及每个的简短描述。 例如，`http.STATUS_CODES[404] === 'Not Found'`。

### `http.createServer([options][, requestListener])`[#](http://nodejs.cn/api-v12/http.html#httpcreateserveroptions-requestlistener)

[中英对照](http://nodejs.cn/api-v12/http/http_createserver_options_requestlistener.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    
    -   `IncomingMessage` [<http.IncomingMessage>](http://nodejs.cn/api/http.html#class-httpincomingmessage) 指定要使用的 `IncomingMessage` 类。 用于扩展原始的 `IncomingMessage`。 **默认值:** `IncomingMessage`。
    -   `ServerResponse` [<http.ServerResponse>](http://nodejs.cn/api/http.html#class-httpserverresponse) 指定要使用的 `ServerResponse` 类。 用于扩展原始的 `ServerResponse`。 **默认值:** `ServerResponse`。
    -   `insecureHTTPParser` [<boolean>](http://url.nodejs.cn/jFbvuT) 使用不安全的 HTTP 解析器，当为 `true` 时接受无效的 HTTP 标头。 应避免使用不安全的解析器。 有关详细信息，请参阅 [`--insecure-http-parser`](http://nodejs.cn/api-v12/cli.html#cli_insecure_http_parser)。 **默认值:** `false`
-   `requestListener` [<Function>](http://url.nodejs.cn/ceTQa6)
    
-   返回: [<http.Server>](http://nodejs.cn/api/http.html#class-httpserver)
    

返回 [`http.Server`](http://nodejs.cn/api-v12/http.html#http_class_http_server) 的新实例。

`requestListener` 是自动添加到 [`'request'`](http://nodejs.cn/api-v12/http.html#http_event_request) 事件的函数。

### `http.get(options[, callback])`[#](http://nodejs.cn/api-v12/http.html#httpgetoptions-callback)

### `http.get(url[, options][, callback])`[#](http://nodejs.cn/api-v12/http.html#httpgeturl-options-callback)

[中英对照](http://nodejs.cn/api-v12/http/http_get_url_options_callback.html)

-   `url` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 接受与 [`http.request()`](http://nodejs.cn/api-v12/http.html#http_http_request_options_callback) 相同的 `options`，但 `method` 始终设置为 `GET`。 从原型继承的属性将被忽略。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<http.ClientRequest>](http://nodejs.cn/api/http.html#class-httpclientrequest)

由于大多数请求是没有正文的 GET 请求，因此 Node.js 提供了这个便捷的方法。 此方法与 [`http.request()`](http://nodejs.cn/api-v12/http.html#http_http_request_options_callback) 的唯一区别在于，它将方法设置为 GET 并自动调用 `req.end()`。 因为 [`http.ClientRequest`](http://nodejs.cn/api-v12/http.html#http_class_http_clientrequest) 章节所述的原因，回调必须注意消费响应数据。

`callback` 使用单个参数（[`http.IncomingMessage`](http://nodejs.cn/api-v12/http.html#http_class_http_incomingmessage) 的实例）调用。

获取 JSON 的示例：

```
http.get('http://nodejs.org/dist/index.json', (res) => {
  const { statusCode } = res;
  const contentType = res.headers['content-type'];

  let error;
  // 任何 2xx 状态码都表示成功响应，但这里只检查 200。
  if (statusCode !== 200) {
    error = new Error('Request Failed.\n' +
                      `Status Code: ${statusCode}`);
  } else if (!/^application\/json/.test(contentType)) {
    error = new Error('Invalid content-type.\n' +
                      `Expected application/json but received ${contentType}`);
  }
  if (error) {
    console.error(error.message);
    // 消费响应数据以释放内存
    res.resume();
    return;
  }

  res.setEncoding('utf8');
  let rawData = '';
  res.on('data', (chunk) => { rawData += chunk; });
  res.on('end', () => {
    try {
      const parsedData = JSON.parse(rawData);
      console.log(parsedData);
    } catch (e) {
      console.error(e.message);
    }
  });
}).on('error', (e) => {
  console.error(`Got error: ${e.message}`);
});
```

### `http.globalAgent`[#](http://nodejs.cn/api-v12/http.html#httpglobalagent)

[中英对照](http://nodejs.cn/api-v12/http/http_globalagent.html)

新增于: v0.5.9

-   [<http.Agent>](http://nodejs.cn/api/http.html#class-httpagent)

`Agent` 的全局实例，用作所有 HTTP 客户端请求的默认值。

### `http.maxHeaderSize`[#](http://nodejs.cn/api-v12/http.html#httpmaxheadersize)

[中英对照](http://nodejs.cn/api-v12/http/http_maxheadersize.html)

新增于: v11.6.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

只读属性，指定 HTTP 标头的最大允许大小（以字节为单位）。 默认为 8KB。 可使用 [`--max-http-header-size`](http://nodejs.cn/api-v12/cli.html#cli_max_http_header_size_size) 命令行选项进行配置。

### `http.request(options[, callback])`[#](http://nodejs.cn/api-v12/http.html#httprequestoptions-callback)

### `http.request(url[, options][, callback])`[#](http://nodejs.cn/api-v12/http.html#httprequesturl-options-callback)

[中英对照](http://nodejs.cn/api-v12/http/http_request_url_options_callback.html)

-   `url` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `agent` [<http.Agent>](http://nodejs.cn/api/http.html#class-httpagent) | [<boolean>](http://url.nodejs.cn/jFbvuT) 控制 [`Agent`](http://nodejs.cn/api-v12/http.html#http_class_http_agent) 的行为。 可能的值：
        -   `undefined`（默认）: 为此主机和端口使用 [`http.globalAgent`](http://nodejs.cn/api-v12/http.html#http_http_globalagent)。
        -   `Agent` 对象: 显式使用传入的 `Agent`。
        -   `false`: 使用具有默认值的新 `Agent`。
    -   `auth` [<string>](http://url.nodejs.cn/9Tw2bK) 基本身份验证，即 `'user:password'` 计算授权标头。
    -   `createConnection` [<Function>](http://url.nodejs.cn/ceTQa6) 当不使用 `agent` 选项时，生成用于请求的套接字/流的函数。 这可用于避免创建自定义 `Agent` 类只是为了覆盖默认的 `createConnection` 函数。 有关详细信息，请参阅 [`agent.createConnection()`](http://nodejs.cn/api-v12/http.html#http_agent_createconnection_options_callback)。 任何 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流都是有效的返回值。
    -   `defaultPort` [<number>](http://url.nodejs.cn/SXbo1v) 协议的默认端口。 **默认值:** 如果使用 `Agent` 则为 `agent.defaultPort`，否则为 `undefined`。
    -   `family` [<number>](http://url.nodejs.cn/SXbo1v) 解析 `host` 或 `hostname` 时要使用的 IP 地址族。 有效值为 `4` 或 `6`。 当未指定时，则将使用 IP v4 和 v6。
    -   `headers` [<Object>](http://url.nodejs.cn/jzn6Ao) 包含请求头的对象。
    -   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 要向其发出请求的服务器的域名或 IP 地址。 **默认值:** `'localhost'`。
    -   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) `host` 的别名。 为了支持 [`url.parse()`](http://nodejs.cn/api-v12/url.html#url_url_parse_urlstring_parsequerystring_slashesdenotehost)，如果同时指定了 `host` 和 `hostname`，则将使用 `hostname`。
    -   `insecureHTTPParser` [<boolean>](http://url.nodejs.cn/jFbvuT) 使用不安全的 HTTP 解析器，当为 `true` 时接受无效的 HTTP 标头。 应避免使用不安全的解析器。 有关详细信息，请参阅 [`--insecure-http-parser`](http://nodejs.cn/api-v12/cli.html#cli_insecure_http_parser)。 **默认值:** `false`
    -   `localAddress` [<string>](http://url.nodejs.cn/9Tw2bK) 用于绑定网络连接的本地接口。
    -   `lookup` [<Function>](http://url.nodejs.cn/ceTQa6) 自定义查找函数。 **默认值:** [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback).
    -   `method` [<string>](http://url.nodejs.cn/9Tw2bK) 指定 HTTP 请求方法的字符串。 **默认值:** `'GET'`。
    -   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 请求的路径。 应包括查询字符串（如果有）。 例如 `'/index.html?page=12'`。 当请求路径包含非法字符时抛出异常。 目前，只有空格被拒绝，但将来可能会改变。 **默认值:** `'/'`。
    -   `port` [<number>](http://url.nodejs.cn/SXbo1v) 远程服务器的端口。 **默认值:** 如果有设置则为 `defaultPort`，否则为 `80`。
    -   `protocol` [<string>](http://url.nodejs.cn/9Tw2bK) 要使用的协议。 **默认值:** `'http:'`。
    -   `setHost` [<boolean>](http://url.nodejs.cn/jFbvuT): 指定是否自动添加 `Host` 标头。 默认为 `true`。
    -   `socketPath` [<string>](http://url.nodejs.cn/9Tw2bK) Unix 域套接字（如果指定了 `host` 或 `port` 之一，则不能使用，因为其指定了 TCP 套接字）。
    -   `timeout` [<number>](http://url.nodejs.cn/SXbo1v): 指定套接字超时的数值（以毫秒为单位）。 这将在连接套接字之前设置超时。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<http.ClientRequest>](http://nodejs.cn/api/http.html#class-httpclientrequest)

Node.js 为每个服务器维护多个连接以发出 HTTP 请求。 此函数允许显式地发出请求。

`url` 可以是字符串或 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 对象。 如果 `url` 是字符串，则会自动使用 [`new URL()`](http://nodejs.cn/api-v12/url.html#url_new_url_input_base) 解析。 如果是 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 对象，则会自动转换为普通的 `options` 对象。

如果同时指定了 `url` 和 `options`，则合并对象，`options` 属性优先。

可选的 `callback` 参数将被添加为 [`'response'`](http://nodejs.cn/api-v12/http.html#http_event_response) 事件的单次监听器。

`http.request()` 返回 [`http.ClientRequest`](http://nodejs.cn/api-v12/http.html#http_class_http_clientrequest) 类的实例。 `ClientRequest` 实例是可写流。 如果需要使用 POST 请求上传文件，则写入 `ClientRequest` 对象。

```
const postData = querystring.stringify({
  'msg': 'Hello World!'
});

const options = {
  hostname: 'www.google.com',
  port: 80,
  path: '/upload',
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'Content-Length': Buffer.byteLength(postData)
  }
};

const req = http.request(options, (res) => {
  console.log(`STATUS: ${res.statusCode}`);
  console.log(`HEADERS: ${JSON.stringify(res.headers)}`);
  res.setEncoding('utf8');
  res.on('data', (chunk) => {
    console.log(`BODY: ${chunk}`);
  });
  res.on('end', () => {
    console.log('No more data in response.');
  });
});

req.on('error', (e) => {
  console.error(`problem with request: ${e.message}`);
});

// 将数据写入请求正文
req.write(postData);
req.end();
```

在示例中，调用了 `req.end()`。 使用 `http.request()` 必须始终调用 `req.end()` 来表示请求的结束 - 即使没有数据写入请求正文。

如果在请求期间遇到任何错误（无论是 DNS 解析、TCP 级别错误还是实际的 HTTP 解析错误），都会在返回的请求对象上触发 `'error'` 事件。 与所有 `'error'` 事件一样，如果没有注册监听器，则会抛出错误。

有一些特殊的标头需要注意。

-   发送 'Connection: keep-alive' 将通知 Node.js，服务器的连接应该持续到下一个请求。
    
-   发送 'Content-Length' 标头将禁用默认的分块编码。
    
-   发送 'Expect' 标头将立即发送请求头。 通常，当发送 'Expect: 100-continue' 时，应该设置超时和 `'continue'` 事件的监听器。 有关更多信息，请参阅 RFC 2616 第 8.2.3 节。
    
-   发送授权标头将覆盖使用 `auth` 选项来计算基本身份验证。
    

使用 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 作为 `options` 的示例：

```
const options = new URL('http://abc:xyz@example.com');

const req = http.request(options, (res) => {
  // ...
});
```

在成功的请求中，将按以下顺序触发以下事件：

-   `'socket'`
-   `'response'`
    -   `res` 对象上的 `'data'`，任意次数（如果响应正文为空，则根本不会触发 `'data'`，例如，在大多数重定向中）
    -   `res` 对象上的 `'end'`
-   `'close'`

在连接错误的情况下，将触发以下事件：

-   `'socket'`
-   `'error'`
-   `'close'`

如果在连接成功之前调用 `req.abort()`，则将按以下顺序触发以下事件：

-   `'socket'`
-   （在此处调用 `req.abort()`）
-   `'abort'`
-   使用具有消息 `'Error: socket hang up'` 和代码 `'ECONNRESET'` 的错误的 `'error'`
-   `'close'`

如果在收到响应之后调用 `req.abort()`，则将按以下顺序触发以下事件：

-   `'socket'`
-   `'response'`
    -   `res` 对象上的 `'data'`，任意次数
-   （在此处调用 `req.abort()`）
-   `'abort'`
-   `res` 对象上的 `'aborted'`
-   `'close'`
-   `res` 对象上的 `'end'`
-   `res` 对象上的 `'close'`

设置 `timeout` 选项或使用 `setTimeout()` 函数将不会中止请求或执行除添加 `'timeout'` 事件外的任何操作。
