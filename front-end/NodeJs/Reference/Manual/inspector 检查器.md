---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/inspector.html
author: 
---

# inspector 检查器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/inspector/inspector.html)

**源代码:** [lib/inspector.js](https://github.com/nodejs/node/blob/v12.22.12/lib/inspector.js)

`inspector` 模块提供了与 V8 检查器交互的 API。

可以使用以下方式访问它：

```
const inspector = require('inspector');
```

### `inspector.close()`[#](http://nodejs.cn/api-v12/inspector.html#inspectorclose)

[中英对照](http://nodejs.cn/api-v12/inspector/inspector_close.html)

停用检查器。 阻塞直到没有活动连接。

### `inspector.console`[#](http://nodejs.cn/api-v12/inspector.html#inspectorconsole)

[中英对照](http://nodejs.cn/api-v12/inspector/inspector_console.html)

-   [<Object>](http://url.nodejs.cn/jzn6Ao) 向远程检查器控制台发送消息的对象。

```
require('inspector').console.log('a message');
```

检查器控制台没有与 Node.js 控制台的 API 奇偶校验。

### `inspector.open([port[, host[, wait]]])`[#](http://nodejs.cn/api-v12/inspector.html#inspectoropenport-host-wait)

[中英对照](http://nodejs.cn/api-v12/inspector/inspector_open_port_host_wait.html)

-   `port` [<number>](http://url.nodejs.cn/SXbo1v) 监听检查器连接的端口。 可选的。 **默认值:** 命令行上指定的内容。
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 主机监听检查器连接。 可选的。 **默认值:** 命令行上指定的内容。
-   `wait` [<boolean>](http://url.nodejs.cn/jFbvuT) 在客户端连接之前阻塞。 可选的。 **默认值:** `false`。

在主机和端口上激活检查器。 相当于 `node --inspect=[[host:]port]`，但可以在 node 启动后以编程方式完成。

如果等待为 `true`，则将阻塞直到客户端连接到检查端口并且流量控制已传给调试器客户端。

### `inspector.url()`[#](http://nodejs.cn/api-v12/inspector.html#inspectorurl)

[中英对照](http://nodejs.cn/api-v12/inspector/inspector_url.html)

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<undefined>](http://url.nodejs.cn/8ym6ow)

返回活动检查器的网址，如果没有，则返回 `undefined`。

```
$ node --inspect -p 'inspector.url()'
Debugger listening on ws://127.0.0.1:9229/166e272e-7a30-4d09-97ce-f1c012b43c34
For help see https://nodejs.org/en/docs/inspector
ws://127.0.0.1:9229/166e272e-7a30-4d09-97ce-f1c012b43c34

$ node --inspect=localhost:3000 -p 'inspector.url()'
Debugger listening on ws://localhost:3000/51cf8d0e-3c36-4c59-8efd-54519839e56a
For help see https://nodejs.org/en/docs/inspector
ws://localhost:3000/51cf8d0e-3c36-4c59-8efd-54519839e56a

$ node -p 'inspector.url()'
undefined
```

### `inspector.waitForDebugger()`[#](http://nodejs.cn/api-v12/inspector.html#inspectorwaitfordebugger)

[中英对照](http://nodejs.cn/api-v12/inspector/inspector_waitfordebugger.html)

新增于: v12.7.0

阻塞直到客户端（现有或稍后连接）发送 `Runtime.runIfWaitingForDebugger` 命令。

如果没有活动的检查器，则将会抛出异常。

### `inspector.Session` 类[#](http://nodejs.cn/api-v12/inspector.html#class-inspectorsession)

[中英对照](http://nodejs.cn/api-v12/inspector/class_inspector_session.html)

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`inspector.Session` 用于向 V8 检查器后端发送消息并接收消息响应和通知。

#### `new inspector.Session()`[#](http://nodejs.cn/api-v12/inspector.html#new-inspectorsession)

[中英对照](http://nodejs.cn/api-v12/inspector/new_inspector_session.html)

新增于: v8.0.0

创建 `inspector.Session` 类的新实例。 检查器会话需要通过 [`session.connect()`](http://nodejs.cn/api-v12/inspector.html#inspector_session_connect) 连接才能将消息发送到检查员后端。

#### `'inspectorNotification'` 事件[#](http://nodejs.cn/api-v12/inspector.html#event-inspectornotification)

[中英对照](http://nodejs.cn/api-v12/inspector/event_inspectornotification.html)

新增于: v8.0.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao) 通知消息对象

当接收到来自 V8 检查器的任何通知时触发。

```
session.on('inspectorNotification', (message) => console.log(message.method));
// Debugger.paused
// Debugger.resumed
```

也可以只订阅特定方法的通知：

#### `<inspector-protocol-method>`; 事件[#](http://nodejs.cn/api-v12/inspector.html#event-inspector-protocol-method)

[中英对照](http://nodejs.cn/api-v12/inspector/event_inspector_protocol_method.html)

新增于: v8.0.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao) 通知消息对象

当接收到检查器通知其方法字段设置为 `<inspector-protocol-method>` 值时触发。

以下代码片段在 [`'Debugger.paused'`](http://url.nodejs.cn/H2jPQz) 事件上安装了监听器，并在程序执行暂停时（例如通过断点）打印程序暂停的原因：

```
session.on('Debugger.paused', ({ params }) => {
  console.log(params.hitBreakpoints);
});
// [ '/the/file/that/has/the/breakpoint.js:11:0' ]
```

#### `session.connect()`[#](http://nodejs.cn/api-v12/inspector.html#sessionconnect)

[中英对照](http://nodejs.cn/api-v12/inspector/session_connect.html)

新增于: v8.0.0

将会话连接到检查器后端。

#### `session.connectToMainThread()`[#](http://nodejs.cn/api-v12/inspector.html#sessionconnecttomainthread)

[中英对照](http://nodejs.cn/api-v12/inspector/session_connecttomainthread.html)

新增于: v12.11.0

将会话连接到主线程检查器后端。 如果没有在工作线程上调用此 API，则会抛出异常。

#### `session.disconnect()`[#](http://nodejs.cn/api-v12/inspector.html#sessiondisconnect)

[中英对照](http://nodejs.cn/api-v12/inspector/session_disconnect.html)

新增于: v8.0.0

立即关闭会话。 所有挂起的消息回调都将使用错误调用。 需要调用 [`session.connect()`](http://nodejs.cn/api-v12/inspector.html#inspector_session_connect) 才能再次发送消息。 重新连接的会话将丢失所有检查器状态，例如启用的代理或配置的断点。

#### `session.post(method[, params][, callback])`[#](http://nodejs.cn/api-v12/inspector.html#sessionpostmethod-params-callback)

[中英对照](http://nodejs.cn/api-v12/inspector/session_post_method_params_callback.html)

新增于: v8.0.0

-   `method` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `params` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

向检查器后端发布消息。 `callback` 将在接收到响应时收到通知。 `callback` 是接受两个可选参数（错误和特定于消息的结果）的函数。

```
session.post('Runtime.evaluate', { expression: '2 + 2' },
             (error, { result }) => console.log(result));
// 输出：{ type: 'number', value: 4, description: '4' }
```

最新版本的 V8 检查器协议发布在 [Chrome 开发者工具协议查看器](http://url.nodejs.cn/L1ERN7)。

Node.js 检查器支持 V8 声明的所有 Chrome 开发者工具协议域。 Chrome 开发者工具协议域提供了一个接口，用于与用于检查应用程序状态和监听运行时事件的运行时代理之一进行交互。

### 使用示例[#](http://nodejs.cn/api-v12/inspector.html#example-usage)

[中英对照](http://nodejs.cn/api-v12/inspector/example_usage.html)

除了调试器之外，还可以通过开发者工具协议使用各种 V8 分析器。

#### CPU 分析器[#](http://nodejs.cn/api-v12/inspector.html#cpu-profiler)

[中英对照](http://nodejs.cn/api-v12/inspector/cpu_profiler.html)

这是示例，展示了如何使用 [CPU 分析器](http://url.nodejs.cn/ouygJq)：

```
const inspector = require('inspector');
const fs = require('fs');
const session = new inspector.Session();
session.connect();

session.post('Profiler.enable', () => {
  session.post('Profiler.start', () => {
    // 在此处调用测量中的业务逻辑...

    // 一段时间之后...
    session.post('Profiler.stop', (err, { profile }) => {
      // 将分析文件写入磁盘、上传等
      if (!err) {
        fs.writeFileSync('./profile.cpuprofile', JSON.stringify(profile));
      }
    });
  });
});
```

#### 堆分析器[#](http://nodejs.cn/api-v12/inspector.html#heap-profiler)

[中英对照](http://nodejs.cn/api-v12/inspector/heap_profiler.html)

这是示例，展示了如何使用[堆分析器](http://url.nodejs.cn/qntq2p)：

```
const inspector = require('inspector');
const fs = require('fs');
const session = new inspector.Session();

const fd = fs.openSync('profile.heapsnapshot', 'w');

session.connect();

session.on('HeapProfiler.addHeapSnapshotChunk', (m) => {
  fs.writeSync(fd, m.params.chunk);
});

session.post('HeapProfiler.takeHeapSnapshot', null, (err, r) => {
  console.log('HeapProfiler.takeHeapSnapshot done:', err, r);
  session.disconnect();
  fs.closeSync(fd);
});
```
