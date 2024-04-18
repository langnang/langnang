---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/dgram.html
author: 
---

# dgram 数据报 | Node.js API 文档

> ## Excerpt
> 中英对照

---
### `dgram.Socket` 类[#](http://nodejs.cn/api-v12/dgram.html#class-dgramsocket)

[中英对照](http://nodejs.cn/api-v12/dgram/class_dgram_socket.html)

新增于: v0.1.99

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

封装数据报功能。

`dgram.Socket` 的新实例是使用 [`dgram.createSocket()`](http://nodejs.cn/api-v12/dgram.html#dgram_dgram_createsocket_options_callback) 创建的。 `new` 关键字不能用于创建 `dgram.Socket` 实例。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/dgram.html#event-close)

[中英对照](http://nodejs.cn/api-v12/dgram/event_close.html)

新增于: v0.1.99

在使用 [`close()`](http://nodejs.cn/api-v12/dgram.html#dgram_socket_close_callback) 关闭套接字后会触发 `'close'` 事件。 一旦触发，则此套接字上将不会触发新的 `'message'` 事件。

#### `'connect'` 事件[#](http://nodejs.cn/api-v12/dgram.html#event-connect)

[中英对照](http://nodejs.cn/api-v12/dgram/event_connect.html)

新增于: v12.0.0

`'connect'` 事件在套接字关联到远程地址作为成功的 [`connect()`](http://nodejs.cn/api-v12/dgram.html#dgram_socket_connect_port_address_callback) 调用的结果之后触发。

#### `'error'` 事件[#](http://nodejs.cn/api-v12/dgram.html#event-error)

[中英对照](http://nodejs.cn/api-v12/dgram/event_error.html)

新增于: v0.1.99

-   `exception` [<Error>](http://url.nodejs.cn/qZ873x)

每当发生任何错误时都会触发 `'error'` 事件。 事件句柄被传入单一的 `Error` 对象。

#### `'listening'` 事件[#](http://nodejs.cn/api-v12/dgram.html#event-listening)

[中英对照](http://nodejs.cn/api-v12/dgram/event_listening.html)

新增于: v0.1.99

一旦 `dgram.Socket` 可寻址并且可以接收数据，则会触发 `'listening'` 事件。 这会在 `socket.bind()` 中显式地发生，或者在第一次使用 `socket.send()` 发送数据时隐式地发生。 直到 `dgram.Socket` 正在监听，底层系统资源不存在，则调用 `socket.address()` 和 `socket.setTTL()` 等将失败。

#### `'message'` 事件[#](http://nodejs.cn/api-v12/dgram.html#event-message)

[中英对照](http://nodejs.cn/api-v12/dgram/event_message.html)

新增于: v0.1.99

当套接字上有新的数据报可用时，则会触发 `'message'` 事件。 事件句柄传入了两个参数：`msg` 和 `rinfo`。

-   `msg` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 消息。
-   `rinfo` [<Object>](http://url.nodejs.cn/jzn6Ao) 远程地址信息。
    -   `address` [<string>](http://url.nodejs.cn/9Tw2bK) 发送者地址。
    -   `family` [<string>](http://url.nodejs.cn/9Tw2bK) 地址族（`'IPv4'` 或 `'IPv6'`）。
    -   `port` [<number>](http://url.nodejs.cn/SXbo1v) 发送者端口。
    -   `size` [<number>](http://url.nodejs.cn/SXbo1v) 消息大小。

如果传入数据包的源地址是 IPv6 链路本地地址，则将接口名称添加到 `address`。 例如，在 `en0` 接口上接收的数据包可能将地址字段设置为 `'fe80::2618:1234:ab11:3b9c%en0'`，其中 `'%en0'` 是作为区域 ID 后缀的接口名称。

#### `socket.addMembership(multicastAddress[, multicastInterface])`[#](http://nodejs.cn/api-v12/dgram.html#socketaddmembershipmulticastaddress-multicastinterface)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_addmembership_multicastaddress_multicastinterface.html)

新增于: v0.6.9

-   `multicastAddress` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `multicastInterface` [<string>](http://url.nodejs.cn/9Tw2bK)

使用 `IP_ADD_MEMBERSHIP` 套接字选项告诉内核在给定的 `multicastAddress` 和 `multicastInterface` 上加入多播组。 如果未指定 `multicastInterface` 参数，则操作系统将选择一个接口并为其添加成员资格。 要为每个可用接口添加成员资格，则多次调用 `addMembership`，每个接口一次。

当在未绑定的套接字上调用时，则此方法将隐式地绑定到随机端口，监听所有接口。

当在多个 `cluster` 工作进程共享 UDP 套接字时，则必须只调用一次 `socket.addMembership()` 函数，否则会发生 `EADDRINUSE` 错误：

```
const cluster = require('cluster');
const dgram = require('dgram');
if (cluster.isMaster) {
  cluster.fork(); // 工作正常。
  cluster.fork(); // EADDRINUSE 失败。
} else {
  const s = dgram.createSocket('udp4');
  s.bind(1234, () => {
    s.addMembership('224.0.0.114');
  });
}
```

#### `socket.addSourceSpecificMembership(sourceAddress, groupAddress[, multicastInterface])`[#](http://nodejs.cn/api-v12/dgram.html#socketaddsourcespecificmembershipsourceaddress-groupaddress-multicastinterface)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_addsourcespecificmembership_sourceaddress_groupaddress_multicastinterface.html)

新增于: v12.16.0

-   `sourceAddress` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `groupAddress` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `multicastInterface` [<string>](http://url.nodejs.cn/9Tw2bK)

告诉内核在给定的 `sourceAddress` 和 `groupAddress` 上加入特定于源的多播频道，使用 `multicastInterface` 和 `IP_ADD_SOURCE_MEMBERSHIP` 套接字选项。 如果未指定 `multicastInterface` 参数，则操作系统将选择一个接口并为其添加成员资格。 要为每个可用接口添加成员资格，则多次调用 `socket.addSourceSpecificMembership()`，每个接口一次。

当在未绑定的套接字上调用时，则此方法将隐式地绑定到随机端口，监听所有接口。

#### `socket.address()`[#](http://nodejs.cn/api-v12/dgram.html#socketaddress)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_address.html)

新增于: v0.1.99

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回包含套接字地址信息的对象。 对于 UDP 套接字，此对象将包含 `address`、`family` 和 `port` 属性。

如果在未绑定的套接字上调用此方法将抛出 `EBADF`。

#### `socket.bind([port][, address][, callback])`[#](http://nodejs.cn/api-v12/dgram.html#socketbindport-address-callback)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_bind_port_address_callback.html)

-   `port` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `address` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 没有参数。 当绑定完成时调用。

对于 UDP 套接字，使 `dgram.Socket` 在命名的 `port` 和可选的 `address` 上监听数据报消息。 如果未指定 `port` 或 `0`，则操作系统将尝试绑定到随机端口。 如果未指定 `address`，则操作系统将尝试监听所有地址。 一旦绑定完成，则会触发 `'listening'` 事件并调用可选的 `callback` 函数。

同时指定 `'listening'` 事件监听器并将 `callback` 传给 `socket.bind()` 方法无害但不是很有用。

绑定的数据报套接字使 Node.js 进程保持运行以接收数据报消息。

如果绑定失败，则生成 `'error'` 事件。 在极少数情况下（例如，尝试与关闭的套接字绑定），可能会抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。

UDP 服务器监听端口 41234 的示例：

```
const dgram = require('dgram');
const server = dgram.createSocket('udp4');

server.on('error', (err) => {
  console.log(`server error:\n${err.stack}`);
  server.close();
});

server.on('message', (msg, rinfo) => {
  console.log(`server got: ${msg} from ${rinfo.address}:${rinfo.port}`);
});

server.on('listening', () => {
  const address = server.address();
  console.log(`server listening ${address.address}:${address.port}`);
});

server.bind(41234);
// 打印: server listening 0.0.0.0:41234
```

#### `socket.bind(options[, callback])`[#](http://nodejs.cn/api-v12/dgram.html#socketbindoptions-callback)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_bind_options_callback.html)

新增于: v0.11.14

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 必需的。 支持以下属性：
    -   `port` [<integer>](http://url.nodejs.cn/SXbo1v)
    -   `address` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `exclusive` [<boolean>](http://url.nodejs.cn/jFbvuT)
    -   `fd` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

对于 UDP 套接字，使 `dgram.Socket` 监听命名 `port` 和可选 `address` 上的数据报消息，这些消息作为作为第一个参数传入的 `options` 对象的属性传入。 如果未指定 `port` 或 `0`，则操作系统将尝试绑定到随机端口。 如果未指定 `address`，则操作系统将尝试监听所有地址。 一旦绑定完成，则会触发 `'listening'` 事件并调用可选的 `callback` 函数。

`options` 对象可能包含 `fd` 属性。 当设置了大于 `0` 的 `fd` 时，则将使用给定的文件描述符环绕现有的套接字。 在这种情况下，`port` 和 `address` 的属性将被忽略。

同时指定 `'listening'` 事件监听器并将 `callback` 传给 `socket.bind()` 方法无害但不是很有用。

`options` 对象可能包含额外的 `exclusive` 属性，当将 `dgram.Socket` 对象与 [`cluster`](http://nodejs.cn/api-v12/cluster.html) 模块一起使用时会使用该属性。 当 `exclusive` 设置为 `false`（默认）时，集群工作进程将使用相同的底层套接字句柄，允许共享连接处理职责。 但是，当 `exclusive` 为 `true` 时，则句柄未共享，尝试共享端口会导致错误。

绑定的数据报套接字使 Node.js 进程保持运行以接收数据报消息。

如果绑定失败，则生成 `'error'` 事件。 在极少数情况下（例如，尝试与关闭的套接字绑定），可能会抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。

监听独占端口的套接字示例如下所示。

```
socket.bind({
  address: 'localhost',
  port: 8000,
  exclusive: true
});
```

#### `socket.close([callback])`[#](http://nodejs.cn/api-v12/dgram.html#socketclosecallback)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_close_callback.html)

新增于: v0.1.99

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当套接字关闭时调用。

关闭底层套接字并停止监听其上的数据。 如果提供回调，则将其添加为 [`'close'`](http://nodejs.cn/api-v12/dgram.html#dgram_event_close) 事件的监听器。

#### `socket.connect(port[, address][, callback])`[#](http://nodejs.cn/api-v12/dgram.html#socketconnectport-address-callback)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_connect_port_address_callback.html)

新增于: v12.0.0

-   `port` [<integer>](http://url.nodejs.cn/SXbo1v)
-   `address` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当连接完成或出错时调用。

将 `dgram.Socket` 关联到远程地址和端口。 此句柄发送的每条消息都会自动发送到该目标。 此外，套接字将只接收来自该远程对等方的消息。 尝试在已连接的套接字上调用 `connect()` 将导致 [`ERR_SOCKET_DGRAM_IS_CONNECTED`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_dgram_is_connected) 异常。 如果未提供 `address`，则默认使用 `'127.0.0.1'`（适用于 `udp4` 套接字）或 `'::1'`（适用于 `udp6` 套接字）。 一旦连接完成，就会触发 `'connect'` 事件并调用可选的 `callback` 函数。 如果失败，则调用 `callback`，或者触发 `'error'` 事件。

#### `socket.disconnect()`[#](http://nodejs.cn/api-v12/dgram.html#socketdisconnect)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_disconnect.html)

新增于: v12.0.0

将连接的 `dgram.Socket` 与其远程地址分离的同步函数。 尝试在未绑定或已断开连接的套接字上调用 `disconnect()` 将导致 [`ERR_SOCKET_DGRAM_NOT_CONNECTED`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_dgram_not_connected) 异常。

#### `socket.dropMembership(multicastAddress[, multicastInterface])`[#](http://nodejs.cn/api-v12/dgram.html#socketdropmembershipmulticastaddress-multicastinterface)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_dropmembership_multicastaddress_multicastinterface.html)

新增于: v0.6.9

-   `multicastAddress` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `multicastInterface` [<string>](http://url.nodejs.cn/9Tw2bK)

指示内核使用 `IP_DROP_MEMBERSHIP` 套接字选项离开 `multicastAddress` 处的多播组。 当套接字关闭或进程终止时，内核会自动调用此方法，因此大多数应用程序永远没有理由调用此方法。

如果未指定 `multicastInterface`，则操作系统将尝试删除所有有效接口上的成员资格。

#### `socket.dropSourceSpecificMembership(sourceAddress, groupAddress[, multicastInterface])`[#](http://nodejs.cn/api-v12/dgram.html#socketdropsourcespecificmembershipsourceaddress-groupaddress-multicastinterface)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_dropsourcespecificmembership_sourceaddress_groupaddress_multicastinterface.html)

新增于: v12.16.0

-   `sourceAddress` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `groupAddress` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `multicastInterface` [<string>](http://url.nodejs.cn/9Tw2bK)

指示内核使用 `IP_DROP_SOURCE_MEMBERSHIP` 套接字选项在给定的 `sourceAddress` 和 `groupAddress` 处保留特定于源的多播通道。 当套接字关闭或进程终止时，内核会自动调用此方法，因此大多数应用程序永远没有理由调用此方法。

如果未指定 `multicastInterface`，则操作系统将尝试删除所有有效接口上的成员资格。

#### `socket.getRecvBufferSize()`[#](http://nodejs.cn/api-v12/dgram.html#socketgetrecvbuffersize)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_getrecvbuffersize.html)

新增于: v8.7.0

-   返回: [<number>](http://url.nodejs.cn/SXbo1v) `SO_RCVBUF` 套接字接收缓冲区大小（以字节为单位）。

如果在未绑定的套接字上调用此方法将抛出 [`ERR_SOCKET_BUFFER_SIZE`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_buffer_size)。

#### `socket.getSendBufferSize()`[#](http://nodejs.cn/api-v12/dgram.html#socketgetsendbuffersize)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_getsendbuffersize.html)

新增于: v8.7.0

-   返回: [<number>](http://url.nodejs.cn/SXbo1v) `SO_SNDBUF` 套接字发送缓冲区大小（以字节为单位）。

如果在未绑定的套接字上调用此方法将抛出 [`ERR_SOCKET_BUFFER_SIZE`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_buffer_size)。

#### `socket.ref()`[#](http://nodejs.cn/api-v12/dgram.html#socketref)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_ref.html)

新增于: v0.9.1

-   返回: [<dgram.Socket>](http://nodejs.cn/api/dgram.html#class-dgramsocket)

默认情况下，只要套接字处于打开状态，则绑定套接字将导致它阻止 Node.js 进程退出。 `socket.unref()` 方法可用于从保持 Node.js 进程处于活动状态的引用计数中排除套接字。 `socket.ref()` 方法将套接字添加回引用计数并恢复默认行为。

多次调用 `socket.ref()` 不会有额外的效果。

`socket.ref()` 方法返回对套接字的引用，因此可以链接调用。

#### `socket.remoteAddress()`[#](http://nodejs.cn/api-v12/dgram.html#socketremoteaddress)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_remoteaddress.html)

新增于: v12.0.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回包含远程端点的 `address`、`family` 和 `port` 的对象。 如果套接字未连接，则此方法将抛出 [`ERR_SOCKET_DGRAM_NOT_CONNECTED`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_dgram_not_connected) 异常。

#### `socket.send(msg[, offset, length][, port][, address][, callback])`[#](http://nodejs.cn/api-v12/dgram.html#socketsendmsg-offset-length-port-address-callback)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_send_msg_offset_length_port_address_callback.html)

-   `msg` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<Array>](http://url.nodejs.cn/ZJSz23) 要发送的消息。
-   `offset` [<integer>](http://url.nodejs.cn/SXbo1v) 消息开始的缓冲区中的偏移量。
-   `length` [<integer>](http://url.nodejs.cn/SXbo1v) 消息中的字节数。
-   `port` [<integer>](http://url.nodejs.cn/SXbo1v) 目标端口。
-   `address` [<string>](http://url.nodejs.cn/9Tw2bK) 目标主机名或 IP 地址。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当消息发送后调用。

在套接字上广播数据报。 对于无连接套接字，则必须指定目标 `port` 和 `address`。 另一方面，已连接的套接字将使用其关联的远程端点，因此不得设置 `port` 和 `address` 参数。

`msg` 参数包含要发送的消息。 根据其类型，可以应用不同的行为。 如果 `msg` 是 `Buffer`、任何 `TypedArray` 或 `DataView`，则 `offset` 和 `length` 分别指定消息开始的 `Buffer` 中的偏移量和消息中的字节数。 如果 `msg` 是 `String`，则会自动转换为 `'utf8'` 编码的 `Buffer`。 对于包含多字节字符的消息，`offset` 和 `length` 将根据[字节长度](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_bytelength_string_encoding)而不是字符位置进行计算。 如果 `msg` 是数组，则不能指定 `offset` 和 `length`。

`address` 参数是字符串。 如果 `address` 的值是主机名，则会使用 DNS 解析主机地址。 如果未提供 `address` 或其他错误，则默认情况下将使用 `'127.0.0.1'`（用于 `udp4` 套接字）或 `'::1'`（用于 `udp6` 套接字）。

如果套接字之前没有绑定过对 `bind` 的调用，则该套接字会被分配随机端口号并绑定到“所有接口”地址（`'0.0.0.0'` 用于 `udp4` 套接字，`'::0'` 用于 `udp6` 套接字。）

可以指定可选的 `callback` 函数作为报告 DNS 错误或确定何时可以安全地重用 `buf` 对象的一种方式。 DNS 查找延迟了 Node.js 事件循环的至少一滴答的发送时间。

确定数据报已发送的唯一方法是使用 `callback`。 如果发生错误并给出 `callback`，则错误将作为第一个参数传给 `callback`。 如果未给出 `callback`，则错误将作为 `socket` 对象上的 `'error'` 事件触发。

偏移量和长度是可选的，但如果使用任何一个，则必须都设置。 仅当第一个参数是 `Buffer`、`TypedArray` 或 `DataView` 时才支持它们。

如果在未绑定的套接字上调用此方法将抛出 [`ERR_SOCKET_BAD_PORT`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_bad_port)。

发送 UDP 包到 `localhost` 端口的示例；

```
const dgram = require('dgram');
const message = Buffer.from('Some bytes');
const client = dgram.createSocket('udp4');
client.send(message, 41234, 'localhost', (err) => {
  client.close();
});
```

发送由多个缓冲区组成的 UDP 数据包到 `127.0.0.1` 上的端口的示例；

```
const dgram = require('dgram');
const buf1 = Buffer.from('Some ');
const buf2 = Buffer.from('bytes');
const client = dgram.createSocket('udp4');
client.send([buf1, buf2], 41234, (err) => {
  client.close();
});
```

发送多个缓冲区可能更快或更慢，这取决于应用程序和操作系统。 运行基准测试以根据具体情况确定最佳策略。 但是，一般来说，发送多个缓冲区会更快。

使用连接到 `localhost` 端口的套接字发送 UDP 数据包的示例：

```
const dgram = require('dgram');
const message = Buffer.from('Some bytes');
const client = dgram.createSocket('udp4');
client.connect(41234, 'localhost', (err) => {
  client.send(message, (err) => {
    client.close();
  });
});
```

##### 关于 UDP 数据报大小的说明[#](http://nodejs.cn/api-v12/dgram.html#note-about-udp-datagram-size)

[中英对照](http://nodejs.cn/api-v12/dgram/note_about_udp_datagram_size.html)

IPv4/v6 数据报的最大大小取决于 `MTU`（最大传输单元）和 `Payload Length` 字段大小。

-   `Payload Length` 字段是 16 位宽，这意味着正常的有效载荷不能超过 64K 八位字节，包括互联网标头和数据（65,507 字节 = 65,535 − 8 字节 UDP 标头 − 20 字节 IP 标头）；这对于环回接口通常是正确的，但是如此长的数据报消息对于大多数主机和网络来说是不切实际的。
    
-   `MTU` 是给定链路层技术可以支持数据报消息的最大尺寸。 对于任何链接，IPv4 要求至少 `MTU` 为 68 个八位字节，而建议 IPv4 的 `MTU` 为 576（通常建议为拨号类型应用程序的 `MTU`），无论它们是完整的还是分段的。
    
    对于 IPv6，最小 `MTU` 是 1280 个八位字节。 但是，强制的最小片段重组缓冲区大小是 1500 个八位字节。 68 个八位字节的值非常小，因为大多数当前的链路层技术，如以太网，最小 `MTU` 为 1500。
    

不可能事先知道数据包可能通过的每个链路的 MTU。 发送大于接收方 `MTU` 的数据报将不起作用，因为数据包将被悄悄丢弃，而不会通知源数据未到达其预期接收方。

#### `socket.setBroadcast(flag)`[#](http://nodejs.cn/api-v12/dgram.html#socketsetbroadcastflag)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_setbroadcast_flag.html)

新增于: v0.6.9

-   `flag` [<boolean>](http://url.nodejs.cn/jFbvuT)

设置或清除 `SO_BROADCAST` 套接字选项。 当设置为 `true` 时，UDP 数据包可能会被发送到本地接口的广播地址。

如果在未绑定的套接字上调用此方法将抛出 `EBADF`。

#### `socket.setMulticastInterface(multicastInterface)`[#](http://nodejs.cn/api-v12/dgram.html#socketsetmulticastinterfacemulticastinterface)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_setmulticastinterface_multicastinterface.html)

新增于: v8.6.0

-   `multicastInterface` [<string>](http://url.nodejs.cn/9Tw2bK)

_本节中对范围的所有引用均指 [IPv6 区域索引](http://url.nodejs.cn/8e3ofa)，由 [RFC 4007](http://url.nodejs.cn/NoPgna) 定义。 以字符串形式，具有作用域索引的 IP 写成 `'IP%scope'`，其中作用域是接口名称或接口编号。_

将套接字的默认传出多播接口设置为选定接口或返回系统接口选择。 `multicastInterface` 必须是来自套接字家族的 IP 的有效字符串表示形式。

对于 IPv4 套接字，这应该是为所需物理接口配置的 IP。 在套接字上发送到多播的所有数据包都将在最近成功使用此调用确定的接口上发送。

对于 IPv6 套接字，`multicastInterface` 应包括范围来指示接口，如以下示例中所示。 在 IPv6 中，单个 `send` 调用也可以在地址中使用显式范围，因此只有发送到多播地址而未指定显式范围的数据包才会受到最近成功使用此调用的影响。

如果在未绑定的套接字上调用此方法将抛出 `EBADF`。

##### IPv6 发送多播数据包[#](http://nodejs.cn/api-v12/dgram.html#example-ipv6-outgoing-multicast-interface)

[中英对照](http://nodejs.cn/api-v12/dgram/example_ipv6_outgoing_multicast_interface.html)

在大多数系统上，范围格式使用接口名称：

```
const socket = dgram.createSocket('udp6');

socket.bind(1234, () => {
  socket.setMulticastInterface('::%eth1');
});
```

在 Windows 上，范围格式使用接口编号：

```
const socket = dgram.createSocket('udp6');

socket.bind(1234, () => {
  socket.setMulticastInterface('::%2');
});
```

##### IPv4 发送多播数据包[#](http://nodejs.cn/api-v12/dgram.html#example-ipv4-outgoing-multicast-interface)

[中英对照](http://nodejs.cn/api-v12/dgram/example_ipv4_outgoing_multicast_interface.html)

所有系统都在所需的物理接口上使用主机的 IP：

```
const socket = dgram.createSocket('udp4');

socket.bind(1234, () => {
  socket.setMulticastInterface('10.0.0.2');
});
```

##### 调用的结果[#](http://nodejs.cn/api-v12/dgram.html#call-results)

[中英对照](http://nodejs.cn/api-v12/dgram/call_results.html)

对未准备好发送或不再打开的套接字的调用可能会抛出 _Not running_ [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。

如果无法将 `multicastInterface` 解析为 IP，则抛出 _EINVAL_ [`System Error`](http://nodejs.cn/api-v12/errors.html#errors_class_systemerror)。

在 IPv4 上，如果 `multicastInterface` 是有效地址但与任何接口都不匹配，或者如果地址与系列不匹配，则抛出 [`System Error`](http://nodejs.cn/api-v12/errors.html#errors_class_systemerror)，例如 `EADDRNOTAVAIL` 或 `EPROTONOSUP`。

在 IPv6 上，大多数指定或省略范围的错误将导致套接字继续使用（或返回）系统的默认接口选择。

套接字地址族的任何地址（IPv4 `'0.0.0.0'` 或 IPv6 `'::'`）可用于将套接字默认传出接口的控制权返回给系统，以便将来使用多播数据包。

#### `socket.setMulticastLoopback(flag)`[#](http://nodejs.cn/api-v12/dgram.html#socketsetmulticastloopbackflag)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_setmulticastloopback_flag.html)

新增于: v0.3.8

-   `flag` [<boolean>](http://url.nodejs.cn/jFbvuT)

设置或清除 `IP_MULTICAST_LOOP` 套接字选项。 当设置为 `true` 时，本地接口也会收到多播数据包。

如果在未绑定的套接字上调用此方法将抛出 `EBADF`。

#### `socket.setMulticastTTL(ttl)`[#](http://nodejs.cn/api-v12/dgram.html#socketsetmulticastttlttl)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_setmulticastttl_ttl.html)

新增于: v0.3.8

-   `ttl` [<integer>](http://url.nodejs.cn/SXbo1v)

设置 `IP_MULTICAST_TTL` 套接字选项。 虽然 TTL 通常代表 "生存时间"，但在此上下文中，它指定了允许数据包通过的 IP 跃点数，特别是对于多播流量。 转发数据包的每个路由器或网关都会递减 TTL。 如果 TTL 被路由器递减为 0，则不会转发。

`ttl` 参数可以是 0 到 255 之间。 大多数系统上的默认值为 `1`。

如果在未绑定的套接字上调用此方法将抛出 `EBADF`。

#### `socket.setRecvBufferSize(size)`[#](http://nodejs.cn/api-v12/dgram.html#socketsetrecvbuffersizesize)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_setrecvbuffersize_size.html)

新增于: v8.7.0

-   `size` [<integer>](http://url.nodejs.cn/SXbo1v)

设置 `SO_RCVBUF` 套接字选项。 设置最大套接字接收缓冲区（以字节为单位）。

如果在未绑定的套接字上调用此方法将抛出 [`ERR_SOCKET_BUFFER_SIZE`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_buffer_size)。

#### `socket.setSendBufferSize(size)`[#](http://nodejs.cn/api-v12/dgram.html#socketsetsendbuffersizesize)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_setsendbuffersize_size.html)

新增于: v8.7.0

-   `size` [<integer>](http://url.nodejs.cn/SXbo1v)

设置 `SO_SNDBUF` 套接字选项。 设置最大套接字发送缓冲区（以字节为单位）。

如果在未绑定的套接字上调用此方法将抛出 [`ERR_SOCKET_BUFFER_SIZE`](http://nodejs.cn/api-v12/errors.html#errors_err_socket_buffer_size)。

#### `socket.setTTL(ttl)`[#](http://nodejs.cn/api-v12/dgram.html#socketsetttlttl)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_setttl_ttl.html)

新增于: v0.1.101

-   `ttl` [<integer>](http://url.nodejs.cn/SXbo1v)

设置 `IP_TTL` 套接字选项。 虽然 TTL 通常代表"生存时间"，但在此上下文中，它指定了允许数据包通过的 IP 跃点数。 转发数据包的每个路由器或网关都会递减 TTL。 如果 TTL 被路由器递减为 0，则不会转发。 更改 TTL 值通常用于网络探测或多播。

`ttl` 参数可以是 1 到 255 之间。 大多数系统的默认值为 64。

如果在未绑定的套接字上调用此方法将抛出 `EBADF`。

#### `socket.unref()`[#](http://nodejs.cn/api-v12/dgram.html#socketunref)

[中英对照](http://nodejs.cn/api-v12/dgram/socket_unref.html)

新增于: v0.9.1

-   返回: [<dgram.Socket>](http://nodejs.cn/api/dgram.html#class-dgramsocket)

默认情况下，只要套接字处于打开状态，则绑定套接字将导致它阻止 Node.js 进程退出。 `socket.unref()` 方法可用于将套接字从保持 Node.js 进程处于活动状态的引用计数中排除，即使套接字仍在监听，也允许进程退出。

多次调用 `socket.unref()` 没有附加效果。

`socket.unref()` 方法返回对套接字的引用，因此可以链接调用。
