---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/cluster.html
author: 
---

# cluster 集群 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/cluster/cluster.html)

**源代码:** [lib/cluster.js](https://github.com/nodejs/node/blob/v12.22.12/lib/cluster.js)

Node.js 的单个实例在单个线程中运行。 为了利用多核系统，用户有时会想要启动 Node.js 进程的集群来处理负载。

集群模块可以轻松创建共享服务器端口的子进程。

```
const cluster = require('cluster');
const http = require('http');
const numCPUs = require('os').cpus().length;

if (cluster.isMaster) {
  console.log(`Master ${process.pid} is running`);

  // 衍生工作进程。
  for (let i = 0; i < numCPUs; i++) {
    cluster.fork();
  }

  cluster.on('exit', (worker, code, signal) => {
    console.log(`worker ${worker.process.pid} died`);
  });
} else {
  // 工作进程可以共享任何 TCP 连接
  // 在本示例中，其是 HTTP 服务器
  http.createServer((req, res) => {
    res.writeHead(200);
    res.end('hello world\n');
  }).listen(8000);

  console.log(`Worker ${process.pid} started`);
}
```

运行 Node.js 现在将在工作进程之间共享端口 8000：

```
$ node server.js
Master 3596 is running
Worker 4324 started
Worker 4520 started
Worker 6056 started
Worker 5644 started
```

在 Windows 上，还不能在工作进程中设置命名管道服务器。

### 工作原理[#](http://nodejs.cn/api-v12/cluster.html#how-it-works)

[中英对照](http://nodejs.cn/api-v12/cluster/how_it_works.html)

工作进程使用 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 方法衍生，因此它们可以通过 IPC 与父进程通信并且来回传递服务器句柄。

集群模块支持两种分发传入连接的方法。

第一种方法（也是除 Windows 之外的所有平台上的默认方法）是循环法，主进程监听端口，接受新连接并以循环方式将它们分发给工作进程，其中使用一些内置智能以避免使工作进程过载。

第二种方法是，主进程创建监听套接字并将其发送给感兴趣的工作进程。 然后工作进程直接接受传入的连接。

理论上，第二种方法具有最好的性能。 但是，在实践中，由于操作系统调度机制难以捉摸，分发往往非常不平衡。 可能会出现八个进程中的两个进程分担了所有连接超过 70% 的负载。

由于 `server.listen()` 将大部分工作交给了主进程，因此普通的 Node.js 进程和集群工作进程之间的行为在三种情况下会有所不同：

1.  `server.listen({fd: 7})` 因为消息传给主进程，所以父进程中的文件描述符 7 将被监听，并将句柄传给工作进程，而不是监听文件描述符 7 引用的工作进程。
2.  `server.listen(handle)` 显式地监听句柄，将使工作进程使用提供的句柄，而不是与主进程对话。
3.  `server.listen(0)` 通常，这会使服务器监听随机端口。 但是，在集群中，每个工作进程每次执行 `listen(0)` 时都会接收到相同的"随机"端口。 实质上，端口第一次是随机的，但之后是可预测的。 要监听唯一的端口，则根据集群工作进程 ID 生成端口号。

Node.js 不提供路由逻辑。 因此，重要的是设计一个应用程序，使其在会话和登录等方面不会过于依赖内存中的数据对象。

因为工作进程都是独立的进程，所以它们可以根据程序的需要被杀死或重新衍生，而不会影响其他工作进程。 只要还有工作进程仍然活动，服务器就会继续接受连接。 如果没有工作进程活动，则现有的连接将被丢弃，且新的连接将被拒绝。 但是，Node.js 不会自动管理工作进程的数量。 应用程序有责任根据自己的需要管理工作进程池。

尽管 `cluster` 模块的主要使用场景是网络，但它也可用于需要工作进程的其他使用场景。

### `Worker` 类[#](http://nodejs.cn/api-v12/cluster.html#class-worker)

[中英对照](http://nodejs.cn/api-v12/cluster/class_worker.html)

新增于: v0.7.0

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`Worker` 对象包含了工作进程的所有公共的信息和方法。 在主进程中，可以使用 `cluster.workers` 来获取它。 在工作进程中，可以使用 `cluster.worker` 来获取它。

#### `'disconnect'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-disconnect)

[中英对照](http://nodejs.cn/api-v12/cluster/event_disconnect.html)

新增于: v0.7.7

类似于 `cluster.on('disconnect')` 事件，但特定于此工作进程。

```
cluster.fork().on('disconnect', () => {
  // 工作进程已断开连接
});
```

#### `'error'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-error)

[中英对照](http://nodejs.cn/api-v12/cluster/event_error.html)

新增于: v0.7.3

此事件与 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 提供的相同。

在工作进程中，也可以使用 `process.on('error')`。

#### `'exit'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-exit)

[中英对照](http://nodejs.cn/api-v12/cluster/event_exit.html)

新增于: v0.11.2

-   `code` [<number>](http://url.nodejs.cn/SXbo1v) 如果其正常退出，则为退出码。
-   `signal` [<string>](http://url.nodejs.cn/9Tw2bK) 造成进程被终止的信号的名称（例如 `'SIGHUP'`）。

类似于 `cluster.on('exit')` 事件，但特定于此工作进程。

```
const worker = cluster.fork();
worker.on('exit', (code, signal) => {
  if (signal) {
    console.log(`worker was killed by signal: ${signal}`);
  } else if (code !== 0) {
    console.log(`worker exited with error code: ${code}`);
  } else {
    console.log('worker success!');
  }
});
```

#### `'listening'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-listening)

[中英对照](http://nodejs.cn/api-v12/cluster/event_listening.html)

新增于: v0.7.0

-   `address` [<Object>](http://url.nodejs.cn/jzn6Ao)

类似于 `cluster.on('listening')` 事件，但特定于此工作进程。

```
cluster.fork().on('listening', (address) => {
  // 工作进程正在监听
});
```

它不会在工作进程中触发。

#### `'message'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-message)

[中英对照](http://nodejs.cn/api-v12/cluster/event_message.html)

新增于: v0.7.0

-   `message` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `handle` [<undefined>](http://url.nodejs.cn/8ym6ow) | [<Object>](http://url.nodejs.cn/jzn6Ao)

类似于 `cluster` 的 `'message'` 事件，但特定于此工作线程。

在工作进程中，也可以使用 `process.on('message')`。

参见 [`process` 事件: `'message'`](http://nodejs.cn/api-v12/process.html#process_event_message)。

这是使用消息系统的示例。 它在主进程中记录工作进程接收到的 HTTP 请求数：

```
const cluster = require('cluster');
const http = require('http');

if (cluster.isMaster) {

  // 跟踪 http 请求
  let numReqs = 0;
  setInterval(() => {
    console.log(`numReqs = ${numReqs}`);
  }, 1000);

  // 计数请求
  function messageHandler(msg) {
    if (msg.cmd && msg.cmd === 'notifyRequest') {
      numReqs += 1;
    }
  }

  // 启动工作进程并监听包含 notifyRequest 的消息
  const numCPUs = require('os').cpus().length;
  for (let i = 0; i < numCPUs; i++) {
    cluster.fork();
  }

  for (const id in cluster.workers) {
    cluster.workers[id].on('message', messageHandler);
  }

} else {

  // 工作进程具有 http 服务器。
  http.Server((req, res) => {
    res.writeHead(200);
    res.end('hello world\n');

    // 通知主进程关于请求
    process.send({ cmd: 'notifyRequest' });
  }).listen(8000);
}
```

#### `'online'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-online)

[中英对照](http://nodejs.cn/api-v12/cluster/event_online.html)

新增于: v0.7.0

类似于 `cluster.on('online')` 事件，但特定于此工作进程。

```
cluster.fork().on('online', () => {
  // 工作进程在线
});
```

它不会在工作进程中触发。

#### `worker.disconnect()`[#](http://nodejs.cn/api-v12/cluster.html#workerdisconnect)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_disconnect.html)

-   返回: [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker) `worker` 的引用。

在工作进程中，此函数将关闭所有服务器，等待那些服务器上的 `'close'` 事件，然后断开 IPC 通道。

在主进程中，内部的消息被发送给工作进程，使其调用自身的 `.disconnect()`。

使 `.exitedAfterDisconnect` 被设置。

服务器关闭后，它将不再接受新连接，但连接可能会被任何其他监听的工作进程接受。 现有的连接将被允许像往常一样关闭。 当不再存在连接时（参见 [`server.close()`](http://nodejs.cn/api-v12/net.html#net_event_close)），到工作进程的 IPC 通道将关闭，允许其正常地死亡。

以上仅适用于服务器连接，客户端连接不会被工作进程自动关闭，并且断开连接不会等待它们关闭才退出。

在工作进程中，`process.disconnect` 是存在的，但不是这个函数；它是 [`disconnect()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_disconnect)。

因为长期存在的服务器连接可能会阻止工作进程断开连接，所以发送消息可能很有用，因此可以采取特定于应用程序的操作来关闭它们。 实现超时也可能很有用，如果 `'disconnect'` 事件在一段时间后没有触发，则杀死工作进程。

```
if (cluster.isMaster) {
  const worker = cluster.fork();
  let timeout;

  worker.on('listening', (address) => {
    worker.send('shutdown');
    worker.disconnect();
    timeout = setTimeout(() => {
      worker.kill();
    }, 2000);
  });

  worker.on('disconnect', () => {
    clearTimeout(timeout);
  });

} else if (cluster.isWorker) {
  const net = require('net');
  const server = net.createServer((socket) => {
    // 连接永远不会结束
  });

  server.listen(8000);

  process.on('message', (msg) => {
    if (msg === 'shutdown') {
      // 发起正常关闭与服务器的任何连接
    }
  });
}
```

#### `worker.exitedAfterDisconnect`[#](http://nodejs.cn/api-v12/cluster.html#workerexitedafterdisconnect)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_exitedafterdisconnect.html)

新增于: v6.0.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果工作进程由于 `.kill()` 或 `.disconnect()` 退出，则此属性为 `true`。 如果工作进程以任何其他方式退出，则为 `false`。 如果工作进程没有退出，则为 `undefined`。

布尔值 [`worker.exitedAfterDisconnect`](http://nodejs.cn/api-v12/cluster.html#cluster_worker_exitedafterdisconnect) 可以区分自愿退出和意外退出，主进程可以根据此值选择不重新衍生工作进程。

```
cluster.on('exit', (worker, code, signal) => {
  if (worker.exitedAfterDisconnect === true) {
    console.log('Oh, it was just voluntary – no need to worry');
  }
});

// 杀死工作进程
worker.kill();
```

#### `worker.id`[#](http://nodejs.cn/api-v12/cluster.html#workerid)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_id.html)

新增于: v0.8.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

每个新的工作进程都被赋予了自己唯一的 id，此 id 存储在 `id`.

当工作进程存活时，这是在 `cluster.workers` 中索引它的键。

#### `worker.isConnected()`[#](http://nodejs.cn/api-v12/cluster.html#workerisconnected)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_isconnected.html)

新增于: v0.11.14

如果工作进程通过其 IPC 通道连接到其主进程，则此函数返回 `true`，否则返回 `false`。 工作进程在创建后连接到其主进程。 触发 `'disconnect'` 事件后断开连接。

#### `worker.isDead()`[#](http://nodejs.cn/api-v12/cluster.html#workerisdead)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_isdead.html)

新增于: v0.11.14

如果工作进程已终止（由于退出或收到信号），则此函数返回 `true`。 否则，它返回 `false`。

```
const cluster = require('cluster');
const http = require('http');
const numCPUs = require('os').cpus().length;

if (cluster.isMaster) {
  console.log(`Master ${process.pid} is running`);

  // 衍生工作进程。
  for (let i = 0; i < numCPUs; i++) {
    cluster.fork();
  }

  cluster.on('fork', (worker) => {
    console.log('worker is dead:', worker.isDead());
  });

  cluster.on('exit', (worker, code, signal) => {
    console.log('worker is dead:', worker.isDead());
  });
} else {
  // 工作进程可以共享任何 TCP 连接。在此示例中，它是 HTTP 服务器。
  http.createServer((req, res) => {
    res.writeHead(200);
    res.end(`Current process\n ${process.pid}`);
    process.kill(process.pid);
  }).listen(8000);
}
```

#### `worker.kill([signal])`[#](http://nodejs.cn/api-v12/cluster.html#workerkillsignal)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_kill_signal.html)

新增于: v0.9.12

-   `signal` [<string>](http://url.nodejs.cn/9Tw2bK) 发送给工作进程的终止信号的名称。 **默认值**: `'SIGTERM'`

此函数会杀死工作进程。 在主进程中，它通过断开 `worker.process` 来实现这一点，一旦断开连接，就使用 `signal` 杀死。 在工作进程中，它通过断开通道来完成，然后以代码 `0` 退出。

由于 `kill()` 尝试正常断开工作进程，因此很容易无限期地等待断开连接完成。 例如，如果工作进程进入无限循环，则永远不会发生正常的断开连接。 如果不需要正常的断开连接行为，则使用 `worker.process.kill()`。

使 `.exitedAfterDisconnect` 被设置。

为了向后兼容，此方法别名为 `worker.destroy()`。

在工作进程中，`process.kill()` 是存在的，但不是这个函数；它是 [`kill()`](http://nodejs.cn/api-v12/process.html#process_process_kill_pid_signal)。

#### `worker.process`[#](http://nodejs.cn/api-v12/cluster.html#workerprocess)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_process.html)

新增于: v0.7.0

-   [<ChildProcess>](http://nodejs.cn/api/child_process.html#class-childprocess)

所有工作进程都是使用 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 创建，此函数返回的对象存储为 `.process`。 在工作进程中，存储了全局的 `process`。

请参阅：[子进程模块](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options)。

如果 `'disconnect'` 事件发生在 `process` 并且 `.exitedAfterDisconnect` 不是 `true`，则工作进程将调用 `process.exit(0)`。 这可以防止意外断开连接。

#### `worker.send(message[, sendHandle[, options]][, callback])`[#](http://nodejs.cn/api-v12/cluster.html#workersendmessage-sendhandle-options-callback)

[中英对照](http://nodejs.cn/api-v12/cluster/worker_send_message_sendhandle_options_callback.html)

-   `message` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `sendHandle` [<Handle>](http://nodejs.cn/api/net.html#serverlistenhandle-backlog-callback)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) `options` 参数（如果存在）是用于参数化某些类型句柄的发送的对象。 `options` 支持以下属性：
    -   `keepOpen` [<boolean>](http://url.nodejs.cn/jFbvuT) 当传入 `net.Socket` 实例时可以使用的值。 当为 `true` 时，套接字在发送过程中保持打开状态。 **默认值:** `false`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

向工作进程或主进程发送消息，可选择使用句柄。

在主进程中，这会向特定的工作进程发送消息。 它与 [`ChildProcess.send()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_send_message_sendhandle_options_callback) 相同。

在工作进程中，这会向主进程发送消息。 它与 `process.send()` 相同。

此示例将回显来自主进程的所有消息：

```
if (cluster.isMaster) {
  const worker = cluster.fork();
  worker.send('hi there');

} else if (cluster.isWorker) {
  process.on('message', (msg) => {
    process.send(msg);
  });
}
```

### `'disconnect'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-disconnect_1)

[中英对照](http://nodejs.cn/api-v12/cluster/event_disconnect_1.html)

新增于: v0.7.9

-   `worker` [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker)

在工作进程 IPC 通道断开连接后触发。 当工作进程正常退出、被杀死、或手动断开连接（例如使用 `worker.disconnect()`）时，可能会发生这种情况。

`'disconnect'` 和 `'exit'` 事件之间可能存在延迟。 这些事件可用于检测进程是否陷入清理或是否存在长期连接。

```
cluster.on('disconnect', (worker) => {
  console.log(`The worker #${worker.id} has disconnected`);
});
```

### `'exit'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-exit_1)

[中英对照](http://nodejs.cn/api-v12/cluster/event_exit_1.html)

新增于: v0.7.9

-   `worker` [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker)
-   `code` [<number>](http://url.nodejs.cn/SXbo1v) 如果其正常退出，则为退出码。
-   `signal` [<string>](http://url.nodejs.cn/9Tw2bK) 造成进程被终止的信号的名称（例如 `'SIGHUP'`）。

当任何工作进程死亡时，则集群模块将触发 `'exit'` 事件。

这可用于通过再次调用 [`.fork()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_fork_env) 来重新启动工作进程。

```
cluster.on('exit', (worker, code, signal) => {
  console.log('worker %d died (%s). restarting...',
              worker.process.pid, signal || code);
  cluster.fork();
});
```

参见 [`child_process` 事件: `'exit'`](http://nodejs.cn/api-v12/child_process.html#child_process_event_exit)。

### `'fork'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-fork)

[中英对照](http://nodejs.cn/api-v12/cluster/event_fork.html)

新增于: v0.7.0

-   `worker` [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker)

当新的工作进程被衍生时，则集群模块将触发 `'fork'` 事件。 这可用于记录工作进程的活动，并创建自定义的超时。

```
const timeouts = [];
function errorMsg() {
  console.error('Something must be wrong with the connection ...');
}

cluster.on('fork', (worker) => {
  timeouts[worker.id] = setTimeout(errorMsg, 2000);
});
cluster.on('listening', (worker, address) => {
  clearTimeout(timeouts[worker.id]);
});
cluster.on('exit', (worker, code, signal) => {
  clearTimeout(timeouts[worker.id]);
  errorMsg();
});
```

### `'listening'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-listening_1)

[中英对照](http://nodejs.cn/api-v12/cluster/event_listening_1.html)

新增于: v0.7.0

-   `worker` [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker)
-   `address` [<Object>](http://url.nodejs.cn/jzn6Ao)

从工作线程调用 `listen()` 后，当服务器上触发 `'listening'` 事件时，则主进程中的 `cluster` 事件也将触发 `'listening'` 事件。

事件句柄使用两个参数执行，`worker` 包含工作进程对象，`address` 对象包含以下连接属性：`address`、`port` 和 `addressType`。 如果工作进程正在监听多个地址，则这将非常有用。

```
cluster.on('listening', (worker, address) => {
  console.log(
    `A worker is now connected to ${address.address}:${address.port}`);
});
```

`addressType` 是以下之一：

-   `4` (TCPv4)
-   `6` (TCPv6)
-   `-1` (Unix 域套接字)
-   `'udp4'` or `'udp6'` (UDP v4 或 v6)

### `'message'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-message_1)

[中英对照](http://nodejs.cn/api-v12/cluster/event_message_1.html)

-   `worker` [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker)
-   `message` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `handle` [<undefined>](http://url.nodejs.cn/8ym6ow) | [<Object>](http://url.nodejs.cn/jzn6Ao)

当集群主进程接收到来自任何工作进程的消息时触发。

参见 [`child_process` 事件: `'message'`](http://nodejs.cn/api-v12/child_process.html#child_process_event_message)。

### `'online'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-online_1)

[中英对照](http://nodejs.cn/api-v12/cluster/event_online_1.html)

新增于: v0.7.0

-   `worker` [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker)

衍生新的工作进程之后，工作进程应该使用在线消息进行响应。 当主进程接收到在线消息时，它将触发此事件。 `'fork'` 和 `'online'` 的区别在于主进程衍生工作进程时触发衍生，而 `'online'` 在工作进程运行时触发。

```
cluster.on('online', (worker) => {
  console.log('Yay, the worker responded after it was forked');
});
```

### `'setup'` 事件[#](http://nodejs.cn/api-v12/cluster.html#event-setup)

[中英对照](http://nodejs.cn/api-v12/cluster/event_setup.html)

新增于: v0.7.1

-   `settings` [<Object>](http://url.nodejs.cn/jzn6Ao)

每次调用 [`.setupMaster()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_setupmaster_settings) 时触发。

`settings` 对象是调用 [`.setupMaster()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_setupmaster_settings) 时的 `cluster.settings` 对象，并且只是建议性的，因为可以在单个滴答中对 [`.setupMaster()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_setupmaster_settings) 进行多次调用。

如果准确性很重要，则使用 `cluster.settings`。

### `cluster.disconnect([callback])`[#](http://nodejs.cn/api-v12/cluster.html#clusterdisconnectcallback)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_disconnect_callback.html)

新增于: v0.7.7

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当所有工作进程断开连接并关闭句柄时调用。

对 `cluster.workers` 中的每个工作进程调用 `.disconnect()`。

当它们断开连接时，所有的内部句柄都将关闭，如果没有其他事件在等待，则允许主进程正常终止。

该方法采用可选的回调参数，当完成时将被调用。

这只能从主进程调用。

### `cluster.fork([env])`[#](http://nodejs.cn/api-v12/cluster.html#clusterforkenv)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_fork_env.html)

新增于: v0.6.0

-   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 要添加到工作进程环境变量的键/值对。
-   返回: [<cluster.Worker>](http://nodejs.cn/api/cluster.html#class-worker)

衍生新的工作进程。

这只能从主进程调用。

### `cluster.isMaster`[#](http://nodejs.cn/api-v12/cluster.html#clusterismaster)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_ismaster.html)

新增于: v0.8.1

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果进程是主进程，则为真。 这是由 `process.env.NODE_UNIQUE_ID` 决定的。 如果 `process.env.NODE_UNIQUE_ID` 未定义，则 `isMaster` 为 `true`。

### `cluster.isWorker`[#](http://nodejs.cn/api-v12/cluster.html#clusterisworker)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_isworker.html)

新增于: v0.6.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果进程不是主进程，则为真（与 `cluster.isMaster` 相反）。

### `cluster.schedulingPolicy`[#](http://nodejs.cn/api-v12/cluster.html#clusterschedulingpolicy)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_schedulingpolicy.html)

新增于: v0.11.2

调度策略，`cluster.SCHED_RR` 用于循环或 `cluster.SCHED_NONE` 将其留给操作系统。 这是全局的设置，一旦衍生第一个工作进程或调用 [`.setupMaster()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_setupmaster_settings)（以先到者为准），就会有效地冻结。

`SCHED_RR` 是除 Windows 之外的所有操作系统的默认值。 一旦 libuv 能够有效地分发 IOCP 句柄而不会导致大量性能损失，则 Windows 将更改为 `SCHED_RR`。

`cluster.schedulingPolicy` 也可以通过 `NODE_CLUSTER_SCHED_POLICY` 环境变量设置。 有效值为 `'rr'` 和 `'none'`。

### `cluster.settings`[#](http://nodejs.cn/api-v12/cluster.html#clustersettings)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_settings.html)

-   [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `execArgv` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 传给 Node.js 可执行文件的字符串参数列表。 **默认值:** `process.execArgv`。
    -   `exec` [<string>](http://url.nodejs.cn/9Tw2bK) 工作进程文件的文件路径。 **默认值:** `process.argv[1]`。
    -   `args` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 传给工作进程的字符串参数。 **默认值:** `process.argv.slice(2)`。
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 工作进程的当前工作目录。 **默认值:** `undefined` （从父进程继承）。
    -   `serialization` [<string>](http://url.nodejs.cn/9Tw2bK) 指定用于在进程之间发送消息的序列化类型。 可能的值为 `'json'` 和 `'advanced'`。 有关更多详细信息，请参阅[子进程的高级序列化](http://nodejs.cn/api-v12/child_process.html#child_process_advanced_serialization)。 **默认值:** `false`。
    -   `silent` [<boolean>](http://url.nodejs.cn/jFbvuT) 是否将输出发送到父进程的标准输入输出。 **默认值:** `false`。
    -   `stdio` [<Array>](http://url.nodejs.cn/ZJSz23) 配置衍生进程的标准输入输出。 由于集群模块依赖 IPC 来运行，因此此配置必须包含 `'ipc'` 条目。 提供此选项时，它会覆盖 `silent`。
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识。 （见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)。）
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识。 （见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)。）
    -   `inspectPort` [<number>](http://url.nodejs.cn/SXbo1v) | [<Function>](http://url.nodejs.cn/ceTQa6) 设置工作进程的检查器端口。 这可以是数字，也可以是不带参数并返回数字的函数。 默认情况下，每个工作进程都有自己的端口，从主进程的 `process.debugPort` 开始递增。
    -   `windowsHide` [<boolean>](http://url.nodejs.cn/jFbvuT) 隐藏通常在 Windows 系统上创建的衍生进程控制台窗口。 **默认值:** `false`。

调用 [`.setupMaster()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_setupmaster_settings)（或 [`.fork()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_fork_env)）之后，此设置对象将包含设置，包括默认值。

此对象不应手动更改或设置。

### `cluster.setupMaster([settings])`[#](http://nodejs.cn/api-v12/cluster.html#clustersetupmastersettings)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_setupmaster_settings.html)

-   `settings` [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`cluster.settings`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_settings)。

`setupMaster` 用于更改默认的 'fork' 行为。 调用后，设置将出现在 `cluster.settings` 中。

任何设置更改只会影响未来对 [`.fork()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_fork_env) 的调用，而不会影响已经运行的工作进程。

唯一不能通过 `.setupMaster()` 设置的工作进程属性是传给 [`.fork()`](http://nodejs.cn/api-v12/cluster.html#cluster_cluster_fork_env) 的 `env`。

上述默认值仅适用于第一次调用；以后调用的默认值是调用 `cluster.setupMaster()` 时的当前值。

```
const cluster = require('cluster');
cluster.setupMaster({
  exec: 'worker.js',
  args: ['--use', 'https'],
  silent: true
});
cluster.fork(); // https 工作进程
cluster.setupMaster({
  exec: 'worker.js',
  args: ['--use', 'http']
});
cluster.fork(); // http 工作进程
```

这只能从主进程调用。

### `cluster.worker`[#](http://nodejs.cn/api-v12/cluster.html#clusterworker)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_worker.html)

新增于: v0.7.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

对当前工作进程对象的引用。 在主进程中不可用。

```
const cluster = require('cluster');

if (cluster.isMaster) {
  console.log('I am master');
  cluster.fork();
  cluster.fork();
} else if (cluster.isWorker) {
  console.log(`I am worker #${cluster.worker.id}`);
}
```

### `cluster.workers`[#](http://nodejs.cn/api-v12/cluster.html#clusterworkers)

[中英对照](http://nodejs.cn/api-v12/cluster/cluster_workers.html)

新增于: v0.7.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

存储活动工作进程对象的哈希，以 `id` 字段为键。 使循环遍历所有工作进程变得容易。 它仅在主进程中可用。

在工作进程断开连接并退出后，工作进程会从 `cluster.workers` 中删除。 这两个事件之间的顺序无法预先确定。 但是，可以保证从 `cluster.workers` 列表中的删除发生在最后一个 `'disconnect'` 或 `'exit'` 事件触发之前。

```
// 遍历所有工作进程
function eachWorker(callback) {
  for (const id in cluster.workers) {
    callback(cluster.workers[id]);
  }
}
eachWorker((worker) => {
  worker.send('big announcement to all workers');
});
```

使用工作进程的唯一 id 是定位工作进程的最简单方法。

```
socket.on('data', (id) => {
  const worker = cluster.workers[id];
});
```
