---
created: 2022-07-29T13:12:55 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/net.html
author: 
---

# net 网络 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/net/net.html)

**源代码:** [lib/net.js](https://github.com/nodejs/node/blob/v12.22.12/lib/net.js)

`net` 模块提供了异步的网络 API，用于创建基于流的 TCP 或 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 服务器 ([`net.createServer()`](http://nodejs.cn/api-v12/net.html#net_net_createserver_options_connectionlistener)) 和客户端 ([`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection))。

可以使用以下方式访问它：

```
const net = require('net');
```

### IPC 支持[#](http://nodejs.cn/api-v12/net.html#ipc-support)

[中英对照](http://nodejs.cn/api-v12/net/ipc_support.html)

`net` 模块在 Windows 上使用命名管道支持 IPC，在其他操作系统上则使用 Unix 域套接字。

#### 标识 IPC 连接的路径[#](http://nodejs.cn/api-v12/net.html#identifying-paths-for-ipc-connections)

[中英对照](http://nodejs.cn/api-v12/net/identifying_paths_for_ipc_connections.html)

[`net.connect()`](http://nodejs.cn/api-v12/net.html#net_net_connect)、[`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection)、[`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 和 [`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect) 采用 `path` 参数来标识 IPC 端点。

在 Unix 上，本地域也称为 Unix 域。 路径是文件系统路径名。 它被截断为与操作系统相关的 `sizeof(sockaddr_un.sun_path) - 1` 长度。 典型的值为 Linux 上的 107 字节和 macOS 上的 103 字节。 如果 Node.js API 抽象创建了 Unix 域套接字，则它也会取消链接 Unix 域套接字。 例如，[`net.createServer()`](http://nodejs.cn/api-v12/net.html#net_net_createserver_options_connectionlistener) 可以会创建 Unix 域套接字，而 [`server.close()`](http://nodejs.cn/api-v12/net.html#net_server_close_callback) 将取消链接它。 但是如果用户在这些抽象之外创建了 Unix 域套接字，则用户将需要删除它。 这同样适用于 Node.js API 创建 Unix 域套接字但程序随后崩溃的情况。 简而言之，Unix 域套接字将在文件系统中可见，并且会一直存在，直到取消链接。

在 Windows 上，本地域是使用命名管道实现的。 路径必须引用 `\\?\pipe\` 或 `\\.\pipe\` 中的条目。 允许使用任何字符，但后者可能会对管道名称进行一些处理，例如解析 `..` 序列。 不管它看起来如何，管道命名空间是扁平的。 管道不会持续存在。 当对它们的最后一个引用关闭时，它们将被删除。 与 Unix 域套接字不同，Windows 将在拥有进程退出时关闭并删除管道。

JavaScript 字符串转义需要使用额外的反斜杠转义来指定路径，例如：

```
net.createServer().listen(
  path.join('\\\\?\\pipe', process.cwd(), 'myctl'));
```

### `net.Server` 类[#](http://nodejs.cn/api-v12/net.html#class-netserver)

[中英对照](http://nodejs.cn/api-v12/net/class_net_server.html)

新增于: v0.1.90

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

此类用于创建 TCP 或 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 服务器。

#### `new net.Server([options][, connectionListener])`[#](http://nodejs.cn/api-v12/net.html#new-netserveroptions-connectionlistener)

[中英对照](http://nodejs.cn/api-v12/net/new_net_server_options_connectionlistener.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`net.createServer([options][, connectionListener])`](http://nodejs.cn/api-v12/net.html#net_net_createserver_options_connectionlistener)。
-   `connectionListener` [<Function>](http://url.nodejs.cn/ceTQa6) 自动设置为 [`'connection'`](http://nodejs.cn/api-v12/net.html#net_event_connection) 事件的监听器。
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

`net.Server` 是具有以下事件的 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter)：

#### `'close'` 事件[#](http://nodejs.cn/api-v12/net.html#event-close)

[中英对照](http://nodejs.cn/api-v12/net/event_close.html)

新增于: v0.5.0

服务器关闭时触发。 如果连接存在，则在所有连接结束之前不会触发此事件。

#### `'connection'` 事件[#](http://nodejs.cn/api-v12/net.html#event-connection)

[中英对照](http://nodejs.cn/api-v12/net/event_connection.html)

新增于: v0.1.90

-   [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 连接对象

建立新连接时触发。 `socket` 是 `net.Socket` 的实例。

#### `'error'` 事件[#](http://nodejs.cn/api-v12/net.html#event-error)

[中英对照](http://nodejs.cn/api-v12/net/event_error.html)

新增于: v0.1.90

-   [<Error>](http://url.nodejs.cn/qZ873x)

发生错误时触发。 与 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 不同，除非手动调用 [`server.close()`](http://nodejs.cn/api-v12/net.html#net_server_close_callback)，否则 [`'close'`](http://nodejs.cn/api-v12/net.html#net_event_close) 事件不会在此事件之后直接触发。 参见 [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 讨论中的示例。

#### `'listening'` 事件[#](http://nodejs.cn/api-v12/net.html#event-listening)

[中英对照](http://nodejs.cn/api-v12/net/event_listening.html)

新增于: v0.1.90

在调用 [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 后绑定服务器时触发。

#### `server.address()`[#](http://nodejs.cn/api-v12/net.html#serveraddress)

[中英对照](http://nodejs.cn/api-v12/net/server_address.html)

新增于: v0.1.90

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC)

如果监听 IP 套接字，则返回操作系统报告的服务器的绑定 `address`、地址 `family` 名称和 `port`（用于在获取操作系统分配的地址时查找分配的端口）：`{ port: 12346, family: 'IPv4', address: '127.0.0.1' }`。

对于监听管道或 Unix 域套接字的服务器，名称作为字符串返回。

```
const server = net.createServer((socket) => {
  socket.end('goodbye\n');
}).on('error', (err) => {
  // 在这里处理错误。
  throw err;
});

// 获取任意未使用的端口。
server.listen(() => {
  console.log('opened server on', server.address());
});
```

`server.address()` 在 `'listening'` 事件触发之前或调用 `server.close()` 之后返回 `null`。

#### `server.close([callback])`[#](http://nodejs.cn/api-v12/net.html#serverclosecallback)

[中英对照](http://nodejs.cn/api-v12/net/server_close_callback.html)

新增于: v0.1.90

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 服务器关闭时调用。
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

停止服务器接受新连接并保持现有连接。 该函数是异步的，当所有连接都结束并且服务器触发 [`'close'`](http://nodejs.cn/api-v12/net.html#net_event_close) 事件时，则服务器最终关闭。 一旦 `'close'` 事件发生，则可选的 `callback` 将被调用。 与该事件不同，如果服务器在关闭时未打开，它将以 `Error` 作为唯一参数被调用。

#### `server.connections`[#](http://nodejs.cn/api-v12/net.html#serverconnections)

[中英对照](http://nodejs.cn/api-v12/net/server_connections.html)

新增于: v0.2.0弃用于: v0.9.7

-   [<integer>](http://url.nodejs.cn/SXbo1v) | [<null>](http://url.nodejs.cn/334hvC)

服务器上的并发连接数。

当向具有 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 的子进程发送套接字时，这将变为 `null`。 要轮询衍生并获取当前的活动连接数，则改用异步的 [`server.getConnections()`](http://nodejs.cn/api-v12/net.html#net_server_getconnections_callback)。

#### `server.getConnections(callback)`[#](http://nodejs.cn/api-v12/net.html#servergetconnectionscallback)

[中英对照](http://nodejs.cn/api-v12/net/server_getconnections_callback.html)

新增于: v0.9.7

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

异步获取服务器上的并发连接数。 当套接字被发送到分叉时工作。

回调应该采用两个参数 `err` 和 `count`。

#### `server.listen()`[#](http://nodejs.cn/api-v12/net.html#serverlisten)

[中英对照](http://nodejs.cn/api-v12/net/server_listen.html)

启动监听连接的服务器。 `net.Server` 可以是 TCP 或 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 服务器，这取决于它监听什么。

可能的语法有：

-   [`server.listen(handle[, backlog][, callback])`](http://nodejs.cn/api-v12/net.html#net_server_listen_handle_backlog_callback)
-   [`server.listen(options[, callback])`](http://nodejs.cn/api-v12/net.html#net_server_listen_options_callback)
-   [`server.listen(path[, backlog][, callback])`](http://nodejs.cn/api-v12/net.html#net_server_listen_path_backlog_callback) 用于 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 服务器

此函数是异步的。 当服务器开始监听时，将触发 [`'listening'`](http://nodejs.cn/api-v12/net.html#net_event_listening) 事件。 最后一个参数 `callback` 将被添加为 [`'listening'`](http://nodejs.cn/api-v12/net.html#net_event_listening) 事件的监听器。

所有 `listen()` 方法都可以采用 `backlog` 参数来指定待处理连接队列的最大长度。 实际长度将由操作系统通过 sysctl 设置确定，例如 Linux 上的 `tcp_max_syn_backlog` 和 `somaxconn`。 此参数的默认值为 511（不是 512）。

所有 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 都设置为 `SO_REUSEADDR`（详见 [`socket(7)`](http://url.nodejs.cn/222WPc)）。

当且仅当在第一次调用 `server.listen()` 期间出现错误或调用 `server.close()` 时，才能再次调用 `server.listen()` 方法。 否则，将抛出 `ERR_SERVER_ALREADY_LISTEN` 错误。

监听时最常见的错误之一是 `EADDRINUSE`。 当另一个服务器已经在监听请求的 `port`/`path`/`handle` 时会发生这种情况。 处理此问题的方法之一是在一定时间后重试：

```
server.on('error', (e) => {
  if (e.code === 'EADDRINUSE') {
    console.log('Address in use, retrying...');
    setTimeout(() => {
      server.close();
      server.listen(PORT, HOST);
    }, 1000);
  }
});
```

##### `server.listen(handle[, backlog][, callback])`[#](http://nodejs.cn/api-v12/net.html#serverlistenhandle-backlog-callback)

[中英对照](http://nodejs.cn/api-v12/net/server_listen_handle_backlog_callback.html)

新增于: v0.5.10

-   `handle` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `backlog` [<number>](http://url.nodejs.cn/SXbo1v) [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 函数的通用参数
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

启动服务器，监听已绑定到端口、Unix 域套接字或 Windows 命名管道的给定 `handle` 上的连接。

`handle` 对象可以是服务器、套接字（任何具有底层 `_handle` 成员的对象），也可以是具有有效文件描述符的 `fd` 成员的对象。

Windows 上不支持监听文件描述符。

##### `server.listen(options[, callback])`[#](http://nodejs.cn/api-v12/net.html#serverlistenoptions-callback)

[中英对照](http://nodejs.cn/api-v12/net/server_listen_options_callback.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 必需的。 支持以下属性：
    -   `port` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `host` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 如果指定了 `port`，则将被忽略。 请参阅[标识 IPC 连接的路径](http://nodejs.cn/api-v12/net.html#net_identifying_paths_for_ipc_connections)。
    -   `backlog` [<number>](http://url.nodejs.cn/SXbo1v) [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 函数的通用参数。
    -   `exclusive` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
    -   `readableAll` [<boolean>](http://url.nodejs.cn/jFbvuT) 对于 IPC 服务器，使管道对所有用户都可读。 **默认值:** `false`。
    -   `writableAll` [<boolean>](http://url.nodejs.cn/jFbvuT) 对于 IPC 服务器，使管道对所有用户都可写。 **默认值:** `false`。
    -   `ipv6Only` [<boolean>](http://url.nodejs.cn/jFbvuT) 对于 TCP 服务器，将 `ipv6Only` 设置为 `true` 将禁用双栈支持，即绑定到主机 `::` 不会绑定 `0.0.0.0`。 **默认值:** `false`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 函数。
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

如果指定了 `port`，则其行为与 [`server.listen([port[, host[, backlog]]][, callback])`](http://nodejs.cn/api-v12/net.html#net_server_listen_port_host_backlog_callback) 相同。 否则，如果指定了 `path`，则其行为与 [`server.listen(path[, backlog][, callback])`](http://nodejs.cn/api-v12/net.html#net_server_listen_path_backlog_callback) 相同。 如果未指定任何一个，则会抛出错误。

如果 `exclusive` 是 `false`（默认），则集群工作进程将使用相同的底层句柄，允许共享连接处理职责。 当 `exclusive` 为 `true` 时，句柄不共享，尝试共享端口会导致错误。 下面展示了监听独占端口的示例。

```
server.listen({
  host: 'localhost',
  port: 80,
  exclusive: true
});
```

以 root 身份启动 IPC 服务器可能会导致非特权用户无法访问服务器路径。 使用 `readableAll` 和 `writableAll` 将使所有用户都可以访问服务器。

##### `server.listen(path[, backlog][, callback])`[#](http://nodejs.cn/api-v12/net.html#serverlistenpath-backlog-callback)

[中英对照](http://nodejs.cn/api-v12/net/server_listen_path_backlog_callback.html)

新增于: v0.1.90

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 服务器应该监听的路径。 请参阅[标识 IPC 连接的路径](http://nodejs.cn/api-v12/net.html#net_identifying_paths_for_ipc_connections)。
-   `backlog` [<number>](http://url.nodejs.cn/SXbo1v) [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 函数的通用参数。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6).
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

启动 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 服务器，监听给定 `path` 上的连接。

##### `server.listen([port[, host[, backlog]]][, callback])`[#](http://nodejs.cn/api-v12/net.html#serverlistenport-host-backlog-callback)

[中英对照](http://nodejs.cn/api-v12/net/server_listen_port_host_backlog_callback.html)

新增于: v0.1.90

-   `port` [<number>](http://url.nodejs.cn/SXbo1v)
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `backlog` [<number>](http://url.nodejs.cn/SXbo1v) [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 函数的通用参数。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6).
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

启动 TCP 服务器，监听给定 `port` 和 `host` 上的连接。

如果 `port` 被省略或为 0，则操作系统将分配任意未使用的端口，可以在 [`'listening'`](http://nodejs.cn/api-v12/net.html#net_event_listening) 事件触发后使用 `server.address().port` 检索该端口。

如果省略 `host`，则当 IPv6 可用时，服务器将接受[未指定的 IPv6 地址](http://url.nodejs.cn/Qm3wjJ) (`::`) 上的连接，否则接受[未指定的 IPv4 地址](http://url.nodejs.cn/ccQvH8) (`0.0.0.0`) 上的连接。

在大多数操作系统中，监听[未指定的 IPv6 地址](http://url.nodejs.cn/Qm3wjJ) (`::`) 可能会导致 `net.Server` 也监听[未指定的 IPv4 地址](http://url.nodejs.cn/ccQvH8) (`0.0.0.0`)。

#### `server.listening`[#](http://nodejs.cn/api-v12/net.html#serverlistening)

[中英对照](http://nodejs.cn/api-v12/net/server_listening.html)

新增于: v5.7.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT) 指示服务器是否正在监听连接。

#### `server.maxConnections`[#](http://nodejs.cn/api-v12/net.html#servermaxconnections)

[中英对照](http://nodejs.cn/api-v12/net/server_maxconnections.html)

新增于: v0.2.0

-   [<integer>](http://url.nodejs.cn/SXbo1v)

设置此属性以在服务器的连接计数变高时拒绝连接。

一旦套接字已发送给具有 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 的子进程，则不建议使用此选项。

#### `server.ref()`[#](http://nodejs.cn/api-v12/net.html#serverref)

[中英对照](http://nodejs.cn/api-v12/net/server_ref.html)

新增于: v0.9.1

-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

与 `unref()` 相反，如果它是唯一剩下的服务器（默认行为），则在以前的 `unref` 的服务器上调用 `ref()` 不会让程序退出。 如果服务器被 `ref`，则再次调用 `ref()` 将无效。

#### `server.unref()`[#](http://nodejs.cn/api-v12/net.html#serverunref)

[中英对照](http://nodejs.cn/api-v12/net/server_unref.html)

新增于: v0.9.1

-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

如果服务器是事件系统中唯一的活动服务器，则在服务器上调用 `unref()` 将允许程序退出。 如果服务器已经被 `unref`，则再次调用 `unref()` 将无效。

### `net.Socket` 类[#](http://nodejs.cn/api-v12/net.html#class-netsocket)

[中英对照](http://nodejs.cn/api-v12/net/class_net_socket.html)

新增于: v0.3.4

-   继承自: [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

此类是 TCP 套接字或流式 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 端点（在 Windows 上使用命名管道，否则使用 Unix 域套接字）的抽象。 它也是 [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter)。

`net.Socket` 可以由用户创建并直接用于与服务器交互。 例如，通过 [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection) 返回它，因此用户可以使用它与服务器对话。

它也可以由 Node.js 创建并在接收到连接时传给用户。 例如，它被传给在 [`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 上触发的 [`'connection'`](http://nodejs.cn/api-v12/net.html#net_event_connection) 事件的监听器，因此用户可以使用它与客户端进行交互。

#### `new net.Socket([options])`[#](http://nodejs.cn/api-v12/net.html#new-netsocketoptions)

[中英对照](http://nodejs.cn/api-v12/net/new_net_socket_options.html)

新增于: v0.3.4

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 可用的选项有：
    -   `fd` [<number>](http://url.nodejs.cn/SXbo1v) 如果指定，则使用给定的文件描述符封装现有的套接字，否则将创建新的套接字。
    -   `allowHalfOpen` [<boolean>](http://url.nodejs.cn/jFbvuT) 有关详细信息，请参阅 [`net.createServer()`](http://nodejs.cn/api-v12/net.html#net_net_createserver_options_connectionlistener) 和 [`'end'`](http://nodejs.cn/api-v12/net.html#net_event_end) 事件。 **默认值:** `false`。
    -   `readable` [<boolean>](http://url.nodejs.cn/jFbvuT) 当传入 `fd` 时，则允许在套接字上读取，否则将被忽略。 **默认值:** `false`。
    -   `writable` [<boolean>](http://url.nodejs.cn/jFbvuT) 当传入 `fd` 时，则允许在套接字上写入，否则将被忽略。 **默认值:** `false`。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

创建新的套接字对象。

新创建的套接字可以是 TCP 套接字或流式 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 端点，这取决于它 [`connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect) 什么。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/net.html#event-close_1)

[中英对照](http://nodejs.cn/api-v12/net/event_close_1.html)

新增于: v0.1.90

-   `hadError` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果套接字有传输错误，则为 `true`。

一旦套接字完全关闭就触发。 参数 `hadError` 是布尔值，表示套接字是否由于传输错误而关闭。

#### `'connect'` 事件[#](http://nodejs.cn/api-v12/net.html#event-connect)

[中英对照](http://nodejs.cn/api-v12/net/event_connect.html)

新增于: v0.1.90

当成功建立套接字连接时触发。 参见 [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection)。

#### `'data'` 事件[#](http://nodejs.cn/api-v12/net.html#event-data)

[中英对照](http://nodejs.cn/api-v12/net/event_data.html)

新增于: v0.1.90

-   [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK)

接收到数据时触发。 参数 `data` 将是 `Buffer` 或 `String`。 数据的编码由 [`socket.setEncoding()`](http://nodejs.cn/api-v12/net.html#net_socket_setencoding_encoding) 设置。

如果 `Socket` 触发 `'data'` 事件时没有监听器，则数据将丢失。

#### `'drain'` 事件[#](http://nodejs.cn/api-v12/net.html#event-drain)

[中英对照](http://nodejs.cn/api-v12/net/event_drain.html)

新增于: v0.1.90

当写缓冲区变空时触发。 可用于限制上传。

另请参阅：`socket.write()` 的返回值。

#### `'end'` 事件[#](http://nodejs.cn/api-v12/net.html#event-end)

[中英对照](http://nodejs.cn/api-v12/net/event_end.html)

新增于: v0.1.90

但是，如果 `allowHalfOpen` 设置为 `true`，套接字将不会自动将其可写端 [`end()`](http://nodejs.cn/api-v12/net.html#net_socket_end_data_encoding_callback)，从而允许用户写入任意数量的数据。 用户必须显式调用 [`end()`](http://nodejs.cn/api-v12/net.html#net_socket_end_data_encoding_callback) 来关闭连接（即发回一个 FIN 数据包）。

#### `'error'` 事件[#](http://nodejs.cn/api-v12/net.html#event-error_1)

[中英对照](http://nodejs.cn/api-v12/net/event_error_1.html)

新增于: v0.1.90

-   [<Error>](http://url.nodejs.cn/qZ873x)

发生错误时触发。 `'close'` 事件将在此事件之后直接调用。

#### `'lookup'` 事件[#](http://nodejs.cn/api-v12/net.html#event-lookup)

[中英对照](http://nodejs.cn/api-v12/net/event_lookup.html)

在解析主机名之后但在连接之前触发。 不适用于 Unix 套接字。

-   `err` [<Error>](http://url.nodejs.cn/qZ873x) | [<null>](http://url.nodejs.cn/334hvC) 错误对象。 参见 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback)。
-   `address` [<string>](http://url.nodejs.cn/9Tw2bK) IP 地址。
-   `family` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) 地址类型。 参见 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback)。
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 主机名。

#### `'ready'` 事件[#](http://nodejs.cn/api-v12/net.html#event-ready)

[中英对照](http://nodejs.cn/api-v12/net/event_ready.html)

新增于: v9.11.0

当套接字准备好使用时触发。

`'connect'` 后立即触发。

#### `'timeout'` 事件[#](http://nodejs.cn/api-v12/net.html#event-timeout)

[中英对照](http://nodejs.cn/api-v12/net/event_timeout.html)

新增于: v0.1.90

如果套接字因不活动而超时则触发。 这只是通知套接字已空闲。 用户必须手动关闭连接。

另见: [`socket.setTimeout()`](http://nodejs.cn/api-v12/net.html#net_socket_settimeout_timeout_callback)。

#### `socket.address()`[#](http://nodejs.cn/api-v12/net.html#socketaddress)

[中英对照](http://nodejs.cn/api-v12/net/socket_address.html)

新增于: v0.1.90

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回操作系统报告的绑定 `address`、地址 `family` 名称和套接字的 `port`：`{ port: 12346, family: 'IPv4', address: '127.0.0.1' }`

#### `socket.bufferSize`[#](http://nodejs.cn/api-v12/net.html#socketbuffersize)

[中英对照](http://nodejs.cn/api-v12/net/socket_buffersize.html)

新增于: v0.3.8

-   [<integer>](http://url.nodejs.cn/SXbo1v)

此属性显示为写入而缓冲的字符数。 缓冲区可能包含编码后长度未知的字符串。 所以这个数字只是缓冲区中字节数的近似值。

`net.Socket` 具有 `socket.write()` 始终有效的特性。 这是为了帮助用户快速启动和运行。 计算机无法始终跟上写入套接字的数据量。 网络连接可能太慢了。 Node.js 将在内部对写入套接字的数据进行排队，并在可能的情况下通过网络将其发送出去。

这种内部缓冲的结果是内存可能会增长。 经历过大型或不断增长的 `bufferSize` 的用户应该尝试使用 [`socket.pause()`](http://nodejs.cn/api-v12/net.html#net_socket_pause) 和 [`socket.resume()`](http://nodejs.cn/api-v12/net.html#net_socket_resume) 来"节流"他们程序中的数据流。

#### `socket.bytesRead`[#](http://nodejs.cn/api-v12/net.html#socketbytesread)

[中英对照](http://nodejs.cn/api-v12/net/socket_bytesread.html)

新增于: v0.5.3

-   [<integer>](http://url.nodejs.cn/SXbo1v)

接收的字节数。

#### `socket.bytesWritten`[#](http://nodejs.cn/api-v12/net.html#socketbyteswritten)

[中英对照](http://nodejs.cn/api-v12/net/socket_byteswritten.html)

新增于: v0.5.3

-   [<integer>](http://url.nodejs.cn/SXbo1v)

发送的字节数。

#### `socket.connect()`[#](http://nodejs.cn/api-v12/net.html#socketconnect)

[中英对照](http://nodejs.cn/api-v12/net/socket_connect.html)

在给定的套接字上发起连接。

可能的语法有：

-   [`socket.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener)
-   [`socket.connect(path[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_path_connectlistener) 用于 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 连接。
-   [`socket.connect(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_port_host_connectlistener) 用于 TCP 连接。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

此函数是异步的。 建立连接后，将触发 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件。 如果连接出现问题，则将触发 [`'error'`](http://nodejs.cn/api-v12/net.html#net_event_error_1) 事件并将错误传给 [`'error'`](http://nodejs.cn/api-v12/net.html#net_event_error_1) 监听器，而不是触发 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件。 最后一个参数 `connectListener`（如果提供）将作为 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件的监听器添加一次。

此函数仅用于在触发 `'close'` 之后重新连接套接字，否则可能导致未定义的行为。

##### `socket.connect(options[, connectListener])`[#](http://nodejs.cn/api-v12/net.html#socketconnectoptions-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/socket_connect_options_connectlistener.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6) [`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect) 方法的常用参数。 将被添加为 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件的监听器一次。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

在给定的套接字上发起连接。 一般不需要这个方法，套接字应该用 [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection) 创建和打开。 仅在实现自定义套接字时使用它。

对于 TCP 连接，可用的 `options` 是：

-   `port` [<number>](http://url.nodejs.cn/SXbo1v) 必需的。 套接字应连接到的端口。
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 套接字应连接到的主机。 **默认值:** `'localhost'`。
-   `localAddress` [<string>](http://url.nodejs.cn/9Tw2bK) 套接字应该连接的本地地址。
-   `localPort` [<number>](http://url.nodejs.cn/SXbo1v) 套接字应连接的本地端口。
-   `family` [<number>](http://url.nodejs.cn/SXbo1v): IP 堆栈的版本。 必须是 `4`、`6` 或 `0`。 值 `0` 表示允许 IPv4 和 IPv6 地址。 **默认值:** `0`。
-   `hints` [<number>](http://url.nodejs.cn/SXbo1v) 可选的 [`dns.lookup()` 提示](http://nodejs.cn/api-v12/dns.html#dns_supported_getaddrinfo_flags)。
-   `lookup` [<Function>](http://url.nodejs.cn/ceTQa6) 自定义查找函数。 **默认值:** [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback).

对于 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 连接，可用的 `options` 是：

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 必需的。 客户端应该连接到的路径。 请参阅[标识 IPC 连接的路径](http://nodejs.cn/api-v12/net.html#net_identifying_paths_for_ipc_connections)。 如果提供，则忽略上面特定于 TCP 的选项。

对于这两种类型，可用的 `options` 包括：

-   `onread` [<Object>](http://url.nodejs.cn/jzn6Ao) 如果指定，传入的数据存储在单个 `buffer` 中，并在数据到达套接字时传给提供的 `callback`。 这将导致流功能不提供任何数据。 套接字将像往常一样触发 `'error'`、`'end'` 和 `'close'` 等事件。 `pause()` 和 `resume()` 等方法也将按预期运行。
    -   `buffer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) | [<Function>](http://url.nodejs.cn/ceTQa6) 用于存储传入数据的可重用内存块或返回此类数据的函数。
    -   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 为每个传入数据块调用此函数。 传给它的有两个参数：写入 `buffer` 的字节数和对 `buffer` 的引用。 从此函数返回 `false` 以隐式 `pause()` 套接字。 该函数将在全局上下文中执行。

以下是使用 `onread` 选项的客户端示例：

```
const net = require('net');
net.connect({
  port: 80,
  onread: {
    // 每次从套接字读取时重用 4KiB 缓冲区。
    buffer: Buffer.alloc(4 * 1024),
    callback: function(nread, buf) {
      // 接收到的数据在 `buf` 中可用，从 0 到 `nread`。
      console.log(buf.toString('utf8', 0, nread));
    }
  }
});
```

##### `socket.connect(path[, connectListener])`[#](http://nodejs.cn/api-v12/net.html#socketconnectpath-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/socket_connect_path_connectlistener.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 客户端应该连接到的路径。 请参阅[标识 IPC 连接的路径](http://nodejs.cn/api-v12/net.html#net_identifying_paths_for_ipc_connections)。
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6) [`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect) 方法的常用参数。 将被添加为 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件的监听器一次。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

在给定的套接字上发起 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 连接。

[`socket.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 的别名被称为 `{ path: path }` 作为 `options`。

##### `socket.connect(port[, host][, connectListener])`[#](http://nodejs.cn/api-v12/net.html#socketconnectport-host-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/socket_connect_port_host_connectlistener.html)

新增于: v0.1.90

-   `port` [<number>](http://url.nodejs.cn/SXbo1v) 客户端应该连接到的端口。
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 客户端应该连接到的主机。
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6) [`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect) 方法的常用参数。 将被添加为 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件的监听器一次。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

在给定的套接字上发起 TCP 连接。

[`socket.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 的别名被称为 `{port: port, host: host}` 作为 `options`。

#### `socket.connecting`[#](http://nodejs.cn/api-v12/net.html#socketconnecting)

[中英对照](http://nodejs.cn/api-v12/net/socket_connecting.html)

新增于: v6.1.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `true`，则 [`socket.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 已被调用且尚未完成。 它将保持 `true` 直到套接字连接，然后将其设置为 `false` 并触发 `'connect'` 事件。 请注意，[`socket.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 回调是 `'connect'` 事件的监听器。

#### `socket.destroy([error])`[#](http://nodejs.cn/api-v12/net.html#socketdestroyerror)

[中英对照](http://nodejs.cn/api-v12/net/socket_destroy_error.html)

新增于: v0.1.90

-   `error` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

确保此套接字上不再发生 I/O 活动。 销毁流并关闭连接。

有关详细信息，请参阅 [`writable.destroy()`](http://nodejs.cn/api-v12/stream.html#stream_writable_destroy_error)。

#### `socket.destroyed`[#](http://nodejs.cn/api-v12/net.html#socketdestroyed)

[中英对照](http://nodejs.cn/api-v12/net/socket_destroyed.html)

-   [<boolean>](http://url.nodejs.cn/jFbvuT) 指示连接是否被破坏。 一旦连接被破坏，就不能再使用它传输数据。

有关详细信息，请参阅 [`writable.destroyed`](http://nodejs.cn/api-v12/stream.html#stream_writable_destroyed)。

#### `socket.end([data[, encoding]][, callback])`[#](http://nodejs.cn/api-v12/net.html#socketenddata-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/net/socket_end_data_encoding_callback.html)

新增于: v0.1.90

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 仅当数据为 `string` 时使用。 **默认值:** `'utf8'`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 套接字完成时的可选回调。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

半关闭套接字。 即，它发送一个 FIN 数据包。 服务器可能仍会发送一些数据。

有关详细信息，请参阅 [`writable.end()`](http://nodejs.cn/api-v12/stream.html#stream_writable_end_chunk_encoding_callback)。

#### `socket.localAddress`[#](http://nodejs.cn/api-v12/net.html#socketlocaladdress)

[中英对照](http://nodejs.cn/api-v12/net/socket_localaddress.html)

新增于: v0.9.6

-   [<string>](http://url.nodejs.cn/9Tw2bK)

远程客户端连接的本地 IP 地址的字符串表示形式。 例如，在监听 `'0.0.0.0'` 的服务器中，如果客户端连接到 `'192.168.1.1'`，则 `socket.localAddress` 的值将是 `'192.168.1.1'`。

#### `socket.localPort`[#](http://nodejs.cn/api-v12/net.html#socketlocalport)

[中英对照](http://nodejs.cn/api-v12/net/socket_localport.html)

新增于: v0.9.6

-   [<integer>](http://url.nodejs.cn/SXbo1v)

本地端口的数字表示。 例如，`80` 或 `21`。

#### `socket.pause()`[#](http://nodejs.cn/api-v12/net.html#socketpause)

[中英对照](http://nodejs.cn/api-v12/net/socket_pause.html)

-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

暂停读取数据。 也就是说，不会触发 [`'data'`](http://nodejs.cn/api-v12/net.html#net_event_data) 事件。 用于限制上传。

#### `socket.pending`[#](http://nodejs.cn/api-v12/net.html#socketpending)

[中英对照](http://nodejs.cn/api-v12/net/socket_pending.html)

新增于: v11.2.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果套接字尚未连接，则为 `true`，要么是因为 `.connect()` 尚未被调用，要么是因为它仍在连接过程中（参见 [`socket.connecting`](http://nodejs.cn/api-v12/net.html#net_socket_connecting)）。

#### `socket.ref()`[#](http://nodejs.cn/api-v12/net.html#socketref)

[中英对照](http://nodejs.cn/api-v12/net/socket_ref.html)

新增于: v0.9.1

-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

与 `unref()` 相反，如果它是唯一剩下的套接字（默认行为），则在以前的 `unref` 套接字上调用 `ref()` 不会让程序退出。 如果套接字是 `ref` 的，再次调用 `ref` 将无效。

#### `socket.remoteAddress`[#](http://nodejs.cn/api-v12/net.html#socketremoteaddress)

[中英对照](http://nodejs.cn/api-v12/net/socket_remoteaddress.html)

新增于: v0.5.10

-   [<string>](http://url.nodejs.cn/9Tw2bK)

远程 IP 地址的字符串表示形式。 例如，`'74.125.127.100'` 或 `'2001:4860:a005::68'`。 如果套接字被破坏（例如，如果客户端断开连接），则值可能是 `undefined`。

#### `socket.remoteFamily`[#](http://nodejs.cn/api-v12/net.html#socketremotefamily)

[中英对照](http://nodejs.cn/api-v12/net/socket_remotefamily.html)

新增于: v0.11.14

-   [<string>](http://url.nodejs.cn/9Tw2bK)

远程 IP 系列的字符串表示形式。 `'IPv4'` 或 `'IPv6'`。

#### `socket.remotePort`[#](http://nodejs.cn/api-v12/net.html#socketremoteport)

[中英对照](http://nodejs.cn/api-v12/net/socket_remoteport.html)

新增于: v0.5.10

-   [<integer>](http://url.nodejs.cn/SXbo1v)

远程端口的数字表示。 例如，`80` 或 `21`。

#### `socket.resume()`[#](http://nodejs.cn/api-v12/net.html#socketresume)

[中英对照](http://nodejs.cn/api-v12/net/socket_resume.html)

-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

调用 [`socket.pause()`](http://nodejs.cn/api-v12/net.html#net_socket_pause) 后继续读取。

#### `socket.setEncoding([encoding])`[#](http://nodejs.cn/api-v12/net.html#socketsetencodingencoding)

[中英对照](http://nodejs.cn/api-v12/net/socket_setencoding_encoding.html)

新增于: v0.1.90

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

将套接字的编码设置为[可读流](http://nodejs.cn/api-v12/stream.html#stream_class_stream_readable)。 有关详细信息，请参阅 [`readable.setEncoding()`](http://nodejs.cn/api-v12/stream.html#stream_readable_setencoding_encoding)。

#### `socket.setKeepAlive([enable][, initialDelay])`[#](http://nodejs.cn/api-v12/net.html#socketsetkeepaliveenable-initialdelay)

[中英对照](http://nodejs.cn/api-v12/net/socket_setkeepalive_enable_initialdelay.html)

新增于: v0.1.92

-   `enable` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`
-   `initialDelay` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

启用/禁用保持活动功能，并可选择在空闲套接字上发送第一个保持活动探测之前设置初始延迟。

设置 `initialDelay`（以毫秒为单位）以设置接收到的最后一个数据包和第一个保持活动探测之间的延迟。 将 `0` 设置为 `initialDelay` 将使该值与默认（或先前）设置保持不变。

#### `socket.setNoDelay([noDelay])`[#](http://nodejs.cn/api-v12/net.html#socketsetnodelaynodelay)

[中英对照](http://nodejs.cn/api-v12/net/socket_setnodelay_nodelay.html)

新增于: v0.1.90

-   `noDelay` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `true`
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

启用/禁用 Nagle 算法的使用。

创建 TCP 连接时，它将启用 Nagle 算法。

Nagle 的算法在数据通过网络发送之前延迟数据。 它试图以延迟为代价来优化吞吐量。

为 `noDelay` 传入 `true` 或不传入参数将禁用套接字的 Nagle 算法。 为 `noDelay` 传入 `false` 将启用 Nagle 的算法。

#### `socket.setTimeout(timeout[, callback])`[#](http://nodejs.cn/api-v12/net.html#socketsettimeouttimeout-callback)

[中英对照](http://nodejs.cn/api-v12/net/socket_settimeout_timeout_callback.html)

新增于: v0.1.90

-   `timeout` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

将套接字设置为在套接字上 `timeout` 毫秒不活动后超时。 默认情况下 `net.Socket` 没有超时。

当空闲超时被触发时，套接字将收到 [`'timeout'`](http://nodejs.cn/api-v12/net.html#net_event_timeout) 事件，但连接不会被切断。 用户必须手动调用 [`socket.end()`](http://nodejs.cn/api-v12/net.html#net_socket_end_data_encoding_callback) 或 [`socket.destroy()`](http://nodejs.cn/api-v12/net.html#net_socket_destroy_error) 才能结束连接。

```
socket.setTimeout(3000);
socket.on('timeout', () => {
  console.log('socket timeout');
  socket.end();
});
```

如果 `timeout` 为 0，则禁用现有空闲超时。

可选的 `callback` 参数将被添加为 [`'timeout'`](http://nodejs.cn/api-v12/net.html#net_event_timeout) 事件的单次监听器。

#### `socket.unref()`[#](http://nodejs.cn/api-v12/net.html#socketunref)

[中英对照](http://nodejs.cn/api-v12/net/socket_unref.html)

新增于: v0.9.1

-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 套接字自身

如果这是事件系统中唯一的活动套接字，则在套接字上调用 `unref()` 将允许程序退出。 如果套接字已经被 `unref`，则再次调用 `unref()` 将无效。

#### `socket.write(data[, encoding][, callback])`[#](http://nodejs.cn/api-v12/net.html#socketwritedata-encoding-callback)

[中英对照](http://nodejs.cn/api-v12/net/socket_write_data_encoding_callback.html)

新增于: v0.1.90

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 仅当数据为 `string` 时使用。 **默认值:** `utf8`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

在套接字上发送数据。 第二个参数指定字符串情况下的编码。 它默认为 UTF8 编码。

如果整个数据被成功刷新到内核缓冲区，则返回 `true`。 如果所有或部分数据在用户内存中排队，则返回 `false`。 当缓冲区再次空闲时，将触发 [`'drain'`](http://nodejs.cn/api-v12/net.html#net_event_drain)。

可选的 `callback` 参数将在数据最终写完时执行（可能不会立即执行）。

有关更多信息，请参阅 `Writable` 流 [`write()`](http://nodejs.cn/api-v12/stream.html#stream_writable_write_chunk_encoding_callback) 方法。

### `net.connect()`[#](http://nodejs.cn/api-v12/net.html#netconnect)

[中英对照](http://nodejs.cn/api-v12/net/net_connect.html)

[`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection) 的别名。

可能的语法有：

-   [`net.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_connect_options_connectlistener)
-   [`net.connect(path[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_connect_path_connectlistener) 用于 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 连接。
-   [`net.connect(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_connect_port_host_connectlistener) 用于 TCP 连接。

#### `net.connect(options[, connectListener])`[#](http://nodejs.cn/api-v12/net.html#netconnectoptions-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/net_connect_options_connectlistener.html)

新增于: v0.7.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

[`net.createConnection(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_options_connectlistener) 的别名。

#### `net.connect(path[, connectListener])`[#](http://nodejs.cn/api-v12/net.html#netconnectpath-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/net_connect_path_connectlistener.html)

新增于: v0.1.90

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

[`net.createConnection(path[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_path_connectlistener) 的别名。

#### `net.connect(port[, host][, connectListener])`[#](http://nodejs.cn/api-v12/net.html#netconnectport-host-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/net_connect_port_host_connectlistener.html)

新增于: v0.1.90

-   `port` [<number>](http://url.nodejs.cn/SXbo1v)
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

[`net.createConnection(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_port_host_connectlistener) 的别名。

### `net.createConnection()`[#](http://nodejs.cn/api-v12/net.html#netcreateconnection)

[中英对照](http://nodejs.cn/api-v12/net/net_createconnection.html)

工厂函数，其创建新的 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket)，并立即使用 [`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect) 发起连接，然后返回启动连接的 `net.Socket`。

建立连接后，将在返回的套接字上触发 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件。 最后一个参数 `connectListener`（如果提供）将作为 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件的监听器添加一次。

可能的语法有：

-   [`net.createConnection(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_options_connectlistener)
-   [`net.createConnection(path[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_path_connectlistener) 用于 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 连接。
-   [`net.createConnection(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_net_createconnection_port_host_connectlistener) 用于 TCP 连接。

[`net.connect()`](http://nodejs.cn/api-v12/net.html#net_net_connect) 函数是此函数的别名。

#### `net.createConnection(options[, connectListener])`[#](http://nodejs.cn/api-v12/net.html#netcreateconnectionoptions-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/net_createconnection_options_connectlistener.html)

新增于: v0.1.90

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 必需的。 将传给 [`new net.Socket([options])`](http://nodejs.cn/api-v12/net.html#net_new_net_socket_options) 调用和 [`socket.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 方法。
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6) [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection) 函数的通用参数。 如果提供，则将被添加为返回套接字上的 [`'connect'`](http://nodejs.cn/api-v12/net.html#net_event_connect) 事件的监听器一次。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 用于启动连接的新创建的套接字。

有关可用的选项，请参阅 [`new net.Socket([options])`](http://nodejs.cn/api-v12/net.html#net_new_net_socket_options) 和 [`socket.connect(options[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener)。

其他选项：

-   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) 如果设置，则将用于在创建套接字之后但在开始连接之前调用 [`socket.setTimeout(timeout)`](http://nodejs.cn/api-v12/net.html#net_socket_settimeout_timeout_callback)。

以下是 [`net.createServer()`](http://nodejs.cn/api-v12/net.html#net_net_createserver_options_connectionlistener) 部分中描述的回显服务器的客户端示例：

```
const net = require('net');
const client = net.createConnection({ port: 8124 }, () => {
  // 'connect' 监听器。
  console.log('connected to server!');
  client.write('world!\r\n');
});
client.on('data', (data) => {
  console.log(data.toString());
  client.end();
});
client.on('end', () => {
  console.log('disconnected from server');
});
```

连接套接字 `/tmp/echo.sock`：

```
const client = net.createConnection({ path: '/tmp/echo.sock' });
```

#### `net.createConnection(path[, connectListener])`[#](http://nodejs.cn/api-v12/net.html#netcreateconnectionpath-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/net_createconnection_path_connectlistener.html)

新增于: v0.1.90

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 套接字应连接到的路径。 将传给 [`socket.connect(path[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_path_connectlistener)。 请参阅[标识 IPC 连接的路径](http://nodejs.cn/api-v12/net.html#net_identifying_paths_for_ipc_connections)。
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6) [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection) 函数的通用参数，对发起套接字上的 `'connect'` 事件的单次监听器。 将传给 [`socket.connect(path[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_path_connectlistener)。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 用于启动连接的新创建的套接字。

发起 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 连接。

此函数创建新的 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket)，所有选项都设置为默认值，立即启动与 [`socket.connect(path[, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_path_connectlistener) 的连接，然后返回启动连接的 `net.Socket`。

#### `net.createConnection(port[, host][, connectListener])`[#](http://nodejs.cn/api-v12/net.html#netcreateconnectionport-host-connectlistener)

[中英对照](http://nodejs.cn/api-v12/net/net_createconnection_port_host_connectlistener.html)

新增于: v0.1.90

-   `port` [<number>](http://url.nodejs.cn/SXbo1v) 套接字应连接到的端口。 将传给 [`socket.connect(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_port_host_connectlistener)。
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 套接字应连接到的主机。 将传给 [`socket.connect(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_port_host_connectlistener)。 **默认值:** `'localhost'`。
-   `connectListener` [<Function>](http://url.nodejs.cn/ceTQa6) [`net.createConnection()`](http://nodejs.cn/api-v12/net.html#net_net_createconnection) 函数的通用参数，对发起套接字上的 `'connect'` 事件的单次监听器。 将传给 [`socket.connect(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_port_host_connectlistener)。
-   返回: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) 用于启动连接的新创建的套接字。

发起 TCP 连接。

此函数创建新的 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket)，所有选项都设置为默认值，立即启动与 [`socket.connect(port[, host][, connectListener])`](http://nodejs.cn/api-v12/net.html#net_socket_connect_port_host_connectlistener) 的连接，然后返回启动连接的 `net.Socket`。

### `net.createServer([options][, connectionListener])`[#](http://nodejs.cn/api-v12/net.html#netcreateserveroptions-connectionlistener)

[中英对照](http://nodejs.cn/api-v12/net/net_createserver_options_connectionlistener.html)

新增于: v0.5.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `allowHalfOpen` [<boolean>](http://url.nodejs.cn/jFbvuT) **默认值:** `false`。
    -   `pauseOnConnect` [<boolean>](http://url.nodejs.cn/jFbvuT) 指示是否应在传入连接上暂停套接字。 **默认值:** `false`。
-   `connectionListener` [<Function>](http://url.nodejs.cn/ceTQa6) 自动设置为 [`'connection'`](http://nodejs.cn/api-v12/net.html#net_event_connection) 事件的监听器。
-   返回: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

创建新的 TCP 或 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 服务器。

有关更多信息，请参阅 [`'end'`](http://nodejs.cn/api-v12/net.html#net_event_end) 事件和 [RFC 1122](http://url.nodejs.cn/tLsNn9)（第 4.2.2.13 章节）。

如果 `pauseOnConnect` 设置为 `true`，则与每个传入连接关联的套接字将被暂停，并且不会从其句柄读取数据。 这允许在进程之间传递连接，而原始进程不会读取任何数据。 要开始从暂停的套接字读取数据，则调用 [`socket.resume()`](http://nodejs.cn/api-v12/net.html#net_socket_resume)。

服务器可以是 TCP 服务器或 [IPC](http://nodejs.cn/api-v12/net.html#net_ipc_support) 服务器，这取决于其 [`listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 什么。

以下是 TCP 回显服务器的示例，它监听端口 8124 上的连接：

```
const net = require('net');
const server = net.createServer((c) => {
  // 'connection' 监听器。
  console.log('client connected');
  c.on('end', () => {
    console.log('client disconnected');
  });
  c.write('hello\r\n');
  c.pipe(c);
});
server.on('error', (err) => {
  throw err;
});
server.listen(8124, () => {
  console.log('server bound');
});
```

使用 `telnet` 对此进行测试：

```
$ telnet localhost 8124
```

要监听套接字 `/tmp/echo.sock`：

```
server.listen('/tmp/echo.sock', () => {
  console.log('server bound');
});
```

使用 `nc` 连接到 Unix 域套接字服务器：

```
$ nc -U /tmp/echo.sock
```

### `net.isIP(input)`[#](http://nodejs.cn/api-v12/net.html#netisipinput)

[中英对照](http://nodejs.cn/api-v12/net/net_isip_input.html)

新增于: v0.3.0

-   `input` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

测试输入是否为 IP 地址。 对于无效字符串返回 `0`，对于 IP 版本 4 的地址返回 `4`，对于 IP 版本 6 的地址返回 `6`。

### `net.isIPv4(input)`[#](http://nodejs.cn/api-v12/net.html#netisipv4input)

[中英对照](http://nodejs.cn/api-v12/net/net_isipv4_input.html)

新增于: v0.3.0

-   `input` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果输入是版本 4 的 IP 地址，则返回 `true`，否则返回 `false`。

### `net.isIPv6(input)`[#](http://nodejs.cn/api-v12/net.html#netisipv6input)

[中英对照](http://nodejs.cn/api-v12/net/net_isipv6_input.html)

新增于: v0.3.0

-   `input` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果输入是版本 6 的 IP 地址，则返回 `true`，否则返回 `false`。
